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
							 $old_session_id 	=  	$isthere->fld_total_time;//exit;
							// BY MOHIT $onSuTime  			= 	getTimeFromSurgerie();							
							$onSuTime  			= 	getActiveEvent();							
							$onSuTime_m 		=  	gettotalTimeMinit($old_session_id);
							$newTIme 			= 	$onSuTime_m % $onSuTime;
							$blance_S_time  	=	convertMinittoTime($newTIme);
							
							
							// echo $old_session_id =  $isthere->fld_current_session_id;exit;
							$this->db->where('fld_session_id',$isthere->fld_current_session_id);
							$sesstionData = $this->db->get('tbl_user_steps')->row();
							$newUserTime 						= 		addTwotIme($isthere->fld_total_time,@$sesstionData->fld_total_time);
							$total_TimeMinit					=		gettotalTimeMinit($newUserTime);
							// BY MOHIT $oneSurgerieTime 					=		getTimeFromSurgerie();
							$oneSurgerieTime 					=		getActiveEvent();
							$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
							$newUserData						=		array();
							$newUserData['fld_total_time']		=		$newUserTime;
							$newUserData['fld_total_surgery']	=		$totalSurgeries;
							$newUserData['fld_current_session_id']	=		'';
							// $this->db->where('fld_id',$isthere->fld_id);
							// $this->db->update('tbl_user',$newUserData);
							
							$this->db->where('fld_token',$params['token']);
							$isthere 				= 		$this->db->get('tbl_user')->row();
						}

						$completeAry					=		array();
						$completeAry['fld_status'] 		=		'0';
						$this->db->where('fld_user_id',$isthere->fld_id);
						$this->db->update('tbl_session',$completeAry);

						$project_Status 				=		checkProjectStatus();
						$project_StatusOption 					=		checkProjectStatusOption();


						$session_id 					=		md5($isthere->fld_id.time());
						$sessionData 					=		array();
						$sessionData['fld_user_id']		=		$isthere->fld_id;
						$sessionData['fld_session_code']=		$session_id;

						$config = $this->db->where('fld_slug','session_complete')->get('tbl_config')->row();
						$startDate 						=		date('Y-m-d',strtotime($config->fld_start_date));
						$today 		=		date('Y-m-d');
						$dateAry 	=		getDatesFromRange(@$startDate,$today,'Y-m-d H:i:s');
						$xAccess 	=		$dateAry;

						$startDate 						=		date('Y-m-d',strtotime($config->fld_start_date));

						//$sessionData['fld_starting_date']=		$xAccess[$params['i']];
						//$sessionData['fld_end_date']	=		date("Y-m-d H:i:s");
						$sessionData['fld_status']		=		'1';	
						if( $this->db->insert('tbl_session',$sessionData) ){
							
								$blance_S_time = "00:00:00";
							
							$userStep							=		array();
							$userStep['fld_session_id']			=		$sessionData['fld_session_code'];
							$userStep['fld_user_id']			=		$isthere->fld_id;
							$userStep['fld_total_time']			=		'0:00:00';//$blance_S_time;	
							$userStep['fld_created_date']		=		date("Y-m-d H:i:s");
							$userStep['fld_update_date']		=		date("Y-m-d H:i:s");
							$this->db->insert('tbl_user_steps',$userStep);
							$userData 							=		array();
							$userData['fld_current_session_id']	=		$sessionData['fld_session_code'];
							$this->db->where('fld_id',$isthere->fld_id);
							$this->db->update('tbl_user',$userData);
							$userData 							=		array();
if (isset($params['longitude']) && isset($params['lattitude']) && ($params['longitude'] != '') && ($params['lattitude'] != '') ){

                            $userLocation['fld_session_code']			=		$sessionData['fld_session_code'];
							$userLocation['fld_user_id']			=		$isthere->fld_id;
							$userLocation['fld_status']			=		1;
							$userLocation['fld_longitude']		=		$params['longitude'];
							$userLocation['fld_lattitude']		=		$params['lattitude'];
							$userLocation['date_added']		=		date("Y-m-d H:i:s");
							$this->db->insert('tbl_session_locations',$userLocation);
}
							$return 					=		array();
							$return['status']			=		'200';
							if( $val == '1' ){
									$return['msg']				=		'Successful execute the api request';
							}else{
									$return['msg']				=		'Successful execute the api request';
							}
							$return['project_status']					=		$project_Status;
							$return['project_status_option']					=		$project_StatusOption;

							$return['data']['token']					=		$params['token'];
							$return['data']['session_code']				=		$session_id;
							$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
							$return['data']['fld_my_total_time']		=		$isthere->fld_my_total_time;
							$return['data']['your_total_time']			=		$isthere->fld_total_time;
$return['data']['step_value']			=		$this->db->where('fld_slug','step_value')->get('tbl_config')->row();
$return['data']['summary_page_type']			=		$this->db->where('fld_slug','summary_page_type')->get('tbl_config')->row();

							$totalArray  						= 		getTotalTimeArray();
							$total_time 						= 		getTotalTime( $totalArray );
							$total_TimeMinit					=		gettotalTimeMinit($total_time);
							// BY MOHIT $oneSurgerieTime 					=		getTimeFromSurgerie();
							$oneSurgerieTime 					=		getActiveEvent();
							$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
							$return['data']['total_contributions']	=		$totalSurgeries;
							$return['data']['session_time']		=		'0:00:00';//$blance_S_time;
							$return['data']['b_time']			=		get_B_Time($isthere->fld_id);//"00:00:00";//convertMinittoTime($oneSurgerieTime);
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
				if( @$params['token'] != '' && @$params['session_code'] != ''  && @$params['time'] != '' && @$params['complete'] != ""  ){ 

					$this->db->where('fld_token',$params['token']);
					$isthere 				= 		$this->db->get('tbl_user')->row();
					if( @$isthere->fld_id != "" ){

							



						$yourTimeNot 			=	$isthere->fld_total_time;

						$this->db->where('s.fld_session_code',$params['session_code']);
						$this->db->where('s.fld_user_id',$isthere->fld_id);
						$this->db->join('tbl_user_steps us','us.fld_session_id=s.fld_session_code');
						$sessiondata 	=	$this->db->order_by('s.fld_id','DESC')->select('s.*,us.fld_total_time')->get('tbl_session s')->row();
						 
						if( $sessiondata->fld_id != "" ){
							if( $sessiondata->fld_status != "0"){


								$complete_status 			=	$params['complete'];
								$check_update_time 			=	'';
								if( $complete_status == 'Y' ){
									$activeEventTarget = $surgerie_time			= 	convertTimetoSecond(convertMinittoTime(getActiveEvent()));
									// // BY MOHIT $surgerie_time 			=	convertTimetoSecond(convertMinittoTime(getTimeFromSurgerie())); 
									$balance_time 			=	convertTimetoSecond(get_B_Time($isthere->fld_id));
									$blance_time_remining_s	=	$surgerie_time - $balance_time;
									$blance_time_remining	=	convertSeconceTOTime(abs($blance_time_remining_s));
									$current_session_code 	= 	$isthere->fld_current_session_id;
									$sesstion_data 			= 	$this->db->select('us.fld_total_time')
																         ->from('tbl_session s')
																         ->join('tbl_user_steps us','us.fld_session_id=s.fld_session_code')
																         ->where('s.fld_status','1')
																         ->where('s.fld_session_code',$params['session_code'])
																         ->get()->row();									
									$session_time 			=	$sesstion_data->fld_total_time;
									$check_update_time		=	convertSeconceTOTime(convertTimetoSecond($session_time) + $blance_time_remining_s);	
									
								}
								if(  $check_update_time != '' ){
									$params['time'] =  $check_update_time;
								}
								

								//New Time 
								$current_session_time 			= 	$sessiondata->fld_total_time;
								$new_session_time 				=	$params['time'];
								$my_total_time 				=	$params['my_time'];
								$newUTime 						= 	getSubTime($new_session_time,$current_session_time);
								$current_session_time.'-'.$new_session_time.'='.$newUTime;
								
								// add Old time with new time
								$userCurrent_time 				= 	$isthere->fld_total_time;
								$usermy_total_time 				= 	$isthere->fld_my_total_time;
								if($usermy_total_time == '')
								{
									$usermy_total_time = '0:00:00';
								}
								$newTime 						=  	addTwotIme($userCurrent_time,$newUTime);
								$newmy_total_time						=  	addTwotIme($my_total_time,$usermy_total_time);
								// total sergery contributed by you
								$total_TimeMinit					=		gettotalTimeMinit($newTime);
								$my_total_time					=		gettotalTimeMinit($newmy_total_time);
								// BY MOHIT $oneSurgerieTime 					=		getTimeFromSurgerie();
								$oneSurgerieTime 					=		getActiveEvent();

								$b_time 							=		getTimeInMin($params['time'],$oneSurgerieTime);
								$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
								
										
								// add total time to user table		
								$userNewData 					=	array();
								$userNewData['fld_total_time']	=	$newTime;
								$userNewData['fld_my_total_time']	=	$newmy_total_time;
								$userNewData['fld_total_surgery']	=		$totalSurgeries;
								$this->db->where('fld_id',$isthere->fld_id);
								$this->db->update('tbl_user',$userNewData);
								$userNewData 					=	array();
								
								$this->db->where('fld_id',$isthere->fld_id);
								$isthere 						= 		$this->db->get('tbl_user')->row();

								$userStep 						=		array();
								$userStep['fld_total_time']		=		$params['time'];
								$userStep['fld_update_date']	=		date("Y-m-d H:i:s");
								$this->db->where('fld_session_id',$params['session_code']);
								$this->db->where('fld_user_id',$isthere->fld_id);

								if( $this->db->update('tbl_user_steps',$userStep) ){
if (isset($params['longitude']) && isset($params['lattitude']) && ($params['longitude'] != '') && ($params['lattitude'] != '') ){

                                                        $userLocation['fld_session_code']			=		$params['session_code'];
							$userLocation['fld_user_id']			=		$isthere->fld_id;
							$userLocation['fld_status']			=		1;
							$userLocation['fld_longitude']		=		$params['longitude'];
							$userLocation['fld_lattitude']		=		$params['lattitude'];
							$userLocation['date_added']		=		date("Y-m-d H:i:s");
							$this->db->insert('tbl_session_locations',$userLocation);
}

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
									$project_StatusOption 					=		checkProjectStatusOption();

									$return['project_status']					=		$project_Status;
									$return['project_status_option']					=		$project_StatusOption;

									$return['data']['token']					=		$params['token'];
									$return['data']['contibuted_by_you']		=		$isthere->fld_total_surgery;
									$return['data']['your_total_time']			=		$isthere->fld_total_time;
									$return['data']['fld_my_total_time']		=		$isthere->fld_my_total_time;
									$totalArray  						= 		getTotalTimeArray();
									$total_time 						= 		getTotalTime( $totalArray );
									$total_TimeMinit					=		gettotalTimeMinit($total_time);
									// BY MOHIT $oneSurgerieTime 					=		getTimeFromSurgerie();
									$oneSurgerieTime 					=		getActiveEvent();
									$totalSurgeries						=		gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
									$return['data']['total_contributions']	=		$totalSurgeries;
									$return['data']['session_code']		=		$params['session_code'];
									$return['data']['session_time']		=		$params['time'];
									// $return['data']['b_time']			=		get_update_s_b_time($isthere->fld_id,$params['time']);//"00:00:00";//$b_time;
									$return['data']['b_time']			=		get_B_Time($isthere->fld_id);//"00:00:00";//$b_time;
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
	public function getUserLocations( $val = '1' )
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
				if( @$params['token'] != ''  ){ 

					$this->db->where('fld_token',$params['token']);
					$isthere 				= 		$this->db->get('tbl_user')->row();
					if( @$isthere->fld_id != "" ){

							



						$yourTimeNot 			=	$isthere->fld_total_time;
if( @$params['session_code'] != ''  ){
						$this->db->where('s.fld_session_code',$params['session_code']);
					}
						$this->db->where('s.fld_user_id',$isthere->fld_id);
						$sessiondata 	=	$this->db->order_by('s.fld_id','ASC')->select('s.*')->get('tbl_session_locations s')->rows();
						 
								$return 					=		array();
									$return['status']			=		'200';
									$return['locations'] = $sessiondata;
									if( $val == '1' ){
											$return['msg']				=		'Successfully logged';
									}else{
											$return['msg']				=		'Successfully logged';
									}
					}
				else{
													$return 					=		array();

					$return['status']				=		'403';
					if( $val == '1' ){
						$return['msg']				=		'TOKEN ERROR';
					}else{
						$return['msg']				=		'TOKEN ERROR';
					}
				}
			}else{
												$return 					=		array();

				$return['status']				=		'403';
				if( $val == '1' ){
					$return['msg']				=		'Request field cannot be null';
				}else{
					$return['msg']				=		'Request field  cannot be null';				
				}
			}
		}	
	}
		$this->rest->response(json_encode($return), 200);exit;	
	}
}
?>