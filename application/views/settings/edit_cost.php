<?php
	/* echo "<pre>";
	print_r($record);
	echo "</pre>"; */
	
	if($type=='category'){
		$id = $record->id;
		$ctitle = '  [ Category Name - '. $record->parent_name.' ]';	
	}elseif($type=='product'){
		$id = $record->pid;
		$category_name = $record->category_name;
		$ctitle = '[ Category Name - '.$category_name . ' ]';
		$ptittle = '[ Product Name - '.$record->product_name .' ]';
	}

	switch($action){
		case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
								$cost = $record->refurbishment_cost;
								$good_to_excellent = $record->refurbishment_good_to_excellent;
								$ok_to_excellent = $record->refurbishment_ok_to_excellent;
								$superb_to_excellent = $record->refurbishment_superb_to_excellent;
								$excellent_to_excellent = $record->refurbishment_excellent_to_excellent;
								$ctype = $record->refurbishment_cost_type;
		break;
		case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
								$cost = $record->packaging_cost;
								$good_to_excellent = $record->packaging_good_to_excellent;
								$ok_to_excellent = $record->packaging_ok_to_excellent;
								$superb_to_excellent = $record->packaging_superb_to_excellent;
								$excellent_to_excellent = $record->packaging_excellent_to_excellent;
								$ctype = $record->packaging_cost_type;
		break;
		case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
								$cost = $record->sales_support;
								$good_to_excellent = $record->sales_support_good_to_excellent;
								$ok_to_excellent = $record->sales_support_ok_to_excellent;
								$superb_to_excellent = $record->sales_support_superb_to_excellent;
								$excellent_to_excellent = $record->sales_support_excellent_to_excellent;
								$ctype = $record->sales_support_type;
		break;
		case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
								$cost = $record->promotion_cost;
								$good_to_excellent = $record->promotion_good_to_excellent;
								$ok_to_excellent = $record->promotion_ok_to_excellent;
								$superb_to_excellent = $record->promotion_superb_to_excellent;
								$excellent_to_excellent = $record->promotion_excellent_to_excellent;
								$ctype = $record->promotion_cost_type;
		break;
		case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
								$cost = $record->hindizo_infra;
								$good_to_excellent = $record->hindizo_infra_good_to_excellent;
								$ok_to_excellent = $record->hindizo_infra_ok_to_excellent;
								$superb_to_excellent = $record->hindizo_infra_superb_to_excellent;
								$excellent_to_excellent = $record->hindizo_infra_excellent_to_excellent;
								$ctype = $record->hindizo_infra_type;
		break;
		case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
								$cost = $record->hindizo_margin;
								$good_to_excellent = $record->hindizo_margin_good_to_excellent;
								$ok_to_excellent = $record->hindizo_margin_ok_to_excellent;
								$superb_to_excellent = $record->hindizo_margin_superb_to_excellent;
								$excellent_to_excellent = $record->hindizo_margin_excellent_to_excellent;
								$ctype = $record->hindizo_margin_type;
		break;
	}	
?>

<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal" action="edit_cost?action=<?php echo $action; ?>&type=<?php echo $type; ?>&id=<?php echo $id; ?>">
            <!--<form method="post" id="data_form" class="form-horizontal">-->

                <h5><?php echo $this->lang->line('Set') . '   ' . $lbl_name; ?></h5>
                <hr>

                				
				
                <!--<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Category') ?></label>

                    <div class="col-sm-6">
                        <select name="cat" class="form-control" id="cat">
							<option value='' selected="" disabled=''>---Select---</option>
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row->id;
                                $title = $row->title;
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>-->
				
				

				<div id="subcatDiv"> </div>
				
				<div id="productDiv"> </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="refurbishment_cost_fixed"><?php echo $lbl_name; ?> (Type)</label>

                    <div class="col-sm-1">
						<div class="radio">
						  <label><input type="radio" value="1" name="type" id="fixed" <?php if($ctype==1){ ?> checked <?php } ?> > Fixed</label>
						</div>																						
					</div>
					
					<div class="col-sm-4">
						<div class="radio">
						  <label><input type="radio" value="2" name="type" id="percent" <?php if($ctype==2){ ?> checked <?php } ?>> Percent</label>
						</div>
					</div>
                </div>
				
				<div class="form-group row" id="fixedDiv">

                    <label class="col-sm-2 col-form-label"
                           for="refurbishment_cost_fixed" id="costlbl"><?php echo $lbl_name; ?> </label>

                    <div class="col-sm-10">
                        <!--<input type="text" placeholder="<?php echo $lbl_name; ?>" id='cost'
                               class="form-control margin-bottom required" name="cost">-->
                        <div id="saman-row">
							<table class="table-responsive tfr my_stripe">
								<thead>

								<tr class="item_header bg-gradient-directional-amber">
									
									<th width="18%" class="text-center">Good to Excellent</th>
									<th width="18%" class="text-center">Okay to Excellent</th>
									<th width="18%" class="text-center">Superb to Excellent</th>
									<th width="18%" class="text-center">Excellent to Excellent</th>
									
								</tr>
								</thead>
								<tbody>
								<tr>
									
									<td><input type="text" class="form-control req amnt" name="good_to_excellent" id="good_to_excellent"                                           
											   autocomplete="off" value="<?php echo $good_to_excellent; ?>" ></td>
									<td><input type="text" class="form-control req prc" name="ok_to_excellent" id="ok_to_excellent"                                           
											   autocomplete="off" value="<?php echo $ok_to_excellent; ?>"></td>
									<td><input type="text" class="form-control vat " name="superb_to_excellent" id="superb_to_excellent"                                           
											   autocomplete="off" value="<?php echo $superb_to_excellent; ?>"></td>
									<td><input type="text" class="form-control vat " name="excellent_to_excellent" id="excellent_to_excellent"                                           
											   autocomplete="off" value="<?php echo $excellent_to_excellent; ?>"></td>

								</tr>

								</tbody>
							</table>
						</div>
                    </div>
                </div>
                
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Save') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/edit_cost?action=<?php echo $action; ?>&type=<?php echo $type; ?>&id=<?php echo $id; ?>" id="action-url">
                    </div>
                </div>
			</form>
			
        </div>
    </div>
</article>

<script>
$('#cat').on('change',function(event){
	var id = $(this).val();
	//alert(baseurl);
	var action = '<?php echo $action; ?>';
	//alert(action);
	$.ajax({
		type : 'POST',
		url : baseurl+'productcategory/subCatDropdown',
		data : {id:id},
		cache : false,
		success : function(result){
			console.log(result);
			$('#subcatDiv').html(result);
			$.ajax({
				type : 'POST',
				url : baseurl+'productcategory/productlist',
				data : {id:id,action:action},
				cache : false,
				success : function(result){
					console.log(result);
					$('#productDiv').html(result);
				}
			});
		}
	});	
	
});

function getsubcatDropdown(id,parent_id){
	//alert(parent_id);
	var action = '<?php echo $action; ?>';
	//alert(action);
	var div_var = '#subcatDiv'+parent_id;
	$.ajax({
		type : 'POST',
		url : baseurl+'productcategory/subCatDropdown',
		data : {id:id},
		cache : false,
		success : function(result){
			console.log(result);
			$(div_var).html(result);
			$.ajax({
				type : 'POST',
				url : baseurl+'productcategory/productlist',
				data : {id:id,action:action},
				cache : false,
				success : function(result){
					console.log(result);
					$('#productDiv').html(result);
				}
			});
		}
	});
}


$('#fixed').click(function(){	
	$("#cost").attr("placeholder","<?php echo $lbl_name; ?> (Fixed)");
	$("#costlbl").html("<?php echo $lbl_name; ?> (Fixed)");
});

$('#percent').click(function(){
	$("#cost").attr("placeholder","<?php echo $lbl_name; ?> (%)");
	$("#costlbl").html("<?php echo $lbl_name; ?> (%)");
});

</script>