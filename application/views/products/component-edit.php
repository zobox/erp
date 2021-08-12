<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Edit Spare Part</h5> 
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
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
			
                <form method="post" id="data_form" class="form-horizontal" > <?php /*?>action="<?php echo base_url();?>products/editproduct" enctype="multipart/form-data"<?php */?>


                    <input type="hidden" name="pid" value="<?php echo $component_detail['id'] ?>">


                    <div class="form-group row">

                        

                        <div class="col-sm-6">
						<label class="col-form-label" for="product_name">Spare Part name*</label>
                            <input type="text" placeholder="Spare Part *" class="form-control margin-bottom  required" name="product_name"
                                   value="<?php echo $component_detail['component_name'] ?>">
                        </div>
						<div class="col-sm-6">
            <label class="col-form-label" for="brand"><?php echo $this->lang->line('Brand') ?> *</label>
            <select class="form-control margin-bottom required" id="brand" name="brand" required>
              <option value="" selected="selected" disabled="disabled"> --- Select ---</option>
              <?php 
					foreach($brand as $key=>$brand_row){
						echo "<option value='".$brand_row['id']."'";if($brand_row['id'] == $component_detail['b_id']){echo "selected='selected'";}echo">".$brand_row['title']." (".$brand_row['extra'].") "."</option>";
					}
				?>
            </select>
          </div>
                    </div>

                    
					<div class="form-group row">

                        

                        <div class="col-sm-6">
						<label class="col-form-label" for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                            <input type="text" placeholder="Product Code"  class="form-control" name="hsn_code" value="<?php echo $component_detail['product_code'] ?>">
                        </div>
						<div class="col-sm-6">
            		<label class="col-form-label" for="product_code"><?php echo $this->lang->line('Product Model') ?></label>
           			 <input type="text" placeholder="<?php echo $this->lang->line('Product Model') ?>" class="form-control" name="product_model" value="<?php echo $component_detail['product_model'] ?>">
          			</div>
                    </div>

                    <div class="form-group row">

                        

                        <div class="col">
						<label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>
                            <!--<select name="product_warehouse" class="form-control">
                                <?php
                               /* echo '<option value="' . $cat_ware['wid'] . '">' . $cat_ware['watt'] . ' (S)</option>';
                                foreach ($warehouse as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }*/
                                ?>
                            </select>-->
							<input type="text" readonly="" disabled="disabled" class="form-control" value="<?= $warehouse2['title']?>" />
							<input type="hidden" readonly="" value="<?= $component_detail['warehouse']?>" />

                        </div>
						<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Product Name') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Product Name') ?>" class="form-control required" name="warehouse_product_name" value="<?php echo $component_detail['warehouse_product_name'] ?>">
			</div>
			<div class="col">
		  <label class="col-form-label" for="product_warehouse"><?php echo $this->lang->line('Warehouse Product Code') ?>*</label>
          <input type="text" placeholder="<?php echo $this->lang->line('Warehouse Product Code') ?>" class="form-control required" name="warehouse_product_code" value="<?php echo $component_detail['warehouse_product_code'] ?>">
			</div>
                    </div>
                    <div class="form-group row">
			<div class="col"> <label class="col-form-label" for="product_specification"><?php echo $this->lang->line('Product Specification') ?></label> 
			<textarea name="product_specification" class="form-control" placeholder="<?php echo $this->lang->line('Product Specification') ?>"><?php echo $component_detail['product_specification'] ?></textarea></div>
			<div class="col"> <label class="col-form-label" for="product_specification"><?php echo $this->lang->line('Product Description') ?></label> 
			<textarea placeholder="<?php echo $this->lang->line('Product Description') ?>"  class="form-control margin-bottom" name="product_desc" ><?php echo $component_detail['product_des'] ?></textarea></div>
		</div>
                    
                    
                    
                    
                    
                    <div class="form-group row">

                        

                        <div class="col">
						<label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>
                            <select name="unit" class="form-control">
                                <?php
                                echo "<option value='" . $component_detail['unit'] . "'>" . $this->lang->line('Do not change') . "</option><option value=''>None</option>";
                                foreach ($units as $row) {
                                    $cid = $row['code'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
						
                        <div class="col">
						<label class="col-form-label"><?php echo $this->lang->line('BarCode') ?></label>
                            <select class="form-control" name="code_type">
                                <?php echo $component_detail['barcode'] ?>
                                <option value="  <?php echo $component_detail['code_type'] ?>">  <?php echo $component_detail['code_type'] ?>
                                    *
                                </option>
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
                                   value="<?php echo $component_detail['barcode'] ?>"
                                   onkeypress="return isNumber(event)">

                        </div>
                    </div>
                    <div class="form-group row">

                        

                        <div class="col">
						<label class="col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>
                            <input type="text" placeholder="Low Stock Alert Quantity"
                                   class="form-control margin-bottom" name="product_qty_alert"
                                   value="<?php echo $component_detail['alert'] ?>"
                                   onkeypress="return isNumber(event)">
                        </div>
						<div class="col">
						 <label class="control-label"
                               for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?>
                            )</label>
                            <input type="text" class="form-control required"
                                   placeholder="Expiry Date" name="wdate"
                                   data-toggle="datepicker" autocomplete="false">
								   <small>Do not change if not applicable</small>
                        </div>
                    </div>                    
                    
                    
                    <div class="form-group row"><label
                                class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                        <div class="col-sm-6">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <table id="files" class="files">
                                <tr>
                                    <td>
                                        <a data-url="<?= base_url() ?>products/file_handling?op=delete&name=<?php echo $component_detail['image'] ?>"
                                           class="aj_delete"><i
                                                    class="btn-danger btn-sm icon-trash-a"></i><?php echo $component_detail['image'] ?>
                                        </a><img style="max-height:200px;"
                                                 src="<?= base_url() ?>userfiles/product/<?php echo $component_detail['image'] . '?c=' . rand(1, 999) ?>">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								<span>Select files...</span>
										<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload" type="file" name="files[]">
							</span>
                            <br>
                            <pre>Allowed: gif, jpeg, png</pre>
                            <br>
                            <!-- The global progress bar -->

                        </div>
                    </div>
					
                    <div class="form-group row">
                        <input type="hidden" name="image" id="image" value="<?php echo $component_detail['image'] ?>">
                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Updating...">
                            <input type="hidden" value="products/update_component" id="action-url">
                        </div>
                    </div>
				<!--<button class="btn btn-pink add_serial btn-sm m-1">   <?php //echo $this->lang->line('add_serial') ?></button>--><div id="added_product"></div>

                    <?php
                    /*if (is_array(@$serial_list[0])) {
                        foreach ($serial_list as $item) { ?>
                            <div class="form-group serial"><label for="field_s"
                                                                  class="col-lg-2 control-label"><?php echo $this->lang->line('serial') ?></label>
                                <div class="col-lg-10"><input class="form-control box-size"
                                                              placeholder="<?php echo $this->lang->line('serial') ?>"
                                                               type="text"
                                                              value="<?= $item['serial'] ?>"
                                                              <?= ($item['status'] ? 'readonly=""' : 'name="product_serial_e['.$item['id'].']"'); ?>></div>
                            </div>
                            <?php
                        }
                    }*/


                    if($component_detail['merge'] == 0) { ?>
                        <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                            <div id="coupon4" class="card-header">
                                <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                                   aria-expanded="true" aria-controls="accordion41"
                                   class="card-title lead <?php if(sizeof($product_variant) == 0){?>collapsed<?php }?>"><i class="fa fa-plus-circle"></i>
                                    <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                </a>
                            </div>
                            <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                                 class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="row p-1">
                                    <div class="col">
                                        <button class="btn btn-blue tr_clone_add">Add Row</button>
                                        <hr>
                                        <table class="table" id="v_var">
											<?php if(sizeof($product_variant) == 0){?>
                                            <tr>
                                                <td><select name="v_type[]" class="form-control">
                                                        <?php
                                                        foreach ($variables as $row) {
                                                            $cid = $row['id'];
                                                            $title = $row['name'];
                                                            $title = $row['name'];
                                                            $variation = $row['variation'];
                                                            echo "<option value='$cid'>$variation - $title </option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td style="display:none;"><input value="" class="form-control" name="v_stock[]"
                                                           placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                                </td>
                                                <td><input value="" class="form-control" name="v_alert[]"
                                                           placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                                </td> 
                                                <td>
                                                    <button class="btn btn-red tr_delete">Delete</button>
                                                </td>
                                            </tr>
											<?php }else{
												foreach($product_variant as $productVariants){
												
												?>
												<tr>
                                                <td><input type="hidden" value="<?= $product_name;?>" /><select name="v_type[]" class="form-control">
                                                        <?php
                                                        foreach ($product as $row) {
                                                            $product_ids = $row['pid'];
                                                            $title = $row['product_name'];
                                                           
                                                            echo "<option value='$product_ids'";
                                                            if($product_ids == $productVariants->product_id){echo "selected=''";}echo ">$title </option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                
                                                <td><input value="<?= $productVariants->warehouse_product_code?>" class="form-control" name="zupc_code[]"
                                                           placeholder="ZUPC Code*">
                                                </td>
                                                <td>
                                                    <button class="btn btn-red tr_delete">Delete</button>
                                                </td>
                                            </tr>
												<?php }
												}
												
                                            if (isset($product_var)) {
                                                foreach ($product_var as $p_var) {
                                                    echo '<tr> <td>' . $p_var['product_name'] . '</td> <td>' . $p_var['qty'] . '<td><td><a href="' . base_url() . 'products/edit?id=' . $p_var['pid'] . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><td></tr>';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>

        <script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js');
        $invoice['tid'] = 0; ?>"></script>
        <script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
        <script>
            /*jslint unparam: true */
            /*global window, $ */
            $(function () {
                'use strict';
                // Change this to the location of your server-side upload handler:
                var url = '<?php echo base_url() ?>products/file_handling?id=<?php echo $invoice['tid'] ?>';
                $('#fileupload').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function (index, file) {
                            $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['tid'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
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
            $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });

                        $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });
		$(document).ready(function(e){
			if($('#accordionWrapa1 #coupon4 a').hasClass('collapsed') == false){
				$('#accordionWrapa1 #accordion41').removeAttr('style').addClass('show');
			}
		});
        </script>
