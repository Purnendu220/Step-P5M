<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model','site');
        $data 								=	array();
    }
	public function index()
	{

		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
    if(isset($_GET['mapdate'])){
$mapdate=$_GET['mapdate'];
    }
    else{
$mapdate=date('d-m-Y');

    }
		// Header Value
		$data['pageName']					=	'Map';
		$data['pageSlug_url']				=	base_url('admin/user');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'User Report';
		$data['pageSlug_two_url']			=	base_url('admin/report');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
        $data['latitude']			=	'';
        $data['longitude']			=	'';
         $data['mapdate']			=	$mapdate;
		//Get Data
		$first_date=date('Y-m-d 00:00:00',strtotime($mapdate));
		$second_date=date('Y-m-d 23:59:59',strtotime($mapdate));
		$this->db->where('u.date_added >=', $first_date);
        $this->db->where('u.date_added <=', $second_date);
		$data['locations'] 						=	$this->db->get('tbl_session_locations u ')->result();
		//print_r($data['locations']);die;
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/map',$data);
		$this->load->view('admin/include/footer',$data);
	}
}
?>