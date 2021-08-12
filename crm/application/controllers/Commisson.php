<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Commisson extends CI_Controller
	{
   	 public function __construct()
    	{
        parent::__construct();
        //$this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    	}

    //invoices list
    public function index()
    	{
			//echo "tttt";exit;
        $head['title'] = "Manage Commisson";
        $this->load->view('includes/header');
        $this->load->view('commisson/index');
        $this->load->view('includes/footer');
   		 }
}
?>