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

class Products_model extends CI_Model
{
    var $table = 'geopos_products';
    var $column_order = array(null, 'geopos_products.product_name', 'geopos_products.qty', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_products.product_price', null); //set column field database for datatable orderable
    var $column_search = array('geopos_products.product_name', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_warehouse.title'); //set column field database for datatable searchable

    var $component_search = array('tbl_component.component_name', 'tbl_component.product_code');
    var $component_order = array(null, 'tbl_component.component_name', 'tbl_component.qty', 'tbl_component.product_code','tbl_component.product_price', null);
    var $component_product_order = array('tbl_component.id' => 'desc');
    var $order = array('geopos_products.pid' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
     private function _get_datatables_query_component($id = '', $w = '', $sub = '')
    {
        $this->db->select('tbl_component.*,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from("tbl_component");
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_component.warehouse');
        if ($sub) {
            //$this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_component.sub_id');

            if ($this->input->post('group') != 'yes') $this->db->where('tbl_component.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("tbl_component.sub_id=$id");

        } else {
           // $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_component.pcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('tbl_component.sub_id', 0);
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

                if ($this->input->post('group') != 'yes') $this->db->where('tbl_component.merge', 0);
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
                    $this->db->where('tbl_component.sub_id', 0);
                }
            }
        }

        $i = 0;

        foreach ($this->component_search as $item) // loop column 
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
            $this->db->order_by($this->component_product_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $component_pro_ord = $this->component_product_order;
            $this->db->order_by(key($component_pro_ord), $component_pro_ord[key($component_pro_ord)]);
        }
    }

    private function _get_datatables_query($id = '', $w = '', $sub = '')
    {
        $this->db->select('geopos_products.*,geopos_product_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.sub_id');

            if ($this->input->post('group') != 'yes') $this->db->where('geopos_products.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("geopos_products.sub_id=$id");

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('geopos_products.sub_id', 0);
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

                if ($this->input->post('group') != 'yes') $this->db->where('geopos_products.merge', 0);
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
                    $this->db->where('geopos_products.sub_id', 0);
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


    private function _get_count_component($id = '', $w = '', $sub = '')
    {
        $this->db->select('tbl_component.*,geopos_product_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_component.warehouse');
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_component.sub_id');

            if ($this->input->post('group') != 'yes') $this->db->where('tbl_component.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("tbl_component.sub_id=$id");

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = tbl_component.pcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('geopos_products.sub_id', 0);
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

                if ($this->input->post('group') != 'yes') $this->db->where('geopos_products.merge', 0);
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
                    $this->db->where('tbl_component.sub_id', 0);
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
            $this->db->order_by($this->component_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->component_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    
    private function _get_datatables_query_bundle($id = '', $w = '', $sub = '')
    {
        $this->db->select('geopos_products_bundle.*,geopos_product_cat.title AS c_title,geopos_warehouse.title,geopos_warehouse.warehouse_code');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products_bundle.warehouse');
        if ($sub) {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products_bundle.sub_id');

            //if ($this->input->post('group') != 'yes') $this->db->where('geopos_products_bundle.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }

            $this->db->where("geopos_products_bundle.sub_id=$id");

        } else {
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products_bundle.bcat');

            if ($w) {

                if ($id > 0) {
                    $this->db->where("geopos_warehouse.id = $id");
                    // $this->db->where('geopos_products.sub_id', 0);
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

                //if ($this->input->post('group') != 'yes') $this->db->where('geopos_products.merge', 0);
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
                   // $this->db->where('geopos_products.sub_id', 0);
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
    
    
    function get_datatables_bundle($id = '', $w = '', $sub = '')
    {
       $this->db->select('a.bid as bundle_id');
       $this->db->select('b.title as warehouse');
       $this->db->select('c.title as category');
       $this->db->select('a.product_code as code');
       $this->db->select('a.new_product_lebal');
       $this->db->from("geopos_products_bundle as a");
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

     function component_count_filtered($id, $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_count_component($id, $w, $sub);
        } else {
            $this->_get_count_component();
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
   
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type = '', $w_stock = '', $w_alert = '', $sub_cat = '', $b_id = '', $serial = '',$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification)
    {
        $conditions = $this->input->post('conditions');
        $colours = $this->input->post('colours');       
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
                 for($m=0;$m<count($catid);$m++)
                    {
                if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                   
                    $data = array(
                        'pcat' => $catid[$m],
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
                        'expiry' => $wdate,
                        'code_type' => $code_type,
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
                        'sub' => $pid,
                        'hsn_code' => $hsn_code,
                        'product_model' => $product_model,
                        'warehouse_product_name' => $warehouse_product_name,
                        'warehouse_product_code' => $warehouse_product_code,
                        'product_specification' => $product_specification
                    );

                } else {

                    $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);

                    $data = array(
                        'pcat' => $catid[$m],
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
                        'expiry' => $wdate,
                        'code_type' => 'EAN13',
                        'sub_id' => $sub_cat,
                        'sub' => $pid,
                        'b_id' => $b_id,
                        'hsn_code' => $hsn_code,
                        'product_model' => $product_model,
                        'warehouse_product_name' => $warehouse_product_name,
                        'warehouse_product_code' => $warehouse_product_code,
                        'product_specification' => $product_specification
                    );
                }               
                

                if ($this->db->insert('geopos_products', $data)) {
                    $pid = $this->db->insert_id();
                    //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
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
                                $this->db->insert('geopos_products', $data);
                            }
                           
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
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
                            
                            if(is_array($conditions[$key])){
                                foreach($conditions[$key] as $key1=>$cval){
                                    $this->db->select('*');                             
                                    $this->db->where('id', $cval);
                                    $query = $this->db->get('geopos_conditions');
                                    $r_c = $query->row_array();
                                    $product_c = $product_n. '-' . $r_c['name'];
                                    $data['product_name'] = $product_c;
                                    $data['sub'] = $pid;
                                    $data['vc'] = $cval;                                
                                    
                                    if(is_array($colours[$key])){
                                        foreach($colours[$key] as $key2=>$colval){
                                            $this->db->select('*');                             
                                            $this->db->where('id', $colval);
                                            $query = $this->db->get('geopos_colours');
                                            $r_col = $query->row_array();
                                            $product_col = $product_c. '-' . $r_col['name'];
                                            $data['product_name'] = $product_col;
                                            $data['sub'] = $pid;
                                            $data['colour_id'] = $colval;
                                            $this->db->insert('geopos_products', $data);
                                        }
                                    }else{
                                        $this->db->insert('geopos_products', $data);
                                    }
                                }
                            }
                            
                            
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
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
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                           // $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            $pid=0;
            for($m=0;$m<count($catid);$m++)
                    {
            if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                $data = array(
                    'pcat' => $catid[$m],
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
                    'expiry' => $wdate,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'sub' => $pid,
                    'hsn_code' => $hsn_code,
                    'product_model' => $product_model,
                    'warehouse_product_name' => $warehouse_product_name,
                    'warehouse_product_code' => $warehouse_product_code,
                    'product_specification' => $product_specification
                );
            } else {
                $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
                $data = array(
                    'pcat' => $catid[$m],
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
                    'expiry' => $wdate,
                    'code_type' => 'EAN13',
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
                    'sub' => $pid,
                    'hsn_code' => $hsn_code,
                    'product_model' => $product_model,
                    'warehouse_product_name' => $warehouse_product_name,
                    'warehouse_product_code' => $warehouse_product_code,
                    'product_specification' => $product_specification
                );
            }
            if ($this->db->insert('geopos_products', $data)) {
                 $pid = $this->db->insert_id();
                 //echo $this->db->last_query();die;
                //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
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
                            $this->db->insert('geopos_products', $data);                        
                            $vid = $this->db->insert_id();
                        }
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $vid, $this->aauth->get_user()->username);
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
                            
                                if(is_array($colours[$key])){                                   
                                    foreach($colours[$key] as $key2=>$colval){
                                        $this->db->select('*');                             
                                        $this->db->where('id', $colval);
                                        $query = $this->db->get('geopos_colours');
                                        $r_col = $query->row_array();
                                        $product_col = $product_c. '-' . $r_col['name'];
                                        $data['product_name'] = $product_col;
                                        $data['sub'] = $pid;
                                        $data['colour_id'] = $colval;
                                        $this->db->insert('geopos_products', $data);
                                    }
                                }else{
                                    $this->db->insert('geopos_products', $data);
                                }
                        }                           
                                                    
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
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
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 4);
            

        }
    }
    
public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '', $serial = null,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code,$product_id,$product_unit,$product_color,$p_qty,$product_var,$v_type, $v_stock, $v_alert,$w_type, $w_stock, $w_alert)
    {
        $conditions = $this->input->post('conditions');
        $colours = $this->input->post('colours');

        $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        $this->db->trans_start();

        for($i=0;$i<count($product_id);$i++)
        {
           
            
            $getUnit = $this->products->getVarientEditProduct($product_var[$i]);
            $getCondition = $this->products->getVarientCondition($product_unit[$i]);
            $getColour = $this->products->getVarientColour($product_color[$i]);
            
            $var_product_name = '';
            if($getUnit!='')
            { 
            $var_product_name = $product_name.'-'.$getUnit;
            }
            if($getCondition!='')
            {
             $var_product_name.='-'.$getCondition;   
            }
            if($getColour!='')
            {
             $var_product_name.='-'.$getColour;   
            }

            $insert_data = array(
                'vb' => $product_var[$i],
                'vc' => $product_unit[$i],
                'colour_id' => $product_color[$i],
                'qty' => $p_qty[$i],
                'product_name' => $var_product_name
            );
            $this->db->set($insert_data);
            $this->db->where('pid', $product_id[$i]);
            $this->db->update('geopos_products');
           // echo $this->db->last_query(); die;        
        }



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

                if ($this->db->update('geopos_products')) {
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
            if ($this->db->update('geopos_products')) {
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
        $this->db->select('sub,pid,pcat');
        $this->db->from("geopos_products"); 
        $this->db->where("pid",$pid);
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        $checkSub = array();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row)
            {
               $checkSub[] = $row;
            }
        }
       
         $check_pcat = $this->db->query("SELECT * FROM `geopos_products` WHERE sub='".$pid."' || pid='".$pid."'");
           
           $total_pcat = $check_pcat->num_rows();
          
           if($total_pcat==1)
           {
           
              $pid = $pid; 
               
           }
           else
           {
           if($checkSub[0]->sub!=0)
        {
            
        $pid = $pid; 

        }
        else
        {
         
        $this->db->select('pid');
        $this->db->from("geopos_products");
        $this->db->where("merge",0);
        $this->db->where("sub",$pid);
        $query = $this->db->get();
        $getsub1 = $query->result_array();

        $pid = $getsub1[0]['pid'];
        
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
                        $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        
                        if(count(($conditions[$key]))==0){                      
                            $this->db->insert('geopos_products', $data);                        
                            $vid = $this->db->insert_id();
                        }
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $vid, $this->aauth->get_user()->username);
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
                            
                                if(is_array($colours[$key])){                                   
                                    foreach($colours[$key] as $key2=>$colval){
                                        $this->db->select('*');                             
                                        $this->db->where('id', $colval);
                                        $query = $this->db->get('geopos_colours');
                                        $r_col = $query->row_array();
                                        $product_col = $product_c. '-' . $r_col['name'];
                                        $data['product_name'] = $product_col;
                                        $data['sub'] = $pid;
                                        $data['colour_id'] = $colval;
                                        $this->db->insert('geopos_products', $data);
                                    }
                                }else{
                                    $this->db->insert('geopos_products', $data);
                                }
                        }                           
                                                    
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
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
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 4);
        $this->db->trans_complete();

    }

    public function prd_stats()
    {

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
            if (BDATA) $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
        } elseif (!BDATA) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0';
        }
        $query = $this->db->query("SELECT
COUNT(IF( geopos_products.qty > 0, geopos_products.qty, NULL)) AS instock,
COUNT(IF( geopos_products.qty <= 0, geopos_products.qty, NULL)) AS outofstock,
COUNT(geopos_products.qty) AS total
FROM geopos_products $whr");
        echo json_encode($query->result_array());
    }

    public function products_list($id, $term = '')
    {
        $this->db->select('geopos_products.*');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.warehouse', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', 0);
        }
        if ($term) {
            $this->db->where("geopos_products.product_name LIKE '%$term%'");
            $this->db->or_where("geopos_products.product_code LIKE '$term%'");
        }
        $query = $this->db->get();
        return $query->result_array();

    }
    
     public function products_list_without_varient($id, $term = '')
    {
        $this->db->select('geopos_products.*');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.warehouse', $id);
        $this->db->where('geopos_products.sub', 0);
        $this->db->where('geopos_products.merge', 0);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', 0);
        }
        if ($term) {
            $this->db->where("geopos_products.product_name LIKE '%$term%'");
            $this->db->or_where("geopos_products.product_code LIKE '$term%'");
        }
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
        $this->db->where('status !=', 8);

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
            $this->db->from('geopos_products');
            $this->db->where('pid', $row);
            $query = $this->db->get();
            $pr = $query->row_array();
            $pr2 = $pr;
            $c_qty = $pr['qty'];
            if ($c_qty - $qty < 0) {

            } elseif ($c_qty - $qty == 0) {


                if ($pr['merge'] == 2) {

                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();

                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
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
                    $this->db->update('geopos_products');
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty ID " . $c_pid, $this->aauth->get_user()->username);
                    $this->db->delete('geopos_products', array('pid' => $row));
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
                $data[' unit'] = $pr['unit'];
                $data['image'] = $pr['image'];
                $data['barcode'] = $pr['barcode'];
                $data['merge'] = 2;
                $data['sub'] = $row;
                $data['vb'] = $to_warehouse;
                if ($pr['merge'] == 2) {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
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
                    $this->db->update('geopos_products');

                    $this->movers(1, $c_pid, $qty, 0, 'Stock Transferred W ' . $to_warehouse_name);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty W $to_warehouse_name  ID " . $c_pid, $this->aauth->get_user()->username);


                } else {
                    $this->db->insert('geopos_products', $data);
                    $pid = $this->db->insert_id();
                    $this->movers(1, $pid, $qty, 0, 'Stock Transferred & Initialized W ' . $to_warehouse_name);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty  W $to_warehouse_name ID " . $pr2['pid'], $this->aauth->get_user()->username);

                }

                $this->db->set('qty', "qty-$qty", FALSE);
                $this->db->where('pid', $row);
                $this->db->update('geopos_products');
                $this->movers(1, $row, -$qty, 0, 'Stock Transferred WID ' . $to_warehouse_name);
            }


            $i++;
        }

        if ($move) {
            $this->db->update_batch('geopos_products', $updateArray, 'pid');
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
        $query = $this->db->get('geopos_products');
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
        $data['new_product_lebal'] = $this->input->post('new_product_lebal',true);
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
        
        if ($this->db->insert('geopos_products_bundle', $data)) {
                    $bid = $this->db->insert_id();
                    $this->aauth->applog("[New Bundle Product] -$bid  " . $bid, $this->aauth->get_user()->username);
                    foreach($pid as $key=>$row){
                        $data2['bid'] = $bid;
                        $data2['pid'] = $row;
                        $data2['pqty'] = $pqty[$key];
                        //print_r($data2);die;
                        if($this->db->insert('geopos_products_bundle_combination', $data2)){
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
        
        $data['new_product_lebal'] = $this->input->post('new_product_lebal',true);
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
        if ($this->db->update('geopos_products_bundle', $data)) {
                    
                    $this->aauth->applog("[Update Bundle Product] -$id  " . $id, $this->aauth->get_user()->username);
                    $this->db->where('bid',$id);
                    $this->db->delete('geopos_products_bundle_combination');
                    foreach($pid as $key=>$row){
                        $data2['bid'] = $id;
                        $data2['pid'] = $row;
                        $data2['pqty'] = $pqty[$key];
                        //print_r($data2);die;
                        if($this->db->insert('geopos_products_bundle_combination', $data2)){
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
        $query = $this->db->get('geopos_products_bundle');
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
        $query = $this->db->get('geopos_products_bundle_combination')->result();
        foreach($query as $row){
            $productId = $row->pid;
            $productQuantity = $row->pqty;
            $this->db->select('product_name');
            $this->db->where('pid',$productId);
            $result = $this->db->get('geopos_products')->result();
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
        $data = array();
        $this->db->where('sub',$pid);
        $query = $this->db->get('geopos_products');
        //echo $this->db->last_query(); die;
        foreach($query->result() as $row){
            $data[] = $row;
        }
        return $data;
    }

     public function component_getvariantById($pid){
        $this->db->where('sub',$pid);
        $query = $this->db->get('tbl_component');

        foreach($query->result() as $row){
            $data[] = $row;
        }
        return $data;
    }
    
    public function getproductByCatId($cid){        
        $this->db->where('pcat',$cid);
        $this->db->where('sub',0);
        $query = $this->db->get('geopos_products'); 
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
        $query = $this->db->get('geopos_products');     
        foreach($query->result() as $row){              
            $data = $row;
        }
        return $data;
    }
    
    public function getAllproductByCatId($cid){         
        $this->db->where('pcat',$cid);      
        $query = $this->db->get('geopos_products'); 
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
	
	public function getAllBrandsByCatId($cid){
		$this->db->select('b.*');
        $this->db->from("geopos_products as a");
        $this->db->join('geopos_brand as b', 'a.b_id = b.id', 'LEFT');    
		$this->db->where('a.pcat',$cid);         
        $this->db->group_by('a.b_id');
		$query = $this->db->get(); 
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
	
	public function getAllproductByBrandId($b_id,$cat_id){         
        $this->db->where('b_id',$b_id);      
        $this->db->where('pcat',$cat_id);      
        $query = $this->db->get('geopos_products'); 
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
        $query = $this->db->get('geopos_products'); 
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
        $query = $this->db->get('geopos_products'); 
        if($query->num_rows() > 0){
            foreach($query->result() as $row){              
                $row->category_name = $this->products_cat->GetParentCatTitleById($row->pcat);
                $row->brand_name = $this->brand->GetTitleById($row->b_id);
                $data[] = $row;
            }
            return $data;
        }else{
            return false;
        }
    }
    
    public function getRecordById($id){
        $this->db->where("pid",$id);                
        $query = $this->db->get("geopos_products");     
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
            case 'refurbishment' :  $base_url = base_url('settings/costlist?action=refurbishment');
                                    $data = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);
                                    $data_history = array('refurbishment_cost' => $cost, 'refurbishment_cost_type' => $type);           
            break;
            case 'packaging'    :   $base_url = base_url('settings/costlist?action=packaging');
                                    $data = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
                                    $data_history = array('packaging_cost' => $cost, 'packaging_cost_type' => $type);
            break;          
            case 'salessupport' :   $base_url = base_url('settings/costlist?action=salessupport');
                                    $data = array('sales_support' => $cost, 'sales_support_type' => $type);
                                    $data_history = array('sales_support' => $cost, 'sales_support_type' => $type);
            break;
            case 'promotion'    :   $base_url = base_url('settings/costlist?action=promotion');
                                    $data = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
                                    $data_history = array('promotion_cost' => $cost, 'promotion_cost_type' => $type);
            break;
            case 'infra'        :   $base_url = base_url('settings/costlist?action=infra');
                                    $data = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
                                    $data_history = array('hindizo_infra' => $cost, 'hindizo_infra_type' => $type);
            break;
            case 'margin'       :   $base_url = base_url('settings/costlist?action=margin');
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
        
        $this->db->where('pid', $id);
        $this->db->update('geopos_products',$data); 
        //echo $this->db->last_query(); exit;
		
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
		$this->db->where('status !=', 5);
		$this->db->where('pcat !=', 0);
        $query = $this->db->get("geopos_products");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){ 
				/* if($row->merge==0){
					if($row->sub==0){
						$row->parent_category_ids = $this->categories_model->parentCategoryIds_list($row->pcat);
						$data =$row;  
					}
				}else{
					$row->parent_category_ids = $this->categories_model->parentCategoryIds_list($row->pcat);
					$data =$row;  
				}  */ 
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
        $data['obc_sale_price'] = $this->input->post('obc_sale_price',true);        
        $data['zobulk_sale_price'] = $this->input->post('zobulk_sale_price',true);        
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
					$data1['purchase_price'] = $this->input->post('purchase_price',true); 
                    $data1['obc_sale_price'] = $this->input->post('obc_sale_price',true);                   
                    $data1['zobulk_sale_price'] = $this->input->post('zobulk_sale_price',true);                   
                    $data1['product_price'] = $net_price;           
                    $data1['taxrate'] = $this->input->post('gst',true);                 
                    $data1['hindizo_margin'] = $this->input->post('hindizo_margin',true);
                    $data1['hindizo_margin_type'] = $this->input->post('hindizo_margin_type',true);
                    $this->db->where('pid',$pid);
                    //$this->db->where('hindizo_margin !=',$data1['hindizo_margin']);
                    $this->db->update('geopos_products', $data1);  
					
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
    
    public function getProductRecords(){
        $term = $this->input->post('term');
        $this->db->like('product_name', $term);
        $this->db->where('status !=', 5);
        $this->db->where('pcat !=', 0);
        $this->db->order_by('product_name','ASC');
        $query = $this->db->get("geopos_products");     
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row) {  
				/* if($row->merge==0){
					if($row->sub==0){
						 $data[] = $row;
					}
				}else{
					$data[] = $row;
				} */
				$data[] = $row;
            }           
            return $data;
        }
        return false;
    }
    
    public function getcostStructureByProductName($product_name){
        $product_records = $this->products->getCostByProductName($product_name);
                        
            $data['product']['refurbishment_cost']  = $product_records->refurbishment_cost;
            $data['product']['refurbishment_cost_type'] = $product_records->refurbishment_cost_type;
            $data['product']['packaging_cost'] = $product_records->packaging_cost;
            $data['product']['packaging_cost_type'] = $product_records->packaging_cost_type;
            $data['product']['sales_support']   = $product_records->sales_support;
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
                $data['cat']['sales_support'][$cat_id]  = $cat_records->sales_support;
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
        $query = $this->db->get("geopos_products");
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
            //echo $this->db->last_query(); exit;
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
        $query = $this->db->get("geopos_products");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){               
                $data =$row;                                
            }           
            return $data;
        }
        return false;
    }
    
    
    public function getFranchisePendingSerial($wid=''){
        $this->db->select('count(a.id) as stock_qty,count( DISTINCT a.pid) as total_product,a.*,b.product_name,c.id as invoice_id,c.tid,c.items,d.title,d.warehouse_code,e.name,e.franchise_code,a.pid');
        $this->db->from("tbl_warehouse_serials as a");
        $this->db->join('geopos_products as b', 'a.pid = b.pid', 'LEFT');       
        $this->db->join('geopos_invoices as c', 'a.invoice_id = c.id', 'LEFT');     
        $this->db->join('geopos_warehouse as d', 'a.twid = d.id', 'LEFT');      
        $this->db->join('geopos_customers as e', 'e.id = d.cid', 'LEFT');   
        
        $this->db->group_by('c.id');
        if($wid){
        $this->db->where("a.twid",$wid);
        }        
        $this->db->where("a.status",0);
        $this->db->order_by('c.id',"desc");             
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array(); 
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){               
                $data[] =$row;
               

            }         
            return $data;
        }
        
        return false;
    }
    
    
    public function getFranchisePendingSerialByInvoiceId($invoice_id=''){
        $this->db->select('a.*,b.product_name,c.id as invoice_id,c.tid,c.items,d.title,d.warehouse_code,e.name,e.franchise_code,f.serial');
        $this->db->from("tbl_warehouse_serials as a");              
        $this->db->join('geopos_products as b', 'a.pid = b.pid', 'LEFT');       
        $this->db->join('geopos_invoices as c', 'a.invoice_id = c.id', 'LEFT');     
        $this->db->join('geopos_warehouse as d', 'a.twid = d.id', 'LEFT');      
        $this->db->join('geopos_customers as e', 'e.id = d.cid', 'LEFT');
        $this->db->join('geopos_product_serials as f', 'a.serial_id = f.id', 'LEFT');       
    
        $this->db->where("c.id",$invoice_id);
		$this->db->where("f.status !=",8); 
        $this->db->where("a.status",0); 
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){               
                $data[] =$row;                              
            }           
            return $data;
        }
        return false;
    }
    
    public function recieve_serial(){
        $id = $this->input->post('id');
        $this->db->set('status',1);
        $this->db->set('date_modified',date('Y-m-d h:i:s'));
        $this->db->where('id',$id);             
        $this->db->update('tbl_warehouse_serials');
    }
    
    public function not_recieve(){
        $id = $this->input->post('id');
        $this->db->set('status',3);
        $this->db->set('date_modified',date('Y-m-d h:i:s'));
        $this->db->where('id',$id);             
        $this->db->update('tbl_warehouse_serials');
    }
    
    public function getMisplacedSerial($wid=''){
        $this->db->select('count(a.id) as stock_qty,a.*,b.product_name,c.id as invoice_id,c.tid,c.items,d.title,d.warehouse_code,e.name,e.franchise_code');
        $this->db->from("tbl_warehouse_serials as a");
        $this->db->join('geopos_products as b', 'a.pid = b.pid', 'LEFT');       
        $this->db->join('geopos_invoices as c', 'a.invoice_id = c.id', 'LEFT');     
        $this->db->join('geopos_warehouse as d', 'a.twid = d.id', 'LEFT');      
        $this->db->join('geopos_customers as e', 'e.id = d.cid', 'LEFT');   
        
        $this->db->group_by('c.id');
        if($wid){
        $this->db->where("a.twid",$wid);
        }       
        $this->db->where("a.status",3);             
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){               
                $data[] =$row;                              
            }           
            return $data;
        }
        return false;
    }
    
    public function getMisplacedSerialByInvoiceId($id){
        $this->db->select('a.*,b.product_name,c.id as invoice_id,c.tid,c.items,d.title,d.warehouse_code,e.name,e.franchise_code,f.serial');
        $this->db->from("tbl_warehouse_serials as a");
        $this->db->join('geopos_products as b', 'a.pid = b.pid', 'LEFT');       
        $this->db->join('geopos_invoices as c', 'a.invoice_id = c.id', 'LEFT');     
        $this->db->join('geopos_warehouse as d', 'a.twid = d.id', 'LEFT');      
        $this->db->join('geopos_customers as e', 'e.id = d.cid', 'LEFT');
        $this->db->join('geopos_product_serials as f', 'a.serial_id = f.id', 'LEFT');   
        
        $this->db->where("c.id",$id);
        $this->db->where("a.status",3);             
        $this->db->where("f.status !=",8);             
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key=>$row){               
                $data[] =$row;                              
            }           
            return $data;
        }
        return false;
    }

    public function getSerial($pid,$wid)
    {
        $this->db->select("p.product_name,gw.warehouse_code,p.hsn_code,s.serial,s.id,s.product_id,p.warehouse_product_code");
        $this->db->from("geopos_product_serials as s");
        $this->db->join('tbl_warehouse_serials as w','s.id=w.serial_id','left');
        $this->db->join('geopos_warehouse as gw','w.twid=gw.id','left');
        $this->db->join("geopos_products as p","w.pid=p.pid",'LEFT');
        $this->db->where('w.pid',$pid);
        $this->db->where('w.twid',$wid);
        $this->db->where('w.status',1);
		$this->db->where('w.is_present',1);
        $this->db->where('s.status !=',8);
        $query = $this->db->get();  
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {                
                    $data[] = $row;             
            }
            return $data;
        }

        return false;
    }
	
    public function getSerialComponent($pid)
    {
        $this->db->select("p.component_name,p.hsn_code,s.serial,s.id,s.serial_in_type,s.component_id,p.warehouse_product_code");
        $this->db->from("tbl_component_serials as s");
        $this->db->join("tbl_component as p","s.component_id=p.id",'LEFT');
        $this->db->where('s.component_id',$pid);
        $this->db->where('s.status',1);
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
	
    public function edit_component_detail($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '', $vari = null, $serial = null,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code)
    {
        $this->db->select('qty');
        $this->db->from('tbl_component');
        $this->db->where('id', $pid);
        $catid=0;
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        $this->db->trans_start(); 
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'component_name' => $product_name,
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

                if ($this->db->update('tbl_component')) {
                   /* if ($r_n['qty'] != $product_qty) {
                        $m_product_qty = $product_qty - $r_n['qty'];
                        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                    }*/
                    $this->aauth->applog("[Update Spare Part] -$product_name  " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED') . " <a href='" . base_url('products/component_edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products/manageproductcomponent') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
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
                'component_name' => $product_name,
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
            //$this->db->update('tbl_component');
            if ($this->db->update('tbl_component')) {
                  //echo $this->db->last_query(); die;
                /*if ($r_n['qty'] != $product_qty) {
                    $m_product_qty = $product_qty - $r_n['qty'];
                    $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                }*/
                
                $this->aauth->applog("[Update Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED') . " <a href='" . base_url('products/component_edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products/manageproductcomponent') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        }

      
        $this->custom->edit_save_fields_data($pid, 4);


        $v_type = $vari['v_type'];

        $zupc_code = $vari['zupc_code'];

        $v_alert = $vari['v_alert'];
        $w_type = $vari['w_type'];
        $w_stock = $vari['w_stock'];
        $w_alert = $vari['w_alert'];

        if (isset($v_type)) {

                $this->db->where('sub',$pid);
                $this->db->delete('tbl_component');
                

            foreach ($v_type as $key => $value) {
                 //echo $v_type.'<br>';
                if ($v_type[$key]) {
                    $this->db->select('product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('pid', $v_type[$key]);
                    $query = $this->db->get();
                    $r_n = $query->row_array();

                    $data['component_name'] = $product_name . '-' . $r_n['product_name'];
                    
                    $data['qty'] = numberClean($v_stock[$key]);
                    $data['alert'] = numberClean($v_alert[$key]);
                    $data['product_id'] = $v_type[$key];
                    $data['warehouse_product_code'] = $zupc_code[$key];
                    $data['merge'] = 1;
                    $data['sub'] = $pid;
                    $data['vb'] = $v_type[$key];
                    $this->db->insert('tbl_component', $data);
                    //echo $this->db->last_query().'<br>';
                    //$pid = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        



        if (isset($w_type)) {
            foreach ($w_type as $key => $value) {
                if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                    $data['component_name'] = $product_name;
                    $data['warehouse'] = $w_type[$key];
                    $data['qty'] = numberClean($w_stock[$key]);
                    $data['alert'] = numberClean($w_alert[$key]);
                    $data['product_id'] = $v_type[$key];
                    $data['warehouse_product_code'] = $zupc_code[$key];
                    $data['merge'] = 2;
                    $data['sub'] = $pid;
                    $data['vb'] = $w_type[$key];
                    $this->db->insert('tbl_component', $data);
                    $pidv = $this->db->insert_id();
                    //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }

        $this->db->trans_complete();
    }
    

    function get_component($id = '', $w = '', $sub = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query_component($id, $w, $sub);
        } else {
            $this->_get_datatables_query_component();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        
       
        return $query->result();
    }


    public function add_new_component($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $zupc_code, $wdate, $code_type, $w_type = '', $w_stock = '', $w_alert = '', $sub_cat = '', $b_id = '', $serial = '',$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_type)
    {
          
         $product_type = $this->input->post('product_type');
        if($product_type==0)
                {
                    $v_type = array();
                $query1 = $this->db->query("select pid from geopos_products where merge=0 && sub=0");
                //  $query1 = $this->db->query("select pid from geopos_products");  
                foreach($query1->result() as $key2=>$row2)
                {  

                    $v_type[] = $row2->pid;
                }
                }   
        
               
        $conditions = $this->input->post('conditions');
        $colours = $this->input->post('colours');       
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
                        'component_name' => $product_name,
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
                        'component_name' => $product_name,
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
                
                
                if ($this->db->insert('tbl_component', $data)) {
                    $pid = $this->db->insert_id();
                    //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "  <a href='productcomponent' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products/manageproductcomponent') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
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
                            $this->db->select('product_name');
                            $this->db->from('geopos_products');
                            $this->db->where('pid', $v_type[$key]);
                            $query = $this->db->get();
                            $r_n = $query->row_array();
                            $data['component_name'] = $product_name . '-' . $r_n['product_name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['product_id'] = $v_type[$key];

                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            if(count(($conditions[$key]))==0){  
                                $this->db->insert('tbl_component', $data);
                            }
                           
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }

                   
                if ($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key]) {
                           $this->db->select('product_name');
                            $this->db->from('geopos_products');
                            $this->db->where('pid', $v_type[$key]);
                            $query = $this->db->get();
                            $r_n = $query->row_array();
                            $data['component_name'] = $product_name . '-' . $r_n['product_name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['product_id'] = $v_type[$key];
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            
                            if(is_array($conditions[$key])){
                                foreach($conditions[$key] as $key1=>$cval){
                                    $this->db->select('*');                             
                                    $this->db->where('id', $cval);
                                    $query = $this->db->get('geopos_conditions');
                                    $r_c = $query->row_array();
                                    $product_c = $product_n. '-' . $r_c['name'];
                                    $data['product_name'] = $product_c;
                                    $data['sub'] = $pid;
                                    $data['vc'] = $cval;                                
                                    
                                    if(is_array($colours[$key])){
                                        foreach($colours[$key] as $key2=>$colval){
                                            $this->db->select('*');                             
                                            $this->db->where('id', $colval);
                                            $query = $this->db->get('geopos_colours');
                                            $r_col = $query->row_array();
                                            $product_col = $product_c. '-' . $r_col['name'];
                                            $data['product_name'] = $product_col;
                                            $data['sub'] = $pid;
                                            $data['colour_id'] = $colval;
                                            $this->db->insert('tbl_component', $data);
                                        }
                                    }else{
                                        $this->db->insert('tbl_component', $data);
                                    }
                                }
                            }
                            
                            
                            //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                } 
                
                
                if ($w_type) {
                    foreach ($w_type as $key => $value) {
                        if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                            $data['component_name'] = $product_name;
                            $data['warehouse'] = $w_type[$key];
                            $data['qty'] = numberClean($w_stock[$key]);
                            $data['alert'] = numberClean($w_alert[$key]);
                            if($product_type==0)
                            {
                            $data['warehouse_product_code'] = $this->lastcomponentid();
                            }
                            else
                            {
                            $data['warehouse_product_code'] = $zupc_code[$key];
                            }
                            $data['merge'] = 2;
                            $data['sub'] = $pid;
                            $data['vb'] = $w_type[$key];
                            $this->db->insert('tbl_component', $data);
                            $pidv = $this->db->insert_id();
                           // $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pidv, $this->aauth->get_user()->username);
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
                    'component_name' => $product_name,
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
                    'component_name' => $product_name,
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
             
            if ($this->db->insert('tbl_component', $data)) {
                 $pid = $this->db->insert_id();
                 //echo $this->db->last_query();die;
                //$this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "  <a href='productcomponent' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products/manageproductcomponent') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
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


                        
                        $this->db->select('product_name');
                        $this->db->from('geopos_products');
                        $this->db->where('pid', $v_type[$key]);
                        $query = $this->db->get();
                        //echo $this->db->last_query(); die;
                        $r_n = $query->row_array();
                        $data['component_name'] = $product_name . '-' . $r_n['product_name'];
                        $getComponentName = $product_name . '-' . $r_n['product_name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        if($product_type==0)
                        {
                            $data['warehouse_product_code'] = $this->lastcomponentid();
                            $wpc = $this->lastcomponentid();
                        }
                        else
                        {
                        $data['warehouse_product_code'] = $zupc_code[$key];
                        $wpc = $zupc_code[$key];
                        }
                        $data['product_id'] = $v_type[$key];
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        
                                           
                            $this->db->insert('tbl_component', $data);                        
                            $vid = $this->db->insert_id();
                            $this->db->select('sub,pid,pcat');
                            $this->db->from("geopos_products");
                            $this->db->where("pid",$pid);
                            $query = $this->db->get();
                            //echo $this->db->last_query(); 
                            $checkSub = array();
                            if($query->num_rows()>0)
                            {
                                foreach($query->result() as $row)
                                {
                                   $checkSub[] = $row;
                                }
                            }
                         $check_pcat = $this->db->query("SELECT * FROM `geopos_products` WHERE sub='".$v_type[$key]."' || pid='".$v_type[$key]."' GROUP by pcat");
           
                       $total_pcat = $check_pcat->num_rows();
                      
                       if($total_pcat==1)
                       {
                       
                          $sub_pid = $v_type[$key]; 
                           
                       }
                       else
                       {
                       if($checkSub[0]->sub!=0)
                    {
                        
                    $sub_pid = $v_type[$key]; 

                    }
                    else
                    {
                     
                    $this->db->select('pid');
                    $this->db->from("geopos_products");
                    $this->db->where("merge",0);
                    $this->db->where("sub",$v_type[$key]);

                    $query = $this->db->get();
                    $getsub1 = $query->result_array();

                    $sub_pid = $getsub1[0]['pid'];
                    
                    }        
                       }
                    

                        $this->db->select('a.product_name,a.pid as pro_id,b.name');
                        $this->db->from('geopos_products as a');
                        $this->db->join("geopos_colours as b",'a.colour_id=b.id','left');
                        $this->db->where('a.sub', $sub_pid);
                        $this->db->where('a.colour_id!=','');
                        $this->db->group_by('a.colour_id');
                        $query = $this->db->get(); 
                        
                        $color_data = array();  
                        foreach($query->result() as $key=>$row)
                        {
                            $component_name = $getComponentName. '-'. $row->name;
                            $color_data = array
                            (
                                'component_name' => $component_name,
                                'merge' => 1,
                                'warehouse_product_code' => $wpc,
                                'product_id' => $row->pro_id,
                                'sub'   => $pid          
                            );


                            $this->db->insert('tbl_component', $color_data); 
                        }
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $vid, $this->aauth->get_user()->username);
                    }
                }
                die;
            }
            
            if ($v_type) {

                foreach ($v_type as $key => $value) {
                    if ($v_type[$key]) {
                        $this->db->select('product_name');
                        $this->db->from('geopos_products');
                        $this->db->where('pid', $v_type[$key]);
                        $query = $this->db->get();
                        $r_n = $query->row_array();
                        $data['component_name'] = $product_name . '-' . $r_n['product_name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['product_id'] = $v_type[$key];
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        
                        foreach($conditions[$key] as $key1=>$cval){
                            $this->db->select('*');                             
                            $this->db->where('id', $cval);
                            $query = $this->db->get('geopos_conditions');
                            $r_c = $query->row_array();
                            $product_c = $product_n. '-' . $r_c['name'];
                            $data['component_name'] = $product_c;
                            $data['sub'] = $pid;
                            $data['vc'] = $cval;
                            
                                if(is_array($colours[$key])){                                   
                                    foreach($colours[$key] as $key2=>$colval){
                                        $this->db->select('*');                             
                                        $this->db->where('id', $colval);
                                        $query = $this->db->get('geopos_colours');
                                        $r_col = $query->row_array();
                                        $product_col = $product_c. '-' . $r_col['name'];
                                        $data['component_name'] = $product_col;
                                        $data['sub'] = $pid;
                                        $data['colour_id'] = $colval;
                                        $this->db->insert('tbl_component', $data);
                                    }
                                }else{
                                    $this->db->insert('tbl_component', $data);
                                }
                        }                           
                                                    
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
                
            
            if ($w_type) {
                foreach ($w_type as $key => $value) {
                    if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {

                        $data['component_name'] = $product_name;
                        $data['warehouse'] = $w_type[$key];
                        $data['qty'] = numberClean($w_stock[$key]);
                        $data['alert'] = numberClean($w_alert[$key]);
                        $data['product_id'] = $v_type[$key];
                        $data['merge'] = 2;
                        $data['sub'] = $pid;
                        $data['vb'] = $w_type[$key];
                        $this->db->insert('tbl_component', $data);
                        $pidv = $this->db->insert_id();
                        //$this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Spare Part] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 4);
        }
    }
	
	public function lastproductid()
    {
        $this->db->select('pid');
        $this->db->from($this->table);
        $this->db->order_by('pid', 'DESC');
        $this->db->limit(1);
        //$this->db->where('i_class', 0);
        $query = $this->db->get();
		//echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return 8900000000000+$query->row()->pid;
        } else {
            return 8900000000000;
        }
    }

    public function lastcomponentid()
    {
        $this->db->select('id');
        $this->db->from("tbl_component");
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        //$this->db->where('i_class', 0);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return 9800000000000+($query->row()->id+1);
        } else {
            return 9800000000000;
        }
    }
	
	public function checkcomponent($serial_no){
		$product_id = $this->input->post('product_id');
        $this->db->where('serial',$serial_no);       
        $this->db->where('product_id',$product_id);       
        $this->db->where('status',2);       
        $query = $this->db->get('geopos_product_serials');  
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {                
                $data = $row;             
            }
			$product_id = $data->product_id;
			
            $this->db->where('id',$data->sticker);       
			$query = $this->db->get('tbl_qc_data'); 
			$data1 = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {                
					$data1 = $row;             
				}
				$item_replaced = $data1->item_replaced;
				$component_array = explode(',',$item_replaced);
				$data2 = array();
				foreach($component_array as $key=>$cmp){
					$this->db->select("a.component_name,b.component_name as component_actual_name");
					$this->db->from("tbl_component as a");
					$this->db->join('tbl_component as b','a.sub=b.id','left');
					$this->db->where('a.product_id',$product_id);
					$this->db->where('b.component_name',$cmp);
					$query = $this->db->get();					
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {                
							$data2[] = $row;             
						}						
					}
				}
				return $data2;
			}else{
				return false;
			}
			
        }else{
			return false;
		}        
	}
	
	public function getProductAndComponentBySeral($serial){
		$this->db->select("a.serial,b.product_name,b.warehouse_product_code,d.component_name,e.component_name as component_actual_name");
        $this->db->from("geopos_product_serials as a");       
        $this->db->join("geopos_products as b","a.product_id=b.pid",'LEFT');
        $this->db->join("tbl_qc_data as c","c.id=a.sticker",'LEFT');
        $this->db->join("tbl_component as d","d.product_id=a.sticker",'LEFT');
		$this->db->join('tbl_component as e','d.sub=e.id','left');
		
        $this->db->where('a.serial',$serial);        
        $this->db->where('a.status !=',8);        
        $query = $this->db->get();  
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {                
                    $data[] = $row;             
            }
            return $data;
        }

        return false;
	}

    public function getUnitsByProduct($pid)
    {
        $this->db->select('*');
        $this->db->from('geopos_units');
        $this->db->join("geopos_products","geopos_units.id=geopos_products.vb");
        $this->db->where('geopos_units.type!=', 0);
        $this->db->where('geopos_products.sub', $pid);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

         $data = array();
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row) { 

                    $data[] = $row->name;             
            }
            
        }        
        return $data;
    }

    public function getConditionByProduct($pid)
    {
        $this->db->select('*');
        $this->db->from('geopos_conditions');
        $this->db->join("geopos_products","geopos_conditions.id=geopos_products.vc");
        $this->db->where('geopos_products.sub', $pid);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

         $data = array();
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row) { 

                    $data[] = $row->name;             
            }
            
        }        
        return $data;
    }

    public function getConditionByColour($pid)
    {
        $this->db->select('*');
        $this->db->from('geopos_colours');
        $this->db->join("geopos_products","geopos_colours.id=geopos_products.colour_id");
        $this->db->where('geopos_products.sub', $pid);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

         $data = array();
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row) { 

                    $data[] = $row->name;             
            }
            
        }

         
        
        
        return $data;
    }
 
      public function getVarientEditProduct($id)
   {
              $this->db->select('u.name AS variation');
              $this->db->where('u.id', $id);
              $query = $this->db->get('geopos_units u');
              //echo $this->db->last_query(); die;
              $v_var = $query->row_array();

              $v_varient = $v_var['variation'];
              return $v_varient;
   }
   public function getVarientCondition($id)
   {
              $this->db->select('c.name AS condition');
              $this->db->where('c.id', $id);
              $query = $this->db->get('geopos_conditions c');
              $v_var = $query->row_array();
              $condition = $v_var['condition'];
              return $condition;
   }
   public function getVarientColour($id)
   {
              $this->db->select('u.name AS colour_name');
              $this->db->where('u.id', $id);
              $query = $this->db->get('geopos_colours u');
              $v_var = $query->row_array();
              $colour_name = $v_var['colour_name'];
              return $colour_name;
   }
   
   public function lastbundleid()
    {
        $this->db->select('bid');
        $this->db->from("geopos_products_bundle");
        $this->db->order_by('bid', 'DESC');
        $this->db->limit(1);
        //$this->db->where('i_class', 0);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return 8800000000000+($query->row()->bid+1);
        } else {
            return 8800000000000;
        }
    } 

    public function getMainProduct()
    {
        $this->db->select('*');
        $this->db->where('sub',0);
        $this->db->where('merge',0);
        $query = $this->db->get('geopos_products');
        $data = array();
        if($query->num_rows()>0)
        {
        foreach($query->result() as $key=>$row)
        {
            $data[] = $row;
         
        }
        return $data;
        }
        return false; 
        

    }

   public function getvarient($product_id)
   {  
        
        //$data = array();
        $this->db->select("b.warehouse_product_code,b.pid as product_id,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.pid as varient_pid,bb.product_name,bb.vb as varient_id,brand.title as brand_name");
        $this->db->from("geopos_products as b");
        $this->db->join("geopos_products as bb",'bb.sub=b.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','bb.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','bb.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','bb.vc=d.id','LEFT');
       
        $this->db->where("b.sub",$product_id);
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


    public function getvarientcolor($product_id,$varient_id)
    {  
        //$data = array();
        $this->db->select('sub,pid,pcat');
        $this->db->from("geopos_products");
        $this->db->where("pid",$product_id);
        $query = $this->db->get();
        $checkSub = array();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row)
            {
               $checkSub[] = $row;
            }
        }
         $check_pcat = $this->db->query("SELECT * FROM `geopos_products` WHERE sub='".$product_id."' || pid='".$product_id."'");
           
           $total_pcat = $check_pcat->num_rows();
          
           if($total_pcat==1)
           {
           
              $pid = $product_id; 
               
           }
           else
           {
           if($checkSub[0]->sub!=0)
        {

                       
        $pid = $product_id; 

        }
        else
        {
         
        $this->db->select('pid');
        $this->db->from("geopos_products");
        $this->db->where("merge",0);
        $this->db->where("sub",$product_id);
        $query = $this->db->get();
        $getsub1 = $query->result_array();

        $pid = $getsub1[0]['pid'];
        
        }        
           } 


        $this->db->select("b.warehouse_product_code,b.pid as product_id,c.name as colour_name,d.name as condition_type,u.name as unit_name, bb.pid as varient_pid,bb.product_name,bb.vb as varient_id,bb.colour_id,brand.title as brand_name");
        $this->db->from("geopos_products as b");
        $this->db->join("geopos_products as bb",'bb.sub=b.pid','left');
        $this->db->join("geopos_brand as brand",'bb.b_id=brand.id','left');
        $this->db->join('geopos_colours as c','bb.colour_id=c.id','LEFT');
        $this->db->join('geopos_units as u','bb.vb=u.id','LEFT');
        $this->db->join('geopos_conditions as d','bb.vc=d.id','LEFT');
        $this->db->where("bb.sub",$pid);
        $this->db->where("bb.vb",$varient_id);
        $this->db->group_by("bb.colour_id");
        $query = $this->db->get();
        
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
      public function getMainPro($product_id)
      {
        $this->db->select('*');
        $this->db->from("geopos_products");
        $this->db->where("pid",$product_id);
        $query = $this->db->get();
        $pro_name = array();
        $pro_list = $query->result_array();

        $pro_name = $pro_list[0];
        return $pro_name;

      }
      public function add_custom_label($pid,$varient_id,$color_id,$mrp,$zupc_code,$qty,$imei_1,$imei_2,$label_size,$product_type)
      {

        $product = $this->getMainPro($pid);
        $pro_name = $product['product_name'];
        
        
        $data = array(
             'pid'          => $pid,
             'varient_id'   => $varient_id,
             'color_id'     => $color_id,
             'product_name' => $pro_name,
             'price'        => $mrp,
             'qty'          => $qty,
             'zupc_code'    => $zupc_code,
             'imei_1'       => $imei_1,
             'imei_2'       => $imei_2,
             'label_size'   => $label_size,
             'product_type' => $product_type,
             'date_created' => date('Y-m-d H:i:s')

        );

        $this->db->insert('tbl_custom_label',$data);
        redirect('products/new_custom');   



      }


      public function getCustomList($id='')
      {
        
        $this->db->select("a.*,b.name as unit_name,c.name as colour_name,d.title as brand_name");
        $this->db->from("tbl_custom_label as a");
        $this->db->join("geopos_units as b","a.varient_id=b.id",'left');
        $this->db->join("geopos_colours as c","a.color_id=c.id",'left');
        $this->db->join("geopos_products as e","a.pid=e.pid",'left');
        $this->db->join("geopos_brand as d","e.b_id=d.id",'left');
        if($id!='')
        {
            $this->db->where('a.id',$id);   
        }
        $this->db->order_by('a.id','desc');

        $query = $this->db->get();
        $data = array();
        if($query->num_rows()>0)
        {
            foreach($query->result() as $key=>$row)
            {
                $data[] = $row;
            }
            return $data;
        }
        return false;
      }
	  
	  
	  
	  public function getPurchasePriceByPID($purchase_id,$pid)
      {
        $this->db->select('a.type,b.price');
        $this->db->from("geopos_purchase as a");
        $this->db->join("geopos_purchase_items as b","a.id=b.tid",'left');
        $this->db->where("a.id",$purchase_id);
        $this->db->where("b.pid",$pid);
        $this->db->limit(1);
        
        $query = $this->db->get();  
        $pro_list = array();
        return $query->result_array();  
      }
      
	  
	  
	  public function remove_duplicate_product_name(){
			$this->db->select('*');
			$this->db->from('geopos_products');			
			$this->db->where('sub', 0);
			$this->db->where('vb', 0);
			$this->db->where('vc', 0);
		
			$query = $this->db->get();
			//echo $this->db->last_query(); die;

			$data = array();
			if ($query->num_rows() > 0) {				
				foreach ($query->result() as $row) {
					$pid= $row->pid;
					
						$this->db->select('*');
						$this->db->from('geopos_products');			
						$this->db->where('sub', $pid);
						$this->db->limit(1);
						$query1 = $this->db->get();
						if ($query1->num_rows() > 0) {				
							foreach ($query1->result() as $row1) {
								$pid1= $row1->pid;
								
								
								if($row->product_price>0)
									$this->db->SET('product_price',$row->product_price);
								if($row->purchase_price>0)
									$this->db->SET('purchase_price',$row->purchase_price);							
								if($row->fproduct_price>0)
									$this->db->SET('fproduct_price',$row->fproduct_price);
								if($row->sale_price>0)
									$this->db->SET('sale_price',$row->sale_price);
								if($row->obc_sale_price>0)
									$this->db->SET('obc_sale_price',$row->obc_sale_price);
								if($row->zobulk_sale_price>0)
									$this->db->SET('zobulk_sale_price',$row->zobulk_sale_price);
								if($row->taxrate>0)
									$this->db->SET('taxrate',$row->taxrate);
								if($row->disrate>0)
									$this->db->SET('disrate',$row->disrate);
								if($row->qty>0)
									$this->db->SET('qty',$row->qty);																
								$this->db->where('pid', $pid1);								 
								$this->db->update('geopos_products');
								
									
								$this->db->SET('status',5);								
								$this->db->where('pid', $pid);								 
								$this->db->update('geopos_products');
								
								$this->db->SET('pid',$pid1);								
								$this->db->where('pid', $pid);								 
								$this->db->update('geopos_purchase_items');
								
								$this->db->SET('pid',$pid1);								
								$this->db->where('pid', $pid);								 
								$this->db->update('tbl_warehouse_serials');
								
								$this->db->SET('product_id',$pid1);								
								$this->db->where('product_id', $pid);								 
								$this->db->update('tbl_component');
								
								$this->db->SET('product_id',$pid1);								
								$this->db->where('product_id', $pid);								 
								$this->db->where('status !=', 8);								 
								$this->db->update('geopos_product_serials');
							}
						}
				}				
			}        
			echo json_encode(array('status' => 'Success', 'message' =>"Duplicate Product Removed sucessfully"));
	  }
	  
	  
	  public function update_marginal_tax(){
		/* 355922100283940,
		354872104303098,
		8603980411296331,
		860398047365314,
		351507115855651,
		354554105211989,
		356131100603573,
		355922100872130,
		355922103677411,
		351595113265403,
		864914045520654,
		864914046450653,
		864914044022256,
		864669041465995,
		351507118378545,
		351507116376293,
		354554103000509,
		359753101600428,
		864089044196770,
		867247043271054,
		863905046736795,
		864428045354873,
		351507112123277,
		358618090930345,
		356131100603540,
		3559221026278541,
		8681160455431751,
		8681160455431751 */

		  $serial =array();
		  $serial[] = 355922100283940;
		  $serial[] = 354872104303098;
		  $serial[] = 8603980411296331;
		  $serial[] = 860398047365314;
		  $serial[] = 351507115855651;
		  $serial[] = 354554105211989;
		  $serial[] = 356131100603573;
		  $serial[] = 355922100872130;
		  $serial[] = 355922103677411;
		  $serial[] = 351595113265403;
		  $serial[] = 864914045520654;
		  $serial[] = 864914046450653;
		  $serial[] = 864914044022256;
		  $serial[] = 864669041465995;
		  $serial[] = 351507118378545;
		  $serial[] = 351507116376293;
		  $serial[] = 354554103000509;
		  $serial[] = 359753101600428;
		  $serial[] = 864089044196770;
		  $serial[] = 867247043271054;
		  $serial[] = 863905046736795;
		  $serial[] = 864428045354873;
		  $serial[] = 351507112123277;
		  $serial[] = 358618090930345;
		  $serial[] = 356131100603540;
		  $serial[] = 3559221026278541;
		  $serial[] = 8681160455431751;
		 
		  
		  
			$this->db->select("a.serial,a.purchase_id,a.product_id,a.purchase_pid,b.pid,d.type,b.invoice_id");
			$this->db->from("geopos_product_serials as a");
			$this->db->join("tbl_warehouse_serials as b","a.id=b.serial_id",'left');			
			$this->db->join("geopos_purchase as d","d.id=a.purchase_id",'left');
			
			$this->db->where_in('a.serial',$serial);   
			$this->db->where('a.status !=',8);
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			$data = array();
			if($query->num_rows()>0)
			{
				foreach($query->result() as $key=>$row)
				{	
					$purchase_record = $this->getPurchasePriceByPidAndPurchaseId($row->purchase_id,$row->purchase_pid);	
					$row->purchase_price = $purchase_record[0]->price;
					$purchase_price = $row->purchase_price;
					$sale_price = $this->getSalePriceByPidAndInvoiceId($row->invoice_id,$row->pid);
					$row->sale_price = $sale_price[0]->price;
					$sale_price = $row->sale_price;
					
					if($purchase_record[0]->type==2){
						$ppm = ($sale_price - ($purchase_price+600));
						$marginal_tax = $ppm - (($ppm*100)/(100+18));
						
					}
					
					$this->db->SET('marginal_gst_price',$marginal_tax);								
					$this->db->SET('marginal_product_type',2);								
					$this->db->where('serial', $row->serial);
					$this->db->update('geopos_invoice_items');
										
					$data[] = $row;
				}
				return $data;
			}
			return false;			
		}
		
		
		
		public function getPurchasePriceByPidAndPurchaseId($purchase_id,$pid){
			$this->db->select("a.tid,a.type,b.price,b.tax,b.discount");
			$this->db->from("geopos_purchase as a");
			$this->db->join("geopos_purchase_items as b","a.id=b.tid",'left');
			
			$this->db->where('a.id',$purchase_id);
			$this->db->where('b.pid',$pid);
			
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
			return false;	
		}
		
		
		public function getSalePriceByPidAndInvoiceId($invoice_id,$pid){
			$this->db->select("a.tid,a.type,b.price,b.tax,b.discount");
			$this->db->from("geopos_invoices as a");
			$this->db->join("geopos_invoice_items as b","a.id=b.tid",'left');
			
			$this->db->where('a.id',$invoice_id);
			$this->db->where('b.pid',$pid);
			
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
			return false;	
		}
		
		
		public function update_purchase_pid(){
			
			$this->db->select("a.serial,a.product_id,b.sub,a.purchase_id");
			$this->db->from("geopos_product_serials as a");
			$this->db->join("geopos_products as b","a.product_id = b.pid",'left');
			//$this->db->limit(100);
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			$data = array();
			if($query->num_rows()>0)
			{
				foreach($query->result() as $key=>$row)
				{	
					$row->pid = $this->getPurchasePid($row->purchase_id,$row->product_id);
					if($row->pid==''){
						$row->pid = $this->getPurchasePid($row->purchase_id,$row->sub);
					}
					
					$this->db->SET('purchase_pid',$row->pid);								
					$this->db->where('serial', $row->serial);								 
					$this->db->where('status !=', 8);								 
					$this->db->update('geopos_product_serials');
					
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}
		
		
		public function getPurchasePid($purchase_id,$pid){
			$this->db->where('tid',$purchase_id);
			$this->db->where('pid',$pid);
			$query = $this->db->get('geopos_purchase_items');
			$data = array();
			if($query->num_rows()>0)
			{
				foreach($query->result() as $key=>$row)
				{						
					$data = $row->pid;
				}
				return $data;
			}
			return false;
		}

}