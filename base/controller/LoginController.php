<?php
include_once(__DIR__.'/../../app/databaseModel/Vertical.php');


class LoginController
{

	public $base_vertical;

	public function __construct()
	{
		$this->base_vertical = new BaseVertical();
		session_start();
	}

	public function registerUser()
	{
		//echo 'here'; print_r($_GET) ;exit();
		$userName = $_POST['Name'];
		$pass_hash = md5($_POST['Password']);
		// $userName = $_GET['Name'];
		// $pass_hash = md5($_GET['Password']);
		if($this->base_vertical->user_exists($userName))
		{
			echo json_encode(array('success'=>false, 'message'=>'userName already exists'));
			return;
		}
		$userId = $this->base_vertical->create_user($userName,$pass_hash);
		$this->start_session($userId ,$userName);
		if($_SESSION['LoggedIn'])
			echo json_encode(array('success'=>true, 'message'=>'registration successful.'));


	}

	public function login()
	{
		$userName = $_POST['Name'];
		$pass_hash = md5($_POST['Password']);
		$userId = $this->base_vertical->user_found($userName,$pass_hash);
		if($userId !=false)
		{
			$this->start_session($userId,$userName);
			//print_r($_SESSION);
			echo json_encode(array('success'=>true, 'message'=>'user logged in.'));

		}
		else
		{
			$this->logout();
			echo json_encode(array('success'=>false, 'message'=>'invalid login details.'));
		}
	}

	public function logout()
	{
		if (isset($_SESSION['Name']))
		{
			echo 'inside';
			unset($_SESSION['UserId']);
			unset($_SESSION['Name']);
			unset($_SESSION['LoggedIn']);
			session_destroy();

		}	
		echo json_encode(array('success'=>true, 'message'=>'logged out'));
	}

	private function start_session($userId ,$userName)
	{
		$_SESSION['UserId'] = $userId ;
		$_SESSION['Name'] = $userName ;
		$_SESSION['LoggedIn'] = true;
	}

	// public function session_var()
	// {
	// 	print_r($_SESSION) ;
	// }


}