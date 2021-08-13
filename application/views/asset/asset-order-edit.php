<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">


                    <div class="row">

                          
                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill From') ?> <a href='#'
                                                                                            class="btn btn-primary btn-sm rounded"
                                                                                            data-toggle="modal"
                                                                                            data-target="#addCustomer">
                                                <?php echo $this->lang->line('Add Supplier') ?>
                                            </a>
                                    </div>
                                </div>

                                 <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('PO') ?></label>
                                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                   name="po_type">
                                                <option value="0" <?php if($product[0]['po_type']==0) echo 'selected'; ?>>Asset</option>
                                                <option value="1" <?php if($product[0]['po_type']==1) echo 'selected'; ?>>Civil Work</option>
                                            </select>
                                            <input type="hidden" name="po_typekkk" value="<?=$product[0]['po_type']?>">
                                            <input type="hidden" value="<?=$product[0]['cid']?>" name="franchise_name111">
                    <input type="hidden" value="<?=$product[0]['sid']?>" name="customer_idjjj">
                                 </div>
                               

                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"><?php echo $this->lang->line('Search Supplier') ?></label>
                                        <input type="text" class="form-control" name="cst" id="supplier-box"
                                               placeholder="Enter Supplier Name or Mobile Number to search"
                                               autocomplete="off"/>

                                        <div id="supplier-box-result"></div>
                                    </div> 

                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                         <input type="hidden" name="franchise_id" id="franchise_id" value="0">

                                         <input type="hidden" name="customer_id" id="customer_id" value="<?=$product[0]['sid']?>">
                                        <?php echo $this->lang->line('Supplier Details') ?>
                                        <hr>
                                        <?php echo '
                                <div id="customer_name"><strong>' . $product[0]['supp_name'] . '</strong></div>
                            </div>
                            <div class="clientinfo">

                                <div id="customer_address1"><strong>' . $product[0]['supp_address'] . '<br>' . $product[0]['supp_city'] . ',' . $product[0]['supp_country'] . '</strong></div>
                            </div>

                            <div class="clientinfo">

                                <div type="text" id="customer_phone">Phone: <strong>' . $product[0]['supp_phone'] . '</strong><br>Email: <strong>' . $product[0]['supp_email'] . '</strong></div>
                            </div>'; ?>
                                        <hr><?php echo $this->lang->line('Warehouse') ?> <input type="text" class="form-control" id="ware1" disabled value="<?=$product[0]['warehouse_title']?>">
                                     <input type="hidden" class="form-control" name="warehouse_id" id="ware2" >                                    </div>


                                </div>
                            </div>
                            <div class="col-sm-6 cmp-pnl">
                                <div class="inner-cmp-pnl">
 

                                    <div class="form-group row">

                                        <div class="col-sm-12"><h3
                                                    class="title"> <?php echo $this->lang->line('Purchase Order Properties') ?></h3>
                                        </div>

                                    </div>
                                     <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst" class="caption"><?php echo $this->lang->line('Search Customer') ?> </label>
                                       <select name="franchise_name" class="form-control" id="franchise_name">
                                          <option value="">Select Franchise Name</option>
                                          <?php
                                         
                                           foreach($franchies as $customer=>$customer_row)
                                          {

                                            ?>
                                             <option value="<?=$customer_row->id.'/'.$customer_row->title.'/'.$customer_row->warehouse_id?>" <?php if($product[0]['customer_id']==$customer_row->id) echo 'selected';?>><?=$customer_row->name?></option>
                                             <?php
                                          }
                                          ?>
                                          ?>
                                      </select>  

                                
                                        <div id="supplier-box-result"></div>
                                    </div>

                                </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6"><label for="invocieno"
                                                                     class="caption"> <?php echo $this->lang->line('Purchase Order') ?>
                                                #</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                     aria-hidden="true"></span></div>
                                                <input type="text" class="form-control" placeholder="Purchase Order #"
                                                       name="invocieno"
                                                       value="<?php echo $invoice['tid']; ?>"><input
                                                        type="hidden"
                                                        name="iid"
                                                        value="<?php echo $invoice['iid']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6"><label for="invocieno"
                                                                     class="caption"> <?php echo $this->lang->line('Reference') ?></label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                     aria-hidden="true"></span></div>
                                                <input type="text" class="form-control" placeholder="Reference #"
                                                       name="refer"
                                                       value="<?php echo $product[0]['refer'] ?>" id="refer">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-sm-6"><label for="invociedate"
                                                                     class="caption"> <?php echo $this->lang->line('Order Date') ?></label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                                     aria-hidden="true"></span></div>
                                                <input type="text" class="form-control required editdate"
                                                       placeholder="Billing Date" name="invoicedate"
                                                       autocomplete="false"
                                                       value="<?php echo dateformat($invoice['invoicedate']) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6"><label for="invocieduedate"
                                                                     class="caption"><?php echo $this->lang->line('Order Due Date') ?></label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                     aria-hidden="true"></span></div>
                                                <input type="text" class="form-control required editdate"
                                                       name="invocieduedate"
                                                       placeholder="Due Date" autocomplete="false"
                                                       value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="taxformat"
                                                   class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                            <select class="form-control round" onchange="changeTaxFormat(this.value)"
                                                    id="taxformat" name="tax_handle">

                                                <?php echo $taxlist; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="discountFormat"
                                                       class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                                <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                        id="discountFormat" name="discountFormat">
                                                    <?php echo '<option value="' . $product[0]['format_discount'] . '">' . $this->lang->line('Do not change') . '</option>'; ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="toAddInfo"
                                                   class="caption"><?php echo $this->lang->line('Order Note') ?></label>
                                            <textarea class="form-control" name="notes"
                                                      rows="2"><?php echo $product[0]['notes']?></textarea></div>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div id="saman-row">
                            <table class="table-responsive tfr my_stripe">

                                <thead>
                                <tr class="item_header bg-gradient-directional-amber">
                                    <th width="30%"
                                        class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                    <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?>(%)</th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                                    <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?>
                                        (<?php echo $this->config->item('currency'); ?>)
                                    </th>
                                    <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                foreach ($products as $row) {

                                    echo '<tr >
                        <td><input type="text" class="form-control asset_product" name="product_name[]" placeholder="Enter Product name or Code"  value="' . $row['asset'] . '" id="productname-'.$i.'" autocomplete="off" data-trate="'.$i.'">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . amountFormat_general($row['qty']) . '" ><input type="hidden" name="old_product_qty[]" value="' . amountFormat_general($row['qty']) . '" ></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . edit_amountExchange_s($row['price'], $invoice['multi'], $this->aauth->get_user()->loc) . '"></td>
                        <td> <input type="text" class="form-control vat" name="product_tax[]" readonly id="vat-' . $i . '"
                                    onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                    autocomplete="off" value="'.$product[0][tax].'"></td>
                        <td class="text-center" id="texttaxa-' . $i . '">' . edit_amountExchange_s($row['totaltax'], $invoice['multi'], $this->aauth->get_user()->loc) . '</td>
                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-' . $i . '"
                                   onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . amountFormat_general($row['discount']) . '"></td>
                        <td><span class="currenty">' . $this->config->item('currency') . '</span>
                            <strong><span class="ttlText" id="result-' . $i . '">' . edit_amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '</span></strong></td>
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . edit_amountExchange_s($row['totaltax'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . edit_amountExchange_s($row['totaldiscount'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . edit_amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                         <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">   <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">
                    </tr><tr class="desc_p"><td colspan="8"><textarea id="dpid-' . $i . '" class="form-control" name="product_description[]" placeholder="Enter Product description" autocomplete="off">' . $row['product_des'] . '</textarea><br></td></tr>';
                                    $i++;
                                } ?>
                                <tr class="last-item-row sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success" id="addproduct-asset">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                        </button>
                                    </td>
                                    <td colspan="7"></td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" align="right">
                                        <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                    </td>
                                    <td align="left" colspan="2"><span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                        <span id="taxr"
                                              class="lightMode"><?= edit_amountExchange_s($invoice['tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                                    </td>
                                </tr>
                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" align="right">
                                        <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                    <td align="left" colspan="2"><span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                        <span id="discs"
                                              class="lightMode"><?php echo edit_amountExchange_s($invoice['discount'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                                    </td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" align="right"><input type="hidden"
                                                                         value="<?php echo edit_amountExchange_s($invoice['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) ?>"
                                                                         id="subttlform"
                                                                         name="subtotal"><strong><?php echo $this->lang->line('Shipping') ?></strong>
                                    </td>
                                    <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                        onkeypress="return isNumber(event)"
                                                                        placeholder="Value"
                                                                        name="shipping" autocomplete="off"
                                                                        onkeyup="billUpyog()"
                                                                        value="<?php if ($invoice['ship_tax_type'] == 'excl') {
                                                                            $invoice['shipping'] = $invoice['shipping'] - $invoice['ship_tax'];
                                                                        }
                                                                        echo amountExchange_s($invoice['shipping'], $invoice['multi'], $this->aauth->get_user()->loc); ?>">( <?= $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                        <span id="ship_final"><?= edit_amountExchange_s($invoice['ship_tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?> </span>
                                        )
                                    </td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="2"><?php if ($exchange['active'] == 1){
                                        echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                        <select name="mcurrency"
                                                class="selectpicker form-control">

                                            <?php
                                            echo '<option value="' . $invoice['multi'] . '">Do not change</option><option value="0">None</option>';
                                            foreach ($currency as $row) {

                                                echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                            } ?>

                                        </select><?php } ?></td>
                                    <td colspan="4" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                            (<span
                                                    class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                    </td>
                                    <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                        id="invoiceyoghtml"
                                                                        value="<?= edit_amountExchange_s($invoice['total'], $invoice['multi'], $this->aauth->get_user()->loc); ?>"
                                                                        readonly="">

                                    </td>
                                </tr>
                               <tr class="sub_c" style="display: table-row;">
                                  
                                    <td align="right" colspan="4"><input type="submit" class="btn btn-success sub-btn"
                                                                         value="<?php echo $this->lang->line('Update Order') ?>"
                                                                         id="submit-data"
                                                                         data-loading-text="Updating...">
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" value="asset/order_asset_update" id="action-url">
                  
                        <input type="hidden" value="asset_search" id="billtype">
                     
                        <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
                        <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">

                        <input type="hidden" value="<?= $this->common->taxhandle_edit($invoice['taxstatus']) ?>"
                               name="taxformat" id="tax_format">
                        <input type="hidden" value="<?= $invoice['format_discount']; ?>" name="discountFormat1"
                               id="discount_format">
                        <input type="hidden" value="<?= $invoice['taxstatus']; ?>" name="tax_handlegg" id="tax_status">
                        <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                          <input type="hidden" value="<?php echo $product[0]['tax'] ?>" disabled class="form-control" id="pro_tax">
                          <input type="hidden" value="<?=$product[0]['wid']?>" name="warehouse_idddd">
                        <input type="hidden" value="<?php
                        $tt = 0;
                        if ($invoice['ship_tax_type'] == 'incl') $tt = @number_format(($invoice['shipping'] - $invoice['ship_tax']) / $invoice['shipping'], 2, '.', '');
                        echo amountFormat_general(number_format((($invoice['ship_tax'] / $invoice['shipping']) * 100) + $tt, 3, '.', '')); ?>"
                               name="shipRate" id="ship_rate">
                        <input type="hidden" value="<?= $invoice['ship_tax_type']; ?>" name="ship_taxtype"
                               id="ship_taxtype">
                        <input type="hidden" value="<?= amountFormat_general($invoice['ship_tax']); ?>" name="ship_tax"
                               id="ship_tax">


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
                <div class="modal-header">

                    <h4 class="modal-title"
                        id="myModalLabel"><?php echo $this->lang->line('Add Supplier') ?></h4>
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
                                   class="form-control margin-bottom crequired" name="email"
                                   id="mcustomer_email">
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


                        <div class="col-sm-6">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>

                    </div>

                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country" id="mcustomer_country">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox">
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
<script type="text/javascript"> $('.editdate').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
$(document).ready(function () {  
    $("#franchise_name").change(function(){
        var franchise_value = $('#franchise_name').val();
        var franchise_val = franchise_value.split('/');
      
        $('#franchise_id').val(franchise_val[0]);
        $('#ware1').val(franchise_val[1]);
        $('#ware2').val(franchise_val[2]);
        $('#refer').val(franchise_val[1])
        //alert(franchise_value);
    });
    }); 

</script>