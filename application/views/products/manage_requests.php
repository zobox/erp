<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Manage Requests') ?> <a
                        href="<?php echo base_url('productcategory/addwarehouse') ?>"
                        class="btn btn-info small-button">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
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
                        <th>#</th>
                        <th><?php echo $this->lang->line('Issue ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <!--<th><?php echo $this->lang->line('Component Details') ?></th>-->
                        <th><?php echo $this->lang->line('Product Qty') ?></th>
                        <th><?php echo $this->lang->line('Component Qty') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
						<?php foreach($records as $key=>$row)
                        {	




                            ?>
					    <tr>
                            <td></td>
                            <td>ISU_<?php echo $row->issue_id; ?></td>
                            <td><?php echo $row->product_name; ?></td>
                            <!--<td>Flast light</td>-->
                            <td><?php echo $row->product_qty; ?></td>
                            <td><?php echo $row->component_qty; ?></td>
                            <td><span class="st-due">Due</span></td>
                            <td><a href="<?=base_url()?>purchase/printinvoice?id=<?=$row->issue_id?>" class="btn btn-info btn-xs" title="Download"><span class="fa fa-download"></span></a></td>
                        </tr>
						<?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Issue ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <!--<th><?php echo $this->lang->line('Component Details') ?></th>-->
                        <th><?php echo $this->lang->line('Product Qty') ?></th>
                        <th><?php echo $this->lang->line('Component Qty') ?></th>
                        <th><?php echo $this->lang->line('Component Name') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
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
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ],
            });

        });
    </script>
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