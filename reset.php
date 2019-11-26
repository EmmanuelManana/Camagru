<?php
require 'includes/autoload.php';
if(isset($_GET['id']) && isset($_GET['token'])){
	$auth = App::getAuth();
	$db = App::getDatabase();
	$user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
    if($user){
        if(!empty($_POST)){
			$validator = new Validator($_POST);
			$validator->isTooLong('passwd', "Entererd password is too long");
			$validator->isConfirmed('passwd', "password must have 8 char's, one digit, uppercase and one spec char ");
			if ($validator->isValid()&& $_POST['passwd'] == $_POST['passwd_confirm']){
				$password = $auth->hashPassword($_POST['passwd']);
				$db->query('UPDATE user SET `passwd` = ?, `reset_at` = NULL, `reset_token` = NULL WHERE id = ?', [$password, $_GET['id']]);
				$auth->connect($user);
				$session = Session::getInstance();
				$session->setFlash('success', "Your password has been changed.");
				App::redirect('account.php');
			}else {
				$session = Session::getInstance();
				$session->setFlash('danger', "Passwords do not match");
			}
		}
	}else{
		$session = Session::getInstance();
		$session->setFlash('danger', "This token is not valid");
		App::redirect('login.php');
	}
}else{
	App::redirect('login.php');
}
?>

<?php require 'includes/header.php';?>

<h2>password reset</h2>
<form action="" method="POST" id="login-form">

    <div class="form-group" id="mini-form">
        <label for="">password</a></label>
        <input type="password" name="passwd" required/>
    </div>

	<div class="form-group"id="mini-form">
        <label for="">confirm password</label></label>
        <input type="password" name="passwd_confirm" required/>
    </div>

    <button type="submit" class="submit">reset password</button> 

</form>

<?php require 'includes/footer.php';?>


