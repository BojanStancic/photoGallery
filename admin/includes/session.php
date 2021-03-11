<?php 



class Session 
{

	private $signed_in = false;
	public  $user_id;
	public  $user_logedin;
	public $message;
	public $count;
	public $register = false;

	function __construct() {

		session_start();
		$this->visitor_count();
		$this->check_the_login();
		$this->check_message();

	}


	public function visitor_count(){

		if ($_SESSION['count']) {

			return $this->count = $_SESSION['count']++;
			
		} else {
			return $_SESSION['count'] = 1;
		}

	}


	public function message($msg="") {

		if(!empty($msg)) {

			$_SESSION['message'] = $msg;
		} else {
			return $this->message;
		}
	}


	private function check_message() {

		if(isset($_SESSION['message'])) {
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {

			$this->message = "";
		}
	}


	public function is_signed_in() {
	
		return $this->signed_in;
	}

	public function login($user) {

		if($user) {
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->user_logedin = $_SESSION['username'] = $user->username;
			$this->signed_in = true;
		}
	}


	public function logout() {

		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->signed_in = false;
	}




	private function check_the_login() {

		if(isset($_SESSION['user_id'])){

			$this->user_id = $_SESSION['user_id'];
			$this->signed_in = true;
		} else {

			unset($this->user_id);
			$this->signed_in = false;
		}
	}

	public function user_loged_in(){

		$this->user_logedin = $_POST['username'];
		return $user_logedin;
	}

		public function loged_user($user) {

		if($user) {
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->signed_in = true;
		}
	}


   
		/*******  NE RADIIII, TREBA DOVRSITI *****************/
	public function register($user) {

		if($user) {
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->user_logedin = $_SESSION['username'] = $user->username;
			$this->register = true;
		}
	}


	public function is_register() {
	
		return $this->register;
	}




}


$session = new Session();
$message = $session->message();



















 ?>