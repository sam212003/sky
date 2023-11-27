<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CourseModel extends CI_Model {

    public function loadallcourses() {
	$query = $this->db->get('course');
        return $query->result();
	    }
	public function searchcourseforstudent($stdid) {
	$this->db->select("*");
	$this->db->from('studentcourse');
 	$this->db->where('stdid', $stdid);
	$this->db->where('status', 'Active');
	$query = $this->db->get();
        return $query->result();
	    }


 public function NewCourse($course_data) 
    {
           return $this->db->insert('course', $course_data);
    }
    public function searchcoursebycid($courseid,$coursename)
    {
        $this->db->select('*');
        $this->db->from('course');

        if ($courseid) {
            $this->db->where('courseid', $courseid);
        }

        if ($coursename) {
            $this->db->like('coursename', $coursename);
        }

        $query = $this->db->get();
        return $query->row();  
    }

    public function loadcoursedetails($courseid)
    {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->WHERE('courseid',$courseid);
        $query = $this->db->get();
        return $query->row();
    }

    public function updatecoursedetails($courseid,$coursename,$duration,$totalfee, $monthlyfee,$admissionfee,$coursesub)
    {
        $this->db->set('coursename',$coursename);
        $this->db->set('duration',$duration);
        $this->db->set('totalfee',$totalfee);
        $this->db->set('monthlyfee',$monthlyfee);
        $this->db->set('admissionfee',$admissionfee);
        $this->db->set('coursesub',$coursesub);
        $this->db->where('courseid',$courseid);
        $this->db->update('course');
    }

    public function viewcoursebyid($courseid,$coursename)
    {
        $this->db->select('*');
        $this->db->from('course');

        if ($courseid) {
            $this->db->where('courseid', $courseid);
        }

        if ($coursename) {
            $this->db->like('coursename', $coursename);
        }

        $query = $this->db->get();
        return $query->row();  
    }
    public function loadcourseview($courseid)
    {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->WHERE('courseid',$courseid);
        $query = $this->db->get();
        return $query->row();
    }

}