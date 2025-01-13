const selectors = {
    task: document.getElementById('task'),
    addTask: document.getElementById('addTask'),
    taskItems: document.querySelectorAll('.task-item'),
    message: document.querySelector('.message'),
    filterButtons: document.querySelectorAll('.activity-table-status button')
};

const messages = {
    taskDeleted: 'Tâche supprimée',
    taskCompleted: (description) => `Tâche ${description} terminée`,
    taskAlreadyDone: (description) => `Tâche ${description} déjà terminée`,
    deleteConfirm: 'Voulez-vous vraiment supprimer cette tâche ?'
};

const messageStyles = {
    base: {
        display: 'block',
        color: 'white',
        fontWeight: 'bold',
        padding: '10px',
        margin: '10px',
        borderRadius: '10px',
        textAlign: 'center',
        width: '50%'
    },
    success: {
        backgroundColor: '#357ABD',
        border: '1px solid #4A90E2'
    },
    error: {
        backgroundColor: '#bd3549',
        border: '1px solid #ffffff'
    }
};

const api = {
    async request(endpoint, data) {
        try {
            const response = await fetch(`/MWD/demo/index.php?page=${endpoint}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Erreur API:', error);
            throw error;
        }
    }
};

const messageManager = {
    show(text, type = 'success') {
        Object.assign(selectors.message.style, messageStyles.base,
            type === 'success' ? messageStyles.success : messageStyles.error);
        selectors.message.textContent = text;
    }
};

const taskManager = {
    async save(description) {
        if (!description.trim()) return;

        const data = await api.request('store', { description });
        if (data.success) window.location.reload();
    },

    async delete(id) {
        if (!confirm(messages.deleteConfirm)) return;

        const data = await api.request('delete', { id: parseInt(id, 10) });
        if (data.success) {
            messageManager.show(messages.taskDeleted, 'error');
            window.location.reload();
        }
    },

    async toggleStatus(id, description) {
        const statusData = await api.request('status', { id: parseInt(id, 10) });

        if (statusData.status === 'DONE') {
            messageManager.show(messages.taskAlreadyDone(description));
            return;
        }

        const data = await api.request('done', { id: parseInt(id, 10) });
        if (data.success) {
            messageManager.show(messages.taskCompleted(description));
            window.location.reload();
        }
    }
};

selectors.addTask.addEventListener('click', () =>
    taskManager.save(selectors.task.value));

selectors.task.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') taskManager.save(selectors.task.value);
});

selectors.taskItems.forEach(item => {
    const id = item.getAttribute('data-id');
    const description = item.querySelector('span').textContent;

    item.addEventListener('click', () =>
        taskManager.toggleStatus(id, description));

    item.addEventListener('dblclick', () =>
        taskManager.delete(id));
});

selectors.filterButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        // Mise à jour des boutons
        selectors.filterButtons.forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-selected', 'false');
        });
        e.target.classList.add('active');
        e.target.setAttribute('aria-selected', 'true');

        // Filtrage des tâches
        const filter = e.target.dataset.filter;
        selectors.taskItems.forEach(item => {
            const isDone = item.classList.contains('task-done');
            item.style.display = filter === 'all'
            || (filter === 'active' && !isDone)
            || (filter === 'done' && isDone)
                ? 'flex' : 'none';
        });
    });
});