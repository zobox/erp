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

class Imei_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status', null);
    var $column_search = array('geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total','geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function getSerialDetails($serial)
    {
        $this->db->select('a.serial,b.status,b.twid,b.is_present,b.hold_status,e.tid,c.title as warehouse,d.product_name,d.sale_price');
        $this->db->from('geopos_product_serials as a');
		$this->db->join('tbl_warehouse_serials as b', 'b.serial_id = a.id', 'LEFT');
		$this->db->join('geopos_warehouse as c', 'c.id = b.twid', 'LEFT');
		$this->db->join('geopos_products as d', 'd.pid = a.product_id', 'LEFT');
		$this->db->join('geopos_invoices as e', 'e.id = b.invoice_id', 'LEFT');
		
		$this->db->where('a.status !=', 8);
		$this->db->where('a.serial',$serial);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){						
				$data = $row;				
            }
            return $data;
        }
        return false;
    }
	
	
	public function transfer(){
		$serial = $this->input->post('serial');
		$this->save_warehouse_log($serial);
		$twid = $this->input->post('to_warehouses');
		$p_s_d = $this->getRecordByProductSerial($serial);
		$serial_id = $p_s_d->id;
		$data = array(
			'twid' => $twid			
		);
		
		$this->db->set($data);
		$this->db->where('serial_id', $serial_id);
		$this->db->update('tbl_warehouse_serials');	
		echo json_encode(array('status' => 'Success', 'message' =>
               "IMEI transfer Sucessfully !"));
	}
	
	
	public function save_warehouse_log($serial){
		$p_s_d = $this->getRecordByProductSerial($serial);
		$w_s_d = $this->getRecordByWarehouseSerialId($p_s_d->id);
		
		
		// Save Warehouse Serial Log
		$ws = array(            
			'warehouse_serial_id' => $w_s_d->id,
			'pid' => $w_s_d->pid,
			'serial_id' => $w_s_d->serial_id,
			'invoice_id' => $w_s_d->invoice_id,
			'fwid' => $w_s_d->fwid,
			'twid' => $w_s_d->twid,
			'logged_user_id' => $w_s_d->logged_user_id,
			'date_created' => $w_s_d->date_created,
			'date_modified' => date('Y-m-d H:i:s'),
			'status' => $w_s_d->status,
			'is_present' => $w_s_d->is_present,			
			'hold_status' => $w_s_d->hold_status			
		);			
		$this->db->insert('tbl_warehouse_serials_log',$ws);
	}
	
	public function getRecordByProductSerial($serial){
		$this->db->where('serial', $serial);
		$this->db->where('status !=', 8);
		$query = $this->db->get('geopos_product_serials');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;
			}
			return $data;
		}
		return false;
	}
	
	
	public function getRecordByWarehouseSerialId($serial_id){
		$this->db->where('serial_id', $serial_id);		
		$query = $this->db->get('tbl_warehouse_serials');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;
			}
			return $data;
		}
		return false;
	}
	
	
	
}