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
                          <h3 class="title">
                                             Bill To </h3> </div>
                      </div>
                      <div class="col-sm-12">
                        <div id="customer">
                          <div id="customer_pass"></div> To Warehouse
                          <select id="to_warehouses" name="to_warehouses" class="form-control round required">
                            <option value="">Select Warehouse</option>
                            <option value="20">Trc_Noida-Noida</option>
                            <option value="21">Trc_Delhi-abc</option>
                            <option value="22">Trc_Delhi-pqr</option>
                          </select>
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
						 <td>1</td>
						 <td>2</td>
						 <td>2</td>
						 <td>2</td>
						 <td>sdf</td>
						 <td>asdf</td>
						 <td>asdf</td>
						 <td>sdaf</td>
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