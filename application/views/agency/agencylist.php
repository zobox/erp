<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;	
}


?>
<div class="content-body">
    <div class="card">
		<div class="card-header pb-0">
            <h5>Manage Agency</h5>
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

				<div class="row">
				<div class="col-md-12 table-responsive">
				
				
				
				
				
				<div class="row">
				
				<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $_SESSION['id']; ?>">
				
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0">
					   
					<?php 
					//print_r($agency_registration); 
					?>
					<thead>
						<tr style="text-align:center;">
                        <th>#</th>
                        <th>Name</th>                        
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Pincode</th> 
						<th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                       
					</tr>
					</thead>				
					
					<tbody>
					<?php 
						$i = 1;
						foreach($agency_registration as $registration_data){
						if($registration_data['status'] != 0){
					?>					
					<tr style="text-align:center;">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $registration_data['name']; ?></td>                        
                        <td><?php echo $registration_data['email'];?></td>
                        <td><?php echo $registration_data['contact_no'];?></td>
                        <td><?php echo $registration_data['state_name']; ?></td>						
                        <td><?php echo $registration_data['city']; ?></td>
                        <td><?php echo $registration_data['pincode']; ?></td>
                        <td><?php $date = explode(" ",$registration_data['date_created']); echo date("d M, Y",strtotime($date[0]))."<br>".$date[1];?></td>
                        <td>
							<?php switch($registration_data['status']){
								case 1:	$status = "NEW";break;
								case 2: $status = "VERIFIED";break;
								case 3: $status = "REJECTED";break;
								case 4: $status = "ACTIVE";break;
								case 5: $status = "DEACTIVE";break;
								default: $status = "";break;
							}
							echo $status;?>
							<?php /*?><select id="status<?php echo $registration_data['id'];?>" name="status<?php echo $registration_data['id'];?>" class="status" disabled="disabled">
								<option value="<?php echo '1'."-".$registration_data['id']; ?>" <?php if($registration_data['status'] == 1){?> selected="selected"<?php }?>>NEW</option>
								<option value="<?php echo '2'."-".$registration_data['id']; ?>" <?php if($registration_data['status'] == 2){?> selected="selected"<?php }?>>VERIFIED</option>
								<option value="<?php echo '3'."-".$registration_data['id']; ?>" <?php if($registration_data['status'] == 3){?> selected="selected"<?php }?>>REJECTED</option>
								<option value="<?php echo '4'."-".$registration_data['id']; ?>" <?php if($registration_data['status'] == 4){?> selected="selected"<?php }?>>ACTIVE</option>
								<option value="<?php echo '5'."-".$registration_data['id']; ?>" <?php if($registration_data['status'] == 5){?> selected="selected"<?php }?>>DEACTIVE</option>
							</select><?php */?>
						</td><!--class="btn btn-success btn-xs sr"><i class="fa fa-eye"></i>-->
                        <td><a href="<?php echo base_url()?>agency/view/<?php echo $registration_data['id']; ?>"class="btn btn-success btn-xs sr" name="agency_view" id="agency_view<?php echo $registration_data['id']; ?>" value="<?php echo $registration_data['id']; ?>" ><i class="fa fa-eye"></i> View</a> <!--<button type="button" class="btn btn-primary btn-sm" id="" name="" value="">EDIT</button>--> <!--<button type="button" class="btn btn-danger btn-sm" id="" name="" value="">DELETE</button>--> <?php if($registration_data['agency_type'] == 1 || $registration_data['agency_type'] == 2){?><button type="button" style="margin-top: 4px;padding: 6px;font-size: 12px;" class="btn btn-warning btn-sm activate" id="activate" name="activate<?php echo $registration_data['id'];?>" value="<?php echo $registration_data['id'];?>"><?php echo ($registration_data['valid'] != 4)? "ACTIVE" : "DE-ACTIVE";?></button><?php } ?></td>
					</tr>					
					<?php $i++;} } ?>
					</tbody>
					<tfoot>
					<tr style="text-align:center;">
                        <th>#</th>
                        <th>Name</th>                        
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Pincode</th> 
						<th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                       
					</tr>
					</tfoot>
                </table>
			
				</div>				
				
				
				</div>
				<div>
				
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

<!-- Modal -->
 









    
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('.activate').click(function(){
			var reg_id = $(this).val();
			var url = baseurl+'agency/activateuser?reg_id='+reg_id;
			var xhttp = new XMLHttpRequest();
  			xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
     				location.reload();
    			}
  			};
  			xhttp.open("GET", url, true);
  			xhttp.send();
		});
		function viewAgecyPartner(e){
			alert(e);
		}
	</script>