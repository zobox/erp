<?php 
/* echo "<pre>";
print_r($records);
echo "</pre>"; */

switch($records->product_condition){
	case A : $previous_condition = 'Excellent';
	break;
	case B : $previous_condition = 'Superb';
	break;
	case C : $previous_condition = 'Good';
	break;
	case D : $previous_condition = 'OK';
	break;
}

switch($records->convert_to){
	case 1 : $current_condition = 'Excellent';
	break;
	case 2 : $current_condition = 'Superb';
	break;
	case 3 : $current_condition = 'Good';
	break;
	case 4 : $current_condition = 'Ok';
	break;
}
?>

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
						<div class="col-md-12 px-0">
							<h3 class="box-title"><?php echo "Manage Job Work"; ?></h3>
							<div class="row">
								<div class="col-md-4">
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>Request ID:</strong></p>
										</div>
										<div class="col-md-7">
											<p>REQ_<?php echo $records->request_id; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>Issue ID:</strong></p>
										</div>
										<div class="col-md-7">
											<p>ISU_<?php echo $records->issue_id; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>Product Name:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->product_detail->product_name; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>ZUPC Code:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->product_detail->warehouse_product_code; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>Serial No:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->serial; ?></p>
										</div>
									</div>
									
								</div>
								<div class="col-md-4">
									<div class="row mt-2">
										<div class="col-md-6">
											<p><strong>Previous Condition:</strong></p>
										</div>
										<div class="col-md-6">
											<p><?php echo $records->product_condition; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-6">
											<p><strong>Current Condition:</strong></p>
										</div>
										<div class="col-md-6">
											<p><?php echo $current_condition; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-6">
											<p><strong>Previous Category:</strong></p>
										</div>
										<div class="col-md-6">
											<p><?php echo $records->product_detail->category_name; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-6">
											<p><strong>Current Category:</strong></p>
										</div>
										<div class="col-md-6">
											<p><?php echo $records->category_name; ?></p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>Batch No:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php if($records->batch_number!='') echo 'Batch_'.date('y-m-d',strtotime($records->batch_number)); ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>QC Engineer:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->assign_engineer; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>QC Team Leader:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->teamlead; ?></p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-5">
											<p><strong>TRC Manager:</strong></p>
										</div>
										<div class="col-md-7">
											<p><?php echo $records->trc_manager; ?></p>
										</div>
									</div>
									
								</div>
							</div>
							<div class="row">
								<div class="table-responsive">
									<table class="table table-striped table-bordered zero-configuration mt-3">
										<thead>
											<tr>
												<th>Spare Part Name</th>
												<th style="width: 20%;">Quantity</th>					
												<th>Spare Part Serial No.</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($records->components as $key=>$row){ ?>
												<tr>
													<td><?php echo $row->component_name; ?></td>					
													<td>1</td>
													<td><?php echo $row->serial; ?></td>
												</tr>
											<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<th>Spare Part Name</th>
												<th>Quantity</th>					
												<th>Spare Part Serial No.</th>
											</tr>
										</tfoot>
									</table>
								</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center mt-2">
								<input type="submit" class="btn btn-success sub-btn" value="Save " id="submit-data" data-loading-text="Creating...">
							</div>
						</div>
					</div>
		</div>
	</div>
</div>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	