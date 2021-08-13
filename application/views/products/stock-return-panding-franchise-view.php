<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="title"> <?php echo $this->lang->line('Stock Return Request') ?> 
            </h5> <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration dataTable dtr-inline no-footer">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th class="text-xs-left">Rate</th>
                           
                            <th class="text-xs-left">GST</th>
                            <th class="text-xs-left">Amount</th>
                            <th class="text-xs-left">Warehouse</th>
                            <th class="text-xs-left">IMEI</th>
                            <th class="text-xs-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					
						<?php $i=1; foreach($list as $key=>$row){ ?>
                        <tr>
                            <th scope="row"><?php echo $i; ?></th>
                            <td><?php echo  $row->product_name; ?></td>
                            <td> ₹ <?php echo  $row->price; ?></td>
                            
                            <td><?php echo  $row->tax; ?></td>
                            <td> ₹ <?php echo  $row->subtotal; ?></td>
                            
							<?php
							/* echo "<pre>";
							print_r($warehouse);
							echo "</pre>"; */
							?>
							<td><select class="form-control round" name='warehouse' id="warehouse-<?php echo  $row->id; ?>">
								<?php foreach($warehouse as $key1=>$data){ ?>
									<option value='<?php echo $data->id; ?>'><?php echo $data->title; ?></option>
                                <?php } ?>
                                </select>
                            </td>
							
                            <td><?php echo  $row->serial; ?></td>
                            <td>
                                <input type="button" id="<?php echo  $row->id; ?>" class="btn btn-success margin-bottom recieve" value="Yes">
                                <input type="button" id="<?php echo  $row->id; ?>" class="btn btn-danger margin-bottom not_recieve" value="No">
                            </td>
                        </tr>
						<?php $i++; } ?>
						
                    </tbody>
                    <tfoot>
                                                <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th class="text-xs-left">Rate</th>
                            
                            <th class="text-xs-left">GST</th>
                            <th class="text-xs-left">Amount</th>
                            <th class="text-xs-left">Warehouse</th>
                            <th class="text-xs-left">IMEI</th>
                            <th class="text-xs-left">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo $this->lang->line('delete this product warehouse') ?>
                            </strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="productcategory/delete_warehouse">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">
                        <?php echo $this->lang->line('Delete') ?>
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">
                        <?php echo $this->lang->line('Cancel') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
	
	
	
	<script>
	$('.recieve').click(function(){
		var id = $(this).attr("id");
		var wvar = '#warehouse-'+id;
		var wid = $(wvar).val();
		var invoice_id = <?php echo $this->input->get('id'); ?>
		//alert(wid);
		$.ajax({
			type : 'POST',
			url : baseurl+'productcategory/recieve',			
			data : {id:id,wid:wid,invoice_id:invoice_id},		
			cache : false,
			success : function(result){				
				console.log(result);
				 location.reload();
			}
		});
	});
	
	
	$('.not_recieve').click(function(){
		//alert('oksss');
		var id = $(this).attr("id");
		var wvar = '#warehouse-'+id;
		var wid = $(wvar).val();
		var invoice_id = <?php echo $this->input->get('id'); ?>
		
		$.ajax({
			type : 'POST',
			url : baseurl+'productcategory/not_recieved',			
			data : {id:id,wid:wid,invoice_id:invoice_id},	
			cache : false,
			success : function(result){				
				console.log(result);
				location.reload();
			}
		});
	});
	</script>