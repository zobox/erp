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

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->li_a = 'settings';
		$this->load->model('Products_model', 'products');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('categories_model', 'products_cat');
		$this->load->model('customers_model', 'customers');
		$this->load->model('brand_model', 'brand');
		//$this->load->library('excel');

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $this->load->model('settings_model', 'settings');


    }

    public function company()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $taxid = $this->input->post('taxid', true);
            $data_share = $this->input->post('data_share', true);
            $foundation = datefordatabase($this->input->post('foundation', true));
            $this->settings->update_company(1, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid, $data_share, $foundation);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Company Settings';
            $data['company'] = $this->settings->company_details(1);			

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/company', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function currency()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $currency = $this->input->post('currency', true);
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');
            $decimal = $this->input->post('decimal');
            $spost = $this->input->post('spos');
            $roundoff = $this->input->post('roundoff');
            $r_precision = $this->input->post('r_precision');

            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost, $roundoff, $r_precision);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Currency Settings';
            $data['currency'] = $this->settings->currency();

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/currency', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function dtformat()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tzone = $this->input->post('tzone');
            $dateformat = $this->input->post('dateformat');
            $this->settings->update_dtformat(1, $tzone, $dateformat);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Date Time Settings';
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/timeformat', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function companylogo()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->settings->companylogo($id, $img);
        }
    }

    //tax


    public function email()
    {
        $this->li_a = 'misc_settings';
        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
            $auth = $this->input->post('auth');
            $auth_type = $this->input->post('auth_type');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $sender = $this->input->post('sender');

            $this->load->library('ultimatemailer');

            $test = $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $sender, 'Geo POS Test', $sender, 'Geo POS Test', 'Geo POS SMTP Test', 'Hi, This is a Geo POS SMTP Test! Working Perfectly', false, '');

            if ($test) {
                $this->settings->update_smtp($host, $port, $auth, $auth_type, $username, $password, $sender);
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    '<br>Your SMTP settings are invalid. If you think it is a correct configuration, please try with different ports like 465, 587.<br> Still not working please contact to your hosting provider. <br> Free SMTP services are generally blocked by many hosting providers.<br>Please do not send support request to Geo POSSupport Team, we can not help in this matter because in the application email system is working perfectly.'));
            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'SMTP Config';
            $data['email'] = $this->settings->email_smtp();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/email', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing_terms()
    {
        $this->li_a = 'billing';
        $data['terms'] = $this->settings->billingterms();
        $head['title'] = "Billing Terms";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/terms', $data);
        $this->load->view('fixed/footer');
    }

    public function about()
    {
        $this->li_a = 'misc_settings';
        $head['title'] = "About";

        $this->load->view('fixed/header', $head);
        $this->load->view('settings/about');
        $this->load->view('fixed/footer');
    }

    public function add_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');

            $this->settings->add_term($title, $type, $term);

        } else {
            $head['title'] = "Add Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/add_terms');
            $this->load->view('fixed/footer');
        }
    }


    public function edit_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');


            $this->settings->edit_term($id, $title, $type, $term);

        } else {
            $id = $this->input->get('id');

            $data['term'] = $this->settings->get_terms($id);
            $head['title'] = "Edit Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_terms', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_terms()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_terms($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }

    public function activate()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $code = $this->input->post('code', true);
            $this->settings->update_atformat($email, $code);
        } else {
            $head['title'] = "Software Activation";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/active');
            $this->load->view('fixed/footer');
        }
    }

    public function theme()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tdirection = $this->input->post('tdirection', true);
            $menu = $this->input->post('menu', true);
            $this->settings->theme($tdirection, $menu);
        } else {
            $head['title'] = "Theme Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/theme');
            $this->load->view('fixed/footer');
        }
    }

    public function themelogo()
    {
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'
        ));
    }

    public function tickets()
    {
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $service = $this->input->post('service', true);
            $email = $this->input->post('email', true);
            $support = $this->input->post('support', true);
            $sign = $this->input->post('signature');
            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Support Ticket Settings';
            $data['support'] = $this->plugins->universal_api(3);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/ticket', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function tax()
    {
        $this->li_a = 'tax';
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxsettings($this->config->item('tax'));
        if ($this->input->post()) {
            $taxid = $this->input->post('taxid');
            $taxstatus = $this->input->post('taxstatus');
            $gst_type = $this->input->post('gst_type');
            $this->settings->update_tax(1, $taxid, $taxstatus, $gst_type);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Tax Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function prefix()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $invoiceprefix = $this->input->post('invoiceprefix');

            $q_prefix = $this->input->post('q_prefix', true);
            $p_prefix = $this->input->post('p_prefix', true);
            $r_prefix = $this->input->post('r_prefix', true);
            $s_prefix = $this->input->post('s_prefix', true);
            $t_prefix = $this->input->post('t_prefix', true);
            $o_prefix = $this->input->post('o_prefix', true);
            $pos_prefix = $this->input->post('pos_prefix', true);
            $this->settings->update_prefix($invoiceprefix, $q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix, $o_prefix, $pos_prefix);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Prefix Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/prefix', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function language()
    {
        $this->li_a = 'localisation';
        $this->load->library("Common");
        if ($this->input->post()) {

            $lang = $this->input->post('language', true);

            $this->settings->update_language(1, $lang);


        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Billing & TAX Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $data['langs'] = $this->common->languages();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function automail()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $sms = $this->input->post('sms');
            $this->settings->update_automail($email, $sms);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Email SMS Settings';
            $data['auto'] = $this->settings->automail();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/automail', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxslabs()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->slabs();
        $head['title'] = "TAX Slabs";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/slabs', $data);
        $this->load->view('fixed/footer');
    }

    public function taxslabs_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate');
            $ttype = $this->input->post('ttype');
            $ttype2 = $this->input->post('ttype2');
            $this->settings->add_slab($tname, $trate, $ttype, $ttype2);

        } else {

            $data['catlist'] = $this->settings->slabs();
            $head['title'] = "TAX Slabs";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxslabs_delete()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_slab($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }

    }

    public function logdata()
    {
        $this->li_a = 'advance';
        $data['acts'] = $this->settings->logs();
        $head['title'] = "App Log";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/logs', $data);
        $this->load->view('fixed/footer');
    }


    public function warehouse()
    {
        $this->li_a = 'billing';
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $wid = $this->input->post('wid');

            $this->plugins->update_api(60, $wid, '', 1, '', '');

        } else {

            $this->db->select('*');
            $this->db->from('geopos_warehouse');

            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', 0);
                $this->db->or_where('loc', $this->aauth->get_user()->loc);
            }


            $query = $this->db->get();
            $data['warehouses'] = $query->result_array();

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Default WareHouse';
            $data['ware'] = $this->plugins->universal_api(60);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/warehouse', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function discship()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(61);
        if ($this->input->post()) {
            $discstatus = $this->input->post('discstatus');
            $shiptax_type = $this->input->post('shiptax_type');
            $shiptax_rate = $this->input->post('shiptax_rate');
            switch ($discstatus) {


                case 'flat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX');
                    break;
                case 'b_p' :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                case 'bflat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                default :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');
                    break;
            }
            $this->plugins->update_api(61, $discstatus, $shiptax_rate, 0, $shiptax_type, $discstatus_name);


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Discount & Shipping Settings';
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/discship', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function pos_style()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $assign = $this->input->post('assign', true);
            $this->plugins->m_update_api(69, $assign, 0, 0, 0, 0, 0, false);
            $this->settings->posstyle($tdirection);
        } else {
            $head['title'] = "Pos Style Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['current'] = $this->plugins->universal_api(69);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/posstyle', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function zero_stock()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $tdirection = $this->input->post('stock', true);
            $expired = $this->input->post('expired', true);
            $this->settings->zerostock($tdirection);
        } else {
            $data['current'] = $this->plugins->universal_api(63);
            $head['title'] = "Product As Service Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/zerostock', $data);
            $this->load->view('fixed/footer');


        }
    }

    public function registration()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $register = $this->input->post('register', true);
            $email_confrim = $this->input->post('email_conf', true);
            $auto_mail = $this->input->post('automail', true);
            $this->plugins->m_update_api(64, $register, 0, $email_confrim, 0, $auto_mail);
        } else {
            $data['current'] = $this->plugins->universal_api(64);
            $head['title'] = "CRM Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/selfregistration', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	public function franchise()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'settings';   
		
			$data['franchise'] = $this->plugins->getFranchiseModule();
			$head['title'] = "CRM Settings";
			$head['usernm'] = $this->aauth->get_user()->username;
			$this->load->view('fixed/header', $head);
			$this->load->view('settings/franchise', $data);
			$this->load->view('fixed/footer');        
    }
	
    public function newfranchise()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'settings';   
		
			$data['franchise'] = $this->plugins->getFranchiseModule();
			$head['title'] = "CRM Settings";
			$head['usernm'] = $this->aauth->get_user()->username;
			$this->load->view('fixed/header', $head);
			$this->load->view('settings/newfranchise', $data);
			$this->load->view('fixed/footer');        
    }
	
	public function updatefranchise()
    {       
        $this->li_a = 'settings';

        if ($this->input->post()) {            
            $this->plugins->updateFranchiseCommission();
			redirect('/settings/franchise/', 'refresh');
        } else {
			$id = $this->input->get('id', true);
			$data['id'] = $id;
            $data['franchise'] = $this->plugins->getFranchise($id);	            
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0);
			
			foreach($data['cat'] as $key=>$catdata){
				$datacat[$catdata->id]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $catdata->id);
				$datacat[$catdata->id][1] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='1');
				$datacat[$catdata->id][2] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='2');
				$datacat[$catdata->id][3] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='3');
			}
			$data['catcommision'] = $datacat;
            $head['title'] = "Franchise Commission Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editfranchise_comission', $data);
            $this->load->view('fixed/footer');
        }
    }
	
    public function updatenewfranchise()
    {       
        $this->li_a = 'settings';

        if ($this->input->post()) {            
            $this->plugins->updateFranchiseCommission();
			redirect('/settings/franchise/', 'refresh');
        } else {
			$id = $this->input->get('id', true);
			$data['id'] = $id;
            $data['franchise'] = $this->plugins->getFranchise($id);	            
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0);
			
			foreach($data['cat'] as $key=>$catdata){
				$datacat[$catdata->id]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $catdata->id);
				$datacat[$catdata->id][1] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='1');
				$datacat[$catdata->id][2] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='2');
				$datacat[$catdata->id][3] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata->id,$purpose='3');
			}
			$data['catcommision'] = $datacat;
            $head['title'] = "Franchise Commission Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editnewfranchise_comission', $data);
            $this->load->view('fixed/footer');
        }
    }    

    public function custom_fields()
    {
        $this->li_a = 'advance';
        $data['customfields'] = $this->settings->custom_fields();
        $head['title'] = "Custom Form Fields Settings";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/custom_field', $data);
        $this->load->view('fixed/footer');
    }

    public function add_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $this->settings->custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $head['title'] = "Custom Form Fields Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_add');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $id = $this->input->post('fid');
            $this->settings->custom_field_edit($id, $f_name, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $id = $this->input->get('id');
            $data['customfields'] = $this->settings->custom_fields($id);
            $head['title'] = "Custom Form Fields Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_custom_field()
    {
        $id = $this->input->post('deleteid');

        if ($this->db->delete('geopos_custom_fields', array('id' => $id))) {
            $this->db->delete('geopos_custom_data', array('field_id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function print_invoice()
    {
        $this->li_a = 'templates';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $this->settings->printinvoice($tdirection);
        } else {
            $head['title'] = "Print Invoice Style Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/printinvoice');
            $this->load->view('fixed/footer');
        }
    }

    public function dual_entry()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist($this->aauth->get_user()->loc);
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(65);
        if ($this->input->post()) {
            $dual = $this->input->post('dual');
            $dual_inv = $this->input->post('dual_inv');
            $dual_pur = $this->input->post('dual_pur');
            $this->plugins->m_update_api(65, $dual, $dual_inv, $dual_pur);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Dual Entry Settings';
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/dual_entry', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function misc_automail()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $td_email = $this->input->post('td_email');
            $id_email = $this->input->post('id_email');
            $send_email = $this->input->post('send');
            $this->plugins->m_update_api(66, $email, $td_email, $send_email, $id_email);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Email Settings';
            $data['auto'] = $this->plugins->universal_api(66);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/misc_automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function allow_custom()
    {
        $enable = $this->input->post('enable');
        if ($enable != CUSTOM) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('CUSTOM', '" . CUSTOM . "')", "('CUSTOM', '$enable')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function debug()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $debug = $this->input->post('debug', true);
            $this->settings->debug($debug);
        } else {
            $head['title'] = "App Debug Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/debug');
            $this->load->view('fixed/footer');
        }
    }

    public function server()
    {
        phpinfo();
    }

    public function db_error()
    {
        $query = $this->db->query("SELECT i.id, SUM(i.total) AS total,i.status,i.i_class,c.name,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id GROUP BY  i.csd ORDER BY  i.id  LIMIT 10");
        $error = $this->db->error();
        if (@$error['code']) {
            echo ' Critical Error: SQL Strict Mode Enabled! Please disable it to run app properly!';
            print_r($error);
        } else {
            echo ' Your SQL service is running well!';
        }
        $result = $query->result_array();
    }

    public function switch_location()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'loc' => $id
        );
        $this->db->set($data);
        $this->db->where('id', $this->aauth->get_user()->id);
        $this->db->update('geopos_users');
        redirect(base_url('dashboard'));
    }

    public function billing_settings()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $stock = $this->input->post('stock', true);
            $serial = $this->input->post('serial', true);
            $expired = $this->input->post('expired', true);
            $this->settings->billing_settings($stock, $serial, $expired);
        } else {
            $data['zero_stock'] = $this->plugins->universal_api(63);
            $data['billing_settings'] = $this->plugins->universal_api(67);
            $head['title'] = "Billing Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing_settings', $data);
            $this->load->view('fixed/footer');


        }
    }
	
	public function getSubcatAjaxData()
	{
	
		$categoryId = $this->input->post('categoryId');
		$moduleid = $this->input->post('moduleid');
		//$datacat[$categoryId]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $categoryId);
		$datacat[$categoryId]['cat'] = $this->products_cat->getCategoryById($categoryId);
		
		$datacat[$categoryId][1] = $this->plugins->getCatCommision($module_id=$moduleid,$category_id=$categoryId,$purpose='1');
		$datacat[$categoryId][2] = $this->plugins->getCatCommision($module_id=$moduleid,$category_id=$categoryId,$purpose='2');
		$datacat[$categoryId][3] = $this->plugins->getCatCommision($module_id=$moduleid,$category_id=$categoryId,$purpose='3');
		$data['catcommision'] = $datacat;
		//print_r($data);
		 $this->load->view('settings/getSubcatAjaxData', $data);
	}
	
	public function cost11022021()
    {       
        $this->li_a = 'billing';

        if ($this->input->post()) {            
            $this->plugins->updateCommission();
			redirect('/settings/cost/', 'refresh');
        } else {
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$website_id='',$product=true);
			
			foreach($data['cat'] as $key=>$catdata){
				$datacat[$catdata->id]['child'] = $this->products_cat->subcategory_list($type = 1, $rel = $catdata->id,$franchise_id=0,$module='',$product=true);
			}
			$data['catcommision'] = $datacat;
            $head['title'] = "Commission Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cost', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	public function getSubcostAjaxData()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$data['type'] = $type;
		if($type=='s'){			
			$datacat[$categoryId]['cat'] = $this->products_cat->getCategoryById($id);
		}elseif($type=='p'){
			$datacat[$categoryId]['cat'] = $this->products->getproductById($id);
		}elseif($type=='v'){
			$datacat[$categoryId]['cat'] = $this->products->getproductById($id);
		}
		
		$data['catcommision'] = $datacat;		
		$this->load->view('settings/getSubcostAjaxData', $data);
	}
	
	public function cost(){
		$this->li_a = 'settings';
		$action = $this->input->get('action');
		$data['action'] = $action;
        if ($this->input->post()) {            
            $this->products_cat->savecost($action);
			redirect('/settings/cost?action='.$action, 'refresh');
        } else {
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$website_id='',$product=true);
			
			switch($action){
				case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
				break;
				case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
				break;
				case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
				break;
				case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
				break;
				case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
				break;
				case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
				break;
			}
				
            $head['title'] = $lbl_name;
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cost', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	
	public function costlist(){			
		$this->li_a = 'settings';   
			$action = $this->input->get('action');
			$data['action'] = $action;
			//$data['products'] = $this->products->refurbishmentCostProductList();
			$data['cat'] = $this->products_cat->CostCatList($action);
						
			switch($action){
				case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
				break;
				case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
				break;
				case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
				break;
				case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
				break;
				case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
				break;
				case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
				break;
			}
			
            $head['title'] = $lbl_name;
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/costlist', $data);
            $this->load->view('fixed/footer');
	}
	
	public function cost_excel(){	
		$action = $this->input->get('action');
		$data['action'] = $action;
		$records = $this->products_cat->CostCatList($action);	
		
		$fileName = 'costlist.xlsx';  
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Refurbishment Cost');  
        $rowCount = 2;
		
		foreach($records as $key=>$crow){
			switch($action){
				case 'refurbishment' : $cost = $crow->refurbishment_cost; $type= $crow->refurbishment_cost_type;
				break;
				case 'packaging' : $cost = $crow->packaging_cost; $type= $crow->packaging_cost_type;
				break;
				case 'salessupport' : $cost = $crow->sales_support; $type= $crow->sales_support_type;
				break;
				case 'promotion' : $cost = $crow->promotion_cost; $type= $crow->promotion_cost_type;
				break;
				case 'infra' : $cost = $crow->hindizo_infra; $type= $crow->hindizo_infra_type;
				break;
				case 'margin' : $cost = $crow->hindizo_margin; $type= $crow->hindizo_margin_type;
				break;
			}
			if($type==2){ $type_val = ' (%)'; }else{ $type_val = " (Fixed)"; }
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $crow->parent_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, floatval($cost).$type_val);
			$rowCount++;		
		
		
			foreach($crow->products as $key1=>$prow){ 
				switch($action){
					case 'refurbishment' : $cost = $prow->refurbishment_cost; $type= $prow->refurbishment_cost_type;
					break;
					case 'packaging' : $cost = $prow->packaging_cost; $type= $prow->packaging_cost_type;
					break;
					case 'salessupport' : $cost = $prow->sales_support; $type= $prow->sales_support_type;
					break;
					case 'promotion' : $cost = $prow->promotion_cost; $type= $prow->promotion_cost_type;
					break;
					case 'infra' : $cost = $prow->hindizo_infra; $type= $prow->hindizo_infra_type;
					break;
					case 'margin' : $cost = $prow->hindizo_margin; $type= $prow->hindizo_margin_type;
					break;
				}
				if($type==2){ $type_val = ' (%)'; }else{ $type_val = " (Fixed)"; }
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $prow->category_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $prow->product_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, floatval($cost).$type_val);
				$rowCount++;
			}
		}
		
		 $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		 $objWriter->save($fileName);
		 header("Content-Type: application/vnd.ms-excel");
		 redirect(base_url().$fileName);   
	
	}
	
	public function edit_cost(){
		$this->li_a = 'settings';
		$action = $this->input->get('action');				
		$type = $this->input->get('type');
		$id = $this->input->get('id');
		
		if($type=='category'){
			$record = $this->products_cat->getRecordById($id);
		}else if($type=='product'){
			$record = $this->products->getRecordById($id);
		}
		
		$data['record'] = $record;
		$data['action'] = $action;
		$data['type'] = $type;
		$data['id'] = $id;
		
        if ($this->input->post()) {    
			if($type=='category'){
				$this->products_cat->save_editcost($action,$id);
			}else if($type=='product'){				
				$this->products->save_editcost($action,$id);
			}
			redirect('/settings/costlist?action='.$action, 'refresh');
        } else {
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$website_id='',$product=true);
			
			switch($action){
				case 'refurbishment' : $lbl_name = $this->lang->line('Refurbishment Cost');
				break;
				case 'packaging' : $lbl_name = $this->lang->line('Packaging Cost');
				break;
				case 'salessupport' : $lbl_name = $this->lang->line('After Sales Support');
				break;
				case 'promotion' : $lbl_name = $this->lang->line('Promotion Cost');
				break;
				case 'infra' : $lbl_name = $this->lang->line('Hindizo Infra');
				break;
				case 'margin' : $lbl_name = $this->lang->line('Hindizo Margin');
				break;
			}	
			
            $head['title'] = $lbl_name;
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_cost', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	
	public function agencycommission(){
		$this->li_a = 'settings';		
        if ($this->input->post()) {            
            $this->settings->saveAgencyCommission();
			redirect('/settings/agencycommission', 'refresh');
        } else {
			$id = $this->input->get('id');
			$record = $this->settings->getAgencyCommission($id);
			$data['record'] = $record;
			
            $head['title'] = "Agency Commission";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/agencycommission', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	
	public function bank_charges(){
		$this->li_a = 'settings';		
        if ($this->input->post()) {            
            $this->settings->saveBankCharges();
			redirect('/settings/bank_charges', 'refresh');
        } else {
			$id = $this->input->get('id');
			$record = $this->settings->getBankCharges($id);
			$data['record'] = $record;
			
            $head['title'] = "Bank Charges";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/bank_charges', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	
	public function tds(){
		$this->li_a = 'settings';		
        if ($this->input->post()) {            
            $this->settings->saveTds();
			redirect('/settings/tds', 'refresh');
        } else {
			$id = $this->input->get('id');
			$record = $this->settings->getTds($id);
			$data['record'] = $record;
			
            $head['title'] = "TDS";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tds', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	public function jobworkcostlist(){
		$this->li_a = 'settings';
		$data['action'] = $this->input->get('action');
		$data['records'] = $this->products_cat->JobWorkCostList($data['action']);
		$head['title'] = "Job work ". ucfirst($data['action']).' Cost';
		$head['usernm'] = $this->aauth->get_user()->username;
		$this->load->view('fixed/header', $head);
		$this->load->view('settings/jobworkcostlist', $data);
		$this->load->view('fixed/footer');
	}
	
	
	public function job_work_cost(){
		$this->li_a = 'settings';
        $this->load->library("Common");
		$action = $this->input->get('action');
		$data['action'] = $action;
		if ($this->input->post()) {
			$this->products_cat->save_job_work_cost($action);
			redirect('/settings/job_work_cost?action='.$action, 'refresh');
        } else {
			$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$website_id='',$product=true);
				
            $data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0,$website_id='',$product=true);
				
            $head['title'] = "Refurbishment Cost";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/job_work_cost', $data);
            $this->load->view('fixed/footer');
        }
			
	}
	
	public function edit_job_work_cost(){
		$this->li_a = 'settings';
		$action = $this->input->get('action');				
		$type = $this->input->get('type');
		$pid = $this->input->get('pid');
		
        if ($this->input->post()) {    
			$this->products_cat->edit_job_work_cost();
			redirect('/settings/jobworkcostlist?action='.$action, 'refresh');
        } else {
			$data['records'] = $this->products_cat->getjobworkrecordByID($pid);
			
            $head['title'] = $lbl_name;
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_job_work_cost', $data);
            $this->load->view('fixed/footer');
        }
	}
	
	public function jobworkcostlistview(){
		$this->li_a = 'settings';
		$action = $this->input->get('action');
		$pid = $this->input->get('pid');
		$data['action'] = $action;
		$data['pid'] = $pid;
		//print_r($this->input->get());die;
		$this->load->view('fixed/header', $head);
		$this->load->view('settings/job_work_cost_view', $data);
		$this->load->view('fixed/footer');
	}
	
	public function viewnewfranchise()
    {       
        $this->li_a = 'settings';

        if ($this->input->post()) {            
            $this->plugins->updateFranchiseCommission();
			redirect('/settings/franchise/', 'refresh');
        } else {
			$id = $this->input->get('id', true);
			$data['id'] = $id;
            $data['franchise'] = $this->plugins->getFranchise($id);
			
			$category = $this->products_cat->category_list_all($type = 0, $rel = 0);		
			
			foreach($category as $catrow){
				$cat_array[$catrow->id]['cat'] = $catrow;
				$cat_array[$catrow->id]['subcat'] = $this->products_cat->category_list_all($type=1, $catrow->id,$website_id=1,$product=false);
				foreach($cat_array[$catrow->id]['subcat'] as $subcatrow){
					$cat_array[$catrow->id]['subsubcat'] = $this->products_cat->category_list_all($type=1, $subcatrow->id,$website_id=1,$product=false);
				}
			}		
			
			$data['cat'] = $cat_array;
			
			$datacat = array();
			foreach($data['cat'] as $key=>$catdata){
				
				$datacat[$catdata['cat']->id][1] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata['cat']->id,$purpose='1');
				
				$datacat[$catdata['cat']->id][2] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata['cat']->id,$purpose='2');
				
				$datacat[$catdata['cat']->id][3] = $this->plugins->getCatCommision($module_id=$id,$category_id=$catdata['cat']->id,$purpose='3');
				
				if(is_array($catdata['subcat'])){								
					foreach($catdata['subcat'] as $key1=>$subcat_data){
						$datacat[$subcat_data->id][1] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subcat_data->id,$purpose='1');
						
						$datacat[$subcat_data->id][2] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subcat_data->id,$purpose='2');
						
						$datacat[$subcat_data->id][3] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subcat_data->id,$purpose='3');
						
						if(is_array($catdata['subsubcat'])){								
							foreach($catdata['subsubcat'] as $key2=>$subsubcat_data){
								$datacat[$subsubcat_data->id][1] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subsubcat_data->id,$purpose='1');
						
								$datacat[$subsubcat_data->id][2] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subsubcat_data->id,$purpose='2');
								
								$datacat[$subsubcat_data->id][3] = $this->plugins->getCatCommision($module_id=$id,$category_id=$subsubcat_data->id,$purpose='3');
							}
						}
						
					}			
				}
			}
			
			$data['catcommision'] = $datacat;
            $head['title'] = "Franchise Commission Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/viewnewfranchise_comission', $data);
            $this->load->view('fixed/footer');
        }
    }	
	
    public function add_data(){
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Data';
		$this->load->view('fixed/header', $head);
		$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0);
		$this->load->view('settings/add-data',$data);
		$this->load->view('fixed/footer');
    }	
	
    public function edit_data(){
		$cat_id= $this->input->get('cat_id');
		$subcat_id= $this->input->get('subcat');
		$subsubcat_id= $this->input->get('subsubcat');
		
		$purpose= $this->input->get('purpose');
		$franchise_id= $this->input->get('franchise_id');
		$module_id= $this->input->get('module_id');		
		if($cat_id)
		$data['subcat'] = $this->products_cat->category_list_all($type=1, $cat_id,$website_id=1,$product=false);
		if($subcat_id)
		$data['subsubcat'] = $this->products_cat->category_list_all($type=1, $subcat_id,$website_id=1,$product=false);
		
		$data['cat_id'] = $cat_id;
		$data['subcat_id'] = $subcat_id;
		$data['subsubcat_id'] = $subsubcat_id;
		$data['purpose'] = $purpose;
		$data['franchise_id'] = $franchise_id;
		$data['module_id'] = $module_id;
		$data['cat'] = $this->products_cat->category_list_all($type = 0, $rel = 0);
		
		$head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Data';
		$this->load->view('fixed/header', $head);
		
		if($cat_id)
		$category_id = $cat_id;
		if($subcat_id)
		$category_id = $subcat_id;
		if($subsubcat_id)
		$category_id = $subsubcat_id;
		
		$data['records'] = $this->plugins->getCatCommision($module_id,$category_id,$purpose,$franchise_id);
		$this->load->view('settings/edit-data',$data);
		$this->load->view('fixed/footer');
    }
	
	public function subCatDropdownHtml($ProductCategoryId=''){
        if($ProductCategoryId == ''){
            $ProductCategoryId = $this->input->post('id',true);
        }
        $result = $this->products_cat->category_list_dropdown(1, $ProductCategoryId);
        if($result != false){
            $html =  "<option value='' selected=''> --- Select --- </option>";
            foreach($result as $row){
                $html .= "<option value='".$row->id."'>".$row->title."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }
	
	public function addrow(){
		$rowcount = $this->input->post('rowcount');
		$cat = $this->products_cat->category_list_all($type = 0, $rel = 0);
		$html = '<tr id="tr-'.$rowcount.'">						
					<td>
						<select name="cat[]" id="cat_id-'.$rowcount.'" class="form-control margin-bottom rqty required" onchange="sub_cat_dropdown(this.value,'.$rowcount.');">
							<option value="">-- Select --</option>';
							
						   foreach($cat as $key=>$cat_data){ 
							$html .= '<option value="';
							$html .= $cat_data->id;
							$html .= '">';
							$html .= $cat_data->title;
							$html .= '</option>';
						    } 
							
						$html .= '</select>
					</td>
					
					<td>
						<select name="sub_cat[]" id="sub_cat_id-'.$rowcount.'" class="form-control margin-bottom rqty " onchange="sub_sub_cat_dropdown(this.value,'.$rowcount.');">
							<option value="">-- Select --</option>
						</select>
					</td>
					
					<td>
						<select name="sub_sub_cat[]" id="sub_sub_cat_id-'.$rowcount.'" class="form-control margin-bottom rqty ">
							<option value="">-- Select --</option>
						</select>
					</td>
					
					<td>
						<select name="purpose[]" id="purpose-'.$rowcount.'" class="form-control margin-bottom rqty required">
							<option value="">-- Purpose --</option>
							<option value="1"> Buying </option>
							<option value="2"> Selling</option>
							<option value="3">Exchange</option>
						</select>
					</td>
					<td class="text-center">
						<input type="text" name="retail[]" id="retail" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
					<td class="text-center">
						<input type="text" name="b2c[]" id="b2c" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
					<td class="text-center">
						<input type="text" name="bulk[]" id="bulk" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
					<td class="text-center">
						<input type="text" name="renting[]" id="renting" class="form-control margin-bottom b_input required" style="width: 100%;"> </td>
					<td><button onclick="deleteRowsss('.$rowcount.');" class=" btn-sm btn-danger text-white" type="button">&times;</button></td>
				</tr>';
			echo $html;
	}
	
	
	public function update_commission(){		
		if ($this->input->post()) { 
			$module = $this->input->post('module');
            $this->plugins->update_commission();
			//redirect('settings/viewnewfranchise?id='.$module, 'refresh');
        } 
		
	}
	
	public function update_commission_edit(){		
		if ($this->input->post()) { 
			//echo "TTTTTTTTTTTTT"; exit;
			$module = $this->input->post('module'); 
            $this->plugins->update_commission_edit();
			//redirect('settings/viewnewfranchise?id='.$module, 'refresh');
        } 
		
	}
	

}