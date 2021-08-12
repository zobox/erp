<tr>
	<td><select id="v_type" name="v_type[<?php echo $row_count; ?>]" class="form-control" onclick='getconditions(<?php echo $row_count; ?>),getcolours(<?php echo $row_count; ?>)'>
		<?php
					foreach ($variables as $row) {
						$cid = $row['id'];
						$title = $row['name'];                                                    
						$variation = $row['variation'];
						echo "<option value='$cid'>$variation - $title </option>";
					}
					?>
	  </select></td>
	<!--<td style="display:none;"><input value="" class="form-control" name="v_stock[]"
								   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
	</td>-->
	
	<td>
	  <select id="conditionsdp<?php echo $row_count; ?>" name="conditions[<?php echo $row_count; ?>][]" class="form-control required select-box"
					multiple="multiple">				
	  </select>	  
	</td>
	
	<td>
	  <select id="coloursdp<?php echo $row_count; ?>" name="colours[<?php echo $row_count; ?>][]" class="form-control required select-box" 
	  multiple="multiple"></select>
	</td>
					  
	<td><input value="" class="form-control" name="v_alert[]" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*"></td>
	<td><button class="btn btn-red tr_delete">Delete</button></td>
</tr>


