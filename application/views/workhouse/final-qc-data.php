<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('QC Data') ?> </h4>
          <!--  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>  -->
           <!-- <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>  -->
     
    
        </div>
        
        
        
        
        <div class="card-content">
            
            <div class="card-body" style="padding-top: 0px;">
              
                <hr>
                
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Brand') ?></th>
                        <th><?php echo $this->lang->line('Product Label') ?></th>
                        <th><?php echo $this->lang->line('Varient') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('Product Condition') ?></th>
                        <th><?php echo $this->lang->line('IMEI-1') ?></th>
                        <th><?php echo $this->lang->line('IMEI-2') ?></th>
                        <th><?php echo $this->lang->line('Items to be Replaced') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Qc Engineer') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                   <!--- <tr>
                        <td>1</td>
                        <td>MI</td>
                        <td>Note 3 Pro</td>
                        <td>16GB</td>
                        <td>Black</td>
                        <td>Good</td>
                        <td>521205151</td>
                        <td>464654654</td>
                        <td>Screen</td>
                        <td>Vikas</td>
                        <td><a href="#sendSmsS" data-toggle="modal" data-remote="false" class="btn btn-info  btn-sm  view-object" style="margin-right: 5px;" > Edit</a><a href="#" data-object-id="3" class="btn btn-success  btn-sm  view-object">Follow</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Apple</td>
                        <td>8+</td>
                        <td>128GB</td>
                        <td>Gold</td>
                        <td>Good</td>
                        <td>102562102</td>
                        <td>785455620</td>
                        <td>USB</td>
                        <td>Deepanshu</td>
                        <td><a href="#sendSmsS" data-toggle="modal" data-remote="false" class="btn btn-info  btn-sm  view-object" style="margin-right: 5px;" > Edit</a><a href="#" data-object-id="3" class="btn btn-success  btn-sm  view-object">Follow</a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Samsung</td>
                        <td>A7</td>
                        <td>256GB</td>
                        <td>White</td>
                        <td>Bad</td>
                        <td>892215250</td>
                        <td>671512052</td>
                        <td>Screen</td>
                        <td>Amit</td>
                        <td><a href="#sendSmsS" data-toggle="modal" data-remote="false" class="btn btn-info  btn-sm  view-object" style="margin-right: 5px;" > Edit</a><a href="#" data-object-id="3" class="btn btn-success  btn-sm  view-object">Follow</a></td>
                    </tr>--> 
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Brand') ?></th>
                        <th><?php echo $this->lang->line('Product Label') ?></th>
                        <th><?php echo $this->lang->line('Varient') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('Product Condition') ?></th>
                        <th><?php echo $this->lang->line('IMEI-1') ?></th>
                        <th><?php echo $this->lang->line('IMEI-2') ?></th>
                        <th><?php echo $this->lang->line('Items to be Replaced') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Qc Engineer') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
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
                <p><?php echo $this->lang->line('delete this quote') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="quote/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="sendSmsS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Final Product Condition</label>
                            <select class="form-control" >
                                <option>Ok</option>
                                <option>Good</option>
                                <option>Superb</option>
                                <option>Excellent </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" form-group">

                            <label>Previous Spare Parts</label>
                            <input type="text" name="" value="Battery, Screen" class="form-control" disabled="disabled">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" form-group">
                            <label>New Spare Parts</label>
                            <input type="text" name="" class="form-control" style="height: 100px;">
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer" style="text-align: center;">
                
                <button type="button" class="btn btn-primary" style="display: block;margin:0px auto;" 
                        id="sendNowSelected"><?php echo $this->lang->line('Submit') ?></button>
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