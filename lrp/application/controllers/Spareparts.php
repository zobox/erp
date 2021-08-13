<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Spareparts extends CI_Controller{
	 public function __construct()
    {
        parent::__construct();
       // $this->load->model('invoices_model', 'invocies');
     
		$this->load->model('Dashboard_model','dashboard');
		$this->load->model('Lead_model','lead');
		$this->load->model('Communication_model','communication');
    }

    //invoices list
    public function index()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/index',$data);
        $this->load->view('includes/footer');
    }
    public function manage_sparepart()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/manage-spare',$data);
        $this->load->view('includes/footer');
    }
    public function spare_more_details()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/spare-more-details',$data);
        $this->load->view('includes/footer');
    }
    public function manage_spare_add()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/manage-spare-add',$data);
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
        $this->load->view('jobwork/open-job',$data);
        $this->load->view('includes/footer');
    }
    public function open_view()
    {
        $this->load->view('includes/header',$head);
        $this->load->view('jobwork/open-view',$data);
        $this->load->view('includes/footer');
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
	
	public function franchise(){
		
		
	}
	
}
?>