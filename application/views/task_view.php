<?php

$action = ($_SERVER["REQUEST_URI"] == '/') ? 'task/addTask' : '';

if(isset($data['errMsg'])){
    echo '<div class="alert alert-danger text-center"><span>'.htmlspecialchars($data['errMsg']).'</span></div>';
}

?>
<div class="container align-items-center pt-5">

    <form action="task/addTask" method="post">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <input class="form-control" id="taskTextInput" name="description" aria-describedby="taskHelp" placeholder="Enter text...">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-dark btn-block" value="Add task">
            </div>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-outline-dark" formaction='task/removeAll' id="removeAllBtn">Remove All</button>
            <button class="btn btn-outline-dark" formaction='task/readyAll' id="readyAllBtn">Ready All</button>
        </div>
    </form>
</div>
 <div class="container align-items-center pt-5">
        <table class="table table-striped text-center" id="taskTbl">
            <tbody>
            <?php foreach ($data['tasks'] as $task): ?>
                <?php if($task != null):?>

                    <?php $statiusColour = ($task['status'] == true) ? 'green': 'red'; ?>
                    <tr>
                       <form method="post">
                        <td id="taskId"><input name="task_id" value = "<?= htmlspecialchars($task['id'])?>" hidden/></td>
                        <td style="width:80%"><?= htmlspecialchars($task['description']) ?></td>
                        <td class="noborder"><button class="btn" id="taskStatus" formaction='task/readyTask' value="ready" style="color:<?= $statiusColour ?>">READY</button></td>
                        <td class="noborder"><button class="btn" id="taskDelete" formaction='task/deleteTask' value="delete">DELETE</button></td>
                       </form>
                    </tr>
                <?php endif; ?>
            <?php  endforeach; ?>
            </tbody>
        </table>
    </div>