<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;	
}


?>
<div class="content-body">
    <div class="card">
    <div class="card-header pb-0">
            <h5>Lead Location Approval</h5>
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
            <hr>
            <div class="card-body">

				
                <div class="table-responsive">
                    <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
					<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Source</th>
									<th>Date</th>
									<th>State</th>
									<th>City</th>
									<th>Pincode</th>
									<th>Shop Type</th>
									<th>RSM/ Agent Name</th>
									<th>RSM/ Agent Phone No.</th>
									<th>Status</th>
								</tr>
							</thead>
                        <tbody>
						<?php
						$i =0;
						//$lead = json_decode(json_encode($lead));
						/* echo "<pre>";
						print_r($lead);
						echo "</pre>"; */
						
						foreach($lead as $lead_list)
						{
                             $i++;
                             //echo $lead_list->source;
						?>					
					<tr>
                        <td style=" padding-top: -1.75rem; padding-right: 1rem; padding-bottom: -1.75rem; padding-left: 1rem;"><?=$i?></td>
						<td style=" padding-top: -1.75rem; padding-right: 1rem; padding-bottom: -1.75rem; padding-left: 1rem;"> <?=$lead_list->name; ?></td>                        
                        <td style=" max-width: 180px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;padding: 5px;"><?=$lead_list->email; ?></td>
							
                        <td style="max-width: 130px;  padding: 10px;"><?=$lead_list->mobileno; ?></td>
                        <!--<td><?php echo $lead_data->business_address; ?></td>-->						
                        <td style="max-width:90px; padding:10px;"><?php echo ($lead_list->source_info == 'Agent') ? '<a href="'.base_url().'agency/view/'.$lead_list->agency_id.'" target="_blank">Agent</a>': 'Direct';?></td>
                        <td style="max-width: 150px;
						white-space: nowrap; padding: 10px;"><?php $date = explode(" ",$lead_list->date); echo date("d M, Y", strtotime($date[0]))."<br>".$date[1];?></td>
                        <td style=" padding-top: -1.75rem; padding-right: 1rem; padding-bottom: -1.75rem; padding-left: 1rem;"><?=$lead_list->state; ?>	</td>
                        <td style=" padding-top: -1.75rem; padding-right: 1rem; padding-bottom: -1.75rem; padding-left: 1rem;"><?=$lead_list->city; ?></td>
                        <td  style=" max-width:80px; padding: 15px;"><?=$lead_list->pincode; ?></td>
                        <td style="max-width:90px; padding:18px;"><?php if($lead_list->shop_type !=''){ echo ($lead_list->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
                        <td style="max-width:90px; padding:18px;"><?php echo ($lead_list->source == 'Agent') ? $lead_list->agent_name : $lead_list->rsm_name;?></td>
                        <td style="max-width:90px; padding:18px;">
						<?php echo ($lead_list->source == 'Agent') ? $lead_list->contact_no : $lead_list->rsm_phone;?></td>
                        <td style="width:150px; padding:18px;">
							<select id="status" class='form-control updateStatus' style="width:150px;" name="status[<?php echo $lead_list->id; ?>]" <?php if($lead_list->verification_status!=0){ ?> disabled <?php } ?>> 
								<option value="">Select Status</option>
								<option value="<?=$lead_list->id.'-0'?>" <?php if($lead_list->verification_status==0) echo 'selected';?>>New</option>
								<option value="<?=$lead_list->id.'-1'?>" <?php if($lead_list->verification_status==1) echo 'selected';?>>Approved</option>
								<option value="<?=$lead_list->id.'-2'?>" <?php if($lead_list->verification_status==2) echo 'selected';?>>Not Approved</option>
							</select>
						</td>
					</tr>					
					<?php  } ?>
					</tbody>
                        <tfoot>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Source</th>
									<th>Date</th>
									<th>State</th>
									<th>City</th>
									<th>Pincode</th>
									<th>Shop Type</th>
									<th>RSM/ Agent Name</th>
									<th>RSM/ Agent Phone No.</th>
									<th>Status</th>
								</tr>
							</tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>



<!-- Modal -->
 <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel"></h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>





<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Delete Franchise</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                   <input type="hidden" class="form-control"
                           id="object-id" name="deleteid" value="0">
                <input type="hidden" id="action-url" value="leads/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Email Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNowSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
    </div>

    
	<div id="sendSmsS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('SMS Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendsms_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="message" class="form-control" rows="3" cols="60"></textarea></div>
                    </div>


                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendSmsSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
    </div>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });



        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('leads/load_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash <?php if ($due) echo ",'due':true" ?> }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ],
        });


        $(document).on('click', "#delete_selected", function (e) {
            e.preventDefault();
                if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            alert($(this).attr('data-lang'));
            jQuery.ajax({
                url: "<?php echo site_url('leads/delete_i')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&<?=$this->security->get_csrf_token_name()?>=' + crsf_hash + '<?php if ($due) echo "&due=true" ?>',
                  dataType: 'json',
                success: function (data) {
                    $("input[name='cust[]']:checked").closest('tr').remove();
                       $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });


        //uni sender
$('#sendMail').on('click', '#sendNowSelected', function (e) {
       e.preventDefault();
         $("#sendMail").modal('hide');
                 if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('leads/sendSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendmail_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});

$('#sendSmsS').on('click', '#sendSmsSelected', function (e) {
       e.preventDefault();
         $("#sendSmsS").modal('hide');
                     if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('leads/sendSmsSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendsms_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});



    });


</script>
<script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#cgrtable').DataTable({responsive: true});
        });
    </script>


<script>



$(".assignLead").change(function(){		
	var assignto = $(this).val();
	//alert(assignto);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/assignLead')?>",
		data : {assignto : assignto},
		cache : false,
		success : function(data)
		{	
			console.log(data);
			//alert("sucess"+data);			
		}
	});
});


$(".updateStatus").change(function(){		
	var status = $(this).val();	
	//alert(status);
	var status1 = status.split('-');
	
	$.ajax({		
		type : "POST",		
		url: "<?php echo site_url('tools/updatestatus')?>",
		data : {status : status},
		cache : false,
		success : function(data)
		{
			//console.log(data);
			switch(status1[1])
			{
				case "0":
					swal("Status updated to", "New", "success");
					break;
				case "1":
					swal("Status updated to", "Approved", "success");
					break;
				case "2":
					swal("Status updated to", "Not Approved", "success");
					break;
			}
			location.reload();
		}
	});
});


$(".view_log").click(function(){		
	var lead_id = $(this).val();
	//alert(lead_id);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/viewLog')?>",
		data : {lead_id : lead_id},
		cache : false,
		success : function(data)
		{	
			 $("#getCodeModal").modal("toggle");
			 $("#getCode").html(data);			
		}
	});
});


$(".statusCounts").change(function(){		
	var emp_id = $(this).val();
	//alert(emp_id);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('leads/statusCounts')?>",
		data : {emp_id : emp_id},
		cache : false,
		success : function(data)
		{	
		    res = data.split("-");				
			 $("#Newcnt").html(res[0]);			
			 $("#Contactedcnt").html(res[1]);			
			 $("#Qualifiedcnt").html(res[2]);			
			 $("#Proposalcnt").html(res[3]);			
			 $("#Covertedcnt").html(res[4]);			
			 $("#notCovertedcnt").html(res[5]);			
		}
	});
});


function statusFiter(str){
	$('#statusF').val(str);		
	$( "#fromfilter" ).submit();
}
</script>






<!--<div class="container">
	<div class="content-body">
    <div class="card">
		<div class="row" style="margin-top:30px" >
		  <table  class="table table-striped table-bordered zero-configuration" cellspacing="0" width="70%">
					   
					<thead>  
					<!--<tr>	
						<td style="text-align:right"><input type="hidden" name="submit" value="update1"></td>
						<td colspan="10" style="text-align:right"><input class="btn btn-primary" type="submit" name="submitsss" value="update"></td>
						
					</tr>-->
					<!--</thead>
					
					<thead>
						<tr style="text-align:center;">
                        <th style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;">#</th>
                        <th>Name</th>                        
                        <th>Email</th>
                        <th>Mobile</th>
                        <th style="max-width:90px; padding:10px;">Source</th>
                        <th style="max-width: 100px;
    white-space: nowrap;">Date</th>
                        <th>State</th>
                        <th>City</th>
                        <th style=" max-width:90px; padding: 10px;">Pincode</th>
                        <th style="max-width:90px; padding:10px;">Shop Type</th>
                        <th style="max-width:90px; padding:10px;">RSM/ Agent Name</th>
                        <th style="max-width:90px; padding:10px;">RSM/ Agent Phone Number</th>
                                                
						<th>Status</th>
					</tr>
					</thead>				
					
					<tbody>
					<?php 
						
						for($i=1;$i<6;$i++)
						{

					?>					
					<tr>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;"><?=$i?></td>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;">Devendra</td>                        
                        <td style=" max-width: 180px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;padding: 5px;">devendra.cartnyou@gmail.com</td>
                        <td style="max-width: 130px;  padding: 10px;">8527626445</td>
                        <!--<td><?php echo $lead_data->business_address; ?></td>-->			<!--			
                        <td style="max-width:90px; padding:10px;">Direct</td>
                        <td style="max-width: 150px;
    white-space: nowrap; padding: 10px;">14 Jan, 2021
07:19:18</td>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;">Andhra Pradesh	</td>
                        <td style=" padding-top: -1.75rem;
    padding-right: 1rem;
    padding-bottom: -1.75rem;
    padding-left: 1rem;">kasjndkasnd</td>
                        <td  style=" max-width:80px; padding: 15px;">736146</td>
                        <td style="max-width:90px; padding:18px;">Owned</td>
                        <td style="max-width:90px; padding:18px;">JAYDEEP</td>
                        <td style="max-width:90px; padding:18px;">+919732212158	</td>
						
                        
						
						
					</tr>					
					<?php  } ?>
					</tbody>
                </table>
            </div>
        </div>
    </div>

</div>