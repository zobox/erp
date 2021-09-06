<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="title"> <?php echo $this->lang->line('LRP Return Pending Inventory') ?> 
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
                <table id="catgtable" class="table table-striped table-bordered zero-configuration dataTable dtr-inline no-footer">
                    <thead>
                        <!--<tr>
                            <th>#</th>
                            <th>Description</th>
                            
                           <th>Product Cost</th>
                           <th>Refurbishment Cost</th>
                           <th>Third Party Job work Cost</th>
                            <th>GST</th>
                            <th>Amount</th>
                            <th>Warehouse</th>
                            <th>IMEI</th>
                            <th>Action</th>
                        </tr>-->
                        <tr>
                            <th>#</th>
                            <th>Product<br> Name</th>
                            <th>Product<br> Pruchase Price</th>
                            <th>Spareparts<br> Name</th>
                            <th>Total<br> Spareparts Cost</th>
                            <th>LRP<br> Service Type</th>
                            <th>Net<br> Service price</th>
                            <th>GST<br> Amount</th>
                            <th>Total Amount</th>
                            <th>Warehouse</th>
                            <th>IMEI</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					
						<?php 
						/* echo "<pre>";
						echo print_r($list);
						echo "</pre>"; */

						$i=1;
						foreach($list as $key=>$row){
							$jobwork_service_type = $row->jobwork_service_type;
							switch($jobwork_service_type){
								case 1: $service_type = 'L1'; $service_charge = 25; $service_gst=4.5; $total_service_charge = 29.5;
								break;
								case 2: $service_type = 'L2'; $service_charge = 100; $service_gst=18; $total_service_charge = 118;
								break;
								case 3: $service_type = 'L3'; $service_charge = 150; $service_gst=27; $total_service_charge = 177
;
								break;
							}
							
							$total_amount = $row->purchase_record[0]['price']+$row->total_component_price+$service_charge +$service_gst;
						?>
					   <tr>
                            <th scope="row">1</th>

                            <td><?php echo $row->product_name; ?></td>
                            
                            <td><?php echo $row->purchase_record[0]['price']; ?></td>
                            <td><?php echo implode(',',$row->components['component_name']); ?></td>
                            <td><?php echo $row->total_component_price; ?></td>
							<td>L<?php echo $row->jobwork_service_type; ?></td>
                            <td><?php echo $service_charge; ?></td>
							<td><?php echo $service_gst; ?></td>
                            <td width="10%;"> ₹ <?php echo $total_amount; ?></td>				
                            <td>
								<select class="form-control round" name='warehouse' id="warehouse-<?php echo  $row->id; ?>">
								<?php foreach($warehouse as $key1=>$data){ ?>
									<option value='<?php echo $data->id; ?>'><?php echo $data->title; ?></option>
                                <?php } ?>
                                </select>
                            </td>
                            
                            <td><?php echo $row->serial; ?></td>

                            <td width="10%;">
                                <!--<button class="btn btn-success btn-sm recieve">Yes</button>
                                <button class="btn btn-danger btn-sm not_recieve">No</button>-->
								 <input type="button" id="<?php echo  $row->id; ?>" class="btn btn-success margin-bottom recieve btn-sm" value="Yes">
                                <!--<input type="button" id="<?php echo  $row->id; ?>" class="btn btn-danger margin-bottom not_recieve" value="No">-->
                            </td>
                        </tr>
						<?php } ?>
						
                    </tbody>
                    <tfoot>
                        <!--<tr>
                            <th>#</th>
                            <th>Description</th>
                           <th>Product Cost</th>
                           <th>Refurbishment Cost</th>
                           <th>Third Party Job work Cost</th>
                            <th>GST</th>
                            <th>Amount</th>
                            <th>Warehouse</th>
                            <th>IMEI</th>
                            <th>Action</th>
                        </tr>-->
                        <tr>
                            <th>#</th>
                            <th>Product<br> Name</th>
                            <th>Product<br> Pruchase Price</th>
                            <th>Spareparts<br> Name</th>
                            <th>Total<br> Spareparts Cost</th>
                            <th>LRP<br> Service Type</th>
                            <th>Net<br> Service price</th>
                            <th>GST<br> Amount</th>
                            <th>Warehouse</th>
                            <th>IMEI</th>
                            <th>Action</th>
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
    
	
	
	
	<script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#catgtable').DataTable({
                responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10]
                        }
                    }
                ],
            });
        });
    </script>
	
	
	<script>
	$('.recieve').click(function(){
		var id = $(this).attr("id");		
		var wvar = '#warehouse-'+id;		
		var wid = $(wvar).val();
		var invoice_id = <?php echo $this->input->get('id'); ?>;
		//alert(invoice_id);
		$.ajax({
			type : 'POST',
			url : baseurl+'productcategory/recievelrp',			
			data : {id:id,wid:wid,invoice_id:invoice_id},		
			cache : false,
			success : function(result){				
				console.log(result);
				 location.reload();
			}
		});
	});
	
	
	/* $('.not_recieve').click(function(){
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
	}); */
	</script>