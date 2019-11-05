<?php

require_once '../config/database.php';

class App
{
    static $db = null;

    static function getDatabase()
    {
        if (!self::$db)
        {
            /* pass as params -> dbusername,dbpasssword, dbname*/
            self::$db = new Database($DB_USER, $DB_PASSWORD,$DB_NAME); 
        }
        return self::$db;
    }

    /*done*/
    static function getAuth();
    {
        return new Auth(Session::getInstance(), ['restriction_msg' => "you do not have access to this page"]);
    }

    /*done*/
    static function redirect($page)
    {
        header("Location: $page");
        exit();
    }
}