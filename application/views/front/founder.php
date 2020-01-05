
		<div class="container">
			<div class="space20"></div>
			<div class="group-founder">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel-founder">
							<div class="name-p text-center">
								<?php echo $page_title ?>
							</div>
							<hr class="dash-w10h3 center-block">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel-founder-2">
							<div class="clearfix">
							<?php
								$images = $this->crud_model->file_view('founder', 'image', '', '', 'thumb', 'src', '', 'all');
                                $firstname =  $this->db->get_where('founder',array('type' => 'firstname'))->row();
                                $lastname =  $this->db->get_where('founder',array('type' => 'lastname'))->row();
                                $firstname = $this->nookcs_model->getDataMultiLanguage($firstname->value,$firstname->value_en);
	                            $lastname = $this->nookcs_model->getDataMultiLanguage($lastname->value,$lastname->value_en);
							?>
								<div class="col-sm-6">
									<div class="box-desc">
										<h3 class="text-center"><?php echo $firstname; ?> <?php echo $lastname; ?><span><?php echo translate('Founder') ?></span></h3>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="box-pic">
								<?php
                                	if(!empty($images)){ 
                                ?>
									<img alt="<?php echo $firstname; ?> <?php echo $lastname; ?>" src="<?=$images?>" />
								<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="list-founder">
							<li><span><?php echo translate('Lists'); ?></span></li>
						<?php 
							foreach ($all_message as $key => $value) :
							$title = $this->nookcs_model->getDataMultiLanguage($value['message_title'],$value['message_title_en']);
						?>
							<li><a href="<?php echo base_url(); ?>index.php/home/founder_detail/<?php echo $value['id']?>"><?php echo $title; ?><span><?php echo translate('Read more') ?></span></a></li>
						<?php
							endforeach;
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>