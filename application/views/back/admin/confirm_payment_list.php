<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
        <tr>
            <th style="width:4ex"><?php echo translate('ID');?></th>
            <th><?php echo translate('sale_code');?></th>
            <th><?php echo translate('name');?></th>
            <th><?php echo translate('last_name');?></th>
            <th><?php echo translate('payment_date');?></th>
            <th><?php echo translate('payment_time');?></th>
            <th><?php echo translate('payment_pay');?></th>
            <th><?php echo translate('confirm_payment_status');?></th>
            <th class="text-right"><?php echo translate('options');?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $i = 0;
        foreach($all_confirm_payment as $row){
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?=$row['order_id']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['last_name']?></td>
                <td><?=$row['payment_date']?></td>
                <td><?=$row['payment_time']?></td>
                <td><?=$row['payment_pay']?></td>
                <td>
                        <div class="label label-<?php if($row['status'] == 1 || $row['status'] == 2){ ?>danger<?php } else { ?>success<?php } ?>">
                            <?php
                            if ($row['status']==1){
                                echo"รอการตรวจสอบ";
                            }elseif ($row['status']==2){
                                echo"ยังไม่ชำระเงิน";
                            }else{
                                echo"โอนเงินแล้ว";
                            }

                            ?>
                        </div>
                </td>
                <td class="text-right">
                    <a class="btn btn-info btn-xs btn-labeled fa fa-file-text" data-toggle="tooltip"
                       onclick="proceed('to_list'); ajax_set_full('view','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','confirm_payment_view','<?php echo $row['order_id']; ?>')"
                       data-original-title="Edit" data-container="body"><?php echo translate('full_invoice'); ?>
                    </a>

                    <a class="btn btn-success btn-xs btn-labeled fa fa-usd" data-toggle="tooltip"
                       onclick="ajax_modal('approve','<?php echo translate('approve'); ?>','<?php echo translate('successfully_approve!'); ?>','approve','<?php echo $row['order_id']; ?>')"
                       data-original-title="Edit" data-container="body"><?php echo translate('approve_status'); ?>
                    </a>

                    <a onclick="delete_confirm('<?php echo $row['id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')"
                       class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip"
                       data-original-title="Delete" data-container="body"><?php echo translate('delete'); ?>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<div id='export-div' style="padding:40px;">
    <h1 id ='export-title' style="display:none;"><?php echo translate('sales'); ?></h1>
    <table id="export-table" class="table" data-name='sales' data-orientation='l' data-width='1500' style="display:none;">
        <colgroup>
            <col width="50">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>Sale Code</th>
            <th>Buyer</th>
            <th>Date</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody >
        <?php
        $i = 0;
        foreach($all_confirm_payment as $row){
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>#<?php echo $row['order_id']; ?></td>
                <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                <td><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
                <td><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<style type="text/css">
    .pending{
        background: #D2F3FF  !important;
    }
    .pending:hover{
        background: #9BD8F7 !important;
    }
</style>



