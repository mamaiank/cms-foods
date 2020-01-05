<div class="panel" style="padding-top: 38px">
    <?php
    foreach ($policy_data as $policy){
        ?>
    <?php
    echo form_open(base_url() . 'index.php/admin/policy/update/'.$policy['id'], array(
        'class' => 'form-horizontal',
        'method' => 'post',
        'id' => '',
        'enctype' => 'multipart/form-data'
    ));
    ?>


        <div class="panel-body">
            <div class="clearfix"></div>
            <div class="form-group">
                <label class="col-sm-12 control-label text-left">
                    <?php echo translate('policy_name'); ?>
                </label>
                <div class="col-sm-12">
                        <input type="text" name="policy_name" id="policy_name" class="form-control required" value="<?=$policy['policy_name'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12 control-label text-left">
                    <?php echo translate('policy_detail'); ?>
                </label>
                <div class="col-sm-12">
                        <textarea class="tinymce" name='policy_detail'><?=$policy['policy_detail'];?></textarea>
                </div>
            </div>
        </div>

    <div class="panel-footer text-right">
        <button type="submit" class="btn btn-success btn-labeled fa fa-check"><?php echo translate('save');?></button>
    </div>
    </form>
        <?php
    }
    ?>
</div>

<script src="<?php echo base_url(); ?>template/back/plugins/tinymce-4.3.4/tinymce.min.js"></script>
<script>
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
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code fullscreen",
        image_advtab: true ,

        external_filemanager_path:"<?=base_url()?>filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "<?=base_url()?>filemanager/plugin.min.js"}
    });
</script>