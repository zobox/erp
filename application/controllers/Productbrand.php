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

class Productbrand extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('brand_model', 'brand');
        $this->load->library("Aauth");
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
        $data['brand'] = $this->brand->getBrand();
        $head['title'] = "Product Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/brand', $data);
        $this->load->view('fixed/footer');
    }   


    

    public function add()
    {
        $data['cat'] = $this->brand->brand_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Product Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/brand_add', $data);
        $this->load->view('fixed/footer');
    }   

    public function addbrand()
    {
        $brand_name = $this->input->post('name', true);
        $brand_desc = $this->input->post('desc', true);       
        if ($brand_name) {
            $this->brand->addnew($brand_name, $brand_desc);
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

   

    

//view for edit
    public function edit()
    {
		$catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_brand');
        $this->db->where('id', $catid);
		
        $query = $this->db->get();
		
        $data['productbrand'] = $query->row_array();
        //$data['cat'] = $this->brand->brand_list();
        $head['title'] = "Edit Product Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-brand-edit', $data);
        $this->load->view('fixed/footer');

    }

    

    public function editbrand()
    {
		$cid = $this->input->post('catid');
        $name = $this->input->post('name');
        $desc = $this->input->post('desc');        
       
        if ($cid) {
            $this->brand->edit($cid, $name, $desc);
        }
    }


}