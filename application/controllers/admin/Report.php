<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
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
		// Header Value
		$data['pageName']					=	'User Report';
		$data['pageSlug_url']				=	base_url('admin/user');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'User Report';
		$data['pageSlug_two_url']			=	base_url('admin/report');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
		//Get Data
		$data['users'] 						=	$this->db->get('tbl_user u')->result();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/report',$data);
		$this->load->view('admin/include/footer',$data);
	}
}
?>