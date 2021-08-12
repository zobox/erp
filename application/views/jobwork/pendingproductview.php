<style>
	/*.row div{
		text-align:center;
	}*/
</style>

<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"> Pending job Work View </h4>
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
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
	  
	  
      <div class="card-body">
		<form method="post" id="data_form" method="post" action="<?php echo base_url(); ?>jobwork/addjobwork">
        <div class="form-group row">
			<div class="col-md-2"> Hindizo Product Name </div>
			<div class="col-md-3"> <?php echo $records->product_name; ?> </div>
			<div class="col-md-2"> Category Name </div>
			<div class="col-md-3"> <?php echo $records->category_name; ?> </div>
		</div>
		
		<div class="form-group row">
			<div class="col-md-2"> Product Code </div>
			<div class="col-md-3"> <?php echo $records->hsn_code; ?> </div>
			<div class="col-md-2"> Serial No </div>
			<div class="col-md-3"> <?php echo $records->serial; ?>  </div>
		</div>
		
		<div class="form-group row">
			<div class="col-md-2"> Previous Condition</div>
			<div class="col-md-2"> 
				<select class="form-control" name="previous_condition" id="previous_condition">
					<option value="" selected="selected">--Select--</option>
					<option value="1">Ok</option>
					<option value="2">Good</option>					
				</select>
			</div>
			
			<div class="col-md-2"> Converted Condition </div>
			<div class="col-md-2"> 
				<select class="form-control" name="new_condition" id="new_condition">					
					<option value="" selected="selected">--Select--</option>
					<!--<option value="2">Good</option>-->
					<option value="4">Excellant</option>
					<option value="3">Super</option>

				</select>
			</div>
			
			<?php if(is_array($records->conditions)>0){ ?>
			<div class="col-md-2"> Final Condition </div>
			<div class="col-md-2"> 
				<select class="form-control" name="final_condition" id="final_condition" required>					
					<option value="" selected="selected">--Select--</option>
					<?php foreach($records->conditions as $key=>$cnd){ ?>
						<option value="<?php echo $cnd->pid; ?>"><?php echo $cnd->product_name; ?></option>
					<?php  } ?>
				</select>
			</div>
			<?php } ?>
		</div>
		
		<table class="table table-striped table-bordered zero-configuration mt-3">
			<thead>
				<tr>
					<th>Component Name</th>
					<th>Quantity</th>					
					<th>Actual Cost</th>
					<th>Batch No.</th>
					<th>Component Serial No.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($component as $key=>$row){ ?>
				<tr>
					<td><?php echo $row->component_name; ?></td>
					<td><input type="number" name="qty[]" id="qty-<?php echo $row->id; ?>"  value="1" class="form-control" onChange=getActualCost(this.value,<?php echo $row->id; ?>); /></td>					
					<td><input type="number" name="actual_cost[]" id="actual_cost-<?php echo $row->id; ?>"    placeholder="Enter Actual Cost" class="form-control" /></td>
					<td><input type="number" name="batch_no[]" id="batch_no-<?php echo $row->id; ?>"  placeholder="Enter Batch No." class="form-control"/></td>
					<td><input type="number" name="component_serial_no[]" id="component_serial_no-<?php echo $row->id; ?>"  placeholder="Enter Component Serial No." class="form-control" /></td>
				</tr>				
				<input type="hidden" name="component_id[]" id="component_id-<?php echo $row->id; ?>" value="<?php echo $row->id; ?>">
				<?php } ?>
			</tbody>
		</table>
		
		<input type="hidden" name="pid" id="pid" value="<?php echo $records->product_id; ?>">
		<input type="hidden" name="serial_id" id="serial_id" value="<?php echo $records->id; ?>">
		<input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo $records->purchase_id; ?>">
		
		<div class="form-group row append">
		</div>
		<div class="form-group row" style="margin-left: 0px;">
			
         <label class="col-sm-2 col-form-label add-attribute btn btn-primary" data-toggle="modal" data-target="#add-attibute-modal"> Add Attribute</label>
		 <input type="hidden" id="attributes_number" value="2">
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