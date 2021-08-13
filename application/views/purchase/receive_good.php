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

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th>PO#</th>
                        <th><?php echo $this->lang->line('Supplier') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th>Pending Quantity</th>
                        <th>Receive Quantity</th>
                        <th><?php echo "Item"; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        foreach($product_list as $po_list)
                        {
                            $pending_qty = number_format((float)($po_list->total_qty-$po_list->receive_qty), 2, '.', '');
                            switch($po_list->type)
                              {
                                case 2: $prefix = 'MRG_';
                                
                                break;
                                case 3: $prefix = 'SP_';
                                
                                break;
                                default : $prefix = '';
                                
                              } 
                              $purchas_id = $prefix.'#'.$po_list->tid;
                           $i++;
                         ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$purchas_id?></td>
                            <td><?=$po_list->name?></td>
                            <td><?=date('d-m-Y',strtotime($po_list->date_created))?></td>
                            <td><?=$pending_qty?></td>
                            <td><?=$po_list->receive_qty?></td>
                            <td><?=$po_list->product?></td>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th>PO#</th>
                        <th><?php echo $this->lang->line('Supplier') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th>Pending Quantity</th>
                        <th>Receive Quantity</th>
                        <th><?php echo "Item"; ?></th>
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
            $('#cgrtable').DataTable({responsive: true});
        });
    </script>
    