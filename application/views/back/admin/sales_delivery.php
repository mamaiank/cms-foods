
<?php
echo form_open(base_url() . 'index.php/admin/sales/delivery_set/' . $sale->sale_code, array(
    'class' => 'form-horizontal',
    'method' => 'post',
    'id' => 'delivery',
    'enctype' => 'multipart/form-data'
));

$info = (object)json_decode($sale->shipping_address,true);
?>
<div class="panel-body">
    <div class="form-group">
        <label for="order_id" class="col-sm-2 control-label"><?php echo translate('Order ID'); ?></label>
        <div class="col-sm-10">
            <input name="order_id" id="order_id" class="form-control" value="<?=$sale->sale_code;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="reciever" class="col-sm-2 control-label"><?php echo translate('Reciever'); ?></label>
        <div class="col-sm-10">
            <input name="reciever" id="reciever" class="form-control" value="<?=$info->firstname;?>  <?=$info->lastname;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label"><?php echo translate('Email'); ?></label>
        <div class="col-sm-10">
            <input name="email" id="email" class="form-control" value="<?=$info->email;?>">
        </div>
    </div>
    <div class="form-group">
        <label for="ems_code" class="col-sm-2 control-label"><?php echo translate('EMS CODE'); ?></label>
        <div class="col-sm-10">
            <input name="ems_code" id="ems_code" class="form-control" value="<?=$delivery->ems_code;?>">
        </div>
    </div>
    <?php
//        var_dump($delivery);
    ?>
    <div class="form-group">
        <label for="detail" class="col-sm-2 control-label"><?php echo translate('Detail'); ?></label>
        <div class="col-sm-10">
        <textarea name="detail tinymce" id="detail"><?=$delivery->detail;?></textarea>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $("form").submit(function(){
            return false;
        });
    });
</script>
<!--End Invoice Footer-->
<script src="<?php echo base_url(); ?>template/back/plugins/tinymce-4.3.4/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        width: '100%',
        height: 400,
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

<div id="reserve"></div>
