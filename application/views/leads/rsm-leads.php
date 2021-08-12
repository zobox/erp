<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4> RSM Leads </h4>
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
                        <th style="width: 97px;">Name</th>
						<th style="width: 136px;">Email</th>
                        <th style="width: 108px;">Mobile</th>
                        <th style="width: 108px;">Source</th>
                        <th style="width: 102px;">State</th>
                        <th style="width: 80px;">City</th>
                        <th style="width: 108px;">Pincode</th>
                        <th style="width: 145px;">Shop Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
					
					<?php
					/* echo "<pre>";
					print_r($leads);
					echo "</pre>";	exit; */
					
					$i=1;
					foreach($leads as $key=>$lead_data){ ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($lead_data->date)); ?></td>
                        <td><?php echo $lead_data->name; ?></td>
                        <td><?php echo $lead_data->email; ?></td>
                        <td><?php echo $lead_data->mobileno; ?></td>
                        <td><?php echo $lead_data->source; ?></td>
                        <td><?php echo $lead_data->state_name; ?></td>
                        <td><?php echo $lead_data->city; ?></td>
                        <td><?php echo $lead_data->pincode; ?></td>
                        <td><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; } ?></td>  
                        
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
								//case 30: $status_html = "Approved"; break;								
								case 30: $status_html = "Approved & Space Finalised"; break;								
								case 31: $status_html = "Not Approved"; break;								
								case 32: $status_html = "Space Re-Allocation"; break;								
								case 33: $status_html = "In Process-Interiors"; break;								
								default : $status_html = "New"; break;
							}
							echo $status_html."<br>";?></td>
							
                            <td><?php if($lead_data->status !=29) { ?><a href="#changestatus<?php echo $lead_data->id; ?>" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-success btn-sm sr">Change Status</a><?php } ?>
							<?php if($lead_data->status ==29) { ?>
							<?php if($lead_data->franchise[0]->module==0){ ?>
							<a href="<?php echo base_url(); ?>leads/add_leads?id=<?php echo $lead_data->id; ?>" class="btn btn-primary btn-sm sr"><span class="fa fa-pencil"></span> Add</a>
							<?php }else{ ?>
							<a href="<?php echo base_url(); ?>leads/edit_leads?id=<?php echo $lead_data->franchise[0]->id; ?>" class="btn btn-warning btn-sm sr"><span class="fa fa-pencil"></span> Edit</a>
							<?php } ?>							
							<?php } ?>
							<a href="#remarks<?php echo $lead_data->id; ?>" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-primary btn-sm sr">View Remarks</a><a href="#reasons" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-warning btn-sm sr">Reasons</a></td>
                    </tr>
					
					
	<div id="changestatus<?php echo $lead_data->id; ?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>

				<div class="modal-body">
					<form class="payment" method="post" action="<?php echo base_url(); ?>leads/rsmleads">
						<?php if($lead_data->status < 19 || $lead_data->status >= 5) { ?>
						<div class="row">
							<div class="col">
								<div class="input-group">
									<select name="status" id="status-1" class="form-control b_input">
										<option value="">--Select--</option>
										<option <?php if($lead_data->status == 16){ ?> selected <?php } ?> value="16">Pending</option>
										<option <?php if($lead_data->status == 17){ ?> selected <?php } ?> value="17">Partially Interested</option>
										<option <?php if($lead_data->status == 18){ ?> selected <?php } ?> value="18">Not Interested</option>
										<option <?php if($lead_data->status == 19){ ?> selected <?php } ?> value="19">Interested</option>
									</select>									   
								</div>
							</div>						   
						</div>
						<br>
						<?php } ?>
						<?php if($lead_data->status ==17) { ?>
						<div class="row">
							<div class="col">
								<div class="input-group">
								<select name="status" id="status-2" class="form-control b_input">
									<option value="">--Select--</option>
									<option <?php if($lead_data->status == 20){ ?> selected <?php } ?> value="20">Will Consider And Contact</option>
									<option <?php if($lead_data->status == 21){ ?> selected <?php } ?> value="21">Allocating Place and Contact Later</option>
									<option <?php if($lead_data->status == 22){ ?> selected <?php } ?> value="22">Others</option>
								</select>									                              
								</div>
							</div>						   
						</div>
						<br>
						<?php } ?>
						<?php if($lead_data->status ==18) { ?>
						<div class="row">
							<div class="col">
								<div class="input-group">
									<select name="status" id="status-3" class="form-control b_input">
											<option value="">--Select--</option>
											<option <?php if($lead_data->status == 23){ ?> selected <?php } ?> value="23">Investment Issue</option>
											<option <?php if($lead_data->status == 24){ ?> selected <?php } ?> value="24">Have Another Options</option>
											<option <?php if($lead_data->status == 25){ ?> selected <?php } ?> value="25">Others</option>
									</select>									                                
								</div>									
							</div>                                              
						</div>
						<br>
						<?php } ?>
						<?php if($lead_data->status ==19 || $lead_data->status == 30 || $lead_data->status >26) { ?>
						<div class="row">
							<div class="col">
								<div class="input-group">
									<select name="status" id="status-4" class="form-control b_input">
										<option value="">--Select--</option>
										<option <?php if($lead_data->status == 26){ ?> selected <?php } ?> value="26">Space Allocation</option>
										<?php if($lead_data->status == 30 || $lead_data->status >26) { ?>
										<option <?php if($lead_data->status == 27){ ?> selected <?php } ?> value="27">Space Finalised</option>
										<option <?php if($lead_data->status == 28){ ?> selected <?php } ?> value="28">Documents Awaited</option>
										<option <?php if($lead_data->status == 29){ ?> selected <?php } ?> value="29">Convert To Franchise</option>
										<?php } ?>
									</select>									                           
								</div>
							</div>
						</div>
						<br>
						<?php } ?>
						<div class="row">
							<div class="col">
								<div class="input-group">
								<textarea name="others" class="form-control" rows="6" cols="60" placeholder="Others"><?php echo $lead_data->remarks; ?></textarea>                           
								</div>
							</div>						   
						</div>
						<br>
					   
						<div class="modal-footer">
							<input type="hidden" class="form-control" name="lead_id" id="lead_id" value="<?php echo $lead_data->id; ?>">
							<button type="button" class="btn btn-default"
									data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>					
							<button type="submit" class="btn btn-primary"
									id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
					
	
	<div id="remarks<?php echo $lead_data->id; ?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title"><?php echo $this->lang->line('Remarks') ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>

				<div class="modal-body">
					<form class="payment" method="post" action="#">
						<div class="row">
						<div class="col">
						<div style="display: flex;">
									<h6>User Name<?php echo $lead_data->id; ?></h6>
									<h6 style="margin-left: 67%;">dd-mm-yy</h6>
						</div>
								<div class="input-group">
								<textarea name="message" class="form-control" rows="6" cols="60" placeholder="Others" disabled></textarea>                           
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
							<!--<button type="submit" class="btn btn-primary"
									id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>-->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

					
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
                        <th>Pincode</th>
                        <th>Shop Type</th>
                        <th>Status</th>
                        <th>Action</th>
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





<div id="reasons" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Reasons</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" method="post" action="#">
                    <div class="row">
                    <div class="col">
                    <div style="display: flex;">
                                <h6>User Name</h6>
                                <h6 style="margin-left: 67%;">dd-mm-yy</h6>
                    </div>
                            <div class="input-group">
                            <textarea name="message" class="form-control" rows="6" cols="60" placeholder="Reasons" disabled></textarea>                           
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
                        <!--<button type="submit" class="btn btn-primary"
                                id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>-->
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