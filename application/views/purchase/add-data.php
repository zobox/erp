<div class="content-body">
    <div class="card">
        <div class="card-content">
                <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message" id="msg"></div>
    </div>
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add Data') ?></h4>
            
                <div class="card-body px-0">
                    <hr />
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control margin-bottom"  style="height: 55px;" value="<?=$purchase_detail[0]->name?>" readonly>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                   PO List
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control margin-bottom" style="height: 55px;" value="<?=$purchase_id?>" readonly>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                   Product Name
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control margin-bottom" style="height: 55px;" value="<?=$product_detail[0]['product_name']?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                    Job Work Required
                                </label>
                                <div class="col-sm-8">
                                    <select id="test" class="form-control" style="height: 55px;" required="">
                                        <option value="">Select Option</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="<?=base_url()?>purchase/add_recevive_goods_info" onSubmit="return valid()">
                     <input type="hidden" name="jobwork_type" id="jobwork" value="">
                     <input type="hidden" name="jobwork_supplier_id" value="<?=$purchase_detail[0]->supplier_id?>">
                                    <input type="hidden" name="jobwork_purchase_id" value="<?=$purchase_detail[0]->purchase_id?>">
                                    <input type="hidden" name="jobwork_pid" value="<?=$purchase_detail[0]->pid?>">
                                    <input type="hidden" name="jobwork_varient_type" value="<?=$product_detail[0]['unit_name']?>">
                                    <input type="hidden" name="jobwork_color_name" value="<?=$product_detail[0]['colour_name']?>">
                                    <input type="hidden" name="jobwork_zupc_code" value="<?=$product_detail[0]['warehouse_product_code']?>">
                                    <input type="hidden" name="product_name" value="<?=$product_detail[0]['product_name']?>">
                                     <input type="hidden" name="brand_name" value="<?=$product_detail[0]['brand_name']?>">
                    <div class="multi-field-wrapper" id="Yes">
                        <div class="multi-fields">
                            <div class="multi-field">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="brand">
                                                <?php echo $this->lang->line('Add Varient') ?>
                                            </label>
                                            <div class="col-sm-7">
                                               <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['unit_name']?></option>

                                                    
                                                </select> 
                                            </div>
                                        </div>
                                        

                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="IMEI-1">
                                                Current Grade
                                            </label>
                                            <div class="col-sm-7">
                                                <select class="form-control" style="height: 55px;" name="current_grade[]" required="">
                                                    <option value="">Select Current Grade</option>
                                                    <option value="1">Ok</option>
                                                    <option value="2">Good</option>
                                                    <option value="3">Super</option>
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('Add Sticker No') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no[]" style="height: 55px;" required=""> </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="franchise_fee">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 1') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="serial_no1[]" style="height: 55px;" required=""> </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="Engineer">
                                                <?php echo $this->lang->line('Add QC Engineer Name') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="qc_engineer[]" style="height: 55px;" required=""> </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="space_required">
                                                <?php echo $this->lang->line('Add Colour') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['colour_name']?></option>
                                                    
                                                </select> 
                                             </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="IMEI-1">
                                                Final Grade
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" style="height: 55px;" name="final_grade[]" required="">
                                                    <option value="">Select Final Grade</option>
                                                    <option value="1">Ok</option>
                                                    <option value="2">Good</option>
                                                    <option value="3">Super</option>
                                                    
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('ZUPC Code') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['warehouse_product_code']?></option>
                                                    
                                                </select> </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="IMEI-2">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 2') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control margin-bottom" name="imei_2[]" required="" style="height: 55px;"> </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="replaced_items">
                                                <?php echo $this->lang->line('Add Item to be replaced') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control margin-bottom" name="items[]" required="" style="height: 55px;"> </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <button type="button" class="remove-field remove-quote-btbx btn bg-danger text-white"><i class="fa fa-close" aria-hidden="true"></i> Delete Row</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="add-field btn btn-info add-row-quotebxk"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Row</button>
                            
                            <button type="submit" class="btn btn-success ">Submit</button>
                        </div>
                    </div>
                </form>

                <form method="post" enctype="multipart/form-data" action="<?=base_url()?>purchase/add_recevive_goods_info">
                    <input type="hidden" name="jobwork_type" id="jobwork_not_required" value="">
                    <input type="hidden" name="supplier_id" value="<?=$purchase_detail[0]->supplier_id?>">
                                    <input type="hidden" name="purchase_id" value="<?=$purchase_detail[0]->purchase_id?>">
                                    <input type="hidden" name="pid" value="<?=$purchase_detail[0]->pid?>">
                                    <input type="hidden" name="varient_type" value="<?=$product_detail[0]['unit_name']?>">
                                    <input type="hidden" name="color_name" value="<?=$product_detail[0]['colour_name']?>">
                                    <input type="hidden" name="zupc_code" value="<?=$product_detail[0]['warehouse_product_code']?>">
                                    <input type="hidden" name="product_name" value="<?=$product_detail[0]['product_name']?>">
                                    <input type="hidden" name="brand_name" value="<?=$product_detail[0]['brand_name']?>">
                    <div class="multi-field-wrapper" id="No" style="display: none;">

                        <div class="multi-fields">
                            <div class="multi-field">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="brand">
                                                <?php echo $this->lang->line('Add Varient') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['unit_name']?></option>
                                                    
                                                </select> 
                                            </div>
                                        </div>
                                        
                                         
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="IMEI-1">
                                                Current Grade
                                            </label>
                                            <div class="col-sm-7">
                                                <select class="form-control" style="height: 55px;" name="current_grade[]" required="">
                                                   <option value="">Select Final Grade</option>
                                                    <option value="1">Ok</option>
                                                    <option value="2">Good</option>
                                                    <option value="3">Super</option>
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('Add Sticker No') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="sticker_no[]" required="" style="height: 55px;"> </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label" for="franchise_fee">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 1') ?>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control margin-bottom" name="serial_no1[]" required="" style="height: 55px;"> </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="space_required">
                                                <?php echo $this->lang->line('Add Colour') ?>
                                            </label>
                                            <div class="col-sm-8">
                                               <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['colour_name']?></option>
                                                    
                                                </select> 
                                             </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="IMEI-1">
                                                Final Grade
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" style="height: 55px;" name="final_grade[]" required="">
                                                   <option value="">Select Final Grade</option>
                                                    <option value="1">Ok</option>
                                                    <option value="2">Good</option>
                                                    <option value="3">Super</option>
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="product_label">
                                                <?php echo $this->lang->line('ZUPC Code') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" style="height: 55px;"  disabled="">
                                                    <option><?=$product_detail[0]['warehouse_product_code']?></option>
                                                    
                                                </select>
                                                 </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="IMEI-2">
                                                <?php echo $this->lang->line('Add IMEI / Serial No 2') ?>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control margin-bottom" name="imei_2[]" style="height: 55px;" required=""> </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>
                                <button type="button" class="remove-field remove-quote-btbx btn bg-danger text-white"><i class="fa fa-close" aria-hidden="true"></i> Delete Row</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="add-field btn btn-info add-row-quotebxk"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Row</button>
                            
                            <button type="submit" class="btn btn-success ">Submit</button>
                        </div>
                    </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if($('.multi-field', $wrapper).length > 1) $(this).parent('.multi-field').remove();
    });
});
</script>
<script>
$('#test').on('change', function() {
  //  alert( this.value ); // or $(this).val()
  if(this.value == "1") {
    $('#Yes').show();
    $('#No').hide();

    $('#jobwork').val('1');
    $('#jobwork_not_required').val('');
    

  } else {
    $('#jobwork_not_required').val('2');
    $('#jobwork').val('');
    $('#Yes').hide();
    $('#No').show();
    
  }
});
function valid()
{
    if(document.getElementById('test').value=='')
    {
        document.getElementById('notify').style.display='block';
        document.getElementById('msg').innerHTML='Please Select Job Work Type';
        document.getElementById('notify').focus();
        document.getElementById('test').focus();
        return false;
    }
}

</script>
