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

defined('BASEPATH') OR exit('No direct script access allowed');


class Plugins_model extends CI_Model
{


    public function recaptcha($captcha, $public_key, $private_key)
    {
        $data = array(
            'key1' => $public_key,
            'key2' => $captcha,
            'url' => $private_key
        );

        $this->db->set($data);
        $this->db->where('id', 53);

        if ($this->db->update('univarsal_api', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function config_general()
    {
        $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s,method AS bank,other AS acid,active AS ext1');
        $this->db->from('univarsal_api');
        $this->db->where('id', 53);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function universal_api($id)
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_api($id, $key1, $key2, $enable, $url = '', $other = '')
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'url' => $url,
            'active' => $enable,
            'other' => $other
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('univarsal_api', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function m_update_api($id, $key1, $key2 = 0, $url = '', $method = 0, $other = '', $enable = 0,$m=true)
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'url' => $url,
            'method' => $method,
            'other' => $other,
            'active' => $enable

        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('univarsal_api', $data)) {
            if ($m) {

                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED')));
            }
        } else {
            if ($m) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }

        }
    }
	
	
	public function updateFranchiseCommission($m=true,$franchise_id=0)
    {
		$id = $this->input->post('id', true);
		$module = $this->input->post('module', true);
		$retail = $this->input->post('retail', true);
		$b2c = $this->input->post('b2c', true);
		$bulk = $this->input->post('bulk', true);
		$renting = $this->input->post('renting', true);	
		$subcat = $this->input->post('subcat', true);			
		
		foreach($retail as $key=>$retail_data){
			foreach($retail_data as $key2=>$retail_row){
				$catdata['retail_commision_percentage'] = numberClean($retail_row);
				$catdata['b2c_comission_percentage'] = numberClean($b2c[$key][$key2]);
				$catdata['bulk_commision_percentage'] = numberClean($bulk[$key][$key2]);
				$catdata['renting_commision_percentage'] = numberClean($renting[$key][$key2]);
				$module_id = $module;
				$category_id = $key;
				$purpose = $key2;
				$catdata['category_id'] = $category_id;
				$catdata['franchise_id'] = $franchise_id;
				$catdata['purpose'] = $purpose;
				$catdata['module_id'] = $module_id;
				$catdata['date_modified']=date('Y-m-d H:i:s');

				$chk = $this->CHKCatCommission($module_id,$category_id,$purpose,$franchise_id);
				if($chk>0){
					$this->db->where('franchise_id', $franchise_id);
					$this->db->where('module_id', $module_id);
					$this->db->where('purpose', $purpose);
					$this->db->where('category_id', $category_id);
					$this->db->update('franchise_category_commision_slab_master',$catdata);
				}else{					
					$this->db->insert('franchise_category_commision_slab_master',$catdata);
				}
				//echo $this->db->last_query();
			}
			
			foreach($subcat as $key3=>$scat){				
				$this->db->where('category_id', $key3);
				$this->db->where('module_id',$module_id);
				$sdata['commission_status'] = 1;
				$this->db->update('franchise_category_commision_slab_master',$sdata);
				if($franchise_id==0){
				$this->db->where('id',$key3);				
				$this->db->update('geopos_product_cat',$sdata);
				}
				//$this->db->last_query(); 
			}
		} 		
		
		$module = $this->input->post('module', true);
		$space_required = $this->input->post('space_required', true);
		$total_refundable = numberClean($this->input->post('total_refundable', true));
		$franchise_fee = numberClean($this->input->post('franchise_fee', true));
		$Infra_and_branding_cost = numberClean($this->input->post('Infra_and_branding_cost', true));
		$total_non_refundable = numberClean($this->input->post('total_non_refundable', true));
		$interest_on_security_deposite = numberClean($this->input->post('interest_on_security_deposite', true));
		$interest_on_security_deposite_st_dt = $this->input->post('interest_on_security_deposite_st_dt', true);
		$interest_on_security_deposite_end_dt = $this->input->post('interest_on_security_deposite_end_dt', true);
		$mg = numberClean($this->input->post('mg', true));
		$mg_st_dt = $this->input->post('mg_st_dt', true);
		$mg_end_dt = $this->input->post('mg_end_dt', true);
		$salary_paid_by_zobox = numberClean($this->input->post('salary_paid_by_zobox', true));
		$salary_paid_by_zobox_st_dt = $this->input->post('salary_paid_by_zobox_st_dt', true);
		$salary_paid_by_zobox_end_dt = $this->input->post('salary_paid_by_zobox_end_dt', true);
		$interest_on_security_deposite_status = $this->input->post('interest_on_security_deposite_status', true);
		$mg_status = $this->input->post('mg_status', true);
		$salary_paid_by_zobox_status = $this->input->post('salary_paid_by_zobox_status', true);

        $data = array(
            'franchise_id' => $franchise_id,
            'module' => $module,
            'space_required' => $space_required,
            'total_refundable' => $total_refundable,
            'franchise_fee' => $franchise_fee,
            'Infra_and_branding_cost' => $Infra_and_branding_cost,
            'total_non_refundable' => $total_non_refundable,
            'interest_on_security_deposite' => $interest_on_security_deposite,
            'interest_on_security_deposite_st_dt' => $interest_on_security_deposite_st_dt,
            'interest_on_security_deposite_end_dt' => $interest_on_security_deposite_end_dt,
            'mg' => $mg,
            'mg_st_dt' => $mg_st_dt,
            'mg_end_dt' => $mg_end_dt,
            'salary_paid_by_zobox' => $salary_paid_by_zobox,
            'salary_paid_by_zobox_st_dt' => $salary_paid_by_zobox_st_dt,
            'salary_paid_by_zobox_end_dt' => $salary_paid_by_zobox_end_dt,
            'interest_on_security_deposite_status' => $interest_on_security_deposite_status,
            'mg_status' => $mg_status,
            'salary_paid_by_zobox_status' => $salary_paid_by_zobox_status
        );
		$data['date_modified']=date('Y-m-d H:i:s');		
				
		if($id!=''){
        $this->db->set($data);        
        $this->db->where('id', $id);
			if ($this->db->update('franchise_module_slab_master', $data)) {					
				if ($m) {

					echo json_encode(array('status' => 'Success', 'message' =>
						$this->lang->line('UPDATED')));
				}
			} else {
				if ($m) {
					echo json_encode(array('status' => 'Error', 'message' =>
						$this->lang->line('ERROR')));
				}

			}
		}else{
			$chk1 = $this->CHKModuleCommission($module_id,$franchise_id);
			if($chk1>0){
				$this->db->where('franchise_id', $franchise_id);
				$this->db->where('module', $module_id);				
				$this->db->update('franchise_module_slab_master',$data);
			}else{					
				$this->db->insert('franchise_module_slab_master',$data);
			}
		}
    }
	

	public function getFranchise($id){		
        $this->db->where('id', $id);
        $query = $this->db->get('franchise_module_slab_master');
        return $query->row_array();
	}
	
	public function getFranchiseComissionByFranchiseID($franchise_id){		
        $this->db->where('franchise_id', $franchise_id);
        $query = $this->db->get('franchise_module_slab_master');
		//echo $this->db->last_query();
        return $query->row_array();
	}

	public function CHKCatCommission($module_id,$category_id,$purpose,$franchise_id=0) {	
		$this->db->where('franchise_id', $franchise_id);
		$this->db->where('module_id', $module_id);
        $this->db->where('category_id', $category_id);
        $this->db->where('purpose', $purpose);
		$this->db->select('count(*) as total');		
		$query = $this->db->get("franchise_category_commision_slab_master");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function CHKModuleCommission($module_id,$franchise_id=0) {	
		$this->db->where('franchise_id', $franchise_id);
		$this->db->where('module', $module_id);       
		$this->db->select('count(*) as total');		
		$query = $this->db->get("franchise_module_slab_master");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }

	public function getCatCommision($module_id='',$category_id='',$purpose='',$franchise_id=0){		
		$this->db->where('franchise_id', $franchise_id);
		if($module_id)
		$this->db->where('module_id', $module_id);
		if($category_id)
        $this->db->where('category_id', $category_id);
		if($purpose)
        $this->db->where('purpose', $purpose);
		$query = $this->db->get("franchise_category_commision_slab_master");
		//echo $this->db->last_query(); //exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {	
				if($purpose==''){
					$data[] = $row;
				}else{
					$data = $row;
				}
			}			
			return $data;
		}
		return false;
	}
	
	
	public function getFranchiseModule(){
		//$this->db1->limit($limit,$start);
		$this->db->where('franchise_id', 0);
		$query = $this->db->get("franchise_module_slab_master");
		//echo $this->db->last_query(); exit;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {			
				$data[] = $row;
			}			
			return $data;
		}
		return false;;
	}
	
	public function update_commission(){		
		$module = $this->input->post('module');
		$cat = $this->input->post('cat');
		$sub_cat = $this->input->post('sub_cat');
		$sub_sub_cat = $this->input->post('sub_sub_cat');
		$purpose = $this->input->post('purpose');
		$retail = $this->input->post('retail');
		$b2c = $this->input->post('b2c');
		$bulk = $this->input->post('bulk');
		$renting = $this->input->post('renting');
		
		
			foreach($retail as $key=>$retail_row){
				$catdata['retail_commision_percentage'] = numberClean($retail_row);
				$catdata['b2c_comission_percentage'] = numberClean($b2c[$key]);
				$catdata['bulk_commision_percentage'] = numberClean($bulk[$key]);
				$catdata['renting_commision_percentage'] = numberClean($renting[$key]);

				$category_id = $cat[$key];
				if($sub_cat[$key])
				$category_id = $sub_cat[$key];
				if($sub_sub_cat[$key])
				$category_id = $sub_sub_cat[$key];
				
				$purpose_id = $purpose[$key];
				$franchise_id = 0;
				
				$catdata['category_id'] = $category_id;
				$catdata['franchise_id'] = $franchise_id;
				$catdata['purpose'] =  $purpose_id;
				$catdata['module_id'] = $module;
				$catdata['commission_status'] = 1;
				$catdata['valid_from']=date('Y-m-d',strtotime($sdate));
				$catdata['date_modified']=date('Y-m-d H:i:s');

				$chk = $this->CHKCatCommission($module,$category_id,$purpose_id,$franchise_id);
				if($chk>0){
					$this->db->where('franchise_id', $franchise_id);
					$this->db->where('module_id', $module);
					$this->db->where('purpose', $purpose_id);
					$this->db->where('category_id', $category_id);
					$res = $this->db->update('franchise_category_commision_slab_master',$catdata);
				}else{					
					$res = $this->db->insert('franchise_category_commision_slab_master',$catdata);
				}			
			}
			
			
			if ($res) {
				
				$redirect_url = base_url().'settings/viewnewfranchise?id='.$module;
				$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";			
			
				echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . $url));

				/* echo json_encode(array('status' => 'Success', 'message' =>
						$this->lang->line('UPDATED'))); */
			}else{
				echo json_encode(array('status' => 'Error', 'message' =>
						$this->lang->line('ERROR')));
			}
	}
	
	public function update_commission_edit(){	
		
		$module = $this->input->post('module');
		$cat = $this->input->post('cat');
		$sub_cat = $this->input->post('sub_cat');
		$sub_sub_cat = $this->input->post('sub_sub_cat');
		$purpose = $this->input->post('purpose');
		$retail = $this->input->post('retail');
		$b2c = $this->input->post('b2c');
		$bulk = $this->input->post('bulk');
		$renting = $this->input->post('renting');
		$valid_from = $this->input->post('valid_from');
		$applied = $this->input->post('applied');
		$franchise1[] = 0;
		$franchise2 = $this->input->post('franchise');
		
		if($applied==1){
			$franchise_array = $this->customers->GetFranchisedropdown1();
			foreach($franchise_array as $franchise_data){
				$franchise2[] = 	$franchise_data->id;			
			}		
		}
		
		$franchise = array_merge($franchise1,$franchise2);	

			
			foreach($retail as $key=>$retail_row){
				
				foreach($franchise as $key1=>$franchise_id){
					
					$catdata['retail_commision_percentage'] = numberClean($retail_row);
					$catdata['b2c_comission_percentage'] = numberClean($b2c[$key]);
					$catdata['bulk_commision_percentage'] = numberClean($bulk[$key]);
					$catdata['renting_commision_percentage'] = numberClean($renting[$key]);

					$category_id = $cat[$key];
					if($sub_cat[$key])
					$category_id = $sub_cat[$key];
					if($sub_sub_cat[$key])
					$category_id = $sub_sub_cat[$key];
					
					$purpose_id = $purpose[$key];					
					
					$catdata['category_id'] = $category_id;
					$catdata['franchise_id'] = $franchise_id;
					$catdata['purpose'] =  $purpose_id;
					$catdata['module_id'] = $module;
					$catdata['commission_status'] = 1;
					$catdata['applied']=$applied;
					$catdata['valid_from']=date('Y-m-d',strtotime($valid_from));
					$catdata['date_modified']=date('Y-m-d H:i:s');

					$chk = $this->CHKCatCommission($module,$category_id,$purpose_id,$franchise_id);
					if($chk>0){
						$this->db->where('franchise_id', $franchise_id);
						$this->db->where('module_id', $module);
						$this->db->where('purpose', $purpose_id);
						$this->db->where('category_id', $category_id);
						$res = $this->db->update('franchise_category_commision_slab_master',$catdata);
					}else{					
						$res = $this->db->insert('franchise_category_commision_slab_master',$catdata);
					}
					//echo $this->db->last_query(); exit;
				}				
			}
			
			
			if ($res) {
				
				$redirect_url = base_url().'settings/viewnewfranchise?id='.$module;
				$url = " <a href='" .$redirect_url. "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";			
			
				echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . $url));

				/* echo json_encode(array('status' => 'Success', 'message' =>
						$this->lang->line('UPDATED'))); */
			}else{
				echo json_encode(array('status' => 'Error', 'message' =>
						$this->lang->line('ERROR')));
			}
	}
	

}