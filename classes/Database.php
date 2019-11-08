<?php

	class Database
	{
		
		private $pdo;

		public function __construct($login, $password, $database_name = NULL, $host = "127.0.0.1")
		{
			if (isset($database_name) && !empty($database_name))
			{
				$this->pdo = new PDO("mysql:host=$host;dbname=$database_name;charset=utf8", $login, $password);
			}
			else
			{
				$this->pdo = new PDO("mysql:host=$host;charset=utf8", $login, $password);
			} 
			// set the PDO error mode to exception
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}

		public function query($query, $params = false)
		{
			if ($params)
			{
				$request = $this->pdo->prepare($query);
				$request->execute($params);
			}
			else
			{
				$request = $this->pdo->query($query);
			}
			return ($request);
		}

		public function lastInsertId()
		{
			return $this->pdo->lastInsertId();
		}
	}

?>