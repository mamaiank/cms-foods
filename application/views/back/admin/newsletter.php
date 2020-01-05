<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow" ><?php echo translate('send_newsletter')?></h1>
	</div>
	<div class="tab-base">
		<!--Tabs Content-->
		<div class="panel">
		<!--Panel heading-->
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade active in" id="lista">
						<div class="panel-body" id="demo_s">
							<?php
                                echo form_open(base_url() . 'index.php/admin/newsletter/send/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post'
                                ));
                            ?>
		                        <div class="row">
			                        <?php
				                        $user_list = array();
				                        $subscribers_list = array();
				                        foreach ($users as $row) {
				                        	$user_list[] = $row['email'];
				                        }
				                        foreach ($subscribers as $row) {
				                        	$subscribers_list[] = $row['email'];
				                        }
			                        	$user_list = join(',',$user_list);
			                        	$subscribers_list = join(',',$subscribers_list);
			                        ?>
	                            	<h3 class="panel-title"><?php echo translate('e-mails_(users)')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="subscribers" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(users)')?>" class="form-control"
					                        		value="<?php echo $user_list; ?>">
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('e-mails_(subscribers)')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="users" data-role="tagsinput" 
					                        	placeholder="<?php echo translate('e-mails_(subscribers)')?>" class="form-control required"
					                        		value="<?php echo $subscribers_list; ?>">
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('from_:_email_address')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="email" name="from" 
                                            	placeholder="<?php echo translate('from_:_email_address')?>" class="form-control required">
					                
					                    </div>
					                </div>
	                            	<h3 class="panel-title"><?php echo translate('newsletter_subject')?></h3>
					                <div class="form-group btm_border">
					                    <div class="col-sm-12">
					                        <input type="text" name="title" 
                                            	placeholder="<?php echo translate('newsletter_subject')?>" class="form-control required">
					                    </div>
					                </div>
	                            	
	                            	<h3 class="panel-title"><?php echo translate('newsletter_content')?></h3>
	                                <textarea class="tinymce" data-height='700' data-name='text' class="required" name="text"></textarea>

	                            </div>
	                            <div class="panel-footer text-right">
	                                <span class="btn btn-info submitter"  data-ing='<?php echo translate('sending'); ?>' data-msg='<?php echo translate('sent!'); ?>'>
										<?php echo translate('send')?>
                                        	</span>
	                            </div>
	                        </form>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script src="<?php echo base_url(); ?>template/back/plugins/tinymce-4.3.4/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script>
	$(document).ready(function() {
		tinymce.init({
			selector: ".tinymce",
			theme: "modern",
			width: '100%',
			height: 700,
			relative_urls: false,
			remove_script_host : false,
			menubar: "view",
			autoresize_on_init: false,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor responsivefilemanager code","fullscreen"
			],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code fullscreen | fontsizeselect",
			image_advtab: true ,
			fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",

			external_filemanager_path:"<?=base_url()?>filemanager/",
			filemanager_title:"Responsive Filemanager" ,
			external_plugins: { "filemanager" : "<?=base_url()?>filemanager/plugin.min.js"}
		});
	});
	
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'admin';
	var module = 'newsletter';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
</script>