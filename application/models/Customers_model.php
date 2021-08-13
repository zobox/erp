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

class Customers_model extends CI_Model
{
    var $table = 'geopos_customers';
    var $column_order = array(null, 'geopos_customers.name', 'geopos_customers.address', 'geopos_customers.email', 'geopos_customers.phone', null);
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
			
			//$this->db->where('geopos_customers.status', 1);
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
			//$this->db->where('geopos_customers.status', 1);
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
	
	public function GetFranchiseById($id){		
		$this->db->where('id', $id);	
		//$this->db->where('status', 29);	
		$query = $this->db->get("geopos_franchise");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				if($row->personal_company == 1){
					$row->fname = 	$row->franchise_name;
					$row->phone = 	$row->franchise_phone;
					$row->email = 	$row->franchise_email;
				}else if($row->personal_company==2){
					$row->fname = 	$row->director_name;
					$row->phone = 	$row->company_phone;
					$row->email = 	$row->company_email;
				}
				$data = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function GetFranchisedropdown(){			
		$this->db->where('partial_active', 1);	
		$query = $this->db->get("geopos_franchise");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				if($row->personal_company == 1){
					$row->fname = 	$row->franchise_name;
				}else if($row->personal_company==2){
					$row->fname = 	$row->director_name;
				}
				$data[] = $row;
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
		//echo $this->db->last_query(); exit;
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
		$franchise_id = $this->input->post('franchise_id', true);	
		$module = $this->input->post('module', true);
		$balance = $this->input->post('balance', true);
		/* switch($module){
			case 1: $balance = 200000;
			break;
			case 2: $balance = 150000;
			break;
			case 3: $balance = 75000;
			break;
		} */
		
		
		$lid = $this->input->post('lid', true);
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
                'discount_c' => 0,
				'balance' => $balance,
                'franchise_id' => $franchise_id,
                'status' => 1
            );


            if ($this->aauth->get_user()->loc) {
                $data['loc'] = $this->aauth->get_user()->loc;
            }

            if ($this->db->insert('geopos_customers', $data)) {				
                $cid = $this->db->insert_id();	
				
				$data = array(
					'type' => 21,
					'rid' => $cid,
					'col1' => $balance,
					'col2' => date('Y-m-d H:i:s') . ' Account Recharge by ' . $this->aauth->get_user()->username
				);

				if ($this->db->insert('geopos_metadata', $data)) {
					// For Transacton 				
					$franchise = $this->getCustomerFranchiseByID($cid);

					$data = array(
						'payerid' => $cid,
						'payer' => $franchise['name'],
						'acid' => $this->aauth->get_user()->id,
						'account' => $this->session->userdata('username'),
						'date' => date('Y-m-d'),
						'debit' => 0,
						'credit' => $balance,
						'type' => 'Expense',
						'trans_type' => 5,
						'cat' => 'Recharge',
						'method' => 'Transfer',
						'tid' => 0,
						'eid' => $cid,
						'ext' => 3,
						'note' => date('Y-m-d H:i:s') . ' Account Recharge by ' . $this->aauth->get_user()->username,
						'loc' => $this->aauth->get_user()->loc
					 );
					$this->db->set('lastbal', "lastbal+$balance", FALSE);
					$this->db->where('id', $result_c['reflect']);
					$this->db->update('geopos_accounts');
					$this->db->insert('geopos_transactions', $data);
					
					$this->aauth->applog("[Client Wallet Recharge] Amt-$balance ID " . $cid, $this->aauth->get_user()->username);           
				}
				
				
				
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
				
				$this->plugins->updateFranchiseCommission($m=true,$franchise_id);
				
				//Email Code Start Here
				$this->load->model('communication_model');
				
				$this->db->where('id',$franchise_id);
				$geopos_franchise_details = $this->db->get('geopos_franchise')->result_array(); 
				$geopos_franchise_details = $geopos_franchise_details[0];
				switch($module){
					case 1: $franchise_model = "ENTERPRISE";break;
					case 2:	$franchise_model = "PROFESSIONAL";break;
					case 3:	$franchise_model = "STANDARD";break;
					default : $franchise_model = "";break;
				}
				$franchise_store_id = $franchise_id;
				switch($geopos_franchise_details['personal_company']){
					case 1 : $franchise_name = $geopos_franchise_details['franchise_name'];$franchise_phone = $geopos_franchise_details['franchise_phone'];break;
					case 2 : $franchise_name = $geopos_franchise_details['company_name'];$franchise_phone = $geopos_franchise_details['company_phone'];break;
					default : $franchise_name = '';$franchise_phone = '';break;
				}
				$franchise_address = $geopos_franchise_details['address_s'];
				$lead_id = $geopos_franchise_details['lead_id'];		
				$website_id = $geopos_franchise_details['website_id'];
				switch($website_id){
					case 1: $website_prefix = 'Box';
					break;
					case 2: $website_prefix = 'Loot';
					break;
					default : $website_prefix ='COCO';
					break;
				}
				
				$rsm_detail = $this->getRSMDetailsByLeadId($lead_id);
				$rsm_name = $rsm_detail->name;
				$rsm_phone = $rsm_detail->phone;
				$rsm_email = $rsm_detail->email;
				$rsm_state = $rsm_detail->state;
				$rsm_state_code = $rsm_detail->abbreviation;
				
				$name_arr = explode(' ',$name);
				$store_code = $website_prefix.'_'.$rsm_state_code.'_'.$city.'_S'.$cid.'-'.$name_arr[0]; 
				
				$branding_team_contact_name = "Preet Kamal";
                $branding_team_mail_id = "projects@zobox.in";
                $branding_team_phone = "+91 9717794224";
                
                /* $mailto = 'neeraj@zobox.in,harish@zobox.in,jitendra@zobox.in,'.$this->session->userdata('email').
                ',mukesh@zobox.in,devendra@zobox.in'; */
                
                /* $mail_array[] = 'shuvankar.cartnyou@gmail.com';
                $mail_array[] = 'devendra.cartnyou@gmail.com';
                $mail_array[] = 'jaydeepsarkar@cartnyou.com'; */
                
                $mail_array[] = 'neeraj@zobox.in';
                $mail_array[] = 'rajinder@cartnyou.com';
                $mail_array[] = 'deepak.kashyap@zobox.in';
                $mail_array[] = 'mukesh@zobox.in';
                $mail_array[] = 'projects@zobox.in';
                $mail_array[] = 'jaydeepsarkar@cartyou.com';
				if($rsm_email!=''){
				$mail_array[] = $rsm_email;
				}
				
				$mailtotitle='ZOBOX'; 
				$subject='New franchise onboard'; 
				$attachmenttrue = false; 
				$attachment = '';
				if($website_id == 2){
					$bodyHtml .= "<!doctype html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'><link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap' rel='stylesheet'><title> New updates in Zoloot Family </title><style>table,tr,td{border-collapse: collapse;}.main-table{background:rgba(255,255,255,0.92);margin:0 aut0;}.footer{display:flex;justify-content:space-between;align-items:center;width:100%;}.inner-div{display:flex;align-items:center;}.first-div{flex:4;}.second-div{flex:3;text-align:center;}.third-div{flex:3;text-align:right;justify-content:flex-end;}@media only screen and (max-width:600px) {.footer{flex-direction:column;align-items:start;}.first-div,.second-div,.third-div{flex:1;}.first-div,.second-div{margin-bottom:5px; }}</style></head><body><table class='main-table' style='padding:30px 0px;text-align:left;color:#000;'><tr><td style='margin-bottom:20px;padding:0 20px;'><img src='https://zobox.in/images/zoloot_mail_image.png' alt='logo' style='max-height:60px;max-width:43px;' /> </td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Dear Zoloot Team Members, </p><p> Greeting from Zoloot !!! </p><p>Congratulations!! New Franchise member comes on board in the  Zoloot Family.</p><p>The details related to the new franchise are available down below: </p></td>  </tr>  <tr>    <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Franchise Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Franchise Model : </strong>";
				$bodyHtml .= $franchise_model;
				$bodyHtml .= "</p></td></tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p>2.  <strong>Franchise Store ID : </strong>".$store_code." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3.  <strong>Franchise Name : </strong>".$franchise_name." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>4.  <strong>Franchise Phone No :".$franchise_phone."</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>5.  <strong>Franchise Location : </strong>".$franchise_address."</p></td>  </tr>  <tr>";
				$bodyHtml .= " <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>RSM Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>RSM Name : </strong>".$rsm_name."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>RSM Phone No :</strong>".$rsm_phone."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>RSM Mail Id :</strong>".$rsm_email."</p></td></tr><tr><td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Branding Team Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Devendra Pundir</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> devendra@zobox.in</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 8800688690</p></td></tr><tr> <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Inventory Team Details</strong> </p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Harish Ahluwalia</p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> harish@zobox.in</p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 8295168000</p></td> </tr>
				<tr><td style='text-align:left;padding:0 20px;'><p> Thank You </p></td></tr><tr><td style='color:#293381;max-width:40%;font-size:20px;font-weight:700;padding: 20px;margin-top:20px;'> Zoloot Retails Pvt. Ltd </td></tr></table></body></html>";
				}else{
					$bodyHtml .= "<!doctype html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'><link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap' rel='stylesheet'><title> New updates in ZOBOX Family </title><style>table,tr,td{border-collapse: collapse;}.main-table{background:rgba(255,255,255,0.92);margin:0 aut0;}.footer{display:flex;justify-content:space-between;align-items:center;width:100%;}.inner-div{display:flex;align-items:center;}.first-div{flex:4;}.second-div{flex:3;text-align:center;}.third-div{flex:3;text-align:right;justify-content:flex-end;}@media only screen and (max-width:600px) {.footer{flex-direction:column;align-items:start;}.first-div,.second-div,.third-div{flex:1;}.first-div,.second-div{margin-bottom:5px; }}</style></head><body><table class='main-table' style='padding:30px 0px;text-align:left;color:#000;'><tr><td style='margin-bottom:20px;padding:0 20px;'><img src='https://zobox.in/images/Zobox_mail.png' alt='logo' style='max-height:60px;max-width:43px;' /> </td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Dear Zobox Team Members, </p><p> Greeting from Zobox !!! </p><p>Congratulations!! New Franchise member comes on board in the  Zobox Family.</p><p>The details related to the new franchise are available down below: </p></td>  </tr>  <tr>    <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Franchise Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Franchise Model : </strong>";
				$bodyHtml .= $franchise_model;
				$bodyHtml .= "</p></td></tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p>2.  <strong>Franchise Store ID : </strong>".$store_code." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3.  <strong>Franchise Name : </strong>".$franchise_name." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>4.  <strong>Franchise Phone No :".$franchise_phone."</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>5.  <strong>Franchise Location : </strong>".$franchise_address."</p></td>  </tr>  <tr>";
				$bodyHtml .= " <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>RSM Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>RSM Name : </strong>".$rsm_name."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>RSM Phone No :</strong>".$rsm_phone."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>RSM Mail Id :</strong>".$rsm_email."</p></td></tr><tr><td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Branding Team Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Preet Kamal Singh</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> projects@zobox.in</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 9717794224</p></td></tr><tr> <td style='text-align:left;padding:0 20px; text-decoration: underline;'><p> <strong>Inventory Team Details</strong> </p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Rajender Pal Singh Rekhi</p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> rajinder@cartnyou.com</p></td> </tr> <tr> <td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 9891425194</p></td> </tr>
                <tr><td style='text-align:left;padding:0 20px;'><p> Thank You </p></td></tr><tr><td style='color:#293381;max-width:40%;font-size:20px;font-weight:700;padding: 20px;margin-top:20px;'> Zobox Retails Pvt. Ltd </td></tr></table></body></html>";
				} 
				foreach($mail_array as $mailto){
				$email_response = $this->communication_model->send_email($mailto, $mailtotitle, $subject, $bodyHtml, $attachmenttrue, $attachment); 
				}
				//$email_response = $this->communication_model->group_email($recipients, $subject, $bodyHtml, $attachmenttrue, $attachment,$m=true); 
				
				
				$username = $email;				
				$link = "<a href='http://erp.zobox.in/crm/user/login' target='_blank'>http://erp.zobox.in/crm/user/login</a>";
				
				if($website_id == 2){
					$bodyHtml2 = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta charset='utf-8' /><meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' /><title>Franchise Partner | ZOLOOT</title><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous' /></head><body style='margin: 8px'><table class='table table-responsive' style=' margin: 0px auto; border: none; text-align: justify; color: #000000; padding-right: 100px; ' ><tr class='header-image'><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><div> <img src='https://zobox.in/images/zoloot_mail_image.png' title='zobox logo' alt='zobox logo' class='company-logo' style='width: 50px' /> <img src='https://www.zobox.in/images/iso_hallmark.png' title='iso logo' alt='iso logo' class='iso-logo' style='width: 62px; float: right' /></div></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Dear Franchise Partner,</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Welcome and congrats for becoming part of Zoloot Family!!!</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>We are Zoloot - We bring smiles on the people's face.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b >Now you are just one step before you are on your way to build your own profitable business and inspiring people to build Zoloot community/family.</b ></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> As we all are aware that the talented people have lot of acumen in life and they seek opportunity that speaks volumes and <b>Zoloot</b> is such an opportunity. We aim to provide easy franchise business solution that is win-win for all of us. Recently, we have extended our operations and have expanded our operations by teaming up with in the electronics domain and delivering the best business opportunity for you. We believe that this initiative is beneficial for both of us and it is guaranteed that you will get recognized as a brand.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We try to build our teams in such a manner that it works together on whole new level. Zoloot is easy franchise opportunity for all. The reason is that it is integrated in a manner that <b>company</b> knows that there is easier and better way to do business. Always remember franchised we stand and divided we fall and business is the key.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> With the mission to empower India with digitalization and like with our Honorable Prime Minister said to make every home in India digital. Similarly, <b>Zoloot</b> expanded in the field of the electronic franchise and ONLY selling franchise was not the criteria as we intended to build long term fruitful association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Hoping this, we have surfaced exciting opportunities for all and thus providing them best business establishment with best possible infrastructure, transparency and affordability.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> On the behalf of whole Zoloot team, thanks for joining us.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We welcome you onboard hoping for fruitful and long term association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b><u>Further franchise details are mentioned below:</u></b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>Login ID : </b>";
				$bodyHtml2 .= $username;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>Password : </b>";
				$bodyHtml2 .= $temp_password;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b>Link : </b>";
				$bodyHtml2 .= $link;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b><u>Note:</u></b> Details mentioned below are confidential and not to be disclosed.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Sincerely,</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Neeraj Chopra</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Founder</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Zoloot Retails Pvt. Ltd.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000'><b>Website :</b> <a href='https://www.erp.zobox.in' target='_blank' title='erp.zobox.in' >https://www.erp.zobox.in</a ></td></tr></table></body></html>";
				
				}else{
					$bodyHtml2 = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta charset='utf-8' /><meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' /><title>Franchise Partner | ZOBOX</title><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous' /></head><body style='margin: 8px'><table class='table table-responsive' style=' margin: 0px auto; border: none; text-align: justify; color: #000000; padding-right: 100px; ' ><tr class='header-image'><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><div> <img src='https://www.zobox.in/images/logo.png' title='zobox logo' alt='zobox logo' class='company-logo' style='width: 50px' /> <img src='https://www.zobox.in/images/iso_hallmark.png' title='iso logo' alt='iso logo' class='iso-logo' style='width: 62px; float: right' /></div></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Dear Franchise Partner,</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Welcome and congrats for becoming part of Zobox Family!!!</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>We are Zobox - We bring smiles on the people's face.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b >Now you are just one step before you are on your way to build your own profitable business and inspiring people to build Zobox community/family.</b ></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> As we all are aware that the talented people have lot of acumen in life and they seek opportunity that speaks volumes and <b>Zobox</b> is such an opportunity. We aim to provide easy franchise business solution that is win-win for all of us. Recently, we have extended our operations and have expanded our operations by teaming up with in the electronics domain and delivering the best business opportunity for you. We believe that this initiative is beneficial for both of us and it is guaranteed that you will get recognized as a brand.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We try to build our teams in such a manner that it works together on whole new level. Zobox is easy franchise opportunity for all. The reason is that it is integrated in a manner that <b>company</b> knows that there is easier and better way to do business. Always remember franchised we stand and divided we fall and business is the key.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> With the mission to empower India with digitalization and like with our Honorable Prime Minister said to make every home in India digital. Similarly, <b>Zobox</b> expanded in the field of the electronic franchise and ONLY selling franchise was not the criteria as we intended to build long term fruitful association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> Hoping this, we have surfaced exciting opportunities for all and thus providing them best business establishment with best possible infrastructure, transparency and affordability.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> On the behalf of whole Zobox team, thanks for joining us.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> We welcome you onboard hoping for fruitful and long term association.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b><u>Further franchise details are mentioned below:</u></b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>Login ID : </b>";
				$bodyHtml2 .= $username;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'> <b>Password : </b>";
				$bodyHtml2 .= $temp_password;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b>Link : </b>";
				$bodyHtml2 .= $link;
				$bodyHtml2 .= "</td></tr><tr><td style='border: none; text-align: justify; color: #000000;padding-bottom:20px;'><b><u>Note:</u></b> Details mentioned below are confidential and not to be disclosed.</td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Sincerely,</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Neeraj Chopra</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Founder</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000;'><b>Zobox Retails Pvt. Ltd.</b></td></tr><tr><td style='border: none; text-align: justify; color: #000000'><b>Website :</b> <a href='https://www.erp.zobox.in' target='_blank' title='erp.zobox.in' >https://www.erp.zobox.in</a ></td></tr></table></body></html>";
				}
				$mailto2= $email;
				//$mailto = 'shuvankar.cartnyou@gmail.com';
				$mailtotitle2='ZOBOX'; 
				$subject2='Congratulation | Welcome On Board Zobox Community'; 
				$attachmenttrue2 = false; 
				$attachment = '';
				$email_response = $this->communication_model->send_email($mailto2, $mailtotitle2, $subject2, $bodyHtml2, $attachmenttrue2, $attachment);
				//Email Code End Here
				
				// Update Franchise ID
				$data3 = array();	
				$name_arr = explode(' ',$name);
				$data3['franchise_code'] = $website_prefix.'_'.$rsm_state_code.'_'.$city.'_F'.$cid.'-'.$name_arr[0]; 
				$this->db->where('id', $cid);
				$this->db->update('geopos_customers',$data3);
				
				//update franchise status
				$data1 = array();
				$data1['partial_active'] = 2; 
				$this->db->where('id', $franchise_id);
				$this->db->update('geopos_franchise',$data1);
				//End
				
				//Create Warehouse
				$data2 = array();
				$data2['title'] = $city.'-'.$name; 
				$data2['cid'] = $cid; 				
				$data2['franchise_id'] = $franchise_id; 				
				$data2['extra'] = $city.'-'.$name;
				$data2['loc'] = $lid; 
				$this->db->insert('geopos_warehouse', $data2);
				
				$wid = $this->db->insert_id();				
				
				$data4 = array();		 		
				$data4['warehouse_code'] = $website_prefix.'_'.$rsm_state_code.'_'.$city.'_W'.$cid.'-'.$name_arr[0]; 
				$this->db->where('id', $wid);
				$this->db->update('geopos_warehouse',$data4);
				// End
				
				//Create Store
				$data5 = array();
				$data5['title'] = $city.'-'.$name; 
				$data5['cid'] = $cid; 				
				$data5['franchise_id'] = $franchise_id; 				
				$data5['extra'] = $city.'-'.$name;
				$data5['loc'] = $lid; 
				$this->db->insert('geopos_store', $data5);
				
				$wid = $this->db->insert_id();				
				
				$data6 = array();		 		
				$data6['store_code'] = $website_prefix.'_'.$rsm_state_code.'_'.$city.'_S'.$cid.'-'.$name_arr[0]; 
				$this->db->where('id', $wid);
				$this->db->update('geopos_store',$data6);
				// End
				
                $this->aauth->applog("[Client Added] $name ID " . $cid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . $p_string . '&nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password, 'discount' => amountFormat_general($discount)));

                $this->custom->save_fields_data($cid, 1);

                $this->db->select('other');
                $this->db->from('univarsal_api');
                $this->db->where('id', 64);
                $query = $this->db->get();
                $othe = $query->row_array();

                /*if ($othe['other']) {
                    $auto_mail = $this->send_mail_auto($email, $name, $temp_password);
                    $this->load->model('communication_model');
                    $attachmenttrue = false;
                    $attachment = '';
                    $this->communication_model->send_corn_email($email, $name, $auto_mail['subject'], $auto_mail['message'], $attachmenttrue, $attachment);
                }*/

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Duplicate Email'));
        }

    }
	
	
	public function getRSMDetailsByLeadId($lead_id){		
		$this->db->select('a.name,a.phone,b.email,d.name as state,d.abbreviation');		
		$this->db->from("geopos_employees as a");
		$this->db->join('contactus as c', 'a.id = c.assign_to', 'INNER');
		$this->db->join('state as d', 'd.id = c.state', 'INNER');
		$this->db->join('geopos_users as b', 'a.id = b.id', 'INNER');
		$this->db->where('c.id',$lead_id);
		$query = $this->db->get();	
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
	}


    public function edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $docid = '', $custom = '', $language = '', $discount = 0)
    {
        $data = array(
            'name' => $name,
			'franchise_code' => 'Box_F'.$id.'-'.$name,
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
		$this->db->where('geopos_invoices.type !=',4);
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

    public function activity13032021($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_metadata');
        $this->db->where('type', 21);
        $this->db->where('rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function activity($id)
    {
        $this->db->select('a.*,b.id as trans_id,b.acid,b.account,b.type,b.trans_type,b.cat,b.debit,b.credit,b.payer,b.payerid,b.method,b.method_id,b.date,b.tid,b.eid,b.note,b.ext,b.loc');
        $this->db->from('geopos_metadata as a');
		$this->db->join('geopos_transactions as b', 'b.tid = a.id', 'inner');
		$this->db->where('a.status !=',5);
        $this->db->where('a.type', 21);
        $this->db->where('b.trans_type !=', 0);
        $this->db->where('a.rid', $id);
        $this->db->order_by('b.id', 'DESC');
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
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
			// For Transacton 
			$ins_id = $this->db->insert_id();
			$franchise = $this->getCustomerFranchiseByID($id);

			 $data = array(
				'payerid' => $id,
				'payer' => $franchise['name'],
				'acid' => $this->aauth->get_user()->id,
				'account' => $this->session->userdata('username'),
				'date' => date('Y-m-d'),
				'debit' => 0,
				'credit' => $amount,
				'type' => 'Expense',
				'trans_type' => 5,
				'cat' => 'Recharge',
				'method' => 'Transfer',
				'tid' => $ins_id,
				'eid' => $id,
				'ext' => 3,
				'note' => date('Y-m-d H:i:s') . ' Account Recharge by ' . $this->aauth->get_user()->username,
				'loc' => $this->aauth->get_user()->loc
			 );
			$this->db->set('lastbal', "lastbal+$amount", FALSE);
			$this->db->where('id', $result_c['reflect']);
			$this->db->update('geopos_accounts');
			$this->db->insert('geopos_transactions', $data);
			
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
	
	public function getCatCommision($module_id='',$category_id='',$purpose='',$franchise_id=0){		
		$this->db->where('franchise_id', $franchise_id);
		if($module_id)
		$this->db->where('module_id', $module_id);
		if($category_id)
        $this->db->where('category_id', $category_id);
		if($purpose)
        $this->db->where('purpose', $purpose);
		$query = $this->db->get("franchise_category_commision_slab_master");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				if($purpose==''){
					$row->category = $this->products_cat->GetTitleById($row->category_id);
					$data[] = $row;
				}else{
					$data = $row;
				}
			}			
			return $data;
		}
		return false;
	}
	
	public function getFranchiseComissionByFranchiseID($franchise_id=0){		
		$this->db->where('franchise_id', $franchise_id);		
		$query = $this->db->get("franchise_module_slab_master");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
					$data = $row;				
			}			
			return $data;
		}
		return false;
	}
	
	public function getStoreByFranchiseId($franchise_id='')
    {
        $this->db->where('franchise_id', $franchise_id);       
        $query = $this->db->get('geopos_store');		
        $data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {							
				$data = $row;
			}			
			return $data;
		}
		return false;
    }

	public function getFranchiseByCustromerID($cid){
		$this->db->select('a.*,b.gst,b.personal_company,b.personal_company,d.state_code');		
		$this->db->from("geopos_customers as a");
		$this->db->join('geopos_franchise as b', 'a.franchise_id = b.id', 'LEFT');		
		$this->db->join('contactus as c', 'b.lead_id = c.id', 'left');		
		$this->db->join('state as d', 'd.id = c.state', 'left');		
		$this->db->where('a.id',$cid);
		$this->db->where('b.partial_active',2);
		$query = $this->db->get();	
		//echo $this->db->last_query(); 
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
	}
	
	
	public function getFranchiseByWarehouseID($wid){
		$this->db->select('b.*,c.gst,c.personal_company,c.module,e.state_code');		
		$this->db->from("geopos_warehouse as a");
		$this->db->join('geopos_customers as b', 'a.cid = b.id', 'LEFT');		
		$this->db->join('geopos_franchise as c', 'b.franchise_id = c.id', 'LEFT');		
		$this->db->join('contactus as d', 'c.lead_id = d.id', 'left');		
		$this->db->join('state as e', 'e.id = d.state', 'left');		
		$this->db->where('a.id',$wid);
		$this->db->where('c.partial_active',2);
		$query = $this->db->get();	
		//echo $this->db->last_query(); 
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
	}
	
	public function GetFranchisedropdown1(){			
		$query = $this->db->get("geopos_customers");		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function is_agent($customer_id){
		$this->db->select('is_agent');
		$this->db->from('geopos_franchise');
		$this->db->join('geopos_customers', 'geopos_franchise.id = geopos_customers.franchise_id', 'INNER');
		$this->db->where('geopos_customers.id',$customer_id);	
		$query = $this->db->get();
		return $query->result_array()[0];
	}
	
	
	public function getCustomerFranchiseByID($id){		
		$this->db->where('id',$id);	
		$query = $this->db->get('geopos_customers');
		return $query->result_array()[0];
	}
	
	public function commission_debit($id, $amount)
    { 
		if($amount>0){			
			$tds = $this->input->post('tds', true);
			$pmethod = $this->input->post('pmethod', true);
			$note = $this->input->post('note', true);
			
			$franchise = $this->getCustomerFranchiseByID($id);		
			
			/* $this->db->set('balance', "balance-$amount", FALSE);
			$this->db->where('id', $id);
			$this->db->update('geopos_customers'); */

			$data = array(
				'type' => 22,
				'rid' => $id,
				'col1' => $amount,
				'd_date' => date('Y-m-d H:i:s'),
				'col2' => date('Y-m-d H:i:s') . ' '.$note . 'By '.$this->aauth->get_user()->username
			);
			
			if ($this->db->insert('geopos_metadata', $data)) {
				 $insert_id = $this->db->insert_id();
				
				$this->load->model('pos_invoices_model', 'invocies');
				$invocieno = $this->invocies->lastinvoice();
				$invocieno +=1;
				//Invoices Generation
				$data = array('tid' => $invocieno,
				'invoicedate' => date('Y-m-d H:i:s'),
				'invoiceduedate' => '',
				'subtotal' => $amount,
				'shipping' => '',
				'ship_tax' => '',
				'ship_tax_type' => '',
				'discount_rate' => '',
				'total' => $amount,
				'tds_deposite' => $tds,
				'pmethod' => $pmethod,
				'notes' => date('Y-m-d H:i:s') . ' '.$note . 'By '. $this->aauth->get_user()->username,
				'status' => 'paid',
				'csd' => $id,
				//'csd' => $customer_id,
				'fwid' => $this->session->userdata('id'),
				'eid' => $this->session->userdata('id'),
				'pamnt' => 0,
				'taxstatus' => '',
				'discstatus' => '',
				'format_discount' => '',
				'refer' => '',
				'term' => '',
				'multi' => '',
				'i_class' => 1,
				'type' => 4,
				'loc' => $this->aauth->get_user()->loc);
				$this->db->insert('geopos_invoices', $data);
				//echo $this->db->last_query(); exit;
				$ins_id = $this->db->insert_id();
				 
				 $data = array(
					'payerid' => $this->session->userdata('id'),
					'payer' => $this->session->userdata('username'),
					'acid' => $id,
					'account' => $franchise['name'],
					'date' => date('Y-m-d'),
					'debit' => $amount,
					'credit' => 0,
					'type' => 'Expense',
					'trans_type' => 5,
					'cat' => 'Debit',
					'method' => 'Transfer',
					'tid' => $ins_id,
					'eid' => $this->aauth->get_user()->id,
					'note' => date('Y-m-d H:i:s') . $note . $this->aauth->get_user()->username,
					'loc' => $this->aauth->get_user()->loc
				 );
				$this->db->set('lastbal', "lastbal+$amount", FALSE);
				$this->db->where('id', $result_c['reflect']);
				$this->db->update('geopos_accounts');
				$this->db->insert('geopos_transactions', $data);
							
				$this->aauth->applog("[".$note."] Amt-$amount ID " . $id, $this->aauth->get_user()->username);
				return true;
			} else {
				return false;
			}
		}else{
			return false;
		}
    }
	
	
	public function debit($id, $amount)
    { 
		$tds = $this->input->post('tds', true);
		$franchise = $this->getCustomerFranchiseByID($id);		
		
		$this->db->set('balance', "balance-$amount", FALSE);
		$this->db->where('id', $id);
		$this->db->update('geopos_customers');

		$data = array(
			'type' => 22,
			'rid' => $id,
			'col1' => $amount,
			'd_date' => date('Y-m-d H:i:s'),
			'col2' => date('Y-m-d H:i:s') . ' Account Debited by ' . $this->aauth->get_user()->username
		);
		
		if ($this->db->insert('geopos_metadata', $data)) {
			 $insert_id = $this->db->insert_id();
			
			$this->load->model('pos_invoices_model', 'invocies');
			$invocieno = $this->invocies->lastinvoice();
			$invocieno +=1;
			//Invoices Generation
			$data = array('tid' => $invocieno,
			'invoicedate' => date('Y-m-d H:i:s'),
			'invoiceduedate' => '',
			'subtotal' => $amount,
			'shipping' => '',
			'ship_tax' => '',
			'ship_tax_type' => '',
			'discount_rate' => '',
			'total' => $amount,				
			'pmethod' => 'Transfer',
			'notes' => date('Y-m-d H:i:s') . ' Account Debited by ' . $this->aauth->get_user()->username,
			'status' => 'paid',
			'csd' => $id,
			//'csd' => $customer_id,
			'fwid' => $this->session->userdata('id'),
			'eid' => $this->session->userdata('id'),
			'pamnt' => 0,
			'taxstatus' => '',
			'discstatus' => '',
			'format_discount' => '',
			'refer' => '',
			'term' => '',
			'multi' => '',
			'i_class' => 1,
			'type' => 4,
			'loc' => $this->aauth->get_user()->loc);
			$this->db->insert('geopos_invoices', $data);
			//echo $this->db->last_query(); exit;
			$ins_id = $this->db->insert_id();
			 
			 $data = array(
				'payerid' => $this->session->userdata('id'),
				'payer' => $this->session->userdata('username'),
				'acid' => $id,
				'account' => $franchise['name'],
				'date' => date('Y-m-d'),
				'debit' => 0,
				'credit' => $amount,
				'type' => 'Income',
				'trans_type' => 5,
				'cat' => 'Debit',
				'method' => 'Transfer',
				'tid' => $ins_id,
				'eid' => $this->aauth->get_user()->id,
				'note' => date('Y-m-d H:i:s') . ' Account Debited by ' . $this->aauth->get_user()->username,
				'loc' => $this->aauth->get_user()->loc
			 );
			$this->db->set('lastbal', "lastbal+$amount", FALSE);
			$this->db->where('id', $result_c['reflect']);
			$this->db->update('geopos_accounts');
			$this->db->insert('geopos_transactions', $data);
						
			$this->aauth->applog("[Client Wallet Debited] Amt-$amount ID " . $id, $this->aauth->get_user()->username);
			return true;
		} else {
			return false;
		}		
    }
	
	public function link_account(){
		$custid = $this->input->post('custid');
		$cash_account_id = $this->input->post('cash_account_id');
		$other_account_id = $this->input->post('other_account_id');
		
		$data = array();	
		$data['cash_account_id'] = $cash_account_id; 
		$data['other_account_id'] = $other_account_id; 
		$this->db->where('id', $custid);
		$this->db->update('geopos_customers',$data);
		//echo $this->db->last_query(); exit;
		return true;
	}
	
	public function getFranchchiseBySalesPerson(){
		$this->db->select('b.*,a.name,a.franchise_id');		
		$this->db->from("geopos_employees as a");
		$this->db->join('geopos_customers as b', 'a.franchise_id = b.id', 'LEFT');		
		
		$this->db->where('a.id',$this->session->userdata('id'));		
		$query = $this->db->get();	
		//echo $this->db->last_query(); 
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data = $row;				
            }
            return $data;
        }
        return false;
	}


     public function user_asset($user)
    {
        $this->db->select("w.code,w.asset,p.tid,w.aid,a.pcat,w.qty,gw.warehouse_code");
        $this->db->from("tbl_asset_warehouse as w");
        $this->db->join("tbl_asset as a","w.aid=a.id","INNER");
        $this->db->join("tbl_asset_purchase as p","w.tid=p.id","LEFT");
        $this->db->join("geopos_warehouse as gw","w.wid=gw.id","LEFT");
        $this->db->where('p.franchies_status',1);
        $this->db->where('p.po_type',0);
        $this->db->where('w.cid',$user);

        $query = $this->db->get();
       
        return $order_list = $query->result_array();
    }
	
    public function getFranchiseByWarehouseID1($wid){
        $this->db->select('b.*,c.gst,c.personal_company,c.module');     
        $this->db->from("geopos_warehouse as a");
        $this->db->join('geopos_customers as b', 'a.cid = b.id', 'LEFT');       
        $this->db->join('geopos_franchise as c', 'b.franchise_id = c.id', 'LEFT');  
        $this->db->where('a.id',$wid);
        $this->db->where('c.partial_active',2);
        $query = $this->db->get();  
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {                
                    $data = $row;               
            }
            return $data;
        }
        return false;
    }

    public function getTrcList()
    {
        $this->db->select("a.*,b.warehouse_code,b.title");
        $this->db->from("users_lrp as a");
        $this->db->join("geopos_warehouse as b","a.users_id=b.franchise_id",'left');
        $this->db->where("b.warehouse_type",2);
        $query = $this->db->get();
        $data = array();

        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
}