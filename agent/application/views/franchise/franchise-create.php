
<article class="content">
  <div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
	<?php //print_r($franchise);?>
    <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url(); ?>franchise/save" enctype="multipart/form-data">
      <div class="row">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                       aria-controls="tab1" href="#tab1" role="tab"
                                       aria-selected="false"><?php echo 'General Details'; ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                       href="#tab4" role="tab"
                                       aria-selected="true"><?php echo 'Upload'; ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#tab2" role="tab"
                                       aria-selected="false"><?php echo 'Shipping & Billing'; ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false"><?php echo 'Statutory'; ?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
                                       href="#tab5" role="tab"
                                       aria-selected="false"><?php echo 'Bank Details'; ?></a> </li>
        </ul>
        <div class="col-md-12 tab-content" style="margin-top:10px;">
          <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
            <div class="form-group row mt-1">
              <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo $this->lang->line('Website') ?></label>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="1" name="website_id" id="zobox" <?php if($franchise['website_id']==1 || $franchise['website_id']==0){ ?> checked <?php } ?>>
                  ZoBox</label>
                </div>
              </div>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="2" name="website_id" id="zoloot" <?php if($franchise['website_id']==2){ ?> checked <?php } ?>>
                  ZoLoot</label>
                </div>
              </div>
            </div>
            <div class="form-group row mt-1">
              <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo 'Franchise Type'; ?></label>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="2" name="personal_company" id="company" <?php if($franchise['personal_company']==2 || $franchise['personal_company']==0){ ?> checked <?php } ?>>
                  Company</label>
                </div>
              </div>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="1" name="personal_company" id="personal" <?php if($franchise['personal_company']==1){ ?> checked <?php } ?>>
                  Individual</label>
                </div>
              </div>
            </div>
            <div class="form-group row mt-1">
              <label class="col-sm-2 col-form-label"
                                               for="company_name"><?php echo 'Franchise Module'; ?></label>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="1" name="module" <?php if($franchise['module']==1 || $franchise['module']==0){ ?> checked <?php } ?>>
                  ENTERPRISE</label>
                </div>
              </div>
              <div class="col-sm-3 col-lg-2">
                <div class="radio">
                  <label>
                  <input type="radio" value="2" name="module" <?php if($franchise['module']==2){ ?> checked <?php } ?>>
                  PROFESSIONAL</label>
                </div>
              </div>
              <div class="col-sm-3 col-lg-2" id="standarddiv">
                <div class="radio">
                  <label>
                  <input type="radio" value="3" name="module" <?php if($franchise['module']==3){ ?> checked <?php } ?>>
                  STANDARD</label>
                </div>
              </div>
            </div>
            <div id="company_div">
              <div class="form-group row mt-1">
                <label class="col-sm-2 col-form-label"
												   for="company_name"><?php echo 'Company Name'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Company Name') ?>" 
													   class="form-control margin-bottom b_input required" name="company_name"
													   id="company_name" value="<?php echo $franchise['company_name'] ?>" >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="company_type"><?php echo 'Company Type'; ?></label>
                <div class="col-sm-8">
                  <?php /*?>value="<?php echo $franchise['company_type'] ?>"<?php */?>
                  <select class="form-control margin-bottom b_input" name="company_type" id="company_type">
                    <option value="Public Limited Company">Public Limited Company</option>
                    <option value="Private Limited Company">Private Limited Company</option>
                    <option value="Joint-Venture Company">Joint-Venture Company</option>
                    <option value="Partnership Firm">Partnership Firm</option>
                    <option value="One Person Company">One Person Company</option>
                    <option value="Sole Proprietorship">Sole Proprietorship</option>
                    <option value="Branch Office">Branch Office</option>
                    <option value="Non-Government OrganiZation">Non-Government Organization</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="company_email"><?php echo 'Communication Email'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Company Email') ?>"
													   class="form-control margin-bottom b_input" name="company_email"												   
													   id="company_email" value="<?php echo $franchise['company_email'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="company_phone"><?php echo 'Communication Phone No'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Company Phone No') ?>"
													   class="form-control margin-bottom b_input" name="company_phone"												   
													   id="company_phone" value="<?php echo $franchise['company_phone'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="director_name"><?php echo 'Director Name'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Director Name') ?>"
													   class="form-control margin-bottom b_input" name="director_name"												   
													   id="director_name" value="<?php echo $franchise['director_name'] ?>">
                </div>
              </div>
            </div>
            <div id="personal_div">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="franchise_name"><?php echo 'Franchise Name'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Franchiser Name') ?>"
													   class="form-control margin-bottom b_input" name="franchise_name"												   
													   id="franchise_name" value="<?php echo $franchise['franchise_name'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="franchise_email"><?php echo 'Communication Email'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Franchiser Email') ?>"
													   class="form-control margin-bottom b_input" name="franchise_email"												   
													   id="franchise_email" value="<?php echo $franchise['franchise_email'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label"
												   for="franchise_phone"><?php echo 'Communication Phone No'; ?></label>
                <div class="col-sm-8">
                  <input type="text" placeholder="<?php echo $this->lang->line('Franchiser Phone No') ?>"
													   class="form-control margin-bottom b_input" name="franchise_phone"												   
													   id="franchise_phone" value="<?php echo $franchise['franchise_phone'] ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
											   for="director_email"><?php echo 'Registered Email'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="<?php echo $this->lang->line('Director Email') ?>"
												   class="form-control margin-bottom b_input" name="director_email"												   
												   id="director_email" value="<?php echo $franchise['director_email'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
											   for="director_phone"><?php echo 'Registered Phone No'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="<?php echo $this->lang->line('Director Phone No') ?>"
												   class="form-control margin-bottom b_input" name="director_phone"												   
												   id="director_phone" value="<?php echo $franchise['director_phone'] ?>">
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
            <h5><strong><?php echo 'Shop Address'; ?></strong></h5>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo 'Phone'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_s"												   
												   id="phone_s" value="<?php echo $franchise['phone_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="email_s"><?php echo 'Email'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_s"												   
												   id="email_s" value="<?php echo $franchise['email_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="address_s"><?php echo 'Address'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_s"												   
												   id="address_s" value="<?php echo $franchise['address_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="state_s"><?php echo 'State'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_s"												   
												   id="state_s" value="<?php echo $franchise['state_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo 'City'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_s"												   
												   id="city_s" value="<?php echo $franchise['city_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="pincode_s"><?php echo 'Pin Code'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_s"												   
												   id="pincode_s" value="<?php echo $franchise['pincode_s'] ?>">
              </div>
            </div>
            <div class="form-group row" style="display:none;">
              <label class="col-sm-2 col-form-label"
                                               for="postbox_s"><?php echo 'Pincode';?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_s"												   
												   id="postbox_ss" value="<?php echo $franchise['postbox_s'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="input-group mt-1">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="" name="same_as_shipping"
                                                       id="same_as_shipping" value="1" <?php if($franchise['same_as_shipping']==1){ ?> checked <?php } ?>>
                  <label class="custom-control-label"
                                                       for="same_as_shipping"><?php echo 'Same as Shop Address'; ?></label>
                </div>
              </div>
              <div class="col-sm-10 text-info"> <?php echo 'Please leave Billing Address blank if you do not want to print it on the invoice.'; ?> </div>
            </div>
            <h5><strong><?php echo 'Billing'; ?></strong></h5>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="phone_b"><?php echo 'Phone'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom b_input" name="phone_b"												   
												   id="phone_b" value="<?php echo $franchise['phone_b'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="email_b"><?php echo 'Email'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom b_input" name="email_b"												   
												   id="email_b" value="<?php echo $franchise['email_b'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="address_b"><?php echo 'Address'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Address"
                                                   class="form-control margin-bottom b_input" name="address_b"												   
												   id="address_b" value="<?php echo $franchise['address_b'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="state_b"><?php echo 'State'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="State"
                                                   class="form-control margin-bottom b_input" name="state_b"												   
												   id="state_b" value="<?php echo $franchise['state_b'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="city_b"><?php echo 'City'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="City"
                                                   class="form-control margin-bottom b_input" name="city_b"												   
												   id="city_b" value="<?php echo $franchise['city_b'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="pincode_b"><?php echo 'Pin Code'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Pin Code"
                                                   class="form-control margin-bottom b_input" name="pincode_b"												   
												   id="pincode_b" value="<?php echo $franchise['pincode_b'] ?>">
              </div>
            </div>
            <div class="form-group row" style="display:none;">
              <label class="col-sm-2 col-form-label"
                                               for="postbox_b"><?php echo 'Pincode'; ?></label>
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
                                               for="pan"><?php echo 'PAN'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="PAN"
                                                   class="form-control margin-bottom b_input" name="pan"												   
												   id="pan" value="<?php echo $franchise['pan'] ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="tan"><?php echo 'TAN'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="TAN"
                                                   class="form-control margin-bottom b_input" name="tan"												   
												   id="tan" value="<?php echo $franchise['tan'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="cin"><?php echo 'CIN'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="CIN"
                                                   class="form-control margin-bottom b_input" name="cin"												   
												   id="cin" value="<?php echo $franchise['cin'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="gst"><?php echo 'GST'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="GST/TIN"
                                                   class="form-control margin-bottom b_input" name="gst"												   
												   id="gst" value="<?php echo $franchise['gst'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="establishment_code"><?php echo 'Establishment Code'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Establishment Code"
                                                   class="form-control margin-bottom b_input" name="establishment_code"												   
												   id="establishment_code" value="<?php echo $franchise['establishment_code'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="esi"><?php echo 'ESI No'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="ESI No"
                                                   class="form-control margin-bottom b_input" name="esi"												   
												   id="esi" value="<?php echo $franchise['esi'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="pf"><?php echo 'PF No'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="PF No"
                                                   class="form-control margin-bottom b_input" name="pf"												   
												   id="pf" value="<?php echo $franchise['pf'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="iec_code"><?php echo 'IEC Code' ?></label>
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
									  <img src="<?php echo base_url(); ?>public/uploads/courier/<?php //echo $logo;?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#logo_old').val('');jQuery('#logo_old_data').hide()">remove</a></span>
									  <?php }?>				  
									</div>-->
            <?php 
									 	
										  $extension1 =  explode('.',$franchise['balance_sheet_up']);										  
										  $extension2 =  explode('.',$franchise['itr_up']);										  
										  $extension3 =  explode('.',$franchise['pan_card_up']);										  
										  $extension4 =  explode('.',$franchise['gst_up']);										  
										  $extension5 =  explode('.',$franchise['bank_statement_up']);										  
										  $extension6 =  explode('.',$franchise['cancelled_cheque_up']);										  
									 										  
										  $ext1 = $extension1[1];
										  $ext2 = $extension2[1];
										  $ext3 = $extension3[1];
										  $ext4 = $extension4[1];
										  $ext5 = $extension5[1];
										  $ext6 = $extension6[1];
										  ?>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label"><strong>Upload Format</strong> : jpg|png|jpeg|gif|pdf|docx|docs|txt|xls</label>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="balance_sheet_up"><?php echo 'Balance Sheet for FYI'; ?> </label>
              <div class="col-sm-4">
                <input type="file" id="balance_sheet_up" name="balance_sheet_up" accept="image/*"/>
                <input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['balance_sheet_up']; ?>">
              </div>
              <?php if($franchise['balance_sheet_up']){?>
              <?php if($ext1=='jpg' || $ext1=='png' || $ext1=='jpeg' || $ext1=='gif'){ ?>
              <span id="balance_sheet_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['balance_sheet_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#balance_sheet_up_old').val('');jQuery('#balance_sheet_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['balance_sheet_up'];?>"><?php echo $franchise['balance_sheet_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="itr_up"><?php echo 'ITR for the FYI'; ?> </label>
              <div class="col-sm-4">
                <input type="file" name="itr_up" accept="image/*"/>
                <input type="hidden" name="itr_up_old" id="itr_up_old" value="<?php echo $franchise['itr_up']; ?>">
              </div>
              <?php if($franchise['itr_up']){?>
              <?php if($ext2=='jpg' || $ext2=='png' || $ext2=='jpeg' || $ext2=='gif'){ ?>
              <span id="balance_sheet_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['itr_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#itr_up_old').val('');jQuery('#itr_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['itr_up'];?>"><?php echo $franchise['itr_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="pan_card_up"><?php echo 'Pan Card'; ?> </label>
              <div class="col-sm-6">
                <input type="file" id="pan_card_up" name="pan_card_up" accept="image/*"/ <?php if($franchise['pan_card_up'] == ''){?>required<?php }?>>
                <input type="hidden" name="balance_sheet_up_old" id="balance_sheet_up_old" value="<?php echo $franchise['pan_card_up']; ?>">
              </div>
              <?php if($franchise['pan_card_up']){?>
              <?php if($ext3=='jpg' || $ext3=='png' || $ext3=='jpeg' || $ext3=='gif'){ ?>
              <span id="pan_card_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['pan_card_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#pan_card_up_old').val('');jQuery('#pan_card_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['pan_card_up'];?>"><?php echo $franchise['pan_card_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="gst_up"><?php echo 'GSTN Certificate'; ?> </label>
              <div class="col-sm-6">
                <input type="file" id="gst_up" name="gst_up" accept="image/*"/>
                <input type="hidden" name="gst_up_old" id="gst_up_old" value="<?php echo $franchise['gst_up']; ?>">
              </div>
              <?php if($franchise['gst_up']){?>
              <?php if($ext4=='jpg' || $ext4=='png' || $ext4=='jpeg' || $ext4=='gif'){ ?>
              <span id="gst_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['gst_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#gst_up_old').val('');jQuery('#gst_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['gst_up'];?>"><?php echo $franchise['gst_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="bank_statement_up"><?php echo 'Last Three Months Bank Statement'; ?> </label>
              <div class="col-sm-6">
                <input type="file" name="bank_statement_up" accept="image/*"/>
                <input type="hidden" name="bank_statement_up_old" id="bank_statement_up_old" value="<?php echo $franchise['bank_statement_up']; ?>">
              </div>
              <?php if($franchise['bank_statement_up']){?>
              <?php if($ext5=='jpg' || $ext5=='png' || $ext5=='jpeg' || $ext5=='gif'){ ?>
              <span id="bank_statement_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['bank_statement_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#bank_statement_up_old').val('');jQuery('#bank_statement_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['bank_statement_up'];?>"><?php echo $franchise['bank_statement_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="cancelled_cheque_up"><?php echo 'Cancelled Cheque Photo'; ?> </label>
              <div class="col-sm-6">
                <input type="file" id="cancelled_cheque_up" name="cancelled_cheque_up" accept="image/*"/ <?php if($franchise['cancelled_cheque_up'] == ''){?>required<?php }?>>
                <input type="hidden" name="cancelled_cheque_up_old" id="cancelled_cheque_up_old" value="<?php echo $franchise['cancelled_cheque_up']; ?>">
              </div>
              <?php if($franchise['cancelled_cheque_up']){?>
              <?php if($ext6=='jpg' || $ext6=='png' || $ext6=='jpeg' || $ext6=='gif'){ ?>
              <span id="cancelled_cheque_up_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['cancelled_cheque_up'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#cancelled_cheque_up_old').val('');jQuery('#cancelled_cheque_up_old_data').hide()"></a></span>
              <?php }else{ ?>
              <div class="col-sm-3"> <br>
                <a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['cancelled_cheque_up'];?>"><?php echo $franchise['cancelled_cheque_up'];?></a> </div>
              <?php } ?>
              <?php }?>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label"
											   for="cancelled_cheque_up"><?php echo 'Payment Reference'; ?> </label>
              <div class="col-sm-6">
                <input type="file" id="abcd" name="abcd" accept="image/*" <?php if($franchise['abcd'] == ''){?>required<?php }?> />
                <input type="hidden" name="abcd_old" id="abcd_old" value="<?php echo $franchise['abcd']; ?>">
              </div>
              <?php if($franchise['abcd']){?>
              <span id="abcd_old_data"><br>
              <br>
              <img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise['abcd'];?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onClick="jQuery('#abcd_old').val('');jQuery('#abcd_old').hide()"></a></span>
              <?php }?>
            </div>
          </div>
          <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="rtgs_ifsc_code"><?php echo 'RTGS/ IFSC Code'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="RTGS/ IFSC Code" class="form-control margin-bottom b_input" name="rtgs_ifsc_code" id="rtgs_ifsc_code" value="<?php echo $franchise['rtgs_ifsc_code'] ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="rtgs_ifsc_code"><?php echo 'Account Holder Name'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Account Holder Name"  class="form-control margin-bottom b_input" name="account_holder" id="account_holder" value="<?php echo $franchise['account_holder'] ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="account_no"><?php echo 'Account Number'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Accounts Number" class="form-control margin-bottom b_input" name="account_no" id="account_no" value="<?php echo $franchise['account_no'] ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="bank_name"><?php echo 'Bank Name'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Bank Name" class="form-control margin-bottom b_input" name="bank_name" id="bank_name" value="<?php echo $franchise['bank_name'] ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"
                                               for="branch"><?php echo 'Branch'; ?></label>
              <div class="col-sm-8">
                <input type="text" placeholder="Branch" class="form-control margin-bottom b_input" name="branch" id="branch" value="<?php echo $franchise['branch'] ?>" required>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-4">
          <input type="submit" id="submit-dataaaa" class="btn btn-success margin-bottom"
                           value="Update" data-loading-text="Updating...">
          <input type="hidden" value="user/update_address" id="action-url">
		  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        </div>
      </div>
    </form>
  </div>
</article>
<script type="text/javascript">
<?php if($franchise['personal_company']==2 || $franchise['personal_company']==0){ ?>
	$('#company_div :input').attr('required','');
	$('#personal_div :input').removeAttr('required');
	
	<?php if($franchise['balance_sheet_up']=='') {?>
	$('#balance_sheet_up').attr('required','');	
	<?php } ?>
	<?php if($franchise['gst_up']=='') {?>
	$('#gst_up').attr('required','');	
	<?php } ?>	
	$('#tan').attr('required','');
	$('#gst').attr('required','');
	
<?php }elseif($franchise['personal_company']==1){ ?>
    $('#company_div :input').removeAttr('required');
	$('#personal_div :input').attr('required','');
	
	$('#balance_sheet_up').removeAttr('required');	
	$('#gst_up').removeAttr('required');	
	$('#tan').removeAttr('required');	
	$('#gst').removeAttr('required');	
	
<?php } ?>

$(document ).ready(function() {	
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
	$('#company_div :input').attr('required','');
	$('#personal_div :input').removeAttr('required');
	
	<?php if($franchise['balance_sheet_up']=='') {?>
	$('#balance_sheet_up').attr('required','');	
	<?php } ?>
	<?php if($franchise['gst_up']=='') {?>
	$('#gst_up').attr('required','');	
	<?php } ?>
	$('#tan').attr('required','');
	$('#gst').attr('required','');
	
	$("#personal_div").hide("slow");
});
$("#personal").click(function () {
	$("#company_div").hide("slow");
	$("#personal_div").show("slow");
	$('#company_div :input').removeAttr('required');
	
	$('#balance_sheet_up').removeAttr('required');	
	$('#gst_up').removeAttr('required');	
	$('#tan').removeAttr('required');	
	$('#gst').removeAttr('required');	
	
	$('#personal_div :input').attr('required','');
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



$('#zoloot').click(function(){	
	$('#standarddiv').hide();
});

$('#zobox').click(function(){
	$('#standarddiv').show();
});


<?php if($franchise['website']==1 || $franchise['website'] == ''){ ?>
	$('#standarddiv').show();
<?php }else{ ?>
	$('#standarddiv').hide();
<?php } ?>
</script>