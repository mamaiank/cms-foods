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
                            <input type="text" class="form-control" id="tracking_text" name="tracking_text" placeholder="<?php echo translate('No._order');?>" value="<?=$_POST['tracking_text'];?>">
                        </div>
                        <button type="submit" class="btn btn-default">check</button>
                    </form>
                </div>
            </div>
            <?php
//            var_dump($tracking);
            if ($_POST['tracking_text']!=""){
                ?>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-xs-12 well">
                        <?php
                        if ($tracking){
                        $payment_status = json_decode($tracking->payment_status);
                        $delivery_status = json_decode($tracking->delivery_status);
                        ?>
                        <dl class="dl-horizontal">
                            <dt style="min-width: 200px; "><h3>สถานะการชำระเงิน :</h3></dt>
                            <dd style="margin-left: 220px;"><h3><?php echo translate($payment_status[0]->status);?></h3></dd>
                            <dt style="min-width: 200px;"><h3>สถานะการจัดส่ง :</h3></dt>
                            <dd style="margin-left: 220px;"><h3><?php echo translate($delivery_status[0]->status);?></h3></dd>
                        </dl>
                        <?php }else{ ?>
                            <h3>ไม่พบรหัสสั่งซื้อนี้</h3>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </section>
    </div><!--/end container-->
</div>
