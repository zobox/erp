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

class Agency extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('agency_model','agency');	
		/*$this->load->model('employee_model', 'employee');
		$this->load->model('communication_model');*/
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }	
		//echo $this->aauth->premission(9);
        if (!$this->aauth->premission(3)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }

    public function index()
    {	
		if (!$this->aauth->premission(3)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
		
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Agency';	
		$data['agency_registration'] = $this->agency->GetRecords();
		
        $this->load->view('fixed/header', $head);	
		$this->load->view('agency/agencylist', $data);
		$this->load->view('fixed/footer');
		
    }
	
	public function activateuser()
	{
		$regId = $this->input->get('reg_id',true);
		$this->agency->activateuser($regId);
		return true;
	}
	
	public function view(){
		$agencyId = $this->uri->segment(3);
		$data['agency_details'] = $this->agency->getAgencyDataById($agencyId);
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Agency View';	
		$this->load->view('fixed/header', $head);
		$this->load->view('agency/view', $data);
		$this->load->view('fixed/footer');
		
	}
	
	
	
}