<?php 

require_once("new_config.php");

class Database
{
	public $connection;
	public $db;

	function __construct(){

		$this->db = $this->open_db_connection();
	}


	public function open_db_connection() {

		// $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME); // OLD WAY 

		$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS,DB_NAME); // NEW WAY

		if($this->connection->connect_errno){
			die("Database connection faild badly" . $this->connection->connect_error);
		}

		return $this->connection;
	}


	public function query($sql) {

		$result = $this->db->query($sql);

		$this->confirm_query($result);

		return $result;
	}

	private function confirm_query($result) {

		if(!$result) {
			die("Query faild" . $this->db->error);

		}
	}


	public function escape_string($string) {

		// $escaped_string = $this->db->real_escape_string($string); // old way
		// return $escaped_string;
		return $this->db->real_escape_string($string);
		
	}

	public function the_insert_id() {
		// return $this->connection->insert_id;

		return mysqli_insert_id($this->db); // ako ne radi staviti connection umesto db
	}











} // End of Class Database

$database = new Database();





 ?>