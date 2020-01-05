<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow" ><?php echo translate('manage_remark');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">

    <?php
    echo form_open(base_url() . 'index.php/admin/remark/update/', array(
        'class' => 'form-horizontal',
        'method' => 'post',
        'id' => '',
        'enctype' => 'multipart/form-data'
    ));
    ?>

    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-3 control-label" ><?php echo translate('remark_head');?></label>
            <div class="col-sm-9">
                <textarea class="tinymce" name="remark_head">
                    <?=$this->crud_model->get_type_name_by_id('general_settings','60','value');?>
                </textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" ><?php echo translate('remark_footer');?></label>
            <div class="col-sm-9">
                <textarea class="tinymce" name="remark_footer">
                    <?=$this->crud_model->get_type_name_by_id('general_settings','61','value');?>
                </textarea>
            </div>
        </div>
    </div>


    <div class="panel-footer text-right">
        <button type="submit" class="btn btn-success btn-labeled fa fa-check"><?php echo translate('save');?></button>
    </div>
    </form>
</div>
                </div>
            </div>
        </div>
    </div>


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
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code fullscreen",
        image_advtab: true ,

        external_filemanager_path:"<?=base_url()?>filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "<?=base_url()?>filemanager/plugin.min.js"}
    });
</script>