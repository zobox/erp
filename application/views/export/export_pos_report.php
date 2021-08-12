<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=pos_sale_report.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>



                <table   cellspacing="0" class="table" width="100%" border="1">
                    <thead>					
                    <tr>
                        <th>#</th>
                        <th>Store ID</th>
                        <th>Invoice Date</th>
                        <th>Invoice No</th>
                        <th>Bill From</th>
                        <th>Bill To</th>
						
						<th>
						<table   cellspacing="0" class="table" width="100%" border="1">
						<tr>
                        <th>Product Label Name</th>
                        <th>Product Code</th>
                        <th>Product Serial Number</th>
                        <th>HSN</th> 
						<th>Original Net Price</th>
                        <th>Net Price</th>
                        <th>Tax</th>
                        <th>Tax Type</th>
                        <th>Tax Amount</th>
						</tr></table>
						</th>
						
						<th>Qty</th>
                        <th>Discount</th>
                        <th>Gross Price</th>
                        <th>Mode of Payment</th>
                        <th>Total Amount Paid</th>
                        <th>Amount Paid in Cash</th>
                        <th>Amount Paid Via UPI Mode</th>
                        <th>Amount Paid Via Rupay Card Mode</th>
                        <th>Amount Paid Via Debit Card ( Master / Visa / Meastro ) Mode</th>
                        <th>Amount Paid Via Credit Card Mode</th>
                        <th>Amount Paid Via EMI Mode</th>                        
                    </tr>					
					
                    </thead>
                    <tbody>
					
					<?php 
					/* echo "<pre>";
					print_r($record);
					echo "</pre>"; 
                    die; */
					
					$i=1;
					foreach($record as $key=>$row){					
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>                        
                        <td><?php echo $row->store_code; ?></td>
                        <td><?php echo $row->invoicedate; ?></td>
                        <td><?php echo $row->tid; ?></td>
                        <td><?php echo $row->to_franchise; ?></td>
                        <td><?php echo $row->customer_name; ?></td>
						
						<td><table   cellspacing="0" class="table" width="100%" border="1">
						<?php
						foreach($row->inv_details as $key1=>$row1){			
							$cash_amount =0;
							$bank_amount =0;
							$upi_amount =0;
							$rupay_amount =0;
							$debit_card_amount =0;
							$credit_card_amount =0;
							$emi_amount =0;
							
							switch($row1->pmethod_id){
								case 1 : 	$cash_amount = $row->subtotal;
								break;
								case 2 : 	$bank_amount = $row->subtotal;
								break;
								case 3 : 	$upi_amount = $row->subtotal;
								break;
								case 4 : 	$rupay_amount = $row->subtotal;
								break;
								case 5 : 	$debit_card_amount = $row->subtotal;
								break;
								case 6 :	$credit_card_amount = $row->subtotal;
								break;
								case 7:		$emi_amount = $row->subtotal;
								break;
							}
							
							if($row1->marginal_gst_price > 0){
								$tax_amt = $row1->marginal_gst_price;
								$tax_rate = 0;
								$tax_type = 'Mrg';
							}else{
								$tax_amt = $row1->totaltax;
								$tax_rate =  $row1->tax;
								$tax_type = $row1->ship_tax_type;
							} ?>
							
						<tr>
                        <td><?php echo $row1->product_name; ?></td>
                        <td><?php echo $row1->warehouse_product_code; ?></td>
                        <td>'<?php echo $row1->serial; ?>'</td>
                        <td><?php echo $row1->hsn_code; ?></td>                        
                        <td><?php echo $row1->price; ?></td>
                        <td><?php echo $row1->net_price; ?></td>
                        <td><?php echo $tax_rate; ?></td>
                        <td><?php echo $tax_type; ?></td>
                        <td><?php echo $tax_amt; ?></td>
						</tr>
						<?php } ?>
						</table></td>
						
                        <td><?php echo $row->items; ?></td>
                        <td><?php echo $row->discount; ?></td>
                        <td><?php echo $row->total; ?></td>
                        <td><?php echo $row->pmethod; ?></td>
                        <td><?php echo $row->total; ?></td>
                        <td><?php echo $cash_amount; ?></td>
                        <td><?php echo $upi_amount; ?></td>
                        <td><?php echo $rupay_amount; ?></td>
                        <td><?php echo $debit_card_amount; ?></td>
                        <td><?php echo $credit_card_amount; ?></td>
                        <td><?php echo $emi_amount; ?></td>
						
                    </tr>
					<?php $i++; }  ?>
					
                    
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Store ID</th>
                        <th>Invoice Date</th>
                        <th>Invoice No</th>
                        <th>Bill From</th>
                        <th>Bill To</th>
						
						<th>
						<table   cellspacing="0" class="table" width="100%" border="1">
						<tr>
                        <th>Product Label Name</th>
                        <th>Product Code</th>
                        <th>Product Serial Number</th>
                        <th>HSN</th> 
						<th>Original Net Price</th>
                        <th>Net Price</th>
                        <th>Tax</th>
                        <th>Tax Type</th>
                        <th>Tax Amount</th>
						</tr></table>
						</th>
						
						<th>Qty</th>
                        <th>Discount</th>
                        <th>Gross Price</th>
                        <th>Mode of Payment</th>
                        <th>Total Amount Paid</th>
                        <th>Amount Paid in Cash</th>
                        <th>Amount Paid Via UPI Mode</th>
                        <th>Amount Paid Via Rupay Card Mode</th>
                        <th>Amount Paid Via Debit Card ( Master / Visa / Meastro ) Mode</th>
                        <th>Amount Paid Via Credit Card Mode</th>
                        <th>Amount Paid Via EMI Mode</th>                        
                    </tr>
                    </tfoot>
                </table>

           
        
        