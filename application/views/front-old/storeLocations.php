<!--=== Content Medium Part ===-->
<div class="content-md margin-bottom-30" style="padding-top: 38px">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 bhoechie-tab-container">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                    <div class="list-group">
                        <?php
                        if ($store) {
                            $i = 0;
                            foreach ($store as $location) {
                                $i++;
                                ?>
                                <a href="#" class="list-group-item <?= $i == 1 ? "active" : " " ?> text-center">
                                    <?= $location['store_name'] ?>
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
                    if ($store) {
                        $i = 0;
                        foreach ($store as $location) {
                            $i++;
                            ?>
                            <div class="bhoechie-tab-content <?= $i == 1 ? "active" : " " ?>">
                                <div align="center">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?=$location['latitude']==""?"13.7596336":$location['latitude']?>,<?=$location['longitude']==""?"100.6140252":$location['longitude']?>&zoom=<?=$location['map_zoom']==""?"7":$location['map_zoom'];?>&size=640x640&maptype=roadmap
&markers=color:red%7Clabel:C%7C<?=$location['latitude']==""?"13.7596336":$location['latitude']?>,<?=$location['longitude']==""?"100.6140252":$location['longitude']?>
&key=AIzaSyATW_2adn-BGPMX3DrR3AwqezwPuZNjnGE">
                                </div>
                                <br>
                                <?= $location['store_detail']; ?>

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
