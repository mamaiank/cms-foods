<meta charset="utf-8">
		<header id="sticky">
			<div class="sf-topbar">
				<div class="container">
					<div class="site-name text-uppercase pull-left hidden-xs"><?php echo translate('Nutrition House Co.,Ltd.'); ?></div>
					<div class="group-link pull-right">
						<span class="" id="loginsets">
                        </span>
						<a class="list-inline shop-badge badge-lists badge-icons" id="added_list">
                		</a>
                		<a href="<?php echo base_url(); ?>index.php/home/confirm_payment/" class="link-th">
                            <?php echo translate('confirm_payment'); ?>
                        </a>
						<a class="link-th" href="<?php echo base_url(); ?>index.php/home/set_language/Thai"><?php echo translate('TH'); ?></a>
						<span class="dash-v">|</span>
						<a class="link-en" href="<?php echo base_url(); ?>index.php/home/set_language/english"><?php echo translate('EN'); ?></a>
						<a class="link-fb" target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','1','value') ? $this->crud_model->get_type_name_by_id('social_links','1','value') : 'javascript:void(0)'; ?>">
							<i class="fa fa-facebook" aria-hidden="true"></i> 
							<span class="sr-only"><?php echo translate('Facebook'); ?></span>
						</a>
						<a class="link-tw" target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','3','value') ? $this->crud_model->get_type_name_by_id('social_links','3','value') : 'javascript:void(0)'; ?>">
							<i class="fa fa-twitter" aria-hidden="true"></i> 
							<span class="sr-only"><?php echo translate('Twitter'); ?></span>
						</a>
						<a class="link-ig" target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','7','value') ? $this->crud_model->get_type_name_by_id('social_links','7','value') : 'javascript:void(0)'; ?>">
							<i class="fa fa-instagram" aria-hidden="true"></i> 
							<span class="sr-only"><?php echo translate('Instagram'); ?></span>
						</a>
						<a class="link-yt" target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','6','value') ? $this->crud_model->get_type_name_by_id('social_links','6','value') : 'javascript:void(0)'; ?>">
							<i class="fa fa-youtube" aria-hidden="true"></i> 
							<span class="sr-only"><?php echo translate('Youtube'); ?></span>
						</a>
					</div>
				</div>
			</div>
			<div class="sf-middlebar hidden-xs">
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<div class="text-brand-left"><?php echo translate('Meat Alternative from'); ?><br><?php echo translate('Non GMOs Protein'); ?></div>
						</div>
						<?php
							$home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
						?>
						<div class="col-sm-4">
							<a class="logo-brand" href="<?php echo base_url(); ?>index.php/home/Thai">
								<img class="img-responsive center-block" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png">
							</a>
						</div>
						<div class="col-sm-4">
							<div class="text-brand-right"><?php echo translate('Suitable for vegetarians'); ?><br><?php echo translate('and health conscious persons'); ?></div>
						</div>
					</div>
				</div>
			</div>
			<nav id="fixedHeader" class="navbar navbar-default navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-sf-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand visible-xs" href="#">
							<img class="img-responsive center-block" src="<?php echo base_url(); ?>template/front/images/SPA-Foods-Logo_H40.png">
						</a>
						<span class="site-name-xs visible-xs">Nutrition House Co Ltd.</span>
					</div>
					<div class="collapse navbar-collapse" id="bs-sf-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li id="Home"><a href="<?php echo base_url(); ?>index.php/home/"><?php echo translate('Home'); ?></a></li>
							<li id="About"><a href="<?php echo base_url(); ?>index.php/home/about"><?php echo translate('About Us'); ?></a></li>
						<?php
							$this->db->order_by('category_id', 'asc');
                            $category = $this->db->get('category')->result_array();
                            foreach ($category as $row): 
								$title = $this->nookcs_model->getDataMultiLanguage($row['category_name'],$row['category_name_en']);
								$active = str_replace(" ","",$row['category_name']);
								$active = str_replace(".","",$active);
                        ?>
                    		<li id="<?= $active ?>" class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $title ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
							<?php
                                $sub_category = $this->db->get_where('sub_category', array('category' => $row['category_id']))->result_array();
                                foreach ($sub_category as $row1) :
                            ?>
                        		<li><a href="<?php echo base_url(); ?>index.php/home/spafoods/<?= $row1['sub_category_id'] ?>"><?= $row1['sub_category_name'] ?></a></li>
	                        <?php 
	                        	endforeach;
	                        ?>
								</ul>
							</li>
                    	<?php
                            endforeach;
                        ?>
							<li id="Restaurant" class="dropdown">
								<a href="restaurant-overview.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo translate('Restaurants & Services'); ?><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url(); ?>index.php/home/restaurant_overview"><?php echo translate('Restaurants & Services'); ?></a></li>
								<?php
									$this->db->order_by('id', 'asc');
		                            $store_locations = $this->db->get('store_locations')->result_array();
		                            foreach ($store_locations as $row): 
										$title = $this->nookcs_model->getDataMultiLanguage($row['store_name'],$row['store_name']);
		                        ?>
		                        	<li><a href="<?php echo base_url(); ?>index.php/home/restaurant_detail/<?= $row['id'] ?>"><?php echo $title ?></a></li>
		                        <?php 
		                        	endforeach;
		                        ?>
									<!-- <li><a href="<?php echo base_url(); ?>index.php/home/the_vegetarian_cottage">The Vegetarian Cottage</a></li>
									<li><a href="<?php echo base_url(); ?>index.php/home/golden_place_rama9">Golden Place Rama9</a></li>
									<li><a href="<?php echo base_url(); ?>index.php/home/golden_place_saphan_soong">Golden Place Saphan Soong</a></li> -->
								</ul>
							</li>
							<li id="News" class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo translate('News & Events'); ?><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url(); ?>index.php/home/news_event"><?php echo translate('News & Events'); ?></a></li>
									<li><a href="<?php echo base_url(); ?>index.php/home/vdo_clips"><?php echo translate('VDO Clips'); ?></a></li>
								</ul>
							</li>
							<li id="Health"><a href="<?php echo base_url(); ?>index.php/home/health"><?php echo translate('Health Corner'); ?></a></li>
							<li id="Founder"><a href="<?php echo base_url(); ?>index.php/home/founder"><?php echo translate('Message From Founder'); ?></a></li>
							<li id="Contact"><a href="<?php echo base_url(); ?>index.php/home/contact"><?php echo translate('Contact Us'); ?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
<script>
	fixedHeader();
	detectBrowser();
</script>