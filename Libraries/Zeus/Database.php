<?php

namespace Zeus
{	
	class Database
	{
		public $dbConnection;
		
		public function __construct()
		{
			try
			{
				$dbConf = API::GetSetting('database');
				$this->dbConnection = new \PDO('mysql:dbname=' . $dbConf['database'] . ';host=' . $dbConf['host'] . ';port=' . $dbConf['port'], $dbConf['username'], $dbConf['password']);
				return $this->dbConnection;
			}
			catch(\PDOException $e)
			{
				API::Respond(['Error'=>'Unable to establish a connection to the database.'], '500 Internal Server Error');
			}
		}
	}
}