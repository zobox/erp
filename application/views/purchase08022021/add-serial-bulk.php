<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>purchase/addbulk">

                <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
                <hr>
				
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Item Name') ?></label>

                    <div class="col-sm-6">
                        <h6><?php $i = 1;foreach($Pdata as $row){
					if($i == 1){echo $i.". ".$row->product;}
					else{echo "<br>".$i.". ".$row->product;}
					$i++;
				}?></h6>
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Upload') ?></label>

                    <div class="col-sm-6">
                        <input type="file" name="file" id="file">
                    </div>
                </div>
				
				
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Download Excel') ?></label>

                    <div class="col-sm-6">
                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="po" type="button"><span><a href="<?php echo base_url(); ?>purchase/serial_excel?id=<?php echo $this->input->get('id'); ?>">Excel</a></span></button>
                    </div>
                </div>
				
				
                
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data111" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <!--<input type="hidden" value="purchase/addbulk" id="action-url">-->
                        <input type="hidden" name="pid" value="<?php echo $Pdata->pid; ?>" id="pid">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

