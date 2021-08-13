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
							<?php $this->load->view('customers/franchise_left_nav', $data); ?>
                        </div>


                    </div>
					
					
                    <div class="col-md-8">
					<form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url();?>customers/update_commission">
					<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="module"><?php echo $this->lang->line('Module') ?> </label>
										<div class="col-sm-6">											
											<?php if($franchise->module=='' || $franchise->module==0){ ?>
											<select name="module" id="module" class='form-control b_input' >											
												 <option value="<?php echo $franchise->module; ?>" <?php if($franchise->module==1){ ?>selected="selected" <?php } ?>>Enterprise</option>													
												 <option value="<?php echo $franchise->module; ?>" <?php if($franchise->module==2){ ?>selected="selected" <?php } ?>>Professional</option>													
												 <option value="<?php echo $franchise->module; ?>" <?php if($franchise->module==3){ ?>selected="selected" <?php } ?>>Standard</option>													
											</select>
											<?php }else{ ?>
											<input type="hidden" placeholder="Module" 
												class="form-control margin-bottom b_input required" name="module"
												id="module" value="<?php echo $franchise->module; ?>">
												<strong><?php 
													if($franchise->website_id==1){
														switch($franchise->module){
															case 1: $module = 'Enterprise'; $balance = 200000;
															break;
															case 2: $module = 'Professional'; $balance = 150000;
															break;
															case 3: $module = 'Standard'; $balance = 75000;
															break;
														}
													}else{
														switch($franchise->module){
															case 1: $module = 'Enterprise'; $balance = 350000;
															break;
															case 2: $module = 'Professional'; $balance = 250000;
															break;															
														}
													}
													echo $module;
												?></strong>	
											<?php } ?>
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="balance"><?php echo $this->lang->line('Wallet Balance') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Wallet Balance" 
												class="form-control margin-bottom b_input required" name="balance"
												id="balance" value="<?php if($franchise_commission['balance']==''){ echo $balance; }else{ echo $franchise_commission['balance']; } ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="space_required"><?php echo $this->lang->line('Space Required') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Space Required" 
												class="form-control margin-bottom b_input required" name="space_required"
												id="space_required" value="<?php echo $franchise_commission['space_required'] ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="total_refundable"><?php echo $this->lang->line('Total Refundable') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Total Refundable" 
												class="form-control margin-bottom b_input required" name="total_refundable"
												id="total_refundable" value="<?php echo $franchise_commission['total_refundable'] ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="franchise_fee"><?php echo $this->lang->line('Franchise Fee') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Franchise Fee" 
												class="form-control margin-bottom b_input required" name="franchise_fee"
												id="franchise_fee" value="<?php echo $franchise_commission['franchise_fee'] ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="Infra_and_branding_cost"><?php echo $this->lang->line('Infra and Branding Cost') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Infra and Branding Cost" 
												class="form-control margin-bottom b_input required" name="Infra_and_branding_cost"
												id="Infra_and_branding_cost" value="<?php echo $franchise_commission['Infra_and_branding_cost'] ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="total_non_refundable"><?php echo $this->lang->line('Total Non Refundable') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Total Non Refundable" 
												class="form-control margin-bottom b_input required" name="total_non_refundable"
												id="total_non_refundable" value="<?php echo $franchise_commission['total_non_refundable'] ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="interest_on_security_deposite"><?php echo $this->lang->line('Interest on Security Deposite') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Interest on Security Deposite" 
												class="form-control margin-bottom b_input required" name="interest_on_security_deposite"
												id="interest_on_security_deposite" value="<?php echo $franchise_commission['interest_on_security_deposite'] ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="interest_on_security_deposite_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="Start Date" 
												class="form-control margin-bottom b_input required" name="interest_on_security_deposite_st_dt"
												id="interest_on_security_deposite_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['interest_on_security_deposite_st_dt'])); ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="interest_on_security_deposite_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="End Date" 
												class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt"
												id="interest_on_security_deposite_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['interest_on_security_deposite_end_dt'])); ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="mg"><?php echo $this->lang->line('MG') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="MG" 
												class="form-control margin-bottom b_input required" name="mg"
												id="mg" value="<?php echo $franchise_commission['mg'] ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="mg_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="Start Date" 
												class="form-control margin-bottom b_input required" name="mg_st_dt"
												id="mg_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['mg_st_dt'])); ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="mg_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="End Date" 
												class="form-control margin-bottom b_input required" name="mg_end_dt"
												id="mg_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['mg_end_dt'])); ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="salary_paid_by_zobox"><?php echo $this->lang->line('Salary Paid By Zobox') ?> </label>
										<div class="col-sm-6">
											<input type="text" placeholder="Salary Paid By Zobox" 
												class="form-control margin-bottom b_input required" name="salary_paid_by_zobox"
												id="salary_paid_by_zobox" value="<?php echo $franchise_commission['salary_paid_by_zobox'] ?>" >
										</div>					
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="salary_paid_by_zobox_st_dt"><?php echo $this->lang->line('Start Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="Start Date" 
												class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_st_dt"
												id="salary_paid_by_zobox_st_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['salary_paid_by_zobox_st_dt'])); ?>" >
										</div>					
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="salary_paid_by_zobox_end_dt"><?php echo $this->lang->line('End Date') ?> </label>
										<div class="col-sm-6">
											<input type="date" placeholder="End Date" 
												class="form-control margin-bottom b_input required" name="salary_paid_by_zobox_end_dt"
												id="salary_paid_by_zobox_end_dt" value="<?php echo date("Y-m-d", strtotime($franchise_commission['salary_paid_by_zobox_end_dt'])); ?>" >
										</div>					
									</div>
									<!--<h4><strong><?php echo $this->lang->line('Category') ?></strong></h4>
									<hr>-->
									
									<div>
									<div class="outer-div" style="border-bottom:1px solid #ddd;;max-width:100%;">
									  <div class="header row">
										<div class="col-sm-4">
										  <div style="padding:11px 28px;"><strong>CATEGORY</strong></div>
										</div>
										<div class="col-sm-8">
										  <div class="d-flex align-items-center" style="width:100%;">
											<div style="width:21%;padding:11px 28px;"><strong>Purpose</strong></div>
											<div style="width:20%;padding:11px 23px;"><strong>Retail</strong></div>
											<div style="width:20%;padding:11px 28px;"><strong>B2C</strong></div>
											<div style="padding:11px 24px;width:20%"><strong>Bulk</strong></div>
											<div style="padding:11px 13px;width:21%"><strong>Renting</strong></div>
										  </div>
										  
										  
										</div>
									  </div>
									</div>
									<?php 
												/* echo "<pre>";
												print_r(json_decode(json_encode($catcommision),true));
												echo "</pre>"; 	 */				
												
											foreach($cat as $key=>$cat_data){ 							
											$cat_id = $cat_data->id;							
											?>
											
											
											<div class="outer-div" style="max-width:100%;">
											  <div class="header row" style="border-top:1px solid #000;">
												<div class="col-sm-4">
												  <div style="padding:11px 28px;"><?php echo $cat_data->title; ?></div>
												  
												  <div style="padding:11px 28px;">
													<span>                                   
													   <?php foreach($catcommision[$cat_id]['child'] as $scat){ ?>
														<ul style="display:block; padding:0px !important; margin-left: 5px;">
														<input class="subcat" type="checkbox" <?php if($scat->commission_status==1){ ?> checked <?php } ?> id="subcat<?php echo $cat_id; ?>" name="subcat[<?php echo $scat->id; ?>]" value="<?php echo $cat_id; ?>-<?php echo $scat->id; ?>"> 
														<?php echo $scat->title;?>
															<?php 
															if(is_array($scat->child)){
																echo sub_print($scat->child,$cat_id);
															}
															?>
														<?php }?>
														</ul>																					
													</span>	
												  </div>
												  
												</div>
												<div class="col-sm-8">
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:28%;padding:11px 28px;">Buying</div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][1]" id="retail[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->retail_commision_percentage; ?>"></div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][1]" id="b2c[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][1]" id="bulk[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][1]" id="renting[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->renting_commision_percentage; ?>"></div>
												  </div>
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:28%;padding:11px 28px;">Selling</div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][2]" id="retail[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->retail_commision_percentage; ?>"></div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][2]" id="b2c[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][2]" id="bulk[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][2]" id="renting[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->renting_commision_percentage; ?>"></div>
												  </div>
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:28%;padding:11px 28px;">Exchange</div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][3]" id="retail[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->retail_commision_percentage; ?>"></div>
													<div style="width:28%;padding:11px 0px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][3]" id="b2c[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][3]" id="bulk[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 0px;width:28%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][3]" id="renting[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->renting_commision_percentage; ?>"></div>
												  </div>
												  
												</div>
											  </div>
											  
											<?php foreach($catcommision[$cat_id]['child'] as $scat){ 
											$scat_id = $scat->id;
											?>
											<!--<tbody style="display:none" id="scommision<?php echo $scat_id; ?>"></tbody>-->
											<div style="display:none" id="scommision<?php echo $scat_id; ?>"></div>
											<?php }?>
											<!--<tbody style="display:none" id="scommision<?php echo $cat_id; ?>"></tbody>-->				
											<div style="display:none" id="scommision<?php echo $cat_id; ?>"></div>	
											<?php } ?>				  
											  
											</div>									
									
									
									
									</div>
									
									<div class="form-group row pt-2 text-center">

										<label class="col-sm-2 col-form-label"></label>

										<div class="col-sm-8">
											<input type="submit" id="submit-data11" class="btn btn-success margin-bottom"
												   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
										</div>
									</div>
									<?php $id = $this->input->get('id', true); ?>
									<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
									<input type="hidden" value="customers/addcustomer" id="action-url">			

					</form>
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

    
<?php
function subcat_print($array,$cat_id) {
    $output = "<ol style='padding:0px !important; margin-left: 10px;'>";
    foreach ($array as $value) {
        if (is_array($value->child)) {
            $output .= '<ul style="display:block; padding:0px !important; margin-left: 5px;">';
				$output .= subcat_print($value->child,$cat_id);
			$output .= "</ul>";	
        } else {
			$output .='<input type="checkbox" id="subcat';
			$output .=$cat_id; 
			$output .='" name="subcat';
			$output .=$cat_id;
			$output .='" value="';
			$output .=$value->id; 
			$output .='">'; 
            $output .= $value->title;
        }		
    }
    $output .= "</ol>";				
    return $output;
}


function sub_print($array,$cat_id) {
    $output = "<ul style='list-style:none;'>";
    foreach ($array as $value) {
        if (is_array($value->child)) {
			$output .= "<li>";
			$output .='<input class="subcat" type="checkbox" ';
			if($value->commission_status==1){
				$output .='checked ';
			}
			$output .='id="subcat';
			$output .=$cat_id; 
			$output .='" name="subcat[';
			$output .=$value->id;
			$output .=']" value="';
			$output .=$cat_id; 
			$output .='-'; 
			$output .=$value->id; 
			$output .='"> '; 
            $output .= $value->title;			
			$output .="</li>";
			
            $output .= "<li>".sub_print($value->child,$cat_id)."</li>";
        } else {
            $output .= "<li>";
			$output .='<input class="subcat" type="checkbox"'; 
			if($value->commission_status==1){
				$output .='checked ';
			}
			$output .='id="subcat';			
			$output .=$cat_id; 
			$output .='" name="subcat[';
			$output .=$value->id;
			$output .=']" value="';
			$output .=$cat_id; 
			$output .='-'; 
			$output .=$value->id; 
			$output .='"> '; 
            $output .= $value->title;			
			$output .="</li>";
        }
    }
    $output .= "</ul>";
    return $output;
}

?>




<script type="text/javascript">
    $('.subcat').click(function(){
		var id = $(this).val();		
		var apend_val = 0;
		var ids = id.split('-');
		var apend_var = '#apend'+ids[1];
		var apendtbl_var = '#apendtbl'+ids[1];
		if($(apend_var).val()){
		var apend_val = $(apend_var).val();
		}
		var scommision_var = '#scommision'+ids[0];
		//var scommision_var = '#scommision';		
		var url = baseurl;
		//alert(apendtbl_var);
		if(apend_val==0){
		$.ajax({
			type : 'POST',
			url : url+"customers/getSubcatAjaxData",
			data : {categoryId:ids[1],moduleid:<?php echo $franchise->module;?>,franchise_id:<?php echo $franchise->id;?>},
			cache : false,
			success : function(result)
				{
					console.log(result);
					$(scommision_var).css("display","block");
					$(scommision_var).append(result);
				}
			});
		}else{
			//$(scommision_var).css("display","none");
			$(apendtbl_var).remove();
		}
	});
	
	
	$(window).ready(function(){
		
		$('input[type="checkbox"]:checked').each(function() {
			var id = $(this).val();
			//alert(123);
			var ids = id.split('-');
			//alert(ids[1]);
			var scommision_var = '#scommision'+ids[0];
			var url = baseurl;
			$.ajax({
			type : 'POST',
			url : url+"customers/getSubcatAjaxData",
			data : {categoryId:ids[1],moduleid:<?php echo $franchise->module;?>,franchise_id:<?php echo $franchise->id;?>},
			cache : false,
			success : function(result)
				{					
					//console.log('hi');
					$(scommision_var).css("display","block");
					$(scommision_var).append(result);
				}
			});
			
		});
	});
</script>

