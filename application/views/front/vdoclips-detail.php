
		<div class="container">
			<div class="space20"></div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="name-p text-center">
						<?php echo $page_title; ?>
					</div>
					<hr class="dash-w10h3 center-block">
				</div>
			</div>
			<div class="group-news">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-8">
								<?php 
									$title = $this->nookcs_model->getDataMultiLanguage($content->vdo_clips_name,$content->vdo_clips_name_en);
									$new_link = str_replace("watch?v=", "embed/", $content->vdo_clips_link);
								?>
								<h3 class="heading"><?php echo $title; ?></h3>
							</div>
							<div class="col-sm-4">
								<div class="group-icon-black">
									<a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-print" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<!-- 16:9 aspect ratio -->
						<div class="embed-responsive embed-responsive-16by9">
<iframe class="embed-responsive-item" src="<?php echo $new_link; ?>" allowfullscreen></iframe>
 						</div>
						<h3 class="text-color-003366"><?php echo translate('detail'); ?></h3>
						<div class="detail">
							<?php 
								$description = $this->nookcs_model->getDataMultiLanguage($content->vdo_clips_detail,$content->vdo_clips_detail_en);
							?>
							<?php echo $description; ?>
						</div>
					</div>
				</div>
			</div>
	
			<?php
				// $this->db->where('event_activity');
                $this->db->limit(5);
                $this->db->order_by('create_date', 'desc');
                $a = $this->db->get('vdo_clips')->result_array();
                // var_dump($a);exit();
			?>

			<h3 class="text-center text-color-003366"><?php echo translate('Other VDO Clips'); ?></h3>

			<div class="group-spafoods">
				<div class="row">
					<?php 
					$i = 0;
					foreach ($a as $row2) {
						if(($row2['id'] != $content->id) && ($i < 4)){ $i++;		
					?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/vdoclips_detail/<?= $row2['id'] ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('vdo_clips', $row2['id'], '', '', 'thumb', 'src', '', 'all'); ?>" />
								<div class="caption">
									<?php 
										$title = $this->nookcs_model->getDataMultiLanguage($row2['vdo_clips_name'],$row2['vdo_clips_name_en']);
									?>
									<?php echo $title; ?>
									<i class="fa fa-plus" aria-hidden="true"></i>
								</div>
							</a>
						</div>
					</div>
					<?php 
						} 
					}
					?>
				</div>
			</div>

		</div>
