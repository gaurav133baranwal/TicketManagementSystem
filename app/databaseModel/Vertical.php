<?php
include(__DIR__.'/DBConnection.php');

class Vertical
{
	public function createTicket($ticket)
	{
		$connection = DBConnection::getInstance()->getConnection();

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
		print_r($keys);
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
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

	public function assignTicket($ticket_id,$user_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "insert into Task (TicketId,UserId) values ($ticket_id,$user_id) on duplicate key
		          update UserId = $user_id";
		          echo $query;
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	public function assignReporterToTicket($ticket_id,$reporter_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "insert into Task (TicketId,ReporterId) values ($ticket_id,$reporter_id) on duplicate key
		          update ReporterId = $reporter_id";
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

	public function comment($comment,$user_id,$ticket_id)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$c_query = "insert into Comment (Comment,UserId,TicketId) values ('$comment',$user_id,$ticket_id)";
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

	public function fetch_comments($user_id,$page)
	{
		$connection = DBConnection::getInstance()->getConnection();
		$query = "select c.Comment,u.Name from Comment c,User u where c.UserId = $user_id and u.Id = $user_id ";
		$query .= " limit $page*10 , ($page+1)*10" ;
		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
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
			$usr_query = "t.UserId = $user_id";
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
		if(isset($filter_array['page']))
		{
			$page = $filter_array['page'] ;
			$lim_q = "limit $page*10 , ($page+1)*10";
		}

		$query = "select * from Ticket t where 1 and $usr_query and $status_query and $r_query 
					and $st_query and $en_query $lim_q" ;

		$result =  mysqli_query($connection, $query);
		return mysqli_fetch_all($result, MYSQLI_ASSOC);

	}

}
?>