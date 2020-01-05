<?php 
	include 'includes_top.php'; 
?>
<body>
<?php
	include 'inc-header.php';

	$slider	 =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;

	if($page_name=="home" && $slider == 'ok')
	{
		include 'inc-largehero.php';
	}

	include $page_name.'.php';
	include("inc-footer.php"); 
	include 'script_text.php';
	include 'script.php'; 
?>
	</body>
</html>