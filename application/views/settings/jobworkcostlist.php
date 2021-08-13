<div class="content-body">
    
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $title; ?> <a
                        href="<?php echo base_url('settings/job_work_cost?action='.$action) ?>"
                        class="btn btn-info rounded small-button">
                    <?php echo $this->lang->line('Set Cost') ?>
                </a> 
				<a
                        href="<?php echo base_url('settings/job_work_cost_excel?action='.$action) ?>"
                        class="btn btn-success rounded small-button">
                    <?php echo $this->lang->line('Download Excel') ?>
                </a>	
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
                        <th>#</th>

                        <th><?php echo $this->lang->line('Product Name') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>                                               
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					
					<?php foreach($records as $key=>$row){ ?>
                    <tr>
                        <td>#</td>
                        <td><?php echo $row->products->product_name; ?></td> 
                        <td><?php echo $row->products->category_name; ?></td> 
                        <td>
                        <a href="<?php echo base_url();  ?>settings/edit_job_work_cost?action=refurbishment&amp;type=category&amp;pid=<?php echo $row->pid; ?>" class="btn btn-warning btn-xs"><i class='fa fa-pencil'></i>
								<?php echo $this->lang->line('Edit') ?></a>
                        </td>
                    </tr>                 
                    <?php } ?>
					
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>

                        <th><?php echo $this->lang->line('Product Name') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>                                               
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