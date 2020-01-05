
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
		<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">
		<title>Spa Foods</title>

		<link href="<?php echo base_url(); ?>template/front/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- CSS -->
		<link href="<?php echo base_url(); ?>template/front/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/layerslider/css/layerslider.css" type="text/css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/lightslider.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/ui/jquery-ui.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/jquery.bxslider.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/jquery.scrollbar.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/styles.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/custom.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/custom-jquery.steps.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/jquery.fancybox.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/datepicker.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>template/front/css/line-icons.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="<?php echo base_url(); ?>template/front/js/jquery-1.12.4.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery-migrate.min.js"></script>
		<!-- <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script> -->
		<script src="<?php echo base_url(); ?>template/front/js/perfect-scrollbar.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.sticky.js"></script>
		<script src="<?php echo base_url(); ?>template/front/layerslider/js/greensock.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>template/front/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>template/front/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>template/front/js/lightslider.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.bxslider.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.scrollbar.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/ui/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery-common.utilities.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/app.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/shop.app.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/stepWizard.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.steps.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/bootstrap-notify.min.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/jquery.fancybox.pack.js"></script>
		<script src="<?php echo base_url(); ?>template/front/js/fancy-box.js"></script>
		<!-- <script src="<?php echo base_url(); ?>template/front/js/datepicker.js"></script> -->
		<script src="<?php echo base_url(); ?>template/front/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>template/front/js/locales/bootstrap-datepicker.th.js" type="text/javascript"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				$("#<?= $header_active ?>").addClass("active");
				FancyBox.initFancybox();
			});
			function check_login_stat(thing){
		        return $.ajax({
		            url: '<?php echo base_url(); ?>index.php/home/check_login/'+thing
		        });
		    }
			function set_cart_form(){
		        check_login_stat('langlat').success(function (data) { $('#langlat').val(data); });
		        check_login_stat('username').success(function (data) { $('#name').val(data); });
		        check_login_stat('email').success(function (data) { $('#email').val(data); });
		        check_login_stat('surname').success(function (data) { $('#surname').val(data); });
		        check_login_stat('phone').success(function (data) { $('#phone').val(data); });
		        check_login_stat('address1').success(function (data) { $('#address_1').val(data); });
		        check_login_stat('address2').success(function (data) { $('#address_2').val(data); });
		        check_login_stat('city').success(function (data) { $('#city').val(data); });
		        check_login_stat('zip').success(function (data) { $('#zip').val(data); });
		    }
		</script>
		<?php header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 ?>
	</head>