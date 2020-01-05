<div>
    <?php
    echo form_open(base_url() . 'index.php/admin/recommended_menus/do_add/', array(
        'class' => 'form-horizontal',
        'method' => 'post',
        'id' => 'recommended_menus_add',
        'enctype' => 'multipart/form-data'
    ));
    ?>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('menu_name'); ?>
            </label>
            <div class="col-sm-12">
                <input type="text" name="menu_name" id="demo-hor-1"
                       class="form-control required" placeholder="<?php echo translate('menu_name'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('menu_name_eng'); ?>
            </label>
            <div class="col-sm-12">
                <input type="text" name="menu_name_en" id="demo-hor-1"
                       class="form-control required" placeholder="<?php echo translate('menu_name_eng'); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('menu_detail'); ?>
            </label>
            <div class="col-sm-12">
                <textarea class="tinymce" name='menu_detail'></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('menu_detail_eng'); ?>
            </label>
            <div class="col-sm-12">
                <textarea class="tinymce" name='menu_detail_en'></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('menu_image'); ?>
            </label>
            <div class="col-sm-12">
                <span id="previewImg" style="padding: 10px"></span>
					<span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?>
                        <input type="file" multiple name="images" onchange="preview(this);" id="demo-hor-12"
                               class="form-control required">
                        (270 x 170 px)
						</span>
            </div>
        </div>

    </div>
    <div class="panel-footer text-right">
        <button type="submit" class="btn btn-success btn-labeled fa fa-check"><?php echo translate('save');?></button>
    </div>
    </form>
</div>

<script>

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