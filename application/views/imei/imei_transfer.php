<?php //echo $this->aauth->get_user()->loc; exit; 
//echo BDATA; exit;
?>
<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <!--<form method="post" id="data_form">-->
                <form method="post" id="data_form" method="post" action="<?php echo base_url(); ?>imei/transfer">
                    <div class="row">
                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <h3 class="title">IMEI Transfer</h3>                                            
                                    </div>
                                </div>
                              
								
						
								
								<div class="form-group row col-sm-6"><label for=""
                                                                 class="caption"><?php echo $this->lang->line('Serial No'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Serial No" name="serial"                                                   
                                                   autocomplete="false" id="serialno">
                                        </div>
                                    </div>
								
								<div class="form-group row col-sm-6 mt-2" id="serial_details">
									
								</div>
								
								<div class="form-group row col-sm-6 mt-2" id='tow'>
								<!--<label for="" class="caption">Transfer To</label>
								<?php echo $this->lang->line('Warehouse') ?> <select
										id="s_warehouses" name="s_warehouses"
										class="form-control round">
									<option value="">--Select--</option>
									<?php foreach ($warehouse as $row) {
										echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
									} ?>

								</select>-->
								</div>
								
								
								<div class="form-group row" id='imei_transfer' style="display:none">
									<div class="col-sm-12 text-center">
										<div class="input-group text-center d-block">
											<input type="submit"
											 class="btn btn-success"
											 value="<?php echo $this->lang->line('Transfer') ?> "
											 id="submita-data" data-loading-text="Creating...">
											<input type="hidden" value="imei/transfer" id="action-url">
										</div>
									</div>
								</div>
                            </div>
                        </div>					
                </form>
            </div>
			
			
			

        </div>
    </div>
</div>


</div>

<script>
$('#serialno').change(function(){
	var serial = $(this).val();
	$.ajax({
		type : 'POST',
		url : baseurl+'imei/getwarehouseDropDown',			
		data : {serial:serial},		
		cache : false,
		success : function(result){				
			if(result!=null){
				//$('#imei_transfer').show();
				$( "#tow" ).html(result);				
			}else{				
				
			}
		}
	});
});

$('#serialno').change(function(){
	var serial = $(this).val();
	//alert(serial);
	$.ajax({
		type : 'POST',
		url : baseurl+'imei/getSerialDetails',			
		data : {serial:serial},		
		cache : false,
		success : function(result){		
			console.log(result);
			$('#serial_details').html(result);
		}
	});
});


</script>

