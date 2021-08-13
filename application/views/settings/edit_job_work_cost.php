<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal" action="<?php echo base_url(); ?>settings/edit_job_work_cost">

                
				
				<div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row mb-0">
                                    <div class="fcol-sm-12">
                                        <h4 class="card-title"> Product Job Card Details </h4>
                                    </div>
                                </div>

                                <div class="form-group row">
										<div class="col-md-4 mb-2"> Hindizo Product Name </div>
										<div class="col-md-6"> <?php echo $records[0]->products->product_name; ?> </div>
									
                                    <div class="col-md-4 mb-2"> Category Name </div>
										<div class="col-md-6"> <?php echo $records[0]->products->category_name; ?> </div>

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
							
							<?php foreach($records as $key=>$row){ ?>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="component_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='component_name-0' style="text-align:left !important;" value="<?php echo $row->component_name; ?>">
                                </td>
                                <td><input type="text" class="form-control req amnt" name="ok_to_superb_cost[]" id="ok_to_superb_cost-0"                                           
                                           autocomplete="off" value="<?php echo $row->ok_to_superb_cost; ?>"></td>
                                <td><input type="text" class="form-control req prc" name="ok_to_good_cost[]" id="ok_to_good_cost-0"                                           
                                           autocomplete="off" value="<?php echo $row->ok_to_good_cost; ?>"></td>
                                <td><input type="text" class="form-control vat " name="good_to_good_cost[]" id="good_to_good_cost-0"                                           
                                           autocomplete="off" value="<?php echo $row->good_to_good_cost; ?>"></td>
                                <td><input type="text" class="form-control vat " name="good_to_superb_cost[]" id="good_to_superb_cost-0"                                           
                                           autocomplete="off" value="<?php echo $row->good_to_superb_cost; ?>"></td>
                                <td><input type="text" class="form-control vat " name="good_to_excellant_cost[]" id="good-to-excellant-cost-0"                                           
                                           autocomplete="off" value="<?php echo $row->good_to_excellant_cost; ?>"></td>
                                <td></td>
                                <td></td>
                            </tr>
							
							<input type="hidden" name="id[]" id="id-<?php echo $row->id; ?>" value="<?php echo $row->id; ?>">
                            <?php } ?>

                             <tr class="last-item-row">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="job_work_setting">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Submit') ?>" data-loading-text="Adding...">
							   <input type="hidden" value="settings/edit_job_work_cost" id="action-url">
							   <input type="hidden" name="pid" value="<?php echo $row->pid; ?>" id="pid">
                                </td>

                                <td colspan="7"></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
    </div>
</article>

<script>
 
$('#job_work_setting').on('click', function () {
    
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td><input type="text" class="form-control" name="component_name[]" placeholder="Enter Component name or Code" id="component_name-' + cvalue + '"></td>	<td><input type="text" class="form-control req amnt" name="ok_to_superb_cost[]" id="ok_to_superb_cost-' + cvalue + '" autocomplete="off"  inputmode="numeric">	<input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td>	<td><input type="text" class="form-control req prc" name="ok_to_good_cost[]" id="ok_to_good_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td>	<td><input type="text" class="form-control req prc" name="good_to_good_cost[]" id="good_to_good_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td>	<td> <input type="text" class="form-control vat" name="good_to_superb_cost[]" id="good_to_superb_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" name="good_to_excellant_cost[]" id="good_to_excellant_cost-' + cvalue + '"  autocomplete="off" inputmode="numeric"></td><td></td>	<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0">  <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr></tr>';
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
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});



</script>