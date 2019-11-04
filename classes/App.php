<?php

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

    /* must buid the AuthFile */
    static function getAuth();
    {
        return new Auth(Session::getInstance(), ['restriction_msg' => "you do not have access to this page"]);
    }


    static function redirect($page)
    {
        header("Location: $page");
        exit();
    }
}