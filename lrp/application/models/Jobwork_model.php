<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobwork_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('invoices_model', 'invocies');
    }	
	
	public function savejobwork(){
		/* echo "<pre>";
		print_r($_REQUEST);
		echo "</pre>"; exit; */ 
				
		$id = $this->input->post('id');
		$final_condition = $this->input->post('final_condition');
		$sub_cat = $this->input->post('sub_cat');
		$sub_sub_cat = $this->input->post('sub_sub_cat');
		$jobwork_service_type = $this->input->post('jobwork_service_type');
		$serial = $this->input->post('serial'); 
		
		$this->db->select('id');
		$this->db->where('serial',$serial);
		$this->db->where('status !=',8);
		$res = $this->db->get('geopos_product_serials')->result();	
		$serial_id = $res['0']->id; 
		
		if($serial_id){
			$data1 = array(            
				'status' => 1,
				'pid' => $final_condition,						
				'date_modified' => date('Y-m-d H:i:s')				
			);
			
			$this->db->set($data1);
			$this->db->where('serial_id', $serial_id);			
			$this->db->update('tbl_warehouse_serials');	
			
			
			$data2 = array(            
				'status' => 7,
				'product_id' => $final_condition,						
				'date_modified' => date('Y-m-d H:i:s')				
			);
			
			$this->db->set($data2);
			$this->db->where('serial',$serial);
			$this->db->where('status !=',8);	
			$this->db->update('geopos_product_serials');	
			
			
			$data3 = array(            
				'status' => 2,
				'batch_number' => date('Y-m-d'),						
				'final_condition' => $final_condition,						
				'sub_cat' => $sub_cat,						
				'sub_sub_cat' => $sub_sub_cat,						
				'jobwork_service_type' => $jobwork_service_type,						
				'logged_user_id' => $_SESSION['id'],						
				'date_modified' => date('Y-m-d H:i:s')				
			);
			
			$this->db->set($data3);
			$this->db->where('id', $id);	
			$this->db->update('tbl_jobcard'); 
			
			return true;
		}else{
			return false;
		}
		//echo $this->db->last_query(); exit;
	}
	
	
	public function jobWorkManage(){
		$warehouse_details = $this->invocies->getWarehouse();
		$this->db->select("b.id,a.id as jobcard_id,a.serial,a.assign_engineer,a.change_status,a.final_qc_status,a.final_qc_remarks,a.type,c.product_condition,f.convert_to");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as b","a.serial=b.serial",'left');		
		$this->db->join("tbl_qc_data as c","a.serial=c.imei1",'left');
		$this->db->join("tbl_jobwork_issue_serial as d","a.serial=d.serial",'left');
		$this->db->join("tbl_jobwork_issue as e","d.jobwork_issue_id=e.id",'left');
		$this->db->join("tbl_jobwork_request as f","e.request_id=f.id",'left');	
		$this->db->join("tbl_warehouse_serials as g","g.serial_id=b.id",'left');
		$this->db->where('a.status',2);
		$this->db->where('b.status !=',8);		
		$this->db->where("g.twid",$warehouse_details[0][id]);
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
				$row->category_name = $this->GetParentCatTitleById($row->pcat);
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
	
	
	public function JobWorkComponent($serial)
	{
		$warehouse_details = $this->invocies->getWarehouse();
		$this->db->select("b.component_name,a.serial");
		$this->db->from("tbl_component_serials as a");	  	
		$this->db->join("tbl_component as b","a.component_id=b.id",'left');
		$this->db->where('a.product_serial',$serial);
		$this->db->where("a.twid",$warehouse_details[0][id]);
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
	
	public function GetParentCatTitleById($rel_id)
    { 		
		$this->db->where("id",$rel_id);		
		$query = $this->db->get("geopos_product_cat");		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				if($row->rel_id !=0){
					$ptitle = $this->GetParentCatTitleById($row->rel_id);
					$row->title = $ptitle.' &rArr; '.$row->title;
				}
				return $row->title;
			}				
		}
		return false;
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
				$row->category_name = $this->GetParentCatTitleById($cat_id);
				$row->components = $this->JobWorkComponent($row->serial);
				$row->component_qty = $this->JobWorkComponentQty($row->serial);                
				$data =$row;
			}			
			return $data;
		}
		return false;
	} 
	
	
	 public function failedJobwork()
	  {
	  	$warehouse_details = $this->invocies->getWarehouse();
		$this->db->select("b.id,a.id as jobcard_id,a.serial,a.assign_engineer,a.change_status,a.final_qc_status,a.final_qc_remarks,a.type,c.product_condition,f.convert_to");
		$this->db->from("tbl_jobcard as a");
		$this->db->join("geopos_product_serials as b","a.serial=b.serial",'left');		
		$this->db->join("tbl_qc_data as c","a.serial=c.imei1",'left');
		$this->db->join("tbl_jobwork_issue_serial as d","a.serial=d.serial",'left');
		$this->db->join("tbl_jobwork_issue as e","d.jobwork_issue_id=e.id",'left');
		$this->db->join("tbl_jobwork_request as f","e.request_id=f.id",'left');	
		$this->db->join("tbl_warehouse_serials as g","g.serial_id=b.id",'left');
		$this->db->where('a.final_qc_status',3);
		$this->db->where('b.status !=',8);
		$this->db->where("g.twid",$warehouse_details[0][id]);
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
	  
	public function getAllWarehouseExceptLoggedLRC()
	{
		
		$warehouse_details = $this->invocies->getWarehouse();
		$this->db->select("*");
		$this->db->from("geopos_warehouse");		
		$this->db->where("id !=",$warehouse_details[0][id]);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return json_decode(json_encode($query->result_array()));
	}
	
	
}