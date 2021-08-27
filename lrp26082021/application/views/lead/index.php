<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title"><?php echo "Leads"; ?><a href="<?php echo base_url()?>lead/create" class="btn btn-success btn-sm" style="margin:5px;">Add Lead</a></h3>
          <div class="row" style="padding: 5px;">
		 
            <div class="col-md-1">
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
			</div>
          </div>
		  <form class="row" action="" method="post" style="margin: 5px; padding:5px;">
		  	<div class="form-group col-md-6">
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
			</div>
			<!--<div class="form-group col-md-2"><button class="btn btn-success" style="left:25%; right:25%; position: absolute; background:#293381;color:#fff;">Submit</button></div>
			<div class="form-group col-md-2"><button class="btn btn-warning" style="left:25%; right:25%; position: absolute; background:#293381;color:#fff;">Export</button></div>-->
			
		  </form>
		  <?php //echo "<pre>";print_r($lead);?>
          <table id="leads" class="cell-border example1 table table-striped table1 delSelTable table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
				<th>State</th>
                <th>City</th>
				<th>Pincode</th>
                <th>Shop Type</th>
				<th>Date</th>
				<th>Source</th>
				<th>Status</th>
				<th>Action</th>
              </tr>
            </thead>
            <tbody>
				<?php /*echo "<pre>";print_r($lead); */$i = 1;foreach($lead as $lead_data){?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $lead_data->name;?></td>
						<td><?php echo $lead_data->email;?></td>
						<td><?php echo $lead_data->mobileno;?></td>
						<td><?php echo $lead_data->state;?></td>
						<td><?php echo $lead_data->city;?></td>
						<td><?php echo $lead_data->pincode;?></td>
						<td><?php echo $lead_data->shop;?></td>
						<td><?php $date = $lead_data->date;echo date("M d, Y",strtotime($date));?></td>
						<td><?php echo $lead_data->sourceBY;?></td>
						<td>
						<?php if($lead_data->status == "Converted to Franchise"){echo $lead_data->status; } ?>
						<select id="stauschnage<?php echo $lead_data->id;?>" name="statuschange<?php echo $lead_data->id;?>" class="form-control statusChange" <?php if($lead_data->status == "Converted to Franchise"){?> style="display:none;" <?php } ?>>
							
							<option value="1" <?php if($lead_data->status == "New"){?> selected="selected"<?php }?>>New</option>
							<option value="2" <?php if($lead_data->status == "Contacted"){?> selected="selected"<?php }?>>Contacted</option>
							<option value="3" <?php if($lead_data->status == "Qualified"){?> selected="selected"<?php }?>>Qualified</option>							 							
							<option value="4" <?php if($lead_data->status == "Proposal Sent"){?> selected="selected"<?php }?>>Proposal Sent</option>							
							<option value="5" <?php if($lead_data->status == "Coverted to Franchise"){?> selected="selected"<?php }?>>Converted to Franchise</option>							
							<option value="6" <?php if($lead_data->status == "Not Coverted to Franchise"){?> selected="selected"<?php }?>>Not Coverted to Franchise</option>
							<option value="7" <?php if($lead_data->status == "Junk"){?> selected="selected"<?php }?>>Junk</option>
							<option value="8" <?php if($lead_data->status == "Test"){?> selected="selected"<?php }?>>Test</option>
						</select>
						</td>
						<td>
							<?php if($lead_data->status == "Converted to Franchise"){?><a href="<?php echo ($lead_data->franchise == 1) ? base_url().'franchise/edit/'.$lead_data->id : base_url().'franchise/create/'.$lead_data->id;?>" class="btn <?php echo ($lead_data->franchise == 1) ? 'btn-secondary' : 'btn-primary';?> btn-sm"><?php echo ($lead_data->franchise == 1) ? 'EDIT' : 'ADD';?></a><?php } ?>
						</td>
					</tr>
				<?php $i++;
				}?>
            </tbody>
            
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
