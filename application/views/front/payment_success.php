<?php
/**
 * Created by PhpStorm.
 * User: ZTOP
 * Date: 8/1/2560
 * Time: 4:20
 */


//var_dump($payment_success);
?>


<div class="container" style="padding-top: 20px;">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
<img src="http://osmhotels.com//assets/check-true.jpg">
<h3>แจ้งการชำระเงินเรียบร้อยแล้ว</h3>
            <p>ทางเจ้าหน้าที่จะทำการตรวจสอบและส่งสินค้าให้ท่านโดยเร็วที่สุด ขอขอบคุณ spafoods.com</p>
<div>
    <table class="table">
        <tr>
            <th><?php echo translate('order_id');?></th>
            <td><?=$payment_success['order_id']?></td>
        </tr>
        <tr>
            <th><?php echo translate('name');?> - <?php echo translate('last_name');?></th>
            <td><?=$payment_success['name']?> <?=$payment_success['last_name']?></td>
        </tr>
        <tr>
            <th><?php echo translate('payment_date');?></th>
            <td><?=$payment_success['payment_date']?></td>
        </tr>
        <tr>
            <th><?php echo translate('payment_time');?></th>
            <td><?=$payment_success['payment_time']?></td>
        </tr>
        <tr>
            <th><?php echo translate('payment_pay');?></th>
            <td><?=$payment_success['payment_pay']?></td>
        </tr>
        <tr>
            <th><?php echo translate('message');?></th>
            <td><?=$payment_success['message']?></td>
        </tr>
        <tr>
            <th><?php echo translate('payment_slip');?></th>
            <td><?php
                $images = $this->crud_model->file_view('confirm_payment', $payment_success['order_id'], '', '', 'no', 'src', '', 'all');
                ?>
                <img src="<?= $images ?>" class="img-responsive">
            </td>
        </tr>
    </table>
</div>
<br><br>
</div>

</div>
</div>