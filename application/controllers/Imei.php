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

class Imei extends CI_Controller
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

		$this->load->model('Imei_model', 'imei');
		$this->load->model('products_model', 'products');
		$this->load->model('ewb_model', 'ewb');
        $this->load->model('categories_model');
        $this->load->model('chart_model', 'chart');
		$this->load->model('settings_model', 'settings');

		$this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('invoices_model', 'invocies');
		$this->load->library("Custom");
		$this->load->library("Common");

        $this->li_a = 'stock';
    }
	

    public function index()
    {	
		$this->load->view('fixed/header');
		$this->load->view('imei/imei_transfer',$data);
		$this->load->view('fixed/footer');
	}
	
	
	public function getSerialDetails(){
		$serial = $this->input->post('serial');
		$record = $this->imei->getSerialDetails($serial);
		
		switch($record->status){
			case 0 : $status = 'Inactive';
			break;
			case 1 : $status = 'Active';
			break;
			case 2 : $status = 'Sold';
			break;
			case 3 : $status = 'Misplaced';
			break;
			case 4 : $status = 'Zobox Sales';
			break;
			case 5 : $status = 'Bundle Product';
			break;
			case 8 : $status = 'Not In Use(Duplicate Date)';
			break;
			case 9 : $status = 'Stock Return';
			break;
		}
		
		
		if($record->is_present==1){ $is_present = 'Yes'; }else{ $is_present = 'No'; }
		if($record->hold_status==1){ $hold_status = 'Yes'; }else{ $hold_status = 'No'; }
		
		$str = '<table id="productstable" class="table table-striped table-bordered zero-configuration dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="productstable_info" style="width: 100%;">
				<thead>
					<tr role="row">
						<th>Serial</th>
						<th>Status</th>
						<th>Is Present</th>
						<th>Hold Status</th>
						<th>Invoice Id</th>
						<th>Warehouse</th>
						<th>Product Name</th>
						<th>sale Price</th>
					</tr>
				</thead>
				<tbody>
					<tr role="row">			
						<td>'.$record->serial.'</td>
						<td>'.$status.'</td>
						<td>'.$is_present.'</td>
						<td>'.$hold_status.'</td>
						<td>'.$record->tid.'</td>
						<td>'.$record->warehouse.'</td>
						<td>'.$record->product_name.'</td>
						<td>'.$record->sale_price.'</td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr role="row">
						<th>Serial</th>
						<th>Status</th>
						<th>Is Present</th>
						<th>Hold Status</th>
						<th>Invoice Id</th>
						<th>Warehouse</th>
						<th>Product Name</th>
						<th>sale Price</th>
					</tr>
				</tfoot>
			</table>';
		
			echo $str;
		
		
		//echo json_encode($record);
	}
	
	
	public function getwarehouseDropDown(){
		$serial = $this->input->post('serial');
		$record = $this->imei->getSerialDetails($serial);
		$warehouse = $this->ewb->getwarehouseDropDown($record->twid);
		$data['warehouse'] = $warehouse;		
		$this->load->view('imei/getwarehouseDropDown',$data);
	}
	
	public function transfer(){
		echo $this->imei->transfer();
	}
	
	

}