<?php
require_once 'includes/autoload.php';

    /* if there are no session variables from the login page, then redirect user to login page*/
//App::getAuth()->restrict();/* get Auth return the AUTH class, hence we access to all methods in  the Class Auth*/

    if (!empty($_POST))
    {
        $errors = array();
        $db = App::getDatabase();
        $validator = new Validator($_POST);

        if(!empty($_POST['login']))
        {
			$validator->isAlpha('login', "Invalid Login");		
			$validator->isUniq('login', $db, "login already in use");
			$validator->isTooLong('login', "Login too long");
		}
        if(!empty($_POST['email']))
        {
			$validator->isEmail('email', "Invalid E-Mail");
			$validator->isUniq('email', $db, 'user', "This E-Mail has been used");	
			$validator->isTooLong('email', "E-Mail too long");	
		}
        if(!empty($_POST['passwd']))
        {
			$validator->isConfirmed('passwd', "password must contain 8 min, atleast 1 special characters and atleast 1 digit");
			$validator->isTooLong('passwd', "The password you have entered is too long.");
        }
        if ($validator->isValid()) 
        {
            App::getAuth()->modify($db, $_POST['login'], $_POST['email'], $_POST['passwd'], $_POST['mail_com'], $_SESSION['auth']->id);
            Session::getInstance()->setFlash('success', "The changes have been made");
            App::redirect('account.php');
        }
        else
        {
            $errors = $validator->getErrors();
        }
    }
   require 'includes/header.php';
?>

<h2> Welcome <?= $_SESSION['auth']->login; ?></h2>

<?php  if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>The form was not completed correctly: </p>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li>$error<br/><br/></li>
                <?php endforeach; ?>
            </ul>
    </div>
<?php  endif; ?>


<form action="" method="POST" id="login-form">
    <div class="form-group" id=mini-form>

        <label>change login</label>
        <input type="text" name="login" placeholder="new login"/><br/>

        <label>change e-mail</label>
        <input type="text" name="email" placeholder="new email"><br/><br/>

        <label for="">create new password</label><br/>
		<input type="password" name="passwd" placeholder="new password"/><br/>
        <input type="password" name="passwd_confirm" placeholder="password confirmation"/>

    </div>
    <button type="submit" class="submit">change your Details</button>
</form>

<?php require 'includes/footer.php';