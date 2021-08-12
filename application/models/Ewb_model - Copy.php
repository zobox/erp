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

	public function generateEWB24022021(){
		$cst = $this->input->post('cst');
		$customer_id = $this->input->post('customer_id');
		$customer_record = $this->customers->getFranchiseByCustromerID($customer_id);		
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
		$customer_id1 = $this->input->post('customer_id1');	
		$customer_record1 = $this->customers->getFranchiseByCustromerID($customer_id1);
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
		

		$invocieno = $this->input->post('invocieno');
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
			$cgstValue += ($product_subtotal[$key]*$cgstRate)/100;
			$sgstValue += ($product_subtotal[$key]*$sgstRate)/100;
			$igstValue += ($product_subtotal[$key]*$igstRate)/100;
			$cessValue += ($product_subtotal[$key]*$param['itemList'][$key]['cessRate'])/100;		
		}
		
		$totInvValue = ($totalValue+$cgstValue+$sgstValue+$igstValue+$cessValue);
		
		$param['totalValue'] = $totalValue;
		$param['cgstValue'] = $cgstValue;
		$param['sgstValue'] = $sgstValue;
		$param['igstValue'] = $igstValue;
		$param['cessValue'] = $cessValue;
		$param['totInvValue'] = $totInvValue;
		
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
			
			
			$param['itemList'][$key]['cessRate'] 	= 1;
			$param['itemList'][$key]['cessAdvol'] 	= 0;			
			$param['itemList'][$key]['taxableAmount'] = $product_subtotal[$key];					
		}
		
		//$totInvValue = ($totalValue+$cgstValue+$sgstValue+$igstValue+$cessValue);
		
		
		
		/* echo "<pre>";
		print_r($param);
		echo "</pre>"; exit; */
		
		$param_json = json_encode($param); // exit;
		
		
		 /* $param_json1 = '{
				"supplyType": "O",
				"subSupplyType": "1",
				"docType": "INV",
				"docNo": "'.$invocieno.'",
				"docDate": "'.date('d/m/Y',strtotime($invoicedate)).'",
				"fromGstin": "'.$fromGstin.'",
				"fromTrdName": "'.$fromTrdName.'",
				"fromAddr1": "'.$fromAddr1.'",
				"fromAddr2": "GROUND FLOOR OSBORNE ROAD",
				"fromPlace": "'.$fromPlace.'",
				"fromPincode": '.$fromPincode.',
				"actFromStateCode": '.$FromStateCode.',
				"fromStateCode": '.$FromStateCode.',
				"toGstin": "'.$toGstin.'",
				"toTrdName": "'.$toTrdName.'",
				"toAddr1": "'.$toAddr1.'",
				"toAddr2": "",
				"toPlace": "'.$toPlace.'",
				"toPincode": '.$toPincode.',
				"actToStateCode": '.$toStateCode.',
				"toStateCode": '.$toStateCode.',
				"totalValue": '.$toStateCode.',
				"cgstValue": '.$cgstValue.',
				"sgstValue": '.$sgstValue.',
				"igstValue": '.$igstValue.',
				"cessValue": '.$cessValue.',
				"totInvValue": '.$totInvValue.',
				"transporterId": "'.$transporterId.'",
				"transporterName": "'.$transporterName.'",
				"transDocNo": "'.$transDocNo.'",
				"transMode": "1",
				"transDistance": "'.$transDistance.'",
				"transDocDate": "'.$transDocDate.'",
				"vehicleNo": "'.$vehicleNo.'",
				"vehicleType": "R",
				"TransactionType": "1", "itemList": [ ';
				
				
				
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
					
					
					$param['itemList'][$key]['cessRate'] 	= 1;
					$param['itemList'][$key]['cessAdvol'] 	= 0;			
					$param['itemList'][$key]['taxableAmount'] = $product_subtotal[$key];
					
					$product_subtotal[$key] = str_replace(',', '', $product_subtotal[$key]);
					if($key>0){
						$param_json1 .=',';
					}
					$param_json1 .='{
						"productName": "'.$product_name[$key].'",
						"productDesc": "'.$product_description[$key].'",
						"hsnCode": '.$hsn[$key].',
						"quantity": '.$product_qty[$key].',
						"qtyUnit": "BOX",
						"cgstRate": '.$cgstRate.',
						"sgstRate": '.$sgstRate.',
						"igstRate": '.$igstRate.',
						"cessRate": 1,
						"cessAdvol": 0,
						"taxableAmount": '.$product_subtotal[$key].'
					}';		
				}
				
				
				
				
				$param_json1 .=']

				}';  */

			//echo $param_json1; exit;

			$CURLOPT_URL = "https://gsp.adaequare.com/test/enriched/ewb/ewayapi?action=GENEWAYBILL"; 
			
			$eway_res = $this->ewb($CURLOPT_URL,$param_json);
			

			$eway_result = json_decode('"'.$eway_res.'"');
			
			print_r($eway_result);	
			
			$data = array();			
			$data['api_result'] = mysqli_real_escape_string($eway_result);
			$data['invoice_number'] = $invocieno;
			$data1['date_created'] = date('Y-m-d H:i:s');
			$data1['logged_user_id'] = $_SESSION['id'];
			$this->db->insert('tbl_ewaybill', $data);	
			
			$this->aauth->applog("[Eway Bill] $res InvoiceID " . $invocieno, $this->aauth->get_user()->username);
			
			/* echo json_encode(array('status' => 'Success', 'message' =>
						$this->lang->line('ADDED')));  */
	}
	
	
	public function generateEWB(){
		echo "<pre>";
		print_r($this->input->post());
		echo "</pre>"; exit;
		
		
		
		
		
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
		

		$invocieno = $this->input->post('invocieno');
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
			$cgstValue += ($product_subtotal[$key]*$cgstRate)/100;
			$sgstValue += ($product_subtotal[$key]*$sgstRate)/100;
			$igstValue += ($product_subtotal[$key]*$igstRate)/100;
			$cessValue += ($product_subtotal[$key]*$param['itemList'][$key]['cessRate'])/100;		
		}
		
		$totInvValue = ($totalValue+$cgstValue+$sgstValue+$igstValue+$cessValue);
		
		$param['totalValue'] = $totalValue;
		$param['cgstValue'] = $cgstValue;
		$param['sgstValue'] = $sgstValue;
		$param['igstValue'] = $igstValue;
		$param['cessValue'] = $cessValue;
		$param['totInvValue'] = $totInvValue;
		
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
			
			
			$param['itemList'][$key]['cessRate'] 	= 1;
			$param['itemList'][$key]['cessAdvol'] 	= 0;			
			$param['itemList'][$key]['taxableAmount'] = $product_subtotal[$key];					
		}	
		
		$param_json = json_encode($param); // exit;
		
			$CURLOPT_URL = "https://gsp.adaequare.com/test/enriched/ewb/ewayapi?action=GENEWAYBILL"; 
			$eway_res = $this->ewb($CURLOPT_URL,$param_json);
			
			
			
			$eway_result = json_decode($eway_res);


			
			$sdata = array();
			
			$sdata['fwid'] = $wid
			$sdata['twid'] = $wid1
			$sdata['pid']
			$sdata['qty']
			$sdata['rate']
			$sdata['product_subtotal']
			$sdata['gst']
			$sdata['date_created'] = date('Y-m-d H:i:s');
			$sdata['logged_user_id'] = $_SESSION['id'];
			
			$this->db->insert('geopos_stock_transfer', $sdata);
			
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
			echo $eway_result;
			/* echo json_encode(array('status' => 'Success', 'message' =>
						$eway_res));  */
	}
	
}