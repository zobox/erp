<select id="to_warehouses" name="to_warehouses" class="form-control round required" >	
	<option value="">---Select---</option>
	<?php foreach ($warehouse as $row) {
		echo '<option value="' . $row->id . '">' . $row->title . '</option>';
	} ?>
</select>