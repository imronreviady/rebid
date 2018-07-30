<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_model extends CI_Model {

	public function select_profile_by_username($username = '')
	{
		return $this->db->get_where('user', array('username' => $username))->result_array();
	}

	public function validate_add_friend_request($from = '', $to = '')
	{
		if ($this->session->userdata('login') != 1) {
			return 'not_login';
		} else {

			$data['from_user_id'] = $from;
			$data['to_user_id'] = $to;
			$data['status'] = 'pending';

			$query = $this->db->insert('friend_requests', $data);

			if ($this->db->affected_rows($query) == 1) {
				return 'success';
			}
		}
	}

	public function getListFriendRequest($user_id = '')
	{
		return $this->db->get_where('friend_requests', array('to_user_id' => $user_id))->join('user', 'friend_requests.from_user_id = user.user_id', 'left')->result_array();
	}

}

/* End of file Front_model.php */
/* Location: .//F/laragon/www/rebid/app/models/Front_model.php */