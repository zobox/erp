<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title bhead"><?php echo "Pending Receives View"; ?></h3>
          
			<form class="row" name="searchfrm" id="searchfrm" action="<?php echo base_url(); ?>pending/receive_view?id=<?php echo $this->input->get('id'); ?>" method="post">
			<div class="form-group col-md-6">
				<input name="serial" id="serial" type="text" placeholder="Search IMEI" class="form-control margin-bottom" required>
				<?php foreach($list as $key1=>$row1){  ?>
					<input type="hidden" name="serial_list[]" id="serial_list" value="<?php echo $row1->serial; ?>">				
				<?php } ?>
			</div>
			<div class="form-group col-md-6">
				<input type="submit" class="btn btn-success btn-md" name="search" id="search" value="Search">
	  		</div>
			</form>
			
			<form method="post" enctype="multipart/form-data" id="data_form" action="<?=base_url()?>pending/save_receive_view">
			<table class="table table-striped table-bordered zero-configuration dataTable dtr-inline text-center">
            <thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Mobile Name</th>
					<th class="text-center">IMEI</th>
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
					<input type="hidden" name="serial_list[]" id="serial_list" value="<?php echo $row->serial; ?>">
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Mobile Name</th>
					<th class="text-center">IMEI</th>
				</tr>
			</tfoot>
            
          </table>
		  <div class="form-group row mt-2">
				<?php if($list[0]->pid){ ?>
				<div class="col-sm-12 text-center">
					<input class="btn btn-success btn-md" type="submit" name="submit" id="submit" value="Submit">
				</div>
				<?php } ?>
				<!--<input type="hidden" name="serial" id="serial" value="<?php echo $list[0]->serial; ?>">-->
		  </div>
		  </form>
          
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
