<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Commission_wallet extends CI_Controller
	{
   	 public function __construct()
    	{
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    	}

    //invoices list
    public function index()
    	{
			
        	$head['title'] = "Commisson Wallet";
        	$this->load->view('includes/header');
        	$this->load->view('commisson_wallet/index');
        	$this->load->view('includes/footer');
   		 }
	
	//invoices view 
	public function view(){
		$tid = $this->uri->segment(3);
		$data['acclist'] = '';
		$data['id'] = $tid;
		$data['invoice'] = $this->invocies->invoice_details($tid);
		
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
		$head['title'] = "View Invoice";
		$this->load->view('includes/header');
		$this->load->view('commisson_wallet/view',$data);
		$this->load->view('includes/footer');
	}
		
}
?>