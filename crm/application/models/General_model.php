<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
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

class General_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function public_key()
    {
     $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s,method AS bank,other AS acid,active AS ext1');
        $this->db->from('univarsal_api');
        $this->db->where('id', 53);
        $query = $this->db->get();
        return $query->row();
    }
    
	public function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
    }
	
	
	public function getWarehouseByEmpID($eid)
    {
		$this->db->select('c.*,a.name,a.id as employee_id,b.name,b.id as franchise_id');		
		$this->db->from("geopos_employees as a");
		$this->db->join('geopos_customers as b', 'b.id = a.franchise_id', 'INNER');
		$this->db->join('geopos_warehouse as c', 'b.id = c.cid', 'INNER');		
		$this->db->where('a.id',$eid);
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
    }
	
	public function getSerial($pid,$wid)
    {
    	$this->db->select('b.serial,c.pid,c.sale_price,c.product_name,c.product_code,c.pcat,c.image,b.id');		
		$this->db->from("tbl_warehouse_serials as a");
		$this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');			
		$this->db->join('geopos_products as c', 'c.pid = b.product_id', 'left');			
		$this->db->where("a.twid",$wid);
		$this->db->where("a.status",1);
		$this->db->where("b.product_id",$pid);
		
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$row->category = $this->GetParentCatTitleById($row->pcat);
				$data[] = $row;				
            }
            return $data;
        }
        return false;
    }
	
	
	public function getWarehouseByUserID($uid)
    {
		$this->db->select('c.*,a.name as username,b.name as customer_name,b.id as customer_id');		
		$this->db->from("users as a");
		$this->db->join('geopos_customers as b', 'b.id = a.cid', 'INNER');
		$this->db->join('geopos_warehouse as c', 'a.cid = c.cid', 'INNER');		
		$this->db->where('a.users_id',$uid);
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
    }
	
	public function getProduct($wid){
		$this->db->select('count(a.id) as avlqty,c.pid,c.sale_price,c.product_name,c.product_code,c.pcat,c.image');		
		$this->db->from("tbl_warehouse_serials as a");
		$this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');			
		$this->db->join('geopos_products as c', 'c.pid = b.product_id', 'left');			
		$this->db->where("a.twid",$wid);
		$this->db->where("a.status",1);
		$this->db->group_by('c.pid');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$row->category = $this->GetParentCatTitleById($row->pcat);
				$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function GetParentCatTitleById($rel_id)
    { 		
		$this->db->where("id",$rel_id);		
		$query = $this->db->get("geopos_product_cat");		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				if($row->rel_id !=0){
					$ptitle = $this->GetParentCatTitleById($row->rel_id);
					$row->title = $ptitle.' &rArr; '.$row->title;
				}
				return $row->title;
			}				
		}
		return false;
    }


}