<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >

        <thead>
        <tr>
            <th><?php echo translate('no');?></th>
            <!--<th><?php // echo translate('image');?></th>-->
            <th><?php echo translate('title');?></th>
            <th><?php echo translate('detail');?></th>
            <th class="text-right"><?php echo translate('options');?></th>
        </tr>
        </thead>

        <tbody >
        <?php
        $i = 0;
        foreach($all_message as $row){
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
<!--                <td>
                    <?php
//                    $images = $this->crud_model->file_view('founder_message', $row['id'], '', '', 'thumb', 'src', '', 'all');
                    ?>
                    <img class="img-thumbnail" width="150" src="<?php echo $images; ?>" alt="<?= $row['payment_name'] ?>">
                </td>-->
                <td><?php echo $row['message_title']; ?></td>
                <td><?php echo $row['message_detail']; ?></td>
                <td class="text-right">
                    <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip"
                       onclick="ajax_set_full('edit','<?php echo translate('founder_message_edit'); ?>','<?php echo translate('successfully_edited!'); ?>','founder_message_edit','<?php echo $row['id']; ?>')"
                       data-original-title="Edit" data-container="body">
                        <?php echo translate('edit');?>
                    </a>
                    <a onclick="delete_confirm('<?php echo $row['id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip"
                       data-original-title="Delete" data-container="body">
                        <?php echo translate('delete');?>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div id='export-div'>
    <h1 style="display:none;"><?php echo translate('founder_message'); ?></h1>
    <table id="export-table" data-name='founder_message' data-orientation='p' style="display:none;">
        <thead>
        <tr>
            <th><?php echo translate('no');?></th>
            <th><?php echo translate('name');?></th>
        </tr>
        </thead>

        <tbody >
        <?php
        $i = 0;
        foreach($all_message as $row){
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['message_title']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

