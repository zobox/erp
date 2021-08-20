<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Jobwork extends CI_Controller{
	 public function __construct()
    {
        parent::__construct();
       // $this->load->model('invoices_model', 'invocies');
     
		$this->load->model('Dashboard_model','dashboard');
		$this->load->model('Lead_model','lead');
		$this->load->model('Communication_model','communication');
		$this->load->model('invoices_model', 'invocies');
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
	public function create()
    {
		$head['title'] = "Create New Lead";
		$this->load->view('includes/header',$head);
        $this->load->view('lead/create');
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
        $this->load->view('jobwork/failed-qc',$data);
        $this->load->view('includes/footer');
    }
	public function managejob()
    {
        $this->load->view('includes/header',$head);
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
		$data['total'] = $this->lead->getCountByStatus();
		$data['new'] = $this->lead->getCountByStatus(1);
		$data['contacted'] = $this->lead->getCountByStatus(2);
		$data['qualified'] = $this->lead->getCountByStatus(3);
		$data['proposal_sent'] = $this->lead->getCountByStatus(4);
		$data['converted_to_franchhise'] = $this->lead->getCountByStatus(5);
		$data['not_converted_to_franchhise'] = $this->lead->getCountByStatus(6);
		$data['junk'] = $this->lead->getCountByStatus(7);
		$data['test'] = $this->lead->getCountByStatus(8);
		$data['lead'] = $this->lead->getLeadList();
		
        $this->load->view('includes/header',$head);
        $this->load->view('pending/pending-work',$data);
        $this->load->view('includes/footer');
    }
	
	public function save(){
		$save = $this->lead->save();
		if($save){
			redirect('dashboard/');
		}
		else{
			redirect('lead/create');
		}
	}
	
	public function changesource(){
		$source = $this->input->post('source',true);
		echo base_url().'lead?source='.$source;
	}
	
	public function changeStatus(){
		$lead_id = $this->input->post('leadid',true);
		$status = $this->input->post('selectedStatus',true);
		$data = array('lead_id'=>$lead_id,'status'=>$status);
		
		echo $this->lead->UpdateLeadStatus($data);
	}
	
	public function getStatusHtml(){
		$status = $this->lead->getStatusHtml();
		$html = '';
		$html .= '<option value="1"';if($status == 1){$html .= 'selected=""';}$html .='>New</option>';
		$html .= '<option value="2"';if($status == 2){$html .= 'selected=""';}$html .='>Contacted</option>';
		$html .= '<option value="3"';if($status == 3){$html .= 'selected=""';}$html .='>Qualified</option>';
		$html .= '<option value="4"';if($status == 4){$html .= 'selected=""';}$html .='>Proposal Sent</option>';
		$html .= '<option value="5"';if($status == 5){$html .= 'selected=""';}$html .='>Converted to Franchise</option>';
		$html .= '<option value="6"';if($status == 6){$html .= 'selected=""';}$html .='>Not Coverted to Franchise</option>';
		$html .= '<option value="7"';if($status == 7){$html .= 'selected=""';}$html .='>Junk</option>';
		$html .= '<option value="8"';if($status == 8){$html .= 'selected=""';}$html .='>Test</option>';
		echo $html;		
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
	
}
?>