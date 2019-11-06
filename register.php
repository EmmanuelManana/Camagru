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
        $validator->isTooLong('forename', "forename too long, exceedds 250 characters");
        $validator->isAlpha('login', "Invalid login");
        $validator->isTooLong('login', "login too long, exceedds 250 characters");
    }
?>

<?php
   //include_once 'includes/header.php';
?>

<h2>Register</h2>

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

    </div>
    <button  type="submit" class="submit">Submit</button>
</form>


<?php // require_once 'includes/footer.php'; 

    if(!empty($_POST))
    {
         print_r($_POST);
    }

?>


