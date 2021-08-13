<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title ml-2"><?php echo $this->lang->line('Add New Customer') ?></h4>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
			
			<form name="Selectfranchise" method="get" id="Selectfranchise" action="<?php base_url();?>create">
			<div class="form-group row mt-4" style="margin-left: 5px; margin-bottom: -10px;">
	
				<label class="col-sm-2 col-form-label"
					   for="name"><?php echo $this->lang->line('Franchise') ?></label>
				<div class="col-sm-4">
					<select name="franchise_id" id="franchise_id" class='form-control b_input' > 
						<option value="">Select Franchise</option>
						<?php foreach($franchiselist as $key=>$franchise_data){ ?>
						 <option value="<?php echo $franchise_data->id; ?>" <?php if($search['franchise_id']==$franchise_data->id){ ?>selected="selected" <?php } ?>><?php echo $franchise_data->fname; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="col-sm-2">
					<div id="mybutton">
						<input type="submit" id="submit"
							   class="btn btn-xl btn btn-success margin-bottom round float-xs-right mr-2"
							   value="<?php echo $this->lang->line('Submit') ?>"
							   data-loading-text="Adding...">
					</div>
				</div>
			</div>
			</form>
        </div>
		
		
	<?php 
	/* echo "<pre>";
	print_r($franchise);
	echo "</pre>"; */
	
//$id
//$franchise_id
$name      	=  $franchise->fname;
$phone		=  $franchise->phone;
$address	=  $franchise->address_s;
$city		=	$franchise->city_s;
$region		=	$franchise->state_s;
//$country	
$postbox	=	$franchise->postbox_s;
$email		=	$franchise->email;
//$picture	
//$gid
$company	=	$franchise->company_name;
$taxid		=	$franchise->gst;
$name_s		=	$franchise->name;
$phone_s	=	$franchise->phone_s;
$email_s	=	$franchise->email_s;
$address_s	=	$franchise->address_s;
$city_s		=	$franchise->city_s;
$region_s	=	$franchise->state_s;
$country_s	=	$franchise->country_s;
$postbox_s	=	$franchise->postbox_s;
//$balance 
//$loc
//$docid
//$custom1
//$discount_c
//$reg_date


$extension1 =  explode('.',$franchise->balance_sheet_up);										  
$extension2 =  explode('.',$franchise->itr_up);										  
$extension3 =  explode('.',$franchise->pan_card_up);										  
$extension4 =  explode('.',$franchise->gst_up);										  
$extension5 =  explode('.',$franchise->bank_statement_up);										  
$extension6 =  explode('.',$franchise->cancelled_cheque_up);										  
$extension7 =  explode('.',$franchise->abcd);										  
								  
$ext1 = $extension1[1];
$ext2 = $extension2[1];
$ext3 = $extension3[1];
$ext4 = $extension4[1];
$ext5 = $extension5[1];
$ext6 = $extension6[1];
$ext7 = $extension7[1];
	
		?>
        <div class="card-body">
            <form method="post" id="data_form" class="form-horizontal">
                <div class="card">

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
                                       href="#tab4" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Statutory').' & '.$this->lang->line('Bank Details') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Settings') ?></a>
                                </li>
								
								<li class="nav-item">
                                    <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
                                       href="#tab5" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Documents') ?></a>
                                </li>
								
								<li class="nav-item">
                                    <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6"
                                       href="#tab6" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Set Commission') ?></a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Name') ?>"
                                                   class="form-control margin-bottom b_input required" name="name"
                                                   id="mcustomer_name" value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Company') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Company') ?>"
                                                   class="form-control margin-bottom b_input" name="company" value="<?php echo $company; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Phone') ?>"
                                                   class="form-control margin-bottom required b_input" name="phone" value="<?php echo $phone; ?>"
                                                   id="mcustomer_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Email"
                                                   class="form-control margin-bottom required b_input" name="email" value="<?php echo $email; ?>"
                                                   id="mcustomer_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Address') ?>"
                                                   class="form-control margin-bottom b_input" name="address" value="<?php echo $address; ?>"
                                                   id="mcustomer_address1">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('City') ?>"
                                                   class="form-control margin-bottom b_input" name="city" value="<?php echo $city; ?>"
                                                   id="mcustomer_city">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Region') ?>"
                                                   class="form-control margin-bottom b_input" name="region" value="<?php echo $region; ?>"
                                                   id="region">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Country') ?>"
                                                   class="form-control margin-bottom b_input" name="country" value="<?php echo $country; ?>"
                                                   id="mcustomer_country">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('PostBox') ?>"
                                                   class="form-control margin-bottom b_input" name="postbox" value="<?php echo $postbox; ?>"
                                                   id="postbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="form-group row">

                                        <div class="input-group mt-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="customer1" value="<?php echo $customer1; ?>"
                                                       id="copy_address">
                                                <label class="custom-control-label"
                                                       for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                            </div>

                                        </div>

                                        <div class="col-sm-10 text-info">
                                            <?php echo $this->lang->line("leave Shipping Address") ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom b_input" name="name_s" value="<?php echo $name_s; ?>"
                                                   id="mcustomer_name_s">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="phone"
                                                   class="form-control margin-bottom b_input" name="phone_s" value="<?php echo $phone_s; ?>"
                                                   id="mcustomer_phone_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email_s">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="email"
                                                   class="form-control margin-bottom b_input" name="email_s" value="<?php echo $email_s; ?>"
                                                   id="mcustomer_email_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="address_s"
                                                   class="form-control margin-bottom b_input" name="address_s" value="<?php echo $address_s; ?>"
                                                   id="mcustomer_address1_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="city"
                                                   class="form-control margin-bottom b_input" name="city_s" value="<?php echo $city_s; ?>"
                                                   id="mcustomer_city_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region_s"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Region"
                                                   class="form-control margin-bottom b_input" name="region_s" value="<?php echo $region_s; ?>"
                                                   id="region_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country_s"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Country"
                                                   class="form-control margin-bottom b_input" name="country_s" value="<?php echo $country_s; ?>"
                                                   id="mcustomer_country_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" style="width:390px;" name="postbox_s" value="<?php echo $postbox_s; ?>"
                                                   id="postbox_s">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <!--<div class="form-group row"><label class="col-sm-2 col-form-label"
                                                                       for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Custom Discount" value="<?php echo $discount; ?>"
                                                   class="form-control margin-bottom b_input" name="discount">
                                        </div>
                                    </div>-->
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="taxid"><?php echo $this->lang->line('TAX') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="TAX" value="<?php echo $gst; ?>"
                                                   class="form-control margin-bottom b_input" style="width:390px;" name="taxid">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="docid"><?php echo $this->lang->line('Document') ?> ID</label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Document ID" value="<?php echo $docid; ?>"
                                                   class="form-control margin-bottom b_input" style="width:390px;" name="docid">
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                                       for="c_field"><?php echo $this->lang->line('Extra') ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Custom Field" 
                                                   class="form-control margin-bottom b_input" style="width:390px;" name="c_field">
                                        </div>
                                    </div>



                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

                                        <div class="col-sm-6">
                                            <select name="customergroup" class="form-control b_input" style="width:390px;">
                                                <?php

                                                foreach ($customergrouplist as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
									
									
									<div class="form-group row">

										<label class="col-sm-2 col-form-label"
											   for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

										<div class="col-sm-6">
											<select name="lid" class="form-control" style="width:390px;">												
												<?php
												foreach ($locations as $row) {
													$cid = $row['id'];
													$acn = $row['cname'];
													$holder = $row['address'];
													//echo "<option value='$cid'>$acn - $holder</option>";
													echo "<option value='$cid'>$acn</option>";
												}
												?>
											</select>


										</div>
									</div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency">Language</label>

                                        <div class="col-sm-6">
                                            <select name="language" class="form-control b_input" style="width:390px;">

                                                <?php

                                                echo $langs;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency"><?php echo $this->lang->line('customer_login') ?></label>

                                        <div class="col-sm-6">
                                            <select name="c_login" class="form-control b_input" style="width:390px;">

                                                <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                                <option value="0"><?php echo $this->lang->line('No') ?></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="password_c"><?php echo $this->lang->line('New Password') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Leave blank for auto generation"
                                                   class="form-control margin-bottom b_input" style="width:390px;" name="password_c"
                                                   id="password_c">
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane show" id="tab4" role="tabpanel" aria-labelledby="base-tab4">

                                 <?php
                                    foreach ($custom_fields as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="form-group row">

                                                <label class="col-sm-2 col-form-label"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                           name="custom[<?= $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                    ?>

                                </div>
								
								<div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
                                    

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name_s"><?php echo $this->lang->line('Balance Sheet for FYI') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext1=='jpg' || $ext1=='png' || $ext1=='jpeg' || $ext1=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->balance_sheet_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->balance_sheet_up;?>"><?php echo $franchise->balance_sheet_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('ITR for the FYI') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext2=='jpg' || $ext2=='png' || $ext2=='jpeg' || $ext2=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->itr_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->itr_up;?>"><?php echo $franchise->itr_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email_s"><?php echo $this->lang->line('Pan Card') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext3=='jpg' || $ext3=='png' || $ext3=='jpeg' || $ext3=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->pan_card_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->pan_card_up;?>"><?php echo $franchise->pan_card_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('GSTN Certificate') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext4=='jpg' || $ext4=='png' || $ext4=='jpeg' || $ext4=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->gst_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->gst_up;?>"><?php echo $franchise->gst_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo $this->lang->line('Last Three Months Bank Statement') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext5=='jpg' || $ext5=='png' || $ext5=='jpeg' || $ext5=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->bank_statement_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->bank_statement_up;?>"><?php echo $franchise->bank_statement_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region_s"><?php echo $this->lang->line('Cancelled Cheque Photo') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext6=='jpg' || $ext6=='png' || $ext6=='jpeg' || $ext6=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->cancelled_cheque_up;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->cancelled_cheque_up;?>"><?php echo $franchise->cancelled_cheque_up;?></a>
											<?php } ?>
                                        </div>
                                    </div>
									
									<div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region_s"><?php echo $this->lang->line('ABCD') ?></label>

                                        <div class="col-sm-8">
											<?php if($ext7=='jpg' || $ext7=='png' || $ext7=='jpeg' || $ext7=='gif'){ ?>
												<img src="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->abcd;?>" height="100%" width="100%" />
											<?php }else{ ?>
												<a target="_blank" href="<?php echo base_url(); ?>userfiles/documents/franchise/<?php echo $franchise->abcd;?>"><?php echo $franchise->abcd;?></a>
											<?php } ?>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
								
								
								
								<!-- Set Commision -->
								<div class="tab-pane" id="tab6" role="tabpanel" aria-labelledby="base-tab6">
								
								

								
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"
											   for="module"><?php echo $this->lang->line('Module') ?> </label>
										<div class="col-sm-6">											
											<?php if($franchise->module=='' || $franchise->module==0){ ?>
											<select name="module" id="module" class='form-control b_input' style="width:50%;">											
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
									
									
									
									
								
									
									<hr>
									
									<div class="form-group table">
															
									<div class="outer-div" style="border-bottom:1px solid #ddd;;max-width:100%;">
									  <div class="header row">
										<div class="col-sm-4">
										  <div style="padding:11px 28px;font-weight: 600;">CATEGORY</div>
										</div>
										<div class="col-sm-8">
										  <div class="d-flex align-items-center" style="width:100%;">
											<div style="width:20%;padding:11px 28px;font-weight: 600;">Purpose</div>
											<div style="width:20%;padding:11px 28px;font-weight: 600;margin-left: 28px;">Retail (%)</div>
											<div style="width:20%;padding:11px 28px;font-weight: 600;margin-left: 15px;">B2C (%)</div>
											<div style="padding:11px 28px;width:20%;font-weight: 600;margin-left: 10px;">Bulk (%)</div>
											<div style="padding:11px 28px;width:20%;font-weight: 600;">Renting (%)</div>
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
												  <div style="padding:11px 28px;"><input type="checkbox" name="mobilephone" checked> <?php echo $cat_data->title; ?></div>
												  
												  <div style="padding:11px 28px;">
													<span >                                   
													   <?php foreach($catcommision[$cat_id]['child'] as $scat){ ?>
														<ul style="display:block; padding:0px !important; margin-left: 0px;">
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
												<div class="col-sm-8 edit-frnch">
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:20%;padding:11px 28px;">Buying</div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][1]" id="retail[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->retail_commision_percentage; ?>"></div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][1]" id="b2c[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][1]" id="bulk[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][1]" id="renting[<?php echo $cat_id; ?>][1]" value="<?php echo $catcommision[$cat_id][1]->renting_commision_percentage; ?>"></div>
												  </div>
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:20%;padding:11px 28px;">Selling</div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][2]" id="retail[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->retail_commision_percentage; ?>"></div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][2]" id="b2c[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][2]" id="bulk[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][2]" id="renting[<?php echo $cat_id; ?>][2]" value="<?php echo $catcommision[$cat_id][2]->renting_commision_percentage; ?>"></div>
												  </div>
												  <div class="d-flex align-items-center" style="width:100%;">
													<div style="width:20%;padding:11px 28px;">Exchange</div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="retail[<?php echo $cat_id; ?>][3]" id="retail[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->retail_commision_percentage; ?>"></div>
													<div style="width:20%;padding:11px 28px;"><input type="text" class="form-control margin-bottom b_input required" name="b2c[<?php echo $cat_id; ?>][3]" id="b2c[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->b2c_comission_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="bulk[<?php echo $cat_id; ?>][3]" id="bulk[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->bulk_commision_percentage; ?>"></div>
													<div style="padding:11px 28px;width:20%"><input type="text" class="form-control margin-bottom b_input required" name="renting[<?php echo $cat_id; ?>][3]" id="renting[<?php echo $cat_id; ?>][3]" value="<?php echo $catcommision[$cat_id][3]->renting_commision_percentage; ?>"></div>
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
								</div>
								<!-- End -->
								
								
                                
                            </div>
                        </div>
                    </div>
                </div>
								<div class="form-group row">

                    <label class="col-sm-5 col-form-label"></label>

                    <div class="col-sm-2 text-center mt-3">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add customer') ?>" data-loading-text="Adding...">
                    </div>
                    <div class="col-sm-5">
                    </div>
                </div>
				<?php $id = $this->input->get('id', true); ?>
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            </div>
				<input type="hidden" name="franchise_id" value="<?php echo $franchise->id;?>" id="franchise_id">
                <input type="hidden" value="customers/addcustomer" id="action-url">
            </form>
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
    
	$(".subcat").click(function (e) {		
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
