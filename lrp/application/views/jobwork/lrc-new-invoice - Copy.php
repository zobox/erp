<?php 
/* echo "<pre>";
print_r($warehouse_list);
echo "</pre>"; exit; */
?>

<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
        <div class="alert alert-info">
          <?php echo $this->session->flashdata("messagePr") ?>
        </div>
        <?php } ?>
          <div class="card card-block">
            <div class="card-content">
              <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">×</a>
                <div class="message" id="msg"></div>
              </div>
              <div class="card-header p-0" style="border-bottom:none;">
                <h4 class="card-title">  New Invoice </h4>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <div id="customerpanel" class="inner-cmp-pnl">
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <h3 class="title">Bill To</h3> </div>
                      </div>
                      <div class="col-sm-12">
                        <div id="customer">						
                          <div id="customer_pass"></div> To Warehouse
                          <select id="to_warehouses1" name="to_warehouses1" class="form-control round required" disabled>
                            <option value="">Select Warehouse</option>
                            <?php foreach($warehouse_list as $key=>$warehouse){ ?>
                            <option value="<?php echo $warehouse->id; ?>" <?php if($warehouse->id==1){ ?> selected <?php } ?> ><?php echo $warehouse->title; ?></option>
                            <?php } ?>
                          </select>
						  <input type="hidden" name="to_warehouses" id="to_warehouses" value="1">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <label for="" class="caption mt-3">Serial No</label>
                        <div class="input-group">
                          <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                          <input type="text" class="form-control" placeholder="Serial No" name="serial" autocomplete="false" id="serial_no_lrp"> </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 cmp-pnl">
                    <div class="inner-cmp-pnl">
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <h3 class="title">Invoice Properties</h3> </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="invocieno" class="caption">Invoice Number</label>
                          <div class="input-group">
                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                            <input type="text" class="form-control round" placeholder="Invoice #" name="invocieno" value="8124" readonly="readonly"> </div>
                        </div>
                        <div class="col-sm-6">
                          <label for="invocieno" class="caption">Reference</label>
                          <div class="input-group">
                            <div class="input-group-addon"><span class="icon-bookmark-o" aria-hidden="true"></span></div>
                            <input type="text" class="form-control round" placeholder="Reference #" name="refer" readonly="readonly"> </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="invociedate" class="caption">Invoice Date</label>
                          <div class="input-group">
                            <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                            <input type="text" class="form-control round required" placeholder="Billing Date" name="invoicedate" data-toggle="datepicker" autocomplete="false" readonly="readonly"> </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="taxformat" class="caption">GST</label>
                          <select class="form-control round" disabled="" onchange="changeTaxFormat(this.value)" id="taxformat">
                            <option value="yes" data-tformat="yes" selected="">»On</option>
                            <option value="yes" data-tformat="yes">On</option>
                            <option value="inclusive" data-tformat="incl">Inclusive</option>
                            <option value="off" data-tformat="off">Off</option>
                            <option value="inclusive" data-tformat="cgst">CGST + SGST</option>
                            <option value="inclusive" data-tformat="igst">IGST</option>
                            <option value="inclusive" data-tformat="inclusive" data-trate="0">Marginal Scheme GST</option>
                            <option value="inclusive" data-tformat="igst" data-trate="28">Central GST 28%</option>
                            <option value="inclusive" data-tformat="cgst" data-trate="28">Local GST 28%</option>
                            <option value="inclusive" data-tformat="igst" data-trate="18">Central GST 18%</option>
                            <option value="inclusive" data-tformat="cgst" data-trate="18">Local GST 18%</option>
                            <option value="inclusive" data-tformat="igst" data-trate="12">Central GST 12%</option>
                            <option value="inclusive" data-tformat="cgst" data-trate="12">Local GST 12%</option>
                            <option value="inclusive" data-tformat="igst" data-trate="5">Central GST 5%</option>
                            <option value="inclusive" data-tformat="cgst" data-trate="5">Local GST 5%</option>
                            <option value="yes" data-tformat="igst" data-trate="28">Central GST 28%</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="discountFormat" class="caption"> Discount</label>
                            <select class="form-control round" disabled="" onchange="changeDiscountFormat(this.value)" id="discountFormat">
                              <option value="bflat">--Flat Discount Before TAX--</option>
                              <option value="%"> % Discount After TAX</option>
                              <option value="flat">Flat Discount After TAX</option>
                              <option value="b_p"> % Discount Before TAX</option>
                              <option value="bflat">Flat Discount Before TAX</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div id="saman-row">
                      <table class="table-responsive tfr my_stripe table-bordered">
                        <thead>
                          <tr class="item_header bg-gradient-directional-blue white">
                            <th width="30%" class="text-center">Item Name</th>
                            <th width="8%" class="text-center"> Quantity</th>
                            <th width="10%" class="text-center">Rate</th>
                            <th width="10%" class="text-center">GST(%)</th>
                            <th width="10%" class="text-center">GST</th>
                            <th width="7%" class="text-center"> Discount</th>
                            <th width="10%" class="text-center"> Code </th>
                            <th width="5%" class="text-center"> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                         <tr>
						 <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='sale_lrp-0'>
										    <input type="hidden" value="" id="cnt"></td>
						 <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"></td>
						 <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" readonly></td>
						 <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" readonly></td>
						 <td>0</td>
						 <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off" readonly></td>
						 <td><span class="currenty"><?php echo $this->config->item('currency'); ?></span>
                                    <strong><span class='ttlText' id="result-0">0</span></strong></td>
						 <td></td>
						</tr>
						<tr class="last-item-row">
							<!--<td class="add-row">
								<button type="button" class="btn btn-success" aria-label="Left Align"
										id="addproduct_sale_lrp">
									<i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
								</button>
							</td>
							<td colspan="7"></td>-->
						</tr>
                          
                        </tbody>
                      </table>
					  <table style="margin-top:20px;">
					  <thead>
					  <tr class="">
                            <td width="30%" class="text-center"></td>
                            <th width="8%" class="text-center"> </th>
                            <th width="10%" class="text-center"></th>
                            <th width="10%" class="text-center">	</th>
                            <th width="10%" class="text-center"></th>
                            <th width="7%" class="text-center"></th>
                            <th width="10%" class="text-center"></th>
                            <th width="5%" class="text-center"></th>
                          </tr>
						  
						  </thead>
						<tbody>
						<tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right">
                              <input type="hidden" value="0" id="subttlform" name="subtotal"><strong> Total Gst</strong> </td>
                            <td align="left" colspan="2"><span class="currenty lightMode"> ₹</span> <span id="taxr" class="lightMode">0</span></td>
                          </tr>
                          <tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right"> <strong> Total Discount</strong></td>
                            <td align="left" colspan="2"><span class="currenty lightMode"> ₹</span> <span id="discs" class="lightMode">0</span></td>
                          </tr>
                          <tr class="sub_c" style="display: table-row;">
                            <td colspan="2"></td>
                            <td colspan="4" align="right"><strong> Grand Total                                        (<span class="currenty lightMode"> ₹</span>)</strong> </td>
                            <td align="left" colspan="2">
                              <input type="text" name="total" class="form-control" id="invoiceyoghtml" readonly=""> </td>
                          </tr>
                          <tr class="sub_c" style="display: table-row;text-align: center;">
                            <td align="right" colspan="3">
                              <input type="submit" class="btn btn-success sub-btn" value="Generate Order" id="submit-data" data-loading-text="Creating..."> </td>
                          </tr>
						</tbody>

					  </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>


<script>
$("#serial_no_lrp").change(function()
{
	var serial = $('#serial_no_lrp').val();
	alert(serial);
    if($('#sale_lrp-0').val()=='')
    {
		//alert('if');
		$.ajax({
            url: baseurl + 'search_products/search_product_lrp',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val(),
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) {
               console.log(data);
				if(data[0]!=null)
				{
				var t_r = data[3];         
			   
				
				var discount = data[4];
				var custom_discount = $('#custom_discount').val();
				if (custom_discount > 0) discount = deciFormat(custom_discount);
				//alert(data[1]);
				//var purchase_price = ((data[1]*100)/(100+t_r));
				var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
				//alert(purchase_price);
				$('#sale_lrp-0').val(data[0]);
				$('#amount-0').val(1);
				//$('#price-0').val(data[1]);
				$('#price-0').val(purchase_price);
				$('#pid-0').val(data[2]);
				//$('#vat-0').val(t_r);
				$('#vat-0').val(0);
				$('#discount-0').val(discount);
				$('#dpid-0').val(data[5]);
				$('#unit-0').val(data[6]);
				$('#hsn-0').val(data[7]);
				$('#alert-0').val(data[8]);
				$('#serialNo-0').val(data[10]);
				$('#serial_id-0').val(data[10]);



				rowTotal(0);

				billUpyog();
				serial = $('#serial_no_lrp').val('');

				$('#cnt').val('1');

				}
			}
        });
	}
	else
	{     
	//alert('else');
     $.ajax({
            url: baseurl + 'search_products/search_product_lrp',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val(),
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);
        var t_r = data[3];
         
        //if(data[0]!=null && $('#productname-0').val()!='' && $('#cnt').val()==1)
        if(data[0]!=null && $('#sale_lrp-0').val()!='')
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
		var nxt = parseInt(cvalue);
		$('#ganak').val(nxt);
		var functionNum = "'" + cvalue + "'";
		count = $('#saman-row div').length;

		//var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no11[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="sale_lrp-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		 //ajax request
		 //$('#saman-row').append(row);
		$('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
		//alert(purchase_price);
		
        $('#sale_lrp-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        //$('#price-'+cvalue).val(data[1]);
        $('#price-'+cvalue).val(purchase_price);
        $('#pid-'+cvalue).val(data[2]);
        //$('#vat-'+cvalue).val(t_r);
        $('#vat-'+cvalue).val(0);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
		var page = '';
		var totalValue = 0;
		var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
		var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
		var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
		var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
		var taxo = 0;
		var disco = 0;
		var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
		var tax_status = $("#taxformat option:selected").val();
		var disFormat = $("#discount_format").val();
		if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
			var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
			if (alertVal <= +amountVal) {
				var aqt = alertVal-amountVal;
				alert('Low Stock! ' + accounting.formatNumber(aqt));
			}
		}
		//tax after bill
		if (tax_status == 'yes') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = precentCalc(totalPrice, vatVal);
				totalValue = totalPrice + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
	//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

				//tax
				var Inpercentage = precentCalc(totalValue, vatVal);
				totalValue = totalValue + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else if (tax_status == 'inclusive') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalPrice;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
			//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalValue;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else {
			taxo = 0;
			if (disFormat == '%' || disFormat == 'flat') {
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

			} else {
			//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
			}
		}
		//alert(Math.ceil(totalValue));
		totalValue = Math.ceil(totalValue);
		$("#result-" + numb).html(accounting.formatNumber(totalValue));
		$("#taxa-" + numb).val(taxo);
		$("#texttaxa-" + numb).text(taxo);
		$("#disca-" + numb).val(disco);
		$("#total-" + numb).val(accounting.formatNumber(totalValue));
		samanYog();
         

        ///rowTotal(0);
        billUpyog();
        serial = $('#serial_no_lrp').val('');
          }                
           
		   }
        });
}
});
</script>