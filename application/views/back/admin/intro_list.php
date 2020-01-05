<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >

        <thead>
        <tr>
            <th><?php echo translate('no');?></th>
            <!--<th><?php // echo translate('image');?></th>-->
            <th><?php echo translate('title');?></th>
            <th><?php echo translate('publish');?></th>
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
                <td><?php echo $row['intro_title']; ?></td>
                <td>
                    <input id="intr_<?php echo $row['id']; ?>" class='sw1' type="checkbox" data-id='<?php echo $row['id']; ?>' <?php if($row['status'] == 'ok'){ ?>checked<?php } ?> />
                </td>
                <td class="text-right">
                    <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip"
                       onclick="ajax_set_full('edit','<?php echo translate('intro_edit'); ?>','<?php echo translate('successfully_edited!'); ?>','intro_edit','<?php echo $row['id']; ?>')"
                       data-original-title="Edit" data-container="body">
                        <?php echo translate('edit');?>
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
    <h1 style="display:none;"><?php echo translate('intro'); ?></h1>
    <table id="export-table" data-name='intro' data-orientation='p' style="display:none;">
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
                <td><?php echo $row['intro_title']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

