<?php
$action = ($_SERVER["REQUEST_URI"] == '/') ? 'user/auth' : '';

if(isset($data['errMsg'])){
    echo '<div class="alert alert-danger text-center"><span>'.htmlspecialchars($data['errMsg']).'</span></div>';
}
?>
<div id="login">
    <div class="container align-items-center pt-5">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="<?= $action; ?>" method="post">
                        <h2 class="text-center text-dark">Login</h2>
                        <div class="form-group">
                            <label for="username" class="text-dark">Username:</label><br>
                            <input type="text" name="login" id="login" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Password:</label><br>
                            <input type="text" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-dark btn-block" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>