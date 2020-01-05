
		<div class="container">
			<div class="space20"></div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="name-p text-center">
						<?php echo $page_title ?>
					</div>
					<hr class="dash-w10h3 center-block">
				</div>
			</div>

			<div class="group-recommended">
				<div class="row">
					<div class="col-sm-9">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="group-icon-black">
									<a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-print" aria-hidden="true"></i></a>
								</div>
								<div class="scrollbar-inner maxh">
								<?php echo $content->menu_detail ?>
								</div>
								<script>
								initScrollbar();
								</script>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
					<?php
						$this->db->limit(4);
						$this->db->order_by('id', 'asc');
                        $store_locations = $this->db->get('recommended_menus')->result_array();
                        $i = 0;
                        foreach ($store_locations as $row): 
                        	if(($row['id'] != $content->id) && ($i < 3)){ $i++;	
							$title = $this->nookcs_model->getDataMultiLanguage($row['menu_name'],$row['menu_name_en']);	
                    ?>
                	<div class="thumbnail">
						<a href="<?php echo base_url(); ?>index.php/home/recommended_menus_detail/<?php echo $row['id'] ?>">
							<img alt="" src="<?php echo $this->crud_model->file_view('recommended_menus',$row['id'],'','','thumb','src','','one'); ?>" />
							<div class="caption">
								<?php echo $title; ?>
							</div>
						</a>
					</div>
                    <?php 
                    		}
                    	endforeach;
                    ?>
					</div>
				</div>
			</div>

		</div>