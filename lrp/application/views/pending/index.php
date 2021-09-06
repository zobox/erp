<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="col-md-12">
          <h3 class="box-title"><?php echo "Pending Receives"; ?></h3>
          <div class="row" style="padding: 5px;">
		 
            
          </div>
		  <form class="row" action="" method="post" style="margin: 5px; padding:5px;">
		  	
			
		  </form>
		  <?php //echo "<pre>";print_r($lead);?>
          <table class="table table-striped table-bordered zero-configuration dataTable dtr-inline text-center" id="cgrtable">
            <thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Date</th>
					<th class="text-center">PO #</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">Total Qty</th>
					<th class="text-center">Pending Qty</th>
					<th class="text-center">Recieved Qty</th>
					<th class="text-center">Action</th>
				</tr>
            </thead>
            <tbody>
			<?php
			$i=1;
			foreach($list as $key=>$row){ 
				
				switch($row->type){
					case 1: $prefix = 'STFO#';
					break;
					case 2: if($row->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
					break;
					case 3: $prefix = 'STF#';
					break;
					case 4: $prefix = 'PO#';
					break;
					case 6: $prefix = 'B2B#';
					break;
					case 7: $prefix = 'STR#';
					break;
					case 8: $prefix = 'LRCIMEI#'; $item_type="IMEI";
					break;
					case 5: $prefix = 'LRCSP#'; $item_type="Sparepart";
					break;
				}			
			?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row->invoicedate; ?></td>
                <td><?php echo $prefix.$row->tid; ?></td>
                <td><?php echo $item_type; ?></td>
                <td><?php echo $row->items; ?></td>
				<td><?php echo $row->pending; ?></td>
				<td><?php echo $row->received; ?></td>
                <td><a href="<?php  echo base_url(); ?>pending/receive_view?id=<?php echo $row->id; ?>" class="btn btn-success btn-sm view-object"><span class="fa fa-eye"></span> View</a></td>
              </tr>
            <?php $i++; } ?> 
            </tbody>
			<tfoot>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Date</th>
					<th class="text-center">PO #</th>
					<th class="text-center">Item Type</th>
					<th class="text-center">Total Qty</th>
					<th class="text-center">Pending Qty</th>
					<th class="text-center">Recieved Qty</th>
					<th class="text-center">Action</th>
				</tr>
			</tfoot>
            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#cgrtable').DataTable({
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": true,
                    },
                ], dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    }
                ],

        });
        });
    </script>
<script type="text/javascript">
	$(document).ready(function(event){
		/*$('.source').change(function(){
			$.ajax({
				type : 'POST',
				data : {source : $('.source').val()},
				url : baseurl+'lead/changesource',
				cache : false,
				success : function(result){
					window.location.href = result;
				},
				error : function (jqXHR, textStatus, errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
			})
		});*/
	});
	$('.statusChange').change(function(event){
		var itsid = $(this).attr('id');
		itsid = itsid.split("chnage");
		itsid = itsid[1];
		var selectedValue = $(this).val();
		$.ajax({
			type : 'post',
			url : baseurl+'lead/changeStatus',
			data : {leadid : itsid, selectedStatus : selectedValue},
			cache : false,
			success : function(result){
				swal("",result,"success");
				$.ajax({
					type : 'POST',
					url : baseurl+'lead/getStatusHtml',
					data : {id : itsid},
					cache : false,
					success : function(data){
						$('#stauschnage'+itsid).html(data);
						setTimeout(function(){ location.reload(); }, 3000);
					},
					error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
				});
			},
			error : function(jqXHR,textStatus,errorThrown){
				 if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
			}
		});
		});
</script>
