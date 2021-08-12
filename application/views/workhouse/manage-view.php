<?php 
/* echo "<pre>";
print_r($records);
echo "</pre>"; */

switch($records->product_condition){
	case A : $previous_condition = 'Excellent';
	break;
	case B : $previous_condition = 'Superb';
	break;
	case C : $previous_condition = 'Good';
	break;
	case D : $previous_condition = 'OK';
	break;
}

switch($records->convert_to){
	case 1 : $current_condition = 'Excellent';
	break;
	case 2 : $current_condition = 'Superb';
	break;
	case 3 : $current_condition = 'Good';
	break;
	case 4 : $current_condition = 'Ok';
	break;
}
?>
<style>
	/*.row div{
		text-align:center;
	}*/
</style>

<div class="content-body">
  <div class="card">
    <div class="card-header">
	<div class="row">
<h4 class="col"> Job Work</h4>
                    
      
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
	</div>
    </div>
    <div class="card-content">
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
	  
	  
      <div class="card-body">
		<form method="post" id="data_form" method="post" action="<?php echo base_url(); ?>jobwork/addjobwork">
        <div class="form-group row">
			<div class="col-md-2"> <b>Request ID:</b> </div>
			<div class="col-md-2" style="margin-left: -90px;"> REQ_<?php echo $records->request_id; ?>
			</div>
			<div class="col-md-2"> <b>Previous Condition:</b> </div>
			<div class="col-md-2" style="margin-left: -50px;"> <?php echo $previous_condition; ?>
			</div>
			<div class="col-md-2"> <b>Batch No:</b> </div>
			<div class="col-md-2" style="margin-left: -70px;"> <?php if($records->batch_number!='') echo 'Batch_'.date('y-m-d',strtotime($records->batch_number)); ?>
			</div>
		</div>
		
		
		<div class="form-group row">
			<div class="col-md-2"><b>Issue ID:</b></div>
			<div class="col-md-2" style="margin-left: -90px;">ISU_<?php echo $records->issue_id; ?>
			</div>
			<div class="col-md-2"><b>Current Condition:</b></div>
			<div class="col-md-2" style="margin-left: -50px;"><?php echo $current_condition; ?>
			</div>
			<div class="col-md-2"><b>QC Engineer:</b></div>
			<div class="col-md-2" style="margin-left: -70px;"><?php echo $records->assign_engineer; ?>
			</div>
			
			
		</div>
		<div class="form-group row">
			<div class="col-md-2"><b>Product Name:</b></div>
			<div class="col-md-2" style="margin-left: -90px;"><?php echo $records->product_detail->product_name; ?>
			</div>
			<div class="col-md-2"><b>Previous Category:</b></div>
			<div class="col-md-2" style="margin-left: -50px;"><?php echo $records->product_detail->category_name; ?>
			</div>
			<div class="col-md-2"><b>QC Team Leader:</b></div>
			<div class="col-md-2" style="margin-left: -70px;"><?php echo $records->teamlead; ?>
			</div>
			
			
		</div>
		<div class="form-group row">
			<div class="col-md-2"><b>ZUPC Code:</b></div>
			<div class="col-md-2" style="margin-left: -90px;"><?php echo $records->product_detail->warehouse_product_code; ?>
			</div>
			<div class="col-md-2"><b>Current Category:</b></div>
			<div class="col-md-2" style="margin-left: -50px;"><?php echo $records->category_name; ?>
			</div>
			<div class="col-md-2"><b>TRC Manager:</b></div>
			<div class="col-md-2" style="margin-left: -70px;"><?php echo $records->trc_manager; ?>
			</div>
			
			
		</div>
		<div class="form-group row">
			<div class="col-md-2"><b>Serial No:</b></div>
			<div class="col-md-2" style="margin-left: -90px;"><?php echo $records->serial; ?>
			</div>
		</div>
		<table class="table table-striped table-bordered zero-configuration mt-3">
			<thead>
				<tr>
					<th>Spare Part Name</th>
					<th style="width: 20%;">Quantity</th>					
					<th>Spare Part Serial No.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($records->components as $key=>$row){ ?>
				<tr>
					<td><?php echo $row->component_name; ?></td>					
					<td>1</td>
					<td><?php echo $row->serial; ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Spare Part Name</th>
					<th>Quantity</th>					
					<th>Spare Part Serial No.</th>
				</tr>
			</tfoot>
		</table> 
		
		<input type="hidden" name="pid" id="pid" value="<?php echo $records->product_id; ?>">
		<input type="hidden" name="serial_id" id="serial_id" value="<?php echo $records->id; ?>">
		<input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo $records->purchase_id; ?>">
		
		<div class="form-group row append">
		</div>
		<div class="form-group row" style="margin-left: 0px;">
			
        <!-- <label class="col-sm-2 col-form-label add-attribute btn btn-primary" data-toggle="modal" data-target="#add-attibute-modal"> Add Attribute</label>
		 <input type="hidden" id="attributes_number" value="2"> -->
          <div class="col-sm-4">
            <input type="submit"
							 class="btn btn-success sub-btn btn-lg ml-auto"
							 value="<?php echo $this->lang->line('Save') ?> "
							 id="submit-data" data-loading-text="Creating...">			
			<input type="hidden" value="jobwork/addjobwork" id="action-url">
          </div>
        </div>
		</form>
		
		
        </div>		
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="add-attibute-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 <form method="post" id="data_form" method="post" action="<?php echo base_url(); ?>jobwork/setComponent">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add attribute</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body row">
	  	
			
		<div class="col-md-2" style=" display: flex; align-items: center;">
			<label for="attribute"> Attribute </label>
		</div>
		<div class="col-md-10">
			<input type="text" name="component_name" id="component_name" class="form-control" placeholder="Enter Attribute Name" />
			<input type="hidden" name="pid" id="pid" value="<?php echo $records->product_id; ?>">
			<input type="hidden" name="id" id="id" value="<?php echo $id= $this->uri->segment(3);  ?>">
		</div>
			
			
		
        
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary" id="add-new-attribute">Add New Attribute</button>-->
		<input type="submit"
							 class="btn btn-success sub-btn btn-lg ml-auto"
							 value="<?php echo $this->lang->line('Save') ?> "
							 id="submit-data" data-loading-text="Creating...">			
			<input type="hidden" value="jobwork/setComponent" id="action-url">
      </div>
	  </form>
    </div>
  </div>
</div>

<script>
$('#add-new-attribute').click(function(){
	if (!$('#new-attribute').val()){
		$('#new-attribute').css('border-color','red');
	}else{
		$('#new-attribute').css('border-color','#BABFC7');
		var attribute = $('#new-attribute').val().toLowerCase();
		var condition = $('#condition').val();
		if(condition == 1){
			var condition_label = '';
		}else if(condition == 2){
			var condition_label = '';
		}else{
			var condition_label = '';
		}
		var labelhtml = attribute.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
		$('#new-attribute').val('');
		$('#add-attibute-modal').modal('hide');
		var attributes_number = $('#attributes_number').val();
		$('#attributes_number').val(parseInt(attributes_number,10)+1);
		
		
		var html = '<tr id="attributes'+attributes_number+'"><td>'+labelhtml+'<input type="hidden" name="attribute_name[]" value="'+attribute+'" /></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" value="1" required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter Batch No." required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter Component Serial No." required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td><td><label class="col-md-12 col-form-label remove-attribute btn btn-danger" onclick="remove_attribute('+attributes_number+')"> Remove attribute </label></td></tr>';
		/*var html .= ''; 
		var html .= '';
		var html .= '';
		var html .= '';*/
		
		$('table tbody tr:last').after(html);
		//var html = '<div class="form-group row attributes'+attributes_number+'"><label class="col-sm-2 col-form-label"> '+labelhtml+' ( '+ condition_label+' ) </label><div class="col-sm-4"><input type="hidden" name="attribute_name[]" value="'+attribute+'" /><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter '+labelhtml+' price" required/></div><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /><label class="col-sm-2 col-form-label remove-attribute btn btn-danger" onclick="remove_attribute('+attributes_number+')"> Remove attribute </label></div>';
		
		//var place = $('.append');
		//$(html).insertAfter(place);
	}
});
function remove_attribute(e){
	$('#attributes'+e).remove();
}


$('#new_condition').change(function(){	
	var previous_condition = $('#previous_condition').val();
	var new_condition = $('#new_condition').val();
	var pid = $('#pid').val();
	$.ajax({
		type : 'POST',
		url : baseurl+'jobwork/getcomponentCost',
		data : { previous_condition : previous_condition, new_condition : new_condition,pid:pid },
		cache : false,
		success : function(data){				
			var abc = JSON.parse(data);
			$.each( abc, function( key, value ) {			 
			  var actual_var = '#actual_cost-'+key;
			  $(actual_var).val(value);
			});
		}
	});
});


$('#previous_condition').change(function(){	
	var previous_condition = $('#previous_condition').val();
	var new_condition = $('#new_condition').val();
	var pid = $('#pid').val();
	$.ajax({
		type : 'POST',
		url : baseurl+'jobwork/getcomponentCost',
		data : { previous_condition : previous_condition, new_condition : new_condition,pid:pid },
		cache : false,
		success : function(data){				
			var abc = JSON.parse(data);
			$.each( abc, function( key, value ) {			 
			  var actual_var = '#actual_cost-'+key;
			  $(actual_var).val(value);
			});
		}
	});
});


function getActualCost(qty,id){
	var previous_condition = $('#previous_condition').val();
	var new_condition = $('#new_condition').val();
	var pid = $('#pid').val();
	$.ajax({
		type : 'POST',
		url : baseurl+'jobwork/getcomponentCost',
		data : { previous_condition : previous_condition, new_condition : new_condition,pid:pid },
		cache : false,
		success : function(data){				
			var abc = JSON.parse(data);
			$.each( abc, function( key, value ) {	
			  if(key==id){
				 var actual_cost = (parseInt(value)*parseInt(qty));
				 var actual_var = '#actual_cost-'+key;
				 $(actual_var).val(actual_cost);
			  }
			 
			});
		}
	});	
}

</script>
<!-- Modal HTML -->
<div id="part_payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Assign Engineer') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Engineer Name" name="amount"
                                       id="rmpay" value="<?php echo $rming ?>">
                            </div>

                        </div>
                       
                    </div>

                   <!-- <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Bank">Bank</option>
                            </select><label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Payment for purchase #<?php echo $invoice['tid'] ?>"></div>
                    </div> -->
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="purchasepayment"><?php echo $this->lang->line('Submit') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <option value="paid"><?php echo $this->lang->line('In Progress') ?></option>
                                <option value="due"><?php echo $this->lang->line('Complete') ?></option>
                                <option value="partial"><?php echo $this->lang->line('Incomplete') ?></option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" id="action-url" value="purchase/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>