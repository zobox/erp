<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

 
 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>     

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
							<h3 class="box-title"><?php echo "IQC Work"; ?></h3>
							<hr>
							<div class="row" style="padding: 5px;"> </div>
							<form class="row" name="searchfrm" id="searchfrm" action="<?php echo base_url(); ?>pending/iqc_work" method="post">
								<div class="form-group col-md-6">
									<input type="text" name="serial" id="serial" placeholder="Search IMEI" class="form-control margin-bottom required" required> </div>
								<div class="form-group col-md-6"> 									
									<input type="submit" class="btn btn-success btn-md" name="search" id="search" value="Search">
								</div>
							</form>
							
							<form method="post" enctype="multipart/form-data" id="data_form" action="<?=base_url()?>pending/save_iqc_work">
								<table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
									<thead>
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th>IMEI Number</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($list as $key=>$row){ 
											$i=1;	
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row->product_name; ?></td>
											<td><?php echo $row->serial; ?></td>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th>IMEI Number</th>
										</tr>
									</tfoot>
								</table>
								
								<?php
								/* echo "<pre>";
								print_r($list);
								echo "</pre>"; */
								?>
								
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="IMEI-1">Current Grade</label>
								<div class="col-sm-3">
									<select class="form-control required" name="current_grade" id="current_grade" required>
										<option value="">Select Current Grade</option>
										<!--<option>Excellant</option>
										<option>Superb</option>
										<option>Good</option>
										<option>Ok</option>-->
										<?php foreach($conditions as $key=>$condition_data){ ?>
											<option <?php if($condition_data->id==$list[0]->current_condition){ ?> selected <?php } ?>value="<?php echo $condition_data->id; ?>"><?php echo $condition_data->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="IMEI-1">Final Grade</label>
								<div class="col-sm-3">
									<select class="form-control required" name="final_grade" id="final_grade" required>
										<option value="">Select Final Grade</option>
										<?php foreach($conditions as $key=>$condition_data){ ?>
											<option <?php if($condition_data->id==$list[0]->convert_to){ ?> selected <?php } ?>value="<?php echo $condition_data->id; ?>"><?php echo $condition_data->new_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="brand"> Job Work Required </label>
								<div class="col-sm-3">
									<select id="jobwork_required" name="jobwork_required" class="form-control required" required>
										<option selected value="">Select Option</option>
										<option value="1">Yes (With Component)</option>
										<option value="3">Yes (Without Component)</option>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv JobworkYes PraxoYes">
								<label class="col-sm-3 col-form-label" for="replaced_items"> Required Component </label>
								<div class="col-sm-3">
									<!--<input type="text" id="zupc" class="form-control margin-bottom moreheight" name="zupc_code"> -->
									<select id="conditionsdp1" name="items[]" class="form-control select-box"
									multiple="multiple" onfocus="getconditions();">
									</select>
								</div>
							</div>
							<div class="form-group row mdiv JobworkYes PraxoYes">
								<label class="col-sm-3 col-form-label" for="replaced_items"> Not Available Component Request </label>
								<div class="col-sm-3">
									<input type="text" id="component_request" name="component_request" class="form-control margin-bottom moreheight"> </div>
							</div>
							<?php if($list[0]->pid){ ?>
							<div class="form-group row mdiv text-center"> 							
							<input class="btn btn-success btn-md" type="submit" name="submit" id="submit" value="Submit">
							</div>
							<?php } ?>
							<input type="hidden" name="serial" id="serial" value="<?php echo $list[0]->serial; ?>">
							<input type="hidden" name="pid" id="pid" value="<?php echo $list[0]->pid; ?>">
						</form>							
							
						</div>
					</div>
		</div>
	</div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$('#jobwork_required').on('change', function() {
  //  alert( this.value ); // or $(this).val()
  if(this.value == "1") {
	$("#final_grade").attr("required", "true");
	$("#conditionsdp1").prop('required',true);
	$("#items").attr("required", "true");
    $('.JobworkYes').show();
    //$('.JobworkNo').hide();

    $('#jobwork').val('1');
    $('#jobwork_not_required').val('');
    

  }else if(this.value == "2"){
   // $('#jobwork_not_required').val('2');
    $('#jobwork').val('');
    $('.JobworkYes').hide();
    //$('.JobworkNo').show();
  }else if(this.value == "3"){
	$("#conditionsdp1").prop('required',false);
	$('#jobwork_not_required').val('3');
	$('#jobwork').val('3');
	$('.PraxoYes').hide();
  }
});
</script>

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


<script type="text/javascript">
	function getconditions(){

		$('#conditionsdp1').select2({
			tags: [''], 
			ajax: {
				url: baseurl + 'pending/getcomponents?pid='+<?php echo $list[0]->pid; ?>,
				dataType: 'json',
				type: 'POST',
				quietMillis: 50,
				data: function (product) {            
				console.log(product);
					return {
						product: product
					};
				},
				processResults: function (data) {
					console.log(data);
					return {
						results: $.map(data, function (item) {                
							return {								
								text: item.component_name,
								id: item.component_name
							}
						})
					};
				},
			}
		});
	}
</script>