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

class Agency_model extends CI_Model
{
	public function GetRecords() {
		$query = $this->db->get('agency_registration')->result_array();
		//echo $this->db->last_query();die;
		foreach($query as $row){
			$state_id = $row['state'];
			$this->db->where('id',$state_id);
			$query2 = $this->db->get('state')->result_array();
			$row['state_name'] = $query2[0]['name'];
			$data[] = $row;
		}
		return $data;
	}
	
	public function activateuser($regId){
		
		$this->db->where('id',$regId);
		$query = $this->db->get('agency_registration')->result_array();
		if($query[0]['agency_type'] == 1 || $query[0]['agency_type'] == 2){
			if($query[0]['valid'] == 4){
			$row['status'] = 'deactive';
			$this->db->where('agency_id',$regId);
			$this->db->update('users_agency',$row);
			$data['status'] = 5;
			$data['valid'] = 5;
		}
		else{
			$this->db->where('agency_id',$regId);
			$agency_user_details_query = $this->db->get('users_agency');
			if($agency_user_details_query->num_rows() > 0){
				$row['status'] = 'active';
				$this->db->where('agency_id',$regId);
				$this->db->update('users_agency',$row);
			}
			else{
				$row['agency_id'] = $regId;
				$row['name'] = $query[0]['name'];
				$row['email'] = $query[0]['email'];
				$password =  rand(200000, 999999);
				$row['hass_p'] = $password;
				$pass = password_hash($password, PASSWORD_DEFAULT);
				$row['password'] = $pass;
				$this->db->insert('users_agency',$row);
			}
			$data['status'] = 4;
			$data['valid'] = 4;
		}
		$this->db->where('id',$regId);
		$this->db->update('agency_registration',$data);
		}
		return true;
	}
	
	
	public function getAgencyDataById($agencyId){
		$this->db->where('id',$agencyId);
		$query = $this->db->get('agency_registration');
		foreach($query->result() as $key=>$row){
			$state_id = $row->state;
			$this->db->where('id',$state_id);
			$query2 = $this->db->get('state')->result_array();
			$state_name = $query2[0]['name'];
			$row->state_name = $state_name;
			$data[] = $row;
		}
		return $data;
	}
}