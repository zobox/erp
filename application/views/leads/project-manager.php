<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4> Project Manager </h4>
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
					<?php $i=1;
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
                            <td><a href="#changestatus<?php echo $lead_data->id; ?>" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-success btn-xs sr">Change Status</a></td>
                    </tr>
					
<div id="changestatus<?php echo $lead_data->id; ?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" method="post" action="<?php echo base_url(); ?>leads/projectmanager">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <select name="status" id="status-1" class="form-control b_input">
									<option value="">--Select--</option>
									<option <?php if($lead_data->status == 30){ ?> selected <?php } ?> value="30">Approved</option>
									<option <?php if($lead_data->status == 31){ ?> selected <?php } ?> value="31">Not Approved</option>
									<option <?php if($lead_data->status == 32){ ?> selected <?php } ?> value="32">Space Re-Allocation</option>
									<option <?php if($lead_data->status == 33){ ?> selected <?php } ?> value="33">In Process - Interiors</option>
							</select>                                                                      
                            </div>
                        </div>                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <textarea name="others" class="form-control" rows="6" cols="60" placeholder="Reason"></textarea>  
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
					
					
                    <?php } ?>
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
                   <!-- <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Bank">Bank</option>
                            </select><label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Payment for purchase #<?php echo $invoice['tid'] ?>"></div>
                    </div> -->
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