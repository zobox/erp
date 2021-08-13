<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Spareparts Warehouse') ?> <a
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
                        
                        <th>Serial</th>
                        <th>Total</th>
                        <th>Price</th>
                        <th>Id</th>
                        
                        <th>Name</th>
                        <th>Status</th>
                        <th>Warehouse</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                                  
                        foreach($result as $data)
                        {

                            $i++;
                            ?>
                            <tr>
                                
                                <th><?=$data['serial'];?></th>
                                <th><?=$data['counter'];?></th>
                                <th><?=str_replace(',','<br>',$data['sale_price']);?></th>
                                <th><?=str_replace(',','<br>',$data['product_id']);?></th>

                                <th><?=str_replace(',','<br>',$data['product_name']);?></th>
                                <th><?=str_replace(',','<br>',$data['serial_status']);?></th>
                                <th><?=str_replace(',','<br>',$data['warehouse']);?></th>
                            </tr>
                            <?php
                        }
                    
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                       <th>#</th>
                        <th>Serial</th>
                        <th>Total</th>
                        <th>Price</th>
                        <th>Id</th>
                        
                        <th>Name</th>
                        <th>Status</th>
                        <th>Warehouse</th>
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
                            columns: [0, 1, 2, 3, 4, 5, 6]
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