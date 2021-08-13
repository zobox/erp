<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>
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
                            <img alt="image" id="dpic" class="rounded-circle img-border height-150"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>


                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="<?php echo base_url('customers/view?id=' . $details['id']) ?>"
                                   class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-user"></i> <?php echo $this->lang->line('View') ?></a>
                                <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
                                </a>
                                <a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
                                   class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('View Transactions') ?>
                                </a>
                                <a href="<?php echo base_url('customers/statement?id=' . $details['id']) ?>"
                                   class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Account Statements') ?>
                                </a>
                                <a href="<?php echo base_url('customers/quotes?id=' . $details['id']) ?>"
                                   class="btn btn-purple btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-quote-left"></i> <?php echo $this->lang->line('Quotes') ?>
                                </a> <a href="<?php echo base_url('customers/projects?id=' . $details['id']) ?>"
                                        class="btn btn-vimeo btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
                                            class="fa fa-bullhorn"></i> <?php echo $this->lang->line('Projects') ?>
                                </a>
                                <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>&t=sub"
                                   class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('Subscriptions') ?>
                                </a>
                                <a href="<?php echo base_url('customers/notes?id=' . $details['id']) ?>"
                                   class="btn btn-github btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-book"></i> <?php echo $this->lang->line('Notes') ?>
                                </a>


                                <a href="<?php echo base_url('customers/documents?id=' . $details['id']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Documents') ?>
                                </a>
								
								<a href="<?php echo base_url('customers/commission?id=' . $details['id']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Commission') ?>
                                </a>

                            </div>
                        </div>


                    </div>
                    <div class="col-md-8">
                        <div id="mybutton" class="mb-1">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>
                                <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                            class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                </a>


                                <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                   class="btn btn-info btn-md"><i
                                            class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                </a>


                                <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                   class="btn btn-danger btn-md"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>
                            </div>

                        </div>
                        <hr>
                        <h4><?php echo $this->lang->line('Commission') ?></h4>
                        <hr>
						
							<?php
								/* echo "<pre>";
								print_r($module_commision);
								echo "</pre>"; */
								
								switch($module_commision->module){
									case 1: $module = 'Enterprise';
									break;
									case 2: $module = 'Professional';
									break;
									case 3: $module = 'Standard';
									break;
								}
							?>
						
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="module"><?php echo $this->lang->line('Module') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Module" disabled
										class="form-control margin-bottom b_input required" name="module"
										id="module" value="<?php echo $module; ?>">
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="space_required"><?php echo $this->lang->line('Space Required') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Space Required" disabled
										class="form-control margin-bottom b_input required" name="space_required"
										id="space_required" value="<?php echo $module_commision->space_required ?>" >
								</div>					
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="total_refundable"><?php echo $this->lang->line('Total Refundable') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Total Refundable" disabled
										class="form-control margin-bottom b_input required" name="total_refundable"
										id="total_refundable" value="<?php echo $module_commision->total_refundable; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="franchise_fee"><?php echo $this->lang->line('Franchise Fee') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Franchise Fee" disabled
										class="form-control margin-bottom b_input required" name="franchise_fee"
										id="franchise_fee" value="<?php echo $module_commision->franchise_fee; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="Infra_and_branding_cost"><?php echo $this->lang->line('Infra and Branding Cost') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Infra and Branding Cost" disabled
										class="form-control margin-bottom b_input required" name="Infra_and_branding_cost"
										id="Infra_and_branding_cost" value="<?php echo $module_commision->Infra_and_branding_cost; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="total_non_refundable"><?php echo $this->lang->line('Total Non Refundable') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Total Non Refundable" disabled
										class="form-control margin-bottom b_input required" name="total_non_refundable"
										id="total_non_refundable" value="<?php echo $module_commision->total_non_refundable; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="interest_on_security_deposite"><?php echo $this->lang->line('Interest on Security Deposite') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Interest on Security Deposite" disabled
										class="form-control margin-bottom b_input required" name="interest_on_security_deposite"
										id="interest_on_security_deposite" value="<?php echo $module_commision->interest_on_security_deposite; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label" 
									   for="interest_on_security_deposite_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="Start Date" disabled
										class="form-control margin-bottom b_input required" name="interest_on_security_deposite_st_dt"
										id="interest_on_security_deposite_st_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->interest_on_security_deposite_st_dt)); ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="interest_on_security_deposite_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="End Date" disabled
										class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt"
										id="interest_on_security_deposite_end_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->interest_on_security_deposite_end_dt)); ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="mg"><?php echo $this->lang->line('MG') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="MG" 
										class="form-control margin-bottom b_input required" name="mg" disabled
										id="mg" value="<?php echo $module_commision->mg; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="mg_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="Start Date" 
										class="form-control margin-bottom b_input required" name="mg_st_dt" disabled
										id="mg_st_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->mg_st_dt)); ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="mg_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="End Date" 
										class="form-control margin-bottom b_input required" name="mg_end_dt" disabled
										id="mg_end_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->mg_end_dt)); ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="salary_paid_by_zobox"><?php echo $this->lang->line('Salary Paid By Zobox') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="Salary Paid By Zobox" disabled
										class="form-control margin-bottom b_input required" name="salary_paid_by_zobox"
										id="salary_paid_by_zobox" value="<?php echo $module_commision->salary_paid_by_zobox; ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="salary_paid_by_zobox_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="Start Date" disabled
										class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_st_dt"
										id="salary_paid_by_zobox_st_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->salary_paid_by_zobox_st_dt)); ?>" >
								</div>					
							</div>
							
							<div class="form-group row">
								<label class="col-sm-4 col-form-label"
									   for="salary_paid_by_zobox_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
								<div class="col-sm-6">
									<input type="date" placeholder="End Date" disabled
										class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_end_dt"
										id="salary_paid_by_zobox_end_dt" value="<?php echo date("Y-m-d", strtotime($module_commision->salary_paid_by_zobox_end_dt)); ?>" >
								</div>					
							</div>
						
						
                        <table id="crtstable" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Category') ?></th>
                                <th><?php echo $this->lang->line('Purpose') ?></th>
                                <th><?php echo $this->lang->line('Retail') ?></th>
                                <th><?php echo $this->lang->line('B2C') ?></th>
                                <th><?php echo $this->lang->line('Bulk') ?></th>
                                <th><?php echo $this->lang->line('Renting') ?></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							/* echo "<pre>";
							print_r($cat_commision);
							echo "</pre>"; */
							
							foreach($cat_commision as $key=>$catCom){ 
							switch($catCom->purpose){
								case 1: $purpose = 'Buying';
								break;
								case 2: $purpose = 'Selling';
								break;
								case 3: $purpose = 'Exchange';
								break;
							}
							
							if($catCom->category == $cur_cat){								
								$cat = '';
							}else{
								$cur_cat = $catCom->category;
								$cat = $catCom->category;
							}
							?>
							<tr>
                                <td><?php echo $cat; ?></td>
                                <td><?php echo $purpose; ?></td>
                                <td><?php echo $catCom->retail_commision_percentage; ?></td>
                                <td><?php echo $catCom->b2c_comission_percentage; ?></td>
                                <td><?php echo $catCom->bulk_commision_percentage; ?></td>
                                <td><?php echo $catCom->renting_commision_percentage; ?></td>
                            </tr>
							<?php } ?>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th><?php echo $this->lang->line('Category') ?></th>
                                <th><?php echo $this->lang->line('Purpose') ?></th>
                                <th><?php echo $this->lang->line('Retail') ?></th>
                                <th><?php echo $this->lang->line('B2C') ?></th>
                                <th><?php echo $this->lang->line('Bulk') ?></th>
                                <th><?php echo $this->lang->line('Renting') ?></th>
                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>


            </div>
        </div>
    </div>


    <div id="sendMail" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Email</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="sendmail_form"><input type="hidden"
                                                    name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-envelope-o"
                                                                         aria-hidden="true"></span></div>
                                    <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                           value="<?php echo $details['email'] ?>">
                                </div>

                            </div>

                        </div>


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                                <input type="text" class="form-control"
                                       name="customername" value="<?php echo $details['name'] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                                <input type="text" class="form-control"
                                       name="subject" id="subject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                                <textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
                            </div>
                        </div>

                        <input type="hidden" class="form-control"
                               id="cid" name="tid" value="<?php echo $details['id'] ?>">
                        <input type="hidden" id="action-url" value="communication/send_general">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <button type="button" class="btn btn-primary"
                            id="sendNow"><?php echo $this->lang->line('Send') ?></button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script>
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '<?php echo base_url() ?>customers/displaypic?id=<?php echo $details['id'] ?>';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                done: function (e, data) {

                    //$('<p/>').text(file.name).appendTo('#files');
                    $("#dpic").load(function () {
                        $(this).hide();
                        $(this).fadeIn('slow');
                    }).attr('src', '<?php echo base_url() ?>userfiles/customers/' + data.result);


                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('.summernote').summernote({
                height: 100,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ]
            });


        });


    </script>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Transaction') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this transaction') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="transactions/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>

    


