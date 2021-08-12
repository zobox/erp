<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;	
} ?>
<div class="content-body">
    <div class="card">  
        <div class="card-header pb-0">
            <h5>Manage Leads</h5>
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

				<div class="row">
				<div class="col-md-12">
				
				
				
				<?php 
					/*echo "<pre>";
					print_r(json_decode(json_encode($RSM_franchise_record),true));
					echo "</pre>";*/
				if($_SESSION['s_role']=='r_5'){ ?>
			   
			    <div class="row">
				<form name="lead" id="lead" method="post" action="<?php echo base_url(); ?>franchise/update">
				<input type="hidden" name="updatelead" id="updatelead" value="update">
				<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $_SESSION['id']; ?>">
                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
					  
					
					<thead>
					<tr>
                        <th>#</th>
                        <th style="width:145px;">Name</th>                        
                        <th style="width:280px;">Email</th>
                        <th>Mobile</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th style="width:145px;">State</th>
                        <th style="width:175px;">City</th>
                        <th>Pincode</th>
                        <th>Shop Type</th>	
					</tr>
					</thead>
					
					<tbody>
					<?php 			
					$i=1;
					foreach($franchise_record as $lead_data){ ?>					
					<tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $lead_data->name; ?></td>                        
                        <td><?php echo $lead_data->email;?></td>
                        <td><?php echo $lead_data->mobileno;?></td>                       					
                        <td><?php echo $lead_data->source;?></td>
                        <td><?php $date = explode(" ",$lead_data->date);echo date("d M, Y", strtotime($date[0]))."<br>".$date[1];?></td>
                        <td><?php echo $lead_data->state_name; ?></td>
                        <td><?php echo $lead_data->city; ?></td>
                        <td><?php echo $lead_data->pincode; ?></td>
                        <td><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
					</tr>						
					<?php $i++; } ?>
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
					</tr>
                    </tfoot>
                </table>
				</form>
				</div>
				
				<?php } else{ ?>
				
				<div class="row">
				<form name="lead1" id="lead1" method="post" action="<?php echo base_url(); ?>franchise/updatestatus">
				<!--<input type="hidden" name="updatelead" id="updatelead" value="update">-->
				<input type="hidden" name="logged_user_id" id="logged_user_id" value="<?php echo $_SESSION['id']; ?>">
                <table  class="table table-striped table-bordered zero-configuration" cellspacing="0" width="90%">
					   
									
					<thead>
						<tr>
                        <th>#</th>
                        <th>Name</th>                        
                        <th> Email</th>
                        <th>Mobile</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Pincode</th>
                        <th>Shop Type</th>  
						<th>RSM</th>                        
						<th>Action</th>
						<?php if($this->aauth->premission(5) ==1){ ?>
						<th>Partial Active</th>
						<?php } ?>
					</tr>
					</thead>				
					
					<tbody>
					<?php $i=1; 
						foreach($RSM_franchise_record as $lead_data){ ?>					
					<tr>
                        <!-- <td style="padding:10px!important;max-width: 30px;"><?php echo $i; ?></td> -->
                        <td><?php echo $i; ?></td>
                        <td ><?php echo $lead_data->name; ?></td>                        
                        <td><?php echo $lead_data->email;?></td>
                        <td><?php echo $lead_data->mobileno;?></td>
                        <!--<td><?php echo $lead_data->business_address; ?></td>-->						
                        <td><?php echo $lead_data->source;?></td>
                        <td><?php $date = explode(" ",$lead_data->date);echo date("d M, Y", strtotime($date[0]))."<br>".$date[1];?></td>
                        <td><?php echo $lead_data->state_name; ?></td>
                        <td><?php echo $lead_data->city; ?></td>
                        <td><?php echo $lead_data->pincode; ?></td>
                        <td><?php if($lead_data->shop_type!=''){ echo ($lead_data->shop_type==1) ?"Owned" : "Rented"; }else{ echo "N/A"; }?></td>
						<td><?php echo $lead_data->assign_name;?></td>
						<td>
						<?php $disabled = ''; if($lead_data->add_status==1){ ?>
						<a href="<?php echo base_url();?>franchise/view?id=<?php echo $lead_data->id; ?>" class="btn btn-info btn-sm"><span class="fa fa-eye" style="margin-right: -5px;"></span >  View</a> <a href="<?php echo base_url();?>franchise/edit?id=<?php echo $lead_data->id; ?>" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>Edit</a>
						<?php }else{ $disabled = 'disabled'; ?>
						<a href="<?php echo base_url();?>franchise/edit?id=<?php echo $lead_data->id; ?>" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>Add</a><?php } ?></td>
						<?php if($this->aauth->premission(5) ==1){ ?>
						<td>
							<input type="checkbox" class="activateFran" id="activate<?php echo $lead_data->id; ?>" name="activate<?php echo $lead_data->id; ?>" value="<?php echo $lead_data->id;?>" <?php if($lead_data->partial_active == 1){?>checked="checked"<?php }  echo $disabled; ?> />
						</td>
						<?php } ?>
					</tr>					
						<?php  $i++; } ?>
					</tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>                        
                        <th> Email</th>
                        <th>Mobile</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Pincode</th>
                        <th>Shop Type</th>  
						<th>RSM</th>                        
						<th>Action</th>
						<?php if($this->aauth->premission(5) ==1){ ?>
						<th>Partial Active</th>
						<?php } ?>
					</tr>
                    </tfoot>
                </table>
				</form>
				</div>				
				<?php } ?>
				
				</div>
				<div>
				
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#cgrtable').DataTable({responsive: true});
        });
    </script>

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

                <h4 class="modal-title">Delete Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                   <input type="hidden" class="form-control"
                           id="object-id" name="deleteid" value="0">
                <input type="hidden" id="action-url" value="franchise/delete_i">
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
                'url': "<?php echo site_url('franchise/load_list')?>",
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
                url: "<?php echo site_url('franchise/delete_i')?>",
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
                url: "<?php echo site_url('franchise/sendSelected')?>",
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
                url: "<?php echo site_url('franchise/sendSmsSelected')?>",
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



<script>



$(".assignLead").change(function(){		
	var assignto = $(this).val();
	//alert(assignto);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('franchise/assignLead')?>",
		data : {assignto : assignto},
		cache : false,
		success : function(data)
		{	
			//console.log(data);
			//alert("sucess"+data);			
		}
	});
});


$(".updateStatus").change(function(){		
	var status = $(this).val();
	//alert(status);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('franchise/updateStatus')?>",
		data : {status : status},
		cache : false,
		success : function(data)
		{	
			//console.log(data);
			//alert("sucess"+data);			
		}
	});
});


$(".view_log").click(function(){		
	var lead_id = $(this).val();
	//alert(lead_id);
	$.ajax({
		type : "POST",		
		url: "<?php echo site_url('franchise/viewLog')?>",
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
		url: "<?php echo site_url('franchise/statusCounts')?>",
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
$('.activateFran').click(function(){
	var id = $(this).val();
	$.ajax({
		type : 'POST',
		url : '<?php echo site_url('franchise/partialActivate')?>',
		data : {franchiseId : id},
		cache : false,
		success : function(result){
			/*alert(result);*/
			if(result == 1){
				swal("","Franchise partially activated successfully.","success");
			}
			else{
				swal("","Franchise partially deactivated successfully.","warning");
			}
		}
	});
});
</script>

