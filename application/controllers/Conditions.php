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

class Conditions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('conditions_model', 'conditions');
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

        $head['title'] = "Product Conditions";
        $data['conditions'] = $this->conditions->conditions_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('conditions/index', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {		
        if ($this->input->post()) {			
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);

            $this->conditions->create($name, $code);
        } else {


            $head['title'] = "Add Conditions";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('conditions/create');
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $code = $this->input->post('code', true);
            $this->conditions->edit($id, $name, $code);
        } else {


            $head['title'] = "Edit Conditions";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->conditions->view($this->input->get('id'));
            $this->load->view('fixed/header', $head);
            $this->load->view('conditions/edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_conditions', array('id' => $id));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
    

}