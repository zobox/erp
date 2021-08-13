<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add Data') ?></h4>
            <div class="card-content">
                <form method="post" enctype="multipart/form-data" action="<?=base_url()?>purchase/receive_good_add_item">
                <div class="card-body px-0">
                    <?php
                    /*echo '<pre>';
                    print_r($supplier_list);
                    die;*/
                    ?>
                    <hr />
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Supplier
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="product_cat" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                      <?php

                                      foreach($supplier_list as $supplier)
                                      {
                                        ?>
                                        <option value="<?=$supplier->id?>"><?=$supplier->company?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    <?php echo $this->lang->line('Pending PO List') ?>
                                </label>
                                <div class="col-sm-7">
                                  <select id="sub_cat" name="purchase_id" class="form-control select-box" required>
                                  <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Items
                                </label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="sub_sub_cat" name="product_id" required="">
                                       <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Receiving Good Quantity
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control margin-bottom" name="qty" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12" style="display: none;" id="product_info">
                            <!--<table  class="table table-striped table-bordered zero-configuration mt-3">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('No') ?></th>
                                    <th><?php echo $this->lang->line('ZUPC Code') ?></th>
                                    <th><?php echo $this->lang->line('Items') ?></th>
                                    <th><?php echo $this->lang->line('Variant') ?></th>
                                    <th><?php echo $this->lang->line('Color') ?></th>
                                    <th><?php echo $this->lang->line('Condition') ?></th>
                                    <th><?php echo $this->lang->line('Qty') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ZO_EX_REDMI_6PRO</td>
                                        <td>realme Narzo 30A</td>
                                        <td>( 1 GB/32 GB )</td>
                                        <td>Black</td>
                                        <td>Good</td>
                                        <td>15</td>
                                        
                                    </tr>
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th><?php echo $this->lang->line('No') ?></th>
                                    <th><?php echo $this->lang->line('ZUPC Code') ?></th>
                                    <th><?php echo $this->lang->line('Items') ?></th>
                                    <th><?php echo $this->lang->line('Variant') ?></th>
                                    <th><?php echo $this->lang->line('Color') ?></th>
                                    <th><?php echo $this->lang->line('Condition') ?></th>
                                    <th><?php echo $this->lang->line('Qty') ?></th>
                                </tr>
                                </tfoot>
                            </table>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center mt-3">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
$('#product_cat').on('change',function(event){
        var productcat = $(this).val();

        $('#sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        $.ajax({
            type : 'POST',
            url : baseurl+'purchase/getListPo',
            data : {id : productcat},
            cache : false, 
            success : function(result){
                console.log(result);
                $('#sub_cat').append(result);
            }
        });
    }); 

$('#sub_cat').on('change',function(event){
        var productcat = $(this).val();
        
        $('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        $.ajax({
            type : 'POST',
            url : baseurl+'purchase/getListPoItem',
            data : {id : productcat},
            cache : false,
            success : function(result){
                console.log(result);
                if(result != 0){
                    $('#sub_sub_cat').append(result);
                    
                    
                    
                }
                
            }
        });
    }); 
  
  $('#sub_sub_cat').on('change',function(event){
        var productcat = $(this).val();
        $('#product_info').css("display","");
       /// $('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        $.ajax({
            type : 'POST',
            url : baseurl+'purchase/getPoItemInfo',
            data : {id : productcat},
            cache : false,
            success : function(result){
                console.log(result);
                if(result != 0){
                    $('#product_info').html(result);
                    
                    
                    
                }
                
            }
        });
    });



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