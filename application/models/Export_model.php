<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Export_model extends CI_Model
{


    public function customers()
    {


        $this->db->select('*');
        $this->db->from('geopos_customers');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }
	
	
	public function export_franchise_sales_new($type='',$status='',$invoice_id=''){
		$sdate = $this->input->post('sdate');
		$edate = $this->input->post('edate');
		$this->db->select('b.id,j.store_code,b.tid,b.invoicedate,b.pmethod,b.pmethod_id,b.total,b.items,g.name as from_franchise,
		i.name as to_franchise,c.discount,k.name as customer_name');		
		$this->db->from("tbl_warehouse_serials as a");		
		$this->db->join('geopos_invoices as b', 'a.invoice_id = b.id', 'LEFT');
		$this->db->join('geopos_invoice_items as c', 'c.tid = b.id', 'LEFT');
		$this->db->join('geopos_products as d', 'd.pid = a.pid', 'LEFT');
		$this->db->join('geopos_product_serials as e', 'e.id = a.serial_id', 'LEFT');
		$this->db->join('geopos_warehouse as f', 'f.id = a.fwid', 'LEFT');
		$this->db->join('geopos_customers as g', 'g.id = f.cid', 'LEFT');
		$this->db->join('geopos_warehouse as h', 'h.id = a.twid', 'LEFT');
		$this->db->join('geopos_customers as i', 'i.id = h.cid', 'LEFT');
		$this->db->join('geopos_store as j', 'j.cid = i.id', 'LEFT');
		$this->db->join('tbl_customers as k', 'k.id = b.csd2', 'LEFT');
		
		$this->db->where('b.invoicedate >=', date('Y-m-d',strtotime($sdate)));
		$this->db->where('b.invoicedate <=', date('Y-m-d',strtotime($edate)));
		$this->db->where('a.invoice_id !=',0);
		
		if($invoice_id){
			$this->db->where('a.invoice_id',$invoice_id);
		}
		
		if($type){
			$this->db->where('b.type',$type);
		}
		
		if($status){
			$this->db->where('a.status',$status);
		}
		
		$this->db->order_by('i.name');
		$this->db->group_by('a.invoice_id');
		$query = $this->db->get();	
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){	
					$row->inv_details = $this->export_franchise_sales_inv_details($type='',$status='',$row->id);
					$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	public function export_franchise_sales_inv_details($type='',$status='',$invoice_id=''){
		$sdate = $this->input->post('sdate');
		$edate = $this->input->post('edate');
		$this->db->select('a.*,b.tid,b.invoicedate,b.pmethod,b.pmethod_id,
		c.qty,c.price,c.tax,c.totaltax,c.marginal_gst_price,c.discount,c.subtotal,c.net_price,
		d.hsn_code,d.warehouse_product_code,d.product_name,
		e.serial,
		g.name as from_franchise,
		i.name as to_franchise,
		j.store_code,k.name as customer_name');		
		$this->db->from("tbl_warehouse_serials as a");		
		$this->db->join('geopos_invoices as b', 'a.invoice_id = b.id', 'LEFT');
		$this->db->join('geopos_invoice_items as c', 'c.tid = b.id', 'LEFT');
		
		$this->db->join('geopos_product_serials as e', 'e.serial = c.serial', 'LEFT');
		$this->db->join('geopos_products as d', 'd.pid = c.pid', 'LEFT');
		$this->db->join('geopos_warehouse as f', 'f.id = a.fwid', 'LEFT');
		$this->db->join('geopos_customers as g', 'g.id = f.cid', 'LEFT');
		$this->db->join('geopos_warehouse as h', 'h.id = a.twid', 'LEFT');
		$this->db->join('geopos_customers as i', 'i.id = h.cid', 'LEFT');
		$this->db->join('geopos_store as j', 'j.cid = i.id', 'LEFT');
		$this->db->join('tbl_customers as k', 'k.id = b.csd2', 'LEFT');
		
		$this->db->where('b.invoicedate >=', date('Y-m-d',strtotime($sdate)));
		$this->db->where('b.invoicedate <=', date('Y-m-d',strtotime($edate)));
		$this->db->where('a.invoice_id !=',0);
		
		if($invoice_id){
			$this->db->where('a.invoice_id',$invoice_id);
		}
		
		if($type){
			$this->db->where('b.type',$type);
		}
		
		if($status){
			$this->db->where('a.status',$status);
		}
		$this->db->where('e.status !=',8);
		
		$this->db->group_by('e.id');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function export_franchise_sales($type='',$status=''){
		$sdate = $this->input->post('sdate');
		$edate = $this->input->post('edate');
		$this->db->select('a.*,b.tid,b.invoicedate,b.pmethod,b.pmethod_id,c.qty,c.price,c.tax,c.discount,c.subtotal,d.hsn_code,d.warehouse_product_code,d.product_name,e.serial,g.name as from_franchise,i.name as to_franchise,j.store_code');		
		$this->db->from("tbl_warehouse_serials as a");		
		$this->db->join('geopos_invoices as b', 'a.invoice_id = b.id', 'LEFT');
		$this->db->join('geopos_invoice_items as c', 'c.tid = b.id', 'LEFT');
		$this->db->join('geopos_products as d', 'd.pid = a.pid', 'LEFT');
		$this->db->join('geopos_product_serials as e', 'e.id = a.serial_id', 'LEFT');
		$this->db->join('geopos_warehouse as f', 'f.id = a.fwid', 'LEFT');
		$this->db->join('geopos_customers as g', 'g.id = f.cid', 'LEFT');
		$this->db->join('geopos_warehouse as h', 'h.id = a.twid', 'LEFT');
		$this->db->join('geopos_customers as i', 'i.id = h.cid', 'LEFT');
		$this->db->join('geopos_store as j', 'j.cid = i.id', 'LEFT');
		
		$this->db->where('b.invoicedate >=', date('Y-m-d',strtotime($sdate)));
		$this->db->where('b.invoicedate <=', date('Y-m-d',strtotime($edate)));
		$this->db->where('a.invoice_id !=',0);
		if($type){
			$this->db->where('b.type',$type);
		}
		
		if($status){
			$this->db->where('a.status',$status);
		}
		
		$this->db->group_by('a.id');
		$query = $this->db->get();	
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function export_product_cost22($type='',$status=''){		
		$this->db->select('a.serial,b.status as product_status,c.title as warehouse, d.id as job_work_id,e.product_name,e.packaging_cost,e.packaging_cost_type,e.sale_price,f.tid,g.price as purchase_price,i.component,i.qty as component_qty');		
		$this->db->from("geopos_product_serials as a");	
		$this->db->join('tbl_warehouse_serials as b', 'b.serial_id = a.id', 'LEFT');	
		$this->db->join('geopos_warehouse as c', 'c.id = b.twid', 'LEFT');		
		$this->db->join('tbl_jobcard as d', 'd.serial = a.serial', 'LEFT');		
		$this->db->join('geopos_products as e', 'e.pid = a.product_id', 'LEFT');
		$this->db->join('geopos_purchase as f', 'f.id = a.purchase_id', 'LEFT');		
		$this->db->join('geopos_purchase_items as g', 'g.tid = a.purchase_id and g.pid = a.product_id', 'LEFT');		
		$this->db->join('tbl_jobwork_issue_serial as h', 'h.serial = a.serial', 'LEFT');		
		$this->db->join('tbl_jobwork_issue_component as i', 'i.jobwork_issue_serial_id	= h.id', 'LEFT');			
		
		$this->db->where('a.status !=',8);
		$this->db->order_by('a.id','DESC');
		$this->db->group_by('a.serial');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {						
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function  export_product_cost($type='',$status=''){		
		$this->db->select('a.serial,a.product_id,a.purchase_id,b.status as product_status,c.title as warehouse, d.id as job_work_id,e.product_name,e.packaging_cost,e.packaging_cost_type,e.sale_price');		
		$this->db->from("geopos_product_serials as a");	
		$this->db->join('tbl_warehouse_serials as b', 'b.serial_id = a.id', 'LEFT');	
		$this->db->join('geopos_warehouse as c', 'c.id = b.twid', 'LEFT');		
		$this->db->join('tbl_jobcard as d', 'd.serial = a.serial', 'LEFT');		
		$this->db->join('geopos_products as e', 'e.pid = a.product_id', 'LEFT');		
		//$this->db->join('geopos_purchase as f', 'f.id = a.purchase_id', 'LEFT');		
		
		$this->db->where('a.status !=',8);
		$this->db->order_by('a.id','DESC');
		$this->db->group_by('a.serial');
		
		$query = $this->db->get();	
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) { 
				$row->components = $this->JobWorkComponent($row->serial);
				$row->component_qty = $this->JobWorkComponentQty($row->serial);
				
				if($row->job_work_id != ""){
					$product_id = $this->getParentPidJobWorkProduct($row->product_id);
					$purchase_details = $this->getPurchaseDetails($product_id,$row->purchase_id);
				}else{
					$purchase_details = $this->getPurchaseDetails($row->product_id,$row->purchase_id);
				}
				$row->po = $purchase_details[0]->po;
				$row->purchase_price = $purchase_details[0]->price;
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}	
	
	
	public function JobWorkComponent($serial)
	{
	  	$this->db->select("c.component_name,a.serial,c.id,b.purchase_id");		
	  	$this->db->from("tbl_jobcard as a");	  	
	  	$this->db->join("tbl_component_serials as b","a.serial=b.product_serial",'left');	  
	  	$this->db->join("tbl_component as c","b.component_id=c.id",'left');	  
	  	$this->db->where('a.serial',$serial);
	  	$query = $this->db->get();
		//echo $this->db->last_query(); 
		$data = array(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){     
				$purchase_details = $this->getPurchaseDetails($row->id,$row->purchase_id);
				$row->component_po = $purchase_details[0]->po;
				$row->component_purchase_price = $purchase_details[0]->price;
                $data[] =$row;
			}			
			return $data;
		}
		return false;
	}
	  
	  
	public function JobWorkComponentQty($serial)
	{
		/* $this->db->select("b.component_name,a.serial");
		$this->db->from("tbl_component_serials as a");	  	
		$this->db->join("tbl_component as b","a.component_id=b.id",'left');
		$this->db->where('a.product_serial',$serial);
		$query = $this->db->get(); */
		
		$this->db->select("c.component_name,b.serial");
		$this->db->from("tbl_jobcard as a");	  	
	  	$this->db->join("tbl_component_serials as b","a.serial=b.product_serial",'left');	  
	  	$this->db->join("tbl_component as c","b.component_id=c.id",'left');	  
	  	$this->db->where('a.serial',$serial);
	  	$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	
	public function getPurchaseDetails($product_id,$purchase_id){
		/* $this->db->select("*");
	  	$this->db->where('tid',$purchase_id);
	  	$this->db->where('pid',$product_id);
	  	$query = $this->db->get('geopos_purchase_items'); */
		//echo $this->db->last_query(); //exit;
		
		$this->db->select("b.*,a.tid as po");
		$this->db->from("geopos_purchase as a");	  	
	  	$this->db->join("geopos_purchase_items as b","a.id=b.tid",'left');	  
	  
		$this->db->where('b.tid',$purchase_id);
	  	$this->db->where('b.pid',$product_id);
	  	$query = $this->db->get();		
		
		$data = array(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){                 
                $data[] =$row;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function  export_product_cost_by_serial($serial){		
		$this->db->select('a.serial,a.id as product_serial_id,a.product_id,a.purchase_id, b.status as product_status,c.title as warehouse, d.id as job_work_id,e.product_name,e.packaging_cost,e.packaging_cost_type,e.sale_price');		
		$this->db->from("geopos_product_serials as a");	
		$this->db->join('tbl_warehouse_serials as b', 'b.serial_id = a.id', 'LEFT');	
		$this->db->join('geopos_warehouse as c', 'c.id = b.twid', 'LEFT');		
		$this->db->join('tbl_jobcard as d', 'd.serial = a.serial', 'LEFT');		
		$this->db->join('geopos_products as e', 'e.pid = a.product_id', 'LEFT');		
		//$this->db->join('geopos_purchase as f', 'f.id = a.purchase_id', 'LEFT');
		
		$this->db->where('a.serial',$serial);
		$this->db->where('a.status !=',8);
		//$this->db->where('d.id !=','');
		$this->db->order_by('a.id','DESC');
		$this->db->group_by('a.serial');
		
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
				$row->components = $this->JobWorkComponent($row->serial);
				$row->component_qty = $this->JobWorkComponentQty($row->serial);
				$purchase_details = $this->getPurchaseDetails($row->product_id,$row->purchase_id);
				$row->po = $purchase_details[0]->po;
				$row->purchase_price = $purchase_details[0]->price;
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function product_cost_report_update(){
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_product_cost_report');		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){ 
				$last_inserted_serial_id = $row->product_serial_id;
			}
		}else{
			$last_inserted_serial_id = 0;
		}
		
		
		$this->db->where('id >',$last_inserted_serial_id);
		$this->db->where('status !=',8);
		$this->db->order_by('id','DESC');	
		$query1 = $this->db->get('geopos_product_serials');			
	
		if ($query1->num_rows() > 0) {
			foreach ($query1->result() as $key1=>$row1){      
				$serial = $row1->serial;
				$this->db->where('serial',$serial);				
				$query2 = $this->db->get('tbl_product_cost_report');	
				
				if ($query2->num_rows() > 0) {
					foreach ($query2->result() as $key2=>$row2){
						if($row2->work_id==''){
							$serial1 = $row2->serial;
							$records = $this->export_product_cost_by_serial($serial);
							
							/* echo "<pre>";
							print_r($records);
							echo "</pre>"; */
							
							
							$data = array();
							foreach($records as $key3=>$row3){
								if($row3->job_work_id !=''){
									
									$components = array();
									$components_po = array();
									$components_price = array();
									
									foreach($row3->components as $key4=>$row4){
										$components[] = $row4->component_name;
										$components_po[] = $row4->component_po;
										$components_price[] = $row4->component_purchase_price;
									}
									
									$components_name = implode(', ', $components);
									$components_po_all = implode(', ', $components_po);
									$components_price_all = implode(', ', $components_price);
									
									/* switch($row3->product_status){
										case 1: $status = 'Availabe';
										break;
										case 2: $status = 'Sold';
										break;
									} */
									
									if($row3->packaging_cost_type==1){
										$packaging_cost_val = $row3->packaging_cost;
									}else if($row3->packaging_cost_type==2){
										$packaging_cost_val = ($row3->purchase_price + (($row3->purchase_price*$row3->packaging_cost)/100));
									}
									
									$data['serial'] = $row3->serial;
									$data['work_id'] = $row3->job_work_id;
									$data['product_details'] = $row3->product_name;
									$data['po'] = $row3->po;
									$data['po_price'] = $row3->purchase_price;
									$data['component_qty'] = $row3->component_qty;
									$data['component_details'] = $components_name;
									$data['component_po'] = $components_po_all;
									$data['component_price'] = $components_price_all;
									$data['zoretailer_price'] = $row3->sale_price;
									$data['packaging_cost'] = $packaging_cost_val;
									$data['predicted_cost'] = 0;
									$data['current_warehouse'] = $row3->warehouse;
									$data['product_status'] = $row3->product_status;
									
									$this->db->where('id', $row2->id);
									$this->db->update('tbl_product_cost_report',$data); 
									//echo $this->db->last_query();
								}
							}
							
							
						}
					}
				}else{
					$records1 = $this->export_product_cost_by_serial($serial);
					/* echo "<pre>";
					print_r($records1);
					echo "</pre>"; */ 
					
					$data1 = array();
					foreach($records1 as $key5=>$row5){
						if($row5->product_name!=''){
							if(is_array($row5->components)){
								
								$components = array();
								$components_po = array();
								$components_price = array();
									
								foreach($row5->components as $key6=>$row6){
									$components[] = $row6->component_name;
									$components_po[] = $row6->component_po;
									$components_price[] = $row6->component_purchase_price;
								}							
								$components_name = implode(', ', $components);
								$components_po_all = implode(', ', $components_po);
								$components_price_all = implode(', ', $components_price);
							}
							
							/* switch($row5->product_status){
								case 1: $status = 'Availabe';
								break;
								case 2: $status = 'Sold';
								break;
								default : $status = 'Inactive';
							} */
							
							if($row5->packaging_cost_type==1){
								$packaging_cost_val = $row5->packaging_cost;
							}else if($row5->packaging_cost_type==2){
								$packaging_cost_val = ($row5->purchase_price + (($row5->purchase_price*$row5->packaging_cost)/100));
							}
							
							//echo "TTTTTTTTTTTTT"; exit;
							$data1['product_serial_id'] = $row5->product_serial_id;
							$data1['serial'] = $row5->serial;
							$data1['work_id'] = $row5->job_work_id;
							$data1['product_details'] = $row5->product_name;
							$data1['po'] = $row5->po;
							$data1['po_price'] = $row5->purchase_price;
							$data1['component_qty'] = $row5->component_qty;
							$data1['component_details'] = $components_name;
							$data1['component_po'] = $components_po_all;
							$data1['component_price'] = $components_price_all;
							$data1['zoretailer_price'] = $row5->sale_price;
							$data1['packaging_cost'] = $packaging_cost_val;
							$data1['predicted_cost'] = 0;
							$data1['current_warehouse'] = $row5->warehouse;
							$data1['product_status'] = $row5->product_status;
							
							/* echo "<pre>";
							print_r($data1);
							echo "</pre>"; */
							
							$res = $this->db->insert('tbl_product_cost_report', $data1);
							//echo $this->db->last_query();
						}
					}
				}
			}
		}
	}
	
	
	
	public function export_product_cost_report(){	
		$query = $this->db->get('tbl_product_cost_report');		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function getParentPidJobWorkProduct($pid=""){	
		$this->db->where('pid',$pid);
		$query = $this->db->get('geopos_products');		
		//echo $this->db->last_query(); exit;
		//$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				if($row->sub != 0 ){
					$row->pid;
					return $product_id = $this->getParentPidJobWorkProduct($row->sub);
				}else{
					//return($row->pid); 
					return $product_id = $row->pid; 
					//$data[] = $row->pid;
				}
            }
           //return $data; 
        }
        return false;
	}

	public function  export_jobwork_product_cost($type='',$status=''){
		
		$this->db->select('a.serial,a.product_id,a.purchase_id,b.status as product_status,c.title as warehouse, d.id as job_work_id,e.product_name,e.packaging_cost,e.packaging_cost_type,e.sale_price');		
		$this->db->from("geopos_product_serials as a");	
		$this->db->join('tbl_warehouse_serials as b', 'b.serial_id = a.id', 'LEFT');	
		$this->db->join('geopos_warehouse as c', 'c.id = b.twid', 'LEFT');		
		$this->db->join('tbl_jobcard as d', 'd.serial = a.serial', 'LEFT');		
		$this->db->join('geopos_products as e', 'e.pid = a.product_id', 'LEFT');		
		//$this->db->join('geopos_purchase as f', 'f.id = a.purchase_id', 'LEFT');		
		
		$this->db->where('a.status =',7);
		$this->db->where('d.id !=','NULL');
		$this->db->order_by('a.id','DESC');
		$this->db->group_by('a.serial');
		
		$query = $this->db->get();	
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) { 
				$row->components = $this->JobWorkComponent($row->serial);
				$row->component_qty = $this->JobWorkComponentQty($row->serial);
				
				if($row->job_work_id != ""){
					$product_id = $this->getParentPidJobWorkProduct($row->product_id);
					$purchase_details = $this->getPurchaseDetails($product_id,$row->purchase_id);
				}else{
					$purchase_details = $this->getPurchaseDetails($row->product_id,$row->purchase_id);
				}
				$row->po = $purchase_details[0]->po;
				$row->purchase_price = $purchase_details[0]->price;
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}	
	
	

}