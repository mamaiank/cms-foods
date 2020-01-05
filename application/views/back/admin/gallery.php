<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_gallery'); ?></h1>
    </div>

    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding: 5px;">
                        <div class="pull-left" style="color: #FF0000; font-size: 20px; line-height: 30px; padding-left: 20px">
                            size: 1350 x 580 pixels
                        </div>
                        <a class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn" href="<?php echo base_url(); ?>index.php/admin/gallery_category">
                            <?php echo translate('back_category_gallery'); ?>
                        </a>
                    </div>
                    <!-- LIST -->
                    <div class="tab-pane fade active in" style="border:1px solid #ebebeb; border-radius:4px;">


                        <div class="col-md-12 col-sm-12" style="margin-top:20px;">
                            <div class="form-group" id="drpzu">
                                <label class="col-sm-1 control-label" for="demo-hor-inputemail"></label>
                                <div class="col-sm-10" id="dropz"><?php include 'dropzone_gallery.php'; ?></div>
                            </div>
                        </div>

                        <div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding: 5px;">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('all_gallery'); ?></h3>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12" style="margin-top:20px;">
                                <div  id="list">
                                </div>
                        </div>

                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- for logo settings -->
<script>
    function load_logos() {
        ajax_load('<?php echo base_url(); ?>index.php/admin/upload_gallery/show_all/<?=$para1?>', 'list', '');
    }
    function load_dropzone() {
        //$('#dropz').remove();
        //$('#drpzu').append('<div class="col-sm-10" id="dropz"></div>');
        //$('#dropz').load('<?php echo base_url(); ?>index.php/admin/load_dropzone');
        // DROPZONE.JS
        // =================================================================
        // Require Dropzone
        // http://www.dropzonejs.com/
        // =================================================================
        Dropzone.options.demoDropzone = { // The camelized version of the ID of the form element
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFiles: 25,

            // The setting up of the dropzone
            init: function () {
                var myDropzone = this;
                this.on("queuecomplete", function (file) {
                    load_logos();
                });
            }
        }
        load_logos();
    }

    $(document).ready(function () {
        load_dropzone();
        load_logos();

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wrap').hide('fast');
                $('#blah').attr('src', e.target.result);
                $('#wrap').show('fast');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        readURL(this);
    });


    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'admin';
    var module = 'upload_gallery';
    var list_cont_func = 'show_all/<?=$para1?>';
    var dlt_cont_func = 'delete_gallery';
</script>
<!-- for logo settings -->