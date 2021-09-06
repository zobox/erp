<select id="to_warehouses" name="to_warehouses" class="form-control round required" >	
	<option value="">---Select---</option>
	<?php foreach ($warehouse as $row) {
		echo '<option value="' . $row->id . '">' . $row->title . '</option>';
	} ?>
</select>

<script>
$('#to_warehouses').change(function(){
	//alert("oks");
	if($(this).val()!=''){
		$('#imei_transfer').show();
	}else{
		$('#imei_transfer').hide();
	}
	
});
</script>