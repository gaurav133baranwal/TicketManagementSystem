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
		//$ticket = new Ticket($_POST);
		$input = array('Title'=>'title1','Description'=>'desc1','Category'=>'cat1','Priority'=>'high',
				'Status'=>'tested','Resolution'=>'resol1');

		$ticket = new Ticket($input);

		$ticket_id = $this->vertical->createTicket($ticket);
		echo $ticket_id;
		return $ticket_id;
	}

	public function updateTicket()
	{
		//$ticket = new Ticket($_POST);
		$input = array('Title'=>'title3','Description'=>'desc3','Category'=>'cat1','Priority'=>'high',
				'Status'=>'tested','Resolution'=>'resol1');

		$this->vertical->updateTicket(3,$input);
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
		$comment_id = $this->vertical->comment($comment,$user_id);
		return $comment_id;
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
		$comments = $this->vertical->fetch_filtered_tickets($_GET);
		return $comments;
	}


	
}
//  $cont = new TMSController();
// $cont->createTicket();
// $cont->assignTicket();
// $cont->updateTicket();





?>