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
    var $column_search = array('geopos_purchase.tid', 'geopos_supplier.name', 'geopos_purchase.invoicedate', 'geopos_purchase.total','geopos_purchase.status','geopos_purchase.status,geopos_purchase.type');
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
		//echo $this->db->last_query(); exit;
        return $query->row_array();

    }

    public function purchase_products($id)
    {
        $this->db->select('geopos_purchase_items.*');
		$this->db->select('geopos_products.hsn_code');
        $this->db->from('geopos_purchase_items');
        $this->db->where('geopos_purchase_items.tid', $id);
		$this->db->join('geopos_products', 'geopos_products.pid = geopos_purchase_items.pid', 'left');
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
        //$this->db->select('geopos_purchase.id,geopos_purchase.tid,geopos_purchase.invoicedate,geopos_purchase.invoiceduedate,geopos_purchase.total,geopos_purchase.status,geopos_purchase.items,geopos_supplier.name');
        $this->db->select('geopos_purchase.id,geopos_purchase.tid,geopos_purchase.invoicedate,geopos_purchase.invoiceduedate,geopos_purchase.total,geopos_purchase.status,geopos_purchase.items,geopos_purchase.pending_qty,geopos_supplier.name,geopos_supplier.company,geopos_purchase.type');
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
	
	function get_datatables_marginal()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('geopos_purchase.type',2);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;		
        return $query->result();
    }
	
	function get_datatables_spareparts()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('geopos_purchase.type',3);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;		
        return $query->result();
    }
	
	function get_pending_purchase_order()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('(geopos_purchase.items-geopos_purchase.pending_qty)>',0);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;		
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
		$this->db->select('a.*,b.pid,b.product,b.code,b.qty,b.price,b.tax,b.discount,b.subtotal,b.totaltax,b.totaldiscount,b.product_des,b.unit');		
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
	
	
	public function getPurchaseByIdNew($id){   		
		$this->db->where("id",$id);				
		$query = $this->db->get("geopos_purchase");
		//echo $this->db->last_query(); 
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				if($row->type==3)
                {
                    $row->pitems = $this->getPurchaseComponentItemsByTID($row->id);
                }
                else
                {               
                $row->pitems= $this->getPurchaseItemsByTID($row->id);
                }   				
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
				if(($row->qty-$row->pending_qty)>0){
					$data[] = $row;	
				}
            }
            return $data;
        }
        return false;
    }
	public function getPurchaseComponentItemsByTID($tid){
        $this->db->select('a.*,b.component_name as product_name,b.warehouse_product_code,b.id as component_id');       
        $this->db->from("geopos_purchase_items as a");      
        $this->db->join('tbl_component as b', 'a.pid = b.id', 'LEFT');
        $this->db->where('a.tid',$tid);     
        $query = $this->db->get(); 

        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if(($row->qty-$row->pending_qty)>0){
                    $data[] = $row; 
                }
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
				$data2 = array('product_id'=>$productId,'purchase_pid'=> $productId,'purchase_id'=>$purchase_id,'serial'=>$rows['serialNumber']);
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
							'purchase_pid' => $key,            
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
		$this->db->where("status !=",8);				
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

     public function getComponentDetailsByPId($pid){           
        $this->db->where("id",$pid);               
        $query = $this->db->get("tbl_component");
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
	
	
	
	public function addscan(){
		$productid = $this->input->post('product',true);
		if($productid!=''){
		$jobwork_required = $this->input->post('jobwork_required',true); 
		if($jobwork_required==1){
			$serial_status = 2;
			$serial_status1 = 0;			
		}else{
			$serial_status = 1;
			$serial_status1 = 1;	
		}
		
		$purchaseid = $this->input->post('purchaseid',true);
		$serialno = $this->input->post('serial',true);
		
		$data = array('product_id'=>$productid,
		'purchase_pid' => $productid,
		'purchase_id'=>$purchaseid,
		'status'=>$serial_status,
		'serial'=>$serialno);		
		$this->db->insert('geopos_product_serials',$data);
		
		$insertid = $this->db->insert_id();
		$this->aauth->applog("[Serial Number Added] $insertid ID " . $insertid, $this->aauth->get_user()->username);
		
		$this->db->where('id',$purchaseid);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase');
		
		$this->db->where('tid',$purchaseid);
		$this->db->where('pid',$productid);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase_items');
		
		$this->db->set('qty', "qty+1", FALSE);
		$this->db->where('pid', $productid);
		$this->db->update('geopos_products'); 
				
		
		$array = array(
			'pid' => $productid,
			'serial_id' => $insertid,
			'fwid' => 0,
			'twid' => 1,
			'status'=>$serial_status1,
			'logged_user_id' => $_SESSION['loggedin'],
			'date_created' => date("Y-m-d H:i:s"),
			);
		$this->db->insert('tbl_warehouse_serials',$array);
		$insert_id2 = $this->db->insert_id();
		$this->aauth->applog("[Warehouse Serials Data Added] $insert_id2 ID " . $insert_id2, $this->aauth->get_user()->username);
		
		
		$pdetails = $this->getProductDetailsByPId($productid);
		$wupc = $pdetails->warehouse_product_code;
		$serialnos = $serialno;				
						
		$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$serialnos."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupc."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
			echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url)); 
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	public function addscan_margin(){
		$productid = $this->input->post('pid',true);		
		
		if($productid!=''){
			$jobwork_required = $this->input->post('jobwork_required',true); 
			if($jobwork_required==1){
				$serial_status = 2;
				$serial_status1 = 0;			
			}else{
				$serial_status = 1;
				$serial_status1 = 1;	
			}
			
			$sticker = $this->input->post('sticker',true);
			$purchaseid = $this->input->post('purchaseid',true);
			$imei1 = $this->input->post('imei1',true);
			$imei2 = $this->input->post('imei2',true);
			
			$data = array('product_id'=>$productid,
			'purchase_pid'=>$productid,
			'purchase_id'=>$purchaseid,			
			'sticker'=>$sticker,
			'imei2'=>$imei2,
			'status'=>$serial_status,
			'serial'=>$imei1);		
			$this->db->insert('geopos_product_serials',$data);
			
			$insertid = $this->db->insert_id();
			$this->aauth->applog("[Serial Number Added] $insertid ID " . $insertid, $this->aauth->get_user()->username);
			
			$this->db->where('id',$sticker);
			$this->db->set('status', 2, FALSE);
			$this->db->update('tbl_qc_data');
			//echo $this->db->last_query(); exit;
			
			$this->db->where('id',$purchaseid);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase');
			
			$this->db->where('tid',$purchaseid);
			$this->db->where('pid',$productid);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase_items');
			
			$this->db->set('qty', "qty+1", FALSE);
			$this->db->where('pid', $productid);
			$this->db->update('geopos_products'); 
					
			
			$array = array(
				'pid' => $productid,
				'serial_id' => $insertid,
				'fwid' => 0,
				'twid' => 1,
				'status'=>$serial_status1,
				'logged_user_id' => $_SESSION['loggedin'],
				'date_created' => date("Y-m-d H:i:s"),
				);
			$this->db->insert('tbl_warehouse_serials',$array);
			$insert_id2 = $this->db->insert_id();
			$this->aauth->applog("[Warehouse Serials Data Added] $insert_id2 ID " . $insert_id2, $this->aauth->get_user()->username);
			
			
			$pdetails = $this->getProductDetailsByPId($productid);
			$wupc = $pdetails->warehouse_product_code;
			$serialnos = $serialno;				
							
			$url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
				   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatelebal')."'>
				   <input type='hidden' name='serials' id='serials' value='".$imei1."'>
				   <input type='hidden' name='wupc' id='wupc' value='".$wupc."'>
				   <input type='hidden' name='id' id='id' value='".$insertid."'>
				   <input type='submit' name='submit' value='Lebal'>
				   </form>
				   ";
				echo json_encode(array('status' => 'Success', 'message' =>
					$this->lang->line('ADDED') . $url)); 
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	
	public function component_addscan(){
        $productid = $this->input->post('product',true);
        if($productid!=''){
        $jobwork_required = $this->input->post('jobwork_required',true); 
        if($jobwork_required==1){
            $serial_status = 2;
            $serial_status1 = 0;            
        }else{
            $serial_status = 1;
            $serial_status1 = 1;    
        }
        
        $purchaseid = $this->input->post('purchaseid',true);
        $serialno = $this->input->post('serial',true);
        
        $data = array('component_id'=>$productid,
        'purchase_id'=>$purchaseid,
        'status'=>$serial_status,
        'serial'=>$serialno);       
        $this->db->insert('tbl_component_serials',$data);
        
        $insertid = $this->db->insert_id();
        $this->aauth->applog("[Component Serial Number Added] $insertid ID " . $insertid, $this->aauth->get_user()->username);
        
        $this->db->where('id',$purchaseid);
        $this->db->set('pending_qty', "pending_qty+1", FALSE);
        $this->db->update('geopos_purchase');
        
        $this->db->where('tid',$purchaseid);
        $this->db->where('pid',$productid);
        $this->db->set('pending_qty', "pending_qty+1", FALSE);
        $this->db->update('geopos_purchase_items');
        
        $this->db->set('qty', "qty+1", FALSE);
        $this->db->where('id', $productid);
        $this->db->update('tbl_component'); 
                
        
       /* $array = array(
            'pid' => $productid,
            'serial_id' => $insertid,
            'fwid' => 0,
            'twid' => 1,
            'status'=>$serial_status1,
            'logged_user_id' => $_SESSION['loggedin'],
            'date_created' => date("Y-m-d H:i:s"),
            );
        $this->db->insert('tbl_warehouse_serials',$array);
        $insert_id2 = $this->db->insert_id();
        $this->aauth->applog("[Warehouse Serials Data Added] $insert_id2 ID " . $insert_id2, $this->aauth->get_user()->username);
        */
        
        $pdetails = $this->getComponentDetailsByPId($productid);
        $wupc = $pdetails->warehouse_product_code;
        $serialnos = $serialno;             
                        
        $url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
               <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
               <input type='hidden' name='serials' id='serials' value='".$serialnos."'>
               <input type='hidden' name='wupc' id='wupc' value='".$wupc."'>
               <input type='submit' name='submit' value='barcode'>
               </form>
               ";
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url)); 
        }else{
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
			
	public function getUniquePurchaseProduct(){
		$term = $this->input->post('term');
		$this->db->like('product', $term);
		$this->db->group_by('pid');
		$query = $this->db->get("geopos_purchase_items");
		//echo $this->db->last_query(); 
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {									
				$data[] = $row;
			}			
			return $data;
		}
		return false;
	}
	
	public function getProductDetailsByName($product_name){
		$this->db->where('product',$product_name);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get("geopos_purchase_items");
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
	
	public function getSerialDetailsById($id){
		$this->db->select('a.*,b.product_name,c.tid,d.qc_engineer,d.sticker_no');
        $this->db->from('geopos_product_serials as a');
		$this->db->join('geopos_products as b', 'b.pid = a.product_id', 'left');
        $this->db->join('geopos_purchase as c', 'c.id = a.purchase_id', 'left');        
        $this->db->join('tbl_qc_data as d', 'd.id = a.sticker', 'left'); 
		$this->db->where("a.id",$id);
		$this->db->where("a.status !=",8);
        $query = $this->db->get();		
		return $query->result();
	}

    public function getSupplier()
    {
        $data = array();
        $this->db->select("b.*");
        $this->db->from("geopos_purchase as a");
        $this->db->join("geopos_supplier as b","a.csd=b.id","left");
        $this->db->group_by("a.csd");
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getpoBySupplier($supplier_id)

    {   
        $data = array();
        $this->db->select("a.*,b.company as supplier_name");
        $this->db->from("geopos_purchase as a");
        $this->db->join("geopos_supplier as b","a.csd=b.id",'left');
        $this->db->where("csd",$supplier_id);
        $this->db->where("type!=",3);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
              
              $data[] = $row;
            }
            
            return $data;
        } 

    }
	
	public function getspoBySupplier($supplier_id)
    {   
        $data = array();
        $this->db->select("a.*,b.company as supplier_name");
        $this->db->from("geopos_purchase as a");
        $this->db->join("geopos_supplier as b","a.csd=b.id",'left');
        $this->db->where("csd",$supplier_id);
        $this->db->where("a.type",3);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
              
              $data[] = $row;
            }
            
            return $data;
        }
    }

    public function getItemByInvoice($invoice_id)
    {
        $data=array(); 
        $this->db->select("*");
        $this->db->from("geopos_purchase_items");
        $this->db->where("geopos_purchase_items.tid",$invoice_id);
        
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

    public function getItemDetail($product_id)
    {  
        //$data = array();
        $this->db->select("a.qty,a.id,b.warehouse_product_code,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.product_name,brand.title as brand_name");
        $this->db->from("geopos_purchase_items as a");
        $this->db->join("geopos_products as b","a.pid=b.pid",'left');
        $this->db->join("geopos_products as bb",'b.sub=bb.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','b.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','b.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','b.vc=d.id','LEFT');
        $this->db->where("a.id",$product_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        return 0;
    }

    public function receive_good_add($purchase_id,$supplier_id,$product_id,$qty)
    {
        $data = array(
            'purchase_id' => $purchase_id,
            'supplier_id' => $supplier_id,
            'pid'         => $product_id,
            'qty'         => $qty,
            'date_created' => date('Y-m-d h:i:s')
        );

        if($this->db->insert('tbl_recieve_purchase',$data))
        {
            redirect('purchase/receive_good');
        }
        else
        {
            return "Error : Data Not Add";
        }
    }

    public function recive_good_po_list($purchase_id='')
    {
        $data = array();

        $this->db->select("a.*,sum(a.qty) as receive_qty, s.name,p.product,p.qty as total_qty,b.tid,b.type,c.pcat,c.pid as product_id,cat.title as cat_name");
        $this->db->from("tbl_recieve_purchase as a");
        $this->db->join("geopos_purchase as b","a.purchase_id=b.id",'left');
        $this->db->join("geopos_products as c","a.pid=c.pid",'left');
        $this->db->join("geopos_product_cat as cat","c.pcat=cat.id",'left');
        $this->db->join("geopos_supplier as s","a.supplier_id=s.id",'left');
        $this->db->join("geopos_purchase_items as p","a.pid=p.id",'left');
        if($purchase_id!='')
        {
            $this->db->where('a.purchase_id',$purchase_id);
        }
        $this->db->group_by('a.purchase_id');
        $query = $this->db->get();
		//echo $this->db->last_query();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }

        public function recive_good_po_list_park($purchase_id='')
    {
        $data = array();

        $this->db->select("a.*,sum(a.qty) as receive_qty, s.name,p.product,p.qty as total_qty,b.tid,b.type,c.pcat,cat.title as cat_name");
        $this->db->from("tbl_recieve_purchase as a");
        $this->db->join("geopos_purchase as b","a.purchase_id=b.id",'left');
        $this->db->join("geopos_products as c","a.pid=c.pid",'left');
        $this->db->join("geopos_product_cat as cat","c.pcat=cat.id",'left');
        $this->db->join("geopos_supplier as s","a.supplier_id=s.id",'left');
        $this->db->join("geopos_purchase_items as p","a.pid=p.id",'left');
        if($purchase_id!='')
        {
            $this->db->where('a.purchase_id',$purchase_id);
        }
        $this->db->group_by('a.purchase_id');
        $query = $this->db->get();
        $get_current_receive_status['qty'] = 0;
        $total_qty = array();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $get_current_receive_status = $this->current_receve_goods_qc_qty($row->purchase_id,$row->supplier_id,$row->pid);
                
                 
                 if($get_current_receive_status['qty']<$row->receive_qty)
                 {

                  $data['total_qty'][] = $row->receive_qty-$get_current_receive_status['qty'];
                  $data['list'][] = $row;
                  }

            }
            return $data;
        }
    }

    public function getReveiveGoods($purchase_id='',$pid)
    {   
        $total = 0;  
        $this->db->select("sum(qty) as received_qty");
        $this->db->from("tbl_recieve_purchase");
        if($purchase_id!='')
        {
        $this->db->where("purchase_id",$purchase_id);
        }
        $this->db->where("pid",$pid);
        $query = $this->db->get();
       
        if($query->num_rows()>0)
        {
            $result = $query->result_array();
            $total = $result[0]['received_qty'];
        }
        return $total;
    }


    public function goods_product_send_jobwork($supplier_id,$jobwork_purchase_id,$jobwork_pid,$jobwork_varient_type,$jobwork_color_name,$jobwork_zupc_code,$current_grade,$sticker_no,$serial_no1,$qc_engineer,$final_grade,$imei_2,$items,$jobwork_product_name,$jobwork_brand_name)
    {
        $insert_data = array();
      
       $get_current_receive_status = $this->current_receve_goods_qc_qty($jobwork_purchase_id,$supplier_id,$jobwork_pid);
       
       
       if($get_current_receive_status['rows']==0)
       {

         $this->receve_goods_qc_qty($jobwork_purchase_id,$supplier_id,$jobwork_pid,count($sticker_no));
       }
       else
       {
         $total_qty = $get_current_receive_status['qty']+count($sticker_no);
         $this->update_receve_goods_qc_qty($jobwork_purchase_id,$supplier_id,$jobwork_pid,$total_qty);
       }
       
       for($i=0;$i<count($sticker_no);$i++)
       {
        switch($current_grade[$i])
        {
            case 1 : $current_condition = 'Ok';
            break;
            case 2 : $current_condition = 'Good';
            break;
            case 3 : $current_condition = 'Super';
        }
        switch($final_grade[$i])
        {
            case 1 : $final_condition = 'Ok';
            break;
            case 2 : $final_condition = 'Good';
            break;
            case 3 : $final_condition = 'Super';
        }

        $insert_data1 = array(
         'purchase_id'        => $jobwork_purchase_id,
         'sticker_no'         => $sticker_no[$i],
         'product_label_name' => $jobwork_product_name,
         'brand'              => $jobwork_brand_name,
         'varient'            => $jobwork_varient_type,
         'colour'             => $jobwork_color_name, 
         'product_condition'  => $current_condition,
         'imei1'              => $serial_no1[$i],
         'imei2'              => $imei_2[$i],
         'item_replaced'      => $items[$i],
         'qc_engineer'        => $qc_engineer[$i],
         'date_created'       => date("Y-m-d H:i:s"),
         'status'             => 1,
         'logged_user_id'     => $_SESSION['loggedin'] 
         );
        $this->db->insert("tbl_qc_data",$insert_data1);
		
		
		
		
		$insert_data2 = array(
         'product_id'        => $jobwork_pid,
		 'purchase_pid'      => $jobwork_pid,
         'purchase_id'       => $jobwork_purchase_id,
         'serial'            => $serial_no1[$i],
         'imei2'             => $imei_2[$i],
         'status'            => 2,
         'sticker'           => $sticker_no[$i],
         'current_condition' => $current_grade[$i],
         'convert_to'        => $final_grade[$i]
        );
        $this->db->insert("geopos_product_serials",$insert_data2);
        $serial_id = $this->db->insert_id();

        $warehouse = array(
         'pid'            => $jobwork_pid,
         'serial_id'      => $serial_id,
         'invoice_id'     => $jobwork_purchase_id,
         'fwid'           => 0,
         'twid'           => 1,
         'logged_user_id' => $_SESSION['loggedin'],
         'date_created'   => date('Y-m-d H:i:s'),
         'status'         => 0
         );
        $this->db->insert("tbl_warehouse_serials",$warehouse);
		
		$this->db->where('id',$jobwork_purchase_id);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase');
		
		$this->db->where('tid',$jobwork_purchase_id);
		$this->db->where('pid',$jobwork_pid);
		$this->db->set('pending_qty', "pending_qty+1", FALSE);
		$this->db->update('geopos_purchase_items');
		
		$this->db->set('qty', "qty+1", FALSE);
		$this->db->where('pid', $jobwork_pid);
		$this->db->update('geopos_products'); 
        
       }

     redirect('purchase/park_goods');       
        
    }

    public function goods_product_send_warehouse($supplier_id,$purchase_id,$pid,$varient_type,$color_name,$zupc_code,$current_grade,$sticker_no,$serial_no1,$final_grade,$imei_2,$product_name,$brand_name)
    {
         $insert_data = array();
      
       $get_current_receive_status = $this->current_receve_goods_qc_qty($purchase_id,$supplier_id,$pid);
       
       
       if($get_current_receive_status['rows']==0)
       {

         $this->receve_goods_qc_qty($purchase_id,$supplier_id,$pid,count($sticker_no));
       }
       else
       {
         $total_qty = $get_current_receive_status['qty']+count($sticker_no);
         $this->update_receve_goods_qc_qty($purchase_id,$supplier_id,$pid,$total_qty);
       }
       
       for($i=0;$i<count($sticker_no);$i++)
       {

        $insert_data1 = array(
         'product_id'        => $pid,
         'purchase_pid'      => $pid,
         'purchase_id'       => $purchase_id,
         'serial'            => $serial_no1[$i],
         'imei2'             => $imei_2[$i],
         'status'            => 1,
         'sticker'           => $sticker_no[$i],
         'current_condition' => $current_grade[$i],
         'convert_to'        => $final_grade[$i]
        );
        $this->db->insert("geopos_product_serials",$insert_data1);
        $serial_id = $this->db->insert_id();

        $warehouse = array(
         'pid'            => $pid,
         'serial_id'      => $serial_id,
         'invoice_id'     => $purchase_id,
         'fwid'           => 0,
         'twid'           => 1,
         'logged_user_id' => $_SESSION['loggedin'],
         'date_created'   => date('Y-m-d H:i:s'),
         'status'         => 1
         );
        $this->db->insert("tbl_warehouse_serials",$warehouse);
        
       }

     redirect('purchase/park_goods');
    }
    
   public function receve_goods_qc_qty($purchase_id,$supplier_id,$pid,$qty)
   {

    $data = array(
     'purchase_id' => $purchase_id,
     'supplier_id' => $supplier_id,
     'product_id'  => $pid,
     'qc_qty'      => $qty,
     'date_created'=> date("Y-m-d H:i:s")    
    );
    

    $this->db->insert("tbl_receve_goods_qc_qty",$data);
    

   }
   
   public function current_receve_goods_qc_qty($purchase_id,$supplier_id,$pid)
   {
    
    $this->db->select('*');
    $this->db->from("tbl_receve_goods_qc_qty");
    $this->db->where('purchase_id',$purchase_id);
    $this->db->where('supplier_id',$supplier_id);
    $this->db->where('product_id',$pid);

    $query = $this->db->get();
    $rows = $query->num_rows();  
    
    $qty = $query->result_array();
    
    $data = array(
     'qty' => $qty[0]['qc_qty'],
     'rows' => $rows
    );
    return $data;
    
   }

   public function update_receve_goods_qc_qty($purchase_id,$supplier_id,$pid,$qty)
   {
     $data = array(
     'qc_qty'      => $qty,
     'date_modified'=> date("Y-m-d H:i:s")    
    );
    
    $this->db->set($data);
    $this->db->where('purchase_id',$purchase_id);
    $this->db->where('supplier_id',$supplier_id);
    $this->db->where('product_id',$pid);
    $this->db->update("tbl_receve_goods_qc_qty");
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
	
	public function getvarient($purchase_item_id)
	{  
        //$data = array();
        $this->db->select("a.qty,a.id,b.warehouse_product_code,b.pid as product_id,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.pid as varient_pid,bb.product_name,bb.vb as varient_id,brand.title as brand_name");
        $this->db->from("geopos_purchase_items as a");
        $this->db->join("geopos_products as b","a.pid=b.pid",'left');
        $this->db->join("geopos_products as bb",'bb.sub=b.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','bb.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','bb.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','bb.vc=d.id','LEFT');
       
        $this->db->where("a.id",$purchase_item_id);
        $this->db->group_by("bb.vb");
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
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
	
	public function getsvarient($purchase_item_id)
    {  
		//$data = array();
		$this->db->select("a.qty,a.id,b.warehouse_product_code,b.id as product_id");
		$this->db->from("geopos_purchase_items as a");
		$this->db->join("tbl_component as b","a.pid=b.id",'left');	   
		$this->db->where("a.id",$purchase_item_id);		
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
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
	 
	 
	 
	 public function getvarientcolor($purchase_item_id,$product_id,$varient_id)
    {  
        //$data = array();
        $this->db->select("a.qty,a.id,b.warehouse_product_code,b.pid as product_id,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.pid as varient_pid,bb.product_name,bb.vb as varient_id,bb.colour_id,brand.title as brand_name");
        $this->db->from("geopos_purchase_items as a");
        $this->db->join("geopos_products as b","a.pid=b.pid",'left');
        $this->db->join("geopos_products as bb",'bb.sub=b.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','bb.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','bb.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','bb.vc=d.id','LEFT');
       
        $this->db->where("a.id",$purchase_item_id);
        $this->db->where("bb.sub",$product_id);
        $this->db->where("bb.vb",$varient_id);
        $this->db->group_by("bb.colour_id");
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
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
	
	public function goods_product_send_jobwork_new()
    {
		$data_type = $this->input->post('data_type');
		$jobwork_required = $this->input->post('jobwork_required');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_ids = $this->input->post('purchase_item_id');
		$id_array = explode('-',$purchase_item_ids);
		$purchase_item_id = $id_array[0];
		
		$zupc_code = $this->input->post('zupc_code');
		$varient_ids = $this->input->post('varient_id');
		$sticker_no = $this->input->post('sticker_no');
		$serial_no1 = $this->input->post('serial_no1');
		$current_grade = $this->input->post('current_grade');
		$qc_engineer = $this->input->post('qc_engineer');
		$color_id = $this->input->post('color_id');
		$imei_2 = $this->input->post('imei_2');
		$final_grade = $this->input->post('final_grade');
		$items_array = $this->input->post('items');
		$items = implode(',',$items_array);
		
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
		
		$product_info = $this->getProductInfo($purchase_item_id,$product_id,$varient_id,$current_grade,$color_id);
		$jobwork_brand_name = $product_info[0]->brand_name;
		$jobwork_varient_type = $product_info[0]->unit_name;
		$jobwork_color_name = $product_info[0]->colour_name;
		//$current_condition = $product_info[0]->condition_type;		
		
		$condition_record = $this->getConditionNamebyID($current_grade);
		$current_condition = $condition_record->name;
		
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
		 'sticker_no'         => $sticker_no,
		 'product_label_name' => $jobwork_product_name,
		 'brand'              => $jobwork_brand_name,
		 'varient'            => $jobwork_varient_type,
		 'colour'             => $jobwork_color_name, 
		 'product_condition'  => $current_condition,
		 'imei1'              => $serial_no1,
		 'imei2'              => $imei_2,
		 'item_replaced'      => $items,
		 'qc_engineer'        => $qc_engineer,
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
		 'sticker'           => $sticker_no,
		 'current_condition' => $current_grade,
		 'convert_to'        => $final_grade
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
	

    public function goods_product_send_warehouse_new()
    {
		$data_type = $this->input->post('data_type');		
		$jobwork_required = $this->input->post('jobwork_required');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_id = $this->input->post('purchase_item_id');
		$zupc_code = $this->input->post('zupc_code');
		$varient_ids = $this->input->post('varient_id');
		$sticker_no = $this->input->post('sticker_no');
		$serial_no1 = $this->input->post('serial_no1');
		$current_grade = $this->input->post('current_grade');
		$qc_engineer = $this->input->post('qc_engineer');
		$color_id = $this->input->post('color_id');
		$imei_2 = $this->input->post('imei_2');
		
		
		$purchase_item_id_array = explode('-',$purchase_item_id);
		$product_id = $purchase_item_id_array[1]; 
		//echo $varient_ids; exit;
		if($varient_ids!=''){
			$varient_array = explode('-',$varient_ids);
			$product_id = $varient_array[1];
			$varient_id = $varient_array[2];
			$varient_pid = $varient_array[3];
		}
		
		$get_current_receive_status = $this->current_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id);

		if($get_current_receive_status['rows']==0)
		{
			$this->receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,count($sticker_no));
		}
		else
		{
			$total_qty = $get_current_receive_status['qty']+count($sticker_no);
			$this->update_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,$total_qty);
		}

		
			$insert_data1 = array(
			'product_id'        => $product_id,
			'purchase_pid'      => $product_id,
			'purchase_id'       => $purchase_id,
			'serial'            => $serial_no1,
			'imei2'             => $imei_2,
			'status'            => 7,
			'sticker'           => $sticker_no,
			'current_condition' => $current_grade			
			);
			
		$this->db->insert("geopos_product_serials",$insert_data1);		
		$serial_id = $this->db->insert_id();

		$warehouse = array(
			'pid'            => $product_id,
			'serial_id'      => $serial_id,
			'invoice_id'     => $purchase_id,
			'fwid'           => 0,
			'twid'           => 1,
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
	
	public function goods_product_send_saparepat_warehouse(){
		$data_type = $this->input->post('data_type');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_id = $this->input->post('purchase_item_id');
		$qty = $this->input->post('qty');
		$serial_no1 = $this->input->post('serial_no1');
		
		for($i=1; $i<=$qty; $i++){
			$insert_data1 = array(
				'component_id'      => $purchase_item_id,
				'purchase_id'       => $purchase_id,
				'qty'       		=> $qty,
				'serial'            => $serial_no1,			
				'status'            => 1,						
				);
				
			$this->db->insert("tbl_component_serials",$insert_data1); 
		}
		//redirect('purchase/park_goods');
	}
	
	public function getProductInfo($purchase_item_id='',$product_id='',$varient_id='',$condition_id='',$color_id=''){
		$this->db->select("a.qty,a.id,b.warehouse_product_code,b.pid as product_id,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.pid as varient_pid,bb.product_name,bb.vb as varient_id,bb.colour_id,brand.title as brand_name,e.tid,e.type");
        $this->db->from("geopos_purchase_items as a");       
        $this->db->join("geopos_purchase as e","e.id=a.tid",'left');
        $this->db->join("geopos_products as b","a.pid=b.pid",'left');
        $this->db->join("geopos_products as bb",'bb.sub=b.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','bb.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','bb.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','bb.vc=d.id','LEFT');
       
		if($purchase_item_id)
        $this->db->where("a.id",$purchase_item_id);
		if($product_id)
        $this->db->where("b.pid",$product_id);
		if($varient_id)
        $this->db->where("bb.vb",$varient_id);		
		if($condition_id)
        //$this->db->where("bb.vc",$condition_id);
		if($color_id)
        $this->db->where("bb.colour_id",$color_id);			
	
        $this->db->group_by("bb.colour_id");
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
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
	
	public function getComponentByPid($pid,$vid=''){
		$this->db->select("a.*,b.component_id,b.purchase_id,b.serial,b.issue_id,b.product_serial,b.qty,b.status");
        $this->db->from("tbl_component as a");       
        $this->db->join("tbl_component_serials as b","b.component_id=a.id",'left');
		$this->db->group_by('a.component_name');
		
        $this->db->where("a.product_id",$pid);
		if($vid)
        $this->db->or_where("a.product_id",$vid);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;        
        return $query->result_array();
	}
	
	public function getComponentById($id){		
        $this->db->where("id",$id);
        $query = $this->db->get('tbl_component');
        //echo $this->db->last_query(); exit;
        $data = array();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data = $row;
            }
            return $data;
        }
	}
	
	public function getConditionNamebyID($id){
		$this->db->where('id',$id);
		$query = $this->db->get('geopos_conditions');
		$data = array();
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
            {
                $data = $row;
            }
            return $data;
		}
	}
	
	public function scanapi($purchaseid){
		
		$product_details = $this->getPurchaseItemsByID($purchaseid);
		
		foreach($product_details as $key=>$row){
			$productid = $row->pid;	
		
		for($i=1; $i<=$row->qty; $i++){
		
		if($productid!=''){
		$jobwork_required = 2; 
		if($jobwork_required==1){
			$serial_status = 2;
			$serial_status1 = 0;			
		}else{
			$serial_status = 7;
			$serial_status1 = 1;	
		}		
		
			//$serialno = time().$purchaseid.$key.$i;		
			$serialno = $this->generateSerial($purchaseid,$key,$i);
			$data = array('product_id'=>$productid,
			'purchase_pid' => $productid,
			'purchase_id'=>$row->purchase_id,
			'status'=>$serial_status,
			'serial'=>$serialno);		
			$this->db->insert('geopos_product_serials',$data);
			
			$insertid = $this->db->insert_id();
			$this->aauth->applog("[Serial Number Added] $insertid ID " . $insertid, $this->aauth->get_user()->username);
			
			$this->db->where('id',$row->purchase_id);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase');
			
			$this->db->where('tid',$row->purchase_id);
			$this->db->where('pid',$productid);
			$this->db->set('pending_qty', "pending_qty+1", FALSE);
			$this->db->update('geopos_purchase_items');
			
			$this->db->set('qty', "qty+1", FALSE);
			$this->db->where('pid', $productid);
			$this->db->update('geopos_products'); 
					
			
			$array = array(
				'pid' => $productid,
				'serial_id' => $insertid,
				'fwid' => 0,
				'twid' => 1,
				'status'=>$serial_status1,
				'logged_user_id' => $_SESSION['loggedin'],
				'date_created' => date("Y-m-d H:i:s"),
				);
			$this->db->insert('tbl_warehouse_serials',$array);
			$insert_id2 = $this->db->insert_id();
			$this->aauth->applog("[Warehouse Serials Data Added] $insert_id2 ID " . $insert_id2, $this->aauth->get_user()->username);
			
			
			$pdetails = $this->getProductDetailsByPId($productid);
			$wupc = $pdetails->warehouse_product_code;
			$serialnos = $serialno;	
		
		
						
		/* $url = "<a href='" . base_url('purchase/pending') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>
			   <form name='barcode' id='barcode' method='post' action='".base_url('purchase/generatebarcode')."'>
			   <input type='hidden' name='serials' id='serials' value='".$serialnos."'>
			   <input type='hidden' name='wupc' id='wupc' value='".$wupc."'>
			   <input type='submit' name='submit' value='barcode'>
			   </form>
			   ";
			echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url));  */
		}else{
			/* echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR'))); */
		} } }
		
		
		echo json_encode(array('status' => 'Success', 'message' =>$this->lang->line('ADDED'))); 
		
	}	
	
	
	public function generateSerial($purchaseid,$key,$i){		
		$serial_no1 =  time().$purchaseid.$key.$i;
		$query = $this->db->query("select * from geopos_product_serials where serial='".$serial_no1."'");
		if($query->num_rows()==0)
		{		
			return $serial_no1;
		}else{
			$key = $key+1;
			$this->generateSerial($purchaseid,$key,$i);
		}
	}	
	
	public function getPurchaseItemsByID($id){
		$this->db->select('b.*,a.id as purchase_id,c.product_name,c.warehouse_product_code');		
		$this->db->from("geopos_purchase as a");		
		$this->db->join('geopos_purchase_items as b', 'a.id = b.tid', 'LEFT');
		$this->db->join('geopos_products as c', 'b.pid = c.pid', 'LEFT');
		$this->db->where('a.tid',$id);		
		$query = $this->db->get();
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				if(($row->qty-$row->pending_qty)>0){
					$data[] = $row;	
				}
            }
            return $data;
        }
        return false;
    }
	
	public function remove_duplicate_serial(){		
		$query = $this->db->get('geopos_product_serials');
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
            {						
				$serialno = $this->generate_serial2($row->serial);
				if($serialno){
					$this->db->set('serial', $serialno, FALSE);
					$this->db->where('id', $row->id);
					$this->db->update('geopos_product_serials');
					//echo $this->db->last_query();
				}				
            }           
		}		
	}
	
	public function generate_serial2($serialno){		
		$this->db->where('serial',$serialno);
		$query = $this->db->get('geopos_product_serials');	
		
		if($query->num_rows()>1){
			$i=1;
			return $serialno = $i.$serialno;
			//$this->generate_serial2($serialno);
		}else{
			return $serialno;			
		}
	}
	
	
	public function goods_product_send_praxo()
    {
		$data_type = $this->input->post('data_type');
		$jobwork_required = $this->input->post('jobwork_required');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_ids = $this->input->post('purchase_item_id');
		$id_array = explode('-',$purchase_item_ids);
		$purchase_item_id = $id_array[0];
		
		$zupc_code = $this->input->post('zupc_code');
		$varient_ids = $this->input->post('varient_id');
		$sticker_no = $this->input->post('sticker_no');
		$serial_no1 = $this->input->post('serial_no1');
		$current_grade = $this->input->post('current_grade');
		$qc_engineer = $this->input->post('qc_engineer');
		$color_id = $this->input->post('color_id');
		$imei_2 = $this->input->post('imei_2');
		$final_grade = $this->input->post('final_grade');
		/* $items_array = $this->input->post('items');
		$items = implode(',',$items_array); */
		
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
		
		$product_info = $this->getProductInfo($purchase_item_id,$product_id,$varient_id,$current_grade,$color_id);
		$jobwork_brand_name = $product_info[0]->brand_name;
		$jobwork_varient_type = $product_info[0]->unit_name;
		$jobwork_color_name = $product_info[0]->colour_name;
		//$current_condition = $product_info[0]->condition_type;		
		
		$condition_record = $this->getConditionNamebyID($current_grade);
		$current_condition = $condition_record->name;
		
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

		$data1 = array(            
			'teamlead_id' => 39,
			'serial' => $serial_no1,
			'status' => 1,
			'change_status' => 1,
			'final_qc_status' => 1,
			'assign_engineer' => $qc_engineer,
			'batch_number' => date('Y-m-d'),
			'type' => 0
		);			
		$this->db->insert('tbl_jobcard',$data1);

		$insert_data = array(
		 'purchase_id'        => $purchase_id,
		 'sticker_no'         => $sticker_no,
		 'product_label_name' => $jobwork_product_name,
		 'brand'              => $jobwork_brand_name,
		 'varient'            => $jobwork_varient_type,
		 'colour'             => $jobwork_color_name, 
		 'product_condition'  => $current_condition,
		 'imei1'              => $serial_no1,
		 'imei2'              => $imei_2,
		 //'item_replaced'      => $items,
		 'qc_engineer'        => $qc_engineer,
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
		 'status'            => 6,
		 'sticker'           => $sticker_no,
		 'current_condition' => $current_grade,
		 'convert_to'        => $final_grade
		);
		$this->db->insert("geopos_product_serials",$insert_data1);
		$serial_id = $this->db->insert_id();

		$warehouse = array(
		 'pid'            => $product_id,
		 'serial_id'      => $serial_id,
		 'invoice_id'     => $purchase_id,
		 'fwid'           => 0,
		 'twid'           => 1,
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
	
	public function add_recieve_goods()
    {		
		/*[product_type1] => 1
		[jobwork_required] => 1
		[purchase_id] => 13
		[varient_id] => 1715-640-14-641
		[serial_no1] => 3532501178092631
		[supplier_id] => 5
		[purchase_item_id] => 1715-640
		[color_id] => 28-
		[serial_no2] => 3532501178092632 */
		
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
	
	
	public function add_recieve_goods_warehouse()
    {		
		/*[product_type1] => 1
		[jobwork_required] => 1
		[purchase_id] => 13
		[varient_id] => 1715-640-14-641
		[serial_no1] => 3532501178092631
		[supplier_id] => 5
		[purchase_item_id] => 1715-640
		[color_id] => 28-
		[serial_no2] => 3532501178092632 */
		
		
		$data_type = $this->input->post('product_type1');		
		$jobwork_required = $this->input->post('jobwork_required');
		$supplier_id = $this->input->post('supplier_id');
		$purchase_id = $this->input->post('purchase_id');
		$purchase_item_id = $this->input->post('purchase_item_id');
		//$zupc_code = $this->input->post('zupc_code');
		$varient_ids = $this->input->post('varient_id');
		//$sticker_no = $this->input->post('sticker_no');
		$serial_no1 = $this->input->post('serial_no1');
		//$current_grade = $this->input->post('current_grade');
		//$qc_engineer = $this->input->post('qc_engineer');
		$color_id = $this->input->post('color_id');
		$imei_2 = $this->input->post('serial_no2');
		
		
		$purchase_item_id_array = explode('-',$purchase_item_id);
		$product_id = $purchase_item_id_array[1]; 
		//echo $varient_ids; exit;
		if($varient_ids!=''){
			$varient_array = explode('-',$varient_ids);
			$product_id = $varient_array[1];
			$varient_id = $varient_array[2];
			$varient_pid = $varient_array[3];
		}
		
		$get_current_receive_status = $this->current_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id);

		if($get_current_receive_status['rows']==0)
		{
			$this->receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,count($sticker_no));
		}
		else
		{
			$total_qty = $get_current_receive_status['qty']+count($sticker_no);
			$this->update_receve_goods_qc_qty($purchase_id,$supplier_id,$product_id,$total_qty);
		}

		
			$insert_data1 = array(
			'product_id'        => $product_id,
			'purchase_pid'      => $product_id,
			'purchase_id'       => $purchase_id,
			'serial'            => $serial_no1,
			'imei2'             => $imei_2,
			'status'            => 7
			//'sticker'           => $sticker_no,
			//'current_condition' => $current_grade			
			);
			
		$this->db->insert("geopos_product_serials",$insert_data1);		
		$serial_id = $this->db->insert_id();

		$warehouse = array(
			'pid'            => $product_id,
			'serial_id'      => $serial_id,
			'invoice_id'     => $purchase_id,
			'fwid'           => 0,
			'twid'           => 1,
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
	
	public function receive_goods()
    {
		$data = array(); 
        $this->db->select("a.status as warehouse_serial_status,
		b.status as product_serial_status,
		b.serial,
		c.tid as purchase_id,
		e.pid,
		e.product_name,
		e.warehouse_product_code,
		f.name as varient,
		g.name as color,
		s.name as supplier_name,
		cat.title as cat_name");
        $this->db->from("tbl_warehouse_serials as a");
        $this->db->join("geopos_product_serials as b","b.id=a.serial_id",'left');
        $this->db->join("geopos_purchase as c","c.id=b.purchase_id",'left');
        $this->db->join("geopos_purchase_items as d","d.tid=c.id",'left');
        $this->db->join("geopos_products as e","e.pid=d.pid",'left');
        $this->db->join("geopos_units as f","f.id=e.vb",'left');
        $this->db->join("geopos_colours as g","g.id=e.vc",'left');       
        $this->db->join("geopos_product_cat as cat","e.pcat=cat.id",'left');
        $this->db->join("geopos_supplier as s","c.csd=s.id",'left');
        
		/* $status_val = array('0'=>2,'1'=>7); 
		$this->db->where_in('b.status',$status_val); */
		
		$twid_val = array('0'=>0,'1'=>1); 
		$this->db->where_in('a.twid',$twid_val);
		
		$this->db->where('a.status !=',0);
		$this->db->where('a.status !=',2);
		$this->db->where('a.status !=',3);
		$this->db->where('a.status !=',8);
		$this->db->where('a.is_present',1);
		
		$this->db->where('b.status !=',8);		
		$this->db->where('a.status !=',0);
		$this->db->where('b.serial !=','');
		
		$this->db->group_by('b.serial');
		$this->db->order_by('a.id','DESC');
		//$this->db->limit(500);
        $query = $this->db->get();
		//echo $this->db->last_query();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }

}