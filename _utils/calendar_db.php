<?php
	class Database {
		
		private static $connection = null;
		
		private static $dbHost = 'localhost';
		private static $dbUser = 'panicUser';
		private static $dbPass = '123';
		private static $dbName = 'biyerds420';

		function __construct() {}

		public static function connect() {
			
			if(null == self::$connection) {
				try {
					self::$connection = new PDO('mysql:host='.self::$dbHost.';dbname='.self::$dbName, self::$dbUser, self::$dbPass);
					self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				} catch(PDOException $e) {
					$e->getCode();
				}	
			}
			return self::$connection;
		}

		public static function disconnect() {
			self::$connection = null;
		}

	}
?>