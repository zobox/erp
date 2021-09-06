<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="card-content">
                <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">×</a>
                  <div class="message" id="msg"></div>
                </div>
                <div class="card-header p-0">
                  <h4 class="card-title">Spareparts More Details</h4>
                  <hr>
                  <div class="card-body px-0">
                      <table class="table table-striped table-bordered zero-configuration dataTable" id="cgrtable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>WarehouseID</th>
                          <th>Name</th>
                          <th>ZUPC Code</th>
                          <th>Serial Number</th>
                          <th>Settings</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=1;

                        foreach($serial_list as $serial)
                        {
                                
                        
                        ?>
                        <tr>
                          <td><?=$i++?></td>
                          <td><?=$warehouse['title']?></td>
                          <td><?=$serial->component_name?> </td>
                          <td><?=$serial->warehouse_product_code?></td>
                          <td><?=$serial->serial?></td>
                          <td>
                            <a class="btn btn-success btn-sm  view-object text-white"><span class="fa fa-eye"></span> View</a> 
                            
                          </td>
                        </tr>
                      <?php } ?>
                        
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>#</th>
                            <th>WarehouseID</th>
                            <th>Name</th>
                            <th>ZUPC Code</th>
                            <th>Serial Number</th>
                            <th>Settings</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#cgrtable').DataTable({
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": true,
                    },
                ], dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    }
                ],

        });
        });
    </script>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function() {
  'use strict';
  // Change this to the location of your server-side upload handler:
  var url = '<?php echo base_url() ?>products/file_handling';
  $('#fileupload').fileupload({
    url: url,
    dataType: 'json',
    formData: {
      '<?=$this->security->get_csrf_token_name()?>': crsf_hash
    },
    done: function(e, data) {
      var img = 'default.png';
      $.each(data.result.files, function(index, file) {
        $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
        img = file.name;
      });
      $('#image').val(img);
    },
    progressall: function(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#progress .progress-bar').css('width', progress + '%');
    }
  }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
});
$(document).on('click', ".aj_delete", function(e) {
  e.preventDefault();
  var aurl = $(this).attr('data-url');
  var obj = $(this);
  jQuery.ajax({
    url: aurl,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      obj.closest('tr').remove();
      obj.remove();
    }
  });
});
$(document).on('click', ".tr_clone_add", function(e) {
  e.preventDefault();
  /* var n_row = $('#v_var').find('tbody').find("tr:last").clone();   
  $('#v_var').find('tbody').find("tr:last").after(n_row); */
  var row_count = $('#row_count').val();
  row_count = (parseInt(row_count) + 1);
  $('#row_count').val(row_count);
  $.ajax({
    type: 'POST',
    url: baseurl + 'products/addcompovarirow',
    data: {
      row_count: row_count
    },
    cache: false,
    success: function(result) {
      //alert(result);
      console.log(result);
      //$('#subcatDiv').html(result); 
      $('#v_var').find('tbody').find("tr:last").after(result);
    }
  });
});
$(document).on('click', ".tr_clone_add_w", function(e) {
  e.preventDefault();
  var n_row = $('#w_var').find('tbody').find("tr:last").clone();
  $('#w_var').find('tbody').find("tr:last").after(n_row);
});
$(document).on('click', ".tr_delete", function(e) {
  e.preventDefault();
  $(this).closest('tr').remove();
});
$('#product_cat').on('change', function(event) {
  var productcat = $(this).val();
  $('.sub-sub-category').hide();
  $('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
  $('.sub-sub-sub-category').hide();
  $('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
  $('#sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
  $.ajax({
    type: 'POST',
    url: baseurl + 'products/subCatDropdownHtml',
    data: {
      id: productcat
    },
    cache: false,
    success: function(result) {
      console.log(result);
      $('#sub_cat').append(result);
    }
  });
});
$('#sub_cat').on('change', function(event) {
  var productcat = $(this).val();
  $('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
  $.ajax({
    type: 'POST',
    url: baseurl + 'products/subCatDropdownHtml',
    data: {
      id: productcat
    },
    cache: false,
    success: function(result) {
      if(result != 0) {
        $('#sub_sub_cat').append(result);
        $('.sub-sub-category').show();
      } else {
        $('.sub-sub-category').hide();
        $('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
      }
    }
  });
});
$('#sub_sub_cat').on('change', function(event) {
  var productcat = $(this).val();
  $('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
  $.ajax({
    type: 'POST',
    url: baseurl + 'products/subCatDropdownHtml',
    data: {
      id: productcat
    },
    cache: false,
    success: function(result) {
      if(result != 0) {
        $('#sub_sub_sub_cat').append(result);
        $('.sub-sub-sub-category').show();
      } else {
        $('.sub-sub-sub-category').hide();
        $('#sub_sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
      }
    }
  });
});
$("input[name='product_name']").keyup(function(event) {
  let productLabelName = $(this).val();
  $("input[name='warehouse_product_name']").val(productLabelName);
});
$("input[name='product_model']").keyup(function(event) {
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
$(document).on('click', ".v_delete_serial", function(e) {
  e.preventDefault();
  $(this).closest('div .serial').remove();
});
$(document).on('click', ".add_serial", function(e) {
  e.preventDefault();
  $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?= $this->lang->line('
    serial ') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?= $this->lang->line('
    serial ') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
    removeItemButton: true,
    maxItemCount: 15,
    searchResultLimit: 15,
    renderChoiceLimit: 15
  });
});
$("#conditionsdp1").select2();
//$("#v_type").on('change', function () {
//var tips = $('#v_type').val();    
function getconditions(row_count) {
  //var tips = $(this).val(); 
  var cnd_var = '#conditionsdp' + parseInt(row_count);
  //alert(cnd_var);
  $(cnd_var).select2({
    tags: [],
    ajax: {
      url: baseurl + 'products/conditionsdrop',
      dataType: 'json',
      type: 'POST',
      quietMillis: 50,
      data: function(product) {
        //console.log(product);
        return {
          product: product,
          '<?=$this->security->get_csrf_token_name()?>': crsf_hash
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
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
function getcolours(row_count) {
  //var tips = $(this).val(); 
  var cnd_var = '#coloursdp' + parseInt(row_count);
  //alert(cnd_var);
  $(cnd_var).select2({
    tags: [],
    ajax: {
      url: baseurl + 'products/coloursdrop',
      dataType: 'json',
      type: 'POST',
      quietMillis: 50,
      data: function(product) {
        console.log(product);
        return {
          product: product,
          '<?=$this->security->get_csrf_token_name()?>': crsf_hash
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
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
$('#pro_type').change(function() {
  var pro_type = $('#pro_type').val();
  if(pro_type == 0) {
    $('#coupon4').css("display", "none");
  }
})
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(event){
		/*$('.source').change(function(){
			$.ajax({
				type : 'POST',
				data : {source : $('.source').val()},
				url : baseurl+'lead/changesource',
				cache : false,
				success : function(result){
					window.location.href = result;
				},
				error : function (jqXHR, textStatus, errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
			})
		});*/
	});
	$('.statusChange').change(function(event){
		var itsid = $(this).attr('id');
		itsid = itsid.split("chnage");
		itsid = itsid[1];
		var selectedValue = $(this).val();
		$.ajax({
			type : 'post',
			url : baseurl+'lead/changeStatus',
			data : {leadid : itsid, selectedStatus : selectedValue},
			cache : false,
			success : function(result){
				swal("",result,"success");
				$.ajax({
					type : 'POST',
					url : baseurl+'lead/getStatusHtml',
					data : {id : itsid},
					cache : false,
					success : function(data){
						$('#stauschnage'+itsid).html(data);
						setTimeout(function(){ location.reload(); }, 3000);
					},
					error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
				});
			},
			error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
		});
		});
</script>
