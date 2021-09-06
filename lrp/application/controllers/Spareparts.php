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
    	
    	$query = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and lrp_status=2 and status=4 group by component_id");
        $count = $query->num_rows();

        $qty = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and lrp_status=2 and status=4");
        $total_qty = $qty->num_rows();
        //$data['result'] = $query->result_array();
        $old_sp_query = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and serial_in_type=2 and status=1 group by component_id");
        $sparepart_count = $old_sp_query->num_rows();

        $sparepart_qty = $this->db->query("select * from tbl_component_serials where twid='".$twid['id'] ."' and serial_in_type=2 and status=1");
        $total_sp_qty = $sparepart_qty->num_rows();


        $data['total_product']=$count;
        $data['total_qty']=$total_qty;
        $data['old_total_product']=$sparepart_count;
        $data['old_total_qty']=$total_sp_qty;
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
    	$query = $this->db->query("select tbl_component_serials.component_id,tbl_component_serials.serial_in_type,tbl_component_serials.purchase_id, tbl_component.component_name as product, tbl_component.warehouse_product_code from tbl_component_serials LEFT JOIN tbl_component on tbl_component_serials.component_id=tbl_component.id where tbl_component_serials.twid='".$twid['id'] ."' and tbl_component_serials.lrp_status=2 and tbl_component_serials.status=4 group by tbl_component_serials.component_id");
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
         $supp_id = array(); 
         $supplier_id = $this->input->post('id',true);
         $supp_id = explode('-',$supplier_id);
         
         if($supp_id[1]==1)
         {
         $result = $this->invocies->getSupplier($supp_id[0]);
         if($result != false){
            $html="";
            $html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
               $prefix = 'LRPSP';
                $po_order = $row->company.' &rArr; '.$prefix.'#'.$row->tid;
                $html .= "<option value='".$row->invoice_id.'-'.$supp_id[1]."'>".$po_order."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
          }
          else
          {
            $result = $this->supplier_list_by_purchase($supp_id[0]);
            if($result != false){
            $html="";
            $html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
                 $prefix = 'LRPSP';
                $po_order = $row['company'].' &rArr; '.$prefix.'#'.$row['tid'];
                $html .= "<option value='".$row['purchase_id'].'-'.$supp_id[1]."'>".$po_order."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
              
          }
          return 0;
      }

    }


    public function getListPoItem($invoice_id=''){

        if($invoice_id == ''){
            $invoice_id = $this->input->post('id',true);
        }

        $invoice_id = explode('-',$invoice_id);
       
        if($invoice_id[1]==1)
        {
        $result = $this->invocies->getItemByInvoice($invoice_id[0]);
        
        
            if($result != false){
                $html="";
                $html .= "<option value='0'>Select</option>";
                foreach($result as $row){
                    $html .= "<option value='".$row->pid.'-'.$row->tid.'-'.$invoice_id[1]."'>".$row->product."</option>";
                }
                echo $html;
            }
        
        
        
        return 0;
        }
        else
        {
            
            $result = $this->invocies->getItemByPurchase($invoice_id[0]);
        
             
            if($result != false){
                $html="";
                $html .= "<option value='0'> --- Select ---</option>";
                foreach($result as $row){
                    $html .= "<option value='".$row->pid.'-'.$row->tid.'-'.$invoice_id[1]."'>".$row->product."</option>";
                }
                echo $html;
            }
        
        
        
        return 0;

        }
    }

     public function getproductinfo(){
        
            $id = $this->input->post('id',true);
            $product = explode('-',$id);
            $component_id = $product[0];
            $invoice_id   = $product[1];
            if($product[2]==1)
            {
            $result = $this->invocies->getvarient($component_id,$invoice_id,'');
            }
            else
            {
            $result = $this->invocies->getvarient($component_id,'',$product[1]);    
            }
                            
            if(is_array($result)){
                $html = $result[0]->warehouse_product_code.'#'.$result[0]->qty.'#'.$result[0]->total_remains_qty;
                echo $html;
            }else{
                return false;
            }
        
    }


   public function receive_sparepart()
   {
     $twid = $this->invocies->getWarehouse()[0];
     $data['warehouse'] = $twid;
   	 $exp          = explode('-',$this->input->post('pid'));
     $invoice_type = $this->input->post('invoice_type');
     $invoice_id   = explode('-',$this->input->post('invoice_id'));
   	 $pid          = $exp[0];
   	 $qty          = $this->input->post('qty');
     $zupc         = $this->input->post('zupc'); 
     $data = array();

     if($invoice_type==1)
     {   
   	 
      $this->db->set('lrp_status',2);
      $this->db->where('component_id',$pid);
      $this->db->where('invoice_id',$invoice_id[0]);
      $this->db->where('status',4);
      $this->db->where('lrp_status',1);
      $this->db->limit($qty);
      $this->db->update('tbl_component_serials');
      //echo $this->db->last_query();die;
      

     }
     else
     {
        for($i=0;$i<$qty;$i++)
        {
            $data[] = array(
              'lrp_status'    => 2,
              'component_id'  => $pid,
              'invoice_id'    => 0,
              'fwid'          => 0,
              'twid'          => $twid['id'],
              'purchase_id'   => $invoice_id[0],
              'serial'        => $zupc,
              'date_modified' => date('Y-m-d h:i:s'),
              'logged_user_id'=> $twid['id'],
              'status'        => 4
            );
        }


        $this->db->insert_batch("tbl_component_serials",$data);


     }


   	 

   	 redirect('spareparts/manage_sparepart','refresh');
   	  
   }

   public function getSupplierByInvoice()
   {
    $id = $this->input->post('id',true);
    
    
    if($id==1)
    {
        $supplier_list = $this->invocies->getSupplier();

        if($supplier_list != false){
                $html="";
                $html .= "<option value=''>Select Supplier</option>";
                foreach($supplier_list as $row){
                    if($row->company!='')
                    {
                    $html .= "<option value='".$row->id.'-'.$id."'>".$row->company."</option>";
                    }
                }
                echo $html;
            }
            return 0;
    } 
    else
    {
        $supplier_list = $this->supplier_list_by_purchase();

        if($supplier_list != false){
                $html="";
                $html .= "<option value=''>Select Supplier</option>";
                foreach($supplier_list as $row){
                    if($row['company']!='')
                    {
                    $html .= "<option value='".$row['id'].'-'.$id."'>".$row['company']."</option>";
                     }
                }
                echo $html;
            }

             return 0;
        
        
    }

   }

   public function supplier_list_by_purchase($supplier_id='')
   {
    $twid = $this->invocies->getWarehouse()[0];
    $data['warehouse'] = $twid;
    $this->db->select('b.company,b.id,a.tid,a.id as purchase_id');
    $this->db->from("geopos_purchase as a");
    $this->db->join("geopos_supplier as b","a.csd=b.id","left");
    if($supplier_id)
    {
     $this->db->where('b.id',$supplier_id);
    }
    $this->db->where("a.twid",$twid['id']);
    $query = $this->db->get();
    
    if($query->num_rows()>0)
    {
    return $query->result_array();
    }

   }

   public function manage_old_spare_add()
    {
      $twid = $this->invocies->getWarehouse()[0];
      $data['warehouse'] = $twid;

      $query = $this->db->query("select tbl_component_serials.component_id,tbl_component_serials.serial_in_type,tbl_component_serials.purchase_id, tbl_component.component_name as product, tbl_component.warehouse_product_code from tbl_component_serials LEFT JOIN tbl_component on tbl_component_serials.component_id=tbl_component.id where tbl_component_serials.twid='".$twid['id'] ."' and tbl_component_serials.serial_in_type=2 and tbl_component_serials.status=1 group by tbl_component_serials.component_id");
       $record = array();
      $qty = array();
      $by_po_qty = array();
      $by_jobwork_qty = array();
      
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key=>$row) {  
              
                $record[] = $row;


                $qty_query = $this->db->query("select * from tbl_component_serials where status=1 and serial_in_type=2 and component_id='".$row->component_id."' and twid='".$twid['id'] ."'");
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
        $this->load->view('spareparts/manage-old-spare-add',$data);
        $this->load->view('includes/footer');
    }

   public function old_spare_more_details()
    {
      $pid = intval($this->input->get('pid'));
      $wid = intval($this->input->get('wid'));
      $twid = $this->invocies->getWarehouse()[0];
      
      $data['warehouse'] = $twid; 
        $data['serial_list'] = $this->invocies->getOldSerialComponent($pid,$wid);

        $head['usernm'] = '';
        $head['title'] = 'Serial List';
        $head['title'] = "View Product Warehouses";
        $this->load->view('includes/header',$head);
        $this->load->view('spareparts/old_spare_more_details',$data);
        $this->load->view('includes/footer');
    }

	
}
?>