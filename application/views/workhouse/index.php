
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Pending Job Work') ?>  
				<!-- <a href="<?php echo base_url('clientgroup/create') ?>" class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>  -->
            </h5>
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
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th style="width: 5px;">#</th>
						<!--  <th style="width: 47px;"><?php echo $this->lang->line('Job Work ID') ?></th> -->
                        <th style="width: 492px;"><?php echo $this->lang->line('Product Label Name') ?></th>
                        <th style="width: 14px;"><?php echo $this->lang->line('QTY') ?></th>
						
						<th><?php echo $this->lang->line('Convert To') ?></th>
						<th style="width: 223px;"><?php echo $this->lang->line('Request Warehouse for Job Work') ?></th>
						
                        <!--<th style="width: 45px;"><?php echo $this->lang->line('Action') ?></th>-->
                    </tr>
                    </thead>
                    <tbody>
					
					<?php
					/* echo "<pre>";
					print_r($records);
					echo "</pre>"; //exit; */
					$i=1;
					foreach($records as $key=>$row){ 
					?>
					<tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->product_name; ?></td>               
                        <td><?php echo $row->qty; ?></td>  
						<input type="hidden" name="qty" id="qty<?php echo $row->product_id; ?>" value="<?php echo $row->qty; ?>">
                        <td><select id="convert_to<?php echo $row->product_id; ?>" name="convert_to" class="form-control">    
                            <?php foreach($conditions as $key=>$condition_data){ ?>
								<option <?php if($row->convert_to==$condition_data->id){ ?> selected <?php } ?> value="<?php echo $condition_data->id; ?>"><?php echo $condition_data->name; ?></option>
							<?php } ?>							
                            </select></td>                              

                        <td><a href="#sendMail" data-toggle="modal" data-remote="false" class="btn btn-success btn-xs sr" onclick="send_request1('<?php echo $row->product_id; ?>');"> Send Request</a></td>               
                    </tr>									
					<?php $i++; } ?>	
					
					</tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <!--  <th><?php echo $this->lang->line('Job Work ID') ?></th> -->
						<th><?php echo $this->lang->line('Product Label Name') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
						<th><?php echo $this->lang->line('Convert To') ?></th>
						<th><?php echo $this->lang->line('Request Warehouse for Job Work') ?></th>                       
						<!--<th><?php echo $this->lang->line('Action') ?></th>-->
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
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

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Discount'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">
                        <p>
                            <?php echo $this->lang->line('you can pre-define the discount') ?>
                        </p>
                        <input type="hidden" id="dobject-id" name="gid" value="">


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="pmethod"><?php echo $this->lang->line('Discount') ?></label>
                                <input name="disc_rate" class="form-control mb-1" type="number"
                                       placeholder="Discount Rate in %">


                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="clientgroup/discount_update">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Customer Group') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this customer group') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="clientgroup/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', ".discount-object", function (e) {
            e.preventDefault();
            $('#dobject-id').val($(this).attr('data-object-id'));
            $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
            $('#pop_model').modal({backdrop: 'static', keyboard: false});
        });
    </script>
	
	
	<script>
	function send_request(){
		//alert(id);
		var product_id = $('#product_id').val();
		var qty = parseInt($('#qty').val());
		var total_qty = parseInt($('#total_qty').val());
		var convert_to = $('#convert_to').val();
		
		if(total_qty >= qty){
			$.ajax({
				type : "POST",		
				url : baseurl+'workhousejob/send_request',
				data : {product_id : product_id,convert_to:convert_to,qty:qty},
				cache : false,
				success : function(data)
				{	
					console.log(data);
					location.reload();	
				}
			});
		}else{
			alert('Quantity Should not be grater than '+total_qty);
		}
	}
	</script>
	
	
    <div id="sendMail" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title"><?php echo $this->lang->line('Add QTY') ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-10">
							<label>Add QTY</label>
								<input type="text" class="form-control" name="qty" id="qty">
							</div>
						</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default"
							data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
					<button type="button" class="btn btn-primary"
							id="sendNowSelected" onclick="send_request();">
							<?php echo $this->lang->line('Send') ?></button>
							
					<input type="hidden" name="product_id" id="product_id">
					<input type="hidden" name="total_qty" id="total_qty">
					<input type="hidden" name="convert_to" id="convert_to">
				</div>
			</div>
		</div>
    </div>
	
	
<script>
function send_request1(id){
	$('#product_id').val(id);
	var qty_var = '#qty'+id;
	var qty = $(qty_var).val();
	$('#total_qty').val(qty);
	
	var convert_to_var = '#convert_to'+id;
	var convert_to = $(convert_to_var).val();
	$('#convert_to').val(convert_to);
}
</script>