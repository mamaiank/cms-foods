<!--=== Content Medium Part ===-->
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
        <div class="header-tags">
            <div class="overflow-h margin-bottom-30">
                <h2><?php echo translate('product_tracking');?></h2>
            </div>
        </div>
        <hr class="style14">
        <section>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    echo form_open(base_url() . 'index.php/home/tracking/chk', array(
                        'method' => 'post',
                        'id' => 'tracking',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-inline'
                    ));
                    ?>
                        <div class="form-group">
                            <label for="tracking"><?php echo translate('No._order');?></label>
                            <input type="text" class="form-control" id="tracking" name="tracking" placeholder="<?php echo translate('No._order');?>">
                        </div>
                        <button type="submit" class="btn btn-default">check</button>
                    </form>
                </div>
            </div>

        </section>
    </div><!--/end container-->
</div>
