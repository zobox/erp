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
		 
            <!-- <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $new;?></h4></span></div>
			<div align="center" class="text-secondary">New</div>
			</div>
            <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $contacted;?></h4></span></div>
			<div align="center" class="text-secondary">Contacted</div>
			</div>
            <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $qualified;?></h4></span></div>
			<div align="center" class="text-secondary">Qualified</div>
			</div>
            <div class="col-md-2">
			<div align="center"><h4><span id="Newcnt"><?php echo $proposal_sent;?></h4></span></div>
			<div align="center" class="text-secondary">Proposal Sent</div>
			</div>
            <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $converted_to_franchhise;?></h4></span></div>
			<div align="center" class="text-secondary">Franchise</div>
			</div>
            <div class="col-md-3">
			<div align="center"><h4><span id="Newcnt"><?php echo $not_converted_to_franchhise;?></h4></span></div>
            <div align="center" class="text-secondary">Unable to Convert Franchise</div>
			</div>
			<div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $total;?></h4></span></div>
			<div align="center" class="text-secondary">Total</div>
			</div>
            <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $junk;?></h4></span></div>
			<div align="center" class="text-secondary">Junk</div>
			</div>
            <div class="col-md-1">
			<div align="center"><h4><span id="Newcnt"><?php echo $test;?></h4></span></div>
			<div align="center" class="text-secondary">Test</div>
			</div> -->
          </div>
		  <form class="row" action="" method="post" style="margin: 5px; padding:5px;">
		  	<!-- <div class="form-group col-md-6">
				<select class="form-control" name="status">
					<option value="" selected="selected" disabled="disabled">Select Status</option>
					<option value="1">New</option>
					<option value="2">Contacted</option>
					<option value="3">Qualified</option>							 							
					<option value="4">Proposal Sent</option>							
					<option value="5">Coverted to Franchise</option>							
					<option value="6">Not Coverted to Franchise</option>
					<option value="7">Junk</option>
					<option value="8">Test</option>
				</select>
			</div>
			<div class="form-group col-md-6">
			<?php //print_r($_REQUEST);?>
				<select class="form-control source" name="source">
					<option value="" selected="selected" disabled="disabled">Select Source</option>
					<option value="1"<?php if($_REQUEST['source'] == 1){echo "selected=''";}?>>Direct</option>
					<option value="2"<?php if($_REQUEST['source'] == 2){echo "selected=''";}?>>Ownself</option>
				</select>
			</div> -->
			<!--<div class="form-group col-md-2"><button class="btn btn-success" style="left:25%; right:25%; position: absolute; background:#293381;color:#fff;">Submit</button></div>
			<div class="form-group col-md-2"><button class="btn btn-warning" style="left:25%; right:25%; position: absolute; background:#293381;color:#fff;">Export</button></div>-->
			
		  </form>
		  <?php //echo "<pre>";print_r($lead);?>
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
