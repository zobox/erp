<table  class="table table-striped table-bordered zero-configuration" cellspacing="0" width="90%" border="1">
<thead>
	<tr>
		<th>#</th>
		<th>Date</th>		
		<th>Status</th>
	</tr>
</thead>

<tbody>
<?php $i=1; foreach($lead_log as $key=>$log_data){

	switch($log_data->status){
		case 1: $status = 'New';
		break;
		case 2: $status = 'Contacted';
		break;
		case 3: $status = 'Qualified';
		break;
		case 4: $status = 'Proposal Sent';
		break;
		case 5: $status = 'Coverted to Franchise';
		break;
		case 6: $status = 'Not Coverted to Franchise';
		break;
		case 7: $status = 'Junk';
		break;
		case 8: $status = 'Test';
		break;
	}	

	?>
<tr>
	<th><?php echo $i; ?></th>
	<td><?php echo $log_data->date_created; ?></td>
	<td><?php echo $status; ?></td>       
</tr>
<?php $i++; } ?>
</tbody>
</table>