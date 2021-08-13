<?php
	switch($action){
		case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
		break;
		case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
		break;
		case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
		break;
		case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
		break;
		case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
		break;
		case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
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


            <form method="post" id="data_form" class="form-horizontal" action="cost?action=<?php echo $action; ?>">
            <!--<form method="post" id="data_form" class="form-horizontal">-->

                <h5><?php echo $this->lang->line('Set') . '   ' . $lbl_name; ?></h5>
                <hr>

                				
				
                <div class="form-group row">

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
                </div>	
				
				

				<div id="subcatDiv"> </div>
				
				
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="refurbishment_cost_fixed"><?php echo $lbl_name; ?> (Type)</label>

                    <div class="col-sm-1">
						<div class="radio">
						  <label><input type="radio" value="1" name="type" id="fixed" checked> Fixed</label>
						</div>																						
					</div>
					
					<div class="col-sm-4">
						<div class="radio">
						  <label><input type="radio" value="2" name="type" id="percent"> Percent</label>
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
											   autocomplete="off" ></td>
									<td><input type="text" class="form-control req prc" name="ok_to_excellent" id="ok_to_excellent"                                           
											   autocomplete="off"></td>
									<td><input type="text" class="form-control vat " name="superb_to_excellent" id="superb_to_excellent"                                           
											   autocomplete="off"></td>
									<td><input type="text" class="form-control vat " name="excellent_to_excellent" id="excellent_to_excellent"                                           
											   autocomplete="off"></td>

								</tr>

								</tbody>
							</table>
						</div>
                    </div>
                </div>
				
				<div id="productDiv"> </div>
                
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Save') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/cost?action=<?php echo $action; ?>" id="action-url">
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