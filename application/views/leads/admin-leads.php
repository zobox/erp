<?php
$due = false;
if($this->input->get('due')){
    $due = true;
} ?>

<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Tele Caller Admin Leads </h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                          

                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
                      
            </div>
						<hr>
            <div class="card-body">
            
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration table-responsive" cellspacing="0" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th style="width: 100px;">Date</th>
                        <th style="width: 120px;">Name</th>
						<th style="width: 125px;">Email</th>
                        <th style="width: 108px;">Mobile</th>
                        <th>Source</th>
                        <th style="width: 102px;">State</th>
                        <th>City</th>
                        <th style="width: 135px;">Shop Type</th>
                        <th>Assign Callers</th>
                        <th>Status</th>
                    </tr>
                    </thead>
					
                    <tbody>
					<?php 
					/* echo "<pre>";
					print_r($leads);
					echo "</pre>"; */
					$i=1; 
					foreach($leads as $key=>$lead_data){
					?>
					
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($lead_data->date)); ?></td>
                        <td><?php echo $lead_data->name; ?></td>
                        <td><?php echo $lead_data->email; ?></td>
                        <td><?php echo $lead_data->mobileno; ?></td>
                        <td><?php echo $lead_data->source; ?></td>
                        <td><?php echo $lead_data->state_name; ?></td>
                        <td><?php echo $lead_data->city; ?></td>
                        <td><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; } ?></td>
                        <td>
						
						<select style="height:32px;min-width:100px; <?php if($lead_data->agency_id != NULL){echo 'display:none;';}?>" name="assign_to[<?php echo $lead_data->id; ?>]" id="assignLead<?php echo $lead_data->id; ?>" class='form-control b_input assignLead' <?php if($lead_data->agency_id != NULL){echo "disabled=''";}?>>
							 <option value="" selected="selected" disabled>Select</option>
							  <?php foreach($telecallers as $key1=>$emp_data){ ?>
							  <option  <?php if($lead_data->assign_to==$emp_data->id){ ?>selected="selected" <?php } ?> value="<?php echo $lead_data->id; ?>-<?php echo $emp_data->id; ?>"><?php echo $emp_data->name; ?></option>
							 <?php } ?>	
						</select>
						
						
						
							<!--<select name="assign_name" id="assign_name-0" class="form-control b_input assignLead">
								<option value="">Select</option>
								<?php foreach($telecallers as $key=>$row){ ?>
								<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
								<?php } ?>
							</select>-->
						</td>
                        <!--<td><a href="#" class="btn btn-success btn-xs sr">View Logs</a></td>-->
                        <td><?php 
							switch($lead_data->status){
								case 1: $status_html = "New"; break;
								case 2: $status_html = "Verified"; break;
								case 3: $status_html = "Junk"; break;
								case 4: $status_html = "Proposal Sent"; break;
								case 5: $status_html = "Qualified"; break;
								case 6: $status_html = "Partially Qualified"; break;
								case 7: $status_html = "Not Qualified"; break;
								case 8: $status_html = "No Investment"; break;
								case 9: $status_html = "Don't like the Concept"; break;								
								case 10: $status_html = "Changed Mind"; break;								
								case 11: $status_html = "Have more option"; break;								
								case 12: $status_html = "Others";  break;								
								case 13: $status_html = "Contact Later"; break;								
								case 14: $status_html = "Self Contact"; break;								
								case 15: $status_html = "Others"; break;								
								case 16: $status_html = "Pending"; break;								
								case 17: $status_html = "Partially Interested"; break;								
								case 18: $status_html = "Not Interested"; break;								
								case 19: $status_html = "Interested"; break;								
								case 20: $status_html = "Will Consider and Contact"; break;								
								case 21: $status_html = "Allocating Place and Contact Later"; break;								
								case 22: $status_html = "Others"; break;								
								case 23: $status_html = "Investment Issue"; break;								
								case 24: $status_html = "Have another options"; break;								
								case 25: $status_html = "Others"; break;								
								case 26: $status_html = "Space Allocation"; break;								
								case 27: $status_html = "Space Finalised"; break;								
								case 28: $status_html = "Documents Awaited"; break;								
								case 29: $status_html = "Convert to Franchise"; break;								
								case 30: $status_html = "Approved"; break;								
								case 31: $status_html = "Not Approved"; break;								
								case 32: $status_html = "Space Re-Allocation"; break;								
								case 33: $status_html = "In Process-Interiors"; break;								
								default : $status_html = "New"; break;
							}
							echo $status_html."<br>";?></td>
                    </tr>
                    <?php $i++; } ?>
					
                    </tbody>
					
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
						<th>Email</th>
                        <th>Mobile</th>
                        <th>Source</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Shop Type</th>
                        <th>Assign Callers</th>
                        <th>Status</th>
                    </tr>
                    </tfoot>
                    
                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		//datatables
		$('#cgrtable').DataTable({responsive: true});
	});
</script>


<script>
$(".assignLead").change(function(){		
	var assignto = $(this).val();
	//alert(assignto);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/assignLead')?>",
		data : {assignto : assignto,type : 2},
		cache : false,
		success : function(data)
		{	
			console.log(data);
			swal("Lead Assigned to", "Tele Caller", "success");		
		}
	});
});
</script>