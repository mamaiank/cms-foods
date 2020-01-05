
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

			<div class="group-spafoods">
				<div class="row">
					<?php $irow = 0; foreach ($query as $r) { $irow++;?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/news_event_detail/<?= $r['id'] ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('event_activity',$r['id'],'','','thumb','src','','one'); ?>" />
								<div class="caption">
									<?php 
										$title = $this->nookcs_model->getDataMultiLanguage($r['activity_name'],$r['activity_name_en']);
									?>
									<?= $title ?>
									<i class="fa fa-plus" aria-hidden="true"></i>
								</div>
							</a>
						</div>
					</div>
					<?php } ?>
					<?php
						if ($irow == 0) {
							echo "<tr><td colspan='6' class='center'>*** ไม่พบข้อมูล ***</td></tr>";
						}
					?>
				</div>
			</div>
			<?php echo $pagination; ?>
		</div>
