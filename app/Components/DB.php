<?php

namespace App\Components;

use PDO;

class DB {
	/**
     * @var PDO
     */
	private static $db;

	/**
	 * Connection
	 * 
     * @return void
     */
	private static function connect()
	{
		$params = config('db');

		$pdo = new PDO("mysql:host=$params[hostname];dbname=$params[database]", 
			$params['username'], 
			$params['password'],
		);

		self::$db = $pdo;
	}

	/**
	 * Query
	 * 
	 * @param string $sql sql-query
     * @return PDOStatement|bool result of query 
     */
	public static function query($sql)
	{
		if (self::$db === null) {
			self::connect();
		}
		
		return self::$db->query($sql);
	}

	/**
	 * PDO
	 * 
     * @return PDO
     */
	public static function get()
	{
		if (self::$db === null) {
			self::connect();
		}

		return self::$db;
	}
}
