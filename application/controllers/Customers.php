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

class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('categories_model', 'products_cat');
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('accounts_model', 'accounts');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
		//$this->customers->getRSMDetailsByLeadId(9); exit;
		$franchise_id = $this->input->get('franchise_id');
		$search['franchise_id'] = $franchise_id;
		$data['search'] = $search;		
		$franchise = $this->customers->GetFranchiseById($franchise_id);
		$data['franchise'] = $franchise;
		$data['franchiselist'] = $this->customers->GetFranchisedropdown();
		$this->load->library("Common");
        $data['langs'] = $this->common->languages();
        $data['customergrouplist'] = $this->customers->group_list();
		$this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->add_fields(1);
		// Set Comission		
		$data['franchise_commission'] = $this->plugins->getFranchiseComissionByFranchiseID($franchise_id);
		$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$franchise->website_id);			
		foreach($data['cat'] as $key=>$catdata){
			$datacat[$catdata->id]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $catdata->id,$franchise_id,$franchise->module);
			$datacat[$catdata->id][1] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='1',$franchise_id);
			$datacat[$catdata->id][2] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='2',$franchise_id);
			$datacat[$catdata->id][3] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='3',$franchise_id);
		}
		$data['catcommision'] = $datacat;
		//End	
		
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
		$data['warehouse'] = $this->products_cat->getWarehouseByFranchiseId($data['details']['franchise_id']);
		$data['store'] = $this->customers->getStoreByFranchiseId($data['details']['franchise_id']);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity'] = $this->customers->activity($custid);
        $data['custom_fields'] = $this->custom->view_fields_data($custid, 1);
		$data['is_agent'] = $this->customers->is_agent($custid);
        $head['title'] = 'View Customer';
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
                $row[] = $customers->franchise_code;
				$row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span>';
                $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = amountExchange($customers->total - $customers->pamnt, 0, $this->aauth->get_user()->loc);
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                //$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                
				if($customers->status==1){
				$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-warning btn-sm deactivate-object">Deactivate</a>';
                }else{
				$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-warning btn-sm activate-object">Activate</a>';	
				}
				
				$data[] = $row;
            }
        } else {
            foreach ($list as $customers) {
                $no++;
                $row = array();				
               // $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
				$row[] = $no;
                $row[] = $customers->franchise_code;
				$row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/' . $customers->picture . '" style="height:70px;width:70px;"></span>';
                $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                //$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                if($customers->status==1){
				$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm deactivate-object">Deactivate</a>';
                }else{
				$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm activate-object">Activate</a>';	
				}
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
        if (!$this->aauth->premission(3)) {
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
        $franchise_id = $this->input->post('franchise_id', true);
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
	
	public function deactivate_i(){
		$id = $this->input->post('deactivateid');
		$this->db->set('is_deleted', 1, FALSE);
        $this->db->where('cid', $id);
		$this->db->update('users');
		
		$this->db->set('status', 0, FALSE);
        $this->db->where('id', $id);
        if($this->db->update('geopos_customers')){
			 echo json_encode(array('status' => 'Success', 'message' => 'Customer deactivated Successfully!'));
		}
	}
	
	public function activate_i(){
		$id = $this->input->post('activateid');
		
		$this->db->set('is_deleted', 0, FALSE);
        $this->db->where('cid', $id);
		$this->db->update('users');
		
		$this->db->set('status', 1, FALSE);
        $this->db->where('id', $id);
        if($this->db->update('geopos_customers')){
			 echo json_encode(array('status' => 'Success', 'message' => 'Customer activated Successfully!'));
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
			switch($invoices->type){
				case 1: $prefix = 'STFO#';
				break;
				case 2: if($invoices->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
				break;
				case 3: $prefix = 'STF#';
				break;
				case 4: $prefix = 'PO#';
				break;
			}
			
            $no++;
            $row = array();
            $row[] = $prefix.$invoices->tid;
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

            $row[] = '<a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a><a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
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
	
	public function commission()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $details = $this->customers->details($custid);		
		$data['details'] = $details;
		$franchise_id = $details['franchise_id'];	
		$franchise = $this->customers->GetFranchiseById($franchise_id);
		$data['franchise'] = $franchise;		
		
		// Set Comission		
		$data['franchise_commission'] = $this->plugins->getFranchiseComissionByFranchiseID($franchise_id);
		$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$franchise->website_id);			
		
		
		foreach($data['cat'] as $key=>$catdata){
			$datacat[$catdata->id]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $catdata->id,$franchise_id,$franchise->module);
			$datacat[$catdata->id][1] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='1',$franchise_id);
			$datacat[$catdata->id][2] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='2',$franchise_id);
			$datacat[$catdata->id][3] = $this->plugins->getCatCommision($franchise->module,$category_id=$catdata->id,$purpose='3',$franchise_id);
		}
		$data['catcommision'] = $datacat;
		//End
		
		
		$data['module_commision'] = $this->customers->getFranchiseComissionByFranchiseID($franchise_id);
		$data['cat_commision'] =$this->customers->getCatCommision($module_id='',$category_id='',$purpose='',$franchise_id);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Commission';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/commission', $data);
        $this->load->view('fixed/footer');
    }
	
	
	public function update_commission(){
		$custid = $this->input->post('id');
        $details = $this->customers->details($custid);		
		$data['details'] = $details;
		$franchise_id = $details['franchise_id'];
		$this->plugins->updateFranchiseCommission($m=true,$franchise_id);
		redirect(base_url().'customers/commission?id='.$custid);
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
	
	public function getSubcatAjaxData()
	{
	
		$categoryId = $this->input->post('categoryId');
		$moduleid = $this->input->post('moduleid');
		$franchise_id = $this->input->post('franchise_id');
		//$datacat[$categoryId]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $categoryId);
		$datacat[$categoryId]['cat'] = $this->products_cat->getCategoryById($categoryId);
		
		$datacat[$categoryId][1] = $this->plugins->getCatCommision($moduleid,$categoryId,$purpose='1',$franchise_id);
		$datacat[$categoryId][2] = $this->plugins->getCatCommision($moduleid,$categoryId,$purpose='2',$franchise_id);
		$datacat[$categoryId][3] = $this->plugins->getCatCommision($moduleid,$categoryId,$purpose='3',$franchise_id);
		$data['catcommision'] = $datacat;
		//print_r($data);
		 $this->load->view('customers/getSubcatAjaxData', $data);
	}
	
	
	public function get_franchise_dropdown(){		
		$data['franchise'] = $this->customers->GetFranchisedropdown1();
		$data['franchise_id'] = $this->input->post('franchise_id');
		$this->load->view('customers/get_franchise_dropdown', $data);
	}
	
	public function commission_wallet(){
		if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
		$data['list'] = $this->invocies->invoiceByFranchiseID($custid);
        $this->load->view('customers/commission_wallet', $data);
        $this->load->view('fixed/footer');
	}
	
	
	public function download_commission_wallet_excel(){
		$this->load->library('excel');
		$fileName = 'franchise_commission.xlsx';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Franchise Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Store Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice No');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Qty');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Invoice Gross Price');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Invoice Net Price');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Invoice GST');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Commission Amount');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Commission %');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'TDS');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');			
		$list = json_decode($this->invocies->invoiceByFranchiseID($this->input->post('cust_id'),$start_date,$end_date));
		$i=2;		
		foreach($list as $invoices){			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $invoices->franchise_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $invoices->store_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $this->config->item('prefix') . ' #' . $invoices->tid);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $invoices->invoicedate);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $invoices->items);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $invoices->total);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $invoices->net_price);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $invoices->tax);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $invoices->franchise_commission);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $invoices->fcp);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $invoices->tds);
			$i++;
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . $fileName);
	}
	
	public function agent_commission_wallet(){
		if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Agent Commission Wallet';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/agent_commission_wallet', $data);
        $this->load->view('fixed/footer');
	}
	
	
	public function commission_wallet_balance(){
		if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $amount = $this->input->post('amount', true);
            if ($this->customers->commission_debit($id, $amount)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Debited')));
				redirect(base_url().'customers/commission_wallet_balance?id='.$id);
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
			$head['usernm'] = $this->aauth->get_user()->username;
			$head['title'] = 'View Commission Wallet Balance';
			$this->load->view('fixed/header', $head);
			$custid = $this->input->get('id');
			$data['details'] = $this->customers->details($custid);
			$data['list'] = $this->invocies->franchiseTransactions($custid);			
			$this->load->view('customers/commission_wallet_balance',$data);
			$this->load->view('fixed/footer');
		}
	}
	
	public function link_account(){
		if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
		
		if ($this->input->post()) {
            $custid = $this->input->post('custid');			
            if ($this->customers->link_account()) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ACCOUNT UPDATED')));
				//redirect(base_url().'customers/link_account?id='.$custid);
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
			$custid = $this->input->get('id');
			$data['custid'] = $custid;
			$data['details'] = $this->customers->details($custid);
			$data['money'] = $this->customers->money_details($custid);
			$head['usernm'] = $this->aauth->get_user()->username;
			$head['title'] = 'View Customer Invoices';
			$this->load->view('fixed/header', $head);
			$data['account_details'] = $this->accounts->accountslist();
			$this->load->view('customers/link_account', $data);
			$this->load->view('fixed/footer');
		}
	}


    public function franchise_assets(){
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $custid = $this->input->get('id');
        $data['result'] = $this->customers->user_asset($custid);
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);

        $data['list'] = $this->invocies->invoiceByFranchiseID($custid);
        
        for($j=0;$j<count($data['result']);$j++)
        {
       $data['product_category_array'] = array_reverse(explode("-",substr($this->products_cat->getParentcategory($data['result'][$j]['pcat']),1)));
       $parent_id = end($data['product_category_array']);
       $data['parent_cat'][] = $this->products_cat->GetParentCatTitleById($parent_id);
        } 
        
        
  
        $this->load->view('customers/franchise_assets', $data);
        $this->load->view('fixed/footer');
    }
    public function add_data(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Data';
		$this->load->view('fixed/header', $head);
		//$data['records'] = $this->jobwork->getjobworkRecords();
		$this->load->view('customers/add-data',$data);
		$this->load->view('fixed/footer');
    }
    public function edit_data(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Data';
		$this->load->view('fixed/header', $head);
		//$data['records'] = $this->jobwork->getjobworkRecords();
		$this->load->view('customers/edit-data',$data);
		$this->load->view('fixed/footer');
    }

    public function add_trc()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add TRC';
        $this->load->view('fixed/header', $head);
        
        $this->load->view('lrp/add_lrp');
        $this->load->view('fixed/footer');
    }

    public function add_trc_lrp()
    {

        $username = $this->input->post('username', true);
        $name       = $this->input->post('name');
        $email      = $this->input->post('email');
        $address    = $this->input->post('address');
        $city       = $this->input->post('city');
        $region     = $this->input->post('region');
        $pincode    = $this->input->post('postbox');
        $password   = $this->input->post('password');
        $c_password = $this->input->post('c_password');
        $name_arr = explode(' ',$name);

        $state_code = $this->getState($state);
        
        

        $data = array();
        $data2= array();

        $exist_user = $this->db->query("select * from users_lrp where email='".$email."'");
        if($exist_user->num_rows()>0)
        {
            echo json_encode(array('status' => 'Error', 'message' =>
                'User Already Exist.'));
        }
        else
        {

        if($password!=$c_password)
        {
            echo json_encode(array('status' => 'Error', 'message' => 'Password Not Matched!'));
        }
        else
        {
            $data = array(
             'agency_id'   => $username,
             'name'        => $name,
             'email'       => $email,
             'address'     => $address,
             'city'        => $city,
             'region'      => $region,
             'pincode'     => $pincode,
             'password'    => md5($password),
             'hass_p'      => $c_password,
             'date_created'=> date('Y-m-d h:i:s')
            );
           
            if($this->db->insert("users_lrp",$data))
            {
                $user_id = $this->db->insert_id();

                
                $data2['title']          = 'Trc_'.$city.'-'.$name; 
                $data2['cid']            = 0;               
                $data2['franchise_id']   = $user_id;                 
                $data2['extra']          = $city.'-'.$name;
                $data2['loc']            = 0;
                $data2['warehouse_type'] = 2; 
                $this->db->insert('geopos_warehouse', $data2);
              
                
                $wid = $this->db->insert_id();              
                
                $data3 = array();               
                $data3['warehouse_code'] = 'Trc_'.$state_code.'_'.$city.'_W'.$user_id.'-'.$name_arr[0]; 
                $this->db->where('id', $wid);
                $this->db->update('geopos_warehouse',$data3);

                $this->aauth->applog("[Add TRC] $name ID " . $user_id, $this->aauth->get_user()->username);

                echo json_encode(array('status' => 'Success', 'message' => 'TRC details Added Successfully!')); 



            }
            else 
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                'There has been an error, please try again.'));
            }
        }
        }
    }

    public function trc_list()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'TRC List';
        $this->load->view('fixed/header', $head);
        
        $this->load->view('lrp/trclist');
        $this->load->view('fixed/footer');
    }


    public function trc_load_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->getTrcList();
        
        $data = array();
        
            foreach ($list as $customers) {
                $no++;
                $row = array();             
               // $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = $no;
                $row[] = $customers->warehouse_code;
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->profile_pic . '" ></span>';
                $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                //$row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
                if($customers->status==1){
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm deactivate-object">Deactivate</a>';
                }else{
                $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm activate-object">Activate</a>'; 
                }
                $data[] = $row;
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
}