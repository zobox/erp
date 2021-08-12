<?php
$id = $record->id;
$commission = $record->commission;
$commission_type = $record->commission_type;
?>
<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Set') ?> <?php echo $this->lang->line('Agency Commission') ?></h5>				
                <hr>
                <div class="row">
					<div class="col-sm-5">
						<div class="form-group row">
							<label class="col-sm-5 col-form-label" for="refurbishment_cost_fixed" id="commission">Type</label>
							<div class="col-sm-7">
                            <select class="form-control calc" name="commission_type" id="commission_type">
						  <option value="1" <?php if($commission_type==1){ ?>selected=""<?php } ?>>Flat</option>
						  <option value="2" <?php if($commission_type==2){ ?>selected=""<?php } ?>>%</option>             
						</select></div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="refurbishment_cost_fixed" id="commission"><?php echo $this->lang->line('Agency Commission') ?></label>
							<div class="col-sm-8">
                            <input type="text" placeholder="<?php echo $this->lang->line('Agency Commission') ?>" id='commission'
                               class="form-control margin-bottom required" name="commission" value="<?php echo  $commission; ?>"></div>
						</div>
					</div>
				</div>
                
                <div class="form-group row text-center">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-12">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Save') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/agencycommission?id=<?php echo $id; ?>" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

