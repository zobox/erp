<article class="content">
    <div class="card card-block">
	
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		
		<div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Pending Inventory') ?> </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card card-block">


            <!--<form method="post" id="data_form" class="card-body" action="<?php echo  base_url(); ?>purchase/addmanual">-->
            <form method="post" id="data_form" class="card-body">                
				<?php 	

				/* echo "<pre>";
				print_r($Fdata);
				echo "</pre>"; */
						
				foreach($Fdata as $key2=>$row){ 				
				if($pid==$row->pid){
					$product_name = '';
				}else{
					$product_name = $row->product_name;
				}
				$pid = $row->pid;
				?>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label"
                           for="product_catname"><?php echo $product_name; ?></label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Product Warehouse Description" class="form-control margin-bottom" name="sl[<?php echo $row->id; ?>][]" value="<?php echo $row->serial; ?>">	
                    </div> 
					<div class="col-sm-2">
						<input type="button" id="recieve-<?php echo $row->id; ?>" class="btn btn-success margin-bottom recieve"  value="<?php echo $this->lang->line('Yes') ?>">
						<!--<input type="button" id="not_recieve-<?php echo $row->id; ?>" class="btn btn-danger margin-bottom not_recieve" value="<?php echo $this->lang->line('No') ?>">-->
					</div>					
                </div>
				<?php }  ?>				
            </form>
        </div>
    </div>
</article>
     

<script>
$(".recieve").click(function(){		
	var status = $(this).val();
	var sid = $(this).attr("id");
	var sid_arr = sid.split('-');
	var id = sid_arr[1];
	
	//alert(status);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('productcategory/recieve_serial')?>",
		data : {id : id},
		cache : false,
		success : function(data)
		{	
			swal("Serial Number Recieved", " ", "success");
			location.reload();
		}
	});
});


$(".not_recieve").click(function(){		
	var status = $(this).val();
	var sid = $(this).attr("id");
	var sid_arr = sid.split('-');
	var id = sid_arr[1];
	
	//alert(status);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('productcategory/not_recieve')?>",
		data : {id : id},
		cache : false,
		success : function(data)
		{	
			swal("Serial Number Not Recieved", " ", "warning");			
			location.reload();
		}
	});
});
</script>