<?php
// Database Connection to MYSQL
class Database {
	// Static variables for database connection
	// Name of the Host
	private static $db_host = 'localhost';
	// Username
	private static $db_user = 'root';
	// Password
	private static $db_pass = '';
	// Database name
	private static $db_name = 'biyerds420';
	
	// Default connection
	private static $connect = null;
	
	// Class constructor
	public function __construct() {
		die('Init function has been disabled');
	}
	
	// Class connection
	public static function connection() {
		// Checking default connection
		if (null == self::$connect) {
			// Establishing connection
			try {
				self::$connect = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name,self::$db_user,self::$db_pass);
				//Validating connection
				self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			} catch (PDOException $e) {
				$e->getCode();
			}
		}
		// Connection successfull
		return self::$connect;
	}
	// Connection disconnect
	public static function disconnect() {
		self::$connect = null;
	}
}
?>