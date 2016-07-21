<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="dashboard.css"/>
	<script src="/js/dashboard.js"></script>
</head>
<body>
	<table>
	<thead>
	<tr>
	<th>Title</th>
	<th>Description</th>
	<th>Category</th>
	<th>Priority</th>
	<th>Status</th>
	<th>Resolution</th>
	<th>StartDate</th>
	<th>EndDate</th>
	</tr>
	</thead>
	<tbody>
	
	<?php 
	include(__DIR__."/../controller/TMSController.php");
	$cont = new TMSController();
	$tickets = $cont->filter_tickets(); $value = $tickets[0];
	//foreach ($tickets  as $value) { ?>

	<tr>
		<td> <?= $value['Title'] ; ?> </td>
		<td> <?= $value['Description'] ; ?> </td>
	 	<td> <?= $value['Category'] ; ?></td>
	 	<td> <?= $value['Priority'] ;?></td>
	 	<td> <?= $value['Status'] ; ?></td>
	 	<td> <?= $value['Resolution']; ?></td>
	 	<td> <?= $value['StartDate']; ?></td>
	 	<td> <?= $value['EndDate'] ; ?></td>
	</tr> 

	</tbody>
	</table>
	
</body>
</html>