<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobwork_model extends CI_Model
{
	private $sub_data = array();
	private $parent_data = array();
	public function __construct()
    {		
        parent::__construct();       
        	
    }
	
    public function productSerial(){
		$this->db->select('a.*,count(a.id) as qty,b.product_name,b.pcat,b.hsn_code');					
		$this->db->from("geopos_product_serials as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->where('a.status',2);
		$this->db->where('a.partial_status',0);
		$this->db->group_by('a.product_id');
		$query = $this->db->get();	
		//echo $this->db->last_query();  exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	   public function getProductSerialById($id){
		$this->db->select('a.*,b.product_name,b.pcat,b.hsn_code,b.pid,b.sub');					
		$this->db->from("geopos_product_serials as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->where('a.status',2);
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();  exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				if($row->sub==0)
					$row->conditions = $this->getProductConditionsByPid($row->pid);
				else
					$row->conditions = $this->getProductConditionsByPid($row->sub);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	/*public function getProductComponentByPID($pid){
		$this->db->where('pid',$pid);
		$query = $this->db->get('tbl_jobwork_component');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				//$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;		
	}*/


	public function getProductSerialByIdAssign($id){
		$this->db->select('a.*,b.product_name,b.pcat,b.hsn_code,b.pid,b.sub,b.warehouse_product_code');					
		$this->db->from("geopos_product_serials as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");		
		//$this->db->where('a.status',6);
		$this->db->where('a.status !=',8);
		$this->db->where('a.id',$id);
		$query = $this->db->get(); 
		//echo $this->db->last_query();  exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				if($row->sub==0)
					$row->conditions = $this->getProductConditionsByPid($row->pid);
				else
					$row->conditions = $this->getProductConditionsByPid($row->sub);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getcomponentCost($previous_condition,$new_condition, $pid){
		if($previous_condition==1 && $new_condition==2){
			$cost_type = 'ok_to_good_cost';
		}else if($previous_condition==1 && $new_condition==3){
			$cost_type = 'ok_to_superb_cost';
		}else if($previous_condition==2 && $new_condition==2){
			$cost_type = 'good_to_good_cost';
		}else if($previous_condition==2 && $new_condition==3){
			$cost_type = 'good_to_superb_cost';
		}else if($previous_condition==1 && $new_condition==4){
			$cost_type = 'good_to_good_cost';
		}else if($previous_condition==2 && $new_condition==4){
			$cost_type = 'good_to_excellant_cost';
		}
		
		$this->db->select($cost_type);
		$this->db->select('id');
		$this->db->where('pid',$pid);
		$query = $this->db->get('tbl_jobwork_component');
		//echo $this->db->last_query();
		$data =array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data[$row->id] = $row->$cost_type;								
			}			
			return json_encode($data);
			//return $data;
		}
		return false;
	}
	
	
	public function addjobwork(){		
		$previous_condition = $this->input->post('previous_condition');
		$new_condition = $this->input->post('new_condition');
		$qty = $this->input->post('qty');
		$actual_cost = $this->input->post('actual_cost');
		$batch_no = $this->input->post('batch_no');
		$component_serial_no = $this->input->post('component_serial_no');
		$pid = $this->input->post('pid');
		$serial_id = $this->input->post('serial_id');
		$purchase_id = $this->input->post('purchase_id');
		$component_id = $this->input->post('component_id');
		$final_condition = $this->input->post('final_condition');
		if($final_condition!=''){
			foreach($qty as $key=>$quantity){
				$data = array();
				$data['serial_id'] =  $serial_id;
				$data['component_id'] =  $component_id[$key];
				$data['qty'] =  $quantity;
				$data['actual_cost'] =  $actual_cost[$key];
				$data['batch_no'] =  $batch_no[$key];
				$data['component_serial_no'] =  $component_serial_no[$key];
				$data['previous_condition'] =  $previous_condition;
				$data['new_condition'] =  $new_condition;
				$data['status'] =  1;
				$data['date_created'] =  date('Y-m-d h:i:s');
				$data['date_created'] =  $_SESSION['id'];
				
				if($actual_cost[$key] !=''){
					$res = $this->db->insert('tbl_jobwork',$data);
					//echo $this->db->last_query(); exit;
				}
			}
			
			$this->db->where('id',$purchase_id);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase');
			
			$this->db->where('tid',$purchase_id);
			$this->db->where('pid',$pid);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase_items');
			
			$this->db->set('qty', "qty+1", FALSE);
			$this->db->where('pid', $pid);
			$this->db->update('geopos_products');
			
			$data1['product_id'] =  $final_condition;
			$data1['status'] =  1;	
			$this->db->set($data1);
			$this->db->where('id', $serial_id);
			$this->db->where('status !=', 8);
			$this->db->update('geopos_product_serials');
			
			//$data1['product_id'] =  $final_condition;
			$data2['status'] =  1;	
			$data2['pid'] =  $final_condition;
			$this->db->set($data2);
			$this->db->where('serial_id', $serial_id);
			$this->db->update('tbl_warehouse_serials');
			
			if ($res) {  
				$redirect_url = base_url().'jobwork/manage';
				$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
				echo json_encode(array('status' => 'Success', 'message' =>
					$this->lang->line('ADDED') . $url));
			} else {
				echo json_encode(array('status' => 'Error', 'message' =>
					$this->lang->line('ERROR')));
			}
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	
	public function getjobworkRecords(){
		$this->db->select('a.*,b.serial,c.product_name,c.hsn_code');					
		$this->db->from("tbl_jobwork as a");
		$this->db->join("geopos_product_serials as b","a.serial_id=b.id","inner");
		$this->db->join("geopos_products as c","b.product_id=c.pid","inner");
		$this->db->where('b.status !=',8);
		$this->db->group_by('a.serial_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getjobworkRecordsById($serial_id){
		$this->db->select('a.*,b.serial,c.product_name,c.hsn_code,c.pcat');					
		$this->db->from("tbl_jobwork as a");
		$this->db->join("geopos_product_serials as b","a.serial_id=b.id","inner");
		$this->db->join("geopos_products as c","b.product_id=c.pid","inner");	
		$this->db->where('a.serial_id',$serial_id);	
		$this->db->where('b.status !=',8);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$row->component = $this->GetComponentById($row->component_id);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function GetComponentById($id){
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_jobwork_component');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data =$row;								
			}			
			return $data;
		}
		return false;		
	}
	
	public function setComponent(){
		$component_name = $this->input->post('component_name');
		$pid = $this->input->post('pid');		
		$id = $this->input->post('id');		
		$data = array('component_name'=>$component_name,
		'pid'=>$pid,
		'logged_user_id' => $_SESSION['loggedin'],
		'date_created' => date("Y-m-d H:i:s"));		
		$res = $this->db->insert('tbl_jobwork_component',$data);
		if ($res) {  
			$redirect_url = base_url().'jobwork/pendingproduct/'.$id;
			$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . $url));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	
	public function getProductConditionsByPid($pid){
		$this->db->select('b.*,a.product_name,a.pid');					
		$this->db->from("geopos_products as a");
		$this->db->join("geopos_conditions as b","a.vc=b.id","inner");
		$this->db->where('a.sub',$pid);
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function send_request(){
		$product_id = $this->input->post('product_id');
		$qty = $this->input->post('qty');
		$convert_to = $this->input->post('convert_to');
		
		$data = array();
		$data['product_id'] = $product_id;
		$data['qty'] = $qty;
		$data['convert_to'] = $convert_to;
		$data['status'] = 1;
		$data['date_created	'] = date('Y-m-d h:i:s');
		
		$this->db->insert('tbl_jobwork_request',$data);
		$jobwork_req_id = $this->db->insert_id();
		
		$this->db->where('product_id',$product_id);
		$this->db->where('partial_status',0);
		$this->db->where('status !=',8);
		$this->db->limit($qty, 0);
		$query = $this->db->get('geopos_product_serials');
		//echo $this->db->last_query(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$this->db->set('partial_status', "1", FALSE);				
				$this->db->set('jobwork_req_id', $jobwork_req_id, FALSE);				
				$this->db->where('id', $row->id);
				$this->db->where('status !=',8);
				$this->db->update('geopos_product_serials');
			}				
		}
		return true;		
		/* $this->db->set('status', "4", FALSE);
		$this->db->set('convert_to', $convert_to, FALSE);
        $this->db->where('id', $id);
        if($this->db->update('geopos_product_serials')){
			return true;
		}else{
			return false;
		}		 */
	}

	public function getJobWorkDetail($request_id){
		$this->db->select("b.id,a.serial,a.sub_cat,a.sub_sub_cat,a.batch_number,a.assign_engineer,a.change_status,a.final_qc_status,a.final_qc_remarks,a.teamlead_id,c.product_condition,e.id as issue_id,f.id as request_id,f.convert_to,g.username as teamlead,h.username as trc_manager");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as b","a.serial=b.serial",'left');
		$this->db->join("tbl_qc_data as c","a.serial=c.imei1",'left');
		$this->db->join("tbl_jobwork_issue_serial as d","a.serial=d.serial",'left');
		$this->db->join("tbl_jobwork_issue as e","d.jobwork_issue_id=e.id",'left');
		$this->db->join("tbl_jobwork_request as f","e.request_id=f.id",'left');
		$this->db->join("geopos_employees as g","g.id=a.teamlead_id",'left');
		$this->db->join("geopos_employees as h","h.id=a.logged_user_id",'left');
		$this->db->where('a.id',$request_id);
		$this->db->where('b.status !=',8);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){                 
                 //$data['product_detail'][] = $this->getProductSerialByIdAssign($row->id);
				$row->product_detail = $this->getProductSerialByIdAssign($row->id);
				if($row->sub_sub_cat!=''){
					$cat_id = $row->sub_sub_cat;
				}else{
					$cat_id = $row->sub_cat;
				}
				$row->category_name = $this->products_cat->GetParentCatTitleById($cat_id);
				$row->components = $this->JobWorkComponent($row->serial);
				$row->component_qty = $this->JobWorkComponentQty($row->serial);                
				$data =$row;
			}			
			return $data;
		}
		return false;
	} 
	

	public function jobWorkRequest(){
		$this->db->select("a.id as request_id,a.type,s.id as serial_id,a.serial,u.username,a.assign_engineer,a.change_status,a.final_qc_status");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as s","a.serial=s.serial",'left');
		$this->db->join("geopos_users as u","a.teamlead_id=u.id",'left');
		$this->db->where('a.final_qc_status!=',3);
		$this->db->where('s.status',6);
		$this->db->where('a.status',1);
		$query = $this->db->get();
		//echo $this->db->last_query();  die;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
                 
                 $data['product_info'][] = $this->getProductSerialByIdAssign($row->serial_id);
                 $data['component_serial'][] = $this->getJobWorkDetail($row->request_id);

				$data['jobwork'][] =$row;

			}			
			return $data;
		}
		return false;
	}

	  public function JobWorkComponent12052021($request_id)
	  {
	  	$this->db->select("a.component,a.qty");
	  	$this->db->from("tbl_jobwork_issue_component as a");
	  	$this->db->join("tbl_jobwork_issue_serial as b","a.jobwork_issue_serial_id=b.id",'left');
	  	$this->db->where('b.jobwork_issue_id',$request_id);
	  		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
                 
                $data[] =$row;

			}			
			return $data;
		}
		return false;
	  } 
	  
	  public function JobWorkComponent13052021($serial)
	  {
	  	$this->db->select("c.component_name,b.serial");
	  	$this->db->from("tbl_jobwork_issue_serial as a");
	  	$this->db->join("tbl_component_serials as b","a.jobwork_issue_id=b.issue_id",'left');
	  	$this->db->join("tbl_component as c","b.component_id=c.id",'left');
	  	$this->db->where('a.serial',$serial);
	  	$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){                 
                $data[] =$row;
			}			
			return $data;
		}
		return false;
	  }
	  
	  public function JobWorkComponent($serial)
	  {
	  	$this->db->select("b.component_name,a.serial");
	  	$this->db->from("tbl_component_serials as a");	  	
	  	$this->db->join("tbl_component as b","a.component_id=b.id",'left');
	  	$this->db->where('a.product_serial',$serial);
	  	$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){                 
                $data[] =$row;
			}			
			return $data;
		}
		return false;
	  }
	  

	  public function failedJobwork()
	  {
	  	$this->db->select("a.id as request_id,s.id as serial_id,a.serial,u.username,a.assign_engineer,a.change_status,a.final_qc_status,a.final_qc_remarks");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as s","a.serial=s.serial",'left');
		$this->db->join("geopos_users as u","a.teamlead_id=u.id",'left');
		$this->db->where('a.final_qc_status',3);
		$this->db->where('s.status !=',8);
		$query = $this->db->get();
		//echo $this->db->last_query();  die;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
                 
                 $data['product_info'][] = $this->getProductSerialByIdAssign($row->serial_id);

				$data['jobwork'][] =$row;

			}			
			return $data;
		}
		return false;
	  }
	  
	  public function getProductVarients($pid){
		$this->db->where('sub',$pid);
		$query = $this->db->get('geopos_products');
		//echo $this->db->last_query(); 
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {
				if ($query->num_rows() > 1) {
					$data[] =$row;
				}
				$pid = $row->pid;
			}	
			$this->db->where('sub',$pid);
			$query = $this->db->get('geopos_products');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {					
					$data[] =$row;					
				}				
			}
			return $data;
		}else{
			$this->db->select('sub');
			$this->db->from('geopos_products');		
			$this->db->where('pid',$pid);
			$sub_query = $this->db->get_compiled_select();

			$this->db->select('*');
			$this->db->from('geopos_products');
			$this->db->where("sub IN ($sub_query)");
			$query = $this->db->get();
			//echo $this->db->last_query();  exit;
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {					
					$data[] =$row;								
				}			
				return $data;
			}
		}
	  }
	  
	  
	  public function getProductVarients24072021($pid){
		$this->db->where('sub',$pid);
		$query = $this->db->get('geopos_products');
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {
				if ($query->num_rows() > 1) {
					$data[] =$row;
				}
				$pid = $row->pid;
			}	
			$this->db->where('sub',$pid);
			$query = $this->db->get('geopos_products');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {					
					$data[] =$row;					
				}	
				return $data;
			}
		}else{
			$this->db->select('sub');
			$this->db->from('geopos_products');		
			$this->db->where('pid',$pid);
			$sub_query = $this->db->get_compiled_select();

			$this->db->select('*');
			$this->db->from('geopos_products');
			$this->db->where("sub IN ($sub_query)");
			$query = $this->db->get();
			//echo $this->db->last_query();  exit;
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {					
					$data[] =$row;								
				}			
				return $data;
			}
		}		
	  }
	  
	  
	public function jobWorkManage(){
		$this->db->select("b.id,a.id as jobcard_id,a.serial,a.assign_engineer,a.change_status,a.final_qc_status,a.final_qc_remarks,a.type,c.product_condition,f.convert_to");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as b","a.serial=b.serial",'left');
		$this->db->join("tbl_qc_data as c","a.serial=c.imei1",'left');
		$this->db->join("tbl_jobwork_issue_serial as d","a.serial=d.serial",'left');
		$this->db->join("tbl_jobwork_issue as e","d.jobwork_issue_id=e.id",'left');
		$this->db->join("tbl_jobwork_request as f","e.request_id=f.id",'left');		
		$this->db->where('a.status',2);
		$this->db->where('b.status !=',8);
		$this->db->group_by('a.serial');
		$this->db->order_by('a.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {                 
                 //$data['product_detail'][] = $this->getProductSerialByIdAssign($row->id);
                 $row->product_detail = $this->getProductSerialByIdAssign($row->id);
				 $row->components = $this->JobWorkComponent($row->serial);
				 $row->component_qty = $this->JobWorkComponentQty($row->serial);
				 $data[] =$row;

			}			
			return $data;
		}
		return false;
	}
	
	public function JobWorkComponentQty($serial)
	{
		$this->db->select("b.component_name,a.serial");
		$this->db->from("tbl_component_serials as a");	  	
		$this->db->join("tbl_component as b","a.component_id=b.id",'left');
		$this->db->where('a.product_serial',$serial);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	 public function componentDetail($purchase_id,$component_id)
    {
    	$this->db->select('*');
    	$this->db->from('geopos_purchase_items');
    	$this->db->where('tid',$purchase_id);
    	$this->db->where('pid',$component_id);
    	$query = $this->db->get();
    	
    	$data = array();
    	if($query->num_rows()>0)
    	{
    		foreach($query->result() as $key=>$row)
    		{
    		$data[] = $row;	
    		}
    		
    		return $data;

    	}
    	return false;
    }    
  
	public function getProductComponentByPID($serial)
	{
		$this->db->where('product_serial',$serial);
		//$this->db->where('status',3)
		$query = $this->db->get('tbl_component_serials');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$data = $this->componentDetail($row->purchase_id,$row->component_id);
												
			}			
			return $data;
		}
		return false;		
	}


	public function getPurchaseItem($product_id,$purchase_id)
	{
		$this->db->select('*');
		$this->db->from("geopos_purchase_items");
		$this->db->where('tid',$purchase_id);
		$this->db->where('pid',$product_id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function getComponentByPid($pid)
	{
        $getproduct = $this->db->query("select pid,sub,status from geopos_products where pid=$pid and status!=5");
        $getpro = $getproduct->result_array();

        $getproduct_sub = $this->db->query("select pid,sub,status from geopos_products where pid='".$getpro[0]['sub']."'");
        $getpro_sub = $getproduct_sub->result_array();

        if($getpro_sub[0]['status']!=5)
        { 
        	
        	
        		$product_id = $getpro_sub[0]['pid'];
        	
        	
        }
        else
        {
        	$product_id = $pid;
        }
      
		$this->db->select('a.*,b.product_id,component_name,b.id as component_id');
		$this->db->from("tbl_component_serials as a");
		$this->db->join("tbl_component as b","a.component_id=b.id","left");
		$this->db->where("b.product_id",$product_id);
		$this->db->where("a.status",1);
		$this->db->group_by("a.component_id");
		$query = $this->db->get();
		
		return $query->result_array();
	}
	public function getComponentItemMaster($pid)
	{
		 $getproduct = $this->db->query("select pid,sub,status from geopos_products where pid=$pid and status!=5");
        $getpro = $getproduct->result_array();

        $getproduct_sub = $this->db->query("select pid,sub,status from geopos_products where pid='".$getpro[0]['sub']."'");
        $getpro_sub = $getproduct_sub->result_array();

        if($getpro_sub[0]['status']!=5)
        { 
        	
        	
        		$product_id = $getpro_sub[0]['pid'];
        	
        	
        }
        else
        {
        	$product_id = $pid;
        }

		$this->db->select("*");
		$this->db->from("tbl_component");
		$this->db->where("product_id",$product_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $data = array();

        if($query->num_rows()>0)
        {
        	foreach($query->result() as $key=>$row)
        	{
        		$data[] = $row;
        	}
        	return $data;
        }

        return false;

	}

	
}