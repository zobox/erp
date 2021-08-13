<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <div class="card card-block">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align:center"><?php echo $this->lang->line('Comission Wallet') ?></h3>
                    <p style="text-align:center"><strong><?php echo $this->lang->line('Current Commission Wallet Balance') ?> &#8377; <?php echo $total_commission; ?></strong><br></p>
                    <table id="commission_wallet" class="cell-border example1 table table-striped table1 delSelTable">
                        <thead>
                        <tr>                            
							<th><?php echo $this->lang->line('Date') ?></th>
							<th><?php echo $this->lang->line('Commission Invoice No') ?></th>
							<th>Credit</th>							
							<th>Debit</th>			
							<th>Closing Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
							<th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('No') ?></th>
                            <th><?php echo $this->lang->line('No') ?></th>                            
                            <th><?php echo $this->lang->line('customer') ?></th>                            
                            <th><?php echo $this->lang->line('Amount') ?></th>                           
                           
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

 
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#commission_wallet').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('commission_wallet/ajax_list')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });

    });
</script>
