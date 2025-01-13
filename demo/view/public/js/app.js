let task = document.getElementById('task');
let addTask = document.getElementById('addTask');

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