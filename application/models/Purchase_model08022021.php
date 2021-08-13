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

class Purchase_model extends CI_Model
{
    var $table = 'geopos_purchase';
    var $column_order = array(null, 'geopos_purchase.tid', 'geopos_supplier.name', 'geopos_purchase.invoicedate', 'geopos_purchase.total', 'geopos_purchase.status', null);
    var $column_search = array('geopos_purchase.tid', 'geopos_supplier.name', 'geopos_purchase.invoicedate', 'geopos_purchase.total','geopos_purchase.status');
    var $order = array('geopos_purchase.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastpurchase()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();

    }

    public function purchase_details($id)
    {

        $this->db->select('geopos_purchase.*,geopos_purchase.id AS iid,SUM(geopos_purchase.shipping + geopos_purchase.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('geopos_purchase.id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_purchase.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_purchase.loc', 0);
        }
        $this->db->join('geopos_supplier', 'geopos_purchase.csd = geopos_supplier.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function purchase_products($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_purchase_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function purchase_transactions($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function purchase_delete($id)
    {
        $this->db->trans_start();
        $this->db->select('pid,qty');
        $this->db->from('geopos_purchase_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('geopos_products');
        }
        $whr = array('id' => $id);
        if ($this->aauth->get_user()->loc) {
            $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
               $whr = array('id' => $id, 'loc' =>0);
        }
        $this->db->delete('geopos_purchase', $whr);
        if ($this->db->affected_rows()) $this->db->delete('geopos_purchase_items', array('tid' => $id));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query()
    {
        $this->db->select('geopos_purchase.id,geopos_purchase.tid,geopos_purchase.invoicedate,geopos_purchase.invoiceduedate,geopos_purchase.total,geopos_purchase.status,geopos_purchase.items,geopos_supplier.name');
        $this->db->from($this->table);
        $this->db->join('geopos_supplier', 'geopos_purchase.csd=geopos_supplier.id', 'left');
            if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_purchase.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_purchase.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);		
        $query = $this->db->get();
        return $query->result();
    }
	
	function get_pending_purchase_order()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('(geopos_purchase.items-geopos_purchase.pending_qty)>',0);
        $query = $this->db->get();
		//echo $this->db->last_query();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
           if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('geopos_terms');
        $this->db->where('type', 4);
        $this->db->or_where('type', 0);
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
        $this->db->where('geopos_metadata.type', 4);
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
	
	public function getPurchaseById($id=''){		
		$this->db->select('a.*,b.pid,b.product,b.code,b.qty,b.price,b.tax,b.discount,b.subtotal,b.totaltax,b.totaldiscount,b.product_des,b.unit,b.approval_status');		
		$this->db->from("geopos_purchase as a");		
		$this->db->join('geopos_purchase_items as b', 'a.id = b.tid', 'LEFT');
		$this->db->where('a.id',$id);		
		$query = $this->db->get();	
		//return $this->db->last_query();die;	
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data[] = $row;				
            }
            return $data;
        }
        return false;
	}
	
	public function getPurchaseByIdNew($id)    {   		
		$this->db->where("id",$id);				
		$query = $this->db->get("geopos_purchase");
		//echo $this->db->last_query(); 
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$row->pitems= $this->getPurchaseItemsByTID($row->id);				
				$data = $row;
			}			
			return $data;
		}
		return false;
    }
	
	
	public function getPurchaseItemsByTID($tid){
		$this->db->select('a.*,b.product_name,b.warehouse_product_code');		
		$this->db->from("geopos_purchase_items as a");		
		$this->db->join('geopos_products as b', 'a.pid = b.pid', 'LEFT');
		$this->db->where('a.tid',$tid);		
		$query = $this->db->get();		
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
					$data[] = $row;				
            }
            return $data;
        }
        return false;
    }
	
	
	public function addmanual04022021()
    {
		$id = $this->input->post('id');
		$sl = $this->input->post('sl');
		//$pid = $this->input->post('pid');
		$purchase_item = $this->input->post('purchase_item');
		
		$qty =0;		
		$serial_data = array();
		$chkstatus = 0;
		
		foreach($sl as $key=>$items){
			$purchase_item_id = $purchase_item[$key]; 
			$qty1 =0;
			$save ='';			
			foreach($items as $key2=>$serial){ 
				if($serial){					
					$res = $this->checkSerialNumberExist($serial);
					if($res==false){
						//$save = $this->db->insert('geopos_product_serials', $data);
						$data = array(
							'product_id' => $key,            
							'serial' => $serial            
						);
						
						$qty++;
						$qty1++;
						$not_exist_serials[] = $serial;						
						$pdetails = $this->getProductDetailsByPId($key);
						$wupc[] = $pdetails->warehouse_product_code;						
					}else{
						$chkstatus = 1;
						$exist_serials_err = "(".$serial.")";
						$exist_serials[] = $serial;
					}
					$serial_data[] = $data;
				}
			}			
		}
		
		
		echo "Not Exists";
		echo "<pre>";
		print_r($not_exist_serials);
		echo "</pre>";
		
		echo "Allredy Exists";
		echo "<pre>";
		print_r($exist_serials);
		echo "</pre>";
		
		exit;

		$this->db->set('pending_qty', "pending_qty+$qty1", FALSE);
		$this->db->where('id', $purchase_item_id);			
		$this->db->update('geopos_purchase_items');
			
		$this->db->set('qty', "qty+$qty1", FALSE);
		$this->db->where('pid', $key);
		$this->db->update('geopos_products');
		
		$this->db->set('pending_qty', "pending_qty+$qty", FALSE);
		$this->db->where('id', $id);
		$save1 = $this->db->update('geopos_purchase');			
		
		
		$inserted_serials = implode(",",$inserted_serial);
		$wupcs = implode(",",$wupc);
		
		if($inserted_serials!=''){
		$exist_serials.="<form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>";
		}

		if($save) {
            $this->aauth->applog("[Serial Number Added] $id ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
               $url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url));
        } else {			
            echo json_encode(array('status' => 'Error', 'message' =>
                $exist_serials_err));
        }
		
		
        /* if ($save1) {
             $this->aauth->applog("[Serial Number Added] $id ID " . $id, $this->aauth->get_user()->username);
               $url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url)); 
				redirect('purchase/pending');
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        } */

    }
	
	
	
	public function addbulk($serialNo){
		$purchase_id = $this->input->post('id');
		//$product_id = $this->input->post('pid');
		//print_r($serialNo);die;
		$qty1 = 0;
		$chkstatus = 0;
		$inserted_serial = array();
		$exist_serials_err = array();
		$wupc = array();
		foreach($serialNo as $key=>$rows){
			$qty = 0;
			
			$res = $this->checkSerialNumberExist($rows['serialNumber']);
			if($res == 0){
				$productname = $rows['product_name'];
				$this->db->select('pid');
				$this->db->where('product_name',$productname);
				$products = $this->db->get('geopos_products')->result();
				$productId = $products[0]->pid;
				$data2 = array('product_id'=>$productId,'purchase_id'=>$purchase_id,'serial'=>$rows['serialNumber']);
				$save = $this->db->insert('geopos_product_serials', $data2);
				$serailid = $this->db->insert_id();
				$this->aauth->applog("[Serial Number Added] $serailid ID " . $serailid, $this->aauth->get_user()->username);
				$this->db->set('pending_qty', "pending_qty+1", FALSE);
				$this->db->where('pid',$productId);
				$this->db->where('tid',$purchase_id);
				$this->db->update('geopos_purchase_items');
				$this->db->set('pending_qty', "pending_qty+1", FALSE);
				$this->db->where('id',$purchase_id);
				$this->db->update('geopos_purchase');
				$inserted_serial[] = $rows['serialNumber'];
				
				$pdetails = $this->getProductDetailsByPId($productId);
				$wupc[] = $pdetails->warehouse_product_code;
			}
			else{
				$chkstatus = 1;
				$exist_serials_err[] = $rows['serialNumber'];
			}
			
		}
		$inserted_serials = "(".implode(",",$inserted_serial).")";
		$wupcs = "(".implode(",",$wupc).")";
		
		if ($chkstatus ==0) {
             $this->aauth->applog("[Serial Number Added] $id ID " . $id, $this->aauth->get_user()->username);
               //$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
				$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
			echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url)); 
				//redirect('purchase/pending');
        } else {
			$exist_serials_err = "(".implode(",",$exist_serials_err).")";
			$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
            echo json_encode(array('status' => 'Error', 'message' =>
                $exist_serials_err.$url));
        }
	}
	
	
	public function addmanual()
    {
		$id = $this->input->post('id');
		$sl = $this->input->post('sl');
		//$pid = $this->input->post('pid');
		$purchase_item = $this->input->post('purchase_item');	
		$inserted_serial = array();
		$exist_serials_err = array();
		$wupc = array();
		$qty = 0;
		$chkstatus = 0;
		foreach($sl as $key=>$items){
			$purchase_item_id = $purchase_item[$key];
			$qty1 = 0;
			foreach($items as $key2=>$serial){ 
				if($serial){					
					$res = $this->checkSerialNumberExist($serial);
					if($res==false){
						$data = array(
							'product_id' => $key,            
							'serial' => $serial            
						);
						$save = $this->db->insert('geopos_product_serials', $data);			
						
						$qty++;
						$qty1++;
						$inserted_serial[] = $serial;						
						$pdetails = $this->getProductDetailsByPId($key);
						$wupc[] = $pdetails->warehouse_product_code;
					}else{
						$chkstatus = 1;
						$exist_serials_err[] = $serial;				
					}					
				}			
			}
			
			
			$this->db->set('pending_qty', "pending_qty+$qty1", FALSE);
			$this->db->where('id', $purchase_item_id);			
			$this->db->update('geopos_purchase_items');	

			$this->db->set('qty', "qty+$qty1", FALSE);
			$this->db->where('pid', $key);
			$this->db->update('geopos_products');		
		}
		
		$this->db->set('pending_qty', "pending_qty+$qty", FALSE);
		$this->db->where('id', $id);
		$save1 = $this->db->update('geopos_purchase');
			
			
		$inserted_serials = implode(",",$inserted_serial);
		$wupcs = implode(",",$wupc);
		
		if ($chkstatus ==0) {
             $this->aauth->applog("[Serial Number Added] $id ID " . $id, $this->aauth->get_user()->username);
               //$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
				$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
			echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url)); 
				//redirect('purchase/pending');
        } else {
			$exist_serials_err = "(".implode(",",$exist_serials_err).")";
			$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$inserted_serials."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupcs."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
            echo json_encode(array('status' => 'Error', 'message' =>
                $exist_serials_err.$url));
        }
    }
	
	
	public function checkSerialNumberExist($serial){
		$this->db->where("serial",$serial);				
		$query = $this->db->get("geopos_product_serials");
		return $query->num_rows();
	}
	
	public function getProductDetailsByPId($pid){   		
		$this->db->where("pid",$pid);				
		$query = $this->db->get("geopos_products");
		//echo $this->db->last_query(); 
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {									
				$data = $row;
			}			
			return $data;
		}
		return false;
    }

}