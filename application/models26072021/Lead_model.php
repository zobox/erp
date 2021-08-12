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

class Lead_model extends CI_Model
{
	var $table = 'contactus';
    var $column_order = array(null, 'contactus.name', 'contactus.business_address', 'geopos_customers.email', 'geopos_customers.phone', null);
    var $column_search = array('geopos_customers.name', 'geopos_customers.phone', 'geopos_customers.address', 'geopos_customers.city', 'geopos_customers.email', 'geopos_customers.docid');
    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);
    var $trans_column_search = array('id', 'date');
    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('id' => 'desc');
    var $inv_order = array('geopos_invoices.tid' => 'desc');
    var $qto_order = array('geopos_quotes.tid' => 'desc');
    var $notecolumn_order = array(null, 'title', 'cdate', null);
    var $notecolumn_search = array('id', 'title', 'cdate');
    var $pcolumn_order = array('geopos_projects.status', 'geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.worth', null);
    var $pcolumn_search = array('geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.status');
    var $ptcolumn_order = array('status', 'name', 'duedate', 'start', null, null);
    var $ptcolumn_search = array('name', 'edate', 'status');
    var $porder = array('id' => 'desc');


    private function _get_datatables_query($id = '')
    {
        $due = $this->input->post('due');
        if ($due) {

            $this->db->select('geopos_customers.*,SUM(geopos_invoices.total) AS total,SUM(geopos_invoices.pamnt) AS pamnt');
            $this->db->from('geopos_invoices');
            $this->db->where('geopos_invoices.status!=', 'paid');
            $this->db->join('geopos_customers', 'geopos_customers.id = geopos_invoices.csd', 'left');
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_customers.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_customers.loc', 0);
            }
            if ($id != '') {
                $this->db->where('geopos_customers.gid', $id);
            }
            $this->db->group_by('geopos_invoices.csd');
            $this->db->order_by('total', 'desc');

        } else {
            $this->db->from($this->table);
            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            if ($id != '') {
                $this->db->where('gid', $id);
            }

        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
		
	public function GetTotalRecord() {			
		$this->db->select('count(*) as total');		
		$query = $this->db->get("contactus");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10){		
		$status	= $this->input->post('status');		
		$source	= $this->input->post('source');		
		$assign_name = $this->input->post('assign_name');		
		$lead_date	= $this->input->post('lead_date');
		
		if($status!=''){
			$this->db->where('status', $status);	
		}
		
		if($source!=''){
			$this->db->where('source', $source);	
		}
		
		if($assign_name!=''){
			$this->db->where('assign_to', $assign_name);	
		}	
		
		$this->db->order_by("id", "desc");
		$query = $this->db->get("contactus");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				$row->state_name = $this->GetStateById($row->state);				
				$row->history = $this->GetLeadStatusLogByLeadId($row->id);
				$row->employee = $this->GetEmployeesById($row->assign_to);
				$row->agent_details = $this->agency->getAgencyDataById($row->agency_id);
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
	
	public function GetLeadById($id) {		
		$this->db->where('id', $id);
		$query = $this->db->get("contactus");
		//echo $this->db1->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->state_name = $this->GetStateById($row->state);
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetTotalRecordByStatus($status='') {
		$this->db->where('status', $status);	
		$this->db->select('count(*) as total');		
		$query = $this->db->get("contactus");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetTotalNotificationLeadsByUser($employee_id='') {
		$this->db->where('notification_view_status', 0);	
		$this->db->where('assign_to', $employee_id);	
		$this->db->select('count(*) as total');		
		$query = $this->db->get("contactus"); 
		//echo $this->db->last_query(); //exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	
	public function GetEmployees() {		
		//$this->db1->limit($limit,$start);
		$query = $this->db->get("geopos_employees");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetEmployeesByRoleId($roleid){
		$this->db->select('b.*,a.roleid');					
		$this->db->from("geopos_users as a");
		$this->db->join("geopos_employees as b","a.id=b.id","Left");		
		$this->db->where('a.roleid',$roleid);		
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
		
	public function GetEmployeesById($id){		
		$this->db->where('id', $id);	
		$query = $this->db->get("geopos_employees");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetLastStatusByLeadId($lead_id){
		$this->db->where('lead_id', $lead_id);
		$this->db->limit(1);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get("history_log");
		//echo $this->db1->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->state_name = $this->GetStateById($row->state);
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function GetSuperAdmins(){		
		$this->db->where('id', $id);	
		$query = $this->db->get("geopos_employees");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function savelead($leads){
		
		foreach($leads as $lead_data){
			$lead_record = $this->GetRecordsByLeadId($lead_data->table_id);
			if($lead_record->id != ""){
							
			}else{
				$data = array();						
						$data['lead_id'] = $lead_data->table_id;						
						$data['Name'] = $lead_data->name;						
						$data['Email'] = $lead_data->email;						
						$data['Mobile'] = $lead_data->mobileno;						
						$data['leaddate'] = date('Y-m-d',strtotime($lead_data->date));						
						$data['State'] = $lead_data->state;						
						$data['City'] = $lead_data->city;						
						$data['Pincode'] = $lead_data->pincode;						
						$data['ShopType'] = $lead_data->shop_type;
						
				$this->db->insert('tbl_lead',$data);
				//echo $this->db->last_query(); 				
			}			
		}		
		return true;
	}	
	
	public function updatelead(){
		$AssignTo = $this->input->post('assign_to');	
		$Status = $this->input->post('status');	
		$data = array();	
		$data1 = array();	
		
		foreach($AssignTo as $key=>$AssignTo_data){	
			$employee_record = $this->GetEmployeesById($AssignTo_data);
						
			$mobileNumber = $employee_record->phone;
			$message_content = "Mr. ".$employee_record->name.", a new lead is assigned to you. Please visit http://erp.zobox.in for more info."; 
			//$response = $this->sendSMS($message_content,$mobileNumber);
			
			$data['assign_to'] = $AssignTo_data;						
			$data['msg91_response'] = $response;						
			$data['status'] = $Status[$key];				
			$data['date_modified']=date('Y-m-d H:i:s');		
			$this->db->where('id', $key);
			$this->db->update('contactus',$data);		
			
			$data1['logged_user_id'] = $_SESSION['id'];
			$data1['lead_id'] = $key;
			$data1['assign_to'] = $AssignTo_data;
			$data1['status'] = $Status[$key];
			$data1['date_created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('history_log',$data1);
			//echo $this->db->last_query(); exit; 
		} 
	}	
	
	public function assignLead($assigntoData){
		$assignto_array = explode('-',$assigntoData);		
		$lead_id = $assignto_array[0];
		$assign_to = $assignto_array[1];
		//$employee_record = $this->GetEmployeesById($assign_to);			
		$employee_record = $this->employee->employee_details($assign_to);
		
		$this->db->where('id',$lead_id);
		$lead_details = $this->db->get('contactus')->result_array();
		foreach($lead_details as $lead_details_row){
			$lead['name'] = $lead_details_row['name'];
			$lead['email'] = $lead_details_row['email'];
			$lead['mobileno'] = $lead_details_row['mobileno'];
			$lead['state'] = $lead_details_row['state'];
		}
		
		$this->db->where('id',$lead['state']);
		$leadState = $this->db->get('state')->result_array();
		foreach($leadState as $rowState){
			$lead['stateName'] = $rowState['name'];
		}
		
		
		//Send SMS To RSM 				
		$RSMNumber = $employee_record['phone'];
		//$RSMNumber = '9732212158';
		$RSMmessage = "Dear ".$employee_record['name'].", Greetings from ZOBOX Management. Congratulations !! There is a new Lead on your Dashboard, Kindly Follow Up.\n\t";
		$RSMmessage .= "Lead Details :\n\t";
		$RSMmessage .= "Name : ".$lead['name'];
		$RSMmessage .= "\n\tEmail : ".$lead['email'];
		$RSMmessage .= "\n\tContact no : ".$lead['mobileno'];
		$RSMmessage .= "\n\tState : ".$lead['stateName'];
		$RSMmessage .= "\n\tAll the Best.";
		
		$response = $this->sendSMS($RSMmessage,$RSMNumber);
		
		//Send Email To RSM
		$mailto = $employee_record['email'];
		//$mailto = 'jroysarkar@gmail.com';
		$mailtotitle='ZOBOX'; 
		$subject='Greeting From Zobox'; 
		$message = 'Dear '.$employee_record['name'].',<br><br>Greetings from ZOBOX Management. Congratulations !! There is a new Lead on your Dashboard, Kindly Follow Up.<br>';
		$message .= "<br>Lead Details :";
		$message .= "<br>Name : ".$lead['name'];
		$message .= "<br>Email : ".$lead['email'];
		$message .= "<br>Contact no : ".$lead['mobileno'];
		$message .= "<br>State : ".$lead['stateName'];
		$message .= "All the Best. <br>";
		$message .= '<br>Thank You'; 
		$attachmenttrue = false; 
		$attachment = '';	
		$email_response = $this->communication_model->send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
				
		//Send SMS To Management 
		$SuperAdminNumber = '9599900999,8295168000,8383880632,9650589864';
		//$SuperAdminNumber = '8527626445';
		$SuperAdminmessage = "Dear Management, The Lead has been assigned to Mr. ".$employee_record['name'].". Stay Tuned for further updates. Have a Blessed Day."; 
		$response = $this->sendSMS($SuperAdminmessage,$SuperAdminNumber);
		
		
		//Send Email To Management
		$mailto = 'neeraj@zobox.in,harish@zobox.in,jitendra@zobox.in';
		//$mailto = 'jroysarkar@gmail.com';
		$mailtotitle='ZOBOX'; 
		$subject='Greeting From Zobox'; 
		$message = 'Dear Management,<br><br>The Lead has been assigned to Mr. '.$employee_record['name'].'. Stay Tuned for further updates. Have a Blessed Day.<br><br>
		Thank You'; 		
		$attachmenttrue = false; 
		$attachment = '';	
		$email_response = $this->communication_model->send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
		
		
			
		$data['assign_to'] = $assign_to;						
		$data['status'] = 'New';						
		$data['msg91_response'] = $response;
		$data['email_response'] = $email_response;
		$data['date_modified']=date('Y-m-d H:i:s');		
		$this->db->where('id', $lead_id);
		$this->db->update('contactus',$data);		
		
		$data1['logged_user_id'] = $_SESSION['id'];
		$data1['lead_id'] = $lead_id;
		$data1['assign_to'] = $assign_to;		
		$data1['date_created'] = date('Y-m-d H:i:s');
		
		$this->db->insert('history_log',$data1);
		return true;
	}	
	
	public function  assignLeadEmp($assigntoData){
		$type = $this->input->post('type');
		$assignto_array = explode('-',$assigntoData);		
		$lead_id = $assignto_array[0];
		$assign_to = $assignto_array[1];
					
		$data['assign_to'] = $assign_to;						
		$data['assign_emp_type'] = $type;						
		//$data['status'] = 'New';						
		//$data['msg91_response'] = $response;
		//$data['email_response'] = $email_response;
		$data['date_modified']=date('Y-m-d H:i:s');		
		$this->db->where('id', $lead_id);
		$this->db->update('contactus',$data);
		//echo $this->db->last_query(); 
		
		$data1['logged_user_id'] = $_SESSION['id'];
		$data1['lead_id'] = $lead_id;
		$data1['assign_to'] = $assign_to;
		$data['assign_emp_type'] = $type;
		$data1['date_created'] = date('Y-m-d H:i:s');
		
		$this->db->insert('history_log',$data1);
		return true;
	}
	
	
	public function UpdateLeadStatus($status_data){	
	
		$status_array = explode('-',$status_data);
		$lead_id = $status_array[0];
		$status = $status_array[1];
		
		//$employee_record = $this->GetEmployeesById($_SESSION['id']);
		$employee_record = $this->employee->employee_details($_SESSION['id']);
		$lead = $this->GetLeadById($lead_id);
		$last_log = $this->GetLastStatusByLeadId($lead_id); 
		$last_status = $last_log->status;
		
		
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
			case 8 :
				$status_html = "Test";break;
			case 9 :
				$status_html = "Local Verification";break;
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
			case 8 :
				$status_html = "Test";break;
			case 9 :
				$status_html = "Local Verification";break;
			default :
				$last_status_html = "Test";break;
		}
		
		//For Super admin 
		//$SuperAdminNumber = '9599900999,8295168000,8383880632,9650589864';
		if($status==9){
			$SuperAdminNumber = '8527626445,9732212158,6289861127,9717794224';
		}else{
			$SuperAdminNumber = '8527626445,9732212158,6289861127';
		}
		$SuperAdminmessage = "Dear Management, Lead from ".$lead->state_name." by ".$employee_record['name']." is updated from ".$last_status_html." to ".$status_html.". Stay Tuned for more Updates."; 
		$response = $this->sendSMS($SuperAdminmessage,$SuperAdminNumber);		
		
		//Send Email To Management
		//$mailto = 'neeraj@zobox.in,harish@zobox.in,jitendra@zobox.in';
		$mailto = 'jroysarkar@gmail.com,shuvankar.cartnyou@gmail.com';
		$mailtotitle='ZOBOX'; 
		$subject='Greeting From Zobox'; 
		$message = 'Dear Management,<br><br>Lead from '.$lead->state_name.' by '.$employee_record['name'].' is updated from '.$last_status_html.' to '.$status_html.'. Stay Tuned for more Updates. <br><br>
		Thank You'; 		
		$attachmenttrue = false; 
		$attachment = '';	
		$email_response = $this->communication_model->send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
				
		
		$data = array();	
		
			$data['status'] = $status;				
			$data['date_modified']=date('Y-m-d H:i:s');		
			$this->db->where('id', $lead_id);
			$this->db->update('contactus',$data);
			
			$data1['logged_user_id'] = $_SESSION['id'];
			$data1['lead_id'] = $lead_id;
			$data1['status'] = $status;
			$data1['date_created'] = date('Y-m-d H:i:s');			
			$this->db->insert('history_log',$data1);
			
			if($status==5){
				$data1['logged_user_id'] = $_SESSION['id'];
				$data1['lead_id'] = $lead_id;
				$data1['status'] = $status;
				$data1['date_created'] = date('Y-m-d H:i:s');			
				$this->db->insert('geopos_franchise',$data1);
			}
			
			return true; 
	}
	
	
	
	public function GetLeadStatusLogByLeadId($lead_id){		
		$this->db->where('lead_id', $lead_id);	
		$this->db->where('status !=', '');	
		$query = $this->db->get("history_log");
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function statusCounts($assign_name='',$status='',$source=''){		
		if($source)
		$this->db->where('source', $source);
		if($assign_name)
		$this->db->where('assign_to', $assign_name);
		if($status)
		$this->db->where('status', $status);
		
		$this->db->select('count(*) as total');		
		$query = $this->db->get("contactus"); 
		//echo $this->db->last_query(); //exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
	}
	
	
	public function sendSMS($message_content,$mobileNumber){
		//$message_content = "Hi ".$name.", thanks for showing interest in the Zobox platform. Our team will contact you within 24 hours. Stay connected with the Zobox platform for the latest update https://www.zobox.in";
	
		// Code Start Here Send SMS
		//Your authentication key
		$authKey = "181687AllIYkeF5ff8166dP1";

		//Multiple mobiles numbers separated by comma
		//$mobileNumber = $mobileno;

		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = "ZOBOXX";

		//Your message to send, Add URL encoding here.
		$message = urlencode($message_content);

		//Define route 
		$route = "default";
		//Prepare you post parameters
		$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route
		);

		//API URL
		$url="http://api.msg91.com/api/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));


		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		//get response
		$output = curl_exec($ch);

		//Print error if any
		if(curl_errno($ch))
		{
			$msg_response = 'error:' . curl_error($ch);
		}else{
			$msg_response = 'sucess:' . $output;
		}

		curl_close($ch);
		
		return $msg_response;
		//echo $output;
	}
	
	
	public function sendemailsmtp($recipient,$subject,$bodyHtml){		
		$this->load->library('email');

		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'hello@zobox.in';
		$config['smtp_pass']    = 'Hello@123';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      

		$this->email->initialize($config);

		$this->email->from('hello@zobox.in', 'sender_name');
		$this->email->to($recipient); 
		$this->email->subject($subject);
		$this->email->message($bodyHtml);  

		$this->email->send();

		//echo $this->email->print_debugger();
	}
	
	
	public function UpdateLeadStatusMultiple(){			
		$status = $this->input->post('status');	
		$data = array();	
		
			$data['status'] = $status;				
			$data['date_modified']=date('Y-m-d H:i:s');		
			$this->db->where('id', $key);
			$this->db->update('contactus',$data);
			
			$data1['logged_user_id'] = $_SESSION['id'];
			$data1['lead_id'] = $key;
			$data1['status'] = $status;
			$data1['date_created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('history_log',$data1);
			//echo $this->db->last_query(); exit; 
	}
	
	
	public function updateleadnotificationstatus(){			
		$data = array();
		
		$data['notification_view_status'] = 1;				
		$data['date_modified']=date('Y-m-d H:i:s');		
		$this->db->where('assign_to', $_SESSION['id']);
		$this->db->update('contactus',$data);
		//echo $this->db->last_query(); exit;		
	}

	
	public function GetRecordsByLeadId($lead_id) {		
		$this->db->where('lead_id', $lead_id);
		$query = $this->db->get("tbl_lead");
		//echo $this->db1->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->aauth->get_user()->loc) {
           // $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_customers.gid', $id);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_customers.loc', $this->aauth->get_user()->loc);
        }
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_customers.loc', $this->aauth->get_user()->loc);
        }
        if ($id != '') {
            $this->db->where('geopos_customers.gid', $id);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function details($custid,$loc=true)
    {
        $this->db->select('geopos_customers.*,users.lang');
        $this->db->from($this->table);
        $this->db->join('users', 'users.cid=geopos_customers.id', 'left');
        $this->db->where('geopos_customers.id', $custid);
        if($loc) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_customers.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_customers.loc', 0);
            }
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($custid)
    {

        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('geopos_transactions');
        $this->db->where('payerid', $custid);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function due_details($custid)
    {

        $this->db->select('SUM(total) AS total,SUM(pamnt) AS pamnt,SUM(discount) AS discount,');
        $this->db->from('geopos_invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $language = '', $create_login = true, $password = '', $docid = '', $custom = '', $discount = 0)
    {
        $this->db->select('email');
        $this->db->from('geopos_customers');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $valid = $query->row_array();
        if (!$valid['email']) {


            if (!$discount) {
                $this->db->select('disc_rate');
                $this->db->from('geopos_cust_group');
                $this->db->where('id', $customergroup);
                $query = $this->db->get();
                $result = $query->row_array();
                $discount = $result['disc_rate'];
            }


            $data = array(
                'name' => $name,
                'company' => $company,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'postbox' => $postbox,
                'gid' => $customergroup,
                'taxid' => $taxid,
                'name_s' => $name_s,
                'phone_s' => $phone_s,
                'email_s' => $email_s,
                'address_s' => $address_s,
                'city_s' => $city_s,
                'region_s' => $region_s,
                'country_s' => $country_s,
                'postbox_s' => $postbox_s,
                'docid' => $docid,
                'custom1' => $custom,
                'discount_c' => $discount
            );


            if ($this->aauth->get_user()->loc) {
                $data['loc'] = $this->aauth->get_user()->loc;
            }

            if ($this->db->insert('geopos_customers', $data)) {
                $cid = $this->db->insert_id();
                $p_string = '';
                $temp_password = '';
                if ($create_login) {

                    if ($password) {
                        $temp_password = $password;
                    } else {
                        $temp_password = rand(200000, 999999);
                    }

                    $pass = password_hash($temp_password, PASSWORD_DEFAULT);
                    $data = array(
                        'user_id' => 1,
                        'status' => 'active',
                        'is_deleted' => 0,
                        'name' => $name,
                        'password' => $pass,
                        'email' => $email,
                        'user_type' => 'Member',
                        'cid' => $cid,
                        'lang' => $language
                    );

                    $this->db->insert('users', $data);
                    $p_string = ' Temporary Password is ' . $temp_password . ' ';
                }
                $this->aauth->applog("[Client Added] $name ID " . $cid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . $p_string . '&nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password, 'discount' => amountFormat_general($discount)));

                $this->custom->save_fields_data($cid, 1);

                $this->db->select('other');
                $this->db->from('univarsal_api');
                $this->db->where('id', 64);
                $query = $this->db->get();
                $othe = $query->row_array();

                if ($othe['other']) {
                    $auto_mail = $this->send_mail_auto($email, $name, $temp_password);
                    $this->load->model('communication_model');
                    $attachmenttrue = false;
                    $attachment = '';
                    $this->communication_model->send_corn_email($email, $name, $auto_mail['subject'], $auto_mail['message'], $attachmenttrue, $attachment);
                }

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Duplicate Email'));
        }

    }


    public function edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $docid = '', $custom = '', $language = '', $discount = 0)
    {
        $data = array(
            'name' => $name,
            'company' => $company,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'gid' => $customergroup,
            'taxid' => $taxid,
            'name_s' => $name_s,
            'phone_s' => $phone_s,
            'email_s' => $email_s,
            'address_s' => $address_s,
            'city_s' => $city_s,
            'region_s' => $region_s,
            'country_s' => $country_s,
            'postbox_s' => $postbox_s,
            'docid' => $docid,
            'custom1' => $custom,
            'discount_c' => $discount
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }

        if ($this->db->update('geopos_customers')) {
            $data = array(
                'name' => $name,
                'email' => $email,
                'lang' => $language
            );
            $this->db->set($data);
            $this->db->where('cid', $id);
            $this->db->update('users');
            $this->aauth->applog("[Client Updated] $name ID " . $id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));

            $this->custom->edit_save_fields_data($id, 1);
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function changepassword($id, $password)
    {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'password' => $pass
        );


        $this->db->set($data);
        $this->db->where('cid', $id);

        if ($this->db->update('users')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        if ($this->db->update('geopos_customers') AND $result['picture'] != 'example.png') {

            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);
            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);
        }


    }

    public function group_list()
    {
        $whr = "";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE (geopos_customers.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE (geopos_customers.loc=" . $this->aauth->get_user()->loc . " OR geopos_customers.loc=0 ) ";
        } elseif (!BDATA) {
            $whr = "WHERE  geopos_customers.loc=0  ";
        }

        $query = $this->db->query("SELECT c.*,p.pc FROM geopos_cust_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM geopos_customers $whr GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }

    public function delete($id)
    {


        if ($this->aauth->get_user()->loc) {
            $this->db->delete('geopos_customers', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));

        } elseif (!BDATA) {
            $this->db->delete('geopos_customers', array('id' => $id, 'loc' => 0));
        } else {
            $this->db->delete('geopos_customers', array('id' => $id));
        }

        if ($this->db->affected_rows()) {
            $this->aauth->applog("[Client Deleted]  ID " . $id, $this->aauth->get_user()->username);
            $this->db->delete('users', array('cid' => $id));
            $this->custom->del_fields($id, 1);
            $this->db->delete('geopos_notes', array('fid' => $id, 'rid' => 1));
            //docs
            $this->db->select('filename');
            $this->db->from('geopos_documents');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($this->db->delete('geopos_documents', array('fid' => $id, 'rid' => 1))) {
                @unlink(FCPATH . 'userfiles/documents/' . $result['filename']);
                $this->aauth->applog("[Client Doc Deleted]  DocId $id CID " . $id, $this->aauth->get_user()->username);
                //docs

            }
            return true;
        }

    }


    //transtables

    function trans_table($id)
    {
        $this->_get_trans_table_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    private function _get_trans_table_query($id)
    {

        $this->db->from('geopos_transactions');
        $this->db->where('payerid', $id);
        $this->db->where('ext', 0);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $i = 0;
        foreach ($this->trans_column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->trans_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function trans_count_filtered($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function trans_count_all($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
    }

    private function _inv_datatables_query($id, $tyd = 0)
    {
        $this->db->select('geopos_invoices.*');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.csd', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }

        if ($tyd) $this->db->where('geopos_invoices.i_class>', 1);
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function inv_datatables($id, $tyd = 0)
    {
        $this->_inv_datatables_query($id, $tyd);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function inv_count_filtered($id)
    {
        $this->_inv_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function inv_count_all($id)
    {
        $this->db->from('geopos_invoices');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }


    private function _qto_datatables_query($id, $tyd = 0)
    {
        $this->db->select('geopos_quotes.*');
        $this->db->from('geopos_quotes');
        $this->db->where('geopos_quotes.csd', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_quotes.loc', 0);
        }
        $this->db->join('geopos_customers', 'geopos_quotes.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->qto_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->qto_order)) {
            $order = $this->qto_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function qto_datatables($id, $tyd = 0)
    {
        $this->_qto_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function qto_count_filtered($id)
    {
        $this->_qto_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function qto_count_all($id)
    {
        $this->db->from('geopos_quotes');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }

    public function group_info($id)
    {

        $this->db->from('geopos_cust_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function activity($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_metadata');
        $this->db->where('type', 21);
        $this->db->where('rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recharge($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);

        $this->db->update('geopos_customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s') . ' Account Recharge by ' . $this->aauth->get_user()->username
        );


        if ($this->db->insert('geopos_metadata', $data)) {
            $this->aauth->applog("[Client Wallet Recharge] Amt-$amount ID " . $id, $this->aauth->get_user()->username);
            return true;
        } else {
            return false;
        }

    }

    private function _project_datatables_query($cday = '')
    {
        $this->db->select("geopos_projects.*,geopos_customers.name AS customer");
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');


        $this->db->where('geopos_projects.cid=', $cday);


        $i = 0;

        foreach ($this->pcolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->pcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->porder)) {
            $order = $this->porder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function project_datatables($cday = '')
    {


        $this->_project_datatables_query($cday);

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function project_count_filtered($cday = '')
    {
        $this->_project_datatables_query($cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function project_count_all($cday = '')
    {
        $this->_project_datatables_query($cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //notes

    private function _notes_datatables_query($id)
    {

        $this->db->from('geopos_notes');
        $this->db->where('fid', $id);
        $this->db->where('ntype', 1);
        $i = 0;

        foreach ($this->notecolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->notecolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function notes_datatables($id)
    {
        $this->_notes_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function notes_count_filtered($id)
    {
        $this->_notes_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function notes_count_all($id)
    {
        $this->_notes_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function editnote($id, $title, $content, $cid)
    {

        $data = array('title' => $title, 'content' => $content, 'last_edit' => date('Y-m-d H:i:s'));


        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('fid', $cid);


        if ($this->db->update('geopos_notes')) {
            $this->aauth->applog("[Client Note Edited]  NoteId $id CID " . $cid, $this->aauth->get_user()->username);
            return true;
        } else {
            return false;
        }

    }

    public function note_v($id, $cid)
    {
        $this->db->select('*');
        $this->db->from('geopos_notes');
        $this->db->where('id', $id);
        $this->db->where('fid', $cid);
        $query = $this->db->get();
        return $query->row_array();
    }

    function addnote($title, $content, $cid)
    {
        $this->aauth->applog("[Client Note Added]  NoteId $title CID " . $cid, $this->aauth->get_user()->username);
        $data = array('title' => $title, 'content' => $content, 'cdate' => date('Y-m-d'), 'last_edit' => date('Y-m-d H:i:s'), 'cid' => $this->aauth->get_user()->id, 'fid' => $cid, 'rid' => 1, 'ntype' => 1);
        return $this->db->insert('geopos_notes', $data);

    }

    function deletenote($id, $cid)
    {
        $this->aauth->applog("[Client Note Deleted]  NoteId $id CID " . $cid, $this->aauth->get_user()->username);
        return $this->db->delete('geopos_notes', array('id' => $id, 'fid' => $cid, 'rid' => 1));

    }

    //documents list

    var $doccolumn_order = array(null, 'title', 'cdate', null);
    var $doccolumn_search = array('title', 'cdate');

    public function documentlist($cid)
    {
        $this->db->select('*');
        $this->db->from('geopos_documents');
        $this->db->where('fid', $cid);
        $this->db->where('rid', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function adddocument($title, $filename, $cid)
    {
        $this->aauth->applog("[Client Doc Added]  DocId $title CID " . $cid, $this->aauth->get_user()->username);
        $data = array('title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'), 'cid' => $this->aauth->get_user()->id, 'fid' => $cid, 'rid' => 1);
        return $this->db->insert('geopos_documents', $data);

    }

    function deletedocument($id, $cid)
    {
        $this->db->select('filename');
        $this->db->from('geopos_documents');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $this->db->trans_start();
        if ($this->db->delete('geopos_documents', array('id' => $id, 'fid' => $cid, 'rid' => 1))) {
            if (@unlink(FCPATH . 'userfiles/documents/' . $result['filename'])) {
                $this->aauth->applog("[Client Doc Deleted]  DocId $id CID " . $cid, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                return true;
            } else {
                $this->db->trans_rollback();
                return false;
            }

        } else {
            return false;
        }
    }


    function document_datatables($cid)
    {
        $this->document_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function document_datatables_query($cid)
    {

        $this->db->from('geopos_documents');
        $this->db->where('fid', $cid);
        $this->db->where('rid', 1);
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function document_count_filtered($cid)
    {
        $this->document_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function document_count_all($cid)
    {
        $this->document_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function send_mail_auto($email, $name, $password)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(16);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'NAME' => $name
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'NAME' => $name,
            'EMAIL' => $email,
            'URL' => base_url() . 'crm',
            'PASSWORD' => $password,
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),


        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        return array('subject' => $subject, 'message' => $message);
    }


    public function recipients($ids)
    {

        $this->db->select('id,name,email,phone');
        $this->db->from('geopos_customers');
        $this->db->where_in('id', $ids);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function sales_due($sdate, $edate, $csd, $trans_type, $pay = true, $amount = 0, $acc = 0, $pay_method = '',$note='')
    {
        if ($pay) {
            $this->db->select_sum('total');
            $this->db->select_sum('pamnt');
            $this->db->from('geopos_invoices');
            $this->db->where('DATE(invoicedate) >=', $sdate);
            $this->db->where('DATE(invoicedate) <=', $edate);
            $this->db->where('csd', $csd);
            $this->db->where('status', $trans_type);
            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }

            $query = $this->db->get();
            $result = $query->row_array();
            return $result;
        } else {
            if ($amount) {
                $this->db->select('id,tid,total,pamnt');
                $this->db->from('geopos_invoices');
                $this->db->where('DATE(invoicedate) >=', $sdate);
                $this->db->where('DATE(invoicedate) <=', $edate);
                $this->db->where('csd', $csd);
                $this->db->where('status', $trans_type);
                if ($this->aauth->get_user()->loc) {
                    $this->db->where('loc', $this->aauth->get_user()->loc);
                } elseif (!BDATA) {
                    $this->db->where('loc', 0);
                }

                $query = $this->db->get();
                $result = $query->result_array();
                $amount_custom = $amount;

                foreach ($result as $row) {
                    $note.=' #'.$row['tid'];
                    $due = $row['total'] - $row['pamnt'];
                    if ($amount_custom >= $due) {
                        $this->db->set('status', 'paid');
                        $this->db->set('pamnt', "pamnt+$due", FALSE);
                        $amount_custom = $amount_custom - $due;
                    } elseif ($amount_custom > 0 AND $amount_custom < $due) {
                        $this->db->set('status', 'partial');
                        $this->db->set('pamnt', "pamnt+$amount_custom", FALSE);
                        $amount_custom = 0;
                    }

                    $this->db->set('pmethod', $pay_method);
                    $this->db->where('id', $row['id']);
                    $this->db->update('geopos_invoices');

                    if ($amount_custom == 0) break;

                }
                  $this->db->select('id,holder');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acc);
        $query = $this->db->get();
        $account = $query->row_array();

                        $data = array(
            'acid' => $account['id'],
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $this->lang->line('Bulk Payment Invoices'),
            'payerid' => $csd,
            'method' => $pay_method,
            'date' => date('Y-m-d'),
            'eid' => $this->aauth->get_user()->id,
            'tid' => 0,
            'note' => $note,
            'loc' => $this->aauth->get_user()->loc
        );

        $this->db->insert('geopos_transactions', $data);
        $tttid = $this->db->insert_id();
		            $this->db->set('lastbal', "lastbal+$amount", FALSE);
                    $this->db->where('id', $account['id']);
                    $this->db->update('geopos_accounts');

            }

        }
    }
	
	
	public function GetStateIDbyName($name) {		
		$this->db->where('name', $name);
		$query = $this->db->get("state");
		//echo $this->db1->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data = $row->id;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function import_leads($data){		
		foreach($data as $key=>$row){
			$this->db->insert('contactus',$row);			
		}
		return true;
	}
	
	public function getLeadsByAssignUser($status_not_array=''){
		$logged_user_id = $_SESSION['id'];		
		$this->db->where('assign_to', $logged_user_id);	
		
		foreach($status_not_array as $key=>$status_not){
			$this->db->where('status !=', $status_not);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get("contactus");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0){
			foreach ($query->result() as $key=>$row) {
				$row->state_name = $this->GetStateById($row->state);				
				$row->history = $this->GetLeadStatusLogByLeadId($row->id);
				$row->franchise = $this->getFranchisebyLeadId($row->id);
				$row->employee = $this->GetEmployeesById($row->assign_to);
				$row->agent_details = $this->agency->getAgencyDataById($row->agency_id);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function getLeadsByStatus($status){
		$this->db->where('status', $status);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("contactus");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0){
			foreach ($query->result() as $key=>$row) {
				$row->state_name = $this->GetStateById($row->state);				
				$row->history = $this->GetLeadStatusLogByLeadId($row->id);
				$row->franchise = $this->getFranchisebyLeadId($row->id);
				$row->rsm = $this->getRSMByLeadId($row->id);
				$row->project_manager = $this->getProjectManagerByLeadId($row->id);
				$row->employee = $this->GetEmployeesById($row->assign_to);
				$row->agent_details = $this->agency->getAgencyDataById($row->agency_id);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function getFranchisebyLeadId($lead_id)
	{
		$this->db->where("lead_id", $lead_id);		
		$query = $this->db->get("geopos_franchise");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0){
			foreach ($query->result() as $key=>$row) {				
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function getRSMByLeadId($lead_id){		
		$this->db->select('c.*,b.id,b.roleid,a.lead_id');
		$this->db->from("history_log as a");		
		$this->db->join('geopos_users as b', 'a.assign_to = b.id', 'left');
		$this->db->join('geopos_employees as c', 'b.id = c.id', 'left');
		$this->db->where('a.lead_id', $lead_id);			
		$this->db->where('b.roleid', 4);			
		$this->db->group_by('b.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {						
				$data[] = $row;
			}			
			return $data;
		}
		return false;		
	}
	
	public function getProjectManagerByLeadId($lead_id){		
		$this->db->select('c.*');
		$this->db->from("history_log as a");		
		$this->db->join('geopos_users as b', 'a.assign_to = b.id', 'left');
		$this->db->join('geopos_employees as c', 'b.id = c.id', 'left');
		$this->db->where('a.lead_id', $lead_id);			
		$this->db->where('b.roleid', 10);			
		$this->db->group_by('b.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {						
				$data[] = $row;
			}			
			return $data;
		}
		return false;		
	}


}