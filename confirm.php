<?php
require_once 'includes/autoload.php';

$db = App::getDatabase();

if (App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){
	Session::getInstance()->setFlash('success', "youre account has been activated");
	App::redirect('account.php');
}else{
	Session::getInstance()->setFlash('danger', "invalid token");
	App::redirect('login.php');
}
?>