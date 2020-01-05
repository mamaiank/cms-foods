<!--=== Content Medium Part ===-->
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
            <div class="header-tags">
                <div class="overflow-h margin-bottom-30">
                    <h2><?php echo translate('event_&_gallery');?></h2>
                    <p><?php echo translate('event_&_gallery');?></p>
                </div>
            </div>
        <hr class="style14">
            <section>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        foreach($gallery_category as $row){
                            $images = $this->crud_model->file_view('gallery_category', $row['c_gallery_id'], '', '', 'thumb', 'src', '', 'all');
                            ?>
                                <div class="col-sm-6 col-md-4">
                                    <a href="<?php echo base_url(); ?>index.php/home/gallery/<?= $row['c_gallery_id'] ?>" class="gallery-box">
                                    <div class="thumbnail">
                                        <img src="<?php echo $images; ?>" alt="<?= $row['c_gallery_title'] ?>" style="max-height: 192px; background-color: #00a65a; width: 100%; ">
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
