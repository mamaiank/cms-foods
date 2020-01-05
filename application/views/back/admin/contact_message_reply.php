<?php
    foreach($message_data as $row)
    { 
?>
	<div>
        <?php
			echo form_open(base_url() . 'index.php/admin/contact_message/reply/' . $row['contact_message_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'contact_message_reply',
				'enctype' => 'multipart/form-data'
			));
		?>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
						<?php echo translate('reply_message');?>
                        	</label>
                    <div class="col-sm-10">
                        <textarea class="tinymce" data-height='500' data-name='reply' name="reply"></textarea>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('view','<?php echo translate('view_contact_message'); ?>','<?php echo translate('successfully_viewed!'); ?>','contact_message_view','<?php echo $row['contact_message_id']; ?>');">
                                <?php echo translate('view_original_message');?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <span class="btn btn-success btn-md btn-labeled fa fa-reply " 
                            onclick="form_submit('contact_message_reply','<?php echo translate('successfully_replied!'); ?>')" >
                                <?php echo translate('reply');?>
                        </span>
                    </div>
                </div>
            </div>
		</form>
	</div>
<?php
    }
?>
<script src="<?php echo base_url(); ?>template/back/plugins/tinymce-4.3.4/tinymce.min.js"></script>
<script>
	$(document).ready(function() {
		$("form").submit(function(e) {
			return false;
		});

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
</script>