
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
									$title = $this->nookcs_model->getDataMultiLanguage($content->activity_name,$content->activity_name_en);
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
						<?php
							$images = $this->crud_model->file_view('event_activity', $content->id, '', '', 'thumb', 'src', '', 'all');
						?>
						<div class="large-img"><img src="<?=$images?>" /></div>
						<h3 class="text-color-003366"><?php echo translate('detail'); ?></h3>
						<div class="detail">
							<?php 
								$description = $this->nookcs_model->getDataMultiLanguage($content->activity_detail,$content->activity_detail_en);
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
                $a = $this->db->get('event_activity')->result_array();
                // var_dump($a);exit();
			?>

			<h3 class="text-center text-color-003366"><?php echo translate('Other News'); ?></h3>

			<div class="group-spafoods">
				<div class="row">
					<?php 
					$i = 0;
					foreach ($a as $row2) {
						if(($row2['id'] != $content->id) && ($i < 4)){ $i++;		
					?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/news_event_detail/<?= $row2['id'] ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('event_activity', $row2['id'], '', '', 'thumb', 'src', '', 'all'); ?>" />
								<div class="caption">
									<?php 
										$title = $this->nookcs_model->getDataMultiLanguage($row2['activity_name'],$row2['activity_name_en']);
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
