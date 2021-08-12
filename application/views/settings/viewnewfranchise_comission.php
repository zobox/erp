<?php 
/* echo "<pre>";
print_r($franchise); 
echo "</pre>";  */

?>

<article class="content-body">
	<div class="card card-block">
		<div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
		<!--<form method="post" id="product_action" class="form-horizontal" action="<?php echo base_url();?>settings/updatefranchise?id=<?php $this->input->get('id', true);?>">-->
		<form method="post" id="product_action" class="form-horizontal">
			<div class="card-body">
				<h5>Franchise Commission Settings</h5>
				<hr>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="module">
								<?php echo $this->lang->line('Module') ?>
							</label>
							<div class="col-sm-6">
								<input type="hidden" placeholder="Module" class="form-control margin-bottom b_input required" name="module" id="module" value="<?php echo $franchise['module']; ?>"> <strong><?php 
											switch($franchise['module']){
												case 1: $module = 'Enterprise';
												break;
												case 2: $module = 'Professional';
												break;
												case 3: $module = 'Standard';
												break;
											}
											echo $module;
										?></strong> </div>
						</div>
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="total_refundable">
								<?php echo $this->lang->line('Total Refundable') ?>
							</label>
							<div class="col-sm-6">
								<input type="text" placeholder="Total Refundable" class="form-control margin-bottom b_input required" name="total_refundable" id="total_refundable" value="<?php echo $franchise['total_refundable'] ?>"> </div>
						</div>
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="Infra_and_branding_cost">
								<?php echo $this->lang->line('Infra and Branding Cost') ?>
							</label>
							<div class="col-sm-6">
								<input type="text" placeholder="Infra and Branding Cost" class="form-control margin-bottom b_input required" name="Infra_and_branding_cost" id="Infra_and_branding_cost" value="<?php echo $franchise['Infra_and_branding_cost'] ?>"> </div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="space_required">
								<?php echo $this->lang->line('Space Required') ?>
							</label>
							<div class="col-sm-6">
								<input type="text" placeholder="Space Required" class="form-control margin-bottom b_input required" name="space_required" id="space_required" value="<?php echo $franchise['space_required'] ?>"> </div>
						</div>
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="franchise_fee">
								<?php echo $this->lang->line('Franchise Fee') ?>
							</label>
							<div class="col-sm-6">
								<input type="text" placeholder="Franchise Fee" class="form-control margin-bottom b_input required" name="franchise_fee" id="franchise_fee" value="<?php echo $franchise['franchise_fee'] ?>"> </div>
						</div>
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="total_non_refundable">
								<?php echo $this->lang->line('Total Non Refundable') ?>
							</label>
							<div class="col-sm-6">
								<input type="text" placeholder="Total Non Refundable" class="form-control margin-bottom b_input required" name="total_non_refundable" id="total_non_refundable" value="<?php echo $franchise['total_non_refundable'] ?>"> </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="interest_on_security_deposite">
								<?php echo $this->lang->line('Interest on Security Deposite') ?>
							</label>
							<div class="col-sm-6">
								<select name="interest_on_security_deposite_status" id="interest_on_security_deposite_status" class="form-control margin-bottom rqty required" required="">
									<option value=""> select </option>
									<option value="1" <?php if($franchise[ 'interest_on_security_deposite_status']==1){ echo 'Selected=selected'; }?>>Yes </option>
									<option value="2" <?php if($franchise[ 'interest_on_security_deposite_status']==2){ 'Selected=selected'; }?>> No </option>
								</select>
							</div>
						</div>
					</div>
					<div id="yes_option1" style="display:none">
						<div class="col-sm-2">
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="text" placeholder="Add Value" class="form-control margin-bottom b_input required" name="interest_on_security_deposite" id="interest_on_security_deposite" value="<?php echo $franchise['interest_on_security_deposite'] ?>"> </div>
							</div>
						</div>
						<div class="col-sm-2">
							<input type="date" placeholder="Start Date" class="form-control margin-bottom b_input required" name="interest_on_security_deposite_st_dt" id="interest_on_security_deposite_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['interest_on_security_deposite_st_dt'])); ?>"> </div>
						<div class="col-sm-2">
							<input type="date" placeholder="Start Date" class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt" id="interest_on_security_deposite_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['interest_on_security_deposite_end_dt'])); ?>"> </div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="mg">
								<?php echo $this->lang->line('MG') ?>
							</label>
							<div class="col-sm-6">
								<select name="mg_status" id="mg_status" class="form-control margin-bottom rqty required" required="">
									<option value=""> select </option>
									<option value="1" <?php if($franchise[ 'mg_status']==1){ echo 'Selected=selected'; }?>> Yes </option>
									<option value="2" <?php if($franchise[ 'mg_status']==2){ echo 'Selected=selected'; }?>> No </option>
								</select>
							</div>
						</div>
					</div>
					<div id="yes_option" style="display:none">
						<div class="col-sm-2">
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="text" placeholder="Add Value" class="form-control margin-bottom b_input required" name="mg" id="mg" value="<?php echo $franchise['mg'] ?>"> </div>
							</div>
						</div>
						<div class="col-sm-2">
							<input type="date" placeholder="Start Date" class="form-control margin-bottom b_input required" name="mg_st_dt" id="mg_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['mg_st_dt'])); ?>"> </div>
						<div class="col-sm-2">
							<input type="date" placeholder="End Date" class="form-control margin-bottom b_input required" name="mg_end_dt" id="mg_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['mg_end_dt'])); ?>"> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-6 col-form-label" for="salary_paid_by_zobox">
								<?php echo $this->lang->line('Salary Paid By Zobox') ?>
							</label>
							<div class="col-sm-6">
								<select name="salary_paid_by_zobox_status" id="salary_paid_by_zobox_status" class="form-control margin-bottom rqty required" required="">
									<option value=""> select </option>
									<option value="1" <?php if($franchise[ 'salary_paid_by_zobox_status']==1){ echo 'Selected=selected'; }?>> Yes </option>
									<option value="2" <?php if($franchise[ 'salary_paid_by_zobox_status']==2){ echo 'Selected=selected'; }?>> No </option>
								</select>
							</div>
						</div>
					</div>
					<div id="yes_option2" style="display:none">
						<div class="col-sm-2">
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="text" placeholder="Salary Paid By Zobox" class="form-control margin-bottom b_input required" name="salary_paid_by_zobox" id="salary_paid_by_zobox" value="<?php echo $franchise['salary_paid_by_zobox'] ?>"> </div>
							</div>
						</div>
						<div class="col-sm-2">
							<input type="date" placeholder="Start Date" class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_st_dt" id="salary_paid_by_zobox_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise['salary_paid_by_zobox_st_dt'])); ?>"> </div>
						<div class="col-sm-2">
							<input type="date" placeholder="End Date" class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_end_dt" id="salary_paid_by_zobox_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise['salary_paid_by_zobox_end_dt'])); ?>"> </div>
					</div>
				</div>
				<hr>
				<div class="card-body"> <a href="add_data?id=<?php echo $franchise['module']; ?>" class="btn btn-primary btn-xl sr mb-1">Add Data</a>
					<table id="cgrtable" class="table table-striped table-bordered zero-configuration table-responsive" cellspacing="0" style="border:none;">
						<thead>
							<tr>
								<th>#</th>
								<th style="width: 240px;">Category</th>
								<th style="width: 210px;">Sub Category</th>
								<th style="width: 210px;">Sub-Sub Category</th>
								<th style="width: 210px;">Purpose</th>
								<th style="width: 90px;">Zo Retail (%)</th>
								<th style="width: 90px;">Zo Bulk (%)</th>
								<th style="width: 90px;">B2C (%)</th>
								<th style="width: 90px;">Renting (%)</th>
								<th>Action</th1>
							</tr>
						</thead>
						
						<tbody>
							<?php 
									/* echo "<pre>";
									print_r($cat); 
									echo "</pre>";  */
							$i=1;
							$module_id = $this->input->get('id');							
							foreach($cat as $key=>$cat_data){ 
							$cat_id = $cat_data['cat']->id;
							
							?>
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td></td>
								<td></td>
								<td>Buying</td>
								<td><?php echo $catcommision[$cat_id][1]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][1]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][1]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][1]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&purpose=1&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="javascript:void(0)" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $cat_id; ?>,1,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td></td>
								<td></td>
								<td>Selling</td>
								<td><?php echo $catcommision[$cat_id][2]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][2]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][2]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][2]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&purpose=2&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $cat_id; ?>,2,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td></td>
								<td></td>
								<td>Exchange</td>
								<td><?php echo $catcommision[$cat_id][3]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][3]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][3]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$cat_id][3]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&purpose=3&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $cat_id; ?>,3,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<?php 
							if(is_array($cat_data['subcat'])){								
							foreach($cat_data['subcat'] as $key1=>$subcat_data){ ?>							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td></td>
								<td>Buying</td>
								<td><?php echo $catcommision[$subcat_data->id][1]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][1]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][1]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][1]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&purpose=1&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subcat_data->id; ?>,1,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td></td>
								<td>Selling</td>
								<td><?php echo $catcommision[$subcat_data->id][2]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][2]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][2]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][2]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&purpose=2&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subcat_data->id; ?>,2,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td></td>
								<td>Exchange</td>
								<td><?php echo $catcommision[$subcat_data->id][3]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][3]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][3]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subcat_data->id][3]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&purpose=3&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subcat_data->id; ?>,3,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>	
							
							
							<?php 
							if(is_array($cat_data['subsubcat'][$subcat_data->id])){								
							foreach($cat_data['subsubcat'][$subcat_data->id] as $key2=>$subsubcat_data){ ?>
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td><?php  echo $subsubcat_data->name; ?></td>
								<td>Buying</td>
								<td><?php echo $catcommision[$subsubcat_data->id][1]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][1]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][1]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][1]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&subsubcat=<?php echo $subsubcat_data->id; ?>&purpose=1&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subsubcat_data->id; ?>,1,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td><?php  echo $subsubcat_data->name; ?></td>
								<td>Selling</td>
								<td><?php echo $catcommision[$subsubcat_data->id][2]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][2]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][2]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][2]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&subsubcat=<?php echo $subsubcat_data->id; ?>&purpose=2&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="#" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subsubcat_data->id; ?>,2,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							
							<tr>
								<td><?php  echo $i; $i++;?></td>
								<td><?php  echo $cat_data['cat']->title; ?></td>
								<td><?php  echo $subcat_data->name; ?></td>
								<td><?php  echo $subsubcat_data->name; ?></td>
								<td>Exchange</td>
								<td><?php echo $catcommision[$subsubcat_data->id][3]->retail_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][3]->bulk_commision_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][3]->b2c_comission_percentage; ?></td>
								<td><?php echo $catcommision[$subsubcat_data->id][3]->renting_commision_percentage; ?></td>
								<td>
								<a href="edit_data?cat_id=<?php echo $cat_id; ?>&subcat=<?php echo $subcat_data->id; ?>&subsubcat=<?php echo $subsubcat_data->id; ?>&purpose=3&franchise_id=0&module_id=<?php echo $module_id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								<a href="javascript:void(0)" class="btn btn-danger btn-sm  delete-object" onClick="deleteCommission(<?php echo $subsubcat_data->id; ?>,3,0,<?php echo $module_id; ?>);"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
							<?php }	} ?>							
							
							<?php }	} ?>
							
							<?php }  ?>							
							
						</tbody>
						
						<tfoot>
							<tr>
								<tr>
									<th>#</th>
									<th>Category</th>
									<th>Sub Category</th>
									<th>Sub-Sub Category</th>
									<th>Purpose</th>
									<th>Zo Retail (%)</th>
									<th>Zo Bulk (%)</th>
									<th>B2C (%)</th>
									<th>Renting (%)</th>
									<th>Action</th>
								</tr>
						</tfoot>
					</table>
				</div>
				<hr>
				<?php 
							/* echo "<pre>";
							print_r(json_decode(json_encode($catcommision),true));
							echo "</pre>"; 	 */				
							
						foreach($cat as $key=>$cat_data){ 							
						$cat_id = $cat_data->id;							
						?>
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
		<label class="col-sm-5 col-form-label"></label>
		<div class="col-sm-2 text-center mt-3">
			<input type="submit" id="franchise_update" class="btn btn-success margin-bottom" value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating..."> </div>
		<div class="col-sm-5"> </div>
	</div>
	<?php $id = $this->input->get('id', true); ?>
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"> </div>
		</form>
		</div>
</article>
<?php
function subcat_print($array,$cat_id) {
    $output = "<ol style='padding:0px !important; margin-left: 10px;'>";
    foreach ($array as $value) {
        if (is_array($value->child)) {
            $output .= '<ul style="display:block; padding:0px !important;">';
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
    $output = "<ul style='list-style:none;margin-top:10px;'>";
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
	$("#franchise_update").click(function(e) {
		e.preventDefault();
		var actionurl = baseurl + 'settings/updatefranchise';
		actionProduct(actionurl);
		console.log(actionurl);
	});	
	
	$(".subcat").click(function(e) {
		var id = $(this).val();
		var apend_val = 0;
		var ids = id.split('-');
		var apend_var = '#apend' + ids[1];
		var apendtbl_var = '#apendtbl' + ids[1];
		if($(apend_var).val()) {
			var apend_val = $(apend_var).val();
		}
		var scommision_var = '#scommision' + ids[0];
		//var scommision_var = '#scommision';		
		var url = baseurl;
		//alert(apendtbl_var);
		if(apend_val == 0) {
			$.ajax({
				type: 'POST',
				url: url + "settings/getSubcatAjaxData",
				data: {
					categoryId: ids[1],
					moduleid: <?php echo $this->input->get('id', true);?>
				},
				cache: false,
				success: function(result) {
					console.log(result);
					$(scommision_var).css("display", "block");
					$(scommision_var).append(result);
				}
			});
		} else {
			//$(scommision_var).css("display","none");
			$(apendtbl_var).remove();
		}
	});
	$(window).ready(function() {
		$('input[type="checkbox"]:checked').each(function() {
			var id = $(this).val();
			//alert(123);
			var ids = id.split('-');
			//alert(ids[1]);
			var scommision_var = '#scommision' + ids[0];
			var url = baseurl;
			$.ajax({
				type: 'POST',
				url: url + "settings/getSubcatAjaxData",
				data: {
					categoryId: ids[1],
					moduleid: <?php echo $this->input->get('id', true);?>
				},
				cache: false,
				success: function(result) {
					//console.log('hi');
					$(scommision_var).css("display", "block");
					$(scommision_var).append(result);
				}
			});
		});
	});
	</script>
	<script>
	<?php if($franchise['interest_on_security_deposite_status']==1){ ?>
	$('#yes_option1').css('display', 'contents');
	<?php } ?>
	<?php if($franchise['mg_status']==1){ ?>
	$('#yes_option').css('display', 'contents');
	<?php } ?>
	<?php if($franchise['salary_paid_by_zobox_status']==1){ ?>
	$('#yes_option2').css('display', 'contents');
	<?php } ?>
	</script>
	<script>
	$('#interest_on_security_deposite_status').on('change', function() {
		if($(this).val() === '1') {
			$('#yes_option1').css('display', 'contents');
		} else {
			$('#yes_option1').css('display', 'none');
		}
	});
	</script>
	<script>
	$('#mg_status').on('change', function() {
		$('#yes_option').css('display', 'none');
		if($(this).val() === '1') {
			$('#yes_option').css('display', 'contents');
		}
	});
	</script>
	<script>
	$('#salary_paid_by_zobox_status').on('change', function() {
		$('#yes_option2').css('display', 'none');
		if($(this).val() === '1') {
			$('#yes_option2').css('display', 'contents');
		}
	});
	</script>
	<script>
	/* $( document ).ready(function() {
		$('#yes_option').css('display', 'none');
		$('#yes_option1').css('display', 'none');
	    $('#yes_option2').css('display', 'none');
	}); */
	</script>
	
<script>
	function deleteCommission(cat_id,purpose,franchise_id,module_id){
		$.ajax({
		  type : 'POST',
			  url : baseurl+'settings/deletecommission',
			  data : {cat_id : cat_id,purpose : purpose,franchise_id : franchise_id,module_id : module_id},
			  cache : false,
			  success : function(result){
				//console.log(result);
				location.reload();
			  }
		});
	}
</script>