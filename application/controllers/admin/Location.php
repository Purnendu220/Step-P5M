<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
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
		$data['pageName']					=	'Location List';
		$data['pageSlug_url']				=	base_url('admin/info');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'Location';
		$data['pageSlug_two_url']			=	base_url('admin/info');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
		//Get Data
		$data['location'] 						=	$this->site->getLocation();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/location',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function addNew()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		// Header Value
		$data['pageName']					=	'Add New Location';
		$data['pageSlug_url']				=	base_url('admin/info');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'Location';
		$data['pageSlug_two_url']			=	base_url('admin/location');
		$data['pageSlug_three']				=	'Add New Location';
		$data['pageSlug_three_url']			=	base_url('admin/location');
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/addLocation',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function edit( $id = '' )
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/location');
		}
		// Header Value
		$data['pageName']					=	'Edit Location';
		$data['pageSlug_url']				=	base_url('admin/location');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'Location';
		$data['pageSlug_two_url']			=	base_url('admin/location');
		$data['pageSlug_three']				=	'Edit Location';
		$data['pageSlug_three_url']			=	base_url('admin/location');
		// Data From Database
		$data['now']						=	$this->db->where('fld_id',$id)->get('tbl_location')->row();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/editLocation',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function saveNew()
	{
		//Post Data from form
		$postData 							=	$this->input->post();
		if( $postData['fld_name'] != '' && $postData['fld_name_ar'] != '' && $postData['fld_status'] != '' ){
			$newData							=	array();				
			$newData['fld_name']				=	$postData['fld_name'];
			$newData['fld_name_ar']				=	$postData['fld_name_ar'];
			$newData['fld_status']				=	$postData['fld_status'];
			if( $this->db->insert('tbl_location',$newData) ){
				$this->session->set_userdata('success-msg', 'Successfully added the Location');
				redirect('admin/location');
			}else{
				$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
				redirect('admin/location');
			}
		}else{
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/location');
		}
	}
	public function saveold($id='')
	{
		if ( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/location');
		}else{
			$postData 								=	$this->input->post();
			if( $postData['fld_name'] != '' && $postData['fld_name_ar'] != '' && $postData['fld_status'] != '' ){
				$postData 							=	$this->input->post();		
				$newData							=	array();		
				$newData['fld_name']				=	$postData['fld_name'];
				$newData['fld_name_ar']				=	$postData['fld_name_ar'];
				$newData['fld_status']				=	$postData['fld_status'];
				$this->db->where('fld_id',$id);
				if( $this->db->update('tbl_location',$newData) ){
					$this->session->set_userdata('success-msg', 'Successfully update the Location details');
					redirect('admin/location');
				}else{
					//echo "2";exit;
					$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
					redirect('admin/location');
				}
			}else{
				//echo "3";exit;
				$this->session->set_userdata('error-msg', "Request Filed con't be null" );
				redirect('admin/location');
			}

		}
	}
	public function delete($value='')
	{
		$id 								=	$value;
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/location');
		}else{
			$this->db->where('fld_id',$id);
			if( $this->db->delete('tbl_location') ){
				$this->session->set_userdata('success-msg', 'Successfully delete Location  from database! ');
				redirect('admin/location');
			}else{
				$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
				redirect('admin/location');	
			}
		}
	}
}?>