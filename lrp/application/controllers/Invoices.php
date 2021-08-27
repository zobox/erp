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

class Invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $this->load->view('includes/header');
        $this->load->view('invoices/invoices');
        $this->load->view('includes/footer');
    }


    public function ajax_list()
    {
        $query = $this->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();

        $this->config->set_item('currency', $row["currency"]);


        $list = $this->invocies->get_datatables();
        $data = array();

        $no = $this->input->post('start');
        $curr = $this->config->item('currency');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total,$invoices->multi);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a>';

            $data[] = $row;
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
			$this->load->view('invoices/view', $data);
			$this->load->view('includes/footer');
		}

    }
	
	public function actionlrp()
    {   
        /* echo "<pre>";
        print_r($_REQUEST);
        echo "</pre>"; exit; */
		
        $serial_no = $this->input->post('serial_no');
        $pid = $this->input->post('pid');
        $fwid = $this->input->post('s_warehouses');
        $twid = $this->input->post('to_warehouses');
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
        'twid' => $twid,
        'eid' => $emp,
        'taxstatus' => $tax,
        'discstatus' => $discstatus,
        'format_discount' => $discountFormat,
        'refer' => $refer,
        'term' => $pterms,
        'multi' => $currency,
        'type' => 8,
        'loc' => $this->aauth->get_user()->loc);
        $invocieno2 = $invocieno;       
        
       /* $this->db->insert('geopos_invoices', $data);
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
							$where = '(a.twid="'.$fwid.'" or a.twid = "0")';
							$this->db->where($where);
							//$this->db->where('a.twid',$fwid);
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
							$wdata['status'] = 6;
							$wdata['invoice_id'] = $invocieno;
							$wdata['is_present'] = 0;
							$wdata['fwid'] = $fwid;
							$wdata['twid'] = $twid;
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
                    //'fcp' => $fcp,
                    //'franchise_commision' => $franchise_commision,
                    //'tds_percentage' => $tds_percentage,
                    //'tds' => $tds_val,
                    //'bank_charge_type' => $bank_charges[0]['charges_type'], 
                    //'bank_p_f'  => $bank_charge,                   
                   // 'bank_charges' => $product_bank_charge,
                    'tax' => numberClean($product_tax[$key]),
					'marginal_gst_price' => 0,   //$gst_with_margin,
					'marginal_product_type' => 2, //$product_type,
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


}