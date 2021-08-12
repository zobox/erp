<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> Spare Part Warehouse <a
                        href="<?php echo base_url('products/productcomponent') ?>"
                        class="btn btn-primary btn-sm rounded">
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
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <table id="productstable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('WarehouseID') ?></th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Serial Type</th>
                        <th><?php echo $this->lang->line('Warehouse Product Code') ?></th>
                        <th><?php echo $this->lang->line('Serial Number') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;

                        foreach($serial_list as $serial)
                        {
                             switch ($serial->serial_in_type) {
                                 case 1:
                                     $serial_type = "By PO";
                                     break;
                                 case 2:
                                     $serial_type = "By Jobwork";
                                     break;
                                 
                        }
                        ?>
					<tr>
						<td><?=$i++?></td>
						<td>W1</td>
						<td><?=$serial->component_name?></td>
                        <td><?=$serial_type?></td>
						<td><?=$serial->warehouse_product_code?></td>
						<td><?=$serial->serial?></td>
						<td><div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  Print                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" target="_blank"> BarCode</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="<?php echo base_url();?>productcategory/component_serial_label?id=<?=$serial->id?>" target="_blank"> Label 1</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="<?php echo base_url();?>productcategory/component_serial_label_2?id=<?=$serial->id?>" target="_blank">Label 2</a>

                                        

                                    </div>
                                </div></td>
					</tr>
                           <?php } ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
						<th><?php echo $this->lang->line('WarehouseID') ?></th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Serial Type</th>
                        <th><?php echo $this->lang->line('Code') ?></th>
                        <th><?php echo $this->lang->line('Serial Number') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
   <!-- <script type="text/javascript">

        var table;

        $(document).ready(function () {

            //datatables
            table = $('#productstable').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                responsive: true,
                <?php datatable_lang();?>

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('products/warehouseproduct_list') . '?id=' . $_GET['id']; ?>",
                    "type": "POST",
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ], dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ],

            });
            $(document).on('click', ".view-object", function (e) {
                e.preventDefault();
                $('#view-object-id').val($(this).attr('data-object-id'));

                $('#view_model').modal({backdrop: 'static', keyboard: false});

                var actionurl = $('#view-action-url').val();
				alert(actionurl);
                $.ajax({
                    url: baseurl + actionurl,
                    data: 'id=' + $('#view-object-id').val() + '&' + crsf_token + '=' + crsf_hash,
                    type: 'POST',
                    dataType: 'html',
                    success: function (data) {
                        $('#view_object').html(data);

                    }

                });

            });
        });
    </script> -->
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this product') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="view_model" class="modal  fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="view_object">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="view-object-id" value="">
                    <input type="hidden" id="view-action-url" value="products/view_over">

                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Close') ?></button>
                </div>
            </div>
        </div>
    </div>