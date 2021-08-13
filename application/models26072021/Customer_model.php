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

class Customer_model extends CI_Model
{
	public function getAllCustomer($id = ''){
		if($id){
			$this->db->where('id',$id);
		}
		$query = $this->db->get('tbl_customers');
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$data[] = $rows;
			}
			return $data;
		}
		return false;
	}

		
	public function getB2BCustomer($id = ''){
		if($id){
			$this->db->where('id',$id);
		}
		$this->db->where('type',2);
		$query = $this->db->get('tbl_customers');
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				$data[] = $rows;
			}
			return $data;
		}
		return false;
	}
	
	function inv_datatables($id, $tyd = 0)
    {
		$this->db->where('geopos_invoices.type !=',4);
        $this->_inv_datatables_query($id, $tyd);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }
	
	
	private function _inv_datatables_query($id, $tyd = 0)
    {
        $this->db->select('geopos_invoices.*');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.csd2', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }

        if ($tyd) $this->db->where('geopos_invoices.i_class>', 1);
        $this->db->join('tbl_customers', 'geopos_invoices.csd=tbl_customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
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

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}