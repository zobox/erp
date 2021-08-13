
<label for="hindizo_margin" class="caption">Product Varient</label>
<select class="form-control calc" name="product_varient" id="product_varient">
	<?php foreach($varient as $key=>$v){ ?>
	  <option value="<?php echo $v->product_id; ?>" ><?php echo $v->product_title; ?></option>	  
	<?php } ?>
</select>

<script>
$('#product_varient').change(function(){
	var id = $(this).val();
	//alert(id);
	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : baseurl+'calculator/getAverageProductPrice',	
		data : {id:id},		
		cache : false,
		success : function(res){	
			//console.log(res);			
			if(res !=''){
				$("#average_online_price").val(res.avg_price.toFixed(2));	
				$("#flipkart_price").val(res.flipkart_price);	
			}
		}
	});
});
</script>