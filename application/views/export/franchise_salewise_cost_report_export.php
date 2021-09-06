<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=franchise_salewise_cost_report.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>

                <table   cellspacing="0" class="table" width="100%" border="1">
                    <thead>					
                    <tr>
						<th>#</th>
                        <th>Billing State</th>	
						<th>Billing Company	</th>
						<th>Billing State GST</th>	
						<th>Billed to</th>	
						<th>Consignee</th>	
						<th>Consignee Gst</th>	
						<th>ranchise ID</th>	
						<th>Franchise Location</th>	
						<th>Invoice Date</th>	
						<th>Invoice No</th>	
						<th>Tax Classification</th>	
						<th>Product name</th>	
						<th>Zupc Code</th>	
						<th>Imei / Serial No.</th>	
						<th>Hsn Code</th>	
						<th>Net Purchase Price</th> 	
						<th>GST Type</th>	
						<th>GST %</th>	
						<th>GTS Amount</th>	
						<th>Gross Purchase Price</th>	
						<th>Number of Sapreparts</th>	
						<th>Total Spareparts Cost</th> 	
						<th>Total Spareparts Net Cost</th>	
						<th>Total Spareparts GST</th>	
						<th>Total NET Landing Cost</th>
						<th>Total Gross Landing cost</th>
                    </tr>					
                    </thead>
                    <tbody>
					
					<?php 
					/* echo "<pre>";
					print_r($record);
					echo "</pre>"; die; */
					
					$i = 1;
					foreach($record as $key=>$row){ 
						
						if(is_array($row->components)){								
							$total_component_purchase_price = 0;
							$total_net_component_purchase_price = 0;
							$total_component_gst = 0;
							foreach($row->components as $key1=>$row1){
								$total_component_purchase_price += $row1->component_purchase_price;
								$component_gst = (($row1->component_purchase_price*$row1->component_purchase_tax)/(100+$row1->component_purchase_tax));
								$total_component_gst += $component_gst;
								$net_component_purchase_price = $row1->component_purchase_price-($component_gst);
								$total_net_component_purchase_price += $net_component_purchase_price;
							}							
								
						}
						
						$ship_tax_type = 0;
						$purchase_tax = 0;
						$gst_price = 0;
						
						if($row->purchase_type==2){
							$tax_classification = 'Marignal';
							$net_purchase_price = $row->purchase_price;							
						}else{
							if($row->purchase_ship_tax_type=='incl'){
								$gst_price = ($row->purchase_price*$row->purchase_tax)/(100+$row->purchase_tax);
								$net_purchase_price = $row->purchase_price - $gst_price;
							}
							$tax_classification = 'Normal';
							$ship_tax_type = $row->ship_tax_type;
							$purchase_tax = $row->purchase_tax;
							
						}
						
							
						
						$net_landing_cost = $net_purchase_price+$total_net_component_purchase_price;
						$gross_landing_cost = $row->purchase_price+$total_component_purchase_price;
						
						
							
						/* switch($row->product_status){
							case 1: $status = 'Availabe';
							break;
							case 2: $status = 'Sold';
							break;
							case 3: $status = 'Misplaced';
							break;
							default : $status = 'Inactive';
						}
						
						if($row->packaging_cost_type==1){
							$packaging_cost_val = $row->packaging_cost;
						}else if($row->packaging_cost_type==2){
							$packaging_cost_val = ($row->purchase_price + (($row->purchase_price*$row->packaging_cost)/100));
						} */					
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>                        
                        <td>New Delhi</td>	
						<td>Zobox Retails Pvt. Ltd.</td>
						<td>07AABCZ6490M1ZN</td>	
						<td><?php echo $row->to_state; ?></td>	
						<td><?php echo $row->consignee; ?></td>	
						<td><?php echo $row->consignee_gst; ?></td>	
						<td><?php echo $row->to_franchise_id; ?></td>	
						<td><?php echo $row->to_city; ?></td>	
						<td><?php echo $row->invoicedate; ?></td>	
						<td><?php echo $row->tid; ?></td>	
						<td><?php echo $tax_classification; ?></td>	
						<td><?php echo $row->product_name; ?></td>	
						<td><?php echo $row->zupc; ?></td>	
						<td><?php echo $row->serial; ?></td>	
						<td><?php echo $row->hsn_code; ?></td>	
						<td><?php echo round($net_purchase_price,2); //Net Purchase Price ?></td> 	
						<td><?php echo $ship_tax_type; ?></td>	
						<td><?php echo $purchase_tax; ?>%</td>	
						<td><?php echo round($gst_price,2); ?></td>	
						<td><?php echo round($row->purchase_price,2); // //Gross Purchase Price?></td>	
						<td><?php echo $row->component_qty; ?></td>	
						<td><?php echo round($total_component_purchase_price,2); ?></td> 	
						<td><?php echo round($total_net_component_purchase_price,2); ?></td>	
						<td><?php echo round($total_component_gst,2); ?></td>	
						<td><?php echo round($net_landing_cost,2); ?></td>
						<td><?php echo round($gross_landing_cost,2); ?></td>						
                    </tr>
					<?php $i++; } ?>                   
                    </tbody>

                    <tfoot>
                    <tr>
						<th>#</th>
                        <th>Billing State</th>	
						<th>Billing Company	</th>
						<th>Billing State GST</th>	
						<th>Billed to</th>	
						<th>Consignee</th>	
						<th>Consignee Gst</th>	
						<th>ranchise ID</th>	
						<th>Franchise Location</th>	
						<th>Invoice Date</th>	
						<th>Invoice No</th>	
						<th>Tax Classification</th>	
						<th>Product name</th>	
						<th>Zupc Code</th>	
						<th>Imei / Serial No.</th>	
						<th>Hsn Code</th>	
						<th>Net Purchase Price</th> 	
						<th>GST Type</th>	
						<th>GST %</th>	
						<th>GTS Amount</th>	
						<th>Gross Purchase Price</th>	
						<th>Number of Sapreparts</th>	
						<th>Total Spareparts Cost</th> 	
						<th>Total Spareparts Net Cost</th>	
						<th>Total Spareparts GST</th>	
						<th>Total NET Landing Cost</th>
						<th>Total Gross Landing cost</th>
                    </tr>
                    </tfoot>
                </table>

           
        
        