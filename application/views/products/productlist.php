
	
		<div class="form-group row">
			<label class="col-sm-2 col-form-label"
				   for="product_cat"><?php echo $this->lang->line('Brand') ?></label>
			<div class="col-sm-6">
				<select name="brand_id" class="form-control" id="brand_id">
					<option value='' selected="">---Select---</option>
					<?php
					foreach ($brands as $row) {
						$cid = $row->id;
						$title = $row->title;
						echo "<option value='$cid'>$title</option>";
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row text-center">
					<div class="col-sm-10"></div>
                    <div class="col-sm-2">
						<div class="all-select">
						<input type="checkbox" id="selectall"> Select all</input>
						</div>																					
					</div>
                </div>
		
		<div id="prodDIV">
		<div class="card-body">

		<input type='hidden' name='sel_cat_id' id='sel_cat_id' value='<?php echo $id; ?>'>
		<table id="productstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
			   width="100%">
			<thead>
			<tr>
				<th>#</th>
				<th><?php echo $this->lang->line('Name') ?></th>
				<!--=<th><?php echo $this->lang->line('Refurbishment Cost') ?></th>-->
				<th>Good to Excellent</th>
				<th>Okay to Excellent</th>
				<th>Superb to Excellent</th>
				<th>Excellent to Excellent</th>
				<th><?php echo $this->lang->line('Select') ?></th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($products as $key=>$prow){ 
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
							case 'salessupport' : $cost = $prow->sales_support; 
													$good_to_excellent = $prow->sales_support_good_to_excellent;
													$ok_to_excellent = $prow->sales_support_ok_to_excellent;
													$superb_to_excellent = $prow->sales_support_superb_to_excellent;
													$excellent_to_excellent = $prow->sales_support_excellent_to_excellent;
													$type= $prow->sales_support_type;
							break;
							case 'promotion' : $cost = $prow->promotion_cost; 
													$good_to_excellent = $prow->promotion_good_to_excellent;
													$ok_to_excellent = $prow->promotion_ok_to_excellent;
													$superb_to_excellent = $prow->promotion_superb_to_excellent;
													$excellent_to_excellent = $prow->promotion_excellent_to_excellent;
													$type= $prow->promotion_cost_type;
							break;
							case 'infra' : $cost = $prow->hindizo_infra; 
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
					<td><?php echo $prow->pid; ?></td>
					<td><?php echo $prow->product_name; ?></td>					
					<!--<td><?php echo floatval($cost); ?><?php if($type==1){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>-->

					<td><?php echo floatval($good_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
					<td><?php echo floatval($ok_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
					<td><?php echo floatval($superb_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
					<td><?php echo floatval($excellent_to_excellent); ?><?php if($type==2){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
					<td><input type="checkbox" class="select_check" name="chk[<?php echo $prow->pid; ?>]" id='chk<?php echo $prow->pid; ?>' value='<?php echo $prow->pid; ?>'></td>
					<?php if($cost == 0){ ?>
					<input type="hidden" name="unchk[<?php echo $prow->pid; ?>]" id='unchk<?php echo $prow->pid; ?>' value='<?php echo $prow->pid; ?>'>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>

			<!--<tfoot>
			<tr>
				<th>#</th>
				<th><?php echo $this->lang->line('Name') ?></th>
				
				<th><?php echo $this->lang->line('Settings') ?></th>
			</tr>
			</tfoot>-->
		</table>

	</div>
	</div>
	<script type="text/javascript">
    $(document).ready(function () {
    $('#selectall').click(function () {
        $('.select_check').prop('checked', this.checked);
    });

    $('.select_check').change(function () {
        var check = ($('.select_check').filter(":checked").length == $('.select_check').length);
        $('#selectall').prop("checked", check);
    });
});	
</script>
	
<script>
	
	$('#brand_id').on('change',function(event){
	var id = $(this).val();
	var cat_id = $('#sel_cat_id').val();
	//alert(id);
	var action = '<?php echo $action; ?>';
		$.ajax({
			type : 'POST',
			url : baseurl+'productcategory/productlistbybrand',
			data : {id:id,action:action,cat_id:cat_id},
			cache : false,
			success : function(result){
				console.log(result);
				$('#prodDIV').html(result);
			}
		});
	});
	
</script>