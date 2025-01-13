<?php
include_once 'partial/header.php';
$tasks = $tasks ?? [];

function getTaskClasses($status) {
    $baseClass = 'task-item';
    return $status === 'DONE' ? "$baseClass task-done" : $baseClass;
}

function getTaskIcon($status) {
    switch ($status) {
        case 'TODO':
            return 'fa-solid fa-circle-info';
        case 'DONE':
            return 'fa-solid fa-circle';
        default:
            return 'fa-regular fa-circle';
    }
}
?>

    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Gestionnaire de tâches</h2>
            </div>

            <div class="card-content">
                <form class="task-bar" onsubmit="return false;">
                    <label for="task" class="sr-only">Ajouter une tâche</label>
                    <input
                            type="text"
                            name="task"
                            id="task"
                            placeholder="Add task.."
                            required
                            autocomplete="off"
                    >
                    <button
                            type="button"
                            class="task-icon"
                            id="addTask"
                            aria-label="Ajouter la tâche"
                    >
                        +
                    </button>
                </form>

                <div class="message" role="alert" aria-live="polite"></div>

                <section class="task-list">
                    <?php foreach ($tasks as $task): ?>
                        <div
                                class="<?= getTaskClasses($task['status']) ?>"
                                data-id="<?= htmlspecialchars($task['id']) ?>"
                                role="listitem"
                        >
                            <i class="<?= getTaskIcon($task['status']) ?>" aria-hidden="true"></i>
                            <span><?= htmlspecialchars($task['description']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </section>

                <div class="activity-table-status" role="tablist">
                    <button
                            class="active"
                            role="tab"
                            aria-selected="true"
                            data-filter="all"
                    >Toutes</button>
                    <button
                            role="tab"
                            aria-selected="false"
                            data-filter="active"
                    >Actives</button>
                    <button
                            role="tab"
                            aria-selected="false"
                            data-filter="done"
                    >Terminées</button>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'partial/footer.php'; ?>