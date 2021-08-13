<?php 					
$closing_balance = 0;
foreach ($activity as $row) {	
	$closing_balance = $closing_balance-$row['debit'];	
	$closing_balance = $closing_balance+$row['credit'];	
} ?>

<div class="app-content content container-fluid">
    <div class="content-wrapper">


        <div class="content-body">
            <section class="card">
                <div class="card-block">
<h2 class="text-xs-center">Current Balance is <?= amountFormat($closing_balance) ?></h2>




                </div>
                <?php /*?><div class="card-block">
                    <form method="get" action="<?php echo substr(base_url(),0,-4) ?>billing/recharge">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" value="<?=base64_encode($this->session->userdata('user_details')[0]->cid) ?>" name="id">

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="amount"><?php echo $this->lang->line('Amount') ?></label>

                            <div class="col-sm-3">
                                <input type="number" placeholder="Enter amount in 0.00"
                                       class="form-control margin-bottom " name="amount">
                            </div>
                        </div>
                         <div class="form-group row ">
                                        <label for="gid" class="col-sm-2 col-form-label"><?php echo $this->lang->line('Payment Gateways') ?></label> <div class="col-sm-3">
                                        <select class="form-control" name="gid"><?php

                                            $surcharge_t = false;
                                            foreach ($gateway as $row) {
                                                $cid = $row['id'];
                                                $title = $row['name'];
                                                if ($row['surcharge'] > 0) {
                                                    $surcharge_t = true;
                                                    $fee = '(+' . amountFormat_s($row['surcharge']) . ' %)';
                                                } else {
                                                    $fee = '';
                                                }
                                                echo "<option value='$cid'>$title $fee</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>   </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"></label>

                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-lg btn-success">
                            </div>
                        </div>



                    </form>



                </div><?php */?>
                <h5 class="text-xs-center"><?php echo $this->lang->line('Payment History') ?></h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Date') ?></th>						
						<th>Transaction No</th>
						<th>Credit</th>
						<th>Debit</th>
						<th>Closing Balance</th>						
						<th><?php echo $this->lang->line('Note') ?></th>
                    </tr>
                    </thead>
                    <tbody id="activity">
                    <?php 
					//$closing_balance = $balance;
                    /*    echo '<tr>
                            <td>' . $row['date'] . '</td>
                            <td> TRN#'. $row['trans_id'] . '</td>
                            <td>' . $row['credit'] . '</td>
                            <td>' . $row['debit'] . '</td>
                            <td>' . $closing_balance . '</td>
                            <td>' . $row['note'] . '</td>  
                            <td> <a href="' . base_url("invoices/view?id=$invoice_id") . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a></td>
                        </tr>';
                        */
					foreach ($activity as $row) {						
                        echo '<tr>
							<td>' . $row['date'] . '</td>
							<td> TRN#'. $row['trans_id'] . '</td>
							<td>' . $row['credit'] . '</td>
							<td>' . $row['debit'] . '</td>
							<td>' . $closing_balance . '</td>
							<td>' . $row['note'] . '</td>  
							
                        </tr>';
						$closing_balance = $closing_balance+$row['debit'];	
						$closing_balance = $closing_balance-$row['credit'];	
						
                    }
					
					
					/* foreach ($activity as $row) {
						
						$invoice_id = $row['invoice_id'];
						
						
						'<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
						
                        echo '<tr>
                            <td>' . amountFormat($row['col1']) . '</td><td>' . $row['col2'] . '</td>
                           <td> <a href="' . base_url("invoices/view?id=$invoice_id") . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a></td>
                        </tr>';
                    }  */?>	
						<!-- <td> <a target="_blank" href="' . $invoice_url . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a></td>-->
                    </tbody>
                </table>
        </div>

            </section>
        </div>
    </div>
</div>
