<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Software
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

class Commission_wallet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    //Commission Wallet list
    public function index()
    {
        $head['title'] = "Manage Commission Wallet";
        $this->load->view('includes/header');		
		//$list = $this->invocies->get_datatables();
		$total_commission = 0;
		/* foreach ($list as $invoices) {			
			$products = $this->invocies->invoice_products($invoices->id);			
			$franchise_commision = 0;
			foreach($products as $prow){
				$franchise_commision += $prow['franchise_commision'];
			}
			$total_commission += $franchise_commision;
		} */	
		$list = $this->invocies->getInvoiceDTL();
		foreach ($list as $invoices) {			
			$products = $this->invocies->invoice_products($invoices->id);			
			$franchise_commision = 0;
			if($invoices->type==2){
				foreach($products as $prow){				
					$franchise_commision += $prow['franchise_commision'];				
				}
			}else if($invoices->type==4){
				$franchise_commision -= $invoices->total;
			}
			
			$total_commission += $franchise_commision;
		}
		$data['total_commission'] = $total_commission;	
        $this->load->view('commission_wallet/commission_wallet', $data);
        $this->load->view('includes/footer');
    }


    public function ajax_list()
    {
		
        $query = $this->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();

        $this->config->set_item('currency', $row["currency"]);


        //$list = $this->invocies->get_datatables();
        $list = $this->invocies->getInvoiceDTL();
        /* echo "<pre>";
		print_r($list);
		echo "</pre>"; exit; */
		
        $data = array();

        $no = $this->input->post('start');
        $curr = $this->config->item('currency');
		
		foreach ($list as $invoices) {			
			$products = $this->invocies->invoice_products($invoices->id);			
			$franchise_commision = 0;
			if($invoices->type==2){
				foreach($products as $prow){				
					$franchise_commision += $prow['franchise_commision'];				
				}
			}else if($invoices->type==4){
				$franchise_commision -= $invoices->total;
			}
			
			$total_commission += $franchise_commision;
		}
		$closing_balance = $total_commission;
        foreach ($list as $invoices) {			
			$products = $this->invocies->invoice_products($invoices->id);			
			$franchise_commision = 0;
			foreach($products as $prow){
				$franchise_commision += $prow['franchise_commision'];				
			}
			
			$debit_amount = 0;
			if($invoices->type==4){
				$debit_amount = $invoices->total;
			}
			
            $no++;
            $row = array();
            //$row[] = $no;
			$row[] = $invoices->invoicedate;			
            $row[] = '<a href="' . base_url("commission_wallet/view?id=$invoices->id") . '"><i class="fa fa-file-text"></i> ' . $this->config->item('prefix') . ' #' . $invoices->tid . '</a>';
			$row[] = $franchise_commision;			
            $row[] = $debit_amount;            
			$row[] = amountExchange($closing_balance,$invoices->multi);
                       
            //$row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            

            $data[] = $row;
			if($invoices->type==2){
				$closing_balance -= $franchise_commision;
			}else if($invoices->type==4){
				$closing_balance += $invoices->total;
			}
			
        }
		
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all(),
            "recordsFiltered" => $this->invocies->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {



        $data['acclist'] = '';
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;

        $data['invoice'] = $this->invocies->invoice_details($tid);			
		
        if($data['invoice']['csd']==$this->session->userdata('user_details')[0]->cid){
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->view('includes/header');
        $this->load->view('commission_wallet/view', $data);
        $this->load->view('includes/footer');
    }

    }


}