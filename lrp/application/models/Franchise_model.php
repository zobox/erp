<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Franchise_model extends CI_Model
{
   
	private $path = 'userfiles/documents/franchise/';
    public function __construct()
    {
        parent::__construct();
    }
	
	public function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|docx|docs|txt|xls';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	public function save($balance_sheet_up=NULL,$itr_up=NULL,$pan_card_up=NULL,$gst_up=NULL,$bank_statement_up=NULL,$cancelled_cheque_up=NULL,$abcd_up=NULL){
		$data = array();
		$id = $this->input->post('id');
		
		$data['personal_company'] = $this->input->post('personal_company');
		$data['website_id'] = $this->input->post('website_id');
		$data['company_name'] = $this->input->post('company_name');
		$data['company_type'] = $this->input->post('company_type');
		$data['company_email'] = $this->input->post('company_email');
		$data['company_phone'] = $this->input->post('company_phone');
		$data['director_name'] = $this->input->post('director_name');
		$data['director_email'] = $this->input->post('director_email');
		$data['director_phone'] = $this->input->post('director_phone');
		$data['franchise_name'] = $this->input->post('franchise_name');
		$data['franchise_email'] = $this->input->post('franchise_email');
		$data['franchise_phone'] = $this->input->post('franchise_phone');
		$data['phone_s'] = $this->input->post('phone_s');
		$data['email_s'] = $this->input->post('email_s');	
		$data['address_s'] = $this->input->post('address_s');	
		$data['state_s'] = $this->input->post('state_s');	
		$data['city_s'] = $this->input->post('city_s');	
		$data['pincode_s'] = $this->input->post('pincode_s');	
		//$data['postbox_s'] = $this->input->post('postbox_s');	
		$data['phone_b'] = $this->input->post('phone_b');	
		$data['email_b'] = $this->input->post('email_b');	
		$data['address_b'] = $this->input->post('address_b');	
		$data['state_b'] = $this->input->post('state_b');	
		$data['city_b'] = $this->input->post('city_b');	
		$data['pincode_b'] = $this->input->post('pincode_b');	
		//$data['postbox_b'] = $this->input->post('postbox_b');	
		$data['pan'] = $this->input->post('pan');	
		$data['tan'] = $this->input->post('tan');	
		$data['cin'] = $this->input->post('cin');	
		$data['gst'] = $this->input->post('gst');	
		$data['establishment_code'] = $this->input->post('establishment_code');	
		$data['esi'] = $this->input->post('esi');	
		$data['pf'] = $this->input->post('pf');	
		$data['iec_code'] = $this->input->post('iec_code');	
		$data['rtgs_ifsc_code'] = $this->input->post('rtgs_ifsc_code');	
		$data['account_holder'] = $this->input->post('account_holder');	
		$data['account_no'] = $this->input->post('account_no');	
		$data['bank_name'] = $this->input->post('bank_name');	
		$data['branch'] = $this->input->post('branch');		
		$data['module'] = $this->input->post('module');
		
		$data['balance_sheet_up'] = $balance_sheet_up;
		$data['itr_up'] = $itr_up;
		$data['pan_card_up'] = $pan_card_up;
		$data['gst_up'] = $gst_up;
		$data['bank_statement_up'] = $bank_statement_up;
		$data['cancelled_cheque_up'] = $cancelled_cheque_up;
		$data['abcd'] = $abcd_up;		
		$data['same_as_shipping'] = $this->input->post('same_as_shipping');			
		$data['add_status']=1;	
		$data['date_modified']=date('Y-m-d H:i:s');	
		
		$this->db->where('id', $id);
		$this->db->update('geopos_franchise',$data);
		//echo $this->db->last_query(); exit;
		//$this->db->where('id',$this->session->userdata('id'));
		//$rsm_details = $this->db->get('geopos_employees')->result_array();
		
		
		//Send SMS To Payment Recieved Team 
		$SmsNumber = array('9732212158','6289861127','8527626445');
		//$SmsNumber = '8527626445,9732212158';
		if($data['personal_company']==1){
			$franchise_name = $this->input->post('franchise_name');
		}else if($data['personal_company']==2){
			$franchise_name = $this->input->post('company_name');
		}
		$this->load->model('Sms_model','sms');
		$Smsmessage = $this->session->userdata('username').' (RSM) updated the all details of '.$franchise_name.' (franchise) in the our ERP, Please check the data and confirm the payment status'; 
		foreach($SmsNumber as $rowNumber){
			$response = $this->sms->sendSMS($Smsmessage,$rowNumber);
		}
		
		
		/*$mailto = 'neeraj@zobox.in,harish@zobox.in,jitendra@zobox.in,'.$this->session->userdata('email').',mukesh@zobox.in';
		
		$mailtotitle='ZOBOX'; 
		$subject='New updates in ZOBOX Family'; 
		$attachmenttrue = false; 
		$attachment = '';
		$bodyHtml .= "<!doctype html><html lang='en'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'><link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap' rel='stylesheet'><title> New updates in ZOBOX Family </title><style>table,tr,td{border-collapse: collapse;}.main-table{background:rgba(255,255,255,0.92);margin:0 aut0;}.footer{display:flex;justify-content:space-between;align-items:center;width:100%;}.inner-div{display:flex;align-items:center;}.first-div{flex:4;}.second-div{flex:3;text-align:center;}.third-div{flex:3;text-align:right;justify-content:flex-end;}@media only screen and (max-width:600px) {.footer{flex-direction:column;align-items:start;}.first-div,.second-div,.third-div{flex:1;}.first-div,.second-div{margin-bottom:5px; }}</style></head><body><table class='main-table' style='padding:30px 0px;text-align:left;color:#000;'><tr><td style='margin-bottom:20px;padding:0 20px;'><img src='https://zobox.in/images/Zobox_mail.png' alt='logo' style='max-height:60px;max-width:43px;' /> </td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Dear Zobox Team Members, </p><p> Greeting from Zobox !!! </p><p>Congratulations!! New Franchise member comes on board in the  Zobox Family.</p><p>The details related to the new franchise are available down below: </p></td>  </tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p> <strong>Franchise Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Franchise Model: </strong>";
		if($this->input->post('module') == 1){$bodyHtml .= "Enterprise"; }
		else if($this->input->post('module') == 2){$bodyHtml .= "Professional";}
		else if($this->input->post('module') == 3){$bodyHtml .= "Standard";}
		$bodyHtml .= "</p></td></tr>  <tr>    <td style='text-align:left;padding:0 20px;'><p>2.  <strong>Franchise Store ID: </strong>".$id." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3.  <strong>Franchise Name: </strong>".$this->input->post('franchise_name')." </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>4.  <strong>Franchise Phone No :</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>5.  <strong>Franchise Location : </strong>".$this->input->post('address_s').",".$this->input->post('state_s').",".$this->input->post('city_b').",".$this->input->post('pincode_s')."</p></td>  </tr>  <tr>";
		$bodyHtml .= " <td style='text-align:left;padding:0 20px;'><p> <strong>RSM Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>RSM Name : </strong>".$this->session->userdata('username')."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>RSM Phone No :</strong>".$rsm_details->phone."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>RSM Mail Id :</strong>".$this->session->userdata('email')."</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p> <strong>Branding Team Details</strong> </p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>1. <strong>Contact Name : </strong> Devendra Pundir</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>2. <strong>Contact Mail Id :</strong> devendra.zobox@gmail.com</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p>3. <strong>Contact Phone No :</strong> +91 8800688690</p></td></tr><tr><td style='text-align:left;padding:0 20px;'><p> Thank You </p></td></tr><tr><td style='color:#293381;max-width:40%;font-size:20px;font-weight:700;padding: 20px;margin-top:20px;'> Zobox Retails Pvt. Ltd </td></tr></table></body></html>";
		$email_response = $this->communication->send_email($mailto, $mailtotitle, $subject, $bodyHtml, $attachmenttrue, $attachment);*/
	
		
		return TRUE;
	}

}