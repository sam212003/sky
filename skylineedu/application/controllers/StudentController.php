<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentController extends CI_Controller {

public function __construct() {
        parent::__construct();
        $this->load->helper('auth'); // Load the auth helper
	$this->load->library('session');
    }



public function loadregisterview(){

if($this->session->userdata('username')){
$this->load->view('registerstudent_view');

}
else{
 redirect('index.php/user/login');
}
}
public function loadstudentcourseview(){
$this->load->view('StudentCourseView');
}
public function loadstudentscheduleview(){
$data['studentid'] = $this->input->post('stdid');
$stdid = $this->input->post('stdid');
$data['studentname'] = $this->input->post('stdname');
$courseid = $this->input->post('courseid');
$data['courseid'] = $this->input->post('courseid');
$data['coursename'] = $this->input->post('coursename');
$this->load->model('StudentAssignmentModel');
$data['stdassignment'] = $this->StudentAssignmentModel->getStudentAssignmentByCourse($stdid,$courseid);
if($data['stdassignment']):
	$this->load->view('StudentScheduleUpdateView',$data);
else:
	$this->load->view('StudentScheduleView',$data);
endif;
}
public function loadstudentdetailsview(){
$data['student'] = null;
$data['op'] = 'CV';
$this->load->view('StudentDetailsView',$data);
}
public function loadstudentdetailsviewforassign(){
$data['student'] = null;
$data['op'] = 'AC';
$this->load->view('StudentDetailsView',$data);
}
public function loadstudentdetailsviewforremove(){
$data['student'] = null;
$data['op'] = 'RS';
$this->load->view('StudentDetailsView',$data);
}

public function initiatepaymentsearch(){
$data['student'] = null;
$this->load->view('InitiatePaymentView',$data);
}

public function initiatestudentsearch(){
$data['student'] = null;
$this->load->view('SearchStudentforView',$data);
}

public function initiatestudentsearchforUpdate(){

$data['student'] = null;
$this->load->view('SearchStudentforUpdateView',$data);
}

public function registerstudent(){

$stdid = mt_rand(100000, 999999);

$courseid = "";
$coursename = "";
$status = "Active";
$stdname = $this->input->post('stdname');
$student_data = array(
'stdid'=> $stdid,
'stdname' => $this->input->post('stdname'),
'dob'=> $this->input->post('dob'),
'address' =>$this->input->post('address'),
'class' => $this->input->post('class'),
'school'=>$this->input->post('school') ,
'phoneno'=> $this->input->post('phoneno'),
'fathername' =>$this->input->post('fathername'),
'mothername' => $this->input->post('mothername'),
'email'=> $this->input->post('email'),
'qualification' =>$this->input->post('qualification'),
'status' => $status,
'teacherid'=> $this->input->post('teacherid'),
'gender'=> $this->input->post('gender'),
'status'=>'Active');
$this->load->model('StudentModel');
$message = $this->StudentModel->registerstudent($student_data);
$msg = "Student Created Successfully with Id:".strval($stdid). ". Assign Subject / Course.";

$this->load->model('CourseModel');
        $data['courses'] = $this->CourseModel->loadallcourses();
	$data['message'] = $msg;
	$data['studentid'] = $stdid;
	$data['studentname'] = $stdname;
        $this->load->view('StudentCourseView', $data);


}
public function assigncoursetostudent(){

$courseidname = $this->input->post('courseidname');
$delimiter = "-";
$parts = explode($delimiter, $courseidname);
$courseid = $parts[0];
$coursename= $parts[1];
$course_data = array(
'stdid'=> $this->input->post('stdid'),
'courseid' => $courseid,
'coursename' => $coursename,
'coursefee'=> $this->input->post('coursefee'),
'admissionfee' =>$this->input->post('admissionfee'),
'coursetype' => $this->input->post('coursetype'),
'admissiondate'=>$this->input->post('admissiondate'),
'status'=>'Active');

$this->load->model('StudentCourseModel');
$message = $this->StudentCourseModel->assigncourse($course_data);
$msg = "Course Assignment Done Successfully. Schedule the Class : ";
$data['message'] = $msg;
$data['studentid'] = $this->input->post('stdid');
$data['studentname'] = $this->input->post('studentname');
$data['courseid'] = $courseid;
$data['coursename'] = $coursename;
$this->load->view('StudentScheduleView', $data);
}

public function searchstudent(){

$stdid = $this->input->post('stdid');
$stdname = $this->input->post('stdname');
$op = $this->input->post('op');
$this->load->model('StudentModel');
$data['student'] = $this->StudentModel->getActiveStudentDetails($stdid, $stdname);
if($data['student']):
$studentid = $data['student']->stdid;
$this->load->model('CourseModel');
if($op==='CV'):
	$data['courses'] = $this->CourseModel->loadallcourses();
endif;
if($op==='AC'):
	$data['courses'] = $this->CourseModel->searchcourseforstudent($studentid);

endif;
$data['op'] = $op;
$this->load->view('StudentDetailsView', $data);
else:
	$data['op'] = $op;
	$data['message'] = "No Students Found with the given Search Criteria";
	$this->load->view('StudentDetailsView', $data);
endif;
}

public function searchstudentdetails(){
$stdid = $this->input->post('stdid');
$stdname = $this->input->post('stdname');
$this->load->model('StudentModel');
$data['student'] = $this->StudentModel->getStudentDetails($stdid, $stdname);
$this->load->view('SearchStudentforView', $data);
}

public function searchstudentdetailsforupdate(){
$stdid = $this->input->post('stdid');
$stdname = $this->input->post('stdname');
$this->load->model('StudentModel');
$data['student'] = $this->StudentModel->getActiveStudentDetails($stdid, $stdname);
$this->load->view('SearchStudentforUpdateView', $data);

}

public function loadstudentdetails(){
$stdid = $this->input->post('stdid');
$this->load->model('StudentModel');
$this->load->model('StudentCourseModel');
$this->load->model('StudentFeeModel');
$this->load->model('StudentAssignmentModel');
$stdname =null;
$data['student']=$this->StudentModel->getStudentDetails($stdid, $stdname);
$data['course']=$this->StudentCourseModel->getCourseDetails($stdid);
$data['fee']=$this->StudentFeeModel->getStudentPaymentDetails($stdid);
$data['assignment']=$this->StudentAssignmentModel->getStudentAssignmentDetails($stdid);
$this->load->view('StudentOnePageView', $data);
}

public function loadstudentdetailsupdate(){

$stdid = $this->input->post('stdid');
$this->load->model('StudentModel');
$this->load->model('StudentCourseModel');
$this->load->model('StudentFeeModel');
$this->load->model('StudentAssignmentModel');
$stdname =null;
$data['student']=$this->StudentModel->getStudentDetails($stdid, $stdname);
$this->load->view('StudentUpdatePageView', $data);

}

public function updatestudentdetails(){
$stdid = $this->input->post('stdid');
$data = array(
			'stdname'=>$this->input->post('stdname'),
			'fathername'=>$this->input->post('fathername'),
'mothername'=>$this->input->post('mothername'),
'email'=>$this->input->post('email'),
'phoneno'=>$this->input->post('phoneno'),
'status'=>$this->input->post('status'),
'dob'=>$this->input->post('dob'),
'gender'=>$this->input->post('gender'),
'address'=>$this->input->post('address'),
'school'=>$this->input->post('school'),
'class'=>$this->input->post('class'),
'qualification'=>$this->input->post('qualification')
			 );

$this->load->model('StudentModel');
$data['msg']=$this->StudentModel->updatestudent($stdid, $data);
$data['student'] = null;
$data['message']="Student Updated Successfully";
$this->load->view('SearchStudentforUpdateView', $data);

}

public function updatecourseofstudent(){
$stdid = $this->input->post('stdid');
$courseidname= $this->input->post('courseidname');
$oldcourseid= $this->input->post('oldcourseid');
$data['coursefee'] = $this->input->post('coursefee');
$data['coursetype'] = $this->input->post('stdid');
$delimiter = "-";
$parts = explode($delimiter, $courseidname);
$courseid = $parts[0];
$coursename= $parts[1];
$data['coursename'] = $coursename;
$data['courseid'] = $courseid;
$this->load->model('StudentCourseModel');
$this->load->model('StudentAssignmentModel');
$this->load->model('StudentFeeModel');
$this->StudentCourseModel->updatecoursedetails($stdid,$oldcourseid,$data);
$this->StudentAssignmentModel->updatecourseofassignment($stdid,$oldcourseid,$courseid,$coursename);
$this->StudentFeeModel->updatecourseoffee($stdid,$oldcourseid,$courseid,$coursename);
$data['student'] = null;
$data['op'] = 'CV';
$this->load->view('StudentDetailsView',$data);
}

public function removestudent(){
$stdid = $this->input->post('stdid');
$this->load->model('StudentCourseModel');
$this->load->model('StudentAssignmentModel');
$this->load->model('StudentModel');
$data['status']='Inactive';
$this->StudentModel->updatestudent($stdid,$data);
$this->StudentCourseModel->updatecoursestatus($stdid,$data);
$this->StudentAssignmentModel->updateAssignmentStatus($stdid,$data);
$data['student'] = null;
$data['op'] = 'RS';
$this->load->view('StudentDetailsView',$data);
}

public function updatecoursestate(){
$stdid = $this->input->post('stdid');
$courseid = $this->input->post('courseid');
$status = $this->input->post('status');
$this->load->model('StudentCourseModel');
if($status==='Active'):
	$data['status']='Inactive';
	$this->StudentCourseModel->updatecoursedetails($stdid,$courseid,$data);
else:
	$data['status']='Active';
	$this->StudentCourseModel->updatecoursedetails($stdid,$courseid,$data);
endif;
$this->loadstudentdetails();
}
public function updateassignmentstate(){

$stdid = $this->input->post('stdid');
$courseid = $this->input->post('courseid');
$status = $this->input->post('status');
$this->load->model('StudentAssignmentModel');
if($status==='Active'):
	$data['status']='Inactive';
	$this->StudentAssignmentModel->updateAssignmentStatusbycourse($stdid,$courseid,$data);
else:
	$data['status']='Active';
	$this->StudentAssignmentModel->updateAssignmentStatusbycourse($stdid,$courseid,$data);
endif;
$this->loadstudentdetails();
}
}