<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentAttendanceController extends CI_Controller {

public function loadattendanceview(){

	$this->load->model('StudentAttendanceModel');
	$data['stdattn'] = $this->StudentAttendanceModel->retrievestudentforAttn();
	$currentTimestamp = time();
	$dayOfWeek = date('w', $currentTimestamp);
	$days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	$dayName = $days[$dayOfWeek];
	$data['sysdate'] = date('Y-m-d',$currentTimestamp);
	$data['day'] = $dayName;
	$this->load->view('StudentAttendanceView', $data);

}

public function savestudentattendance(){
	$stdids = $this->input->post('stdid');
	$stdnames = $this->input->post('stdname');
	$randids = $this->input->post('randid');
	$times = $this->input->post('time');
	$currentTimestamp = time();
	$dayOfWeek = date('w', $currentTimestamp);
	$days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	$dayName = $days[$dayOfWeek];
	$date = date('Y-m-d',$currentTimestamp);
	$this->load->model('StudentAttendanceModel');
	for ($i = 0; $i < count($randids); $i++)
	 {
		$attns = $this->input->post('attn['.$randids[$i].']');
		if($attns):
			$this->StudentAttendanceModel->savestudentattendance($date,$dayName,$stdids[$i],$stdnames[$i],$times[$i],$attns);
		endif;
	}	
	$data['sysdate'] = date('Y-m-d',$currentTimestamp);
	$data['day'] = $dayName;
	$data['stdattn'] = $this->StudentAttendanceModel->retrievestudentforAttn();
	$this->load->view('StudentAttendanceView', $data);
}	
}
