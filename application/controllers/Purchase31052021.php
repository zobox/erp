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

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
        $this->load->model('products_model', 'products');
		$this->load->model('quote_model', 'quote');
        $this->load->model('categories_model');
        $this->load->library("Aauth");
		$this->load->library('excel');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'stock';

    }

    //create invoice
    public function create()
    {
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        //$data['warehouse'] = $this->purchase->warehouses();
		$data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newinvoice', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {

        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Purchase Order $tid";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->purchase->billingterms();
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);;
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/edit', $data);
        $this->load->view('fixed/footer');

    }
	
	//pending PO	
	public function pending()
    {
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/pending');
        $this->load->view('fixed/footer');
    }

    public function receive_good()
    {
        $head['title'] = "Receive Goods";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['product_list'] = $this->purchase->recive_good_po_list();

        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/receive_good',$data);
        $this->load->view('fixed/footer');
    }
    public function receive_good_add()
    {
        $head['title'] = "Receive Goods";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['supplier_list'] = $this->purchase->getSupplier();

        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/receive_good_add',$data);
        $this->load->view('fixed/footer');
    }
	
    public function adddata()
    {
        $purchase_id = $this->input->get('id');
        $head['title'] = "Add Data";
        $data['eid'] = intval($this->input->get('eid'));
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['supplier_list'] = $this->purchase->getSupplier();
        $data['purchase_detail'] = $this->purchase->recive_good_po_list($purchase_id);
        $data['product_detail'] = $this->purchase->getItemDetail($data['purchase_detail'][0]->pid);
		$data['conditions'] = $this->purchase->getConditions();
		
		switch($data['purchase_detail'][0]->type)
		{
			case 2: $prefix = 'MRG_';
			break;
			case 3: $prefix = 'SP_';
			break;
			default : $prefix = '';
		}
		
        $data['purchase_id'] = $prefix.'#'.$data['purchase_detail'][0]->tid;
        $this->load->view('fixed/header', $head);
        //$this->load->view('purchase/add-data', $data);
        $this->load->view('purchase/add-data-iqc', $data);
        $this->load->view('fixed/footer');
    }
	
    public function park_goods()
    {
        $head['title'] = "Park Goods";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['product_list'] = $this->purchase->recive_good_po_list_park();
       
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/park_goods',$data);
        $this->load->view('fixed/footer');
    }
	
	//Add Serial Number Manually
	public function manual()
    {			
		$data['id'] = $this->input->get('id'); 
		$data['Pdata'] = $this->purchase->getPurchaseByIdNew($data['id']);
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/add-serial-manual',$data);
        $this->load->view('fixed/footer');
    }
	
	public function generatelebal(){		
		//Generate Barcode			
		if($this->input->post()) {
			$serial = $this->input->post('serials'); 
			$wup = $this->input->post('wupc');
			$id = $this->input->post('id');
			$data['serial_details'] = $this->purchase->getSerialDetailsById($id);
			
			/* echo "<pre>";
			print_r($data['serial_details']);
			echo "</pre>"; exit; */
			
			$serials = explode(',',$serial);
			$wupc = explode(',',$wup);			
            $data['name'] = $wupc; 
            $data['code'] = $serials;
            $data['ctype'] = 'EAN13';
			
			/* echo $serial;
			echo $wup;
			print_r($data); die; */
			
            $html = $this->load->view('barcode/generate_label', $data, true); 
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');
			redirect('purchase/pending');
        }		
		//End Generate Barcode
	}
	
	public function generatebarcode(){		
		//Generate Barcode			
		if($this->input->post()) {
			$serial = $this->input->post('serials'); 
			$wup = $this->input->post('wupc');
			
			$serials = explode(',',$serial);
			$wupc = explode(',',$wup);			
            $data['name'] = $wupc; 
            $data['code'] = $serials;
            $data['ctype'] = 'EAN13';
			/*echo $serial;
			echo $wup;
			print_r($data);die;*/
            $html = $this->load->view('barcode/serial_number', $data, true); 
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');
			redirect('purchase/pending');
        }		
		//End Generate Barcode
	}
	
	public function addmanual(){
		if ($this->input->post()) {
			$save = $this->purchase->addmanual();
		}else{
			redirect('purchase/pending');
		}
	}
	
	//Add Serial Number Bulk
	public function bulk()
    {
        $data['id'] = $this->input->get('id'); 
		$data['Pdata'] = $this->purchase->getPurchaseById($data['id']);
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
		
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/add-serial-bulk',$data);
        $this->load->view('fixed/footer');
    }
	
	public function serial_excel(){
		/*$data['id'] = $this->input->get('id'); 
		$data['Pdata'] = $this->purchase->getPurchaseById($data['id']);
		$this->load->view('purchase/serial_excel',$data);*/
		
		$data['id'] = $this->input->get('id'); 
		$Pdata = $this->purchase->getPurchaseById($data['id']);
		
		
		
		$fileName = str_replace("#","-",prefix(2))."-".$Pdata[0]->tid."-".date('d-m-y').'.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Purchase Order - '.prefix(2).$Pdata[0]->tid);
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Sl No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Serial');
        $rowCount = 3;
		$i = 1;
		$j = 1;
		foreach($Pdata as $row){
			$qty = $row->qty - $row->pending_qty;
			for($i = 1;$i<=$qty;$i++,$j++) 
       			{
            		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
            		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->product);
           		 	$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
					$rowCount++;
        		}
			
		}
		
		 $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		 $objWriter->save($fileName);
		 header("Content-Type: application/vnd.ms-excel");
		 redirect(base_url().$fileName);   
	
	}
	
	
	public function addbulk(){	
		
		if(isset($_FILES["file"]["name"]))
		{		
			$path = $_FILES["file"]["tmp_name"]; 
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow(); 
				$highestColumn = $worksheet->getHighestColumn();
				for($row=3; $row<=$highestRow; $row++)
				{		
					$slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$product_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$serialNumber = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					if($serialNumber != '' && $serialNumber != ' '){
						$data[] = array('serialNumber' => $serialNumber,'product_name' =>$product_name);
					}
									
					
				}

			}
			//echo "<pre>";print_r($data);die;
			$addBulk = $this->purchase->addbulk($data);
			redirect('purchase/');
			
		}else{
			redirect('purchase/pending');
		}
	}
	
	//Add Serial Number Scan
	public function scan()
    {
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['id'] = $this->input->get('id'); 
        $data['Pdata'] = $this->purchase->getPurchaseByIdNew($data['id']);
        $data['type'] = $data['Pdata']->type;
        
        
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/add-serial-scan',$data);
        $this->load->view('fixed/footer');
    }
	
	
	public function margin_scan()
    {
        $head['title'] = "Pending Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['qc_data'] = $this->quote->get_qc_Dropdown();
		$data['id'] = $this->input->get('id'); 
		$data['Pdata'] = $this->purchase->getPurchaseByIdNew($data['id']);
		$this->load->view('fixed/header', $head);
        $this->load->view('purchase/add-serial-scan-margin',$data);
        $this->load->view('fixed/footer');
    }
	
	
	public function addscan(){
		$this->purchase->addscan();
	}
	
	public function addscan_margin(){
		$this->purchase->addscan_margin();
	}
     
	public function addscanComponent(){
        $this->purchase->component_addscan();
    }
    //invoices list
    public function index()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoices');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {		
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency, 'type' => 2);


        if ($this->db->insert('geopos_purchase', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);
            $product_qty = $this->input->post('product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');


            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key]
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);

                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    }
                    $itc += $amt;
                }

            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>" . $this->lang->line('View') . " </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

	//action
    public function sparepartaction()
    {		
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency, 'type' => 3);


        if ($this->db->insert('geopos_purchase', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);
            $product_qty = $this->input->post('product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');


            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key]
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);

                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    }
                    $itc += $amt;
                }

            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>" . $this->lang->line('View') . " </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

    public function ajax_list()
    {
        $list = $this->purchase->get_datatables();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	
	public function ajax_marginal_list()
    {
        $list = $this->purchase->get_datatables_marginal();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	
	
	public function ajax_pending_list()
    {

        $list = $this->purchase->get_pending_purchase_order();		
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
			$purchaseItems = $this->purchase->purchase_products($invoices->id);				
			$i = 1;
			$item ='';
			$cat = '';
			foreach($purchaseItems as $rowItems){
				if(($rowItems['qty']-$rowItems['pending_qty'])>0){
					$item .= $i.".". $rowItems['product']."<br>";
					$this->db->select('a.title');
					$this->db->from('geopos_product_cat as a');
					$this->db->join('geopos_products as b','b.pcat = a.id','INNER');
					$this->db->where('b.pid',$rowItems['pid']);
					$query = $this->db->get()->result_array();
					$cat .= $i.".".$query[0]['title']."<br>";
					$i++;
				}
			}
			
			switch($invoices->type){
				case 2: $prefix = 'MRG_';
				$url = '<a href="' . base_url("purchase/margin_scan?id=$invoices->id") . '" class="btn btn-primary btn-xs">' . $this->lang->line('Scan') . '</a>';
				break;
				case 3: $prefix = 'SP_';
				$url = '<a href="' . base_url("purchase/scan?id=$invoices->id") . '" class="btn btn-primary btn-xs">' . $this->lang->line('Scan') . '</a>';
				break;
				default : $prefix = '';
				$url = '<a href="' . base_url("purchase/scan?id=$invoices->id") . '" class="btn btn-primary btn-xs">' . $this->lang->line('Scan') . '</a>';
			}
			
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prefix.prefix(2).$invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
			$row[] = $invoices->items - $invoices->pending_qty;
            $row[] = $item;
			$row[] = $cat;
           // $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
			/* $row[] = 
			'<a href="' . base_url("purchase/manual?id=$invoices->id") . '" class="btn btn-success btn-xs">' . $this->lang->line('Manual') . '</a> 
			&nbsp; <a href="' . base_url("purchase/bulk?id=$invoices->id") . '" class="btn btn-info btn-xs"  title="Download">' . $this->lang->line('Bulk') . '</a>
			&nbsp; &nbsp;<a href="' . base_url("purchase/scan?id=$invoices->id") . '" class="btn btn-primary btn-xs">' . $this->lang->line('Scan') . '</a>';
			*/
			$row[] = $url;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('purchase/view', $data);
        $this->load->view('fixed/footer');

    }


    public function printinvoice()
    {
 
        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['component_list'] = $this->categories_model->manage_requests_invoice($tid);
        $data['products'] = $this->categories_model->manage_requests_product_invoice($tid);

        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['invoice']['multi'] = 0;

        $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);


        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/sparepart_print', $data, true);
        } else {

            $html = $this->load->view('print_files/sparepart_print', $data, true);
        }
        //echo $html; die;

        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = "";
            $pdf = $this->pdf->load_split(array('margin_top' => 20));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        
        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }

    public function editaction()
    {
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('iid');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;

        $itc = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit();
        }

        $this->db->trans_start();
        $flag = false;
        $transok = true;


        //Product Data
        $pid = $this->input->post('pid');
        $productlist = array();

        $prodindex = 0;

        $this->db->delete('geopos_purchase_items', array('tid' => $invocieno));
        $product_id = $this->input->post('pid');
        $product_name1 = $this->input->post('product_name', true);
        $product_qty = $this->input->post('product_qty');
        $old_product_qty = $this->input->post('old_product_qty');
        if ($old_product_qty == '') $old_product_qty = 0;
        $product_price = $this->input->post('product_price');
        $product_tax = $this->input->post('product_tax');
        $product_discount = $this->input->post('product_discount');
        $product_subtotal = $this->input->post('product_subtotal');
        $ptotal_tax = $this->input->post('taxa');
        $ptotal_disc = $this->input->post('disca');
        $product_des = $this->input->post('product_description', true);
        $product_unit = $this->input->post('unit');
        $product_hsn = $this->input->post('hsn');

        foreach ($pid as $key => $value) {
            $total_discount += numberClean(@$ptotal_disc[$key]);
            $total_tax += numberClean($ptotal_tax[$key]);
            $data = array(
                'tid' => $invocieno,
                'pid' => $product_id[$key],
                'product' => $product_name1[$key],
                'code' => $product_hsn[$key],
                'qty' => numberClean($product_qty[$key]),
                'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                'tax' => numberClean($product_tax[$key]),
                'discount' => numberClean($product_discount[$key]),
                'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                'product_des' => $product_des[$key],
                'unit' => $product_unit[$key]
            );


            $productlist[$prodindex] = $data;

            $prodindex++;
            $amt = numberClean($product_qty[$key]);
            $itc += $amt;

            if ($this->input->post('update_stock') == 'yes') {
                $amt = numberClean(@$product_qty[$key]) - numberClean(@$old_product_qty[$key]);
                $this->db->set('qty', "qty+$amt", FALSE);
                $this->db->where('pid', $product_id[$key]);
                $this->db->update('geopos_products');
            }
            $flag = true;
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $total_discount = rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc);
        $total_tax = rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc);

        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => $itc, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
        $this->db->set($data);
        $this->db->where('id', $invocieno);

        if ($flag) {

            if ($this->db->update('geopos_purchase', $data)) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Purchase order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> View </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "There is a missing field!"));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add atleast one product in order!"));
            $transok = false;
        }

        if ($this->input->post('update_stock') == 'yes') {
            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {
                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = numberClean($myArray[1]);
                    if ($prid > 0) {

                        $this->db->set('qty', "qty-$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->update('geopos_products');
                    }
                }

            }
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_purchase');

        echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->purchase->meta_delete($invoice, 4, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->purchase->meta_insert($id, 4, $files);
            }
        }
    }
	
	public function getUniquePurchaseProduct(){
		$records  = $this->purchase->getUniquePurchaseProduct();
		echo json_encode($records);
	}
	
	
	public function getProductDetailsByName(){
		$product_name  = $this->input->post('product_name');
		$records = $this->purchase->getProductDetailsByName($product_name);
		if($records){
			echo $records->price; 
		}else{
			echo "N/A";
		}
	}
	
	public function marginalorder()
    {
        $this->load->library("Common");
		//echo $this->config->item('tax'); exit;
        $data['taxlist'] = $this->common->marginaltaxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Marginal Order";
        $head['usernm'] = $this->aauth->get_user()->username;
        //$data['warehouse'] = $this->purchase->warehouses();
		$data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/marginal-purchase-order', $data);
        $this->load->view('fixed/footer');
    }
	
	public function managemarginalorder()
    {
        $head['title'] = "Manage Marginal Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/manage-marginal-order');
        $this->load->view('fixed/footer');
    }
	
	public function spareparts_purchase()
    {
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Sparepart";
        $head['usernm'] = $this->aauth->get_user()->username;
        //$data['warehouse'] = $this->purchase->warehouses();
		$data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/spareparts-purchase', $data);
        $this->load->view('fixed/footer');
    }
	
	public function manage_spareparts()
    {
        $head['title'] = "Manage Spareparts";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/manage-sparepart');
        $this->load->view('fixed/footer');
    }
	
	public function manage_spareparts_ajax_list()
    {
        $list = $this->purchase->get_datatables_spareparts();
        $list = $this->purchase->get_datatables_spareparts();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	
	public function getimei(){
		$id = $this->input->post('id');
		$res =  $this->quote->getimei($id);
		//print_r($res[0]);
		echo json_encode($res[0]);
	}
	
    public function getListPo($supplier_id=''){

        if($supplier_id == ''){
            $supplier_id = $this->input->post('id',true);
        }
		$data_type = $this->input->post('data_type');
		
		if($data_type==1){
			$result = $this->purchase->getpoBySupplier($supplier_id);
		}elseif($data_type==2){
			$result = $this->purchase->getspoBySupplier($supplier_id);
		}
        

        if($result != false){
            //$html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
              switch($row->type)
              {
                case 2: $prefix = 'MRG_';
                
                break;
                case 3: $prefix = 'SP_';
                
                break;
                default : $prefix = '';
                
              }  
                $po_order = $row->supplier_name.' &rArr; '.$prefix.'#'.$row->tid;
                $html .= "<option value='".$row->id."'>".$po_order."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }
 

     public function getListPoItem($invoice_id=''){

        if($invoice_id == ''){
            $invoice_id = $this->input->post('id',true);
        }
		$data_type = $this->input->post('data_type');
		
		$result = $this->purchase->getItemByInvoice($invoice_id);
		
		if($data_type==1){
			if($result != false){
				foreach($result as $row){
					$html .= "<option value='".$row->id."'>".$row->product."</option>";
				}
				echo $html;
			}
        }else{			
			if($result != false){
				foreach($result as $row){
					$html .= "<option value='".$row->pid."'>".$row->product."</option>";
				}
				echo $html;
			}
		}
		
        
        return 0;
    }


    public function getPoItemInfo($product_id=''){
        if($product_id == ''){
            $product_id = $this->input->post('id',true);
        }

        $result = $this->purchase->getItemDetail($product_id);
		$total_receive_qty = $this->purchase->getReveiveGoods('',$product_id);
        $pending_qty = $result[0]['qty']-$total_receive_qty;
       
        if($result != false){
                $html = '<table  class="table table-striped table-bordered zero-configuration mt-3">
                                <thead>
                                <tr>
                                    <th>'.$this->lang->line('No').'</th>
                                    <th>'.$this->lang->line('ZUPC Code').'</th>
                                    <th>'.$this->lang->line('Product Name').'</th>
                                    <th>'.$this->lang->line('Variant').'</th>
                                    <th>'.$this->lang->line('Color').'</th>
                                    <th>'.$this->lang->line('Condition').'</th>
                                    <th>'.$this->lang->line('Qty').'</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>'.$result[0]['warehouse_product_code'].'</td>
                                        <td>'.$result[0]['product_name'].'</td>
                                        <td>'.$result[0]['unit_name'].'</td>
                                        <td>'.$result[0]['colour_name'].'</td>
                                        <td>'.$result[0]['condition_type'].'</td>
                                        <td>'.$pending_qty.'</td>
                                        
                                    </tr>
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>'.$this->lang->line('No').'</th>
                                    <th>'.$this->lang->line('ZUPC Code').'</th>
                                    <th>'.$this->lang->line('Product Name').'</th>
                                    <th>'.$this->lang->line('Variant').'</th>
                                    <th>'.$this->lang->line('Color').'</th>
                                    <th>'.$this->lang->line('Condition').'</th>
                                    <th>'.$this->lang->line('Qty').'</th>
                                </tr>
                                </tfoot>
                            </table>';
                //$html .=  $this->subCatDropdownHtml($row->id);
            
            echo $html;
        }
        return 0;
    }

    public function receive_good_add_item()
    {
        
        $purchase_id = $this->input->post('purchase_id');
        $supplier_id = $this->input->post('supplier_id');
        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');

        $this->purchase->receive_good_add($purchase_id,$supplier_id,$product_id,$qty);
    }

    public function add_recevive_goods_info()
    {       
       $jobwork_type = $this->input->post('jobwork_type');
       if($jobwork_type==1)
       {
         $supplier_id = $this->input->post('jobwork_supplier_id');
         $jobwork_purchase_id = $this->input->post('jobwork_purchase_id');
         $jobwork_pid = $this->input->post('jobwork_pid');   
		 $pid = $this->input->post('pid');
         $jobwork_varient_type = $this->input->post('jobwork_varient_type');
         $jobwork_color_name = $this->input->post('jobwork_color_name');
         $jobwork_zupc_code = $this->input->post('jobwork_zupc_code');
         $jobwork_product_name = $this->input->post('product_name');
         $jobwork_brand_name = $this->input->post('brand_name');

         $current_grade = array();
         $sticker_no    = array();
         $serial_no1    = array();
         $qc_engineer   = array();
         $final_grade   = array();
         $imei_2        = array();
         $items         = array();


         $current_grade = $this->input->post('current_grade');
         $sticker_no    = $this->input->post('sticker_no');
         $serial_no1    = $this->input->post('serial_no1');
         $qc_engineer   = $this->input->post('qc_engineer');
         $final_grade   = $this->input->post('final_grade');
         $imei_2        = $this->input->post('imei_2');
         $items         = $this->input->post('items');
         
         $this->purchase->goods_product_send_jobwork($supplier_id,$jobwork_purchase_id,$jobwork_pid,$jobwork_varient_type,$jobwork_color_name,$jobwork_zupc_code,$current_grade,$sticker_no,$serial_no1,$qc_engineer,$final_grade,$imei_2,$items,$jobwork_product_name,$jobwork_brand_name);
			
       }
       else
       {
         $supplier_id = $this->input->post('supplier_id');
         $purchase_id = $this->input->post('purchase_id');
         $pid = $this->input->post('pid');
         $varient_type = $this->input->post('varient_type');
         $color_name = $this->input->post('color_name');
         $zupc_code = $this->input->post('zupc_code');
         $product_name = $this->input->post('product_name');
         $brand_name = $this->input->post('brand_name');

         $current_grade = array();
         $sticker_no    = array();
         $serial_no1    = array();
         $qc_engineer   = array();
         $final_grade   = array();
         $imei_2        = array();
         $items         = array();

         $current_grade = $this->input->post('current_grade');
         $sticker_no    = $this->input->post('sticker_no');
         $serial_no1    = $this->input->post('serial_no1');
         $final_grade   = $this->input->post('final_grade');
         $imei_2        = $this->input->post('imei_2');

         $this->purchase->goods_product_send_warehouse($supplier_id,$purchase_id,$pid,$varient_type,$color_name,$zupc_code,$current_grade,$sticker_no,$serial_no1,$final_grade,$imei_2,$product_name,$brand_name);

       }
    }
	
	public function getproductinfo(){
		if($product_id == ''){
            $purchase_item_id = $this->input->post('id',true);
        }
		$data_type = $this->input->post('data_type');
		
		if($data_type==1){
			$result = $this->purchase->getvarient($purchase_item_id);
							
			if(is_array($result)){
				$html = $result[0]->warehouse_product_code.'#';
					
					$html .= "<option value=''>--Select--</option>";
				foreach($result as $row){
					$html .= "<option value='".$purchase_item_id.'-'.$row->product_id.'-'.$row->varient_id.'-'.$row->varient_pid."'>".$row->unit_name."</option>";             
				}
				echo $html;
			}else{
				return false;
			}
		}elseif($data_type==2){
			$result = $this->purchase->getsvarient($purchase_item_id);
							
			if(is_array($result)){
				$html = $result[0]->warehouse_product_code.'#';
					
					$html .= "<option value=''>--Select--</option>";
				foreach($result as $row){
					$html .= "<option value='".$row->id."'>".$row->unit_name."</option>";             
				}
				echo $html;
			}else{
				return false;
			}
		}
	}
	
	public function getvarientcolor(){
		$id = $this->input->post('id',true);
		$id_array = explode('-',$id);
		$purchase_item_id = $id_array[0];
		$product_id = $id_array[1];
		$varient_id = $id_array[2];
		
		$result = $this->purchase->getvarientcolor($purchase_item_id,$product_id,$varient_id);
						
		if(is_array($result)){				
				$html = "<option value=''>--Select--</option>";
			foreach($result as $row){
				$html .= "<option value='".$row->colour_id."'>".$row->colour_name."</option>";             
			}
			echo $html;
		}else{
			return false;
		}
	}
	
	public function add_recevive_goods_info_new()
    {   
	   $data_type = $this->input->post('data_type');
       $jobwork_required = $this->input->post('jobwork_required');
	   
	   if($data_type==1){
		   if($jobwork_required==1)
		   {
				$this->purchase->goods_product_send_jobwork_new();
		   }
		   else
		   {
				$this->purchase->goods_product_send_warehouse_new();
		   }
	   }else{
		   $this->purchase->goods_product_send_saparepat_warehouse();
	   }
	   
	   if($this->input->post()) {			   
			$data_type = $this->input->post('data_type');
			$jobwork_required = $this->input->post('jobwork_required');
			$supplier_id = $this->input->post('supplier_id');
			$purchase_id = $this->input->post('purchase_id');
			$purchase_item_id = $this->input->post('purchase_item_id');
			$zupc_code = $this->input->post('zupc_code');
			$varient_ids = $this->input->post('varient_id');
			$sticker_no = $this->input->post('sticker_no');
			$serial_no1 = $this->input->post('serial_no1');
			$current_grade = $this->input->post('current_grade');
			$qc_engineer = $this->input->post('qc_engineer');
			$color_id = $this->input->post('color_id');
			$imei_2 = $this->input->post('imei_2');
			$final_grade = $this->input->post('final_grade');
			$items = $this->input->post('items');
			
			$varient_array = explode('-',$varient_ids);
			$product_id = $varient_array[1];
			$varient_id = $varient_array[2];
			$varient_pid = $varient_array[3];	

			$product_details = $this->products->getproductById($product_id);
			$product_name = $product_details->product_name;
			
			$product_info = $this->purchase->getProductInfo($purchase_item_id,$product_id,$varient_id,$current_grade,$color_id);
			$jobwork_brand_name = $product_info[0]->brand_name;
			$varient = $product_info[0]->unit_name;
			$colour = $product_info[0]->colour_name;
			$current_condition = $product_info[0]->condition_type;
			
			$purchase_details = $this->purchase->getPurchaseById($purchase_id);
			
			switch($purchase_details[0]->type)
			{
				case 2: $prefix = 'MRG_';

				break;
				case 3: $prefix = 'SP_';

				break;
				default : $prefix = '';
			}             
			$purchase_order = $prefix.'#'.$purchase_details[0]->tid;
			
			
			$data['product_name'] = $product_name;
			$data['sticker_no'] = $sticker_no;
			$data['varient'] = $varient;
			$data['colour'] = $colour;
			$data['purchase_order'] = $purchase_order;
			$data['qc_engineer'] = $qc_engineer;
			$data['items'] = $items;
			$data['zupc_code'] = $zupc_code;
			$data['serial_no1'] = $serial_no1;
			
			if($data_type==1){
				if($jobwork_required==1)
				{
					$html = $this->load->view('barcode/generate_label_jobwork_required', $data, true); 
				}else{
					$html = $this->load->view('barcode/generate_label_jobwork_not_required', $data, true);
				}
			}else{
				$data['qty'] = $this->input->post('qty');
				$html = $this->load->view('barcode/generate_label_sparepart', $data, true);
			}
			
			
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');
			//redirect('purchase/park_goods');
        }   
	   
    }
	
	public function generatelebaljobwork(){		
		//Generate Barcode			
		if($this->input->post()) {
			$serial = $this->input->post('serials'); 
			$wup = $this->input->post('wupc');
			$id = $this->input->post('id');
			$data['serial_details'] = $this->purchase->getSerialDetailsById($id);
			
			/* echo "<pre>";
			print_r($data['serial_details']);
			echo "</pre>"; exit; */
			
			$serials = explode(',',$serial);
			$wupc = explode(',',$wup);			
            $data['name'] = $wupc; 
            $data['code'] = $serials;
            $data['ctype'] = 'EAN13';
			
			/* echo $serial;
			echo $wup;
			print_r($data); die; */
			
            $html = $this->load->view('barcode/generate_label', $data, true); 
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($data['name'] . '_barcode.pdf', 'I');
			redirect('purchase/pending');
        }		
		//End Generate Barcode
	}
    
}