<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5>Franchise Salewise Cost Report</h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
		<div class="card-body">
				<form action="<?php echo base_url() ?>export/franchise_salewise_cost_report_export" method="post" role="form">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                        value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">							
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="pay_cat"><?php echo $this->lang->line('Type') ?></label>
									<div class="col-sm-8">
									<select name="type" id="type" class="form-control" required="">
										<option value='1'>
											IMEI WISE
										</option>
																			
									</select>
									</div>
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
