<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>

<div class="content-body">
  <div class="card">
    <div class="card-header pb-0">
      <h4 class="card-title">B2B Customer </h4>
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
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
      <hr>
      <div class="card-body">
	  	
        <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th><?php echo $this->lang->line('Name') ?></th>
			        <th><?php echo $this->lang->line('Email') ?></th>
              <th><?php echo $this->lang->line('Phone') ?></th>
			        <th><?php echo $this->lang->line('GST ID') ?></th>
              <th><?php echo $this->lang->line('Settings') ?></th>
            </tr>
          </thead>
          <tbody>
		  
			<?php 			
			$i=1;
			foreach($customer as $key=>$data){
			?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data->name; ?></td>
              <td><?php echo $data->email; ?></td>
              <td><?php echo $data->phone; ?></td>
              <td><?php echo $data->address; ?></td>
              <td><a href="<?php echo  base_url(); ?>customer/b2bview/<?php echo $data->id; ?>" class="btn btn-success btn-xs sr"><i class="fa fa-eye"></i> View</a></td>
            </tr>
            <?php $i++; } ?>
          </tbody>
          <tfoot>
          <tr>
              <th>#</th>
              <th><?php echo $this->lang->line('Name') ?></th>
			        <th><?php echo $this->lang->line('Email') ?></th>
              <th><?php echo $this->lang->line('Phone') ?></th>
			        <th><?php echo $this->lang->line('GST ID') ?></th>
              <th><?php echo $this->lang->line('Settings') ?></th>
            </tr>
          </tfoot>
        </table>
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