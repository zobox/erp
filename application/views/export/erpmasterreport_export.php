<?php 
/* header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=franchise_salewise_cost_report.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); */

/* CREATE VIEW erp_master_report AS
    SELECT a.serial,c.tid as po,c.invoicedate as po_date,c.type as po_type,
	d.price as purchase_price,d.totaldiscount as purchase_discount_amount,d.tax as purchase_tax,d.totaltax as purchase_tax_amount,
	e.name as supplier_name,e.city as supplier_city,e.address as supplier_address,e.email as supplier_email,e.phone as supplier_contact,e.gst as supplier_gst,
	f.product_name,f.hsn_code,f.warehouse_product_code as zupc,
	g.title as brand,
	h.title as product_category
	
FROM 
	geopos_product_serials as a, 
	tbl_warehouse_serials  as b,
	geopos_purchase as c,
	geopos_purchase_items as d,
	geopos_supplier as e,
	geopos_products as f,
	geopos_brand as g,
	geopos_product_cat as h,	
	geopos_invoices as j,
	geopos_invoice_items as k
	
WHERE a.id = b.serial_id 
and a.purchase_pid = d.pid
and a.purchase_id = d.tid
and a.purchase_id = c.id
and c.csd = e.id
and a.purchase_pid = f.pid
and f.b_id = g.id 
and f.pcat = h.id
and b.invoice_id = k.tid 
and b.pid = k.pid 
and j.id = k.tid */



?>

                <table   cellspacing="0" class="table" width="100%" border="1">
                    <thead>					
                    <tr>
						<th>#</th>//
                        <th>Po No</th>//
						<th>Po Date</th>//
						<th>Po Type</th>
						<th>Tax Classification</th>//
						<th>Supplier Name</th>//
						<th>Supplier Location</th>//
						<th>Supplier Address</th>//	
						<th>Supplier Email</th>//
						<th>Supplier Contact</th>//	
						<th>Supplier GST</th>//	
						<th>Product Name</th>//	
						<th>Brand</th>//	
						<th>Product Category</th>//
						<th>Hsn Code</th>//	
						<th>Zupc Code</th>//	
						<th>imei/Serial No.</th>//
						<th>Quantity</th>//	
						<th>Invoice Value</th>//
						<th>Purchase Discount Type</th>	
						<th>Purchase Discount Amount</th>//	
						<th>IGST%</th>
						<th>IGST Amount</th>	
						<th>CGST%</th>	
						<th>CGST Amount</th>
						<th>SGST%</th>	
						<th>SGST Amount</th>
						<th>Total Tax</th>//	
						<th>Invoice Value</th>//	
						<th>Product Receiving Agent</th>//
						<th>Receiving Date	</th>//
						<th>Product imei/Serial No.	</th>//
						<th>Product Status	</th>//
						<th>Jobwork Status	</th>//
						<th>Jobwork Type	</th>
						<th>Third Party Delivery Challan No.</th>
						<th>Challan Date	</th>
						<th>Third Party Company Name</th>	
						<th>Third Party Location</th>	
						<th>Third Party Address	</th>
						<th>Third Party Email	</th>
						<th>Third Party Contact	</th>
						<th>Third Party GST	</th>
						<th>Product Name</th>//	
						<th>Hsn Code</th>//	
						<th>Zupc Code</th>	//
						<th>imei/Serial No.	</th>//
						<th>Quantity</th>//	
						<th>Challan Value</th>	
						<th>IGST%</th>	
						<th>IGST Amount	</th>
						<th>CGST%</th>
						<th>CGST Amount	</th>
						<th>SGST%	</th>
						<th>SGST Amount	</th>
						<th>Total Tax	</th>
						<th>Challan Total Value	</th>	
						<th>Third Party Receiving Agent</th>	
						<th>Receiving Date</th>	
						<th>Jobwork No.</th>//	
						<th>Team Leader Employee ID</th>//	
						<th>Team Leader Name</th>//	
						<th>Engineer Employee ID</th>	
						<th>Engineer Name</th>//	
						<th>Product Current Grade</th>//	
						<th>Spare Parts Consumed</th>//	
						<th>Spare Parts Po No.</th>//	
						<th>Spare Parts Total Cost</th>//	
						<th>Product Final Grade</th>//	
						<th>Jobwork Type</th>//	
						<th>Jobcard Price</th>//	
						<th>Gst %</th>	
						<th>Gst Amount</th>	
						<th>Total Jobwork Cost</th>	//
						<th>Third Party Company Name</th>	
						<th>Third Party Location</th>	
						<th>Third Party Address</th>	
						<th>Third Party Email</th>	
						<th>Third Party Contact</th>	
						<th>Third Party GST</th>
						<th>Delivery Challan Date</th>	
						<th>Delivery Challan No.</th>	
						<th>Product Name</th>//	
						<th>Hsn Code</th>	
						<th>imei/Serial No.</th>//	
						<th>Quantity</th>//	
						<th>Challan Value</th>	
						<th>IGST%</th>
						<th>IGST Amount</th>	
						<th>CGST%</th>	
						<th>CGST Amount</th>	
						<th>SGST%</th>	
						<th>SGST Amount</th>	
						<th>Total Tax</th>	
						<th>Challan Total Value</th>	
						<th>Zobox Receiving Agent</th>	
						<th>Receiving Date</th>	
						<th>Product imei/Serial No.</th>//	
						<th>Product Grade Received</th>//	
						<th>Re Check Status</th>
                    </tr>					
                    </thead>
                    <tbody>
					
					<?php 
					echo "<pre>";
					print_r($records);
					echo "</pre>"; 
					
					$i = 1;
					foreach($records as $key=>$row){ 
						
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
						
						if($row->po_type==2){
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
						
						$igst_percentage = 0;
						$cgst_percentage = 0;
						$sgst_percentage = 0;
						
						if($row->taxstatus=='igst'){
							$igst_percentage = $row->purchase_tax;
							$igst_amount = $row->purchase_tax_amount;
						}else{
							$cgst_percentage = ($row->purchase_tax/2);
							$sgst_percentage = ($row->purchase_tax/2);
							$cgst_amount = ($row->purchase_tax_amount/2);
							$sgst_amount = ($row->purchase_tax_amount/2);
						}	
						
						
					?>
                    <tr>
                        <td><?php echo  $i; ?></td>                        
						<td><?php echo $row->po; ?></td> 
						<td><?php echo $row->po_date; ?></td> 
						<td><?php echo $row->product_category; ?></td> 
						<td><?php echo $tax_classification; ?></td> 
						<td><?php echo $row->supplier_name; ?></td> 
						<td><?php echo $row->supplier_city; ?></td> 
						<td><?php echo $row->supplier_address; ?></td> 	
						<td><?php echo $row->supplier_email; ?></td> 
						<td><?php echo $row->supplier_contact; ?></td> 	
						<td><?php echo $row->supplier_gst; ?></td> 	
						<td><?php echo $row->product_name; ?></td> 	
						<td><?php echo $row->brand; ?></td> 
						<td><?php echo $row->product_category; ?></td> 
						<td><?php echo $row->hsn_code; ?></td> 	
						<td><?php echo $row->zupc; ?></td> 	
						<td><?php echo $row->serial; ?></td> 	
						<td>1</td> 	
						<td><?php echo $row->purchase_price; ?></td> 	
						<td>Purchase Discount Type</td> 	
						<td><?php echo $row->purchase_discount_amount; ?></td> 	
						<td><?php echo $igst_percentage; ?></td> 	
						<td><?php echo $igst_amount; ?></td> 	
						<td><?php echo $cgst_percentage; ?></td> 	
						<td><?php echo $cgst_amount; ?></td> 	
						<td><?php echo $sgst_percentage; ?></td> 	
						<td><?php echo $sgst_amount; ?></td> 	
						<td><?php echo $row->purchase_tax_amount; ?></td> 	
						<td><?php echo $row->purchase_price; ?></td> 	
						<td><?php echo $row->receiving_agent; ?></td> 	
						<td><?php echo $row->receiving_date; ?></td> 	
						<td><?php echo $row->serial; ?></td> 	
						<td><?php echo $row->product_status; ?></td> 	
						<td>Jobwork Status</td> 	
						<td>Jobwork Type</td> 	
						<td>Third Party Delivery Challan No.</td> 	
						<td>Challan Date</td> 	
						<td>Third Party Company Name</td> 	
						<td>Third Party Location</td> 	
						<td>Third Party Address	</td> 
						<td>Third Party Email</td> 	
						<td>Third Party Contact	</td> 
						<td>Third Party GST	</td> 
						<td><?php echo $row->product_name; ?></td> 	
						<td><?php echo $row->hsn_code; ?></td> 
						<td><?php echo $row->zupc; ?></td> 	
						<td><?php echo $row->serial; ?></td> 	
						<td>1</td> 	
						<td>Challan Value</td> 	
						<td>IGST%</td> 	
						<td>IGST Amount</td> 	
						<td>CGST%</td> 	
						<td>CGST Amount</td> 	
						<td>SGST%</td> 	
						<td>SGST Amount</td> 	
						<td>Total Tax</td> 	
						<td>Challan Total Value</td> 		
						<td>Third Party Receiving Agent</td> 	
						<td>Receiving Date</td> 	
						<td><?php echo $row->jobwork_no; ?></td> 	
						<td><?php echo $row->teamlead_id; ?></td> 	
						<td><?php echo $row->teamlead; ?></td> 	
						<td>Engineer Employee ID</td> 	
						<td><?php echo $row->assign_engineer; ?></td> 	
						<td>Product Current Grade</td> 	
						<td><?php echo $row->components_name; ?></td> 	
						<td><?php echo $row->component_po; ?></td> 	
						<td>Spare Parts Total Cost</td> 	
						<td>Product Final Grade</td> 	
						<td>L<?php echo $row->jobwork_service_type; ?></td> 	
						<td>Jobcard Price</td> 	
						<td>Gst %</td> 	
						<td>Gst Amount</td> 	
						<td>Total Jobwork Cost</td> 	
						<td>Third Party Company Name</td> 	
						<td>Third Party Location</td> 	
						<td>Third Party Address</td> 	
						<td>Third Party Email</td> 	
						<td>Third Party Contact</td> 
						<td>Third Party GST</td> 	
						<td>Delivery Challan Date</td> 	
						<td>Delivery Challan No.</td> 	
						<td>Product Name</td> 	
						<td>Hsn Code</td> 	
						<td>imei/Serial No.</td> 	
						<td>Quantity</td> 	
						<td>Challan Value</td> 	
						<td>IGST%</td> 	
						<td>IGST Amount</td> 	
						<td>CGST%</td> 	
						<td>CGST Amount</td> 	
						<td>SGST%</td> 	
						<td>SGST Amount</td> 	
						<td>Total Tax</td> 	
						<td>Challan Total Value</td> 	
						<td>Zobox Receiving Agent</td> 	
						<td>Receiving Date</td> 	
						<td>Product imei/Serial No.</td> 	
						<td>Product Grade Received</td> 	
						<td>Re Check Status</td> 						
                    </tr>
					<?php $i++; } ?>                   
                    </tbody>

                    <tfoot>
                    <tr>
						<th>#</th>
                        <th>Po No</th>
						<th>Po Date</th>
						<th>Po Type</th>
						<th>Tax Classification</th>
						<th>Supplier Name</th>
						<th>Supplier Location</th>
						<th>Supplier Address</th>	
						<th>Supplier Email</th>
						<th>Supplier Contact</th>	
						<th>Supplier GST</th>	
						<th>Product Name</th>	
						<th>Brand</th>	
						<th>Product Category</th>
						<th>Hsn Code</th>	
						<th>Zupc Code</th>	
						<th>imei/Serial No.</th>
						<th>Quantity</th>	
						<th>Invoice Value</th>
						<th>Purchase Discount Type</th>	
						<th>Purchase Discount Amount</th>	
						<th>IGST%</th>
						<th>IGST Amount</th>	
						<th>CGST%</th>	
						<th>CGST Amount</th>
						<th>SGST%</th>	
						<th>SGST Amount</th>
						<th>Total Tax</th>	
						<th>Invoice Value</th>	
						<th>Product Receiving Agent</th>
						<th>Receiving Date	</th>
						<th>Product imei/Serial No.	</th>
						<th>Product Status	</th>
						<th>Jobwork Status	</th>
						<th>Jobwork Type	</th>
						<th>Third Party Delivery Challan No.	</th>
						<th>Challan Date	</th>
						<th>Third Party Company Name</th>	
						<th>Third Party Location</th>	
						<th>Third Party Address	</th>
						<th>Third Party Email	</th>
						<th>Third Party Contact	</th>
						<th>Third Party GST	</th>
						<th>Product Name</th>	
						<th>Hsn Code</th>	
						<th>Zupc Code</th>	
						<th>imei/Serial No.	</th>
						<th>Quantity</th>	
						<th>Challan Value</th>	
						<th>IGST%</th>	
						<th>IGST Amount	</th>
						<th>CGST%</th>
						<th>CGST Amount	</th>
						<th>SGST%	</th>
						<th>SGST Amount	</th>
						<th>Total Tax	</th>
						<th>Challan Total Value	</th>	
						<th>Third Party Receiving Agent</th>	
						<th>Receiving Date</th>	
						<th>Jobwork No.</th>	
						<th>Team Leader Employee ID</th>	
						<th>Team Leader Name</th>	
						<th>Engineer Employee ID</th>	
						<th>Engineer Name</th>	
						<th>Product Current Grade</th>	
						<th>Spare Parts Consumed</th>	
						<th>Spare Parts Po No.</th>	
						<th>Spare Parts Total Cost</th>	
						<th>Product Final Grade</th>	
						<th>Jobwork Type</th>	
						<th>Jobcard Price</th>	
						<th>Gst %</th>	
						<th>Gst Amount</th>	
						<th>Total Jobwork Cost</th>	
						<th>Third Party Company Name</th>	
						<th>Third Party Location</th>	
						<th>Third Party Address</th>	
						<th>Third Party Email</th>	
						<th>Third Party Contact</th>	
						<th>Third Party GST</th>
						<th>Delivery Challan Date</th>	
						<th>Delivery Challan No.</th>	
						<th>Product Name</th>	
						<th>Hsn Code</th>	
						<th>imei/Serial No.</th>	
						<th>Quantity</th>	
						<th>Challan Value</th>	
						<th>IGST%</th>
						<th>IGST Amount</th>	
						<th>CGST%</th>	
						<th>CGST Amount</th>	
						<th>SGST%</th>	
						<th>SGST Amount</th>	
						<th>Total Tax</th>	
						<th>Challan Total Value</th>	
						<th>Zobox Receiving Agent</th>	
						<th>Receiving Date</th>	
						<th>Product imei/Serial No.</th>	
						<th>Product Grade Received</th>	
						<th>Re Check Status</th>
                    </tr>
                    </tfoot>
                </table>

           
        
        