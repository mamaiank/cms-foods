<div class="container">
	<div class="group-page">
		<div class="row">
			<div class="col-sm-6">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/news_event">
						<img alt="News & Event" src="<?php echo base_url(); ?>template/front/images/thumbPage/NewsEvent.jpg" />
						<span class="caption"><?php echo translate('News & Events'); ?></span>
					</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-xs-6 col-sm-6">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/founder">
								<img alt="Message From FOUNDER" src="<?php echo base_url(); ?>template/front/images/thumbPage/MessageFromFOUNDER.jpg" />
								<span class="caption"><?php echo translate('Message From FOUNDER'); ?></span>
							</a>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/health">
								<img alt="Health Corner" src="<?php echo base_url(); ?>template/front/images/thumbPage/HealthyRecipeINSPIRATION.jpg" />
								<span class="caption"><?php echo translate('Health Corner'); ?></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/group-page-->
	<div class="group-page">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/recommended_menus">
						<img alt="Recommended Menus" src="<?php echo base_url(); ?>template/front/images/thumbPage/RecommendedMenus.jpg" />
						<span class="caption"><?php echo translate('Recommended Menus'); ?></span>
					</a>
				</div>
			</div>
			<?php
                $this->db->order_by('category_id', 'asc');
                $category = $this->db->get('category')->result_array();
                foreach ($category as $row): 
                $title = $this->nookcs_model->getDataMultiLanguage($row['category_name'],$row['category_name_en']);
                $sub_category = $this->db->get_where('sub_category', array('category' => $row['category_id']))->row();
                $images = $this->crud_model->file_view('category', $row['category_id'], '', '', 'thumb', 'src', '', 'all');
            ?>
            <div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/spafoods/<?= $sub_category->sub_category_id ?>">
						<img alt="J.V. PRODUCTS" src="<?php echo $images; ?>" />
						<span class="caption">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i><br>
							<?php echo $title ?>
						</span>
					</a>
				</div>
			</div>
            <?php
                endforeach;
            ?>
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/restaurant_overview">
						<img alt="RESTAURANTS & SERVICES" src="<?php echo base_url(); ?>template/front/images/thumbPage/OurRestaurentsRESTAURENT.jpg" />
						<span class="caption">
							<?php echo translate('RESTAURANTS & SERVICES'); ?>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div><!--/group-page-->
	<div class="group-page">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/our_partners">
						<img alt="Our Partners" src="<?php echo base_url(); ?>template/front/images/thumbPage/OurPartners.jpg" />
						<span class="caption">
							<?php echo translate('Our Partners'); ?>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/wheretobuy">
						<img alt="Where to buy" src="<?php echo base_url(); ?>template/front/images/thumbPage/WhereToBuy.jpg" />
						<span class="caption">
							<?php echo translate('Where to buy'); ?>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="<?php echo base_url(); ?>index.php/home/downloadfile?filename=SPA-FOODS-CompanyProfile.pdf">
						<img alt="Download COMPANY PROFILE" src="<?php echo base_url(); ?>template/front/images/thumbPage/DownloadCompanyPROFILE.jpg" />
						<span class="caption"></span>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="thumbnail">
					<a href="#qrCode">
						<img alt="QR CODE" src="<?php echo base_url(); ?>template/front/images/thumbPage/QRcode.jpg" />
						<span class="caption"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>