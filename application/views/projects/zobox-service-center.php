<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title"><?php echo $this->lang->line('Zobox Service Centers') ?> </h4>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
           <!--<div class="form-group row">
        <form method="post" id="data_form" class="card-body" enctype="multipart/form-data" action="<?=base_url()?>projects/import_service">
        <div class="col-sm-6" style="margin-bottom:-10px;">   
            <input type="file" name="file" id="file">  
            <input type="submit" id="submit-data11" class="btn btn-success margin-bottom"
                       value="Upload Sample File" data-loading-text="Adding...">
            <!--<a href="http://13.233.62.90/zobox/leads/sample_lead" title="sample file" class="btn btn-primary btn-sm">Upload Sample File</a> -
        </div>
        </form>
      </div>-->
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
                        <th>#</th>
                        <th><?php echo $this->lang->line('State') ?></th>
                        <th>City</th>
                        <th>Location Name</th>
                        <th>Address</th>
                        <th>Pin Code</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($service_list)>0)
                        {
                            $i=0;
                            foreach($service_list as $row)
                            {
                                $i++;
                                ?>
                            <tr>
                            <td><?=$i?></td>
                            <td><?=$row['state']?></td>
                            <td><?=$row['city']?></td>
                            <td><?=$row['location']?></td>
                            <td style="width: 35%;"><?=$row['address']?></td>
                            <td><?=$row['pincode']?></td>
                        </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('State') ?></th>
                        <th>City</th>
                        <th>Location Name</th>
                        <th>Address</th>
                        <th>Pin Code</th>
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
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ],

        });
        });
    </script>
    