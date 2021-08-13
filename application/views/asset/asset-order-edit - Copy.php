<div class="content-body">
    <div class="card">
        <div class="card-content">
           <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" enctype="multipart/form-data" >


                    <div class="row">

                        <div class="col-sm-4">

                        </div>

                        <div class="col-sm-3"></div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-3">

                        </div>

                    </div>

                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill From') ?> <?php /*?><a href='#'
                                                                                            class="btn btn-primary btn-sm rounded"
                                                                                            data-toggle="modal"
                                                                                            data-target="#addCustomer">
                                                <?php echo $this->lang->line('Add Supplier') ?><?php */?>
                                            </a>
                                    </div>
                                </div>
                               <?php
                               
                               ?>

                                <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('PO') ?></label>
                                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                   disabled>
                                                <option value="0" <?php if($product[0]['po_type']==0) echo 'selected'; ?>>Asset</option>
                                                <option value="1" <?php if($product[0]['po_type']==1) echo 'selected'; ?>>Job Work</option>
                                            </select>
                                 </div>
                                
                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"><?php echo $this->lang->line('Search Supplier') ?> </label>
                                        <input type="text" class="form-control" name="cst" id="supplier-box"
                                               placeholder="Enter Supplier Name or Mobile Number to search"
                                               autocomplete="off" disabled="" />

                                        <div id="supplier-box-result"></div>
                                    </div>

                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                    <?php echo $this->lang->line('Supplier Details') ?>
                                        <hr>
                                        
                                <div id="customer_name"><strong><?=$product[0]['supp_name']?></strong></div>
                            </div>
                            <div class="clientinfo">

                                <div id="customer_address1"><strong><?=$product[0]['supp_address']?><br><?=$product[0]['supp_city']. ',' . $product[0]['supp_country']?></strong></div>
                            </div>

                            <div class="clientinfo">

                                <div type="text" id="customer_phone">Phone: <strong><?=$product[0]['supp_phone']?></strong><br>Email: <strong><?=$product[0]['supp_email']?></strong></div>
                            </div>
                                    <hr><?php echo $this->lang->line('Warehouse') ?> 

                                     <input type="text" class="form-control" id="ware1" disabled value="<?=$product[0]['franchise_code']?>">
                                     
                                    <!--<select id="s_warehouses" name="warehouse_id"
                                                                                             class="selectpicker form-control" >
                                           <?php
                                           for($i=0;$i<count($result);$i++)
                                           {
                                            echo '<option value="'.$result[$i][id].'">'.$result[$i][title].'</option>';
                                           }                                                  
                                         ?>

                                    </select>-->
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">

                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('Purchase Order') ?> </h3>
                                    </div>

                                </div>
                                  <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst" class="caption"><?php echo $this->lang->line('Search Customer') ?> </label>
                                        <input type="text" class="form-control"
                                               value="<?=$product[0]['cust_name']?>" 
                                               autocomplete="off" disabled/>

                                
                                        <div id="supplier-box-result"></div>
                                    </div>

                                </div>
                                 <div id="customer">
                                    <div class="clientinfo">
                                        
                                        
                                        <div id=""></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="franchise_address1"></div>
                                    </div>

                                    <div class="clientinfo">

                                        <div type="text" id="franchise_phone"></div>
                                    </div>
                                   

                                    </select>
                                </div>
                                <div class="form-group row">
                            
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Order Number') ?> </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Invoice #"
                                                   name="invocieno"
                                                   value="<?php echo $product[0]['invoice_id']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?> </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Reference #"
                                                   name="refer" disabled="" value="<?php echo $product[0]['refer']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption"><?php echo $this->lang->line('Order Date') ?> </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date"                                                   data-toggle="datepicker"
                                                   autocomplete="false" value="<?php echo $product[0]['invoicedate'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption"><?php echo $this->lang->line('Order Due Date') ?> </label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required" id="tsn_due"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" data-toggle="datepicker" autocomplete="false" value="<?php echo $product[0]['invoiceduedate'] ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="taxformat"
                                               class="caption"><?php echo $this->lang->line('Tax') ?> </label>
                                        <input type="text" value="<?php echo $product[0]['tax'] ?>" disabled class="form-control" id="taxformat">
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                    id="discountFormatjj" disabled="">

                                                    <option value="%" <?php if($product[0]['format_discount']=='%') echo 'selected'; ?>><?php echo $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');?></option>
                                                <option value="flat" <?php if($product[0]['format_discount']=='flat') echo 'selected'; ?>><?php echo $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX'); ?></option>
                                                  <option value="b_p" <?php if($product[0]['format_discount']=='b_p') echo 'selected'; ?>><?php echo $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX'); ?> </option>
                                                <option value="bflat" <?php if($product[0]['format_discount']=='bflat') echo 'selected'; ?>><?php echo $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX') ?></option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Order Note') ?> </label>
                                        <textarea class="form-control" name="notes" rows="2"><?php echo $product[0]['notes']?></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">
                            <thead>

                            <tr class="item_header bg-gradient-directional-amber">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?>(%)</th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?php echo $this->config->item('currency'); ?>)
                                </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            for($i=0;$i<count($product);$i++)
                            {


                                ?>
                            <tr>
                                <input type="hidden" name="asset_ids[]" value="<?=$product[$i]['id']?>">
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='productname-<?php echo $i;?>" value="<?=$product[$i]['totaltax']?>' value="<?php echo $product[$i]['asset']?>">
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-<?php echo $i;?>"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="<?php echo $product[$i]['qty']?>"></td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-<?php echo $i;?>"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="<?php echo $product[$i]['price']?>"></td>
                                <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-<?php echo $i;?>"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="<?php echo $product[0]['tax']?>" disabled></td>
                                <td class="text-center" id="texttaxa-<?php echo $i;?>"><?=$product[$i]['totaltax']?></td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-<?php echo $i;?>"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off" value="<?php echo $product[$i]['discount']?>"></td>
                                <td><span class="currenty"><?php echo $this->config->item('currency'); ?></span>
                                    <strong><span class='ttlText' id="result-<?php echo $i;?>"><?php echo $product[$i]['subtotal']?></span></strong></td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-<?php echo $i;?>" value="<?=$product[$i]['totaltax']?>">
                                <input type="hidden" name="disca[]" id="disca-<?php echo $i;?>" value="<?=$product[$i]['totaldiscount']?>">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-<?php echo $i;?>" value="<?=$product[$i]['subtotal']?>">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-<?php echo $i;?>" value="0">
                                <input type="hidden" name="unit[]" id="unit-<?php echo $i;?>" value="<?=$product[$i]['unit']?>">
                                <input type="hidden" name="hsn[]" id="hsn-<?php echo $i;?>" value="">
                            </tr>


                            <tr>
                                <td colspan="8"><textarea id="dpid-0" class="form-control" name="product_description[]"
                                                          placeholder="<?php echo $this->lang->line('Enter Product description'); ?>"
                                                          autocomplete="off"><?php echo $product[$i]['product_des']?></textarea><br></td>
                            </tr>
                           <?php } ?>


                            <tr class="last-item-row">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right"><input type="hidden" value="<?=$product[0]['psubtotal']?>" id="subttlform"
                                                                     name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="taxr" class="lightMode"><?php echo $product[0]['ptax']?></span></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="discs" class="lightMode"><?php echo $product[0]['pdis']?></span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong><?php echo $this->lang->line('Shipping Charge') ?></strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" autocomplete="off"
                                                                    onkeyup="billUpyog();" value="<?php echo $product[0]['shipping']?>">
                                    ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                    <span id="ship_final">0</span> )
                                </td>
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
                                                                    id="invoiceyoghtml" readonly="" value=<?=$product[0]['psubtotal']?>>

                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <!--<td colspan="2"><?php echo $this->lang->line('Payment Terms') ?> <select name="pterms" class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select></td>-->
                                <td colspan="2">
                                    <!--<div>
                                        <label><?php echo $this->lang->line('Update Stock') ?></label>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight1" value="yes" checked="">
                                                <label class="custom-control-label"
                                                       for="customRadioRight1"><?php echo $this->lang->line('Yes') ?></label>
                                            </div>
                                        </fieldset>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight2" value="no">
                                                <label class="custom-control-label"
                                                       for="customRadioRight2"><?php echo $this->lang->line('No') ?></label>
                                            </div>
                                        </fieldset>

                                    </div>-->
                                </td>
                                <td align="right" colspan="4"><input type="submit" class="btn btn-success sub-btn"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?>"
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

<input type="hidden" value="asset/order_asset_update" id="action-url">
                    <?php
                    if($product[0]['po_type']==0)
                    {
                        ?>
                    <input type="hidden" value="asset_search" id="billtype">
                     <?php } ?>
                     <input type="hidden" value="<?php echo count($product); ?>" name="counter" id="ganak">
                    <input type="hidden" value="<?=$product[0]['po_type']?>" name="po_type">
                    <input type="hidden" value="<?=$product[0]['cid']?>" name="franchise_name">
                    <input type="hidden" value="<?=$product[0]['sid']?>" name="customer_id">
                    <input type="hidden" value="<?=$product[0]['tid']?>" name="invocieno">
                    <input type="hidden" value="<?=$product[0]['refer']?>" name="refer">
                    <input type="hidden" value="<?=$product[0]['invoicedate']?>" name="invoice_date">
                    <input type="hidden" value="<?=$product[0]['invoiceduedate']?>" name="invoice_due_date">
                    <input type="hidden" value="<?=$product[0]['format_discount']?>" id="discountFormat">
                    <input type="hidden" value="<?=$product[0]['wid']?>" name="warehouse_id">
                    <input type="hidden" value="<?=$product[0]['term']?>" name="pterms">
                     <input type="hidden" value="<?php echo $product[0]['tax'] ?>" class="form-control" name="product_tax">
                    <input type="hidden" value="<?=$ord_id?>" name="ord_id">

                    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                    <input type="hidden" value="<?=$product[0]['format_discount']; ?>" name="taxformat" id="tax_format">

                    <input type="hidden" value="<?=$product[0]['taxstatus']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">


                    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="<?=$product[0]['ship_tax_type']?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="<?=$product[0]['ship_tax']?>" name="ship_tax" id="ship_tax">

                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-success white">

                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Supplier') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" id="mcustomer_name" name="name" required>
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

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="email" placeholder="Email"
                                   class="form-control margin-bottom crequired" name="email" id="mcustomer_email">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="address"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Address"
                                   class="form-control margin-bottom " name="address" id="mcustomer_address1">
                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-sm-4">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country" id="mcustomer_country">
                        </div>

                    </div>

                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="TAX ID"
                                   class="form-control margin-bottom" name="taxid" id="tax_id">
                        </div>
                    </div>


                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="msupplier_add" class="btn btn-primary submitBtn"
                           value="<?php echo $this->lang->line('ADD') ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {  
    $("#franchise_name").autocomplete({  
        source: function(request,response) {  
            $.ajax({  
                url : baseurl+'asset/getProductRecords',  
                type: "POST",  
                dataType: "json",  
                data: { term: request.term },  
                success: function (data) {  
                    response($.map(data, function (item) {  
                        
                        $('#franchise').val(item.id);
                        $('#ware1').val(item.title);
                        $('#ware2').val(item.warehouse_id);
                        return { value: item.name};  
                    }))  
                }  
            })  
        }
    });  
});
</script>