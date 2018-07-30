<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function clear_cache()
	{
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}

	public function get_image_url($id = '')
	{
		if (file_exists('uploads/user_image/' . $id . '.jpg')) {
			$image_url = base_url() . 'uploads/user_image/' . $id . '.jpg';
		} else {
			$image_url = base_url() . 'uploads/avatar.jpg';
		}

		return $image_url;
	}

	public function is_active($id = '')
	{
		$query = $this->db->get_where('user', array('user_id' => $id));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->is_active;
		}
	}

	public function is_username($username = '')
	{
		$query = $this->db->get_where('user', array('username' => $username));
		if ($query->num_rows() > 0) {
			return "available";
		} else {
			return "unavailable";
		}
	}

	public function is_email($email='')
	{
		$query = $this->db->get_where('user', array('email' => $email));
		if ($query->num_rows() > 0) {
			return "available";
		} else {
			return "unavailable";
		}
	}

}

/* End of file Core_model.php */
/* Location: ./application/models/Core_model.php */