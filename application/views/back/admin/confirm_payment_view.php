<div class="clearfix"></div>
    <div class="tab-base">
        <?php
        foreach ($sale as $row){
        $info = json_decode($row['shipping_address'], true);
        //invoice and map
        ?>

        <div class="col-md-2"></div>

        <div class="col-md-8 bordered print-container">

            <div class="tab-content">
                <div id="full" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-3 col-md-3 col-sm-12 pad-all">
                                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" width="85%">
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 col-sm-12">
                                บริษัท คาซ่า ดิ โมด้า จำกัด (เลขที่ผู้เสียภาษี 0105531098226)<br>
                                611/210-213 ซ.วัดจันทร์ใน ถ.เจริญกรุง แขวงบางโคล่ เขตบางคอแหลม กรุงเทพมหานคร 10120<br>
                                Tel: 02-689-8345 # 2207 <br>
                                Mobile: 091-890-3797
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3 col-sm-12 pad-all">
                                <b class="pull-right">
                                    <?php echo translate('invoice_no:'); ?> :<?php echo $row['sale_code']; ?>
                                </b>
                                <br>
                                <b class="pull-right">
                                    <?php echo translate('date_:'); ?><?php echo date('d M, Y', $row['sale_datetime']); ?>
                                </b>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 pad-top">
                            <!--Panel heading-->
                            <div class="panel panel-bordered-grey shadow-none">
                                <div class="panel-heading">
                                    <h1 class="panel-title"><?php echo translate('client_information'); ?></h1>
                                </div>
                                <!--List group-->
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <b><?php echo translate('first_name'); ?>   <?php echo translate('last_name'); ?></b>
                                        </td>
                                        <td><?php echo $info['firstname']; ?>   <?php echo $info['lastname']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo translate('address'); ?></b></td>
                                        <td><?php echo $info['address1']; ?><?php echo $info['zip']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo translate('phone'); ?></b></td>
                                        <td><?php echo $info['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo translate('e-mail'); ?></b></td>
                                        <td><?php echo $info['email']; ?></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="demo_s">
                            <div class="fff panel panel-dark shadow-none" style="margin-bottom: 0;">
                                <div class="panel-heading">
                                    <h1 class="panel-title"><?php echo translate('product_item'); ?></h1>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th><?php echo translate('no'); ?></th>
                                            <th><?php echo translate('item'); ?></th>
                                            <th><?php echo translate('options'); ?></th>
                                            <th><?php echo translate('quantity'); ?></th>
                                            <th><?php echo translate('unit_cost'); ?></th>
                                            <th><?php echo translate('total'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $product_details = json_decode($row['product_details'], true);
                                        $i = 0;
                                        $total = 0;
                                        foreach ($product_details as $row1) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row1['name']; ?></td>
                                                <td>
                                                    <?php
                                                    $all_o = json_decode($row1['option'], true);
                                                    $color = $all_o['color']['value'];
                                                    if ($color) {
                                                        ?>
                                                        color: <?php echo $color; ?><br>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    foreach ($all_o as $l => $op) {
                                                        if ($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL) {
                                                            ?>
                                                            <?php echo $op['title'] ?> :
                                                            <?php
                                                            if (is_array($va = $op['value'])) {
                                                                echo $va = join(', ', $va);
                                                            } else {
                                                                echo $va;
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row1['qty']; ?></td>
                                                <td><?php echo currency() . $this->cart->format_number($row1['price']); ?></td>
                                                <td><?php echo currency() . $this->cart->format_number($row1['subtotal']);
                                                    $total += $row1['subtotal']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                        <div class="panel panel-colorful panel-grey shadow-none">
                                            <table class="table" border="0">
                                                <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('sub_total_amount'); ?></b></td>
                                                    <td><?php echo currency() . $this->cart->format_number($total); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('tax'); ?></b></td>
                                                    <td><?php echo currency() . $this->cart->format_number($row['vat']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('shipping'); ?></b></td>
                                                    <td><?php echo currency() . $this->cart->format_number($row['shipping']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo translate('coupon_discount');?> :</td>
                                                    <td><?php echo currency().$this->cart->format_number($row['coupon_discount']);?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('grand_total'); ?></b></td>
                                                    <td><?php echo currency() . $this->cart->format_number($row['grand_total']); ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <!--List group-->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                        <!--Panel heading-->
                                        <div class="panel panel-bordered-grey shadow-none">
                                            <div class="panel-heading">
                                                <h1 class="panel-title"><?php echo translate('payment_detail'); ?></h1>
                                            </div>
                                            <!--List group-->
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('payment_status'); ?></b></td>
                                                    <td><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_method'); ?></b></td>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_date'); ?></b></td>
                                                    <td><?php echo date('d M, Y', $row['sale_datetime']); ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-9"></div>
        <div class="col-md-3 print_btn">
            <span class="btn btn-success btn-md btn-labeled fa fa-reply margin-top-10"
                  onclick="print()">
                    <?php echo translate('print'); ?>
            </span>
        </div>
    </div>


<?php
}
?>
<style>
    @media print {
        * {
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }

        .clearfix {
            clear: both;
        }

        .pad-top {
            padding-top: 20px;
        }

        .print-container * {
            visibility: visible;
        }

        .print-container {
            position: absolute;
            left: 0;
            top: 0;
        }

        .panel-body {
            padding: 0 !important;
        }

        .col-md-3 {
            width: 25%;
            float: left;
        }

        .col-md-6 {
            width: 50%;
            float: left;
        }

        .logo-print {
            width: 200px;
        }
    }
</style>
