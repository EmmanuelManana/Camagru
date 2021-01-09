<?php
require 'includes/autoload.php';
if(!empty($_POST) && !empty($_POST['email'])){
	$db = App::getDatabase();
	$auth = App::getAuth();
	$session = Session::getInstance();
	if ($auth->resetPassword($db, $_POST['email'])){
		$session->setFlash('success', "The password reminder instructions have been sent to you by email.");
		App::redirect('login.php');
	}else{
		$session->setFlash('danger', "no account matches this address");		
	}
}
?>

<?php require 'includes/header.php';?>

<h2>Forgot your password?</h2>
<form action="" method="POST" id="login-form">
    <div class="form-group" id=mini-form>
        <label for="">Email</label>
        <input type="email" name="email"/>
    </div>

    <button type="submit" class="submit">Reset password</button> 

</form>

<?php require 'includes/footer.php';?>