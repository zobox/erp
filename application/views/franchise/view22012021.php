<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add New Franchise') ?></h4>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            
                <div class="card" id="viewfranchise">

                    <div class="card-content">
                        <div class="card-body">

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                       aria-controls="tab1" href="#tab1" role="tab"
                                       aria-selected="true"><?php echo $this->lang->line('General Details') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#tab2" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Shipping & Billing') ?></a>
                                </li>
								
								<li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Statutory') ?></a>
                                </li>
								
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                       href="#tab4" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Upload') ?></a>
                                </li>
								
								<li class="nav-item">
                                    <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
                                       href="#tab5" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Bank Details') ?></a>
                                </li>                    

                            </ul>
							
							
							<form method="post" id="franchisefrm" enctype="multipart/form-data" name="franchisefrm"  action="<?php echo base_url(); ?>franchise/save">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
								
									<div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Company | Personal') ?></label>

                                        <div class="col-sm-1">
                                            <div class="radio">
											  <label><input type="radio" value="2" name="personal_company" id="company" <?php if($franchise['personal_company']==2){ ?> checked <?php } ?>> Company</label>
											</div>																						
                                        </div>
										
										<div class="col-sm-1">
											<div class="radio">
											  <label><input type="radio" value="1" name="personal_company" id="personal" <?php if($franchise['personal_company']==1){ ?> checked <?php } ?>> Personal</label>
											</div>
										</div>
										
                                    </div>
									
									<div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Company | Personal') ?></label>

                                        <div class="col-sm-1">
                                            <div class="radio">
											  <label><input type="radio" value="1" name="module" <?php if($franchise['module']==1){ ?> checked <?php } ?>> ENTERPRISE</label>
											</div>																						
                                        </div>
										
										<div class="col-sm-1">
											<div class="radio">
											  <label><input type="radio" value="2" name="module" <?php if($franchise['module']==2){ ?> checked <?php } ?>> PROFESSIONAL</label>
											</div>
										</div>
										
										<div class="col-sm-1">
											<div class="radio">
											  <label><input type="radio" value="3" name="module" <?php if($franchise['module']==3){ ?> checked <?php } ?>> STANDARD</label>
											</div>
										</div>
										
                                    </div>
									
									
									<div id="company_div">
										<div class="form-group row mt-1">

											<label class="col-sm-2 col-form-label"
												   for="company_name"><?php echo $this->lang->line('Company Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Name" 
													   class="form-control margin-bottom b_input required" name="company_name"
													   id="company_name" value="<?php echo $franchise['company_name'] ?>" >
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_type"><?php echo $this->lang->line('Company Type') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Type"
													   class="form-control margin-bottom b_input" name="company_type"												   
													   id="company_type" value="<?php echo $franchise['company_type'] ?>" >
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_email"><?php echo $this->lang->line('Company Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Email"
													   class="form-control margin-bottom b_input" name="company_email"												   
													   id="company_email" value="<?php echo $franchise['company_email'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="company_phone"><?php echo $this->lang->line('Company Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Company Phone No"
													   class="form-control margin-bottom b_input" name="company_phone"												   
													   id="company_phone" value="<?php echo $franchise['company_phone'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_name"><?php echo $this->lang->line('Director Name') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Name"
													   class="form-control margin-bottom b_input" name="director_name"												   
													   id="director_name" value="<?php echo $franchise['director_name'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_email"><?php echo $this->lang->line('Director Email') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Email"
													   class="form-control margin-bottom b_input" name="director_email"												   
													   id="director_email" value="<?php echo $franchise['director_email'] ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="director_phone"><?php echo $this->lang->line('Director Phone No') ?></label>

											<div class="col-sm-8">
												<input type="text" placeholder="Director Phone No"
													   class="form-control margin-bottom b_input" name="director_phone"												   
													   id="director_phone" value="<?php echo $franchise['director_phone'] ?>">
											</div>
										</div>
									</div>
									
									<div id="personal_div">
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
                                </div>
								
								
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="form-group row">

                                        <div class="input-group mt-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="same_as_shipping"
                                                       id="same_as_shipping" value="1" <?php if($franchise['same_as_shipping']==1){ ?> checked <?php } ?>>
                                                <label class="custom-control-label"
                                                       for="same_as_shipping"><?php echo $this->lang->line('Same As Shipping') ?></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-10 text-info">
                                            <?php echo $this->lang->line("leave Shipping Address") ?>
                                        </div>
                                    </div>
									
									<h5><strong><?php echo $this->lang->line('Shipping') ?></strong></h5>
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
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_s"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_s"												   
												   id="postbox_ss" value="<?php echo $franchise['postbox_s'] ?>">
                                        </div>
                                    </div>
									
									
									<h5><strong><?php echo $this->lang->line('Billing') ?></strong></h5>
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
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="postbox_b"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_b"												   
												   id="postbox_b" value="<?php echo $franchise['postbox_b'] ?>">
                                        </div>
                                    </div>

                                    
                                </div>
								
								
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pan"><?php echo $this->lang->line('PAN') ?></label>

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
                                               for="establishment_code"><?php echo $this->lang->line('Establishment Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Establishment Code"
                                                   class="form-control margin-bottom b_input" name="establishment_code"												   
												   id="establishment_code" value="<?php echo $franchise['establishment_code'] ?>">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="esi"><?php echo $this->lang->line('ESI No') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="ESI No"
                                                   class="form-control margin-bottom b_input" name="esi"												   
												   id="esi" value="<?php echo $franchise['esi'] ?>">
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
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo $this->lang->line('IEC Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="IEC Code"
                                                   class="form-control margin-bottom b_input" name="iec_code"												   
												   id="iec_code" value="<?php echo $franchise['iec_code'] ?>">
                                        </div>
                                    </div>
                                </div>
								
								
								
									<div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
									<!--<div class="form-group col-md-4">
									  <label for="city">Logo</label>
									  <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
									  <input type="hidden" name="logo_old" id="logo_old" value="<?php echo $logo; ?>">
									 
									 <?php if($logo){?>
									  <span id="logo_old_data"><br>
									  <br>
									  <img src="<?php echo base_url(); ?>public/uploads/courier/<?php echo $logo;?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#logo_old').val('');jQuery('#logo_old_data').hide()">remove</a></span>
									  <?php }?>				  
									</div>-->
								
								
                                    <div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="balance_sheet_up"><?php echo $this->lang->line('Balance Sheet for FYI') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="balance_sheet_up" accept="image/*"/>
											<input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['balance_sheet_up']; ?>">
										</div>
										<?php if($franchise['balance_sheet_up']){?>
										  <span id="balance_sheet_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['balance_sheet_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#balance_sheet_up_old').val('');jQuery('#balance_sheet_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="itr_up"><?php echo $this->lang->line('ITR for the FYI') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="itr_up" accept="image/*"/>
											<input type="hidden" name="itr_up_old" id="itr_up_old" value="<?php echo $franchise['itr_up']; ?>">
										</div>
										<?php if($franchise['itr_up']){?>
										  <span id="balance_sheet_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['itr_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#itr_up_old').val('');jQuery('#itr_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="pan_card_up"><?php echo $this->lang->line('Pan Card') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="pan_card_up" accept="image/*"/>
											<input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['pan_card_up']; ?>">
										</div>
										<?php if($franchise['pan_card_up']){?>
										  <span id="pan_card_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['pan_card_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#pan_card_up_old').val('');jQuery('#pan_card_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="gst_up"><?php echo $this->lang->line('GSTN Certificate') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="gst_up" accept="image/*"/>
											<input type="hidden" name="gst_up_old" id="gst_up_old" value="<?php echo $franchise['gst_up']; ?>">
										</div>
										<?php if($franchise['gst_up']){?>
										  <span id="gst_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['gst_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#gst_up_old').val('');jQuery('#gst_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="bank_statement_up"><?php echo $this->lang->line('Last Three Months Bank Statement') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="bank_statement_up" accept="image/*"/>
											<input type="hidden" name="bank_statement_up_old" id="bank_statement_up_old" value="<?php echo $franchise['bank_statement_up']; ?>">
										</div>
										<?php if($franchise['bank_statement_up']){?>
										  <span id="bank_statement_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['bank_statement_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#bank_statement_up_old').val('');jQuery('#bank_statement_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="cancelled_cheque_up"><?php echo $this->lang->line('Cancelled Cheque Photo') ?>
											(docx,docs,txt,pdf,xls)</label>

										<div class="col-sm-6">
											<input type="file" name="cancelled_cheque_up" accept="image/*"/>
											<input type="hidden" name="cancelled_cheque_up_old" id="cancelled_cheque_up_old" value="<?php echo $franchise['cancelled_cheque_up']; ?>">
										</div>
										<?php if($franchise['cancelled_cheque_up']){?>
										  <span id="cancelled_cheque_up_old_data"><br>
										  <br>
										  <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['cancelled_cheque_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#cancelled_cheque_up_old').val('');jQuery('#cancelled_cheque_up_old_data').hide()"></a></span>
										  <?php }?>	
									</div>
									
									
                                </div>
								
								
								<div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="rtgs_ifsc_code"><?php echo $this->lang->line('RTGS/ IFSC Code') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="RTGS/ IFSC Code"
                                                   class="form-control margin-bottom b_input" name="rtgs_ifsc_code"												   
												   id="rtgs_ifsc_code" value="<?php echo $franchise['rtgs_ifsc_code'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="account_no"><?php echo $this->lang->line('Accounts Number') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Accounts Number"
                                                   class="form-control margin-bottom b_input" name="account_no"												   
												   id="account_no" value="<?php echo $franchise['account_no'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="bank_name"><?php echo $this->lang->line('Bank Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Bank Name"
                                                   class="form-control margin-bottom b_input" name="bank_name"												   
												   id="bank_name" value="<?php echo $franchise['bank_name'] ?>">
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="branch"><?php echo $this->lang->line('Branch') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Branch"
                                                   class="form-control margin-bottom b_input" name="branch"												   
												   id="branch" value="<?php echo $franchise['branch'] ?>">
                                        </div>
                                    </div>
									
                                </div>
								
								
								<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
							</form>
								
                                
                                
                            </div>
                        </div>
                    </div>
                </div>                
        </div>
    </div>
</div>

<script type="text/javascript">
$(document ).ready(function() {	
	$("#viewfranchise :input").prop("disabled", true);
	<?php if($franchise['personal_company']==1){ ?>
		$("#company_div").hide("slow");
		$("#personal_div").show("slow");
	<?php }else{ ?>
		$("#company_div").show("slow");
		$("#personal_div").hide("slow");
	<?php } ?>	
});

$("#company").click(function () {
	$("#company_div").show("slow");
	$("#personal_div").hide("slow");
});
$("#personal").click(function () {
	$("#company_div").hide("slow");
	$("#personal_div").show("slow");
});




$("#same_as_shipping").click(function () {		
	var phone_s = $("#phone_s").val();
	var email_s = $("#email_s").val();
	var address_s = $("#address_s").val();
	var state_s = $("#state_s").val();
	var city_s = $("#city_s").val();
	var pincode_s = $("#pincode_s").val();
	var postbox_s = $("#postbox_ss").val();	
	
	$("#phone_b").val(phone_s);	
	$("#email_b").val(email_s);	
	$("#address_b").val(address_s);	
	$("#state_b").val(state_s);	
	$("#city_b").val(city_s);	
	$("#pincode_b").val(pincode_s);	
	$("#postbox_b").val(postbox_s);	
});


$('#phone_s').keypress(function() {	
	if ($('#same_as_shipping').attr(':checked'));{	
		$('#phone_b').val($(this).val());	
	}
});




</script>

