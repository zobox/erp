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
                        <th>Serial No</th>
                        <th>Total Product Cost</th>
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
						
						if(is_array($row->components)){
								
									$total_price = 0;
								foreach($row->components as $key1=>$row1){
									$total_price += $row1->component_purchase_price;
								}							
								
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
                        
                        <td><?php echo $row->serial; ?></td>
                        <td><?php echo $total_price+$row->purchase_price; ?></td>
						
                    </tr>
					<?php $i++; } ?>
					
                    
                    </tbody>

                    <tfoot>
                    <tr>
                       <th>#</th>
                        <th><?php echo $this->lang->line('Work ID') ?></th>
                        <th><?php echo $this->lang->line('Product Details') ?></th>
                        <th>PO Price</th>
                        <th>Serial No</th>
                        <th>Components Price</th>
                        <th>Total Product Cost</th>
                    </tr>
                    </tfoot>
                </table>

           
        
        