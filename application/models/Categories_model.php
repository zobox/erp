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

class Categories_model extends CI_Model
{
	private $sub_data = array();
	private $parent_data = array();
	public function __construct()
    {		
        parent::__construct();        
        $this->load->model('products_model', 'products');		
    }
	
    public function category_list($type = 0, $rel = 0)
    {
        $query = $this->db->query("SELECT id,title
		FROM geopos_product_cat WHERE c_type='$type' AND rel_id='$rel'
		ORDER BY id DESC");
        return $query->result_array();
    }

	public function category_list_all($type=0, $rel=0,$website_id='',$product=false)
    {   
		if($website_id!=''){
			$this->db->where("website_id",$website_id);
		}
		$this->db->where("c_type",$type);
		$this->db->where("rel_id",$rel);		
		$this->db->order_by("id","asc");		
		$query = $this->db->get("geopos_product_cat");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				if($product==true)
				$row->product = $this->products->getproductByCatId($row->id);
				if($row->rel_id !=0){
					$ptitle = $this->GetParentCatTitleById($row->rel_id);
					$row->name = $row->title;
					$row->title = $ptitle.' &rArr; '.$row->title;					
				}					
				$data[] = $row;
			}			
			return $data;
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
					$row->title = $ptitle.' &rArr; '.$row->title;
				}					
				$data[] = $row;
			}			
			return $data;
		}
		return false;
    }

	public function subcategory_list($type = 0, $rel = 0,$franchise_id=0,$module='',$product=false){   		
		$this->db->where("c_type",$type);		
		$this->db->where("rel_id",$rel);		
		$this->db->order_by("id","asc");		
		$query = $this->db->get("geopos_product_cat");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				if($franchise_id!=0){
					$p1 = $this->plugins->getCatCommision($module,$row->id,$purpose='1',$franchise_id);
					$p2 = $this->plugins->getCatCommision($module,$row->id,$purpose='2',$franchise_id);
					$p3 = $this->plugins->getCatCommision($module,$row->id,$purpose='3',$franchise_id);
					$commission_status = 0;					
					if($p1->commission_status==1 || $p2->commission_status==1 || $p3->commission_status==1){
						$commission_status = 1;
					}					
					$row->commission_status= $commission_status;
				}
				if($product==true){
					$row->product = $this->products->getproductByCatId($row->id);
				}
				$row->child = $this->subcategory_list(1,$row->id,$franchise_id,$module='',$product);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
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
	
	public function GetTitleById($id)
    { 		
		$this->db->where("id",$id);		
		$query = $this->db->get("geopos_product_cat");		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				return $row->title;
			}				
		}
		return false;
    }


    public function warehouse_list()
    {
        $where = '';
		
        if (!BDATA) $where = "WHERE  (loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }


        $query = $this->db->query("SELECT id,title 	FROM geopos_warehouse $where  	ORDER BY id DESC");
        return $query->result_array();
    }
	
	public function warehouse_list2()
    {
        $where = '';


        if (!BDATA) $where = "WHERE  (loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }


        $query = $this->db->query("SELECT id,title
		FROM geopos_warehouse $where 

		ORDER BY id ASC LIMIT 0,1");
        return $query->result_array();
    }

    public function category_stock()
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_product_cat AS c LEFT JOIN ( SELECT geopos_products.pcat,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  $whr GROUP BY geopos_products.pcat ) AS p ON c.id=p.pcat WHERE c.c_type=0");
        return $query->result_array();
    }

    public function category_sub_stock($id = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $whr2 = '';

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty,p.sub_id FROM geopos_product_cat AS c LEFT JOIN ( SELECT geopos_products.sub_id,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  $whr GROUP BY geopos_products.sub_id ) AS p ON c.id=p.sub_id WHERE c.c_type=1 AND c.rel_id='$id'");
        return $query->result_array();
    }
	
	public function category_sub_stock_all()
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $whr2 = '';

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty,p.sub_id FROM geopos_product_cat AS c LEFT JOIN ( SELECT geopos_products.sub_id,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  $whr GROUP BY geopos_products.sub_id ) AS p ON c.id=p.sub_id WHERE c.c_type=1 ");
        return $query->result_array();
    }

    public function warehouse05032021()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) {
            $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc;

            if (BDATA) $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc . ' OR c.loc=0';
        } elseif (!BDATA) {
            $where = ' WHERE  c.loc=0';
        }
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_warehouse AS c LEFT JOIN ( SELECT warehouse,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM  geopos_products GROUP BY warehouse ) AS p ON c.id=p.warehouse  $where");
        return $query->result_array();
    }
	
	
	public function warehouse()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) {
            $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc;

            if (BDATA) $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc . ' OR c.loc=0';
        } elseif (!BDATA) {
            $where = ' WHERE  c.loc=0';
        }
		$where = ' WHERE  c.id=1';
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_warehouse AS c LEFT JOIN ( SELECT warehouse,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM  geopos_products GROUP BY warehouse ) AS p ON c.id=p.warehouse  $where");
        return $query->result_array();
    }
	
	
	public function otherwarehouse25032021($wid='')
    {
		
		$this->db->select('a.*,COUNT(b.pid) AS pc,SUM(c.product_price*b.qty) AS salessum, SUM(c.fproduct_price*b.qty) AS worthsum,SUM(b.qty)as qty');
		$this->db->from("geopos_warehouse as a");		
		$this->db->join('tbl_warehouse_product as b', 'a.id = b.wid', 'left');
		$this->db->join('geopos_products as c', 'b.pid = c.pid', 'left');
		$this->db->where('a.id !=', 1);
		if($wid)
		$this->db->where('a.id', $wid);		
		$this->db->group_by('a.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {						
				$data[] = $row;
			}			
			return $data;
		}
		return false;
    }
	
	
	public function otherwarehouse($wid='')
    {
		//$this->db->select('a.*,COUNT(d.pid) AS pc,SUM(d.product_price*COUNT(c.id)) AS salessum, SUM(d.fproduct_price*COUNT(c.id)) AS worthsum,SUM(COUNT(b.id))as qty');
		$this->db->select('a.*,GROUP_CONCAT((d.product_price)),GROUP_CONCAT(d.fproduct_price),SUM(d.product_price*d.qty) AS salessum, SUM(d.fproduct_price*d.qty) AS worthsum');
		$this->db->from("geopos_warehouse as a");		
		$this->db->join('tbl_warehouse_serials as b', 'a.id = b.twid', 'left');
		$this->db->join('geopos_product_serials as c', 'b.serial_id = c.id', 'left');
		$this->db->join('geopos_products as d', 'd.pid = c.product_id', 'left');
		//$this->db->where('b.status', 1);	
		//$this->db->where('a.id !=', 1);	
		//$this->db->where('c.status !=', 8);	
		if($wid)
		$this->db->where('a.id', $wid);		
		$this->db->group_by('a.id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				$stock_data = $this->getWarehouseStockQty($row->id);
				$row->qty = $stock_data->qty;
				$row->pc = $stock_data->pc;
				$data[] = $row;
			}			
			return $data;
		}
		return false;
    }
	
	
	public function getWarehouseStockQty($wid='')
    {
		//$this->db->select('a.*,COUNT(d.pid) AS pc,SUM(d.product_price*COUNT(c.id)) AS salessum, SUM(d.fproduct_price*COUNT(c.id)) AS worthsum,SUM(COUNT(b.id))as qty');
		$this->db->select('a.*,COUNT(DISTINCT(b.pid))as pc,COUNT(c.product_id)as qty,GROUP_CONCAT((d.product_price)),GROUP_CONCAT(d.fproduct_price),SUM(d.product_price*d.qty) AS salessum, SUM(d.fproduct_price*d.qty) AS worthsum');
		$this->db->from("geopos_warehouse as a");		
		$this->db->join('tbl_warehouse_serials as b', 'a.id = b.twid', 'left');
		$this->db->join('geopos_product_serials as c', 'b.serial_id = c.id', 'left');
		$this->db->join('geopos_products as d', 'd.pid = c.product_id', 'left');
		$this->db->where('b.status', 1);
		$this->db->where('b.is_present', 1);
		$this->db->where('c.status !=', 8);
		//$this->db->where('a.id !=', 1);		
		if($wid)
		$this->db->where('a.id', $wid);		
		$this->db->group_by('a.id');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data = $row;
			}
			return $data;
		}
		return false;
    }
	

    public function cat_ware($id, $loc = 0)
    {
        $qj = '';
        if ($loc) $qj = "AND w.loc='$loc'";
        $query = $this->db->query("SELECT c.id AS cid, w.id AS wid,c.title AS catt,w.title AS watt FROM geopos_products AS p LEFT JOIN geopos_product_cat AS c ON p.pcat=c.id LEFT JOIN geopos_warehouse AS w ON p.warehouse=w.id WHERE
		p.pid='$id' $qj ");
        return $query->row_array();
    }


    public function addnew($cat_name, $cat_desc, $cat_type = 0, $cat_rel = 0)
    {
        if (!$cat_type) $cat_type = 0;
        if (!$cat_rel) $cat_rel = 0;
		//$website_id = $this->input->post('website_id', true);
		$website_id =1;
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'c_type' => $cat_type,
            'website_id' => $website_id,
            'rel_id' => $cat_rel
        );

        if ($cat_type) {
            $url = "<a href='" . base_url('productcategory/add_sub') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory/view?id=' . $cat_rel) . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        } else {
            $url = "<a href='" . base_url('productcategory/add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        }
        
        if ($this->db->insert('geopos_product_cat', $data)) {
            $this->aauth->applog("[Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function addwarehouse($cat_name, $cat_desc, $lid)
    {
        $data = array(
            'title' => $cat_name,            
            'extra' => $cat_desc,
            'loc' => $lid
        );

        if ($this->db->insert('geopos_warehouse', $data)) {
            $this->aauth->applog("[WareHouse Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
               $url = "<a href='" . base_url('productcategory/addwarehouse') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory/warehouse') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($catid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type)
    {
         if (!$cat_rel) $cat_rel = 0;
		 $website_id = $this->input->post('website_id', true);
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'c_type' => $cat_type,
            'website_id' => $website_id,
            'rel_id' => $cat_rel
        );
        $this->db->set($data);
        $this->db->where('id', $catid);
        if ($this->db->update('geopos_product_cat')) {
            if ($cat_type != $old_cat_type && $cat_type && $cat_type) {
                $data = array('pcat' => $cat_rel);
                $this->db->set($data);
                $this->db->where('sub_id', $catid);
                $this->db->update('geopos_products');
            }
            $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editwarehouse($catid, $product_cat_name, $product_cat_desc, $lid)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'loc' => $lid
        );


        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('geopos_warehouse')) {
            $this->aauth->applog("[Warehouse Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function sub_cat($id = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('rel_id', $id);
        $this->db->where('c_type', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sub_cat_curr($id = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('id', $id);
        $this->db->where('c_type', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sub_cat_list($id = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('rel_id', $id);
        $this->db->where('c_type', 1);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result_array();
    }
	
	
	public function getCategoryById($id='')
    {
        $this->db->where('id', $id);
        $this->db->where('c_type', 1);
        $query = $this->db->get('geopos_product_cat');
        $data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {							
				$data = $row;
			}			
			return $data;
		}
		return false;
    }
	
	public function getWarehouseByFranchiseId($franchise_id='')
    {
        $this->db->where('franchise_id', $franchise_id);
       
        $query = $this->db->get('geopos_warehouse');
        $data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {							
				$data = $row;
			}			
			return $data;
		}
		return false;
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
	
	public function savecost($action){		
		$cat = $this->input->post('cat');
		$subcat = $this->input->post('subcat');
		$chk = $this->input->post('chk');		
		$unchk = $this->input->post('unchk');		
		$type = $this->input->post('type');	
		
		$cost = $this->input->post('cost');		
		$good_to_excellent = $this->input->post('good_to_excellent');
		$ok_to_excellent = $this->input->post('ok_to_excellent');
		$superb_to_excellent = $this->input->post('superb_to_excellent');
		$excellent_to_excellent = $this->input->post('excellent_to_excellent');
		
		$cost_array = array();
		$cost_array[] = $good_to_excellent;
		$cost_array[] = $ok_to_excellent;
		$cost_array[] = $superb_to_excellent;
		$cost_array[] = $excellent_to_excellent;
		rsort($cost_array);
		//print_r($cost_array[0]); exit;
		$cost = $cost_array[0];
		
		$data_history = array();
		
		switch($action){
			case 'refurbishment': $base_url = base_url('settings/costlist?action=refurbishment');
								$data = array();
								$data['refurbishment_cost'] = $cost;								
								$data['refurbishment_cost_type'] = $type;								
								$data['refurbishment_good_to_excellent'] = $good_to_excellent;
								$data['refurbishment_ok_to_excellent'] = $ok_to_excellent;
								$data['refurbishment_superb_to_excellent'] = $superb_to_excellent;
								$data['refurbishment_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);
								
								$data_history['refurbishment_cost'] = $cost;								
								$data_history['refurbishment_good_to_excellent'] = $good_to_excellent;
								$data_history['refurbishment_ok_to_excellent'] = $ok_to_excellent;
								$data_history['refurbishment_superb_to_excellent'] = $superb_to_excellent;
								$data_history['refurbishment_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['refurbishment_cost_type'] = $type;
								$whr_cat_cnd = ['refurbishment_cost' => 0];
								break;
								
			case 'packaging' : 	$base_url = base_url('settings/costlist?action=packaging');
								$data = array();
								$data['packaging_cost'] = $cost;								
								$data['packaging_cost_type'] = $type;								
								$data['packaging_good_to_excellent'] = $good_to_excellent;
								$data['packaging_ok_to_excellent'] = $ok_to_excellent;
								$data['packaging_superb_to_excellent'] = $superb_to_excellent;
								$data['packaging_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
								
								$data_history['packaging_cost'] = $cost;								
								$data_history['packaging_good_to_excellent'] = $good_to_excellent;
								$data_history['packaging_ok_to_excellent'] = $ok_to_excellent;
								$data_history['packaging_superb_to_excellent'] = $superb_to_excellent;
								$data_history['packaging_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['packaging_cost_type'] = $type;
								$whr_cat_cnd = ['packaging_cost' => 0];
								break;
								
			case 'salessupport' : $base_url = base_url('settings/costlist?action=salessupport');
								$data = array();
								$data['sales_support'] = $cost;								
								$data['sales_support_type'] = $type;								
								$data['sales_support_good_to_excellent'] = $good_to_excellent;
								$data['sales_support_ok_to_excellent'] = $ok_to_excellent;
								$data['sales_support_superb_to_excellent'] = $superb_to_excellent;
								$data['sales_support_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('sales_support' => $cost, 'sales_support_type' => $type);
								
								$data_history['sales_support'] = $cost;								
								$data_history['sales_support_good_to_excellent'] = $good_to_excellent;
								$data_history['sales_support_ok_to_excellent'] = $ok_to_excellent;
								$data_history['sales_support_superb_to_excellent'] = $superb_to_excellent;
								$data_history['sales_support_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['sales_support_type'] = $type;
								$whr_cat_cnd = ['sales_support' => 0];
								break;
								
			case 'promotion' : 	$base_url = base_url('settings/costlist?action=promotion');
								$data = array();
								$data['promotion_cost'] = $cost;								
								$data['promotion_cost_type'] = $type;								
								$data['promotion_good_to_excellent'] = $good_to_excellent;
								$data['promotion_ok_to_excellent'] = $ok_to_excellent;
								$data['promotion_superb_to_excellent'] = $superb_to_excellent;
								$data['promotion_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
								
								$data_history['promotion_cost'] = $cost;								
								$data_history['promotion_good_to_excellent'] = $good_to_excellent;
								$data_history['promotion_ok_to_excellent'] = $ok_to_excellent;
								$data_history['promotion_superb_to_excellent'] = $superb_to_excellent;
								$data_history['promotion_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['promotion_cost_type'] = $type;
								$whr_cat_cnd = ['promotion_cost'  => 0];
								break;
								
			case 'infra' : 		$base_url = base_url('settings/costlist?action=infra');
								$data = array();
								$data['hindizo_infra'] = $cost;								
								$data['hindizo_infra_type'] = $type;								
								$data['hindizo_infra_good_to_excellent'] = $good_to_excellent;
								$data['hindizo_infra_ok_to_excellent'] = $ok_to_excellent;
								$data['hindizo_infra_superb_to_excellent'] = $superb_to_excellent;
								$data['hindizo_infra_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
								
								$data_history['hindizo_infra'] = $cost;								
								$data_history['hindizo_infra_good_to_excellent'] = $good_to_excellent;
								$data_history['hindizo_infra_ok_to_excellent'] = $ok_to_excellent;
								$data_history['hindizo_infra_superb_to_excellent'] = $superb_to_excellent;
								$data_history['hindizo_infra_excellent_to_excellent'] = $excellent_to_excellent;
								
								$data_history['hindizo_infra_type'] = $type;
								$whr_cat_cnd = ['hindizo_infra' => 0];
								break;
								
			case 'margin' : 	$base_url = base_url('settings/costlist?action=margin');
								$data = array();
								$data['hindizo_margin'] = $cost;								
								$data['hindizo_margin_type'] = $type;								
								$data['hindizo_margin_good_to_excellent'] = $good_to_excellent;
								$data['hindizo_margin_ok_to_excellent'] = $ok_to_excellent;
								$data['hindizo_margin_superb_to_excellent'] = $superb_to_excellent;
								$data['hindizo_margin_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('hindizo_margin' => $cost, 'hindizo_margin_type' => $type);
								
								$data_history['hindizo_margin'] = $cost;								
								$data_history['hindizo_margin_good_to_excellent'] = $good_to_excellent;
								$data_history['hindizo_margin_ok_to_excellent'] = $ok_to_excellent;
								$data_history['hindizo_margin_superb_to_excellent'] = $superb_to_excellent;
								$data_history['hindizo_margin_excellent_to_excellent'] = $excellent_to_excellent;
								
								$data_history['hindizo_margin_type'] = $type;
								$whr_cat_cnd = ['hindizo_margin' => 0];
								break;
		}				
			
		
		if(!isset($subcat) || count($subcat)==0){
			if($cat){					
				//$this->db->set($data);
				
				//Update Cost in Category
				$this->db->where('id', $cat);
				$this->db->update('geopos_product_cat',$data);
								
				//Update Cost in Sub Category	
				$subcat_ids = $this->subcategoryIds_list($cat);				
				foreach($subcat_ids as $key3=>$scid){
					$this->db->where('id', $scid);
					$this->db->where($whr_cat_cnd);
					$this->db->update('geopos_product_cat',$data);					
				}				
				
				//Update Cost in Product
				$this->db->where('pcat', $cat);
				$this->db->where($whr_cat_cnd);
				$this->db->update('geopos_products',$data);	
				
				//Update Cost in History Log
				$data_history['cid'] = $cat;
				$res = $this->db->insert('cost_settings_history', $data_history);
			}
		}
		
		if(count($subcat)>0){
			foreach($subcat as $key=>$cat_id){
				
			}
			
			if(count($chk)==0){
				if(isset($cat_id)){				
					//$this->db->set($data);
					
					//Update Cost in Category
					$this->db->where('id', $cat_id);
					$this->db->update('geopos_product_cat',$data);
					
					//Update Cost in Sub Category
					$subcat_ids = $this->subcategoryIds_list($cat_id);
					foreach($subcat_ids as $key3=>$scid){
						$this->db->where('id', $scid);
						$this->db->where($whr_cat_cnd);
						$this->db->update('geopos_product_cat',$data);	
					}			
					
					//Update Cost in Product
					$this->db->where('pcat', $cat_id);
					$this->db->where($whr_cat_cnd);
					$this->db->update('geopos_products',$data);
					
					//Update Cost in History Log
					$data_history['cid'] = $cat_id;
					$res = $this->db->insert('cost_settings_history', $data_history);
					
					if(is_array($unchk)){		
						foreach($unchk as $key2=>$pid){						
							$this->db->where('pid', $pid);
							$this->db->where($whr_cat_cnd);
							$this->db->update('geopos_products',$data);			
							$data_history['pid'] = $pid;
							$res = $this->db->insert('cost_settings_history', $data_history);
						}
					}
				}
			}
			
			if(is_array($chk)){		
				foreach($chk as $key1=>$pid){				
					$this->db->where('pid', $key1);
					$this->db->update('geopos_products',$data);			
					$data_history['pid'] = $key1;
					$res = $this->db->insert('cost_settings_history', $data_history);
				}
			}	
		}
		
			
		if ($res) {            
			$url = " <a href='" .$base_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . $url));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}		
		
	}
	
	
	public function save_editcost($action,$id){
		$type = $this->input->post('type');		
		//$cost = $this->input->post('cost');
		$good_to_excellent = $this->input->post('good_to_excellent');
		$ok_to_excellent = $this->input->post('ok_to_excellent');
		$superb_to_excellent = $this->input->post('superb_to_excellent');
		$excellent_to_excellent = $this->input->post('excellent_to_excellent');
		
		$cost_array = array();
		$cost_array[] = $good_to_excellent;
		$cost_array[] = $ok_to_excellent;
		$cost_array[] = $superb_to_excellent;
		$cost_array[] = $excellent_to_excellent;
		rsort($cost_array);
		//print_r($cost_array[0]); exit;
		$cost = $cost_array[0];
		
		
		/* switch($action){
			case 'refurbishment' : 	$base_url = base_url('settings/costlist?action=refurbishment');
									$data = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);
									$data_history = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);			
			break;
			case 'packaging' 	: 	$base_url = base_url('settings/costlist?action=packaging');
									$data = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
									$data_history = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
			break;			
			case 'salessupport' :  	$base_url = base_url('settings/costlist?action=salessupport');
									$data = array('sales_support' => $cost, 'sales_support_type' => $type);
									$data_history = array('sales_support' => $cost, 'sales_support_type' => $type);
			break;
			case 'promotion' 	: 	$base_url = base_url('settings/costlist?action=promotion');
									$data = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
									$data_history = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
			break;
			case 'infra' 		: 	$base_url = base_url('settings/costlist?action=infra');
									$data = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
									$data_history = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
			break;
			case 'margin' 		: 	$base_url = base_url('settings/costlist?action=margin');
									$data = array('hindizo_margin' => $cost, 'hindizo_margin_type' => $type);
									$data_history = array('hindizo_margin' => $cost, 'hindizo_margin_type' => $type);
			break;
		} */
		
		switch($action){
			case 'refurbishment': $base_url = base_url('settings/costlist?action=refurbishment');
								$data = array();
								$data['refurbishment_cost'] = $cost;								
								$data['refurbishment_cost_type'] = $type;								
								$data['refurbishment_good_to_excellent'] = $good_to_excellent;
								$data['refurbishment_ok_to_excellent'] = $ok_to_excellent;
								$data['refurbishment_superb_to_excellent'] = $superb_to_excellent;
								$data['refurbishment_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);
								
								$data_history['refurbishment_cost'] = $cost;								
								$data_history['refurbishment_good_to_excellent'] = $good_to_excellent;
								$data_history['refurbishment_ok_to_excellent'] = $ok_to_excellent;
								$data_history['refurbishment_superb_to_excellent'] = $superb_to_excellent;
								$data_history['refurbishment_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['refurbishment_cost_type'] = $type;
								$whr_cat_cnd = ['refurbishment_cost' => 0];
								break;
								
			case 'packaging' : 	$base_url = base_url('settings/costlist?action=packaging');
								$data = array();
								$data['packaging_cost'] = $cost;								
								$data['packaging_cost_type'] = $type;								
								$data['packaging_good_to_excellent'] = $good_to_excellent;
								$data['packaging_ok_to_excellent'] = $ok_to_excellent;
								$data['packaging_superb_to_excellent'] = $superb_to_excellent;
								$data['packaging_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
								
								$data_history['packaging_cost'] = $cost;								
								$data_history['packaging_good_to_excellent'] = $good_to_excellent;
								$data_history['packaging_ok_to_excellent'] = $ok_to_excellent;
								$data_history['packaging_superb_to_excellent'] = $superb_to_excellent;
								$data_history['packaging_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['packaging_cost_type'] = $type;
								$whr_cat_cnd = ['packaging_cost' => 0];
								break;
								
			case 'salessupport' : $base_url = base_url('settings/costlist?action=salessupport');
								$data = array();
								$data['sales_support'] = $cost;								
								$data['sales_support_type'] = $type;								
								$data['sales_support_good_to_excellent'] = $good_to_excellent;
								$data['sales_support_ok_to_excellent'] = $ok_to_excellent;
								$data['sales_support_superb_to_excellent'] = $superb_to_excellent;
								$data['sales_support_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('sales_support' => $cost, 'sales_support_type' => $type);
								
								$data_history['sales_support'] = $cost;								
								$data_history['sales_support_good_to_excellent'] = $good_to_excellent;
								$data_history['sales_support_ok_to_excellent'] = $ok_to_excellent;
								$data_history['sales_support_superb_to_excellent'] = $superb_to_excellent;
								$data_history['sales_support_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['sales_support_type'] = $type;
								$whr_cat_cnd = ['sales_support' => 0];
								break;
								
			case 'promotion' : 	$base_url = base_url('settings/costlist?action=promotion');
								$data = array();
								$data['promotion_cost'] = $cost;								
								$data['promotion_cost_type'] = $type;								
								$data['promotion_good_to_excellent'] = $good_to_excellent;
								$data['promotion_ok_to_excellent'] = $ok_to_excellent;
								$data['promotion_superb_to_excellent'] = $superb_to_excellent;
								$data['promotion_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
								
								$data_history['promotion_cost'] = $cost;								
								$data_history['promotion_good_to_excellent'] = $good_to_excellent;
								$data_history['promotion_ok_to_excellent'] = $ok_to_excellent;
								$data_history['promotion_superb_to_excellent'] = $superb_to_excellent;
								$data_history['promotion_excellent_to_excellent'] = $excellent_to_excellent;								
								
								$data_history['promotion_cost_type'] = $type;
								$whr_cat_cnd = ['promotion_cost'  => 0];
								break;
								
			case 'infra' : 		$base_url = base_url('settings/costlist?action=infra');
								$data = array();
								$data['hindizo_infra'] = $cost;								
								$data['hindizo_infra_type'] = $type;								
								$data['hindizo_infra_good_to_excellent'] = $good_to_excellent;
								$data['hindizo_infra_ok_to_excellent'] = $ok_to_excellent;
								$data['hindizo_infra_superb_to_excellent'] = $superb_to_excellent;
								$data['hindizo_infra_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
								
								$data_history['hindizo_infra'] = $cost;								
								$data_history['hindizo_infra_good_to_excellent'] = $good_to_excellent;
								$data_history['hindizo_infra_ok_to_excellent'] = $ok_to_excellent;
								$data_history['hindizo_infra_superb_to_excellent'] = $superb_to_excellent;
								$data_history['hindizo_infra_excellent_to_excellent'] = $excellent_to_excellent;
								
								$data_history['hindizo_infra_type'] = $type;
								$whr_cat_cnd = ['hindizo_infra' => 0];
								break;
								
			case 'margin' : 	$base_url = base_url('settings/costlist?action=margin');
								$data = array();
								$data['hindizo_margin'] = $cost;								
								$data['hindizo_margin_type'] = $type;								
								$data['hindizo_margin_good_to_excellent'] = $good_to_excellent;
								$data['hindizo_margin_ok_to_excellent'] = $ok_to_excellent;
								$data['hindizo_margin_superb_to_excellent'] = $superb_to_excellent;
								$data['hindizo_margin_excellent_to_excellent'] = $excellent_to_excellent;
								//$data = array('hindizo_margin' => $cost, 'hindizo_margin_type' => $type);
								
								$data_history['hindizo_margin'] = $cost;								
								$data_history['hindizo_margin_good_to_excellent'] = $good_to_excellent;
								$data_history['hindizo_margin_ok_to_excellent'] = $ok_to_excellent;
								$data_history['hindizo_margin_superb_to_excellent'] = $superb_to_excellent;
								$data_history['hindizo_margin_excellent_to_excellent'] = $excellent_to_excellent;
								
								$data_history['hindizo_margin_type'] = $type;
								$whr_cat_cnd = ['hindizo_margin' => 0];
								break;
		}
		
		$this->db->where('id', $id);
		$this->db->update('geopos_product_cat',$data);	
		//echo $this->db->last_query(); exit;
		
		//Update Cost in History Log
		$data_history['cid'] = $id;
		$res = $this->db->insert('cost_settings_history', $data_history);
		
		if ($res) {            
			$url = " <a href='" .$base_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . $url));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}	
	}
	
	
	public function CostCatList($action=''){
		switch($action){
			case 'refurbishment' : $this->db->where('refurbishment_cost !=',0);
			break;
			case 'packaging' : $this->db->where('packaging_cost !=',0);
			break;
			case 'salessupport' : $this->db->where('sales_support !=',0);
			break;
			case 'promotion' : $this->db->where('promotion_cost !=',0);
			break;
			case 'infra' : $this->db->where('hindizo_infra !=',0);
			break;
			case 'margin' : $this->db->where('hindizo_margin !=',0);
			break;
		}
		
		
				
		$query = $this->db->get('geopos_product_cat');		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){	
				$row->parent_name = $this->products_cat->GetParentCatTitleById($row->id);
				$row->products = $this->products->refurbishmentCostProductListByCatId($row->id,$action);
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}
	
	public function subcategoryIds_list($cat_id = 0){
		$this->db->select('id');
		$this->db->where("rel_id",$cat_id);			
		$query = $this->db->get("geopos_product_cat");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				//$data[] =$row->id;
				$this->sub_data[] = $row->id;
			    $this->subcategoryIds_list($row->id);				
			}			
			return $this->sub_data;
		}
		return false;
    }
	
	
	public function parentCategoryIds_list($rel_id = 0){		
		$this->db->where("id",$rel_id);			
		$query = $this->db->get("geopos_product_cat");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$this->parent_data[] = $row->id;
				
				$this->parentCategoryIds_list($row->rel_id);	
				
			}			
			return $this->parent_data;
		}
		return false;
    }
	
	public function getRecordById($id){
		$this->db->where("id",$id);				
		$query = $this->db->get("geopos_product_cat");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->parent_name = $this->GetParentCatTitleById($row->id);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}	
	 
	public function get_warehouseProductById($wid){
		$this->db->select('a.*,COUNT(distinct(b.id))as qty,b.serial_id,c.serial,d.product_name,d.product_code,d.product_price,d.sale_price,d.pid,d.pcat,d.warehouse_product_code,d.zobulk_sale_price,f.title as brand,g.name as varient,h.name as condition, i.name as colour');
		$this->db->from("geopos_warehouse as a");		
		$this->db->join('tbl_warehouse_serials as b', 'a.id = b.twid', 'inner');
		$this->db->join('geopos_product_serials as c', 'b.serial_id = c.id', 'inner');
		$this->db->join('geopos_products as d', 'b.pid = d.pid', 'inner');
		$this->db->join("geopos_sale_price_calculator as e",'d.pid=e.pid','left');
		$this->db->join("geopos_brand as f",'f.id=d.b_id','left');
		$this->db->join("geopos_units as g",'g.id=d.vb','left');
		$this->db->join("geopos_conditions as h",'h.id=d.vc','left');
		$this->db->join("geopos_colours as i",'i.id=d.colour_id','left');
		$this->db->where('b.status', 1);
		$this->db->where('b.is_present', 1);
		$this->db->where('c.status !=', 8);
		//$this->db->where('a.id !=', 1);
		if($wid)
		$this->db->where('b.twid', $wid);		
		$this->db->group_by('d.pid');
		$query = $this->db->get();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {						
				$row->c_title = $this->GetParentCatTitleById($row->pcat);
				$data[] = $row;
			}			
			return $data;
		}
		return false;
		
		/* $this->db->select('a.*,b.qty,c.product_name,c.product_code,c.product_price,c.pid,c.pcat');
		$this->db->from("geopos_warehouse as a");		
		$this->db->join('tbl_warehouse_product as b', 'a.id = b.wid', 'left');
		$this->db->join('geopos_products as c', 'b.pid = c.pid', 'left');
		$this->db->where('a.id !=', 1);
		if($wid)
		$this->db->where('a.id', $wid);
		$this->db->group_by('c.pid');
		$query = $this->db->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->c_title = $this->GetParentCatTitleById($row->pcat);
				$data[] = $row;
			}			
			return $data;
		}
		return false; */
	}
	
	public function save_job_work_cost(){
		$product_name = $this->input->post('product_name');
		$pid = $this->input->post('pid');
		$product_record = $this->products->getRecordsByProductName($product_name);
		
		$component_name = $this->input->post('component_name');
		$ok_to_superb_cost = $this->input->post('ok_to_superb_cost');
		$ok_to_good_cost = $this->input->post('ok_to_good_cost');
		$good_to_good_cost = $this->input->post('good_to_good_cost');
		$good_to_superb_cost = $this->input->post('good_to_superb_cost');
		$good_to_excellant_cost = $this->input->post('good_to_excellant_cost');
		foreach($component_name as $key=>$component){
			$data = array();
			$data['pid'] = $product_record->pid;
			$data['component_name'] = $component;
			$data['ok_to_superb_cost'] = $ok_to_superb_cost[$key];
			$data['ok_to_good_cost'] = $ok_to_good_cost[$key];
			$data['good_to_good_cost'] = $good_to_good_cost[$key];
			$data['good_to_superb_cost'] = $good_to_superb_cost[$key];
			$data['good_to_excellant_cost'] = $good_to_excellant_cost[$key];
			$data['date_created'] = date('Y-m-d H:i:s');
			$data['logged_user_id'] = $_SESSION['id'];
			if($pid!=''){
				$res = $this->db->insert('tbl_jobwork_component',$data);
			}
			//echo $this->db->last_query(); exit; 			
		}
		
		if ($res) {  
			$redirect_url = base_url().'settings/jobworkcostlist?action=refurbishment';
			$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . $url));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
		
	}
	
	
	public function JobWorkCostList(){
		$this->db->group_by('pid');					
		$query = $this->db->get("tbl_jobwork_component");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$row->products = $this->products->getRecordById($row->pid);				
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getjobworkrecordByID($pid){
		$this->db->where('pid',$pid);					
		$query = $this->db->get("tbl_jobwork_component");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$row->products = $this->products->getRecordById($row->pid);				
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function edit_job_work_cost(){			
		$pid = $this->input->post('pid');		
		
		$id = $this->input->post('id');
		$component_name = $this->input->post('component_name');
		$ok_to_superb_cost = $this->input->post('ok_to_superb_cost');
		$ok_to_good_cost = $this->input->post('ok_to_good_cost');
		$good_to_good_cost = $this->input->post('good_to_good_cost');
		$good_to_superb_cost = $this->input->post('good_to_superb_cost');
		$good_to_excellant_cost = $this->input->post('good_to_excellant_cost');
		foreach($component_name as $key=>$component){
			$data = array();
			$data['pid'] = $pid;
			$data['component_name'] = $component;
			$data['id'] = $id[$key];
			$data['ok_to_superb_cost'] = $ok_to_superb_cost[$key];
			$data['ok_to_good_cost'] = $ok_to_good_cost[$key];
			$data['good_to_good_cost'] = $good_to_good_cost[$key];
			$data['good_to_superb_cost'] = $good_to_superb_cost[$key];
			$data['good_to_excellant_cost'] = $good_to_excellant_cost[$key];
			$data['date_created'] = date('Y-m-d H:i:s');
			$data['logged_user_id'] = $_SESSION['id'];
			
			$this->db->where('pid', $pid);
			$this->db->where('id',$id[$key]);					
			$query = $this->db->get("tbl_jobwork_component");		
			if ($query->num_rows() > 0) {			
				if($pid!=''){
					$this->db->set($data);
					$this->db->where('pid', $pid);
					$this->db->where('id',$id[$key]);
					$res = $this->db->update('tbl_jobwork_component');
				}
			}else{
				$res = $this->db->insert('tbl_jobwork_component',$data);
			}
			//echo $this->db->last_query(); exit; 
			
		}
		
		if ($res) {  
			$redirect_url = base_url().'settings/jobworkcostlist?action=refurbishment';
			$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . $url));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
	}
	
	public function pending_requests05052021(){
		$this->db->select('a.*,b.product_name,b.pcat,b.hsn_code,c.item_replaced,c.sticker_no,c.qc_engineer');					
		$this->db->from("geopos_product_serials as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->join("tbl_qc_data as c","a.sticker=c.id","Left");
		$this->db->where('a.status',4);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function pending_requests_serial($product_id)
	{
		$this->db->select("serial,imei2");
		$this->db->where("product_id",$product_id);
		$this->db->where("status",2);
		$query = $this->db->get("geopos_product_serials");

		$data = array();
		$serial = array();
		$imei2  = array();
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
			{
				$serial[] = $row->serial;
				$imei2[] = $row->imei2;
			}
			$data = array_unique(array_merge($serial,$imei2));
			$data = array_values($data);
			
			return $serial;
		}
		return false;
	}
	
	public function pending_requests(){
		$this->db->select('a.*,b.product_name,b.pcat,b.hsn_code');					
		$this->db->from("tbl_jobwork_request as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->where('a.status',1);
		$this->db->order_by('a.id','DESC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
			    //$data['serial_no'][] = $this->pending_requests_serial($row->product_id);
				$row->serial_records = $this->get_serialByjobworkReqId($row->id);
				$data[] = $row;								
			}						
			return $data;
		}
		return false;
	}
	
	public function pending_requestById($id){
		$this->db->select('a.*,b.product_name,b.pcat,b.hsn_code');					
		$this->db->from("tbl_jobwork_request as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->where('a.id',$id);
		$query = $this->db->get();	
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}	
		
	public function generate_isuue11052021(){
		$serial_array = $this->input->post('serial');
		$product_name_array = $this->input->post('product_name');
		$zupc_array = $this->input->post('zupc');
		$component_array = $this->input->post('component');
		$component_qty_array = $this->input->post('component_qty');	
		$request_id = $this->input->post('request_id');	
		
		$data = array();				
		$data['request_id'] = $request_id;		
		$data['date_created'] = date('Y-m-d h:i:s');
		$data['status'] = 1;
		
		$this->db->insert('tbl_jobwork_issue', $data);		
		$inserted_id = $this->db->insert_id();
		
		foreach($serial_array as $key=>$serial){
			$product_name = $product_name_array[$key];
			$zupc = $zupc_array[$key];
			$component = $component_array[$key];			
			$component_qty = $component_qty_array[$key];			
			
			$this->db->set('status', 5, FALSE);
			$this->db->where('serial', $serial);
			$this->db->update('geopos_product_serials');		
					
			$data1 = array();
			$data1['jobwork_issue_id'] = $inserted_id;
			$data1['product_name'] = $product_name;
			$data1['serial'] = $serial;			
			$data1['zupc'] = $zupc;		
			$data1['status'] = 1;	
			$data1['date_created'] = date('Y-m-d h:i:s');		
			
			$this->db->insert('tbl_jobwork_issue_serial', $data1);			
			$inserted_id1 = $this->db->insert_id();
			
			
			
			foreach($component as $key=>$comp){
				$data2 = array();
				$data2['jobwork_issue_serial_id'] = $inserted_id1;
				$data2['component'] = $comp;
				$data2['qty'] = $component_qty[$key];
				$data2['status'] = 1;
				$data2['date_created'] = date('Y-m-d h:i:s');			
				$this->db->insert('tbl_jobwork_issue_component', $data2); 				
			}
		}
		return true;		
	}
	 
	public function manage_requests(){
		$this->db->select('a.request_id,a.id as issue_id,b.*,count(distinct(b.id)) as product_qty,sum(c.qty) as component_qty,c.component');					
		$this->db->from("tbl_jobwork_issue as a");		
		$this->db->join("tbl_jobwork_issue_serial as b","a.id=b.jobwork_issue_id","Left");
		$this->db->join("tbl_jobwork_issue_component as c","b.id=c.jobwork_issue_serial_id","Left");
		$this->db->where('b.status',1);
		$this->db->group_by('a.id');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->serial_records = $this->get_serialByjobworkReqId($row->request_id);
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function assign_jobwork($id){
		$this->db->select('a.request_id,a.id as issue_id,b.*,count(distinct(b.id)) as product_qty,sum(c.qty) as component_qty,c.component');					
		$this->db->from("tbl_jobwork_issue as a");		
		$this->db->join("tbl_jobwork_issue_serial as b","a.id=b.jobwork_issue_id","Left");
		$this->db->join("tbl_jobwork_issue_component as c","b.id=c.jobwork_issue_serial_id","Left");
		$this->db->where('b.status',1);
		$this->db->where('a.id',$id);
		$this->db->group_by('a.id');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function manage_requests07052021(){
		$this->db->select('c.*,sum(d.qty) as component_qty');					
		$this->db->from("tbl_jobwork_issue as c");
		/* $this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->join("tbl_jobwork_issue as c","a.serial=c.serial","Left"); */
		$this->db->join("tbl_jobwork_issue_component as d","c.id=d.jobwork_issue_id","Left");
		//$this->db->where('a.status',5);
		$this->db->group_by('c.id');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function getiemiByIssueId($issue_id){
		$this->db->where('id',$issue_id);
		$query = $this->db->get('tbl_jobwork_issue_serial');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}

	public function getteamlead(){
		$this->db->select('b.*');					
		$this->db->from("geopos_users as a");
		$this->db->join("geopos_employees as b","a.id=b.id","Left");		
		$this->db->where('a.roleid',13);		
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

	public function assignteamlead(){
		$id = $this->input->post('id');
		$iemi = $this->input->post('iemi');		
		$teamlead_id = $this->input->post('teamlead_id');		
		$iemi_array = explode(',',$iemi);		
		$return_status = 0;

		foreach($iemi_array as $key=>$serial){
			$this->db->where('jobwork_issue_id',$id);
			$this->db->where('serial',$serial);
			$query = $this->db->get('tbl_jobwork_issue_serial');
			//echo $this->db->last_query(); exit;
			if($query->num_rows() > 0){
				$this->db->set('status', 2, FALSE);
				$this->db->where('jobwork_issue_id',$id);
				$this->db->where('serial',$serial);
				$this->db->update('tbl_jobwork_issue_serial');

				$this->db->set('status', 6, FALSE);
				$this->db->where('serial', $serial);
				$this->db->update('geopos_product_serials');
				
				$data = array();				
				$data['teamlead_id'] = $teamlead_id;		
				$data['serial'] = $serial;		
				$data['date_created'] = date('Y-m-d h:i:s');
				$data['status'] = 1;
				
				$this->db->insert('tbl_jobcard', $data);
				$return_status = 1;
			}else{
				$return_status = 0;
			}
		}

		if($return_status==1){
			return true;
		}else{
			return false;
		}
	}	
	
	public function checkSerialforScan(){
		$serial_no = $this->input->post('serial_no');
		$product_id = $this->input->post('product_id');
		$this->db->where('serial',$serial_no);
		$this->db->where('product_id',$product_id);
		$this->db->where('status',2);
		$this->db->where('partial_status',1);
		$query = $this->db->get('geopos_product_serials');
		if ($query->num_rows() > 0) {
			return true;
		}else{
			return false;
			/* echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR'))); */
		}
	}
	
	public function getComponentByImei($imei){
		$this->db->where('imei1',$imei);
		$query = $this->db->get('tbl_qc_data');
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data = $row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function getComponentQty($component,$product_id){
		$this->db->select('a.*,count(b.id) as component_qty');					
		$this->db->from("tbl_component as a");
		$this->db->join("tbl_component_serials as b","a.id=b.component_id","Left");		
		$this->db->where('a.component_name',trim($component));
		$this->db->or_where('a.warehouse_product_name',trim($component));
		$this->db->where('a.product_id',$product_id);
		$this->db->where('b.status',1);
		$this->db->group_by('a.component_name');
		$query = $this->db->get();	
		//echo $this->db->last_query(); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function generate_isuue(){		
		$serial_array = $this->input->post('serials');
		$product_id = $this->input->post('product_id');
		$request_id = $this->input->post('id');			
		$product = $this->products->getRecordById($product_id);
		
		$data = array();				
		$data['request_id'] = $request_id;		
		$data['date_created'] = date('Y-m-d h:i:s');
		$data['status'] = 1;
		
		$this->db->insert('tbl_jobwork_issue', $data);		
		$inserted_id = $this->db->insert_id();
		
		foreach($serial_array as $key=>$serial){
			
			$product_name = $product->product_name;
			$zupc = $product->warehouse_product_code;
			$component_record = $this->getComponentByImei($serial);
			$components = $component_record->item_replaced;
			$component_array = explode(',',$components);			
			
			//$component = $component_array[$key];			
			//$component_qty = $component_qty_array[$key];			
			
			$this->db->set('status', 5, FALSE);
			$this->db->where('serial', $serial);
			$this->db->update('geopos_product_serials');		
					
			$data1 = array();
			$data1['jobwork_issue_id'] = $inserted_id;
			$data1['product_name'] = $product_name;
			$data1['serial'] = $serial;			
			$data1['zupc'] = $zupc;		
			$data1['status'] = 1;	
			$data1['date_created'] = date('Y-m-d h:i:s');		
			
			$this->db->insert('tbl_jobwork_issue_serial', $data1);			
			$inserted_id1 = $this->db->insert_id();			
			//print_r($component_array); 
			
			foreach($component_array as $key=>$component){				
				$component_serial_array = $this->getComponentSerial($component,$product_id,2);
				$component_serial_id = $component_serial_array[0]->component_serial_id; 
							
				$data2 = array();
				$data2['jobwork_issue_serial_id'] = $inserted_id1;
				$data2['component'] = $component;
				$data2['qty'] = 1;
				$data2['status'] = 1;
				$data2['date_created'] = date('Y-m-d h:i:s');			
				$this->db->insert('tbl_jobwork_issue_component', $data2); 	

				$this->db->set('status', 3, FALSE);
				$this->db->set('issue_id', $inserted_id, FALSE);
				$this->db->set('product_serial', $serial, FALSE);
				$this->db->where('id', $component_serial_id);
				$this->db->update('tbl_component_serials');
			}
		}
		//exit;
		$this->db->set('status', 2, FALSE);
		$this->db->where('id', $request_id);
		$this->db->update('tbl_jobwork_request');
			
		return $inserted_id;	
	}
	
	
	public function getComponentSerial($component,$product_id,$status){
		$this->db->select('a.*,b.serial,b.id as component_serial_id');					
		$this->db->from("tbl_component as a");
		$this->db->join("tbl_component_serials as b","a.id=b.component_id","INNER");
		$this->db->where('a.component_name',trim($component));		
		$this->db->where('a.product_id',$product_id);		
		$this->db->where('b.status',$status);
		$this->db->or_where('a.warehouse_product_name',$component);		
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getTodayComponentRequirement(){
		$this->db->select('a.*,count(a.component) as component_qty,b.product_name');					
		$this->db->from("tbl_component_required as a");
		$this->db->join("geopos_products as b","a.product_id=b.pid","Left");
		$this->db->group_by('a.component');
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {					
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function savejobwork(){
		$id = $this->input->post('id');
		$final_condition = $this->input->post('final_condition');
		$sub_cat = $this->input->post('sub_cat');
		$sub_sub_cat = $this->input->post('sub_sub_cat');
		$serial = $this->input->post('serial'); 
		
		$this->db->select('id');
		$this->db->where('serial',$serial);
		$this->db->where('status !=',8);
		$res = $this->db->get('geopos_product_serials')->result();	
		$serial_id = $res['0']->id; 
		
		$this->db->set('status',1, FALSE);
		$this->db->set('is_present',1, FALSE);
		$this->db->set('fwid',0, FALSE);
		$this->db->set('twid',1, FALSE);
		$this->db->set('pid',$final_condition, FALSE);
		$this->db->where('serial_id', $serial_id);
		$this->db->update('tbl_warehouse_serials');
		
		$this->db->set('product_id',$final_condition, FALSE);
		$this->db->set('status',7);
		$this->db->where('serial',$serial);
		$this->db->where('status !=',8);
		$this->db->update('geopos_product_serials');
		 
		 
		if($final_condition)
		$this->db->set('final_condition', $final_condition, FALSE);
		if($sub_cat)
		$this->db->set('sub_cat', $sub_cat, FALSE);
		if($sub_sub_cat)
		$this->db->set('sub_sub_cat', $sub_sub_cat, FALSE);
		$this->db->set('logged_user_id',$_SESSION['id'], FALSE);
		$this->db->set('status',2, FALSE);
		$this->db->where('id', $id);
		$this->db->update('tbl_jobcard');
		//echo $this->db->last_query(); exit;
	}


	public function manage_requests_invoice($id)
	{
		$this->db->select('a.serial,a.id,bb.component_name,b.warehouse_product_code,a.product_serial,pp.product_name,cl.name as colour_name,cn.name as condition,u.name as unit');
		$this->db->from("tbl_component_serials as a");
		$this->db->join("tbl_component as b","a.component_id=b.id","INNER");
		$this->db->join("tbl_component as bb","b.sub=bb.id","INNER");
		$this->db->join("geopos_products as p","b.product_id=p.pid","left");
		$this->db->join("geopos_products as pp","p.sub=pp.pid","left");
		$this->db->join("geopos_colours as cl","p.colour_id=cl.id","left");
		$this->db->join("geopos_conditions as cn","p.vc=cn.id","left");
		$this->db->join("geopos_units as u","p.vb=u.id","left");

		$this->db->where("a.issue_id",$id);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		$data=array();
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return $data; 
	}

	public function manage_requests_product_invoice($id)
	{
		$this->db->select('a.id as issue_id,a.date_created,b.product_name,b.zupc');
		$this->db->from("tbl_jobwork_issue as a");
		$this->db->join("tbl_jobwork_issue_serial as b","a.id=b.jobwork_issue_id","left");
		$this->db->where("a.id",$id);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		$data=array();
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return $data;
	}
	
	
	public function get_serialByjobworkReqId($jobwork_req_id)
	{
		$this->db->select("serial,imei2");
		$this->db->where("jobwork_req_id",$jobwork_req_id);	
		$this->db->where('status !=',8);
		$query = $this->db->get("geopos_product_serials");

		$data = array();
		
		if($query->num_rows()>0)
		{
			foreach($query->result() as $key=>$row)
			{
				$row->serial;
				$row->imei2;
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	
	public function getWarehouseByEmpID($eid)
    {
		$this->db->select('c.*,a.name,a.id as employee_id,b.name,b.id as franchise_id');		
		$this->db->from("geopos_employees as a");
		$this->db->join('geopos_customers as b', 'b.id = a.franchise_id', 'INNER');
		$this->db->join('geopos_warehouse as c', 'b.id = c.cid', 'INNER');		
		$this->db->where('a.id',$eid);
		$query = $this->db->get();	
		//echo $this->db->last_query(); exit;
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {				
			   $data[] = $row;				
            }
            return $data;
        }
        return false;
    }
	
	
	public function getSTRPendingInvoice($type=''){
		$this->db->select('a.id,a.tid,a.invoicedate,count(DISTINCT(b.pid)) as total_product,sum(b.qty) as stock_quantity,c.franchise_code,a.stock_return_status');
		$this->db->from("geopos_invoices as a");		
		$this->db->join('geopos_invoice_items as b', 'b.tid = a.id', 'left');
		$this->db->join('geopos_customers as c', 'a.csd = c.id', 'left');
		$this->db->join('tbl_warehouse_serials as d', 'a.id = d.invoice_id', 'inner');
		$this->db->group_by('a.id');
		$this->db->where('a.type', 7);		
		$this->db->where('d.status', 9);		
		//$this->db->where('a.stock_return_status', 0);			
		$query = $this->db->get();
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
	
	public function getInvoiceDTlIMEIWise($id=''){
		
		$this->db->select('a.id,a.twid,d.price,d.tax,d.subtotal,b.serial,e.product_name');
		$this->db->from("tbl_warehouse_serials as a");		
		$this->db->join('geopos_product_serials as b', 'b.id = a.serial_id', 'left');
		$this->db->join('geopos_invoices as c', 'c.id = a.invoice_id', 'left');
		$this->db->join('geopos_invoice_items as d', 'd.tid = c.id', 'left');
		$this->db->join('geopos_products as e', 'e.pid = b.product_id', 'left');
		
		$this->db->where('a.invoice_id', $id);	
		$this->db->where('a.status', 9);	
		$this->db->group_by('b.serial');
		$query = $this->db->get();
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
	
	
	public function getwarehouseexceptthisid($id){
		$this->db->where('id !=', $id);
		$query = $this->db->get('geopos_warehouse');
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	} 
	
	public function recieve($id,$wid,$invoice_id){
		$data = array(
            'twid' => $wid,
            'status' => 1,
            'is_present' => 1
        );
        $this->db->set($data);
        $this->db->where('id', $id);
		$this->db->update('tbl_warehouse_serials');
		
		$data1 = array(            
            'stock_return_status' => 1
        );
        $this->db->set($data1);
        $this->db->where('id', $invoice_id);
		$this->db->update('geopos_invoices');
	}
	
	public function not_recieve($id,$wid,$invoice_id){
		$data = array(
            'status' => 1,
            'is_present' => 1
        );
        $this->db->set($data);
        $this->db->where('id', $id);
		$this->db->update('tbl_warehouse_serials');
		
		$data1 = array(            
            'stock_return_status' => 2
        );
        $this->db->set($data1);
        $this->db->where('id', $invoice_id);
		$this->db->update('geopos_invoices');
		//echo $this->db->last_query(); exit;
	}
	
	
	public function getwarehousebyid($id=''){
		$this->db->where('id', $id);
		$query = $this->db->get('geopos_warehouse');
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data =$row;								
			}			
			return $data;
		}
		return false;
	} 
	
	
	public function sendjobwork($serial){
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
			$this->db->set('status',6);
			$this->db->set('date_modified',date('Y-m-d H:i:s'));
			$this->db->where('serial', $serial);
			$this->db->where('status !=', 8);
			$this->db->update('geopos_product_serials');
			
			
			$data = array(            
				'status' => 0,
				'hold_status' => 0,				
				'date_modified' => date('Y-m-d H:i:s'),
				'is_present' => 0
			);
			$this->db->set($data);
			$this->db->where('serial_id', $serial_id);
			$this->db->update('tbl_warehouse_serials');
			
			
			$this->db->where('serial', $serial);			
			$query1 = $this->db->get('tbl_jobcard');
			
			if ($query1->num_rows() > 0) {						
				$data1 = array(            
					'status' => 1,
					'change_status' => 1,
					'final_qc_status' => 1,
					'date_modified' => date('Y-m-d H:i:s'),
					'type' => 1
				);
				$this->db->set($data1);
				$this->db->where('serial', $serial);
				$this->db->update('tbl_jobcard');				
			}else{
				$data1 = array(            
					'teamlead_id' => 39,
					'serial' => $serial,
					'status' => 1,
					'change_status' => 1,
					'final_qc_status' => 1,
					'date_modified' => date('Y-m-d H:i:s'),
					'type' => 1
				);			
				$this->db->insert('tbl_jobcard',$data1);
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

	public function trc_warehouse()
	{
		$this->db->select("*");
		$this->db->from("geopos_warehouse");
		$this->db->where("warehouse_type",2);
		$query = $this->db->get();
		$data = array();
		if($query->num_rows()>0)
		{
		foreach($query->result() as $key=>$row)
		{
			$data[]= $row;
		}
		return $data;
	    }
	    return false;
	}
	
}