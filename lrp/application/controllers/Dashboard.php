<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{
	 public function __construct()
    {
        parent::__construct();
       // $this->load->model('invoices_model', 'invocies');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
		$this->load->model('Dashboard_model','dashboard');
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Dashboard";
		$data['leads_count'] = $this->dashboard->lead_count();
        
        $this->load->view('includes/header',$head);
        $this->load->view('dashboard/index',$data);
        $this->load->view('includes/footer');
    }
	
	public function leadlist(){
		$data = json_decode($this->dashboard->leadlist());
		$html = '';
		$i = 1;
		foreach($data as $row){
			$html .= '<tr>';
			$html .= '<td>'.$i.'</td><td>'.$row->name.'</td><td>'.$row->email.'</td><td>'.$row->contactNo.'</td><td>'.$row->city.'</td><td>'.$row->state.'</td><td>'.$row->pincode.'</td><td>'.$row->shop_type.'</td>';	
			$html .= '</tr>';
			$i++;
		}
		echo $html;
	}
	
}
?>