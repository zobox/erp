<div class="content-body">	
	
    <div class="card">		
        <div class="card-header">
			<div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
			
            <h5><?php echo $this->lang->line('Edit supplier Details') ?></h5>

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
		<?php //print_r($customer);?>
            <form method="post" id="data_form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url()?>supplier/editsupplier">
                <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Name"
                               class="form-control margin-bottom  required" name="name"
                               value="<?php echo $customer['name'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Company') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Company"
                               class="form-control margin-bottom" name="company"
                               value="<?php echo $customer['company'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="phone"><?php echo $this->lang->line('Phone') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="phone"
                               class="form-control margin-bottom required" name="phone"
                               value="<?php echo $customer['phone'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom  required" name="email"
                               value="<?php echo $customer['email'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-12 col-form-label"
                           for="billing_address"><?php echo "<strong>Billing Address</strong>"; ?></label>

                    
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="address"><?php echo $this->lang->line('Address') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="address"
                               class="form-control margin-bottom" name="address_b" id="address_b" value="<?php echo $customer['address_b'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="city"
                               class="form-control margin-bottom" name="city_b" id="city_b" value="<?php echo $customer['city_b'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="region"><?php echo $this->lang->line('Region') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Region"
                               class="form-control margin-bottom" name="state_b" id="state_b" value="<?php echo $customer['state_b'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="country"><?php echo $this->lang->line('Country') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Country"
                               class="form-control margin-bottom" name="country_b" id="country_b" value="<?php echo $customer['country_b'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="PostBox"
                               class="form-control margin-bottom" name="postbox_b" id="postbox_b" value="<?php echo $customer['postbox_b'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-12 col-form-label"
                           for="same_address"><input type="checkbox" id="same_address" name="same_address" value="1" <?php if($customer['same_as_billing'] == 1){?> checked="checked"<?php }?> /> Shipping address same as billing address. </label>

                    
                </div>
				<div class="form-group row shiiping">

                    <label class="col-sm-12 col-form-label"
                           for="shipping_address"><?php echo "<strong>Shipping Address</strong>"; ?></label>

                    
                </div>
				<div class="form-group row shiiping">

                    <label class="col-sm-2 col-form-label"
                           for="address"><?php echo $this->lang->line('Address') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="address"
                               class="form-control margin-bottom" name="address_s" id="address_s" value="<?php echo $customer['address_s'] ?>">
                    </div>
                </div>
                <div class="form-group row shiiping">

                    <label class="col-sm-2 col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="city"
                               class="form-control margin-bottom" name="city_s" id="city_s" value="<?php echo $customer['city_s'] ?>">
                    </div>
                </div>
                <div class="form-group row shiiping">

                    <label class="col-sm-2 col-form-label"
                           for="region"><?php echo $this->lang->line('Region') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Region"
                               class="form-control margin-bottom" name="state_s" id="state_s" value="<?php echo $customer['state_s'] ?>">
                    </div>
                </div>
                <div class="form-group row shiiping">

                    <label class="col-sm-2 col-form-label"
                           for="country"><?php echo $this->lang->line('Country') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Country"
                               class="form-control margin-bottom" name="country_s" id="country_s" value="<?php echo $customer['country_s'] ?>">
                    </div>
                </div>
                <div class="form-group row shiiping">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="PostBox"
                               class="form-control margin-bottom" name="postbox_s" id="postbox_s"  value="<?php echo $customer['postbox_s'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-12 col-form-label"
                           for="statuatory_details"><?php echo "<strong>Statuatory Details</strong>"; ?></label>

                    
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('PAN') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="PAN"
                               class="form-control margin-bottom" name="pan" value="<?php echo $customer['pan'] ?>">
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('GST/TIN') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="GST/TIN"
                               class="form-control margin-bottom" name="gst" value="<?php echo $customer['gst'] ?>">
                    </div>
                </div>
				
                <div class="form-group row">

                    <label class="col-sm-12 col-form-label"
                           for="statuatory_details"><?php echo "<strong>Bank Details</strong>"; ?></label>

                    
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('RTGS/ IFSC Code') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="RTGS/ IFSC Code"
                               class="form-control margin-bottom" name="rtgs" value="<?php echo $customer['rtgs'] ?>">
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('Accounts Number') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Accounts Number"
                               class="form-control margin-bottom" name="account_no" value="<?php echo $customer['account_no'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('Bank Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Bank Name"
                               class="form-control margin-bottom" name="bank_name" value="<?php echo $customer['bank_name'] ?>">
                    </div>
                </div>
				<div class="form-group row">


                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('Branch') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Branch"
                               class="form-control margin-bottom" name="branch_name" value="<?php echo $customer['branch_name'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-12 col-form-label"
                           for="statuatory_details"><?php echo "<strong>Upload</strong>"; ?></label>

                    
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('Pan Card') ?></label>

                    <div class="col-sm-6">
                        <input type="file" 
                               class="form-control margin-bottom" name="pan_up">
							   <input type="hidden" name="pan_up_old" value="<?php echo $customer['pan_up'] ?>" />
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('GSTN Certificate') ?></label>

                    <div class="col-sm-6">
                        <input type="file" 
                               class="form-control margin-bottom" name="gst_up">
							   <input type="hidden" name="gst_up_old" value="<?php echo $customer['gst_up'] ?>" />
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('Cancelled Cheque Photo') ?></label>

                    <div class="col-sm-6">
                        <input type="file" 
                               class="form-control margin-bottom" name="cancelled_cheque_up">
							   <input type="hidden" name="cancelled_cheque_up_old" value="<?php echo $customer['cancelled_cheque_up'] ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="supplier/editsupplier" id="action-url">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if($customer['same_as_billing'] == 1){?>
		<script>
			$(window).ready(function(){
				$('.shiiping').hide();
			});
		</script>
<?php } ?>
<script>
	$('#same_address').click(function(){
		 if ($(this).is(':checked')) {
		 	$('.shiiping').hide();
			$('#address_s').val($('#address_b').val());
			$('#country_s').val($('#country_b').val());
			$('#state_s').val($('#state_b').val());
			$('#city_s').val($('#city_b').val());
			$('#postbox_s').val($('#postbox_b').val());
		 }
		 else{
		 	$('.shiiping').show();
			$('#address_s').val('');
			$('#country_s').val('');
			$('#state_s').val('');
			$('#city_s').val('');
			$('#postbox_s').val('');
		 }
		});
</script>

