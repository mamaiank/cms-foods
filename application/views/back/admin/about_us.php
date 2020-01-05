
<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_site');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="tab-base tab-stacked-left">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-5">About Us <?php echo translate('settings');?></a>
                    </li>
                </ul>

                <div class="tab-content bg_grey">

                    <!-- START : About Us------>
                    <div id="demo-stk-lft-tab-5" class="tab-pane fade active in">
                         <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading margin-bottom-20">
                                    <h3 class="panel-title">
                                        <?php echo translate('about us');?>
                                    </h3>
                                </div>
                            <?php 
                                $detail =  $this->db->get_where('about_us',array('type' => 'detail'))->row()->value;
                                $detail_en =  $this->db->get_where('about_us',array('type' => 'detail'))->row()->value_en;
                            ?>
							<?php
                                echo form_open(base_url() . 'index.php/admin/about_us/set', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-1">
                                        <?php echo translate('image'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                            $images = $this->crud_model->file_view('about_us', 'image', '', '', 'thumb', 'src', '', 'all');
                                        ?>
                                        <span id="previewImg" style="padding: 10px"><?php if(!empty($images)){ ?><img width='250' src="<?=$images?>" class='img-thumbnail'><?php } ?></span>
                                                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (565 x 280 px)
                                                <input type="file" multiple name="images" onchange="preview(this);" id="demo-hor-12"
                                                       class="form-control">
                                                                        </span>
                                    </div>
                                </div>
              
                                <div class="form-group">
                                    <label class="col-sm-2  control-label" for="demo-hor-1">
                                        <?php echo translate('detail'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="tinymce" name='detail'><?= $detail ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2  control-label" for="demo-hor-1">
                                        <?php echo translate('detail_eng'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="tinymce" name='detail_en'><?= $detail_en ?></textarea>
                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                    <?php echo translate('save');?></span>
                                </div>
                            </form>               
                        </div>
                        </div> 
                    </div>
                    <!-- END : About Us-->                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="site"></div>

<script type="text/javascript">

    $(document).ready(function() {
//        sets('later');
		$("form").submit(function(e){
			return false;
		});

	});
        
         window.preview = function (input) {
            if (input.files && input.files[0]) {
                $("#previewImg").html('');
                $(input.files).each(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this);
                    reader.onload = function (e) {
                        $("#previewImg").append("<img width='250' src='" + e.target.result + "' class='img-thumbnail'>");
                    }
                });
            }
        }
    
</script>

<script src="<?php echo base_url(); ?>template/back/plugins/tinymce-4.3.4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: ".tinymce",
        theme: "modern",
        width: '100%',
        height: 300,
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
</script>