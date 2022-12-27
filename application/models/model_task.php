<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';

class Task extends Model
{
    public int $id;
    public int $user_id;
    public string $description;
    public bool $status;

    public function __construct(int $user_id, string $description, bool $status){
        $conn = connectDB();
        $sql = "INSERT INTO `tasks` (`description`, `user_id`) VALUES (:desc, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':desc' => $description, ':user_id' => $user_id]);
        $taskId = $conn->lastInsertId();
        $this->id = $taskId;
        $this->user_id = $user_id;
        $this->description = $description;
        $this->status = $status;

    }

    public function update(){
        $conn = connectDB();
        $newStatus = ($this->status == false) ? true : false;
        $sql = "UPDATE `tasks` SET `status` = :new_status WHERE `id` = :task_id AND `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':new_status' => $newStatus,':task_id'=> $this->id, ':user_id' => $this->user_id]);
    }

    static function getUserTasks($user_id){
        $conn = connectDB();
        try {
            $sql = 'SELECT * FROM `tasks` WHERE `user_id` = :user_id';
            $userId = $_SESSION['user_id'];
            $stmt = $conn->prepare($sql);
            $stmt->execute([':user_id'=>$user_id]);
            return $stmt->fetchAll();
        }catch (PDOException $e){
            echo "DatabaseError: ".$e;
        }
    }

    static function removeAll($user_id)
    {
        $conn = connectDB();
        $sql = "DELETE FROM `tasks` WHERE `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
    }

    static function readyAll($user_id)
    {
        $conn = connectDB();
        $sql = "UPDATE `tasks` SET `status` = true WHERE `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
    }

    static function updateTask($id, $user_id)
    {
        $conn = connectDB();
        $statusSql = "SELECT `status` FROM `tasks` WHERE `id` = :id AND `user_id` = :user_id";
        $statusStmt = $conn->prepare($statusSql);
        $statusStmt->execute([':id'=> $id, ':user_id' => $user_id]);
        $status = $statusStmt->fetch();
        if($status['status'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $sql = "UPDATE `tasks` SET `status` = :new_status WHERE `id` = :id  AND `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['new_status'=>$newStatus,':id'=> $id ,':user_id' => $user_id]);
    }

    static function deleteTask($id, $user_id)
    {
        $conn = connectDB();
        $sql = "DELETE FROM `tasks` WHERE `id` = :id AND `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id'=> $id, ':user_id' => $user_id]);
    }

}
