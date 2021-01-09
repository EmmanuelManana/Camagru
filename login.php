<?php
require_once 'includes/autoload.php';
$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);

if($auth->user()){
	App::redirect('account.php');
}

if (!empty($_POST) && !empty($_POST['passwd'])){
	$user = $auth->login($db, $_POST['login'], $_POST['passwd'], isset($_POST['remember']));
	$session = Session::getInstance();
	if ($user){
		$session->setFlash('success', "your logged in");
		App::redirect('index.php');
	}else{
		$session->setFlash('danger', "login error");		
	}
}

?>

<?php require 'includes/header.php';?>

<h2>login</h2>
<form action="" method="POST" id="login-form">
    <div class="form-group" id=mini-form>
        <label for="">Login/email</label>
        <input type="text" name="login"/>

        <label for="">Password</label>
        <input type="password" name="passwd" required/>
		
		<a id=passwd-forgot href="forget.php" style="text-align: center"> forgot password ?</a>
    </div>

    <button type="submit" class="submit">login</button>

</form>

<?php require 'includes/footer.php';?>


