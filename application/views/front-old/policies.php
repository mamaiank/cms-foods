<!--=== Content Medium Part ===-->
<?php
function chk_active($page = '', $active)
{
    if ($page == '') {
        if ($active == 1) {
            return "active";
        }
    }else{
        if ($page == $active) {
            return "active";
        } else {
            return "no";
        }
    }
}


?>
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 bhoechie-tab-container">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                    <div class="list-group">
                        <?php
                        if ($policies) {
                            $i = 0;
                            foreach ($policies as $policy) {
                                $i++;
                                ?>
                                <a href="#" class="list-group-item <?= chk_active($this->uri->segment(3), $i); ?> text-center">
                                    <?= $policy['policy_name'] ?>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                    <!-- flight section -->
                    <?php
                    if ($policies) {
                        $j = 0;
                        foreach ($policies as $policy) {
                            $j++;
                            ?>
                            <div class="bhoechie-tab-content <?= chk_active($this->uri->segment(3), $j); ?>">
                                <?= str_replace('\r\n','',$policy['policy_detail']); ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div><!--/end container-->
