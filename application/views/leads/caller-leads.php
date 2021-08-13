<!--1 - New

Tele Caller

2 - Verified
3 - Junk 

4 - Proposal Sent 
5 -	Qualified
6 -	Partially Qualified
7 -	Not Qualified

8 -	No Investment
9 -	Don't like the Concept
10 - Changed Mind
11 - Have more option
12 - Others

13 - Contact Later
14 - Self Contact
15 - Others


RSM
16 - Pending 
17 - Partially Interested
18 - Not Interested
19 - Interested

20 - Will Consider and Contact
21 - Allocating Place and Contact Later
22 - Others

23 - Investment Issue
24 - Have another options
25 - Others   

26 - Space Allocation
27 - Space Finalised
28 - Documents Awaited
29 - Convert to Franchise

Project Manager
30 - Approved
31 - Not Approved
32 - Space Re-Allocation
33 - In Process-Interiors
  

!--> 

<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Tele Caller Leads </h4>
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
						echo "</pre>"; */					
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
								case 30: $status_html = "Approved"; break;								
								case 31: $status_html = "Not Approved"; break;								
								case 32: $status_html = "Space Re-Allocation"; break;								
								case 33: $status_html = "In Process-Interiors"; break;								
								default : $status_html = "New"; break;
							}
							echo $status_html."<br>";?></td>
                        <td>
                            <a href="#status<?php echo $lead_data->id; ?>" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-success btn-xs sr">Change Status</a><a href="#remarks" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-primary btn-xs sr">Add Remarks</a></td>
                    </tr>
					
					
		<div id="status<?php echo $lead_data->id; ?>" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>

					<div class="modal-body">
						<form class="payment" method="post" action="<?php echo base_url(); ?>leads/callerleads">
							
							<?php if($lead_data->status < 2) { ?>
							<div class="row">
								<div class="col">
									<div class="input-group">
										<select name="status" id="status-1" class="form-control b_input">
											<option value="">--Select--</option>
											<option <?php if($lead_data->status == 2){ ?> selected <?php } ?> value="2">Verified</option>
											<option <?php if($lead_data->status == 3){ ?> selected <?php } ?> value="3">Junk</option>
										</select>                                
									</div>
								</div>                       
							</div>
							<br>
							<?php } ?>
							<?php if($lead_data->status > 1 && $lead_data->status<7) { ?>
							<div class="row">
								<div class="col">
									<div class="input-group">
										<select name="status" id="status-2" class="form-control b_input">
											<option value="">--Select--</option>
											<option <?php if($lead_data->status == 4){ ?> selected <?php } ?> value="4">Proposal Sent</option>
											<option <?php if($lead_data->status == 5){ ?> selected <?php } ?> value="5">Qualified</option>
											<option <?php if($lead_data->status == 6){ ?> selected <?php } ?> value="6">Partially Qualified</option>
											<option <?php if($lead_data->status == 7){ ?> selected <?php } ?> value="7">Not Qualified</option>
										</select>								 
									</div>
								</div>                       
							</div>
							<br>
							<?php } ?>
							<?php if($lead_data->status>6 ) { ?>
							<div class="row">
								<div class="col">
									<div class="input-group">
										<select name="status" id="status-3" class="form-control b_input">
											<option value="">--Select--</option>
											<option <?php if($lead_data->status == 8){ ?> selected <?php } ?> value="8">No Investment</option>
											<option <?php if($lead_data->status == 9){ ?> selected <?php } ?> value="9">Didn't Like The Concept</option>
											<option <?php if($lead_data->status == 10){ ?> selected <?php } ?> value="10">Changed Mind</option>
											<option <?php if($lead_data->status == 11){ ?> selected <?php } ?> value="11">Have More Options</option>
											<option <?php if($lead_data->status == 12){ ?> selected <?php } ?> value="12">Others</option>
										</select>
									</div>
								</div>
							</div>
							<br>
							<?php } ?>
							<?php if($lead_data->status>11) { ?>
							<div class="row">
								<div class="col">
									<div class="input-group">
										<select name="status" id="status-4" class="form-control b_input">
											<option value="">--Select--</option>
											<option <?php if($lead_data->status == 13){ ?> selected <?php } ?> value="13">Contact Later</option>
											<option <?php if($lead_data->status == 14){ ?> selected <?php } ?> value="14">Self Contact</option>
											<option <?php if($lead_data->status == 15){ ?> selected <?php } ?> value="15">Others</option>
										</select>								   
									</div>                                
								</div>
							</div>
							<br>
							<?php } ?>
							<div class="row">
								<div class="col">
									<div class="input-group">
									<textarea name="others" id="others" class="form-control" rows="6" cols="60" placeholder="Others"><?php echo $lead_data->remarks; ?></textarea>
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
<div id="remarks" class="modal fade">
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
                            <div class="input-group">
                            <textarea name="message" class="form-control" rows="6" cols="60" placeholder="Others"></textarea> 
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

