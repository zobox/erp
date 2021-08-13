<?php 
$closing_balance = 0;
$total_tds = 0;
foreach($list as $invoices){
	//echo $invoices->tds;
	if($invoices->type==2 || $invoices->type==6){
		$closing_balance += $invoices->franchise_commision;
		$total_tds += $invoices->tds;
	}else if($invoices->type==4){
		$total_tds -= $invoices->tds_deposite;
		$closing_balance -= $invoices->total;
		$closing_balance -= $invoices->tds_deposite;
	}
}
//echo $total_tds; exit;
?>

<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?> : <?php echo $details['name'] ?></h4>
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
		<?php 
		/* echo "<pre>"; 
		print_r($sum_list); 
		echo "</pre>";  */

		$amount = number_format($closing_balance, 2, '.', '');		
		$tds = number_format($total_tds, 2, '.', '');		
		
		?>
        <h2 class="text-xs-center">Current Balance
          is
          <?php echo  amountExchange($closing_balance, 0, $this->aauth->get_user()->loc) ?>
        </h2>
		 <h2 class="text-xs-center">Total TDS
          is
          <?php echo amountExchange($total_tds, 0, $this->aauth->get_user()->loc) ?>
        </h2>
      </div>
      <div class="card-body" style="padding-top: 0px;">
        <form method="post" id="data_form" class="form-horizontal">
          <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="id">
          <div class="form-group row" style="display: none;">
            <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>
            <div class="col-sm-3">
              <input type="number" placeholder="Enter amount in 0.00"
                                   class="form-control margin-bottom " name="amount">
            </div>
          </div>
          <div class="form-group row">
            
            <div class="col-sm-3">
              <button type="button" class="btn btn-success margin-bottom" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Deduct Balance</button>
              <input type="hidden" value="customers/commission_wallet_balance" id="action-url">
            </div>
          </div>
        </form>
        <h5 class="text-xs-center"><?php echo $this->lang->line('Payment History') ?></h5>
        <table class="table table-striped">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('Date') ?></th>
			  <th>Invoice No</th>
			  <th>Transaction No</th>
			  <th>Credit</th>
			  <th>Debit</th>
			  <th>Closing Balance</th>
			  <th>TDS</th>
              <th><?php echo $this->lang->line('Note') ?></th>
            </tr>
          </thead>
		 
          <tbody>
			<?php 
			
			/* echo "<pre>";
			print_r($list);
			echo "</pre>";  */
			
			foreach($list as $invoices){
			?>
           	<tr>
              <td><?php echo $invoices->invoicedate; ?></td>
			  <td><?php echo $this->config->item('prefix') . ' #' . $invoices->tid; ?></td>
			   <td><?php echo 'TRN#'.$invoices->transID;  ?></td>
			  <td><?php echo $invoices->franchise_commision; ?></td>
			  <td><?php echo $invoices->debit_amount; ?></td>
			  <td><?php echo amountExchange($closing_balance); ?></td>
			  <td><?php if($invoices->tds_deposite>0){ echo '-'.$tds1 = $invoices->tds_deposite; }else{ echo $tds1 = $invoices->tds; } ?></td>
              <td><?php echo $invoices->debit_note; ?></td>
            </tr>
			<?php 
				if($invoices->type==2 || $invoices->type==6){
					$closing_balance -= $invoices->franchise_commision;					
				}else if($invoices->type==4){
					$closing_balance += $invoices->total;
				}
			} ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Debit Payment Confirmation') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
      <div class="modal-body">
                <form method="post" id="data_form" class="form-horizontal" action="<?php echo  base_url(); ?>customers/commission_wallet_balance">
					<!--<div class="row">
                        <div class="col-sm-6 my-1">
                          <div class="input-group">
                                <label style="margin-top: 0px;">From Date</label>
                            </div>
                            <div class="input-group">
                                <input type="date" placeholder="End Date" class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt" id="interest_on_security_deposite_end_dt" value="1970-01-01">
                            </div>
                        </div>
                        <div class="col-sm-6 my-1">
                          <div class="input-group">
                                <label style="margin-top: 0px;">To Date</label>
                            </div>
                            <div class="input-group">
                                <input type="date" placeholder="End Date" class="form-control margin-bottom b_input required" name="interest_on_security_deposite_end_dt" id="interest_on_security_deposite_end_dt" value="1970-01-01">
                            </div>
                        </div>
                    </div>-->

                  

                    <div class="row">
                        <div class="col-sm-6 my-1">
                          <label for="shortnote">TDS Amount</label>
                            <input type="text" class="form-control" name="tds" placeholder="Short note" value="<?php echo $tds; ?>">
                        </div>
                        <div class="col-sm-6 my-1">
                          <label for="shortnote">Main Balance</label>
                            <input type="text" class="form-control" name="amount" placeholder="Short note" value="<?php echo $amount-$tds; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Bank">Bank</option>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="note" value="Payment for Franchise Commission #"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>                        
                        <!--<button type="button" class="btn btn-primary"
                                id="purchasepayment"><?php echo $this->lang->line('Do Payment') ?></button>-->
								
								   <input type="submit" id="submit-data11" class="btn btn-success margin-bottom"
										   value="<?php echo $this->lang->line('Do Payment') ?>" data-loading-text="Adding...">
									<input type="hidden" value="customers/commission_wallet_balance" id="action-url">
									 <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="id">
                    </div>
                </form>
            </div>

    </div>
  </div>
</div>