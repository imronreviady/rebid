<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_model extends CI_Model {

	public function select_profile_by_username($username = '', $account_type = '')
	{
		return $this->db->get_where($account_type, array('username' => $username))->result_array();
	}	

}

/* End of file Front_model.php */
/* Location: .//F/laragon/www/rebid/app/models/Front_model.php */