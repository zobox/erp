<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Add Lead Details</h4>
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
            <div class="card-body" style="margin-top: -40px;">
                <div class="row">
                    <div class="col-md-12">
						<form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                        <div class="">
                           
                                  
                            
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
									<div class="form-group row mt-1">
										<label class="col-sm-2 col-form-label" for="company_name">Business</label>
										<div class="col-sm-3 col-lg-2">
											<select name="website_id" id="website_id" class="form-control b_input required">
												<option value="">Select</option>
												<option value="1">Zobox</option>
												<option value="2">Zoloot</option>
											</select>																		
										</div>
									</div>
									
									<div class="form-group row mt-1">
                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Company | Personal') ?></label>
                                        <div class="col-sm-3 col-lg-2">
                                            <select name="personal_company" id="personal_company" class="form-control b_input required">
												<option value="">Select</option>
												<option value="2">Company</option>
												<option value="1">Individual</option>
											</select>																		
                                        </div>
                                    </div>
									
									<div class="form-group row mt-1">
                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Franchise Module') ?></label>

                                        <div class="col-sm-3 col-lg-2">
											<select name="module" id="module" class="form-control b_input required">
												<option value="">Select</option>
												<option value="1">Enterprise</option>
												<option value="2">Professional</option>
												<option value="3">Standard</option>
											</select>																		
                                        </div>
                                    </div>
									
									<div id="personal_div" <?php if($franchise['personal_company']==2){?> style="display:none;"<?php }?>>
									
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_name"><?php echo $this->lang->line('Franchiser Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Franchise Name"
													   class="form-control margin-bottom b_input" name="franchise_name"												   
													   id="franchise_name" value="<?php echo $franchise['franchise_name'] ?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_email"><?php echo $this->lang->line('Franchiser Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Communation Email"
													   class="form-control margin-bottom b_input" name="franchise_email"												   
													   id="franchise_email" value="<?php echo $franchise['franchise_email'] ?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_phone"><?php echo $this->lang->line('Franchiser Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Communication Phone No"
													   class="form-control margin-bottom b_input" name="franchise_phone"												   
													   id="franchise_phone" value="<?php echo $franchise['franchise_phone'] ?>">
											</div>
										</div>
									
									</div>
									
									<div id="company_div" <?php if($franchise['personal_company']==1){?> style="display:none;"<?php }?>>

										<div class="form-group row mt-1">

											<label class="col-sm-2 col-form-label"
												   for="company_name"><?php echo $this->lang->line('Company Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Name" 
													   class="form-control margin-bottom b_input" name="company_name"
													   id="company_name" value="<?php echo $franchise['company_name'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_type"><?php echo $this->lang->line('Company Type') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Type"
													   class="form-control margin-bottom b_input" name="company_type"												   
													   id="company_type" value="<?php echo $franchise['company_type'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_email"><?php echo $this->lang->line('Company Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Communication Email"
													   class="form-control margin-bottom b_input " name="company_email"												   
													   id="company_email" value="<?php echo $franchise['company_email'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_phone"><?php echo $this->lang->line('Company Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Communication Phone No"
													   class="form-control margin-bottom b_input" name="company_phone"												   
													   id="company_phone" value="<?php echo $franchise['company_phone'] ?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_email"><?php echo $this->lang->line('Director Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Registered Email"
													   class="form-control margin-bottom b_input" name="director_email"												   
													   id="director_email" value="<?php echo $franchise['director_email'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_phone"><?php echo $this->lang->line('Director Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Registered Phone No"
													   class="form-control margin-bottom b_input" name="director_phone"												   
													   id="director_phone" value="<?php echo $franchise['director_phone'] ?>">
											</div>
										</div>
									</div>
									
                            
                            <hr>
                            <h4><?php echo "Billing Details"; ?></h4>
                            <hr>
							<div class="">
							
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                 <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="phone_b"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_b"												   
												   id="phone_b" value="<?php echo $franchise['phone_b'] ?>">
                                        </div>
                                    </div>
									
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="email_b"><?php echo $this->lang->line('Email') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_b"												   
												   id="email_b" value="<?php echo $franchise['email_b'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="address_b"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_b"												   
												   id="address_b" value="<?php echo $franchise['address_b'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="state_b"><?php echo $this->lang->line('State') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_b"												   
												   id="state_b" value="<?php echo $franchise['state_b'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="city_b"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_b"												   
												   id="city_b" value="<?php echo $franchise['city_b'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pincode_b"><?php echo $this->lang->line('Pin Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_b"												   
												   id="pincode_b" value="<?php echo $franchise['pincode_b'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row"  style="display:none;">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_b"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_b"												   
												   id="postbox_b" value="<?php echo $franchise['postbox_b'] ?>">
                                        </div>
                                    </div>

                                    
                                </div>
                               
                            </div>
                            </div>
                            
							</div>
                            
							
                            <hr>
							<h4><?php echo "Registered Shop Address"; ?></h4>
                            <hr>
							<div class="">
							
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                 <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_s"												   
												   id="phone_s" value="<?php echo $franchise['phone_s'] ?>">
                                        </div>
                                    </div>
									
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="email_s"><?php echo $this->lang->line('Email') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_s"												   
												   id="email_s" value="<?php echo $franchise['email_s'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="address_s"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_s"												   
												   id="address_s" value="<?php echo $franchise['address_s'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="state_s"><?php echo $this->lang->line('State') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_s"												   
												   id="state_s" value="<?php echo $franchise['state_s'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_s"												   
												   id="city_s" value="<?php echo $franchise['city_s'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pincode_s"><?php echo $this->lang->line('Pin Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_s"												   
												   id="pincode_s" value="<?php echo $franchise['pincode_s'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row"  style="display:none;">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_s"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_s"												   
												   id="postbox_s" value="<?php echo $franchise['postbox_s'] ?>">
                                        </div>
                                    </div>

                                    
                                </div>
                               
                            </div>
                            </div>
                            
							</div>
                                             
							
							
                            
							
                            <hr>
							<h4><?php echo "Statuatory Details"; ?></h4>
                            <hr>
							
                            <div class="">
							
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
							
							<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pan"><?php echo $this->lang->line('PAN') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PAN"
                                                   class="form-control margin-bottom b_input" name="pan"												   
												   id="pan" value="<?php echo $franchise['pan'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="tan"><?php echo $this->lang->line('TAN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="TAN"
                                                   class="form-control margin-bottom b_input" name="tan"												   
												   id="tan" value="<?php echo $franchise['tan'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="cin"><?php echo $this->lang->line('CIN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="CIN"
                                                   class="form-control margin-bottom b_input" name="cin"												   
												   id="cin" value="<?php echo $franchise['cin'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="gst"><?php echo $this->lang->line('GST/TIN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="GST/TIN"
                                                   class="form-control margin-bottom b_input" name="gst"												   
												   id="gst" value="<?php echo $franchise['gst'] ?>">
                                        </div>
                                    </div>
									
								
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pf"><?php echo $this->lang->line('PF No') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PF No"
                                                   class="form-control margin-bottom b_input" name="pf"												   
												   id="pf" value="<?php echo $franchise['pf'] ?>">
                                        </div>
                                    </div>								
                                </div>
							
							
							 </div>
                               
                            </div>
                            </div>                             
							</div>
							
							
							
							
							
                           <hr>
							<h4><?php echo "Bank Details"; ?></h4>
							<hr>
             			<div class="">
                              <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('RTGS/ IFSC Code') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('RTGS/ IFSC Code') ?>"
                                                   class="form-control margin-bottom b_input required" name="iec_code"												   
												   id="ifsc_code" value="<?php echo $franchise['ifsc_code'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="account_holder"><?php echo $this->lang->line('Account Holder') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Account Holder') ?>"
                                                   class="form-control margin-bottom b_input required" name="account_holder"												   
												   id="account_holder" value="<?php echo $franchise['account_holder'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="account_no"><?php echo $this->lang->line('Account Number') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Accounts Number "
                                                   class="form-control margin-bottom b_input required" name="account_no"												   
												   id="account_no" value="<?php echo $franchise['account_no'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="bank_name"><?php echo $this->lang->line('Bank Name') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Bank Name "
                                                   class="form-control margin-bottom b_input required" name="bank_name"												   
												   id="bank_name" value="<?php echo $franchise['bank_name'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="branch"><?php echo $this->lang->line('Branch') ?>*</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Branch "
                                                   class="form-control margin-bottom b_input required" name="branch"												   
												   id="branch" value="<?php echo $franchise['branch'] ?>">
                                        </div>
                                    </div> 
                            </div>
                            <hr>
                           
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Balance Sheet for FYI') ?></strong>
                                </div>
                                <div class="col-md-10">                                    
								<div class="col-md-12">
                                    <input type="file" id="balance_sheet_up" name="balance_sheet_up" accept="image/*"/>
											<input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['balance_sheet_up']; ?>">
                                </div>
                                </div>
                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('ITR for the FYI') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    
									<div class="col-md-12">
                                    <input type="file" name="itr_up" accept="image/*"/>
											<input type="hidden" name="itr_up_old" id="itr_up_old" value="<?php echo $franchise['itr_up']; ?>">
                                </div>
                                </div>
                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Pan Card') ?></strong>
                                </div>
                                <div class="col-md-10">
                                   
									<div class="col-md-12">
                                    <input type="file" id="pan_card_up" name="pan_card_up" accept="image/*"/ <?php if($franchise['pan_card_up'] == ''){?>required<?php }?>>
											<input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['pan_card_up']; ?>">
                                </div>
                                </div>
                            </div>
							
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('GSTN Certificate') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    
									<div class="col-md-12">
                                    <input type="file" id="gst_up" name="gst_up" accept="image/*"/>
											<input type="hidden" name="gst_up_old" id="gst_up_old" value="<?php echo $franchise['gst_up']; ?>">
                                </div>
                                </div>

                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Last Three Months Bank Statement') ?></strong>
                                </div>
                                <div class="col-md-10">
									<div class="col-md-12">
										<input type="file" name="bank_statement_up" accept="image/*"/>
											<input type="hidden" name="bank_statement_up_old" id="bank_statement_up_old" value="<?php echo $franchise['bank_statement_up']; ?>">
									</div>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Cancelled Cheque Photo') ?></strong>
                                </div>
                                <div class="col-md-10">
                                  	<div class="col-md-12">
                                    <input type="file" id="cancelled_cheque_up" name="cancelled_cheque_up" accept="image/*"required>
											<input type="hidden" name="cancelled_cheque_up_old" id="cancelled_cheque_up_old" value="<?php echo $franchise['cancelled_cheque_up']; ?>">
                                </div>
                                </div>
                            </div>
							<hr>										
							
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('ABCD') ?></strong>
                                </div>
                                <div class="col-md-10">
                                   
									<div class="col-md-12">
                                    <input type="file" id="abcd" name="abcd" accept="image/*" required />
											<input type="hidden" name="abcd_old" id="abcd_old" value="<?php echo $franchise['abcd']; ?>">
                                </div>
                                </div>

                            </div>
							<hr>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
							        <!--<a href="#" class="btn btn-primary btn-sm-8" style="margin-left: 45%;"><?php echo $this->lang->line('Submit') ?></a> -->									
									<!--<input type="submit" id="submit" class="btn btn-primary btn-sm-8" style="margin-left: 45%;"
											   value="Submit" data-loading-text="Updating...">-->
											   
									<input type="submit" id="submit-data11"
                                           class="btn btn-lg btn btn-primary btn-sm-8 margin-bottom round float-xs-right mr-2" style="margin-left: 45%;"
                                           value="<?php echo $this->lang->line('Submit') ?>"
                                           data-loading-text="Adding...">
										    <input type="hidden" value="franchise/save" id="action-url">					
											<input type="hidden" name="id" id="id" value="<?php echo $franchise[0]->id; ?>">
                                </div>
								
								
                            </div>
							</form>
							
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Email</h4>
            </div>

            <div class="modal-body">
                <form id="sendmail_form">
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
                                    for="shortnote"><?php echo $this->lang->line('Supplier Name') ?></label>
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
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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


$('#partial_active').click(function(){
	var id = $(this).val();
	$.ajax({
		type : 'POST',
		url : '<?php echo site_url('franchise/partialActivate')?>',
		data : {franchiseId : id},
		cache : false,
		success : function(result){
			/*alert(result);*/
			if(result == 1){
				swal("","Franchise partially activated successfully.","success");
			}
			else{
				swal("","Franchise partially deactivated successfully.","warning");
			}
		}
	});
});

</script>


<script>

$(document ).ready(function() {		
		$("#company_div").hide();
		$("#personal_div").hide();	
});

$('#personal_company').change(function(){
	var id = $(this).val();
	if(id==1){
		$("#company_div").hide("slow");
		$("#personal_div").show("slow");
		$('#company_div :input').removeAttr('required');		
		$('#balance_sheet_up').removeAttr('required');	
		$('#gst_up').removeAttr('required');	
		$('#tan').removeAttr('required');	
		$('#gst').removeAttr('required');	
		
		$('#personal_div :input').attr('required','');
	}else if(id==2){
		$("#company_div").show("slow");
		$('#company_div :input').attr('required','');
		$('#personal_div :input').removeAttr('required');		
		$('#balance_sheet_up').attr('required','');			
		$('#gst_up').attr('required','');		
		$('#tan').attr('required','');
		$('#gst').attr('required','');
		
		$("#personal_div").hide("slow");
	}
})
</script>
