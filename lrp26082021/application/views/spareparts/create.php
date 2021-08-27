<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      
      <div class="card card-block">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo "Leads Create"; ?></h3>
          <form action="<?php echo base_url()?>lead/save" method="post" class="row">
		  	<div class="form-group col-md-4">
				<input type="text" class="form-control" name="name" required placeholder="Name" />
			</div>
			<div class="form-group col-md-4">
				<input type="email" class="form-control" name="email" required placeholder="Email" />
			</div>
			<div class="form-group col-md-4">
				<input type="number" class="form-control" name="contactno" required placeholder="Contact No" />
			</div>
			<div class="form-group col-md-3">
				<input type="number" class="form-control pincode" name="pincode" required placeholder="Pincode" />
			</div>
			<div class="form-group col-md-3">
				<select class="form-control state" name="state" required><option selected="selected" disabled="disabled"> --- State ---</option></select>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" name="city" required placeholder="City" />
			</div>
			<div class="form-group col-md-3">
				<label class="radio-inline">Shop Type : </label>
				<label class="radio-inline"><input type="radio" name="shop_type" value="1" checked="checked"> Owned</label>
				<label class="radio-inline"><input type="radio" name="shop_type" value="0"> Rented</label>
			</div>
			<div class="form-group col-md-12">
				<input type="submit" class="btn btn-primary btn-sm" value="ADD" />
			</div>
			
		  </form>
		  
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(event){
		$('.pincode').blur(function(e){
			$.ajax({
				type : 'POST',
				url : baseurl+'lead/apicall',
				data : {pincode : $('.pincode').val()},
				cache : false,
				success : function(result){
					if(result != 0){
						$('.state').html(result);
					}
					else{
						$('.state').html('<option selected="selected" disabled="disabled"> --- State ---</option>');
					}
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
	});
</script>
