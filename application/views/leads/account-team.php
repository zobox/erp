<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Account Team Leads </h4>
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

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration table-responsive" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th style="width: 97px;">Name</th>
						<th style="width: 136px;">Email</th>
                        <th style="width: 108px;">Phone No</th>
                        <th style="width: 108px;">State</th>
                        <th style="width: 100px;">City</th>
                        <th style="width: 102px;">Agent Name</th>
                        <th style="width: 80px;">RSM Details</th>
                        <th style="width: 108px;">Project Manager</th>
                        <th style="width: 145px;">Franchise Type</th>
                        <th>Action</th>
                        <th>Partial Active</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
						/* echo "<pre>";
						print_r($leads);
						echo "</pre>"; */
					$i=1;
					foreach($leads as $key=>$lead_data){ 
					
					switch($lead_data->franchise[0]->module){
						case 1 : $franchise_type = 'Enterprise'; break; 
						case 2 : $franchise_type = 'Professional'; break; 
						case 3 : $franchise_type = 'Standard'; break; 
					}
					
					if($lead_data->franchise[0]->personal_company==1){
						$name = $lead_data->franchise[0]->franchise_name; 
						$email = $lead_data->franchise[0]->franchise_email; 
						$phone = $lead_data->franchise[0]->company_phone; 
					}else{
						$name = $lead_data->franchise[0]->company_name;  
						$email = $lead_data->franchise[0]->company_email;  
						$phone = $lead_data->franchise[0]->franchise_phone;  
					}
					
					?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $lead_data->franchise[0]->state_s; ?></td>
                        <td><?php echo $lead_data->franchise[0]->city_s; ?></td>
                        <td><?php echo $lead_data->agent_details[0]->name; ?></td>
                        <td><?php echo $lead_data->rsm[0]->name; ?></td>
                        <td><?php echo $lead_data->project_manager[0]->name; ?></td>
                        <td><?php echo $franchise_type; ?></td>
                        <td><a href="#" class="btn btn-success btn-sm sr">View And Edit</a></td>
                        
                        <td>
						<?php if($lead_data->franchise[0]->partial_active==0){ ?>
						<a class="btn btn-success btn-sm sr" onclick="activate(<?php echo $lead_data->franchise[0]->id; ?>);">Activate</a>
						<?php }elseif($lead_data->franchise[0]->partial_active==1){ ?>
						<a class="btn btn-warning btn-sm sr ml-1" onclick="deactivate(<?php echo $lead_data->franchise[0]->id; ?>);">Deactivate</a>
						<?php } ?>
						</td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
						<th>Email</th>
                        <th>Phone No</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Agent Name</th>
                        <th>RSM Details</th>
                        <th>Project Manager</th>
                        <th>Franchise Type</th>
                        <th>Action</th>
                        <th>Partial Active</th>
                    </tr>
                    </tfoot>
                    
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div id="status1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Status 1') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" method="post" action="#">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <select name="assign_name" id="assign_name-0" class="form-control b_input">
								<option value="">Verified</option>
								<option>Junk</option>
							</select>
                              <input type="hidden" name="jobwork_id" value="<?=$jobwork_id?>" id="jobwork_id">                                   
                            </div>

                        </div>
                       
                    </div>
                    <br>
                   
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="submit" class="btn btn-primary"
                                id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="changestatus" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" method="post" action="#">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <select name="assign_name" id="assign_name-0" class="form-control b_input">
									<option value="">Approved</option>
																			<option>Not Approved</option>
                                                                            <option value="">Space Re-Allocation</option>
																			<option>In Process - Interiors</option>
																	</select>
                                   <input type="hidden" name="jobwork_id" value="<?=$jobwork_id?>" id="jobwork_id">                                   
                            </div>

                        </div>
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <textarea name="message" class="form-control" rows="6" cols="60" placeholder="Reason"></textarea>                           
                            </div>
                        </div>
                       
                    </div>
                    <br>
                   
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="submit" class="btn btn-primary"
                                id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>
                    </div>
                </form>
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
	function activate(id){
		$.ajax({
			type : "POST",		
			url: "<?php echo site_url('leads/partial_activate')?>",
			data : {id : id},
			cache : false,
			success : function(data)
			{	
				console.log(data);
				location.reload();			
			}
		});
	}
	
	function deactivate(id){
		$.ajax({
			type : "POST",		
			url: "<?php echo site_url('leads/partial_deactivate')?>",
			data : {id : id},
			cache : false,
			success : function(data)
			{	
				console.log(data);
				location.reload();			
			}
		});
	}
	
</script>