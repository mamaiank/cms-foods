
		<div class="container">
			<div class="space20"></div>
			<div class="group-restaurant">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default mg-bottom-10">
							<div class="panel-body" style="padding:12px 10px;">
								<div class="name-p text-center">
									<?php echo $page_title ?>
								</div>
								<hr class="dash-w10h3 center-block">
								<?php 
									$restaurants_service_detail = $this->nookcs_model->getDataMultiLanguage($restaurants_service_detail,$restaurants_service_detail_en);
								?>
								<?php echo $restaurants_service_detail ?>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box-rest">
							<div class="row">
								<div class="col-sm-6">
									<div class="content-rest">
									<?php 
										$restaurants_service_pic_detail = $this->nookcs_model->getDataMultiLanguage($restaurants_service_pic_detail,$restaurants_service_pic_detail_en);
										$images = $this->crud_model->file_view('restaurant_service', 'image', '', '', 'thumb', 'src', '', 'all');
									?>
									<?php echo $restaurants_service_pic_detail ?>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="content-pic">
										<img class="img-responsive" src="<?php echo $images; ?>" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<?php
						$this->db->order_by('id', 'asc');
                        $store_locations = $this->db->get('store_locations')->result_array();
                        foreach ($store_locations as $row): 
							$title = $this->nookcs_model->getDataMultiLanguage($row['store_name'],$row['store_name']);
                    ?>
                	<div class="col-sm-3">
						<div class="thumbnail brown">
							<a href="<?php echo base_url(); ?>index.php/home/restaurant_detail/<?php echo $row['id'] ?>">
								<img alt="The Vegetarian Cottage" src="<?php echo $this->crud_model->file_view('store_locations',$row['id'],'','','thumb','src','','one'); ?>" />
								<span class="caption"><?php echo $title; ?></span>
							</a>
						</div>
					</div>
                    <?php 
                    	endforeach;
                    ?>
					<div class="col-sm-3">
						<div class="thumbnail info-contact">
							<i class="fa fa-smile-o" aria-hidden="true"></i>
							<p><?php echo translate('For more information please kindly contact'); ?></p>
							<p class="text-color-003366"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $restaurants_service_tel ?></p>
							<?php 
							if($_SESSION['language']=='Thai'){
								echo '<p class="text-color-003366">หรือ</p>';
							} else {
								echo '<p class="text-color-003366">or</p>';
							}
							?>
							<p class="text-color-003366"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo $restaurants_service_phone ?></p>
						</div>
					</div>
				</div>
			</div><!--/group-restaurant-->
		</div>