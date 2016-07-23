<?php
include_once(__DIR__.'/DBConnection.php');

class BaseVertical
{
	public function create_user($user_name,$pass_hash)
	{
		$connection = DBConnection::getInstance()->getConnection();	
		$query = "insert into User (Name,PasswordHash) values ('$user_name','$pass_hash')";
		//print_r($query);
		mysqli_query($connection, $query);
		return mysqli_insert_id($connection);
	}

	public function user_found($userName,$pass_hash)
	{
		$connection = DBConnection::getInstance()->getConnection();	
		$query = "select Id from  User where Name = '$userName' and PasswordHash = '$pass_hash'";
		$result = mysqli_query($connection, $query);
		$result =mysqli_fetch_all($result, MYSQLI_ASSOC);
		if(!empty($result))
		{
			return $result[0]['Id'];
		}
		return false;
	}

	public function user_exists($user_name)
	{
		$connection = DBConnection::getInstance()->getConnection();	
		$query = "select Id from user where Name = '$user_name'";
		$result = mysqli_query($connection, $query);
		$result =mysqli_fetch_all($result, MYSQLI_ASSOC);
		if(empty($result))
			return false;
		return true;

	}

	public function entry_to_error_log_table($error_msg)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "Insert into ErrorLogs (Error) Values ('$error_msg')";
		$result = mysqli_query($connection, $query);

	}



}
?>