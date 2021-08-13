<style>
	.applicableselecton{
		padding: 5px;
    	background:	#6666f8;
		color: white;
    	margin: 5px;
		cursor:pointer;
	}
	.applicableselectonn
	{
		padding: 5px;
    	background:	#6666f8;
		color: white;
    	margin: 5px;
		cursor:pointer;

	}
	
	.closee{
		float:right;
	}
</style>
<div class="content-body">
  <div class="card">
    <div class="card-header pb-0">
      <?php //print_r($_SESSION);?>
      <h5><?php echo $this->lang->line('Add Promo') ?></h5>
      
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content">
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
	  <hr>
      <div class="card-body">
        <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url();?>promo/create">
		<div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="Coupon Title">
                                    <?php echo $this->lang->line('Coupon Title') ?>
                                </label>
                                <div class="col-sm-7">
								<input type="text" placeholder="Coupon Title" class="form-control margin-bottom required" name="coupon_title" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="Coupon Code">
                                   <?php echo $this->lang->line('Coupon Code') ?>
                                </label>
                                <div class="col-sm-8">
								<input type="text" placeholder="Coupon Code" class="form-control margin-bottom required" name="code" value="<?php echo $this->coupon->generate(8) ?>">
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="Applicable To">
                                   <?php echo $this->lang->line('Applicable To') ?>
                                </label>
                                <div class="col-sm-7">
								<select class="form-control" name="applicable_to" id="applicable_to">
									<option value="" selected="selected" disabled="disabled">Select Applicable to</option>
									<option value="1">Branch Wise</option>
									<option value="2">Store Wise</option>
									<option value="3">All</option>
								 </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="Select">
                                    <?php echo $this->lang->line('Select') ?>
                                </label>
                                <div class="col-sm-8">
                                    <div class="applicable_to_selection_div" style="display:none; border: 1px solid black;height: auto; margin-bottom:5px;">
			<input class="form-control" id="applicableselectioninput" name="applicableselectioninput" type="hidden">
			</div>
              <select class="form-control" name="applicable_to_selection[]" id="applicable_to_selection">
              </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multi-field-wrapper" id="Yes">
                        <div class="multi-fields">
                            <div class="multi-field">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="Discount Type">
                                                <?php echo $this->lang->line('Discount Type') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <select class="form-control"  name="discount_type">
                                                    <option value="1">Percent</option>
                                                    <option value="2">Amount</option>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="Coupon Title">
                                                <?php echo $this->lang->line('Amount') ?>
                                            </label>
                                            <div class="col-sm-7">
											<input type="number" placeholder="Amount" class="form-control margin-bottom required" name="amount" value="">   
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="Valid Till">
                                               <?php echo $this->lang->line('Valid From') ?>
                                            </label>
                                            <div class="col-sm-7">
											<input type="text" class="form-control margin-bottom required" placeholder="Start Date" name="valid_from" data-toggle="datepicker" autocomplete="false"></div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="note">
                                               <?php echo $this->lang->line('Note') ?>
                                            </label>
                                            <div class="col-sm-7">
											<input type="text" class="form-control margin-bottom" name="label" placeholder="Add Note"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="Coupon Discount On">
                                                <?php echo $this->lang->line('Coupon Discount On') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name='coupon_discount_on' id="coupon_discount_on">
                                                    <option value="" selected="selected" disabled="disabled">Select coupon discount on</option>
													<option value="1">All Product</option>
													<option value="2">Category</option>
													<option value="3"> Sub Category</option>
                                                </select>  
                                             </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="Select">
                                                <?php echo $this->lang->line('Select') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="coupon_discount_on_select[]" id="coupon_discount_on_select">
													  </select>
													  <div class="coupon_discount_on_select_div" style="display:none; border: 1px solid black;height: auto;  margin-bottom:5px;">
														<input style="height:auto;" class="form-control" id="coupondiscountselectinput" name="coupondiscountselectinput" type="hidden">
													</div>   
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="valid"><?php echo $this->lang->line('Valid Till') ?>
                                            </label>
                                            <div class="col-sm-8">
												<input type="text" class="form-control margin-bottom required" placeholder="end-Date" name="valid_till" data-toggle="datepicker" autocomplete="false"> </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <button type="button" class="remove-field remove-quote-btbx btn bg-danger text-white"><i class="fa fa-close" aria-hidden="true"></i> Delete Row</button>
                            </div>
                        </div>
                        <div class="text-center">
                
                            
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom "
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
              <input type="hidden" value="promo/create" id="action-url">
                        </div>
                    </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#applicable_to').on('change',function(){
	$('#applicable_to_selection').html('');
	$('.applicableselecton').remove();
	$('#applicableselectioninput').val('');
	$('.applicable_to_selection_div').css('display','none');
	//$('#applicable_to_selection').removeAttr('multiple');
	$('#applicable_to_selection').css('overflow-y','hidden');
	var applicable_to = $(this).val();
	$.ajax({
		type : 'POST',
		url : '<?php echo base_url();?>promo/get_applicable_select_on',
		data : {applicable : applicable_to},
		cache : false,
		success : function(res){
			if(res != 0){
				$('#applicable_to_selection').html(res);
				//$('#applicable_to_selection').attr('multiple','multiple');
				$('#applicable_to_selection').css('overflow-y','scroll');
			}
		}
	});
});
$('#coupon_discount_on').on('change',function(){
	$('#coupon_discount_on_select').html('');
	$('.applicableselectonn').remove();
	$('#coupondiscountselectinput').val('');
	$('.coupon_discount_on_select_div').css('display','none');
	//$('#coupon_discount_on_select').removeAttr('multiple');
	$('#coupon_discount_on_select').css('overflow-y','hidden');
	var coupon_discount_on = $(this).val();
	$.ajax({
		type : 'POST',
		url : '<?php echo base_url();?>promo/get_coupon_discount_on',
		data : {data : coupon_discount_on},
		cache : false,
		success : function(res){
			//alert(res);
			if(res != 0){
				$('#coupon_discount_on_select').html(res);
				//$('#coupon_discount_on_select').attr('multiple','multiple');
				$('#coupon_discount_on_select').css('overflow-y','scroll');
			}
			
		}
	});
});
$('#applicable_to_selection').change(function(){
	var value_selection = $(this).val();
	if($('#applicableselectioninput').val() == '' || $('#applicableselectioninput').val() == ' ' || $('#applicableselectioninput').val() == null){
		$('#applicableselectioninput').val(value_selection);
		$.ajax({
			type : 'POST',
			data : {data : value_selection},
			url : '<?php echo base_url();?>promo/value_selection_data',
			cache : false,
			success : function(result){
				$('.applicable_to_selection_div').append(result);
				$('.applicable_to_selection_div').css('display','block');
			}
		});
	}
	else{
		var applicableselectioninput = $('#applicableselectioninput').val().split(",");
		if(applicableselectioninput.indexOf(value_selection) < 0){
			$('#applicableselectioninput').val($('#applicableselectioninput').val()+','+value_selection);
			$.ajax({
			type : 'POST',
			data : {data : value_selection},
			url : '<?php echo base_url();?>promo/value_selection_data',
			cache : false,
			success : function(result){
				$('.applicable_to_selection_div').append(result);
				$('.applicable_to_selection_div').css('display','block');
			}
	});
		}
	}
	
});

/*$('.applicableselecton').on('click',function(e){
	e.preventDefault();
	alert(1);
});*/
function selectt(e){
	var ids = e;
	var applicableselectioninput = $('#applicableselectioninput').val();
	if(applicableselectioninput.includes(',') == false){
		$('#applicableselectioninput').val('');
		$('.applicable_to_selection_div').css('display','none');
		$('.applicableselecton').remove();
	}
	else{
		applicableselectioninput = applicableselectioninput.split(',');
		var position = applicableselectioninput.indexOf(ids);
		applicableselectioninput.splice(position,1);
		var joinvalue = applicableselectioninput.join();
		$('#applicableselectioninput').val(joinvalue);
		$('#'+ids).remove();
	}
	
	
}

$('#coupon_discount_on_select').on('change',function(){
	var value_selection = $(this).val();
	if($('#coupondiscountselectinput').val() == '' || $('#coupondiscountselectinput').val() == ' ' || $('#coupondiscountselectinput').val() == null){
		$('#coupondiscountselectinput').val(value_selection);
		$.ajax({
		type : 'POST',
		url : '<?php echo base_url();?>promo/coupon_discount_value_selection_data',
		data : {data : value_selection},
		cache : false,
		success : function(result){
			//alert(result);
			$('.coupon_discount_on_select_div').append(result);
			$('.coupon_discount_on_select_div').css('display','block');
			
		}
	});
	}
	else{
		var applicableselectioninput = $('#coupondiscountselectinput').val().split(",");
		if(applicableselectioninput.indexOf(value_selection) < 0){
			$('#coupondiscountselectinput').val($('#coupondiscountselectinput').val()+','+value_selection);
			$.ajax({
			type : 'POST',
			url : '<?php echo base_url();?>promo/coupon_discount_value_selection_data',
			data : {data : value_selection},
			cache : false,
			success : function(result){
				//alert(result);
				$('.coupon_discount_on_select_div').append(result);
				$('.coupon_discount_on_select_div').css('display','block');
			
			}
		});	
			}
	}
	
	
});
function selecttt(e){
	var ids = e;
	var coupondiscountselectinput = $('#coupondiscountselectinput').val();
	if(coupondiscountselectinput.includes(',') == false){
		$('#coupondiscountselectinput').val('');
		$('.coupon_discount_on_select_div').css('display','none');
		$('.applicableselectonn').remove();
	}
	else{
		coupondiscountselectinput = coupondiscountselectinput.split(',');
		var position = coupondiscountselectinput.indexOf(ids);
		coupondiscountselectinput.splice(position,1);
		var joinvalue = coupondiscountselectinput.join();
		$('#coupondiscountselectinput').val(joinvalue);
		$('#'+ids).remove();
	}
	
	
}

</script>
