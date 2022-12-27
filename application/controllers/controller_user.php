<?php

class Controller_User extends Controller
{

    public function action_index()
    {
        $user_status = User::checkAuth();
        if ($user_status == true) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . '/task');
        } else {
            $this->view->generate('login_view.php', 'template_view.php');
        }

    }

    public function action_auth()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            $authResult = User::checkUser($login);

            switch ($authResult) {
                case 'User Exists':
                    $loginResult = User::userLogin($login, $password);
                    if (is_object($loginResult)) {
                        $this->createUserSession($loginResult);
                    } else {
                        $this->errReturn($loginResult);
                    }
                    break;
                case 'Need to registrate':
                    $regResult = User::registrate($login, $password);
                    if (is_object($regResult)) {
                        $this->createUserSession($regResult);
                    } else {
                        $msg = $regResult;
                        $this->errReturn($msg);
                    }
                    break;
            }
        }else{
            $msg = "All fields require!";
            $this->errReturn($msg);
        }
    }


    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['login'] = $user->getUserLogin();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . '/task');
    }

    public function action_logout()
    {

        unset($_SESSION['user_id']);
        unset($_SESSION['login']);
        header("Location: http://" . $_SERVER['HTTP_HOST']);

    }

    private function errReturn($msg)
    {
        $this->view->generate('login_view.php', 'template_view.php', ['errMsg'=>$msg]);
    }


}