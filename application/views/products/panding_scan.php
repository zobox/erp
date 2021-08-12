<?php 
/* echo "<pre>";
print_r($record);
echo "</pre>"; */
?>

<article class="content">
  <div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <div class="card card-block">
      <?php //echo "<pre>";print_r($Pdata);echo "</pre>";?>
      <form method="post" id="data_form" class="card-body" action="<?= base_url() ?>Productcategory/generate_isuue">
      <!--<form method="post" id="data_form" class="card-body" action="<?= base_url() ?>Productcategory/panding_scannew">-->
        <!-- <form method="post" id="data_form" class="card-body">-->
        <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
        <hr>		
		
		<div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Scan Product Via</label>
          <div class="col-sm-4">
            <select name="jobwork_required" id="jobwork_required" class="form-control margin-bottom rqty required" required>
              <option value="1" selected="selected"> Serial Number </option>              
            </select>
          </div>
        </div>
		
		<div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Scan :</label>
          <div class="col-sm-4">            
            <div class="scn-check">
              <input type="text" name="scan" id="scan" class="form-control margin-bottom rqty " placeholder="Scan IMEI Number">
			  <br>
			  <div class="errormsg danger"></div>
             </div>
          </div>
        </div>
		
		
		

		<input type="hidden" name="qty" id="qty" value="<?php echo $record->qty; ?>">
		
		<?php for($i=1; $i<=$record->qty; $i++){ ?>        
		
        <div class="form-group row" id='serialdiv<?php echo $i; ?>' style="display:none;">
          <label class="col-sm-2 col-form-label" for="product_catname">Serial <?php echo $i; ?> :</label>
          <div class="col-sm-4">            
            <div class="scn-check">
              <input type="text" name="serials[]" id="serials<?php echo $i; ?>" class="form-control margin-bottom rqty serial"  placeholder="Scan IMEI Number">
            </div>
          </div>
        </div>
		<?php } ?>
		
        
        
        
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-4">
			<input type="submit" name="next" id="next" value="Next">
			<input type="hidden" name="id" id="id" value="<?php echo $record->id; ?>">
			<input type="hidden" name="product_id" id="product_id" value="<?php echo $record->product_id; ?>">			
            <!--<a href="<?= base_url() ?>Productcategory/panding_scannew" class="btn btn-success btn-xs" target="_blank">Next</a>-->
          </div>
        </div>
        
      </form>
    </div>
  </div>
</article>


<script>
$('.serial').change(function(){
	var serial_no = $(this).val();	
	var product_id = $('#product_id').val();	
	var id = $(this).attr('id');	
	$.ajax({
		type : "POST",		
		url : baseurl+'products/checkcomponent',
		data : {serial_no : serial_no,product_id:product_id},
		cache : false,
		success : function(data)
		{	
			console.log(data);
			$('#cmpmessage'+id).html(data);
			//location.reload();	
		}
	});
});


$('#scan').change(function(){
	var serial_no = $(this).val();
	var product_id = $('#product_id').val();	
	//alert(serial_no);
	$.ajax({
		type : "POST",		
		url : baseurl+'productcategory/scanimei',
		data : {serial_no : serial_no,product_id:product_id},
		//dataType : 'json',
		cache : false,
		success : function(data)
		{	
			console.log(data);
			if(data==1){
				//alert('okss');
				var qty = $('#qty').val();				
				for (var i=1; i<=qty; i++){					
					var serials_var = '#serials'+i;
					var serialdiv_var = '#serialdiv'+i;
					//alert(serials_var);
					if($(serials_var).val()==''){
						$(serialdiv_var).show();
						$(serials_var).val(serial_no); 
						$('#scan').val('');
						$('#scan').focus();
						break;
					}else if(i==qty){
						$('.errormsg').html('Quantity not more than '+qty);
					}
				}
					
			}else if(data==2){
				$('.errormsg').html('Component not available');
			}else{
				$('.errormsg').html('Invalid serial Number! Please Try Again');
			}	
		}
	});
});
</script>