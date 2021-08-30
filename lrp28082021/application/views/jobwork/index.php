<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title"><?php echo "Assign Job Work"; ?></h3>
          <hr>
          <div class="row" style="padding: 5px;">
          </div>
		  <form class="row" action="" method="post" style="margin: 5px; padding:5px;">
		  	
			
		  </form>
		  <?php //echo "<pre>";print_r($lead);?>
          <table class="table table-striped table-bordered zero-configuration dataTable dtr-inline">
            <thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Job Work ID</th>
					<th>IMEI</th>
					<th>Product Name</th>
					<th>Component Qty</th>
					<th>Component Name</th>
					<th>Job Work For</th>
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
				?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row->invoicedate; ?></td>
                <td>JOBWORK<?php echo $row->jobcard_id; ?></td>
                <td><?php echo $row->serial; ?></td>
				<td><?php echo $row->product_name; ?></td>
				<td><?php echo  $component_count; ?></td>
				<td><?php echo $row->item_replaced; ?></td>
                <td><?php echo $row->convert_condition_name; ?></td>
                <td><a href="#" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span>  Edit</a> <a href="#" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> Label</a> <a href="#assigntl" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-info btn-sm"><span class="fa fa-plus"></span>  Assign TL</a></td>
              </tr>
				<?php } ?>
            </tbody>
			<tfoot>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Job Work ID</th>
					<th>IMEI</th>
					<th>Product Name</th>
					<th>Component Qty</th>
					<th>Component Name</th>
					<th>Job Work For</th>
					<th>Action</th>
				</tr>
			</tfoot>
            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="assigntl" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content mdcontent">
			<div class="modal-header">
				<h4 class="modal-title">Assign TL</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="payment" method="post" action="<?php echo base_url()?>jobwork/assigntl">
					<div class="row">
						<div class="col">
							<div class="input-group modinput">
								<input type="text" class="form-control" placeholder="Assign TL" name="teamlead" id="teamlead" required value="<?=$product_info->assign_engineer;?>">
								<input type="hidden" name="serial" value="<?php echo $row->serial; ?>" id="serial"> </div>
								<input type="hidden" name="jobwork_id" value="<?php echo $row->jobcard_id; ?>" id="jobwork_id"> </div>
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
