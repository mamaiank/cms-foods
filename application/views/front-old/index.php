<?php
	// Turn TRUE when working in CSS and JS files
	$css_development =  TRUE;
	
	// Trun TRUE once worked with CSS and JS. 
	// Again turn FALSE to rebuiled minified faster loading CSS and JS
	$rebuild		 =	FALSE;
	
	$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
	$description	 =  $this->db->get_where('general_settings',array('type' => 'meta_description'))->row()->value;
	$keywords		 =  $this->db->get_where('general_settings',array('type' => 'meta_keywords'))->row()->value;
	$author			 =  $this->db->get_where('general_settings',array('type' => 'meta_author'))->row()->value;
	$system_name	 =  $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
	$system_title	 =  $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
	$revisit_after	 =  $this->db->get_where('general_settings',array('type' => 'revisit_after'))->row()->value;
	$slider	 =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;
	$page_title		 =  str_replace('_',' ',$page_title);
	$this->crud_model->check_vendor_mambership();
	if($page_name == 'product_view'){
		$keywords	 .= $product_tags;
	}
	if($css_development == TRUE){
		include 'includes_top.php';
	} else {
		include 'includes_top_n.php';
	}
	include 'preloader.php';
	include 'header.php';

	if($page_name=="home" && $slider == 'ok')
	{
		include 'slider.php';
	}
	include $page_name.'.php';

	//include 'chat.php';
	include 'footer.php';
	include 'script_texts.php';

	?>
<style>

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {
        .facebook-popup{
            position: fixed;
            right: 70px;
            bottom: -500px;
            z-index: 99999;
        }
    }
    /* Small Devices, Tablets */
    @media only screen and (min-width : 320px) {
        .facebook-popup{
            position: fixed;
            right: 45px;
            bottom: -500px;
            z-index: 99999;
        }
    }
</style>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.8&appId=1194886733920083";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="facebook-popup">
        <div class="fbm" data-fbm=""><img src="<?php echo base_url(); ?>/images/fbm.png"></div>
        <div class="fb-page"
             data-tabs="messages,timeline,events"
             data-href="https://www.facebook.com/heelcare/"
             data-width="380"
             data-hide-cover="false"></div>
    </div>

<script>
    $(function() {
        $(document).on("click", '.fbm', function(event) {
            $('.fbm').someFunction();
        });
    });

    $.fn.someFunction = function(){
        this.each(function(){
            // only handle "someElement"
            if (false == $(this).hasClass("close-fbm")) {
                $(this).addClass('close-fbm');
                $('.facebook-popup').css('bottom',0);
                return $('.facebook-popup'); // do nothing
            }else{
                $(this).removeClass('close-fbm');
                $('.facebook-popup').css('bottom','-500px');
                return $('.facebook-popup'); // do nothing
            }
        });
    };
</script>
<?php
	if($css_development == TRUE){
		include 'includes_bottom.php';
	} else {
		include 'includes_bottom_n.php';
	}
?>