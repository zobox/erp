<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Franchise extends CI_Controller{
	 public function __construct()
    {
        parent::__construct();
       // $this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
		$this->load->model('Dashboard_model','dashboard');
		$this->load->model('Lead_model','lead');
		$this->load->model('Communication_model','communication');
		$this->load->model('Sms_model','sms');
		$this->load->model('Franchise_model','franchise');
    }

    //invoices list
    public function index()
    {
       $lead_id = $this->uri->segment(3);
		$head['title'] = "Franchise";
		$this->load->view('includes/header',$head);
        //$this->load->view('lead/index',$data);
        $this->load->view('includes/footer');
    }
	public function create()
    {
		$lead_id = $this->uri->segment(3);
		$data['id'] = $this->lead->getFranchiseIdByLeadId($lead_id);
		$data['franchise'] = $this->lead->details($this->lead->getFranchiseIdByLeadId($lead_id));
		$head['title'] = "Franchise Create";
		$this->load->view('includes/header',$head);
        $this->load->view('franchise/franchise-create',$data);
        $this->load->view('includes/footer');
    }
	public function edit()
    {
		$lead_id = $this->uri->segment(3);
		$data['id'] = $this->lead->getFranchiseIdByLeadId($lead_id);
		$data['franchise'] = $this->lead->details($this->lead->getFranchiseIdByLeadId($lead_id));
		$head['title'] = "Franchise Edit";
		$this->load->view('includes/header',$head);
        $this->load->view('franchise/franchise-create',$data);
        $this->load->view('includes/footer');
    }
	
	public function save(){
			if($_FILES['balance_sheet_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['balance_sheet_up']['name'],PATHINFO_EXTENSION);
				$balance_sheet_up=$this->franchise->upload1('balance_sheet_up',$imageFileType);
			}else{
				$balance_sheet_up=$this->input->post('balance_sheet_up_old');
			}	

			if($_FILES['itr_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['itr_up']['name'],PATHINFO_EXTENSION);
				$itr_up=$this->franchise->upload1('itr_up',$imageFileType);
			}else{
				$itr_up=$this->input->post('itr_up_old');
			}	

			if($_FILES['pan_card_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['pan_card_up']['name'],PATHINFO_EXTENSION);
				$pan_card_up=$this->franchise->upload1('pan_card_up',$imageFileType);
			}else{
				$pan_card_up=$this->input->post('pan_card_up_old');
			}	
			
			if($_FILES['gst_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['gst_up']['name'],PATHINFO_EXTENSION);
				$gst_up=$this->franchise->upload1('gst_up',$imageFileType);
			}else{
				$gst_up=$this->input->post('gst_up_old');
			}	
			
			if($_FILES['bank_statement_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['bank_statement_up']['name'],PATHINFO_EXTENSION);
				$bank_statement_up=$this->franchise->upload1('bank_statement_up',$imageFileType);
			}else{
				$bank_statement_up=$this->input->post('bank_statement_up_old');
			}	
						
			if($_FILES['cancelled_cheque_up']['name']!= ""){
				$imageFileType = pathinfo($_FILES['cancelled_cheque_up']['name'],PATHINFO_EXTENSION);
				$cancelled_cheque_up=$this->franchise->upload1('cancelled_cheque_up',$imageFileType);
			}else{
				$cancelled_cheque_up=$this->input->post('cancelled_cheque_up_old');
			}
			
			if($_FILES['abcd']['name']!= ""){
				$imageFileType = pathinfo($_FILES['abcd']['name'],PATHINFO_EXTENSION);
				$abcd_up=$this->franchise->upload1('abcd',$imageFileType);
			}else{
				$abcd_up=$this->input->post('abcd_old');
			}
			
			
			$save = $this->franchise->save($balance_sheet_up,$itr_up,$pan_card_up,$gst_up,$bank_statement_up,$cancelled_cheque_up,$abcd_up);
             
			if($save==TRUE) {
				redirect('lead/', 'refresh');
			}else{
				$lead_id = $this->uri->segment(3);
				$data['id'] = $this->lead->getFranchiseIdByLeadId($lead_id);
				$data['franchise'] = $this->lead->details($this->lead->getFranchiseIdByLeadId($lead_id));
				$head['title'] = "Franchise";
				$this->load->view('includes/header',$head);
        		$this->load->view('franchise/franchise-create',$data);
        		$this->load->view('includes/footer');
			}
			}
	
	
}
?>