<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	public function loadAjax($view, $data = array(), $die = 0)
	{
		$CI =& get_instance();
		$CI->load->view($view, $data);
		if($die) die($CI->output->get_output());
	}

}

/* End of file Template.php */
/* Location: .//F/laragon/www/rebid/app/libraries/Template.php */
