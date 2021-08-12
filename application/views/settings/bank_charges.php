<?php
$id = $record->id;
$charges = $record->charges;
$charges_type = $record->charges_type;
?>
<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Set') ?> <?php echo $this->lang->line('Bank Charges') ?></h5>				
                <hr>
                <div class="row">
					<div class="col-sm-5">
						<div class="form-group row">
							<label class="col-sm-5 col-form-label" for="charges_type" id="charges_type">Type</label>
							<div class="col-sm-7">
                            <select class="form-control calc" name="charges_type" id="charges_type">
						  <option value="1" <?php if($charges_type==1){ ?>selected=""<?php } ?>>Flat</option>
						  <option value="2" <?php if($charges_type==2){ ?>selected=""<?php } ?>>%</option>             
						</select></div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="charges" id="charges"><?php echo $this->lang->line('Bank Charges') ?> </label>
							<div class="col-sm-8">
                            <input type="text" placeholder="<?php echo $this->lang->line('Bank Charges') ?>" id='charges'
                               class="form-control margin-bottom required" name="charges" value="<?php echo  $charges; ?>"></div>
						</div>
					</div>
				</div>
				
				
				
                
                <div class="form-group row text-center">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-8">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Save') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/bank_charges?id=<?php echo $id; ?>" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

