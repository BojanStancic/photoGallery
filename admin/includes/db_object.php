<?php 



class Db_object
{


	// protected static $db_table = "users";
	public $errors = array();
	public $upload_errors_array = array(

		UPLOAD_ERR_OK         => "There is no error.",
		UPLOAD_ERR_INI_SIZE   => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
		UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
		UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE    => "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE => "Faild to write file on disk.",
		UPLOAD_ERR_EXTENSION  => "a PHP extension stopped the file upload."

	);

	// This is passing $_FILES['uploaded_file'] as an argument

	public function set_file($file) {

		if (empty($file) || !$file || !is_array($file)) {
			$this->errors[] = "There was no file uploaded here";
			return false;

		} elseif ($file['error'] != 0) {
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;

		} else {

			$this->filename = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
		}




	} // End of set_file Method    // Mozda donja i gornja metoda ne budu lepo radile, jer su samo prekopirane iz photo.php

	// pogotovo donja, zbog $filename 


	// 	public function save_file() {

	// 	if ($this->id) {
	// 		$this->update();

	// 	} else {
	// 		if (!empty($this->errors)) {
				
	// 			return false;
	// 		}

	// 		if (empty($this->filename) || empty($this->tmp_path)) {
	// 			$this->errors[] = "The file was not available";
	// 			return false;
	// 		}

	// 		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

	// 		if (file_exists($target_path)) {
	// 			$this->errors[] = "The file {$this->filename} alredy exists";
	// 			return false;
	// 		}

	// 		if (move_uploaded_file($this->tmp_path, $target_path)) {
				
	// 			if ($this->create()) {
					
	// 				unset($this->tmp_path);
	// 				return true;
	// 			}
	// 		} else {
	// 			$this->errors[] = "The file directory probably does not have promission";
	// 			return false;
	// 		}

	// 	}

	// } // End of save Method


	public static function find_all() {

		return static::find_by_query("SELECT * FROM " . static::$db_table . " ");

	} // End of find_all Method


	public static function find_by_id($id) {
		global $database;
		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");

		return !empty($the_result_array) ? array_shift($the_result_array) : false; // ovo i zakomentarisan kod ispod rade isto


		// if (!empty($the_result_array)){

		// 	$first_item = array_shift($the_result_array);
		// 	return $first_item;
		// } else {
		// 	return false; 
		// }

		
	} // End of find_by_id Method


	//    ------   OVA FUNKCIJA PRONALAZI KORISNIKA PO  IMENU(first_name) KOJE SE UKUCA U ZAGRADU  ------
	//    ------   TREBA DORADITI FUNKCIJU POSTO IZBACUJE SERVERSKU GRESKU KADA SE UKUCA NEPOSTOJECE IME... -----

	public static function fuond_first_name($first_name){

		global $database;


		$fuond_first_name = static::find_by_query("SELECT * FROM  " . static::$db_table . "  WHERE first_name = '$first_name' LIMIT 1");

		return !empty($fuond_first_name) ? array_shift($fuond_first_name) : false;

		// if(!empty($fuond_first_name)){
		// 	echo $fuond_first_name;
		// } else {
		// 	echo 'User not found';
		// }


	} // End of fuond_first_name Method


	// ------   OVOM FUNKCIJOM POZIVAMO FUNKCIJU IZNAD
	public static function find_user_by_first_name($first_name){

		$user_name = static::fuond_first_name($first_name);

		

		if($user_first_name = $user_name->first_name){

			return $user_first_name;

		} else {

			echo "No user with that name";
		}	

	} // End of find_user_by_first_name Method



	public static function find_by_query($sql) {
		global $database;
		$result_set = $database->query($sql);
		$the_object_array = array();

		while ($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = static::instantation($row);
		}

		return $the_object_array;

	} // End of find_by_query Method





	public static function instantation($the_record) {

			$calling_class = get_called_class();

		    $the_object = new $calling_class;

            // $the_object->id         = $found_user['id'];
            // $the_object->username   = $found_user['username'];
            // $the_object->password   = $found_user['password'];
            // $the_object->first_name = $found_user['first_name'];
            // $the_object->last_name  = $found_user['last_name'];

		    foreach ($the_record as $the_attribute => $value) {
		    	if ($the_object->has_the_attribute($the_attribute)) {
		    		
		    		$the_object->$the_attribute = $value;
		    	}
		    }




            return $the_object;

	} // End of Instantation Method


	private function has_the_attribute($the_attribute) {

		$object_properties = get_object_vars($this);

		return array_key_exists($the_attribute, $object_properties);

	} // End of has_the_attribute Method




	protected function properties() {

		$properties = array();

		foreach (static::$db_table_fields as $db_field) {
			
			if (property_exists($this, $db_field)) {

				$properties[$db_field] = $this->$db_field;
			}
		}

		return $properties;
	} // End of Properties Method


	protected function clean_properties() {
		global $database;

		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			
			$clean_properties[$key] = $database->escape_string($value);
		}

		return $clean_properties;


	} // End of clean_properties Method







	public function save(){

		return isset($this->id) ? $this->update() : $this->create();  // --- PREVOD: ako je setovan vec taj ID update ga, ako nema 																		create novi
	
	} // End of save Method


	public function create() {

		global $database;

		$properties = $this->clean_properties();


		$sql = "INSERT INTO " . static::$db_table ." ("  . implode(",", array_keys($properties)) . ")";
		$sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";






		// $sql .= $database->escape_string($this->username) . "', '";
		// $sql .= $database->escape_string($this->password) . "', '";       // ovako je pisao da ne bi sve bilo u jednom redu,
		// $sql .= $database->escape_string($this->first_name) . "', '";	  // radi je konkatenciju (lepio, nastavljao je u novom redu)
		// $sql .= $database->escape_string($this->last_name) . "')";

		if($database->query($sql)) {

			$this->id = $database->the_insert_id();

			return true;

		} else {

			return false;
		}

	} // End of Create Method


	public function update() {

		global $database;

		$properties = $this->clean_properties();

		$properties_pairs = array();

		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='{$value}'";
		}

		$sql = "UPDATE " . static::$db_table ." SET ";
		$sql .= implode(", ", $properties_pairs);
		$sql .= " WHERE id= " . $database->escape_string($this->id);


		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	} // End of Update Method


	public function delete() {

		global $database;

		$sql = "DELETE FROM " . static::$db_table ." WHERE id= " . $database->escape_string($this->id) . " LIMIT 1";

		if($database->query($sql)){ // AKO OVO NE BUDE RADILO KAKO TREBA, 																							 ISKORISTITI NJEGOV KOD ISPOD
			return true;
		} else {
			echo false;
		}

		// return (mysqli_affected_rows($database->connection) == 1) ? true : false;  // OVAKO JE ON URADIO, KOD IZNAD SAM JA URADIO

	} // End of Delete Method



	public static function count_all() {

		global $database;

		$sql = "SELECT COUNT(*) FROM " . static::$db_table;
		$result_set = $database->query($sql);
		$row = mysqli_fetch_array($result_set);

		return array_shift($row);

	}





















} // End of Db_object Class











 ?>