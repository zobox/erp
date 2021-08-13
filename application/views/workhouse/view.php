<?php 
/* echo "<pre>"; 
print_r($records);
echo "</pre>"; */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Pending Job Work') ?>  <!--   <a href="<?php echo base_url('clientgroup/create') ?>"
                                                                    class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>  -->
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body" id="saman-row">

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Pdt Name') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
						<th><?php echo $this->lang->line('Assigned TL') ?></th>
						<th>Scan Qty</th>
                        <th><?php echo $this->lang->line('Select IEMI') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
					
                    <tbody>
						<?php $i=1; foreach($records as $key=>$row){ ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->product_name; ?></td>
							<input type="hidden" name="product_name" id="product_name"  value="<?php echo $row->product_name; ?>">
                            <td><?php echo $row->product_qty; ?></td>
                            <td>
								<select name="assign_name" id="assign_name-0" class="form-control b_input">
									<option value="">Select Assigned To</option>
									<?php foreach($teamlead as $key=>$lead){ ?>
										<option value="<?php echo $lead->id; ?>"><?php echo $lead->username; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="text" name="imei_qty[]" id="imei_qty<?php echo $row->id; ?>" class="imei_qty form-control" onChange="addmoreiemi(this.value,0);" value="1">
							<input type="hidden" name="available_qty" id="available_qty" class="available_qty" value="<?php echo $row->product_qty; ?>">
							</td>
                        <td>
                            <!--<select id="products_l" name="products_l[]" class="form-control required select-box"
                                multiple="multiple">
							</select>-->
							<input type="text" name="imei[]" id="imei-0" class="imei-0 form-control" value="">
							<div id="moreimei-0"></div>
                        </td>
                        <td class="add-row" >
							<button type="button" class="btn btn-success" aria-label="Left Align"
									id="job_work_setting">
								<i class="fa fa-plus-square"></i> 
							</button>
							<!--<a href="view" class="btn btn-success btn-xs sr"> Submit </a>-->
							<input type="button" name="submit" id="submit" class="btn btn-success btn-xs sr" onclick="assignTeamLead(0);" value="Submit">
						</td>
                        </tr>
						<?php $i++; } ?>
                        <tr class="last-item-row"></tr>
					</tbody>
					
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Pdt Name') ?></th>
                        <th><?php echo $this->lang->line('QTY') ?></th>
						<th><?php echo $this->lang->line('Assigned TL') ?></th>
						<th>Scan Qty</th>
                        <th><?php echo $this->lang->line('Select IEMI') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#cgrtable').DataTable({responsive: true});

        });
    </script>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Discount'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">
                        <p>
                            <?php echo $this->lang->line('you can pre-define the discount') ?>
                        </p>
                        <input type="hidden" id="dobject-id" name="gid" value="">


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="pmethod"><?php echo $this->lang->line('Discount') ?></label>
                                <input name="disc_rate" class="form-control mb-1" type="number"
                                       placeholder="Discount Rate in %">


                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="clientgroup/discount_update">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Customer Group') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this customer group') ?></p>
                </div>
                <div class="modal-footer">
					<input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="clientgroup/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
	
	
    <script type="text/javascript">
        $(document).on('click', ".discount-object", function (e) {
            e.preventDefault();
            $('#dobject-id').val($(this).attr('data-object-id'));
            $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
            $('#pop_model').modal({backdrop: 'static', keyboard: false});
        });
    </script>
       <script type="text/javascript">
        $("#products_l").select2();
        $("#assign_name").on('change', function () {			
            var tips = $('#assign_name').val();
            $("#products_l").select2({

                tags: [],
                ajax: {
                    url: baseurl + 'workhousejob/getiemi?issue_id=' + <?php echo $this->input->get('id'); ?>,
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (product) {

                        return {
                            product: product,
                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash

                        };
                    },
                    processResults: function (data) {
						console.log(data);
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.serial,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        });
    </script>
	
<script> 
$('#job_work_setting').on('click', function () {    
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
	
	var available_qty = $('#available_qty').val();
	var totalqty = 0;
	$("input[name='imei_qty[]']").each(function() {
		//totalqty.push($(this).val());
		totalqty += parseInt($(this).val());
	});

	var product_name = $('#product_name').val();

	//product row
	if(totalqty<available_qty){
		var data = '<tr><td>1</td><td>'+product_name+'</td><td>1</td><td><select name="assign_name" id="assign_name" class="form-control b_input"><option value="">Select Assigned To</option><?php foreach($teamlead as $key=>$lead){ ?><option value="<?php echo $lead->id; ?>"><?php echo $lead->username; ?></option><?php } ?></select></td><td><input type="text" name="imei_qty[]" id="imei_qty" class="imei_qty form-control" onChange="addmoreiemi(this.value,'+cvalue+');" value="1">	</td><td><input type="text" name="imei[]" id="imei-'+ cvalue + '" class="imei-'+ cvalue +' form-control" value=""><div id="moreimei-'+ cvalue + '"></div></td><td><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> <a href="view" class="btn btn-success btn-xs sr"> Submit </a></td></tr>';
    }else{
		alert('Quantity not more than ' + available_qty);
	}
	//ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

	//alert(cvalue); 

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


<script>
function addmoreiemi(qty,numrow){	
	//alert(qty);
	//alert(numrow);
	var totalqty = 0;
	$("input[name='imei_qty[]']").each(function() {
		//totalqty.push($(this).val());
		totalqty += parseInt($(this).val());
	});
	//alert(totalqty);

	var available_qty = $('#available_qty').val();	
	if(totalqty<=available_qty){
		var str = '';
		for(i=1; i<qty; i++){
			str += '<br><input type="text" name="imei[]" id="imei" class="imei-'+numrow+'" value="">';
		}
		
		$('#moreimei-'+numrow).html(str);
	}else{
		alert('Quantity not more than ' + available_qty);
	}
}



function assignTeamLead(str){
	var assign_name = $('#assign_name-'+str);
	var teamlead_id = $(assign_name).val();
	//alert(teamlead_id);
	if(teamlead_id!=''){
		var iemi_var = '.imei-'+str;
		var iemi = [];
		$(iemi_var).each(function() {
			//var iemi = $(this).val();	
			iemi.push($(this).val());
		});
		//console.log(iemi);
		$.ajax({
			url: baseurl + 'workhousejob/assignteamlead',
			//dataType: "json",
			method: 'post',
			data: 'iemi=' + iemi + '&teamlead_id=' + teamlead_id +'&id=' + <?php echo $this->input->get('id'); ?>,
			success: function (data) {
				console.log(data);
				location.reload();
			}
		});
	}else{
		alert('please select TeamLead');
	}
}

</script>