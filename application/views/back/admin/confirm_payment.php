<div id="content-container">
    <div id="page-title">
        <div class="col-xs-6">
            <h1 class="page-header text-overflow" ><?php echo translate('confirm_payment');?></h1>
        </div>
        <div class="col-xs-6" style="padding-top: 15px;">
            <button class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn"
                    style="display:none;"  onclick="ajax_set_list();  proceed('to_add');"><?php echo translate('back_to_product_list');?>
            </button>
        </div>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <!-- LIST -->
                <div class="tab-pane fade active in" id="list">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin';
    var module = 'confirm_payment';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';

    function proceed(type){
        if(type == 'to_list'){
            $(".pro_list_btn").show();
            $(".add_pro_btn").hide();
        } else if(type == 'to_add'){
            $(".add_pro_btn").show();
            $(".pro_list_btn").hide();
        }
    }
</script>