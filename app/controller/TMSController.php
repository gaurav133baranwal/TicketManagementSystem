<?php

include(__DIR__.'/../databaseModel/Vertical.php');
include(__DIR__.'/../model/Ticket.php');

class TMSController
{
	public $vertical;

	public function __construct()
	{
		$this->vertical = new Vertical();
	}

	public function createTicket()
	{
		$user_id = $_POST['UserId'];
		if($this->check_for_user_existence($user_id))
		{
			$ticket = new Ticket($_POST);
			$ticket_id = $this->vertical->createTicket($ticket);
			$this->vertical->assignReporterToTicket($ticket_id,$user_id);
			//make an entry to ticketUpdateLog
			$this->vertical->enter_log($_POST);
			return $ticket_id;
		}
		else
		{
			return json_encode(array("Sucess"=> false, "message"=> "UserId not present"));
		}
		
			// $input = array('Title'=>'title1','Description'=>'desc1','Category'=>'cat1','Priority'=>'high',
		// 		'Status'=>'tested','Resolution'=>'resol1');
		// $ticket = new Ticket($input);
	}

	public function updateTicket()
	{
		$user_id = isset($_POST['UserId'])? $_POST['UserId']:null ;
		if($user_id==null)
			return json_encode(array("Sucess"=> false, "message"=> "UserId not present"));

		// this user has to be either user or the reporter of this ticket to update it.
		$ticket_id = $_POST['TicketId'];
		$ticket_user = $this->vertical->fetch_user_reporter_ticket($ticket_id);
		if($ticket_user == null || in_array($user_id, $ticket_user[0]))
			$this->vertical->updateTicket($ticket_id,$_POST);
		else
		{
			return json_encode(array("Sucess"=> false, "message"=> "UserId not present"));
		}

		// $input = array('Title'=>'title3','Description'=>'desc3','Category'=>'cat1','Priority'=>'high',
		// 		'Status'=>'tested','Resolution'=>'resol1');
		
	}

	public function assignTicket()
	{
		$ticket_id = $_GET['TicketId'];
		$user_id  = $_GET['UserId'];
		$this->vertical->assignTicket($ticket_id,$user_id);
		//$this->vertical->assignTicket(3,2);
	}

	public function assignReporter()
	{
		$ticket_id = $_GET['TicketId'];
		$reporter_id  = $_GET['ReporterId'];
		$this->vertical->assignReporterToTicket($ticket_id,$reporter_id);
	}

	public function comment()
	{
		$comment = $_GET["Comment"];
		$user_id = $_GET["UserId"];
		$ticket_id= $_GET["TicketId"];
		$ticket_user = $this->vertical->fetch_user_reporter_ticket($ticket_id);
		if(in_array($user_id, $ticket_user[0]))
		{
			$comment_id = $this->vertical->comment($ticket_id,$user_id,$comment);
			return $comment_id;
		}
		else{
			return json_encode(array("Sucess"=> false, "message"=> "UserId not authenticated to comment on this ticket"));
		}
	}

	public function fetch_comments()
	{
		$user_id = $_GET["UserId"];
		$page = isset($_GET["Page"]) ? $_GET["Page"] : 0 ;
		$comments = $this->vertical->fetch_comments($user_id,$page);
		return $comments;
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
		return $tickets;
	}

	public function create_user()
	{
		$user_id = $this->vertical->create_user($_GET['Name']);
		return $user_id;
	}


	
}
//  $cont = new TMSController();
// $cont->createTicket();
// $cont->assignTicket();
// $cont->updateTicket();





?>