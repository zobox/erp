<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=product_cost_report.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>



                <table   cellspacing="0" class="table" width="100%" border="1">
                    <thead>					
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Work ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th>PO Price</th>
                        <th>Serial No</th>
                        <th>Components Qty</th>
                        <th>Components Detail</th>
                        <th>Components PO#</th>
                        <th>Components Price</th>
                        <th>ZoRetail Price</th>
                        <th>Packeging Cost</th>
                        <th>Predicted Cost</th>
                        <th>Current Warehouse</th>
                        <th>Product Status</th>
                    </tr>					
					
                    </thead>
                    <tbody>
					
					<?php 
					/* echo "<pre>";
					print_r($record);
					echo "</pre>"; 
                    die; */
					
					$i = 1;

					foreach($record as $key=>$row){ 
						$components = array();
						$components_po = array();
						$components_price = array();
						$components_name = '';
						$components_po_all = '';
						$components_price_all = '';
						if(is_array($row->components)){
								
								$components = array();
								$components_po = array();
								$components_price = array();
									
								foreach($row->components as $key1=>$row1){
									$components[] = $row1->component_name;
									$components_po[] = $row1->component_po;
									$components_price[] = $row1->component_purchase_price;
								}							
								$components_name = implode(', ', $components);
								$components_po_all = implode(', ', $components_po);
								$components_price_all = implode(', ', $components_price);
						}
							
							switch($row->product_status){
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
							}
                        
						
					
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>                        
                        <td><?php if($row->job_work_id!=''){ ?>JOBWORK<?php } echo $row->job_work_id; ?></td>
                        <td><?php echo $row->product_name; ?></td>
                        <td><?php echo $row->po; ?></td>
                        <td><?php echo $row->purchase_price; ?></td>
                        <td><?php echo $row->serial; ?></td>
                        <td><?php echo $row->component_qty; ?></td>
                        <td><?php echo $components_name; ?></td>
                        <td><?php echo $components_po_all; ?></td>
                        <td><?php echo $components_price_all; ?></td>
                        <td><?php echo $row->sale_price; ?></td>
                        <td><?php echo $packaging_cost_val; ?></td>
                        <td><?php //echo $row->predicted_cost; ?>N/A</td>
                        <td><?php echo $row->warehouse; ?></td>
                        <td><?php echo $status; ?></td>
						
                    </tr>
					<?php $i++; } ?>
					
                    
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Work ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <th><?php echo $this->lang->line('PO#') ?></th>
                        <th><?php echo $this->lang->line('PO Price') ?></th>
                        <th>Serial No</th>
                        <th>Components Qty</th>
                        <th>Components Detail</th>
                        <th>Components PO#</th>
                        <th>Components Price</th>
                        <th>ZoRetail Price</th>
                        <th>Packeging Cost</th>
                        <th>Predicted Cost</th>
                        <th>Current Warehouse</th>
                        <th>Product Status</th>
                    </tr>
                    </tfoot>
                </table>

           
        
        