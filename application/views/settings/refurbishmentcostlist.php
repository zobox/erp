<div class="content-body">
    
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Products') ?> <a
                        href="<?php echo base_url('settings/refurbishmentcost') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
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

            <div class="card-body">


                <table id="productstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
						<th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Product Name') ?></th>
						<th><?php echo $this->lang->line('Refurbishment Cost') ?></th>                        
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach($cat as $key=>$crow){ ?>
					<tr>
						<td>#</td>
						<td><?php echo $crow->parent_name; ?></td>
                        <td><?php //echo $prow->product_name; ?></td>						
                        <td><?php echo floatval($crow->refurbishment_cost); ?><?php if($crow->refurbishment_cost_type==1){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><input type="checkbox" name="chk[<?php echo $crow->id; ?>]" id='chk<?php echo $crow->id; ?>' value='1'></td>
					</tr>
					<?php foreach($crow->products as $key=>$prow){ ?>
					<tr>
						<td>#</td>
						<td><?php echo $prow->category_name; ?></td>
                        <td><?php echo $prow->product_name; ?></td>						
                        <td><?php echo floatval($prow->refurbishment_cost); ?><?php if($prow->refurbishment_cost_type==1){ echo ' (%)'; }else{ echo " (Fixed)"; } ?></td>
                        <td><input type="checkbox" name="chk[<?php echo $prow->pid; ?>]" id='chk<?php echo $prow->pid; ?>' value='1'></td>
					</tr>				
					<?php } ?>
					<?php } ?>					
					
                    </tbody>

                    
                </table>

            </div>            
        </div>
        