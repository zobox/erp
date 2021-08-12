<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="title">
                <?php echo $this->lang->line('Departments') ?> <a href="<?php echo base_url('employee/adddep') ?>"
                                                                  class="btn btn-info rounded small-button">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
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
				
				<form method="post" action="<?php echo base_url('export/products_o') ?>"
                                      class="form-horizontal">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                           value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label"> Export Products </label>
									<div class="col-sm-7">
									<select name="type" class="form-control">
                                            <option value="1"><?php echo $this->lang->line('Products') ?></option>
                                            <option value="2"><?php echo $this->lang->line('Products with categories') ?></option>
                                        </select>
									</div>
								</div>
							</div>
							
						</div>
					
						<div class="text-center">
							<div class="col-sm-12">
													<input type="submit" class="btn btn-success margin-bottom"
														   value="Backup" data-loading-text="Updating...">

												</div>
						</div>
				</form>
			</div>

                

                <script type="text/javascript">
                    $(function () {
                        $('.summernote').summernote({
                            height: 250,
                            toolbar: [
                                // [groupName, [list of button]]
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                ['fontsize', ['fontsize']]

                            ]
                        });
                    });
                </script>

