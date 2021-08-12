<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Failed QC Work') ?>  <!--   <a href="<?php echo base_url('clientgroup/create') ?>"
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
						<th style="width: 47px;"><?php echo $this->lang->line('Job Work ID') ?></th>
                        <th style="width: 200px;"><?php echo $this->lang->line('Product Detail') ?></th>
						<th style="width: 14px;"><?php echo $this->lang->line('Product Serial No') ?></th>
                        <th style="width: 205px;"><?php echo $this->lang->line('Assign TL') ?></th>
                        <th style="width: 205px;"><?php echo $this->lang->line('Assign Engineer') ?></th>
						

						<th><?php echo $this->lang->line('Job Card Status') ?></th>
                        <th><?php echo $this->lang->line('Final QC Status') ?></th>
                        <th style="width: 45px;"><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>

					<?php
                          $k=1; 
                          for($i=0;$i<count($failed_jobwork_list['jobwork']);$i++)
                          {
                         ?>
                    <tr>
                        <td><?=$k++?></td>
                        <td>JOBWORK<?=$failed_jobwork_list['jobwork'][$i]->request_id?></td>
                        <td><?=$failed_jobwork_list['product_info'][$i]->product_name?></td>
                        
                        <td><?=$failed_jobwork_list['jobwork'][$i]->serial?></td>
                        <td><?=$failed_jobwork_list['jobwork'][$i]->username?></td>
                        <td><?=$failed_jobwork_list['jobwork'][$i]->assign_engineer?></td>
                        <td>
                            <?php 
                            if($failed_jobwork_list['jobwork'][$i]->change_status==1)
                            {
                                echo '<span class="badge  st-paid app" style="background-color:blue;">Pending</span>';
                             
 
                            }
                            if($failed_jobwork_list['jobwork'][$i]->change_status==2)
                            {
                                echo '<span class="badge  st-paid app" style="background-color:yellow;color:#000;">In Progress - TRC</span>';
                            }
                            if($failed_jobwork_list['jobwork'][$i]->change_status==3)
                            {
                                echo '<span class="badge  st-paid app" style="background-color:#5ed45e;">Proceed For QC</span>';
                            }
                            ?> 
                            </td>
                        
                        <td><span class="badge  st-paid app"><?php if($failed_jobwork_list['jobwork'][$i]->final_qc_status==1) { echo 'Pending'; } elseif($failed_jobwork_list['jobwork'][$i]->final_qc_status==2) { echo 'QC PASS'; } else { echo 'QC Failed'; } ?></span></td>
                        <td><a href="failed_view?id=<?=$failed_jobwork_list['jobwork'][$i]->request_id?>" class="btn btn-success btn-xs sr"><i class="fa fa-eye"></i>  View</a><a href="#pop_model20<?=$failed_jobwork_list['jobwork'][$i]->request_id?>" data-toggle="modal" data-remote="false" class="btn btn-warning" style="margin-top: 4px;padding: 6px;font-size: 12px;">Remarks</a></td>
                        <div id="pop_model20<?=$failed_jobwork_list['jobwork'][$i]->request_id?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Remarks') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model">
                    <div class="row">
                    <div class="col mb-1">
                            <textarea name="message" placeholder="Remarks" class="form-control" rows="8" cols="60"><?=$failed_jobwork_list['jobwork'][$i]->final_qc_remarks?></textarea></div>
                    </div>
                    </div>

                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    </tr>
                <?php }     ?>
					</tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Job Work ID') ?></th>
						<th><?php echo $this->lang->line('Product Detail') ?></th>
                        <th><?php echo $this->lang->line('Product Serial No') ?></th>
                        <th><?php echo $this->lang->line('Assign TL') ?></th>
                        <th style="width: 205px;"><?php echo $this->lang->line('Assign Engineer') ?></th>
						
                        <th><?php echo $this->lang->line('Job Card Status') ?></th>
                        <th><?php echo $this->lang->line('Final QC Status') ?></th>
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