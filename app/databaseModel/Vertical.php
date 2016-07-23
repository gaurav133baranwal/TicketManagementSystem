<?php
include_once(__DIR__.'/../../base/model/BaseVertical.php');

class Vertical extends BaseVertical
{
	public function createTicket($ticket)
	{
		$connection = DBConnection::getInstance()->getConnection();

		if(!in_array($ticket->priority,array('low','medium','high')))
			$ticket->priority ='low';

		if(!in_array($ticket->status,array('notStarted','Inprogress','Finished','Tested','Closed')))
			$ticket->status ='notStarted';


		$query = "insert into ticket (Title,Description,Category,Priority,Status,Resolution) 
				  values ('$ticket->title','$ticket->description','$ticket->category','$ticket->priority',
				  	'$ticket->status','$ticket->resolution')" ;

		$insertion = mysqli_query($connection, $query);
		if($insertion)
			return mysqli_insert_id($connection);
		return $insertion;

	}

	public function updateTicket($ticket_id,$update_array)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$keys = array_keys($update_array);
		$modify_string = '';

		for ($i=0; $i < sizeof($keys)-1; $i++) 
		{ 
			if($modify_string!='')
				$modify_string = $modify_string.','.$keys[$i] .'=\''.$update_array[$keys[$i]].'\'' ;
			else 
				$modify_string = $keys[$i] .'=\''.$update_array[$keys[$i]] .'\'';

		}
		$query = "update Ticket set $modify_string where Id = $ticket_id";
		$result =  mysqli_query($connection, $query);
		return $result ;

	}

	public function assignTicket($ticket_id,$user_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "insert into Task (TicketId,UserId) values ($ticket_id,$user_id) on duplicate key
		          update UserId = $user_id";
		$result =  mysqli_query($connection, $query);
		return $result;
	}

	public function assignReporterToTicket($ticket_id,$reporter_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "insert into Task (TicketId,ReporterId) values ($ticket_id,$reporter_id) on duplicate key
		          update ReporterId = $reporter_id";
		$result =  mysqli_query($connection, $query);
		return $result;

	}

	public function comment($comment,$user_id,$ticket_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$c_query = "insert into Comment (Comment,UserId,TicketId) values ('$comment',$user_id,$ticket_id)";
		$result =  mysqli_query($connection, $c_query);
		return mysqli_insert_id($connection);

	}

	public function fetch_comments($user_id=null,$ticket_id=null,$page=0)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "select c.Comment u.Name from Comment c inner join User u on c.UserId = u.Id " ;
		if($user_id !=null)
		{
			$query.="where u.Id = $user_id";
		}
		if($ticket_id !=null)
		{
			$query.="where c.TicketId = $ticket_id";
		}
		$start = $page*10;
		$end = ($page+1)*10 ;
		$query .= " limit $start ,$end" ;
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	public function fetch_ticket_details($ticket_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "select * from ticket t left join task ts on t.Id = ts.TicketId left join user u on u.Id = ts.UserId where t.Id =".$ticket_id ;
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

	public function fetch_user_reporter_ticket($ticket_id)
	{
		$connection = DBConnection::getInstance()->getConnection();	
		$query = "select UserId,ReporterId from Task where TicketId = $ticket_id";
		$result =  mysqli_query($connection, $query);
		$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $result;

	}

	public function fetch_filtered_tickets($filter_array)
	{
		$connection = DBConnection::getInstance()->getConnection();

		$usr_query = 1;
		$status_query= 1;
		$r_query = 1;
		$st_query= 1;
		$en_query= 1;
		$lim_q= "limit 0,10" ;


		if(isset($filter_array['UserId']))
		{
			$user_id = $filter_array['UserId'] ;
			$usr_query = "ts.UserId = $user_id";
		}
		if(isset($filter_array['Status']))
		{
			$status = $filter_array['Status'] ;
			$status_query = "t.Status = $status";
		}
		if(isset($filter_array['Resolution']))
		{
			$status = $filter_array['Resolution'] ;
			$r_query = "t.Resolution = $resolution";
		}
		if(isset($filter_array['StartDate']))
		{
			$status = $filter_array['startDate'] ;
			$st_query = "t.StartDate = $startDate";
		}
		if(isset($filter_array['EndDate']))
		{
			$status = $filter_array['EndDate'] ;
			$en_query = "t.EndDate = $endDate";
		}
		if(isset($filter_array['Page']))
		{
			$page = $filter_array['Page'] ;
			$lim_q = "limit $page*10 , ($page+1)*10";
		}

		if($usr_query==1)
		{
			$query = "select * from Ticket t where 1 and $status_query and $r_query 
					and $st_query and $en_query $lim_q" ;
		}
		else
		{
			$query = "select * from Ticket t inner join Task ts on t.Id = ts.TicketId where 1 and $usr_query and $status_query and $r_query 
					and $st_query and $en_query $lim_q" ;
		}

		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

	public function enter_log($parameters)
	{
		$connection = DBConnection::getInstance()->getConnection();

		$query = "insert into ticketUpdateLog (Title,Description,Category,Priority,Status,Resolution,ReporterId) 
				  values ('".$parameters['Title']."','".$parameters['Description']."','".$parameters['Category']."','".
				  	$parameters['Priority']."','".$parameters['Status']."','".$parameters['Resolution']."','".$parameters['ReporterId'] ;

	    mysqli_query($connection, $query);
		
	}

	public function enter_log_user($ticket_id,$user_id,$user = true)
	{
		$connection = DBConnection::getInstance()->getConnection();
		if($user)
			$query ="insert into ticketUpdateLog (TicketId,UserId) values ($ticket_id,$user_id)";
		else
			$query ="insert into ticketUpdateLog (TicketId,ReporterId) values ($ticket_id,$user_id)";

		mysqli_query($connection, $query);
	}


	public function ticket_log_entry($ticket_id,$ticket)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$entry_text = "Ticket created with Title: $ticket->title , Description: $ticket->description ,
						Category: $ticket->category ,Priority: $ticket->priority , Status: $ticket->status 
						and Resolution : $ticket->resolution" ;

		$query = "insert into TicketLog (TicketId,LogMessage) Values ($ticket_id,'$entry_text')" ;
		print_r($query);
		mysqli_query($connection, $query);
	}

	public function ticket_log_assign($ticket_id,$user_id,$is_user)
	{
		$connection = DBConnection::getInstance()->getConnection();
		if($is_user)
		{
			$text = " user $user_id assigned as user" ;
		}
		else
		{
			$text = " Reporter $user_id assigned as reporter" ;
		}
		$query = "insert into TicketLog(TicketId,LogMessage) Values ($ticket_id,'$text')" ;
		mysqli_query($connection, $query);
	
	}

	public function ticket_log_update($ticket_id, $update_array)
	{

		$connection = DBConnection::getInstance()->getConnection();
		$keys = array_keys($update_array);
		$modify_string = '';

		for ($i=0; $i < sizeof($keys)-1; $i++) 
		{ 
			if($modify_string!='')
				$modify_string = $modify_string.','.$keys[$i] .'=\''.$update_array[$keys[$i]].'\'' ;
			else 
				$modify_string = $keys[$i] .'=\''.$update_array[$keys[$i]] .'\'';

		}
		$query = "Insert into TicketLog (TicketId,LogMessage) values ($ticket_id,'Ticket updated to $modify_string') ";
		$result =  mysqli_query($connection, $query);
		return $result ;
	}

	public function fetch_tickt_history($ticket_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "select * from TicketLog where TicketId = $ticket_id";
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}
}
?>