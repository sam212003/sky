<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentAssignmentController extends CI_Controller {

public function assignclass(){
$stdid = $this->input->post('stdid');
$stdname =  $this->input->post('stdname');
$days = $this->input->post('day');
$times = $this->input->post('time');
$courseid = $this->input->post('courseid');
$coursename = $this->input->post('coursename');
$this->load->model('StudentAssignmentModel');

    // Insert the data into the "schedule" table
    for ($i = 0; $i < count($days); $i++) {
      $this->StudentAssignmentModel->assignclass($stdid,$stdname,$courseid,$coursename,$days[$i], $times[$i]);
    }
$data['studentid'] = $this->input->post('stdid');
$data['studentname'] = $this->input->post('stdname');
$data['courseid'] = $this->input->post('courseid');
$data['coursename'] = $this->input->post('coursename');
$this->load->view('StudentFeeView', $data);
}

public function updateclassassignment(){
$stdid = $this->input->post('stdid');
$stdname =  $this->input->post('stdname');
$days = $this->input->post('day');
$times = $this->input->post('time');
$courseid = $this->input->post('courseid');
$coursename = $this->input->post('coursename');
$assignments = $this->input->post('assignmentid');
$this->load->model('StudentAssignmentModel');

    // Insert the data into the "schedule" table
    for ($i = 0; $i < count($days); $i++) {
      $this->StudentAssignmentModel->updateClassAssignment($assignments[$i],$days[$i], $times[$i]);
    }
$data['student'] = null;
$data['op'] = 'AC';
$data['message'] = "Assignment Updated Successfully";
$this->load->view('StudentDetailsView', $data);
}

public function getStudentAssignmentRecords(){
	$this->load->model('StudentAssignmentModel');
        $data['records'] = $this->StudentAssignmentModel->getStudentAssignmentRecords();

        $this->load->view('StudentDashBoard_view', $data);
}
}