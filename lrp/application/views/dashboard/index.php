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
						<div class="box-header with-border">
							<div class="row">
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-primary bg-darken-2"> <i class="fa fa-bookmark text-bold-200  font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-primary white media-body">
													<h5>Pending Receives</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-plus"></i><?php echo $leads_count['total'];?></h5> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-danger bg-darken-2"> <i class="fa fa-flag font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-danger white media-body">
													<h5>Pending Works</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?php echo $leads_count['from_web'];?></h5> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-warning bg-darken-2"> <i class="fa fa-check font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-warning white media-body">
													<h5>Assign Job Work</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>  <?php echo $leads_count['own'];?> </h5> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-primary bg-darken-2"> <i class="fa fa-briefcase font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-primary white media-body">
													<h5>Open Job Work</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>  <?php echo $leads_count['own'];?> </h5> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-danger bg-darken-2"> <i class="fa fa-exclamation-triangle font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-danger white media-body">
													<h5>Failed QC Work</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>  <?php echo $leads_count['own'];?> </h5> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-2 col-lg-6 col-12">
									<div class="card">
										<div class="card-content">
											<div class="media align-items-stretch">
												<div class="p-2 text-center bg-warning bg-darken-2"> <i class="fa fa-shopping-basket font-large-2 white"></i> </div>
												<div class="p-1 bg-gradient-x-warning white media-body">
													<h5>Manage Job Work</h5>
													<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>  <?php echo $leads_count['own'];?> </h5> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card card-block">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo "Leads"; ?></h3>
							<p>
								<br> </p>
							<table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>PO #</th>
										<th>Item Type</th>
										<th>Total Qty</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>02-08-2021</td>
										<td>524565152552</td>
										<td>Screen</td>
										<td>50</td>
										<td><a href="#" class="btn btn-success btn-sm view-object"><span class="fa fa-eye"></span> View</a></td>
									</tr>
									<tr>
										<td>2</td>
										<td>01-08-2021</td>
										<td>748515255220</td>
										<td>USB</td>
										<td>10</td>
										<td><a href="#" class="btn btn-success btn-sm view-object"><span class="fa fa-eye"></span> View</a></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>PO #</th>
										<th>Item Type</th>
										<th>Total Qty</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(event) {
	var url = baseurl + 'dashboard/leadlist';
	$.ajax({
		type: 'POST',
		url: url,
		cache: false,
		success: function(result) {
			$('#leads tbody').html(result);;
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