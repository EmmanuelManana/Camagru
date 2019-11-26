<?php
	require_once 'includes/autoload.php';

    if (!empty($_POST)) {
		$errors = array();

		$db = App::getDatabase();
		$validator = new Validator($_POST);
		$validator->isAlpha('name', "lastname is invalid");
		$validator->isTooLong('name', "lastname too long");
		$validator->isAlpha('forename', "firstname is invalid");	
		$validator->isTooLong('forename', "firstname is too long");
		$validator->isAlpha('login', "login is invalid");
		$validator->isTooLong('login', "login is too long");
		$validator->isUniq('login', $db, 'user', "login already im use ");
		$validator->isEmail('email', "invalid e-mail");
		$validator->isTooLong('email', "email is too long");
		$validator->isUniq('email', $db, 'user', "email already in use");		
		$validator->isConfirmed('passwd', "Invalid Password");
		$validator->isTooLong('passwd', "password is too long");

		if ($validator->isValid()) {
			App::getAuth()->register($db, $_POST['name'], $_POST['forename'], $_POST['login'], $_POST['email'], $_POST['passwd']);
			$session = new Session();
			Session::getInstance()->setFlash('success', "a verication email has nbeen sent to you.");
			App::redirect('login.php');
			die('Your account has been created. Please validate by clicking on the link received by email.');
		}else{
			$errors = $validator->getErrors();
		}
    }
?>

<?php require_once 'includes/header.php'; ?>


<h2>Register</h2>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
	<p> form was not completed correctly : </p>
		<ul>
		<?php foreach($errors as $error): ?>
			<li><?= $error; ?><br/><br/></li>
		<?php endforeach; ?>
		</ul></div>
<?php endif; ?>

<form action="" method="POST" id="login-form">
    <div class="form-group" id=mini-form>
        <label for="">lastname</label>
        <input type="text" name="name" value="<?php if (!empty($_POST)){echo $_POST['name'];}?>"/>

        <label for="">firstname</label>
        <input type="text" name="forename" value="<?php if (!empty($_POST)){echo $_POST['forename'];}?>"/>

        <label for="">Login</label>
        <input type="text" name="login" value="<?php if (!empty($_POST)){echo $_POST['login'];}?>"/>

		<label for="">Email</label>
        <input type="email" name="email" required value="<?php if (!empty($_POST)){echo $_POST['email'];}?>"/>

        <label for="">Password</label>
        <input type="password" name="passwd" required/>

        <label for="">Confirm Password</label>
        <input type="password" name="passwd_confirm" required/>
		
    </div>

    <button type="submit" class="submit">Register</button>

</form>


<?php require 'includes/footer.php'; ?>