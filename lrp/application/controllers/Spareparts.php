<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Spareparts extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
       	$this->load->model('Dashboard_model','dashboard');
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
	
}
?>