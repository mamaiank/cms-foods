<div class="container">
    <div class="header-tags">
        <div class="overflow-h margin-bottom-30" style="padding-top: 38px">
            <?php
            foreach ($activity_one as $data_row) {
                $images = $this->crud_model->file_view('event_activity', $data_row['id'], '', '', 'no', 'src', '', 'all');
                ?>
                <div class="col-md-8">
                    <h2><?php echo $data_row['activity_name']; ?></h2>
                </div>
                <div class="col-md-4">
                    <div id="share"></div>
                </div>
                <div style="margin-top: 10px;">
                    <img src="<?= $images ?>" class="img-responsive">
                </div>
                <div style="margin-top: 10px;">
                    <?php echo $data_row['activity_detail']; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>


<!--=== Content Medium Part ===-->
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
        <div class="header-tags">
            <div class="overflow-h margin-bottom-30">
                <h2><?php echo translate('event_&_activity_other'); ?></h2>
                <p><?php echo translate('event_&_activity_other'); ?></p>
            </div>
        </div>
        <hr class="style14">
        <section>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    foreach ($activity as $row) {
                        $images = $this->crud_model->file_view('event_activity', $row['id'], '', '', 'thumb', 'src', '', 'all');
                        ?>
                        <div class="col-sm-6 col-md-4">
                            <a href="<?php echo base_url(); ?>index.php/home/event_activity/<?= $row['id'] ?>"
                               class="gallery-box">
                                <div class="thumbnail">
                                    <img src="<?php echo $images; ?>" alt="<?= $row['activity_name'] ?>"
                                         style="max-height: 192px; background-color: #00a65a; width: 100%; ">
                                    <div class="caption">
                                        <h3><?= $row['activity_name'] ?></h3>
                                        <p><?= substr($row['activity_detail'], 0, 100); ?></p>
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
    $(document).ready(function() {
        $('#share').share({
            networks: ['facebook','googleplus','twitter','linkedin','tumblr','in1','stumbleupon','digg'],
            theme: 'square'
        });
    });
</script>
