<div class="form-group row">
	<label class="col-sm-2 col-form-label"
		   for="name"><?php echo $this->lang->line('Franchise') ?></label>
	<div class="col-sm-5">
		<select name="franchise_id" id="franchise_id" class="form-control margin-bottom">
			<?php foreach($franchise as $key=>$row){ ?>
				<option <?php if($franchise_id==$row->id){?> selected <?php } ?> value="<?php echo $row->id; ?>"><?php echo $row->name ?></option>
			<?php } ?>
		</select>
	</div>
</div>