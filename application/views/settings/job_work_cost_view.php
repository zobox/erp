<?php
	switch($action){
		case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
		break;
		case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
		break;
		case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
		break;
		case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
		break;
		case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
		break;
		case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
		break;
	}
?>
<div class="content-body">
    
    <div class="card">
        <div class="card-header">
            <h5>Job Work <?php echo $lbl_name ?>  View</h5>
			<h6> <strong>Product Name</strong> : Wheat 100<?php echo $pid;?> </h6>
					
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


                <table id="productstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
						<th><?php echo $this->lang->line('Category') ?></th>
                                            
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<tr>
						<td>1</td>
                        <td>Wheat 1001</td>    

                        <td>Mobile Accessories ? Neck Bands</td>                
                        <td><a href="<?php echo base_url().'settings/jobworkcostlistview?action='.$action.'&pid=1';?>" class="btn btn-success btn-sm">view</a></td>
                    </tr>
					<tr>
						<td>2</td>
						
                        <td>Wheat 1002</td>
                        <td>Mobile Accessories ? Chargers</td>
						                     
                        <td><a href="<?php echo base_url().'settings/jobworkcostlistview?action='.$action.'&pid=2';?>" class="btn btn-success btn-sm">view</a></td>
                    </tr>
					<tr>
						<td>3</td>
                        <td>Wheat 1003</td> 
						<td>Mobile Accessories ? Chargers ? Usb Charger</td>
                                            
                        <td><a href="<?php echo base_url().'settings/jobworkcostlistview?action='.$action.'&pid=3';?>" class="btn btn-success btn-sm">view</a></td>
                    </tr>
					<tr>
						<td>4</td>
                        <td>Wheat 1004</td>  
						<td>Mobile Accessories ? Chargers ? Car Charger ? 2.0 charger	</td>
                                              
                        <td><a href="<?php echo base_url().'settings/jobworkcostlistview?action='.$action.'&pid=4';?>" class="btn btn-success btn-sm">view</a></td>
                    </tr>
                    </tbody>

                    
                </table>

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
	  	<div class="col-md-2" style=" display: flex; align-items: center; margin-bottom:10px;">
			<label for="condition"> Condition </label>
		</div>
		<div class="col-md-10" style=" margin-bottom:10px;">
			<select name="condition" id="condition" class="form-control" required>
				<option value="1"> Super </option>
				<option value="2"> Good </option>
				<option value="3"> Bad </option>
			</select>
			</div>
			
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
		
		var html = '<div class="form-group row attributes'+attributes_number+'"><label class="col-sm-2 col-form-label"> '+labelhtml+' ( '+ condition_label+' ) </label><div class="col-sm-4"><input type="hidden" name="attribute_name[]" value="'+attribute+'" /><input type="text" name="attribute_value[]" id="'+attribute+'" class="form-control" placeholder="Enter '+labelhtml+' price" required/></div><input type="hidden" id="attribute_condition" name="attribute_condition[]" value="'+condition+'" /><label class="col-sm-2 col-form-label remove-attribute btn btn-danger" onclick="remove_attribute('+attributes_number+')"> Remove attribute </label></div>';
		
		var place = $('.add-attribute').parent();
		$(html).insertBefore(place);
	}
});
function remove_attribute(e){
	$('.attributes'+e).remove();
}
</script>        