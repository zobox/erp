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
                                           id='sale_lrp-0'>
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
                                <!--<td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct_sale_lrp">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>-->
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
					
					<?php
					/* <!--<input type="text" name="s_warehouses" value="<?php echo $wid; ?>" id="s_warehouses1">-->
                    <input type="hidden" name="franchise_id" value="<?php echo $franchise_id; ?>" id="franchise_id">
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="invoices/actionlrp" id="action-url">
                    <!--<input type="hidden" value="search_product_by_serialb2b" id="billtype">-->
                    <input type="hidden" value="sale_lrp" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?//= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?//= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?//= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="bflat"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?//= amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="<?//= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">   */
					?>
					
					<!--<input type="text" name="s_warehouses" value="" id="s_warehouses1">-->
                    <input type="hidden" name="franchise_id" value="" id="franchise_id">
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="invoices/actionlrp" id="action-url">
                    <!--<input type="hidden" value="search_product_by_serialb2b" id="billtype">-->
                    <input type="hidden" value="sale_lrp" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value=" ₹" name="currency">
                    <input type="hidden" value="%" name="taxformat" id="tax_format">
                    <input type="hidden" value="yes" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="bflat"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="18.00"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="incl" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">
					
					
					
					
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




