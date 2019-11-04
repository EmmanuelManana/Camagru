<?php

spl_autoload_register('app_autoload');

function app_autoload($class_name)
{
    require "classes/$class_name.php";
}