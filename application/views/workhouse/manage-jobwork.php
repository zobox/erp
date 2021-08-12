<div class="content-body">
    
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Manage Job Work') ?>            
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
            <hr>
            <div class="card-body">


                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>					
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Work ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <th><?php echo $this->lang->line('Serial No') ?></th>
                        <th><?php echo $this->lang->line('Components Qty') ?></th>
                        <th>Components Detail</th>
                        <th><?php echo $this->lang->line('Current Condition') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>					
					
                    </thead>
                    <tbody>
					
					<?php 
					/* echo "<pre>";
					print_r($jobwork_list[1]->components);
					echo "</pre>"; 
                    die;*/
					
					$i = 1;

					foreach($jobwork_list as $key=>$row){ 
                        
						switch($row->product_condition){
							case 'A' : $previous_condition = 'Excellent';
							break;
							case 'B' : $previous_condition = 'Superb';
							break;
							case 'C' : $previous_condition = 'Good';
							break;
							case 'D' : $previous_condition = 'OK';
							break;
						}
						
						switch($row->convert_to){
							case 1 : $current_condition = 'Excellent';
							break;
							case 2 : $current_condition = 'Superb';
							break;
							case 3 : $current_condition = 'Good';
							break;
							case 4 : $current_condition = 'Ok';
							break;
						}
						
						if($row->type==0){
							$prefix = 'JOBWORK';
						}else if($row->type==1){
							$prefix = 'SR-JOBWORK';
						}
					
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>
                        <td><?php echo $prefix.$row->jobcard_id; ?></td>
                        <td><?php echo $row->product_detail->product_name; ?></td>
                        <td><?php echo $row->serial; ?></td>
                        <td><?php echo $row->component_qty; ?></td>

                        <td><?php foreach($row->components as $components=>$component_detail)
                        {
                        echo $component_detail->component_name.' => '.$component_detail->serial.'<br>';    
                        } ?> 
                    </td>
                        <td><?php echo $current_condition; ?></td>
                        <td><a href="manage_view?id=<?php echo $row->jobcard_id; ?>" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> View</a></td>
                    </tr>
					<?php $i++; } ?>
					
                    
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Work ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <th><?php echo $this->lang->line('Serial No') ?></th>
                        <th><?php echo $this->lang->line('Components Qty') ?></th>
                        <th>Components Detail</th>
                        <th><?php echo $this->lang->line('Current Condition') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <input type="hidden" id="dashurl" value="products/prd_stats">
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
                        "url": "<?php echo site_url('products/component_list')?>",
                        "type": "POST",
                        'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'group': '<?=$this->input->get('group')?>'}
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [0], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                    dom: 'Blfrtip',lengthMenu: [10, 20, 50, 100, 200, 500],
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ],

                });
                miniDash();


                $(document).on('click', ".view-object", function (e) {
                    e.preventDefault();
                    $('#view-object-id').val($(this).attr('data-object-id'));

                    $('#view_model').modal({backdrop: 'static', keyboard: false});

                    var actionurl = $('#view-action-url').val();
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
                        <input type="hidden" id="action-url" value="products/delete_component">
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
                        <input type="hidden" id="view-action-url" value="products/view_over_component">

                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Close') ?></button>
                    </div>
                </div>
            </div>
        </div>