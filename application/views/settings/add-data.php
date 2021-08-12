<script>
function deleteRowsss(id){
	var tr_id = '#tr-'+id;
	$(tr_id).remove();
}
</script>

<div class="content-body">
    <div class="card">
		<div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
		
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Data') ?></h5> <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="new-franchise-table">
									<!--<form method="post" id="product_action" class="form-horizontal" action="<?php echo  base_url(); ?>settings/update_commission">-->
									<form method="post" id="product_action" class="form-horizontal" >
									
									<input type="hidden" placeholder="Module" class="form-control margin-bottom b_input required" name="module" id="module" value="<?php echo $this->input->get('id'); ?>">
                                    <table class="table-striped table-responsive tfr">
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
                                        <tbody id="addrowid">
                                            <tr>
												<input type="hidden" name="rowcount" id="rowcount" value="0">										
                                                <td>
                                                    <select name="cat[]" id="cat_id-0" class=" cat_id form-control margin-bottom rqty required" onchange="sub_cat_dropdown(this.value,0);">
                                                        <option value="">-- Select --</option>
                                                       <?php foreach($cat as $key=>$cat_data){ ?>
                                                        <option value="<?php echo $cat_data->id; ?>"><?php echo $cat_data->title; ?></option>
													   <?php } ?>
                                                    </select>
                                                </td>
												
                                                <td>
                                                    <select name="sub_cat[]" id="sub_cat_id-0" class=" sub_cat_id form-control margin-bottom rqty" onchange="sub_sub_cat_dropdown(this.value,0);">
                                                        <option value="">-- Select --</option>
                                                    </select>
                                                </td>
												
                                                <td>
                                                    <select name="sub_sub_cat[]" id="sub_sub_cat_id-0" class=" sub_sub_cat_id form-control margin-bottom rqty">
                                                        <option value="">-- Select --</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="purpose[]" id="purpose-0" class="form-control margin-bottom rqty required">
                                                        <option value="">-- Purpose --</option>
                                                        <option value="1"> Buying </option>
                                                        <option value="2"> Selling</option>
                                                        <option value="3">Exchange</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
													<input type="text" name="retail[]" id="retail" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
												<td class="text-center">
													<input type="text" name="bulk[]" id="bulk" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
												<td class="text-center">
													<input type="text" name="b2c[]" id="b2c" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>	
												<td class="text-center">
													<input type="text" name="renting[]" id="renting" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
                                                <td>
                                                    <button class="btnDeleteRow btn-zap btn-sm btn-danger text-white" type="button">&times;</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" style="text-align: center;"> <button type="button" class="btnAddRow btn btn-success text-white"><i class="fa fa-plus-square" aria-hidden="true" title="Delete"></i> Add Row</button>
                                                <button id="update_commission" class="btn btn-success text-white">Submit</button> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$("#update_commission").click(function(e) {
	e.preventDefault();
	var actionurl = baseurl + 'settings/update_commission';
	actionProduct(actionurl);
	console.log(actionurl);
});



$('.cat_id').on('change',function(event){
    var productcat = $(this).val();   
    $.ajax({
      type : 'POST',
      url : baseurl+'settings/subCatDropdownHtml',
      data : {id : productcat},
      cache : false,
      success : function(result){
        if(result != 0){
          $('.sub_cat_id').html(result);         
        }
        else{
          //$('.sub-sub-category').hide();
          //$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        }
        
      }
    });
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
  
  
  function sub_sub_cat_dropdown(id,rowcount){	  
	$.ajax({
      type : 'POST',
      url : baseurl+'settings/subCatDropdownHtml',
      data : {id : id},
      cache : false,
      success : function(result){
        if(result != 0){
		  var var_sub_sub_cat_id = '#sub_sub_cat_id-'+rowcount;
          $(var_sub_sub_cat_id).html(result);         
        }
        else{
          //$('.sub-sub-category').hide();
          //$('#sub_sub_cat').html("<option value='' disabled='' selected=''> --- Select --- </option>");
        }
        
      }
    });
  }
  
</script>


<script>
//delete row
$(".btnDeleteRow111").click(function() {
	alert('oksss');
	
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
	var rowcount = parseInt($('#rowcount').val());
	var rowcount = rowcount+1;
	$('#rowcount').val(rowcount);
	
	$.ajax({
      type : 'POST',
      url : baseurl+'settings/addrow',
      data : {rowcount : rowcount},
      cache : false,
      success : function(result){
        console.log(result);
		$('#addrowid').append(result)
      }
    });
	
    /* var table = $(this).closest('table');
    var lastRow = table.find('tbody tr').last();
    var newRow = lastRow.clone(true, true);
    newRow.find('input, textarea, select').val('');
    newRow.find('.growTextarea').css('height', 'auto');
    newRow.insertAfter(lastRow);
    table.find('.btnDeleteRow').removeAttr("disabled"); */
});


</script>