<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model','site');
    }
	public function index()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if( isset($is_logged_in) && $is_logged_in->login == 'true' ){
			redirect('admin/dashboard', 'refresh');
		}
		$this->load->view('admin/login');
	}
	public function checkLogin(){
		$postData						=	$this->input->post();
		foreach ($postData as $key => $value) {
			$key  						= 	strip_tags($key);
			$value  					= 	strip_tags($value);
			$postData[$key]				=	$value;
		}
		if( $postData['email'] != '' && $postData['password'] != '' ){
			$isther 					=	$this->site->checkisther( $postData );
			$isther						=	$isther[0];			
			if( $isther != '0' ){
				if( @$isther->fld_id != '' ){
					$isther->login	=	'true';
					$this->session->set_userdata('is_logged_in',$isther);
					echo "true";
				}else{
					echo "false";
				}
			}else{
				echo "false";
			}
		}else{
			echo "0";
		}
	}
	public function logout()
	{
		$this->session->set_userdata('is_logged_in','');
		session_destroy();
		redirect('admin/login', 'refresh');		
	}
}
