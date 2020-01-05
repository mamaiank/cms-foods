<div>
    <?=$this->crud_model->get_type_name_by_id('general_settings','60','value');?>
</div>
<!--=== Breadcrumbs ===-->
    <div style="padding:10px;background:rgba(212, 224, 212, 0.72)">
        <center>
            <h1 class="text-center; "><?php echo translate('invoice_paper');?></h1>
        </center><!--/container-->
    </div><!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->

    <!--=== Content Part ===-->
    <table width="100%" style="background:rgba(212, 224, 212, 0.17);">
    <?php
        $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->result_array();
        foreach($sale_details as $row){
    ?>
        <!--Invoice Header-->
        <tr>
            <td colspan="2" style="padding:10px;">
                <table>
                    <tr>
                        <td width="20%"><img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" width="98%"></td>
                        <td style="font-size:11px; ">
                            Nutrition House Co Ltd. <br>
                            611/277 - 279 Soi Watchannai (Rajuthit), Bangklo, Bangkholeam, Bangkok 10120. Thailand <br>
                            Telephone: (662) 689-9612 Fax: (662) 689-9616 <br>
                            E-mail: info@nutritionhouse.co.th 
                        </td>
                        <td>
                            <table>
                                <tr><td><strong><?php echo translate('invoice_no');?></strong> : <?php echo $row['sale_code']; ?> </td></tr>
                                <tr><td><strong><?php echo translate('date');?></strong> : <?php echo date('d M, Y',$row['sale_datetime'] );?></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--End Invoice Header-->

        <!--Invoice Detials-->
        <tr>
            <td style="padding:20px;">
                <div class="tag-box tag-box-v3">
                    <?php
                        $info = json_decode($row['shipping_address'],true);
                    ?>
                    <h2><?php echo translate('client_information:');?></h2>
                    <table>
                        <tr><td><strong><?php echo translate('first_name:');?></strong> <?php echo $info['firstname']; ?></td></tr>
                        <tr><td><strong><?php echo translate('last_name:');?></strong> <?php echo $info['lastname']; ?></td></tr>
                        <tr><td><strong><?php echo translate('city_:');?></strong> <?php echo $info['city']; ?></td></tr>
                    </table>
                </div>        
            </td>
            <td>
                <div class="tag-box tag-box-v3">
                    <h2><?php echo translate('payment_details_:');?></h2>  
                    <table>       
                        <tr><td><strong><?php echo translate('payment_status_:');?></strong> <i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></i></td></tr>
                        <tr><td><strong><?php echo translate('payment_method_:');?></strong>
                                <?php
                                $payment = $this->db->get_where('payment_method',array('payment_type'=>$row['payment_chk']))->row();
                                if($payment){
                                    ?>
                                    <?php echo $payment->payment_name;
                                }else{
                                    echo "-";
                                }
                                ?>


                            </td></tr>
                    </table>
                </div>
            </td>
        </tr>
        <!--End Invoice Detials-->

        <!--Invoice Table-->
        <tr>
            <td style="padding:10px 5px 0px; background:#818488; color:white; text-align:center;" colspan="2" >
                <h3><?php echo translate('payment_invoice');?></h3>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:0px;">
            <table width="100%">
                <thead>
                    <tr>
                        <th style="padding: 5px;background:rgba(128, 128, 128, 0.30)"><?php echo translate('no');?></th>
                        <th style="padding: 5px;background:rgba(128, 128, 128, 0.30)"><?php echo translate('item');?></th>
                        <th style="padding: 5px;background:rgba(128, 128, 128, 0.30)"><?php echo translate('quantity');?></th>
                        <th style="padding: 5px;background:rgba(128, 128, 128, 0.30)"><?php echo translate('unit_cost');?></th>
                        <th style="padding: 5px;background:rgba(128, 128, 128, 0.30)"><?php echo translate('total');?></th>
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
                            <td style="padding: 5px;text-align:center;background:rgba(128, 128, 128, 0.18)"><?php echo $i; ?></td>
                            <td style="padding: 5px;text-align:center;background:rgba(128, 128, 128, 0.18)"><?php echo $row1['name']; ?></td>
                            <td style="padding: 5px;text-align:center;background:rgba(128, 128, 128, 0.18)"><?php echo $row1['qty']; ?></td>
                            <td style="padding: 5px;text-align:center;background:rgba(128, 128, 128, 0.18)"><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                            <td style="padding: 5px;text-align:right;background:rgba(128, 128, 128, 0.18)"><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <td>
        </tr>
        <!--End Invoice Table-->

        <!--Invoice Footer-->
        <tr>
            <td width="50%" style="background:rgba(212, 224, 212, 0.72)">
                 <table>
                    <tr >
                        <td style="padding:10px 20px;"><h2><?php echo translate('address');?></h2></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 20px;">
                            <?php echo $info['address1'].$info['address'];; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 20px;">
                            <?php echo $info['address2']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 20px;">
                            <?php echo translate('city');?> : <?php echo $info['city']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 20px;">
                            <?php echo translate('zip');?> : <?php echo $info['zip'].$info['postal_code']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 20px;">
                            <?php echo translate('phone');?> : <?php echo $info['phone']; ?>
                        </td>
                    </tr>
                 </table> 
            </td>
            <td style="text-align:right;">
                 <table width="100%">
                    <tr>
                        <td style="text-align:right;padding:3px; width:80%; "><h3><?php echo translate('sub_total_amount');?> :</h3></td>
                        <td style="text-align:right;padding:3px"><h3><?php echo currency().$this->cart->format_number($total);?></h3></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;padding:3px; width:80%;"><h3><?php echo translate('tax');?> :</h3></td>
                        <td style="text-align:right;padding:3px"><h3><?php echo currency().$this->cart->format_number($row['vat']);?></h3></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;padding:3px; width:80%;"><h3><?php echo translate('shipping');?> :</h3></td>
                        <td style="text-align:right;padding:3px"><h3><?php echo currency().$this->cart->format_number($row['shipping']);?></h3></td>
                    </tr>
                     <tr>
                         <td style="text-align:right;padding:3px; width:80%;"><?php echo translate('coupon_discount');?> :</td>
                         <td style="text-align:right;padding:3px"><?php echo currency().$this->cart->format_number($row['coupon_discount']);?></td>
                     </tr>
                    <tr>
                        <td style="text-align:right;padding:3px; width:80%;"><h2><?php echo translate('grand_total');?> :</h2></td>
                        <td style="text-align:right;padding:3px"><h2><?php echo currency().$this->cart->format_number($row['grand_total']);?></h2></td>
                    </tr>
                 </table>
               
            </td>
        </tr>
    <?php } ?>
    </table><!--/container-->

<?php
$payment = $this->db->get_where('bank')->result_array();
?>

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

<div>
    <?=$this->crud_model->get_type_name_by_id('general_settings','61','value');?>
</div>


    <!--=== End Content Part ===-->