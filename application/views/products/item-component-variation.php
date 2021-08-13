<link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
<script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">

<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js "></script>
<style type="text/css">
    .mt-100 {
    margin-top: 100px
}


</style>
<div class="content-body">
  <div class="card">
   <form method="post" enctype="multipart/form-data" action="<?=base_url()?>products/add_new_component_variation">
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
   
		
        
        
        <div class="col-sm-4">
        <!--<select class="form-control" name="product_type" id="pro_type">

          <option value="1">Select Product</option>
          <option value="0">All Product</option>
        </select>-->
      </div>
      <input type="hidden" name="component_id" value="<?=$component_id?>">
        <div id="added_product"></div>
        <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
          <div id="coupon4" class="card-header"> <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                           aria-expanded="true" aria-controls="accordion41"
                           class="card-title lead collapsed"><i class="fa fa-plus-circle"></i> Compatible Product</a> </div>
          <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                         class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="row p-1">
              <div class="col">
        <input type="hidden" name="row_count" id="row_count" value="1">
                
                <table class="table" id="v_var">
                  <tr>
                    <td><select id="v_type1" name="v_type[1]" class="form-control" onclick='getconditions(1),getcolours(1)'>
                        <?php
                              for($i=0;$i<count($product);$i++)
                              {
                                ?>
            <option value="<?=$product[$i]['pid']; ?>"><?=$product[$i]['product_name']; ?></option>
            <?php } ?>
                      </select></td>
                   
          
            
                    <td><input value="" class="form-control" name="zupc_code[1]"
                                                   placeholder="ZUPC Code *" >
                    </td>
                    <td><button class="btn btn-red tr_delete">Delete</button></td>
                  </tr>
                </table>
                <button class="btn btn-success tr_clone_add"><?php echo $this->lang->line('add_row') ?></button>
              </div>
            </div>
          </div>
        </div>
        
       
        <input type="hidden" name="image" id="image" value="default.png">
      
      <div class="form-group row">
          <div class="col-sm-12 text-center">
            <input type="submit" id="submit-datass" class="btn btn-success margin-bottom"
                               value="Add Component" data-loading-text="Adding...">
            <input type="hidden" value="products/add_new_component_variation" id="action-url">
          </div>
        </div>
    </div>
  </div>
</div>
</form>
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
			url : baseurl+'products/addcompovarirow',
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
     
 $(document).ready(function(){

 var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
 removeItemButton: true,
 maxItemCount:15,
 searchResultLimit:15,
 renderChoiceLimit:15
 });


 });        
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
						//console.log(product);
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
	
	
	<script type="text/javascript">
        $("#cloursdp1").select2();
         //$("#v_type").on('change', function () {
            //var tips = $('#v_type').val(); 		
		function getcolours(row_count){
            //var tips = $(this).val(); 
			var cnd_var = '#coloursdp'+parseInt(row_count);
			//alert(cnd_var);
            $(cnd_var).select2({
                tags: [],
                ajax: {
                    url: baseurl + 'products/coloursdrop',
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