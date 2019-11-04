
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
        <label for="">Email</label>
        <input type="email" name="email" required value="<?php if(!empty($_POST)){echo $_POST['email'];}?>"/>
        <label>Password</label>
        <input type="password" name="passwd" required>
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


