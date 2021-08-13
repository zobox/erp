<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('TAX') . ' Statement' ?></h5>
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


            <div class="card-body"> <span class="text-bold-600"><span class="icon-file-pdf"></span> To Export Data Check <a href="<?php echo base_url() ?>export/account">HERE</a></span>
				<hr>
				<form action="<?php echo base_url() ?>reports/taxviewstatement" method="post" role="form"><input
                                    type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">
							<div class="col-sm-5">
								<div class="form-group row">
									<label class="col-sm-5 col-form-label" for="ty"><?php echo $this->lang->line('Type') ?></label>
									<div class="col-sm-7">
										<select name="ty" class="form-control">
											<option value='Sales'>Sales TAX Report</option>
											<option value='Purchase'>Purchase TAX Report</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="lid"><?php echo $this->lang->line('Business Locations') ?></label>
									<div class="col-sm-8">
										<select name="lid" class="form-control">
											<option value='0'>
												<?php echo $this->lang->line('All') ?>
											</option>
											<?php
											foreach ($locations as $row) {
												$cid = $row['id'];
												$acn = $row['cname'];
												$holder = $row['address'];
												echo "<option value='$cid'>$acn - $holder</option>";
											}
											?>
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
										<input type="text" class="form-control required" placeholder="End Date" name="edate" data-toggle="datepicker" autocomplete="false"> </div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="edate"><?php echo $this->lang->line('To Date') ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control required" placeholder="Start Date" name="sdate" id="sdate" data-toggle="datepicker" autocomplete="false"> </div>
								</div>
							</div>
						</div>
						<div class="text-center">
							<label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-success btn-md" value="View">


                                </div>
						</div>
				</form>
			</div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $("#customer_statement").select2({
        minimumInputLength: 4,
        tags: [],
        ajax: {
            url: baseurl + 'search/customer_select',
            dataType: 'json',
            type: 'POST',
            quietMillis: 50,
            data: function (customer) {
                return {
                    customer: customer,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
        }
    });
</script>
