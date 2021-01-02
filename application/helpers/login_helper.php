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
function checkProjectStatusOption(){
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','session_complete')->select('fld_option')->get('tbl_config')->row();
	return $data->fld_option;
}
function checkStepvalue(){
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','step_value')->select('fld_value')->get('tbl_config')->row();
	return $data->fld_value;
}
function checkSummaryType(){
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','summary_page_type')->select('fld_value')->get('tbl_config')->row();
	return $data->fld_value;
}
function getTimeFromSurgerie()
{
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','one_surgery')->select('fld_value')->get('tbl_config')->row();
	return $data->fld_value;
}
function getActiveEvent()
{
	// BY MOHIT
	$CI =& get_instance();
	$data =	$CI->db->where('event_status','1')->select('*')->order_by("event_id", "DESC")->get('tbl_events')->row();
	return $data->event_target;
}
function getActiveEventAll()
{
	// BY MOHIT
	$CI =& get_instance();
	$data =	$CI->db->where('event_status','1')->select('*')->order_by("event_id", "DESC")->get('tbl_events')->row();
	return $data;
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
	// $secs  = strtotime($time2)-strtotime("00:00:00");
	// $time  = date("H:i:s",strtotime($time)+$secs);
	// return $time;
	/*$h= 0;$m=0;$s=0;
	$array 		=		explode(':', $time);
	$h 			=		$h+$array[0];
	$m 			=		$m+$array[1];
	$s 			=		$s+$array[2];	
	
	$array 		=		explode(':', $now);
	$h 			=		$h+$array[0];
	$m 			=		$m+$array[1];
	$s 			=		$s+$array[2];
	$s = getSeconds ($s);
	$m = getMinites($m);
	$time = add_all($h,$m,$s);
	return $time;*/

$timeOne = $old;
$timeTwo = $now;
$timeOne_array = explode(':', $timeOne);
$timeOne_h  = ($timeOne_array[0]*3600 );
$timeOne_m  = ($timeOne_array[1]*60 );
$timeOne_s = $timeOne_h+$timeOne_m+$timeOne_array[2];
$timeTwo_array = explode(':', $timeTwo);
$timeTwo_h  = ($timeTwo_array[0]*3600 );
$timeTwo_m  = ($timeTwo_array[1]*60 );
if(is_numeric($timeTwo_array[2]))
$timeTwo_s = $timeTwo_h+$timeTwo_m+$timeTwo_array[2];
else
$timeTwo_s = $timeTwo_h+$timeTwo_m;

$diff = $timeOne_s + $timeTwo_s;
$diff = abs($diff);
$h = $diff / 3600;
$h = (int)$h;
$m = ($diff % 3600) / 60;
$m = (int)$m;
$s=   $diff - (( $h*3600 )+ ($m *60) );
/*if( $h < 10){
	$h = '0'.$h;
}*/
if( $m < 10){
	$m = '0'.$m;
}
if( $s < 10){
	$s = '0'.$s;
}
return $h.':'.$m.':'.$s;
}
function gettotalTimeMinit($TotalTime){
	$totalminitAr = explode(':', $TotalTime);
	$totalminit = $totalminitAr[0]*60;

	$totalminit = (int) $totalminit+ (int) $totalminitAr[1]	;

	return $totalminit;exit;
	$secs  	= 		strtotime($TotalTime)-strtotime("00:00:00");
	$count 	=		$secs/60;
	return (int)$count;
}
function gettotalSurgeries($oneSurgerieTime,$total_TimeMinit){
	$event_rewardValue = getActiveEventAll();
	$count = $total_TimeMinit/$oneSurgerieTime;
	return (int)$count*$event_rewardValue->event_rewardValue;
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
	/*if($outPutH < 10){
		$outPutH = '0'.$outPutH;
	}*/
	if($outPutM < 10){
		$outPutM = '0'.$outPutM;
	}
	if($outPutS < 10){
		$outPutS = '0'.$outPutS;
	}
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

function getSubTime( $newTime = '00:00:00', $oldTime = '00:00:00' ){
	/*$h= 0;$m=0;$s=0;
	$array 		=		explode(':', $newTime);
	$h 			=		$h-$array[0];
	$m 			=		$m-$array[1];
	$s 			=		$s-$array[2]; 
	$h= abs($h);$m= abs($m);$s= abs($s);
	$array 		=		explode(':',  $oldTime);
	$h 			=		abs($h)-$array[0];
	$m 			=		abs($m)-$array[1];
	$s 			=		abs($s)-$array[2];	
	$h= abs($h);$m= abs($m);$s= abs($s);
	$s = getSeconds ($s);
	$m = getMinites($m);
	$time = add_all($h,$m,$s);
	return $time;*/
$timeOne =$newTime;
$timeTwo = $oldTime;
$timeOne_array = explode(':', $timeOne);
$timeOne_h  = ($timeOne_array[0]*3600 );
$timeOne_m  = ($timeOne_array[1]*60 );
$timeOne_s = $timeOne_h+$timeOne_m+$timeOne_array[2];
$timeTwo_array = explode(':', $timeTwo);
$timeTwo_h  = ($timeTwo_array[0]*3600 );
$timeTwo_m  = ($timeTwo_array[1]*60 );
$timeTwo_s = $timeTwo_h+$timeTwo_m+$timeTwo_array[2];
$diff = $timeOne_s - $timeTwo_s;
$diff = abs($diff);
$h = $diff / 3600;
$h = (int)$h;
$m = ($diff % 3600) / 60;
$m = (int)$m;
$s=   $diff - (( $h*3600 )+ ($m *60) );
/*if( $h < 10){
	$h = '0'.$h;
}*/
if( $m < 10){
	$m = '0'.$m;
}
if( $s < 10){
	$s = '0'.$s;
}
return $h.':'.$m.':'.$s;


	// $newTime = strtotime($newTime);
	// $oldTime  = strtotime($oldTime);
	//echo $newTime.'---'.$oldTime;exit;
	$a =  dateDiff($newTime, $oldTime);
	//print_r($a);
	$minit = '00';
	$second = '00';
	$hour = '00';
	foreach ($a as $key => $value) {
		if (strpos($value, 'second') !== false) {
		    $second = trim(str_replace('second','',$value));
		}
		if (strpos($value, 'minute') !== false) {
		    $minit = trim(str_replace('minute','',$value));
		}
		if (strpos($value, 'hour') !== false) {
		    $hour = trim(str_replace('hour','',$value));
		}	
	}
	return  $hour.':'.$minit.':'.$second;
}
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
        break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
        // Add s if value is not 1
        if ($value != 1) {
          $interval .= "";
        }
        // Add value and interval to times array
        $times[] = $value . " " . $interval;
        $count++;
      }
    }

    // Return string with times
    return  $times ; //implode(", ", $times);
  }
// balance time for a session
function getTimeInMin($time,$oneSurgerieTime){
	$m 				 	= 	date('i',strtotime($time));
	$h 					= 	date('H',strtotime($time));
	if( $h != '00' && $h != 00 && $h != '0' && $h != 0){
		$h 					=	$h*60;
	}
	$total_T_M  		=	$m+$h;
	$b_t_m 				=	$oneSurgerieTime - $total_T_M ;	
	$b_t_m  			=	convertToHoursMins($b_t_m, '%02d:%02d:00');
	return $b_t_m;
	
}
function convertMinittoTime($oneSurgerieTime){
	return convertToHoursMins($oneSurgerieTime, '%02d:%02d:00');
}
function convertTimetoSecond($time){
	$timeOne = $time;
	$timeOne_array = explode(':', $timeOne);
	$timeOne_h  = ($timeOne_array[0]*3600 );
	$timeOne_m  = ($timeOne_array[1]*60 );
	$timeOne_s = $timeOne_h+$timeOne_m+$timeOne_array[2];
	return abs($timeOne_s);
}
function convertSeconceTOTime($seconds){	
	$diff = $seconds;
	$h = $diff / 3600;
	$h = (int)$h;
	$m = ($diff % 3600) / 60;
	$m = (int)$m;
	$s=   $diff - (( $h*3600 )+ ($m *60) );
	/*if( $h < 10){
		$h = '0'.$h;
	}*/
	if( $m < 10){
		$m = '0'.$m;
	}
	if( $s < 10){
		$s = '0'.$s;
	}
	if( $h =='' || $h == 0 ){
		$h ='0';
	}
	return $h.':'.$m.':'.$s;
}
function get_B_Time($id){
	$CI =& get_instance();
	$data =	$CI->db->where('fld_id',$id)->select('fld_total_time')->get('tbl_user')->row();
	$time  = $data->fld_total_time;
	$m_time = convertTimetoSecond($time);
	// BY MOHIT $one_surgery	=	convertTimetoSecond('2:30:00');
	$one_surgery	=	convertTimetoSecond(convertMinittoTime(getActiveEvent()));
	//$b_time = $m_time % 150 ;
	// var_dump($one_surgery);
	$b_time = $m_time % $one_surgery ;
	$b_m_time 	= convertSeconceTOTime($b_time);
	if($b_m_time == '' || $b_m_time == '0' ){
		$b_m_time 	= 	"00:00:00";
	}	
	// var_dump($b_m_time);
	return  $b_m_time;
}
function get_update_s_b_time($id,$s_time)
{
	$CI 		=& 	get_instance();
	$data 		=	$CI->db->where('fld_id',$id)->select('fld_total_time')->get('tbl_user')->row();
	$time  		= 	$data->fld_total_time;
	$time 		= 	convertTimetoSecond($time);//gettotalTimeMinit($time);
	$s_time 	=	convertTimetoSecond($s_time);//gettotalTimeMinit($s_time);
	$time 		= 	$time - $s_time;
	$m_time 	= 	convertSeconceTOTime($time);
	$m_time 	=	convertTimetoSecond($m_time);
	$one_surgery	=	convertTimetoSecond('2:30:00');
	$b_time 	= $m_time % $one_surgery ;
	$b_m_time 	= convertSeconceTOTime($b_time);
	if($b_m_time == '' || $b_m_time == '0' ){
		$b_m_time 	= 	"00:00:00";
	}
	//$b_m_time	= 		$b_m_time.':00';
	return  $b_m_time;
}
function getTimeFromSurgerie_second()
{
	$CI =& get_instance();
	$data =	$CI->db->where('fld_slug','one_surgery')->select('fld_value')->get('tbl_config')->row();
	return ($data->fld_value % 3600) / 60;
}
function gettotalSurgeries_second($oneSurgerieTime,$total_TimeMinit){
	$count = $total_TimeMinit/$oneSurgerieTime;
	echo (int)$count;exit;
}
?>