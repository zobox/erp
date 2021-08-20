<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title"><?php echo $this->lang->line('Receive Goods') ?> <a  href="<?php echo base_url('purchase/receive_good_add') ?>" class="btn btn-info small-button">
                    Add Data               </a></h4>
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
                
                <hr>

                <table id="catgtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('#') ?></th>
                        <th>PO#</th>
                        <th><?php echo $this->lang->line('Supplier') ?></th>
                        <th>Product Type</th>
                        <th>Job Work Required</th>
                        <th>Product Name</th>
                        <th>Variant </th>
                        <th>Color </th>
                        <th>ZUPC Code</th>
                        <th>Serial NO</th>
                        <th>Action </th>
                    </tr>
                    </thead>
                   
                    <tbody>
						 <?php
                        $i=1;
                        foreach($list as $key=>$row){
							
						//product_serial_status   0-Inactive, 1-Active,2-Jobwork,3-stock transfer, 4-Jobwork Request, 5-Jobwokr Issue, 6- jobcard Assign,7-jobwork-completed, 8-Not In Use(Duplicate Date), 9-Stock Return							
							
						//warehouse_serial_status  0-Inactive,1-Active,2-Sold, 3-misplaced, 4-Zobox Sales,5-Bundle Product, 8-Not In Use(Duplicate Date),9-Stock Return
						if($row->product_serial_status == 2){
							$jobwork_required = 'Yes';
						}else if($row->product_serial_status == 7){
							$jobwork_required = 'No';
						}
							
						?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>STFO#<?php echo $row->purchase_id; ?></td>
                            <td><?php echo $row->supplier_name; ?></td>
                            <td><?php echo $row->cat_name; ?></td>
                            <td><?php echo $jobwork_required; ?></td>
                            <td><?php echo $row->product_name; ?></td>
                            <td><?php echo $row->varient; ?></td>
                            <td><?php echo $row->color; ?></td>
                            <td><?php echo $row->warehouse_product_code; ?></td>
                            <td><?php echo $row->serial; ?></td>
                            <td><a href="#" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a></td>
                        </tr>
						<?php $i++; } ?>
                    </tbody>
						
                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('#') ?></th>
                        <th>PO#</th>
                        <th><?php echo $this->lang->line('Supplier') ?></th>
                        <th>Product Type</th>
                        <th> Job Work Required</th>
                        <th>Product Name</th>
                        <th>Variant </th>
                        <th>Color </th>
                        <th>ZUPC Code</th>
                        <th>Serial NO</th>
                        <th>Action </th>
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

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Order') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this order') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="purchase/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    }
                ],
            });

        });
    </script>
    