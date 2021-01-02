<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {	
	public function __construct(){
        parent::__construct();
        $this->load->library('rest');
        $this->token_key 					=		'setps';
    }
	public function registertion( $val = '1' )
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
				if( @$params['phone_number'] != '' && @$params['user_name'] != '' && @$params['location'] != '' && @$params['device_id'] != '' && $params['device_type'] != '' ){
						$totalArray  						= 		getTotalTimeArray();
						$total_time 						= 		getTotalTime( $totalArray );
						$total_TimeMinit					=		gettotalTimeMinit($total_time);
						$oneSurgerieTime 					=		getTimeFromSurgerie();
						$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);						
						//$total_time  =  $time;
						//$configData 						=		$this->db->where('fld_slug','session_complete')->select('fld_value')->get('tbl_config')->row();
						$project_Status 					=		checkProjectStatus();
						$newUserData 						=		array();
						$newUserData['fld_name']			=		$params['user_name'];
						$newUserData['fld_phone']			=		$params['phone_number'];
						$newUserData['fld_location_id']		=		$params['location'];
						$newUserData['fld_status']			=		'1';

						$this->db->where('fld_phone',$newUserData['fld_phone']);
						$isther 		=		$this->db->get('tbl_user')->result();
						
						if( count($isther) == 0){
								if( $this->db->insert('tbl_user',$newUserData) ){
									$insert_id 				=		$this->db->insert_id();
									// Token
									$userSession			=		array();
									//echo time().$this->token_key.$insert_id.mt_rand(500, 5000);
									$token					=		md5(time().$this->token_key.$insert_id.mt_rand(500, 5000));
									$userSession['fld_token']	=		$token;
									$this->db->where('fld_id',$insert_id);
									$this->db->update('tbl_user',$userSession);
									// user log
									$userlog['fld_user_id']		=	$insert_id;
									$userlog['fld_user_name']	=	$newUserData['fld_name'];
									$userlog['fld_user_location']	=	$newUserData['fld_location_id'];
									$userlog['fld_device_id']	=	$params['device_id'];
									$userlog['fld_device_type']	=	$params['device_type'];
									$this->db->insert('tbl_user_log',$userlog);
									

									$return 				=		array();
									$return['status']		=		'200';
									if( $val == '1' ){
											$return['msg']			=		'Successfully logged';
									}else{
											$return['msg']			=		'Successfully logged';
									}
									$return['project_status']					=		$project_Status;
									$return['data']['token']					=		$token;
									$return['data']['contibuted_by_you']		=		'0';
									$return['data']['your_total_time']			=		'00:00:00';
									$return['data']['total_surgeries']			=		$totalSurgeries;
									$return['data']['session_code']				=		'';
									$return['data']['session_time']				=		'00:00:00';
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
								$insert_id 				=		$isther[0]->fld_id;
								
								//echo time().$this->token_key.$insert_id.mt_rand(500, 5000);exit;
								$token					=		md5(time().$this->token_key.$insert_id.mt_rand(500, 5000));
								$userSession 			=	array();
								$userSession['fld_token']	=		$token;
								$this->db->where('fld_id',$insert_id);
								$this->db->update('tbl_user',$userSession);	

								$this->db->where('fld_id',$insert_id);
								$isther 		=		$this->db->get('tbl_user')->result();						
								// user log
								$userlog['fld_user_id']		=	$insert_id;
								$userlog['fld_user_name']	=	$newUserData['fld_name'];
								$userlog['fld_user_location']	=	$newUserData['fld_location_id'];
								$userlog['fld_device_id']	=	$params['device_id'];
								$userlog['fld_device_type']	=	$params['device_type'];
								$this->db->insert('tbl_user_log',$userlog);
								// Get Session Code
								$this->db->where('s.fld_status','1');
								$this->db->where('s.fld_user_id',$insert_id);
								$this->db->join('tbl_user_steps u','u.fld_session_id=s.fld_session_code','INNER');
								$sessioData= $this->db->order_by('fld_id','DESC')->select('s.*,u.fld_total_time')->get('tbl_session s')->row();
								if( @$sessioData->fld_session_code == '' ||  @$sessioData->fld_session_code == NULL  ){
									$session_code 		=	'';
								}else{
									$session_code 		=	$sessioData->fld_session_code;
								}
								if( @$sessioData->fld_total_time != ''){
									$fld_total_time 	=	 $sessioData->fld_total_time ;
								}else{
									$fld_total_time 	=	'00:00:00';
								}
								$token					=		md5($this->token_key.$insert_id);
								$return 				=		array();
								$return['status']		=		'200';

								if( $val == '1' ){
										$return['msg']			=		'Successfully logged';
								}else{
										$return['msg']			=		'Successfully logged';
								}
								$return['project_status']					=		$project_Status;
								$return['data']['token']					=		$isther[0]->fld_token;
								$return['data']['contibuted_by_you']		=		$isther[0]->fld_total_surgery;
								$return['data']['your_total_time']			=		$isther[0]->fld_total_time;
								$return['data']['total_surgeries']			=		$totalSurgeries;
								$return['data']['session_code']				=		@$session_code;
								$return['data']['session_time']				=		$fld_total_time;
						}	

				}else{
						$return 						=		array();
						$return['status']				=		'403';
						if( $val == '1' ){
							$return['msg']				=		'Request field cannot be null';
						}else{
							$return['msg']				=		'Request field  cannot be null';				
						}		
				}	

			}else{
				$return 						=		array();
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
