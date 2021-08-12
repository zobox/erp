<?php 
/* echo "<pre>";
print_r($records);
echo "</pre>";  */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Edit Data</h5> <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <hr>
						
						<form method="post" id="product_action" class="form-horizontal" action="<?php echo base_url(); ?>settings/update_commission_edit">
                        <div class="row">
                            <div class="col-sm-12">
							
                            <div class="form-group row">
								<label class="col-sm-2 col-form-label"
								for="shortnote"><?php echo $this->lang->line('Valid From') ?></label>
								<div class="col-sm-4">
								
								
								<input type="date" placeholder="End Date" class="form-control margin-bottom b_input required" name="valid_from" id="valid_from" value="<?php echo date("Y-m-d", strtotime($records->valid_from)); ?>">
								</div>
							</div>
										
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="shortnote"><?php echo $this->lang->line('Update For') ?></label>

								<div class="col-sm-4">
									<select name="applied" id="applied" class="form-control margin-bottom rqty required">
										<option value="">-- Select --</option>
										<option <?php if($records->applied==1){ ?>selected<?php } ?> value="1"> All </option>
										<option <?php if($records->applied==2){ ?>selected<?php } ?> value="2"> Selected Franchise</option>
									</select>	
								</div>								                                            
							</div>
							
							<div class="form-group row" id="franchisedrop" style="display:none;">
								<label class="col-sm-2 col-form-label" for="shortnote"><?php echo $this->lang->line('Select Franchise') ?></label>
								
								<div class="col-sm-4">
								<select id="conditionsdp1" name="franchise[]" class="form-control required 	select-box"
									multiple="multiple">
									<?php foreach($franchise as $key=>$row){ ?>
										<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
									<?php } ?>
								 </select> 	
								</div>
							</div>
                                        
                                <div class="new-franchise-table">								
									
									<input type="hidden" placeholder="Module" class="form-control margin-bottom b_input required" name="module" id="module" value="<?php echo $module_id; ?>">
									
                                    <table class="table-striped table-responsive tfr mt-3">
                                        <thead>
                                            <tr class="item_header bg-gradient-directional-blue white">
                                                <th class="text-center">
                                                    <?php echo $this->lang->line('Category') ?>*</th>
                                                <th class="text-center">
                                                    <?php echo $this->lang->line('Sub Category') ?>
                                                </th>
                                                <th class="text-center">
                                                    <?php echo $this->lang->line('Sub Sub Category') ?>
                                                </th>
                                                <th class="text-center">
                                                    <?php echo $this->lang->line('Purpose') ?>
                                                </th>
                                                <th class="text-center" width="10%;">
                                                    <?php echo $this->lang->line('Zo Retail (%)') ?>
                                                </th>
                                                <th class="text-center" width="10%;">
                                                    <?php echo $this->lang->line('Zo Bulk (%)') ?>
                                                </th>
                                                <th class="text-center" width="8%;">
                                                    <?php echo $this->lang->line('B2C (%)') ?>
                                                </th>
                                                <th class="text-center" width="8%;">
                                                    <?php echo $this->lang->line('Renting (%)') ?>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											
											<tr>
												<input type="hidden" name="rowcount" id="rowcount" value="0">										
                                                <td>
                                                    <select name="cat[]" id="cat_id-0" class=" cat_id form-control margin-bottom rqty required" onchange="sub_cat_dropdown(this.value,0);">
                                                        <option value="">-- Select --</option>
                                                       <?php foreach($cat as $key=>$cat_data){ ?>
                                                        <option <?php if($cat_id==$cat_data->id){ ?> selected <?php } ?> value="<?php echo $cat_data->id; ?>"><?php echo $cat_data->title; ?></option>
													   <?php } ?>
                                                    </select>
                                                </td>
												
                                                <td>
                                                    <select name="sub_cat[]" id="sub_cat_id-0" class=" sub_cat_id form-control margin-bottom rqty" onchange="sub_sub_cat_dropdown(this.value,0);">
                                                        <option value="">-- Select --</option>
														<?php if(is_array($subcat)){ 
														foreach($subcat as $key1=>$subcat_data){ ?>
                                                        <option <?php if($subcat_id==$subcat_data->id){ ?> selected <?php } ?> value="<?php echo $subcat_data->id; ?>"><?php echo $subcat_data->title; ?></option>
														<?php }} ?>														
                                                    </select>
                                                </td>
												
                                                <td>
                                                    <select name="sub_sub_cat[]" id="sub_sub_cat_id-0" class=" sub_sub_cat_id form-control margin-bottom rqty">
                                                        <option value="">-- Select --</option>
														<?php if(is_array($subsubcat)){
														foreach($subsubcat as $key=>$subsubcat_data){ ?>
                                                        <option <?php if($subsubcat_id==$subsubcat_data->id){ ?> selected <?php } ?> value="<?php echo $subsubcat_data->id; ?>"><?php echo $subsubcat_data->title; ?></option>
														<?php }} ?>
                                                    </select>
                                                </td>
												
                                                <td>
                                                    <select name="purpose[]" id="purpose-0" class="form-control margin-bottom rqty required">
                                                        <option value="">-- Purpose --</option>
                                                        <option <?php if($purpose==1){ ?> selected <?php } ?> value="1"> Buying </option>
                                                        <option <?php if($purpose==2){ ?> selected <?php } ?> value="2"> Selling </option>
                                                        <option <?php if($purpose==3){ ?> selected <?php } ?> value="3"> Exchange </option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
													<input type="text" name="retail[]" id="retail" class="form-control margin-bottom b_input required" value="<?php echo $records->retail_commision_percentage; ?>" style="width: 100%;"> </td>
												<td class="text-center">
													<input type="text" name="bulk[]" id="bulk" class="form-control margin-bottom b_input required" value="<?php echo $records->bulk_commision_percentage; ?>" style="width: 100%;"> </td>

												<td class="text-center">
													<input type="text" name="b2c[]" id="b2c" class="form-control margin-bottom b_input required" value="<?php echo $records->b2c_comission_percentage; ?>" style="width: 100%;"> </td>
												
												<td class="text-center">
													<input type="text" name="renting[]" id="renting" class="form-control margin-bottom b_input required" value="<?php echo $records->renting_commision_percentage; ?>" style="width: 100%;"> </td>
                                                <td>
                                                    <button class="btnDeleteRow btn-zap btn-sm btn-danger text-white" type="button">&times;</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" style="text-align: center;">
                                                <!--<a href="#" class="btn btn-success text-white">Update</a> -->
												 <button id="update_commission_edit" class="btn btn-success text-white">Update</button>
												</td>
                                            </tr>
                                        </tfoot>
                                    </table>
									
                                </div>
                            </div>
                        </div>
						</form>
						
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<div id="update" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Select') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Valid From') ?></label>
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate"
                                           data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Update For') ?></label>
                                    <select name="purpose[]" id="purpose-0" class="form-control margin-bottom rqty required">
                                                        <option value="">-- Select --</option>
                                                        <option selected="" value="1"> All </option>
                                                        <option value="2"> Selected Franchise</option>
                                                    </select></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                        <select id="conditionsdp1" name="conditions[1][]" class="form-control required select-box"
                                    multiple="multiple">
                                    <option>Excellant</option>
                                    <option>Ok</option>
                                    <option>Good</option>
                                    <option>Superb</option>
                      </select> 
                                    </div>
                    </div>




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNowSelected"><?php echo $this->lang->line('Update') ?></button>
            </div>
        </div>
    </div>
    </div>-->
<script type="text/javascript">

$('#applied').change(function(){
	var applied_val = $(this).val();
	if(applied_val==2){
		$('#franchisedrop').show();
	}else{
		$('#franchisedrop').hide();
	}
	
});


$("#update_commission_edit").click(function(e) {
	e.preventDefault();
	var actionurl = baseurl + 'settings/update_commission_edit';
	actionProduct(actionurl);
	console.log(actionurl);
});


$('.sub_cat_id').on('change',function(event){
    var productcat = $(this).val();   
    $.ajax({
      type : 'POST',
      url : baseurl+'settings/subCatDropdownHtml',
      data : {id : productcat},
      cache : false,
      success : function(result){
        if(result != 0){
          $('.sub_sub_cat_id').html(result);         
        }
        else{
          //$('.sub-sub-category').hide();
          //$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        }
        
      }
    });
  });
  
  
  function sub_cat_dropdown(id,rowcount){
	//alert(id);
	//alert(rowcount);
	$.ajax({
      type : 'POST',
      url : baseurl+'settings/subCatDropdownHtml',
      data : {id : id},
      cache : false,
      success : function(result){
        if(result != 0){
		  var var_sub_cat_id = '#sub_cat_id-'+rowcount;
          $(var_sub_cat_id).html(result);         
        }
        else{
          //$('.sub-sub-category').hide();
          //$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        }
        
      }
    });
  }



$("#customer_statement").select2({
    minimumInputLength: 4,
    tags: [],
    ajax: {
        url: baseurl + 'search/supplier_select',
        dataType: 'json',
        type: 'POST',
        quietMillis: 50,
        data: function(supplier) {
            return {
                supplier: supplier,
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
</script>
<script>
//delete row
$(".btnDeleteRow").click(function() {
    var rowCount = $(this).closest('table').find('tbody tr').length;
    if(rowCount > 1) {
        $(this).closest('tbody tr').remove();
    }
    rowCount--;
    if(rowCount <= 1) {
        $(document).find('.btnDeleteRow').prop('disabled', true);
    }
});
//add row
$(".btnAddRow").click(function() {
    var table = $(this).closest('table');
    var lastRow = table.find('tbody tr').last();
    var newRow = lastRow.clone(true, true);
    newRow.find('input, textarea, select').val('');
    newRow.find('.growTextarea').css('height', 'auto');
    newRow.insertAfter(lastRow);
    table.find('.btnDeleteRow').removeAttr("disabled");
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