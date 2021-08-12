<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="box-header with-border">
          <div class="row">
            
            <div class="col-xl-4 col-lg-6 col-12">
              <div class="card">
			 
                <div class="card-content">
                  <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2"> <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i> </div>
                    <div class="p-1 bg-gradient-x-primary white media-body">
                      <h5>Total Leads</h5>
                      <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i><?php echo $leads_count['total'];?></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-12">
              <div class="card">
                <div class="card-content">
                  <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2"> <i class="fa fa-sticky-note-o font-large-2 white"></i> </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                      <h5>Leads from Website</h5>
                      <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?php echo $leads_count['from_web'];?></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-12">
              <div class="card">
                <div class="card-content">
                  <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2"> <i class="fa fa-shopping-basket font-large-2 white"></i> </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                      <h5>Own Leads</h5>
                      <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>  <?php echo $leads_count['own'];?> </h5>
                    </div>
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
          <p><br>
          </p>
          <table id="leads" class="cell-border example1 table table-striped table1 delSelTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>City</th>
                <th>State</th>
				<th>Pincode</th>
                <th>Shop Type</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>City</th>
                <th>State</th>
				<th>Pincode</th>
                <th>Shop Type</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(event){
		var url = baseurl+'dashboard/leadlist';
		$.ajax({
			type :'POST',
			url : url,
			cache : false,
			success : function(result){
				$('#leads tbody').html(result);;
			},
			error : function (jqXHR, textStatus, errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
		});
	});
</script>
