<meta charset="utf-8">
		<footer>
			<div class="sf-sitebar">
				<div class="container">
					<ul class="list-footer">
						<li><a href="<?php echo base_url(); ?>index.php/home/"><?php echo translate('Home'); ?></a></li>
						<li><a href="<?php echo base_url(); ?>index.php/home/about"><?php echo translate('About Us'); ?></a></li>
                        <?php
                            $this->db->order_by('category_id', 'asc');
                            $category = $this->db->get('category')->result_array();
                            foreach ($category as $row): 
                            $title = $this->nookcs_model->getDataMultiLanguage($row['category_name'],$row['category_name_en']);
                            $sub_category = $this->db->get_where('sub_category', array('category' => $row['category_id']))->row();
                        ?>
                            <li><a href="<?php echo base_url(); ?>index.php/home/spafoods/<?= $sub_category->sub_category_id ?>"><?= $title ?></a></li>
                        <?php
                            endforeach;
                        ?>
						<li><a href="<?php echo base_url(); ?>index.php/home/restaurant_overview"><?php echo translate('Restaurants & Services'); ?></a></li>
						<li><a href="<?php echo base_url(); ?>index.php/home/news_event"><?php echo translate('News & Events'); ?></a></li>
						<li><a href="<?php echo base_url(); ?>index.php/home/health"><?php echo translate('Health Corner'); ?></a></li>
						<li><a href="<?php echo base_url(); ?>index.php/home/founder"><?php echo translate('Message From Founder'); ?></a></li>
						<li><a href="<?php echo base_url(); ?>index.php/home/contact"><?php echo translate('Contact Us'); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="sf-address-copyright">
				<div class="container">
					<div class="address">
						<address>
							<strong>Nutrition House Co Ltd.</strong><br>
							611/277 - 279 Soi Watchannai (Rajuthit), Bangklo, Bangkholeam, Bangkok 10120. Thailand<br>
							Telephone: (662) 689-9612 Fax: (662) 689-9616<br>
							E-mail: info@nutritionhouse.co.th
						</address>
					</div>
					<div class="copyright">
						Copyright by nutritionhouse.co.th 2006 All rights reserved
					</div>
				</div>
			</div>
		</footer>
		<!-- BackToTop Button -->
		<a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">
		<span class="sr-only">Top</span> <i class="fa fa-angle-up" aria-hidden="true"></i>
		</a>

        <!-- Modal -->
        <div class="modal fade" id="v_registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div id='ajvlup'></div>
        </div>
        <!-- End Modal -->

        <!-- Modal -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div id='ajlin'></div>
        </div>
        <!-- End Modal -->

        <!-- Modal -->
        <div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div id='ajlup'></div> 
        </div>
        <!-- End Modal -->

<script>
	backToTop();

	    <?php
        $volume = $this->crud_model->get_type_name_by_id('general_settings','50','value');
        if($this->crud_model->get_type_name_by_id('general_settings','49','value') == 'ok'){
    ?>
        function sound(type){
            document.getElementById(type).volume = <?php if($volume == '10'){ echo 1 ; }else{echo '0.'.round($volume); } ?>;
            document.getElementById(type).play();
        }
    <?php
        } else {
    ?>
        function sound(type){}
    <?php
        }
    ?>
</script>
<?php
    $audios = scandir('uploads/audio/home/');
    foreach ($audios as $row) {
        if($row !== '' && $row !== '.' && $row !== '..'){
            $row = str_replace('.mp3', '', $row);
?>
<audio style='display:none;' id='<?php echo $row; ?>' ><source type="audio/mpeg" src="<?php echo base_url(); ?>uploads/audio/home/<?php echo $row; ?>.mp3"></audio>
<?php
        }
    }
?>

<?php
if ($page_name=="invoice"){
    ?>
    <script type="text/javascript">
        $(function () {
            $.fancybox.open([
                {

                    padding : 0,
                    href: '<?php echo base_url(); ?>/index.php/home/thankyou',
                    type: 'iframe'


                }
            ], {
                helpers : {
                    thumbs : {
                        width  : 50,
                        height : 50
                    }
                }
            },{
                padding: 0
            });

        });
    </script>
    <?php
}
    ?>

    <script>
    	$( document ).ready(function() {
        FancyBox.initFancybox(); 
    });
    </script>