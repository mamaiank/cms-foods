
		<div class="container">
			<div class="space20"></div>
			<div class="group-spafoods">
				<div class="row">
					<div class="col-sm-6">
						<div class="thumbnail-page">
							<img class="img-responsive hidden-xs" src="<?php echo base_url(); ?>template/front/images/overy590x290.jpg" />
							<div class="content-page">
								<div class="name-p text-center"><?php echo $this->nookcs_model->getDataMultiLanguage($content->sub_category_name,$content->sub_category_name_en); ?></div>
								<hr class="dash-w10h3 center-block">
								<div class="caption text-center"><?php echo $this->nookcs_model->getDataMultiLanguage($content->description,$content->description_en); ?></div>
							</div>
						</div>
					</div>
					<?php $irow = 0; foreach ($query as $r) { $irow++;?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/spafood_detail/<?= $r['sub_category'] ?>/<?= $r['product_id'] ?>">
								<!-- <img alt="" src="<?php echo base_url(); ?>template/front/images/noimg400x300.jpg" /> -->
								<img alt="" src="<?php echo $this->crud_model->file_view('product',$r['product_id'],'','','thumb','src','multi','one'); ?>" />
								<div class="caption">
								<?php 
									$title = $this->nookcs_model->getDataMultiLanguage($r['title'],$r['title_en']);
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
			
			<!-- <nav aria-label="Page navigation" class="text-center pageall"> -->
				<!-- <ul class="pagination"> -->
					<?php echo $pagination; ?>
					<!-- <li class="previous">
						<a href="#" aria-label="Previous">
							<span aria-hidden="true">PREV</span>
						</a>
					</li>
					<li class="active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li class="next">
						<a href="#" aria-label="Next">
							<span aria-hidden="true">NEXT</span>
						</a>
					</li> -->
				<!-- </ul> -->
			<!-- </nav> -->
			<div class="logo-bottom">
				<a href="#"><img class="img-responsive" src="<?php echo base_url(); ?>template/front/images/spafoods/Award-Standing.jpg" /></a>
				<a href="#"><img class="img-responsive" src="<?php echo base_url(); ?>template/front/images/spafoods/Halal.jpg" /></a>
				<a href="#"><img class="img-responsive" src="<?php echo base_url(); ?>template/front/images/spafoods/International-Award_Gold-Label.png" /></a>
			</div>
		</div>