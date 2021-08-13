<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Workhousejob extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model("Jobwork_model",'jobwork');
        $this->load->model("Categories_model",'products_cat');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
	}
	
	public function index(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pending Job Work';
		$data['records'] = $this->jobwork->productSerial();
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/index',$data);
		$this->load->view('fixed/footer');
	}
	
	public function view(){	
		$id = $this->input->get('id');
		$data['records'] = $this->products_cat->assign_jobwork($id);
		$data['teamlead'] = $this->products_cat->getteamlead();
		$head['usernm'] = $this->aauth->get_user()->username;
		$head['title'] = 'View Page';
		$this->load->view('fixed/header', $head);
		$data['serial'] = $this->jobwork->productSerial();
		$this->load->view('workhouse/view',$data);
		$this->load->view('fixed/footer');
	}
	
	public function getiemi(){
		$issue_id = $this->input->get('issue_id');
		$res = $this->products_cat->getiemiByIssueId(1);
		echo json_encode($res);
	}
	
	public function assignwork(){
		$data['records'] = $this->products_cat->manage_requests();
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Assign Job Work';
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/assign-work',$data);
		$this->load->view('fixed/footer');
	}
	
	public function openwork(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Open Job Work';
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/open-work');
		$this->load->view('fixed/footer');
	}
	
	public function open_view(){
		$id= $this->uri->segment(3); 
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pending Job Work';
		$this->load->view('fixed/header', $head);
		$records = $this->jobwork->getProductSerialById($id);
		$data['records'] = $records;
		$data['component'] = $this->jobwork->getProductComponentByPID($records->product_id);		
		$this->load->view('workhouse/openview',$data);
		$this->load->view('fixed/footer');		
	}
	
	public function send_request(){		
		//$id = 11;
		echo $this->jobwork->send_request();
	}
	
	public function manage_jobwork(){
        $head['title'] = "Manage Job Work";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('workhouse/manage-jobwork');
        $this->load->view('fixed/footer');
    
    }
	
	public function manage_view(){
		$id= $this->uri->segment(3); 
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Manage Job Work View';
		$this->load->view('fixed/header', $head);
		$records = $this->jobwork->getProductSerialById($id);
		$data['records'] = $records;
		$data['component'] = $this->jobwork->getProductComponentByPID($records->product_id);		
		$this->load->view('workhouse/manage-view',$data);
		$this->load->view('fixed/footer');		
	}

	public function assignteamlead(){		
		$res = $this->products_cat->assignteamlead();
		print_r($res);
		//echo json_encode($res);
	}
	
}
?>