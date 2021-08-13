<div class="content-body">
    <div class="card">
        <div class="card-content">
                <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message" id="msg"></div>
    </div> 
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add Data') ?></h4>
            
                <div class="card-body px-0">
                    <hr />
				<form method="post" enctype="multipart/form-data" id="data_form" action="<?=base_url()?>purchase/add_recevive_goods_info_new" onSubmit="return valid111()">
                      <div class="row">
                        
                        <div class="col-sm-5" style="" id="">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Add Data Via
                                </label>
                                <div class="col-sm-7">
                                    <select id="data_type" name="data_type" class="form-control" required>
                                        <option value="">Select Option</option>
                                        <option value="1">Serial No</option>
                                        <option value="2">ZUPC Code</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						
                        <div class="col-sm-6" style="" id="serial_no_type">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                    Job Work Required
                                </label>
                                <div class="col-sm-8">
                                    <select id="jobwork_required" name="jobwork_required" class="form-control">
                                        <option value="">Select Option</option>
                                        <option selected value="1">Yes</option>
                                        <option value="2">No</option>
                                        <option value="3">Yes (Without Component)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="product_cat" name="supplier_id">
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
                                <label class="col-sm-4 col-form-label" for="brand">
                                    <?php echo $this->lang->line('Pending PO List') ?>
                                </label>
                                <div class="col-sm-8">
                                  <select id="sub_cat" name="purchase_id" class="form-control select-box">
                                  <option value="" selected="selected"> --- Select ---</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Product List
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="sub_sub_cat" name="purchase_item_id" >
                                       <option value="" selected="selected"> --- Select ---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						
                        <div class="col-sm-6">
                            <div class="form-group row zupcno">
                                 <label class="col-sm-4 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('ZUPC Code') ?>
                                            </label>
									<div class="col-sm-8">
									  <input type="text" id="zupc" class="form-control margin-bottom" name="zupc_code">  
									 </div>
                            </div>
                        </div>

                    </div>
                        
                    
                    
                     <input type="hidden" name="jobwork_type" id="jobwork" value="">
                     <!--<input type="hidden" name="jobwork_supplier_id" value="<?=$purchase_detail[0]->supplier_id?>">
                     <input type="hidden" name="jobwork_purchase_id" value="<?=$purchase_detail[0]->purchase_id?>">
                     <input type="hidden" name="jobwork_pid" value="<?=$purchase_detail[0]->pid?>">
                     <input type="hidden" name="jobwork_varient_type" value="<?=$product_detail[0]['unit_name']?>">
                     <input type="hidden" name="jobwork_color_name" value="<?=$product_detail[0]['colour_name']?>">
                     <input type="hidden" name="jobwork_zupc_code" value="<?=$product_detail[0]['warehouse_product_code']?>">
                     <input type="hidden" name="product_name" value="<?=$product_detail[0]['product_name']?>">
                     <input type="hidden" name="brand_name" value="<?=$product_detail[0]['brand_name']?>">-->
                    
					<div class="multi-field-wrapper">
                        <div class="multi-fields">
                            <div class="multi-field">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-5 col-form-label" for="brand">
                                                <?php echo $this->lang->line('Add Varient') ?>
                                            </label>
                                            <div class="col-sm-7">
                                               <select class="form-control" name="varient_id" id="varient">                                                   
                                                </select> 
                                            </div>
                                        </div>
                                        

										<div class="form-group row zupcno">
                                            <label class="col-sm-5 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('Add Sticker No') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no" id="sticker_no"> </div>
                                        </div>
                                        
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-5 col-form-label" for="IMEI-2">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 2') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="imei_2" id="imei_2"> </div>
                                        </div>
										
										
										
										<div class="form-group row JobworkYes zupcno">
                                            <label class="col-sm-5 col-form-label" for="IMEI-1">Final Grade</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="final_grade" id="final_grade">
                                                    <option value="">Select Final Grade</option>
													<?php foreach($conditions as $key=>$condition_data){ ?>
														<option value="<?php echo $condition_data->id; ?>"><?php echo $condition_data->name; ?></option>
                                                    <?php } ?>                                                    
                                                </select>    
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-5 col-form-label" for="Engineer">
                                                <?php echo $this->lang->line('Add QC Engineer Name') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="qc_engineer" id="qc_engineer"> </div>
                                        </div>
										
										<div class="form-group row zupcno_y" style="display:none">
                                            <label class="col-sm-5 col-form-label" for="franchise_fee">
                                                <?php echo $this->lang->line('Quantity') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="qty" id="qty"> </div>
                                        </div>
                                        
                                    </div>
									
									
                                    <div class="col-sm-6">
									
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-4 col-form-label" for="space_required">
                                                <?php echo $this->lang->line('Add Colour') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="color_id" id="color">
                                                    <option value="">---Select-</option>                                      
                                                </select> 
                                             </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="imei">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 1') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control margin-bottom" name="serial_no1" id="serial_no1"> 
												<span id="serial_avl" style="color:red"></span>
												</div>
                                        </div> 							
										
										<div class="form-group row zupcno">
                                            <label class="col-sm-4 col-form-label" for="IMEI-1">
                                                Current Grade
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="current_grade" id="current_grade">
                                                    <option value="">Select Current Grade</option>
                                                    <?php foreach($conditions as $key=>$condition_data){ ?>
														<option value="<?php echo $condition_data->id; ?>"><?php echo $condition_data->name; ?></option>
                                                    <?php } ?>
                                                </select>    
                                            </div>
                                        </div>	


										
										
                                        <div class="form-group row JobworkYes PraxoYes zupcno">
                                            <label class="col-sm-4 col-form-label" for="replaced_items">
                                                <?php echo $this->lang->line('Add Item to be replaced') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <!--<input type="text" class="form-control margin-bottom" name="items" id="items"  style="height: 55px;">-->
												<select id="conditionsdp1" name="items[]" class="form-control required 	select-box"
												multiple="multiple" onfocus="getconditions();">
												
											 </select>		
											</div>
                                        </div>	
										                                        
                                    </div>
                                    
                                </div>
                               
                            </div>
                        </div>
						
                        <div class="text-center">
							<input type="submit"
							 class="btn btn-success sub-btn btn-lg ml-auto"
							 value="<?php echo $this->lang->line('Submit') ?>"
							 id="submit-data11" data-loading-text="Creating...">			
							<input type="hidden" value="purchase/add_recevive_goods_info_new" id="action-url">
                        </div>
						
                    </div>
                </form>			
				
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$('#serial_no1').on('change',function(event){
	var serial_no = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'purchase/checkSerialAvailability',
		data : {serial_no : serial_no},
		cache : false,
		success : function(result){
			console.log(result);
			if(result=='false'){
				$('#submit-data11').attr('disabled','true');
				$('#serial_avl').html('Allready Exist !');
			}else if(result=='true'){
				$('#submit-data11').removeAttr("disabled");
				$('#serial_avl').html('');
			}
			//$('#sub_cat').append(result);
		}
	});
});


$('#serial_no1').on('keyup',function(event){
	var serial_no = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'purchase/checkSerialAvailability',
		data : {serial_no : serial_no},
		cache : false,
		success : function(result){
			console.log(result);
			if(result=='false'){
				$('#submit-data11').attr('disabled','true');
				$('#serial_avl').html('Allready Exist !');
			}else if(result=='true'){
				$('#submit-data11').removeAttr("disabled");
				$('#serial_avl').html('');
			}
			//$('#sub_cat').append(result);
		}
	});
});


$('#product_cat').on('change',function(event){
        var productcat = $(this).val();
		var data_type = $('#data_type').val();
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
		var data_type = $('#data_type').val();
		
		$('#sub_sub_cat').html("<option value='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'purchase/getListPoItem',
			data : {id : productcat,data_type:data_type},
			cache : false,
			success : function(result){
				if(result != 0){
				   $('#sub_sub_cat').append(result);                    
				}                
			}
		});
	}); 
  
  $('#sub_sub_cat').on('change',function(event){
        var productcat = $(this).val();
		var data_type = $('#data_type').val();
		
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

$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if($('.multi-field', $wrapper).length > 1) $(this).parent('.multi-field').remove();
    });
});
</script>
<script>
$('#data_type').on('change', function() {      
      if(this.value == '1')
      {
		$("#jobwork_required").attr("required", "true");
		$("#product_cat").attr("required", "true");
		$("#sub_cat").attr("required", "true");
		$("#sub_sub_cat").attr("required", "true");
		//$("#varient").attr("required", "true");
		//$("#color").attr("required", "true");
		$("#sticker_no").attr("required", "true");
		$("#serial_no1").attr("required", "true");
		$("#imei_2").attr("required", "true");
		//$("#final_grade").attr("required", "true");
		$("#current_grade").attr("required", "true");
		//$("#items").attr("required", "true");
		$("#qc_engineer").attr("required", "true");
		$("label[for='imei']").text("Add IMEI / Serial No 1");  
		
        $('#serial_no_type').show();
        $('.zupcno').show();        
		$('#submit_zupc').hide();
		$('.zupcno_y').hide();
      }
      if(this.value == '2')
      {
		$("#product_cat").attr("required", "true");
		$("#sub_cat").attr("required", "true");
		$("#sub_sub_cat").attr("required", "true");
		$("#qty").attr("required", "true");
		$("#serial_no1").attr("required", "true");  
		$("label[for='imei']").text("ZUPC");  
        $('.zupcno').hide();
        $('#serial_no_type').hide();
        $('#submit_zupc').show();
        $('.zupcno_y').show();
      }
})

$('#jobwork_required').on('change', function() {
  //  alert( this.value ); // or $(this).val()
  if(this.value == "1") {
	$("#final_grade").attr("required", "true");
	$("#items").attr("required", "true");
    $('.JobworkYes').show();
    //$('.JobworkNo').hide();

    $('#jobwork').val('1');
    $('#jobwork_not_required').val('');
    

  }else if(this.value == "2"){
    $('#jobwork_not_required').val('2');
    $('#jobwork').val('');
    $('.JobworkYes').hide();
    //$('.JobworkNo').show();
  }else if(this.value == "3"){
	$("#final_grade").attr("required", "true");
	$("#items").attr("required", "true");
    $('.JobworkYes').show();
	$('#jobwork_not_required').val('3');
	$('#jobwork').val('3');
	$('.PraxoYes').hide();
  }
});


function valid()
{
    if(document.getElementById('test').value=='')
    {
        document.getElementById('notify').style.display='block';
        document.getElementById('msg').innerHTML='Please Select Job Work Type';
        document.getElementById('notify').focus();
        document.getElementById('test').focus();
        return false;
    }
}


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


<script type="text/javascript">

	function getconditions(){
		var product_id = $('#sub_sub_cat').val(); 
		var varient_id = $('#varient').val();
		//alert(product_id);
		//alert(varient_id);
		
		$('#conditionsdp1').select2({
			tags: [],
			ajax: {
				url: baseurl + 'purchase/getcomponents?product_id='+product_id+'&varient_id='+varient_id,
				dataType: 'json',
				type: 'POST',
				quietMillis: 50,
				data: function (product) {            
				console.log(product);
					return {
						product: product,
						'<?=$this->security->get_csrf_token_name()?>': crsf_hash
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {                
							return {								
								text: item.component_name,
								id: item.component_name
							}
						})
					};
				},
			}
		});
	}
</script>
