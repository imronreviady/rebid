<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function send_sms($message = '', $reciever_phone = '')
	{
		$clickatell_user = $this->db->get_whare('settings', array('type' => 'clickatell_user'))->row()->description;
		$clickatell_password = $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;
        $clickatell_api_id = $this->db->get_where('settings', array('type' => 'clickatell_api_id'))->row()->description;
        $clickatell_baseurl = "http://api.clickatell.com";

        $text = urlencode($message);
        $to = $reciever_phone;

        $url = "$clickatell_baseurl/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id";

        $ret = file($url);

        $sess = explode(":",$ret[0]);
        print_r($sess);echo '<br>';

        if ($sess[0] == "OK") {
        	$sess_id = trim($sess[1]); // remove any whitespace
            $url = "$clickatell_baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";

            // do sendmsg call
            $ret = file($url);
            $send = explode(":",$ret[0]);
            print_r($send);echo '<br>';
            if ($send[0] == "ID") {
                echo "successnmessage ID: ". $send[1];
            } else {
                echo "send message failed";
            }
        } else {
        	echo "Authentication failure: ". $ret[0];
        }
	}

}

/* End of file Sms_model.php */
/* Location: ./application/models/Sms_model.php */