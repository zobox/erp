<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title"><?php echo "Open Job Work"; ?></h3>
          <div class="row" style="padding: 5px;">

          </div>
		  <form class="row" action="" method="post" style="margin: 5px; padding:5px;">

			
		  </form>
		  <div class="table-responsive">
          <table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
            <thead>
				<tr>
					<th>#</th>
					<th>Job Work ID</th>
					<th>Product Detail</th>
					<th>Product Serial No.</th>
					<th>Component Detail</th>
					<th>Assign TL</th>
					<th>Assign Engineer</th>
					<th>Job Card Status</th>
					<th>Final QC Status</th>
					<th>Action</th>
				</tr>
            </thead>
            <tbody>
				<?php 
				/* echo "<pre>";
				print_r($list);
				echo "</pre>"; */
				
				foreach($list as $key=>$row){ 
				$component_array = explode(',',$row->item_replaced);
				$component_count = count($component_array);
				$i=1;	
				
				switch($row->jobwork_change_status){
					case 1: $jobwork_change_status_name = 'Pending'; $style='style="background-color:blue;"';
					break;
					case 2: $jobwork_change_status_name = 'In Progress - TRC'; $style='style="background-color:yellow;color:#000;"';
					break;
					case 3: $jobwork_change_status_name = 'Proceed For QC'; $style='style="background-color:#5ed45e;"';
					break;
				}
				
				switch($row->jobwork_final_qc_status){
					case 1: $jobwork_final_qc_status_name = 'Pending'; $style1='style="background-color:blue;"';
					break;
					case 2: $jobwork_final_qc_status_name = 'QC PASS'; $style1='style="background-color:#5ed45e;"';
					break;
					case 3: $jobwork_final_qc_status_name = 'QC FAIL'; $style1='style="background-color:yellow;color:#000;"';
					break;
				}
				
				
				
				?>			
              <tr>
              	<td><?php echo $i; ?></td>
              	<td>JOBWORK<?php echo $row->jobcard_id; ?></td>
              	<td><?php echo $row->product_name; ?></td>
              	<td><?php echo $row->serial; ?></td>
              	<td>Battery Cover-Vivo Y17 ⇒ 9800000026245</td>
              	<td><?php echo $row->teamlead; ?></td>
              	<td><?php echo $row->jobwork_assign_engineer; ?></td>
              	<td><span class="badge  st-paid app" <?php echo $style; ?>><?php echo $jobwork_change_status_name; ?></span></td>
              	<td><span class="badge  st-paid app" <?php echo $style1; ?>><?php echo $jobwork_final_qc_status_name; ?></span></td>
              	<td><a href="<?php echo  base_url(); ?>jobwork/open_view?id=<?php echo $row->jobcard_id; ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>  View</a></td>
              </tr>
			  <?php } ?>
              
            </tbody>
			<tfoot>
				<tr>
					<th>#</th>
					<th>Job Work ID</th>
					<th>Product Detail</th>
					<th>Product Serial No.</th>
					<th>Component Detail</th>
					<th>Assign TL</th>
					<th>Assign Engineer</th>
					<th>Job Card Status</th>
					<th>Final QC Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
            
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(event){
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
	$('.statusChange').change(function(event){
		var itsid = $(this).attr('id');
		itsid = itsid.split("chnage");
		itsid = itsid[1];
		var selectedValue = $(this).val();
		$.ajax({
			type : 'post',
			url : baseurl+'lead/changeStatus',
			data : {leadid : itsid, selectedStatus : selectedValue},
			cache : false,
			success : function(result){
				swal("",result,"success");
				$.ajax({
					type : 'POST',
					url : baseurl+'lead/getStatusHtml',
					data : {id : itsid},
					cache : false,
					success : function(data){
						$('#stauschnage'+itsid).html(data);
						setTimeout(function(){ location.reload(); }, 3000);
					},
					error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
				});
			},
			error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
		});
		});
</script>
