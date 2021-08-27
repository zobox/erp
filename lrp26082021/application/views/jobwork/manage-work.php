<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title"><?php echo "Manage Job Work"; ?></h3>
          <div class="row" style="padding: 5px;">
		 
            
			
		  </form>
		  <?php //echo "<pre>";print_r($list);?>
		  <div class="table-responsive">
          <table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
            <thead>
								<tr>
									<th>#</th>
									<th>Work ID</th>
									<th>Product Details</th>
									<th>Serial No</th>
									<th>Components Qty</th>
									<th>Components Detail</th>
									<th>Current Condition</th>
									<th> Action</th>
								</tr>
            </thead>
            <tbody>
			  <?php foreach($list as $key=>$row){  $i=1; 
						switch($row->product_condition){
							case 'A' : $previous_condition = 'Excellent';
							break;
							case 'B' : $previous_condition = 'Superb';
							break;
							case 'C' : $previous_condition = 'Good';
							break;
							case 'D' : $previous_condition = 'OK';
							break;
						}
						
						switch($row->convert_to){
							case 1 : $current_condition = 'Excellent';
							break;
							case 2 : $current_condition = 'Superb';
							break;
							case 3 : $current_condition = 'Good';
							break;
							case 4 : $current_condition = 'Ok';
							break;
						}
						
						if($row->type==0){
							$prefix = 'JOBWORK';
						}else if($row->type==1){
							$prefix = 'SR-JOBWORK';
						}
			  
			  ?>
              <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $prefix.$row->jobcard_id; ?></td>
                  <td><?php echo $row->product_detail->product_name; ?></td>
                  <td><?php echo $row->serial; ?></td>
                  <td><?php echo $row->component_qty; ?></td>
				  <td>
				  <?php foreach($row->components as $components=>$component_detail)
					{
					echo $component_detail->component_name.' => '.$component_detail->serial.'<br>';    
					} ?> 
				  </td>
                  <td><?php echo $current_condition; ?></td>
                  <td>
					<a href="manage_view?id=<?php echo $row->jobcard_id; ?>" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> View</a>
                  	<!--<a href="<?php echo base_url('jobwork/managejobview') ?>" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> View</a>-->
                  </td>
              </tr>
			  <?php $i++; } ?>
              
            </tbody>
			<tfoot>
				<tr>
					<th>#</th>
					<th>Work ID</th>
					<th>Product Details</th>
					<th>Serial No</th>
					<th>Components Qty</th>
					<th>Components Detail</th>
					<th>Current Condition</th>
					<th> Action</th>
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
