<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library('session');
		$this->load->model('front_model');
	}

	public function index()
	{
		$data['page_name'] = 'home';
        $data['page_title'] = get_phrase('home');
        $this->load->view('index', $data);
	}

	public function profile()
	{
		$username = $this->uri->segment(1);
		$task = $this->uri->segment(2);

		if (empty($username)) {
            $this->displayPageNotFound();
        }

        if ($this->core_model->is_username($username, 'user') == 'available') {
        	if ($task == 'edit') {
        		if ($this->session->userdata('username') != $username) {
            		$this->session->set_userdata('last_page', current_url());
            		redirect(base_url(), 'refresh');
        		}
        		$data['profile_info'] = $this->front_model->select_profile_by_username($username, 'user');
				$data['page_name'] = 'profile_edit';
        		$data['page_title'] = get_phrase('edit_profile');
				$this->load->view('index', $data);
        	} else {
				$data['profile_info'] = $this->front_model->select_profile_by_username($username, 'user');
				$data['page_name'] = 'profile';
        		$data['page_title'] = get_phrase('profile');
				$this->load->view('index', $data);
			}
		} else {
			$this->displayPageNotFound();
		}
	}

	protected function displayPageNotFound()
	{
        show_404();
    }

}

/* End of file Front.php */
/* Location: .//F/laragon/www/rebid/app/controllers/Front.php */