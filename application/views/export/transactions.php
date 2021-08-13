<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Export Transactions</h5>
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
            <hr>
            <div class="card-body"> 
					<form action="<?php echo base_url() ?>export/transactions_o" method="post" role="form">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                       value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="row">
								<div class="col-sm-5">
									<div class="form-group row">
										<label class="col-sm-5 col-form-label" for="pay_cat"><?php echo $this->lang->line('Account') ?></label>
										<div class="col-sm-7">
											<select name="pay_acc" class="form-control">
												<?php
														foreach ($accounts as $row) {
															$cid = $row['id'];
															$acn = $row['acn'];
															$holder = $row['holder'];
															echo "<option value='$cid'>$acn - $holder</option>";
														}
														?>
														<option value='All'><?php echo $this->lang->line('All Accounts') ?></option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="pay_cat"><?php echo $this->lang->line('Type') ?></label>
										<div class="col-sm-8">
											<select name="trans_type" class="form-control">
												<option value='All'>
													<?php echo $this->lang->line('All Transactions') ?>
												</option>
												<option value='Expense'>
													<?php echo $this->lang->line('Debit') ?>
												</option>
												<option value='Income'>
													<?php echo $this->lang->line('Credit') ?>
												</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-5">
									<div class="form-group row">
										<label class="col-sm-5 col-form-label" for="sdate"><?php echo $this->lang->line('From Date') ?></label>
										<div class="col-sm-7">
											<input type="text" class="form-control required" placeholder="Start Date" name="sdate" data-toggle="datepicker" id="sdate" autocomplete="false"> </div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="edate"><?php echo $this->lang->line('To Date') ?></label>
										<div class="col-sm-8">
											<input type="text" class="form-control required" placeholder="End Date" name="edate" data-toggle="datepicker" autocomplete="false"> </div>
									</div>
								</div>
							</div>
							<div class="text-center">
								<label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-success btn-md"
                                               value="<?php echo $this->lang->line('Export') ?>">


                                    </div>
							</div>
					</form>
			</div>
        </div>
    </div>
</div>