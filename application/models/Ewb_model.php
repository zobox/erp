<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ewb_model extends CI_Model
{
	private $sub_data = array();
	private $parent_data = array();
	public function __construct()
    {		
        parent::__construct();       
        	
    }
	
    public function getRecordById($id){
		$this->db->where("id",$id);				
		$query = $this->db->get("geopos_product_cat");		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				$row->parent_name = $this->GetParentCatTitleById($row->id);
				$data =$row;								
			}			
			return $data;
		}
		return false;
	}

	public function ewb($CURLOPT_URL,$params){
			$requestid = rand(10,1000000000000);
			$ch = curl_init();
			curl_setopt_array($ch, array(
			CURLOPT_URL => $CURLOPT_URL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			//CURLOPT_POSTFIELDS => http_build_query($params),
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'gspappid:EDB6440700A14BE9A017F5D2FFCDC54F',
				'gspappsecret:78DBABD6G8E50G4C4EGAE1CG5E9D07CF7322',
				'username:05AAACG2115R1ZN',
				'password:abc123@@',
				'GSTIN:05AAACG2115R1ZN',
				'requestid:'.$requestid,
				'Authorization:bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJnc3AiXSwiZXhwIjoxNjE2NTcyNDcwLCJhdXRob3JpdGllcyI6WyJST0xFX1NCX0VfQVBJX0VXQiJdLCJqdGkiOiJhODczZjA0Zi00NzAyLTQ4NjUtYjIzOC0wM2I0Njk3M2FlMmEiLCJjbGllbnRfaWQiOiJFREI2NDQwNzAwQTE0QkU5QTAxN0Y1RDJGRkNEQzU0RiJ9.iIePmYNp3QbU_L_iHcL9VIQd7ncjWcbNmqZ92QnT0-c',
				),
		));
		
		$response = curl_exec($ch);

		curl_close($ch);
		return $response;
	}	
	
	
	public function generateEWB(){
		$stock_transfer_status = 0;
		$invocieno = $this->input->post('invocieno');
		
		$this->db->where('tid',$invocieno);
		$query = $this->db->get('geopos_invoices');
		if ($query->num_rows() > 0) {
			echo json_encode(array('status' => 'Error', 'message' => $invocieno.' - Invoice Number Already Exist !')); $stock_transfer_status = 0; exit;
		}
		
		$cst = $this->input->post('cst');		
		//$customer_record = $this->customers->getFranchiseByCustromerID($customer_id);	
		$wid = $this->input->post('s_warehouses'); 
		$customer_record = $this->customers->getFranchiseByWarehouseID($wid);		
		$fromGstin = $customer_record->gst;
		$FromStateCode = $customer_record->state_code;
		$from_personal_company = $customer_record->personal_company;		
		if($from_personal_company==1){
			$fromTrdName = $customer_record->name;
		}else if($from_personal_company==2){
			$fromTrdName = $customer_record->company;
		}	
		$fromAddr1 = $customer_record->address_s;
		$fromPlace = $customer_record->city_s;
		$fromPincode = $customer_record->postbox_s;
		
		$cst1 = $this->input->post('cst1');
		/* $customer_id1 = $this->input->post('customer_id1');	
		$customer_record1 = $this->customers->getFranchiseByCustromerID($customer_id1); */
		$wid1 = $this->input->post('to_warehouses');
		$customer_record1 = $this->customers->getFranchiseByWarehouseID($wid1);		
		
		$toGstin = $customer_record1->gst;
		$toStateCode = $customer_record1->state_code;
		$to_personal_company = $customer_record1->personal_company;
		if($to_personal_company==1){
			$toTrdName = $customer_record1->name;
		}else if($to_personal_company==2){
			$toTrdName = $customer_record1->company;
		}	
		
		$toAddr1 = $customer_record1->address_s;
		$toPlace = $customer_record1->city_s;		
		$toPincode = $customer_record1->postbox_s;
		$franchise_module = $customer_record1->module;
		$franchise_balance = $customer_record1->balance;	
		
		$refer = $this->input->post('refer');
		$invoicedate = $this->input->post('invoicedate');		
		$notes = $this->input->post('notes');

		//product info 
		$product_name = $this->input->post('product_name');
		$product_qty = $this->input->post('product_qty');
		$alert = $this->input->post('alert');
		$product_price = $this->input->post('product_price');
		$product_tax = $this->input->post('product_tax');
		$product_discount = $this->input->post('product_discount');
		$taxa = $this->input->post('taxa');
		$disca = $this->input->post('disca');
		$product_subtotal = $this->input->post('product_subtotal');
		$pid = $this->input->post('pid');
		$unit = $this->input->post('unit');
		$hsn = $this->input->post('hsn');
		$serial = $this->input->post('serial');
		$product_description = $this->input->post('product_description');
		
		$counter = $this->input->post('counter');
		$currency = $this->input->post('currency');
		$taxformat = $this->input->post('taxformat');
		$tax_handle = $this->input->post('tax_handle');
		$applyDiscount = $this->input->post('applyDiscount');
		$discountFormat = $this->input->post('discountFormat');
		$shipRate = $this->input->post('shipRate');
		$ship_taxtype = $this->input->post('ship_taxtype');
		$ship_tax = $this->input->post('ship_tax');
		$transporterName = $this->input->post('transporter_name');
		$transporterId = $this->input->post('transporter_id');
		$transDistance = $this->input->post('aprox_distance');
		$mode = $this->input->post('mode');
		//$vehicle_type = $this->input->post('vehicle_type');
		$vehicle_type = $this->input->post('vehicle_type');
		$vehicleNo = $this->input->post('vehicle_no');
		$transDocNo = $this->input->post('transporter_doc_no');
		$transDocDate = $this->input->post('transport_date');
		
		
		$param = array();
		$param['supplyType'] = "O";
		$param['subSupplyType'] = "1";
		$param['docType'] = "INV";
		$param['docNo'] = $invocieno;
		$param['docDate'] = date('d/m/Y', strtotime($invoicedate));
		$param['fromGstin'] = $fromGstin;
		$param['fromTrdName'] = $fromTrdName;
		$param['fromAddr1'] = $fromAddr1;
		$param['fromAddr2'] = "";
		$param['fromPlace'] = $fromPlace;
		$param['fromPincode'] = $fromPincode;
		$param['actFromStateCode'] = $FromStateCode;
		$param['fromStateCode'] = $FromStateCode;
		$param['toGstin'] = $toGstin;
		$param['toTrdName'] = $toTrdName;
		$param['toAddr1'] = $toAddr1;
		$param['toAddr2'] = "";
		$param['toPlace'] = $toPlace;
		$param['toPincode'] = $toPincode;
		$param['actToStateCode'] = $toStateCode;
		$param['toStateCode'] = $toStateCode;
		
		$param['transporterId'] = $transporterId;
		$param['transporterName'] = $transporterName;
		$param['transDocNo'] = $transDocNo;
		//$param['transMode'] = $mode;
		$param['transMode'] = '1';
		$param['transDistance'] = $transDistance;
		$param['transDocDate'] = date('d/m/Y', strtotime($transDocDate));
		$param['vehicleNo'] = $vehicleNo;
		$param['vehicleType'] = 'R';
		$param['TransactionType'] = "1";
		
		$totalValue =0;
		$cgstValue =0;
		$sgstValue =0;
		$igstValue =0;
		$cessValue =0;
		$totInvValue =0;
		$cessRate 	= 1;
		$withoutcgstValue = 0;
		$withoutsgstValue = 0;
		$withoutigstValue = 0;
		$withoutcessValue = 0;
		
		foreach($product_name as $key=>$item){			
			
			$cgstRate = 0;
			$sgstRate = 0;
			$igstRate = 0;
			
			if($FromStateCode==$toStateCode){
				$cgstRate = $product_tax[$key]/2;
				$sgstRate = $product_tax[$key]/2;
			}else{
				$igstRate = $product_tax[$key];
			}		
			
			$product_subtotal[$key] = str_replace(',', '', $product_subtotal[$key]);

			$totalValue += $product_subtotal[$key];
			$cgstRate1 = (100+$cgstRate);
			$sgstRate1 = (100+$sgstRate);
			$igstRate1 = (100+$igstRate);
			$cessRate1 = (100+$cessRate);
			
			$withoutcgstValue += ($product_subtotal[$key]*100)/$cgstRate1;
			$cgstValue = $product_subtotal[$key]-$withoutcgstValue;
			
			
			$withoutsgstValue += ($product_subtotal[$key]*100)/$sgstRate1 ;
			$sgstValue = $product_subtotal[$key]-$withoutsgstValue;
			
			
			$withoutigstValue += ($product_subtotal[$key]*100)/$igstRate1 ;
			$igstValue = $product_subtotal[$key]-$withoutigstValue;
			
			$withoutcessValue += ($product_subtotal[$key]*100)/$cessRate1 ;
			$cessValue = $product_subtotal[$key]-$withoutcessValue;
		}
		
		//$totInvValue = ($totalValue+$cgstValue+$sgstValue+$igstValue+$cessValue);
		
		
		$subtotal = numberClean($this->input->post('subtotal'));
		
		// Check and validate franchise balance for stock transfer
		
		switch($franchise_module){
			case 1: $franchise_balance = $franchise_balance+100000;  if($franchise_balance >= $subtotal){ $stock_transfer_status = 1; }
			break;
			case 2:  $franchise_balance = $franchise_balance+75000;  if($franchise_balance >= $subtotal){ $stock_transfer_status = 1; }
			break;
			case 3:  $franchise_balance = $franchise_balance+50000;  if($franchise_balance >= $subtotal){ $stock_transfer_status = 1; }
			break;
		}
		
		
		if($subtotal==0 || $subtotal==''){  echo json_encode(array('status' => 'Error', 'message' =>'Total Invoice Value Should be Greater than 0 !')); $stock_transfer_status = 0; exit; }
		if($transDistance==0 || $transDistance==''){  echo json_encode(array('status' => 'Error', 'message' =>'Distance cant be blank !')); $stock_transfer_status = 0; exit; }
		if($vehicleNo==''){  echo json_encode(array('status' => 'Error', 'message' =>'Please Enter Viechle Number !')); $stock_transfer_status = 0; exit; }
		
		
		$param['totalValue'] = $subtotal-($cgstValue+$sgstValue+$igstValue+$cessValue);
		$param['cgstValue'] = $cgstValue;
		$param['sgstValue'] = $sgstValue;
		$param['igstValue'] = $igstValue;
		$param['cessValue'] = $cessValue;
		$param['totInvValue'] = $subtotal;
		
		if($stock_transfer_status==1){		
		
		foreach($product_name as $key=>$item){
			$param['itemList'][$key]['productName'] = $product_name[$key];
			$param['itemList'][$key]['productDesc'] = $product_description[$key];
			$param['itemList'][$key]['hsnCode'] 	= $hsn[$key];
			$param['itemList'][$key]['quantity'] 	= $product_qty[$key];
			$param['itemList'][$key]['qtyUnit'] 	= $unit[$key];
			
			$cgstRate = 0;
			$sgstRate = 0;
			$igstRate = 0;
			
			if($FromStateCode==$toStateCode){
				$cgstRate = $product_tax[$key]/2;
				$sgstRate = $product_tax[$key]/2;
			}else{
				$igstRate = $product_tax[$key];
			}
			
			$param['itemList'][$key]['cgstRate'] 	= $cgstRate;
			$param['itemList'][$key]['sgstRate'] 	= $sgstRate;
			$param['itemList'][$key]['igstRate'] 	= $igstRate;			
			
			$param['itemList'][$key]['cessRate'] 	= $cessRate;			
			$param['itemList'][$key]['cessAdvol'] 	= 0;			
			$param['itemList'][$key]['taxableAmount'] = $product_subtotal[$key];	
			
			
		}	
		
						
			$param_json = json_encode($param); 
		
			$CURLOPT_URL = "https://gsp.adaequare.com/test/enriched/ewb/ewayapi?action=GENEWAYBILL"; 
			
					
			if($FromStateCode!=$toStateCode && $subtotal >= 50000){			
				//$eway_res = $this->ewb($CURLOPT_URL,$param_json);
			}else if($FromStateCode==$toStateCode && $subtotal >= 100000){
				//$eway_res = $this->ewb($CURLOPT_URL,$param_json);
			}
			
			
			if(isset($eway_res) && $eway_res!=''){
				$eway_result = json_decode($eway_res);	
				
				$data = array();
				
				$data['invoice_number'] = $invocieno;
				$data['success'] = $eway_result->success;
				$data['message'] = $eway_result->message;
				$data['ewayBillNo'] = $eway_result->result->ewayBillNo;
				$data['ewayBillDate'] = $eway_result->result->ewayBillDate;
				$data['validUpto'] = $eway_result->result->validUpto;
				$data['alert'] = $eway_result->result->alert;		
				
				
				$data1['date_created'] = date('Y-m-d H:i:s');
				$data1['logged_user_id'] = $_SESSION['id'];
				$this->db->insert('tbl_ewaybill', $data);
				
				$this->aauth->applog("[Eway Bill] $eway_result->result->ewayBillNo InvoiceID " . $invocieno, $this->aauth->get_user()->username);
				//echo $eway_res;
			}
			//Generate Invoice
			$this->ewb->generateInvoice($customer_record1->id);
			
			/* echo json_encode(array('status' => 'Success', 'message' =>
						$eway_res));  */
		}else{
			 echo json_encode(array('status' => 'Error', 'message' =>
                    'Franchise Have Insufficiant Balance !'));
		}
	}
	
	
	//generateInvoice 
    public function generateInvoice($customer_id)
    {		
        $customer_id = $customer_id;   //Yes
        $invocieno = $this->input->post('invocieno');     //Yes
        $invoicedate = $this->input->post('invoicedate'); //Yes
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);   //Yes
        $tax = $this->input->post('tax_handle');	// Yes
        $ship_taxtype = $this->input->post('ship_taxtype');   //Yes
        $disc_val = numberClean($this->input->post('disc_val'));   //No
        $subtotal = numberClean($this->input->post('subtotal'));		//Yes        
        $refer = $this->input->post('refer', true);   //Yes
        $total = $subtotal; 
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat'); //Yes       
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new Franchise')));
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
			
		$fwid 	= $this->input->post('s_warehouses');
		$twid	= $this->input->post('to_warehouses');
		
        $data = array('tid' => $invocieno, 
		'invoicedate' => $bill_date,
		'invoiceduedate' => $bill_due_date,
		'subtotal' => $subtotal,
		'shipping' => 0,
		'ship_tax' => 0,
		'ship_tax_type' => $ship_taxtype,
		'discount_rate' => $disc_val,
		'total' => $total,
		'notes' => $notes,
		'csd' => $customer_id,
		'fwid' => $fwid,
		'twid' => $twid,
		'eid' => $_SESSION['id'],
		'taxstatus' => $tax,
		'discstatus' => $discstatus,
		'format_discount' => $discountFormat,
		'refer' => $refer,
		'term' => 2,
		'transporter_name' => $this->input->post('transporter_name'),
		'transporter_id' => $this->input->post('transporter_id'),
		'aprox_distance' => $this->input->post('aprox_distance'),
		'mode' =>  $this->input->post('mode'),
		'vehicle_type' => $this->input->post('vehicle_type'),
		'vehicle_no' => $this->input->post('vehicle_no'),
		'transporter_doc_no' => $this->input->post('transporter_doc_no'),
		'transport_date' => $this->input->post('transport_date'),
		'multi' => 0,
		'type' => 3,
		'loc' => $this->aauth->get_user()->loc);		
		
        $invocieno2 = $invocieno;
		
        if ($this->db->insert('geopos_invoices', $data)) {
            $invocieno = $this->db->insert_id();
            //products
            $pid = $this->input->post('pid'); //Yes
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);   //Yes
            $product_qty = $this->input->post('product_qty');	//Yes
            $product_price = $this->input->post('product_price'); //Yes
            $product_tax = $this->input->post('product_tax'); 	//Yes
            $product_discount = $this->input->post('product_discount');  //Yes
            $product_subtotal = $this->input->post('product_subtotal');  //Yes
            $ptotal_tax = $this->input->post('taxa');   //Yes
            $ptotal_disc = $this->input->post('disca');   //Yes
            $product_des = $this->input->post('product_description', true);  //Yes
            $product_unit = $this->input->post('unit');		//Yes
            $product_hsn = $this->input->post('hsn', true);		//Yes
            $product_alert = $this->input->post('alert');		//Yes
            $product_serial = $this->input->post('serial');		//Yes
            $serial_no = $this->input->post('serial_no');	
            $product_serial_id = $this->input->post('serial_id');		//Yes
            foreach ($pid as $key => $value) {
				//$avlserial = $this->getAvailableSerialByPID($product_id[$key],$fwid);
				$avlserial = $this->getAvailableSerial($serial_no[$key],$fwid);
				if((numberClean($avlserial) - numberClean($product_qty[$key]) < 0 and $st_c == 0)){						
					echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $avlserial));
					$transok = false;
					$st_c = 1;
				} else { 
					$total_discount += numberClean(@$ptotal_disc[$key]);
					$total_tax += numberClean($ptotal_tax[$key]);
					$data = array(
						'tid' => $invocieno,
						'pid' => $product_id[$key],
						'product' => $product_name1[$key],
						'code' => $product_hsn[$key],
						'qty' => numberClean($product_qty[$key]),
						'price' => numberClean($product_price[$key]),
						'tax' => numberClean($product_tax[$key]),
						'discount' => numberClean($product_discount[$key]),
						'subtotal' => numberClean($product_subtotal[$key]),
						'totaltax' => numberClean($ptotal_tax[$key]),
						'totaldiscount' => numberClean($ptotal_disc[$key]),
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
						'serial' => $product_serial[$key]
					);

					$productlist[$prodindex] = $data;
					$i++;
					$prodindex++;
					$amt = numberClean($product_qty[$key]); 
					if ($product_id[$key] > 0 && $fwid==1) {
						$this->db->set('qty', "qty-$amt", FALSE);
						$this->db->where('pid', $product_id[$key]);
						$this->db->update('geopos_products');
						if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0 and $this->common->zero_stock()) {
							echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
							$transok = false;
							$st_c = 1;
						}
					}
				
					$qty = $product_qty[$key];					
					$change_status = $this->ChangeSerialsStatus($product_id[$key],$fwid,$twid,$qty,$invocieno,$serial_no[$key]); 
					if($change_status==false){						
						echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
						$transok = false;
					}
					$itc += $amt;				
			
					// Stock Transfer				
					
					$fwid = $this->input->post('s_warehouses');
					$twid = $this->input->post('to_warehouses');
					$sdata = array();
					
					$sdata['fwid'] 	= $fwid;
					$sdata['twid'] 	= $twid;
					$sdata['invocieno']  = $invocieno;
					$sdata['pid']  	= $pid[$key];
					$sdata['qty']	= $product_qty[$key];	
					$sdata['rate']	= $product_price[$key];
					$sdata['product_subtotal'] = $product_subtotal[$key];
					$sdata['gst']	= $product_tax[$key];
					$sdata['date_created'] = date('Y-m-d H:i:s');
					$sdata['logged_user_id'] = $_SESSION['id'];
					
					$this->db->insert('geopos_stock_transfer', $sdata);	
				}
            }
			
           			
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->set(array('discount' => numberClean(amountFormat_general($total_discount)), 'tax' => numberClean(amountFormat_general($total_tax)), 'items' => $itc));
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
                    $this->lang->line('Invoice Success') . " <a href='invoices/view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='invoices/printinvoice?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Invalid Entry!"));
            $transok = false;
        }
        if ($transok) {
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
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency=0);
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

                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency=0);
                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];
                $this->load->model('sms_model', 'sms');
                $this->sms->send_sms($mobile, $text_message, false);
            }
			
			
			
			$mdata = array(
				'type' => 21,
				'rid' => $customer_id,
				'col1' => $subtotal,
				'invoice_id' => $invocieno,
				'invoice_url' => $link,				
				'col2' => date('Y-m-d H:i:s') . '  PO#' . $invocieno2. '  Stock Transfer by ' . $this->aauth->get_user()->username
			);

			if ($this->db->insert('geopos_metadata', $mdata)) {
				$ins_id = $this->db->insert_id();
				// Update Wallet of Franchise
				$customer_record = $this->customers->getFranchiseByWarehouseID($twid);
				$to_personal_company = $customer_record->personal_company;
				if($to_personal_company==1){
					$toTrdName = $customer_record->name;
				}else if($to_personal_company==2){
					$toTrdName = $customer_record->company;
				}			
				
				$customer_record1 = $this->customers->getFranchiseByWarehouseID($fwid);
				$from_personal_company = $customer_record1->personal_company;
				if($from_personal_company==1){
					$fromTrdName = $customer_record1->name;
				}else if($from_personal_company==2){
					$fromTrdName = $customer_record1->company;
				}	
			
			
				$data_t = array(
					'payerid' => $customer_record->id,
					'payer' => $toTrdName,
					'acid' => $customer_record1->id,
					'account' => $fromTrdName,
					'date' => date('Y-m-d'),
					'debit' => $subtotal,
					'credit' => 0,
					'type' => 'Expense',
					'trans_type' => 4,
					'cat' => 'StockTransfer',
					'method' => 'Transfer',
					'tid' => $ins_id,
					'eid' => $customer_record->id,
					'ext' => 3,
					'note' => date('Y-m-d H:i:s') . '  PO#' . $invocieno2. '  Stock Transfer by ' . $this->aauth->get_user()->username,
					'loc' => $this->aauth->get_user()->loc
				 );
				 
				$this->db->set('lastbal', "lastbal+$subtotal", FALSE);
				$this->db->where('id', $customer_record->id);
				$this->db->update('geopos_accounts');
				
				$this->db->insert('geopos_transactions', $data_t);
				//echo $this->db->last_query(); exit;
				
				$this->db->set('balance', "balance-$subtotal", FALSE);
				$this->db->where('id', $customer_id);
				$this->db->update('geopos_customers');
			
				$this->aauth->applog("[Franchise Stock Transfer] Amt-$subtotal ID " . $customer_record1->id, $this->aauth->get_user()->username);
				//return true;
			} else {
				//return false;
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
	
	public function getwarehouseDropDown($id){
		$this->db->where('id !=', $id);
		$query = $this->db->get('geopos_warehouse');		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				$data[] =$row;								
			}			
			return $data;
		}
		return false;
	} 
	
	
	public function ChangeSerialsStatus($pid,$fwid,$twid,$qty,$invoice_id,$serial_no){
		//echo "TTTT";die;
		$i = 1;
		while($i<=$qty){
				$this->db->select('a.id');
				$this->db->select('a.serial_id');
				$this->db->from('tbl_warehouse_serials as a');
				$this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
				$this->db->where('a.pid',$pid);
				$this->db->where('a.twid',$fwid);
				$this->db->where('a.status',1);
				$this->db->where('b.serial',$serial_no);
				$this->db->where('b.status !=',8);
				$this->db->where('a.is_present',1);
				$this->db->order_by("a.id", "asc");
				$this->db->limit(1);			
				//$query = $this->db->get();
				//echo $this->db->last_query(); exit;
				$query = $this->db->get()->result_array();			
				$query = $query[0];			
				$id = $query['id'];	
				$s_id = $query['serial_id'];
			if($id>0 && $s_id>0){				
				$this->db->set('fwid',$fwid);
				$this->db->set('twid',$twid);
				$this->db->set('invoice_id',$invoice_id);
				$this->db->set('status',0);
				$this->db->set('date_modified',date('Y-m-d h:i:s'));
				$this->db->where('id',$id);
				$this->db->where('serial_id',$s_id);
				$this->db->update('tbl_warehouse_serials');
				//echo $this->db->last_query(); exit;
				$i++;
			}else{
				return false;
			}			
		}
		return true;		
	}
	
	
	public function getAvailableSerialByPID($product_id,$fwid){
		$this->db->select('COUNT(b.id) as qty');
		$this->db->from('tbl_warehouse_serials as a');
        $this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
		$this->db->where('b.product_id', $product_id);
		$this->db->where('a.twid', $fwid);
		$this->db->where('b.status !=', 8);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				return $rows->qty;
			}			
		}
		return false;
	}
	
	
	public function getAvailableSerial($serial_no,$fwid){
		$this->db->select('COUNT(b.id) as qty');
		$this->db->from('tbl_warehouse_serials as a');
        $this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
		$this->db->where('b.serial', $serial_no);
		$this->db->where('b.status !=', 8);
		$this->db->where('a.twid', $fwid);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				return $rows->qty;
			}			
		}
		return false;
	}
	
	
	public function ChangeSerialsStatus2($pid,$fwid,$twid,$qty,$invoice_id){
		//echo "TTTT";die;
		$i = 1;
		while($i<=$qty){
				$this->db->select('a.id');
				$this->db->select('a.serial_id');
				$this->db->from('tbl_warehouse_serials as a');
				$this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
				$this->db->where('a.pid',$pid);
				$this->db->where('a.twid',$fwid);
				$this->db->where('a.status',1);
				$this->db->where('b.status !=',8);
				$this->db->where('a.is_present',1);
				$this->db->order_by("a.id", "asc");
				$this->db->limit(1);			
				//$query = $this->db->get();
				//echo $this->db->last_query(); exit;
				$query = $this->db->get()->result_array();			
				$query = $query[0];			
				$id = $query['id'];	
				$s_id = $query['serial_id'];
			if($id>0 && $s_id>0){				
				$this->db->set('fwid',$fwid);
				$this->db->set('twid',$twid);
				$this->db->set('invoice_id',$invoice_id);
				$this->db->set('status',0);
				$this->db->set('date_modified',date('Y-m-d h:i:s'));
				$this->db->where('id',$id);
				$this->db->where('serial_id',$s_id);
				$this->db->update('tbl_warehouse_serials');
				//echo $this->db->last_query(); exit;
				$i++;
			}else{
				return false;
			}			
		}
		return true;		
	}
	
	
	public function getAvailableSerialByPIDINV2($pid,$twid){
		$this->db->select('COUNT(b.id) as qty');
		$this->db->from('tbl_warehouse_serials as a');
		$this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
		$this->db->where('a.pid',$pid);
		$this->db->where('a.twid',$twid);
		$this->db->where('a.status',1);
		$this->db->where('b.status !=',8);
		$this->db->where('a.is_present',1);
		$this->db->order_by("a.id", "asc");
		$this->db->limit(1);			
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				return $rows->qty;
			}			
		}
		return false;
	}
	
	public function getAvailableSerialByPIDB2B($product_id,$fwid){
		$this->db->select('COUNT(b.id) as qty');
		$this->db->from('tbl_warehouse_serials as a');
        $this->db->join('geopos_product_serials as b', 'a.serial_id = b.id', 'left');
		$this->db->where('b.product_id', $product_id);
		$this->db->where('a.twid', $fwid);
		$this->db->where('a.status',1);
		$this->db->where('b.status !=',8);
		$this->db->where('a.is_present',1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			foreach($query->result() as $rows){
				return $rows->qty;
			}			
		}
		return false;
	}
	
}