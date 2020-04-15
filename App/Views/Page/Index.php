<script src="/js/TaskService.js"></script>
<script src="/js/main.js"></script>
<div class="container <?=$model['mode']?>-mode">
    <div class="card card-block">
        <div class="card-body">
            <h1 class="float-left">Tasks</h1>
            <button id="create-task" type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal">Create</button>
        </div>
    </div>
    <div class="card card-block">
        <div class="card-body">
            <?php include "App/Views/Widgets/TaskTable.php" ?>
        </div>
    </div>
    <?php include "App/Views/Widgets/CreateTaskForm.php" ?>
</div>