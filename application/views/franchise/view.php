<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $details['name'] ?></h4>
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
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="ibox-content mt-2">
                                <img alt="image" id="dpic" class="img-responsive"
                                     src="<?php echo base_url('userfiles/customers/') . $franchise['picture'] ?>">
									 <?php //echo "<pre>";print_r($details);echo "</pre>";?>
                            </div>
							<div class="ibox-content mt-2">
                                Partial Active : <input type="checkbox" id="partial_active" value="<?php echo $franchise['id'];?>" name="partial_active" <?php if($franchise['partial_active'] == 1){?>checked="checked"<?php } ?> />
                            </div>
                            <hr>
                            
                            

                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="">
                            <h4><?php echo $this->lang->line('General Details') ?></h4>
                                  
                            <form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
								
									<div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Company | Personal') ?></label>

                                        <div class="col-sm-3">
                                            <div class="radio">
											  <label><input type="radio" value="2" name="personal_company" id="company" <?php if($franchise['personal_company']==2){ ?> checked <?php }else{?> disabled="disabled"<?php } ?>> Company</label>
											</div>																						
                                        </div>
										
										<div class="col-sm-3">
											<div class="radio">
											  <label><input type="radio" value="1" name="personal_company" id="personal" <?php if($franchise['personal_company']==1){ ?> checked <?php } else{?> disabled="disabled"<?php } ?>> Individual</label>
											</div>
										</div>
										
                                    </div>
									
									<div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Company | Personal') ?></label>

                                        <div class="col-sm-3">
                                            <div class="radio">
											  <label><input type="radio" value="1" name="module" <?php if($franchise['module']==1){ ?> checked <?php }else{?>disabled="disabled" <?php }?>> ENTERPRISE</label>
											</div>																						
                                        </div>
										
										<div class="col-sm-3">
											<div class="radio">
											  <label><input type="radio" value="2" name="module" <?php if($franchise['module']==2){ ?> checked <?php } else{?> disabled="disabled"<?php }?>> PROFESSIONAL</label>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="radio">
											  <label><input type="radio" value="3" name="module" <?php if($franchise['module']==3){ ?> checked <?php } else{?>disabled="disabled" <?php } ?>> STANDARD</label>
											</div>
										</div>
										
                                    </div>
									<div id="personal_div" <?php if($franchise['personal_company']==2){?> style="display:none;"<?php }?>>
									
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_name"><?php echo $this->lang->line('Franchiser Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Franchiser Name"
													   class="form-control margin-bottom b_input" name="franchise_name"												   
													   id="franchise_name" value="<?php echo $franchise['franchise_name'] ?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_email"><?php echo $this->lang->line('Franchiser Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Franchiser Email"
													   class="form-control margin-bottom b_input" name="franchise_email"												   
													   id="franchise_email" value="<?php echo $franchise['franchise_email'] ?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="franchise_phone"><?php echo $this->lang->line('Franchiser Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Franchiser Phone No"
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
													   class="form-control margin-bottom b_input required" name="company_name"
													   id="company_name" value="<?php echo $franchise['company_name'] ?>" readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_type"><?php echo $this->lang->line('Company Type') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Type"
													   class="form-control margin-bottom b_input" name="company_type"												   
													   id="company_type" value="<?php echo $franchise['company_type'] ?>" readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_email"><?php echo $this->lang->line('Company Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Email"
													   class="form-control margin-bottom b_input" name="company_email"												   
													   id="company_email" value="<?php echo $franchise['company_email'] ?>" readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_phone"><?php echo $this->lang->line('Company Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Phone No"
													   class="form-control margin-bottom b_input" name="company_phone"												   
													   id="company_phone" value="<?php echo $franchise['company_phone'] ?>" readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_name"><?php echo $this->lang->line('Director Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Name"
													   class="form-control margin-bottom b_input" name="director_name"												   
													   id="director_name" value="<?php echo $franchise['director_name'] ?>"  readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_email"><?php echo $this->lang->line('Director Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Email"
													   class="form-control margin-bottom b_input" name="director_email"												   
													   id="director_email" value="<?php echo $franchise['director_email'] ?>"  readonly="">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_phone"><?php echo $this->lang->line('Director Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Phone No"
													   class="form-control margin-bottom b_input" name="director_phone"												   
													   id="director_phone" value="<?php echo $franchise['director_phone'] ?>"  readonly="">
											</div>
										</div>
									</div>
									</form>
                            
                            <hr>
                            <h4><?php echo " Billing Details"; ?></h4>
                            <hr>
							<div class="">
							<form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                 <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="phone_b"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_b"												   
												   id="phone_b" value="<?php echo $franchise['phone_b'] ?>"  readonly="">
                                        </div>
                                    </div>
									
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="email_b"><?php echo $this->lang->line('Email') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_b"												   
												   id="email_b" value="<?php echo $franchise['email_b'] ?>"  readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="address_b"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_b"												   
												   id="address_b" value="<?php echo $franchise['address_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="state_b"><?php echo $this->lang->line('State') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_b"												   
												   id="state_b" value="<?php echo $franchise['state_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="city_b"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_b"												   
												   id="city_b" value="<?php echo $franchise['city_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pincode_b"><?php echo $this->lang->line('Pin Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_b"												   
												   id="pincode_b" value="<?php echo $franchise['pincode_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row"  style="display:none;">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_b"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_b"												   
												   id="postbox_b" value="<?php echo $franchise['postbox_b'] ?>" readonly="">
                                        </div>
                                    </div>

                                    
                                </div>
                               
                            </div>
                            </div>
                            </form> 
							</div>
                            
							
                            <hr>
							<h4><?php echo "Shipping Details"; ?></h4>
                            <hr>
							<div class="">
							<form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                 <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="phone_b"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_b"												   
												   id="phone_b" value="<?php echo $franchise['phone_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="email_b"><?php echo $this->lang->line('Email') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_b"												   
												   id="email_b" value="<?php echo $franchise['email_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="address_b"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_b"												   
												   id="address_b" value="<?php echo $franchise['address_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="state_b"><?php echo $this->lang->line('State') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_b"												   
												   id="state_b" value="<?php echo $franchise['state_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="city_b"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_b"												   
												   id="city_b" value="<?php echo $franchise['city_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pincode_b"><?php echo $this->lang->line('Pin Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_b"												   
												   id="pincode_b" value="<?php echo $franchise['pincode_b'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row"  style="display:none;">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_b"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_b"												   
												   id="postbox_b" value="<?php echo $franchise['postbox_b'] ?>" readonly="">
                                        </div>
                                    </div>

                                    
                                </div>
                               
                            </div>
                            </div>
                            </form> 
							</div>
                                             
							
							
                            
							
                            <hr>
							<h4><?php echo "Statuatory Details"; ?></h4>
                            <hr>
							
                            <div class="">
							<form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
							
							<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pan"><?php echo $this->lang->line('PAN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PAN"
                                                   class="form-control margin-bottom b_input" name="pan"												   
												   id="pan" value="<?php echo $franchise['pan'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="tan"><?php echo $this->lang->line('TAN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="TAN"
                                                   class="form-control margin-bottom b_input" name="tan"												   
												   id="tan" value="<?php echo $franchise['tan'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="cin"><?php echo $this->lang->line('CIN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="CIN"
                                                   class="form-control margin-bottom b_input" name="cin"												   
												   id="cin" value="<?php echo $franchise['cin'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="gst"><?php echo $this->lang->line('GST/TIN') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="GST/TIN"
                                                   class="form-control margin-bottom b_input" name="gst"												   
												   id="gst" value="<?php echo $franchise['gst'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="establishment_code"><?php echo $this->lang->line('Establishment Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Establishment Code"
                                                   class="form-control margin-bottom b_input" name="establishment_code"												   
												   id="establishment_code" value="<?php echo $franchise['establishment_code'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="esi"><?php echo $this->lang->line('ESI No') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="ESI No"
                                                   class="form-control margin-bottom b_input" name="esi"												   
												   id="esi" value="<?php echo $franchise['esi'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pf"><?php echo $this->lang->line('PF No') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PF No"
                                                   class="form-control margin-bottom b_input" name="pf"												   
												   id="pf" value="<?php echo $franchise['pf'] ?>" readonly="">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('IEC Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="IEC Code"
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="iec_code" value="<?php echo $franchise['iec_code'] ?>" readonly="">
                                        </div>
                                    </div>
                                </div>
							
							
							 </div>
                               
                            </div>
                            </div>
                            </form> 
							</div>
							
							
							
							
							
                           <hr>
							<h4><?php echo "Bank Details"; ?></h4>
							<hr>
             			<div class="">
                              <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('RTGS/ IFSC Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('RTGS/ IFSC Code') ?>"
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="ifsc_code" value="<?php echo $franchise['ifsc_code'] ?>" readonly="">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('Account Holder') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Account Holder') ?>"
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="ifsc_code" value="<?php echo $franchise['account_holder'] ?>" readonly="">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('Account Number') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Accounts Number "
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="account_no" value="<?php echo $franchise['account_no'] ?>" readonly="">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('Bank Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Bank Name "
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="bank_name" value="<?php echo $franchise['bank_name'] ?>" readonly="">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('Branch') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Branch "
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="branch_name" value="<?php echo $franchise['branch_name'] ?>" readonly="">
                                        </div>
                                    </div>
                                

                            </div>
                            <hr>
							
							
							<!--<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php //echo $this->lang->line('Accounts Number') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php //echo $details['account_no'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php //echo $this->lang->line('Bank Name') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php //echo $details['bank_name'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php //echo $this->lang->line('Branch') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php //echo $details['branch_name'] ?>
                                </div>

                            </div>
							-->
                           
					<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Balance Sheet for FYI') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['balance_sheet_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['balance_sheet_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('ITR for the FYI') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['itr_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['itr_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Pan Card') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['pan_card_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['pan_card_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('GSTN Certificate') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['gst_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['gst_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Last Three Months Bank Statement') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['bank_statement_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['bank_statement_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Cancelled Cheque Photo') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['cancelled_cheque_up'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['cancelled_cheque_up'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<hr>
							
							
							
							
							
							
							
							
							
							<hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('ABCD') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <img src="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['abcd'];?>" class="img-responsive" style="width:30%;" />
									<div class="col-md-12">
                                    <a href="<?php echo base_url().'userfiles/documents/franchise/'.$franchise['abcd'];?>"
                                       class="btn btn-success btn-sm-8"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('Download') ?>
                                    </a>
                                </div>
                                </div>

                            </div>
							<hr>
							
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
