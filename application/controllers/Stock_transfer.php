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

class Stock_transfer extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

		$this->load->model('products_model', 'products');
		$this->load->model('ewb_model', 'ewb');
        $this->load->model('categories_model');
        $this->load->model('chart_model', 'chart');
		$this->load->model('settings_model', 'settings');

		$this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('invoices_model', 'invocies');
		$this->load->library("Custom");
		$this->load->library("Common");

        $this->li_a = 'stock';
    }
	

    public function index()
    {
		if($this->input->post()){						
			$this->ewb->generateEWB();	
			/* $wid = $this->input->post('s_warehouses');
			$customer_record = $this->customers->getFranchiseByWarehouseID($wid);
			$wid1 = $this->input->post('to_warehouses');
			$customer_record1 = $this->customers->getFranchiseByWarehouseID($wid1);	
			$this->ewb->generateInvoice($customer_record1->id); */
			
			
		}else{		
			$head['title'] = "Stock Transfer HTML VIEW";
			$data['emp'] = $this->plugins->universal_api(69);
			if ($data['emp']['key1']) {
				$this->load->model('employee_model', 'employee');
				$data['employee'] = $this->employee->list_employee();
			}

			
			$data['custom_fields_c'] = $this->custom->add_fields(1);

			
			$data['exchange'] = $this->plugins->universal_api(5);
			$data['customergrouplist'] = $this->customers->group_list();
			$data['lastinvoice'] = $this->invocies->lastinvoice();
			$data['warehouse'] = $this->invocies->warehouses();
			$data['terms'] = $this->invocies->billingterms();
			$data['currency'] = $this->invocies->currencies();
		   
			$data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
			$head['title'] = "New Invoice";
			$head['usernm'] = $this->aauth->get_user()->username;
			$data['taxdetails'] = $this->common->taxdetail();
			$data['custom_fields'] = $this->custom->add_fields(2);
			
			$this->load->view('fixed/header');
			$this->load->view('stock_transfer/stock_transfer',$data);
			$this->load->view('fixed/footer');
		}
	}
	

	public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['attach'] = $this->invocies->attach($tid);
        $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = "Invoice " . $data['invoice']['tid'];
        $this->load->view('fixed/header', $head);
        $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $data['custom_fields'] = $this->custom->view_fields_data($tid, 2);
        if ($data['invoice']['id']) {
            $data['invoice']['id'] = $tid;
            $this->load->view('invoices/view', $data);
        }
        $this->load->view('fixed/footer');
    }
	
	
	public function generateewb(){
		if($this->input->post()){
			echo json_encode(array('status' => 'Success', 'message' =>'Success'));
			//$this->ewb->generateEWB();		
		}
	}
	
	
	public function getwarehouseDropDown(){
		$id = $this->input->post('id');
		$warehouse = $this->ewb->getwarehouseDropDown($id);
		$data['warehouse'] = $warehouse;		
		$this->load->view('stock_transfer/getwarehouseDropDown',$data);
	}
	
	public function getAvailableSerialByPID(){
		echo $this->ewb->getAvailableSerialByPID(14,1);
	}
	
	public function ChangeSerialsStatus(){
		$this->ewb->ChangeSerialsStatus(14,1,2,2);
	}
	

}