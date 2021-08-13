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
							<form class="row" action="" method="post">
								<div class="form-group col-md-6">
									<input type="text" placeholder="Search IMEI" class="form-control margin-bottom required"> </div>
								<div class="form-group col-md-6"> <a href="#" class="btn btn-success btn-md">Search</a> </div>
							</form>
							<table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
									<thead>
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th>IMEI Number</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>Iphone 6</td>
											<td>642144555254</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th>IMEI Number</th>
										</tr>
									</tfoot>
								</table>
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="IMEI-1">Current Grade</label>
								<div class="col-sm-3">
									<select class="form-control" name="current-grade" id="current_grade">
										<option value="">Select Current Grade</option>
										<option>Excellant</option>
										<option>Superb</option>
										<option>Good</option>
										<option>Ok</option>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="IMEI-1">Final Grade</label>
								<div class="col-sm-3">
									<select class="form-control" name="final_grade" id="final_grade">
										<option value="">Select Final Grade</option>
										<option>Praxo</option>
										<option>Zo-Retail</option>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv">
								<label class="col-sm-3 col-form-label" for="brand"> Job Work Required </label>
								<div class="col-sm-3">
									<select id="jobwork_required" name="jobwork_required" class="form-control">
										<option selected value="">Select Option</option>
										<option value="1">Yes (With Component)</option>
										<option value="3">Yes (Without Component)</option>
									</select>
								</div>
							</div>
							<div class="form-group row mdiv JobworkYes PraxoYes">
								<label class="col-sm-3 col-form-label" for="replaced_items"> Required Component </label>
								<div class="col-sm-3">
									<input type="text" id="zupc" class="form-control margin-bottom moreheight" name="zupc_code"> </div>
							</div>
							<div class="form-group row mdiv JobworkYes PraxoYes">
								<label class="col-sm-3 col-form-label" for="replaced_items"> Not Available Component Request </label>
								<div class="col-sm-3">
									<input type="text" id="zupc" class="form-control margin-bottom moreheight" name="zupc_code"> </div>
							</div>
							<div class="form-group row mdiv text-center"> <a href="#" class="btn btn-success btn-md">Submit</a> </div>
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
	$("#items").attr("required", "true");
    $('.JobworkYes').show();
    //$('.JobworkNo').hide();

    $('#jobwork').val('1');
    $('#jobwork_not_required').val('');
    

  }else if(this.value == "2"){
    $('#jobwork_not_required').val('2');
    $('#jobwork').val('');
    $('.JobworkYes').hide();
    //$('.JobworkNo').show();
  }else if(this.value == "3"){
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