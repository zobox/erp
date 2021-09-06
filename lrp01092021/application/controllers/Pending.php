<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Pending extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
       // $this->load->model('invoices_model', 'invocies');
     
		$this->load->model('Dashboard_model','dashboard');		
		$this->load->model('Communication_model','communication');
		$this->load->model('invoices_model', 'invocies');
    }

    //invoices list
    public function index()
    {		
        $head['title'] = "Pending Receives";
        $this->load->view('includes/header',$head);
		//$data['list'] = $this->invocies->invoice_details();
		$data['list'] = $this->invocies->invoice_list();
        $this->load->view('pending/index',$data);
        $this->load->view('includes/footer');
    }
	
	public function receive_view()
    {
		if ($this->input->post('serial', true)) {
			$invoice_id = $this->input->post('id', true);			
			$serial = $this->input->post('serial', true);			
			$serial_list = $this->input->post('serial_list', true);				
			$serial_list[] = $serial;						
			$data['list'] = $this->invocies->invoice_serial_details($invoice_id,$serial,$status=6,$is_present=0,$product_serial_status='',$jobcard_id='',$serial_list);						
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
	
	public function getcomponents(){
		$pid = $this->input->get('pid');		
		$result = $this->invocies->getComponentByPid($pid);
		
		//echo $result;
		echo json_encode($result);
	}
	
	public function save_iqc_work(){
		/* echo "<pre>";
		print_r($_REQUEST);
		echo "</pre>"; exit;*/
		
		$jobwork_required = $this->input->post('jobwork_required');	
		if($jobwork_required==1 || $jobwork_required==3){
			$res = $this->invocies->send_to_jobwork();
			if($res=1){
				//redirect('pending/manage_iqc_work');
				
				
				//$type = "mini";
				//$data['product_detail'] = $this->invocies->getCustomList($id);
				/* echo "<pre>";
				print_r($data['product_detail']);
				echo "</pre>"; exit; */
				$current_grade = $this->input->post('current_grade');
				$final_grade = $this->input->post('final_grade');
				$jobwork_required = $this->input->post('jobwork_required');
				
				$items = $this->input->post('items');
				$component_request = $this->input->post('component_request');
				$serial = $this->input->post('serial');
				$pid = $this->input->post('pid');
				
				/* [current_grade] => 4
				[final_grade] => 1
				[jobwork_required] => 1
				[items] => Array
					(
						[0] => Back Camera-Vivo Z1 Pro
						[1] => Battery-Vivo Z1 Pro
					)

				[component_request] => Glass
				[submit] => Submit
				[serial] => 3532501178092633
				[pid] => 640 */
				$data['items'] = $items;
				$product_details = $this->invocies->getProductDetailsByID($serial);
				/* echo "<pre>";
				print_r($product_details);
				echo "</pre>"; exit; */
				
				$product_detail[0] = array(
					'id' => 1136,
					'pid' => 1766,
					'varient_id' => 14,
					'color_id' => 45,
					'product_name' => $product_details[0]['product_name'],
					'price' => 0.00,
					'zupc_code' => $product_details[0]['warehouse_product_code'],
					'qty' => '',
					'imei_1' => $serial,
					'imei_2' => $product_details[0]['imei2'],
					'product_type' => 1,
					'label_size' => 6,
					'prexo_grade' => 3,
					'date_created' => date('Y-m-d h:i:s'),
					'date_modified' => '',
					'unit_name' => '4GB / 64GB',
					'colour_name' => 'Grey',
					'brand_name' => 'Samsung'
				);
				$data['product_detail'] = json_decode(json_encode($product_detail));
				/* echo "<pre>";
				print_r($data['product_detail']);
				echo "</pre>"; exit; */
				
				$data['label_type'] = $type;
				ini_set('memory_limit', '64M');

				$html = $this->load->view('pending/new_custom_label', $data, true);
				
				$this->load->library('pdf'); 

				$header = "";
				$pdf = $this->pdf->prexo_with_grade(array('margin_top' => 0.5));
				$pdf->SetHTMLHeader($header);
			   
				$pdf->SetHTMLFooter('<div style="text-align: center;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;"></div>');
			
				
				$pdf->WriteHTML($html);			
				$pdf->Output($data['product_detail'][0]->product_name . '_label.pdf', 'I');
			
			}
		}else if($jobwork_required==3){
			
		}
	}
	
	
	public function save_receive_view(){	
		//$serial = $this->input->post('serial');
		$serial_list = $this->input->post('serial_list');
		if($serial_list){
			$res = $this->invocies->save_receive_view($serial_list);
			if($res){
				redirect('pending');
			}
		}
	}
	
	
	public function new_custom_label() 
    { 
        $id = $this->input->get('id');
        $type='';
        if($this->input->get('type'))
        {
            $type = "mini";
        }
        $data['product_detail'] = $this->invocies->getCustomList($id);
		/* echo "<pre>";
		print_r($data['product_detail']);
		echo "</pre>"; exit; */
		
        $data['label_type'] = $type;
        ini_set('memory_limit', '64M');

        $html = $this->load->view('pending/new_custom_label', $data, true);
        
        $this->load->library('pdf'); 

            $header = "";
            
			/* if($type!='' || $data['product_detail'][0]->label_size==3)
            {
				$pdf = $this->pdf->custom_mini_label(array('margin_top' => 0.5)); 
            }
            if($type=='' && $data['product_detail'][0]->label_size==1)
            {
            $pdf = $this->pdf->custom_small_label(array('margin_top' => 0.5));
            }
            if($type=='' && $data['product_detail'][0]->label_size==2)
            {
                
                $pdf = $this->pdf->custom_big_label(array('margin_top' => 0.5));
            }
            if($type=='' && $data['product_detail'][0]->label_size==4)
            {
                
                $pdf = $this->pdf->custom_xl_label(array('margin_top' => 0.5));
            }
            if($type=='' && $data['product_detail'][0]->label_size==5)
            {                
                $pdf = $this->pdf->custom_prexo_label(array('margin_top' => 0.5));
            } 			
            if($type=='' && $data['product_detail'][0]->label_size==6)
            {                
                $pdf = $this->pdf->prexo_with_grade(array('margin_top' => 0.5));
            }*/
			
			$pdf = $this->pdf->prexo_with_grade(array('margin_top' => 0.5));
            $pdf->SetHTMLHeader($header);
           
			$pdf->SetHTMLFooter('<div style="text-align: center;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;"></div>');
        
			
            $pdf->WriteHTML($html);			
            $pdf->Output($data['product_detail'][0]->product_name . '_label.pdf', 'I');
			//echo "TTTTTTTTTTTTTTTTTTTTTTTTT"; exit;
        //$this->load->view('products/new_custom_label', $data);
    }

	
}
?>