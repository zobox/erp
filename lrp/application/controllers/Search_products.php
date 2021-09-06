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

defined('BASEPATH') or exit('No direct script access allowed');

class Search_products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
       
        //$this->load->model('search_model');
        $this->load->model('jobwork_model','jobwork');
       // $this->load->model('products_model','products');
        
    }
	
	
	//search product in invoice
	public function search_product_lrp()
    {	   
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);    
        //$name = 3532501178092631;    
        
        $wid = $this->input->post('wid', true);
        //$wid = 18;
        

        if ($name) {
			
			$this->db->select('count(b.id) as qty,
			c.pid,c.product_name,c.sale_price,c.product_price,c.zobulk_sale_price,c.hsn_code,c.taxrate,c.disrate,c.product_des,c.qty as pqty,c.unit,
			a.serial,a.id as serial_id,a.purchase_id,a.purchase_pid,d.id as jobwork_id,d.jobwork_service_type');
			$this->db->from('geopos_product_serials as a');
			$this->db->join('tbl_warehouse_serials as b','a.id=b.serial_id','left');
			$this->db->join('geopos_products as c', 'a.product_id=c.pid','left');
			$this->db->join('tbl_jobcard as d', 'd.serial=a.serial','left');			
		
			$this->db->where('b.twid',$wid);
			$this->db->where('b.status !=',0);	// ! Inactive		
			$this->db->where('b.status !=',2);	// ! sold		
			$this->db->where('b.status !=',3);	// ! Misplaced		
			$this->db->where('b.status !=',8);	// ! deleted		
			$this->db->where('b.is_present',1);	// IS Present		
					
			$this->db->where('a.status !=',8);	// ! Deleted		
			$this->db->where('a.status !=',0);	// ! Inactive				
			$this->db->where('a.status !=',2);  // ! In Jobwork
			$this->db->where('a.status !=',4);  // ! Jobwork Request
			$this->db->where('a.status !=',5);  // ! Jobwokr Issue
			$this->db->where('a.status !=',6);  // ! jobcard Assign
			
			//$this->db->where('c.expiry','NULL');	
			//$this->db->where('DATE (c.expiry) < ', date('Y-m-d'));
			$this->db->where('a.serial',$name);			
			$this->db->limit('1');			
			$query = $this->db->get();

			$sql = $this->db->last_query(); 
			//echo $sql; exit; 
    
            if($query->num_rows()==1)
            {
            $result = $query->result_array();
            foreach ($result as $row) {
				$purchase_record = $this->jobwork->getPurchasePriceByPID($row['purchase_id'],$row['purchase_pid']);
				$component_details = $this->jobwork->JobWorkComponent($row['serial']);
								
				$components = array();
				$total_component_price = 0;
				foreach($component_details as $key=>$component){
					$component_id = $component->component_id; 
					$purchase_id = $component->purchase_id;
					$cprice = json_decode(json_encode($this->jobwork->getComponentPrice($purchase_id,$component_id))); 
					$component_price = $cprice[0]->price; 
					
					$components['component_name'][] = $component->component_name;
					$components['serial'][] = $component->serial;
					$components['price'][] = $component_price;
					$total_component_price += $component_price; 
				}
								
				$jobwork_service_type = $row['jobwork_service_type'];
				switch($jobwork_service_type){
					case 1: $service_type = 'L1'; $service_charge = 29.5;
					break;
					case 2: $service_type = 'L2'; $service_charge = 118;
					break;
					case 3: $service_type = 'L3'; $service_charge = 177;
					break;
				}
				
				
				
				$purchase_price = $purchase_record[0]['price'];
				
				/* echo "purchase_price";
				echo $purchase_price; 
				echo "total_component_price";
				echo $total_component_price;
				echo "service_charge";
				echo $service_charge;
				echo "sale_price_after_jobwork"; exit; */
				$sale_price_after_jobwork = $purchase_price+$total_component_price+$service_charge;				
				
				
                //$name = array($row['product_name'], amountExchange_s($purchase_price, 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                $name = array($row['product_name'], $sale_price_after_jobwork, $row['pid'], $row['taxrate'], $row['disrate'], $row['product_des'], $row['unit'], $row['hsn_code'], $row['qty'], $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            } 
        }               
            echo json_encode($name);
        }
    }
	
	
	
	
    

}