<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h5>Customers</h5>
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
      <div class="card-body">
        <table id="clientstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th><?php echo $this->lang->line('Name') ?></th>
              <th><?php echo $this->lang->line('Email') ?></th>
              <th><?php echo $this->lang->line('Phone') ?></th>
              <th><?php echo $this->lang->line('Address') ?></th>
              <th><?php echo $this->lang->line('Settings') ?></th>
            </tr>
          </thead>
          <tbody>
		  <?php $i = 1;
		  foreach($customer as $row){?>
		  	<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $row->name;?></td>
				<td><?php echo $row->email;?></td>
				<td><?php echo $row->phone;?></td>
				<td><?php echo $row->address;?></td>
				<td>
					<a href="<?php echo base_url()?>customers/viewCustomer?id=<?php echo $row->id;?>" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> View</a>
					<a href="#" data-object-id="<?php echo $row->id;?>" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>
				</td>
			</tr>
		  <?php $i++;} ?>
          </tbody>
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
        <p>Are you sure you want to delete this customer ? </p>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="object-id" value="">
        <input type="hidden" id="action-url" value="customers/delete_customer">
        <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
        <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
      </div>
    </div>
  </div>
</div>
