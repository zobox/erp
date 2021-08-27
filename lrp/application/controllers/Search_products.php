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
        ///$this->load->model('jobwork_model','jobwork');
       // $this->load->model('products_model','products');
        
    }
	
	
	//search product in invoice
	public function search_product_lrp()
    {	   
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);    
        //$name = 352682103377684;    
        
        $wid = $this->input->post('wid', true);
        //$wid = 1;
        

        if ($name) {
			$sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.sale_price,
			geopos_products.product_price,geopos_products.zobulk_sale_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,
			geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit ,geopos_product_serials.serial,
			geopos_product_serials.id as serial_id,geopos_product_serials.purchase_id,geopos_product_serials.purchase_pid  
			FROM geopos_product_serials  
			LEFT JOIN tbl_warehouse_serials ON geopos_product_serials.id=tbl_warehouse_serials.serial_id 
			LEFT JOIN geopos_products ON geopos_product_serials.product_id=geopos_products.pid 
			WHERE (tbl_warehouse_serials.twid='1' OR tbl_warehouse_serials.twid='0') 
			AND(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<2021-08-26) 
			AND tbl_warehouse_serials.status!=0 && tbl_warehouse_serials.status!=2 &&
                tbl_warehouse_serials.status!=3 && tbl_warehouse_serials.status!=8 && 
				tbl_warehouse_serials.is_present=1 && geopos_product_serials.status!=8
                && geopos_product_serials.status!=0 && geopos_product_serials.status=2 
				&&(UPPER(geopos_product_serials.serial) = '".$name."') LIMIT 1;";
			$query = $this->db->query($sql);
			


			//echo $sql; exit;
    
            if($query->num_rows()==1)
            {
            $result = $query->result_array();
            foreach ($result as $row) {
				//$purchase_record = $this->products->getPurchasePriceByPID($row['purchase_id'],$row['purchase_pid']);
				
				//$purchase_price = $purchase_record[0]['price'];
				$purchase_price = $purchase_record[0]['price'];
                //$name = array($row['product_name'], amountExchange_s($purchase_price, 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                $name = array($row['product_name'], $row['sale_price'], $row['pid'], $row['taxrate'], $row['disrate'], $row['product_des'], $row['unit'], $row['hsn_code'], $row['qty'], $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            } 
        }               
            echo json_encode($name);
        }
    }
	
	
	
    

}