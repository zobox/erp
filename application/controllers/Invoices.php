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

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class Invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('customers_model', 'customers');
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('ewb_model', 'ewb');
        $this->load->model('locations_model','locations');
        $this->load->model('employee_model', 'employee');
        $this->load->model('settings_model', 'settings');
        $this->load->model('categories_model');
		$this->load->model('products_model','products');
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        if ($this->aauth->get_user()->roleid == 2) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }
        $this->load->library("Custom");
        $this->li_a = 'sales';

    }

    //create invoice
    public function create()
    {
        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }

        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);

        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taxdetails'] = $this->common->taxdetail();
        $data['custom_fields'] = $this->custom->add_fields(2);
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/newinvoice', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {

        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = "Edit Invoice $tid";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

         $this->load->library("Common");
          $data['custom_fields_c'] = $this->custom->add_fields(1);
        $data['custom_fields'] = $this->custom->add_fields(2);




        $this->load->view('fixed/header', $head);
        if ($data['invoice']['id']) $this->load->view('invoices/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/invoices');
        $this->load->view('fixed/footer');
    } 

    //action
    public function action()
    {
        $serial_no = $this->input->post('serial_no');
        $pid = $this->input->post('pid');
        
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $fwid = $this->input->post('s_warehouses');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = numberClean($this->input->post('disc_val'));
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms', true);
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;
        }

        $this->load->model('plugins_model', 'plugins');
        $empl_e = $this->plugins->universal_api(69);
        if ($empl_e['key1']) {
            $emp = $this->input->post('employee');
        } else {
            $emp = $this->aauth->get_user()->id;
        }

        $transok = true;
        $st_c = 0;
        $this->load->library("Common");
        $this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        
        $warehouse = $this->invocies->getWarehouseByCustomerId($customer_id); 
        $twid = $warehouse->id; 
        
        $data = array('tid' => $invocieno,
        'invoicedate' => $bill_date,
        'invoiceduedate' => $bill_due_date,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'ship_tax' => $shipping_tax,
        'ship_tax_type' => $ship_taxtype,
        'discount_rate' => $disc_val,
        'total' => $total,
        'notes' => $notes,
        'csd' => $customer_id,
        'fwid' => $fwid,
        'twid' => $twid,
        'eid' => $emp,
        'taxstatus' => $tax,
        'discstatus' => $discstatus,
        'format_discount' => $discountFormat,
        'refer' => $refer,
        'term' => $pterms,
        'multi' => $currency,
        'type' => 1,
        'loc' => $this->aauth->get_user()->loc);
        $invocieno2 = $invocieno;
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
            //products
            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
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
            $product_hsn = $this->input->post('hsn', true);
            $product_alert = $this->input->post('alert');
            $serial_no = $this->input->post('serial_no');   
            //$product_serial = $this->input->post('serial');

            
            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);
                $qty = numberClean($product_qty[$key]);
                
                
                //Marginal Variable
                $product_price_margin = "0.00";
                $gst_with_margin = "0.00";
                $product_type=0;                
                
                //$purchase_price = $this->products->getPurchasePriceByPID($product_id[$key]); 
                //Marginal GST Start    
                $this->db->select("c.*,b.type");
                $this->db->from('geopos_product_serials as a');
                $this->db->join('geopos_purchase as b', 'b.id = a.purchase_id', 'left');
                $this->db->join('geopos_purchase_items as c', 'c.tid = b.id', 'left');
                
                $this->db->where("a.serial",$serial_no[$key]);                          
                $this->db->where("b.type",2);
                $this->db->where("c.pid",$product_id[$key]);
                $pro_type = $this->db->get();
                //echo $this->db->last_query(); die;                
                
                $purchase_details = array();
                if($pro_type->num_rows()>0)
                {   
                    foreach ($pro_type->result() as $row) {
                        $purchase_details = $row;
                    }
                    
                    $purchase_price = $purchase_details->price; 
                    
                    $product_type = 2;
                    $price = rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc); 
                    $product_price_margin = $price-($purchase_price+600); 

                    $gst_with_margin += amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$product_tax[$key]))); 
                }
                //Marginal GST End 
                
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'marginal_gst_price' => $gst_with_margin,
                    'marginal_product_type' => $product_type,
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                    'serial' => $serial_no[$key]
                );
                
                $this->ewb->ChangeSerialsStatus($product_id[$key],$fwid,$twid,$qty,$invocieno,$serial_no[$key]);
                
                if($product_subtotal[$key]>0){  }else{ $transok = false;  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }

                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                if ($product_id[$key] > 0) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                    if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0 and $this->common->zero_stock()) {
                        echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                        $transok = false;
                        $st_c = 1;
                    }
                }
                
                //update stock transfer  from warehouse Product
                
                if ($product_id[$key] > 0 and $this->common->zero_stock()) {
                    $avlqty = $this->invocies->getAvailableQtyByPID($product_id[$key],$fwid);
                    if((numberClean($avlqty) - $amt) < 0 and $st_c == 0){
                        echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlqty));
                        $transok = false;
                        $st_c = 1;
                    } else { 
                        
                        $wdata = array();
                        $this->db->where('pid',$product_id[$key]);
                        $this->db->where('wid',$fwid);                      
                        
                        $query = $this->db->get('tbl_warehouse_product');
                        if ($query->num_rows() > 0) {
                            $this->db->set('qty', "qty-$amt",False);
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->where('wid', $fwid);
                            $this->db->update('tbl_warehouse_product');
                            
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->where('wid', $fwid);
                            $wdata['date_modified'] = date('Y-m-d h:i:s');
                            $wdata['logged_user_id'] = $this->session->userdata('id');
                            $this->db->update('tbl_warehouse_product',$wdata);
                        }else{
                            $wdata['pid'] = $product_id[$key];
                            $wdata['wid'] = $fwid;
                            $wdata['qty'] = (0-$qty);
                            $wdata['date_created'] = date('Y-m-d h:i:s');
                            $wdata['logged_user_id'] = $this->session->userdata('id');
                            $this->db->insert('tbl_warehouse_product',$wdata);
                        }
                    }
                }
                
                
                //update stock transfer to warehouse Product
                $wdata = array();
                $this->db->where('pid',$product_id[$key]);
                $this->db->where('wid',$twid);
                $query = $this->db->get('tbl_warehouse_product');
                if ($query->num_rows() > 0) {
                    $this->db->set('qty', "qty+$amt",False);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->where('wid', $twid);
                    $this->db->update('tbl_warehouse_product');
                    
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->where('wid', $twid);
                    $wdata['date_modified'] = date('Y-m-d h:i:s');
                    $wdata['logged_user_id'] = $this->session->userdata('id');
                    $this->db->update('tbl_warehouse_product',$wdata);
                }else{
                    $wdata['pid'] = $product_id[$key];
                    $wdata['wid'] = $twid;
                    $wdata['qty'] = (0+$amt);
                    $wdata['date_created'] = date('Y-m-d h:i:s');
                    $wdata['logged_user_id'] = $this->session->userdata('id');
                    $this->db->insert('tbl_warehouse_product',$wdata);
                }
                
                $itc += $amt;
            }
            
            /* echo "<pre>";
            print_r($productlist);
            echo "</pre>"; exit; */
            
           /*  if (count($product_serial) > 0) {
                $this->db->set('status', 1);
                $this->db->where_in('serial', $product_serial);
                $this->db->update('geopos_product_serials');
            } */
            if ($prodindex > 0) {               
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_invoices');
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }
            if ($transok) {
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Invalid Entry!"));
            $transok = false;
        }
        if ($transok) {
            if ($this->aauth->premission(4) and $project > 0) {
                $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');
                $this->db->insert('geopos_project_meta', $data);
            }
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
        
        if ($transok) {
            $this->db->from('univarsal_api');
            $this->db->where('univarsal_api.id', 56);
            $query = $this->db->get();
            $auto = $query->row_array();
            if ($auto['key1'] == 1) {
                $this->db->select('name,email');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('communication_model');
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $attachmenttrue = false;
                $attachment = '';
                $this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);
            }
            if ($auto['key2'] == 1) {
                $this->db->select('name,phone');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('plugins_model', 'plugins');

                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];
                $this->load->model('sms_model', 'sms');
                $this->sms->send_sms($mobile, $text_message, false);
            }

            //profit calculation
            $t_profit = 0;
            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
            $this->db->where('geopos_invoice_items.tid', $invocieno);
            $query = $this->db->get();
            $pids = $query->result_array();
            foreach ($pids as $profit) {
                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                $s_cost = $profit['price'] * $profit['qty'];
                $t_profit += $s_cost - $t_cost;
            }
            

            $this->custom->save_fields_data($invocieno, 2);

        }

    }


    public function ajax_list()
    {
        $list = $this->invocies->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
			switch($invoices->type){
				case 1: $prefix = 'STFO#';
				break;
				case 2: if($invoices->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
				break;
				case 3: $prefix = 'STF#';
				break;
				case 4: $prefix = 'PO#';
				break;
			}
			
            $no++;
            $row = array();
            $row[] = $no;

            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '">&nbsp; ' . $prefix.$invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	

    public function view()
    {
		
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['attach'] = $this->invocies->attach($tid);
        $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = "Invoice " . $data['invoice']['tid'];
        $this->load->view('fixed/header', $head);
        $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $data['custom_fields'] = $this->custom->view_fields_data($tid, 2);
        if ($data['invoice']['id']) {
            $data['invoice']['id'] = $tid;
            $this->load->view('invoices/view', $data);
        }
        $this->load->view('fixed/footer');
    }
   
	public function printinvoice()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;

        $invoice_record = $this->invocies->getInvoiceDetailsByID($tid); 

        $type = $invoice_record[0]['type']; 
        if($type==6 || $type==7){
            $data['invoice'] = $this->invocies->invoice_detailsB2B($tid, $this->limited);
        }else{      
            $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);              
        }
		
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if ($data['invoice']['i_class'] == 1) {
            $pref = prefix(7);
        } else {
            $pref = $this->config->item('prefix');
        }
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
        $data['general'] = array('title' => $this->lang->line('Invoice'), 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
      

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            if($type==6){
				$html = $this->load->view('print_files/invoice-a4_v1-b2b', $data, true);
			}else if($type==7){					
				$html = $this->load->view('print_files/invoice-a4_v1-str', $data, true);
			}else{
				$html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
			}
            //$html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }
        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
			if($type==6){
				$header = $this->load->view('print_files/invoice-header_v1', $data, true);
				$pdf = $this->pdf->load_split(array('margin_top' => 50));
				$pdf->SetHTMLHeader($header);
			}else if($type==7){
				$header = $this->load->view('print_files/invoice-header_v1', $data, true);
				$pdf = $this->pdf->load_split(array('margin_top' => 50));
				$pdf->SetHTMLHeader($header);
			}else{
				$pdf = $this->pdf->load_split(array('margin_top' => 5));
			}
            //$pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Invoice__' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }
   
    public function printinvoice120721()
    {

        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if ($data['invoice']['i_class'] == 1) {
            $pref = prefix(7);
        } else {
            $pref = $this->config->item('prefix');
        }
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
        $data['general'] = array('title' => $this->lang->line('Invoice'), 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }
        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Invoice__' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');

            if ($this->invocies->invoice_delete($id, $this->limited)) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editaction()
    {
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $iid = $this->input->post('iid');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $total_tax = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $currency = $this->input->post('mcurrency');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $disc_val = numberClean($this->input->post('disc_val'));
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $i = 0;
        if ($this->limited) {
            $employee = $this->invocies->invoice_details($iid, $this->limited);
            if ($this->aauth->get_user()->id != $employee['eid']) exit();
        }
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;
        }
        $this->db->trans_start();
        $transok = true;
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount_rate' => $disc_val, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => 0, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
        $this->db->set($data);
        $this->db->where('id', $iid);


        if ($this->db->update('geopos_invoices', $data)) {
            //Product Data
            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $this->db->delete('geopos_invoice_items', array('tid' => $iid));
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);
            $product_qty = $this->input->post('product_qty');
            $old_product_qty = $this->input->post('old_product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');
            $product_serial = $this->input->post('serial');

            foreach ($pid as $key => $value) {

                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);

                $data = array(
                    'tid' => $iid,
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
                    'unit' => $product_unit[$key],
                    'serial' => $product_serial[$key]
                );
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;

                $amt = numberClean(@$product_qty[$key]) - numberClean(@$old_product_qty[$key]);
                if ($product_id[$key] > 0 and $amt) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                }
                $itc += $amt;
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                if (count($product_serial) > 0) {
                    $this->db->set('status', 1);
                    $this->db->where_in('serial', $product_serial);
                    $this->db->update('geopos_product_serials');
                }
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $iid);
                $this->db->update('geopos_invoices');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice has  been updated') . " <a href='view?id=$iid' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
                $transok = false;
            }

            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {
                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = numberClean($myArray[1]);
                    if ($prid > 0) {
                        $this->db->set('qty', "qty+$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->update('geopos_products');
                    }
                }
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add at least one product in invoice"));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }

        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $iid);
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
       $this->db->trans_start();
        $this->db->set('col1', $t_profit);
        $this->db->where('type', 9);
        $this->db->where('rid', $iid);
        $this->db->update('geopos_metadata');
        $this->db->trans_complete();
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_invoices');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }


    public function addcustomer()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $taxid = $this->input->post('taxid', true);
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);

        $this->load->model('customers_model', 'customers');
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s);

    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->invocies->meta_delete($invoice, 1, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->invocies->meta_insert($id, 1, $files);
            }
        }


    }

    public function delivery()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

        ini_set('memory_limit', '64M');

        $html = $this->load->view('invoices/del_note', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }

    public function proforma()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        ini_set('memory_limit', '64M');
        $html = $this->load->view('invoices/proforma', $data, true);
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Proforma_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Proforma_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }


    public function send_invoice_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(6);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2,
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
        return array('subject' => $subject, 'message' => $message);
    }

    public function send_sms_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(30);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
        $this->load->model('plugins_model', 'plugins');
        $sms_service = $this->plugins->universal_api(1);
        if ($sms_service['active']) {
            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);
        }
        $data = array(
            'BillNumber' => $invocieno2,
            'URL' => $link,
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
        return array('message' => $message);
    }

    public function view_payslip()
    {
        $id = $this->input->get('id');
        $inv = $this->input->get('inv');
        $data['invoice'] = $this->invocies->invoice_details($inv, $this->limited);
        if (!$data['invoice']['id']) exit('Limited Permissions!');

        $this->load->model('transactions_model', 'transactions');
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;

        $data['trans'] = $this->transactions->view($id);

        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'], $data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }
        ini_set('memory_limit', '64M');

        $html = $this->load->view('transactions/view-print-customer', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Trans_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Trans_#' . $id . '.pdf', 'I');
        }
    }
	
	
	public function paytm()
    {   
        
        $req_field['paytm_field'] = array("channelId" => "ABC",
                           "checksum" => "FFFFFFFFFF2345000004",
                           "paytmMid" => "FINALE32321107827478",
                           "paytmTid" => "12345678",
                           "merchantTransactionId" => "2091293484338398383",
                           "transactionAmount" => "1.00");
        $req_field['field_name'] = array_keys($req_field['paytm_field']);
        $this->load->view('paytm',$req_field);
    }
    

    public function paytm_transaction()
    {
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        $timestamp = date('Y-m-dh:i:s');
        
        $channelId = $this->input->post('channelId'); 
        $checksum = $this->input->post('checksum');
        $paytmMid = $this->input->post('paytmMid');
        $paytmTid = $this->input->post('paytmTid');
        $merchantTransactionId = $this->input->post('merchantTransactionId');
        $transactionAmount = $this->input->post('transactionAmount');

        $data = array("requestTimeStamp" => "2019-10-0713:15:18",
                      "channelId" => $channelId,
                      "checksum" => $checksum,
                      "paytmMid" => $paytmMid,
                      "paytmTid" => $paytmTid,
                      "transactionDateTime" => "2019-10-0713:15:18",
                      "merchantTransactionId" => $merchantTransactionId,
                      "transactionAmount" => $transactionAmount   
                      );

        $headers = [
                        "Content-Type: application/json"
                    ];

		$request_json = '{
"head": {
"requestTimeStamp": "2019-10-17 13:15:18",
"channelId": "RIL",
"checksum": "FFFFFFFFFF2345000004",
"version": "3.1"
},

"body": {
"paytmMid": "jMBLis87655817377506",
"paytmTid": "12346490",
"transactionDateTime": "2019-10-17 13:15:25",
"merchantTransactionId": "2019101710290000000112346490",
"merchantReferenceNo": "234564323456",
"transactionAmount": "300"
}
}';
							
		$req = json_decode($request_json);	
		
		/* echo "<pre>";
		print_r($req);
		echo "</pre>"; exit; */
		$url = 'https://securegw-stage.paytm.in/ecr/payment/request';

		$curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
       
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($req));  
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);

        
          $result = curl_exec($curl);
          echo $result;
          die;
     
		 /*$data = array("head" => array(
			  "requestTimeStamp" => $timestamp,
			  "channelId" => $channelId,
			  "checksum" => $checksum,
			  "version" => "3.1"
			  ),
			  "body" => array(
			  "paytmMid" => $paytmMid,
			  "paytmTid" => $paytmTid,
			  "transactionDateTime" => $timestamp,
			  "merchantTransactionId" => $merchantTransactionId,
			  "merchantReferenceNo" => "234564323456",
			  "transactionAmount" => $transactionAmount,
			  "subWalletAmount" => "200",
			  "callbackUrl" => null,
			  "merchantExtendedInfo" => 
			  array(
			  "txnType" => "CARD",
			  "CHN" => "CARD 05 VISA ACQUIRER TEST",
			  "akash"=>"akash"   
			  )
		  )
		  ); */

    }

    public function zobox_sales()
    {

        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }

        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);
 
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        //$data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taxdetails'] = $this->common->taxdetail();
        $data['custom_fields'] = $this->custom->add_fields(2);
        $data['locations'] = $this->locations->locations_list();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/zoboxsales', $data);
        $this->load->view('fixed/footer');
    }
    public function manage_zoboxsales()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/managezobox');
        $this->load->view('fixed/footer');
    }

    public function getToLocation()
    {
        
        $to_location = $this->input->post('id');
        
        
        $result = $this->locations->getToLocation($to_location);
       
        
        if($result != false)
        {
            $html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
        foreach($result as $row)
        {
             $html .= "<option value='".$row->id."'>".$row->cname."</option>";
        }
        echo $html;
        }
        return 0;
    
    }

    public function zobox_sales_save()
    {
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $from_business = $this->input->post('from_location');
        $to_business = $this->input->post('to_location');
        $fwid = $this->input->post('s_warehouses');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = numberClean($this->input->post('disc_val'));
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms', true);
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;
        }

        $this->load->model('plugins_model', 'plugins');
        $empl_e = $this->plugins->universal_api(69);
        if ($empl_e['key1']) {
            $emp = $this->input->post('employee');
        } else {
            $emp = $this->aauth->get_user()->id;
        }

        $transok = true;
        $st_c = 0;
        $this->load->library("Common");
        //$this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        
        $warehouse = $this->invocies->getWarehouseByCustomerId($customer_id); 
        $twid = $warehouse->id; 
        
        $data = array('tid' => $invocieno,
        'invoicedate' => $bill_date,
        'invoiceduedate' => $bill_due_date,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'ship_tax' => $shipping_tax,
        'ship_tax_type' => $ship_taxtype,
        'discount_rate' => $disc_val,
        'total' => $total,
        'notes' => $notes,
        'csd' => $customer_id,
        'fwid' => $fwid,
        'twid' => $twid,
        'from_business' => $from_business,
        'to_business' => $to_business,
        'eid' => $emp,
        'taxstatus' => $tax,
        'discstatus' => $discstatus,
        'format_discount' => $discountFormat,
        'refer' => $refer,
        'term' => $pterms,
        'multi' => $currency,
        'type' => 5,
        'loc' => $this->aauth->get_user()->loc);
         

        $invocieno2 = $invocieno;
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
            //products
            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $product_id = $this->input->post('pid');
            $actual_price = $this->input->post('actual_price');
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
            $product_hsn = $this->input->post('hsn', true);
            $product_alert = $this->input->post('alert');
            $serial_no = $this->input->post('serial_no');   
            $product_serial = $this->input->post('serial');
            foreach ($pid as $key => $value) {
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);
                $qty = numberClean($product_qty[$key]);
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'actual_price' => rev_amountExchange_s($actual_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                    'serial' => $product_serial[$key]
                );
                
                
                if($product_subtotal[$key]>0){  }else{ $transok = false;  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }

                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                if ($product_id[$key] > 0) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('geopos_products');
                    if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0 and $this->common->zero_stock()) {
                        echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                        $transok = false;
                        $st_c = 1;
                    }
                }
                
                
                //update stock transfer  from warehouse Product
                
                if ($product_id[$key] > 0 and $this->common->zero_stock()) {
                    $avlqty = $this->invocies->getAvailableQtyByPID($product_id[$key],$fwid);
                    if((numberClean($avlqty) - $amt) < 0 and $st_c == 0){
                        echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlqty));
                        $transok = false;
                        $st_c = 1;
                    } else { 
                        
                        $wdata = array();
                        $this->db->where('pid',$product_id[$key]);
                        $this->db->where('wid',$fwid);                      
                        
                        $query = $this->db->get('tbl_warehouse_product');
                        if ($query->num_rows() > 0) {
                            $this->db->set('qty', "qty-$amt",False);
                            $this->db->set('from_business',$from_business);
                            $this->db->set('to_business',$to_business);
                            $this->db->set('status',4);
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->where('wid', $fwid);
                            $this->db->update('tbl_warehouse_product');
                            
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->where('wid', $fwid);
                            $wdata['date_modified'] = date('Y-m-d h:i:s');
                            $wdata['logged_user_id'] = $this->session->userdata('id');
                            $this->db->update('tbl_warehouse_product',$wdata);
                        }else{
                            $wdata['pid'] = $product_id[$key];
                            $wdata['wid'] = $fwid;
                            $wdata['from_business'] = $from_business;
                            $wdata['to_business'] = $to_business;
                            $wdata['status'] = 4;
                            $wdata['qty'] = (0-$qty);
                            $wdata['date_created'] = date('Y-m-d h:i:s');
                            $wdata['logged_user_id'] = $this->session->userdata('id');
                            $this->db->insert('tbl_warehouse_product',$wdata);
                        }
                    }
                }
                
                
                
                //update stock transfer to warehouse Product
                $wdata = array();
                $this->db->where('pid',$product_id[$key]);
                $this->db->where('wid',$twid);
                $query = $this->db->get('tbl_warehouse_product');
                if ($query->num_rows() > 0) {
                    $this->db->set('qty', "qty+$amt",False);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->where('wid', $twid);
                    $this->db->update('tbl_warehouse_product');
                    
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->where('wid', $twid);
                    $wdata['date_modified'] = date('Y-m-d h:i:s');
                    $wdata['logged_user_id'] = $this->session->userdata('id');
                    $this->db->update('tbl_warehouse_product',$wdata);
                }else{
                    $wdata['pid'] = $product_id[$key];
                    $wdata['wid'] = $twid;
                    $wdata['qty'] = (0+$amt);
                    $wdata['date_created'] = date('Y-m-d h:i:s');
                    $wdata['logged_user_id'] = $this->session->userdata('id');
                    $this->db->insert('tbl_warehouse_product',$wdata);
                }
                
                
                $this->ewb->ChangeSerialsStatus($product_id[$key],$fwid,$twid,$qty,$invocieno,$serial_no[$key]);
                
                $itc += $amt;
            }
            if (count($product_serial) > 0) {
                $this->db->set('status', 1);
                $this->db->where_in('serial', $product_serial);
                $this->db->update('geopos_product_serials');
            }

            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_invoices');
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }
            if ($transok) {
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Invalid Entry!"));
            $transok = false;
        }
        if ($transok) {
            if ($this->aauth->premission(4) and $project > 0) {
                $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');
                $this->db->insert('geopos_project_meta', $data);

            }

            //$this->db->trans_complete();
        } else {
              
            //$this->db->trans_rollback();
        }
        if ($transok) {
            $this->db->from('univarsal_api');
            $this->db->where('univarsal_api.id', 56);
            $query = $this->db->get();
            $auto = $query->row_array();
            if ($auto['key1'] == 1) {
                $this->db->select('name,email');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('communication_model');
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $attachmenttrue = false;
                $attachment = '';
                $this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);
            }
            if ($auto['key2'] == 1) {
                $this->db->select('name,phone');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();
                $this->load->model('plugins_model', 'plugins');

                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];
                $this->load->model('sms_model', 'sms');
                $this->sms->send_sms($mobile, $text_message, false);
            }

            //profit calculation
            $t_profit = 0;
            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
            $this->db->where('geopos_invoice_items.tid', $invocieno);
            $query = $this->db->get();
            $pids = $query->result_array();
            foreach ($pids as $profit) {
                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                $s_cost = $profit['price'] * $profit['qty'];
                $t_profit += $s_cost - $t_cost;
            }
            //$data = array('type' => 9, 'rid' => $invocieno, 'col1' => rev_amountExchange_s($t_profit, $currency, $this->aauth->get_user()->loc), 'd_date' => $bill_date);
            $data = array('type' => 21,
            'rid' => $customer_id,
            'col1' => rev_amountExchange_s($t_profit, $currency, $this->aauth->get_user()->loc),
            'col2' => date('Y-m-d H:i:s') .'  ZO #'.$invocieno2. ' Sale to Franchise by ' . $this->aauth->get_user()->username,
            'd_date' => $bill_date);

            $this->db->insert('geopos_metadata', $data);

            $ins_id = $this->db->insert_id();
            // Update Wallet of Franchise
            
            $customer_record1 = $this->customers->getFranchiseByWarehouseID($twid);
            $from_personal_company = $customer_record1->personal_company;
            if($from_personal_company==1){
                $fromTrdName = $customer_record1->name;
            }else if($from_personal_company==2){
                $fromTrdName = $customer_record1->company;
            }

            $data = array(
                'payerid' => $fwid,
                'payer' => $this->session->userdata('username'),
                'acid' => $twid,
                'account' => $fromTrdName,
                'date' => date('Y-m-d'),
                'debit' => $subtotal,
                'credit' => 0,
                'type' => 'Expanse',
                'trans_type' => 4,
                'cat' => 'Franchise Stock Sale',
                'method' => 'Transfer',
                'tid' => $ins_id,
                'ext' => 3,
                'eid' => $this->aauth->get_user()->id,
                'note' => date('Y-m-d H:i:s') .'  ZO #'.$invocieno2. ' Sale to Franchise by ' . $this->aauth->get_user()->username,
                'loc' => $this->aauth->get_user()->loc
             );

              
            //$this->db->set('lastbal', "lastbal+$subtotal", FALSE);
            //$this->db->where('id', $result_c['reflect']);
            //$this->db->update('geopos_accounts');
            $this->db->insert('geopos_transactions', $data);
            
            $this->db->set('balance', "balance-$subtotal", FALSE);
            $this->db->where('id', $customer_id);
            $this->db->update('geopos_customers');
            
            $this->custom->save_fields_data($invocieno, 2);
            //$this->db->trans_complete();


        }

    }
	
	
	public function new_invoice2()
    {

        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }

        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);

        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taxdetails'] = $this->common->taxdetail();
        $data['custom_fields'] = $this->custom->add_fields(2);
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/newinvoice_2', $data);
        $this->load->view('fixed/footer');
    }
	
	
	
	
	public function action2()
    {		
		$currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $fwid = $this->input->post('s_warehouses');
		$product_qty = $this->input->post('product_qty');
		$pid = $this->input->post('pid');
		$flag = 1;
		foreach($pid as $key3=>$pidval){		
			$aval_qty = $this->ewb->getAvailableSerialByPIDINV2($pidval,$fwid);
			$rq_qty = $product_qty[$key3];
			if($aval_qty < $rq_qty){
				$flag = 0;			
			}
		}
		
		if($flag==1){	
		
			$invocieno = $this->input->post('invocieno');
			$invoicedate = $this->input->post('invoicedate');
			$invocieduedate = $this->input->post('invocieduedate');
			$notes = $this->input->post('notes', true);
			$tax = $this->input->post('tax_handle');
			$ship_taxtype = $this->input->post('ship_taxtype');
			$disc_val = numberClean($this->input->post('disc_val'));
			$subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
			$shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
			$shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
			if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
			$refer = $this->input->post('refer', true);
			$total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
			$project = $this->input->post('prjid');
			$total_tax = 0;
			$total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
			$discountFormat = $this->input->post('discountFormat');
			$pterms = $this->input->post('pterms', true);
			$i = 0;
			if ($discountFormat == '0') {
				$discstatus = 0;
			} else {
				$discstatus = 1;
			}
			if ($customer_id == 0) {
				echo json_encode(array('status' => 'Error', 'message' =>
					$this->lang->line('Please add a new client')));
				exit;
			}

			$this->load->model('plugins_model', 'plugins');
			$empl_e = $this->plugins->universal_api(69);
			if ($empl_e['key1']) {
				$emp = $this->input->post('employee');
			} else {
				$emp = $this->aauth->get_user()->id;
			}

			$transok = true;
			$st_c = 0;
			$this->load->library("Common");
			$this->db->trans_start();
			//Invoice Data
			$bill_date = datefordatabase($invoicedate);
			$bill_due_date = datefordatabase($invocieduedate);
			
			$warehouse = $this->invocies->getWarehouseByCustomerId($customer_id); 
			$twid = $warehouse->id; 
			
			$data = array('tid' => $invocieno,
			'invoicedate' => $bill_date,
			'invoiceduedate' => $bill_due_date,
			'subtotal' => $subtotal,
			'shipping' => $shipping,
			'ship_tax' => $shipping_tax,
			'ship_tax_type' => $ship_taxtype,
			'discount_rate' => $disc_val,
			'total' => $total,
			'notes' => $notes,
			'csd' => $customer_id,
			'fwid' => $fwid,
			'twid' => $twid,
			'eid' => $emp,
			'taxstatus' => $tax,
			'discstatus' => $discstatus,
			'format_discount' => $discountFormat,
			'refer' => $refer,
			'term' => $pterms,
			'multi' => $currency,
			'type' => 1,
			'loc' => $this->aauth->get_user()->loc);
			$invocieno2 = $invocieno;
			
			$query = $this->db->query("select * from geopos_invoices where tid='".$invocieno."'");
			if($query->num_rows()==0){
						
				if ($this->db->insert('geopos_invoices', $data)) {
					$invocieno = $this->db->insert_id();
					//products
					$pid = $this->input->post('pid');
					$productlist = array();
					$prodindex = 0;
					$itc = 0;
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
					$product_hsn = $this->input->post('hsn', true);
					$product_alert = $this->input->post('alert');           
					$product_serial = $this->input->post('serial');
					foreach ($pid as $key => $value) {
						$total_discount += numberClean(@$ptotal_disc[$key]);
						$total_tax += numberClean($ptotal_tax[$key]);
						$qty = numberClean($product_qty[$key]);
						
						
						$amt = numberClean($product_qty[$key]);
						if ($product_id[$key] > 0) {
							$this->db->set('qty', "qty-$amt", FALSE);
							$this->db->where('pid', $product_id[$key]);
							$this->db->update('geopos_products');
							if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0 and $this->common->zero_stock()) {
								echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
								$transok = false;
								$st_c = 1;
							}
						}						
						
						//Marginal Variable
						$product_price_margin = "0.00";
						$gst_with_margin = "0.00";
						$product_type=0;
						
						for($i=0; $i<$qty; $i++){

							$avlqty = $this->ewb->getAvailableSerialByPIDB2B($product_id[$key],$fwid);   
							//$avlqty = $this->invocies->getAvailableQtyByPID($product_id[$key],$fwid);
							if((numberClean($avlqty) - $amt) < 0 and $st_c == 0){
								echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlqty));
								$transok = false;
								$st_c = 1;
							}else{                              
									$this->db->select('a.id');
									$this->db->select('a.serial_id');
									$this->db->select('b.purchase_id');
									$this->db->select('b.purchase_pid');
									$this->db->from('tbl_warehouse_serials as a');
									$this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
									$this->db->where('a.pid',$product_id[$key]);
									$this->db->where('a.twid',$fwid);
									//$this->db->where('a.status',1);
									
									$this->db->where('b.status!=',8);                            
									$this->db->where('b.status!=',0);
									$this->db->where('a.status!=',0);
									$this->db->where('a.status!=',2);
									$this->db->where('a.status!=',3);
									$this->db->where('a.status!=',8);
									$this->db->where('a.is_present',1);
									$this->db->order_by("a.id", "asc");
									$this->db->limit(1);            
									$query = $this->db->get()->result_array();
									//echo $this->db->last_query(); exit;
									$query = $query[0];         
									$id = $query['id']; 
									$s_id = $query['serial_id'];
									$purchase_id = $query['purchase_id'];
									$purchase_pid = $query['purchase_pid'];
								   
								if($id>0 && $s_id>0){                           
									
									$purchase_price = $this->products->getPurchasePriceByPID($purchase_id,$purchase_pid);
									
									//Marginal GST Start    
									$this->db->select("b.*,a.type");
									$this->db->from('geopos_purchase as a');
									$this->db->join('geopos_purchase_items as b', 'b.tid = a.id', 'left');
									
									$this->db->where("a.id",$purchase_id);                          
									$this->db->where("a.type",2);
									$pro_type = $this->db->get();
									//echo $this->db->last_query(); die;                                
									
									if($pro_type->num_rows()>0)
									{   
										$product_type = 2;
										$price = rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc);
																				
										$product_price_margin = $price-($purchase_price[0]['price']+600);

										$gst_with_margin += amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$product_tax[$key])));
									}
									//Marginal GST End									
									
									
									$this->db->set('fwid',$fwid);
									$this->db->set('twid',$twid);
									$this->db->set('invoice_id',$invoice_id);
									$this->db->set('status',7);
									$this->db->set('date_modified',date('Y-m-d h:i:s'));
									$this->db->where('id',$id);
									$this->db->where('serial_id',$s_id);
									$this->db->update('tbl_warehouse_serials');                                                                  
									//echo $this->db->last_query(); exit;
									$i++;
								}else{
									$transok = false;                                                   
								}                   
							}               
						}						
						
						
						$data = array(
							'tid' => $invocieno,
							'pid' => $product_id[$key],
							'product' => $product_name1[$key],
							'code' => $product_hsn[$key],
							'qty' => numberClean($product_qty[$key]),
							'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
							'tax' => numberClean($product_tax[$key]),
							'marginal_gst_price' => $gst_with_margin,
							'marginal_product_type' => $product_type,
							'discount' => numberClean($product_discount[$key]),
							'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
							'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
							'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
							'product_des' => $product_des[$key],
							'unit' => $product_unit[$key],
							'serial' => $product_serial[$key]
						);
						
						
						if($product_subtotal[$key]>0){  }else{ $transok = false;  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }

						$productlist[$prodindex] = $data;
						$i++;
						$prodindex++;						
						
						//update stock transfer  from warehouse Product

						//$this->ewb->ChangeSerialsStatus2($product_id[$key],$fwid,$twid,$qty,$invocieno);
						
						$itc += $amt;
					}
					
					if (count($product_serial) > 0) {
						$this->db->set('status', 1);
						$this->db->where_in('serial', $product_serial);
						$this->db->update('geopos_product_serials');
					}
					if ($prodindex > 0) {
						$this->db->insert_batch('geopos_invoice_items', $productlist);
						$this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
						$this->db->where('id', $invocieno);
						$this->db->update('geopos_invoices');
					} else {
						echo json_encode(array('status' => 'Error', 'message' =>
							"Please choose product from product list. Go to Item manager section if you have not added the products."));
						$transok = false;
					}
					if ($transok) {
						$validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
						$link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
						echo json_encode(array('status' => 'Success', 'message' =>
							$this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
					}
				} else {
					echo json_encode(array('status' => 'Error', 'message' =>
						"Invalid Entry!"));
					$transok = false;
				}
			}else{
				$transok = false;
			}
			if ($transok) {
				if ($this->aauth->premission(4) and $project > 0) {
					$data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');
					$this->db->insert('geopos_project_meta', $data);
				}
				$this->db->trans_complete();
			} else {
				$this->db->trans_rollback();
			}
			if ($transok) {
				$this->db->from('univarsal_api');
				$this->db->where('univarsal_api.id', 56);
				$query = $this->db->get();
				$auto = $query->row_array();
				if ($auto['key1'] == 1) {
					$this->db->select('name,email');
					$this->db->from('geopos_customers');
					$this->db->where('id', $customer_id);
					$query = $this->db->get();
					$customer = $query->row_array();
					$this->load->model('communication_model');
					$invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
					$attachmenttrue = false;
					$attachment = '';
					$this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);
				}
				if ($auto['key2'] == 1) {
					$this->db->select('name,phone');
					$this->db->from('geopos_customers');
					$this->db->where('id', $customer_id);
					$query = $this->db->get();
					$customer = $query->row_array();
					$this->load->model('plugins_model', 'plugins');

					$invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
					$mobile = $customer['phone'];
					$text_message = $invoice_sms['message'];
					$this->load->model('sms_model', 'sms');
					$this->sms->send_sms($mobile, $text_message, false);
				}

				//profit calculation
				$t_profit = 0;
				$this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
				$this->db->from('geopos_invoice_items');
				$this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
				$this->db->where('geopos_invoice_items.tid', $invocieno);
				$query = $this->db->get();
				$pids = $query->result_array();
				foreach ($pids as $profit) {
					$t_cost = $profit['fproduct_price'] * $profit['qty'];
					$s_cost = $profit['price'] * $profit['qty'];
					$t_profit += $s_cost - $t_cost;
				}
				

				$this->custom->save_fields_data($invocieno, 2);

			}
		}else{
			echo json_encode(array('status' => 'Error', 'message' =>"Insufficient Quantity !"));
						$transok = false;
		}

    }

   

   public function b2b_newinvoice()
    {
        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {

            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }


        
        $eid = $this->session->userdata('id');   
        
        $data['swarehouse'] = $this->employee->getWarehouseByEmpID($eid);
        
        $data['wid'] = $data['swarehouse']->id;

        $data['franchise_id'] = $data['
        .0']->franchise_id;      
        
        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);
 
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        //$data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taxdetails'] = $this->common->taxdetail();
        $data['custom_fields'] = $this->custom->add_fields(2);
        $data['locations'] = $this->locations->locations_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();        
        
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/b2b_newinvoice1', $data);
        $this->load->view('fixed/footer');
    }
    
    
    public function b2b_manageinvoice()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/b2b_manageinvoice');
        $this->load->view('fixed/footer');
    }   
    
    
	public function actionb2b()
    {   
            
                
        $serial_no = $this->input->post('serial_no');
        $pid = $this->input->post('pid');
        $fwid = $this->input->post('s_warehouses');
        $product_qty = $this->input->post('product_qty');
        $product_name2 = $this->input->post('product_name', true);
        
        foreach ($pid as $key4 => $value) {
            $qty = numberClean($product_qty[$key4]);
            $avlqty = $this->ewb->getAvailableSerialByPIDB2B($pid[$key4],$fwid);
            if($qty>$avlqty){
                echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name2[$key4] . "</strong> - Low quantity. Available stock is  " . $avlqty));
                $transok = false;
                exit;
            }
        }        
       
                
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');       
        $franchise_id = $this->input->post('franchise_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = numberClean($this->input->post('disc_val'));
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $discountFormat = $this->input->post('discountFormat');
        //$pterms = $this->input->post('pterms', true);
        $pterms = 2;
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        
            
        $emp = $this->aauth->get_user()->id; 

        $transok = true;
        $st_c = 0;
        $this->load->library("Common");
        $this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        
        /* $warehouse = $this->invocies->getWarehouseByCustomerId($customer_id); 
        $twid = $warehouse->id;  */
        if($franchise_id=='')
        {
          $fr_id = $this->customers->getFranchiseByWarehouseID1($fwid);
          $franchise_id = $fr_id->id;
        }
        
        $data = array('tid' => $invocieno,
        'invoicedate' => $bill_date,
        'invoiceduedate' => $bill_due_date,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'ship_tax' => $shipping_tax,
        'ship_tax_type' => $ship_taxtype,
        'discount_rate' => $disc_val,
        'total' => $total,
        'notes' => $notes,
        'csd' => $franchise_id,
        'csd2' => $customer_id,
        'fwid' => $fwid,
        'twid' => $twid,
        'eid' => $emp,
        'taxstatus' => $tax,
        'discstatus' => $discstatus,
        'format_discount' => $discountFormat,
        'refer' => $refer,
        'term' => $pterms,
        'multi' => $currency,
        'type' => 6,
        'loc' => $this->aauth->get_user()->loc);
        $invocieno2 = $invocieno;        
        
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
            //products
            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
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
            $product_hsn = $this->input->post('hsn', true);
            $product_alert = $this->input->post('alert');
            $serial_no = $this->input->post('serial_no');   
            //$product_serial = $this->input->post('serial');
            
            $this->db->select('*');
            $this->db->from('geopos_bank_charges');
            $get_charge = $this->db->get();
            $bank_charges = $get_charge->result_array();        
            
            foreach ($pid as $key => $value) {                
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);
                
                $price = rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc);
                $qty = numberClean($product_qty[$key]);
                $netSubTotal = $price*$qty;
                $eid = $this->session->userdata('id');
                 
                $franchise = $this->employee->getFranchiseByEmpID($eid); 
                 
                $fcp = $this->products->getFranchiseCommissionByProductID($franchise->module,$product_id[$key],$purpose='2',$franchise->franchise_id,$commissiontype='bulk_commision_percentage'); 
                 
                $franchise_commision =  (($netSubTotal*$fcp)/100);
                $tdsdata = $this->settings->getTds(1);
                $tds_type = $tdsdata->tds_type;
                $tds = $tdsdata->tds;
                
                $tds_percentage='';     
                if($tds_type==1){
                    $tds_val = $tds;                            
                }else if($tds_type==2){
                    $tds_val = (($franchise_commision*$tds)/100);
                    $tds_percentage=$tds;
                }
                
               
                
                $product_bank_charge = '';
                $bank_charge = '';
                if($pmethod_id!=1){
                    if($bank_charges[0]['charges_type']==1){
                        $product_bank_charge =  $bank_charges[0]['charges'];
                    }
                    else
                    {
                        $stotal = rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc);
                        $product_bank_charge =  (($stotal*$bank_charges[0]['charges'])/100);
                    }
                    $bank_charge = $bank_charges[0]['charges'];
                }
                
                //Marginal Variable
				$product_price_margin = "0.00";
				$gst_with_margin = "0.00";
				$product_type=0;
               
                
                for($i=0; $i<$qty; $i++){

                    $avlqty = $this->ewb->getAvailableSerialByPIDB2B($product_id[$key],$fwid);                    
                    if((numberClean($avlqty) - $amt) < 0 and $st_c == 0){
                        echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlqty));
                        $transok = false;
                        $st_c = 1;
                    }else{                              
                            $this->db->select('a.id');
                            $this->db->select('a.serial_id');
                            $this->db->select('b.purchase_id');
                            $this->db->select('b.purchase_pid');
                            $this->db->from('tbl_warehouse_serials as a');
                            $this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
                            $this->db->where('b.product_id',$product_id[$key]);
                            $this->db->where('a.twid',$fwid);
                            //$this->db->where('a.status',1);
                            
                            $this->db->where('b.status!=',8);                            
                            $this->db->where('b.status!=',0);
                            $this->db->where('a.status!=',0);
                            $this->db->where('a.status!=',2);
                            $this->db->where('a.status!=',3);
                            $this->db->where('a.status!=',8);
                            $this->db->where('a.is_present',1);
                            $this->db->order_by("a.id", "asc");
                            $this->db->limit(1);            
                            $query = $this->db->get()->result_array();
                            //echo $this->db->last_query(); exit;
                            $query = $query[0];         
                            $id = $query['id']; 
                            $s_id = $query['serial_id'];
                            $purchase_id = $query['purchase_id'];
                            $purchase_pid = $query['purchase_pid'];
                           // echo 'tttt3434';die;
                        if($id>0 && $s_id>0){                           
                            
                            $purchase_price = $this->products->getPurchasePriceByPID($purchase_id,$purchase_pid);

                            //Marginal GST Start    
                            $this->db->select("b.*,a.type");
                            $this->db->from('geopos_purchase as a');
                            $this->db->join('geopos_purchase_items as b', 'b.tid = a.id', 'left');
                            
                            $this->db->where("a.id",$purchase_id);                          
                            $this->db->where("a.type",2);
                            $pro_type = $this->db->get();
                            //echo $this->db->last_query(); die;                                
                            
                            if($pro_type->num_rows()>0)
                            {   
                                $product_type = 2;
                                
                                $product_price_margin = $price-($purchase_price[0]['price']+600);

                                $gst_with_margin += amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$product_tax[$key])));
                            }
                            //Marginal GST End
                            
                            
                            
                            $wdata = array();
                            $wdata['status'] = 2;
                            $wdata['invoice_id'] = $invocieno;
                            $wdata['is_present'] = 0;
                            $wdata['date_modified'] = date('Y-m-d h:i:s');
                            $wdata['logged_user_id'] = $this->session->userdata('id');                              
                            $this->db->where('id',$id);
                            //$this->db->where('serial_id',$s_id);
                            $this->db->update('tbl_warehouse_serials',$wdata);                                                                  
                            //echo $this->db->last_query(); exit;
                            $i++;
                        }else{
                            $transok = false;                                                   
                        }                   
                    }               
                }
               
                
                if($gst_with_margin>0){                 
                    $total_tax = 0;
                }else{
                    $total_tax = rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc);
                }
                
                
               
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'net_price' => $netSubTotal,
                    'fcp' => $fcp,
                    'franchise_commision' => $franchise_commision,
                    'tds_percentage' => $tds_percentage,
                    'tds' => $tds_val,
                    'bank_charge_type' => $bank_charges[0]['charges_type'], 
                    'bank_p_f'  => $bank_charge,
                    'marginal_gst_price' => $gst_with_margin,
                    'marginal_product_type' => $product_type,
                    'bank_charges' => $product_bank_charge,
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => $total_tax,
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'i_class' => 1,
                    'unit' => $product_unit[$key],
                    'serial' => $product_serial[$key]
                );
                
                
                if($product_subtotal[$key]>0){  }else{ $transok = false;  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }

                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);
                
               
                
                               
                $itc += $amt;
            }       
            
            
            if ($prodindex > 0) {               
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                //echo $this->db->last_query(); //exit;               
                
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_invoices');
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            } 
            
            
            if ($transok) {
                
                $this->db->from('univarsal_api');
                $this->db->where('univarsal_api.id', 56);
                $query = $this->db->get();
                $auto = $query->row_array();
                if ($auto['key1'] == 1) {               
                    $this->load->model('communication_model');
                    $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                    $attachmenttrue = false;
                    $attachment = '';
                    $this->communication_model->send_corn_email($cemail, $cname, $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);
                }
                if ($auto['key2'] == 1) {
                   
                    $this->load->model('plugins_model', 'plugins');

                    $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                    $mobile = $cphone;
                    $text_message = $invoice_sms['message'];
                    $this->load->model('sms_model', 'sms');
                    $this->sms->send_sms($mobile, $text_message, false);
                }

                //profit calculation
                $t_profit = 0;
                $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
                $this->db->from('geopos_invoice_items');
                $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
                $this->db->where('geopos_invoice_items.tid', $invocieno);
                $query = $this->db->get();
                $pids = $query->result_array();
                foreach ($pids as $profit) {
                    $t_cost = $profit['fproduct_price'] * $profit['qty'];
                    $s_cost = $profit['price'] * $profit['qty'];
                    $t_profit += $s_cost - $t_cost;
                }  

                //$data = array('type' => 9, 'rid' => $invocieno, 'col1' => rev_amountExchange_s($t_profit, $currency, $this->aauth->get_user()->loc), 'd_date' => $bill_date);
                    
                
                //Transaction
                
                $data = array('type' => 21,
                'rid' => $franchise_id,
                'invoice_id' => $invocieno,
                'col1' => rev_amountExchange_s($t_profit, $currency, $this->aauth->get_user()->loc),
                'col2' => date('Y-m-d H:i:s') .'  ZO #'.$invocieno2. ' Sale to Franchise by ' . $this->aauth->get_user()->username,
                'd_date' => $bill_date);

                $this->db->insert('geopos_metadata', $data);
                $ins_id = $this->db->insert_id();
                // Update Wallet of Franchise
                
                
                
                $data = array(
                    'payerid' => $fwid,
                    'payer' => $this->session->userdata('username'),
                    'acid' => $customer_id,
                    'account' => $cname,
                    'date' => date('Y-m-d'),
                    'debit' => $subtotal,
                    'credit' => 0,
                    'type' => 'Expanse',
                    'trans_type' => 7,
                    'cat' => 'Franchise Stock Sale',
                    'method' => 'Transfer',
                    'tid' => $ins_id,
                    'ext' => $customer_id,
                    'eid' => $this->aauth->get_user()->id,
                    'note' => date('Y-m-d H:i:s') .'  ZO #'.$invocieno2. ' Sale to Franchise by ' . $this->aauth->get_user()->username,
                    'loc' => $this->aauth->get_user()->loc
                 );
                 
                $this->db->set('lastbal', "lastbal+$subtotal", FALSE);
                $this->db->where('id', $result_c['reflect']);
                $this->db->update('geopos_accounts');
                $this->db->insert('geopos_transactions', $data);
                //echo $this->db->last_query(); exit;
                $this->db->set('balance', "balance-$subtotal", FALSE);
                $this->db->where('id', $franchise_id);
                $this->db->update('geopos_customers');  
                
            $this->custom->save_fields_data($invocieno, 2);
         }
                
                
            if($transok){               
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
                echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
                $this->db->trans_complete();
            }else {             
                $this->db->trans_rollback();
            }
            
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Invalid Entry!"));
            $transok = false;
        }
            
                
        
    }

    public function ajax_listb2b()
    {
        $list = $this->invocies->get_datatables($this->limited,$type=6);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            switch($invoices->type){
                case 1: $prefix = 'STFO#';
                break;
                case 2: if($invoices->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
                break;
                case 3: $prefix = 'STF#';
                break;
                case 4: $prefix = 'PO#';
                break;
                case 6: $prefix = 'POBB#';
                break;
            }
            
            $no++;
            $row = array();
            $row[] = $no;

            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '">&nbsp; ' . $prefix.$invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add_customers(){        
        $name = $this->input->post('name',true);
        $phone = $this->input->post('phone',true);      
        $email = $this->input->post('email',true);
        $address = $this->input->post('address',true);
                
        $array = array('name' => $name,'phone' => $phone,'address' => $address,'email' => $email,'type' => 2,'date_created' => date("Y-m-d H:i:s"),'logged_user_id' => $this->session->userdata('id'));
        
        $this->db->where('phone',$phone);
        $query1 = $this->db->get('tbl_customers');

        if($query1->num_rows() == 0){
            if($email!=''){
                $this->db->where('email',$email);
                $query2 = $this->db->get('tbl_customers');

                if($query2->num_rows() == 0){
                    $this->db->insert('tbl_customers',$array);

                    $insert_id = $this->db->insert_id();
                    $customer_id = $insert_id;
                    $array2 = array('note'=>'[Customer Created] -'.$insert_id.'[Logged User] -'.$this->session->userdata('id'),'created' => date("Y-m-d H:i:s"));
                    $this->db->insert('geopos_log',$array2);
                    echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED')));
                    //return true;              
                }else{
                    //return "Email already exists.";   
                    $res2 = $query2->result_array();
                    $customer_id = $res2[0]['id'];
                    echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Duplicate Email')));
                }
            }else{
                $this->db->insert('tbl_customers',$array);
                $insert_id = $this->db->insert_id();
                $customer_id = $insert_id;
                $array2 = array('note'=>'[Customer Created] -'.$insert_id.'[Logged User] -'.$this->session->userdata('id'),'created' => date("Y-m-d H:i:s"));
                $this->db->insert('geopos_log',$array2);
                echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
            }
        }else{
            //return "Mobile no already exists.";   
            /* $res1 = $query1->result_array();
            $customer_id = $res1[0]['id']; */
            
            echo json_encode(array('status' => 'Error', 'message' =>
            $this->lang->line('Duplicate Mobile Number')));
        }
    }
	
	public function stock_return()
    {
		$data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
		
		$eid = $this->session->userdata('id');   
		
		$data['swarehouse'] = $this->employee->getWarehouseByEmpID($eid);
		
		$data['wid'] = $data['swarehouse']->id;		
		$data['franchise_id'] = $data['swarehouse']->franchise_id;		
		
        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);
 
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();
        //$data['warehouse'] = $this->invocies->warehouses();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $head['title'] = "New Invoice";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taxdetails'] = $this->common->taxdetail();
        $data['custom_fields'] = $this->custom->add_fields(2);
        $data['locations'] = $this->locations->locations_list();
		if($_SESSION['s_role']=='r_2')
        {			
			$data['fwarehouse'] = $this->categories_model->getWarehouseByEmpID($eid); 
		}else{			
			$data['fwarehouse'] = json_decode(json_encode($this->invocies->warehouses())); 
		} 
		
        $data['twarehouse'] = $this->categories_model->warehouse_list(); 
		
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/stocks', $data);
        $this->load->view('fixed/footer');
    }
	
    public function manage_stockreturn()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/managestock');
        $this->load->view('fixed/footer');
    }
	
	
	public function actionstr()
    {   
        /* echo "<pre>";
        print_r($_REQUEST);
        echo "</pre>"; exit; */
		
        $serial_no = $this->input->post('serial_no');
        $pid = $this->input->post('pid');
        $fwid = $this->input->post('s_warehouses');
        $product_qty = $this->input->post('product_qty');
        $product_name2 = $this->input->post('product_name', true);
        
        foreach ($pid as $key4 => $value) {
            $qty1 = numberClean($product_qty[$key4]);
            $avlqty1 = $this->ewb->getAvailableSerialByPIDB2B($pid[$key4],$fwid);
            if($qty1>$avlqty1){
                echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name2[$key4] . "</strong> - Low quantity. Available stock is  " . $avlqty1));
                $transok = false;
                exit;
            }
        }
        
                        
        $currency = $this->input->post('mcurrency');
        //$customer_id = $this->input->post('customer_id');       
        //$franchise_id = $this->input->post('franchise_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = numberClean($this->input->post('disc_val'));
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount = rev_amountExchange_s($this->input->post('after_disc'), $currency, $this->aauth->get_user()->loc);
        $discountFormat = $this->input->post('discountFormat');
        //$pterms = $this->input->post('pterms', true);
        $pterms = 2;
        //$i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        
            
        $emp = $this->aauth->get_user()->id; 

        $transok = true;
        $st_c = 0;
        $this->load->library("Common");
        $this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
		
		$warehouse_dtl = $this->categories_model->getwarehousebyid($fwid);
        $franchise_id = $warehouse_dtl->cid;
        /* $warehouse = $this->invocies->getWarehouseByCustomerId($customer_id); 
        $twid = $warehouse->id;  */
        
        $data = array('tid' => $invocieno,
        'invoicedate' => $bill_date,
        'invoiceduedate' => $bill_due_date,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'ship_tax' => $shipping_tax,
        'ship_tax_type' => $ship_taxtype,
        'discount_rate' => $disc_val,
        'total' => $total,
        'notes' => $notes,
        'csd' => $franchise_id,
        //'csd2' => $customer_id,
        'fwid' => $fwid,
        //'twid' => $twid,
        'eid' => $emp,
        'taxstatus' => $tax,
        'discstatus' => $discstatus,
        'format_discount' => $discountFormat,
        'refer' => $refer,
        'term' => $pterms,
        'multi' => $currency,
        'type' => 7,
        'loc' => $this->aauth->get_user()->loc);
        $invocieno2 = $invocieno;       
        
       /*  $this->db->insert('geopos_invoices', $data);
		echo $this->db->last_query(); exit; */
		
		
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
            //products
            $pid = $this->input->post('pid');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
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
            $product_hsn = $this->input->post('hsn', true);
            $product_alert = $this->input->post('alert');
            $serial_no = $this->input->post('serial_no'); 			
            //$product_serial = $this->input->post('serial');
              
            $this->db->select('*');
            $this->db->from('geopos_bank_charges');
            $get_charge = $this->db->get();
            $bank_charges = $get_charge->result_array();        
            
            foreach ($pid as $key => $value) {
                
                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);
                
                $price = rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc);
                $qty = numberClean($product_qty[$key]);
                $netSubTotal = $price*$qty;
                $eid = $this->session->userdata('id');
                
                $franchise = $this->employee->getFranchiseByEmpID($eid); 
                 
                $fcp = $this->products->getFranchiseCommissionByProductID($franchise->module,$product_id[$key],$purpose='2',$franchise->franchise_id,$commissiontype='bulk_commision_percentage'); 
                 
                $franchise_commision =  (($netSubTotal*$fcp)/100);
                $tdsdata = $this->settings->getTds(1);
                $tds_type = $tdsdata->tds_type;
                $tds = $tdsdata->tds;
                
                $tds_percentage='';     
                if($tds_type==1){
                    $tds_val = $tds;                            
                }else if($tds_type==2){
                    $tds_val = (($franchise_commision*$tds)/100);
                    $tds_percentage=$tds;
                }
				
				
				$amt = numberClean($product_qty[$key]);
                
				$avlqty = $this->ewb->getAvailableSerialByPIDB2B($product_id[$key],$fwid);                   
				if((numberClean($avlqty) - $amt) < 0 and $st_c == 0){
					echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlqty));
					$transok = false;
					$st_c = 1;
				}else{ 
					//Marginal Variable
					$product_price_margin = "0.00";
					$gst_with_margin = "0.00";
					$product_type=0;
						
						
					for($j=0; $j<$qty; $j++){ 
							
							$this->db->select('a.id');
							$this->db->select('a.serial_id');
							$this->db->select('b.purchase_id');
							$this->db->select('b.purchase_pid');
							$this->db->from('tbl_warehouse_serials as a');
							$this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
							$this->db->where('b.product_id',$product_id[$key]);
							$this->db->where('a.twid',$fwid);
							if($serial_no[$key]){
							$this->db->where('b.serial',$serial_no[$key]);
							}
							$this->db->where('a.status',1);
							$this->db->where('a.is_present',1);
							$this->db->order_by("a.id", "asc");
							$this->db->limit(1);            
							$query = $this->db->get()->result_array();
							//echo $this->db->last_query(); exit;
							$query = $query[0];         
							$id = $query['id']; 
							$s_id = $query['serial_id'];
							$purchase_id = $query['purchase_id'];
							$purchase_pid = $query['purchase_pid'];
							
						if($id>0 && $s_id>0){
							
							$purchase_price = $this->products->getPurchasePriceByPID($purchase_id,$purchase_pid);
									
							//Marginal GST Start    
							$this->db->select("b.*,a.type");
							$this->db->from('geopos_purchase as a');
							$this->db->join('geopos_purchase_items as b', 'b.tid = a.id', 'left');
							
							$this->db->where("a.id",$purchase_id);                          
							$this->db->where("a.type",2);
							$pro_type = $this->db->get();
							//echo $this->db->last_query(); die;                                
							
							if($pro_type->num_rows()>0)
							{   
								$product_type = 2;
								$subtotal = rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc);
																
								$product_price_margin = $subtotal-($purchase_price[0]['price']+600);

								$gst_with_margin += amountFormat_general($product_price_margin-(($product_price_margin*100)/(100+$product_tax[$key])));
							}
							//Marginal GST End	
							
							
							$wdata = array();
							$wdata['status'] = 9;
							$wdata['invoice_id'] = $invocieno;
							//$wdata['is_present'] = 0;
							$wdata['date_modified'] = date('Y-m-d h:i:s');
							$wdata['logged_user_id'] = $this->session->userdata('id');                              
							$this->db->where('id',$id);
							//$this->db->where('serial_id',$s_id);
							$this->db->update('tbl_warehouse_serials',$wdata);                                                                  
							//echo $this->db->last_query(); exit;
							//$i++;
						}else{
							$transok = false;                                                   
						} 
					}
				}
                               
                
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'net_price' => $netSubTotal,
                    'fcp' => $fcp,
                    'franchise_commision' => $franchise_commision,
                    'tds_percentage' => $tds_percentage,
                    'tds' => $tds_val,
                    'bank_charge_type' => $bank_charges[0]['charges_type'], 
                    //'bank_p_f'  => $bank_charge,                   
                   // 'bank_charges' => $product_bank_charge,
                    'tax' => numberClean($product_tax[$key]),
					'marginal_gst_price' => $gst_with_margin,
					'marginal_product_type' => $product_type,
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'i_class' => 1,
                    'unit' => $product_unit[$key],
                    'serial' => $serial_no[$key]
                );
                
                
                
                if($product_subtotal[$key]>0){  }else{ $transok = false;  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }

                $productlist[$prodindex] = $data;
                //$i++;
                $prodindex++;
					               
                //}               
                $itc += $amt;
            }       
            
            
            if ($prodindex > 0) {               
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                //echo $this->db->last_query(); exit;               
                
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_invoices');
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }
            
                    
            if ($transok) {
				$this->custom->save_fields_data($invocieno, 2);
				
				$this->db->trans_complete();				
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>")); 
            }else {
				//$this->db->trans_rollback();
			}
            
            
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Invalid Entry!"));
            $transok = false;
        }
        
    }
	
	
	public function ajax_liststr()
    {
        $list = $this->invocies->get_datatables($this->limited,$type=7);
		/* echo "<pre>";
		print_r($list);
		echo "</pre>";  */
		
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            switch($invoices->type){
                case 1: $prefix = 'STFO#';
                break;
                case 2: if($invoices->pmethod_id==1){ $prefix = 'PCS#'; }else{ $prefix = 'POS#'; }
                break;
                case 3: $prefix = 'STF#';
                break;
                case 4: $prefix = 'PO#';
                break;
                case 6: $prefix = 'POBB#';
                break;
				 case 7: $prefix = 'SRR#';
                break;
            }
             
            $no++;
            $row = array();
            $row[] = $no;

            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '">&nbsp; ' . $prefix.$invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}