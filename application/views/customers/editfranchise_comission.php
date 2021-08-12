<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>	
	
		<!--<form method="post" id="product_action" class="form-horizontal" action="<?php echo base_url();?>settings/updatefranchise?id=<?php $this->input->get('id', true);?>">-->
		<form method="post" id="product_action" class="form-horizontal" >
            <div class="card-body">
				
                <h5><?php echo $this->lang->line('Franchise') ?> <?php echo $this->lang->line('Settings') ?></h5>
                <hr>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="module"><?php echo $this->lang->line('Module') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Module" 
							class="form-control margin-bottom b_input required" name="module"
							id="module" value="<?php echo $franchise['module'] ?>">
                    </div>					
                </div>
				
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="space_required"><?php echo $this->lang->line('Space Required') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Space Required" 
							class="form-control margin-bottom b_input required" name="space_required"
							id="space_required" value="<?php echo $franchise['space_required'] ?>" >
                    </div>					
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="total_refundable"><?php echo $this->lang->line('Total Refundable') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Total Refundable" 
							class="form-control margin-bottom b_input required" name="total_refundable"
							id="total_refundable" value="<?php echo $franchise['total_refundable'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="franchise_fee"><?php echo $this->lang->line('Franchise Fee') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Franchise Fee" 
							class="form-control margin-bottom b_input required" name="franchise_fee"
							id="franchise_fee" value="<?php echo $franchise['franchise_fee'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="Infra_and_branding_cost"><?php echo $this->lang->line('Infra and Branding Cost') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Infra and Branding Cost" 
							class="form-control margin-bottom b_input required" name="Infra_and_branding_cost"
							id="Infra_and_branding_cost" value="<?php echo $franchise['Infra_and_branding_cost'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="total_non_refundable"><?php echo $this->lang->line('Total Non Refundable') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Total Non Refundable" 
							class="form-control margin-bottom b_input required" name="total_non_refundable"
							id="total_non_refundable" value="<?php echo $franchise['total_non_refundable'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="interest_on_security_deposite"><?php echo $this->lang->line('Interest on Security Deposite') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Interest on Security Deposite" 
							class="form-control margin-bottom b_input required" name="interest_on_security_deposite"
							id="interest_on_security_deposite" value="<?php echo $franchise['interest_on_security_deposite'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="interest_on_security_deposite_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="Start Date" 
							class="form-control margin-bottom b_input required" name="interest_on_security_deposite_st_dt"
							id="interest_on_security_deposite_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['interest_on_security_deposite_st_dt'])); ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="interest_on_security_deposite_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="End Date" 
							class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt"
							id="interest_on_security_deposite_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['interest_on_security_deposite_end_dt'])); ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="mg"><?php echo $this->lang->line('MG') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="MG" 
							class="form-control margin-bottom b_input required" name="mg"
							id="mg" value="<?php echo $franchise['mg'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="mg_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="Start Date" 
							class="form-control margin-bottom b_input required" name="mg_st_dt"
							id="mg_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['mg_st_dt'])); ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="mg_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="End Date" 
							class="form-control margin-bottom b_input required" name="mg_end_dt"
							id="mg_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['mg_end_dt'])); ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="salary_paid_by_zobox"><?php echo $this->lang->line('Salary Paid By Zobox') ?> </label>
                    <div class="col-sm-6">
						<input type="text" placeholder="Salary Paid By Zobox" 
							class="form-control margin-bottom b_input required" name="salary_paid_by_zobox"
							id="salary_paid_by_zobox" value="<?php echo $franchise['salary_paid_by_zobox'] ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="salary_paid_by_zobox_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="Start Date" 
							class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_st_dt"
							id="salary_paid_by_zobox_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['salary_paid_by_zobox_st_dt'])); ?>" >
                    </div>					
                </div>
				
				<div class="form-group row">
                    <label class="col-sm-4 col-form-label"
                           for="salary_paid_by_zobox_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
                    <div class="col-sm-6">
						<input type="date" placeholder="End Date" 
							class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_end_dt"
							id="salary_paid_by_zobox_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['salary_paid_by_zobox_end_dt'])); ?>" >
                    </div>					
                </div>	
				
				
				<h4><strong><?php echo $this->lang->line('Category') ?></strong></h4>
                <hr>
				
				<div class="form-group row table table-responsive">
										
				<div class="outer-div" style="border-bottom:1px solid #ddd;;max-width:100%;">
				  <div class="header row">
					<div class="col-sm-6">
					  <div style="padding:11px 28px;">CATEGORY</div>
					</div>
					<div class="col-sm-6">
					  <div class="d-flex align-items-center" style="width:100%;">
						<div style="width:20%;padding:11px 28px;">Purpose</div>
						<div style="width:20%;padding:11px 28px;">Retail</div>
						<div style="width:20%;padding:11px 28px;">B2C</div>
						<div style="padding:11px 28px;width:20%">Bulk</div>
						<div style="padding:11px 28px;width:20%">Renting</div>
					  </div>
					  
					  
					</div>
				  </div>
				</div>
					
					

						<?php 
							/* echo "<pre>";
							print_r(json_decode(json_encode($catcommision),true));
							echo "</pre>"; 	 */				
							
						foreach($cat as $key=>$cat_data){ 							
						$cat_id = $cat_data->id;							
						?>
						
						
						<div class="outer-div" style="max-width:100%;">
						  <div class="header row" style="border-top:1px solid #000;">
							<div class="col-sm-6">
							  <div style="padding:11px 28px;"><?php echo $cat_data->title; ?></div>
							  
							  <div style="padding:11px 28px;">
								<span >                                   
								   <?php foreach($catcommision[$cat_id]['child'] as $scat){ ?>
									<ul style="display:block; padding:0px !important; margin-left: 5px;">
									<input class="subcat" type="checkbox" <?php if($scat->commission_status==1){ ?> checked <?php } ?> id="subcat<?php echo $cat_id; ?>" name="subcat[<?php echo $scat->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $scat->id; ?>"> 
									<?php echo $scat->title;?>
										<?php 
										if(is_array($scat->child)){
											echo sub_print($scat->child,$cat_id);
										}
										?>
									<?php }?>
									</ul>
								   								
                                </span>	
							  </div>
							  
							</div>
							<div class="col-sm-6">
							  <div class="d-flex align-items-center" style="width:100%;">
								<div style="width:20%;padding:11px 28px;">Buying</div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][1]" id="retail[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->retail_commision_percentage; ?>"></div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][1]" id="b2c[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->b2c_comission_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][1]" id="bulk[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->bulk_commision_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][1]" id="renting[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->renting_commision_percentage; ?>"></div>
							  </div>
							  <div class="d-flex align-items-center" style="width:100%;">
								<div style="width:20%;padding:11px 28px;">Selling</div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][2]" id="retail[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->retail_commision_percentage; ?>"></div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][2]" id="b2c[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->b2c_comission_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][2]" id="bulk[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->bulk_commision_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][2]" id="renting[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->renting_commision_percentage; ?>"></div>
							  </div>
							  <div class="d-flex align-items-center" style="width:100%;">
								<div style="width:20%;padding:11px 28px;">Exchange</div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][3]" id="retail[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->retail_commision_percentage; ?>"></div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][3]" id="b2c[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->b2c_comission_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][3]" id="bulk[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->bulk_commision_percentage; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][3]" id="renting[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->renting_commision_percentage; ?>"></div>
							  </div>
							  
							</div>
						  </div>
						  
						<?php foreach($catcommision[$cat_id]['child'] as $scat){ 
						$scat_id = $scat->id;
						?>
						<!--<tbody style="display:none" id="scommision<?php echo $scat_id; ?>"></tbody>-->
						<div style="display:none" id="scommision<?php echo $scat_id; ?>"></div>
						<?php }?>
						<!--<tbody style="display:none" id="scommision<?php echo $cat_id; ?>"></tbody>-->				
						<div style="display:none" id="scommision<?php echo $cat_id; ?>"></div>	
						<?php } ?>				  
						  
						</div>	
				
				</div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="franchise_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>
				<?php $id = $this->input->get('id', true); ?>
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            </div>
			
        </form>
    </div>

</article>

<?php
function subcat_print($array,$cat_id) {
    $output = "<ol style='padding:0px !important; margin-left: 10px;'>";
    foreach ($array as $value) {
        if (is_array($value->child)) {
            $output .= '<ul style="display:block; padding:0px !important; margin-left: 5px;">';
				$output .= subcat_print($value->child,$cat_id);
			$output .= "</ul>";	
        } else {
			$output .='<input type="checkbox" id="subcat';
			$output .=$cat_id; 
			$output .='" name="subcat';
			$output .=$cat_id;
			$output .='" value="';
			$output .=$value->id; 
			$output .='">'; 
            $output .= $value->title;
        }		
    }
    $output .= "</ol>";				
    return $output;
}


function sub_print($array,$cat_id) {
    $output = "<ul style='list-style:none;'>";
    foreach ($array as $value) {
        if (is_array($value->child)) {
			$output .= "<li>";
			$output .='<input class="subcat" type="checkbox" ';
			if($value->commission_status==1){
				$output .='checked ';
			}
			$output .='id="subcat';
			$output .=$cat_id; 
			$output .='" name="subcat[';
			$output .=$value->id;
			$output .=']" value="';
			$output .=$cat_id; 
			$output .='-'; 
			$output .=$value->id; 
			$output .='"> '; 
            $output .= $value->title;			
			$output .="</li>";
			
            $output .= "<li>".sub_print($value->child,$cat_id)."</li>";
        } else {
            $output .= "<li>";
			$output .='<input class="subcat" type="checkbox"'; 
			if($value->commission_status==1){
				$output .='checked ';
			}
			$output .='id="subcat';			
			$output .=$cat_id; 
			$output .='" name="subcat[';
			$output .=$value->id;
			$output .=']" value="';
			$output .=$cat_id; 
			$output .='-'; 
			$output .=$value->id; 
			$output .='"> '; 
            $output .= $value->title;			
			$output .="</li>";
        }
    }
    $output .= "</ul>";
    return $output;
}

?>

<script type="text/javascript">
    $("#franchise_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/updatefranchise';
        actionProduct(actionurl);
		console.log(actionurl);
		
    });
	
	
	$(".subcat").click(function (e) {
        var id = $(this).val();
       
		var apend_val = 0;
		var ids = id.split('-');
		var apend_var = '#apend'+ids[1];
		var apendtbl_var = '#apendtbl'+ids[1];
		if($(apend_var).val()){
		var apend_val = $(apend_var).val();
		}
		var scommision_var = '#scommision'+ids[0];
		//var scommision_var = '#scommision';		
		var url = baseurl;
		//alert(apendtbl_var);
		if(apend_val==0){
		$.ajax({
			type : 'POST',
			url : url+"settings/getSubcatAjaxData",
			data : {categoryId:ids[1],moduleid:<?php echo $this->input->get('id', true);?>},
			cache : false,
			success : function(result)
				{
					console.log(result);
					$(scommision_var).css("display","block");
					$(scommision_var).append(result);
				}
			});
		}else{
			//$(scommision_var).css("display","none");
			$(apendtbl_var).remove();
		}
    });
	
	
	$(window).ready(function(){
		
		$('input[type="checkbox"]:checked').each(function() {
			var id = $(this).val();
			//alert(123);
			var ids = id.split('-');
			//alert(ids[1]);
			var scommision_var = '#scommision'+ids[0];
			var url = baseurl;
			$.ajax({
			type : 'POST',
			url : url+"settings/getSubcatAjaxData",
			data : {categoryId:ids[1],moduleid:<?php echo $this->input->get('id', true);?>},
			cache : false,
			success : function(result)
				{					
					//console.log('hi');
					$(scommision_var).css("display","block");
					$(scommision_var).append(result);
				}
			});
			
		});
	});
</script>
