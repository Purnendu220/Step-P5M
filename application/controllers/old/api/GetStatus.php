<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetStatus extends CI_Controller {	
	public function __construct(){
        parent::__construct();
        $this->load->library('rest');
        $this->token_key 					=		'setps';
    }
    public function index( $val = '1' )
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
				if( @$params['token'] != '' ){
					$this->db->where('fld_token',$params['token']);
					$isthere 				= 		$this->db->get('tbl_user')->row();
					if( @$isthere->fld_id != "" ){
						$totalArray  						= 		getTotalTimeArray();
						$total_time 						= 		getTotalTime( $totalArray );
						$total_TimeMinit					=		gettotalTimeMinit($total_time);
						$oneSurgerieTime 					=		getTimeFromSurgerie();
						$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
						$return 				=		array();
						$return['status']		=		'200';
						if( $val == '1' ){
								$return['msg']			=		'Successful execute the api request';
						}else{
								$return['msg']			=		'Successful execute the api request';
						}
						$return['project_status']					=		checkProjectStatus();;
						$return['data']['token']					=		$params['token'];
						$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
						$return['data']['your_total_time']			=		$isthere->fld_total_time;
						$return['data']['total_surgeries']			=		$totalSurgeries;
					}else{
						$return['status']				=		'404';
						if( $val == '1' ){
							$return['msg']				=		'Token not found in our database';
						}else{
							$return['msg']				=		'Token not found in our database';				
						}
					}
				}else{
					$return['status']				=		'403';
					if( $val == '1' ){
						$return['msg']				=		'Request field cannot be null';
					}else{
						$return['msg']				=		'Request field  cannot be null';				
					}
				}
			}else{
				$return['status']				=		'403';
				if( $val == '1' ){
					$return['msg']				=		'Request field cannot be null';
				}else{
					$return['msg']				=		'Request field  cannot be null';				
				}
			}
		}
		$this->rest->response(json_encode($return), 200);exit; 
    }
}?>