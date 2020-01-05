<div class="panel" style="padding-top: 38px">
    <?php
    echo form_open(base_url() . 'index.php/admin/store_locations/do_add/', array(
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
                <?php echo translate('store_name'); ?>
            </label>
            <div class="col-sm-12">
                <input type="text" name="store_name" id="store_name" class="form-control required" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('store_locations_image'); ?>
            </label>
            <div class="col-sm-12">
                <span id="previewImgCover" style="padding: 10px"></span>
                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (280 x 280 px)
                        <input type="file" multiple name="cover" onchange="preview_cover(this);" id="demo-hor-12"
                               class="form-control required">
                    </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-12 control-label text-left">
                <?php echo translate('store_detail'); ?>
            </label>
            <div class="col-sm-12">
                <textarea class="tinymce" name='store_detail'></textarea>
            </div>
        </div>
        <div class="form-group btm_border">
            <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
            <div class="col-sm-6">
            <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?> (1140 x 480 px)
                <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-12" class="form-control required">
            </span>
                <br><br>
                <span id="previewImg" ></span>
            </div>
        </div>
        <div class="form-group">
<!--             <label class="col-sm-4 control-label text-left">
                <?php echo translate('latitude'); ?>
            </label>
            <label class="col-sm-4 control-label text-left">
                <?php echo translate('longitude'); ?>
            </label> -->
            <label class="col-sm-12 control-label text-left">
                <?php echo translate('map'); ?>
            </label>
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <textarea class="form-control" name='map_zoom'></textarea>
                </div>
                <!-- <input type="text" name="map_zoom" id="map_zoom" class="form-control required" value="<?=$store['map_zoom']?>"> -->
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-12" for="demo-hor-1">
                <?php echo translate('store_locations_map_picture'); ?>
            </label>
            <div class="col-sm-12">
                <span id="previewImgMap" style="padding: 10px"></span>
                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (750 x 450 px)
                        <input type="file" multiple name="map" onchange="preview_map(this);" id="demo-hor-12"
                               class="form-control required">
                    </span>
            </div>
        </div>
        <!-- <div class="form-group">
            <div class="col-xs-12">
                <style>
                    #map {
                        width: 100%;
                        height: 400px;
                        background-color: grey;
                    }
                </style>
                <div id="map"></div>
                <script>
                    var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
                    var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
                    function initMap() { // ฟังก์ชันแสดงแผนที่
                        GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
                        // กำหนดจุดเริ่มต้นของแผนที่
                        var my_Latlng  = new GGM.LatLng(13.761728449950002,100.6527900695800);
                        var my_mapTypeId=GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
                        // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
                        var my_DivObj=$("#map")[0];
                        // กำหนด Option ของแผนที่
                        var myOptions = {
                            zoom: 13, // กำหนดขนาดการ zoom
                            center: my_Latlng , // กำหนดจุดกึ่งกลาง
                            mapTypeId:my_mapTypeId // กำหนดรูปแบบแผนที่
                        };
                        map = new GGM.Map(my_DivObj,myOptions);// สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map

                        var my_Marker = new GGM.Marker({ // สร้างตัว marker
                            position: my_Latlng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
                            map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
                            draggable:true, // กำหนดให้สามารถลากตัว marker นี้ได้
                            title:"คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
                        });

                        // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร
                        GGM.event.addListener(my_Marker, 'dragend', function() {
                            var my_Point = my_Marker.getPosition();  // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
                            map.panTo(my_Point);  // ให้แผนที่แสดงไปที่ตัว marker
                            $("#latitude").val(my_Point.lat());  // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
                            $("#longitude").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value
                            $("#map_zoom").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value
                        });

                        // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
                        GGM.event.addListener(map, 'zoom_changed', function() {
                            $("#map_zoom").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value
                        });

                    }
                </script>

                <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4wH4eb6gEdEvX2tPpo3ujU42JxwkeNXo&callback=initMap"></script>
            </div>
        </div> -->
    </div>


    <div class="panel-footer text-right">
        <button type="submit" class="btn btn-success btn-labeled fa fa-check"><?php echo translate('save');?></button>
    </div>
    </form>
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

    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    window.preview_cover = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImgCover").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImgCover").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    window.preview_map = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImgMap").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImgMap").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
</script>