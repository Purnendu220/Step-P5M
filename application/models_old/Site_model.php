<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Site_model extends CI_Model {
	
    public function __construct(){
        parent::__construct();
    }
    public function checkisther($postData)
    {
    	foreach ($postData as $key => $value) {
			$key  						= 	strip_tags($key);
			$value  					= 	strip_tags($value);
			$postData[$key]				=	$value;
		}
		if( $postData['email'] != '' && $postData['password'] != '' ){
			$this->db->select('*');
			$this->db->from('tbl_admin');
			$this->db->where('fld_email',$postData['email']);
			$this->db->where('fld_password',md5('steps'.$postData['password']));
			$this->db->where('fld_status','1');
			$query = $this->db->get();
			$isther = $query->result();			
			return  $isther;
		}else{
			return 0;
		}
    }
}