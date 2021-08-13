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

class Products extends CI_Controller
{ 
   public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('products_model', 'products');
        $this->load->model('categories_model');
        $this->load->model('brand_model','brand');
        $this->load->model('conditions_model','conditions');
        $this->load->model('colours_model','colours');
        $this->load->model('units_model', 'units');
        
        $this->load->library("Custom");
        $this->li_a = 'stock';  
    }

    public function index()
    {
        $head['title'] = "Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/products');
        $this->load->view('fixed/footer');
    }

    public function cat()
    {
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/cat_productlist');
        $this->load->view('fixed/footer');
    }


    public function add()
    {
        $data['cat'] = $this->categories_model->category_list();
        $data['units'] = $this->products->units();
        $data['autogencode'] = $this->products->lastproductid();

        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $data['brand'] = $this->brand->brand_list();
        
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $data['conditions'] = $this->conditions->conditions_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-add', $data);
        $this->load->view('fixed/footer');
    }


   public function product_list()
    {   
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');

        if ($catid > 0) {
            $list = $this->products->get_datatables($catid, '', $sub);
        } else {
            $list = $this->products->get_datatables();

            
        }
          
         
        
        //$data['product_category_array_title'] = $this->categories_model->getCategoryNames($data['product_category_array']);

        $data = array();
        $no = $this->input->post('start');
        
        foreach ($list as $prd) {

           



            $cat['product_category_array'] = array_reverse(explode("-",substr($this->categories_model->getParentcategory($prd->pcat),1)));
            $cat['product_category_array_title'] = $this->categories_model->getCategoryNames($cat['product_category_array']);
           $brand_name = $this->brand->GetTitleById($prd->b_id);
           $check_pcat = $this->db->query("SELECT * FROM `geopos_products` WHERE sub='".$prd->pid."' || pid='".$prd->pid."' GROUP by pcat");
           
           $total_pcat = $check_pcat->num_rows();
           if($total_pcat==1)
           {

            $this->db->select('pid');
           $this->db->from("geopos_products");
           $this->db->where("merge",0);
           $this->db->where("sub",$prd->sub);
           $query = $this->db->get();
           $getsub = $query->result_array();
           $child = $getsub[0]['pid'];
           

           }
           else
           {

            if($prd->sub!=0)
           {
            //echo '1 pid '.$prd->pid.'<br>';
           $this->db->select('pid');
           $this->db->from("geopos_products");
           $this->db->where("merge",0);
           $this->db->where("sub",$prd->sub);
           $query = $this->db->get();
           $getsub = $query->result_array();
           $child = $getsub[0]['pid'];
           }

           else
           {
           // echo '2 pid '.$prd->pid.'<br>';
           $this->db->select('pid');
           $this->db->from("geopos_products");
           $this->db->where("merge",0);
           $this->db->where("sub",$prd->pid);
           $query = $this->db->get();
           
           $getsub = $query->result_array();

            $child = $getsub[0]['pid'];
           }

           }
           
             
           

           $product_info['get_varient'] = $this->products->getUnitsByProduct($child);

           $product_info['get_condition'] = $this->products->getConditionByProduct($child);
           $product_info['get_colour'] = $this->products->getConditionByColour($child); 
           $varient = implode('<br>',array_unique($product_info['get_varient']));
           $condition = implode('<br>',array_unique($product_info['get_condition']));
           $colour = implode('<br>',array_unique($product_info['get_colour']));
           
           
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $brand_name;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline">'.$prd->product_name . '</a>';
            $row[] = $varient;
            $row[] = $condition;
            $row[] = $colour;
            $pid = $prd->pid;
            
            $row[] = +$prd->qty;
            $row[] = $cat['product_category_array_title'][0]['title'];
            $row[] = $prd->warehouse_product_code;
            //$row[] = $prd->title;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> 
            <div class="btn-group">
                                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>  ' . $this->lang->line('Print') . '</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a><div class="dropdown-divider"></div> <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a> <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $pid . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a><div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $pid . '" target="_blank"> Label - Compact</a></div></div><a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $pid . '" target="_blank"> <span class="fa fa-pie-chart"></span> ' . $this->lang->line('Reports') . '</a> <div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
            &nbsp;<a href="' . base_url() . 'products/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->products->count_all($catid, '', $sub),
            "recordsFiltered" => $this->products->count_filtered($catid, '', $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function product_list_bundle(){
        
        $list = $this->products->get_datatables_bundle();
        $data = array();
        $no = 1;
        foreach ($list as $prd) {
           
            $row = array();
            $row[] = $no;
            $pid = $prd->bundle_id;
            $this->db->select('a.product_name');
            $this->db->from('geopos_products as a');
            $this->db->join('geopos_products_bundle_combination as b', 'a.pid = b.pid', 'LEFT');
            $this->db->join('geopos_products_bundle as c', 'b.bid = c.bid', 'LEFT');
            $this->db->where('c.bid',$pid);
            $products = $this->db->get()->result();
            $productname = '';
            $i = 1;
            foreach($products as $bndlp){
                $productname .= $i.". ".$bndlp->product_name."<br>";
                $i++;
            }
            
            
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object">&nbsp;' . $productname . '</a>';
            
            $row[] = $prd->code;
            $row[] = $prd->category;
            $row[] = $prd->warehouse;
          
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> 
            <div class="btn-group">
                                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>  ' . $this->lang->line('Print') . '</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode_bundle?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a><div class="dropdown-divider"></div> <a class="dropdown-item" href="' . base_url() . 'products/posbarcode_bundle?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a> <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label_bundle?id=' . $pid . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a><div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel_bundle?id=' . $pid . '" target="_blank"> Label - Compact</a></div></div> <div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
            &nbsp;<a href="' . base_url() . 'products/productbundleedit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
             $no++;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->products->count_all($catid, '', $sub),
            "recordsFiltered" => $this->products->count_filtered($catid, '', $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    
    }   

    public function addproduct()
    {
        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $catid1 = end($this->input->post('product_cat'));
        $catid2 = end($this->input->post('product_cat2'));

        $catid3 = $catid1.','.$catid2; 
        $catid = explode(',',$catid3);
        
        $hsn_code = $this->input->post('hsn_code',true);
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit', true);
        $code_type = $this->input->post('code_type');
        $barcode = $this->input->post('barcode');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $wdate = datefordatabase($this->input->post('wdate'));
        $image = $this->input->post('image');
          
        $v_type = $this->input->post('v_type');        
        $v_stock = $this->input->post('v_stock');
        $v_alert = $this->input->post('v_alert');
        $w_type = $this->input->post('w_type');
        $w_stock = $this->input->post('w_stock');
        $w_alert = $this->input->post('w_alert');
        $product_code = $this->input->post('hsn_code',true);
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $sub_cat = '';
        $serial = '';
        
        $conditions = $this->input->post('conditions');
        $colours = $this->input->post('colours');
                
        if ($catid) {
            $this->products->addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand, $serial,$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification);
            
            
            //$this->products->addnew($product_name,$brand,$catid,$hsn_code,$product_model,$warehouse,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_desc,$unit,$code_type,$barcode,$product_qty_alert,$wdate,$image,$v_type,$v_stock,$v_alert,$w_type,$w_stock,$w_alert);
        }
    }

    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_products', array('pid' => $id));
                $this->db->delete('geopos_products', array('sub' => $id, 'merge' => 1));
                $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                $this->db->set('merge', 0);
                $this->db->where('sub', $id);
                $this->db->update('geopos_products');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function component_delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('tbl_component', array('id' => $id));
                $this->db->delete('tbl_component', array('sub' => $id, 'merge' => 1));
                $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                $this->db->set('merge', 0);
                $this->db->where('sub', $id);
                $this->db->update('tbl_component');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
    public function delete_i_bundle()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_products_bundle', array('bid' => $id));
                $this->db->delete('geopos_products_bundle_combination', array('bid' => $id));
                //$this->db->delete('geopos_products', array('sub' => $id, 'merge' => 1));
               // $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                //$this->db->set('merge', 0);
               // $this->db->where('sub', $id);
                //$this->db->update('geopos_products');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function edit()
    {
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
        if ($data['product']['merge'] > 0) {
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('merge', 1);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_var'] = $query->result_array();
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('merge', 2);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_ware'] = $query->result_array();
        }

        $data['product_category_array'] = array_reverse(explode("-",substr($this->categories_model->getParentcategory($data['product']['pcat']),1)));
        $data['product_category_array_title'] = $this->categories_model->getCategoryNames($data['product_category_array']);
        $data['brand'] = $this->brand->brand_list();
        $data['units'] = $this->products->units();
        $data['serial_list'] = $this->products->serials($data['product']['pid']);
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['cat_sub'] = $this->categories_model->sub_cat_curr($data['product']['sub_id']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['product']['pcat']);
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['cat'] = $this->categories_model->category_list();
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 4);
        $data['product_variant'] = $this->products->getvariantById($pid);
        /*echo "<pre>";
        print_r($data['product_variant']);die;*/
        $head['title'] = "Edit Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-edit', $data);
        $this->load->view('fixed/footer');

    }



    public function editproduct()
    {
        $pid = $this->input->post('pid');
        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $cat = $this->input->post('product_cat');
        $catid = end($cat);
        if($catid == ''){
            array_pop($cat);
            $catid = end($cat);
            if($catid == ''){
                array_pop($cat);
                $catid = end($cat);
            }
            }
        
        $hsn_code = $this->input->post('hsn_code',true);
        $product_code = $this->input->post('hsn_code');
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $sub_cat = 0;
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $image = $this->input->post('image');
        
        
        $vari = array();
        $vari['v_type'] = $this->input->post('v_type');
        $vari['v_stock'] = $this->input->post('v_stock');
        $vari['v_alert'] = $this->input->post('v_alert');
        $vari['w_type'] = $this->input->post('w_type');
        $vari['w_stock'] = $this->input->post('w_stock');
        $vari['w_alert'] = $this->input->post('w_alert');
        $serial = array();
        $serial['new'] = '';
        $serial['old'] = '';
        if ($pid) {
            $this->products->edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat, $brand, $vari, $serial,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code);
        }
    }


    public function warehouseproduct_list()
    {
        $wid = $this->input->get('id'); 
        //$catid = 1;
        /* if($catid==1){
            $list = $this->products->get_datatables($catid, true);
        }else{
            $list = $this->categories_model->get_warehouseProductById($catid);
        } */
        
        $list = $this->categories_model->get_warehouseProductById($wid);
         

        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = $prd->warehouse_code;
            $row[] = $prd->product_name;
            $row[] = +$prd->qty;
            $row[] = $prd->warehouse_product_code;
            $row[] = $prd->c_title;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a><a href="' . base_url() . 'productcategory/moredetails?pid=' . $pid . '&wid='.$wid.'"  class="btn btn-primary btn-sm  "><span class="fa fa-eye"></span> More Details</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            //"recordsTotal" => $this->products->count_all($catid, true),
            "recordsTotal" => $no,
            //"recordsFiltered" => $this->products->count_filtered($catid, true),
            "recordsFiltered" => $no,
            "data" => $data,
        );  
        
        echo json_encode($output);
    }
    

    public function prd_stats()
    {
        $this->products->prd_stats();
    }

    public function stock_transfer_products()
    {
        $wid = $this->input->get('wid');
        $customer = $this->input->post('product');
        $terms = @$customer['term'];
        $result = $this->products->products_list($wid, $terms);
        echo json_encode($result);
    }
    
    public function conditionsdrop()
    {       
        $result = $this->conditions->conditions_list();
        echo json_encode($result);
    }
    
    public function coloursdrop()
    {       
        $result = $this->colours->colours_list();
        echo json_encode($result);
    }
    
    public function addvariantrow(){
        $data['row_count'] = $this->input->post('row_count');
        $data['variables'] = $this->units->variables_list();
        $this->load->view('products/addvariantrow',$data);
    }

     public function addcompovarirow(){
        $data['row_count'] = $this->input->post('row_count');
        $data['variables'] = $this->units->variables_list();
        $data['product'] = $this->products->products_list(1, $terms);
        $this->load->view('products/addcompovarirow',$data);
    }

    

    public function sub_cat()
    {
        $wid = $this->input->get('id');
        $result = $this->categories_model->category_list_all(1, $wid);
        echo json_encode($result);
    }


    public function stock_transfer25022021()
    {
        if ($this->input->post()) {
            $products_l = $this->input->post('products_l');
            $from_warehouse = $this->input->post('from_warehouse');
            $to_warehouse = $this->input->post('to_warehouse');
            $qty = $this->input->post('products_qty');
            $this->products->transfer($from_warehouse, $products_l, $to_warehouse, $qty);
        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/stock_transfer', $data);
            $this->load->view('fixed/footer');
        }
    }
    
    
    public function stock_transfer()
    {
        if ($this->input->post()) {
            $products_l = $this->input->post('products_l');
            $from_warehouse = $this->input->post('from_warehouse');
            $to_warehouse = $this->input->post('to_warehouse');
            $qty = $this->input->post('products_qty');
            $this->products->transfer($from_warehouse, $products_l, $to_warehouse, $qty);
        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/stock_transfer', $data);
            $this->load->view('fixed/footer');
        }
    }
    

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            if ($this->products->meta_delete($name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'
            ));
        }
    }

    public function barcode()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,barcode,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_name'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            /*print_r($data);
            $this->load->view('fixed/header', $head);
            $this->load->view('barcode/view', $data);
            $this->load->view('fixed/footer');*/
            $html = $this->load->view('barcode/view', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }
     public function barcode_bundle()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_code,barcode,code_type');
            $this->db->from('geopos_products_bundle');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('bid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_code'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            
            /*print_r($data);
            $this->load->view('fixed/header', $head);
            $this->load->view('barcode/view', $data);
            $this->load->view('fixed/footer');*/
            $html = $this->load->view('barcode/view-bundle', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }

    public function posbarcode()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,barcode,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_name'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            $html = $this->load->view('barcode/posbarcode', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }
     public function posbarcode_bundle()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_code,barcode,code_type');
            $this->db->from('geopos_products_bundle');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('bid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_name'];
            $data['code'] = $resultz['barcode'];
            $data['ctype'] = $resultz['code_type'];
            $html = $this->load->view('barcode/posbarcode', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');

        }
    }

   public function view_over()
    {
        $pid = $this->input->post('id');
        $this->db->select('sub,pid');
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
        
       $check_pcat = $this->db->query("SELECT * FROM `geopos_products` WHERE sub='".$pid."' || pid='".$pid."' GROUP by pcat");
           
           $total_pcat = $check_pcat->num_rows();
          
           if($total_pcat==1)
           {
           
              $pid = $this->input->post('id'); 
               
           }
           else
           {
           if($checkSub[0]->sub!=0)
        {
            
        $pid = $this->input->post('id'); 

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

        
  

        $this->db->select('geopos_products.*,geopos_warehouse.title');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.pid', $pid);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }


        $query = $this->db->get();
         //echo $this->db->last_query(); die;
        $data['product'] = $query->row_array();
        
        $data['variant'] = $this->products->getvariantById($pid);


        $this->db->select('geopos_products.*,geopos_warehouse.title,geopos_brand.title as brand_name,geopos_colours.name as colour_name,geopos_conditions.name as condition_type,geopos_units.name as unit_name');
        $this->db->from('geopos_products');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse','LEFT');
        $this->db->join('geopos_brand','geopos_products.b_id=geopos_brand.id','LEFT');
        $this->db->join('geopos_colours','geopos_products.colour_id=geopos_colours.id','LEFT');
        $this->db->join('geopos_units','geopos_products.vb=geopos_units.id','LEFT');
        $this->db->join('geopos_conditions','geopos_products.vc=geopos_conditions.id','LEFT');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('geopos_products.merge', 1);
        $this->db->where('geopos_products.sub', $pid);

        $query = $this->db->get();
        $data['product_variations'] = $query->result_array();
        

        $this->db->select('geopos_products.*,geopos_warehouse.title');
        $this->db->from('geopos_products');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('geopos_products.sub', $pid);
        $this->db->where('geopos_products.merge', 2);
        $query = $this->db->get();
        $data['product_warehouse'] = $query->result_array();
          


        $this->load->view('products/view-over', $data);
    }
    
    public function component_view_over()
    {
        $pid = $this->input->post('id');
       
        $this->db->select('*');
        $this->db->from('tbl_component');
        $this->db->where('tbl_component.id', $pid);
       

        $query = $this->db->get();
       
        $data['product'] = $query->row_array();

        $this->db->select('*');
        $this->db->from('tbl_component');
       
        $this->db->where('tbl_component.merge', 1);
        $this->db->where('tbl_component.sub', $pid);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;      
        $data['product_variations'] = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_component');
       
        $this->db->where('tbl_component.sub', $pid);
        $this->db->where('tbl_component.merge', 2);
        $query = $this->db->get();
        $data['product_warehouse'] = $query->result_array();
       
        
        $this->load->view('products/component-view-over', $data);
    }

    public function view_over_component()
    {
        $pid = $this->input->post('id');
        $this->db->select('tbl_component.*,geopos_warehouse.title');
        $this->db->from('tbl_component');
        $this->db->where('tbl_component.id', $pid);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_component.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }

        $query = $this->db->get();
        $data['product'] = $query->row_array();

        $this->db->select('tbl_component.*,geopos_warehouse.title');
        $this->db->from('tbl_component');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_component.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('tbl_component.merge', 1);
        $this->db->where('tbl_component.sub', $pid);
        $query = $this->db->get();
        $data['product_variations'] = $query->result_array();

        $this->db->select('tbl_component.*,geopos_warehouse.title');
        $this->db->from('tbl_component');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_component.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('tbl_component.sub', $pid);
        $this->db->where('tbl_component.merge', 2);
        $query = $this->db->get();
        $data['product_warehouse'] = $query->result_array();


        $this->load->view('products/view-over-component', $data);
    }
    



    
    public function view_over_bundle(){
        $pid = $this->input->post('id');
        $this->db->select('b.title as warehouse');
        $this->db->select('c.title as category');
        $this->db->select('a.product_code as code');
        $this->db->from("geopos_products_bundle as a");
        $this->db->join('geopos_warehouse as b', 'a.warehouse = b.id', 'LEFT');
        $this->db->join('geopos_product_cat as c', 'a.bcat = c.id', 'LEFT');
        $this->db->where('a.bid',$pid);
        $result = $this->db->get()->result_array();
        
        $this->db->select('a.product_name');
        $this->db->from('geopos_products as a');
        $this->db->join('geopos_products_bundle_combination as b', 'a.pid = b.pid', 'LEFT');
        $this->db->join('geopos_products_bundle as c', 'b.bid = c.bid', 'LEFT');
        $this->db->where('c.bid',$pid);
        $products = $this->db->get()->result();
        
        $i = 1;
        foreach($products as $row){
            $productName .= $i.". ".$row->product_name."<br>";
            $i++;
        }
        $product['pid'] = $pid;
        $product['productname'] = $productName;
        $product['code'] = $result[0]['code'];
        $product['warehouse'] = $result[0]['warehouse'];
        
        //print_r($product);die;
        $this->load->view('products/view-over-bundle', $product);
    }


    public function label()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();

            $html = $this->load->view('barcode/label', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');

        }
    }
    
    
    public function label_bundle()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_code,barcode,code_type');
            $this->db->from('geopos_products_bundle');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('bid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            
            $html = $this->load->view('barcode/label-bundle', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_code'] . '_label.pdf', 'I');

        }
    }


    public function poslabel()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $html = $this->load->view('barcode/poslabel', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');
            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }
    
    
    public function poslabel_bundle()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('product_code,barcode,code_type');
            $this->db->from('geopos_products_bundle');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('bid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $html = $this->load->view('barcode/poslabel-bundle', array('lab' => $resultz), true);
            ini_set('memory_limit', '64M');
            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }

    public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid WHERE geopos_invoice_items.pid='$pid' AND geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid WHERE geopos_purchase_items.pid='$pid' AND geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT rid2 AS qty, DATE(d_time) AS  invoicedate,note FROM geopos_movers  WHERE geopos_movers.d_type='1' AND rid1='$pid'  AND (DATE(d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }

            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $cat_ware = $this->categories_model->cat_ware($pid, $this->aauth->get_user()->loc);

//if(!$cat_ware) exit();
            $html = $this->load->view('products/statementpdf-ltr', array('report' => $result, 'product' => $product, 'cat_ware' => $cat_ware, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $product = $query->row_array();
            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }

    public function custom_label()
    {
        if ($this->input->post()) {
            $width = $this->input->post('width');
            $height = $this->input->post('height');
            $padding = $this->input->post('padding');
            $store_name = $this->input->post('store_name');
            $warehouse_name = $this->input->post('warehouse_name');
            $product_price = $this->input->post('product_price');
            $product_code = $this->input->post('product_code');
            $bar_height = $this->input->post('bar_height');
            $total_rows = $this->input->post('total_rows');
            $items_per_rows = $this->input->post('items_per_row');
            $products = array();


            foreach ($this->input->post('products_l') as $row) {
                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');
                $this->db->from('geopos_products');
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');

                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

                //  $this->db->where('warehouse', $warehouse);
                $this->db->where('geopos_products.pid', $row);
                $query = $this->db->get();
                $resultz = $query->row_array();

                $products[] = $resultz;

            }


            $loc = location($resultz['loc']);

            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);


            $html = $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering

            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');


        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/custom_label', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function standard_label()
    {
        if ($this->input->post()) {
            $width = $this->input->post('width');
            $height = $this->input->post('height');
            $padding = $this->input->post('padding');
            $store_name = $this->input->post('store_name');
            $warehouse_name = $this->input->post('warehouse_name');
            $product_price = $this->input->post('product_price');
            $product_code = $this->input->post('product_code');
            $bar_height = $this->input->post('bar_height');
            $total_rows = $this->input->post('total_rows');
            $items_per_rows = $this->input->post('items_per_row');
            $standard_label = $this->input->post('standard_label');
            $products = array();


            foreach ($this->input->post('products_l') as $row) {
                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');
                $this->db->from('geopos_products');
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');

                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

                //  $this->db->where('warehouse', $warehouse);
                $this->db->where('geopos_products.pid', $row);
                $query = $this->db->get();
                $resultz = $query->row_array();

                $products[] = $resultz;

            }


            $loc = location($resultz['loc']);

            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);

            switch ($standard_label) {
                case 'eu30019' :
                    $html = $this->load->view('standard_label/eu30019', array('products' => $products, 'style' => $design), true);
                    break;
            }


            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_en();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');


        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/standard_label', $data);
            $this->load->view('fixed/footer');
        }
    }
    
    
    public function subCatDropdownHtml($ProductCategoryId=''){
        if($ProductCategoryId == ''){
            $ProductCategoryId = $this->input->post('id',true);
        }
        $result = $this->categories_model->category_list_dropdown(1, $ProductCategoryId);
        if($result != false){
            //$html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
                $html .= "<option value='".$row->id."'>".$row->title."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }
        
    public function addbundle(){
        $data['cat'] = $this->categories_model->category_list();
        $data['units'] = $this->products->units();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        //$data['custom_fields'] = $this->custom->add_fields(4);
        $data['brand'] = $this->brand->brand_list();
        $data['products'] = $this->products->getAllProducts();          
        $data['variables'] = $this->units->variables_list();
        $head['title'] = "Add Bundle Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-bundle-add', $data);
        $this->load->view('fixed/footer');
    }
        
        
        
    public function addbundleproduct(){
        if($this->products->saveBundle()){
            redirect('products/bundleproducts');
        }
        else{
            redirect('products/addbundle');
        }
    }
    
    public function editbundleproduct(){
        $bundleid = $this->input->post('bundle_product_id',true);
        if($this->products->editBundle($bundleid)){
            redirect('products/bundleproducts');
        }
        else{
            redirect('products/productbundleedit?id='.$bundleid );
        }
    }   
        
    public function bundleproducts(){
        $head['title'] = "Bundle Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/bundle-products');
        $this->load->view('fixed/footer');
    
    }
        
    public function productbundleedit()
    {
        $bundleid = $this->input->get('id');
        $head['title'] = "Edit Bundle Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['units'] = $this->products->units();
        $data['product'] = $this->products->getBundleProductDetails($bundleid);
        $data['pdouctBundleDetails'] = $this->products->getProductBundleDetails($bundleid);
        $data['cat'] = $this->categories_model->category_list();
        $data['product_category_array'] = array_reverse(explode("-",substr($this->categories_model->getParentcategory($data['product']->bcat),1)));
        $data['product_category_array_title'] = $this->categories_model->getCategoryNames($data['product_category_array']);
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['mainproducts'] = $this->products->getAllProducts();
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-bundle-edit', $data);
        $this->load->view('fixed/footer');
    }
    
    public function getParentcat(){
        $id = $this->uri->segment(3);
        $data = array_reverse(explode("-",substr($this->categories_model->getParentcategory($id),1)));
        print_r($data);
    }
        
        
    public function getCategoryNames(){
        $arr = array(27,22,20,9);
        echo "<pre>";
        print_r($this->categories_model->getCategoryNames($arr));
    }
    
    public function getSql(){
        $this->view_over_bundle();
    }
    
    public function getCategories(){
        $page = $this->uri->segment(3);
        
        $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/list/categories?api_key=".$nb_key."&page=".$page,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/json"
                        ),
                        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }

        
    }
        
    public function getProducts(){
        $product = $this->uri->segment(3);
        $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/search?api_key=".$nb_key."&product=".$product,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/json"
                        ),
                        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }

        
    }
        
        public function getProductDetails(){
            $id = $this->uri->segment(3);
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/detail?api_key=".$nb_key."&id=".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }

            
        }
        public function getProductSpecification(){
            $id = $this->uri->segment(3);
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/specs?api_key=".$nb_key."&id=".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }

            
        }
        public function getProductImages(){
            $id = $this->uri->segment(3);
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

        curl_setopt_array($curl, array(
  CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/images?api_key=".$nb_key."&id=".$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
            
        }
        public function getProductPrices(){
            $id = $this->uri->segment(3);
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/price?api_key=".$nb_key."&id=".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }

            
        }
        public function getProductKeywords(){
            $product = $this->uri->segment(3);
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/search/suggest?api_key=".$nb_key."&product=".$product,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }

            
        }
        
        public function calculator(){
            $product_name = $this->input->post('product_name',true); 
            $buyingprice = $this->input->post('buying_price_p_calc',true); 
            $discount_type = $this->input->post('discount_on',true);
            $discount = $this->input->post('discount_p_calc',true);
            $discountapply = $this->input->post('discount_applied_state',true);
            $gst = $this->input->post('gst_percentage_p_calc',true);
            // echo "ttt";die;
            if($discount_type == 1 && $discount > 100){
                echo  "A";
            }
            else if($discount_type == 1 && $discount < 100){
                if($discountapply == 1){
                    $beforediscount = $buyingprice - ($buyingprice * $discount /100);
                    $gst_per = ($gst+100);
                    $without_gst = ($beforediscount * 100 / $gst_per);
                    $gst_val =  $beforediscount-$without_gst;
                    //$beforediscount = $beforediscount - ($beforediscount * 100 / $gst_per);
                    $without_gst_price =  $without_gst;
                }else{
                    $gst_per = ($gst+100);
                    $afterdiscount = ($buyingprice * 100 / $gst_per);
                    $gst_val =  $buyingprice - $afterdiscount;
                    //$afterdiscount = $buyingprice - ($buyingprice * 100 / $gst_per);
                    $afterdiscount = $afterdiscount - ($afterdiscount * $discount / 100);
                    $without_gst_price =  $afterdiscount;
                }
            }
            else{
                if($discountapply == 1){                    
                    $beforediscount = $buyingprice -  $discount;
                    $gst_per = ($gst+100);
                    $without_gst = ($beforediscount * 100 / $gst_per);
                    $gst_val =  $beforediscount-$without_gst;
                    //$beforediscount = $beforediscount - ($beforediscount * 100 / $gst_per);
                    $without_gst_price =  $without_gst;
                }else{
                    $gst_per = ($gst+100);
                    $after_gst_price = ($buyingprice * 100 / $gst_per);
                    $gst_val =  $buyingprice - $after_gst_price;
                    //$afterdiscount = $buyingprice - ($buyingprice * 100 / $gst_per);
                    $afterdiscount = $after_gst_price - $discount;
                    $without_gst_price = $afterdiscount;                    
                }
            }
            
            $gross_price = $without_gst_price+$gst_val;
            //$product_name = 'mi10-Specification-64 GB RAM-Super';         
            $cost = $this->products->getcostStructureByProductName($product_name);          
            //echo json_encode($cost);          
            
            $refurbishment_cost = $cost['refurbishment_cost'];
            $refurbishment_cost_type = $cost['refurbishment_cost_type'];
            $packaging_cost = $cost['packaging_cost'];
            $packaging_cost_type = $cost['packaging_cost_type'];
            $sales_support = $cost['sales_support'];
            $sales_support_type = $cost['sales_support_type'];
            $promotion_cost = $cost['promotion_cost'];
            $promotion_cost_type = $cost['promotion_cost_type'];
            $hindizo_infra = $cost['hindizo_infra'];
            $hindizo_infra_type = $cost['hindizo_infra_type'];
            $hindizo_margin = $cost['hindizo_margin'];
            $hindizo_margin_type = $cost['hindizo_margin_type'];
            
            
            $refurbishment_cost_actual =NULL;
            $packaging_cost_actual =NULL;
            $sales_support_actual =NULL;
            $promotion_cost_actual =NULL;
            $hindizo_infra_actual =NULL;
            $hindizo_margin_actual =NULL;
            $product_cost = $without_gst_price;
            
            if($refurbishment_cost_type==2){
                $refurbishment_cost_actual = (($without_gst_price*$refurbishment_cost)/100);
                $product_cost =  $product_cost + $refurbishment_cost_actual;
                $refurbishment_cost = $refurbishment_cost_actual;
            }else if($refurbishment_cost_type==1){
                $product_cost =  $product_cost + $refurbishment_cost;
            }
            
            if($packaging_cost_type==2){
                $packaging_cost_actual = (($without_gst_price*$packaging_cost)/100);
                $product_cost =  $product_cost + $packaging_cost_actual;
                $packaging_cost = $packaging_cost_actual;
            }else if($packaging_cost_type==1){
                $product_cost =  $product_cost + $packaging_cost;
            }
            
            if($sales_support_type==2){
                $sales_support_actual = (($without_gst_price*$sales_support)/100);
                $product_cost =  $product_cost + $sales_support_actual;
                $sales_support = $sales_support_actual;
            }else if($sales_support_type==1){
                $product_cost =  $product_cost + $sales_support;
            }
            
            if($promotion_cost_type==2){
                $promotion_cost_actual = (($without_gst_price*$promotion_cost)/100);
                $product_cost =  $product_cost + $promotion_cost_actual;
                $promotion_cost = $promotion_cost_actual;
            }else if($promotion_cost_type==1){
                $product_cost =  $product_cost + $promotion_cost;
            }
            
            if($hindizo_infra_type==2){
                $hindizo_infra_actual = (($without_gst_price*$hindizo_infra)/100);
                $product_cost =  $product_cost + $hindizo_infra_actual;
                $hindizo_infra = $hindizo_infra_actual;
            }else if($hindizo_infra_type==1){
                $product_cost =  $product_cost + $hindizo_infra;
            }
            
            if($hindizo_margin_type==2){                
                $hindizo_margin_actual = (($without_gst_price*$hindizo_margin)/100);
                $product_cost =  $product_cost + $hindizo_margin_actual;
                $hindizo_margin = $hindizo_margin_actual;
            }else if($hindizo_margin_type==1){
                $product_cost =  $product_cost + $hindizo_margin;
            }
            
            $return_data['refurbishment_cost'] = $refurbishment_cost;
            $return_data['refurbishment_cost_type'] = $refurbishment_cost_type;
            $return_data['packaging_cost'] = $packaging_cost;
            $return_data['packaging_cost_type'] = $packaging_cost_type;
            $return_data['sales_support'] = $sales_support;
            $return_data['sales_support_type'] = $sales_support_type;
            $return_data['promotion_cost'] = $promotion_cost;
            $return_data['promotion_cost_type'] = $promotion_cost_type;
            $return_data['hindizo_infra'] = $hindizo_infra;
            $return_data['hindizo_infra_type'] = $hindizo_infra_type;
            $return_data['hindizo_margin'] = $hindizo_margin;
            $return_data['hindizo_margin_type'] = $hindizo_margin_type;
            
            $return_data['product_cost'] = $product_cost;
            $return_data['without_gst_price'] = $without_gst_price;
            $return_data['gst'] = $gst_val;         
            $return_data['gross_price'] = $gross_price; 
            echo json_encode($return_data);
        }
        
        public function getProductsA(){
            //$product = $this->uri->segment(3);
            $product = $this->input->post('term');
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/search?api_key=".$nb_key."&product=".$product,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        //echo $response;
                        $res = json_decode($response);                      
                        echo json_encode($res->data);                       
                    }

            
        }
        
        public function getVarientProduct(){
            //$product = $this->uri->segment(3);
            $product = $this->input->post('term');
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/search?api_key=".$nb_key."&product=".$product,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                
                            ),
                            ));     

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                } else {
                    //echo $response;
                    $res = json_decode($response);                      
                    echo json_encode($res->data[0]);                        
                }           
        }
        
        
        public function getAverageProductPrice(){
            //$id = $this->uri->segment(3);
            $id = $this->input->post('id');
            
            $nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/price?api_key=".$nb_key."&id=".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
                            ),
                            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
                    } else {
                        //echo $response;
                        $res = json_decode($response);
                        //print_r($res);
                        $sum = 0;
                        $i=0;
                        $avg_price = 0;
                        foreach($res as $key=>$val){
                            if($val!=''){
                                $sum = $sum+$val;
                                $i++;
                            }
                        }   
                        if($sum!=0){
                            echo $avg_price = $sum/$i;  
                        }else{
                            echo "N/A";
                        }
                    }       
        }
        
        public function salecalculator(){
            $product_name_d_api = $this->input->post('product_name_d_api',true);
            $varient_name_d_api = $this->input->post('varient_name_d_api',true);
            $average_price_d_api = $this->input->post('average_price_d_api',true);
            $wproduct_name_d = $this->input->post('wproduct_name_d',true);
            $purchase_price_d = $this->input->post('purchase_price_d',true);
            $discount_type = $this->input->post('discount_type',true);
            $discount_d = $this->input->post('discount_d',true);
            $gst_d = $this->input->post('gst_d',true);
            //$wproduct_name_d = 'mi10-Specification-64 GB RAM-Super';
            $product_records = $this->products->getCostByProductName($wproduct_name_d);
                        
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
            
            
                        
            foreach($product_records->parent_category_ids as $key=>$cat_id){
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
                
            }
                        
            $price = 0;
            // echo "ttt";die;
            if($discount_type == 1 && $discount_d > 100){
                echo  "A";
            }
            
            else if($discount_type == 1 && $discount_d < 100){      
                $discount_d = (($average_price_d_api * $discount_d)/100);
                $price = $average_price_d_api - $discount_d;
                $gst = $gst_d+100;
                $withoutgstprice = ($price * 100 / $gst);
                $gst_price = $price - $withoutgstprice;
                $withgstprice = $withoutgstprice + $gst_price;                          
            }
            else if($discount_type == 2){               
                $price = $average_price_d_api -  $discount_d;
                $gst = $gst_d+100;
                $withoutgstprice = ($price * 100 / $gst);
                $gst_price = $price - $withoutgstprice;
                $withgstprice = $withoutgstprice + $gst_price;              
            }
            
            $refurbishment_cost_actual =NULL;
            $packaging_cost_actual =NULL;
            $sales_support_actual =NULL;
            $promotion_cost_actual =NULL;
            $hindizo_infra_actual =NULL;
            $hindizo_margin_actual =NULL;
            $product_cost = 0;
            
            if($refurbishment_cost_type==2){
                $refurbishment_cost_actual = (($withgstprice*$refurbishment_cost)/100);
                $product_cost =  $withgstprice - $refurbishment_cost_actual;
            }else if($refurbishment_cost_type==1){
                $product_cost =  $withgstprice - $refurbishment_cost;
            }
            
            if($packaging_cost_type==2){
                $packaging_cost_actual = (($withgstprice*$packaging_cost)/100);
                $product_cost =  $product_cost - $packaging_cost_actual;
            }else if($packaging_cost_type==1){
                $product_cost =  $product_cost - $packaging_cost;
            }
            
            if($sales_support_type==2){
                $sales_support_actual = (($withgstprice*$sales_support)/100);
                $product_cost =  $product_cost - $sales_support_actual;
            }else if($sales_support_type==1){
                $product_cost =  $product_cost - $sales_support;
            }
            
            if($promotion_cost_type==2){
                $promotion_cost_actual = (($withgstprice*$promotion_cost)/100);
                $product_cost =  $product_cost - $promotion_cost_actual;
            }else if($promotion_cost_type==1){
                $product_cost =  $product_cost - $promotion_cost;
            }
            
            if($hindizo_infra_type==2){
                $hindizo_infra_actual = (($withgstprice*$hindizo_infra)/100);
                $product_cost =  $product_cost - $hindizo_infra_actual;
            }else if($hindizo_infra_type==1){
                $product_cost =  $product_cost - $hindizo_infra;
            }
            
            if($hindizo_margin_type==2){                
                $hindizo_margin_actual = (($withgstprice*$hindizo_margin)/100);
                $product_cost =  $product_cost - $hindizo_margin_actual;
            }else if($hindizo_margin_type==1){
                $product_cost =  $product_cost - $hindizo_margin;
            }   
        
            $return_data['purchase_price_d'] = $purchase_price_d;
            $return_data['product_cost'] = $product_cost;
            $return_data['gst_price'] = round($gst_price);
            $return_data['withoutgstprice'] = round($withoutgstprice);
            $return_data['withgstprice'] = $withgstprice;
            $return_data['discount_d'] = $discount_d;
            $return_data['average_price_d_api'] = $average_price_d_api;
            $return_data['pid'] = $product_records->pid;
            
            $return_data['refurbishment_cost'] = $refurbishment_cost;
            $return_data['refurbishment_cost_type'] = $refurbishment_cost_type;
            $return_data['refurbishment_cost_actual'] = $refurbishment_cost_actual;
            
            $return_data['packaging_cost'] = $packaging_cost;
            $return_data['packaging_cost_type'] = $packaging_cost_type;
            $return_data['packaging_cost_actual'] = $packaging_cost_actual;
            
            $return_data['sales_support'] = $sales_support;
            $return_data['sales_support_type'] = $sales_support_type;
            $return_data['sales_support_actual'] = $sales_support_actual;
            
            $return_data['promotion_cost'] = $promotion_cost;
            $return_data['promotion_cost_type'] = $promotion_cost_type;
            $return_data['promotion_cost_actual'] = $promotion_cost_actual;
            
            $return_data['hindizo_infra'] = $hindizo_infra;
            $return_data['hindizo_infra_type'] = $hindizo_infra_type;
            $return_data['hindizo_infra_actual'] = $hindizo_infra_actual;
            
            $return_data['hindizo_margin'] = $hindizo_margin;
            $return_data['hindizo_margin_type'] = $hindizo_margin_type;
            $return_data['hindizo_margin_actual'] = $hindizo_margin_actual;         
            
            echo json_encode($return_data);
        }
        
        public function setSalePrice(){
            echo $save = $this->products->setSalePrice();            
        }
        
        public function getProductRecords(){            
            $records = $this->products->getProductRecords();
            echo json_encode($records);
        }
        
        public function getcostStructureByProductName(){
            $cost = $this->products->getcostStructureByProductName('mi10-Specification-64 GB RAM-Good');
            echo "<pre>";
            print_r($cost);
            echo "</pre>"; 
        }
        
        public function getCatCommisionMax(){           
            $commission = $this->products->getCatCommisionMax($module_id='',$category_id=28,$purpose=2,$franchise_id='',$commissiontype='renting_commision_percentage');
            echo "<pre>";
            print_r($commission);
            echo "</pre>"; 
        }
        public function productcomponent()
    {
        $data['cat'] = $this->categories_model->category_list();
        $data['units'] = $this->products->units();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $data['brand'] = $this->brand->brand_list();
        $data['product'] = $this->products->products_list(1, $terms);
        $data['autogencode'] = $this->products->lastcomponentid();
       
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $data['conditions'] = $this->conditions->conditions_list();
        $head['title'] = "Add Item Component";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/item-component', $data);
        $this->load->view('fixed/footer');
    }
     public function manageproductcomponent(){
        $head['title'] = "Manage Product Components";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/manage-component');
        $this->load->view('fixed/footer');
    
    }
    

     public function add_component()
    {
        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $catid = 0;
        $hsn_code = $this->input->post('hsn_code',true);
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit', true);
        $code_type = $this->input->post('code_type');
        $barcode = $this->input->post('barcode');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $wdate = datefordatabase($this->input->post('wdate'));
        $image = $this->input->post('image');
         
        $product_component = $this->input->post('products_l'); 
      
        $v_type = $this->input->post('v_type');        
        $v_stock = $this->input->post('v_stock');
        $zupc_code = $this->input->post('zupc_code');
        $w_type = $this->input->post('w_type');
        $w_stock = $this->input->post('w_stock');
        $w_alert = $this->input->post('w_alert');
        $product_code = $this->input->post('hsn_code',true);
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $sub_cat = '';
        $serial = '';
        $product_type = $this->input->post('product_type');

        
        $conditions = $this->input->post('conditions');
                
        if ($brand) {
            //echo $product_type; die;
            $this->products->add_new_component($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $zupc_code, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand, $serial,$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_component,$product_type);
            
            
            //$this->asset->addnew($product_name,$brand,$catid,$hsn_code,$product_model,$warehouse,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_desc,$unit,$code_type,$barcode,$product_qty_alert,$wdate,$image,$v_type,$v_stock,$v_alert,$w_type,$w_stock,$w_alert);
        }
    }

    public function component_list()
    {
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');

        if ($catid > 0) {
            $list = $this->products->get_component($catid, '', $sub);
           
        } else {
            $list = $this->products->get_component();
        }

        
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->id;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline"><img src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span></a>';
            $row[] = $prd->component_name;
            $row[] = +$prd->qty;
            $row[] = $prd->warehouse_product_code;
            $row[] = $prd->title;
           
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> 
            <div class="btn-group">
                                        
                                    <div class="dropdown-menu">
                                        <div class="dropdown-divider"></div> 
                                         </div></div>  <div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
            &nbsp;<a href="' . base_url() . 'products/component_edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            //"recordsTotal" => $this->products->count_all($catid, '', $sub),
            //"recordsFiltered" => $this->products->component_count_filtered($catid, '', $sub),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }



    public function component_edit()
    {
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('tbl_component');
        $this->db->where('id', $pid);

        $query = $this->db->get();
        $data['component_detail'] = $query->row_array();
       
        if ($data['component_detail']['merge'] > 0) {
            $this->db->select('*');
            $this->db->from('tbl_component');
            $this->db->where('merge', 1);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_var'] = $query->result_array();
            $this->db->select('*');
            $this->db->from('tbl_component');
            $this->db->where('merge', 2);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_ware'] = $query->result_array();
        }

        $this->db->select('title');
        $this->db->from('geopos_warehouse');
        $this->db->where('id',$data['component_detail']['warehouse']);
        $warehouse = $this->db->get();
        $data['warehouse2'] = $warehouse->row_array();
        
        
        $data['brand'] = $this->brand->brand_list();
        $data['units'] = $this->products->units();
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
       
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['cat'] = $this->categories_model->category_list();
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 4);
        $data['product_variant'] = $this->products->component_getvariantById($pid);
        $head['title'] = "Edit Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('units_model', 'units');
        $data['product'] = $this->products->products_list(1, $terms);
       
        $this->load->view('fixed/header', $head);
        $this->load->view('products/component-edit', $data);
        $this->load->view('fixed/footer');

    }


 public function update_component()
    {
        $pid = $this->input->post('pid');
        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $cat = $this->input->post('product_cat');
        $catid = 0;
      
        
        $hsn_code = $this->input->post('hsn_code',true);
        $product_code = $this->input->post('hsn_code');
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $sub_cat = 0;
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $image = $this->input->post('image');
        
        
        $vari = array();
        $vari['v_type'] = $this->input->post('v_type');
        $vari['v_stock'] = $this->input->post('v_stock');
        $vari['zupc_code'] = $this->input->post('zupc_code');
        $vari['w_type'] = $this->input->post('w_type');
        $vari['w_stock'] = $this->input->post('w_stock');
        $vari['w_alert'] = $this->input->post('w_alert');
        $serial = array();
        $serial['new'] = '';
        $serial['old'] = '';
        if ($pid) {
            $this->products->edit_component_detail($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat, $brand, $vari, $serial,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code);
        }
    }


     public function delete_component()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('tbl_component', array('id' => $id));
                $this->db->delete('tbl_component', array('sub' => $id, 'merge' => 1));
                $this->db->set('merge', 0);
                $this->db->where('sub', $id);
                $this->db->update('tbl_component');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function checkcomponent(){       
        $serial_no = $this->input->post('serial_no');
        $result = $this->products->checkcomponent($serial_no);
        $str = '';
        if($result){
            $i=1;
            foreach($result as $key=>$row){
                $str .= '<tr><td><b>'.$i.'.</b></td><td>'.$row->component_actual_name.'</td></tr>';
                $i++;
            }
            echo '<input type="hidden" name="serial" id="serial" value="'.$serial_no.'">'.$str;
        }else{
            echo '<input type="hidden" name="serial" id="serial" value="'.$serial_no.'">Not Available';
        }
    }
     
}