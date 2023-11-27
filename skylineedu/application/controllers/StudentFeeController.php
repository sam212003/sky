<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StudentFeeController extends CI_Controller {


public function loadstudentfeeview(){
$data['studentid'] = $this->input->post('stdid');
$data['studentname'] = $this->input->post('stdname');
$data['courseid'] = $this->input->post('courseid');
$data['coursename'] = $this->input->post('coursename');
$this->load->view('StudentFeeView',$data);

}

public function loadinitiateduepayment(){
$data['studentfee']=null;
$this->load->view('InitiateDuePaymentView',$data);

}

public function makepayment(){

$stdid = $this->input->post('stdid');
$stdname =  $this->input->post('stdname');
$courseid = $this->input->post('courseid');
$coursename = $this->input->post('coursename');
$paymentdate = $this->input->post('paymentdate');
$years = $this->input->post('year');
$months = $this->input->post('month');
$feeamounts = $this->input->post('feeamount');
$feetypes = $this->input->post('feetype');
$type= $this->input->post('type');
$this->load->model('StudentFeeModel');
$this->StudentFeeModel->updateoldpayments($stdid);
for ($i = 0; $i < count($years); $i++) {
      $this->StudentFeeModel->insertpayment($stdid,$stdname,$courseid,$coursename,$paymentdate,$years[$i], $months[$i],$feeamounts[$i],$feetypes[$i]);
    }

$data['studentid'] = $this->input->post('stdid');
$data['studentname'] = $this->input->post('stdname');
$data['courseid'] = $this->input->post('courseid');
$data['coursename'] = $this->input->post('coursename');
if($type=='CS')
{
$data['message'] = "Student ".$stdname." Registered Succesfully with Student id ".$stdid." in course ".$coursename;
$this->load->view('registerstudent_view', $data);
}
else{
$data['student'] = null;
$data['message'] = "Amount Paid Successfully";
$this->load->view('InitiatePaymentView', $data);
}
}

public function verifystudentforpay(){
$this->load->model('StudentFeeModel');
$stdid = $this->input->post('stdid');
$stdname = $this->input->post('stdname');
 $data['studentid'] = $stdid;
 $data['studentname']  = $stdname;
        $data['student'] = $this->StudentFeeModel->verifystudentforpay($stdid,$stdname);
        $this->load->view('InitiatePaymentView', $data);
}

public function fetchlastpayments(){
$this->load->model('StudentFeeModel');
$feetype = $this->input->post('feetype');
$data['studentfee'] = $this->StudentFeeModel->fetchLastPaymentsMonthly($feetype);
$this->load->view('InitiateDuePaymentView', $data);
}

public function searchreceivedfees(){
$data['stdfees']=null;
$this->load->view('SearchReceivedFeeInitiateView',$data);
}

public function fetchdailypaidfees()
{
$paymentdate = $this->input->post('paymentdate');
$this->load->model('StudentFeeModel');
$data['stdfees'] = $this->StudentFeeModel->fecthdailypaidfees($paymentdate);
$data['totalfee'] = $this->StudentFeeModel->fecthdailytotalfees($paymentdate);
$this->load->view('SearchReceivedFeeInitiateView',$data);
}
}