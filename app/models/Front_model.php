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

	public function get_friend_request($user_id)
	{
		return $this->db->where('friend_requests.to_user_id', $user_id)
			->select("user.user_id as user_id, user.username as username, user.first_name as first_name, user.last_name as last_name, friend_requests.status, friend_requests.created_at, friend_requests.friend_request_id as friend_request_id")
			->join("user", "user.user_id = friend_requests.from_user_id")
			->limit(5)
			->order_By("friend_requests.friend_request_id", "DESC")
			->get("friend_requests");
	}

}

/* End of file Front_model.php */
/* Location: .//F/laragon/www/rebid/app/models/Front_model.php */