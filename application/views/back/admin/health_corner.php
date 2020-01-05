<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow" ><?php echo translate('health_&_corner');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                    <div style="border-bottom: 1px solid #ebebeb;padding: 25px 5px 5px 5px;"
                         class="col-md-12" >
                        <button class="btn btn-primary btn-labeled fa fa-plus-circle pull-right mar-rgt"
                                onclick="ajax_set_full('add','<?php echo translate('health_&_corner_add'); ?>','<?php echo translate('successfully_added!'); ?>','health_corner_add','')">
                            <?php echo translate('health_&_corner');?>
                        </button>
                    </div>
                    <br>
                    <div class="tab-pane fade active in"
                         id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'admin';
    var module = 'health_corner';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
</script>

