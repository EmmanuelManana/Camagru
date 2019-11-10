<?php
    require 'includes/autoload';
    App::getAuth()->logout();
    Session::getInstance()->setFlash('success',"You've been logged out");
    App::redirect('login.php');