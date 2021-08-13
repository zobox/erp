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
                                <a href="<?php echo  base_url(); ?>customer/b2bviewinvoices?id=<?php echo $customer->id; ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
                                </a>
                        </div>
                        </div>


                    </div>
                    <div class="col-md-8">
                        
                        <div class="">
                            <h4>Customer Details</h4>


                            

                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Email</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $customer->email; ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Phone') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $customer->phone; ?>
                                </div>

                            </div>
							
							
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Address</strong>
                                </div>
                                <div class="col-md-10">
                                     <?php echo $customer->address; ?>
                                </div>

                            </div>
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
</div>


<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>

