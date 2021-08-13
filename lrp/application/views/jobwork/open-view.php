<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row"> </div>
		<div class="content-body">
			<?php if ($this->session->flashdata("messagePr")) { ?>
				<div class="alert alert-info">
					<?php echo $this->session->flashdata("messagePr") ?>
				</div>
				<?php } ?>
					<div class="card card-block">
						<div class="col-md-12">
							<!-- <h3 class="box-title"><?php echo "Open Job Work"; ?></h3> -->
							<div class="row">
								<h4 class="card-title col-md-4"> Job Card		<input type="number" name="quantity" id="qty-3" class="form-control" style="display: inline-block;margin-left: 20px;width: 40%;margin-right: 20px;" value="<?=$request_id?>" readonly="">			</h4>
								<div class="col-md-8">
									<div class="title-action"> <a href="#part_payment" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-large btn-danger" title="Partial Payment"><span class="fa fa-money"></span> <?php echo $this->lang->line('Assign Engineer') ?> </a>
										<div class="btn-group ">
											<button type="button" class="btn btn-success btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>
												<?php echo $this->lang->line('Print Order') ?>
											</button>
											<div class="dropdown-menu"> <a class="dropdown-item" href="<?= base_url('billing/printorder?id=' . $invoice['iid'] . '&token=' . $validtoken); ?>"><?php echo $this->lang->line('Print') ?></a>
												<div class="dropdown-divider"></div> <a class="dropdown-item" href="<?= base_url('billing/printorder?id=' . $invoice['iid'] . '&token=' . $validtoken); ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a> </div>
										</div> <a href="#pop_model" data-toggle="modal" data-remote="false" class="btn btn-large btn-warning" title="Change Status"><span class="fa fa-retweet"></span> <?php echo $this->lang->line('Change Status') ?></a> <a href="#pop_model1" data-toggle="modal" data-remote="false" class="btn btn-large btn-info" <?php if($product_info->assign_engineer!='' && $product_info->change_status<3) echo 'style="display:none;"'; ?>><?php echo $this->lang->line('Final QC Status') ?></a> </div>
								</div>
							</div>
					<div class="div1">
								<div class="form-group row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5"> Job Card No. </div>
										<div class="col-md-7">
											<input type="number" name="quantity" id="qty-3" class="form-control" value="<?php echo $request_id?>" readonly=""> </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5"> Batch No.</div>
										<div class="col-md-7">
											<input type="number" name="quantity" id="qty-3" class="form-control"> </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Product Name</div>
										<div class="col-md-7">
											<input type="text" name="quantity" id="qty-3" class="form-control" value="<?php echo $product_info->product_detail->product_name; ?>" readonly>
											<input type="hidden" id="product_id" value="<?=$product_info->product_detail->product_id?>"> </div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">ZUPC Code</div>
										<div class="col-md-7">
											<input type="text" name="quantity" id="qty-3" class="form-control" value="<?php echo $product_info->product_detail->warehouse_product_code; ?>" readonly> </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5"> Serial No. 1</div>
										<div class="col-md-7">
											<input type="number" name="serial" id="serial" class="form-control" value="<?php echo $product_info->product_detail->serial; ?>" readonly> </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Serial No. 2</div>
										<div class="col-md-7">
											<input type="number" name="quantity" id="qty-3" class="form-control" value="<?php echo $product_info->product_detail->imei2; ?>" readonly> </div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Current Condition</div>
										<div class="col-md-7">
											<select class="form-control" name="previous_condition" id="previous_condition" disabled>
												<option value="" selected="selected">--Select--</option>
												<option value="A" <?php if($product_info->product_condition=='A'){ ?> selected='selected'
													<?php } ?>>Excellent</option>
												<option value="B" <?php if($product_info->product_condition=='B'){ ?> selected='selected'
													<?php } ?>>Superb</option>
												<option value="C" <?php if($product_info->product_condition=='C'){ ?> selected='selected'
													<?php } ?>>Good</option>
												<option value="D" <?php if($product_info->product_condition=='D'){ ?> selected='selected'
													<?php } ?>>Ok</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Convert To</div>
										<div class="col-md-7">
											<select class="form-control" name="previous_condition" id="previous_condition" disabled>
												<option value="" selected="selected">--Select--</option>
												<option value="1" <?php if($product_info->convert_to==1){ ?> selected='selected'
													<?php } ?>>Excellent</option>
												<option value="2" <?php if($product_info->convert_to==2){ ?> selected='selected'
													<?php } ?>>Superb</option>
												<option value="3" <?php if($product_info->convert_to==3){ ?> selected='selected'
													<?php } ?>>Good</option>
												<option value="4" <?php if($product_info->convert_to==4){ ?> selected='selected'
													<?php } ?>>Ok</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Final Condition</div>
										<div class="col-md-7">
											<select class="form-control" name="final_condition" id="final_condition">
												<option value="" selected="selected">--Select--</option>
												<?php foreach($varients as $key2=>$varient){ ?>
													<option value="<?php echo $varient->pid; ?>">
														<?php echo $varient->product_name; ?>
													</option>
													<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Previous Product Category</div>
										<div class="col-md-7">
											<select name="product_cat[]" id="product_cat1" class="form-control" disabled="">
												<?php foreach ($cat as $row) { 
			  echo "<option value='".$row['id']."'";if(end($product_category_array) == $row['id']){echo "selected='selected'";}echo">".$row['title']."</option>";
			  } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Sub Category</div>
										<div class="col-md-7">
											<select id="sub_cat1" name="product_cat[]" class="form-control" disabled>
												<option value="" disabled="disabled"> --- Select ---</option>
												<option value='<?php echo $product_category_array_title[0][' id ']?>' selected="selected">
													<?php echo $product_category_array_title[0]['title']?>
												</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Sub Sub Category</div>
										<div class="col-md-7">
											<select id="sub_sub_cat1" name="product_cat[]" class="form-control select-box" disabled>
												<option value="" disabled="disabled"> --- Select ---</option>
												<option value='<?php echo $product_category_array_title[1][' id ']?>' selected="selected">
													<?php echo $product_category_array_title[1]['title']?>
												</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">New Product Category</div>
										<div class="col-md-7">
											<select name="product_cat[]" id="product_cat1" class="form-control" disabled="">
												<?php foreach ($cat as $row) { 
			  echo "<option value='".$row['id']."'";if(end($product_category_array) == $row['id']){echo "selected='selected'";}echo">".$row['title']."</option>";
			  } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Sub Category</div>
										<div class="col-md-7">
											<select id="sub_cat1" name="product_cat[]" class="form-control">
												<option value="" disabled="disabled"> --- Select ---</option>
												<option value='<?php echo $product_category_array_title[0][' id ']?>' selected="selected">
													<?php echo $product_category_array_title[0]['title']?>
												</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-5">Sub Sub Category</div>
										<div class="col-md-7">
											<select id="sub_sub_cat1" name="product_cat[]" class="form-control select-box">
												<option value="" disabled="disabled"> --- Select ---</option>
												<option value='<?php echo $product_category_array_title[1][' id ']?>' selected="selected">
													<?php echo $product_category_array_title[1]['title']?>
												</option>
											</select>
										</div>
									</div>
								</div>
					</div>
				</div>
						<div class="div2">
								<table class="table table-striped table-bordered zero-configuration mt-3">
								<thead>
									<tr>
										<th>Spare Part Name</th>
										<th style="width: 20%;">Quantity</th>
										<th>Spare Part Serial No.</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Battery Cover-Vivo Y17</td>
										<td>
											<input type="number" name="quantity" id="qty-3" class="form-control" value="1" readonly=""> </td>
										<td>9800000026245</td>
									</tr>
								</tbody>
							</table>
						</div>
							
							<div class="form-group row">
								<div class="col-sm-3">
									<a href="#morecomp" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-large btn-danger">
										<?php echo $this->lang->line('Add More Component') ?>
									</a>
								</div>
								<div class="col-sm-4">
									<a href="#sendused" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-large btn-warning">
										<?php echo $this->lang->line('Send Used Component Warehouse') ?>
									</a>
								</div>
								<div class="col-sm-2">
									<input type="submit" class="btn btn-success sub-btn btn-md ml-auto" value="<?php echo $this->lang->line('Save') ?>" id="submit-data11" data-loading-text="Creating...">
									<input type="hidden" value="workhousejob/save" id="action-url">
									<input type="hidden" value="<?php echo $this->input->get('id'); ?>" id="id" name="id"> </div>
							</div>
						</div>
					</div>
		</div>
		<div class="modal fade" id="add-attibute-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" id="data_form" method="post" action="<?php echo base_url(); ?>jobwork/setComponent">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add attribute</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body row">
							<div class="col-md-2" style=" display: flex; align-items: center;">
								<label for="attribute"> Attribute </label>
							</div>
							<div class="col-md-10">
								<input type="text" name="component_name" id="component_name" class="form-control" placeholder="Enter Attribute Name" />
								<input type="hidden" name="pid" id="pid" value="<?php echo $records->product_id; ?>">
								<input type="hidden" name="id" id="id" value="<?php echo $id= $this->uri->segment(3);  ?>"> </div>
						</div>
						<div class="modal-footer">
							<!--<button type="button" class="btn btn-primary" id="add-new-attribute">Add New Attribute</button>-->
							<input type="submit" class="btn btn-success sub-btn btn-lg ml-auto" value="<?php echo $this->lang->line('Save') ?>" id="submit-data" data-loading-text="Creating...">
							<input type="hidden" value="jobwork/setComponent" id="action-url"> </div>
					</form>
				</div>
			</div>
		</div>
		<div id="morecomp" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Add More Component') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form class="payment" method="post" action="<?php echo base_url()?>workhousejob/addcomponentJobwork">
							<div class="row mb-2" style="display:none;">
								<div class="col">
									<div class="input-group modinput"> </div>
								</div>
							</div>
							<input type="hidden" name="req_jobwork_id" value="<?=$jobwork_id?>">
							<input type="hidden" name="req_product_id" value="<?=$product_info->product_detail->product_id?>">
							<input type="hidden" name="pro_serial" id="serial" class="form-control" value="<?php echo $product_info->product_detail->serial; ?>" readonly>
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<select id="conditionsdp3" name="items[]" class="form-control required 	select-box" required="" multiple="multiple" onfocus="getcomponent();" style="height: 65px !important width: 469.333px !important;"> </select>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control required" name="type" id="type" value="1">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary" id="">
									<?php echo $this->lang->line('Submit') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="sendused" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Send Used Component Warehouse') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form class="payment" method="post" action="<?php echo base_url()?>workhousejob/addComponentMasterJobwork">
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<select id="item_component_id" name="item_component_id" class="form-control" required="">
											<option value="">---Select Sparepart---</option>
											<?php
                               foreach($item_component as $item => $component_list)
                               {
                               ?>
												<option value="<?=$component_list->id?>">
													<?=$component_list->component_name?>
												</option>
												<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<input type="text" class="form-control margin-bottom" id="component_zupc_code" required="required" placeholder="ZUPC Code">
										<input type="hidden" name="component_zupc_code" value="" id="component_zupc_code2">
										<input type="hidden" name="req_jobwork_id_component" value="<?=$jobwork_id?>">
										<input type="hidden" name="req_product_id_component" value="<?=$product_info->product_detail->product_id?>">
										<input type="hidden" name="pro_component_serial" id="serial" class="form-control" value="<?php echo $product_info->product_detail->serial; ?>" readonly> </div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<input type="text" class="form-control margin-bottom" name="component_qty" id="qty" required="required" placeholder="Quantity"> </div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control required" name="type" id="type" value="1">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary" id="assign_engineer_submit">
									<?php echo $this->lang->line('Submit') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="selectproduct" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Select Product Type') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form class="payment" method="post" action="<?php echo base_url()?>workhousejob/assign_engineer">
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<select id="data_type" name="data_type" class="form-control" required="">
											<option value="">---Select Product Type---</option>
											<option value="1">Praxo</option>
											<option value="2">Zobox Retails</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<input type="text" name="imei_qty[]" id="imei_qty<?php echo $row->id; ?>" class="imei_qty form-control" onChange="addmoreiemi(this.value,0);" placeholder="number of item">
										<input type="hidden" name="available_qty" id="available_qty" class="available_qty" value="<?php echo $row->product_qty; ?>"> </div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col">
									<div class="input-group modinput">
										<select id="data_type" name="data_type" class="form-control" required="">
											<option value="">---Select Items---</option>
											<option value="1">Mobile Phone</option>
											<option value="2">Printer</option>
										</select>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control required" name="type" id="type" value="1">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary" id="assign_engineer_submit">
									<?php echo $this->lang->line('Submit') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="part_payment" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Assign Engineer') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form class="payment" method="post" action="<?php echo base_url()?>workhousejob/assign_engineer">
							<div class="row">
								<div class="col">
									<div class="input-group modinput">
										<input type="text" class="form-control" placeholder="Engineer Name" name="engineer_name" id="engineer_name" required value="<?=$product_info->assign_engineer;?>">
										<input type="hidden" name="jobwork_id" value="<?=$jobwork_id?>" id="jobwork_id"> </div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control required" name="type" id="type" value="1">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary" id="assign_engineer_submit">
									<?php echo $this->lang->line('Submit') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="pop_model" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form id="form_model" method="post" action="<?php echo base_url() ?>workhousejob/change_status">
							<div class="row">
								<div class="col">
									<div class="input-group modinput">
										<select name="change_status" class="form-control">
											<option value="1" <?php if($product_info->assign_engineer=='') echo 'selected'; ?> >Pending</option>
											<option value="2" <?php if($product_info->assign_engineer!='' && $product_info->change_status==2) echo 'selected'; ?>>In Progress - TRC</option>
											<option value="3" <?php if($product_info->assign_engineer!='' && $product_info->change_status==3) echo 'selected'; ?>>Proceed For QC</option>
										</select>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control" name="jobwork_id" value="<?php echo $jobwork_id ?>">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary" id="change_status">
									<?php echo $this->lang->line('Change Status') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="pop_model1" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content mdcontent">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo $this->lang->line('Final QC Status') ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form id="form_model" method="post" action="<?php echo base_url()?>workhousejob/final_qc_status">
							<div class="row">
								<div class="col">
									<div class="input-group modinput">
										<select name="final_qc_status" class="form-control">
											<option value="1" <?php if($product_info->final_qc_status==1) echo 'selected'; ?> >PENDING</option>
											<option value="2" <?php if($product_info->final_qc_status==2) echo 'selected'; ?>>QC PASS</option>
											<option value="3" <?php if($product_info->final_qc_status==3) echo 'selected'; ?>>QC FAIL</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="input-group modinput">
										<textarea name="remark" placeholder="Remarks" class="form-control" rows="3" cols="60">
											<?=$product_info->final_qc_remarks?>
										</textarea>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="hidden" class="form-control" name="jobwork_id" id="invoiceid" value="<?php echo $jobwork_id ?>">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo $this->lang->line('Close') ?>
								</button>
								<button type="submit" class="btn btn-primary">
									<?php echo $this->lang->line('Submit') ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(event) {
			/*$('.source').change(function(){
			$.ajax({
				type : 'POST',
				data : {source : $('.source').val()},
				url : baseurl+'lead/changesource',
				cache : false,
				success : function(result){
					window.location.href = result;
				},
				error : function (jqXHR, textStatus, errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
			})
		});*/
		});
		$('.statusChange').change(function(event) {
			var itsid = $(this).attr('id');
			itsid = itsid.split("chnage");
			itsid = itsid[1];
			var selectedValue = $(this).val();
			$.ajax({
				type: 'post',
				url: baseurl + 'lead/changeStatus',
				data: {
					leadid: itsid,
					selectedStatus: selectedValue
				},
				cache: false,
				success: function(result) {
					swal("", result, "success");
					$.ajax({
						type: 'POST',
						url: baseurl + 'lead/getStatusHtml',
						data: {
							id: itsid
						},
						cache: false,
						success: function(data) {
							$('#stauschnage' + itsid).html(data);
							setTimeout(function() {
								location.reload();
							}, 3000);
						},
						error: function(jqXHR, textStatus, errorThrown) {
							if(jqXHR.status == 500) {
								alert('Internal error: ' + jqXHR.responseText);
							} else {
								alert('Unexpected error.' + jqXHR.status);
							}
						}
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(jqXHR.status == 500) {
						alert('Internal error: ' + jqXHR.responseText);
					} else {
						alert('Unexpected error.' + jqXHR.status);
					}
				}
			});
		});
		</script>