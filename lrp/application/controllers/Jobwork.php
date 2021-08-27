<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Jobwork extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		// $this->load->model('invoices_model', 'invocies');
		$this->load->model('Dashboard_model','dashboard');		
		$this->load->model('Communication_model','communication');
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('jobwork_model', 'jobwork');
    }

    //invoices list
    public function index()
    {
        $this->load->view('includes/header',$head);
		$data['list'] = $this->invocies->invoice_details($invoice_id='',$product_serial_status=4);
        $this->load->view('jobwork/index',$data);
        $this->load->view('includes/footer');
	}
	
    public function manage_job_work()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('jobwork/manage-job-work',$data);
        $this->load->view('includes/footer');
    }
	
	
	public function open()
    {
        $this->load->view('includes/header',$head);
		$data['list'] = $this->invocies->invoice_details($invoice_id='',$product_serial_status=6);
        $this->load->view('jobwork/open-job',$data);
        $this->load->view('includes/footer');
    }
	
    public function open_view()
    {
		$id = $this->input->get('id');		
        $this->load->view('includes/header',$head);		
		$data['conditions'] = $this->invocies->getConditions();
		$data['list'] = $this->invocies->invoice_serial_details($invoice_id='',$serial,$status='',$is_present='',$product_serial_status=6,$id);	
		$data['varients'] = $this->invocies->getProductVarients($data['list'][0]->pid);
		$data['product_category_array'] = array_reverse(explode("-",substr($this->invocies->getParentcategory($data['list'][0]->pcat),1)));
		$data['product_category_array_title'] = $this->invocies->getCategoryNames($data['product_category_array']);
		$data['cat'] = $this->invocies->category_list();
		$data['components'] = $this->invocies->JobWorkComponent($data['list'][0]->serial);
		$data['qc_components'] = $this->invocies->get_qc_component_bySerial($data['list'][0]->serial);
		$data['item_component'] = $this->invocies->getComponentItemMaster($data['list'][0]->pid);
		
        $this->load->view('jobwork/open-view',$data);
        $this->load->view('includes/footer');		
			
		/* $id= $this->input->get('id');		 
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
		$this->load->view('fixed/footer'); */		
    }
	
	
	public function failedqc()
    {
        $this->load->view('includes/header',$head);	
		$head['title'] = 'Failed QC Work';
        $data['list'] = $this->jobwork->failedJobwork();
        $this->load->view('jobwork/failed-qc',$data);
        $this->load->view('includes/footer');
    }
	
	public function managejob()
    {
        $this->load->view('includes/header',$head);
		$data['list'] = $this->jobwork->jobWorkManage();
		$head['title'] = "Manage Job Work";
        $this->load->view('jobwork/manage-work',$data);
        $this->load->view('includes/footer');
    }
	
	public function apicall(){
		$pincode = $this->input->post('pincode',true);
		$data = json_decode(file_get_contents("https://api.postalpincode.in/pincode/".$pincode),true);
		if($data[0]['Status'] == "Success"){
			$data = $data[0]['PostOffice'];
			$data = $data[0]['State'];
			$query = $this->db->get('state');
			if($query->num_rows() > 0){
				foreach($query->result() as $rows){
					if(strtolower($data) == strtolower($rows->name)){echo '<option value="'.$rows->id.'" selected="">'.$rows->name.'</option>';}
				}
			}
			
		}
		
	}
	
	public function pending_work()
    {
        $head['title'] = "Pending Work";
        $this->load->view('includes/header',$head);
        $this->load->view('pending/pending-work',$data);
        $this->load->view('includes/footer');
    }
	
	
	public function assigntl(){
		$teamlead = $this->input->post('teamlead');
		$serial = $this->input->post('serial');
		$jobwork_id = $this->input->post('jobwork_id');		 
		
		$this->db->set('status', 6, FALSE);
		$this->db->set('date_modified', "'".date('Y-m-d H:i:s')."'", FALSE);
		$this->db->where('serial', $serial);
		$this->db->update('geopos_product_serials');		
		
		$this->db->set('teamlead', "'".$teamlead."'", FALSE);
		$this->db->set('date_modified', "'".date('Y-m-d H:i:s')."'", FALSE);
		$this->db->where('id', $jobwork_id);
		$this->db->update('tbl_jobcard');
				
		redirect('jobwork/open');
	}
	
	public function subCatDropdownHtml($ProductCategoryId=''){
        if($ProductCategoryId == ''){
            $ProductCategoryId = $this->input->post('id',true);
        }
        $result = $this->invocies->category_list_dropdown(1, $ProductCategoryId);
        if($result != false){
            //$html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
                $html .= "<option value='".$row->id."'>".$row->title."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }
	
	public function getComponentZupcById()
	{
		$component_id = $this->input->post('component_id');
		$this->db->select("warehouse_product_code");
		$this->db->where("id",$component_id);
		$data = $this->db->get("tbl_component")->result_array();

		echo $data[0]['warehouse_product_code'];
	}
	
	public function getcomponents(){
		$product_id = $this->input->GET('product_id');
		$result = $this->jobwork->getComponentByPid1($product_id);
        
		echo json_encode($result);
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
		//echo $this->db->last_query(); exit;
        redirect('jobwork/open', 'refresh');        
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

        redirect('jobwork/open', 'refresh');
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
        	redirect('jobwork/open','refresh');
        }
        else
        {
        redirect('jobwork/open_view?id='.$jobwork_id, 'refresh');
        }         
	}

	public function addcomponentJobwork()
	{
		$pid        = $this->input->post('req_product_id');
		$jobwork_id = $this->input->post('req_jobwork_id');
		$component_id = $this->input->post('items');
		$pro_serial = $this->input->post('pro_serial');
		$warehouse_details = $this->invocies->getWarehouse();

		for($i=0;$i<count($component_id);$i++)
		{
			$data = array(
              'issue_id' => $jobwork_id,
              'product_serial' => $pro_serial,
              'status'        => 3   
			);
			$this->db->set($data);
			$this->db->where("component_id",$component_id[$i]);
			$this->db->where("status",4);
			$this->db->where("twid",$warehouse_details[0][id]);
			$this->db->limit(1);
			$this->db->update("tbl_component_serials",$data);
			//echo $this->db->last_query(); exit;
        }
        redirect('jobwork/open_view?id='.$jobwork_id, 'refresh');
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
		redirect('jobwork/open_view?id='.$jobwork_id, 'refresh');
	}
	
	public function save(){
		$id = $this->input->post('id');
		$res = $this->jobwork->savejobwork();
		if($res){				
			redirect('jobwork/open', 'refresh');
		}else{
			redirect('jobwork/open_view?id='.$id, 'refresh');
		}
	}
	
	public function manage_view(){
		$id= $this->uri->segment(3); 
		//$head['usernm'] = $this->aauth->get_user()->username;
		$id= $this->input->get('id');
		$data['records'] = $this->jobwork->getJobWorkDetail($id);
        $head['title'] = 'Manage Job Work View';
		$this->load->view('includes/header', $head);				
		$this->load->view('jobwork/manage-work-view',$data);
		$this->load->view('includes/footer');
	}
	
	public function lrc_new_invoice()
    {
        $this->load->view('includes/header',$head);
		$data['warehouse_list'] = $this->jobwork->getAllWarehouseExceptLoggedLRC();
        $this->load->view('jobwork/lrc-new-invoice',$data);
        $this->load->view('includes/footer');
    }
	
	public function lrc_manage_invoice()
    {
		$this->load->view('includes/header',$head);		
        $this->load->view('jobwork/lrc-manage-invoice',$data);
        $this->load->view('includes/footer');
    }
	
}
?>