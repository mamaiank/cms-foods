<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <!-- Contact form Start -->
                <?php
                echo form_open(base_url() . 'index.php/home/confirm_payment/confirm', array(
                    'class' => 'sky-form',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                    'id' => 'sky-form3'
                ));
                ?>

                <header><?php echo translate('confirm_payment');?></header>

                <fieldset>
                    <section>
                        <label class="label"><?php echo translate('order_id');?></label>
                        <label class="input">
                            <i class="icon-append fa fa-tag"></i>
                            <input type="text" name="order_id" id="order_id" class='required' >
                        </label>
                    </section>

                    <div class="row">
                        <section class="col col-6">
                            <label class="label"><?php echo translate('name');?></label>
                            <label class="input">
                                <i class="icon-append fa fa-user"></i>
                                <input type="text" name="name" id="name" class='required' >
                            </label>
                        </section>
                        <section class="col col-6">
                            <label class="label"><?php echo translate('last_name');?></label>
                            <label class="input">
                                <i class="icon-append fa fa-user"></i>
                                <input type="text" name="last_name" id="last_name" class='required' >
                            </label>
                        </section>
                    </div>

                    <section>
                        <label class="label"><?php echo translate('payment_date');?></label>
                        <label class="input">
                            <i class="icon-append fa fa-tag"></i>
                            <input type="text" name="payment_date" id="payment_date" class='payment_date required' data-date-language="th-th">
                        </label>
                    </section>

                    <section>
                        <label class="label"><?php echo translate('payment_time');?></label>
                        <label class="input">
                            <i class="icon-append fa fa-tag"></i>
                            <input type="text" name="payment_time" id="payment_time" class='required'>
                        </label>
                    </section>

                    <section>
                        <label class="label"><?php echo translate('payment_pay');?></label>
                        <label class="input">
                            <i class="icon-append fa fa-tag"></i>
                            <input type="text" name="payment_pay" id="payment_pay" class='required'>
                        </label>
                    </section>

                    <section>
                        <label class="label"><?php echo translate('message');?></label>
                        <label class="textarea">
                            <i class="icon-append fa fa-comment"></i>
                            <textarea rows="4" name="message" id="message"></textarea>
                        </label>
                    </section>

                    <section>
                        <label class="label"><?php echo translate('payment_slip');?></label>
                        <label class="input">
                            <i class="icon-append fa fa-tag"></i>
                            <input type="file" name="payment_slip" id="payment_slip">
                        </label>
                    </section>
<!--                    <section>-->
<!--                        <div class="g-recaptcha" data-sitekey="6Lfq3xEUAAAAAP9kfKnNWoNTSJv82SsQbkcxBLZP"></div>-->
<!--                    </section>-->
                </fieldset>

                <footer>
                    <span class="button submittertt" data-ing='<?php echo translate('sending..'); ?>' ><?php echo translate('confirm_payment:');?></span>
                </footer>
                <?php echo form_close(); ?>
                <!-- Contact form End -->
            </div>
            <div class="col-xs-6">
                <h3>การจัดส่ง</h3>
                <p>1.เจ้าหน้าที่ทำการตรวจสอบการโอนเงิน จากนั้นทำการส่งสินค้า</p>
                <p> 2. จัดส่งสินค้า ในทุกเวลา 14.00 น. ทุกวันจันทร์-ศุกร์ โดยกำหนดวันละ 1 ครั้ง/วัน (ยกเว้นวันหยุด)</p>
                <p> 3.ถ้าโอนเงินก่อนเวลา 12.00 น. จะจัดส่งสินค้าให้ได้ภายในวันเดียวกัน (ยกเว้นวันหยุด)</p>
                <p> 4.ถ้าโอนเงินหลัง 12.00 น. จะจัดส่งสินค้าให้ได้ในวันถัดไป (ยกเว้นวันหยุด)</p>
                <p> 5.เราจะจัดส่งสินค้าให้ภายใน 2-3 วันทำการ, EMS โดยไปรษณีย์ไทย</p>
                <p> 6.ซื้อสินค้าครบ 1000 บาท ขึ้นไป จัดส่งฟรี</p>
                <p> 7. ตรวจสอบสถานะการส่งสินค้า <a href="http://track.thailandpost.co.th/tracking/default.aspx">http://track.thailandpost.co.th/tracking/default.aspx</a></p>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>template/front/assets/js/custom/confirm_payment.js"></script>
<script>
    $(function () {
        $('.payment_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>