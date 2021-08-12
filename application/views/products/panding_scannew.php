<?php  
/* echo "<pre>";
print_r($records);
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
      <form method="post" id="data_form" class="card-body" action="<?php echo  base_url(); ?>productcategory/generate_isuue">
        <!-- <form method="post" id="data_form" class="card-body">-->
        <h4 class="card-title">Items Components </h4>
        <hr>
		
		
		
        <?php foreach($records as $key=>$data){ ?>
        <div class="form-group row" style="margin-top: 70px;">
          <div class="col-sm-3">
            
            <div class="scn-check">
              <label>Product Label Name</label>
              <input type="text" name="product_name[]" id="product_name" class="form-control margin-bottom rqty required" required="" readonly  value="<?php echo $data[0]->product_name; ?>">
            </div>

          </div>
          <div class="col-sm-3">
            
            <div class="scn-check">
              <label>Product Serial Number</label>
              <input type="text" name="serial[]" id="serial" class="form-control margin-bottom rqty required" required=""  readonly value="<?php echo $data[0]->serial; ?>">
            </div>
            
          </div>
        </div>
        <div class="form-group row" style="margin-top: 20px;">
          
		  <!--<div class="col-sm-3">            
            <div class="scn-check">
              <label>Qty</label>
              <select name="product_qty" id="product_qty" class="form-control margin-bottom rqty required" required="">
              <option value="1" selected="1"> 1 </option>
              <option value="2" selected="2"> 2 </option>
              <option value="3" selected="3"> 3 </option>
              <option value="4" selected="4"> 4 </option>
              <option value="5" selected="5"> 5 </option>
            </select>
            </div>            
          </div>-->
		  
		  
          <div class="col-sm-3">
            
            <div class="scn-check">
              <label>ZUPC </label>
              <input type="text" name="zupc[]" id="zupc" class="form-control margin-bottom rqty required" required="" placeholder="1929282829011" readonly value="<?php echo $data[0]->warehouse_product_code; ?>">
            </div>

          </div>
          
        </div>
        <div class="">
          <div class="form-group row" style="margin-bottom: 0px;">
            <label class="col-sm-2 col-form-label">Components</label>
          </div>
		 
		  <?php foreach($data as $key1=>$row){ ?>
          <div class="form-group row">			
            <div class="col-sm-3">              
              <div class="scn-check">
                <input type="text" name="component[<?php echo $key; ?>][<?php echo $key1; ?>]" id="component" class="form-control margin-bottom rqty required" required="" placeholder="Flash Light" readonly value="<?php echo $row->component_name; ?>">
              </div>
            </div>			
            <div class="col-sm-3">              
              <div class="scn-check">
                <input type="text" name="component_qty[<?php echo $key; ?>][<?php echo $key1; ?>]" id="component_qty" class="form-control margin-bottom rqty required" required="">
              </div>              
            </div>           
          </div>
		  <?php } ?>
		  
          
		  
        </div>
		
		<?php } ?>
		
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-5">
		  <input type="submit" name="submit" class="btn btn-success btn-xs" value="Submit">
		  <input type="hidden" name="request_id" id="request_id" value="<?php echo $req_id; ?>">
            <!--<a href="#" class="btn btn-success btn-xs">Submit</a>-->
          </div>
        </div>
        
      </form>
	  
    </div>
  </div>
</article>