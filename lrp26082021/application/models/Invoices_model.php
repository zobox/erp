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

class Invoices_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }




    /* public function invoice_details($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();
    } */

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }


    private function _get_datatables_query()
    {

        $this->db->select('geopos_invoices.id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_invoices.multi,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
		//$this->db->where('geopos_invoices.i_class');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
         // $this->db->where('geopos_invoices.i_class', 0);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
		//$this->db->where('geopos_invoices.i_class', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
		//$this->db->where('geopos_invoices.i_class', 0);
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id =geopos_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function invoice_details1($id='', $eid = '',$type='')
    {
        $this->db->select('a.*,SUM(a.shipping + a.ship_tax) AS shipping,a.loc as loc,
		c.name,c.address,c.city,c.region,c.country,c.phone,c.gst_number,c.pincode,d.id AS termid,d.title AS termtit,
		d.terms AS terms,e.ewayBillNo');
        $this->db->from('geopos_invoices as a');
		
		if($id){
			$this->db->where('a.id', $id);
		}
		if($type){
			$this->db->where('a.type', $type);
		}
        if ($eid) {
            $this->db->where('a.eid', $eid);
        }
        
        $this->db->join('geopos_warehouse as b', 'a.twid = b.id', 'left');
        $this->db->join('users_lrp as c', 'b.franchise_id = c.users_id', 'left');
        $this->db->join('geopos_terms as d', 'd.id = a.term', 'left');
		$this->db->join('tbl_ewaybill as e', 'e.invoice_number = a.tid', 'left');
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }
	
	
	public function invoice_details($invoice_id='',$product_serial_status='')
    {		
        $this->db->select('a.pid,b.serial,a.fwid,a.twid,a.status,a.is_present,a.hold_status,
		b.status as product_serial_status,b.current_condition,b.convert_to,b.jobwork_req_id,
		c.*,count(c.id) as qty,e.title,f.name as trc_name,f.email as trc_email,f.phone as trc_phone,
		f.address as trc_address,f.city as trc_city,g.terms,h.ewayBillNo,i.product_name,j.title as category,
		k.item_replaced,k.component_request,k.qc_engineer,k.status as qc_status,l.new_name as current_condition_name,
		m.new_name as convert_condition_name,o.id as jobcard_id,o.teamlead,
		o.assign_engineer as jobwork_assign_engineer,
		o.batch_number as jobwork_batch_number,
		o.status as jobwork_status,
		o.change_status as jobwork_change_status,
		o.final_qc_status as jobwork_final_qc_status,
		o.final_qc_remarks as jobwork_final_qc_remarks,
		o.final_condition as jobwork_final_condition,
		o.sub_cat as jobwork_sub_cat,
		o.sub_sub_cat as jobwork_sub_sub_cat');
        $this->db->from('tbl_warehouse_serials as a');		
        
        $this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');		
        $this->db->join('geopos_invoices as c', 'c.id = a.invoice_id', 'left');
        //$this->db->join('geopos_invoice_items as d', 'd.tid = c.id', 'left');		
        $this->db->join('geopos_warehouse as e', 'e.id = c.twid', 'left');
        $this->db->join('users_lrp as f', 'f.users_id = e.franchise_id', 'left');
        $this->db->join('geopos_terms as g', 'g.id = c.term', 'left');
		$this->db->join('tbl_ewaybill as h', 'h.invoice_number = c.tid', 'left');
		$this->db->join('geopos_products as i', 'i.pid = a.pid', 'left');
		$this->db->join('geopos_product_cat as j', 'j.id = i.pcat', 'left');
		$this->db->join('tbl_qc_data as k', 'k.imei1 = b.serial', 'left');
		$this->db->join('geopos_conditions as l', 'l.id = b.current_condition', 'left');
		$this->db->join('geopos_conditions as m', 'm.id = b.convert_to', 'left');
		$this->db->join('tbl_jobcard as o', 'o.serial = b.serial', 'left');
		
		if($invoice_id){
			$this->db->where('c.id', $invoice_id);
		}	
		if($product_serial_status){
			$this->db->where('b.status', $product_serial_status);
		}
		
		$this->db->where('f.users_id', $this->session->userdata('user_details')[0]->users_id);
		
		$this->db->group_by('c.id');
		$this->db->order_by('c.id','DESC');
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        //return $query->result();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				$row->pending_qty = $this->get_pending_qty($row->id);
				$row->recieved_qty = $this->get_recieved_qty($row->id);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
    }
	

	
	
	public function invoice_serial_details($invoice_id='',$serial='',$status='',$is_present='',$product_serial_status='',$jobcard_id='')
    {   
        $this->db->select('a.pid,b.serial,b.imei2,a.fwid,a.twid,a.status,a.is_present,a.hold_status,
		b.status as product_serial_status,b.current_condition,b.convert_to,b.jobwork_req_id,
		c.*,e.title,f.name as trc_name,f.email as trc_email,f.phone as trc_phone,
		f.address as trc_address,f.city as trc_city,g.terms,h.ewayBillNo,i.product_name,i.warehouse_product_code,i.pcat,j.title as category,
		k.item_replaced,k.component_request,k.qc_engineer,k.status as qc_status,l.new_name as current_condition_name,
		m.new_name as convert_condition_name,o.id as jobcard_id,o.teamlead,
		o.assign_engineer as jobwork_assign_engineer,
		o.batch_number as jobwork_batch_number,
		o.status as jobwork_status,
		o.change_status as jobwork_change_status,
		o.final_qc_status as jobwork_final_qc_status,
		o.final_qc_remarks as jobwork_final_qc_remarks,
		o.final_condition as jobwork_final_condition,
		o.sub_cat as jobwork_sub_cat,
		o.sub_sub_cat as jobwork_sub_sub_cat');
        $this->db->from('tbl_warehouse_serials as a');
		
		if($invoice_id){
			$this->db->where('c.id', $invoice_id);
		}
		if($serial){
			$this->db->where('b.serial', $serial);
		}
		if($status){
			$this->db->where('a.status', $status);
		}
		if($is_present){
			$this->db->where('a.is_present', $is_present);
		}
		if($product_serial_status){
			$this->db->where('b.status', $product_serial_status);
		}
		if($jobcard_id){
			$this->db->where('o.id', $jobcard_id);
		}
		
		$this->db->where('f.users_id', $this->session->userdata('user_details')[0]->users_id);
        
        $this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');		
        $this->db->join('geopos_invoices as c', 'c.id = a.invoice_id', 'left');
        //$this->db->join('geopos_invoice_items as d', 'd.tid = c.id', 'left');		
        $this->db->join('geopos_warehouse as e', 'e.id = a.twid', 'left');
        $this->db->join('users_lrp as f', 'f.users_id = e.franchise_id', 'left');
        $this->db->join('geopos_terms as g', 'g.id = c.term', 'left');
		$this->db->join('tbl_ewaybill as h', 'h.invoice_number = c.tid', 'left');
		$this->db->join('geopos_products as i', 'i.pid = a.pid', 'left');
		$this->db->join('geopos_product_cat as j', 'j.id = i.pcat', 'left');
		$this->db->join('tbl_qc_data as k', 'k.imei1 = b.serial', 'left');
		$this->db->join('geopos_conditions as l', 'l.id = b.current_condition', 'left');
		$this->db->join('geopos_conditions as m', 'm.id = b.convert_to', 'left');
		$this->db->join('tbl_jobcard as o', 'o.serial = b.serial', 'left');
		
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }
	
	public function getConditions(){
		$query = $this->db->get('geopos_conditions');
		$data = array();
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
		}
	}
	
	public function getComponentByPid($pid='',$vid='',$component_name=''){		
		$warehouse_details = $this->getWarehouse();		
		$this->db->select("a.*,b.id as component_serial_id,b.component_id,b.purchase_id,b.serial,b.issue_id,b.product_serial,b.qty,b.status");
        $this->db->from("tbl_component as a");       
        $this->db->join("tbl_component_serials as b","b.component_id=a.id",'left');
		$this->db->group_by('a.component_name');
		if($pid){
        $this->db->where("a.product_id",$pid);
		}
		if($component_name){
        $this->db->where("a.component_name",$component_name);
		}
        $this->db->where("b.twid",$warehouse_details[0][id]);
        $this->db->where("b.status",4);
		if($vid)
        $this->db->or_where("a.product_id",$vid);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;        
        return $query->result_array();
	}
	
	
	public function add_recieve_goods()
    {		
		$data_type = $this->input->post('product_type1');
		$jobwork_required = $this->input->post('jobwork_required');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_ids = $this->input->post('purchase_item_id');
		$id_array = explode('-',$purchase_item_ids);
		$purchase_item_id = $id_array[0];
		
		//$zupc_code = $this->input->post('zupc_code');
		$varient_ids = $this->input->post('varient_id');
		//$sticker_no = $this->input->post('sticker_no');
		$serial_no1 = $this->input->post('serial_no1');
		//$current_grade = $this->input->post('current_grade');
		//$qc_engineer = $this->input->post('qc_engineer');
		$color_id = $this->input->post('color_id');
		$imei_2 = $this->input->post('serial_no2');
		//$final_grade = $this->input->post('final_grade');
		//$items_array = $this->input->post('items');
		//$items = implode(',',$items_array);
		
		if($varient_ids!=""){
			$varient_array = explode('-',$varient_ids);
			$product_id = $varient_array[1];
			$varient_id = $varient_array[2];
			$varient_pid = $varient_array[3];	
		}else{
			$product_id = $id_array[1];
		}
		$product_details = $this->products->getproductById($product_id);
				
		$jobwork_product_name = $product_details->product_name;
		
		$product_info = $this->getProductInfo($purchase_item_id,$product_id,$varient_id,$current_grade='',$color_id);
		$jobwork_brand_name = $product_info[0]->brand_name;
		$jobwork_varient_type = $product_info[0]->unit_name;
		$jobwork_color_name = $product_info[0]->colour_name;
		//$current_condition = $product_info[0]->condition_type;		
		
		/* $condition_record = $this->getConditionNamebyID($current_grade);
		$current_condition = $condition_record->name; */
		
		$get_current_receive_status = $this->current_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id);

		if($get_current_receive_status['rows']==0)
		{
			$this->receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,1);
		}
		else
		{
			 $total_qty = $get_current_receive_status['qty']+1;
			 $this->update_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,$total_qty);
		}		

		$insert_data = array(
		 'purchase_id'        => $purchase_id,
		 //'sticker_no'         => $sticker_no,
		 'product_label_name' => $jobwork_product_name,
		 'brand'              => $jobwork_brand_name,
		 'varient'            => $jobwork_varient_type,
		 'colour'             => $jobwork_color_name, 
		 //'product_condition'  => $current_condition,
		 'imei1'              => $serial_no1,
		 'imei2'              => $imei_2,
		 //'item_replaced'      => $items,
		 //'qc_engineer'        => $qc_engineer,
		 'date_created'       => date("Y-m-d H:i:s"),
		 'status'             => 1,
		 'logged_user_id'     => $_SESSION['loggedin'] 
		 );
		$this->db->insert("tbl_qc_data",$insert_data);
		//echo $this->db->last_query(); exit;
		
		$insert_data1 = array(
		 'product_id'        => $product_id,
		 'purchase_pid'      => $product_id,
		 'purchase_id'       => $purchase_id,
		 'serial'            => $serial_no1,
		 'imei2'             => $imei_2,
		 'status'            => 2,
		 //'sticker'           => $sticker_no,
		 //'current_condition' => $current_grade,
		 //'convert_to'        => $final_grade
		);
		$this->db->insert("geopos_product_serials",$insert_data1);		
		$serial_id = $this->db->insert_id();

		$warehouse = array(
		 'pid'            => $product_id,
		 'serial_id'      => $serial_id,
		 'invoice_id'     => $purchase_id,
		 'fwid'           => 0,
		 'twid'           => 0,
		 'logged_user_id' => $_SESSION['loggedin'],
		 'date_created'   => date('Y-m-d H:i:s'),
		 'status'         => 1
		 );
		$this->db->insert("tbl_warehouse_serials",$warehouse);

		$this->db->where('id',$purchase_id);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase');

		$this->db->where('tid',$purchase_id);
		$this->db->where('pid',$product_id);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase_items');

		$this->db->set('qty', "qty+1", FALSE);
		$this->db->where('pid', $product_id);
		$this->db->update('geopos_products');	

     //redirect('purchase/park_goods'); 
    }
	
	
	public function send_to_jobwork(){
		/* echo "<pre>";
		print_r($_REQUEST);
		echo "</pre>"; exit; */
		
		$serial = $this->input->post('serial');
		$product_id = $this->input->post('pid');
		$jobwork_required = $this->input->post('jobwork_required');
		$current_grade = $this->input->post('current_grade');
		$final_grade = $this->input->post('final_grade');
		$items_array = $this->input->post('items');
		$component_request = $this->input->post('component_request');
		$items = implode(',',$items_array);
		
		//Save Job Card Resend Log
		$this->save_jobcard_resend_log($serial);
		
		$this->db->where('serial', $serial);
		$this->db->where('status !=', 8);
		$query = $this->db->get('geopos_product_serials');
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$serial_id =$row->id;
			}
		}		
		
		if($serial_id!=''){			
			$data = array(            
				'item_replaced'  => $items,				
				'component_request'  => $component_request,				
				'date_modified' => date('Y-m-d H:i:s'),
				'logged_user_id'  => $this->session->userdata('user_details')[0]->users_id 
			);
			$this->db->set($data);
			$this->db->where('imei1', $serial);
			$this->db->update('tbl_qc_data');
			
			$data1 = array(            
				'status' => 4,
				'current_condition' => $current_grade,				
				'convert_to' => $final_grade,				
				'date_modified' => date('Y-m-d H:i:s')				
			);
			$this->db->set($data1);
			$this->db->where('serial', $serial);
			$this->db->where('status !=', 8);
			$this->db->update('geopos_product_serials');			
						
			$data2 = array( 
				'hold_status' => 0,				
				'date_modified' => date('Y-m-d H:i:s')
			);
			$this->db->set($data2);
			$this->db->where('serial_id', $serial_id);
			$this->db->update('tbl_warehouse_serials');
			
			
			$this->db->where('serial', $serial);			
			$query1 = $this->db->get('tbl_jobcard');
			
			if ($query1->num_rows() > 0) {						
				$data3 = array(            
					'status' => 1,
					'change_status' => 1,
					'final_qc_status' => 1,
					'date_modified' => date('Y-m-d H:i:s'),
					'type' => 1
				);
				$this->db->set($data3);
				$this->db->where('serial', $serial);
				$this->db->update('tbl_jobcard');				
			}else{
				$data3 = array(					
					'serial' => $serial,
					'status' => 1,
					'change_status' => 1,
					'final_qc_status' => 1,
					'date_modified' => date('Y-m-d H:i:s'),
					'type' => 0
				);			
				$this->db->insert('tbl_jobcard',$data3);
			}
			
			foreach($items_array as $key=>$component_name){
				$component_details = $this->getComponentByPid($product_id,$vid='',$component_name);	
				$this->db->set('status', 3, FALSE);
				$this->db->set('product_serial', $serial, FALSE);
				$this->db->where('id', $component_details[0]['component_serial_id']);
				$this->db->update('tbl_component_serials');
			}
			//echo $this->db->last_query();
			
			return true;
		}else{
			return false;
		}		
	}
	
	public function save_jobcard_resend_log($serial){
		$p_s_d = $this->getRecordByProductSerial($serial);
		$w_s_d = $this->getRecordByWarehouseSerialId($p_s_d->id);
		$j_c_d = $this->getJobCardrecordBySerial($serial);	
		
		
		// Save Product Serial Log
		$ps = array(            
			'product_serial_id' => $p_s_d->id,
			'product_id' => $p_s_d->product_id,
			'purchase_id' => $p_s_d->purchase_id,
			'serial' => $p_s_d->serial,
			'status' => $p_s_d->status,
			'partial_status' => $p_s_d->partial_status,
			'jobwork_req_id' => $p_s_d->jobwork_req_id,
			'sticker' => $p_s_d->sticker,
			'imei2' => $p_s_d->imei2,
			'current_condition' => $p_s_d->current_condition,
			'convert_to' => $p_s_d->convert_to,
			'logged_user_id' => $_SESSION['id'],
			'date_modified' => date('Y-m-d H:i:s')
		);			
		$this->db->insert('geopos_product_serials_log',$ps);
		//echo $this->db->last_query();
		// Save Warehouse Serial Log
		$ws = array(            
			'warehouse_serial_id' => $w_s_d->id,
			'pid' => $w_s_d->pid,
			'serial_id' => $w_s_d->serial_id,
			'invoice_id' => $w_s_d->invoice_id,
			'fwid' => $w_s_d->fwid,
			'twid' => $w_s_d->twid,
			'logged_user_id' => $w_s_d->logged_user_id,
			'date_created' => $w_s_d->date_created,
			'date_modified' => date('Y-m-d H:i:s'),
			'status' => $w_s_d->status,
			'is_present' => $w_s_d->is_present,			
			'hold_status' => $w_s_d->hold_status			
		);			
		$this->db->insert('tbl_warehouse_serials_log',$ws);
		
		// Save Job Card Log
		$jc = array(            
			'jobcard_id' => $j_c_d->id,
			'teamlead_id' => $j_c_d->teamlead_id,
			'serial' => $j_c_d->serial,
			'assign_engineer' => $j_c_d->assign_engineer,
			'status' => $j_c_d->status,
			'change_status' => $j_c_d->change_status,
			'final_qc_status' => $j_c_d->final_qc_status,
			'final_qc_remarks' => $j_c_d->final_qc_remarks,
			'final_condition' => $j_c_d->final_condition,
			'sub_cat' => $j_c_d->sub_cat,
			'sub_sub_cat' => $j_c_d->sub_sub_cat,
			'jobwork_service_type' => $j_c_d->jobwork_service_type,
			'date_created' => $j_c_d->date_created,
			'date_modified' => date('Y-m-d H:i:s')
		);			
		$this->db->insert('tbl_jobcard_history',$jc);
	}
	
	public function getRecordByProductSerial($serial){
		$this->db->where('serial', $serial);
		$this->db->where('status !=', 8);
		$query = $this->db->get('geopos_product_serials');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;
			}
			return $data;
		}
		return false;
	}
	
	public function getRecordByWarehouseSerialId($serial_id){
		$this->db->where('serial_id', $serial_id);		
		$query = $this->db->get('tbl_warehouse_serials');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;
			}
			return $data;
		}
		return false;
	}
	
	public function getJobCardrecordBySerial($serial){
		$this->db->where('serial', $serial);		
		$query = $this->db->get('tbl_jobcard');
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;
			}
			return $data;
		}
		return false;
	}	
	
	public function get_recieved_qty($invoice_id){
		$this->db->where('invoice_id',$invoice_id);
		$this->db->where('status',0);
		$this->db->where('is_present',1);		
        $query = $this->db->get('tbl_warehouse_serials');
		//echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {			
			return $query->num_rows();
		}
		return 0;	
	}
	
	public function get_pending_qty($invoice_id){
		$this->db->where('invoice_id',$invoice_id);
		$this->db->where('status !=',0);
		$this->db->where('is_present !=',1);		
        $query = $this->db->get('tbl_warehouse_serials');
		//echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {			
			return $query->num_rows();
		}
		return 0;	
	}
	
	public function save_receive_view($serial){
		$this->db->where('serial',$serial);
		$this->db->where('status !=',8);		
        $query = $this->db->get('geopos_product_serials');		
        if ($query->num_rows() > 0) {			
			foreach ($query->result() as $key=>$row) {
				$data = array( 
					'status' => 0,				
					'is_present' => 1,				
					'date_modified' => date('Y-m-d H:i:s')
				);
				$this->db->set($data);
				$this->db->where('serial_id', $row->id);
				$this->db->update('tbl_warehouse_serials');
			}
			return true;
		}
		return false;
	}
	
	public function invoice_serial_details_pending($invoice_id='',$serial='', $status='',$is_present='')
    {
        $this->db->select('a.pid,b.serial,a.fwid,a.twid,a.status,a.is_present,a.hold_status,
		b.status as product_serial_status,b.current_condition,b.convert_to,b.jobwork_req_id,
		c.*,e.title,f.name as trc_name,f.email as trc_email,f.phone as trc_phone,
		f.address as trc_address,f.city as trc_city,g.terms,h.ewayBillNo,i.product_name,j.title as category');
        $this->db->from('tbl_warehouse_serials as a');
		
		if($invoice_id){
			$this->db->where('c.id', $invoice_id);
		}
		if($serial){
			$this->db->where('b.serial', $serial);
		}
		if($status){
			$this->db->where('a.status', $status);
		}
		if($is_present){
			$this->db->where('a.is_present', $is_present);
		}
		$this->db->where('f.users_id', $this->session->userdata('user_details')[0]->users_id);
        
        $this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');		
        $this->db->join('geopos_invoices as c', 'c.id = a.invoice_id', 'left');
        //$this->db->join('geopos_invoice_items as d', 'd.tid = c.id', 'left');		
        $this->db->join('geopos_warehouse as e', 'e.id = a.twid', 'left');
        $this->db->join('users_lrp as f', 'f.users_id = e.franchise_id', 'left');
        $this->db->join('geopos_terms as g', 'g.id = c.term', 'left');
		$this->db->join('tbl_ewaybill as h', 'h.invoice_number = c.tid', 'left');
		$this->db->join('geopos_products as i', 'i.pid = a.pid', 'left');
		$this->db->join('geopos_product_cat as j', 'j.id = i.pcat', 'left');
		
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
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
	  
	public function category_list($type = 0, $rel = 0)
    {
        $query = $this->db->query("SELECT id,title
		FROM geopos_product_cat WHERE c_type='$type' AND rel_id='$rel'
		ORDER BY id DESC");
        return $query->result_array();
    }
	
	public function getParentcategory($cat){
		//$data[] = $cat;
		$this->db->where('id',$cat);
		$query = $this->db->get('geopos_product_cat');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				//$data[] = $row->rel_id;
				if($row->rel_id != 0){
					$parent = $this->getParentcategory($row->rel_id);
				}
				return $parent = $parent.'-'.$row->id;
			}
			//return $data;
		}
		return false;
		
	}
	
	public function getCategoryNames($arr){
		array_pop($arr);
		foreach($arr as $row){
			$data['id'] = $row;
			$data['title'] = $this->GetParentCatTitleById($row);
			$dataArr[] = $data;
		}
		return $dataArr;
	}
	
	public function GetParentCatTitleById($rel_id='')
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
	
	public function category_list_dropdown($type=0, $rel=0,$website_id='')
    {   
		if($website_id!=''){
			$this->db->where("website_id",$website_id);
		}
		if($type !=NULL)
		$this->db->where("c_type",$type);
		if($rel !=NULL)
		$this->db->where("rel_id",$rel);		
		$this->db->order_by("id","asc");		
		$query = $this->db->get("geopos_product_cat");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				if($row->rel_id !=0){
					$ptitle = $this->GetParentCatTitleById($row->rel_id);
					//$row->title = $ptitle.' &rArr; '.$row->title;
					$row->title = $row->title;
				}					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
    }	
	
	public function getComponentByPid1($pid)
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
	
	public function JobWorkComponent($serial)
	{	
		$warehouse_details = $this->getWarehouse();
	  	$this->db->select("b.component_name,a.serial");
	  	$this->db->from("tbl_component_serials as a");	  	
	  	$this->db->join("tbl_component as b","a.component_id=b.id",'left');
	  	$this->db->where('a.product_serial',$serial);			
		$this->db->where("a.twid",$warehouse_details[0][id]);
	  	$this->db->where('a.status',3);
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
	
	
	public function getCustomList($id='')
	{

		$this->db->select("a.*,b.name as unit_name,c.name as colour_name,d.title as brand_name");
		$this->db->from("tbl_custom_label as a");
		$this->db->join("geopos_units as b","a.varient_id=b.id",'left');
		$this->db->join("geopos_colours as c","a.color_id=c.id",'left');
		$this->db->join("geopos_products as e","a.pid=e.pid",'left');
		$this->db->join("geopos_brand as d","e.b_id=d.id",'left');
		if($id!='')
		{
			$this->db->where('a.id',$id);   
		}
		$this->db->order_by('a.id','desc');

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
	
	
	public function getProductDetailsByID($serial){
		$this->db->select('b.*,a.serial,a.imei2');
		$this->db->where('a.serial',$serial);
		$this->db->from("geopos_product_serials as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid",'left');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	public function getWarehouse()
	{
		$this->db->select("*");
		$this->db->from("geopos_warehouse");
		$this->db->where("franchise_id",$this->session->userdata('user_details')[0]->users_id);
		$this->db->where("warehouse_type",2);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getSerialComponent($pid,$twid)
    {
        $this->db->select("p.component_name,s.serial_in_type,p.hsn_code,s.serial,s.id,s.component_id,p.warehouse_product_code");
        $this->db->from("tbl_component_serials as s");
        $this->db->join("tbl_component as p","s.component_id=p.id",'LEFT');
        $this->db->where('s.component_id',$pid);
        $this->db->where('s.twid',$twid);
        $this->db->where('s.status',4);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                    $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function getSupplier($supplier_id='')
	{
		$this->db->select("e.company,c.purchase_id,e.id,c.invoice_id,b.tid");
		$this->db->from("geopos_warehouse as a");
		$this->db->join("geopos_invoices as b","a.id=b.twid","left");
		$this->db->join("tbl_component_serials as c","b.id=c.invoice_id","left");
		$this->db->join("geopos_purchase as d","c.purchase_id=d.id","left");
		$this->db->join("geopos_supplier as e","d.csd=e.id","left");
		$this->db->where("b.type",5);
		if($supplier_id!='')
		{
		$this->db->where("a.franchise_id",$this->session->userdata('user_details')[0]->users_id);	
		$this->db->where("e.id",$supplier_id);
		$this->db->group_by("b.id");
		}
		else
		{
		$this->db->where("a.franchise_id",$this->session->userdata('user_details')[0]->users_id);
		$this->db->group_by("e.company");
		}
		$query = $this->db->get();
		$data = array();
		if($query->num_rows()>0)
		{
		  foreach ($query->result() as $key => $value) {
			$data[] = $value;
		  }
		  return $data;
		}
		return false;
	}
   
   public function getItemByInvoice($invoice_id)
    {
        $data=array();
        $this->db->select("*");
        $this->db->from("geopos_invoice_items");
        $this->db->where("geopos_invoice_items.tid",$invoice_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $total_received_good = $this->getReveiveGoods($invoice_id,$row->id);
                if($row->qty>$total_received_good)
                {
                $data[] = $row;
                }
            }
            return $data;
        }
    }
	
    public function getReveiveGoods($invoice_id='',$pid)
    {
        $total = 0;
        $this->db->select("count(id) as received_qty");
        $this->db->from("tbl_component_serials");
        if($purchase_id!='')
        {
        $this->db->where("invoice_id",$purchase_id);
        }
        $this->db->where("id",$pid);
        $this->db->where("lrp_status",2);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            $result = $query->result_array();
            $total = $result[0]['received_qty'];
        }
        return $total;
    }
	
	public function getvarient($component_id,$invoice_id)
	{
		//$data = array();
		$this->db->select("a.warehouse_product_code,b.qty");
		$this->db->from("geopos_invoice_items as b");
		$this->db->join("tbl_component as a","b.pid=a.id","left");
		$this->db->where("a.id",$component_id);
		$this->db->where("b.tid",$invoice_id);
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
	}
	
	public function get_qc_component_bySerial($serial){
		$this->db->where("imei1",$serial);
		$query = $this->db->get('tbl_qc_data');
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


	public function invoice_list()
	{
		$this->db->select("a.invoicedate,a.id,a.tid,a.type,a.subtotal,a.twid,a.items");
		$this->db->from("users_lrp as c");
		$this->db->join("geopos_warehouse as b","c.users_id=b.franchise_id","left");
		$this->db->join("geopos_invoices as a","b.id=a.twid","left");
		$this->db->where("c.users_id",$this->session->userdata('user_details')[0]->users_id);
		$this->db->where("a.type",5);
		$this->db->or_where("a.type",8);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;

		$data = array();
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $key => $value) {
				if($value->type==5)
				{
				$value->pending = $this->sparepart_qty_status(1,$value->id,$value->twid);
				$value->received = $this->sparepart_qty_status(2,$value->id,$value->twid);
				}
				else
				{
				$value->pending = $this->get_pending_qty($value->id);
				$value->received = $this->get_recieved_qty($value->id); 
				}
				$data[] = $value;
			}

		return $data;
	}


   	return false;
   }

    public function sparepart_qty_status($status,$invoice_id,$twid)
   {
   	$this->db->select("*");
   	$this->db->from("tbl_component_serials");
   	$this->db->where("lrp_status",$status);
   	$this->db->where("invoice_id",$invoice_id);
   	$this->db->where("twid",$twid);
   	$query = $this->db->get();
   	//echo $this->db->last_query(); die;
   	//$data = array();
    return	$query->num_rows(); 

   }

	
}