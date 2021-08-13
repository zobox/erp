<article class="content">
  <div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <div class="card card-block">
      <?php //echo "<pre>";print_r($Pdata);echo "</pre>";?>
      <form method="post" id="data_form" class="card-body" action="<?php echo  base_url(); ?>purchase/addscan_margin">
        <!-- <form method="post" id="data_form" class="card-body">-->
        <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
        <hr>        
		
		<?php 
		/* echo "<pre>";
		print_r($Pdata);
		echo "</pre>";	 */	
		
		?>
		
		<div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Select PO Product</label>
          <div class="col-sm-4">            
            <select name="pid" id="pid" class="form-control margin-bottom rqty required" required>
				<?php foreach($Pdata->pitems as $key=>$row){ ?>
					<option value="<?php echo $row->pid;?>"> <?php echo $row->product;?> </option>
				<?php } ?>
            </select>	
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Product Sticker No</label>
          <div class="col-sm-4">            
            <select name="sticker" id="sticker" class="form-control margin-bottom rqty required" required>
				<option value=""> ---Select--- </option>
              <?php foreach($qc_data as $key=>$row){ ?>
				<option value="<?php echo $row->id; ?>"> <?php echo $row->sticker_no; ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Product Label Name</label>
          <div class="col-sm-4">            	
			<input type="text" name="product_name" id="product_name" class="form-control margin-bottom rqty required" required placeholder=''>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Colour </label>
          <div class="col-sm-4">
            
            <div class="scn-check">
              <input type="text" name="colour" id="colour" class="form-control margin-bottom rqty "  placeholder=''>
            </div>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Varient  </label>
          <div class="col-sm-4">
            
            <div class="scn-check">
              <input type="text" name="varient" id="varient" class="form-control margin-bottom rqty "  placeholder=''>
            </div>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Condition   </label>
          <div class="col-sm-4">
            
            <div class="scn-check">
              <input type="text" name="condition" id="condition" class="form-control margin-bottom rqty "  placeholder=''>
            </div>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">IMEI / Serial No</label>
          <div class="col-sm-4">
            
            <div class="scn-check">
              <input type="text" name="imei1disp" id="imei1disp" class="form-control margin-bottom rqty required" required placeholder='IEMI Number'>
              <input type="hidden" name="imei1" id="imei1" class="form-control margin-bottom rqty required" required placeholder='IEMI Number'>
            </div>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">IMEI / Serial No</label>
          <div class="col-sm-4">
            
            <div class="scn-check">
              <input type="text" name="imei2" id="imei2" class="form-control margin-bottom rqty required" required placeholder='IEMI Number'>
            </div>
          </div>
        </div>

        
        
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Job Work required</label>
          <div class="col-sm-4">
            <select name="jobwork_required" id="jobwork_required" class="form-control margin-bottom rqty required" required>
              <option value="1" selected="selected"> Yes </option>
              <option value="0"> No </option>
            </select>
          </div>
        </div>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-4">
            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
              value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
            <input type="hidden" value="purchase/addscan_margin" id="action-url">
            <input type="hidden" name="purchaseid" value="<?php echo $id; ?>" id="id">
          </div>
        </div>
      </form>
    </div>
  </div>
</article>


<script>
$('#sticker').change(function(){
	var id = $(this).val();
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('purchase/getimei')?>",
		data : {id : id},
		dataType : 'json',
		cache : false,
		success : function(data)
		{	
			console.log(data);
		    		
			 $("#product_name").val(data['product_label_name']);			
			 $("#colour").val(data['colour']);			
			 $("#varient").val(data['varient']);			
			 $("#condition").val(data['product_condition']);			
			 $("#imei1").val(data['imei1']);
			 //var lastfour = data['imei1'].substr(data['imei1'].length - 4);
			 $("#imei1disp").val(data['imei1']);			
			 $("#imei2").val(data['imei2']);			
			 
		}
	});
});

</script>