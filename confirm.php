<?php

require_once 'includes/autoload.php';

$db = App::getDatabase();

if (App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance()))
{
    Session::getInstance()->setFlash('success'," ");
    App::redirect('account.php');
}
else
{
    Session::getInstance()->setFlash('Danger', "");
    App::redirect('login.php');
}