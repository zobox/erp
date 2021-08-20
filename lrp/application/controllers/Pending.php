<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Pending extends CI_Controller{
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
        $head['title'] = "Pending Receives";
        $this->load->view('includes/header',$head);
		$data['list'] = $this->invocies->invoice_details();
        $this->load->view('pending/index',$data);
        $this->load->view('includes/footer');
    }
	
	public function create()
    {
		$head['title'] = "Create New Lead";
		$this->load->view('includes/header',$head);
        $this->load->view('lead/create');
        $this->load->view('includes/footer');
    }
	
	public function receive_view()
    {
		if ($this->input->post('serial', true)) {
			$serial = $this->input->post('serial', true);
			$data['list'] = $this->invocies->invoice_serial_details($invoice_id='',$serial,$status=6,$is_present=0);			
		}
		$id = $this->input->get('id');
        $head['title'] = "Pending Receives View";
        $this->load->view('includes/header',$head);
        $this->load->view('pending/receive-view',$data);
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
	
	public function iqc_work()
    {
		if ($this->input->post('serial', true)) {
			$serial = $this->input->post('serial', true);
			$data['list'] = $this->invocies->invoice_serial_details($invoice_id='',$serial,$status='',$is_present='',$product_serial_status=2);	
		}
		$data['conditions'] = $this->invocies->getConditions();
        $this->load->view('includes/header',$head);
        $this->load->view('pending/iqc-work',$data);
        $this->load->view('includes/footer');
    }
	
	public function manage_iqc_work()
    {
        $this->load->view('includes/header',$head);
		$data['list'] = $this->invocies->invoice_details($invoice_id='',$product_serial_status=4);
        $this->load->view('pending/manage-iqc-work',$data);
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
	
	public function getcomponents(){
		$pid = $this->input->get('pid');		
		$result = $this->invocies->getComponentByPid($pid);
		
		//echo $result;
		echo json_encode($result);
	}
	
	public function save_iqc_work(){	
		$jobwork_required = $this->input->post('jobwork_required');	
		if($jobwork_required==1){
			$res = $this->invocies->send_to_jobwork();
			if($res){
				redirect('pending/manage_iqc_work');
			}
		}else if($jobwork_required==3){
			
		}
	}
	
	public function save_receive_view(){	
		$serial = $this->input->post('serial');
		if($serial){
			$res = $this->invocies->save_receive_view($serial);
			if($res){
				redirect('pending');
			}
		}
	}

	
}
?>