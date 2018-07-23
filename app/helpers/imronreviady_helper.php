<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * encode_str
 * @return string
 */
if (!function_exists('encode_str')) {
	function encode_str($str) {
		$CI = &get_instance();
		$CI->load->library('encrypt');
		$ret = $CI->encrypt->encode($str, $CI->config->item('encryption_key'));
		$ret = strtr($ret, array('+' => '.', '=' => '-', '/' => '~'));
		return $ret;
	}
}

/**
 * decode_str
 * @return string
 */
if (!function_exists('decode_str')) {
	function decode_str($str) {
		$CI = &get_instance();
		$CI->load->library('encrypt');
		$str = strtr($str, array('.' => '+', '-' => '=', '~' => '/'));
		return $CI->encrypt->decode($str, $CI->config->item('encryption_key'));
	}
}

/**
 * indo_date
 * @return string
 */
if (!function_exists('indo_date')) {
	function indo_date($date) {
		if (is_valid_date($date)) {
			$parts = explode("-", $date);
			$result = $parts[2] . ' ' . bulan($parts[1]) . ' ' . $parts[0];
			return $result;
		}
		return '';
	}
}

/**
 * english_date
 * @return string
 */
if (!function_exists('english_date')) {
	function english_date($date) {
		if (is_valid_date($date)) {
			$parts = explode("-", $date);
			$result = $parts[2] . ', ' . month($parts[1]) . ' ' . $parts[0];
			return $result;
		}
		return '';
	}
}

/**
 * Day Name
 * @return string
 */
if (! function_exists('day_name')) {
	function day_name($idx) {
		$arr = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu'];
		return $arr[$idx];
	}
}

/**
 * is_valid_date
 * @return string
 */
if (!function_exists('is_valid_date')) {
	function is_valid_date($date) {
		if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
			return checkdate($parts[2], $parts[3], $parts[1]) ? true : false;
		}
		return false;
	}
}

/**
 * bulan
 * @return string
 */
if (!function_exists('bulan')) {
	function bulan($key = '') {
		$data = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'Nopember',
			'12' => 'Desember',
		];
		return $key === '' ? $data : $data[$key];
	}
}

/**
 * month
 * @return string
 */
if (!function_exists('month')) {
	function month($key = '') {
		$data = [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		];
		return $key === '' ? $data : $data[$key];
	}
}

/**
 * get_ip_address
 * @return string
 */
if (! function_exists('get_ip_address')) {
	function get_ip_address() {
		return getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
	}
}

/**
 * check_internet_connection
 * @return bool
 */
if (! function_exists('check_internet_connection')) {
	function check_internet_connection() {
		return checkdnsrr('google.com');
	}
}

/**
 * array_date
 * @return array
 */
if ( ! function_exists('array_date')) {
   function array_date($start, $end) {
      $range = [];    
      if (is_valid_date($start))
         $start = strtotime($start);
      if (is_valid_date($end) ) 
         $end = strtotime($end);      
      if ($start > $end) 
         return array_date($end, $start);     
      do {
         $range[] = date('Y-m-d', $start);
         $start = strtotime("+ 1 day", $start);
      }
      while($start <= $end);      
      return $range;
   }
}

/**
 * delete_cache
 * @return void
 */
if (! function_exists('delete_cache')) {
	function delete_cache() {
		$CI = &get_instance();
		$CI->load->helper('directory');
		$path = APPPATH . 'cache';
		$files = directory_map($path, FALSE, TRUE);
		foreach ($files as $file) {
			if ($file !== 'index.html' && $file !== '.htaccess') {
				@chmod($path . '/' . $file, 0777);
				@unlink($path . '/' . $file);
			}
		}
	}
}

/**
 * copyright
 * @return string
 */
if (!function_exists('copyright')) {
	function copyright($year = '', $link = '', $company = '') {
		if ($year != '') {
			if (strlen($year) != 4 || !is_numeric($year)) {
				return;
			}
		}
		$start = $year == '' ? date('Y') : $year;
		define('CREATED', $start);
		$string = 'Copyright &copy; ';
		$string .= date('Y') > CREATED ? CREATED . ' - ' . date('Y') : CREATED;
		$string .= '<a href="';
		$string .= $link == '' ? base_url() : $link;
		$string .= '"> ';
		$string .= $company == '' ? str_replace(array('http://', 'https://'), '', rtrim(base_url(), '/')) : $company;
		$string .= '</a>';
		$string .= ' All rights reserved.';
		return $string;
	}
}
