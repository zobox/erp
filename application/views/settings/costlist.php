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
<div class="content-body">
    
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Products') ?> <a
                        href="<?php echo base_url('settings/cost?action='.$action) ?>"
                        class="btn btn-info rounded small-button">
                    <?php echo $this->lang->line('Set Cost') ?>
                </a> 
				<a
                        href="<?php echo base_url('settings/cost_excel?action='.$action) ?>"
                        class="btn btn-success rounded small-button">
                    <?php echo $this->lang->line('Download Excel') ?>
                </a>	
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
			<hr>
            <div class="card-body">


                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <!--<tr>
                        <th>#</th>
						<th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Product Name') ?></th>
						<th><?php echo $this->lang->line($lbl_name) ?></th>                        
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>-->
                    <tr>
                    	<th>Category</th>
                    	<th>Brand </th>
                    	<th>Product </th>                    	
                    	<th>Good to Excellent</th>
                    	<th>Okay to Excellent</th>
                    	<th>Superb to Excellent</th>
                    	<th>Excellent to Excellent</th>
                    	<th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 					
					/* echo "<pre>";
					print_r($cat);
					echo "</pre>"; */
					
					foreach($cat as $key=>$crow){ 
					
						switch($action){
							case 'refurbishment' : $cost = $crow->refurbishment_cost; 
												   $good_to_excellent = $crow->refurbishment_good_to_excellent;
												   $ok_to_excellent = $crow->refurbishment_ok_to_excellent;
												   $superb_to_excellent = $crow->refurbishment_superb_to_excellent;
												   $excellent_to_excellent = $crow->refurbishment_excellent_to_excellent;
												   $type= $crow->refurbishment_cost_type;
							break;
							case 'packaging' : $cost = $crow->packaging_cost; 
											   $good_to_excellent = $crow->packaging_good_to_excellent;
											   $ok_to_excellent = $crow->packaging_ok_to_excellent;
											   $superb_to_excellent = $crow->packaging_superb_to_excellent;
											   $excellent_to_excellent = $crow->packaging_excellent_to_excellent;
											   $type= $crow->packaging_cost_type;
							break;
							case 'salessupport' : 	$cost = $crow->sales_support; 
													$good_to_excellent = $crow->sales_support_good_to_excellent;
													$ok_to_excellent = $crow->sales_support_ok_to_excellent;
													$superb_to_excellent = $crow->sales_support_superb_to_excellent;
													$excellent_to_excellent = $crow->sales_support_excellent_to_excellent;
													$type= $crow->sales_support_type;
							break;
							case 'promotion' : 	$cost = $crow->promotion_cost;
												$good_to_excellent = $crow->promotion_good_to_excellent;
												$ok_to_excellent = $crow->promotion_ok_to_excellent;
												$superb_to_excellent = $crow->promotion_superb_to_excellent;
												$excellent_to_excellent = $crow->promotion_excellent_to_excellent;
												$type= $crow->promotion_cost_type;
							break;
							case 'infra' : 	$cost = $crow->hindizo_infra; 
											$good_to_excellent = $crow->hindizo_infra_good_to_excellent;
											$ok_to_excellent = $crow->hindizo_infra_ok_to_excellent;
											$superb_to_excellent = $crow->hindizo_infra_superb_to_excellent;
											$excellent_to_excellent = $crow->hindizo_infra_excellent_to_excellent;
											$type= $crow->hindizo_infra_type;
							break;
							case 'margin' : $cost = $crow->hindizo_margin; 
											$good_to_excellent = $crow->hindizo_margin_good_to_excellent;
											$ok_to_excellent = $crow->hindizo_margin_ok_to_excellent;
											$superb_to_excellent = $crow->hindizo_margin_superb_to_excellent;
											$excellent_to_excellent = $crow->hindizo_margin_excellent_to_excellent;
											$type= $crow->hindizo_margin_type;
							break;
						}
					?>
					<tr>
						<td><?php echo $crow->parent_name; ?></td>
						<td></td>
                        <td><?php //echo $prow->product_name; ?></td>						
                        <td><?php echo floatval($good_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($ok_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($superb_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($excellent_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td>
						<a href="<?php echo base_url('settings/edit_cost?action='.$action.'&type=category&id='.$crow->id) ?>" class="btn btn-warning btn-xs"><i class='fa fa-pencil'></i>
								<?php echo $this->lang->line('Edit') ?></a>
						</td>
					</tr>
					
					<?php foreach($crow->products as $key=>$prow){ 
							/* switch($action){
								case 'refurbishment' : $cost = $prow->refurbishment_cost; $type= $prow->refurbishment_cost_type;
								break;
								case 'packaging' : $cost = $prow->packaging_cost; $type= $prow->packaging_cost_type;
								break;
								case 'salessupport' : $cost = $prow->sales_support; $type= $prow->sales_support_type;
								break;
								case 'promotion' : $cost = $prow->promotion_cost; $type= $prow->promotion_cost_type;
								break;
								case 'infra' : $cost = $prow->hindizo_infra; $type= $prow->hindizo_infra_type;
								break;
								case 'margin' : $cost = $prow->hindizo_margin; $type= $prow->hindizo_margin_type;
								break;
							} */

							switch($action){
								case 'refurbishment' : $cost = $prow->refurbishment_cost; 
													   $good_to_excellent = $prow->refurbishment_good_to_excellent;
													   $ok_to_excellent = $prow->refurbishment_ok_to_excellent;
													   $superb_to_excellent = $prow->refurbishment_superb_to_excellent;
													   $excellent_to_excellent = $prow->refurbishment_excellent_to_excellent;
													   $type= $prow->refurbishment_cost_type;
								break;
								case 'packaging' : $cost = $prow->packaging_cost; 
												   $good_to_excellent = $prow->packaging_good_to_excellent;
												   $ok_to_excellent = $prow->packaging_ok_to_excellent;
												   $superb_to_excellent = $prow->packaging_superb_to_excellent;
												   $excellent_to_excellent = $prow->packaging_excellent_to_excellent;
												   $type= $prow->packaging_cost_type;
								break;
								case 'salessupport' : 	$cost = $prow->sales_support; 
														$good_to_excellent = $prow->sales_support_good_to_excellent;
														$ok_to_excellent = $prow->sales_support_ok_to_excellent;
														$superb_to_excellent = $prow->sales_support_superb_to_excellent;
														$excellent_to_excellent = $prow->sales_support_excellent_to_excellent;
														$type= $prow->sales_support_type;
								break;
								case 'promotion' : 	$cost = $prow->promotion_cost;
													$good_to_excellent = $prow->promotion_good_to_excellent;
													$ok_to_excellent = $prow->promotion_ok_to_excellent;
													$superb_to_excellent = $prow->promotion_superb_to_excellent;
													$excellent_to_excellent = $prow->promotion_excellent_to_excellent;
													$type= $prow->promotion_cost_type;
								break;
								case 'infra' : 	$cost = $prow->hindizo_infra; 
												$good_to_excellent = $prow->hindizo_infra_good_to_excellent;
												$ok_to_excellent = $prow->hindizo_infra_ok_to_excellent;
												$superb_to_excellent = $prow->hindizo_infra_superb_to_excellent;
												$excellent_to_excellent = $prow->hindizo_infra_excellent_to_excellent;
												$type= $prow->hindizo_infra_type;
								break;
								case 'margin' : $cost = $prow->hindizo_margin; 
												$good_to_excellent = $prow->hindizo_margin_good_to_excellent;
												$ok_to_excellent = $prow->hindizo_margin_ok_to_excellent;
												$superb_to_excellent = $prow->hindizo_margin_superb_to_excellent;
												$excellent_to_excellent = $prow->hindizo_margin_excellent_to_excellent;
												$type= $prow->hindizo_margin_type;
								break;
							}
					?>
					<tr>
						<td><?php echo $prow->category_name; ?></td>
						<td><?php echo $prow->brand_name; ?></td>
                        <td><?php echo $prow->product_name; ?></td>						
                        <td><?php echo floatval($good_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($ok_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($superb_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><?php echo floatval($excellent_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td>
						<a href="<?php echo base_url('settings/edit_cost?action='.$action.'&type=product&id='.$prow->pid) ?>" class="btn btn-warning btn-xs"><i class='fa fa-pencil'></i>
								<?php echo $this->lang->line('Edit') ?></a>
						</td>
					</tr>				
					<?php } ?>
					<?php } ?>					
					
                    </tbody>
					<tfoot>
					<tr>
                    	<th>Category</th>
                    	<th>Brand </th>
                    	<th>Product </th>                    	
                    	<th>Good to Excellent</th>
                    	<th>Okay to Excellent</th>
                    	<th>Superb to Excellent</th>
                    	<th>Excellent to Excellent</th>
                    	<th>Action</th>
                    </tr>
					</tfoot>
                    
                </table>

            </div>            
        </div>
        <script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#cgrtable').DataTable({responsive: true});
        });
    </script>