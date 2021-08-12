<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Leads.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<table  class="table table-striped table-bordered zero-configuration" cellspacing="0" width="90%">
	<thead>
	<tr>
		<th>#</th>
		<th>Name</th>                        
		<th>Email</th>
		<th>Mobile</th>
		<th>Source</th>
		<th>Date</th>
		<th>State</th>
		<th>City</th>
		<th>Pincode</th>
		<th>Shop Type</th>		
		<th>Status</th>
		<th>Assign To</th>
		<th>New (Date Time)</th>
		<th>Contacted (Date Time)</th>
		<th>Qualified (Date Time)</th>
		<th>Proposal Sent (Date Time)</th>
		<th>Coverted to Franchise (Date Time)</th>
		<th>Not Coverted to Franchise (Date Time)</th>
		<th>Junk</th>
		<th>Test</th>
	</tr>
	</thead>
	
	<tbody>
	<?php 
	/* echo "<pre>";
	print_r($leads);
	echo "</pre>";  *///exit;
	
	foreach($leads as $lead_data){ 
			switch($lead_data->status){
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
			
			$date = array();
			
			
			if($lead_data->history != false || $lead_data->history !=''){				
				
				foreach($lead_data->history as $history_dt){
					switch($history_dt->status){
						case 1: $date['1'] = $history_dt->date_created; 
						break;
						case 2: $date['2'] = $history_dt->date_created;
						break;
						case 3: $date['3'] = $history_dt->date_created;
						break;
						case 4: $date['4'] = $history_dt->date_created;
						break;
						case 5: $date['5'] = $history_dt->date_created;
						break;
						case 6: $date['6'] = $history_dt->date_created;
						break;
						case 7: $date['7'] = $history_dt->date_created;
						break;
						case 8: $date['8'] = $history_dt->date_created;
						break;
					}	
				}
			}
				
			
	?>					
	<tr>
		<td><?php echo $lead_data->id; ?></td>
		<td><?php echo $lead_data->name; ?></td>                        
		<td><?php echo $lead_data->email;?></td>
		<td><?php echo $lead_data->mobileno;?></td>							
		<td><?php echo $lead_data->source;?></td>
		<td><?php echo $lead_data->date; ?></td>
		<td><?php echo $lead_data->state_name; ?></td>
		<td><?php echo $lead_data->city; ?></td>
		<td><?php echo $lead_data->pincode; ?></td>
		<td><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
		<td><?php echo $status; ?></td>
		<td><?php echo $lead_data->employee->name; ?></td>
		
		<td><?php if($date['1']!=''){ echo $date['1']; }else{ echo $lead_data->date; } ?></td>
		<td><?php echo $date['2']; ?></td>
		<td><?php echo $date['3']; ?></td>
		<td><?php echo $date['4']; ?></td>
		<td><?php echo $date['5']; ?></td>
		<td><?php echo $date['6']; ?></td>			
		<td><?php echo $date['7']; ?></td>			
		<td><?php echo $date['8']; ?></td>			
	</tr>						
	<?php } ?>
	</tbody>
	
	
</table>
				