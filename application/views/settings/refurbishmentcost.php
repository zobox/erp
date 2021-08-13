<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Set') . '   ' . $this->lang->line('Refurbishment Cost') ?></h5>
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
				
				<div id="productDiv"> </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="refurbishment_cost_fixed"><?php echo $this->lang->line('Refurbishment Cost') ?> (Type)</label>

                    <div class="col-sm-1">
						<div class="radio">
						  <label><input type="radio" value="0" name="type" id="fixed" checked> Fixed</label>
						</div>																						
					</div>
					
					<div class="col-sm-4">
						<div class="radio">
						  <label><input type="radio" value="1" name="type" id="percent"> Percent</label>
						</div>
					</div>
                </div>
				
				<div class="form-group row" id="fixedDiv">

                    <label class="col-sm-2 col-form-label"
                           for="refurbishment_cost_fixed" id="refurbishment_costlbl"><?php echo $this->lang->line('Refurbishment Cost') ?> </label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Refurbishment Cost (Fixed)" id='refurbishment_cost'
                               class="form-control margin-bottom required" name="refurbishment_cost">
                    </div>
                </div>
				
                
				
				
				
                
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Save') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/refurbishmentcost" id="action-url">
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
				data : {id:id},
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
				data : {id:id},
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
	$("#refurbishment_cost").attr("placeholder","Refurbishment Cost (Fixed)");
	$("#refurbishment_costlbl").html("Refurbishment Cost (Fixed)");
});

$('#percent').click(function(){
	$("#refurbishment_cost").attr("placeholder","Refurbishment Cost (%)");
	$("#refurbishment_costlbl").html("Refurbishment Cost (%)");
});

</script>