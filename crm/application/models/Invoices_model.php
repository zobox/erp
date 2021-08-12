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




    public function invoice_details($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms,tbl_ewaybill.ewayBillNo');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.id', $id);


        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $this->db->join('tbl_ewaybill', 'tbl_ewaybill.invoice_number = geopos_invoices.tid', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function invoice_products09032021($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }
	
	public function invoice_products($id)
    {
		$this->db->select('geopos_invoice_items.*, geopos_products.hsn_code');
		$this->db->join('geopos_products','geopos_products.pid = geopos_invoice_items.pid', 'inner');
		$this->db->from('geopos_invoice_items');
        $this->db->where('geopos_invoice_items.tid', $id);
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

         $this->db->select('geopos_invoices.id,geopos_invoices.type,geopos_invoices.pmethod,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_invoices.multi,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
     //     $this->db->where('geopos_invoices.i_class');
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

    function get_datatables($type='')
    {

        $this->_get_datatables_query();
		if($type){
        $this->db->where('geopos_invoices.type', $type);
		}
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
         // $this->db->where('geopos_invoices.i_class', 0);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	
	
	
	private function _get_datatables_query1()
    {

         $this->db->select('geopos_invoices.id,geopos_invoices.type,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_invoices.multi,geopos_customers.name');
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
     //     $this->db->where('geopos_invoices.i_class');
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

    function get_datatables1()
    {

        $this->_get_datatables_query1();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
        $this->db->where('geopos_invoices.type', 2);
        $this->db->or_where('geopos_invoices.type', 4);
        //$this->db->where('geopos_invoices.i_class', 0);
        if ($_POST['length'] != -1)
           // $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
     //     $this->db->where('geopos_invoices.i_class', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('geopos_invoices.csd', $this->session->userdata('user_details')[0]->cid);
    //      $this->db->where('geopos_invoices.i_class', 0);
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
	
	
	public function getInvoiceDTL(){
		$this->db->where('csd',$this->session->userdata('user_details')[0]->cid);
		/* $this->db->where('type',2);
		$this->db->or_where('type',4); */
		$type_val = array('2', '4', '6');
		$this->db->where_in('type', $type_val);
		$this->db->order_by('id','DESC');
        $query = $this->db->get('geopos_invoices');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function franchiseTransactions($cid){	
		$this->db->where('csd',$this->session->userdata('user_details')[0]->cid);
		$this->db->where('type',2);
		$this->db->or_where('type',4);
		$this->db->order_by('id','DESC');
        $query = $this->db->get('geopos_invoices');
		//echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$items = $this->franchiseTransactionsItems($row->id);
				$transaction_record = $this->getTransactionDetails($row->id);
				$row->transaction_details = $transaction_record;
				$row->transID = $transaction_record->id;
				$row->net_price = $items->net_price;
				$row->franchise_commision = $items->franchise_commision;
				$row->tds = $items->tds;
				$row->fcp = $items->fcp;
				if($row->type==4){
					$row->debit_amount = $row->total;
					$row->debit_note = $row->notes;
				}
				$data[] = $row;
			}			
			return $data;
		}
		return false;	
	}
	
	public function franchiseTransactionsItems($tid){
		$this->db->select('*,sum(net_price) as net_price,sum(franchise_commision) as franchise_commision,sum(tds) as tds,GROUP_CONCAT(fcp)');
		$this->db->where('tid',$tid);
		$this->db->group_by('tid');
        $query = $this->db->get('geopos_invoice_items');
		//echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data = $row;
			}			
			return $data;
		}
		return false;	
	}
	
	public function getTransactionDetails($tid){
		$this->db->where('tid',$tid);
		$query = $this->db->get('geopos_transactions');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data = $row;
			}			
			return $data;
		}
		return false;
	}

}