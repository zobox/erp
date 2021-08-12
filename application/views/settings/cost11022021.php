<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>	
	
		<!--<form method="post" id="product_action" class="form-horizontal" action="<?php echo base_url();?>settings/updatefranchise?id=<?php $this->input->get('id', true);?>">-->
		<form method="post" id="product_action" class="form-horizontal" >
            <div class="card-body">
				
                <h5><?php echo $this->lang->line('Commission') ?> <?php echo $this->lang->line('Settings') ?></h5>
                <hr>
								
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
						
						<div style="width:20%;padding:11px 28px;">Refurbishment Cost</div>
						<div style="width:20%;padding:11px 28px;">Packaging Cost</div>
						<div style="padding:11px 28px;width:20%">After Sales Support</div>
						<div style="padding:11px 28px;width:20%">Promotion Cost</div>
						<div style="padding:11px 28px;width:20%">Hindizo Infra</div>
						<div style="padding:11px 28px;width:20%">Hindizo Margin</div>
					  </div>  
					  
					</div>
				  </div>
				</div>				

						<?php						
						foreach($cat as $key=>$cat_data){ 							
						$cat_id = $cat_data->id;							
						?>
						
						
						<div class="outer-div" style="max-width:100%;">
						  <div class="header row" style="border-top:1px solid #000;">
							<div class="col-sm-6">							  
							  <div style="padding:11px 28px;"><strong><?php echo $cat_data->title; ?></strong></div>
							 <?php if(count($cat_data->product)>0){?>
							 <strong>Product :</strong>
							 <?php } ?>
							  <?php foreach($cat_data->product as $key2=>$prod){ ?> 						
										
										<li style="display:block; padding:0px !important; margin-left: 5px;">
											<input class="subcat" type="checkbox" <?php if($scat->cost_status==1){ ?> checked <?php } ?> id="product<?php echo $cat_id; ?>" name="product[<?php echo $prod->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $prod->pid; ?>-p"> 										
											<?php echo $prod->product_name;?>
										</li>
											<ul>
											<?php if(count($prod->varient)>0){?>
											<strong>Varient :</strong>
											<?php } ?>
											<?php foreach($prod->varient as $key3=>$var){ ?> 											
											<li style="display:block; padding:0px !important; margin-left: 5px;">
												<input class="subcat" type="checkbox" <?php if($var->cost_status==1){ ?> checked <?php } ?> id="pvar<?php echo $cat_id; ?>" name="pvar[<?php echo $var->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $var->pid; ?>-v"> 										
												<?php echo $var->product_name;?>
											</li>										
											<?php } ?>	
											</ul>
							 <?php } ?>
							  
							  <div style="padding:11px 28px;">
								<span >                                   
								   <?php
								   foreach($catcommision[$cat_id]['child'] as $scat){ ?>
									<ul style="display:block; padding:0px !important; margin-left: 5px;">
									<input class="subcat" type="checkbox" <?php if($scat->cost_status==1){ ?> checked <?php } ?> id="subcat<?php echo $cat_id; ?>" name="subcat[<?php echo $scat->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $scat->id; ?>-s"> 
									<?php echo $scat->title;?>
										<br>
										<?php if(count($scat->product)>0){?>
										<strong>Product :</strong>
										<?php } ?>
										<?php foreach($scat->product as $key2=>$prod){ ?> 
										<li style="display:block; padding:0px !important; margin-left: 5px;">
											<input class="subcat" type="checkbox" <?php if($prod->cost_status==1){ ?> checked <?php } ?> id="product<?php echo $cat_id; ?>" name="product[<?php echo $prod->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $prod->pid; ?>-p"> 										
											<?php echo $prod->product_name;?>
										</li>
											<ul>
											<?php if(count($prod->varient)>0){?>
											<strong>Varient :</strong>
											<?php } ?>
											<?php foreach($prod->varient as $key3=>$var){ ?> 
											<li style="display:block; padding:0px !important; margin-left: 5px;">
												<input class="subcat" type="checkbox" <?php if($var->cost_status==1){ ?> checked <?php } ?> id="pvar<?php echo $cat_id; ?>" name="pvar[<?php echo $var->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $var->pid; ?>-v"> 										
												<?php echo $var->product_name;?>
											</li>										
											<?php } ?>	
											</ul>
										<?php } ?>
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
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="refurbishment_cost['c'][<?php echo $cat_id; ?>]" id="refurbishment_cost['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->refurbishment_cost; ?>"></div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="packaging_cost['c'][<?php echo $cat_id; ?>]" id="packaging_cost['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->packaging_cost; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="sales_support['c'][<?php echo $cat_id; ?>]" id="sales_support['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->sales_support; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="promotion_cost['c'][<?php echo $cat_id; ?>]" id="promotion_cost['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->promotion_cost; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="hindizo_infra['c'][<?php echo $cat_id; ?>]" id="hindizo_infra['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->hindizo_infra; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="hindizo_margin['c'][<?php echo $cat_id; ?>]" id="hindizo_margin['c'][<?php echo $cat_id; ?>]" value="<?php echo $catcommision[$cat_id][1]->hindizo_margin; ?>"></div>
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
                        <input type="submit" id="cost_settings" class="btn btn-success margin-bottom"
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
			if($value->cost_status==1){
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
			$output .='-s"> '; 
            $output .= $value->title;			
			$output .="</li>";
			
            $output .= "<li>".sub_print($value->child,$cat_id)."</li>";
        } else {
            $output .= "<li>";
			$output .='<input class="subcat" type="checkbox"'; 
			if($value->cost_status==1){
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
			$output .='-s"> '; 
            $output .= $value->title;			
			$output .="</li>";
        }
    }
    $output .= "</ul>";
    return $output;
}

?>

<script type="text/javascript">
    $("#cost_settings").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/savecost';
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
			url : url+"settings/getSubcostAjaxData",
			data : {id:ids[1],type:ids[2]},
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
	
	
	/* $(window).ready(function(){
		
		$('input[type="checkbox"]:checked').each(function() {
			var id = $(this).val();
			//alert(123);
			var ids = id.split('-');
			//alert(ids[1]);
			var scommision_var = '#scommision'+ids[0];
			var url = baseurl;
			$.ajax({
			type : 'POST',
			url : url+"settings/getSubcostAjaxData",
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
	}); */
</script>
