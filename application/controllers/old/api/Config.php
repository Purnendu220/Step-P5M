<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {	
	public function __construct(){
        parent::__construct();
        $this->load->library('rest');
        $this->token_key 					=		'setps';
    }
    public function getLocation( $val = '1' )
    {
    	$location = $this->db->where('fld_status','1')->get('tbl_location')->result();
    	$return 									=	array();
		$return['status']							=	'200';
		if( $val == '1' ){
				$return['msg']						=	'Successful execute the api request';
		}else{
				$return['msg']						=	'Successful execute the api request';
		}
    	$i = 0;
    	foreach ($location as $key => $value) {
    		$return['data'][$i]['fld_id']				=		$value->fld_id;
    		if( $val == '1' ){
    				$return['data'][$i]['fld_name']				=		$value->fld_name;
    		}else{
    				$return['data'][$i]['fld_name']				=		$value->fld_name_ar;
    		}
    		$i++;
    	}
    	$this->rest->response(json_encode($return), 200);exit;
    }
    public function getInfoSlug( $val = '1' )
    {
    	if( $this->rest->get_request_method() != 'POST' ){
			$return 						=		array();
			$return['status']				=		'401';
			if( $val == '1' ){
				$return['msg']				=		'Invalid Request Type';
			}else{
				$return['msg']				=		'Invalid Request Type';				
			}
		}else{
			$params 						=		(array)json_decode($this->rest->_request);			
			if( !empty( $params ) ){				
				if( @$params['slug'] != '' ){
					$infoHead = $this->db->where('fld_slug',$params['slug'])->get('tbl_info')->row();
					if( @$infoHead->fld_slug != "" ){
						$return 						=		array();
						$return['status']				=		'200';
						if( $val == '1' ){
								$return['msg']			=		'Successful execute the api request';
						}else{
								$return['msg']			=		'Successful execute the api request';
						}
						$return['data'][0]['fld_title']			=		$infoHead->fld_title;
						$return['data'][0]['fld_details']		=		$infoHead->fld_details;
					}else{
						$return 						=		array();
						$return['status']				=		'404';
						if( $val == '1' ){
							$return['msg']				=		'Server error was found, Please try again later!';
						}else{
							$return['msg']				=		'Server error was found, Please try again later!';				
						}
					}
				}else{
					$return 						=		array();
					$return['status']				=		'402';
					if( $val == '1' ){
						$return['msg']				=		'Invalid Json format';
					}else{
						$return['msg']				=		'Invalid Json format';				
					}
				}
			}else{
				$return 						=		array();
				$return['status']				=		'401';
				if( $val == '1' ){
					$return['msg']				=		'Invalid Request Type';
				}else{
					$return['msg']				=		'Invalid Request Type';				
				}
			}
    	}
    	$this->rest->response(json_encode($return), 200);exit;
	}
	public function getInfoList( $val = '1' )
	{
		$info = $this->db->where('fld_slug',NULL)->where('fld_status','1')->get('tbl_info')->result();
		$return 									=	array();
		$return['status']							=	'200';
		if( $val == '1' ){
				$return['msg']						=	'Successful execute the api request';
		}else{
				$return['msg']						=	'Successful execute the api request';
		}
		$i = 0;
		foreach ($info as $key => $value) {
			$return['data'][$i]['fld_title']					=		$value->fld_title;
			$return['data'][$i]['fld_details']					=		$value->fld_details;
			$return['data'][$i]['fld_image']					=		base_url().'upload/info/'.$value->fld_image;
			$i++;
		}
		$this->rest->response(json_encode($return), 200);exit;
	}
}
?>
