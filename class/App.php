<?php

class App{

	static $db = null;

	static function getDatabase(){
		if(!self::$db){
			self::$db = new Database('root', '123pass', 'camagru');
		}
		return self::$db;
	}

	static function getAuth(){
		return new Auth(Session::getInstance(), ['restriction_msg' => "You do not access to this page"]);
	}

	static function redirect($page){
		header("Location: $page");
		exit();
	}
}