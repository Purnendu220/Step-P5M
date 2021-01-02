<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiTest extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model','site');
        $data 								=	array();
    }
	public function index()
	{
		$count=200;
		
		for ($i=0; $i < $count ; $i++) { 
			//
			// A very simple PHP example that sends a HTTP POST to a remote site
			//
			$data = array(
						"phone_number"=>"9207406".$i,
						"user_name"=>"Unais Ellias ".$i,
						"location"=>"1",
						"device_id"=>"INHGV6780900".$i,
						"device_type"=>"IOS"
					);
			$postdata = json_encode($data);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://localhost/steps/api/user/registertion/1");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
			            $postdata);

			// In real life you should use something like:
			// curl_setopt($ch, CURLOPT_POSTFIELDS, 
			//          http_build_query(array('postvar1' => 'value1')));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close ($ch);

			// Further processing ...
			echo "<pre>";print_r($server_output);echo "</pre>";
		}
	}
	public function setStartSession($value='')
	{
		$userList 		=	$this->db->get('tbl_user')->result();
		$i=0;
		foreach ($userList as $key => $value) {
			if($i==6){
				$i=0;
			}
			$data = array(
						"token" => $value->fld_token,
						'i' => $i
					);
			$postdata = json_encode($data);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://localhost/steps/api/userSession/createNewSession/1");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
			            $postdata);

			// In real life you should use something like:
			// curl_setopt($ch, CURLOPT_POSTFIELDS, 
			//          http_build_query(array('postvar1' => 'value1')));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close ($ch);

			// Further processing ...
			echo "<pre>";print_r($server_output);echo "</pre>";
			$i++;
		}
	}
	public function setUpdateSession($value='')
	{

		$dataSession = $this->db->select('*')->get('tbl_user')->result();
		$i=0;
		foreach ($dataSession as $key => $value) {
			if($i==6){
				$i=0;
			}
			switch ($i) {
				case 0:
					$time = '03.02.00';
					break;
				case 1:
					$time = '0.50.00';
					break;
				case 2:
					$time = '05.55.00';
					break;
				case 3:
					$time = '03.10.00';
					break;
				case 4:
					$time = '02.25.00';
					break;
				case 5:
					$time = '01.05.00';
					break;
				
				default:
					$time = '02.00.00';
					break;
			}
			$data = array(
						"token" => $value->fld_token,
						"session_code" => $value->fld_current_session_id,
						'time' => $time
					);
			$postdata = json_encode($data);
			// echo "<pre>";print_r($postdata);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://localhost/steps/api/userSession/updateSessionData/1");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
			            $postdata);

			// In real life you should use something like:
			// curl_setopt($ch, CURLOPT_POSTFIELDS, 
			//          http_build_query(array('postvar1' => 'value1')));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close ($ch);

			// Further processing ...
			echo "<pre>";print_r($server_output);echo "</pre>";
			$i++;

		}
	}
	public function getTotalTime($value='')
	{
		$user = $this->db->select('fld_total_time')->get('tbl_user')->result();
		
		$time =	array();
		// foreach ($user as $key => $value) {
		// 	$time[] 		=	$value->fld_total_time;
		// }
		echo "<pre>";

		echo getTotalTime($user).'<br>';
		print_r($user);
	}
}
?>