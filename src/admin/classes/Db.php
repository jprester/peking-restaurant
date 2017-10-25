<?php
class Db{
	protected $host,
		$user,
		$pass,
		$dbname,
		$pdo;

	public function __construct(){
		try {
			$host= DB_HOST;
			$dbname=DB_NAME;
			$user=DB_USER;
			$pass= DB_USER;
			$this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}

		catch(PDOException $e) {
			echo $e->getMessage();
			echo "something is wrong";
		}

	}
}
?>