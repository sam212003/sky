<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function check_session() {
    $CI = get_instance();
    if (!$CI->session->userdata('user_id')) {
        redirect('user/login'); // Redirect to login page if user is not logged in
    }
}