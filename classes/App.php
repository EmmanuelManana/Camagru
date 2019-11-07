<?php

//require_once '../config/database.php';

class App
{
    static $db = null;

    static function getDatabase()
    {
        if (!self::$db)
        {
            /* pass as params -> dbusername,dbpasssword, dbname*/
            self::$db = new Database('root', 'root','camagru');
        }
        return self::$db;
    }

    /*done*/
    static function getAuth()//return the "Auth class" to have accesibliity to every method of authentication, hence "getAuth"
    {
        /*get instance starts a new session*/
        return new Auth(Session::getInstance(), ['restriction_msg' => "you do not have access to this page"]);
    }

    /*done*/
    static function redirect($page)
    {
        header("Location: $page");
        exit();
    }
}