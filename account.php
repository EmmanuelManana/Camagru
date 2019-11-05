<?php
    require_once 'includes/autoload.php';
?>

<?php  //require 'includes/header.php' ?>

<form action="" method="POST" id="login-form">
    <div class="form-group" id=mini-form>
        <label>change login</label>
        <input type="text" name="login" placeholder="new login"/><br/>

        <label>chance e-mail</label>
        <input type="text" name="email" placeholder="new email"><br/><br/>
    </div>
</form>

<?php require 'includes/footer.php';