<div class="container">
    <div class="header-tags">
        <div class="overflow-h margin-bottom-30" style="padding-top: 38px">
            <?php
            foreach ($gallery_category_one as $category) {
                ?>
                <div class="col-md-8">
                    <h2><?php echo $category['c_gallery_title']; ?></h2>
                </div>
                <div class="col-md-4">
                    <div id="share"></div>
                </div>
                <div class="col-md-12" style="margin-top: 10px;">
                    <?php echo $category['c_gallery_description']; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="container" style="position: relative;">
    <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-width="100%"
         data-height="100%" data-fit="cover" data-loop="true">
        <?php
        foreach ($gallery as $row) {
            ?>
            <a href="<?php echo base_url(); ?>uploads/gallery_image/<?php echo $row['gallery_name']; ?><?= $row['gallery_extension']; ?>"><img
                    src="<?php echo base_url(); ?>uploads/gallery_image/<?php echo $row['gallery_name']; ?>_thumb<?= $row['gallery_extension']; ?>"></a>

        <?php } ?>
    </div>
    <!--    <div class="hidden-xs hidden-sm" style="padding-top: 22px; position: absolute; top: 0; padding-left: 100px">-->
    <!--        <div class="header-tags">-->
    <!--            <div class="overflow-h margin-bottom-30">-->
    <!--                <h2>--><?php //echo translate('gallery'); ?><!--</h2>-->
    <!--                <p>--><?php //echo translate('gallery'); ?><!--</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</div>


<!--=== Content Medium Part ===-->
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
        <div class="header-tags">
            <div class="overflow-h margin-bottom-30">
                <h2><?php echo translate('event_&_gallery'); ?></h2>
                <p><?php echo translate('event_&_gallery'); ?></p>
            </div>
        </div>
        <hr class="style14">
        <section>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    foreach ($gallery_category as $row) {
                        $images = $this->crud_model->file_view('gallery_category', $row['c_gallery_id'], '', '', 'thumb', 'src', '', 'all');
                        ?>
                        <div class="col-sm-6 col-md-4">
                            <a href="<?php echo base_url(); ?>index.php/home/gallery/<?= $row['c_gallery_id'] ?>"
                               class="gallery-box">
                                <div class="thumbnail">
                                    <img src="<?php echo $images; ?>" alt="<?= $row['c_gallery_title'] ?>"
                                         style="max-height: 192px; background-color: #00a65a; width: 100%; ">
                                    <div class="caption">
                                        <h3><?= $row['c_gallery_title'] ?></h3>
                                        <p><?= $row['c_gallery_description'] ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </div><!--/end container-->
</div>
<script>
    $(document).ready(function () {
        $('#share').share({
            networks: ['facebook', 'googleplus', 'twitter', 'linkedin', 'tumblr', 'in1', 'stumbleupon', 'digg'],
            theme: 'square'
        });
    });
</script>