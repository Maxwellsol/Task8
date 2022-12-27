<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/connection.php';

class User extends Model
{
    private int $user_id;
    private string $login;
    private string $password;

    public function __construct(int $user_id, string $login, string $password)
    {
        $this->user_id = $user_id;
        $this->login = $login;
        $this->password = $password;
    }

    public function registrate($login, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $userData = ['registerLogin' => $login,
            'registerPassword' => $hash];
        try {
            $conn = connectDB();
            $sql = "INSERT INTO users (login, password) VALUES (:registerLogin, :registerPassword)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($userData);
            $user_id = $conn->lastInsertId();
            $_SESSION['session_username'] = $login;
            $_SESSION['user_id'] = $user_id;
            $user = new User($user_id, $login, $password);
            return $user;
        } catch (PDOException $e) {
            return 'Registration Error: ' . $e->getMessage();
        }
    }

    static function checkAuth()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    static function checkUser($login): string
    {
        $conn = connectDB();
        $sql = "SELECT * FROM `users` WHERE `login`=:login";
        $userData = $conn->prepare($sql);
        $userData->execute([':login' => $login]);
        if ($userData->rowCount() != 0) {
            return 'User Exists';
        } else {
            return 'Need to registrate';
        }
    }

    static function userLogin($login, $password)
    {
        $conn = connectDB();
        $sql = "SELECT * FROM `users` WHERE `login`=:login";
        $userData = $conn->prepare($sql);
        $userData->execute([':login' => $login]);
        $userFields = $userData->fetch();
        if (password_verify($password, $userFields['password'])) {
            $user = new User($userFields['id'], $userFields['login'], $userFields['password']);
            return $user;
        } else {
            return 'Wrong Password!';
        }
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUserLogin(): string
    {
        return $this->login;
    }
}