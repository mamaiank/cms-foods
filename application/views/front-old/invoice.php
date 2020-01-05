<div class="container content invoice_div box-border margin-top-20 margin-bottom-20">
    <?=$this->crud_model->get_type_name_by_id('general_settings','60','value');?>
</div>
    <!--=== Content Part ===-->
    <div class="container content invoice_div box-border margin-top-20 margin-bottom-20">
    <?php
        $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->result_array();
        foreach($sale_details as $row){
    ?>
        <!--Invoice Header-->
        <div class="row invoice-header">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" width="60%">
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                บริษัท คาซ่า ดิ โมด้า จำกัด (เลขที่ผู้เสียภาษี 0105531098226)<br>
                611/210-213 ซ.วัดจันทร์ใน ถ.เจริญกรุง แขวงบางโคล่ เขตบางคอแหลม กรุงเทพมหานคร 10120<br>
                Tel: 02-689-8345 # 2207 <br>
                Mobile: 091-890-3797
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2 invoice-numb">
            	<ul class="list-unstyled">
                    <li><strong><?php echo translate('invoice_no');?></strong> : <?php echo $row['sale_code']; ?> </li>
                    <li><strong><?php echo translate('date');?></strong> : <?php echo date('d M, Y',$row['sale_datetime'] );?></li>
                </ul>
            </div>
        </div>
        <!--End Invoice Header-->

        <!--Invoice Detials-->
        <div class="row invoice-info">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v3">
                    <?php
                        $info = json_decode($row['shipping_address'],true);
                    ?>
                    <h2><?php echo translate('client_information:');?></h2>
                    <ul class="list-unstyled">
                        <li><strong><?php echo translate('first_name:');?></strong> <?php echo $info['firstname']; ?></li>
                        <li><strong><?php echo translate('last_name:');?></strong> <?php echo $info['lastname']; ?></li>
                        <li><strong><?php echo translate('city_:');?></strong> <?php echo $info['city']; ?></li>
                    </ul>
                </div>        
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v3">
                    <h2><?php echo translate('peyment_details_:');?></h2>  
                    <ul class="list-unstyled">       
                        <li><strong><?php echo translate('payment_status_:');?></strong> <i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></i></li>
                        <li><strong><?php echo translate('payment_method_:');?></strong>
                            <?php
                                $payment = $this->db->get_where('payment_method',array('payment_type'=>$row['payment_chk']))->row();
                            if($payment){
                            ?>
                            <?php echo $payment->payment_name;
                            }else{
                                echo "-";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--End Invoice Detials-->

        <!--Invoice Table-->
        <div class="panel panel-purple margin-bottom-40">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo translate('payment_invoice');?></h3>
            </div>
            <table class="table table-striped invoice-table">
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('item');?></th>
                        <th><?php echo translate('options');?></th>
                        <th><?php echo translate('quantity');?></th>
                        <th><?php echo translate('unit_cost');?></th>
                        <th><?php echo translate('total');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $product_details = json_decode($row['product_details'], true);
                        $i =0;
                        $total = 0;
                        foreach ($product_details as $row1) {
                            $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row1['name']; ?></td>
                            <td>
                                <?php 
                                    $option = json_decode($row1['option'],true);
                                    foreach ($option as $l => $op) {
                                        if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){
                                ?>
                                    <?php echo $op['title'] ?> : 
                                    <?php 
                                        if(is_array($va = $op['value'])){ 
                                            echo $va = join(', ',$va); 
                                        } else {
                                            echo $va;
                                        }
                                    ?>
                                    <br>
                                <?php
                                        }
                                    } 
                                ?>
                            </td>
                            <td><?php echo $row1['qty']; ?></td>
                            <td style="text-align:center;"><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                            <td style="text-align:right;"><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!--End Invoice Table-->
        <!--Invoice Footer-->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v6">
                    <h2><?php echo translate('address');?></h2>
                    <address>
                        <?php echo $info['address1']; ?>
                        <?php echo $info['address2']; ?>
                        <?php echo $info['address']; ?> <br>
                        <?php echo translate('city');?> : <?php echo $info['city']; ?> <br>
                        <?php echo translate('zip');?> : <?php echo $info['zip'].$info['postal_code']; ?> <br>
                        <?php echo translate('phone');?> : <?php echo $info['phone'].$info['tel']; ?> <br>
                    </address>
                </div>            
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
            	<div class="tag-box tag-box-v6" style="padding:0px 15px !important;">
                 	 <table class="table">
                     	<tr>
                        	<td><?php echo translate('sub_total_amount');?> :</td>
                        	<td><?php echo currency().$this->cart->format_number($total);?></td>
                        </tr>
                        <tr>
                        	<td><?php echo translate('tax');?> :</td>
                            <td><?php echo currency().$this->cart->format_number($row['vat']);?></td>
                        </tr>
                        <tr>
                        	<td><?php echo translate('shipping');?> :</td>
                            <td><?php echo currency().$this->cart->format_number($row['shipping']);?></td>
                        </tr>
                         <tr>
                             <td><?php echo translate('coupon_discount');?> :</td>
                             <td><?php echo currency().$this->cart->format_number($row['coupon_discount']);?></td>
                         </tr>
                        <tr>
                        	<td><?php echo translate('grand_total');?> :</td>
                            <td><?php echo currency().$this->cart->format_number($row['grand_total']);?></td>
                        </tr>
                     </table>
               </div>
               
                <button class="btn-u btn-u-cust push pull-right margin-bottom-10" onclick="javascript:window.print();">
                	<i class="fa fa-print"></i> <?php echo translate('print');?>
                </button>
            </div>
        </div>
    <?php } ?>
    </div><!--/container-->

<div class="container content invoice_div box-border margin-top-20 margin-bottom-20">
    <?php
        $payment = $this->db->get_where('bank')->result_array();
    ?>

    <p>รายละเอียดการชำระค่าบริการ</p>
    <table width="100%" border="0">
        <thead style="background-color: #e0e0e0">
        <tr>
            <td style="padding:5px">ธนาคาร</td>
            <td style="padding:5px">เลขที่บัญชี</td>
            <td style="padding:5px">ชื่อบัญชี</td>
            <td style="padding:5px">สาขา</td>
        </tr>
        </thead>
        <tbody>
    <?php
        foreach ($payment as $get_pay){
            $payment_images = $this->crud_model->file_view('bank', $get_pay['id'], '', '', 'thumb', 'src', '', 'all');
            ?>
            <tr>
                <td style="padding:5px"><img src="<?=$payment_images;?>" width="50px"> <?=$get_pay['bank_name']?></td>
                <td style="padding:5px"><?=$get_pay['bank_number']?></td>
                <td style="padding:5px"><?=$get_pay['bank_our']?></td>
                <td style="padding:5px"><?=$get_pay['bank_branch']?></td>
            </tr>
    <?php
        }
    ?>
        </tbody>
    </table>
</div>



<div class="container content invoice_div box-border margin-top-20 margin-bottom-20">
    <?=$this->crud_model->get_type_name_by_id('general_settings','61','value');?>
</div>
    <!--=== End Content Part ===-->