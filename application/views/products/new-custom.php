<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4><?php echo $this->lang->line('Custom Label') ?> <a  href="<?php echo base_url('products/adddata') ?>" class="btn btn-info rounded small-button">
                    Add Data               </a></h4>
            
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body pt-0" >
                <div class="form-group row">  
          <!--<div class="col-sm-12">
            <div class="upload-flex">    
                <div class="downloadbx">      
                    <a href="#" class="button btn btn-info text-white" ><span><i class="fa fa-download"></i></span>Download Sample</a>
                </div>    
                <div class="downloadbxx">
                    <span class="btn  fileinput-button button"> <i class="glyphicon glyphicon-plus"></i> <span>Select files...</span>
            
                    <input id="fileupload" type="file" name="files[]">
                    </span>
                </div>
                <div class="downloadbx ml-1">      
                    <a  class="button btn btn-success text-white" ><span><i class="fa fa-cloud-upload"></i></span>Upload</a>
                </div>  
                 
            </div>
          </div>-->
       <!--<div class="col-sm-2" style="margin-right:-60px;"><a href="#" class="btn btn-info btn-xs" title="Download"><span class="fa fa-download"></span></a>&nbsp Download</div>
        <div class="col-sm-2"><input type="file" name="file" id="file"> </div>
        <div class="col-sm-2"> <a href="#" class="btn btn-success btn-xs" title="Upload"><span class="fa fa-upload"></span></a>&nbsp Upload </div>
        <div class="col-sm-2" style="margin-left:-80px;"> <a href="adddata" class="btn btn-warning btn-xs">Add Data</a> </div>-->
    
        </div>
                <hr>

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Product') ?></th>
                        <th><?php echo $this->lang->line('Variant') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('MRP') ?></th>
                        <th><?php echo $this->lang->line('ZUPC') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
                        <th><?php echo $this->lang->line('IMEI 1') ?></th>
                        <th><?php echo $this->lang->line('IMEI 2') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $k=0;
                        
                        foreach($product_list as $po_list)
                        {
                           $i++
                         ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=date('d-m-Y',strtotime($po_list->date_created))?></td>
                            <td><?=$po_list->product_name?></td>
                            <td><?=$po_list->unit_name?>.00</td>
                            <td><?=$po_list->colour_name?></td>
                            <td><?=$po_list->price?></td>
                            <td><?=$po_list->zupc_code?></td>
                            <td><?=$po_list->qty?></td>
                            <td><?=$po_list->imei_1?></td>
                            <td><?=$po_list->imei_2?></td>
                            <td><a href="<?= base_url() ?>products/new_custom_label?id=<?=$po_list->id?>" class="button btn btn-warning text-white btn-sm">Label</a> &nbsp;&nbsp; &nbsp;<a href="<?= base_url() ?>products/new_custom_label?id=<?=$po_list->id?>&type=mini" class="button btn btn-primary text-white btn-sm">Mini Label</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Product') ?></th>
                        <th><?php echo $this->lang->line('Variant') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('MRP') ?></th>
                        <th><?php echo $this->lang->line('ZUPC') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
                        <th><?php echo $this->lang->line('IMEI 1') ?></th>
                        <th><?php echo $this->lang->line('IMEI 2') ?></th>
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
	
    