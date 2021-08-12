<div class="content-body">
  <div class="card">
    <div class="card-header pb-0">
      <h5><?php echo $this->lang->line('Add Asset') ?></h5>
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
    <?php //print_r($brand);?>
    <div class="card-body">
      <form method="post" id="data_form"> <?php /*?>action="<?php echo base_url()?>products/addproduct"<?php */?>
        <input type="hidden" name="act" value="add_product">
        <div class="form-group row">
          <div class="col-sm-6">
            <label class="col-form-label" for="product_name"><?php echo $this->lang->line('Asset Name') ?> *</label>
            <input type="text" placeholder="<?php echo $this->lang->line('Asset Name') ?>" class="form-control margin-bottom required" name="product_name">
          </div>
          <div class="col-sm-6">
            <label class="col-form-label" for="brand"><?php echo $this->lang->line('Brand') ?> *</label>
            <select class="form-control margin-bottom required" id="brand" name="brand" required>
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
              <?php 
					foreach($brand as $key=>$brand_row){
						echo "<option value='".$brand_row['id']."'>".$brand_row['brand_name']." (".$brand_row['description'].") "."</option>";
					}
				?>
            </select>
          </div>
          <div class="col-sm-6">
            <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Asset Category') ?> *</label>
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
            <label class="col-form-label" for="sub_sub_sub_cat"><?php echo $this->lang->line('Sub Sub Category') ?></label>
            <select id="sub_sub_sub_cat" name="product_cat[]" class="form-control">
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6">
            <label class="col-form-label" for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
            <input type="text" placeholder="<?php echo $this->lang->line('Product Code') ?>" class="form-control" name="hsn_code">
          </div>
		  <div class="col-sm-6">
            <label class="col-form-label" for="product_code"><?php echo $this->lang->line('Asset Model') ?></label>
            <input type="text" placeholder="<?php echo $this->lang->line('Asset Model') ?>" class="form-control" name="product_model" value="<?=$autogenerate?>" readonly>
          </div>
        </div>
        <hr />
        <div class="form-group row">
		 <div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse') ?>*</label>
          
              <?php
			  	foreach ($warehouse as $row) {
					$warehouseid = $row['id'];
					$warehouseName = $row['title'];
					
					} ?>
            
			<input type="text" value="<?= $warehouseName;?>" class="form-control" readonly="" disabled="disabled" />
			<input type="hidden" name="product_warehouse" value="<?= $warehouseid;?>" readonly="" />
			</div>
			<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Asset Name') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Asset Name') ?>" class="form-control required" name="warehouse_product_name">
			</div>
			<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Product Code') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Product Code') ?>" class="form-control required" name="warehouse_product_code" value="<?=$autogenerate?>" readonly>
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
		  	<label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?>*</label>
            <select name="unit" class="form-control">
              <option value=''>None</option>
              <?php
                            foreach ($units as $row) {
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title - $cid</option>";
                            }
                            ?>
            </select>
          </div>
		  
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
            <input type="text" placeholder="BarCode Numeric Digit 123112345671"
                               class="form-control margin-bottom" name="barcode"
                               onkeypress="return isNumber(event)" value="<?=$autogenerate?>" readonly>
            <small>Leave blank if you want auto generated in EAN13.</small> </div>
        </div>
        <div class="form-group row">
          
          <div class="col">
		  	 <label class="col-form-label" for="Alert Quantity"><?php echo $this->lang->line('Alert Quantity') ?></label>
            <input type="text" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"  class="form-control margin-bottom" name="product_qty_alert" id="product_qty_alert" onkeypress="return isNumber(event)">
          </div>
		  <div class="col">
		  	<label class="col-form-label" for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?> )</label>
            <input type="text" class="form-control required" placeholder="Expiry Date" name="wdate" data-toggle="datepicker" autocomplete="false"><small>Do not change if not applicable</small>
          </div>
        </div>
        <hr>
		
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
            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add Asset') ?>" data-loading-text="Adding...">
            <input type="hidden" value="asset/add_asset" id="action-url">
          </div>
        </div>
        <!--<button class="btn btn-pink add_serial btn-sm m-1"> <?php echo $this->lang->line('add_serial') ?></button>-->
        <div id="added_product"></div>
        
   
        <input type="hidden" name="image" id="image" value="default.png">
      </form>
    </div>
  </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
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
        /* var n_row = $('#v_var').find('tbody').find("tr:last").clone();		
        $('#v_var').find('tbody').find("tr:last").after(n_row); */	
		var row_count = $('#row_count').val();
		row_count = (parseInt(row_count)+1);		
		$('#row_count').val(row_count);
		$.ajax({
			type : 'POST',
			url : baseurl+'products/addvariantrow',
			data : {row_count:row_count},
			cache : false,
			success : function(result){
				//alert(result);
				console.log(result);
				//$('#subcatDiv').html(result);	
				 $('#v_var').find('tbody').find("tr:last").after(result);
			}
		});	
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
			url : baseurl+'asset/subCatDropdownHtml',
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
			url : baseurl+'asset/subCatDropdownHtml',
			data : {id : productcat},
			cache : false,
			success : function(result){
				if(result != 0){
					$('#sub_sub_cat').append(result);
					$('.sub-sub-category').show();
					
				}
				else{
					$('.sub-sub-category').hide();
					$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
				}
				
			}
		});
	});	
	$('#sub_sub_cat').on('change',function(event){
		var productcat = $(this).val();
		$('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
		$.ajax({
			type : 'POST',
			url : baseurl+'asset/subCatDropdownHtml',
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
	$("input[name='product_name']").keyup(function(event){
		let productLabelName = $(this).val();
		$("input[name='warehouse_product_name']").val(productLabelName);
	});
	$("input[name='product_model']").keyup(function(event){
		let productModel = $(this).val();
		$("input[name='warehouse_product_code']").val(productModel);
	});
	/*$("input[name='warehouse_product_name']").keyup(function(event){
		let productLabelName = $(this).val();
		$("input[name='product_name']").val(productLabelName);
	});
	$("input[name='warehouse_product_code']").keyup(function(event){
		let productModel = $(this).val();
		$("input[name='product_model']").val(productModel);
	});*/
	
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
    $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });
                    $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });
</script>



<script type="text/javascript">
        $("#conditionsdp1").select2();
         //$("#v_type").on('change', function () {
            //var tips = $('#v_type').val(); 		
		function getconditions(row_count){
            //var tips = $(this).val(); 
			var cnd_var = '#conditionsdp'+parseInt(row_count);
			//alert(cnd_var);
            $(cnd_var).select2({
                tags: [],
                ajax: {
                    url: baseurl + 'products/conditionsdrop',
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
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
			
		 }
       // });
    </script>
