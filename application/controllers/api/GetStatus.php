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
						// BY MOHIT $oneSurgerieTime 					=		getTimeFromSurgerie();
						$oneSurgerieTime 					=		getActiveEvent();
						$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
						$return 				=		array();
						$return['status']		=		'200';
						if( $val == '1' ){
								$return['msg']			=		'Successful execute the api request';
						}else{
								$return['msg']			=		'Successful execute the api request';
						}
						$return['project_status']					=		checkProjectStatus();;
						   $return['project_status_option'] 					=		checkProjectStatusOption();

						$return['data']['token']					=		$params['token'];
						$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
						$return['data']['your_total_time']			=		$isthere->fld_total_time;
						if($isthere->fld_my_total_time == ''){
							$fld_my_total_time			=      '0:00:00';
						}else{
							$fld_my_total_time			=      $isthere->fld_my_total_time;
						}
						$return['data']['fld_my_total_time']			=		$fld_my_total_time;
						$return['data']['total_contributions']			=		$totalSurgeries;
						$return['data']['session_time']				=		'0:00:00';
						$return['data']['b_time']					=		get_B_Time($isthere->fld_id);
						
						$this->db->where('event_status','1');
						$isevent				= 		$this->db->get('tbl_events')->row_array();
						if($isevent){
							$return['data']['event'] = $isevent;
							// $return['event']['event_name'] = $isevent->event_name;
							// $return['event']['event_image'] = $isevent->event_image;
							// $return['event']['event_longitude'] = $isevent->event_longitude;
							// $return['event']['event_radius'] = $isevent->event_radius;
							// $return['event']['event_target'] = $isevent->event_target;
							// $return['event']['event_resultValue'] = $isevent->event_resultValue;
							// $return['event']['event_rewardName'] = $isevent->event_rewardName;
							// $return['event']['event_rewardValue'] = $isevent->event_rewardValue;
							// $return['event']['event_creation'] = $isevent->event_creation;
							// $return['event']['event_status'] = $isevent->event_status;
						}else{
							$return['data']['event'] = array();
						}
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