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

class Search_products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('search_model');
        $this->load->model('jobwork_model','jobwork');
        $this->load->model('products_model','products');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }

//search product in invoice
    public function search()
    {
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid') AND geopos_products.status=1 AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND geopos_products.status=1 AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $qw .= '(geopos_product_serials.status=0) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial';
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%')  LIMIT 6");
            } else {
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%') LIMIT 6");
            }			
			
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial']);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }
	
	
//search product in stock transfer
     public function search1()
    {
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(tbl_warehouse_serials.twid='$wid') AND geopos_products.status=1 AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND geopos_products.status=1 AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
            $join .= ' LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $join .= ' LEFT JOIN tbl_warehouse_serials ON tbl_warehouse_serials.serial_id=geopos_product_serials.id';  
            $qw .= '(geopos_product_serials.status=1) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
                $sql = "SELECT count(tbl_warehouse_serials.id) as qty, geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6";
                $query = $this->db->query($sql);
                //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
                $sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6";
               $query = $this->db->query($sql);
               //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
            
            //echo $sql; exit;
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }
    


    public function search_product_by_serial()
    {
		$this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(tbl_warehouse_serials.twid='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
			$join .= ' LEFT JOIN tbl_warehouse_serials ON geopos_product_serials.id=tbl_warehouse_serials.serial_id';
			$join .= ' LEFT JOIN geopos_products ON geopos_product_serials.product_id=geopos_products.pid';  
            $qw .= '(geopos_product_serials.status=7) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty, geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '" . strtoupper($name) . "') GROUP By(geopos_products.pid)  LIMIT 6";
                $query = $this->db->query($sql);
				//$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '". strtoupper($name) . "') LIMIT 6";
               $query = $this->db->query($sql);
			   //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
	
		      if($query->num_rows()==1)
            {
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            }
        }
               
            echo json_encode($name);
        }

    }
	
	public function search_product_by_serial_zoboxsales()
    {
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        //$wid = $this->input->post('wid', true);
        $wid=1;
        $qw = '';
        if ($wid > 0) {
            $qw = "(tbl_warehouse_serials.twid='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND geopos_products.status=1 AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.purchase_id,geopos_product_serials.id as serial_id,tbl_warehouse_serials.pid as pro_id';
            $join .= ' LEFT JOIN tbl_warehouse_serials ON geopos_product_serials.id=tbl_warehouse_serials.serial_id';
            $join .= ' LEFT JOIN geopos_products ON geopos_product_serials.product_id=geopos_products.pid';  
            $qw .= '(geopos_product_serials.status=7) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial,geopos_product_serials.purchase_id,geopos_product_serials.id as serial_id,tbl_warehouse_serials.pid as pro_id';
                $sql = "SELECT count(tbl_warehouse_serials.id) as qty, geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '" . strtoupper($name) . "') GROUP By(geopos_products.pid)  LIMIT 6";
                $query = $this->db->query($sql);
                //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
                $sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '". strtoupper($name) . "') LIMIT 6";
               $query = $this->db->query($sql);
               //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
    
              if($query->num_rows()==1)
            {
            $result = $query->result_array();

            foreach ($result as $row) {
                $component_result = $this->jobwork->getProductComponentByPID($row['serial']);
                $product_detail = $this->jobwork->getPurchaseItem($row['pro_id'],$row['purchase_id']);


                $actual_price = $product_detail[0]['price'];
                foreach($component_result as $key=>$detail)  
                {
                  $actual_price+=$detail->price;
                }

                $actual_price = amountExchange_s($actual_price, 0, $this->aauth->get_user()->loc);
                 
                $name = array($product_detail[0]['product'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $product_detail[0]['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id'],$actual_price);
                array_push($out, $name);
            }
        }

            echo json_encode($name);
        }

    } 
    
    
	public function search125032021()
    {
		$this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $qw .= '(geopos_product_serials.status=1) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial';
				$sql = "SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6";
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
				$sql = "SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6";
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
			
			echo $sql; exit;
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial']);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }
	

    public function puchase_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            //$qw = "(geopos_products.warehouse='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_products.pid,geopos_products.merge,geopos_products.sub,geopos_products.product_name,geopos_products.product_code,geopos_products.fproduct_price,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.unit FROM geopos_products $join WHERE " . $qw . " geopos_products.status=1 AND UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%' LIMIT 150");

            $result = $query->result_array();
			//print_r($result); exit;
            foreach ($result as $row) {
				$name = array($row['product_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
					array_push($out, $name);
					
				/* if($row['merge'] == 0){
					if($row['sub'] == 0){
						$name = array($row['product_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
						array_push($out, $name);
					}	
				}else{
					$name = array($row['product_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
					array_push($out, $name);
                } */
				
            }			
            echo json_encode($out);
        }
    }

    public function csearch()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . amountFormat_general($row['discount_c']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }
	
	public function csearch1()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer1('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . amountFormat_general($row['discount_c']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function party_search()
    {
        $result = array();
        $out = array();
        $tbl = 'geopos_customers';
        $name = $this->input->get('keyword', true);

        $ty = $this->input->get('ty', true);
        if ($ty) $tbl = 'geopos_supplier';
        $whr = '';


        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }


        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM $tbl  WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function pos_c_search()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }

        if ($name) {
            $query = $this->db->query("SELECT id,name,phone,email FROM tbl_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"PselectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . " &nbsp; &nbsp  " . $row['email'] ."</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }


    public function supplier()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,company,email FROM geopos_supplier WHERE $whr (UPPER(company)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"selectSupplier('" . $row['id'] . "','" . $row['company'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  ". $row['company'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    /*public function pos_search()
    {
		
        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
           $qw = "(tbl_warehouse_serials.twid='$wid') AND geopos_products.status=1 AND ";           
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND geopos_products.status=1 AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
			$join .= ' LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
			$join .= ' LEFT JOIN tbl_warehouse_serials ON tbl_warehouse_serials.serial_id=geopos_product_serials.id';  
            $qw .= '(tbl_warehouse_serials.status=1) AND ';
        }
		//$join .= 'LEFT JOIN tbl_warehouse_product ON tbl_warehouse_product.pid=geopos_products.pid ';

        $bar = '';
        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }

            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.*,geopos_product_serials.serial FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";


        } else {
            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.* $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";

        }

		//echo $query; exit;
		
        $query = $this->db->query($query);

        $result = $query->result_array();
        $i = 0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {

            $out .= '    <div class="col-3 border mb-1 "><div class="rounded">
                                 <a   id="posp' . $i . '"  class="select_pos_item btn btn-outline-light-blue round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '"   data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['wqty']) . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '" data-serial_id="' . @$row['serial_id'] . '">
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-xs-center text">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;
            //   if ($i % 4 == 0) $out .= '</div><div class="row">';
        }

        echo $out;

    }
	*/
    public function pos_search11082021()
    {
        
        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
           $qw = "(tbl_warehouse_serials.twid='$wid') AND ";           
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id,geopos_product_serials.purchase_id,geopos_product_serials.imei2';
            $join .= ' LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $join .= ' LEFT JOIN tbl_warehouse_serials ON tbl_warehouse_serials.serial_id=geopos_product_serials.id';  
            $qw .= '(tbl_warehouse_serials.status=1) AND ';
        }
        //$join .= 'LEFT JOIN tbl_warehouse_product ON tbl_warehouse_product.pid=geopos_products.pid ';

        $bar = '';
        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }

            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.*,geopos_product_serials.serial,geopos_product_serials.purchase_id FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "  OR geopos_products.warehouse_product_code LIKE '%" . $name . "%' OR geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";


        } else {
            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.* $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' OR geopos_products.warehouse_product_code LIKE '%" . $name . "%' OR geopos_product_serials.serial LIKE '%" . $name . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";

        }
         
        
        $query = $this->db->query($query);

        $result = $query->result_array();
        $i = 0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {
                
                $purchase_price = $this->products->getPurchasePriceByPID($row['pid']);

                $this->db->select("*");
                $this->db->from("geopos_purchase");
                $this->db->where("id",$row['purchase_id']);
                $this->db->where("type",2);
                $pro_type = $this->db->get();
                //echo $this->db->last_query(); die;
                $product_price_margin = "0.00";
                $gst_with_margin = "0.00";
                $product_type=0;

                if($pro_type->num_rows()>0)
                {
                    $product_type = 2;

                    $product_price_margin = $row['sale_price']-($purchase_price+600);

                    $gst_with_margin = amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$row['taxrate'])));

                }
               
                 


                

            $out .= '    <div class="col-3 border mb-1 "><div class="rounded">
                                 <a   id="posp' . $i . '"  class="select_pos_item btn btn-outline-light-blue round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '"   data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['wqty']) . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '" data-serial_id="' . @$row['serial_id'] . '" data-product_type="' . @$product_type . '" data-margin_gst_price="' . @$gst_with_margin . '" data-pruchase_price="'.$purchase_price.'" data-sale_price="'.@$row['sale_price'].'" data-imei_no="'.@$row['imei2'].'" >
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-xs-center text">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;
            //   if ($i % 4 == 0) $out .= '</div><div class="row">';
        }

        echo $out;

    }

     public function pos_search()
    {
        
        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
           $qw = "(tbl_warehouse_serials.twid='$wid') AND ";           
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id,geopos_product_serials.purchase_id,geopos_product_serials.imei2,geopos_product_serials.purchase_pid';
            $join .= ' LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $join .= ' LEFT JOIN tbl_warehouse_serials ON tbl_warehouse_serials.serial_id=geopos_product_serials.id';  
            $qw .= '(tbl_warehouse_serials.status=1) AND ';
        }
        //$join .= 'LEFT JOIN tbl_warehouse_product ON tbl_warehouse_product.pid=geopos_products.pid ';

        $bar = '';
        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }

            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.*,geopos_product_serials.serial,geopos_product_serials.purchase_id,geopos_product_serials.purchase_pid FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "  OR geopos_products.warehouse_product_code LIKE '%" . $name . "%' OR geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";


        } else {
            $query = "SELECT count(tbl_warehouse_serials.id) as wqty,geopos_products.* $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' OR geopos_products.warehouse_product_code LIKE '%" . $name . "%' OR geopos_product_serials.serial LIKE '%" . $name . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (tbl_warehouse_serials.id!='') GROUP By(geopos_products.pid) LIMIT 16";

        }
        
       // echo $query; die;
        $query = $this->db->query($query);

        $result = $query->result_array();
        $i = 0;
        $total_price=0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {
                
                $purchase_price = $this->products->getPurchasePriceByPID($row['purchase_id'],$row['purchase_pid'])[0];
             

                
                $product_price_margin = "0.00";
                $gst_with_margin = "0.00";
                $product_type=0;

                if($purchase_price['type']==2)
                {
                    $product_type = 2;

                    $product_price_margin = $row['sale_price']-($purchase_price['price']+600);

                    $gst_with_margin = amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$row['taxrate'])));

                    $total_price = $row['sale_price']-$gst_with_margin;

                }
                else
                {
                    $total_price = $row['product_price'];
                }
                
                 


                

            $out .= '    <div class="col-3 border mb-1 "><div class="rounded">
                                 <a   id="posp' . $i . '"  class="select_pos_item btn btn-outline-light-blue round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '"   data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['wqty']) . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '" data-serial_id="' . @$row['serial_id'] . '" data-product_type="' . @$product_type . '" data-margin_gst_price="' . @$gst_with_margin . '" data-pruchase_price="'.$purchase_price['price'].'" data-sale_price="'.@$row['sale_price'].'" data-pruchase_price="'.$purchase_price.'" data-imei_no="'.@$row['imei2'].'" data-price_with_margin="'.$total_price.'" >
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-xs-center text">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;
            //   if ($i % 4 == 0) $out .= '</div><div class="row">';
        }

        echo $out;

    }
	
	public function pos_search1()
    {

        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND geopos_products.status=1 AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND geopos_products.status=1 AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid ';
            $qw .= '(geopos_product_serials.status=0) AND  ';
        }


        $bar = '';
        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }

            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT geopos_products.*,geopos_product_serials.serial FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (geopos_products.qty>0) GROUP By(geopos_products.pid) LIMIT 16";


        } else {
            $query = "SELECT geopos_products.* $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (geopos_products.qty>0) GROUP By(geopos_products.pid) LIMIT 16";

        }

		//echo $query; exit;
		
        $query = $this->db->query($query);

        $result = $query->result_array();
        $i = 0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {

            $out .= '    <div class="col-3 border mb-1 "><div class="rounded">
                                 <a   id="posp' . $i . '"  class="select_pos_item btn btn-outline-light-blue round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '"   data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['qty']) . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '">
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-xs-center text">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;
            //   if ($i % 4 == 0) $out .= '</div><div class="row">';
        }

        echo $out;

    }

    public function v2_pos_search()
    {

        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);


        $qw = '';

        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid ';
            $qw .= '(geopos_product_serials.status=0) AND  ';
        }

        $bar = '';

        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }
            //    echo(substr($barcode, 0, -1));
            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
            //  $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . " $bar AND (geopos_products.qty>0) LIMIT 16";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT geopos_products.*,geopos_product_serials.serial FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (geopos_products.qty>0) LIMIT 18";

        } else {
            $query = "SELECT geopos_products.* $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (geopos_products.qty>0) ORDER BY geopos_products.product_name LIMIT 18";
        }

        $query = $this->db->query($query);
        $result = $query->result_array();
        $i = 0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {

            $out .= '    <div class="col-2 border mb-1"  ><div class=" rounded" >
                                 <a  id="posp' . $i . '"  class="v2_select_pos_item round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '" data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['qty']) . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '">
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-center" style="margin-top: 4px;">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;

        }

        echo $out;

    }
    
	public function asset_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        //$wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            //$qw = "(tbl_asset.warehouse='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=tbl_asset.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=tbl_asset.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT tbl_asset.id,tbl_asset.asset_name,tbl_asset.product_code,tbl_asset.fproduct_price,tbl_asset.taxrate,tbl_asset.disrate,tbl_asset.product_des,tbl_asset.unit FROM tbl_asset $join WHERE " . $qw . "UPPER(tbl_asset.asset_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(tbl_asset.product_code) LIKE '" . strtoupper($name) . "%' LIMIT 150");

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['asset_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['id'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'], $row_num);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }
	
	public function sparepart_search()
    {
		$result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
		//$name ='b';
        //$wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) { 
            //$qw = "(tbl_asset.warehouse='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=tbl_component.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=tbl_component.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
			$sql ="SELECT tbl_component.id,tbl_component.component_name,tbl_component.product_code,tbl_component.fproduct_price,tbl_component.taxrate,tbl_component.disrate,tbl_component.product_des,tbl_component.unit FROM tbl_component $join WHERE " . $qw . "UPPER(tbl_component.component_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(tbl_component.product_code) LIKE '" . strtoupper($name) . "%' LIMIT 150";
            $query = $this->db->query($sql);

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['component_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['id'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'], $row_num);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }
	
	
	public function invoice2_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(b.twid='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
            //if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
             $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
			 $qw .= '(b.status=1 and is_present=1) AND ';
            //$qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
			
			$sql = "SELECT a.pid,a.merge,a.sub,a.product_name,
			a.product_code,a.fproduct_price,a.sale_price,a.product_price,a.taxrate,a.disrate,
			a.product_des,a.unit FROM geopos_products as a INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid WHERE " . $qw . " a.status=1 
			AND UPPER(a.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(a.product_code) 
			LIKE '" . strtoupper($name) . "%' GROUP BY(a.pid) LIMIT 6"; 
			
            $query = $this->db->query($sql);
			

            $result = $query->result_array();
			//print_r($result); exit;
            foreach ($result as $row) {
				if($row['merge'] == 0){
					//if($row['sub'] == 0){
						$name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
						array_push($out, $name);
					//}	
				}else{
					$name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
					array_push($out, $name);
                }
				
            }			
            echo json_encode($out);
        }
    }
	
	
	public function search_product_by_serialb2b()
    {
		$this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);	
		
        $wid = $this->input->post('wid', true);
        //$wid = 1;
        $qw = '';
        if ($wid > 0) {
            $qw = "(tbl_warehouse_serials.twid='$wid') AND tbl_warehouse_serials.status=1 AND tbl_warehouse_serials.is_present=1 AND";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
			$join .= ' LEFT JOIN tbl_warehouse_serials ON geopos_product_serials.id=tbl_warehouse_serials.serial_id';
			$join .= ' LEFT JOIN geopos_products ON geopos_product_serials.product_id=geopos_products.pid';  
            $qw .= '(geopos_product_serials.status=7) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty, geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.zobulk_sale_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '" . strtoupper($name) . "') GROUP By(geopos_products.pid)  LIMIT 6";
                $query = $this->db->query($sql);
				//$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.zobulk_sale_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '". strtoupper($name) . "') LIMIT 6";
               $query = $this->db->query($sql);
			   //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
			
			//echo $sql;
	
		    if($query->num_rows()==1)
            {
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['zobulk_sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            }
        }               
            echo json_encode($name);
        }
    }
	
	
	public function invoice2_searchb2b()
    {
		$result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(b.twid='$wid' ) AND b.status=1 AND b.is_present=1 AND";
        }
		
		//$qw = "(b.twid='$wid' ) AND ";
		
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
            //if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
             $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
			 $qw .= '(b.status=1 and is_present=1) AND ';
            //$qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
			
			$sql = "SELECT a.pid,a.merge,a.sub,a.product_name,
			a.product_code,a.fproduct_price,a.sale_price,a.product_price,a.zobulk_sale_price,a.taxrate,a.disrate,
			a.product_des,a.unit FROM geopos_products as a INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid WHERE " . $qw . " a.status=1 
			AND UPPER(a.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(a.product_code) 
			LIKE '" . strtoupper($name) . "%' GROUP BY(a.pid) LIMIT 6"; 
			
			//echo $sql; exit;
			
            $query = $this->db->query($sql);
			

            $result = $query->result_array();
			//print_r($result); exit;
            foreach ($result as $row) {
				if($row['merge'] == 0){
					if($row['sub'] == 0){
						$name = array($row['product_name'], amountExchange_s($row['zobulk_sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
						array_push($out, $name);
					}	
				}else{
					$name = array($row['product_name'], amountExchange_s($row['zobulk_sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
					array_push($out, $name);
                }
				
            }	

			
            echo json_encode($out);
        }
    }
	
	
	public function pos_c_search_b2b()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }

        if ($name) {
            $query = $this->db->query("SELECT id,name,phone,email FROM tbl_customers WHERE $whr type=2 AND (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"PselectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . " &nbsp; &nbsp  " . $row['email'] ."</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }
	
	
	public function stock_return()
    {
		$result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(b.twid='$wid' ) AND b.status=1 AND b.is_present=1 AND";
        }
		
		//$qw = "(b.twid='$wid' ) AND ";
		
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
            //if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
             $join = 'INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid';
			 $qw .= '(b.status=1 and is_present=1) AND ';
            //$qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
			
			$sql = "SELECT a.pid,a.merge,a.sub,a.product_name,
			a.product_code,a.fproduct_price,a.sale_price,a.product_price,a.zobulk_sale_price,a.taxrate,a.disrate,
			a.product_des,a.unit FROM geopos_products as a INNER JOIN tbl_warehouse_serials as b ON b.pid=a.pid WHERE " . $qw . " a.status=1 
			AND UPPER(a.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(a.product_code) 
			LIKE '" . strtoupper($name) . "%' GROUP BY(a.pid) LIMIT 6"; 
			
			//echo $sql; exit;
			
            $query = $this->db->query($sql);
			

            $result = $query->result_array();
			//print_r($result); exit;
            foreach ($result as $row) {
				if($row['merge'] == 0){
					if($row['sub'] == 0){
						$name = array($row['product_name'], amountExchange_s($row['sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
						array_push($out, $name);
					}	
				}else{
					$name = array($row['product_name'], amountExchange_s($row['sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'],$row_num);
					array_push($out, $name);
                }
				
            }	

			
            echo json_encode($out);
        }
    }
	
	
	public function search_product_by_serialsr()
    {
		$this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);	
		
        $wid = $this->input->post('wid', true);
        //$wid = 1;
        $qw = '';
        if ($wid > 0) {
            $qw = "(tbl_warehouse_serials.twid='$wid') AND tbl_warehouse_serials.status=1 AND tbl_warehouse_serials.is_present=1 AND";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
			$join .= ' LEFT JOIN tbl_warehouse_serials ON geopos_product_serials.id=tbl_warehouse_serials.serial_id';
			$join .= ' LEFT JOIN geopos_products ON geopos_product_serials.product_id=geopos_products.pid';  
            $qw .= '(geopos_product_serials.status=7) AND ';
        }

        if ($name) {

            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial,geopos_product_serials.id as serial_id';
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty, geopos_products.pid,geopos_products.product_name,geopos_products.sale_price,geopos_products.product_price,geopos_products.zobulk_sale_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '" . strtoupper($name) . "') GROUP By(geopos_products.pid)  LIMIT 150";
                $query = $this->db->query($sql);
				//$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid)  LIMIT 6");
            } else {
				$sql = "SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.sale_price,geopos_products.product_price,geopos_products.zobulk_sale_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_product_serials $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) = '". strtoupper($name) . "') LIMIT 150";
               $query = $this->db->query($sql);
			   //$query = $this->db->query("SELECT count(tbl_warehouse_serials.id) as qty,geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.hsn_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty as pqty,geopos_products.unit $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.hsn_code) LIKE '" . strtoupper($name) . "%') GROUP By(geopos_products.pid) LIMIT 6");
            }
			
			//echo $sql;
	
		    if($query->num_rows()==1)
            {
            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['sale_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['hsn_code'], amountFormat_general($row['qty']), $row_num, @$row['serial'], @$row['serial_id']);
                array_push($out, $name);
            }
        }               
            echo json_encode($name);
        }
    }

}