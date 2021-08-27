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

		$data['item_component'] = $this->jobwork->getComponentItemMaster($data['product_info']->product_detail->pid);		
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
	
	
     public function delete_assign_jobwork()
    {
       
            
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $get_request = $this->db->query("select * from tbl_jobwork_request where id in (select request_id from tbl_jobwork_issue where id='".(int)$id."')");
                
                $get_req_info = $get_request->row_array();
                
                $jobwork_req_id = $get_req_info['id'];


                $this->db->set('status',8);
                $this->db->where("id",$jobwork_req_id);
                $this->db->update("tbl_jobwork_request");
                
                $this->db->set('status',8);
                $this->db->where("jobwork_req_id",$jobwork_req_id);     
                $this->db->update("geopos_product_serials");

                $query3 = $this->db->query("update tbl_warehouse_serials set status=8 where serial_id in (select id from geopos_product_serials where jobwork_req_id='".(int)$jobwork_req_id."')");

                 $this->db->set('status',8);
                $this->db->where("id",$id);
                $this->db->update("tbl_jobwork_issue");
                
                $this->db->set('status',8);
                $this->db->where("jobwork_issue_id",$id);     
                $this->db->update("tbl_jobwork_issue_serial");
                

                $query1 = $this->db->query("update tbl_jobwork_issue_component set status=8 where jobwork_issue_serial_id in (select id from tbl_jobwork_issue_serial where jobwork_issue_id='".(int)$id."')"); 
                
                 echo json_encode(array('status' => "Success", 'message' => $this->lang->line('DELETED')));
                
                
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


     public function getcomponents(){
		$product_id = $this->input->GET('product_id');
		$result = $this->jobwork->getComponentByPid($product_id);
        
		echo json_encode($result);
	}

	public function addcomponentJobwork()
	{
		$pid        = $this->input->post('req_product_id');
		$jobwork_id = $this->input->post('req_jobwork_id');
		$component_id = $this->input->post('items');
		$pro_serial = $this->input->post('pro_serial');

		for($i=0;$i<count($component_id);$i++)
		{
			$data = array(
              'issue_id' => $jobwork_id,
              'product_serial' => $pro_serial,
              'status'        => 3   
			);
			$this->db->set($data);
			$this->db->where("component_id",$component_id[$i]);
			$this->db->where("status",1);
			$this->db->limit(1);
			$this->db->update("tbl_component_serials",$data);

        }
            redirect('workhousejob/open_view?id='.$jobwork_id, 'refresh');
	}

	public function getComponentZupcById()
	{
		$component_id = $this->input->post('component_id');
		$this->db->select("warehouse_product_code");
		$this->db->where("id",$component_id);
		$data = $this->db->get("tbl_component")->result_array();

		echo $data[0]['warehouse_product_code'];
	}

	public function addComponentMasterJobwork()
	{
        $pid        = $this->input->post('req_product_id_component');
		$jobwork_id = $this->input->post('req_jobwork_id_component');
		$item_component_id = $this->input->post('item_component_id');
		$pro_component_serial = $this->input->post('pro_component_serial');
		$component_zupc_code = $this->input->post('component_zupc_code');
		$component_qty = $this->input->post('component_qty');


        $data = array();
		for($i=0;$i<$component_qty;$i++)
		{
			$data = array(
             'component_id'   => $item_component_id,
             'purchase_id'    => 0,
             'serial'         => $component_zupc_code,
             'issue_id'       => $jobwork_id,
             'product_serial' => $pro_component_serial,
             'qty'            => 1,
             'serial_in_type' => 2,
             'status'         => 1
			);
			

			$this->db->insert("tbl_component_serials",$data);
			
			
		}
		redirect('workhousejob/open_view?id='.$jobwork_id, 'refresh');
		
	}



	
}
?>