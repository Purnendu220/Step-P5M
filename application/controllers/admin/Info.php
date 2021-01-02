<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {
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
		$data['pageName']					=	'info';
		$data['pageSlug_url']				=	base_url('admin/info');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'info';
		$data['pageSlug_two_url']			=	base_url('admin/info');
		$data['pageSlug_three']				=	'';
		$data['pageSlug_three_url']			=	'';
		//Get Data
		$data['info'] 						=	$this->site->getInfo();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/info',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function addNew()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( !isset($is_logged_in) && !$is_logged_in->login == 'true' ){
			redirect('admin/login', 'refresh');
		}
		// Header Value
		$data['pageName']					=	'info';
		$data['pageSlug_url']				=	base_url('admin/info');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'info';
		$data['pageSlug_two_url']			=	base_url('admin/info');
		$data['pageSlug_three']				=	'Add New Info';
		$data['pageSlug_three_url']			=	base_url('admin/info');
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/addinfo',$data);
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
			redirect('admin/info');
		}
		// Header Value
		$data['pageName']					=	'info';
		$data['pageSlug_url']				=	base_url('admin/info');
		$data['pageSlug_one']				=	'Home';
		$data['pageSlug_one_url']			=	base_url('admin/dashboard');
		$data['pageSlug_two']				=	'info';
		$data['pageSlug_two_url']			=	base_url('admin/info');
		$data['pageSlug_three']				=	'Edit Info';
		$data['pageSlug_three_url']			=	base_url('admin/info');
		// Data From Database
		$data['now']						=	$this->db->where('fld_id',$id)->get('tbl_info')->row();
		// View Files
		$this->load->view('admin/include/header',$data);
		$this->load->view('admin/include/sidebar',$data);
		$this->load->view('admin/editinfo',$data);
		$this->load->view('admin/include/footer',$data);
	}
	public function saveNew()
	{
		//Post Data from form
		$postData 							=	$this->input->post();
		
		$newData							=	array();
		if( @$_FILES['fld_image']['name'] != '' ){
			$image 							= 	$this->imageUpload();
			$newData['fld_image']			=	$image;
		}
		
		$newData['fld_title']				=	$postData['fld_title'];
		$newData['fld_details']				=	$postData['fld_details'];
		$newData['fld_status']				=	$postData['fld_status'];
		if( $this->db->insert('tbl_info',$newData) ){
			$this->session->set_userdata('success-msg', 'Successfully added the info details');
			redirect('admin/info');
		}else{
			$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
			redirect('admin/info');
		}
	}
	public function saveold($id='')
	{
		if ( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/info');
		}else{
			$postData 							=	$this->input->post();		
			$newData							=	array();
			if( @$_FILES['fld_image']['name'] != '' ){
				$image 							= 	$this->imageUpload();
				$newData['fld_image']			=	$image;
			}			
			$newData['fld_title']				=	$postData['fld_title'];
			$newData['fld_details']				=	$postData['fld_details'];
			$newData['fld_status']				=	$postData['fld_status'];
			$this->db->where('fld_id',$id);
			if( $this->db->update('tbl_info',$newData) ){
			$this->session->set_userdata('success-msg', 'Successfully update the info details');
			redirect('admin/info');
		}else{
			$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
			redirect('admin/info');
		}

		}
	}
	public function delete($value='')
	{
		$id 								=	$value;
		if( $id == '' ){
			$this->session->set_userdata('error-msg', "Request Filed con't be null" );
			redirect('admin/info');
		}else{
			$this->db->where('fld_id',$id);
			if( $this->db->delete('tbl_info') ){
				$this->session->set_userdata('success-msg', 'Successfully delete info data from database! ');
				redirect('admin/info');
			}else{
				$this->session->set_userdata('error-msg', 'Error was found, please try again later' );
				redirect('admin/info');	
			}
		}
	}
	private function imageUpload(){
		$target_path 						= 	FCPATH."/upload/info/"; 
		$filename 							= 	@basename($_FILES['fld_image']['name']);
		$ext 								= 	@end(explode('.', $filename));
		$ext 								= 	@strtolower($ext);
		$image 								= 	md5(rand() * time()).'.'.$ext;
		move_uploaded_file($_FILES['fld_image']['tmp_name'],  $target_path.$image);
		return $image;
    } 
}