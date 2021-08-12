<div class="content-body">
<div class="card">
  <div class="card-header">
    <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?> : <?php echo $details['name'] ?></h4>
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
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 border-right border-right-grey">
          <div class="ibox-content mt-2"> <img alt="image" id="dpic" class="rounded-circle img-border height-150"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>"> </div>
          <hr>
          <div class="row mt-3">
            <!--<div class="col-md-12"> <a href="<?php echo base_url('customers/view?id=' . $details['id']) ?>"
                                   class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-user"></i> <?php echo $this->lang->line('View') ?></a> <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?> </a> <a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
                                   class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('View Transactions') ?> </a> <a href="<?php echo base_url('customers/statement?id=' . $details['id']) ?>"
                                   class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Account Statements') ?> </a> <a href="<?php echo base_url('customers/quotes?id=' . $details['id']) ?>"
                                   class="btn btn-purple btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-quote-left"></i> <?php echo $this->lang->line('Quotes') ?> </a> <a href="<?php echo base_url('customers/projects?id=' . $details['id']) ?>"
                                        class="btn btn-vimeo btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
                                            class="fa fa-bullhorn"></i> <?php echo $this->lang->line('Projects') ?> </a> <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>&t=sub"
                                   class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('Subscriptions') ?> </a> <a href="<?php echo base_url('customers/notes?id=' . $details['id']) ?>"
                                   class="btn btn-github btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-book"></i> <?php echo $this->lang->line('Notes') ?> </a> <a href="<?php echo base_url('customers/documents?id=' . $details['id']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Documents') ?> </a> <a href="<?php echo base_url('customers/commission?id=' . $details['id']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Commission') ?> </a> <a href="<?php echo base_url('customers/commission_wallet?id=' . $details['id']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> Commission Wallet </a> </div>-->
											<?php $this->load->view('customers/franchise_left_nav', $data); ?>
          </div>
        </div>
        <div class="col-md-8">
          <div id="mybutton" class="mb-1">
            <div class=""> <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?> </a> <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                            class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?> </a> <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                   class="btn btn-info btn-md"><i
                                            class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?> </a> <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                   class="btn btn-danger btn-md"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?> </a> 
											<a href="<?php echo base_url('customers/commission_wallet_balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> Commission Wallet
                                </a>
								</div>
          </div>
          <hr>
          <h4>Commission Wallet <button data-toggle="modal" data-target="#excel_model" class="btn btn-primary">Excel</button></h4>
		 
          <hr>
          <table id="invoices" class="table table-striped table-bordered zero-configuration table-responsive"
                               cellspacing="0" width="100%">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('Invoice') ?> No</th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th>Qty</th>
                <th class="no-sort">Invoice Gross Price</th>
                <th class="no-sort">Invoice Net Price</th>
				<th>Invoice GST</th>
                <th>Commission Amount</th>
                <th class="no-sort">Commission %</th>
                <th class="no-sort">TDS</th>
              </tr>
            </thead>
            <tbody>
				<?php 
				/* echo "<pre>"; 
				print_r(json_decode($list));
				echo "</pre>"; */
				foreach(json_decode($list) as $key=>$invoices){
					switch($invoices->type){
						case 1: $prefix = 'STFO#';
						break;
						case 2: if($invoices->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
						break;
						case 3: $prefix = 'STF#';
						break;
						case 4: $prefix = 'PO#';
						break;
					}
				?>
				<tr>
					<td><?php echo '<a href="' . base_url("invoices/view?id=$invoices->id") . '"><i class="fa fa-file-text"></i> ' . $prefix .$invoices->tid . '</a>'; ?></td>
					<td><?php echo $invoices->invoicedate; ?></td>
					<td><?php echo $invoices->items; ?></td>
					<td class="no-sort"><?php echo $invoices->total; ?></td>
					<td class="no-sort"><?php echo $invoices->net_price; ?></td>
					<td><?php echo $invoices->tax; ?></td>
					<td><?php echo $invoices->franchise_commision; ?></td>
					<td class="no-sort"><?php echo $invoices->fcp; ?></td>
					<td class="no-sort"><?php echo $invoices->tds; ?></td>
				</tr>
				<?php } ?>
            </tbody>
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
        <form id="sendmail_form">
          <input type="hidden"
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
            <div class="col mb-1">
              <label
                                        for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
              <input type="text" class="form-control"
                                       name="customername" value="<?php echo $details['name'] ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-1">
              <label
                                        for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
              <input type="text" class="form-control"
                                       name="subject" id="subject">
            </div>
          </div>
          <div class="row">
            <div class="col mb-1">
              <label
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
        <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p><?php echo $this->lang->line('You can not revert') ?></p>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="object-id" value="">
        <input type="hidden" id="action-url" value="invoices/delete_i">
        <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
        <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
      </div>
    </div>
  </div>
</div>




<div id="excel_model" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Download Commission Wallet Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="download_commission_wallet_excel" id="download_commission_wallet_excel" method="post" action="download_commission_wallet_excel">
		Start Date : <input type="date" class="form-control" name="start_date" id="start_date" />
		End Date : <input type="date" class="form-control" name="end_date" id="end_date" />
        <input type="hidden" id="action-url" value="customers/download_commission_wallet_excel">
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Download</button>
        <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
		<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $this->input->get('id'); ?>">
		</form>
      </div>
    </div>
  </div>
</div>

