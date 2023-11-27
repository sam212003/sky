<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CourseController extends CI_Controller {

public function loadallcourses(){
$this->load->model('CourseModel');
$this->load->model('StudentCourseModel');
$stdid = $this->input->post('stdid');
$stdname = $this->input->post('stdname');
 $data['studentid'] = $stdid;
 $data['studentname']  = $stdname;
        $data['courses'] = $this->CourseModel->loadallcourses();
	$data['studentcourses']=$this->StudentCourseModel->getCourseDetails($stdid);
        $this->load->view('StudentCourseView', $data);
}

public function setcourse(){

$this->load->model('CourseModel');
 $data['stdid']= $this->input->post('stdid');
$data['stdname']= $this->input->post('stdname');
$data['courseid'] = $this->input->post('courseid');
$data['coursename'] = $this->input->post('coursename');
$data['coursefee'] = $this->input->post('coursefee');
$data['status'] = $this->input->post('status');
$data['coursetype'] = $this->input->post('coursetype');
$data['courses'] = $this->CourseModel->loadallcourses();
$this->load->view('StudentCourseUpdateView', $data);


}
public function loadregisterview(){
        $this->load->view('NewCourse_view');
    }

    public function NewCourse()
    {
        $courseid = mt_rand(100000, 999999);
        $type = $this->input->post('coursetype');
        $course_data = array(
        'courseid'=> $courseid,
        'coursename'=> $this->input->post('coursename'),
        'duration'=> $this->input->post('duration'),
        'totalfee' =>$this->input->post('totalfee'),
        'monthlyfee'=> $this->input->post('monthlyfee'),
        'admissionfee'=> $this->input->post('admissionfee'),
        'coursesub'=> $this->input->post('coursesub'),
        'type' => $type);


    $this->load->model('CourseModel');
    $message = $this->CourseModel->NewCourse($course_data);
    $msg = "Course assigned Successfully with Course Id:".strval($courseid);
    redirect("index.php/CourseController/loadregisterview");
    }

    public function initiateupdatecourse()
    {
        $data['course'] = null;
        $this->load->view('SearchCourseforupdate_view',$data);
    }

    public function searchcoursebycid()
    {
        $courseid=$this->input->post('courseid');
        $coursename=$this->input->post('coursename');
        $this->load->model('CourseModel');
        $data['course'] = $this->CourseModel->searchcoursebycid($courseid,$coursename);
        $this->load->view('SearchCourseforupdate_view',$data);
    }
   public function loadcoursedetails()
   {
        $courseid=$this->input->post('courseid');
        $this->load->model('CourseModel');
        $data['course']=$this->CourseModel->loadcoursedetails($courseid);
        $this->load->view('updatecourse_view',$data);
   }

    public function updatecoursedetails()
    {
        $courseid=$this->input->post('courseid');
        $coursename=$this->input->post('coursename');
        $duration=$this->input->post('duration');
        $totalfee=$this->input->post('totalfee');
        $monthlyfee=$this->input->post('monthlyfee');
        $admissionfee=$this->input->post('admissionfee');
        $coursesub=$this->input->post('coursesub');
        $this->load->model('CourseModel');
        $data['course'] = $this->CourseModel->updatecoursedetails($courseid,$coursename,$duration,$totalfee, $monthlyfee,$admissionfee,$coursesub);
        $this->load->view('SearchCourseforupdate_view',$data);
    }

    public function initiatecourseview()
    {
        $data['course'] = null;
        $this->load->view('course_view',$data);
    }
   
    public function viewcoursebyid()
    {
        $courseid=$this->input->post('courseid');
        $coursename=$this->input->post('coursename');
        $this->load->model('CourseModel');
        $data['course'] = $this->CourseModel->viewcoursebyid($courseid,$coursename);
        $this->load->view('course_view',$data);
    }

    public function loadcourseview()
    {
         $courseid=$this->input->post('courseid');
         $this->load->model('CourseModel');
         $data['course']=$this->CourseModel->loadcoursedetails($courseid);
         $this->load->view('view_courseonly',$data);
    }
}