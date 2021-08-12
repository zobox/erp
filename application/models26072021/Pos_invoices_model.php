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

class Pos_invoices_model extends CI_Model
{
    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status', null);
    var $column_search = array('geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoices.total','geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $this->db->where('i_class', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }


    public function invoice_details($id, $eid = '',$loc=null)
    {

        $this->db->select('geopos_invoices.*, SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,tbl_customers.name as c_name,tbl_customers.address as c_address,tbl_customers.email as c_email,tbl_customers.phone as c_phone,geopos_invoices.loc as loc,geopos_invoices.id AS iid,tbl_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);
        if ($eid) {
            $this->db->where('geopos_invoices.eid', $eid);
        }
        if (@$this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA and !$loc) { $this->db->where('geopos_invoices.loc', 0); }
        if($loc){ $this->db->where('geopos_invoices.loc', $loc); }
        $this->db->join('tbl_customers', 'geopos_invoices.csd2 = tbl_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('geopos_currencies');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
       if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }

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

    public function invoice_delete($id, $eid = '')
    {

        $this->db->trans_start();

        $this->db->select('status');
        $this->db->from('geopos_invoices');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();

          if ($this->aauth->get_user()->loc) {
            if ($eid) {

                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => $this->aauth->get_user()->loc));


            } else {
                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));
            }
        }

        else {
            if (BDATA) {
                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id));
                }
            } else {


                if ($eid) {

                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => 0));


                } else {
                    $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => 0));
                }
            }
        }
        $affect = $this->db->affected_rows();
        if ($res) {
            if ($result['status'] != 'canceled') {
                $this->db->select('pid,qty');
                $this->db->from('geopos_invoice_items');
                $this->db->where('tid', $id);
                $query = $this->db->get();
                $prevresult = $query->result_array();
                foreach ($prevresult as $prd) {
                    $amt = $prd['qty'];
                    $this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $prd['pid']);
                    $this->db->update('geopos_products');
                }
            }
            if ($affect) $this->db->delete('geopos_invoice_items', array('tid' => $id));
            $data = array('type' => 9, 'rid' => $id);
            $this->db->delete('geopos_metadata', $data);
            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function _get_datatables_query($opt = '')
    {
		$this->db->select('geopos_invoices.id,geopos_invoices.type,geopos_invoices.pmethod_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.i_class', 1);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
          elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
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

    function get_datatables($opt = '',$type='',$wid ='')
    {
        $this->_get_datatables_query($opt);
		
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        
        $this->db->where('geopos_invoices.i_class', 1);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
          elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
		if($type){
        $this->db->where('geopos_invoices.type', $type);
		}
		
		if($this->aauth->premission(5) !=1){			
			$this->db->where('geopos_invoices.fwid', $wid);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($opt) {
            $this->db->where('eid', $opt);

        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->select('geopos_invoices.id');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.i_class', 1);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_invoices.loc', 0); }
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('type', 1);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('geopos_metadata', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 1);
        $this->db->where('geopos_metadata.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }

    public function gateway_list($enable = '')
    {

        $this->db->from('geopos_gateways');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function drafts()
    {


        $this->db->select('geopos_draft.id,geopos_draft.tid,geopos_draft.invoicedate');
        $this->db->from('geopos_draft');
       $this->db->where('geopos_draft.loc', $this->aauth->get_user()->loc);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(12);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function draft_products($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_draft_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function draft_details($id, $eid = '')
    {

        $this->db->select('geopos_draft.*,SUM(geopos_draft.shipping + geopos_draft.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_draft.id AS iid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_draft');
        $this->db->where('geopos_draft.id', $id);
        if ($eid) {
            $this->db->where('geopos_draft.eid', $eid);
        }
        $this->db->join('geopos_customers', 'geopos_draft.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_draft.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');

        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
           if(BDATA) $this->db->or_where('loc', 0);
        }else{
             if(!BDATA) $this->db->where('loc', 0);
        }

        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function AddNewCustomer(){
		$array = array('name' => $this->input->post('name',true),'phone' => $this->input->post('phone',true),'address' => $this->input->post('address'),'email' => $this->input->post('email'),'date_created' => date("Y-m-d H:i:s"),'logged_user_id' => $this->session->userdata('id'));

		$this->db->where('phone',$this->input->post('phone',true));
		$query1 = $this->db->get('tbl_customers');
		if($query1->num_rows() == 0){
            if($this->input->post('email')!='')
            {
			$this->db->where('email',$this->input->post('email'));
			$query2 = $this->db->get('tbl_customers');
             
			if($query2->num_rows() == 0){
				$this->db->insert('tbl_customers',$array);
				
				$insert_id = $this->db->insert_id();
				$array2 = array('note'=>'[Customer Created] -'.$insert_id.'[Logged User] -'.$this->session->userdata('id'),'created' => date("Y-m-d H:i:s"));
				$this->db->insert('geopos_log',$array2);
				return true;
				
			}else{
				return "Email already exists.";	
			}
        }
        else
        {
                $this->db->insert('tbl_customers',$array);
               
                $insert_id = $this->db->insert_id();
                $array2 = array('note'=>'[Customer Created] -'.$insert_id.'[Logged User] -'.$this->session->userdata('id'),'created' => date("Y-m-d H:i:s"));
                $this->db->insert('geopos_log',$array2);
                return true; 
        }
		}else{
			return "Mobile no already exists.";	
		}
		
	}
	
	
	public function getCustomers(){
		$user = $this->session->userdata('id');
		$this->db->where('logged_user_id',$user);
		$this->db->where('status',1);
		$query = $this->db->get('tbl_customers');
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$data[] = $rows;
			}
			return $data;
		}
		return false;
	}
	
	public function getAvailableQtyByPID($pid,$wid){
		$this->db->where('pid', $pid);
		$this->db->where('wid', $wid);
		$query = $this->db->get('tbl_warehouse_product');
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				return $rows->qty;
			}			
		}
		return false;
	}
	
	public function getBillFromAddress($billFromId = ''){
		//echo "ttt";die;
		$this->db->select('franchise_id');
		$this->db->where('id',$billFromId);
		$query = $this->db->get('geopos_employees')->result_array();
		
		$franchiseid = $query[0]['franchise_id'];
		
		if($franchiseid == 0){
			$this->db->where('id',1);
			$query2 = $this->db->get('geopos_locations')->result_array();
			//echo $this->db->last_query();die;
			$data[] = $query2[0];
		}else{
			$this->db->select('*');
			$this->db->where('id',$franchiseid);
			$query2 = $this->db->get('geopos_customers')->result_array();
           

			$locationid = $query2[0]['loc'];
			$this->db->where('id',$locationid);
			$query3 = $this->db->get('geopos_locations')->result_array();
			//echo $this->db->last_query();die;
			$data[] = $query3[0];
            $data[] = $query2[0];
            
		}
         
		return $data;
		
	}
	
	public function getBillToAddress($customerId){
		$this->db->where('id',$customerId);
		$query = $this->db->get('tbl_customers')->result_array();
		return $query[0];
	}
	
}