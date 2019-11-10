<?php

    require_once 'includes/autoload.php';
    $auth = App::getAuth();
    $db = App::getDatabase();
    $auth->connectFromCookie($db);

    if ($auth->user())/* if a session varable associated with this account exsit*/
    {
        App::redirect('account.php');/* take user to the account*/
    }

    if (!empty($_POST) && !empty($_POST['passwd']))
    {
        /* login() ->queries the database to check if user exist and has been verified( that if check = 1)*/
        $user = $auth->login($db, $_POST['login'], $_POST['passwd'], isset($_POST['remember']));
        $session = Session::getInstance();

        if ($user)
        {
            $session->setFlash('success', "You are connected");
		    App::redirect('index.php');
        }
        else
        {
            $session->setFlash('danger', "Connection fail");
        }

    }

?>

<?php  require 'includes/header.php'; ?>

<h2>Login</h2>
<form action="" method="POST" id="login-form">

    <div class="form-group" id=mini-form>
        <label for="">Login/email</label>
        <input type="text" name="login"/>

        <label for="">password</label>
        <input type="password" name="passwd" required/>
		
		<a id=passwd-forgot href="forget.php" style="text-align: center">Forgot your password?</a>
    </div>

    <button type="submit" class="submit">login</button>

</form>

<?php  require 'includes/footer.php'; ?>