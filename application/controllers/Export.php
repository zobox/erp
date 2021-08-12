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

class Export extends CI_Controller
{
    var $date;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
		$this->load->library('excel');
        $this->load->model('export_model', 'export');
		$this->load->model('customers_model', 'customers');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 5 && $this->aauth->get_user()->roleid!=1) {

            exit('Not Allowed!');
        }
        $this->date = 'backup_' . date('Y_m_d_H_i_s');
        $this->li_a = 'export';
    }


    function dbexport()
    {
		$head['title'] = "Backup Database";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/db_back');
        $this->load->view('fixed/footer');
    }


    function dbexport_c()
    {

        $this->load->dbutil();
        $backup =& $this->dbutil->backup();
        $this->load->helper('file');
        write_file('<?php  echo base_url();?>/downloads', $backup);
        $this->load->helper('download');
        force_download($this->date . '.gz', $backup);
    }


    function crm()
    {


        $head['title'] = "Export CRM Data";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/crm');
        $this->load->view('fixed/footer');


    }


    function crm_now()
    {


        $type = $this->input->post('type');

        switch ($type) {
            case 1 :
                $this->customers();
                break;

            case 2 :
                $this->suppliers();
                break;
        }


    }

    private function customers()
    {

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=customers_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " WHERE loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " WHERE loc='0';";
        }


        $query = $this->db->query("SELECT name,address,city,region,country,postbox,email,phone,company FROM geopos_customers $whr");
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);
        //  force_download('customers_' . $this->date . '.csv', );

    }

    private function suppliers()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " WHERE loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " WHERE loc='0';";
        }
        $query = $this->db->query("SELECT name,address,city,region,country,postbox,email,phone,company FROM geopos_supplier $whr");
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=suppliers_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);

    }

    function transactions()
    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/transactions', $data);
        $this->load->view('fixed/footer');
    }

    function transactions_o()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " AND loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " AND loc='0';";
        }

        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        if ($pay_acc == 'All') {
            if ($trans_type == 'All') {
                $where = " WHERE (DATE(date) BETWEEN '$sdate' AND '$edate') ";
            } else {
                $where = " WHERE (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
            }
        } else {
            if ($trans_type == 'All') {
                $where = " WHERE acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";
            } else {
                $where = " WHERE acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
            }
        }

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=transactions_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');
        $query = $this->db->query("SELECT account,type,cat AS category,debit,credit,payer,method,date,note FROM geopos_transactions" . $where . ' ' . $whr);
        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);
    }


    function products()
    {
        $head['title'] = "Export Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/products');
        $this->load->view('fixed/footer');
    }

    function products_o()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id WHERE geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id WHERE geopos_warehouse.loc='0';";
        }

        $type = $this->input->post('type');
        $query = '';
        switch ($type) {
            case 1 :
                $query = "SELECT product_name,product_code,product_price,fproduct_price AS factory_price,taxrate,disrate AS discount_rate,qty FROM geopos_products $whr";
                break;

            case 2 :
                $query = "SELECT geopos_product_cat.title as category,geopos_products.product_name,geopos_products.product_code,geopos_products.product_price,geopos_products.fproduct_price AS factory_price,geopos_products.taxrate,geopos_products.disrate AS discount_rate,geopos_products.qty FROM geopos_products LEFT JOIN geopos_product_cat ON geopos_products.pcat=geopos_product_cat.id $whr";
                break;
        }
        $query = $this->db->query($query);
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=transactions_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');


        echo "\xEF\xBB\xBF"; // Byte Order Mark
        echo $this->dbutil->csv_from_result($query);

    }


    function account()
    {


        $this->load->model('transactions_model');
        $this->load->model('employee_model');
        $data['cat'] = $this->transactions_model->categories();
        $data['emp'] = $this->employee_model->list_employee();
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/account', $data);
        $this->load->view('fixed/footer');


    }

    function accounts_o()
    {
        $this->load->model('reports_model');
        $this->load->model('accounts_model');

        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['account'] = $this->accounts_model->details($pay_acc);


        $data['list'] = $this->reports_model->get_statements($pay_acc, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Account Statement');
        $data['lang']['title'] = $this->lang->line('Account');
        $data['lang']['var1'] = $data['account']['holder'];
        $data['lang']['var2'] = $data['account']['acn'];

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $pay_acc . '.pdf', 'D');


    }

    function employee()
    {
        $this->load->model('reports_model');
        $this->load->model('accounts_model');

        $pay_acc = $this->input->post('employee');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $this->load->model('employee_model');
        $data['employee'] = $this->employee_model->employee_details($pay_acc);


        $data['list'] = $this->reports_model->get_statements_employee($pay_acc, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Employee Account Statement');
        $data['lang']['title'] = $this->lang->line('Employee');
        $data['lang']['var1'] = $data['employee']['name'];
        $data['lang']['var2'] = $data['employee']['email'];
        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $pay_acc . '.pdf', 'D');


    }

    function trans_cat()
    {
        $this->load->model('reports_model');
        $this->load->model('transactions_model');

        $pay_cat = $this->input->post('pay_cat', true);
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['cat'] = $this->transactions_model->cat_details_name($pay_cat);


        $data['list'] = $this->reports_model->get_statements_cat($pay_cat, $trans_type, $sdate, $edate);

        $data['lang']['statement'] = $this->lang->line('Transaction Categories Statement');
        $data['lang']['title'] = $this->lang->line('Transaction Categories');
        $data['lang']['var1'] = $data['cat'] ['name'];
        $data['lang']['var2'] = '';
        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;
        $html = $this->load->view('accounts/statementpdf-' . LTR, $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $data['lang']['var1'] . '.pdf', 'D');


    }

    function customer()
    {
        $this->load->model('reports_model');
        $this->load->model('customers_model');

        $customer = $this->input->post('customer');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->customers_model->details($customer);


        $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type, $sdate, $edate);

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;


        $html = $this->load->view('customers/statementpdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function supplier()
    {
        $this->load->model('reports_model');
        $this->load->model('supplier_model');

        $customer = $this->input->post('supplier');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->supplier_model->details($customer);

        $data['list'] = $this->reports_model->get_supplier_statements($customer, $trans_type, $sdate, $edate);

        $loc = location($this->aauth->get_user()->loc);
        $company = '<strong>' . $loc['cname'] . '</strong><br>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
        if ($loc['taxid']) $company .= '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
        $data['lang']['company'] = $company;

        $html = $this->load->view('supplier/statementpdf', $data, true);

        ini_set('memory_limit', '64M');

        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($html);

        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function taxstatement()
    {


        $head['title'] = "Export TAX Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/taxstatement');
        $this->load->view('fixed/footer');


    }

    function taxstatement_o()
    {
        $whr = '';
        $whr2 = '';
        if ($this->aauth->get_user()->loc) {
            $whr = " AND geopos_invoices.loc='" . $this->aauth->get_user()->loc . "';";
            $whr2 = " AND geopos_purchase.loc='" . $this->aauth->get_user()->loc . "';";
        } elseif (!BDATA) {
            $whr = " AND geopos_invoices.loc='0';";
            $whr2 = " AND geopos_purchase.loc='0';";
        }

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $trans_type = $this->input->post('ty');
        $prefix = $this->config->item('prefix') . '-';
        $curr = $this->config->item('currency') . ' ';

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=tax_transactions_' . $this->date . '..csv');
        header('Content-Transfer-Encoding: binary');


        echo "\xEF\xBB\xBF"; // Byte Order Mark


        if ($trans_type == 'Sales') {
            $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate') $whr";
            $query = $this->db->query("SELECT geopos_customers.taxid AS TAX_Number,concat('$prefix',geopos_invoices.tid) AS invoice_number,concat('$curr',geopos_invoices.total) AS amount,geopos_invoices.shipping AS shipping,geopos_invoices.ship_tax AS ship_tax,geopos_invoices.ship_tax_type AS ship_tax_type,geopos_invoices.discount AS discount,geopos_invoices.tax AS tax,geopos_invoices.pmethod AS payment_method,geopos_invoices.status AS status,geopos_invoices.refer AS referance,geopos_customers.name AS customer_name,geopos_customers.company AS Company_Name,geopos_invoices.invoicedate AS date FROM geopos_invoices LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id" . $where);

            echo $this->dbutil->csv_from_result($query);

        } else {

            $where = " WHERE (DATE(geopos_purchase.invoicedate) BETWEEN '$sdate' AND '$edate') $whr";
            $query = $this->db->query("SELECT concat('$prefix',geopos_purchase.tid) AS receipt_number,concat('$curr',geopos_purchase.total) AS amount,geopos_purchase.tax AS tax,geopos_supplier.name AS supplier_name,geopos_supplier.company AS Company_Name,geopos_purchase.invoicedate AS date FROM geopos_purchase LEFT JOIN geopos_supplier ON geopos_purchase.csd=geopos_supplier.id" . $where);

            echo $this->dbutil->csv_from_result($query);

        }


    }

    function people_products()
    {


        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Export Product Transactions";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/product', $data);
        $this->load->view('fixed/footer');


    }


    function cust_products_o()
    {
        $this->load->model('reports_model');
        $this->load->model('customers_model');

        $customer = $this->input->post('customer');

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->customers_model->details($customer);


        $data['list'] = $this->reports_model->product_customer_statements($customer, $sdate, $edate);


        $html = $this->load->view('customers/cust_prod_pdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'D');


    }

    function sup_products_o()
    {
        $this->load->model('reports_model');
        $this->load->model('supplier_model');

        $customer = $this->input->post('supplier');

        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $data['customer'] = $this->supplier_model->details($customer);


        $data['list'] = $this->reports_model->product_supplier_statements($customer, $sdate, $edate);

        $html = $this->load->view('supplier/supp_prod_pdf', $data, true);


        ini_set('memory_limit', '64M');


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->WriteHTML($html);


        $pdf->Output('Statement' . $customer . '.pdf', 'I');


    }
	
	function franchise_sales()
    {
		
        $head['title'] = "Franchise Sales Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
		$data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $this->load->view('export/franchisesales', $data);
        $this->load->view('fixed/footer');
		
    }
	
	
	function export_franchise_sales()
    {		
		$record = $this->export->export_franchise_sales(1);			
		$fileName = 'franchise_sales.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Bill From');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill To');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Product Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'HSN');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Product Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Qty');		
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Net Price');		
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tax');		
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');		
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Gross Price');	
		
		/* echo "<pre>";
		print_r($record);
		echo "</pre>"; exit; */
		
		$i=2;
		foreach($record as $key=>$row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row->invoicedate);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->tid);			
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row->from_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->to_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->warehouse_product_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row->hsn_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row->serial);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->qty);		
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row->price);		
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row->tax);		
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row->discount);		
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row->subtotal);
			$i++;
		}
		
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url().$fileName);   	
	}
	

	function online_bank()
    {
        $head['title'] = "Franchise Sales Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/onlinebank');
        $this->load->view('fixed/footer');
    }
	
	
	function POS_report()
    {
		$data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $head['title'] = "Franchise Sales Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/posreport',$data);
        $this->load->view('fixed/footer');
    }
	
	
	function export_pos_report()
    {				
		$record = $this->export->export_franchise_sales_new(2,2);
		$data['record'] = $record;
		$this->load->view('export/export_pos_report',$data);	
    }
	
	
	function export_pos_report28072021()
    {
		$record = $this->export->export_franchise_sales('',2);			
		$fileName = 'pos_report.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Store ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice No');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill From');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bill To');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Product Label Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Product Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Product Serial Number');		
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'HSN');		
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Qty');		
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Net Price');		
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Tax');	
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discount');	
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Gross Price');	
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mode of Payment');	
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Total Amount Paid');	
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Amount Paid in Cash');	
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Amount Paid Via UPI Mode');	
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Amount Paid Via Rupay Card Mode');	
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Amount Paid Via Debit Card ( Master / Visa / Meastro ) Mode');	
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Amount Paid Via Credit Card Mode');	
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Amount Paid Via EMI Mode');	
		
		/* echo "<pre>";
		print_r($record);
		echo "</pre>"; exit; */
		
		$i=2;
		foreach($record as $key=>$row){
			
			$cash_amount =0;
			$bank_amount =0;
			$upi_amount =0;
			$rupay_amount =0;
			$debit_card_amount =0;
			$credit_card_amount =0;
			$emi_amount =0;
			
			switch($row->pmethod_id){
				case 1 : 	$cash_amount = $row->subtotal;
				break;
				case 2 : 	$bank_amount = $row->subtotal;
				break;
				case 3 : 	$upi_amount = $row->subtotal;
				break;
				case 4 : 	$rupay_amount = $row->subtotal;
				break;
				case 5 : 	$debit_card_amount = $row->subtotal;
				break;
				case 6 :	$credit_card_amount = $row->subtotal;
				break;
				case 7:		$emi_amount = $row->subtotal;
				break;
			}
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row->store_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->invoicedate);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row->tid);			
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->from_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->to_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row->product_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row->warehouse_product_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->hsn_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row->serial);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row->qty);		
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row->price);		
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row->tax);		
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $row->discount);		
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $row->subtotal);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row->pmethod);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $row->subtotal);			
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $cash_amount);			
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $upi_amount);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $rupay_amount);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, $debit_card_amount);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i, $credit_card_amount);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, $emi_amount);					
			$i++;
		}
		
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url().$fileName);
    }
	
	
	function stock_transfer_report()
    {
		$data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $head['title'] = "Stock Transfer Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/stockreport',$data);
        $this->load->view('fixed/footer');
    }
	
	
	function export_stock_transfer_report()
    {		
		$record = $this->export->export_franchise_sales(3);			
		$fileName = 'stock_transfer_report.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Bill From');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill To');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Product Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'HSN');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Product Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Qty');		
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Net Price');		
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tax');		
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');		
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Gross Price');	
		
		/* echo "<pre>";
		print_r($record);
		echo "</pre>"; exit; */
		
		$i=2;
		foreach($record as $key=>$row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row->invoicedate);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->tid);			
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row->from_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->to_franchise);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->warehouse_product_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row->hsn_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row->serial);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->qty);		
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row->price);		
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row->tax);		
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row->discount);		
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row->subtotal);
			$i++;
		}
		
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url().$fileName);   	
	}
	
	
	function franchise_commision()
    {
        $head['title'] = "Franchise Sales Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['customers'] = $this->customers->GetFranchisedropdown1();
       
        $this->load->view('fixed/header', $head);
        $this->load->view('export/franchisecommision',$data);
        $this->load->view('fixed/footer');
    }

    function online_bank_export()
    {
        $sdate = $this->input->post('sdate');
        $edate =$this->input->post('edate');
        

       $this->db->select('a.*,b.tid,b.invoicedate,b.pmethod,b.pmethod_id,b.tid as invoice_id_dt,b.type as sale_type,c.qty,c.price,c.tds,c.fcp,c.franchise_commision,c.bank_p_f,c.bank_charges,c.bank_charge_type,c.tds_percentage,c.tax,c.discount,c.subtotal,d.hsn_code,d.warehouse_product_code,d.product_name,e.serial as serial_no,g.name as from_franchise,i.name as to_franchise,j.store_code,ts.name as customer_name');     
        $this->db->from("tbl_warehouse_serials as a");      
        $this->db->join('geopos_invoices as b', 'a.invoice_id = b.id', 'LEFT');
        $this->db->join('geopos_invoice_items as c', 'c.tid = b.id', 'LEFT');
        $this->db->join('tbl_customers as ts','b.csd2=ts.id','left');
        $this->db->join('geopos_products as d', 'd.pid = a.pid', 'LEFT');
        $this->db->join('geopos_product_serials as e', 'e.id = a.serial_id', 'LEFT');
        $this->db->join('geopos_warehouse as f', 'f.id = a.fwid', 'LEFT');
        $this->db->join('geopos_customers as g', 'g.id = f.cid', 'LEFT');
        $this->db->join('geopos_warehouse as h', 'h.id = a.twid', 'LEFT');
        $this->db->join('geopos_customers as i', 'i.id = h.cid', 'LEFT');
        $this->db->join('geopos_store as j', 'j.cid = i.id', 'LEFT');
        
        $this->db->where('b.invoicedate >=', date('Y-m-d',strtotime($sdate)));
        $this->db->where('b.invoicedate <=', date('Y-m-d',strtotime($edate)));
        $this->db->where('a.invoice_id !=',0); 
        $this->db->where('b.pmethod_id !=',1); 

        $this->db->where('b.type',2);

        $query = $this->db->get();
      
        $aa = $query->result_array();
        
         
        
        //$record = $this->export->export_franchise_sales(1);         
        $fileName = 'online_bank_export.xlsx';  
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        //$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
        //$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Store Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice No');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill From');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bill To');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Product Label Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Product Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Product Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'HSN');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Qty');      
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Net Price');        
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Tax');      
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discount');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Gross Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mode of Payment');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Banking Charges %');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Banking Charges Amount');
        
        /* echo "<pre>";
        print_r($record);
        echo "</pre>"; exit; */
        
        $i=2;
        foreach($aa as $key=>$row){
            switch($row['sale_type'])
            {
            case 1 : $invoice = 'STFO#'.$row['invoice_id_dt'];
            break;
            case 2 : $invoice = 'POS#'.$row['invoice_id_dt'];
            break;
            case 3 : $invoice = 'STF#'.$row['invoice_id_dt'];
            break;
            }
             $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row['store_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, date('d-m-Y',strtotime($row['invoicedate'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $invoice);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row['to_franchise']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row['product_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row['warehouse_product_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row['serial_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row['hsn_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row['qty']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row['price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row['tax']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $row['discount']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $row['subtotal']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row['pmethod']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $row['bank_p_f']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $row['bank_charges']);
            $i++;
        }
        
        
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url().$fileName);   
    }

    function franchise_sales_commission_export()
    {   
        $franchise = $this->input->post('customer');
        $trans_type = $this->input->post('trans_type');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
       
        
        $this->db->select('a.*,b.tid,b.invoicedate,b.pmethod,b.pmethod_id,type as sale_type,c.qty,c.price,c.tds,c.fcp,c.franchise_commision,c.tds_percentage,c.tax,c.discount,c.subtotal,d.hsn_code,d.warehouse_product_code,d.product_name,e.serial as serial_no,g.name as from_franchise,i.name as to_franchise,j.store_code,ts.name as customer_name');     
        $this->db->from("tbl_warehouse_serials as a");      
        $this->db->join('geopos_invoices as b', 'a.invoice_id = b.id', 'LEFT');
        $this->db->join('geopos_invoice_items as c', 'c.tid = b.id', 'LEFT');
        $this->db->join('tbl_customers as ts','b.csd2=ts.id','left');
        $this->db->join('geopos_products as d', 'd.pid = a.pid', 'LEFT');
        $this->db->join('geopos_product_serials as e', 'e.id = a.serial_id', 'LEFT');
        $this->db->join('geopos_warehouse as f', 'f.id = a.fwid', 'LEFT');
        $this->db->join('geopos_customers as g', 'g.id = f.cid', 'LEFT');
        $this->db->join('geopos_warehouse as h', 'h.id = a.twid', 'LEFT');
        $this->db->join('geopos_customers as i', 'i.id = h.cid', 'LEFT');
        $this->db->join('geopos_store as j', 'j.cid = i.id', 'LEFT');
        
        $this->db->where('b.invoicedate >=', date('Y-m-d',strtotime($sdate)));
        $this->db->where('b.invoicedate <=', date('Y-m-d',strtotime($edate)));
        $this->db->where('a.invoice_id !=',0); 

        
        $this->db->where('b.type',2);
        if($franchise!='All')
        {
            $this->db->where('g.id',$franchise); 
        }
        if($trans_type!='All')
        {

            $this->db->where('b.pmethod_id',$trans_type);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $aa = $query->result_array();
        
         
        
        //$record = $this->export->export_franchise_sales(1);         
        $fileName = 'franchise_sales_commission_export.xlsx';  
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        //$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
        //$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Store Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Invoice No');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill From');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bill To');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Product Label Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Product Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Product Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'HSN');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Qty');      
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Net Price');        
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Tax');      
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discount');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Gross Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mode of Payment');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Franchise Commission %');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Franchise Commission Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Franchise Commission TDS %');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Franchise Comission TDS Amount to be Deduct');
        

        
        
        
        /* echo "<pre>";
        print_r($record);
        echo "</pre>"; exit; */
        
        $i=2;
        foreach($aa as $key=>$row){
            switch($row['sale_type'])
            {
            case 1 : $invoice = 'STFO#'.$row['tid'];
            break;
            case 2 : $invoice = 'POS#'.$row['tid'];
            break;
            case 3 : $invoice = 'STF#'.$row['tid'];
            break;
            }
           
           


            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row['store_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, date('d-m-Y',strtotime($row['invoicedate'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $invoice);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row['to_franchise']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row['product_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row['warehouse_product_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row['serial_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row['hsn_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row['qty']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row['price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row['tax']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $row['discount']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $row['subtotal']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row['pmethod']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $row['fcp']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $row['franchise_commision']);
            $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $row['tds_percentage']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $row['tds']);
            $i++;
        }
        
        
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url().$fileName);   
    }
	
	
	function product_cost_report()
    {
		$data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $head['title'] = "Stock Transfer Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/product_cost_report',$data);
        $this->load->view('fixed/footer');
    }
		
	/* function export_product_cost_report()
    {
		$type = $this->input->post('type');
		if($type!=''){
			$record = $this->export->export_product_cost($type);		
			
			$fileName = 'stock_transfer_report.xlsx';  
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
			//$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Leads - ');
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', '#');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Work ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Product Details');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PO#');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'PO Price');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Serial No');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Components Qty');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Components Detail');		
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Components PO#');		
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Components Price');				
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'ZoRetail Price');				
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Packeging Cost');	
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Predicted Cost');	
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Current Warehouse');	
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Product Status');	
			
			
			
			$i=2;
			$j=1;
			foreach($record as $key=>$row){
				
				switch($row->product_status){
					case 1: $status = 'Availabe';
					break;
					case 2: $status = 'Sold';
					break;
					default : $status = 'Inactive';
				}
							
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $j);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row->work_id);			
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row->product_details);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row->po);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row->po_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row->serial);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row->component_qty);				
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->component_details);		
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $row->component_po);		
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row->component_price);		
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row->zoretailer_price);		
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $row->predicted_cost);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $row->packaging_cost);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $row->current_warehouse);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $row->product_status);
				$i++;
				$j++;
			}
			
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save($fileName);
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url().$fileName);
		}
	} */
	
	
	function export_product_cost_report()
    {
		$type = $this->input->post('type');
		if($type!=''){
			$record = $this->export->export_product_cost($type);		
			$data['record'] = $record;	
			
			$head['title'] = "Product Cost Report";
			$head['usernm'] = $this->aauth->get_user()->username;
			//$this->load->view('fixed/header', $head);
			$this->load->view('export/product_cost_report_list_old',$data);
			//$this->load->view('fixed/footer');		
		}
	}
	
	
	function export_product_cost_report190721()
    {
		$type = $this->input->post('type');
		if($type!=''){
			$data['record'] = $this->export->export_product_cost_report($type);	
			
			$head['title'] = "Product Cost Report";
			$head['usernm'] = $this->aauth->get_user()->username;
			//$this->load->view('fixed/header', $head);
			$this->load->view('export/product_cost_report_list',$data);
			//$this->load->view('fixed/footer');
		}
	}
	
	
	public function product_cost_report_update(){
		//echo "TTTTTTTTTTTTTTTTTTTTT"; exit;
		$record = $this->export->product_cost_report_update();	
	}
	
	
	public function getParentPidJobWorkProduct(){
		//echo "TTTTTTTTTTTTTTTTTTTT"; exit;
		$res =  $this->export->getParentPidJobWorkProduct(1265);
		echo "<pre>";
		print_r($res);
		echo "</pre>";
	}


    public function productReportByCondition()
    {
        $data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $head['title'] = "Stock Transfer Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/product_report_by_condition',$data);
        $this->load->view('fixed/footer');
    }

    public function product_sale_price_report()
    {
        $type = $this->input->post('type');
        $sql = "SELECT a.product_name,GROUP_CONCAT(b.zobulk_sale_price) as bulk_sale_price,GROUP_CONCAT(b.sale_price) as sale_price,c.title as category_name FROM `geopos_products` as a left join geopos_sale_price_calculator as b on a.pid=b.pid left join geopos_product_cat as c on a.pcat=c.id ";
        if($type!='')
        {
            $sql.="where a.vc=$type ";
        }
        $sql.="group by b.pid order by b.pid desc";

        $query = $this->db->query($sql);

            $data['result'] = $query->result_array();

        $head['title'] = "View Product Sale Price Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $this->load->view('export/product_sale_price_report', $data);
       
        

    }


    function jobwork_report_cost()
    {
        $data['cutomers'] = $this->customers->GetFranchisedropdown1();
        $head['title'] = "Stock Transfer Report";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('export/jobwork_cost_report',$data);
        $this->load->view('fixed/footer');
    }

    public function jobwork_product_cost_report()
    {
        $type = $this->input->post('type');
        if($type!=''){
            $record = $this->export->export_jobwork_product_cost($type);        
            $data['record'] = $record;
            
            
            $head['title'] = "Product Cost Report";
            $head['usernm'] = $this->aauth->get_user()->username;
            //$this->load->view('fixed/header', $head);
            $this->load->view('export/jobwork_product_cost_report_list_old',$data);
            //$this->load->view('fixed/footer');        
        }
    }

}