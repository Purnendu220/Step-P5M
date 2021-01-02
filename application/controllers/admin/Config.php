<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
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
		$data['pageName']					=	'Config Data';
		$data['pageSlug_url']				=	base_url('admin/user');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'Config Data';
		$data['pageSlug_two_url']			=	base_url('admin/user');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
		//Get Data
		$data['config'] 					=	$this->db->get('tbl_config')->result();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/config',$data);
		$this->load->view('admin/include/footer',$data);
    }
	public function updateStatus( $id = '' )
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/config');
		}
		if($id == 'RUN'){
                $newData['fld_value']				=	'COMPLETE';
				$this->db->where('fld_slug','session_complete');
				if( $this->db->update('tbl_config',$newData) ){
					$this->session->set_userdata('success-msg', 'Successfully update the SESSION COMPLETE STATUS');
					redirect('admin/config');
				}else{
					//echo "2";exit;
					$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
					redirect('admin/config');
				}
		}
		else{
   $newData['fld_value']				=	'RUN';
				$this->db->where('fld_slug','session_complete');
				if( $this->db->update('tbl_config',$newData) ){
					$this->session->set_userdata('success-msg', 'Successfully update the SESSION COMPLETE STATUS');
					redirect('admin/config');
				}else{
					//echo "2";exit;
					$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
					redirect('admin/config');
				}
		}
		redirect('admin/config');
	}
	public function updateOption( $id = '' )
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/config');
		}
		if($id == 'A'){
                $newData['fld_option']				=	'B';
				$this->db->where('fld_slug','session_complete');
				if( $this->db->update('tbl_config',$newData) ){
					$this->session->set_userdata('success-msg', 'Successfully update the SESSION COMPLETE OPTION');
					redirect('admin/config');
				}else{
					//echo "2";exit;
					$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
					redirect('admin/config');
				}
		}
		else{
   $newData['fld_option']				=	'A';
				$this->db->where('fld_slug','session_complete');
				if( $this->db->update('tbl_config',$newData) ){
					$this->session->set_userdata('success-msg', 'Successfully update the SESSION COMPLETE OPTION');
					redirect('admin/config');
				}else{
					//echo "2";exit;
					$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
					redirect('admin/config');
				}
		}
		redirect('admin/config');
	}
}