<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;	
}
/* UPDATE `contactus` SET `status` = '1' WHERE `contactus`.`status` = 'New';
UPDATE `contactus` SET `status` = '2' WHERE `contactus`.`status` = 'Contacted';
UPDATE `contactus` SET `status` = '3' WHERE `contactus`.`status` = 'Qualified';
UPDATE `contactus` SET `status` = '4' WHERE `contactus`.`status` = 'Proposal Sent';
UPDATE `contactus` SET `status` = '5' WHERE `contactus`.`status` = 'Coverted to Franchise';
UPDATE `contactus` SET `status` = '6' WHERE `contactus`.`status` = 'Not Coverted to Franchise'; */

?>

<div class="content-body">
    <div class="card">		
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

				<div class="row">
				<div class="col-md-12">
				
				
				
<?php if($_SESSION['s_role']=='r_5'){ ?>
				

	<div class="row">
	
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="fa fa-plus text-bold-200  font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-primary white media-body">
                        <h6 style="font-size:13px;"><?php echo $this->lang->line('New') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i> <?php echo $New; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-user font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                        <h6 style="font-size:13px;"><?= $this->lang->line('Contacted') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i><?php echo $Contacted; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="fa fa-check-circle-o font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                        <h6 style="font-size:13px;"><?= $this->lang->line('Qualified') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i
                                    class="ft-plus"></i><?php echo $Qualified; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="fa fa-share-square-o text-bold-200  font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-primary white media-body">
                        <h6 style="font-size:13px;"><?php echo $this->lang->line('Proposal Sent') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i> <?php echo $Proposal; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-basket-loaded font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                        <h6 style="font-size:13px;"><?= $this->lang->line('Franchise') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i><?php echo $Coverted; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="fa fa-exclamation-circle font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                        <h6 style="font-size:12px;"><?= $this->lang->line('Unable to Convert Franchise') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i
                                    class="ft-plus"></i><?php echo $notCoverted; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="fa fa-money text-bold-200  font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                        <h6 style="font-size:13px;"><?php echo $this->lang->line('Total') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i> <?php echo $subtotal; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="icon-grid font-large-1 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                        <h6 style="font-size:13px;"><?= $this->lang->line('Junk') ?></h6>
                        <h6 style="font-size:13px;" class="text-bold-400 mb-0"><i class="ft-plus"></i><?php echo $Junk; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	
							   
			   
			   <form name="filter" id="fromfilter" method="post" action="<?php echo base_url(); ?>leads">
			   		
					<input type="hidden" name="statusF" id="statusF"  value="">
					<div class="row" style="margin-top:30px" >
					<div class="col-md-2">
					
					<select name="status" id="status" class='form-control b_input' > 
						<option value="">Select Status</option>
						 <option value="1" <?php if($search['status']==1){ ?>selected="selected" <?php } ?>>New</option>
						 <option value="2" <?php if($search['status']==2){ ?>selected="selected" <?php } ?>>Contacted</option>
						 <option value="3" <?php if($search['status']==3){ ?>selected="selected" <?php } ?>>Qualified</option>							 							
						 <option value="4" <?php if($search['status']==4){ ?>selected="selected" <?php } ?>>Proposal Sent</option>							
						 <option value="5" <?php if($search['status']==5){ ?>selected="selected" <?php } ?>>Coverted to Franchise</option>							
						 <option value="9" <?php if($search['status']==9){ ?>selected="selected" <?php } ?>>Local Verification</option>							
						 <option value="6" <?php if($search['status']==6){ ?>selected="selected" <?php } ?>>Not Coverted to Franchise</option>
						 <option value="7" <?php if($search['status']==7){ ?>selected="selected" <?php } ?>>Junk</option>
						 <option value="8" <?php if($search['status']==8){ ?>selected="selected" <?php } ?>>Test</option>						 
					</select>
					</div>
					
					
					<div class="col-md-2">
					
					<select name="source" class="form-control b_input" >
					<option value="">Select Source</option>
					<option value="Direct" <?php if($search['source']=="Direct"){ ?>selected="selected" <?php } ?>>Direct</option>
					</select>
					</div>
					
					<div class="col-md-2">
					
					<select name="assign_name" class="form-control b_input" >
					<option value="">Select Assigned To</option>
					 <?php foreach($employees as $key1=>$emp_data){ ?>
					<option value="<?php echo $emp_data->id; ?>" <?php if($search['assign_name']==$emp_data->id){ ?>selected="selected" <?php } ?>><?php echo $emp_data->name; ?></option>
					<?php } ?>	
					</select>
					</div>				
					
					
					<div class="col-lg-1 col-md-2">					
					<input class="btn btn-success" type="submit" name="submit" value="Submit">
					</div>
					
					<div class="col-lg-1 col-md-2" style="margin-right:37px">					
						<a href="<?php base_url(); ?>leads/?export=excel"><input style="background:#293381;color:#fff;" class="btn" type="button" name="export" value="Export Leads"></a>					
					</div>
					
					<div class="col-lg-1 col-md-2">					
						<a href="<?php base_url(); ?>leads/import"><input style="background:#293381;color:#fff;" class="btn" type="button" name="import" value="Import Leads"></a>					
					</div>
					
					</div>				
			   </form>
			   
				
			   
			    <div class="row" style="margin-top:30px" >
                <div class="col-md-12">
				<form name="lead" id="lead" method="post" action="<?php echo base_url(); ?>leads/update">
				<input type="hidden" name="updatelead" id="updatelead" value="update">
				<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $_SESSION['id']; ?>">
               
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" data-sort-name="#" data-sort-order="desc">
					   
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
                            <th>Assign To</th>
                            <th>Status</th>
					    </tr>
					</thead>
					
					<tbody>
					<?php /*echo "<pre>";print_r($leads);*/foreach($leads as $lead_data){ ?>					
					<tr>
                        <td class="th-data" style=" padding-top: -1.75rem;
						padding-right: 1rem;
						padding-bottom: -1.75rem;
						padding-left: 1rem;"><?php echo $lead_data->id; ?></td>
                        <td style="max-width:90px;" class="th-data"><?php echo $lead_data->name; ?></td>                        
                        <td style="max-width:180px;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;" class="th-data"><?php echo $lead_data->email;?></td>
                        <td class="th-data"><?php echo $lead_data->mobileno;?></td>
                        <!--<td><?php echo $lead_data->business_address; ?></td>-->						
                        <!--<td class="th-data" style="text-align:center;"><?php echo ($lead_data->source == 'Agent') ? '<a href="'.base_url().'agency/view/'.$lead_data->agency_id.'" target="_blank" style="color:#000;" title="'.$lead_data->agent_details[0]->name.'">Agent</a>': 'Direct';?></td>-->
						<td style="max-width:90px; padding:10px;">
						<?php 
						if($lead_data->source == 'Agent') { 
							echo '<a href="'.base_url().'agency/view/'.$lead_data->agency_id.'" target="_blank">Agent</a>';
						}else if($lead_data->source == 'facebook' || $lead_data->source == 'Facebook' || $lead_data->source == 'FACEBOOK'){
							echo 'Facebook';
						}else{
							echo 'Direct';
						}
						?>
						</td>
                        <td style="white-space:nowrap;" class="th-data date"><?php $date = explode(" ",$lead_data->date);echo date("d M, Y", strtotime($date[0]))."<br>".$date[1];?></td>
                        <td class="th-data"><?php echo $lead_data->state_name; ?></td>
                        <td class="th-data"><?php echo $lead_data->city; ?></td>
                        <td class="th-data"><?php echo $lead_data->pincode; ?></td>
                        <td class="th-data"><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
						
                        <td class="th-data">						
						<select style="height:32px;min-width:100px; <?php if($lead_data->agency_id != NULL){echo 'display:none;';}?>" name="assign_to[<?php echo $lead_data->id; ?>]" id="assignLead<?php echo $lead_data->id; ?>" class='form-control b_input assignLead' <?php if($lead_data->agency_id != NULL){echo "disabled=''";}?>>
							 <option value="" selected="selected" disabled>Select</option>
							  <?php foreach($employees as $key1=>$emp_data){ ?>
							  <option  <?php if($lead_data->assign_to==$emp_data->id){ ?>selected="selected" <?php } ?> value="<?php echo $lead_data->id; ?>-<?php echo $emp_data->id; ?>"><?php echo $emp_data->name; ?></option>
							 <?php } ?>	
						</select>
						<?php if($lead_data->agency_id != NULL){
							echo '<a href="'.base_url().'agency/view/'.$lead_data->agency_id.'" target="_blank" style="color:#000;" title="'.$lead_data->agent_details[0]->name.'">'.$lead_data->agent_details[0]->name.' ( '.$lead_data->agent_details[0]->referral_code.' )</a>';
						}?>
						</td> 
						
						<td class="th-data">
						<?php 
							switch($lead_data->status){
								case 1: $status_html = "New";break;
								case 2: $status_html = "Contacted";break;
								case 3: $status_html = "Qualified";break;
								case 4: $status_html = "Proposal Sent";break;
								case 9: $status_html = "Local Verification";break;
								case 5: $status_html = "Coverted to Franchise";break;
								case 6: $status_html = "Not Coverted to Franchise";break;
								case 7: $status_html = "Junk";break;
								case 8: $status_html = "Test";break;								
								default : $status_html = "New";break;
							}
							echo $status_html."<br>";?>
							<button style="height:32px;" type="button" class="btn btn-success btn-xs sr" data-toggle="modal"  value="<?php echo $lead_data->id; ?>"><i class="fa fa-eye"></i> View Log</button>
                            					
						</td>
					</tr>						
					<?php } ?>
					</tbody>
                    <tfoot>
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
                            <th>Assign To</th>
                            <th>Status</th>
					    </tr>
					</tfoot>
					
					
                </table>
				</form>
                </div>
				</div>
				
				<?php } else{ ?>
				
				<div class="row" style="margin-top:30px" >
				<form name="lead1" id="lead1" method="post" action="<?php echo base_url(); ?>leads/updatestatus">
				<!--<input type="hidden" name="updatelead" id="updatelead" value="update">-->
				<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $_SESSION['id']; ?>">
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="60%">
					   
					<thead>  
					<!--<tr>	
						<td style="text-align:right"><input type="hidden" name="submit" value="update1"></td>
						<td colspan="10" style="text-align:right"><input class="btn btn-primary" type="submit" name="submitsss" value="update"></td>
						
					</tr>-->
					</thead>
					
					<thead>
						<tr style="text-align:center;">
                        <th style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;">#</th>
                        <th>Name</th>                        
                        <th>Email</th>
                        <th>Mobile</th>
                        <th style="max-width:90px; padding:10px;">Source</th>
                        <th style="max-width: 100px;
    white-space: nowrap;">Date</th>
                        <th>State</th>
                        <th>City</th>
                        <th style=" max-width:90px; padding: 10px;">Pincode</th>
                        <th style="max-width:90px; padding:10px;">Shop Type</th>                        
						<th>Status</th>
					</tr>
					</thead>				
					
					<tbody>
					<?php 
						foreach($leads as $lead_data){
						if($lead_data->assign_to==$_SESSION['id']){
					?>					
					<tr>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;"><?php echo $lead_data->id; ?></td>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;"><?php echo $lead_data->name; ?></td>                        
                        <td style=" max-width: 180px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;padding: 5px;"><?php echo $lead_data->email;?></td>
                        <td style="max-width: 130px;  padding: 10px;"><?php echo $lead_data->mobileno;?></td>
                        <!--<td><?php echo $lead_data->business_address; ?></td>-->						
                        <!--<td style="max-width:90px; padding:10px;"><?php echo ($lead_data->source == 'Agent') ? '<a href="'.base_url().'agency/view/'.$lead_data->agency_id.'" target="_blank">Agent</a>': 'Direct';?></td>-->
                        <td style="max-width:90px; padding:10px;">
						<?php 
						if($lead_data->source == 'Agent') { 
							echo '<a href="'.base_url().'agency/view/'.$lead_data->agency_id.'" target="_blank">Agent</a>';
						}else if($lead_data->source == 'facebook' || $lead_data->source == 'Facebook' || $lead_data->source == 'FACEBOOK'){
							echo 'Facebook';
						}else{
							echo 'Direct';
						}
						?>
						</td>
    
	<td style="max-width: 150px; white-space: nowrap; padding: 10px;"><?php $date = explode(" ",$lead_data->date);echo date("d M, Y", strtotime($date[0]))."<br>".$date[1];?></td>
                       
					   <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;"><?php echo $lead_data->state_name; ?></td>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;"><?php echo $lead_data->city; ?></td>
                        <td  style=" max-width:80px; padding: 15px;"><?php echo $lead_data->pincode; ?></td>
                        <td style="max-width:90px; padding:18px;"><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
						
                        
						
						<td>
							<?php 
							/*switch($lead_data->status){
								case 1: $status_html = "New";break;
								case 2: $status_html = "Contacted";break;
								case 3: $status_html = "Qualified";break;
								case 4: $status_html = "Proposal Sent";break;
								case 5: $status_html = "Coverted to Franchise";break;
								case 6: $status_html = "Not Coverted to Franchise";break;
								case 7: $status_html = "Junk";break;
								default : $status_html = "Test";break;
							}
							echo $status_html;*/?>	
							
							<?php if($lead_data->verification_status==1 && $lead_data->status!=5){  $converted_franchise_disable = '';  }else{  $converted_franchise_disable = 'disabled';  } ?>
							<select class="form-control b_input updateStatus" name="status[<?php echo $lead_data->id; ?>]" id="status" <?php if($lead_data->status==5){ ?>disabled<?php } ?>>							  
								 <option value="<?php echo $lead_data->id; ?>-1" <?php if($lead_data->status==1){ ?>selected="selected" <?php } ?>>New</option>
								 <option value="<?php echo $lead_data->id; ?>-2" <?php if($lead_data->status==2){ ?>selected="selected" <?php } ?>>Contacted</option>
								 <option value="<?php echo $lead_data->id; ?>-3" <?php if($lead_data->status==3){ ?>selected="selected" <?php } ?>>Qualified</option>							 							
								 <option value="<?php echo $lead_data->id; ?>-4" <?php if($lead_data->status==4){ ?>selected="selected" <?php } ?>>Proposal Sent</option>
								 <option value="<?php echo $lead_data->id; ?>-9" <?php if($lead_data->status==9){ ?>selected="selected" <?php } ?>>Local Verification</option>	
								 <option value="<?php echo $lead_data->id; ?>-5" <?php if($lead_data->status==5){ ?>selected="selected" <?php } ?> <?php echo $converted_franchise_disable; ?>>Coverted to Franchise</option>							
								 <option value="<?php echo $lead_data->id; ?>-6" <?php if($lead_data->status==6){ ?>selected="selected" <?php } ?>>Not Coverted to Franchise</option>							
								 <option value="<?php echo $lead_data->id; ?>-7" <?php if($lead_data->status==7){ ?>selected="selected" <?php } ?>>Junk</option>							
								 <option value="<?php echo $lead_data->id; ?>-8" <?php if($lead_data->status==8){ ?>selected="selected" <?php } ?>>Test</option>
							</select>
						</td>
					</tr>					
					<?php } } ?>
					</tbody>
                </table>
				</form>
				</div>				
				<?php } ?>
				
				</div>
				<div>
				
            </div>
        </div>

       <div class="count-value my-1" style="max-width:135px;">				
            <select name="status" id="status" class='form-control b_input' > 
                <option style="max-width:135px;overflow:hidden;" value="">Select Status</option>
                <option style="max-width:135px;overflow:hidden;" value="1" <?php if($search['status']==1){ ?>selected="selected" <?php } ?>>New</option>
                <option style="max-width:135px;overflow:hidden;" value="2" <?php if($search['status']==2){ ?>selected="selected" <?php } ?>>Contacted</option>
                <option style="max-width:135px;overflow:hidden;" value="3" <?php if($search['status']==3){ ?>selected="selected" <?php } ?>>Qualified</option>							 							
                <option style="max-width:135px;overflow:hidden;" value="4" <?php if($search['status']==4){ ?>selected="selected" <?php } ?>>Proposal Sent</option>
				<option style="max-width:135px;overflow:hidden;" value="9" <?php if($search['status']==9){ ?>selected="selected" <?php } ?>>Local Verification</option>
                <option style="max-width:135px;overflow:hidden;" value="5" <?php if($search['status']==5){ ?>selected="selected" <?php } ?>>Coverted to Franchise</option>							
                <option style="max-width:135px;overflow:hidden;" value="6" <?php if($search['status']==6){ ?>selected="selected" <?php } ?>>Not Coverted to Franchise</option>
                <option style="max-width:135px;overflow:hidden;" value="7" <?php if($search['status']==7){ ?>selected="selected" <?php } ?>>Junk</option>
                <option style="max-width:135px;overflow:hidden;" value="8" <?php if($search['status']==8){ ?>selected="selected" <?php } ?>>Test</option>                
            </select>					
       </div>

    </div>
</div>



<!-- Modal -->
 <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel"></h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>





<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Delete Franchise</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                   <input type="hidden" class="form-control"
                           id="object-id" name="deleteid" value="0">
                <input type="hidden" id="action-url" value="leads/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Email Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNowSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
    </div>

    
	<div id="sendSmsS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('SMS Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendsms_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="message" class="form-control" rows="3" cols="60"></textarea></div>
                    </div>


                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendSmsSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#cgrtable').DataTable({
                responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ],
                "order": [[ 0, "desc" ]]
            });

        });
    </script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });



        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('leads/load_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash <?php if ($due) echo ",'due':true" ?> }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': true,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ],
        });


        $(document).on('click', "#delete_selected", function (e) {
            e.preventDefault();
                if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            alert($(this).attr('data-lang'));
            jQuery.ajax({
                url: "<?php echo site_url('leads/delete_i')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&<?=$this->security->get_csrf_token_name()?>=' + crsf_hash + '<?php if ($due) echo "&due=true" ?>',
                  dataType: 'json',
                success: function (data) {
                    $("input[name='cust[]']:checked").closest('tr').remove();
                       $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });


        //uni sender
$('#sendMail').on('click', '#sendNowSelected', function (e) {
       e.preventDefault();
         $("#sendMail").modal('hide');
                 if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('leads/sendSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendmail_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});

$('#sendSmsS').on('click', '#sendSmsSelected', function (e) {
       e.preventDefault();
         $("#sendSmsS").modal('hide');
                     if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('leads/sendSmsSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendsms_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});



    });


</script>



<script>



$(".assignLead").change(function(){		
	var assignto = $(this).val();
	//alert(assignto);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/assignLead')?>",
		data : {assignto : assignto,type : 1},
		cache : false,
		success : function(data)
		{	
			console.log(data);
			swal("Lead Assign to", "Lead Manager", "success");
		}
	});
});


$(".updateStatus").change(function(){		
	var status = $(this).val();
	//alert(status);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/updateStatus')?>",
		data : {status : status},
		cache : false,
		success : function(data)
		{	
			switch(status)
			{
				case "72-2":
					swal("Status updated to", "Contacted", "success");
					break;
				case "72-3":
					swal("Status updated to", "Qualified", "success");
					break;
				case "72-4":
					swal("Status updated to", "Proposal Sent", "success");
					break;
				case "72-5":
					swal("Status updated to", "Coverted to Franchise", "success");
					break;
					
				case "72-6": 
					swal("Status updated to", "Not Coverted to Franchise", "success");
					break;
				default :
					swal("Status updated to", "New", "success");
					break;
			}
			location.reload();
		}
	});
});


$(".view_log").click(function(){		
	var lead_id = $(this).val();
	//alert(lead_id);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/viewLog')?>",
		data : {lead_id : lead_id},
		cache : false,
		success : function(data)
		{	
			 $("#getCodeModal").modal("toggle");
			 $("#getCode").html(data);			
		}
	});
});


$(".statusCounts").change(function(){		
	var emp_id = $(this).val();
	//alert(emp_id);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/statusCounts')?>",
		data : {emp_id : emp_id},
		cache : false,
		success : function(data)
		{	
		    res = data.split("-");				
			 $("#Newcnt").html(res[0]);			
			 $("#Contactedcnt").html(res[1]);			
			 $("#Qualifiedcnt").html(res[2]);			
			 $("#Proposalcnt").html(res[3]);			
			 $("#Covertedcnt").html(res[4]);			
			 $("#notCovertedcnt").html(res[5]);			
		}
	});
});


function statusFiter(str){
	$('#statusF').val(str);		
	$( "#fromfilter" ).submit();
}
</script>