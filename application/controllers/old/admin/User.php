<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
		$data['pageName']					=	'User List';
		$data['pageSlug_url']				=	base_url('admin/user');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'User';
		$data['pageSlug_two_url']			=	base_url('admin/user');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
		//Get Data
		$data['users'] 						=	$this->site->getUsers();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/user',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function view($value='')
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		$id 								=	$value;
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/user');
		}else{
			// Header Value
			$data['pageName']					=	'User Data';
			$data['pageSlug_url']				=	base_url('admin/user');
			$data['pageSlug_one']				=	'Home';
			$data['pageSlug_one_url']			=	base_url('admin/dashboard');
			$data['pageSlug_two']				=	'User';
			$data['pageSlug_two_url']			=	base_url('admin/user');
			$data['pageSlug_three']				=	'User Data';
			$data['pageSlug_three_url']			=	base_url('admin/user');
			//Get Data
			$this->db->join('tbl_location l','l.fld_id=u.fld_location_id','inner');
			$data['now'] 						=	$this->db->where('u.fld_id',$id)->select('u.*,l.fld_name As l_name')->get('tbl_user u')->row();
			// View Files
			$this->load->view('admin/include/header',$data);
			$this->load->view('admin/include/sidebar',$data);
			$this->load->view('admin/userView',$data);
			$this->load->view('admin/include/footer',$data);
		}
	}
	public function delete($value='')
	{
		$id 								=	$value;
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/user');
		}else{
			$this->db->where('fld_id',$id);
			if( $this->db->delete('tbl_user') ){
				$this->session->set_userdata('success-msg', 'Successfully delete user data from database! ');
				redirect('admin/user');
			}else{
				$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
				redirect('admin/user');	
			}
		}
	}
}
?>