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
		$this->load->model('invoices_model', 'invocies');
    }

    //invoices list
    public function index()
    {
        $this->load->view('includes/header',$head);
        $data['supplier_list'] = $this->invocies->getSupplier();
       
        $this->load->view('spareparts/index',$data);
        $this->load->view('includes/footer');
    }
    public function manage_sparepart()
    {

    	$twid = $this->invocies->getWarehouse()[0];
    	
    	$data['warehouse'] = $twid;
    	
    	$query = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and  status=4 group by component_id");
        $count = $query->num_rows();

        $qty = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and status=4");
        $total_qty = $qty->num_rows();
        $data['result'] = $query->result_array();
        
        $data['total_product']=$count;
        $data['total_qty']=$total_qty;
        $head['title'] = "View Component Warehouses";
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/manage-spare',$data);
        $this->load->view('includes/footer');
    }
    public function spare_more_details()
    {
    	$pid = intval($this->input->get('pid'));
    	$wid = intval($this->input->get('wid'));
    	$twid = $this->invocies->getWarehouse()[0];
    	
    	$data['warehouse'] = $twid;	
        $data['serial_list'] = $this->invocies->getSerialComponent($pid,$wid);

        $head['usernm'] = '';
        $head['title'] = 'Serial List';
        $head['title'] = "View Product Warehouses";
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/spare-more-details',$data);
        $this->load->view('includes/footer');
    }
    public function manage_spare_add()
    {
    	$twid = $this->invocies->getWarehouse()[0];
    	$data['warehouse'] = $twid;
    	$query = $this->db->query("select tbl_component_serials.component_id,tbl_component_serials.serial_in_type,tbl_component_serials.purchase_id, tbl_component.component_name as product, tbl_component.warehouse_product_code from tbl_component_serials LEFT JOIN tbl_component on tbl_component_serials.component_id=tbl_component.id where tbl_component_serials.twid='".$twid['id'] ."' and tbl_component_serials.status=4 group by tbl_component_serials.component_id");
       $record = array();
      $qty = array();
      $by_po_qty = array();
      $by_jobwork_qty = array();
      
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key=>$row) {  
              
                $record[] = $row;


                $qty_query = $this->db->query("select * from tbl_component_serials where status=4 and component_id='".$row->component_id."' and twid='".$twid['id'] ."'");
                if($qty_query->num_rows() > 0)
                {
                    $qty[] = $qty_query->num_rows();
                }else{
                    $qty[] = 0;
                }



            }           
            
        }
 
        $data['result']=$record;
        
        $data['qty']=$qty;
        $head['title'] = "View Product Warehouses";
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
	
	public function getListPo($supplier_id=''){

        if($supplier_id == ''){
            $supplier_id = $this->input->post('id',true);
        }

       
         $result = $this->invocies->getSupplier($supplier_id);
         if($result != false){
            //$html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
               $prefix = 'LRPSP';
                $po_order = $row->company.' &rArr; '.$prefix.'#'.$row->tid;
                $html .= "<option value='".$row->invoice_id."'>".$po_order."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }


    public function getListPoItem($invoice_id=''){

        if($invoice_id == ''){
            $invoice_id = $this->input->post('id',true);
        }
       
        
        $result = $this->invocies->getItemByInvoice($invoice_id);
        
        
            if($result != false){
                foreach($result as $row){
                    $html .= "<option value='".$row->pid.'-'.$row->tid."'>".$row->product."</option>";
                }
                echo $html;
            }
        
        
        
        return 0;
    }

     public function getproductinfo(){
        
            $id = $this->input->post('id',true);
            $product = explode('-',$id);
            $component_id = $product[0];
            $invoice_id   = $product[1];
            $result = $this->invocies->getvarient($component_id,$invoice_id);
                            
            if(is_array($result)){
                $html = $result[0]->warehouse_product_code.'#'.$result[0]->qty;
                echo $html;
            }else{
                return false;
            }
        
    }


   public function receive_sparepart()
   {
   	 $exp        = explode('-',$this->input->post('pid'));
     $invoice_id = $this->input->post('invoice_id');
   	 $pid        = $exp[0];
   	 $qty       = $this->input->post('qty');
     
     $data = array();   
   	 
      $this->db->set('lrp_status',2);
      $this->db->where('component_id',$pid);
      $this->db->where('invoice_id',$invoice_id);
      $this->db->where('status',4);
      $this->db->limit($qty);
      $this->db->update('tbl_component_serials');


   	 

   	 redirect('spareparts/manage_sparepart','refresh');
   	  
   }
	
}
?>