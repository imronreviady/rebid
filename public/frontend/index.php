<?php
$system_name    = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_title   = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
$text_align     = $this->db->get_where('settings', array('type' => 'text_align'))->row()->description;
$account_type   = $this->session->userdata('login_type');
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title><?=$system_title?></title>

	<!-- Required meta tags always come first -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<?php include 'common/includes_head.php'; ?>

</head>
<body <?php if ($this->session->userdata('admin_login') != '1') echo 'class="body-bg-white"';?>>

	<?php include $page_name . '.php'; ?>

	<?php include 'common/includes_bottom.php'; ?>

</body>
</html>