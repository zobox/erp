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

class Asset_Model extends CI_Model
{
    var $table = 'tbl_asset';
    var $column_order = array(null, 'tbl_asset.asset_name', 'tbl_asset.qty', 'tbl_asset.product_code', 'tbl_asset_cat.title', 'tbl_asset.product_price', null); //set column field database for datatable orderable
    var $column_search = array('tbl_asset.asset_name', 'tbl_asset.product_code', 'tbl_asset_cat.title', 'geopos_warehouse.title'); //set column field database for datatable searchable
    var $order = array('tbl_asset.id' => 'desc'); // default order
    var $asset_order = array('tbl_asset.id' => 'desc');
    var $asset_purchase_order = array('tbl_asset_purchase.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


  private function _get_datatables_query_asset($id = '', $w = '', $sub = '')
    {
        $this->db->select('tbl_asset.*,tbl_asset_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from("tbl_asset");
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse','left');
        if ($sub) {
            $this->db->join('tbl_asset_cat', 'tbl_asset_cat.id = tbl_asset.sub_id','left');

            if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("tbl_asset.sub_id=$id");

        } else {
            $this->db->join('tbl_asset_cat', 'tbl_asset_cat.id = tbl_asset.pcat','left');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('tbl_asset.sub_id', 0);
                }
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

            } else {

                if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset.merge', 0);
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
                if ($id > 0) {
                    $this->db->where("geopos_product_cat.id = $id");
                    $this->db->where('tbl_asset.sub_id', 0);
                }
            }
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
            $asset_order = $this->asset_order;
            $this->db->order_by(key($asset_order), $asset_order[key($asset_order)]);
        }

    }




    private function _get_datatables_query($id = '', $w = '', $sub = '')
    {
        $this->db->select('tbl_asset.*,geopos_product_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_asset.sub_id');

            if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("tbl_asset.sub_id=$id");

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_asset.pcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('tbl_asset.sub_id', 0);
                }
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

            } else {

                if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset.merge', 0);
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
                if ($id > 0) {
                    $this->db->where("geopos_product_cat.id = $id");
                    $this->db->where('tbl_asset.sub_id', 0);
                }
            }
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
	

     private function get_tbl_asset()
    {
            //$this->db->select('geopos_purchase.id,geopos_purchase.tid,geopos_purchase.invoicedate,geopos_purchase.invoiceduedate,geopos_purchase.total,geopos_purchase.status,geopos_purchase.items,geopos_supplier.name');
        $this->db->select('tbl_asset_purchase.id,tbl_asset_purchase.tid,tbl_asset_purchase.invoicedate,tbl_asset_purchase.invoiceduedate,tbl_asset_purchase.total,tbl_asset_purchase.status,tbl_asset_purchase.items,tbl_asset_purchase.pending_qty,geopos_supplier.name,geopos_supplier.company,geopos_supplier.id as supplier_id');
        $this->db->from("tbl_asset_purchase");
        $this->db->join('geopos_supplier', 'tbl_asset_purchase.csd=geopos_supplier.id', 'left');
            if ($this->aauth->get_user()->loc) {
            $this->db->where('tbl_asset_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('tbl_asset_purchase.loc', 0); }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(tbl_asset_purchase.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(tbl_asset_purchase.invoicedate) <=', datefordatabase($this->input->post('end_date')));
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
        } else if (isset($this->asset_purchase_order)) {
            $order = $this->asset_purchase_order;
            $this->db->order_by(key($asset_purchase_order), $asset_purchase_order[key($asset_purchase_order)]);
        }
     
        
    }

	
	private function _get_datatables_query_bundle($id = '', $w = '', $sub = '')
    {
        $this->db->select('tbl_asset_bundle.*,geopos_product_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset_bundle.warehouse');
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_asset_bundle.sub_id');

            //if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset_bundle.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("tbl_asset_bundle.sub_id=$id");

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_asset_bundle.bcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('tbl_asset.sub_id', 0);
                }
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

            } else {

                //if ($this->input->post('group') != 'yes') $this->db->where('tbl_asset.merge', 0);
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
                if ($id > 0) {
                    $this->db->where("geopos_product_cat.id = $id");
                   // $this->db->where('tbl_asset.sub_id', 0);
                }
            }
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
	

    function get_datatables($id = '', $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w, $sub);
        } else {
            $this->_get_datatables_query();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $query->result();
    }

    function get_datatables_asset($id = '', $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->get_tbl_asset($id, $w, $sub);
        } else {
            $this->get_tbl_asset();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $query->result();
    }

    
	
    function get_asset($id = '', $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query_asset($id, $w, $sub);
        } else {
            $this->_get_datatables_query_asset();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
    
         
        return $query->result();
    }
    
	
	function get_datatables_bundle($id = '', $w = '', $sub = '')
    {
       $this->db->select('a.bid as bundle_id');
	   $this->db->select('b.title as warehouse');
	   $this->db->select('c.title as category');
	   $this->db->select('a.product_code as code');
	   $this->db->from("tbl_asset_bundle as a");
	   $this->db->join('geopos_warehouse as b', 'a.warehouse = b.id', 'LEFT');
	   $this->db->join('geopos_product_cat as c', 'a.bcat = c.id', 'LEFT');
	   return $this->db->get()->result();	   
	}
	

    function count_filtered($id, $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w, $sub);
        } else {
            $this->_get_datatables_query();
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

     function count_filtered_asset()
    {  

         $this->get_tbl_asset();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        return $this->db->count_all_results();
    }


    public function count_all_asset()
    {
        $this->db->from('tbl_asset_purchase');
           if ($this->aauth->get_user()->loc) {
            $this->db->where('tbl_asset_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('tbl_asset_purchase.loc', 0); }
        return $this->db->count_all_results();
    }

    
    public function add_new_asset($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type = '', $w_stock = '', $w_alert = '', $sub_cat = '', $b_id = '', $serial = '',$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification)
    {
        $conditions = $this->input->post('conditions');
        $ware_valid = $this->valid_warehouse($warehouse);
        if (!$sub_cat) $sub_cat = 0;
        if (!$b_id) $b_id = 0;
        $datetime1 = new DateTime(date('Y-m-d'));

        $datetime2 = new DateTime($wdate);

        $difference = $datetime1->diff($datetime2);
        if (!$difference->d > 0) {
            $wdate = null;
        }
        
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'asset_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => $code_type,
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
                        'hsn_code' => $hsn_code,
                        'product_model' => $product_model,
                        'warehouse_product_name' => $warehouse_product_name,
                        'warehouse_product_code' => $warehouse_product_code,
                        'product_specification' => $product_specification
                    );

                } else {

                    $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);

                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'asset_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => 'EAN13',
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
                        'hsn_code' => $hsn_code,
                        'product_model' => $product_model,
                        'warehouse_product_name' => $warehouse_product_name,
                        'warehouse_product_code' => $warehouse_product_code,
                        'product_specification' => $product_specification
                    );
                }               
                
                
                if ($this->db->insert('tbl_asset', $data)) {
                    $pid = $this->db->insert_id();
                    //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
                /*if ($serial) {
                    $serial_group = array();
                    foreach ($serial as $key => $value) {
                         if($value) $serial_group[] = array('product_id' => $pid, 'serial' => $value);
                    }
                    $this->db->insert_batch('geopos_product_serials', $serial_group);
                }*/
                
                
                            
                if($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key]) {
                            $this->db->select('u.id,u.name,u2.name AS variation');
                            $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                            $this->db->where('u.id', $v_type[$key]);
                            $query = $this->db->get('geopos_units u');
                            $r_n = $query->row_array();
                            $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            if(count(($conditions[$key]))==0){  
                                $this->db->insert('tbl_asset', $data);
                            }
                           
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                                
                
                if ($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key]) {
                            $this->db->select('u.id,u.name,u2.name AS variation');
                            $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                            $this->db->where('u.id', $v_type[$key]);
                            $query = $this->db->get('geopos_units u');
                            $r_n = $query->row_array();
                            
                            $product_n = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            
                            foreach($conditions[$key] as $key1=>$cval){
                                $this->db->select('*');                             
                                $this->db->where('id', $cval);
                                $query = $this->db->get('geopos_conditions');
                                $r_c = $query->row_array();
                                $product_c = $product_n. '-' . $r_c['name'];
                                $data['product_name'] = $product_c;
                                $data['sub'] = $pid;
                                $data['vc'] = $cval;
                                $this->db->insert('tbl_asset', $data);
                            }                           
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                } 
                
                
                if ($w_type) {
                    foreach ($w_type as $key => $value) {
                        if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                            $data['product_name'] = $product_name;
                            $data['warehouse'] = $w_type[$key];
                            $data['qty'] = numberClean($w_stock[$key]);
                            $data['alert'] = numberClean($w_alert[$key]);
                            $data['merge'] = 2;
                            $data['sub'] = $pid;
                            $data['vb'] = $w_type[$key];
                            $this->db->insert('tbl_asset', $data);
                            $pidv = $this->db->insert_id();
                           // $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
        
            if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'asset_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'hsn_code' => $hsn_code,
                    'product_model' => $product_model,
                    'warehouse_product_name' => $warehouse_product_name,
                    'warehouse_product_code' => $warehouse_product_code,
                    'product_specification' => $product_specification
                );
            } else {
                $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'asset_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => 'EAN13',
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'hsn_code' => $hsn_code,
                    'product_model' => $product_model,
                    'warehouse_product_name' => $warehouse_product_name,
                    'warehouse_product_code' => $warehouse_product_code,
                    'product_specification' => $product_specification
                );
            }
           
            if ($this->db->insert('tbl_asset', $data)) {
                 $pid = $this->db->insert_id();
                 //echo $this->db->last_query();die;
                //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
            /*if ($serial) {
                $serial_group = array();
                foreach ($serial as $key => $value) {
                     if($value)  $serial_group[] = array('product_id' => $pid, 'serial' => $value);
                }
                $this->db->insert_batch('geopos_product_serials', $serial_group);
            }*/
            if ($v_type) {
                foreach ($v_type as $key => $value) {
                    if ($v_type[$key]) {
                        $this->db->select('u.id,u.name,u2.name AS variation');
                        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                        $this->db->where('u.id', $v_type[$key]);

                        $query = $this->db->get('geopos_units u');
                        
                        $r_n = $query->row_array();
                        $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        
                        if(count(($conditions[$key]))==0){                      
                            $this->db->insert('tbl_asset', $data);                        
                            $vid = $this->db->insert_id();
                        }
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $vid, $this->aauth->get_user()->username);
                    }
                }
            }
            
            if ($v_type) {
                foreach ($v_type as $key => $value) {
                    if ($v_type[$key]) {
                        $this->db->select('u.id,u.name,u2.name AS variation');
                        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                        $this->db->where('u.id', $v_type[$key]);
                        $query = $this->db->get('geopos_units u');
                        $r_n = $query->row_array();
                        
                        $product_n = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        
                        foreach($conditions[$key] as $key1=>$cval){
                            $this->db->select('*');                             
                            $this->db->where('id', $cval);
                            $query = $this->db->get('geopos_conditions');
                            $r_c = $query->row_array();
                            $product_c = $product_n. '-' . $r_c['name'];
                            $data['product_name'] = $product_c;
                            $data['sub'] = $pid;
                            $data['vc'] = $cval;
                            $this->db->insert('tbl_asset', $data);
                        }                           
                                                    
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
                
            
            if ($w_type) {
                foreach ($w_type as $key => $value) {
                    if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {

                        $data['product_name'] = $product_name;
                        $data['warehouse'] = $w_type[$key];
                        $data['qty'] = numberClean($w_stock[$key]);
                        $data['alert'] = numberClean($w_alert[$key]);
                        $data['merge'] = 2;
                        $data['sub'] = $pid;
                        $data['vb'] = $w_type[$key];
                        $this->db->insert('tbl_asset', $data);
                        $pidv = $this->db->insert_id();
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 4);
            

        }
    }
    
   
   public function edit_asset($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '', $vari = null, $serial = null,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code)
    {
        $this->db->select('qty');
        $this->db->from('tbl_asset');
        $this->db->where('id', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        $this->db->trans_start();
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'asset_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'hsn_code' => $hsn_code,
                    'product_model' => $product_model,
                    'warehouse_product_name' => $warehouse_product_name,
                    'warehouse_product_code' => $warehouse_product_code,
                    'product_specification' => $product_specification
                );

                $this->db->set($data);
                $this->db->where('id', $pid);

                if ($this->db->update('tbl_asset')) {
                   /* if ($r_n['qty'] != $product_qty) {
                        $m_product_qty = $product_qty - $r_n['qty'];
                        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                    }*/
                    $this->aauth->applog("[Update Asset] -$product_name  " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED') . " <a href='" . base_url('asset/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('asset') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            $data = array(
                'pcat' => $catid,
                'warehouse' => 1,
                'asset_name' => $product_name,
                'product_code' => $product_code,
                'product_price' => $product_price,
                'fproduct_price' => $factoryprice,
                'taxrate' => $taxrate,
                'disrate' => $disrate,
                'qty' => $product_qty,
                'product_des' => $product_desc,
                'alert' => $product_qty_alert,
                'unit' => $unit,
                'image' => $image,
                'barcode' => $barcode,
                'code_type' => $code_type,
                'sub_id' => $sub_cat,
                'b_id' => $b_id,
                 'hsn_code' => $hsn_code,
                 'product_model' => $product_model,
                 'warehouse_product_name' => $warehouse_product_name,
                 'warehouse_product_code' => $warehouse_product_code,
                 'product_specification' => $product_specification
            );
            $this->db->set($data);
            $this->db->where('id', $pid);
            if ($this->db->update('tbl_asset')) {
                /*if ($r_n['qty'] != $product_qty) {
                    $m_product_qty = $product_qty - $r_n['qty'];
                    $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                }*/
                
                $this->aauth->applog("[Update Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED') . " <a href='" . base_url('asset/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('asset') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        }

        /*if (isset($serial['old'])) {
            $this->db->delete('geopos_product_serials', array('product_id' => $pid,'status'=>0));
            $serial_group = array();
            foreach ($serial['old'] as $key => $value) {
                if($value) $serial_group[] = array('product_id' => $pid, 'serial' => $value);
            }
            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }*/
                /*if (isset($serial['new'])) {
            $serial_group = array();
            foreach ($serial['new'] as $key => $value) {
                 if($value)  $serial_group[] = array('product_id' => $pid, 'serial' => $value,'status'=>0);
            }

            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }*/
        $this->custom->edit_save_fields_data($pid, 4);


        $v_type = $vari['v_type'];
        $v_stock = $vari['v_stock'];
        $v_alert = $vari['v_alert'];
        $w_type = $vari['w_type'];
        $w_stock = $vari['w_stock'];
        $w_alert = $vari['w_alert'];

        if (isset($v_type)) {
                $this->db->where('sub',$pid);
                $this->db->delete('tbl_asset');
                
            foreach ($v_type as $key => $value) {
                if ($v_type[$key]) {
                    $this->db->select('u.id,u.name,u2.name AS variation');
                    $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                    $this->db->where('u.id', $v_type[$key]);
                    $query = $this->db->get('geopos_units u');
                    
                    $r_n = $query->row_array();
                    $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                    $data['qty'] = numberClean($v_stock[$key]);
                    $data['alert'] = numberClean($v_alert[$key]);
                    $data['merge'] = 1;
                    $data['sub'] = $pid;
                    $data['vb'] = $v_type[$key];
                    $this->db->insert('tbl_asset', $data);
                    //echo $this->db->last_query();die;
                    $pidv = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        if (isset($w_type)) {
            foreach ($w_type as $key => $value) {
                if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                    $data['product_name'] = $product_name;
                    $data['warehouse'] = $w_type[$key];
                    $data['qty'] = numberClean($w_stock[$key]);
                    $data['alert'] = numberClean($w_alert[$key]);
                    $data['merge'] = 2;
                    $data['sub'] = $pid;
                    $data['vb'] = $w_type[$key];
                    $this->db->insert('tbl_asset', $data);
                    $pidv = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Asset] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        $this->db->trans_complete();

    }








    public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '', $vari = null, $serial = null,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code)
    {
        $this->db->select('qty');
        $this->db->from('tbl_asset');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        $this->db->trans_start();
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
					'hsn_code' => $hsn_code,
					'product_model' => $product_model,
					'warehouse_product_name' => $warehouse_product_name,
					'warehouse_product_code' => $warehouse_product_code,
					'product_specification' => $product_specification
                );

                $this->db->set($data);
                $this->db->where('pid', $pid);

                if ($this->db->update('tbl_asset')) {
                   /* if ($r_n['qty'] != $product_qty) {
                        $m_product_qty = $product_qty - $r_n['qty'];
                        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                    }*/
                    $this->aauth->applog("[Update Product] -$product_name  " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            $data = array(
                'pcat' => $catid,
                'warehouse' => 1,
                'product_name' => $product_name,
                'product_code' => $product_code,
                'product_price' => $product_price,
                'fproduct_price' => $factoryprice,
                'taxrate' => $taxrate,
                'disrate' => $disrate,
                'qty' => $product_qty,
                'product_des' => $product_desc,
                'alert' => $product_qty_alert,
                'unit' => $unit,
                'image' => $image,
                'barcode' => $barcode,
                'code_type' => $code_type,
                'sub_id' => $sub_cat,
                'b_id' => $b_id,
				 'hsn_code' => $hsn_code,
				 'product_model' => $product_model,
				 'warehouse_product_name' => $warehouse_product_name,
				 'warehouse_product_code' => $warehouse_product_code,
				 'product_specification' => $product_specification
            );
            $this->db->set($data);
            $this->db->where('pid', $pid);
            if ($this->db->update('tbl_asset')) {
                /*if ($r_n['qty'] != $product_qty) {
                    $m_product_qty = $product_qty - $r_n['qty'];
                    $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                }*/
				
                $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        }

        /*if (isset($serial['old'])) {
            $this->db->delete('geopos_product_serials', array('product_id' => $pid,'status'=>0));
            $serial_group = array();
            foreach ($serial['old'] as $key => $value) {
                if($value) $serial_group[] = array('product_id' => $pid, 'serial' => $value);
            }
            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }*/
                /*if (isset($serial['new'])) {
            $serial_group = array();
            foreach ($serial['new'] as $key => $value) {
                 if($value)  $serial_group[] = array('product_id' => $pid, 'serial' => $value,'status'=>0);
            }

            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }*/
        $this->custom->edit_save_fields_data($pid, 4);


        $v_type = $vari['v_type'];
        $v_stock = $vari['v_stock'];
        $v_alert = $vari['v_alert'];
        $w_type = $vari['w_type'];
        $w_stock = $vari['w_stock'];
        $w_alert = $vari['w_alert'];

        if (isset($v_type)) {
				$this->db->where('sub',$pid);
				$this->db->delete('tbl_asset');
				
            foreach ($v_type as $key => $value) {
                if ($v_type[$key]) {
                    $this->db->select('u.id,u.name,u2.name AS variation');
                    $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                    $this->db->where('u.id', $v_type[$key]);
                    $query = $this->db->get('geopos_units u');
					
                    $r_n = $query->row_array();
                    $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                    $data['qty'] = numberClean($v_stock[$key]);
                    $data['alert'] = numberClean($v_alert[$key]);
                    $data['merge'] = 1;
                    $data['sub'] = $pid;
                    $data['vb'] = $v_type[$key];
                    $this->db->insert('tbl_asset', $data);
					//echo $this->db->last_query();die;
                    $pidv = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        if (isset($w_type)) {
            foreach ($w_type as $key => $value) {
                if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                    $data['product_name'] = $product_name;
                    $data['warehouse'] = $w_type[$key];
                    $data['qty'] = numberClean($w_stock[$key]);
                    $data['alert'] = numberClean($w_alert[$key]);
                    $data['merge'] = 2;
                    $data['sub'] = $pid;
                    $data['vb'] = $w_type[$key];
                    $this->db->insert('tbl_asset', $data);
                    $pidv = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        $this->db->trans_complete();

    }

    public function prd_stats()
    {

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = tbl_asset.warehouse WHERE geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
            if (BDATA) $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = tbl_asset.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
        } elseif (!BDATA) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = tbl_asset.warehouse WHERE geopos_warehouse.loc=0';
        }
        $query = $this->db->query("SELECT
COUNT(IF( tbl_asset.qty > 0, tbl_asset.qty, NULL)) AS instock,
COUNT(IF( tbl_asset.qty <= 0, tbl_asset.qty, NULL)) AS outofstock,
COUNT(tbl_asset.qty) AS total
FROM tbl_asset $whr");
        echo json_encode($query->result_array());
    }

   public function products_list($id, $term = '')
    {
        $this->db->select('tbl_asset.*');
        $this->db->from('tbl_asset');
        $this->db->where('tbl_asset.warehouse', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
            $this->db->where('geopos_warehouse.loc', 0);
        }
        if ($term) {
            $this->db->where("tbl_asset.asset_name LIKE '%$term%'");
            $this->db->or_where("tbl_asset.product_code LIKE '$term%'");
        }
        $this->db->join("geopos_product_serials","tbl_asset.id=geopos_product_serials.product_id","inner");
        $this->db->where("geopos_product_serials.status",1);
        $this->db->group_by("geopos_product_serials.product_id");
        $query = $this->db->get();
        return $query->result_array();

    }

    public function serial_list($wid,$pid, $term = '')
    {
        
        $this->db->select("b.serial,b.id");
        $this->db->from("tbl_asset as a");
        $this->db->join("geopos_product_serials as b","a.id=b.product_id",'LEFT');
        $this->db->where("a.warehouse",$wid);
        $this->db->where("a.id",$pid);
        $this->db->where("b.status",1);
        $query = $this->db->get();
        
        
        return $query->result_array();



    } 


    public function units()
    {
        $this->db->select('*');
        $this->db->from('geopos_units');
        $this->db->where('type', 0);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function serials($pid)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_serials');
        $this->db->where('product_id', $pid);

        $query = $this->db->get();
        return $query->result_array();


    }

    public function transfer($from_warehouse, $products_l, $to_warehouse, $qty)
    {
        $updateArray = array();
        $move = false;
        $qtyArray = explode(',', $qty);
        $this->db->select('title');
        $this->db->from('geopos_warehouse');
        $this->db->where('id', $to_warehouse);
        $query = $this->db->get();
        $to_warehouse_name = $query->row_array()['title'];

        $i = 0;
        foreach ($products_l as $row) {
            $qty = 0;
            if (array_key_exists($i, $qtyArray)) $qty = $qtyArray[$i];

            $this->db->select('*');
            $this->db->from('tbl_asset');
            $this->db->where('pid', $row);
            $query = $this->db->get();
            $pr = $query->row_array();
            $pr2 = $pr;
            $c_qty = $pr['qty'];
            if ($c_qty - $qty < 0) {

            } elseif ($c_qty - $qty == 0) {


                if ($pr['merge'] == 2) {

                    $this->db->select('pid,product_name');
                    $this->db->from('tbl_asset');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();

                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('tbl_asset');
                    $this->db->where('merge', 2);
                    $this->db->where('sub', $row);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                }


                $c_pid = $pr['pid'];
                $product_name = $pr['product_name'];

                if ($c_pid) {

                    $this->db->set('qty', "qty+$qty", FALSE);
                    $this->db->where('pid', $c_pid);
                    $this->db->update('tbl_asset');
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty ID " . $c_pid, $this->aauth->get_user()->username);
                    $this->db->delete('tbl_asset', array('pid' => $row));
                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));

                } else {
                    $updateArray[] = array(
                        'pid' => $row,
                        'warehouse' => $to_warehouse
                    );
                    $move = true;
                    $product_name = $pr2['product_name'];
                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));

                    $this->movers(1, $row, $qty, 0, 'Stock Transferred & Initialized W- ' . $to_warehouse_name);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty W- $to_warehouse_name PID " . $pr2['pid'], $this->aauth->get_user()->username);
                }


            } else {
                $data['product_name'] = $pr['product_name'];
                $data['pcat'] = $pr['pcat'];
                $data['warehouse'] = $to_warehouse;
                $data['product_name'] = $pr['product_name'];
                $data['product_code'] = $pr['product_code'];
                $data['product_price'] = $pr['product_price'];
                $data['fproduct_price'] = $pr['fproduct_price'];
                $data['taxrate'] = $pr['taxrate'];
                $data['disrate'] = $pr['disrate'];
                $data['qty'] = $qty;
                $data['product_des'] = $pr['product_des'];
                $data['alert'] = $pr['alert'];
                $data['	unit'] = $pr['unit'];
                $data['image'] = $pr['image'];
                $data['barcode'] = $pr['barcode'];
                $data['merge'] = 2;
                $data['sub'] = $row;
                $data['vb'] = $to_warehouse;
                if ($pr['merge'] == 2) {
                    $this->db->select('pid,product_name');
                    $this->db->from('tbl_asset');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('tbl_asset');
                    $this->db->where('merge', 2);
                    $this->db->where('sub', $row);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                }


                $c_pid = $pr['pid'];
                $product_name = $pr2['product_name'];

                if ($c_pid) {

                    $this->db->set('qty', "qty+$qty", FALSE);
                    $this->db->where('pid', $c_pid);
                    $this->db->update('tbl_asset');

                    $this->movers(1, $c_pid, $qty, 0, 'Stock Transferred W ' . $to_warehouse_name);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty W $to_warehouse_name  ID " . $c_pid, $this->aauth->get_user()->username);


                } else {
                    $this->db->insert('tbl_asset', $data);
                    $pid = $this->db->insert_id();
                    $this->movers(1, $pid, $qty, 0, 'Stock Transferred & Initialized W ' . $to_warehouse_name);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty  W $to_warehouse_name ID " . $pr2['pid'], $this->aauth->get_user()->username);

                }

                $this->db->set('qty', "qty-$qty", FALSE);
                $this->db->where('pid', $row);
                $this->db->update('tbl_asset');
                $this->movers(1, $row, -$qty, 0, 'Stock Transferred WID ' . $to_warehouse_name);
            }


            $i++;
        }

        if ($move) {
            $this->db->update_batch('tbl_asset', $updateArray, 'pid');
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));


    }

    public function meta_delete($name)
    {
        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {
            return true;
        }
    }

    public function valid_warehouse($warehouse)
    {
        $this->db->select('id,loc');
        $this->db->from('geopos_warehouse');
        $this->db->where('id', $warehouse);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }


    public function movers($type = 0, $rid1 = 0, $rid2 = 0, $rid3 = 0, $note = '')
    {
        $data = array(
            'd_type' => $type,
            'rid1' => $rid1,
            'rid2' => $rid2,
            'rid3' => $rid3,
            'note' => $note
        );
        $this->db->insert('geopos_movers', $data);
    }
	
	public function getAllProducts(){
		$query = $this->db->get('tbl_asset');
		if($query->num_rows() > 0){
			foreach($query->result() as $key=>$row){
				$data[] = $row;
			}
			return $data;
		}	
		return false;
	}
	
	public function saveBundle(){
		$data['product_in'] = $this->input->post('product_in',true);
		$data['unit'] = $this->input->post('unit',true);
		$pid = $this->input->post('pid',true);
		$pqty = $this->input->post('pqty',true);
		$data['bcat'] = end($this->input->post('product_cat',true));
		$data['warehouse_product_name'] = $this->input->post('warehouse_product_name',true);
		$data['warehouse_product_code'] = $this->input->post('warehouse_product_code',true);
		$data['product_specification'] = $this->input->post('product_specification',true);
		$data['product_des'] = $this->input->post('product_desc',true);
		$data['code_type'] = $this->input->post('code_type',true);
		$data['barcode'] = $this->input->post('barcode',true);
		$data['warehouse'] = $this->input->post('product_warehouse',true); 
		$data['product_code'] = $this->input->post('warehouse_product_code',true);
		$data['hsn_code'] = $this->input->post('warehouse_product_code',true);
		if (strlen($data['barcode']) < 5 && !is_numeric($data['barcode'])) {
		
			$data['barcode'] = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
		}
		$data['alert'] = $this->input->post('product_qty_alert');
		$data['image'] = $this->input->post('image');
		
		if ($this->db->insert('tbl_asset_bundle', $data)) {
                    $bid = $this->db->insert_id();
					$this->aauth->applog("[New Bundle Product] -$bid  " . $bid, $this->aauth->get_user()->username);
                    foreach($pid as $key=>$row){
						$data2['bid'] = $bid;
						$data2['pid'] = $row;
						$data2['pqty'] = $pqty[$key];
						//print_r($data2);die;
						if($this->db->insert('tbl_asset_bundle_combination', $data2)){
							$bcid = $this->db->insert_id();
							$this->aauth->applog("[New Bundle Product Combination] -$bcid  " . $bcid, $this->aauth->get_user()->username);
						}
						
					}
					return true;
                } else {
                    return false;
                }
	}
	
	public function editBundle($id){
		$data['product_in'] = $this->input->post('product_in',true);
		$data['unit'] = $this->input->post('unit',true);
		$pid = $this->input->post('pid',true);
		$pqty = $this->input->post('pqty',true);
		$data['bcat'] = end($this->input->post('product_cat',true));
		if($data['bcat'] == ''){
			$data['bcat'] = $this->input->post('product_cat',true);
			array_pop($data['bcat']);
			$data['bcat'] = end($data['bcat']);
		}
		
		$data['warehouse_product_name'] = $this->input->post('warehouse_product_name',true);
		$data['warehouse_product_code'] = $this->input->post('warehouse_product_code',true);
		$data['product_specification'] = $this->input->post('product_specification',true);
		$data['product_des'] = $this->input->post('product_desc',true);
		$data['code_type'] = $this->input->post('code_type',true);
		$data['barcode'] = $this->input->post('barcode',true);
		$data['warehouse'] = $this->input->post('product_warehouse',true); 
		$data['product_code'] = $this->input->post('warehouse_product_code',true);
		$data['hsn_code'] = $this->input->post('warehouse_product_code',true);
		if (strlen($data['barcode']) < 5 && !is_numeric($data['barcode'])) {
		
			$data['barcode'] = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
		}
		$data['alert'] = $this->input->post('product_qty_alert');
		$data['image'] = $this->input->post('image');
		//print_r($data);die;
		$this->db->where('bid',$id);
		if ($this->db->update('tbl_asset_bundle', $data)) {
                    
					$this->aauth->applog("[Update Bundle Product] -$id  " . $id, $this->aauth->get_user()->username);
					$this->db->where('bid',$id);
					$this->db->delete('tbl_asset_bundle_combination');
                    foreach($pid as $key=>$row){
						$data2['bid'] = $id;
						$data2['pid'] = $row;
						$data2['pqty'] = $pqty[$key];
						//print_r($data2);die;
						if($this->db->insert('tbl_asset_bundle_combination', $data2)){
							$bcid = $this->db->insert_id();
							$this->aauth->applog("[New Bundle Product Combination] -$bcid  " . $bcid, $this->aauth->get_user()->username);
						}
						
					}
					return true;
                } else {
                    return false;
                }
		
	}
	
	public function getBundleProductDetails($bundleid = ''){
		if($bundleid != ''){
			$this->db->where('bid',$bundleid);
		}
		$query = $this->db->get('tbl_asset_bundle');
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data = $row;
			}
		return $data;
		}
		return false;
	}
	public function getProductBundleDetails($bundleid){
		$this->db->select('pid');
		$this->db->select('pqty');
		$this->db->where('bid',$bundleid);
		$query = $this->db->get('tbl_asset_bundle_combination')->result();
		foreach($query as $row){
			$productId = $row->pid;
			$productQuantity = $row->pqty;
			$this->db->select('product_name');
			$this->db->where('pid',$productId);
			$result = $this->db->get('tbl_asset')->result();
			//echo $this->db->last_query();die;
			foreach($result as $rows){
				$product_name = $rows->product_name;
			}
			$arr['productId'] = $productId;
			$arr['productQuantity'] = $productQuantity;
			$arr['product_name'] = $product_name;
			$data[] = $arr;
		}
		return $data;
		
	}
	
	public function getvariantById($pid){
		$this->db->where('sub',$pid);
		$query = $this->db->get('tbl_asset');
		foreach($query->result() as $row){
			$data[] = $row;
		}
		return $data;
	}
	
	public function getproductByCatId($cid){		
		$this->db->where('pcat',$cid);
		$this->db->where('sub',0);
		$query = $this->db->get('tbl_asset');	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->varient = $this->getvariantById($row->pid);
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}
	
	public function getproductById($pid){		
		$this->db->where('pid',$pid);		
		$query = $this->db->get('tbl_asset');		
		foreach($query->result() as $row){				
			$data = $row;
		}
		return $data;
	}
	
	public function getAllproductByCatId($cid){			
		$this->db->where('pcat',$cid);		
		$query = $this->db->get('tbl_asset');	
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){				
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}
	
	public function refurbishmentCostProductList(){
		$this->db->where('refurbishment_cost !=',0);		
		$query = $this->db->get('tbl_asset');	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){	
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}
	
	public function refurbishmentCostProductListByCatId($cid,$action){		
		$this->db->where('pcat',$cid);
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
		$query = $this->db->get('tbl_asset');	
		if($query->num_rows() > 0){
			foreach($query->result() as $row){				
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data[] = $row;
			}
			return $data;
		}else{
			return false;
		}
	}
	
	public function getRecordById($id){
		$this->db->where("pid",$id);				
		$query = $this->db->get("tbl_asset");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {
				$row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function save_editcost($action,$id){
		$type = $this->input->post('type');		
		$cost = $this->input->post('cost');
		
		switch($action){
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
		}
		
		$this->db->where('pid', $id);
		$this->db->update('tbl_asset',$data);	
		
		//Update Cost in History Log
		$data_history['pid'] = $id;
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
	
	
	public function getCostByProductName($name){
		$this->db->where("product_name",$name);				
		$query = $this->db->get("tbl_asset");
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){				
				$row->parent_category_ids = $this->categories_model->parentCategoryIds_list($row->pcat);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	public function setSalePrice(){
		$data['pid'] = $this->input->post('pid',true);
		$data['purchase_price'] = $this->input->post('purchase_price',true);
		$data['sale_price'] = $this->input->post('sale_price',true);		
		$data['gst'] = $this->input->post('gst',true);		
		$data['discount'] = $this->input->post('discount',true);
		$data['average_market_price'] = $this->input->post('average_market_price',true);		
		$data['refurbishment_cost'] = $this->input->post('refurbishment_cost',true);
		$data['packaging_cost'] = $this->input->post('packaging_cost',true);
		$data['sales_support'] = $this->input->post('sales_support',true);
		$data['promotion_cost'] = $this->input->post('promotion_cost',true);
		$data['hindizo_infra'] = $this->input->post('hindizo_infra',true);
		$data['hindizo_margin'] = $this->input->post('hindizo_margin',true);
		$data['logged_user_id'] = $_SESSION['id'];
		$data['date_created'] = date('Y-m-d H:i:s');
		
		$pid = $this->input->post('pid',true);
		
		if($pid !=''){
			if($data['sale_price'] >0 ){
				if ($this->db->insert('geopos_sale_price_calculator', $data)) {
					$id = $this->db->insert_id();
					
					$net_price = ($this->input->post('sale_price',true)*100)/(100+$this->input->post('gst',true));
					$net_price = number_format((float)$net_price, 2, '.', '');
					$data1['sale_price'] = $this->input->post('sale_price',true);					
					$data1['product_price'] = $net_price;			
					$data1['taxrate'] = $this->input->post('gst',true);					
					$data1['hindizo_margin'] = $this->input->post('hindizo_margin',true);
					$data1['hindizo_margin_type'] = $this->input->post('hindizo_margin_type',true);
					$this->db->where('pid',$pid);
					//$this->db->where('hindizo_margin !=',$data1['hindizo_margin']);
					$this->db->update('tbl_asset', $data1);					
					$sale_price = $data['sale_price'];
					$this->aauth->applog("[Sale Price] - $sale_price ID " . $id, $this->aauth->get_user()->username);
					echo json_encode(array('status' => 'Success', 'message' =>
						$this->lang->line('ADDED')));
				} else {
					echo json_encode(array('status' => 'Error', 'message' =>
						'Sale Price Not Set !'));
				}
			}else{
				echo json_encode(array('status' => 'Error', 'message' =>
						'Sale Price Should be Greater than 0'));
			}
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>
						'Product Not Available in Master Warehouse !'));
		}
	}
	
	
	
	public function getcostStructureByProductName($product_name){
		$product_records = $this->products->getCostByProductName($product_name);
						
			$data['product']['refurbishment_cost']  = $product_records->refurbishment_cost;
			$data['product']['refurbishment_cost_type'] = $product_records->refurbishment_cost_type;
			$data['product']['packaging_cost'] = $product_records->packaging_cost;
			$data['product']['packaging_cost_type'] = $product_records->packaging_cost_type;
			$data['product']['sales_support']	= $product_records->sales_support;
			$data['product']['sales_support_type']  = $product_records->sales_support_type;
			$data['product']['promotion_cost']  = $product_records->promotion_cost;
			$data['product']['promotion_cost_type']  = $product_records->promotion_cost_type;
			$data['product']['hindizo_infra']  = $product_records->hindizo_infra;
			$data['product']['hindizo_infra_type']  = $product_records->hindizo_infra_type;
			$data['product']['hindizo_margin']  = $product_records->hindizo_margin;
			$data['product']['hindizo_margin_type']  = $product_records->hindizo_margin_type;
			
		
			$refurbishment_cost = $data['product']['refurbishment_cost'];
			$refurbishment_cost_type = $data['product']['refurbishment_cost_type'];
			$packaging_cost = $data['product']['packaging_cost'];
			$packaging_cost_type = $data['product']['packaging_cost_type'];
			$sales_support = $data['product']['sales_support'];
			$sales_support_type = $data['product']['sales_support_type'];
			$promotion_cost = $data['product']['promotion_cost'];
			$promotion_cost_type = $data['product']['promotion_cost_type'];
			$hindizo_infra = $data['product']['hindizo_infra'];
			$hindizo_infra_type = $data['product']['hindizo_infra_type'];
			$hindizo_margin = $data['product']['hindizo_margin'];
			$hindizo_margin_type = $data['product']['hindizo_margin_type'];		
			
			
			$retail_commision_percentage=0;
			$b2c_comission_percentage=0;
			$bulk_commision_percentage=0;
			$renting_commision_percentage=0;
			
			foreach($product_records->parent_category_ids as $key=>$cat_id){
				
				$retail_commision_percentage_temp  = $this->products->getCatCommisionMax($module_id='',$cat_id,$purpose=2,$franchise_id='',$commissiontype='retail_commision_percentage');
				$b2c_comission_percentage_temp   = $this->products->getCatCommisionMax($module_id='',$cat_id,$purpose=2,$franchise_id='',$commissiontype='b2c_comission_percentage');
				$bulk_commision_percentage_temp   = $this->products->getCatCommisionMax($module_id='',$cat_id,$purpose=2,$franchise_id='',$commissiontype='bulk_commision_percentage');
				$renting_commision_percentage_temp   = $this->products->getCatCommisionMax($module_id='',$cat_id,$purpose=2,$franchise_id='',$commissiontype='renting_commision_percentage');
				
				$data['cat']['retail_commision_percentage'][$cat_id]  = $retail_commision_percentage;
				$data['cat']['b2c_comission_percentage'][$cat_id]  = $b2c_comission_percentage;
				$data['cat']['bulk_commision_percentage'][$cat_id]  = $bulk_commision_percentage;
				$data['cat']['renting_commision_percentage'][$cat_id]  = $renting_commision_percentage;
				
			
				$cat_records = $this->categories_model->getRecordById($cat_id);
				$data['cat']['refurbishment_cost'][$cat_id]  = $cat_records->refurbishment_cost;
				$data['cat']['refurbishment_cost_type'][$cat_id] = $cat_records->refurbishment_cost_type;
				$data['cat']['packaging_cost'][$cat_id] = $cat_records->packaging_cost;
				$data['cat']['packaging_cost_type'][$cat_id] = $cat_records->packaging_cost_type;
				$data['cat']['sales_support'][$cat_id]	= $cat_records->sales_support;
				$data['cat']['sales_support_type'][$cat_id]  = $cat_records->sales_support_type;
				$data['cat']['promotion_cost'][$cat_id]  = $cat_records->promotion_cost;
				$data['cat']['promotion_cost_type'][$cat_id]  = $cat_records->promotion_cost_type;
				$data['cat']['hindizo_infra'][$cat_id]  = $cat_records->hindizo_infra;
				$data['cat']['hindizo_infra_type'][$cat_id]  = $cat_records->hindizo_infra_type;
				$data['cat']['hindizo_margin'][$cat_id]  = $cat_records->hindizo_margin;
				$data['cat']['hindizo_margin_type'][$cat_id]  = $cat_records->hindizo_margin_type;
				
				if($refurbishment_cost==0){
					$refurbishment_cost = $cat_records->refurbishment_cost;
					$refurbishment_cost_type = $cat_records->refurbishment_cost_type;
				}
				
				if($packaging_cost==0){
					$packaging_cost = $cat_records->packaging_cost;
					$packaging_cost_type = $cat_records->packaging_cost_type;
				}
				
				if($sales_support==0){
					$sales_support = $cat_records->sales_support;
					$sales_support_type = $cat_records->sales_support_type;
				}
				
				if($promotion_cost==0){
					$promotion_cost = $cat_records->promotion_cost;
					$promotion_cost_type = $cat_records->promotion_cost_type;
				}
				
				if($hindizo_infra==0){
					$hindizo_infra = $cat_records->hindizo_infra;
					$hindizo_infra_type = $cat_records->hindizo_infra_type;
				}
				
				if($hindizo_margin==0){
					$hindizo_margin = $cat_records->hindizo_margin;
					$hindizo_margin_type = $cat_records->hindizo_margin_type;
				}
				
				if($retail_commision_percentage==0){
					$retail_commision_percentage = $retail_commision_percentage_temp;					
				}
				
				if($b2c_comission_percentage==0){
					$b2c_comission_percentage = $b2c_comission_percentage_temp;					
				}
				
				if($bulk_commision_percentage==0){
					$bulk_commision_percentage = $bulk_commision_percentage_temp;					
				}
				
				if($renting_commision_percentage==0){
					$renting_commision_percentage = $renting_commision_percentage_temp;					
				}
				
			}
			
			$cost['refurbishment_cost'] = $refurbishment_cost;
			$cost['refurbishment_cost_type'] = $refurbishment_cost_type;
			$cost['packaging_cost'] = $packaging_cost;
			$cost['packaging_cost_type'] = $packaging_cost_type;
			$cost['sales_support'] = $sales_support;
			$cost['sales_support_type'] = $sales_support_type;
			$cost['promotion_cost'] = $promotion_cost;
			$cost['promotion_cost_type'] = $promotion_cost_type;
			$cost['hindizo_infra'] = $hindizo_infra;
			$cost['hindizo_infra_type'] = $hindizo_infra_type;
			$cost['hindizo_margin'] = $hindizo_margin;
			$cost['hindizo_margin_type'] = $hindizo_margin_type;
			$cost['retail_commision_percentage'] = $retail_commision_percentage;
			$cost['b2c_comission_percentage'] = $b2c_comission_percentage;
			$cost['bulk_commision_percentage'] = $bulk_commision_percentage;
			$cost['renting_commision_percentage'] = $renting_commision_percentage;
			$cost['pid'] = $product_records->pid;
			
			return $cost;
	}
	
	
	public function getCatCommisionMax($module_id='',$category_id='',$purpose='',$franchise_id='',$commissiontype=''){		
		if($franchise_id)
		$this->db->where('franchise_id', $franchise_id);
		if($module_id)
		$this->db->where('module_id', $module_id);
		if($category_id)
        $this->db->where('category_id', $category_id);
		if($purpose)
        $this->db->where('purpose', $purpose);
		$this->db->order_by($commissiontype,'DESC');
		$this->db->limit(1);
		$query = $this->db->get("franchise_category_commision_slab_master");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				if($purpose==''){
					$data[] = $row->$commissiontype;
				}else{
					$data = $row->$commissiontype;
				}
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getAllPCategoryByProductID($pid){
		$this->db->where("pid",$pid);				
		$query = $this->db->get("tbl_asset");
		//echo $this->db->last_query(); exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){				
				$row->parent_category_ids = $this->categories_model->parentCategoryIds_list($row->pcat);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getFranchiseCommissionByProductID($module_id='',$pid='',$purpose='',$franchise_id='',$commissiontype=''){
		$pcat = $this->getAllPCategoryByProductID($pid);
		foreach($pcat->parent_category_ids as $key=>$cat){
			if($franchise_id)
			$this->db->where('franchise_id', $franchise_id);
			if($module_id)
			$this->db->where('module_id', $module_id);
			if($cat)
			$this->db->where('category_id', $cat);
			if($purpose)
			$this->db->where('purpose', $purpose);
			$this->db->order_by($commissiontype,'DESC');
			$this->db->limit(1);
			$query = $this->db->get("franchise_category_commision_slab_master");
			//echo $this->db->last_query(); //exit;
			$data = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {	
					if($purpose==''){
						$data[] = $row->$commissiontype;
					}else{
						$data = $row->$commissiontype;
					}
				}			
				return $data;
			}
			//return false;
		}
		
		// For Global Commission
		foreach($pcat->parent_category_ids as $key=>$cat){			
			$this->db->where('franchise_id', 0);
			if($module_id)
			$this->db->where('module_id', $module_id);
			if($cat)
			$this->db->where('category_id', $cat);
			if($purpose)
			$this->db->where('purpose', $purpose);
			$this->db->order_by($commissiontype,'DESC');
			$this->db->limit(1);
			$query = $this->db->get("franchise_category_commision_slab_master");
			//echo $this->db->last_query(); //exit;
			$data = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $key=>$row) {	
					if($purpose==''){
						$data[] = $row->$commissiontype;
					}else{
						$data = $row->$commissiontype;
					}
				}			
				return $data;
			}
			//return false;
		}
		return 0;
		
	}
	
	
	public function getRecordsByProductName($name){
		$this->db->where("product_name",$name);				
		$query = $this->db->get("tbl_asset");
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row){				
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}


    public function purchase_details($id)
    {
        
        $this->db->select('tbl_asset_purchase.*,tbl_asset_purchase.id AS iid,SUM(tbl_asset_purchase.shipping + tbl_asset_purchase.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from("tbl_asset_purchase");
        $this->db->where('tbl_asset_purchase.id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('tbl_asset_purchase.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('tbl_asset_purchase.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('tbl_asset_purchase.loc', 0);
        }
        $this->db->join('geopos_supplier', 'tbl_asset_purchase.csd = geopos_supplier.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = tbl_asset_purchase.term', 'left');
        $query = $this->db->get();

        return $query->row_array();

    }


     public function purchase_products($id)
    {
        $this->db->select('tbl_asset_warehouse.*,tbl_asset_warehouse.asset as product,geopos_customers.name');
        $this->db->select('tbl_asset.hsn_code');
        $this->db->from('tbl_asset_warehouse');
        $this->db->where('tbl_asset_warehouse.tid', $id);
        $this->db->join('tbl_asset', 'tbl_asset.id = tbl_asset_warehouse.aid', 'left');
        $this->db->join('geopos_customers',"tbl_asset_warehouse.cid=geopos_customers.id",'left');

        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result_array();
    }

      public function purchase_transactions($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_metadata as m');
        $this->db->join('geopos_transactions as t','m.id=t.tid','left');
        $this->db->where('m.invoice_id', $id);
        $this->db->where('t.ext', 1);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
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



public function lastpurchase()
    {
        $this->db->select('tid');
        $this->db->from("tbl_asset_purchase");
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
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

     public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 4);
        $this->db->where('geopos_metadata.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProductRecords(){
        //$term = $this->input->post('term');
        
        $this->db->select("w.id as warehouse_id,w.title,c.name,c.id");
        $this->db->from("geopos_customers as c");
        $this->db->join("geopos_warehouse as w","c.id=w.cid","left");

        //$this->db->like('c.name', $term);
        //$this->db->or_like('c.franchise_code', $term);
        $this->db->group_by("c.id");
        $this->db->order_by('c.name','ASC');
        $query = $this->db->get();
        
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row) {                                  
                $data[] = $row;
            }           
            return $data;
        }
        return false;
    }

public function brand_list()
    {
        $query = $this->db->query("SELECT * FROM tbl_asset_brand WHERE 1 ORDER BY id DESC");
        return $query->result_array();
    }
        public function updatestatus($status,$id){ 
    
        
        $data = array();        
            $data['franchies_status'] = $status;             
            $data['date_modified']=date('Y-m-d H:i:s');     
            $this->db->where('id', $id);
            $this->db->update('tbl_asset_purchase',$data);            
           // echo  $this->db->last_query(); exit;
            return true; 
    }

     public function addnewbrand($brand_name, $brand_desc)
    {
        $data = array(
            'brand_name' => $brand_name,
            'description' => $brand_desc,
            'add_date' => date('Y-m-d H:i:s')           
        );

        
        $url = "<a href='" . base_url('asset/asset_brand_add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset/assetbrand') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        

        if ($this->db->insert('tbl_asset_brand', $data)) {
            $this->aauth->applog("[Asset Brand Created] $brand_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function getBrand()
    {
        $query = $this->db->query("SELECT * FROM tbl_asset_brand");
        return $query->result_array();
    }
    public function getBrandById($id='')
    {
        $this->db->where('id', $id);        
        $query = $this->db->get('tbl_asset_brand');
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row) {                          
                $data = $row;
            }           
            return $data;
        }
        return false;
    }
    public function brandedit($catid, $name, $desc)
    {         
        $data = array(
            'brand_name' => $name,
            'description' => $desc,
            'add_date' => date('Y-m-d H:i:s')           
        );
        $this->db->set($data);
        $this->db->where('id', $catid);
        $url = "<a href='" . base_url('asset/asset_brand_add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset/productbrand') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        if ($this->db->update('tbl_asset_brand')) {            
            $this->aauth->applog("[Asset Brand Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'). " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function addnewCategory($cat_name, $cat_desc, $cat_type = 0, $cat_rel = 0)
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
            $url = "<a href='" . base_url('asset/addasset_category') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset/category_view?id=' . $cat_rel) . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        } else {
            $url = "<a href='" . base_url('asset/addasset_category') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('asset/assetcategory') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        }
        
        if ($this->db->insert('tbl_asset_cat', $data)) {
            $this->aauth->applog("[Asset Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function category_stock()
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }
        
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM tbl_asset_cat AS c LEFT JOIN ( SELECT tbl_asset.pcat,COUNT(tbl_asset.id) AS pc,SUM(tbl_asset.product_price*tbl_asset.qty) AS salessum, SUM(tbl_asset.fproduct_price*tbl_asset.qty) AS worthsum,SUM(tbl_asset.qty) AS qty FROM tbl_asset LEFT JOIN geopos_warehouse ON tbl_asset.warehouse=geopos_warehouse.id  $whr GROUP BY tbl_asset.pcat ) AS p ON c.id=p.pcat WHERE c.c_type=0");
        return $query->result_array();
    }

    public function category_list_dropdown($type=0, $rel=0)
    {   
        if($type !=NULL)
        $this->db->where("c_type",$type);
        if($rel !=NULL)
        $this->db->where("rel_id",$rel);        
        $this->db->order_by("id","asc");        
        $query = $this->db->get("tbl_asset_cat");
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

    public function GetParentCatTitleById($rel_id)
    {       
        $this->db->where("id",$rel_id);     
        $query = $this->db->get("tbl_asset_cat");      
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
    

    public function category_sub_stock($id = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $whr2 = '';

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty,p.sub_id FROM tbl_asset_cat AS c LEFT JOIN ( SELECT tbl_asset.sub_id,COUNT(tbl_asset.id) AS pc,SUM(tbl_asset.product_price*tbl_asset.qty) AS salessum, SUM(tbl_asset.fproduct_price*tbl_asset.qty) AS worthsum,SUM(tbl_asset.qty) AS qty FROM tbl_asset LEFT JOIN geopos_warehouse ON tbl_asset.warehouse=geopos_warehouse.id  $whr GROUP BY tbl_asset.sub_id ) AS p ON c.id=p.sub_id WHERE c.c_type=1 AND c.rel_id='$id'");
        return $query->result_array();
    }

    public function category_list($type = 0, $rel = 0)
    {
        $query = $this->db->query("SELECT id,title
        FROM tbl_asset_cat WHERE c_type='$type' AND rel_id='$rel'

        ORDER BY id DESC");
        return $query->result_array();
    }


     public function asset_cat_edit($catid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type)
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
        if ($this->db->update('tbl_asset_cat')) {
            if ($cat_type != $old_cat_type && $cat_type && $cat_type) {
                $data = array('pcat' => $cat_rel);
                $this->db->set($data);
                $this->db->where('sub_id', $catid);
                $this->db->update('tbl_asset');
            }
            $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
       

       public function lastAssetId()
    {
        $this->db->select('id');
        $this->db->from("tbl_asset");
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        //$this->db->where('i_class', 0);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return 9500000000000+($query->row()->id+1);
        } else {
            return 9500000000000;
        }
    }


    public function getParentcategory($cat){
        //$data[] = $cat;
        $this->db->where('id',$cat);
        $query = $this->db->get('tbl_asset_cat');
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

     public function sub_cat_curr($id = 0)
    {
        $this->db->select('*');
        $this->db->from('tbl_asset_cat');
        $this->db->where('id', $id);
        $this->db->where('c_type', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function cat_ware($id, $loc = 0)
    {
        $qj = '';
        if ($loc) $qj = "AND w.loc='$loc'";
        $query = $this->db->query("SELECT c.id AS cid, w.id AS wid,c.title AS catt,w.title AS watt FROM tbl_asset AS p LEFT JOIN tbl_asset_cat AS c ON p.pcat=c.id LEFT JOIN geopos_warehouse AS w ON p.warehouse=w.id WHERE
        p.id='$id' $qj ");
        return $query->row_array();
    }

     public function sub_cat_list($id = 0)
    {
        $this->db->select('*');
        $this->db->from('tbl_asset_cat');
        $this->db->where('rel_id', $id);
        $this->db->where('c_type', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
}