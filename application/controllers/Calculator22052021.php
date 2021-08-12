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

class Calculator extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(10)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

		$this->load->model('products_model', 'products');
        $this->load->model('categories_model');
        $this->load->model('chart_model', 'chart');
		$this->load->model('settings_model', 'settings');
        $this->li_a = 'data';


    }

    public function index()
    {
		$head['title'] = "Price Calculator";
		$this->load->view('fixed/header', $head);
        $this->load->view('calculator/index');
        $this->load->view('fixed/footer');
	}
	
	public function purchase_old()
    {
		$this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
		$head['title'] = "Price Calculator";
		$this->load->view('fixed/header', $head);
        $this->load->view('calculator/purchase_old',$data);
        $this->load->view('fixed/footer');
	}
	
	public function purchase()
    {
		$this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
		$head['title'] = "Price Calculator";
		$this->load->view('fixed/header', $head);
        $this->load->view('calculator/purchase',$data);
        $this->load->view('fixed/footer');
	}

	public function see_html(){
		$head['title'] = "Stock Transfer HTML VIEW";
		$this->load->view('fixed/header');
        $this->load->view('calculator/stock_transfer',$data);
        $this->load->view('fixed/footer');
	}

		
	public function calculate(){
		$product_name = $this->input->post('product_name',true);
		$average_online_price = $this->input->post('average_online_price',true);
		$discount_avaerage_online_price = $this->input->post('discount_avaerage_online_price',true);
		$avg_discount_type = $this->input->post('avg_discount_type',true);	
		$discountFormat = $this->input->post('discountFormat',true);
		$supplier_offer_price = $this->input->post('supplier_offer_price',true);
		$supplier_offer_discount = $this->input->post('supplier_offer_discount',true);
		$supplier_price_gst = $this->input->post('supplier_price_gst',true);		
		$hindizo_margin_type_new = $this->input->post('hindizo_margin',true);		
		$hindizo_margin_new = $this->input->post('hindizo_margin_value',true);		
		$obc_discount = $this->input->post('obc_discount',true);
		$obc_discount_value = $this->input->post('obc_discount_value',true);
		
		
		$buyingprice = $supplier_offer_price; 		
		$discount = $supplier_offer_discount;
		$discountapply = $this->input->post('discount_applied_state',true);		
		$gst_per = ($supplier_price_gst+100);
		
		// echo "ttt";die;
		if($discountFormat == 'b_p'){	// b_p => % Discount Before TAX	
				$gross_price = $buyingprice - ($buyingprice * $discount / 100);
				$beforediscount = $buyingprice - ($buyingprice * $discount /100);				
				$without_gst = ($beforediscount * 100 / $gst_per);
				$gst_val =  $beforediscount-$without_gst;				
				$without_gst_price =  $without_gst;
		}else if($discountFormat == '%'){  // % => % Discount After TAX	
				$gross_price = $buyingprice - ($buyingprice * $discount / 100);
				$without_gst = ($buyingprice * 100 / $gst_per);
				$gst_val =  $buyingprice - $without_gst;				
				$afterdiscount = $without_gst - ($without_gst * $discount / 100);
				$without_gst_price =  $afterdiscount;
			
		}else if($discountFormat == 'bflat'){  //bflat => Flat Discount Before TAX
				$gross_price = $buyingprice - $discount;				
				$beforediscount = $buyingprice -  $discount;	
				$without_gst = ($beforediscount * 100 / $gst_per);
				$gst_val =  $beforediscount-$without_gst;				
				$without_gst_price =  $without_gst;
		}else if($discountFormat == 'flat'){	//flat => Flat Discount After TAX	
				$gross_price = $buyingprice - $discount;
				$without_gst = ($buyingprice * 100 / $gst_per);
				$gst_val =  $buyingprice - $without_gst;				
				$afterdiscount = $without_gst - $discount;
				$without_gst_price = $afterdiscount;		
		}
		
		
		//$gross_price = $without_gst_price+$gst_val;
		//$product_name = 'mi10-Specification-64 GB RAM-Super';	
		
		$cost = $this->products->getcostStructureByProductName($product_name);			
		//echo json_encode($cost); exit;			
		
		$refurbishment_cost = $cost['refurbishment_cost'];
		$refurbishment_cost_type = $cost['refurbishment_cost_type'];
		$packaging_cost = $cost['packaging_cost'];
		$packaging_cost_type = $cost['packaging_cost_type'];
		$sales_support = $cost['sales_support'];
		$sales_support_type = $cost['sales_support_type'];
		$promotion_cost = $cost['promotion_cost'];
		$promotion_cost_type = $cost['promotion_cost_type'];
		$hindizo_infra = $cost['hindizo_infra'];
		$hindizo_infra_type = $cost['hindizo_infra_type'];
		$hindizo_margin = $cost['hindizo_margin'];
		$hindizo_margin_type = $cost['hindizo_margin_type'];
		
		$retail_commision_percentage = $cost['retail_commision_percentage'];
		$b2c_comission_percentage = $cost['b2c_comission_percentage'];
		$bulk_commision_percentage = $cost['bulk_commision_percentage'];
		$renting_commision_percentage = $cost['renting_commision_percentage'];		
		
		$refurbishment_cost_actual =NULL;
		$packaging_cost_actual =NULL;
		$sales_support_actual =NULL;
		$promotion_cost_actual =NULL;
		$hindizo_infra_actual =NULL;
		$hindizo_margin_actual =NULL;
		
		if($avg_discount_type=='flat'){
			$hindizo_sale_price = $average_online_price-$discount_avaerage_online_price;
		}else if($avg_discount_type=='per'){
			$hindizo_sale_price = $average_online_price-(($average_online_price*$discount_avaerage_online_price)/100);
		}
		$sale_without_gst_price = ($hindizo_sale_price * 100 / $gst_per);
		$sale_projected_gst = $hindizo_sale_price-$sale_without_gst_price;
		$sale_grand_total = $sale_without_gst_price+$sale_projected_gst;
		$product_loded_cost = $hindizo_sale_price;
		
		
		if($refurbishment_cost_type==2){
			$refurbishment_cost_actual = (($sale_without_gst_price*$refurbishment_cost)/100);
			$product_loded_cost =  $product_loded_cost - $refurbishment_cost_actual;
			//$refurbishment_cost = $refurbishment_cost_actual;
		}else if($refurbishment_cost_type==1){
			$product_loded_cost =  $product_loded_cost - $refurbishment_cost;
		}
		
		if($packaging_cost_type==2){
			$packaging_cost_actual = (($sale_without_gst_price*$packaging_cost)/100);
			$product_loded_cost =  $product_loded_cost - $packaging_cost_actual;
			//$packaging_cost = $packaging_cost_actual;
		}else if($packaging_cost_type==1){
			$product_loded_cost =  $product_loded_cost - $packaging_cost;
		}
		
		if($sales_support_type==2){
			$sales_support_actual = (($sale_without_gst_price*$sales_support)/100);
			$product_loded_cost =  $product_loded_cost - $sales_support_actual;
			//$sales_support = $sales_support_actual;
		}else if($sales_support_type==1){
			$product_loded_cost =  $product_loded_cost - $sales_support;
		}
		
		if($promotion_cost_type==2){
			$promotion_cost_actual = (($sale_without_gst_price*$promotion_cost)/100);
			$product_loded_cost =  $product_loded_cost - $promotion_cost_actual;
			//$promotion_cost = $promotion_cost_actual;
		}else if($promotion_cost_type==1){
			$product_loded_cost =  $product_loded_cost - $promotion_cost;
		}
		
		if($hindizo_infra_type==2){
			$hindizo_infra_actual = (($sale_without_gst_price*$hindizo_infra)/100);
			$product_loded_cost =  $product_loded_cost - $hindizo_infra_actual;
			//$hindizo_infra = $hindizo_infra_actual;
		}else if($hindizo_infra_type==1){
			$product_loded_cost =  $product_loded_cost - $hindizo_infra;
		}
		
		if($hindizo_margin_new!=''){
			if($hindizo_margin_type_new==2){
				$hindizo_margin_new_actual = (($sale_without_gst_price*$hindizo_margin_new)/100);
			}else{
				$hindizo_margin_new_actual = $hindizo_margin_new;
			}		
			
			if($hindizo_margin_type==2){				
				$hindizo_margin_actual = (($sale_without_gst_price*$hindizo_margin)/100);
				//$product_loded_cost =  $product_loded_cost - $hindizo_margin_actual;
				//$hindizo_margin = $hindizo_margin_actual;
			}else if($hindizo_margin_type==1){
				//$product_loded_cost =  $product_loded_cost - $hindizo_margin;
				$hindizo_margin_actual = $hindizo_margin;
			}
			
			if($hindizo_margin_new_actual==$hindizo_margin_actual){
				$product_loded_cost =  $product_loded_cost - $hindizo_margin_actual;
			}else{
				$hindizo_margin_actual = $hindizo_margin_new_actual;
				$product_loded_cost =  $product_loded_cost - $hindizo_margin_actual;
				$hindizo_margin = $hindizo_margin_new; 				
				$hindizo_margin_type = $hindizo_margin_type_new; 				
			}
		}else{
			if($hindizo_margin_type==2){				
				$hindizo_margin_actual = (($sale_without_gst_price*$hindizo_margin)/100);
				$product_loded_cost =  $product_loded_cost - $hindizo_margin_actual;
				//$hindizo_margin = $hindizo_margin_actual;
			}else if($hindizo_margin_type==1){
				$product_loded_cost =  $product_loded_cost - $hindizo_margin;
				$hindizo_margin_actual = $hindizo_margin;
			}
		}
		
		$retail_commision_percentage_actual = (($sale_without_gst_price*$retail_commision_percentage)/100);
		$product_loded_cost =  $product_loded_cost - $retail_commision_percentage_actual;
		
		$b2c_comission_percentage_actual = (($sale_without_gst_price*$b2c_comission_percentage)/100);
		$product_loded_cost =  $product_loded_cost - $b2c_comission_percentage_actual;
		
		$bulk_commision_percentage_actual = (($sale_without_gst_price*$bulk_commision_percentage)/100);
		$product_loded_cost =  $product_loded_cost - $bulk_commision_percentage_actual;
		
		$renting_commision_percentage_actual = (($sale_without_gst_price*$renting_commision_percentage)/100);
		$product_loded_cost =  $product_loded_cost - $renting_commision_percentage_actual;
		
		// Agency commission
		$agency_record = $this->settings->getAgencyCommission(1);
		$agency_commission_type =$agency_record->commission_type;
		if($agency_commission_type==2){
			$agency_commission = $agency_record->commission;		
			$agency_commission_actual = (($sale_without_gst_price*$agency_commission)/100);
		}else if($agency_commission_type==1){
			$agency_commission = $agency_record->commission;
			$agency_commission_actual = $agency_commission;
		}
		$product_loded_cost =  $product_loded_cost - $agency_commission_actual;
		
		// Cost Settings
		$bank_charges_record = $this->settings->getBankCharges(1);
		$bank_charges_type =$bank_charges_record->charges_type;
		if($bank_charges_type==2){
			$bank_charges = $bank_charges_record->charges;		
			$bank_charges_actual = (($sale_without_gst_price*$bank_charges)/100);
		}else if($bank_charges_type==1){
			$bank_charges = $bank_charges_record->charges;
			$bank_charges_actual = $bank_charges;
		}
		$product_loded_cost =  $product_loded_cost - $bank_charges_actual;
		
		
		$product_loded_cost =  $product_loded_cost + $gst_val;
		$product_loded_cost =  $product_loded_cost - $sale_projected_gst;
		$product_loded_cost =  $product_loded_cost - $without_gst_price;
		
		
		$return_data['hindizo_sale_price'] = $hindizo_sale_price;
		$return_data['refurbishment_cost'] = $refurbishment_cost;
		$return_data['refurbishment_cost_type'] = $refurbishment_cost_type;
		$return_data['packaging_cost'] = $packaging_cost;
		$return_data['packaging_cost_type'] = $packaging_cost_type;
		$return_data['sales_support'] = $sales_support;
		$return_data['sales_support_type'] = $sales_support_type;
		$return_data['promotion_cost'] = $promotion_cost;
		$return_data['promotion_cost_type'] = $promotion_cost_type;
		$return_data['hindizo_infra'] = $hindizo_infra;
		$return_data['hindizo_infra_type'] = $hindizo_infra_type;
		$return_data['hindizo_margin'] = $hindizo_margin;
		$return_data['hindizo_margin_type'] = $hindizo_margin_type;		
		$return_data['agency_commission'] = $agency_commission;	
		$return_data['agency_commission_type'] = $agency_commission_type;

		$return_data['bank_charges'] = $bank_charges;	
		$return_data['bank_charges_type'] = $bank_charges_type;
		$return_data['bank_charges_actual'] = $bank_charges_actual;
		
		$return_data['retail_commision_percentage'] = $retail_commision_percentage;		
		$return_data['b2c_comission_percentage'] = $b2c_comission_percentage;		
		$return_data['bulk_commision_percentage'] = $bulk_commision_percentage;		
		$return_data['renting_commision_percentage'] = $renting_commision_percentage;

		$return_data['refurbishment_cost_actual'] = $refurbishment_cost_actual;
		$return_data['packaging_cost_actual'] = $packaging_cost_actual;
		$return_data['sales_support_actual'] = $sales_support_actual;
		$return_data['promotion_cost_actual'] = $promotion_cost_actual;		
		$return_data['hindizo_infra_actual'] = $hindizo_infra_actual;		
		$return_data['hindizo_margin_actual'] = $hindizo_margin_actual;		
		$return_data['retail_commision_percentage_actual'] = $retail_commision_percentage_actual;		
		$return_data['b2c_comission_percentage_actual'] = $b2c_comission_percentage_actual;		
		$return_data['bulk_commision_percentage_actual'] = $bulk_commision_percentage_actual;		
		$return_data['renting_commision_percentage_actual'] = $renting_commision_percentage_actual;		
		
		$return_data['without_gst_price'] = $without_gst_price;
		$return_data['gst'] = $supplier_price_gst;			
		$return_data['gst_val'] = $gst_val;			
		$return_data['gross_price'] = $gross_price;	
		$return_data['discountFormat'] = $discountFormat;
		
		$return_data['hindizo_sale_price_net'] = $sale_without_gst_price;	
		$return_data['sale_projected_gst'] = $sale_projected_gst;
		$return_data['sale_grand_total'] = $sale_grand_total;		
		$return_data['product_loded_cost'] = $product_loded_cost;	
		$return_data['pid'] = $cost['pid'];	
		
		
		echo json_encode($return_data);
	}
	
	
	public function setSalePrice(){
		echo $save = $this->products->setSalePrice();			 
	}
	
	
	public function getVarientProduct(){
		//$product = $this->uri->segment(3);
		$term = $this->input->post('term');
		$term_arr = explode('-',$term);
		$product = $term_arr[0];
		
		$nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/search?api_key=".$nb_key."&product=".$product,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/json",
			
						),
						));		

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
			} else {
				//echo $response;
				$res = json_decode($response);
				$data['varient'] = $res->data;
				$this->load->view('calculator/api_product_varient',$data);				
				//echo json_encode($res->data[0]);						
			}			
	}
	
	
	public function getAverageProductPrice(){
		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');
		
		$nb_key = 'fdwto5qVqDKAT9Xouf53eAGPvKnksOkjwty ';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://price-api.datayuge.com/api/v1/compare/price?api_key=".$nb_key."&id=".$id,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
						),
						));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
				} else {
					//echo $response;
					$res = json_decode($response);
					//print_r($res); 
					$flipkart_price =  $res->flipkart; 
					$sum = 0;
					$i=0;
					$avg_price = 0;
					foreach($res as $key=>$val){
						if($val!=''){
							$sum = $sum+$val;
							$i++;
						}
					}	
					if($sum!=0){
						 $avg_price = $sum/$i;  
					}else{
						 $avg_price = "N/A";
					}
					
					$data['avg_price'] = $avg_price;
					$data['flipkart_price'] = $flipkart_price;
					echo json_encode($data);
				}		
	}


}