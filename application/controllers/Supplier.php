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

class Supplier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model', 'supplier');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'stock';
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {   
        $data['customergrouplist'] = $this->supplier->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);
        $data['customergroup'] = $this->supplier->group_info($data['details']['gid']);
        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        if ($data['details']['id']) $this->load->view('supplier/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $list = $this->supplier->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;           
           // $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->company;
			$row[] = '<a href="supplier/view?id=' . $customers->id . '">' . $customers->name . '</a>';
            $row[] = $customers->email;
            $row[] = $customers->phone;
            $row[] = '<a href="'.base_url().'supplier/view?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="'.base_url().'supplier/edit?id=' . $customers->id . '" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->count_all(),
            "recordsFiltered" => $this->supplier->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //edit section
    public function edit()
    {
        $pid = $this->input->get('id');

        $data['customer'] = $this->supplier->details($pid);
        $data['customergroup'] = $this->supplier->group_info($pid);
        $data['customergrouplist'] = $this->supplier->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function addsupplier()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address_b = $this->input->post('address_b', true);
        $city_b = $this->input->post('city_b', true);
        $state_b = $this->input->post('state_b', true);
        $country_b = $this->input->post('country_b', true);
        $postbox_b = $this->input->post('postbox_b', true);
		if($this->input->post('same_address', true) == 1){
			$same_as_billing = 1;
			$address_s = $this->input->post('address_b', true);
			$city_s = $this->input->post('city_b', true);
			$state_s = $this->input->post('state_b', true);
			$country_s = $this->input->post('country_b', true);
			$postbox_s = $this->input->post('postbox_b', true);
		}
		else{
			$same_as_billing = 1;
			$address_s = $this->input->post('address_s', true);
			$city_s = $this->input->post('city_s', true);
			$state_s = $this->input->post('state_s', true);
			$country_s = $this->input->post('country_s', true);
			$postbox_s = $this->input->post('postbox_s', true);
		}
		$pan = $this->input->post('pan', true);
		$gst = $this->input->post('gst', true);
		$rtgs = $this->input->post('rtgs', true);
		$account_no = $this->input->post('account_no', true);
		$bank_name = $this->input->post('bank_name', true);
        $branch_name = $this->input->post('branch_name', true);
		
		if($_FILES['pan_up']['name']!= ""){
					
				$imageFileType = pathinfo($_FILES['pan_up']['name'],PATHINFO_EXTENSION);
				$pan_up=$this->supplier->upload1('pan_up',$imageFileType);
			}else{
				$pan_up=$this->input->post('pan_up_old');
			}
		if($_FILES['gst_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['gst_up']['name'],PATHINFO_EXTENSION);
				$gst_up=$this->supplier->upload1('gst_up',$imageFileType);
			}else{
				$gst_up=$this->input->post('gst_up_old');
			}
		if($_FILES['cancelled_cheque_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['cancelled_cheque_up']['name'],PATHINFO_EXTENSION);
				$cancelled_cheque_up=$this->supplier->upload1('cancelled_cheque_up',$imageFileType);
			}else{
				$cancelled_cheque_up=$this->input->post('cancelled_cheque_up_old');
			}
		
       $this->supplier->add($name, $company, $phone, $email, $address_b, $city_b, $state_b, $country_b, $postbox_b, $address_s, $city_s, $state_s, $country_s, $postbox_s, $pan, $gst, $rtgs, $account_no, $bank_name, $branch_name, $pan_up, $gst_up, $cancelled_cheque_up,$same_as_billing);
	    /* $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/clist');
        $this->load->view('fixed/footer'); */
	}

    public function editsupplier()
    {
        $id = $this->input->post('id', true);
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address_b = $this->input->post('address_b', true);
        $city_b = $this->input->post('city_b', true);
        $state_b = $this->input->post('state_b', true);
        $country_b = $this->input->post('country_b', true);
        $postbox_b = $this->input->post('postbox_b', true);
		if($this->input->post('same_address', true) == 1){
			$same_as_billing = 1;
			$address_s = $this->input->post('address_b', true);
			$city_s = $this->input->post('city_b', true);
			$state_s = $this->input->post('state_b', true);
			$country_s = $this->input->post('country_b', true);
			$postbox_s = $this->input->post('postbox_b', true);
		}
		else{
			$same_as_billing = 1;
			$address_s = $this->input->post('address_s', true);
			$city_s = $this->input->post('city_s', true);
			$state_s = $this->input->post('state_s', true);
			$country_s = $this->input->post('country_s', true);
			$postbox_s = $this->input->post('postbox_s', true);
		}
		$pan = $this->input->post('pan', true);
		$gst = $this->input->post('gst', true);
		$rtgs = $this->input->post('rtgs', true);
		$account_no = $this->input->post('account_no', true);
		$bank_name = $this->input->post('bank_name', true);
        $branch_name = $this->input->post('branch_name', true);
		
		if($_FILES['pan_up']['name']!= ""){
					
				$imageFileType = pathinfo($_FILES['pan_up']['name'],PATHINFO_EXTENSION);
				$pan_up=$this->supplier->upload1('pan_up',$imageFileType);
			}else{
				$pan_up=$this->input->post('pan_up_old');
			}
		if($_FILES['gst_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['gst_up']['name'],PATHINFO_EXTENSION);
				$gst_up=$this->supplier->upload1('gst_up',$imageFileType);
			}else{
				$gst_up=$this->input->post('gst_up_old');
			}
		if($_FILES['cancelled_cheque_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['cancelled_cheque_up']['name'],PATHINFO_EXTENSION);
				$cancelled_cheque_up=$this->supplier->upload1('cancelled_cheque_up',$imageFileType);
			}else{
				$cancelled_cheque_up=$this->input->post('cancelled_cheque_up_old');
			}

        if ($id) {
            $this->supplier->edit($id, $name, $company, $phone, $email, $address_b, $city_b, $state_b, $country_b, $postbox_b, $address_s, $city_s, $state_s, $country_s, $postbox_s, $pan, $gst, $rtgs, $account_no, $bank_name, $branch_name, $pan_up, $gst_up, $cancelled_cheque_up,$same_as_billing);
			/* $head['usernm'] = $this->aauth->get_user()->username;
			$head['title'] = 'Supplier';
			$this->load->view('fixed/header', $head);
			$this->load->view('supplier/clist');
			$this->load->view('fixed/footer'); */
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->supplier->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function displaypic()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->supplier->editpicture($id, $img);
        }


    }


    public function translist()
    {
        $cid = $this->input->post('cid');
        $list = $this->supplier->trans_table($cid);
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
            $row[] = $prd->payer;
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->trans_count_all($cid),
            "recordsFiltered" => $this->supplier->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->supplier->inv_datatables($cid);
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;

            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->inv_count_all($cid),
            "recordsFiltered" => $this->supplier->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }


    public function transactions()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);
        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);

        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function bulkpayment()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->supplier->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Bulk Payment Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/bulkpayment', $data);
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
        $data['details'] = $this->supplier->sales_due($sdate, $edate, $csd, $trans_type);

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
        $data['details'] = $this->supplier->sales_due($sdate, $edate, $csd, $trans_type, false, $amount, $account, $pay_method, $note);

        $due = 0;
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Paid') . ' ' . amountExchange($amount), 'due' => amountExchange_s($due)));
    }


}