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

class Leads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('categories_model', 'products_cat');
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('accounts_model', 'accounts');
        $this->load->model('lead_model');	
		$this->load->model('employee_model', 'employee');
		$this->load->model('communication_model');
		$this->load->model('agency_model','agency');
        $this->load->library("Aauth");
		$this->load->library('excel');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }	
		//echo $this->aauth->premission(9);
        if (!$this->aauth->premission(3)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }

    public function index()
    {
		if (!$this->aauth->premission(3)){
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
		
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lead';	
		$export	= $this->input->get('export'); 
		
		if($export!='excel'){
		    $this->load->view('fixed/header', $head);		
		}
		
		$search['status']	= $this->input->post('status');		
		$search['source']	= $this->input->post('source');		
		$search['assign_name']	= $this->input->post('assign_name');	
		$search['lead_date']	= $this->input->post('lead_date');		
				
		$data['search'] = $search;
		
		//$employees = $this->lead_model->GetEmployees();	
		$employees = $this->lead_model->GetEmployeesByRoleId(15);	
		$data['employees'] = $employees;
		
		$emp_id = $search['assign_name'];		
		
		$data['New'] =  0;	
		$data['Contacted'] =  0;	
		$data['Qualified'] =  0;	
		$data['Proposal'] =  0;	
		$data['Coverted'] =  0;	
		$data['notCoverted']=  0;		
		
		if($search['status']==''){
		$data['New'] =  $this->lead_model->statusCounts($emp_id,1,$search['source']);	
		$data['Contacted'] =  $this->lead_model->statusCounts($emp_id,2,$search['source']);	
		$data['Qualified'] =  $this->lead_model->statusCounts($emp_id,3,$search['source']);	
		$data['Proposal'] =  $this->lead_model->statusCounts($emp_id,4,$search['source']);	
		$data['Coverted'] =  $this->lead_model->statusCounts($emp_id,5,$search['source']);	
		$data['notCoverted']=  $this->lead_model->statusCounts($emp_id,6,$search['source']);				
		$data['Junk']=  $this->lead_model->statusCounts($emp_id,7,$search['source']);				
		$data['Test']=  $this->lead_model->statusCounts($emp_id,8,$search['source']);				
		}else{
			$status = $search['status'];
			/* if($search['status']=='Not Coverted to Customer')
				$status = 'notCoverted';
			if($search['status']=='Coverted to Customer')
				$status = 'Coverted';
			if($search['status']=='Proposal Sent')
				$status = 'Proposal'; */
				
			switch($search['status']){
				case 1: $status = 'New';
				break;
				case 2: $status = 'Contacted';
				break;
				case 3: $status = 'Qualified';
				break;
				case 4: $status = 'Proposal';
				break;
				case 5: $status = 'Coverted';
				break;
				case 6: $status = 'notCoverted';
				break;
				case 7: $status = 'Junk';
				break;
				case 8: $status = 'Test';
				break;
				case 9: $status = 'Local Verification';
				break;
			}				
			$data[$status] =  $this->lead_model->statusCounts($emp_id,$search['status'],$search['source']);
		}		
		
		$data['subtotal'] = ($data['New']+$data['Contacted']+$data['Qualified']+$data['Proposal']+$data['Coverted']+$data['notCoverted']);
		
		$leads =  $this->lead_model->GetRecords();
		/* echo "<pre>";
		print_r($leads); 
		echo "</pre>";
		exit; */
		$data['leads'] = $leads;
		
		if($export!='excel'){
       
			$this->load->view('leads/leadlist', $data);
			$this->load->view('fixed/footer');
		}else{
            
			$this->load->view('leads/leadexcel', $data);
		}
    }
	
	
	public function exporttoexcel(){
		$leads =  $this->lead_model->GetRecords();
		//print_r($lead); exit;
		$data['leads'] = $leads;		
        $this->load->view('leads/leadexcel', $data);
	}
	
	public function update()
    {
	   $this->lead_model->updatelead();
	   redirect('/leads/', 'refresh');
    }
	
	public function updatestatus()
    {
	   $status	= $this->input->post('status');
       return $this->lead_model->UpdateLeadStatus($status);	   
    }
	
	public function manageleads()
    {
       $this->lead_model->updateleadnotificationstatus();
	   redirect('/leads/', 'refresh');
    }
	
	public function assignLead(){		
		$assignto	= $this->input->post('assignto');	
		return $this->lead_model->assignLeadEmp($assignto);	
	}
	
	public function statusCounts(){		
		$emp_id	= $this->input->post('emp_id');	
		$data[] =  $this->lead_model->statusCounts($emp_id,1);	
		$data[] =  $this->lead_model->statusCounts($emp_id,2);	
		$data[] =  $this->lead_model->statusCounts($emp_id,3);	
		$data[] =  $this->lead_model->statusCounts($emp_id,4);	
		$data[] =  $this->lead_model->statusCounts($emp_id,5);	
		$data[] =  $this->lead_model->statusCounts($emp_id,6);	
		$data[] =  $this->lead_model->statusCounts($emp_id,7);	
		$data[] =  $this->lead_model->statusCounts($emp_id,8);	
		$data[] =  $this->lead_model->statusCounts($emp_id,9);	
		$data1 = implode("-",$data);
		print_r($data1);
	}
	
	public function GetTotalNotificationLeadsByUser(){
		echo $lead_noti_count = $this->lead_model->GetTotalNotificationLeadsByUser($_SESSION['id']);
	}
	
	public function viewLog(){
		$lead_id	= $this->input->post('lead_id');
		$data['lead_log'] = $this->lead_model->GetLeadStatusLogByLeadId($lead_id);
		$this->load->view('leads/view-lead-log', $data);
	}
	
		
	public function sendemail(){
		$mailto = 'devendra.cartnyou@gmail.com';
		$mailtotitle='Cartnyou'; 
		$subject='Test Mail'; 
		$message = 'Test Mail'; 
		$attachmenttrue = false; 
		$attachment = '';	
		
		$this->load->model('communication_model');
		//$this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
		$this->communication_model->send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
	}
	

    public function create()
    {
        $this->load->library("Common");
        $data['langs'] = $this->common->languages();
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->add_fields(1);
        $head['title'] = 'Create Franchise';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity'] = $this->customers->activity($custid);
        $data['custom_fields'] = $this->custom->view_fields_data($custid, 1);
        $head['title'] = 'View Franchise';
        $this->load->view('fixed/header', $head);
        if ($data['details']['id']) $this->load->view('customers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_datatables();
        $data = array();
        if ($this->input->post('due')) {
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = amountExchange($customers->total - $customers->pamnt, 0, $this->aauth->get_user()->loc);
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                $data[] = $row;
            }
        } else {
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                $data[] = $row;
            }
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    //edit section
    public function edit()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Common");
        $pid = $this->input->get('id');
        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 1);
        $head['title'] = 'Edit Customer';
        $data['langs'] = $this->common->languages();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');
    }

    public function addcustomer()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $taxid = $this->input->post('taxid', true);
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $language = $this->input->post('language', true);
        $create_login = $this->input->post('c_login', true);
        $password = $this->input->post('password_c', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $discount = $this->input->post('discount', true);
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $language, $create_login, $password, $docid, $custom, $discount);


    }

    function sendSelected()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post('cust')) {
            $ids = $this->input->post('cust');

            $subject = $this->input->post('subject', true);
            $message = $this->input->post('text');
            $attachmenttrue = false;
            $attachment = '';
            $recipients = $this->customers->recipients($ids);
            $this->load->model('communication_model');
            $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
        }
    }

    function sendSmsSelected()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->input->post('cust')) {
            $ids = $this->input->post('cust');
            $message = $this->input->post('message', true);
            $recipients = $this->customers->recipients($ids);
            $this->config->load('sms');
            $this->load->model('sms_model');
            foreach ($recipients as $row) {

                $this->sms_model->send_sms($row['phone'], $message);

            }
        }
    }

    public function editcustomer()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->post('id');
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $customergroup = $this->input->post('customergroup', true);
        $taxid = $this->input->post('taxid', true);
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $language = $this->input->post('language', true);
        $discount = $this->input->post('discount', true);
        if ($id) {
            $this->customers->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $docid, $custom, $language, $discount);
        }
    }

    public function changepassword()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password', true);
            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if ($this->aauth->premission(11)) {

            $id = $this->input->post('deleteid');
            if ($id > 1) {
                if ($this->customers->delete($id)) {
                    echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
                }
            } else if ($this->input->post('cust')) {
                $customers = $this->input->post('cust');
                foreach ($customers as $row) {
                    $this->customers->delete($row);
                }
                echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function displaypic()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }
    }


    public function translist()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;

            $row[] = $this->lang->line($prd->method);
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->customers->inv_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $invoices->tid;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function transactions()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function quotes()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Quotes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/quotes', $data);
        $this->load->view('fixed/footer');
    }

    public function qto_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $list = $this->customers->qto_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();

            $row[] = $invoices->tid;

            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->qto_count_all($cid),
            "recordsFiltered" => $this->customers->qto_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function balance()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $amount = $this->input->post('amount', true);
            if ($this->customers->recharge($id, $amount)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'View Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function projects()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/projects', $data);
        $this->load->view('fixed/footer');
    }

    public function prj_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');


        $list = $this->customers->project_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';

            $row[] = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> ' . $this->lang->line('View') . ' </a> <a class="btn btn-info btn-sm" href="' . base_url() . 'projects/edit?id=' . $project->id . '" data-object-id="' . $project->id . '"> <i class="fa fa-pencil"></i> </a>&nbsp;<a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $project->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->project_count_all($cid),
            "recordsFiltered" => $this->customers->project_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function notes()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
        $this->session->set_userdata("cid", $custid);
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/notes', $data);
        $this->load->view('fixed/footer');
    }

    public function notes_load_list()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->notes_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $note->title;
            $row[] = dateformat($note->cdate);

            $row[] = '<a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->notes_count_all($cid),
            "recordsFiltered" => $this->customers->notes_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editnote()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $content = $this->input->post('content');
            $cid = $this->input->post('cid');
            if ($this->customers->editnote($id, $title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='notes?id=$cid' class='btn btn-indigo btn-lg'><span class='icon-user' aria-hidden='true'></span>  </a> <a href='editnote?id=$id&cid=$cid' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $cid = $this->input->get('cid');
            $data['note'] = $this->customers->note_v($id, $cid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function addnote()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $content = $this->input->post('content');

            if ($this->customers->addnote($title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote?id=" . $cid . "' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='notes?id=" . $cid . "' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Note';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/addnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function delete_note()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');
        if ($this->customers->deletenote($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function statement()
    {

        if ($this->input->post()) {

            $this->load->model('reports_model');


            $customer = $this->input->post('customer');
            $trans_type = $this->input->post('trans_type');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
            $data['customer'] = $this->customers->details($customer);


            $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type, $sdate, $edate);


            $html = $this->load->view('customers/statementpdf', $data, true);


            ini_set('memory_limit', '64M');


            $this->load->library('pdf');

            $pdf = $this->pdf->load();


            $pdf->WriteHTML($html);


            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        } else {
            $data['id'] = $this->input->get('id');
            $this->load->model('transactions_model');

            $data['details'] = $this->customers->details($data['id']);
            $head['title'] = "Account Statement";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/statement', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function documents()
    {
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Documents';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/documents', $data);
        $this->load->view('fixed/footer');
    }

    public function document_load_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->customers->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat($document->cdate);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->document_count_all($cid),
            "recordsFiltered" => $this->customers->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {
        $data['id'] = $this->input->get('id');
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Document';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents?id=' . $cid . '"
                                       class="btn btn-indigo btn-md"><i
                                                class="icon-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->customers->adddocument($title, $filename, $cid);
            }

            $this->load->view('customers/adddocument', $data);
        } else {


            $this->load->view('customers/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');

        if ($this->customers->deletedocument($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function bulkpayment()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Bulk Payment Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/bulkpayment', $data);
        $this->load->view('fixed/footer');
    }

    public function bulk_post()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $csd = $this->input->post('customer', true);
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $trans_type = $this->input->post('trans_type', true);
        $data['details'] = $this->customers->sales_due($sdate, $edate, $csd, $trans_type);

        $due = $data['details']['total'] - $data['details']['pamnt'];
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated') . ' ' . amountExchange($due), 'due' => amountExchange_s($due)));
    }
	
    public function adminleads(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tele Caller Admin Leads';
		$this->load->view('fixed/header', $head);
		$data['telecallers'] = $this->lead_model->GetEmployeesByRoleId(16);
		$data['leads'] = $this->lead_model->getLeadsByAssignUser();
		//$data['records'] = $this->jobwork->getjobworkRecords();
		$this->load->view('leads/admin-leads',$data);
		$this->load->view('fixed/footer');
	}
	
    public function manageadminleads(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tele Caller Manage Admin Leads';
		$this->load->view('fixed/header', $head);
		$data['rsm'] = $this->lead_model->GetEmployeesByRoleId(4);
		$data['leads'] = $this->lead_model->getLeadsByStatus(5);
		$this->load->view('leads/manage-admin-leads',$data);
		$this->load->view('fixed/footer');
	}
	
    public function callerleads(){
		if($this->input->post('status') !=''){
			$status = $this->input->post('status');
			$lead_id = $this->input->post('lead_id');
			$others = $this->input->post('others');
			$date_modified = date('Y-m-d H:i:s');
			
			$this->db->set('status', $status);
			$this->db->set('remarks', $others);
			$this->db->set('date_modified', $date_modified);
			$this->db->where('id', $lead_id);
			$this->db->update('contactus');			
			
			$data1 = array();	
			$data1['lead_id'] = $lead_id;
			$data1['status'] = $status;
			$data1['remarks'] = $others;			
			$data1['date_created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('history_log',$data1);
		}
		
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tele Caller Leads';
		$this->load->view('fixed/header', $head);
		$status_not[] = 3; // Junk
		$status_not[] = 5; // Qualified
		
		$data['leads'] = $this->lead_model->getLeadsByAssignUser($status_not);
		$this->load->view('leads/caller-leads',$data);
		$this->load->view('fixed/footer');
	}
	
    public function rsmleads(){
		if($this->input->post('status') !=''){
			$status = $this->input->post('status');
			$lead_id = $this->input->post('lead_id');
			$others = $this->input->post('others');
			$date_modified = date('Y-m-d H:i:s');
			$data2 = array();
			if($status==29){
				$data2['lead_id'] = $lead_id;
				$this->db->insert('geopos_franchise',$data2);
			}
			
			$this->db->set('status', $status);
			$this->db->set('remarks', $others);
			$this->db->set('date_modified', $date_modified);
			$this->db->where('id', $lead_id);
			$this->db->update('contactus');			
			
			$data1 = array();	
			$data1['lead_id'] = $lead_id;
			$data1['status'] = $status;
			$data1['remarks'] = $others;			
			$data1['date_created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('history_log',$data1);
		}
		
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'RSM Leads';
		$this->load->view('fixed/header', $head);
		$data['leads'] = $this->lead_model->getLeadsByAssignUser();
		$this->load->view('leads/rsm-leads',$data);
		$this->load->view('fixed/footer');
	}
	
    public function projectmanager(){
		if($this->input->post('status') !=''){
			$status = $this->input->post('status');
			$lead_id = $this->input->post('lead_id');
			$others = $this->input->post('others');
			$date_modified = date('Y-m-d H:i:s');
			
			$this->db->set('status', $status);
			$this->db->set('remarks', $others);
			$this->db->set('date_modified', $date_modified);
			$this->db->where('id', $lead_id);
			$this->db->update('contactus');			
			
			$data1 = array();	
			$data1['lead_id'] = $lead_id;
			$data1['status'] = $status;
			$data1['remarks'] = $others;			
			$data1['date_created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('history_log',$data1);
		}
		
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Project Manager';
		$this->load->view('fixed/header', $head);
		$data['leads'] = $this->lead_model->GetRecords();
		$this->load->view('leads/project-manager',$data);
		$this->load->view('fixed/footer');
	}
	
    public function accountteamleads(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Account Team Leads';
		$this->load->view('fixed/header', $head);
		$data['leads'] = $this->lead_model->getLeadsByStatus(29);		
		$this->load->view('leads/account-team',$data);
		$this->load->view('fixed/footer');
	}
	
    public function bulk_post_payment()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $csd = $this->input->post('customer', true);
        $account = $this->input->post('account', true);
        $pay_method = $this->input->post('pmethod', true);
        $amount = numberClean($this->input->post('amount', true));
        $sdate = datefordatabase($this->input->post('sdate_2'));
        $edate = datefordatabase($this->input->post('edate_2'));

        $trans_type = $this->input->post('trans_type_2', true);
        $note = $this->input->post('note', true);
        $data['details'] = $this->customers->sales_due($sdate, $edate, $csd, $trans_type, false, $amount, $account, $pay_method, $note);

        $due = 0;
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Paid') . ' ' . amountExchange($amount), 'due' => amountExchange_s($due)));
    }
	
	
	public function import(){
		$head['title'] = 'Import';
        $this->load->view('fixed/header', $head);
        $this->load->view('leads/import', $data);
        $this->load->view('fixed/footer');
	}	
	
	
	public function sample_lead(){
		
		$fileName = 'sample_lead.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Source');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'State');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Pincode');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Shop Type');
       
		
		
		 $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		 $objWriter->save($fileName);
		 header("Content-Type: application/vnd.ms-excel");
		 redirect(base_url().$fileName);   	
	}
	
    public function add_leads()
    {
		$id = $this->input->get('id');
		$data['franchise'] = $this->lead_model->getFranchisebyLeadId($id);		
		 
        $head['title'] = 'Add Leads';
        $this->load->view('fixed/header', $head);
        $this->load->view('leads/addlead', $data);
        $this->load->view('fixed/footer');
    }
	
	public function edit_leads()
    {
		$franchise_id = $this->input->get('id');
		$search['franchise_id'] = $franchise_id;
		$data['search'] = $search;		
		$franchise = $this->customers->GetFranchiseById($franchise_id);
		$data['franchise'] = $franchise;
		
		//End	
		
        $head['title'] = 'Edit Leads';
        $this->load->view('fixed/header', $head);
        $this->load->view('leads/editlead', $data);
        $this->load->view('fixed/footer');
    }
	
	public function import_leads(){	
		
		if(isset($_FILES["file"]["name"]))
		{		
			$path = $_FILES["file"]["tmp_name"]; 
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow(); 
				$highestColumn = $worksheet->getHighestColumn();
				
				$data = array();
				$data1 = array();
				for($row=2; $row<=$highestRow; $row++)
				{		
					$name = 		$worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$email = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$mobile = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$source = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$state = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$city = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$pincode = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$shop_type = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					
					$state_id = $this->lead_model->GetStateIDbyName($state);
					
					$data['name'] = $name;
					$data['email'] = $email;
					$data['mobileno'] = $mobile;
					$data['source'] = $source;
					$data['state'] = $state_id;
					$data['city'] = $city;
					$data['pincode'] = $pincode;
					$data['shop_type'] = $shop_type;					
					$data['status'] = 1;					
					$data['date'] = date('Y-m-d h:i:s');					
					
					/* if($serialNumber != '' && $serialNumber != ' '){
						$data[] = array('serialNumber' => $serialNumber,'product_name' =>$product_name);
					} */		
					$data1[] = $data;
				}

			}
			//echo "<pre>";print_r($data1);die;	
			$this->lead_model->import_leads($data1);
			redirect('/leads', 'refresh');			
		}else{
			 echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	public function partial_activate(){
		$id = $this->input->post('id');
		$this->db->set('partial_active', 1);			
		$this->db->set('date_modified', $date_modified);
		$this->db->where('id', $id);
		$this->db->update('geopos_franchise');
	}
	
	public function partial_deactivate(){
		$id = $this->input->post('id');
		$this->db->set('partial_active', 0);			
		$this->db->set('date_modified', $date_modified);
		$this->db->where('id', $id);
		$this->db->update('geopos_franchise');
	}

}