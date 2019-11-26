<?php 
require 'includes/autoload.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success', "logged out");
App::redirect('login.php');