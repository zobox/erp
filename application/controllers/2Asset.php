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

class Asset extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
         // $this->load->model('purchase_model', 'purchase');
        $this->load->model('customer_model', 'customer');
        $this->load->model('plugins_model', 'plugins');
        
        $this->load->library("Aauth");
     //   $this->load->library('excel');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('asset_model', 'asset');
        $this->load->model('categories_model');
        $this->load->model('brand_model','brand');
        $this->load->model('conditions_model','conditions');
        $this->load->model('units_model', 'units');
         
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }
    
     public function add()
    {
      $data['cat'] = $this->asset->category_list();
        $data['units'] = $this->asset->units();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $data['brand'] = $this->asset->brand_list();
        
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $data['conditions'] = $this->conditions->conditions_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = "Add Asset";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
         $this->load->view('asset/asset_add', $data);
        $this->load->view('fixed/footer');
    }

  public function add_asset()
    {
        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $catid = end($this->input->post('product_cat'));
        $hsn_code = $this->input->post('hsn_code',true);
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit', true);
        $code_type = $this->input->post('code_type');
        $barcode = $this->input->post('barcode');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $wdate = datefordatabase($this->input->post('wdate'));
        $image = $this->input->post('image');
          
        $v_type = $this->input->post('v_type');        
        $v_stock = $this->input->post('v_stock');
        $v_alert = $this->input->post('v_alert');
        $w_type = $this->input->post('w_type');
        $w_stock = $this->input->post('w_stock');
        $w_alert = $this->input->post('w_alert');
        $product_code = $this->input->post('hsn_code',true);
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $sub_cat = '';
        $serial = '';
        
        $conditions = $this->input->post('conditions');
                
        if ($catid) {
            $this->asset->add_new_asset($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand, $serial,$hsn_code,$product_model,$warehouse_product_name,$warehouse_product_code,$product_specification);
            
            
            //$this->asset->addnew($product_name,$brand,$catid,$hsn_code,$product_model,$warehouse,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_desc,$unit,$code_type,$barcode,$product_qty_alert,$wdate,$image,$v_type,$v_stock,$v_alert,$w_type,$w_stock,$w_alert);
        }
    }

    public function manadd()
    {
        $data['cat'] = $this->categories_model->category_list();
        $data['units'] = $this->asset->units();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $data['brand'] = $this->brand->brand_list();
        
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $data['conditions'] = $this->conditions->conditions_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-add', $data);
        $this->load->view('fixed/footer');
    }

    public function index()
    {
        $head['title'] = "Manage Asset";
        $head['usernm'] = $this->aauth->get_user()->username;
       $this->load->view('fixed/header', $head);       
        $this->load->view('asset/asset_manage');
        $this->load->view('fixed/footer');
    }

     public function asset_order_list()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_order_list');
        $this->load->view('fixed/footer');
    }

     public function ajax_list()
    {

        $list = $this->asset->get_datatables_asset();
        
      
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = '<a href="' . base_url("supplier/view?id=$invoices->supplier_id") . '" target="_blank">'.$invoices->name.'</a>';
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("asset/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("asset/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;
        }
        
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->asset->count_all_asset(),
            "recordsFiltered" => $this->asset->count_filtered_asset(),
            "data" => $data
        );
        
        //output to json format
        echo json_encode($output);

    }

     public function printinvoice()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->asset->purchase_details($tid);
        $data['products'] = $this->asset->purchase_products($tid);
        $data['employee'] = $this->asset->employee($data['invoice']['eid']);
        $data['invoice']['multi'] = 0;

        $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);


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

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }
    public function create_asset()
    {
        


        $common = $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $data['franchies'] = $this->asset->getProductRecords();

        //$data['terms'] = $this->asset->billingterms();
        //$this->load->model('plugins_model', 'plugins');
        $this->load->model('customers_model', 'customers');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->asset->currencies();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->asset->lastpurchase();
        $data['terms'] = $this->asset->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->asset->warehouses();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['taxdetails'] = $this->common->taxdetail();
         
            $this->db->select("a.title,a.id");
            $this->db->from("geopos_warehouse as a");
            $this->db->where("a.cid!=",0);
            $query = $this->db->get(); 

            $results = $query->result_array();
            
            $data['result']=$results;
            
        $head['title'] = "New Purchase";
        
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_create',$data);
        $this->load->view('fixed/footer');
    }
    

    public function asset_list()
    {
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');

        if ($catid > 0) {
            $list = $this->asset->get_asset($catid, '', $sub);
           
        } else {
            $list = $this->asset->get_asset();
        }

        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->id;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline"><img src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span>&nbsp;' . $prd->asset_name . '</a>';
            $row[] = +$prd->qty;
            $row[] = $prd->product_code;
            $row[] = $prd->c_title;
            $row[] = $prd->title;
            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);
            $row[] = '
            <div class="btn-group">
                                    
                                    <div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
            &nbsp;<a href="' . base_url() . 'asset/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->asset->count_all($catid, '', $sub),
            "recordsFiltered" => $this->asset->count_filtered($catid, '', $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
     

    

    public function view_over()
    {
        $pid = $this->input->post('id');
        $this->db->select('tbl_asset.*,geopos_warehouse.title');
        $this->db->from('tbl_asset');
        $this->db->where('tbl_asset.id', $pid);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }

        $query = $this->db->get();
        $data['product'] = $query->row_array();

        $this->db->select('tbl_asset.*,geopos_warehouse.title');
        $this->db->from('tbl_asset');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('tbl_asset.merge', 1);
        $this->db->where('tbl_asset.sub', $pid);
        $query = $this->db->get();
        $data['product_variations'] = $query->result_array();

        $this->db->select('tbl_asset.*,geopos_warehouse.title');
        $this->db->from('tbl_asset');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = tbl_asset.warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
        $this->db->where('tbl_asset.sub', $pid);
        $this->db->where('tbl_asset.merge', 2);
        $query = $this->db->get();
        $data['product_warehouse'] = $query->result_array();

       
        $this->load->view('products/view-over', $data);


    }


      public function edit()
    {

      $common = $this->load->library("Common"); 
        //$data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
         /*$this->db->select("a.title,a.id");
            $this->db->from("geopos_warehouse as a");
            $this->db->where("a.cid!=",0);
            $query = $this->db->get(); 

            $results = $query->result_array();
            
            $data['result']=$results;
            */
        $pid = $this->input->get('id');
        $data['id'] = $tid;
        $this->db->select('*');
        $this->db->from('tbl_asset');
        $this->db->where('id', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
        
        $data['product_category_array'] = array_reverse(explode("-",substr($this->categories_model->getParentcategory($data['product']['pcat']),1)));

        $data['product_category_array_title'] = $this->categories_model->getCategoryNames($data['product_category_array']);
        $data['brand'] = $this->brand->brand_list();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['units'] = $this->asset->units();
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['cat_sub'] = $this->categories_model->sub_cat_curr($data['product']['sub_id']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['product']['pcat']);
        $data['cat'] = $this->categories_model->category_list();
    
      

        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-edit', $data);
        $this->load->view('fixed/footer');

    }
     /* public function asset_order_edit()
    {

      $common = $this->load->library("Common"); 
       $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $pid = $this->input->get('id');
        $data['id'] = $tid;
        $this->db->select('w.*,p.total,p.po_type,c.name as cust_name,s.name as supp_name,s.phone as supp_phone,w.sid,w.cid,s.address as supp_address,c.franchise_code,s.city as supp_city,s.country as supp_country,s.email as supp_email,p.tid as invoice_id,p.refer,p.invoicedate,p.invoiceduedate,p.format_discount,p.notes,p.tax as ptax,p.discount as pdis,p.shipping,p.subtotal as psubtotal,p.term,p.ship_tax,p.ship_tax_type,p.taxstatus');
        $this->db->from('tbl_asset_warehouse as w');
        $this->db->join('tbl_asset_purchase as p',"w.tid=p.id",'inner');
        $this->db->join('geopos_customers as c',"w.cid=c.id",'inner');
        $this->db->join('geopos_supplier as s',"w.sid=s.id",'inner');
        $this->db->where('w.tid', $pid);
       
        $query = $this->db->get();
        

        $data['product'] = $query->result_array();
        
        $data['product_category_array'] = array_reverse(explode("-",substr($this->categories_model->getParentcategory($data['product']['pcat']),1)));
        $data['product_category_array_title'] = $this->categories_model->getCategoryNames($data['product_category_array']);
        $data['brand'] = $this->brand->brand_list();
        $data['warehouse'] = $this->categories_model->warehouse_list2();
        $data['units'] = $this->asset->units();
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['terms'] = $this->asset->billingterms();
        $data['cat_sub'] = $this->categories_model->sub_cat_curr($data['product']['sub_id']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['product']['pcat']);
        $data['cat'] = $this->categories_model->category_list();
        $data['ord_id'] = $pid;

      

        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-order-edit', $data);
        $this->load->view('fixed/footer');

    }

*/

    public function asset_order_edit()
    {
       $common = $this->load->library("Common"); 
       $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));


        $tid = $this->input->get('id');
        $data['id'] = $tid;
          
          $this->db->select('w.*,p.total,p.po_type,c.name as cust_name,s.name as supp_name,s.phone as supp_phone,w.sid,w.cid,s.address as supp_address,c.franchise_code,s.city as supp_city,s.country as supp_country,s.email as supp_email,p.tid as invoice_id,p.refer,p.invoicedate,p.invoiceduedate,p.format_discount,p.notes,p.tax as ptax,p.discount as pdis,p.shipping,p.subtotal as psubtotal,p.term,p.ship_tax,p.ship_tax_type,p.taxstatus,gw.title as warehouse_title');
        $this->db->from('tbl_asset_warehouse as w');
        $this->db->join('tbl_asset_purchase as p',"w.tid=p.id",'inner');
        $this->db->join('geopos_customers as c',"w.cid=c.id",'inner');
        $this->db->join('geopos_warehouse as gw',"w.wid=gw.id",'inner');
        $this->db->join('geopos_supplier as s',"w.sid=s.id",'inner');
        $this->db->where('w.tid', $tid);
       
        $query = $this->db->get();

        $data['product'] = $query->result_array();

 
        $data['title'] = "Purchase Order $tid";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->asset->billingterms();
        $data['invoice'] = $this->asset->purchase_details($tid);
        $data['products'] = $this->asset->purchase_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->asset->warehouses();
        $data['currency'] = $this->asset->currencies();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['product'][0]['taxstatus']);
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-order-edit', $data);
        $this->load->view('fixed/footer');
    
    }

     public function edit_asset()
    {
        $pid = $this->input->post('pid');

        $product_name = $this->input->post('product_name', true);
        $brand = $this->input->post('brand', true);
        $cat = $this->input->post('product_cat');
        $catid = end($cat);
        if($catid == ''){
            array_pop($cat);
            $catid = end($cat);
            if($catid == ''){
                array_pop($cat);
                $catid = end($cat);
            }
            }
        
        $hsn_code = $this->input->post('hsn_code',true);
        $product_code = $this->input->post('hsn_code');
        $product_model = $this->input->post('product_model',true);
        $warehouse = $this->input->post('product_warehouse');
        $warehouse_product_name = $this->input->post('warehouse_product_name',true);
        $warehouse_product_code = $this->input->post('warehouse_product_code',true);
        $product_specification = $this->input->post('product_specification',true);
        $product_desc = $this->input->post('product_desc', true);
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $sub_cat = 0;
        $product_price = '';
        $factoryprice = '';
        $taxrate = '';
        $disrate = '';
        $product_qty = '';
        $image = $this->input->post('image');
        
        
        $vari = array();
        $vari['v_type'] = $this->input->post('v_type');
        $vari['v_stock'] = $this->input->post('v_stock');
        $vari['v_alert'] = $this->input->post('v_alert');
        $vari['w_type'] = $this->input->post('w_type');
        $vari['w_stock'] = $this->input->post('w_stock');
        $vari['w_alert'] = $this->input->post('w_alert');
        $serial = array();
        $serial['new'] = '';
        $serial['old'] = '';

        if ($pid) {
            $this->asset->edit_asset($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat, $brand, $vari, $serial,$warehouse_product_name,$warehouse_product_code,$product_specification,$product_model,$hsn_code);
        }
    }
    
        public function report_asset()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid WHERE geopos_invoice_items.pid='$pid' AND geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid WHERE geopos_purchase_items.pid='$pid' AND geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT rid2 AS qty, DATE(d_time) AS  invoicedate,note FROM geopos_movers  WHERE geopos_movers.d_type='1' AND rid1='$pid'  AND (DATE(d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }

            $this->db->select('*');
            $this->db->from('tbl_asset');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $cat_ware = $this->categories_model->cat_ware($pid, $this->aauth->get_user()->loc);

//if(!$cat_ware) exit();
            $html = $this->load->view('asset/statementpdf-ltr', array('report' => $result, 'product' => $product, 'cat_ware' => $cat_ware, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('tbl_asset');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();
            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('asset/statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }
     

     public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('tbl_asset', array('id' => $id));
                $this->db->delete('tbl_asset', array('sub' => $id, 'merge' => 1));
                $this->db->set('merge', 0);
                $this->db->where('sub', $id);
                $this->db->update('tbl_asset');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

      public function delete_asset_order()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                
                $this->db->delete('tbl_asset_purchase', array('id' => $id));
                $this->db->delete('tbl_asset_warehouse', array('tid' => $id));
                

                //$this->db->update('tbl_asset_purchase');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }






        public function action()
    {
       
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('warehouse_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate'); 
        $cid = intval($this->input->post('franchise_name'));
        $supplier_id = intval($this->input->post('customer_id'));
        $po_type = $this->input->post('po_type');

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
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $supplier_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer,'po_type' => $po_type, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency);

        if ($this->db->insert('tbl_asset_purchase', $data)) {

          
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            
            $warehouse_id = $this->input->post('warehouse_id');
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
                    'wid' => $warehouse_id,
                    'cid' => $cid,
                    'aid' => $product_id[$key],
                    'sid' => $supplier_id,
                    'asset' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'po_type' => $po_type,
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
                        $this->db->where('id', $product_id[$key]);
                        $this->db->update('tbl_asset');
                    }
                    $itc += $amt;
                }

            }
            if ($prodindex > 0) {
                $this->db->insert_batch('tbl_asset_warehouse', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('tbl_asset_purchase');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose asset from asset list. Go to Item manager section if you have not added the asset."));
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


   /*  public function order_asset_update()
    {

        $ord_id = $this->input->post('ord_id');

        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('warehouse_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate'); 
        $cid = intval($this->input->post('franchise_name'));
        $supplier_id = intval($this->input->post('customer_id'));
        $po_type = $this->input->post('po_type');

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
        $data = array('subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'loc' => $this->aauth->get_user()->loc);
            $this->db->where('id',$ord_id);
            $this->db->update('tbl_asset_purchase', $data);
            //echo $this->db->last_query(); die;

        if($ord_id!='')
        {

        $item_id = $this->input->post('asset_ids');
        $product_name1 = $this->input->post('product_name', true);
        $warehouse_id = $this->input->post('warehouse_id');
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

          
         for($i=0;$i<count($product_name1);$i++)
         {
        
             if($item_id[$i]!='')
             {
                $data = array(
                     'asset' => $product_name1[$i],
                     'qty'   => $product_qty[$i],
                     'price' => $product_price[$i],
                     'discount' => $ptotal_disc[$i],
                     'totaltax' => $ptotal_tax[$i],
                     'subtotal' => $product_subtotal[$i],
                     'aid'      => $product_id[$i],
                     'product_des' => $product_des[$i]
                );


                $this->db->where("id",$item_id[$i]);
                $this->db->update("tbl_asset_warehouse",$data);
             }
             else
             {
                $total_discount += numberClean(@$ptotal_disc[$i]);
                $total_tax += numberClean($ptotal_tax[$i]);
                 $data = array(
                     'tid' => $ord_id,
                     'wid' => $warehouse_id,
                     'cid' => $cid,
                     'aid' => $product_id[$i],
                     'sid' => $supplier_id,                    
                     'asset' => $product_name1[$i],
                     'qty'   => $product_qty[$i],
                     'price' => $product_price[$i],
                     'discount' => $ptotal_disc[$i],

                     'tax' => numberClean($product_tax),
                    'discount' => numberClean($product_discount[$i]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$i], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$i], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$i], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$i],
                    'po_type' => $po_type,
                    'unit' => $product_unit[$i]
                );


                 $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$i]);

                if ($product_id[$i] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('id', $product_id[$i]);
                        $this->db->update('tbl_asset');
                    }
                    $itc += $amt;
                }


             }

            

         } 
         
        
          
         if ($prodindex > 0) {
                $this->db->insert_batch('tbl_asset_warehouse', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $ord_id);
                $this->db->update('tbl_asset_purchase');

            } 
 
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view?id=$ord_id' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>" . $this->lang->line('View') . " </a>"));
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
    */

    

    public function order_asset_update()
    {
        $currency = $this->input->post('mcurrency');
        //$customer_id = $this->input->post('customer_id');
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
        $cid = intval($this->input->post('franchise_name'));
        $supplier_id = intval($this->input->post('customer_id'));
        $warehouse_id = $this->input->post('warehouse_id');
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;

        $itc = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($supplier_id == 0) {
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

        $this->db->delete('tbl_asset_warehouse', array('tid' => $invocieno));
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
        $po_type = $this->input->post('po_type');

        foreach ($pid as $key => $value) {
            $total_discount += numberClean(@$ptotal_disc[$key]);
            $total_tax += numberClean($ptotal_tax[$key]);
            $data = array(
                'tid' => $invocieno,
                'aid' => $product_id[$key],
                'wid' => $warehouse_id,
                'asset' => $product_name1[$key],
                'sid' => $supplier_id,
                'cid' => $cid,
                'code' => $product_hsn[$key],
                'qty' => numberClean($product_qty[$key]),
                'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                'tax' => numberClean($product_tax[$key]),
                'discount' => numberClean($product_discount[$key]),
                'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                'product_des' => $product_des[$key],
                'po_type' => $po_type,
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
                $this->db->update('tbl_asset');
            }
            $flag = true;
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $total_discount = rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc);
        $total_tax = rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc);

        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $supplier_id, 'items' => $itc, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat,'po_type' => $po_type, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
        $this->db->set($data);
        $this->db->where('id', $invocieno);

        if ($flag) {

            if ($this->db->update('tbl_asset_purchase', $data)) {
                $this->db->insert_batch('tbl_asset_warehouse', $productlist);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Asset order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> View </a> "));
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
                        $this->db->update('tbl_asset');
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







    public function view()
    {
        $this->load->model('accounts_model');

        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->asset->purchase_details($tid);
        $data['products'] = $this->asset->purchase_products($tid);
        $data['activity'] = $this->asset->purchase_transactions($tid);
        $data['attach'] = $this->asset->attach($tid);
        $data['employee'] = $this->asset->employee($data['invoice']['eid']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('asset/view', $data);
        $this->load->view('fixed/footer');

    }


    public function getProductRecords(){            
            $records = $this->asset->getProductRecords();
            echo json_encode($records);
        }
             

         public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('tbl_asset_purchase');

        echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));
    }


    public function printorder()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
           

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->asset->purchase_details($tid);
            $data['products'] = $this->asset->purchase_products($tid);
            $data['employee'] = $this->asset->employee($data['invoice']['eid']);
            $data['round_off'] = $this->custom->api_config(4);
            $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);
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
                $pdf = $this->pdf->load_split(array('margin_top' => 60));
                $pdf->SetHTMLHeader($header);
            }
            if (INVV == 2) {
                $pdf = $this->pdf->load_split(array('margin_top' => 5));
            }
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Purchase_#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Purchase_#' . $tid . '.pdf', 'I');
            }


        }

    }    

    public function purchase()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');
        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));
        if (hash_equals($token, $validtoken)) {
            
            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['attach'] = $this->asset->attach($tid);
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $data['invoice'] = $this->asset->purchase_details($tid);
            // $data['online_pay'] = $this->purchase->online_pay_settings();
            $data['products'] = $this->asset->purchase_products($tid);
            $data['activity'] = $this->asset->purchase_transactions($tid);
            $head['title'] = "Purchase " . $data['invoice']['tid'];
            $data['employee'] = $this->asset->employee($data['invoice']['eid']);
            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/purchase', $data);
            $this->load->view('billing/footer');
        }
    }
 public function update_order_status()
    { 

       $status  = $this->input->post('status');
       $id  = $this->input->post('id');
       echo $this->asset->updatestatus($status,$id);
    }

    public function assetbrand()
    {
        $data['brand'] = $this->asset->getBrand();
        $head['title'] = "Asset Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-brand', $data);
        $this->load->view('fixed/footer');
    }   
    public function asset_brand_add()
    {
        $data['cat'] = $this->brand->brand_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Asset Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/assetbrandadd', $data);
        $this->load->view('fixed/footer');
    }
    public function assetcategory()
    {
        $data['cat'] = $this->asset->category_stock();
        $head['title'] = "Asset Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-category',$data);
        $this->load->view('fixed/footer');
    }
    public function addasset_category()
    {
       // $data['cat'] = $this->products_cat->category_list();
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Asset Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function addasset_sub_category()
    {
        //$data['cat'] = $this->products_cat->category_list();
        $data['cat'] = $this->asset->category_list_dropdown();		
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = "Add Asset Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_category_add_sub', $data);
        $this->load->view('fixed/footer');
    }

     public function addbrand()
    {
        $brand_name = $this->input->post('name', true);
        $brand_desc = $this->input->post('desc', true);       
        if ($brand_name) {
            $this->asset->addnewbrand($brand_name, $brand_desc);
        }
    }

     public function brand_edit()
    {   
        $id = $this->input->get('id');
       
        $data['result'] = $this->asset->getBrandById($id);

        $head['title'] = "Edit Asset Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_brand_edit', $data);
        $this->load->view('fixed/footer');
    }

    public function asset_brand_update()
    {   
        $id = $this->input->post('brand_id');
        $brand_name = $this->input->post('name');
        $brand_desc = $this->input->post('desc');


        $this->asset->brandedit($id,$brand_name,$brand_desc);
        
        $head['title'] = "Edit Asset Brand";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset_brand_edit', $data);
        $this->load->view('fixed/footer');
    }


      public function asset_brand_delete()
    {
        if ($this->aauth->premission(11)) {
            $id = intval($this->input->post('deleteid'));
            if ($id) {

                

                $this->db->delete('tbl_asset', array('pcat' => $id));
                $this->db->delete('tbl_asset_brand', array('id' => $id));
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function add_asset_cat()
    {        
        $cat_name = $this->input->post('product_catname', true);
        $cat_desc = $this->input->post('product_catdesc', true);
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        if ($cat_name) {
            $this->asset->addnewCategory($cat_name, $cat_desc, $cat_type, $cat_rel);
        }
    }

      public function category_view()
    {
        $data['id'] = $this->input->get('id');
        $data['sub'] = $this->input->get('sub');
        $data['cat'] = $this->asset->category_sub_stock($data['id']);
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-category', $data);
        $this->load->view('fixed/footer');
    }


    public function category_edit()
    {
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('tbl_asset_cat');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['productcat'] = $query->row_array();
        $data['cat'] = $this->asset->category_list();

        $head['title'] = "Edit Asset Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('asset/asset-cat-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editcat()
    {
        $cid = $this->input->post('catid');
        $product_cat_name = $this->input->post('product_cat_name');
        $product_cat_desc = $this->input->post('product_cat_desc');
        $cat_type = $this->input->post('cat_type', true);
        $cat_rel = $this->input->post('cat_rel', true);
        $old_cat_type = $this->input->post('old_cat_type', true);
        if ($cid) {
            $this->asset->asset_cat_edit($cid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel, $old_cat_type);
        }
    }


    public function asset_cat_delete()
    {
        if ($this->aauth->premission(11)) {
            $id = intval($this->input->post('deleteid'));
            if ($id) {

                $query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN tbl_asset ON  geopos_movers.rid1=tbl_asset.id LEFT JOIN geopos_product_cat ON  tbl_asset.pcat=tbl_asset_cat.id WHERE tbl_asset_cat.id='$id' AND  geopos_movers.d_type='1'");

                $this->db->delete('tbl_asset', array('pcat' => $id));
                $this->db->delete('tbl_asset_cat', array('id' => $id));
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


     public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));
        $sub_date = $this->input->post('sub');
        $filter = 'pcat';
        if ($sub_date) $filter = 'sub_id';

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON tbl_asset.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN tbl_asset ON tbl_asset.id=geopos_invoice_items.pid  LEFT JOIN tbl_asset_cat ON tbl_asset_cat.id=tbl_asset.$filter  $qj WHERE geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND tbl_asset.$filter='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN tbl_asset ON tbl_asset.id=geopos_purchase_items.pid  LEFT JOIN tbl_asset_cat ON tbl_asset_cat.id=tbl_asset.$filter  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND tbl_asset.$filter='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,tbl_asset.product_price AS price,tbl_asset.product_name   FROM geopos_movers LEFT JOIN tbl_asset ON tbl_asset.id=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND tbl_asset.$filter='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }
            $this->db->select('*');
            $this->db->from('tbl_asset_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/cat_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $sub = $this->input->get('sub');
            $this->db->select('*');
            $this->db->from('tbl_asset_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/cat_statement', array('id' => $pid, 'product' => $product, 'sub' => $sub));
            $this->load->view('fixed/footer');
        }
    }
     

     public function subCatDropdownHtml($ProductCategoryId=''){
        if($ProductCategoryId == ''){
            $ProductCategoryId = $this->input->post('id',true);
        }
        $result = $this->asset->category_list_dropdown(1, $ProductCategoryId);
        if($result != false){
            //$html =  "<option value='' selected='' disabled=''> --- Select --- </option>";
            foreach($result as $row){
                $html .= "<option value='".$row->id."'>".$row->title."</option>";
                //$html .=  $this->subCatDropdownHtml($row->id);
            }
            echo $html;
        }
        return 0;
    }

}

