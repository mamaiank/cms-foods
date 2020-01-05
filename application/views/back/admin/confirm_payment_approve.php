<div>
    <?php
    echo form_open(base_url() . 'index.php/admin/confirm_payment/confirm_payment_set/' . $order_id, array(
        'class' => 'form-horizontal',
        'method' => 'post',
        'id' => 'approve',
        'enctype' => 'multipart/form-data'
    ));
    ?>
    <div class="panel-body">
        <table class="table">
            <tr>
                <th>
                    <?php echo translate('Order ID'); ?>
                </th>
                <td>
                    <?=$confirm_payment->order_id;?>
                </td>
            </tr>
            <tr>
                <th>
                    ชื่อ - นามสกุล
                </th>
                <td>
                    <?=$confirm_payment->name;?>  <?=$confirm_payment->last_name;?>
                </td>
            </tr>
            <tr>
                <th>
                    วันที่โอน
                </th>
                <td>
                    <?=$confirm_payment->payment_date;?>
                </td>
            </tr>
            <tr>
                <th>
                    เวลาที่โอน
                </th>
                <td>
                    <?=$confirm_payment->payment_time;?>
                </td>
            </tr>
            <tr>
                <th>
                    จำนวนเงินที่โอน (บาท)
                </th>
                <td>
                    <?=$confirm_payment->payment_pay;?>
                </td>
            </tr>
            <tr>
                <th>
                    หมายเหตุ (อื่นๆ เกี่ยวกับการโอนเงิน)
                </th>
                <td>
                    <?=$confirm_payment->message;?>
                </td>
            </tr>

            <tr>
                <th>
                    payment slip
                </th>
                <td>
                    <?php
                    $images = $this->crud_model->file_view('confirm_payment', $confirm_payment->order_id, '', '', 'no', 'src', '', 'all');
                    ?>
                    <a href="<?= $images ?>" target="_blank"><img src="<?= $images ?>" class="img-responsive"></a>
                </td>
            </tr>

        </table>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('confirm_payment_status'); ?></label>
            <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                        <option value="1">รอการตรวจสอบ</option>
                        <option value="2">ยังไม่ชำระเงิน</option>
                        <option value="3">โอนเงินแล้ว</option>
                    </select>

            </div>
        </div>

    </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#confirm_payment").submit(function(){
            return false;
        });
    });
</script>
<div id="reserve"></div>

