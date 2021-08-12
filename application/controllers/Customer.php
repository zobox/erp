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

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model', 'customer');
		$this->load->model('plugins_model', 'plugins');
		
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
        $head['title'] = 'Customer';
		$data['customer'] = $this->customer->getAllCustomer();
		$this->load->view('fixed/header', $head);
        $this->load->view('customer/clist',$data);
        $this->load->view('fixed/footer');
    }
	
	public function view(){
		$id = $this->uri->segment(3);
		$data['customer'] = $this->customer->getAllCustomer($id)[0];
		$data['customer']->image = base_url(). 'userfiles/customers/example.png';
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customer Details';
		$this->load->view('fixed/header', $head);
        $this->load->view('customer/view',$data);
        $this->load->view('fixed/footer');
	}
	
     public function b2bcustomers()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'B2B Customers';
        $data['customer'] = $this->customer->getB2BCustomer();
        $this->load->view('fixed/header', $head);
        $this->load->view('customer/b2b',$data);
        $this->load->view('fixed/footer');
    }
    
    
    public function b2bview(){
        $id = $this->uri->segment(3);
        $data['customer'] = $this->customer->getAllCustomer($id)[0];
        $data['customer']->image = base_url(). 'userfiles/customers/example.png';
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customer Details';
        $this->load->view('fixed/header', $head);
        $this->load->view('customer/b2bview',$data);
        $this->load->view('fixed/footer');
    }
    public function b2bviewinvoices(){
        //$id = $this->uri->segment(3);
        $id = $this->input->get('id');
        
        $data['customer'] = $this->customer->getAllCustomer($id)[0];
        $data['list'] = $this->customer->inv_datatables($id, $tid=0);
        /* echo "<pre>";
        print_r($data['list']);
        echo "</pre>"; exit; */
        
        $data['customer']->image = base_url(). 'userfiles/customers/example.png';
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customer/b2bview_invoices',$data);
        $this->load->view('fixed/footer');
    }
    
    
    public function inv_list()
    {
        
        /* if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        } */
        $cid = $this->input->post('cid');
        //$tid = $this->input->post('tyd');

        $list = $this->customer->inv_datatables($cid, $tid=0);
        //$list = $this->customer->inv_datatables(22, $tid);
        
        /* echo "<pre>";
        print_r($list);
        echo "</pre>"; exit; */
        
        
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
                case 6: $prefix = 'POBB#';
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
   
   

   

}