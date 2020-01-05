
	
	$(document).ready(function() {
		$('.demo-chosen-select').chosen();
		$('.demo-cs-multiselect').chosen({
			width: '100%'
		});
		set_summer();
	});
	
	function set_summer(){
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
	}
	
	$('#curr_n_i').on('keyup', function() {
		$('#curr_n_s').html($('#curr_n_i').val());
	});
	
	$('#curr_s_i').on('keyup', function() {
		$('#curr_s_s').html($('#curr_s_i').val());
	});
	
	$(document).ready(function() {
		$("form").submit(function(e) {
			//return false;
		});
	});