<div class="content-body">
    
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo 'Pending Franchise' ?></h5>
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


                <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th><?php echo "Supplier" ?></th>
                        <th>Franchies Name</th>
                        
                        <th><?php echo $this->lang->line('Warehouse ID') ?></th>
                        <th>Action</th>
						<th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                 
                       for($i=0;$i<count($result);$i++)
                       {
                            ?>
                       
                        
					<tr>
						<td><?=$result[$i]['invoicedate']?></td>
						<td><?php echo prefix(2) . $result[$i]['tid']; ?></td>
						<td><a href=<?=base_url();?>supplier/view?id=<?=$result[$i]['sid']?> target="_blank"> <?=$result[$i]['name']?></a></td>
						<td><?=$result[$i]['franchise_code']?></td>
						<td><?=$result[$i]['warehouse_code']?></td>
						<td><a href="<?php echo base_url()?>asset/view?id=<?php echo $result[$i]['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i><?php echo $this->lang->line('View'); ?></a></td>
						<td> <select class="form-control margin-bottom required pstatus"  id="status" name="status" required>
              <option value="0-<?=$result[$i]['id']?>" <?php if($result[$i]['franchies_status']==0) echo 'selected'; ?>>Pending Recieve</option>
              <option value="1-<?=$result[$i]['id']?>" <?php if($result[$i]['franchies_status']==1) echo 'selected'; ?>>Received</option></select></td>
					</tr>
                <?php } ?>
					
                    </tbody>
                    <tfoot>
                        <tr>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th><?php echo "Supplier" ?></th>
                        <th>Franchies Name</th>
                        
                        <th><?php echo $this->lang->line('Warehouse ID') ?></th>
                        <th>Action</th>
						<th><?php echo $this->lang->line('Settings') ?></th>
                        </tr>
                    </tfoot>
                   
                </table>

            </div>
            <input type="hidden" id="dashurl" value="products/prd_stats">
      
        <div id="delete_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $this->lang->line('delete this product') ?></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id" value="">
                        <input type="hidden" id="action-url" value="products/delete_i_bundle">
                        <button type="button" data-dismiss="modal" class="btn btn-primary"
                                id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div id="view_model" class="modal  fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="view_object">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="view-object-id" value="">
                        <input type="hidden" id="view-action-url" value="products/view_over_bundle">

                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Close') ?></button>
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
    <script>
        $(".pstatus").change(function(){       
            var get_status = $(this).val();
            var get_st = get_status.split('-');
            var status = get_st[0];
            var id = get_st[1];

            $.ajax({        
                type : "POST",      
                url: baseurl+'asset/update_order_status',
                data : {status : status, id : id},
                cache : false,
                success : function(data)
                {
                    console.log(data);
                    switch(status)
                    {
                        case "0":
                            swal("Status updated to", "Pending Recieve", "success");
                            break;
                        case "1":
                            swal("Status updated to", "Received", "success");
                            break;
                        
                    }
                    location.reload();
                }
                });
            });
    </script>