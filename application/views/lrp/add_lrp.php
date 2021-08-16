<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url(); ?>customers/add_trc_lrp">

                <h5><?php echo $this->lang->line('New TRC') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="TRC Name"
                               class="form-control margin-bottom b_input required" name="name">
                    </div>
                </div>
								
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                   for="phone"><?php echo $this->lang->line('Phone') ?></label>
                     <div class="col-sm-8">
                       <input type="text" placeholder="<?php echo $this->lang->line('Phone') ?>"
					   class="form-control margin-bottom required b_input" name="phone" value="<?php echo $phone; ?>" 
					   id="phone">
                      </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                   for="phone">Email</label>
                     <div class="col-sm-8">
                        <input type="text" placeholder="Email" class="form-control margin-bottom required b_input" 
						name="email" value="<?php echo $email; ?>" id="email">
                      </div>
                </div>

				<div class="form-group row">

					<label class="col-sm-2 col-form-label"
						   for="address"><?php echo $this->lang->line('Address') ?></label>

					<div class="col-sm-8">
						<input type="text" placeholder="<?php echo $this->lang->line('Address') ?>"
							   class="form-control margin-bottom b_input" name="address" value="<?php echo $address; ?>"
							   id="address">
					</div>
				</div>
				
				<div class="form-group row">

					<label class="col-sm-2 col-form-label"
						   for="city"><?php echo $this->lang->line('City') ?></label>

					<div class="col-sm-8">
						<input type="text" placeholder="<?php echo $this->lang->line('City') ?>"
							   class="form-control margin-bottom b_input" name="city" value="<?php echo $city; ?>"
							   id="city">
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
						   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

					<div class="col-sm-8">
						<input type="text" placeholder="<?php echo $this->lang->line('PostBox') ?>"
							   class="form-control margin-bottom b_input" name="postbox" value="<?php echo $postbox; ?>"
							   id="postbox">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-2 col-form-label"
						   for="postbox"><?php echo $this->lang->line('GST') ?></label>
					<div class="col-sm-8">
						<input type="text" placeholder="<?php echo $this->lang->line('GST') ?>"
							   class="form-control margin-bottom b_input" name="gst_number" value="<?php echo $gst_number; ?>"
							   id="gst_number">
					</div>
				</div>

				 <div class="form-group row">

					<label class="col-sm-2 col-form-label"
						   for="postbox">Password</label>

					<div class="col-sm-8">
						<input type="password" placeholder="Password"
							   class="form-control margin-bottom b_input" name="password" value="<?php echo $password; ?>"
							   id="password">
					</div>
				</div>

				 <div class="form-group row">

					<label class="col-sm-2 col-form-label"
						   for="postbox">Confirm Password</label>

					<div class="col-sm-8">
						<input type="password" placeholder="password"
							   class="form-control margin-bottom b_input" name="c_password" value="<?php echo $password; ?>"
							   id="password">
					</div>
				</div>
                <input type="hidden" value="0" name="cat_type">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Add TRC" data-loading-text="Adding...">
                        <input type="hidden" value="customers/add_trc_lrp" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

