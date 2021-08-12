<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Assign Job Work') ?>  <!--   <a href="<?php echo base_url('clientgroup/create') ?>"
                                                                    class="btn btn-primary btn-sm rounded">
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
						<th style="width: 47px;"><?php echo $this->lang->line('Issue ID') ?></th>
						<th style="width: 47px;"><?php echo $this->lang->line('Request ID') ?></th>
                        <th style="width: 200px;"><?php echo $this->lang->line('Product Label Name') ?></th>
						<th>Serial No</th>
						<th style="width: 14px;"><?php echo $this->lang->line('Product QTY') ?></th>
						<th style="width: 100px;"><?php echo $this->lang->line('Component QTY') ?></th>
						<!--<th style="width: 205px;"><?php echo $this->lang->line('Assigned TL') ?></th>
						<th><?php echo $this->lang->line('Status') ?></th>-->
                        <th style="width: 45px;"><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					/* echo "<pre>";
					print_r($records);
					echo "</pre>"; */	
					$i=1;
					foreach($records as $key=>$row){
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>ISU_<?php echo $row->issue_id; ?></td>
						<td>REQ_<?php echo $row->request_id; ?></td>
						<td><?php echo $row->product_name; ?></td>
						<td><?php $j=0; foreach($row->serial_records as $key=>$row1){ if($j>0){ echo ","; } echo $row1->serial; $j++;} ?></td>
						<td><?php echo $row->product_qty; ?></td>
						<td><?php echo $row->component_qty; ?></td>						
						<td><a href="view/?id=<?php echo $row->issue_id; ?>" class="btn btn-success btn-xs sr"> Assign TL </a> &nbsp;<!--<a href="#" data-object-id="<?php echo $row->issue_id; ?>" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span><?=$this->lang->line('Delete')?></a>--></td>
                    </tr>
					<?php $i++; } ?>
					
					</tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Issue ID') ?></th>
						<th style="width: 47px;"><?php echo $this->lang->line('Request ID') ?></th>
						<th><?php echo $this->lang->line('Product Label Name') ?></th>
                        <th><?php echo $this->lang->line('Product QTY') ?></th>
						<th><?php echo $this->lang->line('Component QTY') ?></th>
						<!--<th><?php echo $this->lang->line('Assigned TL') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>-->
						<th><?php echo $this->lang->line('Action') ?></th>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Delete this Request ID</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id" value="">
                        <input type="hidden" id="action-url" value="workhousejob/delete_assign_jobwork">
                        <button type="button" data-dismiss="modal" class="btn btn-primary"
                                id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
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
                            columns: [0, 1, 2, 3, 4, 5, 6]
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