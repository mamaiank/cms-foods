<!DOCTYPE html>
<!--[if IE 8]> <html lang="th" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="th" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="th"> <!--<![endif]-->
<head>

    <meta name="google-site-verification" content="9tKpQFOwbbxUksHqAr98ajm1bV23Ji5Kvh9PpYvWdcI" />
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $description; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->description; } ?> ?>">
    <meta name="keywords" content="<?php echo $keywords; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->keywords; } ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="revisit-after" content="<?php echo $revisit_after; ?> days">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="expires" content="Mon, 10 Dec 2001 00:00:00 GMT" />
    <title><?php echo $page_title; ?> | <?php echo $system_title; ?></title>
    <style>
		html, body{
			overflow: hidden;
			height: 100%;
		}
	</style>

    <?php
    if($page_name == 'gallery_view'){
        foreach($gallery_category_one as $row){
            ?>
            <!-- Schema.org markup for Google+ -->
            <meta itemprop="name" content="<?php echo $row['c_gallery_title']; ?>">
            <meta itemprop="description" content="<?php echo strip_tags($row['c_gallery_description']); ?>">
            <meta itemprop="image" content="<?php echo $this->crud_model->file_view('gallery_category',$row['c_gallery_id'],'','','no','src','multi','one'); ?>">

            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="@publisher_handle">
            <meta name="twitter:title" content="<?php echo $row['c_gallery_title']; ?>">
            <meta name="twitter:description" content="<?php echo strip_tags($row['c_gallery_description']); ?>">
            <!-- Twitter summary card with large image must be at least 280x150px -->
            <meta name="twitter:image:src" content="<?php echo $this->crud_model->file_view('gallery_category',$row['c_gallery_id'],'','','no','src','multi','one'); ?>">

            <!-- Open Graph data -->
            <meta property="og:title" content="<?php echo $row['c_gallery_title']; ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/gallery/<?php echo $row['c_gallery_id']; ?>" />
            <meta property="og:image" content="<?php echo $this->crud_model->file_view('gallery_category',$row['c_gallery_id'],'','','no','src','multi','one'); ?>" />
            <meta property="og:description" content="<?php echo strip_tags($row['c_gallery_description']); ?>" />
            <meta property="og:site_name" content="<?php echo $row['c_gallery_title']; ?>" />
            <?php
        }
    }
    ?>


    <?php
    if($page_name == 'event_activity_view'){
        foreach($activity_one as $row)
        {
            ?>
            <!-- Schema.org markup for Google+ -->
            <meta itemprop="name" content="<?php echo $row['activity_name']; ?>">
            <meta itemprop="description" content="<?php echo strip_tags($row['activity_detail']); ?>">
            <meta itemprop="image" content="<?php echo $this->crud_model->file_view('event_activity',$row['id'],'','','no','src','multi','one'); ?>">

            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="@publisher_handle">
            <meta name="twitter:title" content="<?php echo $row['activity_name']; ?>">
            <meta name="twitter:description" content="<?php echo strip_tags($row['activity_detail']); ?>">
            <!-- Twitter summary card with large image must be at least 280x150px -->
            <meta name="twitter:image:src" content="<?php echo $this->crud_model->file_view('event_activity',$row['id'],'','','no','src','multi','one'); ?>">

            <!-- Open Graph data -->
            <meta property="og:title" content="<?php echo $row['activity_name']; ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/event_activity/<?php echo $row['id']; ?>" />
            <meta property="og:image" content="<?php echo $this->crud_model->file_view('event_activity',$row['id'],'','','no','src','multi','one'); ?>" />
            <meta property="og:description" content="<?php echo strip_tags($row['activity_detail']); ?>" />
            <meta property="og:site_name" content="<?php echo $row['activity_name']; ?>" />
            <?php
        }
    }
    ?>

    <?php 
		if($page_name == 'product_view'){
			foreach($product_data as $row)
			{
	?>
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $row['title']; ?>">
        <meta itemprop="description" content="<?php echo strip_tags($row['description']); ?>">
        <meta itemprop="image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
        
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="<?php echo $row['title']; ?>">
        <meta name="twitter:description" content="<?php echo strip_tags($row['description']); ?>">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
        
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $row['title']; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/product_view/<?php echo $row['product_id']; ?>" />
        <meta property="og:image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>" />
        <meta property="og:description" content="<?php echo strip_tags($row['description']); ?>" />
        <meta property="og:site_name" content="<?php echo $row['title']; ?>" />
    <?php
			}
		} 
        if($page_name == 'vendor_home'){
            $vendor_data = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->result_array();
            foreach($vendor_data as $row)
            {
	?>
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $row['display_name']; ?>">
        <meta itemprop="description" content="<?php echo strip_tags($row['description']); ?>">
        <meta itemprop="image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
        
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="<?php echo $row['display_name']; ?>">
        <meta name="twitter:description" content="<?php echo strip_tags($row['description']); ?>">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
        
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $row['display_name']; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/vendor/<?php echo $row['vendor_id']; ?>" />
        <meta property="og:image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png" />
        <meta property="og:description" content="<?php echo strip_tags($row['description']); ?>" />
        <meta property="og:site_name" content="<?php echo $system_title; ?>" />
    <?php
            }
        }
    ?>
    
    <!-- Favicon -->
    <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">
    <?php
        $this->minify->css(array('front/assets/plugins/bootstrap/css/bootstrap.min.css',
                                'front/assets/css/app.css',
                                'front/assets/css/ie8.css',
                                'front/assets/css/blocks.css',
                                'front/assets/css/plugins.css',
                                'front/assets/css/plugins/animate.css',
                                'front/assets/css/plugins/box-shadows.css',
                                'front/assets/css/headers/header-purple.css',
                                'front/assets/css/headers/header-blue.css',
                                'front/assets/css/headers/header-green.css',
                                'front/assets/css/headers/header-grey.css',
                                'front/assets/css/headers/header-aqua.css',
                                'front/assets/css/headers/header-pink.css',
                                'front/assets/css/footers/footer-purple.css',
                                'front/assets/css/footers/footer-blue.css',
                                'front/assets/css/footers/footer-green.css',
                                'front/assets/css/footers/footer-grey.css',
                                'front/assets/css/footers/footer-aqua.css',
                                'front/assets/css/footers/footer-pink.css',
                                'front/assets/css/style.css',
                                'front/assets/plugins/jquery-steps/css/custom-jquery.steps.css',
                                'front/assets/plugins/line-icons/line-icons.css',
                                'front/assets/plugins/scrollbar/src/perfect-scrollbar.css',
                                'front/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css',
                                'front/assets/plugins/revolution-slider/rs-plugin/css/settings.css',
                                'front/assets/css/pages/profile.css',
                                'front/assets/css/app.css',
                                'front/assets/css/pages/page_contact.css',
                                'front/assets/plugins/flexslider/flexslider.css',
                                'front/assets/plugins/noUiSlider/jquery.nouislider.css',
                                'front/assets/css/plugins.css',
                                'front/assets/plugins/parallax-slider/css/parallax-slider.css',
                                'front/assets/css/pages/page_log_reg_v2.css',
                                'front/assets/plugins/ladda-buttons/css/custom-lada-btn.css',
                                'front/assets/css/plugins/hover-effect/css/custom-hover-effects.css',
                                'front/assets/plugins/zoompic/multizoom.css',
                                'front/assets/css/theme-colors/default.css',
                                'front/assets/css/custom.css',
                                'front/assets/plugins/noUiSlider/jquery.nouislider.css',
                                'front/assets/plugins/ionrangeslider/css/normalize.css',
                                'front/assets/plugins/ionrangeslider/css/ion.rangeSlider.css',
                                'front/assets/plugins/fancybox/source/jquery.fancybox.css',
                                'front/assets/js/share/jquery.share.css',
                                'front/assets/plugins/zoome/css/zoome-min.css',
                                'front/layerslider/assets/css/doc.css',
                                'front/assets/plugins/image-hover/css/img-hover.css',
                                'front/assets/plugins/jquery-ui/jquery-ui.min.css',
                                'front/assets/plugins/glasscase/css/glasscase.css',
                            ));
        echo $this->minify->deploy_css($rebuild);
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/pages/log-reg-v3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/css/ion.rangeSlider.skinModern.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/shop.style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    

    <?php                 
        $this->minify->js(array(
                            'front/assets/plugins/jquery/jquery.min.js',
                            'front/assets/plugins/jquery-ui/jquery-ui.min.js',
                            'front/assets/js/share/jquery.share.js',
                            'front/assets/plugins/zoome/zoome.js'
                    ));
        echo $this->minify->deploy_js($rebuild, 'top_home_scripts.min.js');

    ?>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700,900' rel='stylesheet' type='text/css'>
	<link href="http://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400italic,400,600italic,600,700italic,700,800italic,800" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>


    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-82047906-1', 'auto');
        ga('send', 'pageview');

    </script>

    
</head>
<?php
    $theme_color =  $this->db->get_where('ui_settings',array('type' => 'header_color'))->row()->value;
?>
