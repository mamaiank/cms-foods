<?php
foreach ($partners_data as $data) {
    ?>
    <div class="tab-pane fade active in" id="edit">
        <?php
        echo form_open(base_url() . 'index.php/admin/partners/update/' . $data['partners_id'], array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'partners_id' => '',
            'enctype' => 'multipart/form-data'
        ));
        ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_name'); ?>
                </label>
                <div class="col-sm-12">
                    <input type="text" name="partners_name" id="demo-hor-1"
                           class="form-control required" value="<?= $data['partners_name'] ?>"
                           placeholder="<?php echo translate('partners_name'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_link'); ?>
                </label>
                <div class="col-sm-12">
                    <input type="text" name="partners_link" id="demo-hor-1"
                           class="form-control required" value="<?= $data['partners_link'] ?>"
                           placeholder="<?php echo translate('partners_link'); ?>">
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_name_eng'); ?>
                </label>
                <div class="col-sm-12">
                    <input type="text" name="partners_name_en" id="demo-hor-1"
                           class="form-control required" value="<?= $data['partners_name_en'] ?>"
                           placeholder="<?php echo translate('partners_name_eng'); ?>">
                </div>
            </div> -->


            <!-- <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_detail'); ?>
                </label>
                <div class="col-sm-12">
                    <textarea class="tinymce" name='partners_detail'><?= $data['partners_detail'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_detail_eng'); ?>
                </label>
                <div class="col-sm-12">
                    <textarea class="tinymce" name='partners_detail_en'><?= $data['partners_detail_en'] ?></textarea>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-sm-12" for="demo-hor-1">
                    <?php echo translate('partners_image'); ?>
                </label>
                <?php
                $images = $this->crud_model->file_view('partners', $data['partners_id'], '', '', 'thumb', 'src', '', 'all');
                ?>
                <div class="col-sm-12">
					<span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (270 x 200 px)
                        <input type="file" multiple name="images" onchange="preview(this);" id="demo-hor-12"
                               class="form-control">
						</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-xs-8">
						<span id="previewImg" style="padding: 10px">
							<img class="img-thumbnail" width="250" src="<?php echo $images; ?>" alt="<?= $data['partners_name'] ?>">
						</span>
                </div>
            </div>


        </div>
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-success btn-labeled fa fa-check"><?php echo translate('save');?></button>
        </div>
        </form>
    </div>
    <?php
}
?>

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