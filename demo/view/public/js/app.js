let task = document.getElementById('task');
let addTask = document.getElementById('addTask');
let taskitem = document.querySelectorAll('.task-item');
let message=document.querySelector('.message');
addTask.addEventListener('click', function() {
    let taskValue = task.value;
    saveTask(taskValue);
})


function saveTask(taskValue) {
    if (taskValue) {
        fetch('/MWD/demo/index.php?page=store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({description: taskValue})
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location.reload();
                }
            });
    }
}

taskitem.forEach(function(item) {
    item.addEventListener('click', function() {
        spanContent = item.querySelector('span').textContent;
        checkTaskDone(item.getAttribute('data-id'), spanContent);
    });

});


function checkTaskDone(taskId,spanContent) {
    const numericId = parseInt(taskId, 10);
    fetch(`/MWD/demo/index.php?page=status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: numericId})
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.status === 'DONE') {
                message.innerHTML = `Tache ${spanContent} deja terminee`;
                message.style.display = 'block';
                message.style.color = 'white';
                message.style.fontWeight = 'bold';
                message.style.border = '1px solid #4A90E2';
                message.style.padding = '10px';
                message.style.margin = '10px';
                message.style.borderRadius = '10px';
                message.style.textAlign = 'center';
                message.style.width = '50%';
                message.style.backgroundColor = '#357ABD';
                message.style.display = 'flex';
            }else {

                fetch('/MWD/demo/index.php?page=done', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id: numericId})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            message.innerHTML = `Tache ${spanContent} terminee`;
                            message.style.display = 'block';
                            message.style.color = 'white';
                            message.style.fontWeight = 'bold';
                            message.style.border = '1px solid #4A90E2';
                            message.style.padding = '10px';
                            message.style.margin = '10px';
                            message.style.borderRadius = '10px';
                            message.style.textAlign = 'center';
                            message.style.width = '50%';
                            message.style.backgroundColor = '#357ABD';
                            message.style.display = 'flex';

                        } else if (data.error) {
                            console.error('Erreur:', data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            }
        });

}