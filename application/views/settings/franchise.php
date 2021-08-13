<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <h5 class="title">
                Module 
            </h5>

            <p>&nbsp;</p>
            <table class="table display" cellspacing="0" width="100%" style="border-top: 2px solid #e3ebf3;">
                <thead>
                <tr>
                    <th style="border:none;"><?php echo $this->lang->line('Module') ?></th>                                     
                    <th style="border:none;" class="left"><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </thead>
                <tbody>                
					<?php 					
					foreach($franchise as $franchise_data){
					?>
					<tr>
                    <td>					
					<strong><?php 
						switch($franchise_data->module){
							case 1: $module = 'Enterprise';
							break;
							case 2: $module = 'Professional';
							break;
							case 3: $module = 'Standard';
							break;
						}
						echo $module;
					?></strong>					
					</td>                   
                    <td><a href="<?php echo base_url('settings/updatefranchise?id=').$franchise_data->id; ?>" class="btn btn-primary btn-sm rounded left"> <?php echo $this->lang->line('Edit') ?> </a></td>
                    </tr>
					<?php } ?>                       
                
                </tbody>

            </table>
        </div>
    </div>
</article>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="settings/taxslabs_delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>