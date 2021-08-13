<div class="form-group row">

	<label class="col-sm-2 col-form-label"
		   for="product_cat"><?php echo $this->lang->line('Sub Category') ?></label>

	<div class="col-sm-6">
		<select name="subcat[<?php echo $id; ?>]" class="form-control" id="subcat<?php echo $id; ?>" onChange=getsubcatDropdown(this.value,<?php echo $id; ?>);>
			<option value='' selected='' disabled=''>--- select ---</option>
			<?php
			foreach ($subcat as $row) {
				$cid = $row->id;
				$title = $row->title;
				echo "<option value='$cid'>$title</option>";
			}
			?>
		</select>

	</div>
</div> 
<div id="subcatDiv<?php echo $id; ?>"> </div>

	