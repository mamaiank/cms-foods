
		<div class="container">
			<div class="space20"></div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="name-p text-center">
					<?php echo $title; ?>
					</div>
					<hr class="dash-w10h3 center-block">
				</div>
			</div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="wrapMaxW900">
						<div class="row">
							<div class="col-sm-6">
								<div class="gallery-spafoods clearfix">
									<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
									<?php
                    $thumbs = $this->crud_model->file_view('product', $content->product_id, '', '', 'thumb', 'src', 'multi', 'all');
                    $mains = $this->crud_model->file_view('product', $content->product_id, '', '', 'no', 'src', 'multi', 'all');
                    if($mains){
                    				foreach ($mains as $key => $row1) {
                    ?>
										<li data-thumb="<?php echo $thumbs[$key]; ?>">
											<img class="img-responsive" src="<?php echo $row1; ?>" />
										</li>
									<?php } } else { echo '<div>ไม่มีรูปภาพ</div>'; } ?>
									</ul>
									<a id="goToPrevSlide" class="iconPrev" href="javascript:;">
										<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
										<span class="sr-only">Prev</span>
									</a>
									<a id="goToNextSlide" class="iconNext" href="javascript:;">
										<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
										<span class="sr-only">Next</span>
									</a>
								</div>
								<script>
									gallerySpafoods();
								</script>
							</div>
							<div class="col-sm-6">
								<?php 
									$title = $this->nookcs_model->getDataMultiLanguage($content->title,$content->title_en);
								?>
								<h3 class="text-color-003366"><?php echo $title; ?></h3>
								<div><span class="text-color-003366"><?php echo translate('Net Weight'); ?>:</span> <?php echo $content->unit; ?></div>
								<div>Keep Refrigerated 0-5 C*</div>
								 <?php if ($this->crud_model->get_type_name_by_id('product', $content->product_id, 'discount') > 0) { ?>
	                            <div class="price" style="color: #DBDBDB; text-decoration-line: line-through;"><?php echo currency() . $content->sale_price; ?></div>
	                            <div class="price"><?php echo currency() . $this->crud_model->get_product_price($content->product_id); ?></div>
		                        <?php } else { ?>
		                            <div class="price"><?php echo $content->sale_price.' '.currency(); ?></div>
		                        <?php } ?>
		                        <?php
					            echo form_open('', array(
					                'method' => 'post',
					                'class' => 'sky-form',
					            ));
					            ?>
								<div class="form-group q-item">
									<?php echo translate('Items'); ?> : <input id="spinner" name="qty" value="1" style="max-width:40px;" />
								</div>
								<script>
									initSpiner();
								</script>
								<div class="form-group g-addtocart">
									<a class="btn btn-addtocart add_to_cart" data-type='text' data-pid='<?php echo $content->product_id; ?>' type="submit">
										<i class="fa fa-shopping-basket" aria-hidden="true"></i> | <?php echo translate('ADD TO CART'); ?>
									</a>
								</div>
								</form>
								<div id="pnopoi"></div>
								<hr>
								<div class="group-icon-black">
									<a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-print" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<h3 class="text-color-003366"><?php echo translate('detail'); ?></h3>
						<div class="detail">
							<?php 
								$description = $this->nookcs_model->getDataMultiLanguage($content->description,$content->description_en);
							?>
							<?php echo $description; ?>
						</div>
					</div>
				</div>
			</div>

			<?php
				$this->db->where('sub_category', $content->sub_category);
                $this->db->limit(5);
                $this->db->order_by('product_id', 'desc');
                $a = $this->db->get('product')->result_array();
                // var_dump($a);exit();
			?>
			<h3 class="text-color-003366 text-center"><?php echo translate('Other Products'); ?></h3>
			<div class="group-spafoods">
				<div class="row">
					<?php 
					$i = 0;
					foreach ($a as $row2) {
						if(($row2['product_id'] != $content->product_id) && ($i < 4)){ $i++;		
					?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/spafood_detail/<?= $row2['sub_category'] ?>/<?= $row2['product_id'] ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>" />
								<div class="caption">
									<?php 
										$title = $this->nookcs_model->getDataMultiLanguage($row2['title'],$row2['title_en']);
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
