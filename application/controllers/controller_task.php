<?php
class Controller_Task extends Controller
{
    private string $user_id;
    private $tasks = [];


    public function __construct()
    {
        $user_id = $_SESSION['user_id'];
        $this->user_id = $user_id;
        $this->view = new View();
    }

    public function action_index()
    {
        $this->view->generate('task_view.php', 'template_view.php', ['tasks' => $this->getTasks()]);
    }

    public function action_addTask(){
        if(!empty($_POST['description'])){
            $description = htmlspecialchars($_POST['description']);
            $task = new Task($this->getUserId(), $description, false);
            array_push($this->tasks, $task);
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }else{
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }
    }

    public function action_removeAll(){
        Task::removeAll($this->getUserId());
        unset($this->tasks);
        header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
    }

    public function action_readyAll(){
        Task::readyAll($this->getUserId());
        header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
    }

    public function action_readyTask()
    {
        if(!empty($_POST["task_id"])) {
            $task_id = htmlspecialchars($_POST["task_id"]);
            Task::updateTask($task_id, $this->user_id);
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }else{
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }
    }

    public function action_deleteTask()
    {
        if(!empty($_POST["task_id"])) {
            $task_id = htmlspecialchars($_POST["task_id"]);
            Task::deleteTask($task_id, $this->user_id);
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }else{
            header("Location: http://" . $_SERVER['HTTP_HOST'].'/task');
        }
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getTasks(): array
    {
        $tasks = Task::getUserTasks($this->getUserId());
        $this->tasks = $tasks;
        return $this->tasks;
    }

}