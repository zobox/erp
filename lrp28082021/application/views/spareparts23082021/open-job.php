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
              <tr>
              	<td>1</td>
              	<td>SR-JOBWORK12</td>
              	<td>Vivo Y17--(4GB / 128GB)-Excellant-Mystic Purple</td>
              	<td>860398041129633</td>
              	<td>Battery Cover-Vivo Y17 ⇒ 9800000026245</td>
              	<td>trmteamleader</td>
              	<td>Ravi</td>
              	<td><span class="badge  st-paid app" style="background-color:#5ed45e;">Proceed For QC</span></td>
              	<td><span class="badge  st-paid app">QC PASS</span></td>
              	<td><a href="open_view" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>  View</a></td>
              </tr>
              <tr>
              	<td>2</td>
              	<td>SR-JOBWORK388</td>
              	<td>Samsung Galaxy M30S--(6GB / 128GB)-Excellant-Black</td>
              	<td>3515071169192661</td>
              	<td>Back Housing-Samsung Galaxy A30 ⇒ 9800000026211</td>
              	<td>trmteamleader</td>
              	<td>Ravi</td>
              	<td><span class="badge  st-paid app" style="background-color:blue;">Pending</span></td>
              	<td></td>
              	<td><a href="open_view" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>  View</a></td>
              </tr>
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
