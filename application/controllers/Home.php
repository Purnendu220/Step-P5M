<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		redirect('admin', 'refresh');
		//$this->load->view('front/home');
	}
}
