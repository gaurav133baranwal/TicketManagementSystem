<?php
include(__DIR__."/../controller/TMSController.php");

$cont = new TMSController();
$ticket_id = $_GET['Id'];
$ticket_details = $cont->fetch_ticket_details($ticket_id)[0];

?>

<form id="ticket-update-form" action="/TMS/app/handler.php?controller=TMSController&action=UpdateTicket" method="post">
    
    <ul>
        <li>
           Title: <input type="text" name="title" id="title" value= <?=$ticket_details['Title'] ?> />
        </li>
        <li>
           Description : <input type="text" name="description" id="description" value= <?=$ticket_details['Description'] ?>  />
        </li>
        <li>
           Category: <input type="text" name="category" id="category" value= <?=$ticket_details['Category'] ?>  />
        </li>
        <li>
        	Priority: <select name="priority" id="priority">
			    <option value="low">low</option>
			    <option value="medium">medium</option>
			    <option value="high">high</option>
			 </select>
        </li>
        <li>
        	Status: <select name="status" id="status">
			    <option value="notStarted">notStarted</option>
			    <option value="Inprogress">Inprogress</option>
			    <option value="Finished">Finished</option>
			    <option value="Tested">Tested</option>
			    <option value="Closed">Closed</option>
			 </select>
        </li>
        <li>
            Resolution :<input type="text" name="resolution" id="resolution" value= <?=$ticket_details['Resolution'] ?>  />
        </li>
        <li>
           StartDAte:  <input type="text" name="startDate" id="startDate" value= <?=$ticket_details['startDate'] ?>  />
        </li>
        <li>
           EndDate:  <input type="text" name="endDate" id="endDate" value= <?=$ticket_details['endDate'] ?>  />
        </li>
        
        <li>
            <input type="submit" value="submit" />
            <input type="reset" value="reset" />
        </li>
    </ul>
</form>