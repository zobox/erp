<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_model extends CI_Model
{
   

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getCountByStatus($status = ''){
		$this->db->where('agency_id',$this->session->userdata('user_details')[0]->agency_id);
		if($status != ''){
			$this->db->where('status',$status);
		}
		$query = $this->db->get('contactus');
		return $query->num_rows();
		
	}

	public function save(){
		$agency_id = $this->session->userdata('user_details')[0]->agency_id;
		$data['agency_id'] = $agency_id;
		$data['mobileno'] = $this->input->post('contactno',true);
		$data['email'] = $this->input->post('email',true);
		$data['name'] = $this->input->post('name',true);
		$data['state'] = $this->input->post('state',true);
		$data['city'] = $this->input->post('city',true);
		$data['pincode'] = $this->input->post('pincode',true);
		$data['shop_type'] = $this->input->post('shop_type',true);
		$data['date'] = date("Y-m-d H:i:s");
		$data['source'] = 'Agent';
		$data['status'] = 1;
		$this->db->insert('contactus',$data);
		$insert_id = $this->db->insert_id();
		$data2['agent_id'] = $agency_id;
		$data2['lead_id'] = $insert_id;
		$data2['date_created'] = date("Y-m-d H:i:s");
		$this->db->insert('geopos_leads_by_agent',$data2);
		$this->load->model('Sms_model','sms');
		$this->db->select('name');
		$this->db->where('id',$agency_id);
		$query = $this->db->get('agency_registration')->result();
		$message = "Dear management ,\nA lead is added by an agent: ".$query[0]->name." from the dashboard.\nLead Details : \nName : ".$data['name']."\nEmail : ".$data['email']."\nContact No : ".$data['mobileno']."\nCity : ".$data['city']."\nThanks,\nZobot";
		$number = array('6289861127','9732212158','8527626445');
		foreach($number as $row){
			$response = $this->sms->sendSMS($message,$row);
		}
		$this->db->set('msg91_response',$response);
		$this->db->where('id',$insert_id);
		$this->db->update('contactus');
		return true;
		
	}
	
	public function getLeadList($id = ''){
		if($id == ''){
			$agency_id = $this->session->userdata('user_details')[0]->agency_id;
			$this->db->where('agency_id',$agency_id);
			$this->db->order_by('id','desc');
		}else{
			$this->db->where('id',$id);
		}
		
		$query = $this->db->get('contactus');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$stateid = $row->state;
				$this->db->select('name');
				$this->db->where('id',$stateid);
				$state = $this->db->get('state')->result();
				$row->state = $state[0]->name;
				$row->shop = ($row->shop_type == 1)?'Owned':'Rented';
				$this->db->where('lead_id',$row->id);
				$this->db->where('agent_id',$agency_id);
				$check = $this->db->get('geopos_leads_by_agent');
				$row->sourceBY = ($check->num_rows() > 0)?'Ownself':'Website';
				switch($row->status){
					case 1 : $status = 'New';break;
					case 2 : $status = 'Contacted';break;
					case 3 : $status = 'Qualified';break;
					case 4 : $status = 'Proposal sent';break;
					case 5 : $status = 'Converted to Franchise';break;
					case 6 : $status = 'Not Converted to Franchise';break;
					case 7 : $status = 'Junk';break;
					case 8 : $status = 'Test';break;
				}
				$row->status = $status;
				if($status == 'Converted to Franchise'){
					$this->db->select('module');
					$this->db->where('lead_id',$row->id);
					$this->db->where('is_agent',1);
					$fran = $this->db->get('geopos_franchise')->result();
					$row->franchise = ($fran[0]->module == 1 || $fran[0]->module == 2 || $fran[0]->module == 3) ? 1 : 0;
				}else{
					$row->franchise = 0;
				}
				$data[] = $row;
			}
			return $data;
		}
		else{
			return false;
		}
		
	}
	
	public function UpdateLeadStatus($data){
		
		$this->load->model('Sms_model','sms');
		$lead_id = $data['lead_id'];
		$status = $data['status'];
		$agency_id = $this->session->userdata('user_details')[0]->agency_id;
		$agency_record = $this->agency_details($agency_id);
		
		$lead = $this->getLeadList($lead_id);
		
		$last_log = $this->GetLastStatusByLeadId($lead_id);
		
		$last_status = $last_log[0]->status;
		
		
		switch($status){
			case 1 :
				$status_html = "New";break;
			case 2 :
				$status_html = "Contacted";break;
			case 3 :
				$status_html = "Qualified";break;
			case 4 :
				$status_html = "Proposal Sent";break;
			case 5 :
				$status_html = "Coverted to Franchise";break;
			case 6 :
				$status_html = "Not Coverted to Franchise";break;
			case 7 :
				$status_html = "Junk";break;
			default :
				$status_html = "Test";break;
		}
		
		switch($last_status){
			case 1 :
				$last_status_html = "New";break;
			case 2 :
				$last_status_html = "Contacted";break;
			case 3 :
				$last_status_html = "Qualified";break;
			case 4 :
				$last_status_html = "Proposal Sent";break;
			case 5 :
				$last_status_html = "Coverted to Franchise";break;
			case 6 :
				$last_status_html = "Not Coverted to Franchise";break;
			case 7 :
				$last_status_html = "Junk";break;
			default :
				$last_status_html = "Test";break;
		}
		
		$SuperAdminNumber = array('6289861127','9732212158','8527626445');
		$SuperAdminmessage = "Dear Management,\nLead from ".$lead[0]->state." is updated by Agent ".$agency_record[0]->name." from ".$last_status_html."\nto ".$status_html.". Stay Tuned for more Updates.";
		//$response = $this->sendSMS($SuperAdminmessage,$SuperAdminNumber);
		foreach($SuperAdminNumber as $row){
			//echo $SuperAdminmessage;die;
			//$response = $this->sms->sendSMS($SuperAdminmessage,$row);
		}
		
		$mailto = array('shuvankar.cartnyou@gmail.com','jaydeepsarkar@gmail.com','devendra.cartnyou@gmail.com');
		$mailtotitle='ZOBOX'; 
		$subject='Greeting From Zobox'; 
		$message = 'Dear Management,<br><br>Lead from '.$lead[0]->state.' is updated by Agent '.$agency_record[0]->name.' from '.$last_status_html.' to '.$status_html.'. Stay Tuned for more Updates. <br><br>
		Thank You'; 		
		$attachmenttrue = false; 
		$attachment = '';	
		foreach($mailto as $mailrow){
			//$email_response = $this->communication->send_email($mailrow, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
		}
		
		
		$data = array();
		$data['status'] = $status;	
		$data['date_modified']=date('Y-m-d H:i:s');	
		$this->db->where('id', $lead_id);
		$this->db->update('contactus',$data);
		
		$data1['logged_user_id'] = $agency_id;
		$data1['lead_id'] = $lead_id;
		$data1['assign_to'] = $agency_id;
		$data1['status'] = $status;
		$data1['date_created'] = date('Y-m-d H:i:s');	
		$data1['is_agent'] = 1;	
		$this->db->insert('history_log',$data1);
		$data1 = array();
		if($status == 5){
			$data1['logged_user_id'] = $agency_id;
			$data1['lead_id'] = $lead_id;
			$data1['status'] = $status;
			$data1['date_created'] = date('Y-m-d H:i:s');	
			$data1['is_agent'] = 1;		
			$this->db->insert('geopos_franchise',$data1);
			//echo $this->db->last_query();die;
			}
			
		return 'Status changed to '.$status_html.' from '.$last_status_html; 
	
	}
	
	public function agency_details($agency_id){
		$this->db->where('id',$agency_id);
		$query = $this->db->get('agency_registration');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
				return $data;
			}
		}else{
			return false;
		}
	}
	
	public function GetLastStatusByLeadId($lead_id){
		
		$this->db->where('lead_id', $lead_id);
		$this->db->limit(1);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get("history_log");
		//echo $this->db->last_query();die;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->state_name = $this->GetStateById($row->state);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetStateById($id) {		
		$this->db->where('id', $id);
		$query = $this->db->get("state");
		//echo $this->db1->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data = $row->name;
			}			
			return $data;
		}
		return false;
	}
	
	public function getStatusHtml(){
		$this->db->select('status');
		$this->db->where('id',$this->input->post('id',true));
		$query = $this->db->get('contactus')->result();
		return $query[0]->status;
	}
	
    public function getFranchiseIdByLeadId($lead_id){
		$this->db->select('id');
		$this->db->where('lead_id',$lead_id);
		$query = $this->db->get('geopos_franchise')->result();
		return $query[0]->id;
	} 
	public function details($franchiseid,$loc=true)
    {        
        $this->db->where('id', $franchiseid);        
        $query = $this->db->get('geopos_franchise');
        return $query->row_array();
    }


}