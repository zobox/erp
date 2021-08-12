<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Pending Requests') ?> 
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
                        <th><?php echo $this->lang->line('Request ID') ?></th>
                        <th><?php echo $this->lang->line('Product Detail') ?></th>
                        <th>Serial No</th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
                        <th><?php echo $this->lang->line('Components') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					
					<?php
						 
						/* echo "<pre>";
						print_r($records);
						echo "</pre>"; exit;  */
						 
						/* $i=1;
                        for($k=0;$k<count($records);$k++)
                        {
						// $component = $row->item_replaced;
						// $component_array = explode(',',$component); 
						$serialno = implode(', ',$records['serial_no'][$i]);
						$request_id = $records[$i]->id;					
					?>
                        <tr>
                            <td><?php echo $i; //echo $row->id; ?></td>
                            <td><?php echo 'REQ_000'.$request_id; ?></td>
                            <td><?php echo $records[$i]->product_name; ?></td>
                            <td><?php echo $serialno; ?></td>

                            <td><?php echo $records[$i]->qty; ?></td>
                            <!--<td><?php echo count($component_array); ?></td>-->
                            <td><a href="<?= base_url() ?>Productcategory/panding_scan/?id=<?php echo $records[$i]->id; ?>" class="btn btn-primary btn-xs">Scan</a></td>
                        </tr>
					<?php $i++; }  */	?>
						
						<?php $i=1; foreach($records as $key=>$row){ ?>
						<tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo 'REQ_000'.$row->id; ?></td>
                            <td><?php echo $row->product_name; ?></td>
                            <td><?php $j=0; foreach($row->serial_records as $key=>$row1){ if($j>0){ echo ","; } echo $row1->serial; $j++;} ?></td>

                            <td><?php echo $row->qty; ?></td>
                            <td><?php echo str_replace(',','<br>', $row->component_detail[0]->item_replaced); ?></td>
                            <td><a href="<?= base_url() ?>Productcategory/panding_scan/?id=<?php echo $row->id; ?>" class="btn btn-primary btn-xs">Scan</a> &nbsp;<a href="#" data-object-id="<?php echo $row->id; ?>" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span><?=$this->lang->line('Delete')?></a></td>
                        </tr>
						<?php $i++; } ?>
						
                    </tbody>
					
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Request ID') ?></th>
                        <th><?php echo $this->lang->line('Product Detail') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
                        <!--<th><?php echo $this->lang->line('Components') ?></th>-->
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div id="edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content" style="height:375px;">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Edit') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" method="post" action="<?php echo base_url()?>workhousejob/assign_engineer">
                <div class="row">
                        <div class="col">
                            <div class="input-group">
                            <select name="status" id="status-1" class="form-control b_input">
									<option value="">--Select IMEI--</option>
									<option>10125424101520</option>
									<option>10125424101521</option>
									<option>10125424101522</option>
									<option>10125424101523</option>
									<option>10125424101524</option>
							</select>                                                                      
                            </div>
                        </div>                       
                </div>
                <br>
                <div class="row">
                        <div class="col">
                        <label class="col-sm-8 col-form-label pl-0" for="replaced_items">
                                                <?php echo $this->lang->line('Add Item to be replaced') ?>
                                            </label>
                        </div>                       
                </div>
                <div class="row">
                        <div class="col">
                        <select id="conditionsdp1" style="width: 470px !important;height:100px !important;" name="items[]" class="form-control required 	select-box"
												multiple="multiple" onfocus="getconditions();">
												
											 </select>
                        </div>                       
                </div>
                <br>
                   
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="type" id="type" value="1">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>                        
                        <button type="submit" class="btn btn-primary"
                                id="assign_engineer_submit"><?php echo $this->lang->line('Submit') ?></button>
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

                        <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Delete this Request ID</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id" value="">
                        <input type="hidden" id="action-url" value="productcategory/delete_request_jobwork">
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