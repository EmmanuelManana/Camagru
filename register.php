<?php
    require_once 'includes/autoload.php';

    if (!empty($_POST))
    {
        $errors = array();

        $db = App::getDatabase();
        $validator = new Validator($_POST);

        $validator->isAlpha('name', "Invalid username");
        $validator->isTooLong('name', "name too long, exceeds 250 charecters");
        $validator->isAlpha('forename', "Invalid login");
        $validator->isTooLong('forename', "forename too long, exceeds 250 characters");
        $validator->isAlpha('login', "Invalid login");
        $validator->isTooLong('login', "login too long, exceeds 250 characters");
        $validator->isUniq('login', $db, 'user', "The login is already used");
		$validator->isEmail('email', "invalid email.");
		$validator->isTooLong('email', "email is too long");
		$validator->isUniq('email', $db, 'user', "email has been registered already");		
		$validator->isConfirmed('passwd', " Password must contain 8 min characters, aleast 1 Uppercase, 1 special character)");
		$validator->isTooLong('passwd', "the password is too long");
	//	$validator->isCaptcha('g-recaptcha-response', "the captcha did not work");

        if($validator->isValid())
        {
            /*start a new session if user is valid*/
            App::getAuth()->register($db, $_POST['name'], $_POST['forename'], $_POST['login'], $_POST['email'], $_POST['passwd']);
            $session = new Session();
            Session::getInstance()->setFlash('success', "a Confirmation email has been sent to validate your account");
            // App::redirect('login.php');
			die('Your account has been created. Please validate by clicking on the sent on your email.');
        }
        else
        {
            $errors = $validator->getErrors();
            //print_r($errors);
        }
    }
?>

<?php
   include_once 'includes/header.php';
?>

<h2>Register</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>the form was completed incorrectly: </p>
            <ul>
                <?php  foreach($errors as $error): ?>
                     <li><?= $error; ?><br/><br/></li>
                    <?php endforeach; ?>
            </ul>
    </div>
<?php endif; ?>

<form method="POST" id="login-form">
    <div class="form-group" id="mini-form">

        <label>Last name</label>
        <input type="text" name="name" value="<?php if(!empty($_POST)){echo $_POST['name'];}  ?>">

        <label>First name</label>
        <input type="text" name="forename" value="<?php if(!empty($_POST)){echo $_POST['forename'];}  ?>">

        <label for="">Login</label>
        <input type="text" name="login" value="<?php if (!empty($_POST)){echo $_POST['login'];}?>"/>

        <label for="">Email</label>
        <input type="email" name="email" required value="<?php if(!empty($_POST)){echo $_POST['email'];}?>"/>

        <label>Password</label>
        <input type="password" name="passwd" required><!-- will show red boxes if theres no input-->

        <label>Password Confirmmation</label>
        <input type="password" name="passwd_confirm" required>

        <br/>
	<!--	<div class="g-recaptcha" data-sitekey="6Ld1gMEUAAAAADd8GjOC4eFoseSUz1zDeCgEHtmW"></div>-->

    </div>
    <button  type="submit" class="submit">Submit</button>
</form>


