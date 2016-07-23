<?php

include_once(__DIR__.'/../model/Ticket.php');
include_once(__DIR__.'/../../base/controller/LoginController.php');

class TMSController  extends LoginController
{
	public $vertical;

	public function __construct()
	{
		$this->vertical = new Vertical();
		
		session_start();
	}

	public function createTicket()
	{
		if($this->loggedin())
		{
			$ticket = new Ticket($_POST);
			$ticket_id = $this->vertical->createTicket($ticket);
			$this->vertical->Ticket_log_entry($ticket_id,$ticket);

			if($ticket_id)
				echo json_encode(array("Sucess"=> true, "message"=> "ticket created"));
		}
		else
		{
			echo json_encode(array("Sucess"=> false, "message"=> "User not loggedin."));
		}
	}

	public function updateTicket()
	{
		if($this->loggedin())
		{
			$ticket_id = $_POST['TicketId'];
			$updated = $this->vertical->updateTicket($ticket_id,$_POST);
			$this->vertical->ticket_log_update($ticket_id,$_POST);

			if($updated)
				echo json_encode(array("Sucess"=> true, "message"=> "ticket updated"));
		}
		else
		{
			echo json_encode(array("Sucess"=> false, "message"=> "User not loggedin."));
		}
		
	}

	public function assignTicket()
	{
		if($this->loggedin())
		{
			$ticket_id = $_GET['TicketId'];
			$user_id  = $_GET['UserId'];
			$assigned = $this->vertical->assignTicket($ticket_id,$user_id);
			$this->vertical->ticket_log_assign($ticket_id,$user_id,true);
			if($assigned)
				echo json_encode(array("Sucess"=> true, "message"=> "ticket assigned to user"));

		}
		else
		{
			echo json_encode(array("Sucess"=> false, "message"=> "User not loggedin."));
		}
	}

	public function assignReporter()
	{
		if($this->loggedin())
		{
			$ticket_id = $_GET['TicketId'];
			$reporter_id  = $_GET['ReporterId'];
			$assigned = $this->vertical->assignReporterToTicket($ticket_id,$reporter_id);
			$this->vertical->ticket_log_assign($ticket_id,$user_id,false);
			if($assigned)
				echo json_encode(array("Sucess"=> true, "message"=> "reporter assigned to ticket "));
		}
		else
		{
			return json_encode(array("Sucess"=> false, "message"=> "User not loggedin."));
		}
	}

	public function comment()
	{
		if($this->loggedin())
		{
			$comment = $_POST["Comment"];
			$user_id = $_SESSION['UserId'];
			$ticket_id= $_POST["TicketId"];
			$comment_id = $this->vertical->comment($comment,$user_id,$ticket_id);
			echo json_encode(array("Sucess"=> true, "message"=> "commented."));
		}
		else
		{
			echo json_encode(array("Sucess"=> false, "message"=> "User not loggedin."));
		}
	}

	public function fetch_comments()
	{
			$user_id = $_GET['UserId'];
			$ticket_id = $_GET['TicketId'];
			$page = isset($_GET["Page"]) ? $_GET["Page"] : 0 ;
			$comments = $this->vertical->fetch_comments($user_id,$page);
			print_r($comments);
	}
		
	public function filter_tickets()
	{
		$tickets = $this->vertical->fetch_filtered_tickets($_GET = array());
		return $tickets;
	}

	public function fetch_ticket_details()
	{
		$ticket_id = $_GET['TicketId'];
		$tickets = $this->vertical->fetch_ticket_details($ticket_id);
		print_r($tickets);
	}

	public function loggedin()
	{
		if(isset($_SESSION['LoggedIn']) &&  $_SESSION['LoggedIn'])
			return true;
		return false;

	}

	public function fetch_tickt_history()
	{
		$ticket_id = $_GET['TicketId'];
		$ticket_his = $this->vertical->fetch_tickt_history($ticket_id);
		print_r($ticket_his);

	}
	// public function session_var()
	// {
	// 	print_r($_SESSION) ;
	// }
	
}






?>