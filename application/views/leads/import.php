<article class="content">
  <div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <div class="card card-block">
      <!--<form method="post" id="data_form" class="card-body" enctype="multipart/form-data">-->
	  <form method="post" id="data_form" class="card-body" enctype="multipart/form-data" action="<?php echo base_url();?>leads/import_leads">
      <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
      <hr>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label"
                           for="product_catname">Upload Lead</label>
        <div class="col-sm-6">
          <h6>
            
          </h6>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Download Excel') ?></label>
        <div class="col-sm-6"> <a href="<?php echo base_url(); ?>leads/sample_lead" title="sample file" class="btn btn-warning btn-sm">Download Sample File</a> </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Upload Excel') ?></label>
        <div class="col-sm-6">
          <input type="file" name="file" id="file">
        </div>
      </div>
      
	  
		<div class="form-group row">

			<label class="col-sm-2 col-form-label"></label>

			<div class="col-sm-4">
				<input type="submit" id="submit-data11" class="btn btn-success margin-bottom"
					   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
				<input type="hidden" value="leads/import_leads" id="action-url">
			</div>
		</div>
      </form>
    </div>
  </div>
</article>
