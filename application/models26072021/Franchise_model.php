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

class Franchise_model extends CI_Model
{
	private $path = 'userfiles/documents/franchise/';
	
    var $table = 'geopos_franchise';
    var $column_order = array(null, 'geopos_franchise.name', 'geopos_franchise.address', 'geopos_franchise.email', 'geopos_franchise.phone', null);
    var $column_search = array('geopos_franchise.name', 'geopos_franchise.phone', 'geopos_franchise.address', 'geopos_franchise.city', 'geopos_franchise.email', 'geopos_franchise.docid');
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
	

	public function GetRecords($start=0, $limit=10) {
		$this->db->select('a.*,b.id as lead_id,b.mobileno,b.email,b.name,b.business_address,b.state,
		b.city,b.pincode,b.shop_type,b.date,b.valid,b.assign_to,b.status as lead_status,b.msg91_response,
		b.email_response,b.notification_view_status,b.date_modified as lead_date_modified,b.source');
		$this->db->from("geopos_franchise as a");
		$this->db->join('contactus as b', 'a.lead_id = b.id', 'left');
		$this->db->where('b.status', 5);				
		//$this->db1->limit($limit,$start);
		$this->db->order_by("a.id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
					
					$assign_id = $row->assign_to;
					$this->db->where('id',$assign_id);
					$query2 = $this->db->get('geopos_employees')->result_array();
					$row->assign_name = $query2[0]['name'];
					$state_id = $row->state;
					$this->db->where('id',$state_id);
					$query3 = $this->db->get('state')->result_array();
					$row->state_name = $query3[0]['name'];
					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetPartialInactiveRecords($start=0, $limit=10) {
		$this->db->select('a.*,b.id as lead_id,b.mobileno,b.email,b.name,b.business_address,b.state,
		b.city,b.pincode,b.shop_type,b.date,b.valid,b.assign_to,b.status as lead_status,b.msg91_response,
		b.email_response,b.notification_view_status,b.date_modified as lead_date_modified,b.source');
		$this->db->from("geopos_franchise as a");
		$this->db->join('contactus as b', 'a.lead_id = b.id', 'left');
		$this->db->where('b.status', 5);		
		$this->db->where('a.partial_active', 0);		
		//$this->db1->limit($limit,$start);
		$this->db->order_by("a.id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
					
					$assign_id = $row->assign_to;
					$this->db->where('id',$assign_id);
					$query2 = $this->db->get('geopos_employees')->result_array();
					$row->assign_name = $query2[0]['name'];
					$state_id = $row->state;
					$this->db->where('id',$state_id);
					$query3 = $this->db->get('state')->result_array();
					$row->state_name = $query3[0]['name'];
					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function RSM_franchise_record($start=0, $limit=10){
		$this->db->select('a.*,b.id as lead_id,b.mobileno,b.email,b.name,b.business_address,b.state,
		b.city,b.pincode,b.shop_type,b.date,b.valid,b.assign_to,b.status as lead_status,b.msg91_response,
		b.email_response,b.notification_view_status,b.date_modified as lead_date_modified,b.source');
		$this->db->from("geopos_franchise as a");
		$this->db->join('contactus as b', 'a.lead_id = b.id', 'left');
		$this->db->where('b.status', 5);
		$this->db->where('b.assign_to', $_SESSION['id']);
		
		//$this->db1->limit($limit,$start);
		$this->db->order_by("a.id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
					$assign_id = $row->assign_to;
					$this->db->where('id',$assign_id);
					$query2 = $this->db->get('geopos_employees')->result_array();
					$row->assign_name = $query2[0]['name'];
					$state_id = $row->state;
					$this->db->where('id',$state_id);
					$query3 = $this->db->get('state')->result_array();
					$row->state_name = $query3[0]['name'];	
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	
	public function save($balance_sheet_up=NULL,$itr_up=NULL,$pan_card_up=NULL,$gst_up=NULL,$bank_statement_up=NULL,$cancelled_cheque_up=NULL,$abcd_up=NULL){
		$data = array();
		$id = $this->input->post('id');
		
		$data['personal_company'] = $this->input->post('personal_company');
		$data['website_id'] = $this->input->post('website_id');
		$data['company_name'] = $this->input->post('company_name');
		$data['company_type'] = $this->input->post('company_type');
		$data['company_email'] = $this->input->post('company_email');
		$data['company_phone'] = $this->input->post('company_phone');
		$data['director_name'] = $this->input->post('director_name');
		$data['director_email'] = $this->input->post('director_email');
		$data['director_phone'] = $this->input->post('director_phone');
		$data['franchise_name'] = $this->input->post('franchise_name');
		$data['franchise_email'] = $this->input->post('franchise_email');
		$data['franchise_phone'] = $this->input->post('franchise_phone');
		$data['phone_s'] = $this->input->post('phone_s');
		$data['email_s'] = $this->input->post('email_s');	
		$data['address_s'] = $this->input->post('address_s');	
		$data['state_s'] = $this->input->post('state_s');	
		$data['city_s'] = $this->input->post('city_s');	
		$data['pincode_s'] = $this->input->post('pincode_s');	
		//$data['postbox_s'] = $this->input->post('postbox_s');	
		$data['phone_b'] = $this->input->post('phone_b');	
		$data['email_b'] = $this->input->post('email_b');	
		$data['address_b'] = $this->input->post('address_b');	
		$data['state_b'] = $this->input->post('state_b');	
		$data['city_b'] = $this->input->post('city_b');	
		$data['pincode_b'] = $this->input->post('pincode_b');	
		//$data['postbox_b'] = $this->input->post('postbox_b');	
		$data['pan'] = $this->input->post('pan');	
		$data['tan'] = $this->input->post('tan');	
		$data['cin'] = $this->input->post('cin');	
		$data['gst'] = $this->input->post('gst');	
		$data['establishment_code'] = $this->input->post('establishment_code');	
		$data['esi'] = $this->input->post('esi');	
		$data['pf'] = $this->input->post('pf');	
		$data['iec_code'] = $this->input->post('iec_code');	
		$data['rtgs_ifsc_code'] = $this->input->post('rtgs_ifsc_code');	
		$data['account_holder'] = $this->input->post('account_holder');	
		$data['account_no'] = $this->input->post('account_no');	
		$data['bank_name'] = $this->input->post('bank_name');	
		$data['branch'] = $this->input->post('branch');		
		$data['module'] = $this->input->post('module');
		
		$data['balance_sheet_up'] = $balance_sheet_up;
		$data['itr_up'] = $itr_up;
		$data['pan_card_up'] = $pan_card_up;
		$data['gst_up'] = $gst_up;
		$data['bank_statement_up'] = $bank_statement_up;
		$data['cancelled_cheque_up'] = $cancelled_cheque_up;
		$data['abcd'] = $abcd_up;		
		$data['same_as_shipping'] = $this->input->post('same_as_shipping');			
		$data['add_status']=1;	
		$data['date_modified']=date('Y-m-d H:i:s');	
		
		$this->db->where('id', $id);
		$this->db->update('geopos_franchise',$data);
		//echo $this->db->last_query(); exit;
		/* if($this->db->update('geopos_franchise',$data)){
			 $this->aauth->applog("[Franchise Updated] ID " . $id, $this->aauth->get_user()->username);
			 echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . $p_string . '&nbsp;<a href="' . base_url('leads/rsmleads') . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password, 'discount' => amountFormat_general($discount)));
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
		} */
		
		
		
		
		
		
		//echo $this->db->last_query(); exit;
		//$this->db->where('id',$this->session->userdata('id'));
		//$rsm_details = $this->db->get('geopos_employees')->result_array();
		
		
		//Send SMS To Payment Recieved Team 
		$SmsNumber = '9732212158,8851968363,9953191230,9650589864';
		//$SmsNumber = '8527626445,9732212158';
		if($data['personal_company']==1){
			$franchise_name = $this->input->post('franchise_name');
		}else if($data['personal_company']==2){
			$franchise_name = $this->input->post('company_name');
		}
		
		$Smsmessage = $this->session->userdata('username').' (RSM) updated the all details of '.$franchise_name.' (franchise) in the our ERP, Please check the data and confirm the payment status'; 
		//$response = $this->lead_model->sendSMS($Smsmessage,$SmsNumber);
		
		
		/*$mailto = 'neeraj@zobox.in,harish@zobox.in,jitendra@zobox.in,'.$this->session->userdata('email').',mukesh@zobox.in';
		
		$mailtotitle='ZOBOX'; 
		$subject='New updates in ZOBOX Family'; 
		$attachmenttrue = false; 
		$attachment = '';
		$bodyHtml .= "<!doctype html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'><link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap' rel='stylesheet'><title> New updates in ZOBOX Family </title><style>table,tr,td{border-collapse: collapse;}.main-table{background:rgba(255,255,255,0.92);margin:0 aut0;}.footer{display:flex;justify-content:space-between;align-items:center;width:100%;}.inner-div{display:flex;align-items:center;}.first-div{flex:4;}.second-div{flex:3;text-align:center;}.third-div{flex:3;text-align:right;justify-content:flex-end;}@media only screen and (max-width:600px) {.footer{flex-direction:column;align-items:start;}.first-div,.second-div,.third-div{flex:1;}.first-div,.second-div{margin-bottom:5px; }}</style></head><body><table class='main-table' style='padding:30px 0px;text-align:left;color:#000;'><tr><td style='margin-bottom:20px;padding:0 20px;'><img src='https://zobox.in/images/Zobox_mail.png' alt='logo' style='max-height:60px;max-width:43px;' /> </td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Dear Zobox Team Members, </p><p> Greeting from Zobox !!! </p><p>Congratulations!! New Franchise member comes on board in the  Zobox Family.</p><p>The details related to the new franchise are available down below: </p></td>  </tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p> <strong>Franchise Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Franchise Model: </strong>";
		if($this->input->post('module') == 1){$bodyHtml .= "Enterprise"; }
		else if($this->input->post('module') == 2){$bodyHtml .= "Professional";}
		else if($this->input->post('module') == 3){$bodyHtml .= "Standard";}
		$bodyHtml .= "</p></td></tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p>2.  <strong>Franchise Store ID: </strong>".$id." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3.  <strong>Franchise Name: </strong>".$this->input->post('franchise_name')." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>4.  <strong>Franchise Phone No :</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>5.  <strong>Franchise Location : </strong>".$this->input->post('address_s').",".$this->input->post('state_s').",".$this->input->post('city_b').",".$this->input->post('pincode_s')."</p></td>  </tr>  <tr>";
		$bodyHtml .= " <td style='text-align:left;padding:0 20px;'><p> <strong>RSM Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>RSM Name : </strong>".$this->session->userdata('username')."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>RSM Phone No :</strong>".$rsm_details->phone."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>RSM Mail Id :</strong>".$this->session->userdata('email')."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p> <strong>Branding Team Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Devendra Pundir</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> devendra.zobox@gmail.com</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 8800688690</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Thank You </p></td></tr><tr><td style='color:#293381;max-width:40%;font-size:20px;font-weight:700;padding: 20px;margin-top:20px;'> Zobox Retails Pvt. Ltd </td></tr></table></body></html>";
		$email_response = $this->communication->send_email($mailto, $mailtotitle, $subject, $bodyHtml, $attachmenttrue, $attachment);*/
	
		
		return TRUE;
	}
	
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|docx|docs|txt|xls';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	
	
    private function _get_datatables_query($id = '')
    {
        $due = $this->input->post('due');
        if ($due) {

            $this->db->select('geopos_franchise.*,SUM(geopos_invoices.total) AS total,SUM(geopos_invoices.pamnt) AS pamnt');
            $this->db->from('geopos_invoices');
            $this->db->where('geopos_invoices.status!=', 'paid');
            $this->db->join('geopos_franchise', 'geopos_franchise.id = geopos_invoices.csd', 'left');
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_franchise.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_franchise.loc', 0);
            }
            if ($id != '') {
                $this->db->where('geopos_franchise.gid', $id);
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

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->aauth->get_user()->loc) {
           // $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_franchise.gid', $id);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_franchise.loc', $this->aauth->get_user()->loc);
        }
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_franchise.loc', $this->aauth->get_user()->loc);
        }
        if ($id != '') {
            $this->db->where('geopos_franchise.gid', $id);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function details12012021($custid,$loc=true)
    {
        $this->db->select('geopos_franchise.*,users.lang');
        $this->db->from($this->table);
        $this->db->join('users', 'users.cid=geopos_franchise.id', 'left');
        $this->db->where('geopos_franchise.id', $custid);
        if($loc) {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('geopos_franchise.loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('geopos_franchise.loc', 0);
            }
        }
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function details($franchiseid,$loc=true)
    {        
        $this->db->where('id', $franchiseid);        
        $query = $this->db->get('geopos_franchise');
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
        $this->db->from('geopos_franchise');
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

            if ($this->db->insert('geopos_franchise', $data)) {
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

        if ($this->db->update('geopos_franchise')) {
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
        if ($this->db->update('geopos_franchise') AND $result['picture'] != 'example.png') {

            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);
            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);
        }


    }

    public function group_list()
    {
        $whr = "";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE (geopos_franchise.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE (geopos_franchise.loc=" . $this->aauth->get_user()->loc . " OR geopos_franchise.loc=0 ) ";
        } elseif (!BDATA) {
            $whr = "WHERE  geopos_franchise.loc=0  ";
        }

        $query = $this->db->query("SELECT c.*,p.pc FROM geopos_cust_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM geopos_franchise $whr GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }

    public function delete($id)
    {


        if ($this->aauth->get_user()->loc) {
            $this->db->delete('geopos_franchise', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));

        } elseif (!BDATA) {
            $this->db->delete('geopos_franchise', array('id' => $id, 'loc' => 0));
        } else {
            $this->db->delete('geopos_franchise', array('id' => $id));
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
        $this->db->join('geopos_franchise', 'geopos_invoices.csd=geopos_franchise.id', 'left');

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
        $this->db->join('geopos_franchise', 'geopos_quotes.csd=geopos_franchise.id', 'left');

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

        $this->db->update('geopos_franchise');

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
        $this->db->select("geopos_projects.*,geopos_franchise.name AS customer");
        $this->db->from('geopos_projects');
        $this->db->join('geopos_franchise', 'geopos_projects.cid = geopos_franchise.id', 'left');


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
        $this->db->from('geopos_franchise');
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
	
	public function partialActivate($franchiseId){
		$this->db->select('partial_active');
		$this->db->where('id',$franchiseId);
		$query = $this->db->get('geopos_franchise')->result_array();
		$partial_active = $query[0]['partial_active'];
		if($partial_active == 0){
			//$data['partial_active'] = 1;
			$this->db->set('partial_active','1',FALSE);
			$this->db->where('id',$franchiseId);
			$this->db->update('geopos_franchise');
			return 1;
		}
		else{
			$this->db->set('partial_active', '0', FALSE);
			$this->db->where('id',$franchiseId);
			$this->db->update('geopos_franchise');
			return 0;
		}
		
	}
	
	
	public function send_mail_test(){
		$mailto = 'shuvankar.cartnyou@gmail.com';
		$mailtotitle='ZOBOX'; 
		$subject='Franchise Partner | ZOBOX'; 
		$attachmenttrue = false; 
		$attachment = '';
		// Head Part
	$bodyHtml = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta charset='utf-8' /><meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' /><title>Franchise Partner | ZOBOX</title><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' /></head><body style='margin: 8px'><table class='table table-responsive' style=' margin: 0px auto; border: none; text-align: justify; color: #000000; padding-right: 100px;'><tr class='header-image'><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><div> <img src='https://www.zobox.in/images/logo.png' title='zobox logo' alt='zobox logo' class='company-logo' style='width: 50px' /> <img src='https://www.zobox.in/images/iso_hallmark.png' title='iso logo' alt='iso logo' class='iso-logo' style='width: 62px; float: right' /></div></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Dear Franchise Partner,</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Welcome and congrats for becoming part of Zobox Family!!!</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b>We are Zobox - We bring smiles on the people's face.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b> Now you are just one step before you are on your way to build your own profitable business and inspiring people to build Zobox community/family. </b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> As we all are aware that the talented people have lot of acumen in life and they seek opportunity that speaks volumes and <b>Zobox</b> is such an opportunity. We aim to provide easy franchise business solution that is win-win for all of us. Recently, we have extended our operations and have expanded our operations by teaming up with in the electronics domain and delivering the best business opportunity for you. We believe that this initiative is beneficial for both of us and it is guaranteed that you will get recognized as a brand.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We try to build our teams in such a manner that it works together on whole new level. Zobox is easy franchise opportunity for all. The reason is that it is integrated in a manner that <b>company</b> knows that there is easier and better way to do business. Always remember franchised we stand and divided we fall and business is the key.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> With the mission to empower India with digitalization and like with our Honorable Prime Minister said to make every home in India digital. Similarly, <b>Zobox</b> expanded in the field of the electronic franchise and ONLY selling franchise was not the criteria as we intended to build long term fruitful association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Hoping this, we have surfaced exciting opportunities for all and thus providing them best business establishment with best possible infrastructure, transparency and affordability.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> On the behalf of whole Zobox team, thanks for joining us.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We welcome you onboard hoping for fruitful and long term association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b><u>Further franchise details are mentioned below:</u></b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b>Login ID : </b>jaydeep@gmail.com</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b>Password : </b>Account@12345</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b><u>Note:</u></b> Details mentioned below are confidential and not to be disclosed.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Sincerely,</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Neeraj Chopra</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Founder</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Zobox Retails Pvt. Ltd.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000'><b>Website :</b> <a href='https://www.erp.zobox.in' target='_blank' title='erp.zobox.in' >https://www.erp.zobox.in</a ></td></tr></table></body></html>";
	 
	 $email_response = $this->communication->send_email($mailto, $mailtotitle, $subject, $bodyHtml, $attachmenttrue, $attachment);
	 echo $email_response;
		
	}
    public function asset_order_list()
	{
		$this->db->select("c.franchise_code,s.name,p.tid,p.id,p.invoicedate,p.franchies_status,p.status,gw.warehouse_code,w.sid");
		$this->db->from("tbl_asset_purchase as p");
		$this->db->join("tbl_asset_warehouse as w","p.id=w.tid","inner");
		$this->db->join("geopos_customers as c","w.cid=c.id","inner");
		$this->db->join("geopos_warehouse as gw","c.id=gw.cid","inner");
		$this->db->join("geopos_supplier as s","w.sid=s.id","inner");
		$this->db->where('p.franchies_status',0);
		$this->db->where('p.po_type',0);
		$this->db->group_by('w.tid');


		$query = $this->db->get();
		
		
		return $order_list = $query->result_array();
	}


}