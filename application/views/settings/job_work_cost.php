<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" action="<?php echo base_url(); ?>settings/job_work_cost">

                    <div class="row">

                        <div class="col-sm-4">

                        </div>

                        <div class="col-sm-3"></div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-3">

                        </div>

                    </div>

                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill From') ?> <?php /*?><a href='#'
                                                                                            class="btn btn-primary btn-sm rounded"
                                                                                            data-toggle="modal"
                                                                                            data-target="#addCustomer">
                                                <?php echo $this->lang->line('Add Supplier') ?><?php */?>
                                            </a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-12">
										<label for="product_name" class="caption">Product Name</label>
										<input type="text" class="form-control calc api" name="product_name" id="product_name" placeholder="Enter HindiZo Product Name" />
										<input type="hidden" name="pid" id="pid" value="">
									  </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>


                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">
                            <thead>

                            <tr class="item_header bg-gradient-directional-amber">
                                <th width="25%" class="text-center"><?php echo $this->lang->line('Component Name') ?></th>
                                <th width="18%" class="text-center"><?php echo $this->lang->line('Ok To Superb Condition Cost') ?></th>
                                <th width="18%" class="text-center"><?php echo $this->lang->line('Ok To Good Condition Cost') ?></th>
                                <th width="18%" class="text-center">Ok To Excellant Cost</th>
                                <th width="18%" class="text-center"><?php echo $this->lang->line('Good To Superb Condition Cost') ?></th>
                                <th width="18%" class="text-center">Good To Excellant Cost</th>
                                <th width="18%" class="text-center"></th>
                                <th width="18%" class="text-center"></th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="component_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='component_name-0' style="text-align:left !important;">
                                </td>
                                <td><input type="text" class="form-control req amnt" name="ok_to_superb_cost[]" id="ok_to_superb_cost-0"                                           
                                           autocomplete="off" ></td>
                                <td><input type="text" class="form-control req prc" name="ok_to_good_cost[]" id="ok_to_good_cost-0"                                           
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control vat " name="good_to_good_cost[]" id="good_to_good_cost-0"                                           
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control vat " name="good_to_superb_cost[]" id="good_to_superb_cost-0"                                           
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control vat " name="good_to_excellant_cost[]" id="good_to_excellant_cost-0"                                           
                                           autocomplete="off"></td>
                                <td></td>
                                <td></td>
                                
                                
                            </tr>
                            

                            <tr class="last-item-row">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="job_work_setting">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Submit') ?>" data-loading-text="Adding...">
							   <input type="hidden" value="settings/job_work_cost" id="action-url">
                                </td>

                                <td colspan="7"></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>








<script>




$('#job_work_setting').on('click', function () {
    
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td><input type="text" class="form-control" name="component_name[]" placeholder="Enter Component name or Code" id="component_name-' + cvalue + '"></td>	<td><input type="text" class="form-control req amnt" name="ok_to_superb_cost[]" id="ok_to_superb_cost-' + cvalue + '" autocomplete="off"  inputmode="numeric">	<input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td>	<td><input type="text" class="form-control req prc" name="ok_to_good_cost[]" id="ok_to_good_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td>	<td><input type="text" class="form-control req prc" name="good_to_good_cost[]" id="good_to_good_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td>	<td> <input type="text" class="form-control vat" name="good_to_superb_cost[]" id="good_to_superb_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" name="good_to_excellant_cost[]" id="good_to_excellant_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td><td></td>	<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
			
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});


$(document).ready(function () {  
	$("#product_name").autocomplete({  
		source: function(request,response) {  
			$.ajax({  
				url : baseurl+'products/getProductRecords',  
				type: "POST",  
				dataType: "json",  
				data: { term: request.term },  
				success: function (data) {
					response($.map(data, function (item) { 
						$('#pid').val(item.pid);
						return { value: item.product_name };  
					}))  
				}  
			})  
		}
	});  
});



</script>


