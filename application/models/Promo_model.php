<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
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

class Promo_model extends CI_Model
{

    var $table = 'geopos_promo';
    var $column_order = array(null, 'code', 'valid', 'amount', null);
    var $column_search = array('code', 'valid', 'amount');
    var $order = array('id' => 'desc');

    private function _get_datatables_query($id = '')
    {

        $this->db->from($this->table);
                if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
                     if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('location', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('location', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('location', 0);
        }
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function create($coupon_title,$code,$applicable_to,$applicable_to_selection,$discount_type,$amount,$coupon_discount_on,$coupon_discount_on_select,$valid_from,$valid_till,$note)
    {

        /*if ($link_ac == 'no') {
            $pay_acc = 0;
        }*/

        /*$data = array(
            'code' => $code,
            'amount' => $amount,
            'valid' => $valid,
            'active' => 0,
            'note' => $note,
            'reflect' => $pay_acc,
            'qty' => $qty,
            'available' => $qty,
            'location' => $this->aauth->get_user()->loc
        );*/
		$data['code'] = $code;
		$data['amount'] = $amount;
		$data['valid'] = $valid_till;
		$data['active'] = 0;
		$data['note'] = $note;
		$data['location'] = $this->aauth->get_user()->loc;
		$data['coupon_title'] = $coupon_title;
		$data['applicable_to'] = $applicable_to;
		$data['applicable_to_selection'] = $applicable_to_selection;
		$data['discount_type'] = $discount_type;
		$data['coupon_discount_on'] = $coupon_discount_on;
		$data['coupon_discount_on_select'] = $coupon_discount_on_select;
		$data['valid_from'] = $valid_from;
		$data['valid_till'] = $valid_till;
		$data['date_created'] = date("Y-m-d H:i:s");
		$data['logged_user_id'] = $this->session->userdata('id');
		$data['status'] = 0;
		//print_r($data);exit();
		if($this->db->insert('geopos_promo', $data)){
			echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
		}else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
		

        /*if ($this->db->insert('geopos_promo', $data)) {
            $cid = $this->db->insert_id();
            if ($pay_acc > 0) {
                $amount = $amount * $qty;
                $this->db->select('holder');
                $this->db->from('geopos_accounts');
                $this->db->where('id', $pay_acc);
                $query = $this->db->get();
                $account = $query->row_array();
                $data = array(
                    payerid' => 0,
                    payer' => $this->lang->line('Coupon') . '-' . $code,
                    acid' => $pay_acc,
                    account' => $account['holder'],
                    date' => date('Y-m-d'),
                    debit' => $amount,
                    credit' => 0,
                    type' => 'Expense',
                    cat' => $this->lang->line('Coupon'),
                    method' => 'Transfer',
                    eid' => $this->aauth->get_user()->id,
                    note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Qty') . '-' . $qty,
                    loc' => $this->aauth->get_user()->loc
                );
                $this->db->set('lastbal', "lastbal-$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');
                $this->db->insert('geopos_transactions', $data);
            }
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));

        } */
    }


    public function promo_stats()
    {  $whr='';
             if ($this->aauth->get_user()->loc) {
            $whr = ' WHERE location=' . $this->aauth->get_user()->loc;
             if(BDATA) $whr .= 'OR location=0 ';
        } elseif (!BDATA) {
            $whr = ' WHERE location=0';
        }


        $query = $this->db->query("SELECT
				COUNT(IF( active = '0', id, NULL)) AS Active,
				COUNT(IF( active = '1', id, NULL)) AS Used,
				COUNT(IF( active = '2', id, NULL)) AS Expired
				FROM geopos_promo $whr");
        echo json_encode($query->result_array());

    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
                    if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_status($id, $stat)
    {

        $data = array('active' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('geopos_promo');
    }
	public function getAllBusinessLocation(){
		$result = $this->db->get('geopos_locations')->result_array();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($result as $row){
			$html .="<option value='business_".$row['id']."'>".$row['cname']."</option>"; 
		}
		return $html;
	}
	
	public function getAllStores(){
		$result = $this->db->get('geopos_customers')->result_array();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($result as $row){
			$html .="<option value='stores_".$row['id']."'>".$row['name']."</option>"; 
		}
		return $html;
	}
	
	public function getAllforApplicable(){
		$result = $this->db->get('geopos_locations')->result_array();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($result as $row){
			$html .="<option value='business_".$row['id']."'>".$row['cname']."</option>"; 
		}
		$result2 = $this->db->get('geopos_customers')->result_array();
		foreach($result2 as $row2){
			$html .="<option value='stores_".$row2['id']."'>".$row2['name']."</option>"; 
		}
		return $html;
	}
	public function defaultApplicable(){
		return 0;
	}
	public function getAllProduct(){
		$result = $this->db->get('geopos_products')->result_array();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($result as $row){
			$html .= "<option value='product_".$row['pid']."'>".$row['product_name']."</option>";
		}
		return $html;
	}
	public function getAllCategory(){
		$this->db->where('c_type','0');
		$this->db->where('rel_id','0');
		$result = $this->db->get('geopos_product_cat')->result_array();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($result as $row){
			$html .= "<option value='category_".$row['id']."'>".$row['title']."(".$row['extra'].")</option>";
		}
		return $html;
	}
	public function getAllSubCategory(){
		/*$this->db->where('c_type','1');
		$result = $this->db->get('geopos_product_cat')->result_array();
		foreach($result as $row){
			$html .= "<option value='subcategory_".$row['id']."'>".$row['title']."(".$row['extra'].")</option>";
		}
		return $html;*/
		$data = $this->categories->category_list_dropdown();
		$html .="<option value='' selected='' disabled>--- Select ---</option>"; 
		foreach($data as $row){
			if($row->c_type == 1){$html .= "<option value='category_".$row->id."'>".$row->title."</option>";}
		}
		return $html;
	}
	
	public function value_selection_data($data){
		$data = explode("_",$data);
		switch($data[0]){
			case "business":
				$this->db->where('id',$data[1]);
				$query = $this->db->get('geopos_locations')->result_array();
				echo '<p class="applicableselecton" id="'.$this->input->post('data',true).'" onclick="selectt('."'".$this->input->post('data',true)."'".')">'.$query[0]['cname'].' <span class="closee"> x </span></p>';
				break;
			case "stores":
				$this->db->where('id',$data[1]);
				$query = $this->db->get('geopos_customers')->result_array();
				echo '<p class="applicableselecton" id="'.$this->input->post('data',true).'" onclick="selectt('."'".$this->input->post('data',true)."'".')">'.$query[0]['name'].' <span class="closee"> x </span></p>';
				break;
		}
	}
	
	public function coupon_discount_value_selection_data($data){
		$data = explode("_",$data);
		switch($data[0]){
			case "product":
				$this->db->where('pid',$data[1]);
				$query = $this->db->get('geopos_products')->result_array();
				echo '<p class="applicableselectonn" id="'.$this->input->post('data',true).'" onclick="selecttt('."'".$this->input->post('data',true)."'".')">'.$query[0]['product_name'].' <span class="closee"> x </span></p>';
				break;
			case "category":
				$this->db->where('id',$data[1]);
				$query = $this->db->get('geopos_product_cat')->result_array();
				echo '<p class="applicableselectonn" id="'.$this->input->post('data',true).'" onclick="selecttt('."'".$this->input->post('data',true)."'".')">'.$query[0]['title'].' <span class="closee"> x </span></p>';
				break;
				
		}
	}


}