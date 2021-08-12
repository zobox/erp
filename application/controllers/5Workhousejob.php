<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Workhousejob extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model("Jobwork_model",'jobwork');
		$this->load->model('purchase_model', 'purchase');
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
		$data['conditions'] = $this->purchase->getConditions();
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
	
	public function final_qc_data(){
		$data['records'] = $this->products_cat->manage_requests();
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Assign Job Work';
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/final-qc-data',$data);
		$this->load->view('fixed/footer');
	}
	
	public function openwork(){		
		$data['jobwork_list'] = $this->jobwork->jobWorkRequest();
		
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Open Job Work';
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/open-work',$data);
		$this->load->view('fixed/footer');
	}
	
	public function open_view(){
		$id= $this->input->get('id');		 
		$data['product_info'] = $this->jobwork->getJobWorkDetail($id);
		//echo $data['product_info']->product_detail->pid; exit;
		$data['varients'] = $this->jobwork->getProductVarients($data['product_info']->product_detail->pid);
		//$data['component_list'] = $this->jobwork->JobWorkComponent($data['product_info']->serial);

        $data['jobwork_id'] = $id;
        $data['product_category_array'] = array_reverse(explode("-",substr($this->products_cat->getParentcategory($data['product_info']->product_detail->pcat),1)));
        $data['product_category_array_title'] = $this->products_cat->getCategoryNames($data['product_category_array']);
		$data['cat_sub'] = $this->products_cat->sub_cat_curr($data['product_info']->product_detail->sub_id);
        $data['cat_sub_list'] = $this->products_cat->sub_cat_list($data['product_info']->product_detail->pcat);
        $data['cat'] = $this->products_cat->category_list();
		
		$data['request_id'] = $id;
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pending Job Work';
		$this->load->view('fixed/header', $head);
		$records = $this->jobwork->getProductSerialById($id);
		$data['records'] = $records;
		$data['component'] = $this->jobwork->getProductComponentByPID($records->product_id);		
		$this->load->view('workhouse/openview',$data);
		$this->load->view('fixed/footer');		
	}
	
	public function failed_view(){
		$id= $this->input->get('id');		 
		$data['product_info'] = $this->jobwork->getJobWorkDetail($id);
		//echo $data['product_info']->product_detail->pid; exit;
		$data['varients'] = $this->jobwork->getProductVarients($data['product_info']->product_detail->pid);
		$data['component_list'] = $this->jobwork->JobWorkComponent($data['product_info']->serial);

        $data['jobwork_id'] = $id;
        $data['product_category_array'] = array_reverse(explode("-",substr($this->products_cat->getParentcategory($data['product_info']->product_detail->pcat),1)));
        $data['product_category_array_title'] = $this->products_cat->getCategoryNames($data['product_category_array']);
		$data['cat_sub'] = $this->products_cat->sub_cat_curr($data['product_info']->product_detail->sub_id);
        $data['cat_sub_list'] = $this->products_cat->sub_cat_list($data['product_info']->product_detail->pcat);
        $data['cat'] = $this->products_cat->category_list();
		
		$data['request_id'] = $id;
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Failed QC Work View';
		$this->load->view('fixed/header', $head);
		$records = $this->jobwork->getProductSerialById($id);
		$data['records'] = $records;
		$data['component'] = $this->jobwork->getProductComponentByPID($records->product_id);		
		$this->load->view('workhouse/failedwork-view',$data);
		$this->load->view('fixed/footer');		
	}
	
	public function send_request(){		
		//$id = 11;
		echo $this->jobwork->send_request();
	}
	
	public function manage_jobwork(){
		$data['jobwork_list'] = $this->jobwork->jobWorkManage();
        $head['title'] = "Manage Job Work";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('workhouse/manage-jobwork',$data);
        $this->load->view('fixed/footer');
    
    }
	
	public function manage_view(){
		$id= $this->uri->segment(3); 
		$head['usernm'] = $this->aauth->get_user()->username;
		$id= $this->input->get('id');
		$data['records'] = $this->jobwork->getJobWorkDetail($id);
        $head['title'] = 'Manage Job Work View';
		$this->load->view('fixed/header', $head);				
		$this->load->view('workhouse/manage-view',$data);
		$this->load->view('fixed/footer');		
	}
	
	
	public function failedwork(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Failed QC Work';
        $data['failed_jobwork_list'] = $this->jobwork->failedJobwork();
       
		$this->load->view('fixed/header', $head);
		$this->load->view('workhouse/failedwork',$data);
		$this->load->view('fixed/footer');
	}	

	public function assignteamlead(){		
		$res = $this->products_cat->assignteamlead();
		print_r($res);
		//echo json_encode($res);
	}
 
	public function assign_engineer()
	{
		$serial = $this->input->post('serial');
		$type = $this->input->post('type');
		$jobwork_id = $this->input->post('jobwork_id');
		$engineer  = $this->input->post('engineer_name');
		
		$this->db->where('id',$jobwork_id);		
		$query = $this->db->get('tbl_jobcard');
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {					
				if($row->assign_engineer!=''){
					$data1 = array('jobcard_id' =>$jobwork_id, 
					'teamlead_id' => $row->teamlead_id,
					'serial' => $row->serial,
					'assign_engineer' => $row->assign_engineer,
					'status' => $row->status,
					'change_status' => $row->change_status,
					'final_qc_status' => $row->final_qc_status,
					'final_qc_remarks' => $row->final_qc_remarks,
					'final_condition' => $row->final_condition,
					'sub_cat' => $row->sub_cat,
					'date_created' => date('Y-m-d h:i:s')				
					);
					
					$this->db->insert('tbl_jobcard_history',$data1);
				}else{
					$date = date('Y-m-d');
					$data2 = array('batch_number' =>$date);
					$this->db->set($data2);
					$this->db->where('id', $jobwork_id);
					$this->db->update('tbl_jobcard');
					//echo $this->db->last_query(); exit;
				}				
			}			
		}	
		
        $data = array('assign_engineer' =>$engineer, 'change_status' => 2);
		if($type==2){
			$data['final_qc_status'] = 1;
		}
		
		$this->db->set($data);
        $this->db->where('id', $jobwork_id);
        $this->db->update('tbl_jobcard');	
        redirect('workhousejob/openwork', 'refresh');        
	}

	public function change_status()
	{
		$jobwork_id = $this->input->post('jobwork_id');
		$change_status  = $this->input->post('change_status');
        $data = array('change_status' => $change_status);
		
		$this->db->where('id',$jobwork_id);		
		$query = $this->db->get('tbl_jobcard');
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {					
				if($row->assign_engineer!=''){
					$data1 = array('jobcard_id' =>$jobwork_id, 
					'teamlead_id' => $row->teamlead_id,
					'serial' => $row->serial,
					'assign_engineer' => $row->assign_engineer,
					'status' => $row->status,
					'change_status' => $row->change_status,
					'final_qc_status' => $row->final_qc_status,
					'final_qc_remarks' => $row->final_qc_remarks,
					'final_condition' => $row->final_condition,
					'sub_cat' => $row->sub_cat,
					'date_created' => date('Y-m-d h:i:s')				
					);
					
					$this->db->insert('tbl_jobcard_history',$data1);
				}
			}			
		}

		$this->db->set($data);
        $this->db->where('id', $jobwork_id);
        $this->db->update('tbl_jobcard');
        //echo $this->db->last_query(); die;

        redirect('workhousejob/openwork', 'refresh');

        
	}
	public function final_qc_status()
	{
		$jobwork_id = $this->input->post('jobwork_id');
		$final_qc_status  = $this->input->post('final_qc_status');
		$remark = $this->input->post('remark');
        $data = array('final_qc_status' => $final_qc_status,'final_qc_remarks' => $remark);
        
		$this->db->where('id',$jobwork_id);		
		$query = $this->db->get('tbl_jobcard');
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {					
				if($row->assign_engineer!=''){
					$data1 = array('jobcard_id' =>$jobwork_id, 
					'teamlead_id' => $row->teamlead_id,
					'serial' => $row->serial,
					'assign_engineer' => $row->assign_engineer,
					'status' => $row->status,
					'change_status' => $row->change_status,
					'final_qc_status' => $row->final_qc_status,
					'final_qc_remarks' => $row->final_qc_remarks,
					'final_condition' => $row->final_condition,
					'sub_cat' => $row->sub_cat,
					'date_created' => date('Y-m-d h:i:s')				
					);
					
					$this->db->insert('tbl_jobcard_history',$data1);
				}
			}			
		}
		
		$this->db->set($data);
        $this->db->where('id', $jobwork_id);
        $this->db->update('tbl_jobcard');
        if($final_qc_status==3)
        {
        	redirect('workhousejob/openwork','refresh');
        }
        else
        {
        redirect('workhousejob/open_view?id='.$jobwork_id, 'refresh');
        } 
        
	} 
	
	public function save(){
		$this->products_cat->savejobwork();
		 redirect('workhousejob/openwork', 'refresh');
	}
	
	
}
?>