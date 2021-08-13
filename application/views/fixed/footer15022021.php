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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pcalculator" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p><img src="<?php echo base_url()?>/app-assets/images/logo/zobot.jpg" class="img-thumb" style="width: 20%;"  /> <span style="font-size: 20px; vertical-align: middle;">Purchase Calculator</span></p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span> </button>
      </div>
      <div class="modal-body">
        <form class="row" name="calculator-form" action="" method="" enctype="multipart/form-data">
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
              <label class="form-check-label" for="inlineRadio2">Percentage(%)</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_on" id="inlineRadio3" value="2">
              <label class="form-check-label" for="inlineRadio1">Flat</label>
            </div>
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="discount_p_calc" id="discount_p_calc" placeholder="Enter Discount(%)" />
          </div>
		  <div class="form-group col-md-6">
            <label for="data_came">Discount Applied? : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_applied_state" id="inlineRadio6" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio2">Before GST</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_applied_state" id="inlineRadio5" value="2">
              <label class="form-check-label" for="inlineRadio1">After GST</label>
            </div>
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="gst_percentage_p_calc" id="gst_percentage_p_calc" placeholder="Enter GST Percentage" />
          </div>
		  <div class="form-group col-md-6">
		  	<input type="button" class="btn btn-primary" name="calc" id="calc" value="CALCULATE" style="width:100%;" />
         
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="hindizo_buying_price_p_calc" id="hindizo_buying_price_p_calc" placeholder="Hindizo Buying Price" />
          </div>
		  
		  <div class="form-group col-md-12">
		  	
            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="SUBMIT" style="width:100%;" />
          </div>
		  
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Deciding Price Calculator -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="dpcalculator" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p><img src="<?php echo base_url()?>/app-assets/images/logo/zobot.jpg" class="img-thumb" style="width: 20%;"  /> <span style="font-size: 20px; vertical-align: middle;">Deciding Price Calculator</span></p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span> </button>
      </div>
      <div class="modal-body">
        <form class="row" name="calculator-form" action="" method="" enctype="multipart/form-data">
          <div class="form-group col-md-6">
            <input type="text" class="form-control" name="product_name_d_api" id="product_name_d_api" placeholder="Enter Product Name" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="average_price__api" id="average_price_d_api" placeholder="Enter Average Selling Price" />
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="wproduct_name_d" id="wproduct_name_d" placeholder="Warehouse Product Name" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="purchase_price_d" id="purchase_price_d" placeholder="Warehouse Purchase Price" />
          </div>
		  
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="average_price_d" id="average_price_d" placeholder="Enter Average Selling Price" />
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
            <input type="text" class="form-control" name="gst_d" id="gst_d" placeholder="Enter Zo Selling Price(Incl GST.)" />
          </div>
		  <div class="form-group col-md-6">
            <input type="text" class="form-control" name="gst_toPaid_d" id="gst_toPaid_d" placeholder="Enter GST Amount to be paid" />
          </div>
		   <div class="form-group col-md-6">
            <input type="text" class="form-control" name="final_sell_price_d" id="final_sell_price_d" placeholder="Enter Zo Selling Net Price" />
          </div>
		  <div class="form-group col-md-12">
            <input type="button" class="btn btn-primary" name="dpcalc" id="dpcalc" value="CALCULATE" style="width:100%;" />
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<script>
	$('#inlineRadio1').click(function(){
		$('.manual').hide(300);
		$('.manual input').val('');
		$('.average input').val('');
		$('.average').removeClass('col-md-4').addClass('col-md-6');
		$('.average').next('div').removeClass('col-md-12').addClass('col-md-6');
		$('.average').next('div').find('input').val('');
	});
	$('#inlineRadio2').click(function(){
		$('.manual').show(300);
		$('.manual input').val('');
		$('.average input').val('');
		$('.average').removeClass('col-md-6').addClass('col-md-4');
		$('.average').next('div').removeClass('col-md-6').addClass('col-md-12');
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
	$('#calc').click(function(){
		
		if($('#buying_price_p_calc').val() == null || $('#buying_price_p_calc').val() == '' || $('#buying_price_p_calc').val() == ' '){
			swal('','Enter Buying Price','warning');
			$('#buying_price_p_calc').css('border','1px solid red');
		}else{
			
		}
	})
</script>

<?php  



?>

<script>
$('#dproduct_name').blur(function(){
	var product_name = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'products/getwarehouseProducts',
		cache : false,
		success : function(result){
			//console.log(result);
			//alert(result);
			/* $( "#dproduct_name" ).autocomplete({
				source: result;
			}); */
			//alert(result);
			
		}
	});
});
</script>


<script>
$( function() {
    var products = <?php echo json_encode($pname); ?>; 
    $( "#wproduct_name_d" ).autocomplete({
      source: products
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
	var purchase_price_d = parseFloat($('#purchase_price_d').val());
	var average_price_d = parseFloat($('#average_price_d').val());
	var discount_d = parseFloat($('#discount_d').val());
	var gst_d = parseFloat($('#gst_d').val());	
	var discount_type = parseFloat($("input[name='discount_on_d']:checked").val());
	alert(average_price_d);
	alert(discount_type);
	if(discount_type==2){
		var discount = discount_d;
	}else if(discount_type==1){
		var discount = ((average_price_d*discount_d)/100);
	}	
	var zo_selling_price = (average_price_d-discount);
	alert(zo_selling_price);
	var gst_value = ((zo_selling_price*gst_d)/100);
	$('#gst_toPaid_d').val(gst_value);
	var without_gst_price = (zo_selling_price-gst_value);
	$('#final_sell_price_d').val(without_gst_price);
});

</script>

<style>
 .ui-front {
    z-index: 2000 !important;
}
</style>

</html>
