<tr>
	<td><select id="v_type" name="v_type[<?php echo $row_count; ?>]" class="form-control" onclick='getconditions(<?php echo $row_count; ?>),getcolours(<?php echo $row_count; ?>)'>
		<?php
                              for($i=0;$i<count($product);$i++)
                              {
                                ?>
            <option value="<?=$product[$i]['pid']; ?>"><?=$product[$i]['product_name']; ?></option>
            <?php } ?>
	  </select></td>
	<!--<td style="display:none;"><input value="" class="form-control" name="v_stock[]"
								   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
	</td>-->
	
			  
	<td><input value="" class="form-control" name="zupc_code[]" placeholder="ZUPC Code"></td>
	<td><button class="btn btn-red tr_delete">Delete</button></td>
</tr>


