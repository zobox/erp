<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $this->lang->line('Agency Details') ?> : <?php echo $details['name'] ?></h4>
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
            <?php $agency_details = json_decode(json_encode($agency_details[0]),true); //print_r($agency_details);?>
            <div class="ibox-content mt-2"> <img alt="image" id="dpic" class="card-img-top img-fluid"
                                 src="<?php echo base_url('userfiles/customers/') . $agency_details['image'] ?>"> </div>
            <hr>
            <h6><?php echo $this->lang->line('Agency Name') ?> <small><?php echo $agency_details['name'] ?></small> </h6>
            <?php /*?><div class="row mt-3">
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

                            </div>
                        </div><?php */?>
          </div>
          <div class="col-md-8">
            <?php /*?><div id="mybutton">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>

                                 <a href="<?php echo base_url('customers/bulkpayment?id=' . $details['id']) ?>"
                                   class="btn btn-grey-blue btn-md"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('Bulk Payment') ?>
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

                        </div><?php */?>
            <div class="">
              <hr>
              <div class="row m-t-lg">
                <div class="col-md-2"> <strong>Email</strong> </div>
                <div class="col-md-10"> <?php echo $agency_details['email'] ?> </div>
              </div>
              <hr>
              <div class="row m-t-lg">
                <div class="col-md-2"> <strong><?php echo $this->lang->line('Phone') ?></strong> </div>
                <div class="col-md-10"> <?php echo $agency_details['contact_no'] ?> </div>
              </div>
              <hr>
              <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                <div id="heading2" class="card-header"> <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion2"
                                       aria-expanded="false" aria-controls="accordion2"
                                       class="card-title lead collapsed"> <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Address') ?> </a> </div>
                <div id="accordion2" role="tabpanel" aria-labelledby="heading2"
                                     class="card-collapse collapse" aria-expanded="false">
                  <div class="card-body">
                    <div class="card-block">
                      <?php /*?><div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Address') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $agency_details['address'] ?>
                                                </div>

                                            </div>
                                            <hr><?php */?>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('State') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['state_name'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('City') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['city'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('PostBox') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['pincode'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Country') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['country']; ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Status') ?></strong> </div>
                        <div class="col-md-10">
                          <?php if($agency_details['agency_type'] == 1 || $agency_details['agency_type'] == 2){echo "New";}else{echo "Not Verified";} ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
								if($agency_details['agency_type'] == 1 || $agency_details['agency_type'] == 2) {?>
                <div id="heading3" class="card-header"> <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion3"
                                       aria-expanded="false" aria-controls="accordion3"
                                       class="card-title lead collapsed"> <i class="fa  fa-plus-circle"></i> <?php echo $this->lang->line('Agency KYC') ?> </a> </div>
                <div id="accordion3" role="tabpanel" aria-labelledby="heading3"
                                     class="card-collapse collapse" aria-expanded="false">
                  <div class="card-body">
                    <div class="card-block">
                      <h4>Identity Details</h4>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Agency Type') ?></strong> </div>
                        <div class="col-md-10"> <?php echo ($agency_details['agency_type'] == 1)? "Individual" : "Company"; ?> </div>
                      </div>
                      <hr>
                      <?php if($agency_details['agency_type'] == 1){?>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Name of the Applicant') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_form_name']; ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Email of the Applicant') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_form_email'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Contact of the Applicant') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_form_contact'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Alternate Phone Number of the Applicant') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['alt_contact_no'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Pan Card') ?></strong> </div>
                        <div class="col-md-3"> <?php echo $agency_details['pan_card'] ?> </div>
                        <div class="col-md-7"> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['pan_card_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $agency_details['other_proof']; ?></strong> </div>
                        <div class="col-md-4"> <?php echo $agency_details['adhar_card_no'] ?> </div>
                        <div class="col-md-3"> <?php echo $agency_details['other_proof']." Front "; ?> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['adhar_card_front_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                        <div class="col-md-3"> <?php echo $agency_details['other_proof']." Back "; ?> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['adhar_card_back_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                      </div>
                      <?php }
											else{?>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Company Name') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['comapany_name'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Director Email') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['registered_email_address'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Director Phone No') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['registered_contact_no'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('GST/TIN') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['gst_no'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('GSTN Certificate') ?></strong> </div>
                        <div class="col-md-10"> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['gst_no_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                      </div>
                      <hr>
                      <?php }?>
                      <h4>Address Details</h4>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Address Line 1') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['address_line_1'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Address Line 2') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['address_line_2'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('State') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_state'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('City') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_city'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('PostBox') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['kyc_pincode'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Country') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['country'] ?> </div>
                      </div>
                      <hr>
                      <h4>Bank Details</h4>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Account Holder') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['account_holder_name'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('RTGS/ IFSC Code') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['ifsc_code'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Account No') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['account_number'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Bank Name') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['bank_name'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Branch') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['branch'] ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo "Cancel ".$this->lang->line('Cheque') ?></strong> </div>
                        <div class="col-md-10"> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['cancel_cheque_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                      </div>
                      <hr>
                      <h4>Declaration</h4>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Applicant Signature') ?></strong> </div>
                        <div class="col-md-10"> <img src="<?php echo base_url() . "app-assets/images/agencykyc/" .$agency_details['applicant_signature_up'] ?>" class="img-thumbnail" style="width:25%;" alt="Pan Card" /> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Signature Date') ?></strong> </div>
                        <div class="col-md-10"> <?php echo date("M d, Y",strtotime($agency_details['applicant_signed_date'])); ?> </div>
                      </div>
                      <hr>
                      <div class="row m-t-lg">
                        <div class="col-md-2"> <strong><?php echo $this->lang->line('Referral Code') ?></strong> </div>
                        <div class="col-md-10"> <?php echo $agency_details['referral_code']; ?> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
				<a href="<?php echo base_url()?>agency/" class="btn btn-success btn-sm">Back</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
