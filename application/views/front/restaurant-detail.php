
		<div class="container">
			<div class="underhero brown">
				<ul class="bxsliderUnderhero">
				<?php 
				$title = $this->nookcs_model->getDataMultiLanguage($content->store_name,$content->store_name);
                $images = $this->crud_model->file_view('store_locations',$content->id,'','','no','src','multi_id','all');
                if($images){
                    foreach ($images as $row1){
                ?>
                	<li><img src="<?php echo $row1; ?>" title="<?php echo $title ?>" /></li>
                <?php 
                        }
                    } 
                ?>
				</ul>
			</div>
			<script>
			initBxsliderUnderhero();
			</script>

			<div class="group-restaurant">
				<div class="row">
					<div class="col-sm-9">
						<h3 class="text-color-003366"><?php echo translate('Info') ?></h3>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-8">
										<h3 class="heading"><?php echo $title ?></h3>
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
								<div class="scrollbar-inner maxh">
									<div class="detail">
									<?php 
										$detail = $this->nookcs_model->getDataMultiLanguage($content->store_detail,$content->store_detail);
									?>
										<?php echo $detail; ?>
										<h3><?php echo translate('Location'); ?></h3>
										<ul class="list-inline">
											<li><a class="link" href="javascript:;" data-toggle="modal" data-target="#zoomMap"><?php echo translate('Zoom map'); ?></a></li>
											<li><a class="link" href="javascript:;" data-toggle="modal" data-target="#googleMap"><?php echo translate('Google map'); ?></a></li>
										</ul>
			<?php
            $images = $this->crud_model->file_view('store_locations_map', $content->id, '', '', 'no', 'src', '', 'all');
            ?>
										<p><img src="<?php echo $images ?>" /></p>
										<!-- Modal Zoom map-->
										<div class="modal fade" id="zoomMap" tabindex="-1" role="dialog">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">
															<span aria-hidden="true">&times;</span>
														</button>
														<h4 class="modal-title" id="myModalLabel">Map</h4>
													</div>
													<div class="modal-body">
														<img class="img-responsive" src="<?php echo $images ?>" />
													</div>
												</div>
											</div>
										</div>
										<!-- Modal Google map-->
										<div class="modal fade" id="googleMap" tabindex="-1" role="dialog">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">
															<span aria-hidden="true">&times;</span>
														</button>
														<h4 class="modal-title" id="myModalLabel">Google Map</h4>
													</div>
													<div class="modal-body">
<?php echo html_entity_decode($content->map_zoom,ENT_HTML5,'UTF-8'); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<script>
								initScrollbar();
								</script>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<?php include("inc-restaurants.php"); ?>
					</div>
				</div>
			</div>

			<?php include("inc-recommended-menu.php"); ?>
		</div>
