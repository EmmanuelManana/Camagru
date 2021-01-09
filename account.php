<?php
require 'includes/autoload.php';

App::getAuth()->restrict();

	if(!empty($_POST)){
		$errors = array();
		$db = App::getDatabase();
		$validator = new Validator($_POST);

		if(!empty($_POST['login'])){
			$validator->isAlpha('login', "Invalid login");		
			$validator->isUniq('login', $db, 'user', "login already in use");
			$validator->isTooLong('login', "login too long.");
		}
		if(!empty($_POST['email'])){
			$validator->isEmail('email', "Invalid email format");
			$validator->isUniq('email', $db, 'user', "email already in use");	
			$validator->isTooLong('email', "email too long");	
		}
		if(!empty($_POST['passwd'])){
			$validator->isConfirmed('passwd', "password must contain, 8 cha");
			$validator->isTooLong('passwd', "The password you entered is too long.");
		}
		if ($validator->isValid()) {
			App::getAuth()->modify($db, $_POST['login'], $_POST['email'], $_POST['passwd'], $_POST['mail_com'], $_SESSION['auth']->id);
			Session::getInstance()->setFlash('success', "The changes have been taken into account");
			App::redirect('account.php');
		}else{
			$errors = $validator->getErrors();
		}
	}
			

require 'includes/header.php';?>

<h2>Welcome  <?= $_SESSION['auth']->login; ?></h2>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
	<p>The form was not completed correctly: </p>
		<ul>
		<?php foreach($errors as $error): ?>
			<li><?= $error; ?><br/><br/></li>
		<?php endforeach; ?>
		</ul></div>
<?php endif; ?>


<form action="" method="POST" id="login-form">
	<div class="form-group" id=mini-form>
        <label for="">new login</label>
        <input type="text" name="login" placeholder="new login"/><br/>

        <label for="">change email</label>
        <input type="text" name="email" placeholder="new email"/><br/><br/>

		<label for="">change password</label><br/>
		<input type="password" name="passwd" placeholder="new password"/>
        <input type="password" name="passwd_confirm" placeholder="Confirm Password"/>

	<label><input type="checkbox" checked="checked" name="mail_com" value="1"/>Receive an email with each new comment on one of my photos</label><br/>
	</div>
    <button type="submit" class="submit">Edit my information</button>
</form>

<?php require 'includes/footer.php';?>