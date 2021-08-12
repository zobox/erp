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
        <div class="form-group row">
			<div class="col-md-2"> Hindizo Product Name </div>
			<div class="col-md-3"> <?php echo $records[0]->product_name; ?> </div>
			<div class="col-md-2"> Category Name </div>
			<div class="col-md-3"> <?php echo $records[0]->category_name; ?> </div>
		</div>
		
		<div class="form-group row">
			<div class="col-md-2"> Product Code </div>
			<div class="col-md-3"> <?php echo $records[0]->hsn_code; ?> </div>
			<div class="col-md-2"> Serial No </div>
			<div class="col-md-3"> <?php echo $records[0]->serial; ?> </div>
		</div>
		<?php
		switch($records[0]->previous_condition){
			case 1: $prv = 'Ok';
			break;
			case 2: $prv = 'Good';
			break;
			case 3: $prv = 'Superb';
			break;
		}
		
		switch($records[0]->new_condition){
			case 1: $new = 'Ok';
			break;
			case 2: $new = 'Good';
			break;
			case 3: $new = 'Superb';
			break;
		}
		?>
		<div class="form-group row">
			<div class="col-md-2"> Previous Condition</div>
			<div class="col-md-3"> <?php echo $prv; ?> </div>
			<div class="col-md-2"> Current Condition </div>
			<div class="col-md-3"> <?php echo $new; ?></div>
			
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
				<?php foreach($records as $key=>$row){ ?>
				<tr>
					<td><?php echo $row->component->component_name; ?></td>
					<td><input type="number" name="" id=""  value="<?php echo $row->qty; ?>" class="form-control" disabled="disabled" /></td>
					
					<td><input type="number" name="" id="" value="<?php echo $row->actual_cost; ?>" placeholder="Enter Actual Cost" class="form-control" disabled="disabled"/></td>
					<td><input type="number" name="" id="" value="<?php echo $row->batch_no; ?>" placeholder="Enter Batch No." class="form-control" disabled="disabled"/></td>
					<td><input type="number" name="" id="" value="<?php echo $row->component_serial_no; ?>" placeholder="Enter Component Serial No." class="form-control" disabled="disabled"/></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="form-group row append">
		</div>
		<div class="form-group row" style="margin-left: 0px;">
			
        
		 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="add-attibute-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add attribute</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body row">
	  	
			
		<div class="col-md-2" style=" display: flex; align-items: center;">
			<label for="attribute"> Attribute </label>
		</div>
		<div class="col-md-10">
			<input type="text" name="attribute" id="new-attribute" class="form-control" placeholder="Enter Attribute Name" />
		</div>
			
			
		
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add-new-attribute">Add New Attribute</button>
      </div>
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
			var condition_label = 'Super Condition';
		}else if(condition == 2){
			var condition_label = 'Good Condition';
		}else{
			var condition_label = 'Bad Condition';
		}
		var labelhtml = attribute.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
		$('#new-attribute').val('');
		$('#add-attibute-modal').modal('hide');
		var attributes_number = $('#attributes_number').val();
		$('#attributes_number').val(parseInt(attributes_number,10)+1);
		
		
		var html = '<tr id="attributes'+attributes_number+'"><td>'+labelhtml+' ( '+ condition_label+' )<input type="hidden" name="attribute_name[]" value="'+attribute+'" /></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" value="1" required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td><td></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter Batch No." required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td><td><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter Component Serial No." required/><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /></td></tr>';
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
</script>