<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('LRP Return Pending Inventory') ?> 
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
            <hr>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="card-body pt-0">


                <table id="catgtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th><?php echo $this->lang->line('LRP Id') ?></th>
						<th><?php echo $this->lang->line('Total Products') ?></th>
                        <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
						<?php 
						/* echo "<pre>";
						print_r($list);
						echo "</pre>"; */
						$i=1;
						foreach($list as $key=>$row){
						?>
					   <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->invoicedate; ?></td>
                            <td><a target="_blank" href="<?php echo base_url(); ?>invoices/view?id=<?php echo $row->id; ?>">LRP#<?php echo $row->tid; ?></a></td>
                            <td><?php echo $row->warehouse_code; ?></td>
                            <td><?php echo $row->total_product; ?></td>
                            <td><?php echo $row->stock_quantity; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>productcategory/lrp_panding_inventory_view?id=<?php echo $row->id; ?>" class="btn btn-success btn-sm view-object"><span class="fa fa-eye">View</span>
                                </a>
                            </td>
                        </tr>
						<?php $i++; } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
						<th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th><?php echo $this->lang->line('LRP Id') ?></th>
						<th><?php echo $this->lang->line('Total Products') ?></th>
                        <th><?php echo $this->lang->line('Stock Quantity') ?></th>
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
                    <p><?php echo $this->lang->line('delete this product warehouse') ?></strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="productcategory/delete_warehouse">
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
            $('#catgtable').DataTable({
                responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
            });
        });
    </script>