<?php 
/* echo "<pre>";
print_r($catcommision); */

foreach($catcommision as $key=>$scat){  
$scat_id = $scat['cat']->id; ?>
						<table id="apendtbl<?php echo $scat_id; ?>">
							<tr>
							<td style="position:relative" rowspan="4"><?php echo $scat['cat']->title; ?>
							<input type="hidden" name="apend" id="apend<?php echo $scat_id; ?>" value="<?php echo $scat_id; ?>">
							</td>							
							<td>
								<tr>
									<td>Buying</td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $scat_id; ?>][1]" id="retail[<?php echo $scat_id; ?>][1]" value="<?php echo $scat[1]->retail_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $scat_id; ?>][1]" id="b2c[<?php echo $scat_id; ?>][1]" value="<?php echo $scat[1]->b2c_comission_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $scat_id; ?>][1]" id="bulk[<?php echo $scat_id; ?>][1]" value="<?php echo $scat[1]->bulk_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $scat_id; ?>][1]" id="renting[<?php echo $scat_id; ?>][1]" value="<?php echo $scat[1]->renting_commision_percentage; ?>"></td>								
								</tr>
								<tr>
									<td>Selling</td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $scat_id; ?>][2]" id="retail[<?php echo $scat_id; ?>][2]" value="<?php echo $scat[2]->retail_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $scat_id; ?>][2]" id="b2c[<?php echo $scat_id; ?>][2]" value="<?php echo $scat[2]->b2c_comission_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $scat_id; ?>][2]" id="bulk[<?php echo $scat_id; ?>][2]" value="<?php echo $scat[2]->bulk_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $scat_id; ?>][2]" id="renting[<?php echo $scat_id; ?>][2]" value="<?php echo $scat[2]->renting_commision_percentage; ?>"></td>
								</tr>
								<tr>
									<td>Exchange</td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $scat_id; ?>][3]" id="retail[<?php echo $scat_id; ?>][3]" value="<?php echo $scat[3]->retail_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $scat_id; ?>][3]" id="b2c[<?php echo $scat_id; ?>][3]" value="<?php echo $scat[3]->b2c_comission_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $scat_id; ?>][3]" id="bulk[<?php echo $scat_id; ?>][3]" value="<?php echo $scat[3]->bulk_commision_percentage; ?>"></td>
									<td><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $scat_id; ?>][3]" id="renting[<?php echo $scat_id; ?>][3]" value="<?php echo $scat[3]->renting_commision_percentage; ?>"></td>						
								</tr>
							</td>							
						</tr>
						</table>
						
						<?php } ?>