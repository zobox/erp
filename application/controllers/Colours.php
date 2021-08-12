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

class Colours extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('colours_model', 'colours');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


    }

    public function index()
    {

        $head['title'] = "Product Colours";
        $data['colours'] = $this->colours->colours_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('colours/index', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {		
        if ($this->input->post()) {			
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);

            $this->colours->create($name, $code);
        } else {


            $head['title'] = "Add Coloures";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('colours/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);
            $this->colours->edit($id, $name, $code);
        } else {


            $head['title'] = "Edit Colours";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->colours->view($this->input->get('id'));
            $this->load->view('fixed/header', $head);
            $this->load->view('colours/edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_colours', array('id' => $id));

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
    

}