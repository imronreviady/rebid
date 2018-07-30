<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library('session');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
	}

	public function ajax_login()
	{
		$response = array();
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$response['submitted_data'] = $this->input->post();

		$login_status = $this->validate_login($email, $password);
		$response['login_status'] = $login_status;
		if ($login_status == 'success') {

			$query = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')));
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$data = array();

				$data['status'] = "online";
				$data['ip_address'] = get_ip_address();
				$this->db->update('user', $data);
			}

			$response['redirect_url'] = $this->session->userdata('last_page');
		}

		echo json_encode($response);
	}

	public function validate_login($email = '', $password = '')
	{
		$credential = array('email' => $email, 'password' => sha1($password));

		// Checking login credential for Admin
		/*$query = $this->db->get_where('admin', $credential);
		if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->is_deleted == 'true' && $row->is_active == 'false') {
            	return 'bannad';
            } elseif ($row->is_deleted == 'true') {
            	return 'suspend';
            } elseif ($row->is_active == 'false') {
            	return 'inactive';
            } else {
            	$this->session->set_userdata('admin_login', '1');
            	$this->session->set_userdata('login_user_id', $row->admin_id);
            	$this->session->set_userdata('first_name', $row->first_name);
            	$this->session->set_userdata('last_name', $row->last_name);
            	$this->session->set_userdata('email', $row->email);
            	$this->session->set_userdata('username', $row->username);
            	$this->session->set_userdata('login_type', 'admin');
            	return 'success';
            }
        }*/

        // Checking login credential for User
        $query = $this->db->get_where('user', $credential);
		if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->is_deleted == 'true' && $row->is_active == 'false') {
            	return 'bannad';
            } elseif ($row->is_deleted == 'true') {
            	return 'suspend';
            } elseif ($row->is_active == 'false') {
            	return 'inactive';
            } else {
            	$this->session->set_userdata('login', '1');
            	$this->session->set_userdata('user_id', $row->user_id);
            	$this->session->set_userdata('first_name', $row->first_name);
            	$this->session->set_userdata('last_name', $row->last_name);
            	$this->session->set_userdata('email', $row->email);
            	$this->session->set_userdata('username', $row->username);
            	$this->session->set_userdata('login_type', $row->role);
            	return 'success';
            }
        }

        return 'invalid';
	}

	public function four_zero_four()
	{
		$this->load->view('four_zero_four');
	}

	public function reset_password()
	{
		$account_type = $this->input->post('account_type');
		if ($account_type == '') {
			redirect(base_url(), 'refresh');
		}
		$email = $this->input->post('email');
		$result = $this->email_model->password_reset_email($account_type, $email);
		if ($result == true) {
			$this->session->set_flashdata('message', get_phrase('password_sent'));
		} elseif ($result == false) {
			$this->session->set_flashdata('message', get_phrase('account_not_found'));
		}

		redirect(base_url(), 'refresh');
	}

	public function logout()
	{
		$query = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$data = array();

			$data['status'] = "disconnected";
			$this->db->update('user', $data);
		}

		$this->session->sess_destroy();
        $this->session->set_flashdata('message', 'logged_out');
        redirect(base_url(), 'refresh');
	}

}

/* End of file Login.php */
/* Location: .//F/laragon/www/rebid/app/controllers/Login.php */