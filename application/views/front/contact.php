<script src='https://www.google.com/recaptcha/api.js'></script>
<link href="<?php echo base_url(); ?>template/front/css/sweetalert.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>template/front/js/sweetalert.min.js"></script>
<?php 
if($_SESSION['FLASH']=='sent'){
?>
<script>
	swal({
	  title: "<?php echo translate('Success!'); ?>",
	  text: "<?php echo translate('Thank you for contacting us. I will contact you as soon as possible!'); ?>",
	  type: "success",
	  confirmButtonText: "<?php echo translate('Close'); ?>"
	});
</script>
<?php
	$_SESSION['FLASH']=null;
} else if($_SESSION['FLASH']=='recaptcha_error'){
?>
<script>
swal({
  title: "<?php echo translate('Error!'); ?>",
  text: "<?php echo translate('Please confirm that you are not a bot!'); ?>",
  type: "error",
  confirmButtonText: "<?php echo translate('Close'); ?>"
});
</script>
<?php
	$_SESSION['FLASH']=null;
} else if($_SESSION['FLASH']=='validation_error'){
?>
<script>
swal({
  title: "<?php echo translate('Error!'); ?>",
  text: "<?php echo translate('Please fill in all fields.'); ?>",
  type: "error",
  confirmButtonText: "<?php echo translate('Close'); ?>"
});
</script>
<?php
	$_SESSION['FLASH']=null;
}
?>
		<div class="container">
			<div class="space20"></div>
			<div class="group-contact">
				<div class="row">
					<div class="col-sm-9">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="maxw600">
									<div class="name-p text-center">
										<?php echo translate('CONTACT US'); ?>
									</div>
									<hr class="dash-w10h3 center-block">
									<p class="text-center"><?php echo translate('if you require further information on any of our products.'); ?></p>
									<address>
										<strong class="text-color-003366">Nutrition House Co Ltd.</strong><br>
										611/277 - 279 Soi Watchannai (Rajuthit), Bangklo, Bangkholeam<br>
										Bangkok 10120. Thailand<br>
										<span class="text-color-003366">Telephone: (662) 689-9612</span><br>
										<span class="text-color-003366">Fax: (662) 689-9616</span><br>
										<span class="text-color-003366">E-Mail us at : info@nutritionhouse.co.th</span>
									</address>
									<h4 class="text-color-003366"><?php echo translate('Contact Form'); ?></h4>
									<p><?php echo translate('We_would welcome your comments.'); ?></p>
									<?php
		                                echo form_open(base_url() . 'index.php/home/contact/send', array(
		                                    'class' => 'form-horizontal',
		                                    'method' => 'post',
		                                    'id' => '',
		                                    'enctype' => 'multipart/form-data'
		                                ));
		                            ?>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="text-color-999" for="FirstnameOrNickname">
														<?php echo translate('First Name / Nickname'); ?> <span class="text-danger">*</span>
													</label>
													<input class="form-control" type="text" required name="name" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="text-color-999" for="Email">
														<?php echo translate('Email'); ?> <span class="text-danger">*</span>
													</label>
													<input class="form-control" type="email" required name="email" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="text-color-999" for="Telephone">
														<?php echo translate('Telephone'); ?> <span class="text-danger">*</span>
													</label>
													<input class="form-control" type="text" required name="tel" />
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="text-color-999" for="Subject">
														<?php echo translate('Subject'); ?> <span class="text-danger">*</span>
													</label>
													<input class="form-control" type="text" required name="subject" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="text-color-999" for="Message"><?php echo translate('Message'); ?></label>
											<textarea class="form-control" name="message" rows="5"></textarea>
										</div>
										<div class="form-group">
<div class="g-recaptcha" data-sitekey="6LcaUyEUAAAAAG1eZIZ6zb4lWuUB4QkRN7dFf3NX"></div>
										</div>
										<div class="form-group">
											<input class="btn btn-sendmail" type="submit" name="SendMail" value="<?php echo translate('SEND'); ?>" />
										</div>
									</form>
									<div class="space20"></div>
									<h4 class="text-color-003366">Google Map</h4>
									<div class="googleMap">
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3876.4240411993446!2d100.5164952!3d13.6927485!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e298a8838cc519%3A0xdeb743f4f796f96b!2z4Lia4Lij4Li04Lip4Lix4LiXIOC4meC4ueC4l-C4o-C4teC4iuC4seC5iOC4mSDguYDguK7guYnguLLguKrguYwg4LiI4Liz4LiB4Lix4LiU!5e0!3m2!1sth!2sth!4v1492502395608" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="thumb-link icon-instagram">
							<a target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','7','value') ? $this->crud_model->get_type_name_by_id('social_links','7','value') : 'javascript:void(0)'; ?>">
								<img class="img-rounded" src="<?php echo base_url(); ?>template/front/images/contact/C001_20170411.jpg" />
								<span><i class="fa fa-instagram"></i></span>
							</a>
						</div>
						<div class="thumb-link icon-twitter">
							<a target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','3','value') ? $this->crud_model->get_type_name_by_id('social_links','3','value') : 'javascript:void(0)'; ?>">
								<img class="img-rounded" src="<?php echo base_url(); ?>template/front/images/contact/C002_20170411.jpg" />
								<span><i class="fa fa-twitter-square"></i></span>
							</a>
						</div>
						<div class="thumb-link icon-facebook">
							<a target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','1','value') ? $this->crud_model->get_type_name_by_id('social_links','1','value') : 'javascript:void(0)'; ?>">
								<img class="img-rounded" src="<?php echo base_url(); ?>template/front/images/contact/C003_20170411.jpg" />
								<span><i class="fa fa-facebook-square"></i></span>
							</a>
						</div>
						<div class="thumb-link icon-pinterest">
							<a target='_blank' href="<?php echo $this->crud_model->get_type_name_by_id('social_links','5','value') ? $this->crud_model->get_type_name_by_id('social_links','5','value') : 'javascript:void(0)'; ?>">
								<img class="img-rounded" src="<?php echo base_url(); ?>template/front/images/contact/C004_20170411.jpg" />
								<span><i class="fa fa-pinterest-square"></i></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

<script src='https://www.google.com/recaptcha/api.js'></script>
