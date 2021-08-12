<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('QC Data') ?> </h4>
          <!--  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>  -->
           <!-- <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>  -->
			
	  <div class="form-group row">
			<label class="col-sm-2 col-form-label" for="product_catname"></label>        
      </div> 
	  
	  
	  <div class="form-group row">        
        <div class="col-sm-6"><a href="<?php echo base_url(); ?>quote/sample_qc" title="sample file" class="btn btn-warning btn-sm">Download Sample File</a> </div>
	  </div>
	  <div class="form-group row">
		<form method="post" id="data_form" class="card-body" enctype="multipart/form-data" action="<?php echo base_url();?>quote/import_qc">
		<div class="col-sm-6" style="margin-bottom:-10px;">   
			<input type="file" name="file" id="file">  
			<input type="submit" id="submit-data11" class="btn btn-success margin-bottom"
					   value="<?php echo $this->lang->line('Upload Sample File') ?>" data-loading-text="Adding...">
				<input type="hidden" value="quote/import_qc" id="action-url">
			<!--<a href="<?php echo base_url(); ?>leads/sample_lead" title="sample file" class="btn btn-primary btn-sm">Upload Sample File</a> -->
		</div>
		</form>
	  </div>
    
        </div>
		
		
		
		
        <div class="card-content">
            
            <div class="card-body">
              
                <hr>
                <table id="quotes" class="table table-striped table-bordered zero-configuration">
                    <thead>
						<tr>
							<th><?php echo $this->lang->line('Date & Time') ?>#</th>
							<th><?php echo $this->lang->line('Uploaded By') ?></th>
							<th class="no-sort"><?php echo $this->lang->line('Action') ?></th>                        
						</tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
						<th><?php echo $this->lang->line('Date & Time') ?>#</th>
						<th><?php echo $this->lang->line('Uploaded By') ?></th>
						<th class="no-sort"><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
</div>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this quote') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="quote/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#quotes').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('quote/ajax_qc_data_excel')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ],
            });
        };

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#quotes').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>