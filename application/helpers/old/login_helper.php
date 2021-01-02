<?php
function checkAdminLogin()
{
	// $CI =& get_instance();
 //    $is_logged_in = $CI->session->userdata('is_logged_in');     
 //    if(!isset($is_logged_in) || $is_logged_in->login != 'true')
 //    {
 //        redirect('admin/login', 'refresh');
 //    } 
 //    elseif(isset($is_logged_in) && $is_logged_in->login == 'true') { 
	// 	redirect('admin/dashboard', 'refresh');
 //    }   
} 
function getTotalTimeArray(){
	$CI =& get_instance();
	$data =	$CI->db->select('fld_total_time')->get('tbl_user')->result();
	return $data;
}
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function checkProjectStatus(){
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','session_complete')->select('fld_value')->get('tbl_config')->row();
	return $data->fld_value;
}
function getTimeFromSurgerie()
{
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','one_surgery')->select('fld_value')->get('tbl_config')->row();
	return $data->fld_value;
}
function getTotalTime( $totalArray ){
	// $time = '00:00:00';
	// foreach ($totalArray as $key => $value) {
	// 	if( $value->fld_total_time != '00:00:00'){	
	// 		$time2 = $value->fld_total_time;
	// 		$secs  = strtotime($time2)-strtotime("00:00:00");
	// 		$time  = date("H:i:s",strtotime($time)+$secs);
	// 	}
	// }
	// return $time;
	$time = '00:00:00';
	$totalHr = array();$i=0;
	$h= 0;$m=0;$s=0;
	foreach ($totalArray as $key => $value) {
		if( $value->fld_total_time != '00:00:00'){	
			$array 		=		explode(':', $value->fld_total_time);
			$h 			=		$h+$array[0];
			$m 			=		$m+$array[1];
			$s 			=		$s+$array[2];		
		}
	}
	$s = getSeconds ($s);
	$m = getMinites($m);
	$time = add_all($h,$m,$s);
	return $time;
}

function addTwotIme($old,$now){
	$time =	$old;
	$time2 = $now;
	$secs  = strtotime($time2)-strtotime("00:00:00");
	$time  = date("H:i:s",strtotime($time)+$secs);
	return $time;
}
function gettotalTimeMinit($TotalTime){
	$totalminitAr = explode(':', $TotalTime);
	$totalminit = $totalminitAr[0]*60;
	$totalminit = (int) $totalminit+ (int) $totalminitAr[0]	;

	return $totalminit;exit;
	$secs  	= 		strtotime($TotalTime)-strtotime("00:00:00");
	$count 	=		$secs/60;
	return (int)$count;
}
function gettotalSurgeries($oneSurgerieTime,$total_TimeMinit){
	$count = $total_TimeMinit/$oneSurgerieTime;
	return (int)$count;
}
function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
    // Declare an empty array 
    $array = array(); 
      
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
    // Use loop to store date into array 
    foreach($period as $date) {                  
        $array[] = $date->format($format);  
    } 
  
    // Return the array elements 
    return $array; 
}


function getNewTotalTime( $totalArray ){
	$time = '00:00:00';
	$totalHr = array();$i=0;
	$h= 0;$m=0;$s=0;
	foreach ($totalArray as $key => $value) {
		if( $value->fld_total_time != '00:00:00'){	
			$array 		=		explode(':', $value->fld_total_time);
			$h 			=		$h+$array[0];
			$m 			=		$m+$array[1];
			$s 			=		$s+$array[2];		
		}
	}
	$s = getSeconds ($s);
	$m = getMinites($m);
	$time = add_all($h,$m,$s);
	return $time;
}
function add_all($h,$m,$s){
	$sAr = explode(":", $s); 
	$mAr = explode(":", $m); 	
	$outPutS = $sAr[2] ;
	$outPutM = (int)$sAr[1]+(int)$mAr[1];
	$outPutH = (int)$h+(int)$mAr[0];
	return $outPutH.':'.$outPutM.':'.$outPutS;
}
function getMinites($m){
	return date('H:i', mktime(0, $m));
}
function getSeconds($seconds){
	$hours = floor($seconds / 3600);
  $minutes = floor(($seconds / 60) % 60);
  $seconds = $seconds % 60;
  return "$hours:$minutes:$seconds";
}
function getSecondsAll($seconds){
	foreach ($seconds as $key => $value) {
		$seconds = $seconds->fld_total_time;
  		$hours = floor($seconds / 3600);
  		$minutes = floor(($seconds / 60) % 60);
  		$seconds = $seconds % 60;
	}
  return "$hours:$minutes:$seconds";
}

?>