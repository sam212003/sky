
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        // Check if the user is already logged in
        if ($this->session->userdata('user_id')) {
            redirect('dashboard'); // Redirect to the dashboard page
        } else {
            $this->load->view('login'); // Load the login view
        }
    }

    public function login() {
        // Check user credentials (you should implement proper authentication logic here)
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username === 'user' && $password === 'password') {
            $user_data = array(
                'user_id' => 1,
                'username' => $username,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($user_data);
            redirect('dashboard');
        } else {
            // Invalid login
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy(); // Destroy session data
        redirect('auth');
    }
}