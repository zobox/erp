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

class Dashboard_model extends CI_Model
{
   

    public function __construct()
    {
        parent::__construct();
    }

	public function lead_count(){
		$agency_id = $this->session->userdata('user_details')[0]->agency_id;
		$this->db->where('agency_id',$agency_id);
		$query = $this->db->get('contactus');
		$data['total'] = $query->num_rows();
		$this->db->where('agent_id',$agency_id);
		$query2 = $this->db->get('geopos_leads_by_agent');
		if($query2->num_rows() > 0){
			$data['from_web'] = $data['total'] - $query2->num_rows();
			$data['own'] = $query2->num_rows();
		}
		else{
			$data['from_web'] = $data['total'] - $query2->num_rows();
			$data['own'] = $query2->num_rows();
		}
		return $data;
		
		
	}
	
	public function leadlist(){
		$users_id = $this->session->userdata('user_details')[0]->users_id;
		$agency_id = $this->session->userdata('user_details')[0]->agency_id;
		$this->db->where('agency_id',$agency_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get('contactus');
		if($query->num_rows() > 0){
			foreach($query->result() as $row)
			{
				$arr['name'] = $row->name; 
				$arr['email'] = $row->email;
				$arr['contactNo'] = $row->mobileno;
				$stateid = $row->state;
				$this->db->select('name');
				$this->db->where('id',$stateid);
				$state = $this->db->get('state')->result();
				$arr['stateid'] = $stateid;
				$arr['state'] = $state[0]->name;
				$arr['city'] = $row->city;
				$arr['pincode'] = $row->pincode;
				$arr['shop_type'] = ($row->shop_type == 0) ? 'Rented' : 'Owned';
				$data[] = $arr;
			}
			return json_encode($data);
		}
		return false;
	}


     


}