<?php header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
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
                        
						switch($row->product_status){
							case 1: $status = 'Availabe';
							break;
							case 2: $status = 'Sold';
							break;
							default : $status = 'Inactive';
						}
					
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>                        
                        <td>JOBWORK<?php echo $row->work_id; ?></td>
                        <td><?php echo $row->product_details; ?></td>
                        <td><?php echo $row->po; ?></td>
                        <td><?php echo $row->po_price; ?></td>
                        <td><?php echo $row->serial; ?></td>
                        <td><?php echo $row->component_qty; ?></td>
                        <td><?php echo $row->component_details; ?></td>
                        <td><?php echo $row->component_po; ?></td>
                        <td><?php echo $row->component_price; ?></td>
                        <td><?php echo $row->zoretailer_price; ?></td>
                        <td><?php echo $row->packaging_cost; ?></td>
                        <td><?php echo $row->predicted_cost; ?></td>
                        <td><?php echo $row->current_warehouse; ?></td>
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

           
        
        