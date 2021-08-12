<?php 
/* echo "<pre>";
print_r($catcommision); */

foreach($catcommision as $key=>$scat){  
if($type=='s'){
	$id = $scat['cat']->id; 
	$title = $scat['cat']->title;
}else{
	$id = $scat['cat']->pid; 
	$title = $scat['cat']->product_name;
}

?>
											
						  <div class="header row" id="apendtbl<?php echo $id; ?>" style="border-top:1px solid orange; max-width:100%;">
							<div class="col-sm-6">
							  <div style="padding:11px 28px;"><?php echo $title; ?></div>
							  <input type="hidden" name="apend" id="apend<?php echo $id; ?>" value="<?php echo $id; ?>">
							  <div style="padding:11px 28px;">
								
							  </div>
							  
							  
							  
							</div>
							<div class="col-sm-6">
							  <div class="d-flex align-items-center" style="width:100%;">
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="refurbishment_cost[<?php echo $type; ?>][<?php echo $id; ?>]" id="refurbishment_cost[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->refurbishment_cost; ?>"></div>
								<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="packaging_cost[<?php echo $type; ?>][<?php echo $id; ?>]" id="packaging_cost[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->packaging_cost; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="sales_support[<?php echo $type; ?>][<?php echo $id; ?>]" id="sales_support[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->sales_support; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="promotion_cost[<?php echo $type; ?>][<?php echo $id; ?>]" id="promotion_cost[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->promotion_cost; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="hindizo_infra[<?php echo $type; ?>][<?php echo $id; ?>]" id="hindizo_infra[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->hindizo_infra; ?>"></div>
								<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="hindizo_margin[<?php echo $type; ?>][<?php echo $id; ?>]" id="hindizo_margin[<?php echo $type; ?>][<?php echo $id; ?>]" value="<?php echo $catcommision[$cat_id][1]->hindizo_margin; ?>"></div>
							  </div>							  
							</div>
						  </div>
						
						
						<?php } ?>