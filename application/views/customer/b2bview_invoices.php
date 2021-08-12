<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">B2B Customer</h4>
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


                <div class="row">
                    <div class="col-md-4 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="card-img-top img-fluid"
                                 src="<?php echo $customer->image; ?>">
                        </div>
                        <hr>
                        <h6>
                            <strong>Customer Name : </strong><small><?php echo $customer->name; ?></small>
                        </h6>
                        <div class="row mt-3">
                        <div class="col-md-12">
                                <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
                                </a>
                        </div>
                        </div>


                    </div>
                    <div class="col-md-8">
                        
                    <h4><?php echo $this->lang->line('Invoices') ?></h4>
                        <hr>
                        <table id="cgrtable" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th><?php echo $this->lang->line('Invoice') ?>#</th>

                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Total') ?></th>
                                <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                            </tr>
                            </thead>
                            <tbody>
							
							<?php 
							/* echo "<pre>";
							print_r($list);
							echo "</pre>"; */
							
							foreach($list as $key=>$data){
							?>
							<tr>
                                <td><?php echo $data->tid; ?></td>
                                <td><?php echo $data->invoicedate; ?></td>
                                <td><?php echo $data->total; ?></td>
                                <td class="no-sort"><?php echo '<span class="st-' . $data->status . '">' . $this->lang->line(ucwords($data->status)) . '</span>'; ?></td>
                                <td class="no-sort"><?php echo '<a href="' . base_url("invoices/view?id=$data->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$data->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $data->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a> '; ?></td>
                            </tr>
							<?php } ?>
							
                            </tbody>

                            <tfoot>
                            <tr>

                                <th><?php echo $this->lang->line('Invoice') ?>#</th>

                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Total') ?></th>
                                <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                            </tr>
                            </tfoot>
                        </table>
                        <hr />
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><a href='<?php echo base_url()?>customer/b2bcustomers' class='btn btn-success btn-sm'>Back</a></strong>
                                </div>
                                

                            </div>
                    </div>
                </div>


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

<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script type="text/javascript">
        $(document).ready(function () {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('customer/inv_list')?>",
                    'type': 'POST',
                    'data': {
                        'cid':<?php echo $_GET['id'] ?>,
                        //'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
            });
        });
    </script>