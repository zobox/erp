<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" method="post" action="<?php echo  base_url(); ?>invoices/actionstr">
                    <div class="row">
					
						<div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill To') ?> </h3>
                                    </div>
                                </div>
                               
                                <div id="customer">
                                    <div id="customer_pass"></div><?php echo $this->lang->line('From Warehouse') ?> <select
                                            id="s_warehouses" name="s_warehouses"
                                            class="form-control round">
                                        <?php //echo $this->common->default_warehouse();
                                          foreach ($fwarehouse as $row) {
                                            echo '<option value="' . $row->id . '">' . $row->title . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 pt-4 pl-0 pb-2"><label for=""
                                                                 class="caption"><?php echo $this->lang->line('Serial No'); ?></label>

                                        <div class="input-group" style="width:572px;">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Serial No" name="serial"                                                   
                                                   autocomplete="false" id="serial_no_stock_return">
                                        </div>
                                    </div>
                               
                                </div>
                        </div>
					
												
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">

                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('Invoice Properties') ?></h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Invoice #"
                                                   name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Reference #"
                                                   name="refer" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" readonly="readonly">
                                        </div>
                                    </div>
                                    
                                </div>
								
								<div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="taxformat"
                                               class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                        <select class="form-control round" disabled
                                                onchange="changeTaxFormat(this.value)"
                                                id="taxformat">

                                            <?php echo $taxlist; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <select class="form-control round" disabled
                                                    onchange="changeDiscountFormat(this.value)"
                                                    id="discountFormat">

                                                <?php echo $this->common->disclist() ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								
                            </div>
                        </div>

                    </div>

                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">
                            <thead>

                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?>(%)</th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Code') ?>
                                </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>
                            </thead>
                            <tbody>
							
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='stock_return-0'>
										    <input type="hidden" value="" id="cnt">
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"></td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" readonly></td>
                                <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" readonly></td>
                                <td class="text-center" id="texttaxa-0">0</td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off" readonly></td>
                                <td><span class="currenty"><?php echo $this->config->item('currency'); ?></span>
                                    <strong><span class='ttlText' id="result-0">0</span></strong></td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                <input type="hidden" name="unit[]" id="unit-0" value="">
								<input type="hidden" name="hsn[]" id="hsn-0" value="">
								<input type="hidden" name="serial_no[]" id="serial_id-0" value="">
                            </tr>
							
                            <tr>
                                <td colspan="8"><textarea id="dpid-0" class="form-control" name="product_description[]"
                                                          placeholder="<?php echo $this->lang->line('Enter Product description'); ?>"
                                                          autocomplete="off"></textarea><br></td>
                            </tr>

                            <tr class="last-item-row">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct_stock_return">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right"><input type="hidden" value="0" id="subttlform"
                                                                     name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="taxr" class="lightMode">0</span></td>
                            </tr>
							
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="discs" class="lightMode">0</span></td>
                            </tr>

                            

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2"><?php if ($exchange['active'] == 1){
                                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                        <option value="0">Default</option>
                                        <?php foreach ($currency as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                        } ?>

                                    </select><?php } ?></td>
                                <td colspan="4" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                    id="invoiceyoghtml" readonly="">

                                </td>
                            </tr>
                            
                            
                           
                            
                            <tr class="sub_c" style="display: table-row;text-align: center;">                                
                                <td align="right" colspan="3"><input type="submit" class="btn btn-success sub-btn"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?>"
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
					
					
					
                    <!--<input type="text" name="s_warehouses" value="<?php echo $wid; ?>" id="s_warehouses1">-->
                    <input type="hidden" name="franchise_id" value="<?php echo $franchise_id; ?>" id="franchise_id">
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="invoices/actionstr" id="action-url">
                    <!--<input type="hidden" value="search_product_by_serialb2b" id="billtype">-->
                    <input type="hidden" value="stock_return" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">
                </form>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="Pos_addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal" action="<?php echo base_url(); ?>invoices/add_customers">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-blue white">
                    <i class="icon-user-plus"></i> Add Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Customer Details</h5>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>
                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('GST') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="GST"
                                           class="form-control margin-bottom " name="address"
                                           id="mcustomer_address1">
                                </div>
                            </div>

                            
                        </div>


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add1" class="btn btn-primary submitBtn" value="ADD"/ >
                </div>
            </form>
        </div>
    </div>
</div>







<script type="text/javascript">

$('#from_location').on('change',function(event){
    var productcat = $(this).val();
     $.ajax({
      type : 'POST',
      url : baseurl+'invoices/getToLocation',
      data : {id : productcat},
      cache : false,
      success : function(result){
        
        $('#to_location').html(result);
        //$('.sub-sub-category').show();
      }
    });
}); 



/* $('#s_warehouses').change(function(){
	var id = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'stock_transfer/getwarehouseDropDown',			
		data : {id:id},		
		cache : false,
		success : function(result){				
			if(result!=null){
				$( "#tow" ).html(result);				
			}else{				
				
			}
		}
	});
});  */ 
</script>