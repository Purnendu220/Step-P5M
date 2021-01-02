<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSession extends CI_Controller {	
	public function __construct(){
        parent::__construct();
        $this->load->library('rest');
        $this->token_key 					=		'setps';
    }
	public function createNewSession( $val = '1' )
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
						if( $isthere->fld_current_session_id != '' ){
							$this->db->where('fld_session_id',$isthere->fld_current_session_id);
							$sesstionData = $this->db->get('tbl_user_steps')->row();
							$newUserTime 						= 		addTwotIme($isthere->fld_total_time,$sesstionData->fld_total_time);
							$total_TimeMinit					=		gettotalTimeMinit($newUserTime);
							$oneSurgerieTime 					=		getTimeFromSurgerie();
							$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
							$newUserData						=		array();
							$newUserData['fld_total_time']		=		$newUserTime;
							$newUserData['fld_total_surgery']	=		$totalSurgeries;
							$newUserData['fld_current_session_id']	=		'';
							$this->db->where('fld_id',$isthere->fld_id);
							$this->db->update('tbl_user',$newUserData);
							$this->db->where('fld_token',$params['token']);
							$isthere 				= 		$this->db->get('tbl_user')->row();
						}

						$completeAry					=		array();
						$completeAry['fld_status'] 		=		'0';
						$this->db->where('fld_user_id',$isthere->fld_id);
						$this->db->update('tbl_session',$completeAry);

						$project_Status 				=		checkProjectStatus();

						$session_id 					=		md5($isthere->fld_id.time());
						$sessionData 					=		array();
						$sessionData['fld_user_id']		=		$isthere->fld_id;
						$sessionData['fld_session_code']=		$session_id;
						$sessionData['fld_starting_date']=		date("Y-m-d H:i:s");
						$sessionData['fld_end_date']	=		date("Y-m-d H:i:s");
						$sessionData['fld_status']		=		'1';						
						if( $this->db->insert('tbl_session',$sessionData) ){
							$userStep							=		array();
							$userStep['fld_session_id']			=		$sessionData['fld_session_code'];
							$userStep['fld_user_id']			=		$isthere->fld_id;
							$userStep['fld_total_time']			=		'00:00:00';	
							$userStep['fld_created_date']		=		$sessionData['fld_starting_date'];
							$userStep['fld_update_date']		=		$sessionData['fld_end_date'];	
							$this->db->insert('tbl_user_steps',$userStep);
							$userData 							=		array();
							$userData['fld_current_session_id']	=		$sessionData['fld_session_code'];
							$this->db->where('fld_id',$isthere->fld_id);
							$this->db->update('tbl_user',$userData);
							$userData 							=		array();

							$return 					=		array();
							$return['status']			=		'200';
							if( $val == '1' ){
									$return['msg']				=		'Successful execute the api request';
							}else{
									$return['msg']				=		'Successful execute the api request';
							}
							$return['project_status']					=		$project_Status;
							$return['data']['token']					=		$params['token'];
							$return['data']['session_code']				=		$session_id;
							$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
							$return['data']['your_total_time']			=		$isthere->fld_total_time;

							$totalArray  						= 		getTotalTimeArray();
							$total_time 						= 		getTotalTime( $totalArray );
							$total_TimeMinit					=		gettotalTimeMinit($total_time);
							$oneSurgerieTime 					=		getTimeFromSurgerie();
							$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
							$return['data']['total_surgeries']	=		$totalSurgeries;
							$return['data']['session_time']		=		'00:00:00';
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
	public function updateSessionData( $val = '1' )
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
				if( @$params['token'] != '' && @$params['session_code'] != ''  && @$params['time'] != ''  ){ 
					$this->db->where('fld_token',$params['token']);
					$isthere 				= 		$this->db->get('tbl_user')->row();
					if( @$isthere->fld_id != "" ){
						$yourTimeNot 			=	$isthere->fld_total_time;

						$this->db->where('fld_session_code',$params['session_code']);
						$this->db->where('fld_user_id',$isthere->fld_id);
						$sessiondata 	=	$this->db->order_by('fld_id','DESC')->get('tbl_session')->row();
						if( $sessiondata->fld_id != "" ){
							if( $sessiondata->fld_status != "0"){
								$userStep 						=		array();
								$userStep['fld_total_time']		=		$params['time'];
								$userStep['fld_update_date']	=		date("Y-m-d H:i:s");
								$this->db->where('fld_session_id',$params['session_code']);
								$this->db->where('fld_user_id',$isthere->fld_id);
								if( $this->db->update('tbl_user_steps',$userStep) ){
									// $newUserTime 						= 		addTwotIme($yourTimeNot,$params['time']);
									// $total_TimeMinit					=		gettotalTimeMinit($newUserTime);
									// $oneSurgerieTime 					=		getTimeFromSurgerie();
									// $totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
									// $newUserData						=		array();
									// $newUserData['fld_total_time']		=		$newUserTime;
									// $newUserData['fld_total_surgery']	=		$totalSurgeries;
									// $this->db->where('fld_id',$isthere->fld_id);
									// $this->db->update('tbl_user',$newUserData);

									$return 					=		array();
									$return['status']			=		'200';
									if( $val == '1' ){
											$return['msg']				=		'Successfully logged';
									}else{
											$return['msg']				=		'Successfully logged';
									}
									$project_Status 							=		checkProjectStatus();
									$return['project_status']					=		$project_Status;
									$return['data']['token']					=		$params['token'];
									$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
									$return['data']['your_total_time']			=		$isthere->fld_total_time;
									$totalArray  						= 		getTotalTimeArray();
									$total_time 						= 		getTotalTime( $totalArray );
									$total_TimeMinit					=		gettotalTimeMinit($total_time);
									$oneSurgerieTime 					=		getTimeFromSurgerie();
									$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
									$return['data']['total_surgeries']	=		$totalSurgeries;
									$return['data']['session_code']		=		$params['session_code'];
									$return['data']['session_time']		=		$params['time'];
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
								$return['status']				=		'406';
								if( $val == '1' ){
									$return['msg']				=		'This session code data is completed , please create a new session';
								}else{
									$return['msg']				=		'This session code data is completed , please create a new session';				
								}
							}
						}else{
							$return['status']				=		'405';
							if( $val == '1' ){
								$return['msg']				=		'Session code not found in our database';
							}else{
								$return['msg']				=		'Session code found in our database';				
							}
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
}
?>