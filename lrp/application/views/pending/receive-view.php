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
          
		  <form class="row" action="" method="post">
			<div class="form-group col-md-6">
			<input type="text" placeholder="Search IMEI" class="form-control margin-bottom required">
			</div>
			<div class="form-group col-md-6">
			<a href="#" class="btn btn-success btn-md">Search</a>
	  		</div>
			  <table class="table table-striped table-bordered zero-configuration dataTable dtr-inline text-center">
            <thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Mobile Name</th>
					<th class="text-center">IMEI</th>
				</tr>
            </thead>
            <tbody>
				<tr>
					<td>1</td>
					<td>Samsung A30</td>
					<td>4585522525220</td>
	  			</tr>
				<tr>
					<td>2</td>
					<td>Xiaomi Mi 10</td>
					<td>6865435465454</td>
	  			</tr>
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
				<div class="col-sm-12 text-center">
					<a href="#" class="btn btn-success btn-md">Submit</a>
				</div>
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
