</div>
</div>
</div>
<!-- BEGIN VENDOR JS-->
<script type="text/javascript">
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
    $('[data-toggle="datepicker"]').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');


</script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="<?= assets_url() ?>app-assets/js/core/app-menu.js"></script>
<script src="<?= assets_url() ?>app-assets/js/core/app.js"></script>
<script type="text/javascript" src="<?= assets_url() ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="<?php echo assets_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo assets_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
<script src="<?php echo assets_url('assets/myjs/custom.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/basic.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/control.js') . APPVER; ?>"></script>

<script type="text/javascript">
    $.ajax({

        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }

    });


</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
<!-- Modal -->
<!-- Purchase Calculator -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pcalculator" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p><img src="<?php echo base_url()?>/app-assets/images/logo/zobot.jpg" class="img-thumb" style="width: 20%;"  /> <span style="font-size: 20px; vertical-align: middle;">Purchase Calculator</span></p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span> </button>
      </div>
      <div class="modal-body">
        <form class="row" name="calculator-form" id="calculator-form"  action="" method="" enctype="multipart/form-data">
          <div class="form-group col-md-6">
            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" />
          </div>
          <div class="form-group col-md-6">
            <label for="data_came">Data Entered By : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio2" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio2">Manual</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio1" value="2">
              <label class="form-check-label" for="inlineRadio1">API</label>
            </div>
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="flipkart_price" id="flipkart_price" placeholder="Enter Flipkart Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="amazon_price" id="amazon_price" placeholder="Enter Amazon Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="snapdeal_price" id="snapdeal_price" placeholder="Enter Snapdeal Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="2gud_price" id="2gud_price" placeholder="Enter 2GuD Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="infibeam_price" id="infibeam_price" placeholder="Enter Infibeam Price" />
          </div>
          <div class="form-group col-md-4 average">
            <input type="text" class="form-control" name="average_price_p_calc" id="average_price_p_calc" placeholder="Enter Average Price" />
          </div>
		  <div class="form-group col-md-12">
            <input type="text" class="form-control" name="buying_price_p_calc" id="buying_price_p_calc" placeholder="Enter Buying Price" />
          </div>
		  
		  
          <div class="form-group col-md-6">
            <label for="data_came">How much Discount the supplier is offering you? : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_on" id="inlineRadio4" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio4">Percentage(%)</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_on" id="inlineRadio3" value="2">
              <label class="form-check-label" for="inlineRadio3">Flat</label>
            </div>
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="discount_p_calc" id="discount_p_calc" placeholder="Enter Discount(%)" />
          </div>
		  <div class="form-group col-md-6">
            <label for="data_came">Discount Applied? : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_applied_state" id="inlineRadio6" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio6">Before GST</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_applied_state" id="inlineRadio5" value="2">
              <label class="form-check-label" for="inlineRadio5">After GST</label>
            </div>
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="gst_percentage_p_calc" id="gst_percentage_p_calc" placeholder="Enter GST Percentage" />
          </div>
		  <div class="form-group col-md-12">
		  	<input type="button" class="btn btn-primary" name="calc" id="calc" value="CALCULATE" style="width:100%;" />
         
          </div>	  
		  
		  <div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_gst" id="hindizo_buying_gst" placeholder="Hindizo Buying GST" />
          </div>
		  
		  <div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_price_p_calc" id="hindizo_buying_price_p_calc" placeholder="Hindizo Buying Price Without GST" />
          </div>
		  
		   <div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_with_gst" id="hindizo_buying_with_gst" placeholder="Hindizo Buying Gross Price" />
          </div>
		  
		  <div class="form-group col-md-12">
		  	
            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="SUBMIT" style="width:100%;" />
          </div>
		  
        </form>
      </div>
    </div>
  </div>
</div>


<!--Deciding Price Calculator-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="dpcalculator" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p><img src="<?php echo base_url()?>/app-assets/images/logo/zobot.jpg" class="img-thumb" style="width: 20%;"  /> <span style="font-size: 20px; vertical-align: middle;">Sale Price Calculator</span></p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span> </button>
      </div>
	  <div id="cost_status_message"></div>
	   <div id="notify" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>

			<div class="message"></div>
		</div>
		
		<div id="warning" class="alert alert-warning" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>

			<div class="message"></div>
		</div>
      <div class="modal-body">
        <form class="row" name="calculator-form" action="" method="post" enctype="multipart/form-data">
		
          <div class="form-group col-md-6">
            <input type="text" class="form-control" name="product_name_d_api" id="product_name_d_api" placeholder="Enter Product Name" />
          </div>
		  
		  <div class="form-group col-md-6">
            <label for="data_came">Data Entered By : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="manual" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio2">Manual</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="api" value="2">
              <label class="form-check-label" for="inlineRadio1">API</label>
            </div>
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="flipkart_price_s" id="flipkart_price_s" placeholder="Enter Flipkart Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="amazon_price_s" id="amazon_price_s" placeholder="Enter Amazon Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="snapdeal_price_s" id="snapdeal_price_s" placeholder="Enter Snapdeal Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="2gud_price_s" id="2gud_price_s" placeholder="Enter 2GuD Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <input type="text" class="form-control" name="infibeam_price_s" id="infibeam_price_s" placeholder="Enter Infibeam Price" />
          </div>		  
		 
		  <div class="form-group col-md-6 average">
            <input type="text" class="form-control" name="average_price_d_api" id="average_price_d_api" placeholder="Enter Average Selling Price" />
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="varient_name_d_api" id="varient_name_d_api" placeholder="Product Varient" readonly />
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="wproduct_name_d" id="wproduct_name_d" placeholder="Warehouse Product Name" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="purchase_price_d" id="purchase_price_d" placeholder="Warehouse Purchase Price" />
          </div>	  
		  
          <div class="form-group col-md-6">
            <label for="data_came">How much Discount you want to apply? : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_on_d" id="inlineRadio8" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio2">Percentage(%)</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_on_d" id="inlineRadio7" value="2">
              <label class="form-check-label" for="inlineRadio1">Flat</label>
            </div>
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="discount_d" id="discount_d" placeholder="Enter Discount" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="gst_d" id="gst_d" placeholder="Enter GST. Percentage" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="gst_toPaid_d" id="gst_toPaid_d" placeholder="Enter GST Amount to be paid" />
          </div>
		   <div class="form-group col-md-6">
            <input type="text" class="form-control" name="final_sell_price_d" id="final_sell_price_d" placeholder="Enter Zo Selling Net Price" />
          </div>
		  <div class="form-group col-md-4">
            <input type="button" class="btn btn-primary" name="dpcalc" id="dpcalc" value="CALCULATE" style="width:100%;" />
          </div>
		  
		  <div class="form-group col-md-4">
            <input type="button" class="btn btn-primary" name="clear_s" id="clear_s" value="CLEAR" style="width:100%;" />
          </div>
		  
		  <div class="form-group col-md-4">
            <input type="button" class="btn btn-primary" name="set_s" id="set_s" value="SET" style="width:100%;" />
          </div>
		  
			<input type="hidden" name="wpurchase_price" id="wpurchase_price" value="">
			<input type="hidden" name="product_cost" id="product_cost" value="">
			<input type="hidden" name="gst_price" id="gst_price" value="">
			<input type="hidden" name="withoutgstprice" id="withoutgstprice" value="">
			<input type="hidden" name="withgstprice" id="withgstprice" value="">
			<input type="hidden" name="refurbishment_cost" id="refurbishment_cost" value="">			
			<input type="hidden" name="packaging_cost" id="packaging_cost" value="">			
			<input type="hidden" name="sales_support" id="sales_support" value="">			
			<input type="hidden" name="promotion_cost" id="promotion_cost" value="">			
			<input type="hidden" name="hindizo_infra" id="hindizo_infra" value="">			
			<input type="hidden" name="hindizo_margin" id="hindizo_margin" value="">
			<input type="hidden" name="discount" id="discount" value="">
			<input type="hidden" name="average_market_price" id="average_market_price" value="">
			<input type="hidden" name="pid" id="pid" value="">
							
        </form>
      </div>
    </div>
  </div>
</div>

<!--<div class="modal fade" id="add-another" tabindex="-1" role="dialog" aria-labelledby="add-another" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Website Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <input type="text" id="website" name="website" class="form-control" placeholder="ADD Website" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>-->
<script>
	 /* $('#inlineRadio1').click(function(){
		$('.manual').hide(300);
		$('.manual input').val('');
		$('.average input').val('');
		//$('.average').removeClass('col-md-4').addClass('col-md-6');
		//$('.average').next('div').removeClass('col-md-12').addClass('col-md-6');
		$('.average').next('div').find('input').val('');
	});
	$('#inlineRadio2').click(function(){
		$('.manual').show(300);
		$('.manual input').val('');
		$('.average input').val('');
		//$('.average').removeClass('col-md-6').addClass('col-md-4');
		//$('.average').next('div').removeClass('col-md-6').addClass('col-md-12');
		$('.average').next('div').find('input').val('');
	});
	
	$('#average_price_p_calc').focus(function(){
		if($('#inlineRadio2').is(':checked')) { 
			if($('#flipkart_price').val() != null){
				var fp = parseFloat($('#flipkart_price').val());
			}else{
				var fp = 0;
			}
			if($('#amazon_price').val() != null){
				var ap = parseFloat($('#amazon_price').val());
			}else{
				var ap = 0;
			}
			if($('#snapdeal_price').val() != null){
				var sdp = parseFloat($('#snapdeal_price').val());
			}else{
				var sdp = 0;
			}
			if($('#2gud_price').val() != null){
				var twogp = parseFloat($('#2gud_price').val());
			}else{
				var twogp = 0;
			}
			if($('#infibeam_price').val() != null){
				var inp = parseFloat($('#infibeam_price').val());
			}else{
				var inp = 0;
			}
			$('#average_price_p_calc').val((fp+ap+sdp+twogp+inp)/5);
		 }
		 else{
		 	$('#average_price_p_calc').val(0);
		 }
	});
	$('#inlineRadio3').click(function(){
		$('#discount_p_calc').attr('placeholder','Enter Discount Amount');
		
	});
	$('#inlineRadio4').click(function(){
		$('#discount_p_calc').attr('placeholder','Enter Discount (%)');
	});
	$('#buying_price_p_calc').keypress(function(){
		$('#buying_price_p_calc').css('border','1px solid #ccd6e6');
	});
	$('#gst_percentage_p_calc').keypress(function(){
		$('#gst_percentage_p_calc').css('border','1px solid #ccd6e6');
	});
	
	
	$('#calc111').click(function(){		
		if($('#buying_price_p_calc').val() == null || $('#buying_price_p_calc').val() == '' || $('#buying_price_p_calc').val() == ' '){
			swal('','Enter Buying Price','warning');
			$('#buying_price_p_calc').css('border','1px solid red');
			$('#buying_price_p_calc').focus();
		}else{
			$('#buying_price_p_calc').css('border','1px solid #ccd6e6');
			if($('#gst_percentage_p_calc').val() == null || $('#gst_percentage_p_calc').val() == '' || $('#gst_percentage_p_calc').val() == ''){
				swal('','Enter GST Percentage','warning');
				$('#gst_percentage_p_calc').css('border','1px solid red');
				$('#gst_percentage_p_calc').focus();
			}else{
				if($('#discount_p_calc').val() == null || $('#discount_p_calc').val() == '' || $('#discount_p_calc').val() == ' '){
					var bPrice = $('#buying_price_p_calc').val();
					var gstPrice = $('#gst_percentage_p_calc').val();					
					var price = bPrice - (bPrice * gstPrice / 100);
					$('#hindizo_buying_price_p_calc').val(price);
				}else{
					$('#hindizo_buying_price_p_calc').val('');
					$.ajax({
						type : 'POST',
						dataType : 'json',
						url : baseurl+'products/calculator',
						data  : $('#calculator-form').serialize(),
						cache : false,
						success : function(result){
							if(result == 'A'){
								swal('','Percentage can not be more than 100');
								$('#discount_p_calc').val('');
								$('#discount_p_calc').css('border','1px solid red');
							}else{	
								console.log(result);
								$('#hindizo_buying_gst').val(result.gst);
								$('#hindizo_buying_price_p_calc').val(result.without_gst_price);
								$('#hindizo_buying_with_gst').val(result.gross_price);
								
								var average_price_p_calc = $('#average_price_p_calc').val();
								var product_cost = result.product_cost;
								
								if(average_price_p_calc > product_cost){
									swal('','Congratulations! You are in Profit','success');		
									$('#cost_status_message').css('border','1px solid green');
									$('#cost_status_message').focus();
								}else{
									swal('','You are in Loss','warning');
									$('#cost_status_message').css('border','1px solid red');
									$('#cost_status_message').focus();
								}
							}
							
						}
						
					});
				}
			}
		}
		});
		
		
		
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
		},  
		messages: {  
			noResults: "", results: ""  
		}  
	});  
});   */	 
		
		
</script>











<?php //Sale Price Calculator Script Start Here ?>
<script>
/* $(document).ready(function () {  
	$("#wproduct_name_d").autocomplete({  
		source: function(request,response) {  
			$.ajax({  
				url : baseurl+'purchase/getUniquePurchaseProduct',  
				type: "POST",  
				dataType: "json",  
				data: { term: request.term },  
				success: function (data) {  
					response($.map(data, function (item) {  
						return { value: item.product };  
					}))  
				}  
			})  
		},  
		messages: {  
			noResults: "", results: ""  
		}  
	});  
});  





$(document).ready(function () {  
	$("#product_name_d_api").autocomplete({  
		source: function(request,response) {  
			$.ajax({  
				url : baseurl+'products/getProductsA',  
				type: "POST",  
				dataType: "json",  
				data: { term: request.term },  
				success: function (data) {  
					response($.map(data, function (item) {  
						return { value: item.product_title };  
					}))  
				}  
			})  
		},  
		messages: {  
			noResults: "", results: ""  
		}  
	});  
});


$("#api").click(function(){
	
	var term = $('#product_name_d_api').val();

	$.ajax({
		type : 'POST',
		url : baseurl+'products/getVarientProduct',
		
		data : {term:term},		
		cache : false,
		success : function(result){	
			
			var obj = JSON.parse(result);	
			if(result!=null){
				$( "#varient_name_d_api" ).val(obj.product_title);
				
				var id = obj.product_id;
				
				$.ajax({
					type : 'POST',
					url : baseurl+'products/getAverageProductPrice',
				
					data : {id:id},		
					cache : false,
					success : function(res){	
						console.log(res);
						if(res !=''){
							$("#average_price_d_api").val(res);	
						}
					}
				});
			}else{
				$( "#varient_name_d_api" ).val('N/A');
				$( "#varient_name_d_api" ).val('N/A');
			}
		}
	});
});


$( "#wproduct_name_d" ).blur(function(){
	var product_name = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'purchase/getProductDetailsByName',
		data : {product_name:product_name},
		cache : false,
		success : function(result){			
			$( "#purchase_price_d" ).val(result);
		}
	});
});


$('#dpcalc').click(function(){
	var product_name_d_api = parseFloat($('#product_name_d_api').val());	
	var varient_name_d_api = parseFloat($('#varient_name_d_api').val());		
	var average_price_d_api = parseFloat($('#average_price_d_api').val());
	var wproduct_name_d = $('#wproduct_name_d').val();
	var purchase_price_d = parseFloat($('#purchase_price_d').val());
	var discount_d = parseFloat($('#discount_d').val());
	var gst_d = parseFloat($('#gst_d').val());		
	var discount_type = parseFloat($("input[name='discount_on_d']:checked").val());
	

	$.ajax({
		type : 'POST',
		dataType: "json",
		url : baseurl+'products/salecalculator',
		data : {product_name_d_api:product_name_d_api,varient_name_d_api:varient_name_d_api,average_price_d_api:average_price_d_api,wproduct_name_d:wproduct_name_d,purchase_price_d:purchase_price_d,discount_type:discount_type,discount_d:discount_d,gst_d:gst_d},
		cache : false,
		success : function(res){		
			console.log(res);
			if(res == 'A'){
				swal('','Percentage can not be more than 100');
				$('#discount_p_calc').val('');
				$('#discount_p_calc').css('border','1px solid red');
			}else{
				var purchase_price_d = res.purchase_price_d;
				var product_cost = res.product_cost;
				var gst_price = res.gst_price;
				var withoutgstprice = res.withoutgstprice;
				var withgstprice = res.withgstprice;
				var discount_d = res.discount_d;
				var average_price_d_api = res.average_price_d_api;
				var pid = res.pid;

				var refurbishment_cost = res.refurbishment_cost;
				var refurbishment_cost_type = res.refurbishment_cost_type;
				var refurbishment_cost_actual = res.refurbishment_cost_actual;

				var packaging_cost = res.packaging_cost;
				var packaging_cost_type = res.packaging_cost_type;
				var packaging_cost_actual = res.packaging_cost_actual;

				var sales_support = res.sales_support;
				var sales_support_type = res.sales_support_type;
				var sales_support_actual = res.sales_support_actual;

				var promotion_cost = res.promotion_cost;
				var promotion_cost_type = res.promotion_cost_type;
				var promotion_cost_actual = res.promotion_cost_actual;

				var hindizo_infra = res.hindizo_infra;
				var hindizo_infra_type = res.hindizo_infra_type;
				var hindizo_infra_actual = res.hindizo_infra_actual;

				var hindizo_margin = res.hindizo_margin;
				var hindizo_margin_type = res.hindizo_margin_type;
				var hindizo_margin_actual = res.hindizo_margin_actual;
				
				$('#wpurchase_price').val(purchase_price_d);
				$('#product_cost').val(product_cost);
				$('#gst_price').val(gst_price);
				$('#withoutgstprice').val(withoutgstprice);
				$('#withgstprice').val(withgstprice);
				$('#refurbishment_cost').val(refurbishment_cost);
				$('#packaging_cost').val(packaging_cost);
				$('#sales_support').val(sales_support);
				$('#promotion_cost').val(promotion_cost);
				$('#hindizo_infra').val(hindizo_infra);
				$('#hindizo_margin').val(hindizo_margin);
				$('#discount').val(discount_d);
				$('#average_market_price').val(average_price_d_api);
				$('#pid').val(pid);
				
				
				$('#gst_toPaid_d').val(gst_price);
				$('#final_sell_price_d').val(withoutgstprice);
				
				if(purchase_price_d < product_cost){
					swal('','Congratulations! You are in Profit','success');		
					$('#cost_status_message').css('border','1px solid green');
					$('#cost_status_message').focus();
				}else{
					swal('','You are in Loss','warning');
					$('#cost_status_message').css('border','1px solid red');
					$('#cost_status_message').focus();
				}
			}
						
			
		}
	});
	
	
});


$('#clear_s').click(function(){
	$('#product_name_d_api').val('');
	$('#average_price_d_api').val('');
	$('#wproduct_name_d').val('');
	$('#purchase_price_d').val('');	
	$('#discount_d').val('');
	$('#gst_d').val('');
	$('#gst_toPaid_d').val('');
	$('#final_sell_price_d').val('');	
	$('#varient_name_d_api').val('');	
});


$('#api').click(function(){
	$('#varient_name_d_api').val('');	
	$('#average_price_d_api').val('');	
	//$('.average').removeClass('col-md-4').addClass('col-md-6');
	$('.manual').hide(300);	
	$('#varient_name_d_api').show(300);	
});
$('#manual').click(function(){	
	$('#varient_name_d_api').val('');	
	$('#average_price_d_api').val('');
	$('#varient_name_d_api').hide(300);
	$('.manual').show(300);	
	//$('.average').removeClass('col-md-6').addClass('col-md-4');
});


$(document).ready(function(){
	$('#varient_name_d_api').val('');	
	$('#average_price_d_api').val('');
	$('#varient_name_d_api').hide(300);
	$('.manual').show(300);	
	//$('.average').removeClass('col-md-6').addClass('col-md-4');
});


$('#average_price_d_api').focus(function(){
	if($('#manual').is(':checked')) { 
		if($('#flipkart_price_s').val() != null){
			var fp = parseFloat($('#flipkart_price_s').val());
		}else{
			var fp = 0;
		}
		if($('#amazon_price_s').val() != null){
			var ap = parseFloat($('#amazon_price_s').val());
		}else{
			var ap = 0;
		}
		if($('#snapdeal_price_s').val() != null){
			var sdp = parseFloat($('#snapdeal_price_s').val());
		}else{
			var sdp = 0;
		}
		if($('#2gud_price_s').val() != null){
			var twogp = parseFloat($('#2gud_price_s').val());
		}else{
			var twogp = 0;
		}
		if($('#infibeam_price_s').val() != null){
			var inp = parseFloat($('#infibeam_price_s').val());
		}else{
			var inp = 0;
		}
		$('#average_price_d_api').val((fp+ap+sdp+twogp+inp)/5);
	 }
	 else{
		$('#average_price_d_api').val(0);
	 }
});


 $('#set_s').click(function(){
	var purchase_price = $('#wpurchase_price').val();
	var sale_price = $('#product_cost').val();
	var refurbishment_cost = $('#refurbishment_cost').val();
	var packaging_cost = $('#packaging_cost').val();
	var sales_support = $('#sales_support').val();
	var promotion_cost = $('#promotion_cost').val();
	var hindizo_infra = $('#hindizo_infra').val();
	var hindizo_margin = $('#hindizo_margin').val();
	var discount = $('#discount').val();
	var average_market_price = $('#average_market_price').val();
	var pid = $('#pid').val();	
	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : baseurl+'products/setSalePrice',
		data : {purchase_price:purchase_price, sale_price:sale_price, refurbishment_cost:refurbishment_cost, packaging_cost:packaging_cost, sales_support:sales_support, promotion_cost:promotion_cost, hindizo_infra:hindizo_infra, hindizo_margin:hindizo_margin, discount:discount, average_market_price:average_market_price, pid:pid},
		cache : false,
		success : function(result){			
		
			
			if(result.status=='Success'){
				$('#notify').show();
				$('.message').html('Sale price set sucessfully !');
			}else if(result.status=='Error'){
				$('#warning').show();
				$('.message').html(result.message);
			}
		}
	});
})  */

</script>

<style>
 .ui-front {
    z-index: 2000 !important;
}
</style>



</html>
