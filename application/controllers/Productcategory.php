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

defined('BASEPATH') or exit('No direct script access allowed'); 

class Productcategory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model', 'products_cat');
        $this->load->model('products_model', 'products');
		$this->load->model('employee_model', 'employee');
		$this->load->model('purchase_model', 'purchase');
		$this->load->model('communication_model');
        $this->load->library("Aauth");
		$this->load->library('excel');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->li_a = 'stock';
    }
 
    public function index()
    {
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category', $data);
        $this->load->view('fixed/footer');
    }

    public function warehouse()
    {		 
		$eid = $this->session->userdata('id'); 
		$s_role = $this->session->userdata('s_role'); 		
		if($s_role=='r_2'){
			$warehouse = $this->employee->getWarehouseByEmpID($eid);
			$data['warehouse'] = $warehouse; 
			$wid = $warehouse->id;
			$data['cat'] = json_decode(json_encode($this->products_cat->otherwarehouse($wid)),true);
		}else{
			//$data['cat'] = $this->products_cat->warehouse();		
			$data['cat'] = json_decode(json_encode($this->products_cat->otherwarehouse($wid)),true);		
			//$data['cat'] = array_merge($data['cat'],$data['othercat']);
		}
       
        $head['title'] = "Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $data['id'] = $this->input->get('id');
        $data['sub'] = $this->input->get('sub');
        $data['cat'] = $this->products_cat->category_sub_stock($data['id']);
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }

    public function viewwarehouse()
    {
		//$list = $this->products_cat->get_warehouseProductById(1);
        $data['cat'] = $this->products_cat->warehouse();
		$data['othercat'] = json_decode(json_encode($this->products_cat->otherwarehouse()),true);		
		$data['cat'] = array_merge($data['cat'],$data['othercat']);
        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse_view', $data);
        $this->load->view('fixed/footer');
    }
	
    public function viewcomponent()
    {
       $query = $this->db->query("select tbl_component_serials.component_id,tbl_component_serials.serial_in_type,tbl_component_serials.purchase_id, tbl_component.component_name as product, tbl_component.warehouse_product_code from tbl_component_serials LEFT JOIN tbl_component on tbl_component_serials.component_id=tbl_component.id group by tbl_component_serials.component_id");
       $record = array();
      $qty = array();
      $by_po_qty = array();
      $by_jobwork_qty = array();
      
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key=>$row) {  
              
                $record[] = $row;


                $qty_query = $this->db->query("select * from tbl_component_serials where status=1 and component_id='".$row->component_id."'");
                if($qty_query->num_rows() > 0)
                {
                    $qty[] = $qty_query->num_rows();
                }else{
                    $qty[] = 0;
                }


                $by_po_qty_query = $this->db->query("select * from tbl_component_serials where status=1 and serial_in_type=1 and component_id='".$row->component_id."'");
                if($by_po_qty_query->num_rows() > 0)
                {
                    $by_po_qty[] = $by_po_qty_query->num_rows();
                }else{
                    $by_po_qty[] = 0;
                }


                $jobwork_qty_query = $this->db->query("select * from tbl_component_serials where status=1 and serial_in_type=2 and component_id='".$row->component_id."'");
                if($jobwork_qty_query->num_rows() > 0)
                {
                    $by_jobwork_qty[] = $jobwork_qty_query->num_rows();
                }else{
                    $by_jobwork_qty[] = 0;
                }
            }           
            
        }
 
        $data['result']=$record;
        
        $data['qty']=$qty;
        $data['po_qty']=$by_po_qty;
        $data['jobwork_qty']=$by_jobwork_qty;


        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/component_warehouse_view', $data);
        $this->load->view('fixed/footer');
    }    
       
    
    public function add()
    {
        $data['cat'] = $this->products_cat->category_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function add_sub()
    {
        //$data['cat'] = $this->products_cat->category_list();
        $data['cat'] = $this->products_cat->category_list_dropdown();		
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add_sub', $data);
        $this->load->view('fixed/footer');
    }

    public function addwarehouse()
    {
        if ($this->input->post()) {
            $cat_name = $this->input->post('product_catname');
            $cat_desc = $this->input->post('product_catdesc');
            $lid = $this->input->post('lid');
            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 or $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }

            if ($cat_name) {

                $this->products_cat->addwarehouse($cat_name, $cat_desc, $lid);
            }
        } else {
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $data['cat'] = $this->products_cat->category_list();
            $head['title'] = "Add Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/warehouse_add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function addcat()
    {        
        $cat_name = $this->input->post('product_catname', true);
        $cat_desc = $this->input->post('product_catdesc', true);
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        if ($cat_name) {
            $this->products_cat->addnew($cat_name, $cat_desc, $cat_type, $cat_rel);
        }
    }


    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = intval($this->input->post('deleteid'));
            if ($id) {

                $query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON  geopos_products.pcat=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");

                $this->db->delete('geopos_products', array('pcat' => $id));
                $this->db->delete('geopos_product_cat', array('id' => $id));
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function delete_i_sub()
    {
        if ($this->aauth->premission(11)) {
            $id = intval($this->input->post('deleteid'));
            if ($id) {

                $query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON  geopos_products.sub_id=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");

                $this->db->delete('geopos_products', array('sub_id' => $id));
                $this->db->delete('geopos_product_cat', array('id' => $id));
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function delete_warehouse()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_products', array('warehouse' => $id));
                $this->db->delete('geopos_warehouse', array('id' => $id));
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Warehouse with products')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

//view for edit
    public function edit()
    {
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['productcat'] = $query->row_array();
        $data['cat'] = $this->products_cat->category_list();

        $head['title'] = "Edit Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-cat-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editwarehouse()
    {
        if ($this->input->post()) {
            $cid = $this->input->post('catid');
            $cat_name = $this->input->post('product_cat_name', true);
            $cat_desc = $this->input->post('product_cat_desc', true);
            $lid = $this->input->post('lid');

            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 or $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }


            if ($cat_name) {

                $this->products_cat->editwarehouse($cid, $cat_name, $cat_desc, $lid);
            }
        } else {
            $catid = $this->input->get('id');
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $catid);
            $query = $this->db->get();
            $data['warehouse'] = $query->row_array();
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $head['title'] = "Edit Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/product-warehouse-edit', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function editcat()
    {
        $cid = $this->input->post('catid');
        $product_cat_name = $this->input->post('product_cat_name');
        $product_cat_desc = $this->input->post('product_cat_desc');
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        $old_cat_type = $this->input->post('old_cat_type', true);
        if ($cid) {
            $this->products_cat->edit($cid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type);
        }
    }


    public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));
        $sub_date = $this->input->post('sub');
        $filter = 'pcat';
        if ($sub_date) $filter = 'sub_id';

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.$filter  $qj WHERE geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.$filter  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name   FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.$filter='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/cat_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $sub = $this->input->get('sub');
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/cat_statement', array('id' => $pid, 'product' => $product, 'sub' => $sub));
            $this->load->view('fixed/footer');
        }
    }

    public function warehouse_report()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }

            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid $qj WHERE geopos_invoices.status!='canceled'  AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.warehouse='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.pcat='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name  FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.warehouse='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }


            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/ware_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');


            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/ware_statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }
	
	public function subCatDropdown(){		
		$id = $this->input->post('id');
		$data['id'] = $id;
		$subcat = $this->products_cat->category_list_dropdown(1, $id);
		$data['subcat'] = $subcat;				
		if($subcat){			
			$this->load->view('products/subCatDropdown',$data);
		}else{
			return false;
		}
	}
	
	public function productlist(){		
		$id = $this->input->post('id');
		$action = $this->input->post('action');
		$data['id'] = $id;		
		$data['action'] = $action;		
		$products = $this->products->getAllproductByCatId($id);
		$data['products'] = $products;
		$brands = $this->products->getAllBrandsByCatId($id);		
		$data['brands'] = $brands;
		if($products){			
			$this->load->view('products/productlist',$data);
		}else{
			return false;
		}
	}
	
	
	public function productlistbybrand(){		
		$id = $this->input->post('id');
		$cat_id = $this->input->post('cat_id');
		$action = $this->input->post('action');
		$data['id'] = $id;		
		$data['cat_id'] = $cat_id;		
		$data['action'] = $action;		
		$products = $this->products->getAllproductByBrandId($id,$cat_id);
		$data['products'] = $products;
		
		if($products){			
			$this->load->view('products/productlist-brand',$data);
		}else{
			return false;
		}
	}
	  
	
	public function franchise_pending()
    {
		
		$eid = $this->session->userdata('id'); 
		$s_role = $this->session->userdata('s_role'); 		
		if($s_role=='r_2'){
			$warehouse = $this->employee->getWarehouseByEmpID($eid);
			$data['warehouse'] = $warehouse; 
			$wid = $warehouse->id;
			$data['pending_serial'] = $this->products->getFranchisePendingSerial($wid);
		}else{
			$data['pending_serial'] = $this->products->getFranchisePendingSerial($wid='');
		}
       
        $head['title'] = "Franchise Pending Inventory";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
		//$data['pending_serial'] = $this->products->getFranchisePendingSerial();
        $this->load->view('products/pending_franchise_inventory', $data);
        $this->load->view('fixed/footer');
    }
	
    public function stock_return_panding_franchise()
    { 
		$data['list'] = $this->products_cat->getSTRPendingInvoice($type=7);
		/* $this->load->model('invoices_model', 'invocies');
		$data['list'] = $this->invocies->get_datatables($this->limited,$type=7); */		
        $id = $this->input->get('id');       
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/stock-return-panding-franchise',$data);
        $this->load->view('fixed/footer');
    }
	
    public function stock_return_panding_franchise_view()
    {           
        $id = $this->input->get('id');
        $data['list'] = $this->products_cat->getInvoiceDTlIMEIWise($id);
		$data['warehouse'] = $this->products_cat->getwarehouseexceptthisid($data['list'][0]->twid);
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/stock-return-panding-franchise-view',$data);
        $this->load->view('fixed/footer');
    }
	
	public function manual_add()
    {			
		$id = $this->input->get('id');
		$data['Fdata'] = $this->products->getFranchisePendingSerialByInvoiceId($id);
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/add-franchise-manual',$data);
        $this->load->view('fixed/footer');
    }
	
	public function misplaced()
    {
		
		$eid = $this->session->userdata('id'); 
		$s_role = $this->session->userdata('s_role'); 		
		if($s_role=='r_2'){
			$warehouse = $this->employee->getWarehouseByEmpID($eid);
			$data['warehouse'] = $warehouse; 
			$wid = $warehouse->id;
			$data['serial_record'] = $this->products->getMisplacedSerial($wid);
		}else{
			$data['serial_record'] = $this->products->getMisplacedSerial();
		}
       
        $head['title'] = "Franchise Pending Inventory";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/misplaced_inventory', $data);
        $this->load->view('fixed/footer');
    }
	
	
	public function misplaced_view()
    {		
		$id = $this->input->get('id');
		$data['serial_record'] = $this->products->getMisplacedSerialByInvoiceId($id);
        $head['title'] = "Franchise Pending Inventory";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/misplaced_inventory_view', $data);
        $this->load->view('fixed/footer');
    }
	
	
	public function recieve_serial(){
		$this->products->recieve_serial();
	}
	
	public function not_recieve(){
		$this->products->not_recieve();
	}
	
	public function moredetails()
    {
        $pid = intval($this->input->get('pid'));
        $wid = intval($this->input->get('wid'));
        $data['serial_list'] = $this->products->getSerial($pid,$wid);
          

        $head['usernm'] = '';
        $head['title'] = 'Serial List';
        $data['cat'] = $this->products_cat->warehouse();
        $data['othercat'] = json_decode(json_encode($this->products_cat->otherwarehouse()),true);       
        $data['cat'] = array_merge($data['cat'],$data['othercat']);
        $head['title'] = "View Product Warehouses";

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse_details', $data);
        $this->load->view('fixed/footer');
    }

    public function component_moredetails()
    {
        $pid = intval($this->input->get('pid'));
        $data['serial_list'] = $this->products->getSerialComponent($pid);
        $head['usernm'] = '';
        $head['title'] = 'Serial List';
        $data['cat'] = $this->products_cat->warehouse();
        $data['othercat'] = json_decode(json_encode($this->products_cat->otherwarehouse()),true);       
        $data['cat'] = array_merge($data['cat'],$data['othercat']);
        $head['title'] = "View Product Warehouses";

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/component_warehouse_details', $data);
        $this->load->view('fixed/footer');
    }
	
    public function serial_barcode(){
        
        $pid = $this->input->get('id');
        
        if ($pid) {
          $this->db->select('a.serial,a.id,b.product_name');
          $this->db->from('geopos_product_serials as a');
          $this->db->join("geopos_products as b","a.product_id=b.pid",'inner');
          $this->db->where("a.id",$pid);
          $query = $this->db->get();
          $resultz = $query->row_array();
          $data['name'] = $resultz['product_name'];
          $data['code'] = $resultz['barcode'];
          $data['ctype'] = $resultz['code_type'];
          $html = '<table cellpadding="20">';
          for($i=0;$i<1;$i++){
            $html .= '<tr>';
            for($j = 0;$j<1;$j++){
                $html .= '<td> <small>'.$resultz['product_name'].'<br><br></small><img src="'.base_url().'userfiles/barcode/barcode.processor.php?encode=CODE128&qrdata_type=text&qr_btext_text=&qr_link_link=&qr_sms_phone=&qr_sms_msg=&qr_phone_phone=&qr_vc_N=&qr_vc_C=&qr_vc_J=&qr_vc_W=&qr_vc_H=&qr_vc_AA=&qr_vc_ACI=&qr_vc_AP=&qr_vc_ACO=&qr_vc_E=&qr_vc_U=&qr_mec_N=&qr_mec_P=&qr_mec_E=&qr_mec_U=&qr_email_add=&qr_email_sub=&qr_email_msg=&qr_wifi_ssid=&qr_wifi_type=wep&qr_wifi_pass=&qr_geo_lat=&qr_geo_lon=&bdata_matrix=123&bdata_pdf=123&bdata='.$resultz['serial'].'&height=30&scale=1&bgcolor=#ffffff&color=#000000&file=&type=png&folder=" /><br></td>';
            }
            $html .= '</tr>';
          }
          $html .= '</table>';
          echo $html;die;
         /* ini_set('memory_limit', '64M');
          $this->load->library('pdf');
          $pdf = $this->pdf->load();
          $pdf->WriteHTML($html);
          $pdf->Output($data['name'] . '_barcode.pdf', 'I');*/
          $this->load->library('pdf');
          $this->pdf->createPDF($html, 'mypdf', false);
        }
    }


   public function serial_label(){
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('c.name as colour_name,u.name as unit_name,gc.name as condition,bb.product_name,b.product_name as parent_product_name,b.warehouse_product_code,b.product_price,b.product_code,b.sale_price,a.serial,a.id');
            $this->db->from('geopos_product_serials as a');
            $this->db->join('geopos_products as b','a.product_id=b.pid','INNER');
            $this->db->join('geopos_products as bb','b.sub=bb.pid','left');
            $this->db->join('geopos_colours as c','b.colour_id=c.id','left');
            $this->db->join('geopos_units as u','b.vb=u.id','left');
             $this->db->join('geopos_conditions as gc','b.vc=gc.id','left');
            $this->db->where('a.id', $pid);
            $query = $this->db->get();
            //echo $this->db->last_query(); die;
            $resultz = $query->row_array();

           // $productss = explode('-Size-',$resultz[product_name]);
            //$pro_name = $productss[0];
            //$varient = $productss[1];

            if($resultz['product_name']=='')
            {
                $product = $resultz['parent_product_name'];
            }
            else
            {
                $product = $resultz['product_name'];
            }
           

            $price = number_format((float)$resultz['product_price'], 2, '.', '');
            $html = '<!doctype html><html lang="en"><head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"><title>Label 1</title>
  </head><body><table class="table-box" style="width: 200px;">
                            <thead></thead>
                            <tbody> <tr>
                                    <td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:100px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 9px;vertical-align: top;">:'.$resultz[colour_name]. '</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 8px;vertical-align: top;">:';

                                                    if(strlen($product)>40) { 
                                                        $html.=substr($product,0,40).'...'; } else { $html.=$product; 
                                                        } 
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 8px;vertical-align: top;width:80px;">:';
                                                    if(strlen($resultz['unit_name'])>40) 
                                                        { 
                                                            $html.=substr($resultz['unit_name'],0,40).'...'; } else { 
                                                                $html.=$resultz['unit_name'].' - '.$resultz['condition']; }
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">ZUPC Code</td>
                                                    <td style="font-size: 8px;vertical-align: top;">:'.$resultz[warehouse_product_code].'</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">MRP. <span style="font-size: 7px;">(Inclusive of all Taxes)</span></td>
                                                    <td style="font-size: 8px;vertical-align: top;">: Rs. ';
                                                    if($resultz[sale_price]<1) 
                                                        { 
                                                            $html.="0.00";
                                                     } 
                                                    else 
                                                    {
                                                    $html.=$resultz[sale_price]; 
                                                     }
                                                    $html.='/-</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 8px;vertical-align: top;">: 1 Unit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:40px;">
                                        <table >
                                            <tbody>
                                                <tr>
                                                    <td style="width:40px;">
                                                        <h6 style="font-size: 7px;line-height: 10px;margin:0px;padding:0px;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 7px;line-height: 12     px;margin:0px;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 7px;vertical-align: top;">Regd Office</span>
                                                        <span style="font-size: 7px;vertical-align: top;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;">
                                                            <span style="font-size: 7px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 7px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 7px;margin:0px;line-height: 12px;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                             <img alt="Barcode Generator TEC-IT"
       src="https://barcode.tec-it.com/barcode.ashx?data='.$resultz[serial].'&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;width:90px;height:70px;"/>
                                                   </td>
                                                    </tr>
                                               </tbody>
                                        </table>
                                    </td>
                                </tr></tbody>
                        </table></body></html>';

            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }


    public function serial_label_2(){
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('c.name as colour_name,u.name as unit_name,gc.name as condition,bb.product_name,b.product_name as parent_product_name,b.warehouse_product_code,b.product_price,b.product_code,b.sale_price,a.serial,a.id');
            $this->db->from('geopos_product_serials as a');
            $this->db->join('geopos_products as b','a.product_id=b.pid','INNER');
            $this->db->join('geopos_products as bb','b.sub=bb.pid','left');
            $this->db->join('geopos_colours as c','b.colour_id=c.id','left');
            $this->db->join('geopos_units as u','b.vb=u.id','left');
             $this->db->join('geopos_conditions as gc','b.vc=gc.id','left');
            $this->db->where('a.id', $pid);
            $query = $this->db->get();

            $resultz = $query->row_array();
            if($resultz['product_name']=='')
            {
                $product = $resultz['parent_product_name'];
            }
            else
            {
                $product = $resultz['product_name'];
            }
            $price = number_format((float)$resultz['product_price'], 2, '.', '');

            

            
             $html = '<!doctype html><html lang="en"><head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"><title>Label 2</title>
  </head><body><table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody> <tr><td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:300px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:'.$resultz[colour_name]. ' </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:';

                                                    if(strlen($product)>40) { 
                                                        $html.=substr($product,0,40).'...'; } else { $html.=$product; 
                                                        } 
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:';
                                                    if(strlen($resultz['unit_name'])>40) 
                                                        { 
                                                            $html.=substr($resultz['unit_name'],0,40).'...'; } else { 
                                                                $html.=$resultz['unit_name'].' - '.$resultz['condition']; }
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">ZUPC Code</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:'.$resultz[warehouse_product_code].'</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">MRP. <h6 style="font-size: 10px;display:">(Inclusive of all Taxes)</h6></td>
                                                    <td style="font-size: 14px;vertical-align: top;">: Rs. ';
                                                    if($resultz[sale_price]<1) 
                                                        { 
                                                            $html.="0.00";
                                                     } 
                                                    else 
                                                    {
                                                    $html.=$resultz[sale_price]; 
                                                     }
                                                    $html.='/-</td>
                                                </tr>
                                                
                                                 <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: 1 Unit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td><td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:170px;">
                                        <table >
                                            <tbody>
                                                    <tr>
                                                    <td style="width:170px;">
                                                        <h6 style="font-size: 11px;line-height: 10px;margin:0px;padding:0px;font-weight: normal;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 11px;line-height: 12     px;margin:0px;font-weight: normal;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 11px;vertical-align: top;font-weight: normal;">Regd Office</span>
                                                        <span style="font-size: 11px;vertical-align: top;font-weight: normal;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;font-weight: normal;">
                                                            <span style="font-size: 11px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 11px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 11px;margin:0px;line-height: 12px;font-weight: normal;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                             <img alt="Barcode Generator TEC-IT"
       src="https://barcode.tec-it.com/barcode.ashx?data='.$resultz[serial].'&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;width:180px;height:100px;"/>
                                                   </td>
                                                    </tr>
                                               </tbody>
                                        </table>
                                    </td></tr></tbody>
                        </table></body></html>';
            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }


 public function component_serial_label(){
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('c.name as colour_name,u.name as unit_name,gc.name as condition,bb.component_name,b.component_name as parent_product_name,b.warehouse_product_code,b.product_price,b.product_code,b.sale_price,a.serial,a.id');
            $this->db->from('tbl_component_serials as a');
            $this->db->join('tbl_component as b','a.component_id=b.id','INNER');
            $this->db->join('tbl_component as bb','b.sub=bb.id','left');
            $this->db->join('geopos_colours as c','b.colour_id=c.id','left');
            $this->db->join('geopos_units as u','b.vb=u.id','left');
             $this->db->join('geopos_conditions as gc','b.vc=gc.id','left');
            $this->db->where('a.id', $pid);
            $query = $this->db->get();
            //echo $this->db->last_query(); die;
            $resultz = $query->row_array();

           // $productss = explode('-Size-',$resultz[product_name]);
            //$pro_name = $productss[0];
            //$varient = $productss[1];

            if($resultz['component_name']=='')
            {
                $product = $resultz['parent_product_name'];
            }
            else
            {
                $product = $resultz['component_name'];
            }
           

            $price = number_format((float)$resultz['product_price'], 2, '.', '');
            $html = '<!doctype html><html lang="en"><head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"><title>Label 1</title>
  </head><body><table class="table-box" style="width: 200px;">
                            <thead></thead>
                            <tbody> <tr>
                                    <td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:100px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 9px;vertical-align: top;">:'.$resultz[colour_name]. '</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 8px;vertical-align: top;">:';

                                                    if(strlen($product)>40) { 
                                                        $html.=substr($product,0,40).'...'; } else { $html.=$product; 
                                                        } 
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 8px;vertical-align: top;width:80px;">:';
                                                    if(strlen($resultz['unit_name'])>40) 
                                                        { 
                                                            $html.=substr($resultz['unit_name'],0,40).'...'; } else { 
                                                                $html.=$resultz['unit_name'].' - '.$resultz['condition']; }
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">ZUPC Code</td>
                                                    <td style="font-size: 8px;vertical-align: top;">:'.$resultz[warehouse_product_code].'</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">MRP. <span style="font-size: 7px;">(Inclusive of all Taxes)</span></td>
                                                    <td style="font-size: 8px;vertical-align: top;">: Rs. ';
                                                    if($resultz[sale_price]<1) 
                                                        { 
                                                            $html.="0.00";
                                                     } 
                                                    else 
                                                    {
                                                    $html.=$resultz[sale_price]; 
                                                     }
                                                    $html.='/-</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 8px;vertical-align: top;">: 1 Unit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:40px;">
                                        <table >
                                            <tbody>
                                                <tr>
                                                    <td style="width:40px;">
                                                        <h6 style="font-size: 7px;line-height: 10px;margin:0px;padding:0px;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 7px;line-height: 12     px;margin:0px;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 7px;vertical-align: top;">Regd Office</span>
                                                        <span style="font-size: 7px;vertical-align: top;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;">
                                                            <span style="font-size: 7px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 7px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 7px;margin:0px;line-height: 12px;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                             <img alt="Barcode Generator TEC-IT"
       src="https://barcode.tec-it.com/barcode.ashx?data='.$resultz[serial].'&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;width:90px;height:70px;"/>
                                                   </td>
                                                    </tr>
                                               </tbody>
                                        </table>
                                    </td>
                                </tr></tbody>
                        </table></body></html>';

            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }


    public function component_serial_label_2(){
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('c.name as colour_name,u.name as unit_name,gc.name as condition,bb.product_name,b.product_name as parent_product_name,b.warehouse_product_code,b.product_price,b.product_code,b.sale_price,a.serial,a.id');
            $this->db->from('geopos_product_serials as a');
            $this->db->join('geopos_products as b','a.product_id=b.pid','INNER');
            $this->db->join('geopos_products as bb','b.sub=bb.pid','left');
            $this->db->join('geopos_colours as c','b.colour_id=c.id','left');
            $this->db->join('geopos_units as u','b.vb=u.id','left');
             $this->db->join('geopos_conditions as gc','b.vc=gc.id','left');
            $this->db->where('a.id', $pid);
            $query = $this->db->get();

            $resultz = $query->row_array();
            if($resultz['product_name']=='')
            {
                $product = $resultz['parent_product_name'];
            }
            else
            {
                $product = $resultz['product_name'];
            }
            $price = number_format((float)$resultz['product_price'], 2, '.', '');

            

            
             $html = '<!doctype html><html lang="en"><head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"><title>Label 2</title>
  </head><body><table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody> <tr><td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:300px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:'.$resultz[colour_name]. ' </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:';

                                                    if(strlen($product)>40) { 
                                                        $html.=substr($product,0,40).'...'; } else { $html.=$product; 
                                                        } 
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:';
                                                    if(strlen($resultz['unit_name'])>40) 
                                                        { 
                                                            $html.=substr($resultz['unit_name'],0,40).'...'; } else { 
                                                                $html.=$resultz['unit_name'].' - '.$resultz['condition']; }
                                                    $html.='</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">ZUPC Code</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:'.$resultz[warehouse_product_code].'</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">MRP. <h6 style="font-size: 10px;display:">(Inclusive of all Taxes)</h6></td>
                                                    <td style="font-size: 14px;vertical-align: top;">: Rs. ';
                                                    if($resultz[sale_price]<1) 
                                                        { 
                                                            $html.="0.00";
                                                     } 
                                                    else 
                                                    {
                                                    $html.=$resultz[sale_price]; 
                                                     }
                                                    $html.='/-</td>
                                                </tr>
                                                
                                                 <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: 1 Unit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td><td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:170px;">
                                        <table >
                                            <tbody>
                                                    <tr>
                                                    <td style="width:170px;">
                                                        <h6 style="font-size: 11px;line-height: 10px;margin:0px;padding:0px;font-weight: normal;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 11px;line-height: 12     px;margin:0px;font-weight: normal;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 11px;vertical-align: top;font-weight: normal;">Regd Office</span>
                                                        <span style="font-size: 11px;vertical-align: top;font-weight: normal;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;font-weight: normal;">
                                                            <span style="font-size: 11px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 11px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 11px;margin:0px;line-height: 12px;font-weight: normal;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                             <img alt="Barcode Generator TEC-IT"
       src="https://barcode.tec-it.com/barcode.ashx?data='.$resultz[serial].'&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;width:180px;height:100px;"/>
                                                   </td>
                                                    </tr>
                                               </tbody>
                                        </table>
                                    </td></tr></tbody>
                        </table></body></html>';
            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }	
	
	public function spareparts_warehouse()
    {
        $query = $this->db->query("select * from tbl_component_serials group by component_id");
        $count = $query->num_rows();

        $qty = $this->db->query("select * from tbl_component_serials");
        $total_qty = $qty->num_rows();
        //$query = $this->db->query("select count(tbl_component_serials.component_id) as product,count(tbl_component_serials.component_id) as qty from tbl_component_serials LEFT JOIN tbl_component on tbl_component_serials.component_id=tbl_component.id group by tbl_component_serials.component_id");
        $data['result'] = $query->result_array();
        
       // $data['result'] = $this->products_cat->warehouse();
        $data['total_product']=$count;
        $data['total_qty']=$total_qty;
        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/spareparts_warehouse', $data);
        $this->load->view('fixed/footer');
    }
	
	public function manage_requests()
    {
        $head['title'] = "Manage Requests";		
		$data['records'] = $this->products_cat->manage_requests();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/manage_requests', $data);
        $this->load->view('fixed/footer');
    }
	
    public function pending_requests()
    {
       	$data['records'] = $this->products_cat->pending_requests();		
        $head['title'] = "Pending Requests";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/pending_requests', $data);
        $this->load->view('fixed/footer');
    }
	
    public function panding_scan()
    {
       	$id = $this->input->get('id');
		$data['record'] = $this->products_cat->pending_requestById($id);
        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/panding_scan', $data);
        $this->load->view('fixed/footer');
    }
	
    public function panding_scannew()
    {
		$serials = $this->input->post('serials'); 
		$data['req_id'] = $this->input->post('id'); 
		
		foreach($serials as $key=>$serial){
			$serial_data[] = $this->products->getProductAndComponentBySeral($serial);
		}		
		$data['records'] = $serial_data;
        $head['title'] = "ITEMS COMPONENTS";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/panding_scannew', $data);
        $this->load->view('fixed/footer');
    }	
	
	public function generate_isuue(){		
		$id = $this->products_cat->generate_isuue();
		redirect('/purchase/printinvoice?id='.$id, 'refresh');
	}
	
	public function scanimei(){
		$status = 1;
		$status = $this->products_cat->checkSerialforScan(); 
		$imei = $this->input->post('serial_no');
		$product_id = $this->input->post('product_id');
		$component_record = $this->products_cat->getComponentByImei($imei);
		$components = $component_record->item_replaced;
		$component_array = explode(',',$components);
		//print_r($component_array);
		$qty = '';
		foreach($component_array as $key=>$component){
			$component_res = $this->products_cat->getComponentQty($component,$product_id);				
			//echo $qty .= ','.$component.'-'.$component_res->component_qty;
			if($component_res->component_qty < 1){				
				$status = 2;
				
				$data = array();
				$data['product_id'] = $product_id;
				$data['component'] = $component;				
				$data['qty'] = 1;
				$data['date_created'] = date('Y-m-d h:i:s');			
				$this->db->insert('tbl_component_required', $data); 	
			}else{				
				$component_serial_array = $this->products_cat->getComponentSerial($component,$product_id,1);
				//print_r($component_serial_array);
				$component_serial_id = $component_serial_array[0]->component_serial_id;
				$this->db->set('status', 2, FALSE);
				$this->db->where('id', $component_serial_id);
				$this->db->update('tbl_component_serials');
				//echo $this->db->last_query(); 
			}
		}
		echo $status;
	}
	
	
	public function sendcomponentrequestemail(){		
		$fileName = 'component.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Date');
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'S.NO.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Color');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Part');
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Qty');
		
		$component = $this->products_cat->getTodayComponentRequirement();
		/* echo "<pre>";
		print_r($component);
		echo "</pre>"; exit; */
		$i=3;
		$j=1;
		foreach($component as $key=>$row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $j);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->product_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->component);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->component_qty);
			$i++;
			$j++;
		}
        		
		 $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		 $objWriter->save($fileName);
		 //header("Content-Type: application/vnd.ms-excel");
		 //redirect(base_url().$fileName); exit;
		 
		$msg = '<!DOCTYPE html>
		<html>
		<head>
		  <title>email</title>
		</head>
		<body>
		<table style="margin:0px auto;">
		  <tr>
			<td>
			  <table style="background:#FFF;margin:0;border-collapse:collapse;max-width:100%;width:600px;border:1px solid #ddd;">
				<tr>
				  <td style="padding: 50px 30px 10px;">
					<img src="http://13.233.62.90/zobox/userfiles/company/1618553743309630865.png" style="width: 60px;">
				  </td>
				</tr>
				
				<tr>
				  <td style="padding:10px 30px;margin:0px;text-align:left;;font-size: 18px;">
					<p>Dear Admin, </p>
					<p style="margin-bottom: 0px;">Greetings of the Day.</p>
				  </td>
				</tr>
				<tr>
				  <td style="padding:10px 30px;margin:0px;font-size: 18px;">
					<p style="margin-top: 0px;">Attached is the requirement for the Spare Parts in Warehouse.</p>
					<p>Kindly Bring them fast, so that I can put the people on job.</p>
				  </td>
				</tr>
				<tr>
				  <td style="padding:0px 30px 50px;margin:0px;font-size: 18px;">
					<p style="margin-top: 0px;">Thanks</p>
					<p style="margin-bottom: 0px;">ZO BOT</p>
				  </td>

				</tr>
				
				
			  </table>
			</td>
		  </tr>
		</table>
		</body>
		</html>';		
		
		
		$mailto = 'jaydeepsarkar@cartnyou.com';
		$mailtotitle='Cartnyou'; 
		$subject='ALERT!! - Required Spare Parts in Warehouse for Refurbishment '; 
		$message = $msg; 
		$attachmenttrue = true; 
		$attachment = $fileName;	
		
		$this->load->model('communication_model');
		//$this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
		$this->communication_model->send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
	}

    public function barcode_label() 
    { 
        $pid = $this->input->get('id');
        $label_type = $this->input->get('label');
        $this->db->select('c.name as colour_name,u.name as unit_name,gc.name as condition,bb.product_name,b.product_name as parent_product_name,b.warehouse_product_code,b.product_price,b.product_code,b.sale_price,a.serial,a.id');
        $this->db->from('geopos_product_serials as a');
        $this->db->join('geopos_products as b','a.product_id=b.pid','INNER');
        $this->db->join('geopos_products as bb','b.sub=bb.pid','left');
        $this->db->join('geopos_colours as c','b.colour_id=c.id','left');
        $this->db->join('geopos_units as u','b.vb=u.id','left');
        $this->db->join('geopos_conditions as gc','b.vc=gc.id','left');
        $this->db->where('a.id', $pid);
        $query = $this->db->get();
        $data['product_detail'] = $query->row_array();
        $data['serial'] = $this->input->get('serial');
        if($data['product_detail']['product_name']=='')
            {
                $product = $data['product_detail']['parent_product_name'];
            }
            else
            {
                $product = $data['product_detail']['product_name'];
            }

         $data['label_size']  = $label_type;
         $data['product_name'] = $product;  
        
        ini_set('memory_limit', '64M');

            $html = $this->load->view('products/product_barcode_label', $data, true);
        
        $this->load->library('pdf'); 

            $header = "";
            if($label_type==3)
            {
            $pdf = $this->pdf->custom_big_label(array('margin_top' => 0.5)); 
            }
            if($label_type==1)
            {
            $pdf = $this->pdf->custom_small_label(array('margin_top' => 0.5));
            }
            if($label_type==2)
            {
                
                $pdf = $this->pdf->custom_small_label(array('margin_top' => 0.5));
            }
            if($label_type==4)
            {
                
                $pdf = $this->pdf->custom_big_label(array('margin_top' => 0.5));
            }
            $pdf->SetHTMLHeader($header);
           
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;"></div>');
           
    
            $pdf->WriteHTML($html);
            $pdf->Output($data['product_detail'][0]->product_name . '_label.pdf', 'I');
        //$this->load->view('products/new_custom_l4abel', $data);
    }
	
	
	public function recieve(){
		$id = $this->input->post('id');
		$wid = $this->input->post('wid');
		$invoice_id = $this->input->post('invoice_id');
		echo $this->products_cat->recieve($id,$wid,$invoice_id);
	}
	
	public function not_recieved(){		
		$id = $this->input->post('id');
		$wid = $this->input->post('wid');
		$invoice_id = $this->input->post('invoice_id');
		echo $this->products_cat->not_recieve($id,$wid,$invoice_id);
	}

    public function delete_request_jobwork()
    {
        $data['records'] = $this->products_cat->pending_requests();
            
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                
                $this->db->select('*');
                $this->db->where("jobwork_req_id",$id);
                $getSerialpro = $this->db->get("geopos_product_serials");

                foreach($getSerialpro->result() as $key=>$row)
                {
                    $data = array
                    (
                    'product_serial_id' => $row->id,    
                    'product_id'      => $row->product_id,
                    'purchase_id'     => $row->purchase_id,
                    'serial'          => $row->serial,
                    'status'          => $row->status,
                    'partial_status'  => $row->partial_status,
                    'jobwork_req_id'  => $row->jobwork_req_id,
                    'sticker'         => $row->sticker,
                    'imei2'           => $row->imei2,
                    'current_condition' => $row->current_condition,
                    'convert_to'        => $row->convert_to,
                    'logged_user_id'    => $this->session->userdata('id'),
                    'date_modified'     => date('Y-m-d h:i:s')
                    );

                    $this->db->insert("geopos_product_serials_log",$data);
                }


                $this->db->set('status',8);
                $this->db->where("id",$id);
                $this->db->update("tbl_jobwork_request");
                
                $this->db->set('status',8);
                $this->db->set('date_modified',date('Y-m-d h:i:s'));
                $this->db->where("jobwork_req_id",$id);     
                $this->db->update("geopos_product_serials");


                $query = $this->db->query("update tbl_warehouse_serials set status=8 where serial_id in (select id from geopos_product_serials where jobwork_req_id='".(int)$id."')");  

                
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function download_data()
    {
       
        $query = $this->db->query("SELECT a.serial, COUNT(a.serial)as counter, `b`.`sale_price`, GROUP_CONCAT(a.product_id) as product_id,GROUP_CONCAT(b.product_name) as product_name,GROUP_CONCAT(c.status) as serial_status,GROUP_CONCAT(d.title) as warehouse
		FROM `geopos_product_serials` as `a`
		LEFT JOIN `geopos_products` as `b` ON `a`.`product_id` = `b`.`pid`
		LEFT JOIN `tbl_warehouse_serials` as `c` ON `a`.`id` = `c`.`serial_id`
		LEFT JOIN `geopos_warehouse` as `d` ON `c`.`twid` = `d`.`id`
		where a.status!=8 GROUP BY (a.serial) having COUNT(a.serial)>1");
				
				$data['result'] = $query->result_array();
				
				$head['title'] = "View Product Warehouses";
				$head['usernm'] = $this->aauth->get_user()->username;
				$this->load->view('fixed/header', $head);
				$this->load->view('products/download_data', $data);
				$this->load->view('fixed/footer');
    }
	
	public function sendjobwork(){
		$serial = $this->input->post('serial');		
		//$serial = 354554103000509;		
		echo $this->products_cat->sendjobwork($serial);
	}
	
	public function lrp_panding_inventory()
    { 
		$data['list'] = $this->products_cat->getLRPPendingInvoice($type=9);
        /* $this->load->model('invoices_model', 'invocies');
        $data['list'] = $this->invocies->get_datatables($this->limited,$type=7); */     
        $id = $this->input->get('id');       
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/lrp_panding_inventory',$data);
        $this->load->view('fixed/footer');
    }
    
    public function lrp_panding_inventory_view()
    {           
        $id = $this->input->get('id');
        $data['list'] = $this->products_cat->getInvoiceDTlIMEIWiseLRP($id,10);
		$data['warehouse'] = $this->products_cat->getwarehouseexceptthisid($data['list'][0]->fwid);
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/lrp_panding_inventory_view',$data);
        $this->load->view('fixed/footer');
    }
	
	
	public function recievelrp(){
		$id = $this->input->post('id');
		$wid = $this->input->post('wid');
		$invoice_id = $this->input->post('invoice_id');
		echo $this->products_cat->recievelrp($id,$wid,$invoice_id);
	}

}