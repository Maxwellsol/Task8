<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Q-digital internship Task List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.css" >
</head>

<body>

<?php
if (isset($_SESSION['user_id'])){
    echo '<a href="user/logout" class="btn btn-outline-dark float-right">Выйти</a>';
}
?>
<h1 class="text-center text-dark pt-5">Task List</h1>
    <?php include 'application/views/'.$content_view; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="../../js/task_actions.js"></script>
<script src="../../js/bootstrap.js"></script>
<footer class="text-center text-lg-start bg-white text-muted">
    <div class="footer fixed-bottom">
        <span>Q-digital internship TASK6 made by Maxwell Sollow</span>
    </div>
</footer>
</body>

</html>