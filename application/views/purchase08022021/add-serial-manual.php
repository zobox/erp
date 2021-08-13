<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <!--<form method="post" id="data_form" class="card-body" action="<?php echo  base_url(); ?>purchase/addmanual">-->
            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
                <hr>
				<?php foreach($Pdata->pitems as $key=>$Purchaseitems){ 
				$qty = $Purchaseitems->qty-$Purchaseitems->pending_qty;
				if($qty>0){
				?>				
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Item Name') ?></label>

                    <div class="col-sm-2">
                        <h6><?php echo $Purchaseitems->product; ?>   [PO QTY - <?php echo $qty; ?>]</h6>
                    </div>
					
					<div class="col-sm-4">
                        <input type="text" placeholder="Product Recieved in Warehouse"
                               class="form-control margin-bottom rqty" id="<?php echo $Purchaseitems->pid; ?>" name="qty[<?php echo $Purchaseitems->pid; ?>][]" value="">
						<input type="hidden" name="purchase_item[<?php echo $Purchaseitems->pid; ?>]" value="<?php echo $Purchaseitems->id; ?>">
						<div class="error_msg<?php echo $Purchaseitems->pid; ?>"></div>
                    </div>					
                </div>
				<div class="sereal<?php echo $Purchaseitems->pid; ?>"></div>
				
				<input type="hidden" name="poqty<?php echo $Purchaseitems->pid; ?>" id="poqty<?php echo $Purchaseitems->pid; ?>" value="<?php echo $qty; ?>">
				<!--<input type="hidden" name="wupc<?php echo $Purchaseitems->pid; ?>" id="wupc<?php echo $Purchaseitems->pid; ?>" value="<?php echo $Purchaseitems->warehouse_product_code.'-'.$Purchaseitems->id.'-'.(strtotime("now")); ?>">-->
				<input type="hidden" name="wupc<?php echo $Purchaseitems->pid; ?>" id="wupc<?php echo $Purchaseitems->pid; ?>" value="<?php echo $Purchaseitems->id.(rand(1,1000000)); ?>">
				<?php 	
								
				/* for($i=1; $i<=$qty; $i++){ ?>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Serial Number').'-'.$i; ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Warehouse Description"
                               class="form-control margin-bottom" name="sl[<?php echo $Purchaseitems->pid; ?>][]">
						<input type="hidden" name="purchase_item[<?php echo $Purchaseitems->pid; ?>]" value="<?php echo $Purchaseitems->id; ?>">	
                    </div> 
                </div>
				<?php }  */?>
				
				<?php }} ?>
				
                
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="purchase/addmanual" id="action-url">                   
                        <input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>


<script>
$(document).ready(function(){
	var qty = parseInt($(this).val());
	var pid = $(this).attr('id');
	var sereal_var = '.sereal'+pid;
	$(sereal_var).html('');
	var poqty_var = '#poqty'+pid;	
	var poqty = parseInt($(poqty_var).val());
	var wupc_var = '#wupc'+pid;	
	var wupc = $(wupc_var).val();		
	var qty_var = '#'+pid;
	var error_msg = '.error_msg'+pid;	 
	
	// $(sereal_var).remove();
	if(poqty >= qty){		
		for(i=1; i<=qty; i++){
			var wupc_concat = wupc+i;
			$(sereal_var).append('<div class="form-group row"> <label class="col-sm-2 col-form-label" for="product_catname">Serial Number-'+i+'</label> <div class="col-sm-6"> <input type="text" placeholder="Product Warehouse Description" class="form-control margin-bottom" name="sl['+pid+'][]" value="'+wupc_concat+'"> </div> </div>');
		}	
		$(error_msg).html('');
		$(qty_var).removeAttr("style");
	}else{
		$(error_msg).html("<span style='color:red'>Recieved qty should be less than equal to recieved qty</span>")
		$(qty_var).css('border','1px solid red');
	}
});


$('.rqty').blur(function(){	
	var qty = parseInt($(this).val());
	var pid = $(this).attr('id');
	var sereal_var = '.sereal'+pid;
	$(sereal_var).html('');
	var poqty_var = '#poqty'+pid;	
	var poqty = parseInt($(poqty_var).val());
	var wupc_var = '#wupc'+pid;	
	var wupc = $(wupc_var).val();		
	var qty_var = '#'+pid;
	var error_msg = '.error_msg'+pid;	 
	
	// $(sereal_var).remove();
	if(poqty >= qty){		
		for(i=1; i<=qty; i++){
			var wupc_concat = wupc+i;
			$(sereal_var).append('<div class="form-group row"> <label class="col-sm-2 col-form-label" for="product_catname">Serial Number-'+i+'</label> <div class="col-sm-6"> <input type="text" placeholder="Product Warehouse Description" class="form-control margin-bottom" name="sl['+pid+'][]" value="'+wupc_concat+'"> </div> </div>');
		}	
		$(error_msg).html('');
		$(qty_var).removeAttr("style");
	}else{
		$(error_msg).html("<span style='color:red'>Recieved qty should be less than equal to recieved qty</span>")
		$(qty_var).css('border','1px solid red');
	}
});
</script>

