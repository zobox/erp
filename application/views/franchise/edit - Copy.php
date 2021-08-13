<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Franchise Details') ?></h5>

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
            <form method="post" id="data_form" class="form-horizontal">
                <div class="row">

                    <div class="col-md-6">
                        <h5><?php echo $this->lang->line('General Details') ?></h5>
                        <input type="hidden" name="id" value="<?php echo $franchise['id'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="company_name"><?php echo $this->lang->line('Company Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Company Name"
                                       class="form-control margin-bottom required" name="company_name"
                                       value="<?php echo $franchise['company_name'] ?>" id="mfranchise_name">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="company_type"><?php echo $this->lang->line('Company Type') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Company Type"
                                       class="form-control margin-bottom" name="company_type"
                                       value="<?php echo $franchise['company_type'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="company_email"><?php echo $this->lang->line('Company Email') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Company Email"
                                       class="form-control margin-bottom  required" name="company_email"
                                       value="<?php echo $franchise['company_email'] ?>" id="mfranchise_phone">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label" for="company_phone">Company Phone No</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="company_phone"
                                       class="form-control margin-bottom required" name="company_phone"
                                       value="<?php echo $franchise['company_phone'] ?>" id="mfranchise_email">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="director_name"><?php echo $this->lang->line('Director Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Director Name"
                                       class="form-control margin-bottom" name="director_name"
                                       value="<?php echo $franchise['director_name'] ?>" id="director_name">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="director_email"><?php echo $this->lang->line('Director Email') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Director Email"
                                       class="form-control margin-bottom" name="director_email"
                                       value="<?php echo $franchise['director_email'] ?>" id="director_email">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="director_phone"><?php echo $this->lang->line('Director Phone No') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Director Phone No"
                                       class="form-control margin-bottom" name="director_phone"
                                       value="<?php echo $franchise['director_phone'] ?>" id="director_phone">
                            </div>
                        </div>
						
						
						
						<h5><?php echo $this->lang->line('General Details') ?></h5>
						
						
						
						
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="franchise_name"><?php echo $this->lang->line('Franchiser Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Franchiser Name"
                                       class="form-control margin-bottom" name="franchise_name"
                                       value="<?php echo $franchise['franchise_name'] ?>" id="franchise_name">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="franchise_email"><?php echo $this->lang->line('Franchiser Email') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Franchiser Email"
                                       class="form-control margin-bottom" name="franchise_email"
                                       value="<?php echo $franchise['franchise_email'] ?>" id="franchise_email">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="franchise_phone"><?php echo $this->lang->line('Franchiser Phone No') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Franchiser Phone No"
                                       class="form-control margin-bottom" name="franchise_phone"
                                       value="<?php echo $franchise['franchise_phone'] ?>">
                            </div>
                        </div>
						
						
						
						
						
						
						
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="postbox"><?php echo $this->lang->line('Document') ?> ID</label>

                            <div class="col-sm-6">
                                <input type="text" placeholder="Document ID"
                                       class="form-control margin-bottom b_input" name="docid"
                                       value="<?php echo $franchise['docid'] ?>">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                           for="postbox"><?php echo $this->lang->line('Extra') ?> </label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Custom Field"
                                       class="form-control margin-bottom b_input" name="c_field"
                                       value="<?php echo $franchise['custom1'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="franchisegroup"><?php echo $this->lang->line('franchise group') ?></label>

                            <div class="col-sm-6">
                                <select name="franchisegroup" class="form-control">
                                    <?php
                                    echo '<option value="' . $franchisegroup['id'] . '">' . $franchisegroup['title'] . ' (S)</option>';
                                    foreach ($franchisegrouplist as $row) {
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
                                   for="franchisegroup">Language</label>
                            <div class="col-sm-6">
                                <select name="language" class="form-control b_input">
                                    <?php
                                    echo '<option value="' . $franchise['lang'] . '">-' . ucfirst($franchise['lang']) . '-</option>';
                                    echo $langs;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                           for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Custom Discount"
                                       class="form-control margin-bottom b_input" name="discount"
                                       value="<?php echo $franchise['discount_c'] ?>">
                            </div>
                        </div>

                        <?php foreach ($custom_fields as $row) {
                            if ($row['f_type'] == 'text') { ?>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="docid"><?= $row['name'] ?></label>

                                    <div class="col-sm-8">
                                        <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                               class="form-control margin-bottom b_input"
                                               name="custom[<?= $row['id'] ?>]"
                                               value="<?= $row['data'] ?>">
                                    </div>
                                </div>


                            <?php }


                        }
                        ?>
                    </div>

                    <div class="col-md-6">
                        <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                        <div class="form-group row">

                            <div class="input-group mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="franchise1"
                                           id="copy_address">
                                    <label class="custom-control-label"
                                           for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                </div>

                            </div>

                            <div class="col-sm-10">
                                <?php echo $this->lang->line("leave Shipping Address") ?>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_name"><?php echo $this->lang->line('Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom" name="name_s"
                                       value="<?php echo $franchise['name_s'] ?>" id="mfranchise_name_s">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="phone"
                                       class="form-control margin-bottom" name="phone_s"
                                       value="<?php echo $franchise['phone_s'] ?>" id="mfranchise_phone_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label" for="email">Email</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="email"
                                       class="form-control margin-bottom" name="email_s"
                                       value="<?php echo $franchise['email_s'] ?>" id="mfranchise_email_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_name"><?php echo $this->lang->line('Address') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="address"
                                       class="form-control margin-bottom" name="address_s"
                                       value="<?php echo $franchise['address_s'] ?>" id="mfranchise_address1_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="city"><?php echo $this->lang->line('City') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="city"
                                       class="form-control margin-bottom" name="city_s"
                                       value="<?php echo $franchise['city_s'] ?>" id="mfranchise_city_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="region"><?php echo $this->lang->line('Region') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="region"
                                       class="form-control margin-bottom" name="region_s"
                                       value="<?php echo $franchise['region_s'] ?>" id="region_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Country"
                                       class="form-control margin-bottom" name="country_s"
                                       value="<?php echo $franchise['country_s'] ?>" id="mfranchise_country_s">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="region"
                                       class="form-control margin-bottom" name="postbox_s"
                                       value="<?php echo $franchise['postbox_s'] ?>" id="postbox_s">
                            </div>
                        </div>


                    </div>

                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Update Franchise" data-loading-text="Updating...">
                        <input type="hidden" value="franchise/editfranchise" id="action-url">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

