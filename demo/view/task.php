<?php
include_once 'partial/header.php';
$tasks = $tasks ?? [];
?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Gestionnaire de tâches</h2>
        </div>
        <div class="card-content">
            <div class="task-bar">
                <label for="task">
                    <input type="text" name="task" id="task" placeholder="Add task..">
                </label>
                <span class="task-icon" id="addTask" onclick="saveTask()">
                    +
                </span>
            </div>
            <div class="message">

            </div>
            <section class="task-list">
                <?php
                foreach ($tasks as $task) {
                    if ($task['status'] ==='TODO') {
                        ?>
                        <div class="task-item" data-id="<?=$task['id']?>">
                            <i class="fa-solid fa-circle-info"></i>
                            <span><?= $task['description'] ?></span>
                        </div>
                        <?php
                    }elseif ($task['status'] ==='DONE') {
                        ?>
                        <div class="task-item task-done" data-id="<?=$task['id']?>">
                            <i class="fa-solid fa-circle"></i>
                            <span><?= $task['description'] ?></span>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="task-item" data-id="<?=$task['id']?>">
                            <i class="fa-regular fa-circle"></i>
                            <span><?= $task['description'] ?></span>
                        </div>
                        <?php
                    }
                }
                ?>
            </section>
            <div class="activity-table-status">
                <span class="active">Toutes</span>
                <span>Actives</span>
                <span>Terminees</span>
            </div>

    </div>
</div>
<?php
include_once 'partial/footer.php';
?>