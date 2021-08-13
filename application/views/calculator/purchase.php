<style>
.profit-green{
	color:green !important;font-size: 30px !important;
}
.loss-red{
	color:red !important;font-size: 30px !important;
}
</style>
<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h5 class="title"> <?php echo "Purchase Calculator"; ?> </h5>
      <hr>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content">
	
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
	  
	  <div id="warning" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
	  
      <div class="card-body">
        <form class="row" name="calculator-form" id="calculator-form"  action="" method="" enctype="multipart/form-data">
          
		  	  
		  <div class="form-group col-md-3">
            <label for="product_name" class="caption">Product Name</label>
            <input type="text" class="form-control calc api" name="product_name" id="product_name" placeholder="Enter HindiZo Product Name" />
          </div>
		  
		  <div class="form-group col-md-2" id="online_product_varient">
		  
          </div>
		  
		  <div class="col-md-3 form-group ">
            <label for="taxformat" class="caption">Tax </label>
            <select class="form-control round"
					onchange="changeTaxFormat(this.value)"
					id="taxformat">
				<?php echo $taxlist; ?>
			</select>
          </div>
		  
          <div class="col-md-4 form-group">
            <label for="discountFormat" class="caption"> Discount From Supplier</label>
            <select class="form-control calc" onchange="changeDiscountFormat(this.value)"
					id="discountFormat" name="discountFormat">
				<?php echo $this->common->disclist() ?>
			</select>
          </div>
		  
		  <div id="saman-row" class="col-sm-12 form-group">
            <table class="table-responsive tfr my_stripe">
              <thead>
                <tr class="item_header bg-gradient-directional-amber">
                  <th width="10%" class="text-center">Supplier Offer Price</th>
                  <th width="10%" class="text-center">Discount Offered</th>
                  <th width="10%" class="text-center">Tax(%)</th>
				  <th width="10%" class="text-center"> Buying Price (Incl. GST) </th>
                  <th width="7%" class="text-center"> Projected Price </th>
                  <th width="10%" class="text-center"> Projected GST </th>				   
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" class="form-control req prc calc" name="supplier_offer_price" id="supplier_offer_price" autocomplete="off" placeholder="Enter Supplier Offer Price"></td>
                  <td><input type="text" class="form-control discount calc" name="supplier_offer_discount" id="supplier_offer_discount" autocomplete="off" placeholder="Enter Supplier Offered Discount"></td>
                  <td><input type="text" class="form-control vat calc" name="supplier_price_gst" id="supplier_price_gst" autocomplete="off"></td>
                  
				  <td style="text-align: center;"><span class="currenty"> &#8377;</span> <strong><span class="ttlText" id="total">0.00</span></strong></td>
                  <td style="text-align: center;"><span class="currenty"> &#8377;</span> <strong><span class="ttlText" id="projected_price">0.00</span></strong></td>
                  <td style="text-align: center;"><span class="currenty"> &#8377;</span> <strong><span class="ttlText" id="projected_gst">0.00</span></strong></td>
				  
                </tr>
              </tbody>
            </table>
          </div>
		  
		  <!--<div class="form-group col-md-6">
            <label style="color:white; width: 100%; margin-top: 2px;">false label</label>
            <label for="data_came" class="caption">Data : </label>
			
			<div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio1" value="2" checked="checked">
              <label class="form-check-label" for="inlineRadio1">Online</label>
            </div>
			
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio2" value="1">
              <label class="form-check-label" for="inlineRadio2">Manual</label>
            </div>            
          </div>-->
		  
		  <div class="col-md-4 form-group ">
            <label for="online_manual" class="caption">Data</label>
            <select class="form-control calc api" name="online_manual" id="online_manual">
              <option value="online" selected="">Online</option>
              <option value="manual">Manual</option>             
            </select>
          </div>
		  
		  
          <div class="form-group col-md-4">
            <label for="flipkart_price" class="caption">Flipkart Price</label>
            <input type="text" class="form-control ecommerce" name="flipkart_price" id="flipkart_price" placeholder="Enter Flipkart Price" />
          </div>
          <div class="form-group col-md-6 manual" style="display:none">
            <label for="amazon_price" class="caption">Amazon Price</label>
            <input type="text" class="form-control ecommerce" name="amazon_price" id="amazon_price" placeholder="Enter Amazon Price" />
          </div>
          <div class="form-group col-md-6 manual" style="display:none">
            <label for="snapdeal_price" class="caption">Snapdeal Price</label>
            <input type="text" class="form-control ecommerce" name="snapdeal_price" id="snapdeal_price" placeholder="Enter Snapdeal Price" />
          </div>
          <div class="form-group col-md-6 manual" style="display:none">
            <label for="2gud_price" class="caption">2GuD Price</label>
            <input type="text" class="form-control ecommerce" name="2gud_price" id="2gud_price" placeholder="Enter 2GuD Price" />
          </div>
          <div class="form-group col-md-6 manual" style="display:none">
            <label for="infibeam_price" class="caption">Infibeam Price</label>
            <input type="text" class="form-control ecommerce" name="infibeam_price" id="infibeam_price" placeholder="Enter Infibeam Price" />
          </div>
          <div class="form-group col-md-6 manual" style="display:none">
            <button type="button" class="btn btn-primary" id="add-another" style="margin: 25px 5px;">ADD ROW</button>
            <!--data-toggle="modal" data-target="#add-another"-->
          </div>
		  
		  
          <div class="form-group col-md-4 average">
            <label for="average_online_price" class="caption">Online Average Price</label>
            <input type="text" class="form-control calc" name="average_online_price" id="average_online_price" placeholder="Average Price" />
          </div>
         
          
          
          <div class="col-md-6 form-group ">
            <label for="avg_discount_type" class="caption">Discount To Customer</label>
            <select class="form-control calc"  name="avg_discount_type" id="avg_discount_type">
              <option value="flat" selected="">Flat Discount</option>
              <option value="per">% Discount</option>             
            </select>
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">Discount</label>
            <input type="text" class="form-control calc" name="discount_avaerage_online_price" id="discount_avaerage_online_price" placeholder="Enter Discount Value" />
          </div>	  
		  
		  
		  <div class="col-md-6 form-group ">
            <label for="hindizo_margin" class="caption">Zo Retail Margin</label>
            <select class="form-control calc" name="hindizo_margin" id="hindizo_margin">
              <option value="1" selected="">% Margin</option>
              <option value="2">Flat Margin</option>             
            </select>
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">Zo Retail Margin Value</label>
            <input type="text" class="form-control calc" name="hindizo_margin_value" id="hindizo_margin_value" placeholder="Enter Discount Value" />
          </div>
		  
		  <div class="form-group col-md-6">
			<label for="taxformat" class="caption">Zo Retail Selling Price (Incl. GST)</label>
            <input type="text" class="form-control" name="hindizo_selling_price" id="hindizo_selling_price" placeholder="" />
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">P&L</label>   
				<input type="text" class="form-control" name="pnl" id="pnl" placeholder="" />
				<!--<p id="pnl-profit" class="profit-green" style="display:none"><strong>0.00</strong></p>
				<p id="pnl-loss" class="loss-red" style="display:none"><strong>0.00</strong></p>-->
          </div>
		  
		  <div class="col-md-6 form-group ">
            <label for="obc_discount" class="caption">Open Box Category Discount Type</label>
            <select class="form-control calc" name="obc_discount" id="obc_discount">
              <option value="1" selected="">% Margin</option>
              <option value="2">Flat Margin</option>             
            </select>
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">Open Box Category Discount Value</label>
            <input type="text" class="form-control calc" name="obc_discount_value" id="obc_discount_value" placeholder="Enter Discount Value" />
          </div>
		  
		  <div class="form-group col-md-6">
			<label for="taxformat" class="caption">Open Box Category Selling Price (Incl. GST)</label>
            <input type="text" class="form-control" name="obc_selling_price" id="obc_selling_price" placeholder="" />
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">P&L</label>   
				<input type="text" class="form-control" name="pnl_obc" id="pnl_obc" placeholder="" />
				<!--<p id="pnl-profit" class="profit-green" style="display:none"><strong>0.00</strong></p>
				<p id="pnl-loss" class="loss-red" style="display:none"><strong>0.00</strong></p>-->
          </div>

		  <div class="col-md-6 form-group ">
            <label for="zo_bulk_discount" class="caption">Zo Bulk Discount Type</label>
            <select class="form-control calc" name="zo_bulk_discount" id="zo_bulk_discount">
              <option value="1" selected="">% Margin</option>
              <option value="2">Flat Margin</option>             
            </select>
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="zo_bulk_discount_value" class="caption">Zo Bulk Discount Value</label>
            <input type="text" class="form-control calc" name="zo_bulk_discount_value" id="zo_bulk_discount_value" placeholder="Enter Discount Value" />
          </div>
		  
		  <div class="col-md-6 form-group ">
            <label for="zo_bulk_margin" class="caption">Zo Bulk Margin</label>
            <select class="form-control calc" name="zo_bulk_margin" id="zo_bulk_margin">
              <option value="1" selected="">% Margin</option>
              <option value="2">Flat Margin</option>             
            </select>
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="zo_bulk_margin_value" class="caption">Zo Bulk Margin Value</label>
            <input type="text" class="form-control calc" name="zo_bulk_margin_value" id="zo_bulk_margin_value" placeholder="Enter Discount Value" />
          </div>

		  <div class="form-group col-md-6">
			<label for="taxformat" class="caption">Zo Bulk Selling Price (Incl. GST)</label>
            <input type="text" class="form-control" name="zo_bulk_selling_price" id="zo_bulk_selling_price" placeholder="" />
          </div>
		  
		  <div class="form-group col-md-6 average">
            <label for="discount_avaerage_online_price" class="caption">P&L</label>   
				<input type="text" class="form-control" name="pnl_zobulk" id="pnl_zobulk" placeholder="" />
				<!--<p id="pnl-profit" class="profit-green" style="display:none"><strong>0.00</strong></p>
				<p id="pnl-loss" class="loss-red" style="display:none"><strong>0.00</strong></p>-->
          </div> 
          
          
          <div class="form-group col-md-12" style="display: flex; justify-content: center;">
            <input type="button"  class="btn btn-default" name="submit" id="go_live" value="GO LIVE" style="width:8%; background:#E91E63;color:#fff;" />
            <!--<input type="button" class="btn btn-primary" name="calc" id="calc" value="CALCULATE" style="width:15%; margin: 15px 10px; float:right" />-->
          </div>
		  <input type="hidden" name="refurbishment_cost" id="refurbishment_cost" value="">
		  <input type="hidden" name="packaging_cost" id="packaging_cost" value="">
		  <input type="hidden" name="sales_support" id="sales_support" value="">
		  <input type="hidden" name="promotion_cost" id="promotion_cost" value="">
		  <input type="hidden" name="hindizo_infra" id="hindizo_infra" value="">
		  <input type="hidden" name="hindizo_margin_val" id="hindizo_margin_val" value="">
		  <input type="hidden" name="hindizo_margin_type" id="hindizo_margin_type" value="">
		  <input type="hidden" name="gst" id="gst" value="">
		  <input type="hidden" name="pid" id="pid" value="">		  
        </form>
      </div>
    </div>
  </div>
</div>
<script>
	$('#add-another').click(function(){
		var num = Math.floor(Math.random() * 6) + 1;
		var parents = $(this).parent();
		$('<div class="col-md-4 row manual new'+num+'"><div class="col-md-8 form-group"><label style="color:white;">ABC</label><input type="text" class="form-control ecommerce" name="otherwebsite_price" id="otherwebsite_price" placeholder="Enter Other Website Price" /></div><div class="col-md-4"><button type="button" value="1" class="btn btn-warning" style="margin: 25px 0px;" onclick="remove_otherwebsite('+num+')">REMOVE</button></div></div>').insertBefore(parents);
	});
	
	
	function remove_otherwebsite(e){
		$('.new'+e).remove();
	}
	
	
$(document).ready(function () {  
	$("#product_name").autocomplete({  
		source: function(request,response) {  
			$.ajax({  
				url : baseurl+'products/getProductRecords',  
				type: "POST",  
				dataType: "json",  
				data: { term: request.term },  
				success: function (data) {  
					response($.map(data, function (item) {  
						return { value: item.product_name };  
					}))  
				}  
			})  
		}
	});  
});

/* $(document).ready(function(){
	$('.manual').hide();
	$('.manual input').val('');
	$('.average input').val('');	
	//$('.average').next('div').find('input').val('');
}); */

$('#online_manual').change(function(){
	var online_manual = $(this).val();
	if(online_manual=='online'){
		$('.manual').hide();
		$('.manual input').val('');
		$('.average input').val('');	
		//$('.average').next('div').find('input').val('');
	}else if(online_manual=='manual'){
		$('.manual').show();
		$('.manual input').val('');
		$('.average input').val('');
		//$('.average').next('div').find('input').val('');
	}	
});

	
	
$('.ecommerce').keyup(function(){	
	var online_manual = $("#online_manual option:selected").val();		
	if(online_manual=='manual') { 			
		var sum = 0;
		var i=0;
		$('.ecommerce').each(function(){
			var price = ($(this).val());
			if(price!= null && price!= '' && price!= ' '){
				sum = sum+parseFloat(price);
				i++;
			}
		})
		var avg = (sum)/i;		
		$('#average_online_price').val(avg.toFixed(2));
	 }
	 else{
		$('#average_online_price').val(0);
	 }
});


$('#average_online_price').focus(function(){
	var online_manual = $("#online_manual option:selected").val();	
	if(online_manual=='manual') { 		
		var sum = 0;
		var i=0;
		$('.ecommerce').each(function(){
			var price = ($(this).val());
			if(price!= null && price!= '' && price!= ' '){
				sum = sum+parseFloat(price);
				i++;
			}
		})
				
		var avg = (sum)/i;		
		$('#average_online_price').val(avg.toFixed(2));
	 }
	 else{
		$('#average_online_price').val(0);
	 }
});			



$('.calc').change(function(){	
	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : baseurl+'calculator/calculate',
		data : $('#calculator-form').serialize(),
		cache : false,
		success : function(result){
			console.log(result);
			$('#projected_gst').html(result.gst_val.toFixed(2));
			$('#projected_price').html(result.without_gst_price.toFixed(2));			
			$('#total').html(result.gross_price.toFixed(2));
			$('#sale_projected_gst').val(result.sale_projected_gst);
			$('#projected_price').val(result.without_gst_price);
			
			$('#refurbishment_cost').val(result.refurbishment_cost);
			$('#packaging_cost').val(result.packaging_cost);
			$('#sales_support').val(result.sales_support);
			$('#promotion_cost').val(result.promotion_cost);
			$('#hindizo_infra').val(result.hindizo_infra);
			$('#hindizo_margin_val').val(result.hindizo_margin);
			$('#hindizo_margin_type').val(result.hindizo_margin_type);
			$('#gst').val(result.gst);
			$('#pid').val(result.pid);
			
			var average_online_price = $('#average_online_price').val();
			
			if(average_online_price>0){
				$('#hindizo_selling_price').val(result.sale_grand_total);	
				$('#hindizo_sale_price_net').val(result.hindizo_sale_price_net);
				$('#hindizo_margin_value').val(result.hindizo_margin);
				$('#obc_selling_price').val(result.obc_selling_price);
				$('#zo_bulk_selling_price').val(result.zo_bulk_selling_price);
				
				if(result.hindizo_margin_type==2){
					$("#hindizo_margin").val("2");
					$("#hindizo_margin option:selected").val(2);
				}
				$('#pnl').val(result.pnl_retail.toFixed(2));
				$('#pnl_obc').val(result.pnl_obc.toFixed(2));
				$('#pnl_zobulk').val(result.pnl_zobulk.toFixed(2));
				
				/* if(result.pnl_retail > 0){	
					$("#pnl-profit").show();
					$("#pnl-loss").hide();
					$("#pnl-profit").html(result.pnl_retail.toFixed(2));
				}else{
					$("#pnl-profit").hide();
					$("#pnl-loss").show();
					$("#pnl-loss").html(result.pnl_retail.toFixed(2));
				} */
			}
			
			/* var pnl_retail = result.pnl_retail;
			if(pnl_retail > 0){
				swal('','Congratulations! You are in Profit','success');		
				$('#cost_status_message').css('border','1px solid green');
				$('#cost_status_message').focus();
			}else{
				swal('','You are in Loss','warning');
				$('#cost_status_message').css('border','1px solid red');
				$('#cost_status_message').focus();
			} */
			
		}
	});
})


$('#go_live').click(function(){	
	if(confirm("Are you Sure!")){
		if(confirm("Are you Sure!")){
			var purchase_price = $('#total').html();	
			var sale_price = $('#hindizo_selling_price').val();
			var obc_sale_price = $('#obc_selling_price').val();
			var zobulk_sale_price = $('#zo_bulk_selling_price').val();
			var refurbishment_cost = $('#refurbishment_cost').val();
			var packaging_cost = $('#packaging_cost').val();
			var sales_support = $('#sales_support').val();
			var promotion_cost = $('#promotion_cost').val();
			var hindizo_infra = $('#hindizo_infra').val();
			var hindizo_margin = $('#hindizo_margin_val').val();
			var discount = $('#discount_avaerage_online_price').val();
			var discount_type = $('#avg_discount_type').val();
			var average_market_price = $('#average_online_price').val();
			var hindizo_margin_type = $('#hindizo_margin_type').val();
			var gst = $('#gst').val();
			var pid = $('#pid').val();	
				$.ajax({
					type : 'POST',
					dataType : 'json',
					url : baseurl+'calculator/setSalePrice',
					data : {purchase_price:purchase_price, sale_price:sale_price, obc_sale_price:obc_sale_price, zobulk_sale_price:zobulk_sale_price, refurbishment_cost:refurbishment_cost, packaging_cost:packaging_cost, sales_support:sales_support, promotion_cost:promotion_cost, hindizo_infra:hindizo_infra, hindizo_margin:hindizo_margin, discount:discount, average_market_price:average_market_price, hindizo_margin_type:hindizo_margin_type, gst:gst, pid:pid},
					cache : false,
					success : function(result){						
						//console.log(result);
						if(result.status=='Success'){
							$('#notify').show();
							$('#warning').hide();
							$('.message').html('Sale price set sucessfully !');
						}else if(result.status=='Error'){
							$('#warning').show();
							$('#notify').hide();
							$('.message').html(result.message);
						}
					}
				});
		}
	}	
})  



$(".api").change(function(){
	var online_manual = $("#online_manual option:selected").val();
	if(online_manual=='online') { 
	var term = $('#product_name').val();
		$.ajax({
			type : 'POST',
			url : baseurl+'calculator/getVarientProduct',			
			data : {term:term},		
			cache : false,
			success : function(result){	
				//console.log(term);
				//console.log(result);
				//var obj = JSON.parse(result);	
				if(result!=null){
					$( "#online_product_varient" ).html(result);
					
					/* var id = obj.product_id;
					
					$.ajax({
						type : 'POST',
						url : baseurl+'calculator/getAverageProductPrice',
					
						data : {id:id},		
						cache : false,
						success : function(res){	
							console.log(res);
							if(res !=''){
								$("#average_price_d_api").val(res);	
							}
						}
					}); */
				}else{
					$( "#varient_name_d_api" ).val('N/A');
					$( "#varient_name_d_api" ).val('N/A');
				}
			}
		});
	}
});




</script>
