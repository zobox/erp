<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Jobwork extends CI_Controller{
	public function __construct()
    {
        parent::__construct();       
        $this->load->model("Jobwork_model",'jobwork');       
	}
	
	public function index(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Job Work';
		$this->load->view('fixed/header', $head);
		$this->load->view('jobwork/index');
		$this->load->view('fixed/footer');
	}
	
	public function pending(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pending Job Work';
		$this->load->view('fixed/header', $head);
		$data['records'] = $this->jobwork->productSerial();
		$this->load->view('jobwork/pending',$data);
		$this->load->view('fixed/footer');
	}
	
	public function manage(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Manage Job Work';
		$this->load->view('fixed/header', $head);
		$data['records'] = $this->jobwork->getjobworkRecords();
		$this->load->view('jobwork/manage',$data);
		$this->load->view('fixed/footer');
	}
	
	public function pendingproduct(){
		$id= $this->uri->segment(3); 
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pending Job Work';
		$this->load->view('fixed/header', $head);
		$records = $this->jobwork->getProductSerialById($id);
		$data['records'] = $records;
		$data['component'] = $this->jobwork->getProductComponentByPID($records->product_id);		
		$this->load->view('jobwork/pendingproductview',$data);
		$this->load->view('fixed/footer');		
	}

	public function manage_product(){
		$serial_id= $this->uri->segment(3); 
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Manage Product Work';
		$this->load->view('fixed/header', $head);
		$data['records'] = $this->jobwork->getjobworkRecordsById($serial_id);
		$this->load->view('jobwork/manage_product',$data);
		$this->load->view('fixed/footer');
		
	}
	
	public function getcomponentCost(){
		$previous_condition = $this->input->post('previous_condition');
		$new_condition = $this->input->post('new_condition');
		$pid = $this->input->post('pid');
		$res =  $this->jobwork->getcomponentCost($previous_condition,$new_condition,$pid);
		print_r($res);
	}
	
	
	public function addjobwork(){
		$this->jobwork->addjobwork();
	}
	
	
	public function setComponent(){
		$id = $this->input->post('id');	
		$redirect_url = base_url().'jobwork/pendingproduct/'.$id;
		$this->jobwork->setComponent();
		redirect($redirect_url);
	}

	
}
?>