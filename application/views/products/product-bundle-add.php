<div class="content-body">
  <div class="card">
    <div class="card-header pb-0">
      <h5><?php echo $this->lang->line('Add New Bundle Product') ?></h5>
      <hr>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <?php //echo "<pre>";print_r($products);echo "</pre>";?>
    <div class="card-body">
      <form method="post" id="data_form" action="<?php echo base_url()?>products/addbundleproduct"> 
        
        <div class="form-group row">
		<div class="col-sm-6">
        <label class="col-form-label" for="product_name"><?php echo $this->lang->line('Number of Product in Bundle') ?> *</label>
        <input type="number" placeholder="<?php echo $this->lang->line('Number of Product in Bundle') ?>" class="form-control margin-bottom required" name="product_in" id="number_of_product">
        </div>
		<div class="col-sm-6">
		<label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?>*</label>
        <select name="unit" class="form-control">
        <option value=''>None</option>
        <?php
		foreach ($units as $row) {
			echo "<option value='".$row['code']."'>".$row['name']." - ".$row['code']."</option>";
                            }
                            ?>
            </select>
          </div>
		</div>
		
		<div class="form-group row append">
		</div>
         <hr id="hr_append" style="display:none" />
      
		<div class="form-group row">
		<div class="col-sm-6">
            <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Product Category') ?> *</label>
            <select name="product_cat[]" id="product_cat" class="form-control">
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
              <?php foreach ($cat as $row) { 
			  echo "<option value='".$row['id']."'>".$row['title']."</option>";
			  } ?>
            </select>
          </div>
          <div class="col-sm-6">
            <label class="col-form-label" for="sub_cat"><?php echo $this->lang->line('Sub Category') ?></label>
            <select id="sub_cat" name="product_cat[]" class="form-control required">
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
            </select>
          </div>
          <div class="col-sm-6 sub-sub-category" style="display:none;">
            <label class="col-form-label" for="sub_sub_cat"><?php echo $this->lang->line('Sub Sub Category') ?></label>
            <select id="sub_sub_cat" name="product_cat[]" class="form-control">
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
            </select>
          </div>
          <div class="col-sm-6 sub-sub-sub-category" style="display:none;">
            <label class="col-form-label" for="sub_sub_sub_cat"><?php echo $this->lang->line('Sub Sub Sub Category') ?></label>
            <select id="sub_sub_sub_cat" name="product_cat[]" class="form-control">
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
            </select>
          </div>
		  </div>
		  <hr />
		  <div class="form-group row">
		 <div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse') ?>*</label>
          <select name="product_warehouse" id="product_warehouse" class="form-control">
              <?php
			  	foreach ($warehouse as $row) {
					echo "<option value='".$row['id']."'>".$row['title']."</option>";
					} ?>
            </select>
			</div>
			<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Product Name') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Product Name') ?>" class="form-control required" name="warehouse_product_name">
			</div>
			<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Product Code') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Product Code') ?>" value="<?php echo $autogencode; ?>" class="form-control required" name="warehouse_product_code">
			</div>
         
        </div>
        <hr />
		
        <div class="form-group row">
		<div class="col">
		  	<label class="col-form-label"><?php echo $this->lang->line('Product Label Name') ?></label>
        <input type="text" placeholder="Product Label Name"
                               class="form-control margin-bottom" name="bundle_label_name">
          </div>
          <div class="col">
		  <label class="col-form-label"><?php echo "Variant"; ?></label>
            <input type="text" placeholder="Variant"
                               class="form-control margin-bottom" name="variant">
           </div>
			<div class="col">
		  	<label class="col-form-label" for="edate"><?php echo $this->lang->line('Color')?></label>
            <input type="text" class="form-control required" placeholder="Color" name="color">
          </div>
		  <div class="col">
		  	 <label class="col-form-label" for="Alert Quantity"><?php echo $this->lang->line('Contents') ?></label>
            <input type="text" placeholder="<?php echo $this->lang->line('Contents') ?>"  class="form-control margin-bottom" name="contents" id="Contents">
          </div>
        </div>
        <hr>
		<div class="form-group row">		
		
		<div class="col">
		  	<label class="col-form-label"><?php echo $this->lang->line('GST Amount') ?></label>
            <select class="form-control" name="gst">
				<option value="">Select</option>
			 <?php foreach($taxlist as $key=>$row){ ?>
				<option value="<?php echo $row->val2; ?>"><?php echo $row->val1; ?></option>
			 <?php } ?>             
            </select>
          </div>
          <div class="col">
		  <label class="col-form-label"><?php echo "Zo Retail Selling Price"; ?></label>
            <input type="number" placeholder="Zo Retail Selling Price"
                               class="form-control margin-bottom" name="zo_retail_selling_price">
            <small>(Incl. GST)</small> </div>
			<div class="col">
		  	<label class="col-form-label" for="edate"><?php echo $this->lang->line('Open Box Category Selling Price')?></label>
            <input type="text" class="form-control required" placeholder="Selling Price" name="open_box_selling_price"><small>(Incl. GST)</small>
          </div>
		  <div class="col">
		  	 <label class="col-form-label" for="Alert Quantity"><?php echo $this->lang->line('Zo Bulk Selling Price') ?></label>
            <input type="number" placeholder="<?php echo $this->lang->line('Zo Bulk Selling Price') ?>"  class="form-control margin-bottom" name="zobulk_selling_price" id="zo_bulk">
            <small>(Incl. GST)</small>
          </div>
        </div>
		<hr>
    
  
		<div class="form-group row">
			<div class="col"> <label class="col-form-label" for="product_specification"><?php echo $this->lang->line('Product Specification') ?></label> 
			<textarea name="product_specification" class="form-control" placeholder="<?php echo $this->lang->line('Product Specification') ?>"></textarea></div>
			<div class="col"> <label class="col-form-label" for="product_specification"><?php echo $this->lang->line('Product Description') ?></label> 
			<textarea placeholder="<?php echo $this->lang->line('Product Description') ?>"  class="form-control margin-bottom" name="product_desc" ></textarea></div>
		</div>
		<hr />
		<div class="form-group row">
		<div class="col">
		  	<label class="col-form-label"><?php echo $this->lang->line('BarCode') ?></label>
            <select class="form-control" name="code_type">
              <option value="EAN13">EAN13 - Default</option>
              <option value="UPCA">UPC</option>
              <option value="EAN8">EAN8</option>
              <option value="ISSN">ISSN</option>
              <option value="ISBN">ISBN</option>
              <option value="C128A">C128A</option>
              <option value="C39">C39</option>
            </select>
          </div>
          <div class="col">
		  <label class="col-form-label"><?php echo "BarCode Numeric Digit"; ?></label>
            <input type="number" placeholder="BarCode Numeric Digit 123112345671" value="<?php echo $autogencode; ?>"
                               class="form-control margin-bottom" name="barcode"
                               onkeypress="return isNumber(event)">
            <small>Leave blank if you want auto generated in EAN13.</small> </div>
			<div class="col">
		  	<label class="col-form-label" for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?> )</label>
            <input type="text" class="form-control required" placeholder="Expiry Date" name="valid_date" data-toggle="datepicker" autocomplete="false"><small>Do not change if not applicable</small>
          </div>
		  <div class="col">
		  	 <label class="col-form-label" for="Alert Quantity"><?php echo $this->lang->line('Alert Quantity') ?></label>
            <input type="number" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"  class="form-control margin-bottom" name="product_qty_alert" id="product_qty_alert" onkeypress="return isNumber(event)">
          </div>
        </div>
        <div class="form-group row">
          <label
                            class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
          <div class="col-sm-6">
            <div id="progress" class="progress">
              <div class="progress-bar progress-bar-success"></div>
            </div>
            <!-- The container for the uploaded files -->
            <table id="files" class="files">
            </table>
            <br>
            <span class="btn btn-success fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span>Select files...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]">
            </span> <br>
            <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
            <br>
            <!-- The global progress bar -->
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12 text-center">
            <input type="submit" id="submit-dataa" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
            <input type="hidden" value="products/addbundleproduct" id="action-url">
          </div>
        </div>
        
        
        
        <input type="hidden" name="image" id="image" value="default.png">
      </form>
    </div>
  </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
$("input[name='warehouse_product_name']").keyup(function(event){
	let productLabelName = $(this).val();
	$("input[name='bundle_label_name']").val(productLabelName);
});

$("input[name='product_model']").keyup(function(event){
	let productModel = $(this).val();
	$("input[name='warehouse_product_code']").val(productModel);
});
</script>


<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

	$('#product_cat').on('change',function(event){
		var productcat = $(this).val();
		$('.sub-sub-category').hide();
		$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$('.sub-sub-sub-category').hide();
		$('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$('#sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'products/subCatDropdownHtml',
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
			url : baseurl+'products/subCatDropdownHtml',
			data : {id : productcat},
			cache : false,
			success : function(result){
				if(result != 0){
					$('#sub_sub_cat').append(result);
					$('.sub-sub-category').show();
					
				}
				else{
					$('.sub-sub-category').hide();
					$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select Product --- </option>");
				}
				
			}
		});
	});	
	$('#sub_sub_cat').on('change',function(event){
		var productcat = $(this).val();
		$('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'products/subCatDropdownHtml',
			data : {id : productcat},
			cache : false,
			success : function(result){
				if(result != 0){
					$('#sub_sub_sub_cat').append(result);
					$('.sub-sub-sub-category').show();
					
				}
				else{
					$('.sub-sub-sub-category').hide();
					$('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
				}
				
			}
		});
	});
	
    //$("#sub_cat").select2();
   /* $("#product_cat").on('change', function () {
        $("#sub_cat").val('').trigger('change');
        var tips = $('#product_cat').val();
        $("#sub_cat").select2({

            ajax: {
                url: baseurl + 'products/sub_cat?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?php //$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });*/
	
	$('#number_of_product').on('blur',function(){
		$('#hr_append').css('display','none');
		$('.append').html('');
		var qty = $(this).val();
		var html2 = '';
		for(var i=1;i<=qty;i++){
			html2 = '<div class="col-sm-4"> <label class="col-form-label" for="product_name"><?php echo $this->lang->line('Product Name') ?> *</label><select class="form-control margin-bottom required" id="product'+i+'" name="pid[]" onchange="geproductcost('+i+');" required> <option value="" selected="selected" > --- Select ---</option><?php foreach($products as $row){echo '<option value="'.$row->pid.'">'.$row->product_name.'</option>';}?></select></div><div class="col-sm-4"> <label class="col-form-label" for="product_quantity"><?php echo "Quantity"; ?> *</label><input class="form-control margin-bottom required" type="number" name="pqty[]" placeholder="Quantity" /></div><div class="col-sm-4"> <label class="col-form-label" for="product_quantity"><?php echo "Cost Of The Product"; ?> *</label><input class="form-control margin-bottom required" type="number" name="pcost[]" placeholder="Cost Of The Product" /></div>';
		$('.append').append(html2);
		}
		$('#hr_append').css('display','block');
	});
    $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });
                    $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });
</script>


<script>
function geproductcost(str){
	var product_id_var = '#product'+str;
	var pid = $(product_id_var).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'products/product_cost',
		data : {pid : pid},
		cache : false,
		success : function(result){
			console.log(result);			
		}
	});	
}
</script>