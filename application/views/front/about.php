
		<div class="container">
			<div class="group-founder">
				<div class="row">
				<?php
                    $images = $this->crud_model->file_view('about_us', 'image', '', '', 'no', 'src', '', 'all');
                ?>
					<div class="col-sm-6">
						<div class="panel-founder">
							<div class="name-p text-center">
								<?php echo $page_title ?>
							</div>
							<hr class="dash-w10h3 center-block">
						</div>
					</div>
					<div class="col-sm-6">
						<p><img class="img-rounded img-responsive" alt="" src="<?=$images?>" /></p>
					</div>
				</div>
			</div>
			<div class="content">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
						<?php 
							$content = $this->nookcs_model->getDataMultiLanguage($content->value,$content->value_en);
						?>
						
							<div class="col-sm-9">
								<?= $content ?>
							</div>
							<div class="col-sm-3">
								<?php
                                    $images = $this->crud_model->file_view('founder', 'image', '', '', 'thumb', 'src', '', 'all');
                                    $firstname =  $this->db->get_where('founder',array('type' => 'firstname'))->row();
	                                $lastname =  $this->db->get_where('founder',array('type' => 'lastname'))->row();
	                                $firstname = $this->nookcs_model->getDataMultiLanguage($firstname->value,$firstname->value_en);
	                                $lastname = $this->nookcs_model->getDataMultiLanguage($lastname->value,$lastname->value_en);
                                if(!empty($images)){ ?>
								<img class="img-responsive center-block" alt="<?php echo $firstname; ?> <?php echo $lastname; ?>" src="<?=$images?>" />
								<?php } ?>
								<h3 class="ab-name text-center"><?php echo $firstname; ?> <?php echo $lastname; ?></h3>
								<p class="ab-position text-center"><?php echo translate('Founder') ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
