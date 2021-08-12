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

class Brand_model extends CI_Model
{

    public function brand_list()
    {
        $query = $this->db->query("SELECT * FROM geopos_brand WHERE 1 ORDER BY id DESC");
        return $query->result_array();
    }
	
	public function GetTitleById($id)
    { 		
		$this->db->where("id",$id);		
		$query = $this->db->get("geopos_brand");		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {				
				return $row->title;
			}				
		}
		return false;
    }
    
	
	public function getBrand()
    {
        $query = $this->db->query("SELECT * FROM geopos_brand");
        return $query->result_array();
    }
    

    public function addnew($brand_name, $brand_desc)
    {
        $data = array(
            'title' => $brand_name,
            'extra' => $brand_desc,           
        );

        
        $url = "<a href='" . base_url('productbrand/add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productbrand') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        

        if ($this->db->insert('geopos_brand', $data)) {
            $this->aauth->applog("[Brand Created] $brand_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    

    public function edit($catid, $name, $desc)
    {         
        $data = array(
            'title' => $name,
            'extra' => $desc
        );
        $this->db->set($data);
        $this->db->where('id', $catid);
		$url = "<a href='" . base_url('productbrand/add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productbrand') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        if ($this->db->update('geopos_brand')) {			
            $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'). " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	
	
	public function getBrandById($id='')
    {
        $this->db->where('id', $id);        
        $query = $this->db->get('geopos_brand');
        $data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key=>$row) {							
				$data = $row;
			}			
			return $data;
		}
		return false;
    }

}