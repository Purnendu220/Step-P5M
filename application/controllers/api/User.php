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
						$project_StatusOption 					=		checkProjectStatusOption();
						$newUserData 						=		array();
						$newUserData['fld_name']			=		$params['user_name'];
						$newUserData['fld_phone']			=		$params['phone_number'];
                                                $newUserData['fld_phonecode']			=		@$params['phonecode'];
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
									$userSession 			=		array();
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
											$return['project_status_option']					=		$project_StatusOption;
									$return['data']['token']					=		$token;
									$return['data']['contibuted_by_you']		=		'0';
									$return['data']['your_total_time']			=		'00:00:00';
									$return['data']['total_contributions']			=		$totalSurgeries;
									$return['data']['session_code']				=		'';
									$return['data']['session_time']				=		'00:00:00';
									$return['data']['fld_my_total_time']		=		'00:00:00';
									$return['data']['b_time']					=		'00:00:00';
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
								$insert_id 				=		$isther[0]->fld_id;
								
								$old_session_id 	                =  	$isther[0]->fld_total_time;							
						
								$onSuTime  			= 	getTimeFromSurgerie();							
								$onSuTime_m 		=  	gettotalTimeMinit($old_session_id);
								$newTIme 			= 	$onSuTime_m % $onSuTime;
								$blance_S_time  	=	 convertMinittoTime($newTIme);


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
									if($blance_S_time == ""){
										$fld_total_time 	=	'00:00:00';
									}else{
										$fld_total_time 	=	$blance_S_time;
									}
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
								$return['project_status_option']					=		$project_StatusOption;

								$return['data']['token']					=		$isther[0]->fld_token;
								$return['data']['contibuted_by_you']		=		$isther[0]->fld_total_surgery;
								$return['data']['your_total_time']			=		$isther[0]->fld_total_time;
								$return['data']['total_contributions']			=		$totalSurgeries;
								$return['data']['session_code']				=		@$session_code;
								$return['data']['session_time']				=		$fld_total_time;
								$return['data']['b_time']					=		get_B_Time($isther[0]->fld_id);
								if($isther[0]->fld_my_total_time != ''){
									$return['data']['fld_my_total_time']		=		$isther[0]->fld_total_time;
								}else{
									$return['data']['fld_my_total_time']		=		'00:00:00';
								}
								
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
public function country_phone_code( $val = '1' )
	{		
		
		if( $this->rest->get_request_method() != 'GET' ){
			$return 						=		array();
			$return['status']				=		'401';
			if( $val == '1' ){
				$return['msg']				=		'Invalid Request Type';
			}else{
				$return['msg']				=		'Invalid Request Type';

			}
$this->rest->response($this->json($return), 200);exit;
		}else{
		$sql = "SELECT id AS country_id  ,if(".$val."=1,nicename,name_ar) AS country_name ,phonecode FROM tbl_country_code ORDER BY sort";

		$result =  $this->db->query($sql);

		//return $return_array
$return_array = array('status' => '200', 'msg' => 'Success', 'result' => $result->result_array());

			$this->rest->response(json_encode($return_array), 200);exit;
}
	}

public function getLeaderBoard( $val = '1' )
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
$page=@$params['page']-1;
$limit=20;
$page=$page*$limit;

// BY MOHIT $sql = "SELECT fld_id ,if(".@$isthere->fld_id."=fld_id,1,0) AS user_flag ,fld_name,fld_total_time,fld_my_total_time FROM tbl_user where fld_status = 1 ORDER BY TIME(fld_my_total_time) desc,fld_name LIMIT ".@$limit." OFFSET ".@$page;
$sql = "SELECT fld_id ,if(".@$isthere->fld_id."=fld_id,1,0) AS user_flag ,fld_name,fld_total_time,fld_my_total_time FROM tbl_user where fld_status = 1 AND fld_my_total_time != '0:00:00' AND fld_my_total_time != '' ORDER BY TIME(fld_my_total_time) desc,fld_name LIMIT ".@$limit." OFFSET ".@$page;

		$result =  $this->db->query($sql);
											


                                                $return['status']				=		'200';

						if( $val == '1' ){
							$return['msg']				=		'Success';
						}else{
							$return['msg']				=		'Success';				
						}

                                                    $return_result				=		$result->result_array();
foreach ($return_result as $key => $value) {

$sql123 = "SELECT count(fld_id) as total_users FROM tbl_user where fld_status = 1 AND TIME(fld_my_total_time) > TIME('".@$value['fld_my_total_time']."')";
$ranks123=  $this->db->query($sql123);
                 $my_ranks123				=		$ranks123->row_array();
                 $my_rank123				=   $my_ranks123['total_users']+1;
$return_result[$key]['rank']				=(string)$my_rank123;

}
  $return['result']=$return_result;

@$return['user_flag_available'] =@(string)max(array_column($return['result'], 'user_flag'));

$sql = "SELECT fld_id ,if(".@$isthere->fld_id."=fld_id,1,0) AS user_flag ,fld_name,fld_total_time,fld_my_total_time FROM tbl_user where fld_id = ".@$isthere->fld_id;

		$result123 =  $this->db->query($sql);
                 $return['user_data']				=		$result123->row_array();
$sql = "SELECT count(fld_id) as total_users FROM tbl_user where fld_status = 1 AND TIME(fld_my_total_time) > TIME('".@$return['user_data']['fld_my_total_time']."')";
$ranks=  $this->db->query($sql);
                 $my_ranks				=		$ranks->row_array();
                 $my_rank				=   $my_ranks['total_users']+1;
$return['user_data']['rank']				=(string)$my_rank;


if(count($return_result) > 20){
	$return['is_last_page'] ='0';
}else{
	$return['is_last_page'] ='1';
}
$qry = "SELECT count(fld_id) as total_users FROM tbl_user where fld_status = 1";
$qury=  $this->db->query($qry);
$alltotal_users =		$qury->row_array();
if(((@$params['page']*$limit)==500) || ((@$params['page']*$limit)>=$alltotal_users['total_users']))
$return['is_last_page'] ='1';

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
	
public function getUserActivity( $val = '1' )
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
						$today=date('Y-m-d');

                                                $return['status']				=		'200';

						if( $val == '1' ){
							$return['msg']				=		'Success';
						}else{
							$return['msg']				=		'Success';				
						}
				$is_last_page ='0';		
$page=@$params['page']-1;
$limit=3;
$page=$page*$limit;
$pg=0;
$month_first_day=date('Y-m-01',strtotime(-$page." months", strtotime($today)));
$month_name=date("F", strtotime($month_first_day));
$year=date("Y", strtotime($month_first_day));

if($page==0)
$month_last_day=$today;
else
$month_last_day=date("Y-m-t", strtotime($month_first_day));

if($month_first_day=='2020-04-01')
{	
$is_last_page ='1';
}
$month_activity=array();
$month_total_time=0;

$date1=date_create($month_first_day);
$date2=date_create($month_last_day);
$diff=date_diff($date1,$date2);
$diff = $diff->format("%a");

$newdate=$month_last_day;
for($i=0;$i<=$diff;$i++){

$total_day_time='00:00:00';
$month_activity[$i]['date']=$newdate;
if($newdate==$today){
$month_activity[$i]['day']='Today';	
}
else{
$month_activity[$i]['day']=date('D', strtotime($newdate));
}

$newdate1=$newdate.' 00:00:00';
$newdate2=$newdate.' 23:59:59';
	$sql = "SELECT fld_total_time FROM tbl_user_steps where fld_user_id='".$isthere->fld_id."' AND fld_update_date BETWEEN '".$newdate1."' AND '".$newdate2."'";

		$result =  $this->db->query($sql);
		$return_result				=		$result->result_array();


foreach ($return_result as $key => $value) {
	 		$total_day_time=addTwotIme($total_day_time,@$value['fld_total_time']);

}
$total_day_time=gettotalTimeMinit($total_day_time);
$month_total_time=$month_total_time+$total_day_time;
$month_activity[$i]['total_day_time']=(string)$total_day_time;
$newdate=date('Y-m-d',strtotime("-1 day", strtotime($newdate)));
}

$return['activity'][$pg]['month_name']				=(string)$month_name;
$return['activity'][$pg]['year']				=(string)$year;
$return['activity'][$pg]['month_total_time']				=(string)$month_total_time;
$return['activity'][$pg]['month_activity']				=$month_activity;

if(!$is_last_page){
	$page++;
$pg++;
$month_first_day=date('Y-m-01',strtotime(-$page." months", strtotime($today)));
$month_name=date("F", strtotime($month_first_day));
$year=date("Y", strtotime($month_first_day));

if($page==0)
$month_last_day=$today;
else
$month_last_day=date("Y-m-t", strtotime($month_first_day));

if($month_first_day=='2020-04-01')
{	
$is_last_page ='1';
}
$month_activity=array();
$month_total_time=0;

$date1=date_create($month_first_day);
$date2=date_create($month_last_day);
$diff=date_diff($date1,$date2);
$diff = $diff->format("%a");

$newdate=$month_last_day;
for($i=0;$i<=$diff;$i++){

$total_day_time='00:00:00';
$month_activity[$i]['date']=$newdate;
if($newdate==$today){
$month_activity[$i]['day']='Today';	
}
else{
$month_activity[$i]['day']=date('D', strtotime($newdate));
}

$newdate1=$newdate.' 00:00:00';
$newdate2=$newdate.' 23:59:00';
	$sql = "SELECT fld_total_time FROM tbl_user_steps where fld_user_id='".$isthere->fld_id."' AND fld_update_date BETWEEN '".$newdate1."' AND '".$newdate2."'";

		$result =  $this->db->query($sql);
		$return_result				=		$result->result_array();


foreach ($return_result as $key => $value) {
	 		$total_day_time=addTwotIme($total_day_time,@$value['fld_total_time']);

}
$total_day_time=gettotalTimeMinit($total_day_time);
$month_total_time=$month_total_time+$total_day_time;
$month_activity[$i]['total_day_time']=(string)$total_day_time;
$newdate=date('Y-m-d',strtotime("-1 day", strtotime($newdate)));
}

$return['activity'][$pg]['month_name']				=(string)$month_name;
$return['activity'][$pg]['year']				=(string)$year;
$return['activity'][$pg]['month_total_time']				=(string)$month_total_time;
$return['activity'][$pg]['month_activity']				=$month_activity;

}
if(!$is_last_page){
	$page++;
$pg++;
$month_first_day=date('Y-m-01',strtotime(-$page." months", strtotime($today)));
$month_name=date("F", strtotime($month_first_day));
$year=date("Y", strtotime($month_first_day));

if($page==0)
$month_last_day=$today;
else
$month_last_day=date("Y-m-t", strtotime($month_first_day));

if($month_first_day=='2020-04-01')
{	
$is_last_page ='1';
}
$month_activity=array();
$month_total_time=0;

$date1=date_create($month_first_day);
$date2=date_create($month_last_day);
$diff=date_diff($date1,$date2);
$diff = $diff->format("%a");

$newdate=$month_last_day;
for($i=0;$i<=$diff;$i++){

$total_day_time='00:00:00';
$month_activity[$i]['date']=$newdate;
if($newdate==$today){
$month_activity[$i]['day']='Today';	
}
else{
$month_activity[$i]['day']=date('D', strtotime($newdate));
}

$newdate1=$newdate.' 00:00:00';
$newdate2=$newdate.' 23:59:00';
	$sql = "SELECT fld_total_time FROM tbl_user_steps where fld_user_id='".$isthere->fld_id."' AND fld_update_date BETWEEN '".$newdate1."' AND '".$newdate2."'";

		$result =  $this->db->query($sql);
		$return_result				=		$result->result_array();


foreach ($return_result as $key => $value) {
	 		$total_day_time=addTwotIme($total_day_time,@$value['fld_total_time']);

}
$total_day_time=gettotalTimeMinit($total_day_time);
$month_total_time=$month_total_time+$total_day_time;
$month_activity[$i]['total_day_time']=(string)$total_day_time;
$newdate=date('Y-m-d',strtotime("-1 day", strtotime($newdate)));
}

$return['activity'][$pg]['month_name']				=(string)$month_name;
$return['activity'][$pg]['year']				=(string)$year;
$return['activity'][$pg]['month_total_time']				=(string)$month_total_time;
$return['activity'][$pg]['month_activity']				=$month_activity;

}



$return['is_last_page']=$is_last_page;

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
