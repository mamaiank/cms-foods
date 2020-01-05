
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
			<div class="group-health">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-8">
								<?php 
									$title = $this->nookcs_model->getDataMultiLanguage($content->corner_name,$content->corner_name_en);
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
							$images = $this->crud_model->file_view('health_corner', $content->id, '', '', 'thumb', 'src', '', 'all');
						?>
						<div class="large-img"><img src="<?=$images?>" /></div>
						<h3 class="text-color-003366"><?php echo translate('detail'); ?></h3>
						<div class="detail">
							<?php 
								$description = $this->nookcs_model->getDataMultiLanguage($content->corner_detail,$content->corner_detail_en);
							?>
							<?php echo $description; ?>
						</div>
					</div>
				</div>
			</div>

			<?php
                $this->db->limit(5);
                $this->db->order_by('create_date', 'desc');
                $a = $this->db->get('health_corner')->result_array();
			?>

			<h3 class="text-center text-color-003366"><?php echo translate('Other'); ?></h3>

			<div class="group-spafoods">
				<div class="row">
					<?php 
					$i = 0;
					foreach ($a as $row2) {
						if(($row2['id'] != $content->id) && ($i < 4)){ $i++;		
					?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/health_detail/<?= $row2['id'] ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('health_corner', $row2['id'], '', '', 'thumb', 'src', '', 'all'); ?>" />
								<div class="caption">
									<?php 
										$title = $this->nookcs_model->getDataMultiLanguage($row2['corner_name'],$row2['corner_name_en']);
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
