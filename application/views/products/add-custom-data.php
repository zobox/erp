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
                <form method="post" enctype="multipart/form-data" action="<?=base_url()?>products/add_custom_label" onSubmit="return valid111()">
                      <div class="row">
                        <div class="col-sm-5" style="" id="">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Product Type
                                </label>
                                <div class="col-sm-7">
                                <select id="product_type" name="product_type" class="form-control" required="">
                                        <option value="">Select Option</option>
                                        <option value="1">Product</option>
                                        <option value="2">Accessories</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                Size
                                </label>
                                <div class="col-sm-8">
                                <select name="size" class="form-control" required="" id="label_size">
                                        <option value="">Select Size</option>
                                        <option value="3">38 * 25 MM</option>
                                        <option value="1">75 * 50 MM</option>
                                        <option value="2">90 * 60 MM</option>
                                        <option value="5">79 * 49 Prexo</option>
                                        <option value="4">150 * 100 MM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5" style="" id="">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Product
                                </label>
                                <div class="col-sm-7">
                                <select id="sub_sub_cat" name="product_id" class="form-control" required="">
                                        <option value="">Select Option</option>
                                        <?php

                                        foreach($product as $row)
                                        {
                                            ?>
                                        
                                        <option value="<?=$row->pid?>"><?=$row->product_name?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6" style="" id="serial_no_type">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                    Variant
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="varient_id" id="varient">              <option value="">---Select-</option>                                     
                                     </select> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                    Colour
                                </label>
                                <div class="col-sm-7">
                                   <select class="form-control" name="color_id" id="color">
                                    <option value="">---Select-</option>                                      
                                                </select> 
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" id="label_mrp">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="brand">
                                    MRP 
                                </label>
                                <div class="col-sm-8">
                                <input type="text" id="mrp" class="form-control margin-bottom" name="mrp"> 
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-5" >
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label" for="brand">
                                <?php echo $this->lang->line('ZUPC Code') ?>
                                </label>
                                <div class="col-sm-7">
                                <input type="text" id="zupc" class="form-control margin-bottom" name="zupc_code" > 
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6" id="label_qty">
                            <div class="form-group row zupcno">
                                 <label class="col-sm-4 col-form-label" for="product_label">
                                            QTY
                                            </label>
                                    <div class="col-sm-8">
                                      <input type="text" id="qty" class="form-control margin-bottom" name="qty">  
                                     </div>
                            </div>
                        </div>

                    </div>
                        
                    
                    
                     <input type="hidden" name="jobwork_type" id="jobwork" value="">
                     <!--<input type="hidden" name="jobwork_supplier_id" value="<?=$purchase_detail[0]->supplier_id?>">
                     <input type="hidden" name="jobwork_purchase_id" value="<?=$purchase_detail[0]->purchase_id?>">
                     <input type="hidden" name="jobwork_pid" value="<?=$purchase_detail[0]->pid?>">
                     <input type="hidden" name="jobwork_varient_type" value="<?=$product_detail[0]['unit_name']?>">
                     <input type="hidden" name="jobwork_color_name" value="<?=$product_detail[0]['colour_name']?>">
                     <input type="hidden" name="jobwork_zupc_code" value="<?=$product_detail[0]['warehouse_product_code']?>">
                     <input type="hidden" name="product_name" value="<?=$product_detail[0]['product_name']?>">
                     <input type="hidden" name="brand_name" value="<?=$product_detail[0]['brand_name']?>">-->
                    
                    <div class="multi-field-wrapper">
                        <div class=""  id="imei_list">
                            <div class="multi-field">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-5 col-form-label" for="brand">
                                                IMEI 1
                                            </label>
                                            <div class="col-sm-7">
                                            <input type="text" class="form-control margin-bottom" name="imei_1" >
                                            </div>
                                        </div>
                                        

                                        
                                        
                                    </div>
                                    
                                    
                                    
                                    <div class="col-sm-6">
                                    
                                        <div class="form-group row zupcno">
                                            <label class="col-sm-4 col-form-label" for="space_required">
                                                IMEI 2
                                            </label>
                                            <div class="col-sm-8">
                                            <input type="text"  class="form-control margin-bottom" name="imei_2" >
                                             </div>
                                        </div>  
                                                                                
                                    </div>
                                    
                                </div>
                                
                               
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
                            <!--<button type="submit" class="btn btn-success ">Submit</button>-->
                        </div>
                    </div>
                </form>         
                
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  
  $('#sub_sub_cat').on('change',function(event){
        var productcat = $(this).val();
        var data_type = $('#data_type').val();
        
        $.ajax({
            type : 'POST',
            url : baseurl+'purchase/getproductinfo',
            data : {id : productcat,data_type:data_type},
            cache : false,
            success : function(result){
                //console.log(result);
                if(result != 0){
                    var res = result.split("#");
                    
                    $('#zupc').val(res[0]);
                    $('#varient').html(res[1]);
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
<script>
$('#data_type').on('change', function() {      
      if(this.value == '1')
      {
        $("#jobwork_required").attr("required", "true");
        $("#product_cat").attr("required", "true");
        $("#sub_cat").attr("required", "true");
        $("#sub_sub_cat").attr("required", "true");
        //$("#varient").attr("required", "true");
        //$("#color").attr("required", "true");
        $("#sticker_no").attr("required", "true");
        $("#serial_no1").attr("required", "true");
        $("#imei_2").attr("required", "true");
        //$("#final_grade").attr("required", "true");
        $("#current_grade").attr("required", "true");
        //$("#items").attr("required", "true");
        $("#qc_engineer").attr("required", "true");
        $("label[for='imei']").text("Add IMEI / Serial No 1");  
        
        $('#serial_no_type').show();
        $('.zupcno').show();        
        $('#submit_zupc').hide();
        $('.zupcno_y').hide();
      }
      if(this.value == '2')
      {
        $("#product_cat").attr("required", "true");
        $("#sub_cat").attr("required", "true");
        $("#sub_sub_cat").attr("required", "true");
        $("#qty").attr("required", "true");
        $("#serial_no1").attr("required", "true");  
        $("label[for='imei']").text("ZUPC");  
        $('.zupcno').hide();
        $('#serial_no_type').hide();
        $('#submit_zupc').show();
        $('.zupcno_y').show();
      }
})

$('#jobwork_required').on('change', function() {
  //  alert( this.value ); // or $(this).val()
  if(this.value == "1") {
    $("#final_grade").attr("required", "true");
    $("#items").attr("required", "true");
    $('.JobworkYes').show();
    //$('.JobworkNo').hide();

    $('#jobwork').val('1');
    $('#jobwork_not_required').val('');
    

  } else {
    $('#jobwork_not_required').val('2');
    $('#jobwork').val('');
    $('.JobworkYes').hide();
    //$('.JobworkNo').show();
    
    
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


$('#varient').change(function(){
    var id = $(this).val();
    $.ajax({
        type : 'POST',
        url : baseurl+'products/getvarientcolor',
        data : {id : id},
        cache : false,
        success : function(result){
            console.log(result);
            if(result != 0){                            
                $('#color').html(result);
            }
        }
    });
});



</script>


<script type="text/javascript">

    function getconditions(){
        var product_id = $('#sub_sub_cat').val(); 
        var varient_id = $('#varient').val();
        //alert(product_id);
        //alert(varient_id);
        
        $('#conditionsdp1').select2({
            tags: [],
            ajax: {
                url: baseurl + 'purchase/getcomponents?product_id='+product_id+'&varient_id='+varient_id,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {            
                console.log(product);
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {                
                            return {                                
                                text: item.component_name,
                                id: item.component_name
                            }
                        })
                    };
                },
            }
        });
    }

    $('#sub_sub_cat').on('change',function(event){
        var productcat = $(this).val();
        
        
        $.ajax({
            type : 'POST',
            url : baseurl+'products/getproductinfo',
            data : {id : productcat},
            cache : false,
            success : function(result){
                console.log(result);
                if(result != 0){
                    var res = result.split("#");
                    
                    $('#zupc').val(res[0]);
                    $('#varient').html(res[1]);
                }
            }
        });
    });
    
 
    $('#product_type').on('change', function(event)
    {
         var type = $(this).val();
        
         if(type==1)
         {
            $('#imei_list').css('display','');
         }
         if(type==2)
         {
            $('#imei_list').css('display','none');
         }
    });

    $('#label_size').on('change', function()
    {
        var label_size = $(this).val();
        
        

    })
</script>
