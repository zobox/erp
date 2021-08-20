<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add Data') ?></h4>
            <div class="card-content">
                
                    <div class="card-body px-0">
					
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="brand">Product Type</label>
                                    <select id="product_type" name="product_type" class="form-control select-box" required>
                                      <option value="Mobile">Mobile</option>
                                     <option value="Accessories">Accessories</option>
                                     <option value="Spareparts">Spareparts</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						
						 <form method="post" enctype="multipart/form-data" id="data_form" action="<?=base_url()?>purchase/add_recieve_goods">
                         <div id="Mobile" class="receive_good_add mt-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="card-title mb-2">Mobile</h4>
									<input type="hidden" name="product_type1" value="1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Job Work Required
                                        </label>
                                        <div class="col-sm-7">
                                            <select id="jobwork_required" name="jobwork_required" class="form-control" required="">
                                                <option value="">Select Option</option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Pending PO List
                                        </label>
                                        <div class="col-sm-7">
                                            <select id="sub_cat" name="purchase_id" class="form-control select-box" required>
                                              <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Add Varient
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="varient_id" id="varient" class="form-control select-box">
                                              <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Add IMEI / Serial No 1
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control margin-bottom" name="serial_no1" id="serial_no1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                    <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                        </label>
                                        <div class="col-sm-7">
											<select class="form-control" id="product_cat" name="supplier_id" required>
											<option value="">Select Supplier</option>
											  <?php
											  foreach($supplier_list as $supplier)
											  {
												?>
												<option value="<?=$supplier->id?>"><?=$supplier->company?></option>
												<?php
											  }
											  ?>
											</select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Product List
                                            </label>
                                            <div class="col-sm-7">
                                                <select id="sub_sub_cat" name="purchase_item_id" class="form-control select-box" required>
                                                  <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
									
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Add Colour
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="color_id" id="color" class="form-control select-box">
                                                  <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
									
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Add IMEI / Serial No 2
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="serial_no2" id="serial_no2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <input type="submit" name="submit" id="submit" class="btn btn-success mt-2" value="Submit">
                                        <!--<button type="submit" class="btn btn-success ">Submit</button>-->
                                    </div>
                                </div>
                            </div>
                         </div>
						 </form>
						 
						 
						 
						 
                         <div id="Accessories" class="receive_good_add mt-3" style="display: none;">
                             <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="card-title mb-2">Accessories</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                    <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" id="product_cat1" name="supplier_id1">
											<option value="">Select Supplier</option>
											  <?php

											  foreach($supplier_list as $supplier)
											  {
												?>
												<option value="<?=$supplier->id?>"><?=$supplier->company?></option>
												<?php
											  }
											  ?>
											</select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Product List
                                            </label>
                                            <div class="col-sm-7">
                                                <select id="sub_sub_cat1" name="purchase_item_id1" class="form-control select-box">
                                                  <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Qty 
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no" id="sticker_no">
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Pending PO List
                                        </label>
                                        <div class="col-sm-7">
                                            <select id="sub_cat1" name="purchase_id1" class="form-control select-box">
                                              <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        ZUPC 
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="zupc" id="zupc">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <input type="submit" name="submit" id="submit" class="btn btn-success mt-2" value="Submit">
                                        <!--<button type="submit" class="btn btn-success ">Submit</button>-->
                                    </div>
                                </div>
                            </div>
                         </div>
						 
						 
                         <div id="Spareparts" class="receive_good_add mt-3" style="display: none;">
                             <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="card-title mb-2">Spareparts</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                    <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                        </label>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <option value="">Select Supplier</option>
                                                <option value="1">Manak Waste Management Pvt. Ltd.</option>
                                                <option value="2">Supplier_Test_Company</option>
                                                <option value="3">Onsite Phones Private Limited</option>
                                                <option value="4">Joltme Electrovision (India) Private Limited </option>
                                                <option value="5">GreenTek Reman Pvt. Ltd</option>
                                                <option value="6">AMAZON SELLER SERVICES PRIVATE LIMITED</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Product List
                                            </label>
                                            <div class="col-sm-7">
                                                <select class="form-control select-box">
                                                  <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        Qty 
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no" id="sticker_no">
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                    Pending PO List
                                        </label>
                                        <div class="col-sm-7">
                                            <select id="sub_cat" name="purchase_id" class="form-control select-box">
                                              <option value="" selected="selected"> --- Select ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label" for="brand">
                                        ZUPC 
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no" id="sticker_no">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <input type="submit" name="submit" id="submit" class="btn btn-success mt-2" value="Submit">
                                        <!--<button type="submit" class="btn btn-success ">Submit</button>-->
                                    </div>
                                </div>
                            </div>
                         </div>
						 
                        
                    </div>
                
                <!--<form method="post" enctype="multipart/form-data" action="<?=base_url()?>purchase/receive_good_add_item">
                <div class="card-body px-0">
                    <?php
                    /*echo '<pre>';
                    print_r($supplier_list);
                    die;*/
                    ?>
                    <hr />
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="product_cat" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                      <?php

                                      foreach($supplier_list as $supplier)
                                      {
                                        ?>
                                        <option value="<?=$supplier->id?>"><?=$supplier->company?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    <?php echo $this->lang->line('Pending PO List') ?>
                                </label>
                                <div class="col-sm-7">
                                  <select id="sub_cat" name="purchase_id" class="form-control select-box" required>
                                  <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Items
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="sub_sub_cat" name="product_id" required="">
                                       <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Receiving Good Quantity
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control margin-bottom" name="qty" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row">
                        <div class="col-sm-12 text-center mt-3">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>-->
            </div>
        </div>
    </div>
</div>
<script>
	$(function() {
	  $('#product_type').change(function(){
		$('.receive_good_add').hide();
		$('#' + $(this).val()).show();
	  });
	});
</script>


<script>
	$('#product_cat').on('change',function(event){
		var productcat = $(this).val();
		//alert(productcat);
		//var data_type = $('#product_type').val();
		var data_type = 1;
		$('#sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getListPo',
			data : {id : productcat,data_type:data_type},
			cache : false,
			success : function(result){
				//console.log(result);
				$('#sub_cat').append(result);
			}
		});
	});
	

	$('#sub_cat').on('change',function(event){
		var productcat = $(this).val();
		var data_type = 1;
		
		$('#sub_sub_cat').html("<option value='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getListPoItem',
			data : {id : productcat,data_type:data_type},
			cache : false,
			success : function(result){
				//console.log("TTTTTTTTTTTTTTTTTTTT");
				if(result != 0){
				   $('#sub_sub_cat').append(result);                    
				}                
			}
		});
	});
	
	
	$('#sub_sub_cat').on('change',function(event){
        var productcat = $(this).val();
		var data_type = 1;
		
		$.ajax({
            type : 'POST',
            url : baseurl+'purchase/getproductinfo',
            data : {id : productcat,data_type:data_type},
            cache : false,
            success : function(result){
                //console.log(result);
                if(result != 0){
					var res = result.split("#");
					
                    $('#zupc').val(res[0]);
					$('#varient').html(res[1]);
                }
            }
        });
    });
	
	
	$('#varient').change(function(){
		var id = $(this).val();
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getvarientcolor',
			data : {id : id},
			cache : false,
			success : function(result){
				//console.log(result);
				if(result != 0){							
					$('#color').html(result);
				}
			}
		});
	});
</script>




<script>
//Accessories


$('#product_cat1').on('change',function(event){
		var productcat = $(this).val();
		//alert(productcat);
		//var data_type = $('#product_type').val();
		var data_type = 1;
		$('#sub_cat1').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getListPo',
			data : {id : productcat,data_type:data_type},
			cache : false,
			success : function(result){
				//console.log(result);
				$('#sub_cat1').append(result);
			}
		});
	});
	

	$('#sub_cat1').on('change',function(event){
		var productcat = $(this).val();
		var data_type = 1;
		
		$('#sub_sub_cat1').html("<option value='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getListPoItem',
			data : {id : productcat,data_type:data_type},
			cache : false,
			success : function(result){
				//console.log("TTTTTTTTTTTTTTTTTTTT");
				if(result != 0){
				   $('#sub_sub_cat1').append(result);                    
				}                
			}
		});
	});
	
	$('#sub_sub_cat1').on('change',function(event){
        var productcat = $(this).val();
		var data_type = 1;
		
		$.ajax({
            type : 'POST',
            url : baseurl+'purchase/getproductinfo',
            data : {id : productcat,data_type:data_type},
            cache : false,
            success : function(result){
                //console.log(result);
                if(result != 0){
					var res = result.split("#");
					
                    $('#zupc').val(res[0]);
					//$('#varient').html(res[1]);
                }
            }
        });
    });
</script>