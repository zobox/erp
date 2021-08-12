<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Add New Asset Brand') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Asset Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Asset Name"
                               class="form-control margin-bottom  required" name="name" value="<?=$result->brand_name?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Asset Short Description"
                               class="form-control margin-bottom required" name="desc" value="<?=$result->description?>">
                    </div>
                </div>
                <input type="hidden" value="0" name="cat_type">
                <input type="hidden" name="brand_id" value="<?=$result->id?>">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add Brand') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="asset/asset_brand_update" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

