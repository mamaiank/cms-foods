<!--=== home banner ===-->
<div class="container margin-bottom-20 margin-top-20">
    <?php
    $place = 'after_slider';
    $query = $this->db->get_where('banner', array('page' => 'home', 'place' => $place, 'status' => 'ok'));
    $banners = $query->result_array();
    if ($query->num_rows() > 0) {
        $r = 12 / $query->num_rows();
    }
    foreach ($banners as $row) {
        ?>
        <a href="<?php echo $row['link']; ?>">
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>"
                             style="background:url('<?php echo $this->crud_model->file_view('banner', $row['banner_id'], '', '', 'no', 'src') ?>') no-repeat center center; background-size: 100% auto;">
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php
    }
    ?>
</div>
<!--=== home banner ===-->


<?php
$i = 0;
if ($vendor_system == 'ok') {
    $vendors = $this->db->get_where('vendor', array('status' => 'approved'))->result_array();
    if ($vendors) {
        ?>
        <!--=== Sponsors  ===-->
        <div class="container content job-partners">
            <div class="heading margin-bottom-20">
                <h2><?php echo translate('our_vendors'); ?></h2>
            </div>

            <ul class="list-inline owl-sponsor our-clients" id="effect-2">
                <?php
                $i = 0;
                foreach ($vendors as $row1) {
                    $i++;
                    ?>
                    <li class="item <?php if ($i == 1) { ?>first-child<?php } ?>">
                        <a href="<?php echo $this->crud_model->vendor_link($row1['vendor_id']); ?>">
                            <figure>
                                <?php
                                if (!file_exists('uploads/vendor/logo_' . $row1['vendor_id'] . '.png')) {
                                    ?>
                                    <img src="<?php echo base_url(); ?>uploads/vendor/logo_0.png" alt="">
                                    <?php
                                } else {
                                    ?>
                                    <img
                                        src="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $row1['vendor_id']; ?>.png"
                                        alt="">
                                    <?php
                                }
                                ?>
                                <div class="img-hover">
                                    <h4><?php echo $row1['display_name']; ?></h4>
                                </div>
                            </figure>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul><!--/end owl-carousel-->
        </div>
        <?php
    }
}
?>
<!--=== Category wise products ===-->
<div class="container" style="margin-bottom: -40px;">
    <div class="heading heading-v1 margin-bottom-20">
        <h2><?php echo translate('featured_product'); ?></h2>
        <p></p>
    </div>

    <div class="illustration-v2 margin-bottom-60">
        <ul class="list-inline owl-slider-v2">
            <?php
            foreach ($featured_data as $row1) {
                if ($this->crud_model->is_publishable($row1['product_id'])) {
                    ?>
                    <li class="item custom_item">
                        <div class="product-img">
                            <a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                                <div class="shadow"
                                     style="background: url('<?php echo $this->crud_model->file_view('product', $row1['product_id'], '', '', 'thumb', 'src', 'multi', 'one'); ?>') no-repeat center center;
                                         background-size: 100% auto;">
                                </div>
                            </a>

                            <a class="add-to-cart add_to_cart" data-type='text'
                               data-pid='<?php echo $row1['product_id']; ?>'>
                                <i class="fa fa-shopping-cart"></i>
                                <?php if ($this->crud_model->is_added_to_cart($row1['product_id'])) { ?>
                                    <?php echo translate('added_to_cart'); ?>
                                <?php } else { ?>
                                    <?php echo translate('add_to_cart'); ?>
                                <?php } ?>
                            </a>
                            <?php
                            if ($this->crud_model->get_type_name_by_id('product', $row1['product_id'], 'current_stock') <= 0) {
                                ?>
                                <div class="shop-rgba-red rgba-banner"
                                     style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock'); ?></div>
                                <?php
                            } else {
                                if ($this->crud_model->get_type_name_by_id('product', $row1['product_id'], 'discount') > 0) {
                                    ?>
                                    <div class="shop-bg-green rgba-banner"
                                         style="border-top-right-radius: 4px !important;">
                                        <?php
                                        if ($row1['discount_type'] == 'percent') {
                                            echo $row1['discount'] . '%';
                                        } else if ($row1['discount_type'] == 'amount') {
                                            echo currency() . $row1['discount'];
                                        }
                                        ?>
                                        <?php echo ' ' . translate('off'); ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="product-description product-description-brd">
                            <div class="overflow-h margin-bottom-5">
                                <div class="col-md-9 pull-left" style="padding:0px;">
                                    <h4 class="title-price"><a
                                            href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>"><?php echo $row1['title'] ?></a>
                                    </h4>
                                    <span
                                        class="gender text-uppercase"><?php echo $this->crud_model->get_type_name_by_id('category', $row1['category'], 'category_name'); ?></span>
                                    <span
                                        class="gender"><?php echo $this->crud_model->get_type_name_by_id('sub_category', $row1['sub_category'], 'sub_category_name'); ?></span>
                                    <?php
                                    if ($vendor_system == 'ok') {
                                        ?>
                                        <span class="gender">
                                <?php echo translate('vendor') . ' : ' . $this->crud_model->product_by($row1['product_id'], 'with_link'); ?>
                            </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-3 product-price" style="padding:0px;">
                                    <?php if ($this->crud_model->get_type_name_by_id('product', $row1['product_id'], 'discount') > 0) { ?>
                                        <span
                                            class="title-price"><?php echo currency() . $this->crud_model->get_product_price($row1['product_id']); ?></span>
                                        <span
                                            class="title-price line-through"><?php echo currency() . $row1['sale_price']; ?></span>
                                    <?php } else { ?>
                                        <span class="title-price"><?php echo currency() . $row1['sale_price']; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <ul class="list-inline product-ratings col-md-5 col-sm-5 col-xs-5 tooltips"
                                data-original-title="<?php echo $rating = $this->crud_model->rating($row1['product_id']); ?>"
                                data-toggle="tooltip" data-placement="right">
                                <?php
                                $rating = $this->crud_model->rating($row1['product_id']);
                                $r = $rating;
                                $i = 0;
                                while ($i < 5) {
                                    $i++;
                                    ?>
                                    <li>
                                        <i class="rating<?php if ($i <= $rating) {
                                            echo '-selected';
                                        }
                                        $r--; ?> fa fa-star<?php if ($r < 1 && $r > 0) {
                                            echo '-half';
                                        } ?>"></i>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <div class="col-md-6 col-sm-6 col-xs-6"></div>
                            <?php
                            $wish = $this->crud_model->is_wished($row1['product_id']);
                            ?>

                            <ul class="list-inline product-ratings col-md-1 col-sm-1 col-xs-1 tooltips"
                                data-original-title="<?php if ($wish == 'yes') { ?><?php echo translate('added_to_wishlist'); ?><?php } else { ?><?php echo translate('add_to_wishlist'); ?><?php } ?>"
                                data-toggle="tooltip" data-placement="left">
                                <li class="like-icon">
                            <span data-pid='<?php echo $row1['product_id']; ?>'
                                  class="<?php if ($wish == 'yes') { ?>wished_it<?php } else { ?>wish_it<?php } ?>">
                                <i class="fa fa-heart"></i>
                            </span>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>

<!--=== home banner ===-->
<div class="container margin-bottom-20 margin-top-20">
    <?php
    $place = 'after_featured';
    $query = $this->db->get_where('banner', array('page' => 'home', 'place' => $place, 'status' => 'ok'));
    $banners = $query->result_array();
    if ($query->num_rows() > 0) {
        $r = 12 / $query->num_rows();
    }
    foreach ($banners as $row) {
        ?>
        <a href="<?php echo $row['link']; ?>">
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>"
                             style="background:url('<?php echo $this->crud_model->file_view('banner', $row['banner_id'], '', '', 'no', 'src') ?>') no-repeat center center; background-size: 100% auto;">
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php
    }
    ?>
</div>


<div class="container margin-top-20">
    <?php
    $place = 'after_search';
    $query = $this->db->get_where('banner', array('page' => 'home', 'place' => $place, 'status' => 'ok'));
    $banners = $query->result_array();
    if ($query->num_rows() > 0) {
        $r = 12 / $query->num_rows();
    }
    foreach ($banners as $row) {
        ?>
        <a href="<?php echo $row['link']; ?>">
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h margin-top-5">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>"
                             style="background:url('<?php echo $this->crud_model->file_view('banner', $row['banner_id'], '', '', 'no', 'src') ?>') no-repeat center center; background-size: 100% auto;">

                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php
    }
    ?>
</div>


<div class="container content">
    <div class="row">

        <!---------New Arrivals-------->
        <div class="col-md-12">
            <div class="tab-v2 margin-bottom-30">
                <ul class="nav nav-tabs full theme_1" style="background:#F9F9F9;">
                    <li>
                        <div onClick="return false;" data-toggle="tab">
                            <?php echo translate('new_arrivals'); ?>
                        </div>
                    </li>

                    <li class="pull-right">
                        <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">
                            <i class="fa fa-angle-right"></i>
                        </div>
                    </li>
                    <li class="pull-right">
                        <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">
                            <i class="fa fa-angle-left"></i>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        <div class="row">
                            <div class="illustration-v2 margin-bottom-60">
                                <ul class="list-inline owl-slider-v2">
                                    <?php
                                    $this->db->order_by('product_id', 'desc');
                                    $this->db->where('status', 'ok');
                                    $latest = $this->db->get('product')->result_array();
                                    $i = 0;
                                    foreach ($latest as $row2) {
                                        if ($this->crud_model->is_publishable($row1['product_id'])) {
                                            $i++;
                                            if ($i <= 9) {
                                                ?>
                                                <li class="item custom_item">
                                                    <div class="product-img">

                                                        <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                                            <div class="shadow"
                                                                 style="background: url('<?php echo $this->crud_model->file_view('product', $row2['product_id'], '', '', 'thumb', 'src', 'multi', 'one'); ?>') no-repeat center center;
                                                                     background-size: 100% auto;">
                                                            </div>

                                                        </a>

                                                        <a class="add-to-cart add_to_cart" data-type='text'
                                                           data-pid='<?php echo $row2['product_id']; ?>'>
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <?php if ($this->crud_model->is_added_to_cart($row2['product_id'])) { ?>
                                                                <?php echo translate('added_to_cart'); ?>
                                                            <?php } else { ?>
                                                                <?php echo translate('add_to_cart'); ?>
                                                            <?php } ?>
                                                        </a>
                                                        <?php
                                                        if ($this->crud_model->get_type_name_by_id('product', $row2['product_id'], 'current_stock') <= 0) {
                                                            ?>
                                                            <div class="shop-rgba-red rgba-banner"
                                                                 style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock'); ?></div>
                                                            <?php
                                                        } else {
                                                            if ($this->crud_model->get_type_name_by_id('product', $row2['product_id'], 'discount') > 0) {
                                                                ?>
                                                                <div class="shop-bg-green rgba-banner"
                                                                     style="border-top-right-radius: 4px !important;">
                                                                    <?php
                                                                    if ($row2['discount_type'] == 'percent') {
                                                                        echo $row2['discount'] . '%';
                                                                    } else if ($row2['discount_type'] == 'amount') {
                                                                        echo currency() . $row2['discount'];
                                                                    }
                                                                    ?>
                                                                    <?php echo ' ' . translate('off'); ?>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="product-description product-description-brd">
                                                        <div class="overflow-h margin-bottom-5">
                                                            <div class="col-md-9 pull-left" style="padding:0px;">
                                                                <h4 class="title-price"><a
                                                                        href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title'] ?></a>
                                                                </h4>
                                                                <span
                                                                    class="gender text-uppercase"><?php echo $this->crud_model->get_type_name_by_id('category', $row2['category'], 'category_name'); ?></span>
                                                                <span
                                                                    class="gender"><?php echo $this->crud_model->get_type_name_by_id('sub_category', $row2['sub_category'], 'sub_category_name'); ?></span>

                                                                <?php
                                                                if ($vendor_system == 'ok') {
                                                                    ?>
                                                                    <span class="gender">
                                                            <?php echo translate('vendor') . ' : ' . $this->crud_model->product_by($row2['product_id'], 'with_link'); ?>
                                                        </span>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-3 product-price" style="padding:0px;">
                                                                <?php if ($this->crud_model->get_type_name_by_id('product', $row2['product_id'], 'discount') > 0) { ?>
                                                                    <span
                                                                        class="title-price"><?php echo currency() . $this->crud_model->get_product_price($row2['product_id']); ?></span>
                                                                    <span
                                                                        class="title-price line-through"><?php echo currency() . $row2['sale_price']; ?></span>
                                                                <?php } else { ?>
                                                                    <span
                                                                        class="title-price"><?php echo currency() . $row2['sale_price']; ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <ul class="list-inline product-ratings col-md-5 col-sm-5 col-xs-5 tooltips"
                                                            data-original-title="<?php echo $rating = $this->crud_model->rating($row2['product_id']); ?>"
                                                            data-toggle="tooltip" data-placement="right">
                                                            <?php
                                                            $rating = $this->crud_model->rating($row2['product_id']);
                                                            $r = $rating;
                                                            $i = 0;
                                                            while ($i < 5) {
                                                                $i++;
                                                                ?>
                                                                <li>
                                                                    <i class="rating<?php if ($i <= $rating) {
                                                                        echo '-selected';
                                                                    }
                                                                    $r--; ?> fa fa-star<?php if ($r < 1 && $r > 0) {
                                                                        echo '-half';
                                                                    } ?>"></i>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                        <div class="col-md-6 col-sm-6 col-xs-6"></div>
                                                        <?php
                                                        $wish = $this->crud_model->is_wished($row2['product_id']);
                                                        ?>

                                                        <ul class="list-inline product-ratings col-md-1 col-sm-1 col-xs-1 tooltips"
                                                            data-original-title="<?php if ($wish == 'yes') { ?><?php echo translate('added_to_wishlist'); ?><?php } else { ?><?php echo translate('add_to_wishlist'); ?><?php } ?>"
                                                            data-toggle="tooltip" data-placement="left">
                                                            <li class="like-icon">
                                                        <span data-pid='<?php echo $row2['product_id']; ?>'
                                                              class="<?php if ($wish == 'yes') { ?>wished_it<?php } else { ?>wish_it<?php } ?>">
                                                            <i class="fa fa-heart"></i>
                                                        </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------New Arrivals-------->


        <!---------Best Seller-------->
        <div class="col-md-12">
            <div class="tab-v2 margin-bottom-30">
                <ul class="nav nav-tabs full theme_2" style="background:#F9F9F9;">
                    <li>
                        <div onClick="return false;" data-toggle="tab">
                            <?php echo translate('best_seller'); ?>
                        </div>
                    </li>

                    <li class="pull-right">
                        <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">
                            <i class="fa fa-angle-right"></i>
                        </div>
                    </li>
                    <li class="pull-right">
                        <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">
                            <i class="fa fa-angle-left"></i>
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        <div class="row">
                            <div class="illustration-v2 margin-bottom-60">
                                <ul class="list-inline owl-slider-v2">
                                    <?php
                                    $mp = 0;
                                    $most_popular = $this->crud_model->most_sold_products();
                                    foreach ($most_popular as $row2) {
                                        if ($this->crud_model->is_publishable($row1['product_id'])) {
                                            if ($mp <= 9) {
                                                $now = $this->db->get_where('product', array('product_id' => $most_popular[$mp]['id']))->row();
                                                ?>
                                                <li class="item custom_item">
                                                    <div class="product-img">
                                                        <a href="<?php echo $this->crud_model->product_link($now->product_id); ?>">
                                                            <div class="shadow"
                                                                 style="background: url('<?php echo $this->crud_model->file_view('product', $now->product_id, '', '', 'thumb', 'src', 'multi', 'one'); ?>') no-repeat center center;
                                                                     background-size: 100% auto;">
                                                            </div>

                                                        </a>

                                                        <a class="add-to-cart add_to_cart" data-type='text'
                                                           data-pid='<?php echo $now->product_id; ?>'>
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <?php if ($this->crud_model->is_added_to_cart($now->product_id)) { ?>
                                                                <?php echo translate('added_to_cart'); ?>
                                                            <?php } else { ?>
                                                                <?php echo translate('add_to_cart'); ?>
                                                            <?php } ?>
                                                        </a>
                                                        <?php
                                                        if ($this->crud_model->get_type_name_by_id('product', $now->product_id, 'current_stock') <= 0) {
                                                            ?>
                                                            <div class="shop-rgba-red rgba-banner"
                                                                 style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock'); ?></div>
                                                            <?php
                                                        } else {
                                                            if ($this->crud_model->get_type_name_by_id('product', $now->product_id, 'discount') > 0) {
                                                                ?>
                                                                <div class="shop-bg-green rgba-banner"
                                                                     style="border-top-right-radius: 4px !important;">
                                                                    <?php
                                                                    if ($now->discount_type == 'percent') {
                                                                        echo $now->discount . '%';
                                                                    } else if ($now->discount_type == 'amount') {
                                                                        echo currency() . $now->discount;
                                                                    }
                                                                    ?>
                                                                    <?php echo ' ' . translate('off'); ?>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="product-description product-description-brd">
                                                        <div class="overflow-h margin-bottom-5">
                                                            <div class="col-md-9 pull-left" style="padding:0;">
                                                                <h4 class="title-price"><a
                                                                        href="<?php echo $this->crud_model->product_link($now->product_id); ?>"><?php echo $now->title ?></a>
                                                                </h4>
                                                                <span
                                                                    class="gender text-uppercase"><?php echo $this->crud_model->get_type_name_by_id('category', $now->category, 'category_name'); ?></span>
                                                                <span
                                                                    class="gender"><?php echo $this->crud_model->get_type_name_by_id('sub_category', $now->sub_category, 'sub_category_name'); ?></span>

                                                                <?php
                                                                if ($vendor_system == 'ok') {
                                                                    ?>
                                                                    <span class="gender">
                                                            <?php echo translate('vendor') . ' : ' . $this->crud_model->product_by($now->product_id, 'with_link'); ?>
                                                        </span>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-3 product-price" style="padding:0;">
                                                                <?php if ($this->crud_model->get_type_name_by_id('product', $now->product_id, 'discount') > 0) { ?>
                                                                    <span
                                                                        class="title-price"><?php echo currency() . $this->crud_model->get_product_price($now->product_id); ?></span>
                                                                    <span
                                                                        class="title-price line-through"><?php echo currency() . $now->sale_price; ?></span>
                                                                <?php } else { ?>
                                                                    <span
                                                                        class="title-price"><?php echo currency() . $now->sale_price; ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <ul class="list-inline product-ratings col-md-5 col-sm-5 col-xs-5 tooltips"
                                                            data-original-title="<?php echo $rating = $this->crud_model->rating($now->product_id); ?>"
                                                            data-toggle="tooltip" data-placement="right">
                                                            <?php
                                                            $rating = $this->crud_model->rating($now->product_id);
                                                            $r = $rating;
                                                            $i = 0;
                                                            while ($i < 5) {
                                                                $i++;
                                                                ?>
                                                                <li>
                                                                    <i class="rating<?php if ($i <= $rating) {
                                                                        echo '-selected';
                                                                    }
                                                                    $r--; ?> fa fa-star<?php if ($r < 1 && $r > 0) {
                                                                        echo '-half';
                                                                    } ?>"></i>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                        <div class="col-md-6 col-sm-6 col-xs-6"></div>
                                                        <?php
                                                        $wish = $this->crud_model->is_wished($now->product_id);
                                                        ?>

                                                        <ul class="list-inline product-ratings col-md-1 col-sm-1 col-xs-1 tooltips"
                                                            data-original-title="<?php if ($wish == 'yes') { ?><?php echo translate('added_to_wishlist'); ?><?php } else { ?><?php echo translate('add_to_wishlist'); ?><?php } ?>"
                                                            data-toggle="tooltip" data-placement="left">
                                                            <li class="like-icon">
                                                        <span data-pid='<?php echo $now->product_id; ?>'
                                                              class="<?php if ($wish == 'yes') { ?>wished_it<?php } else { ?>wish_it<?php } ?>">
                                                            <i class="fa fa-heart"></i>
                                                        </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        $mp++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------Best Seller-------->


        <!--=== home banner ===-->
        <div class="col-md-12" style="margin-bottom: 20px;">
            <div class="container">
                <?php
                $place = 'after_category';
                $query = $this->db->get_where('banner', array('page' => 'home', 'place' => $place, 'status' => 'ok'));
                $banners = $query->result_array();
                if ($query->num_rows() > 0) {
                    $r = 12 / $query->num_rows();
                }
                foreach ($banners as $row) {
                    ?>
                    <a href="<?php echo $row['link']; ?>">
                        <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                            <div class="overflow-h">
                                <div class="illustration-v1 illustration-img1">
                                    <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>"
                                         style="background:url('<?php echo $this->crud_model->file_view('banner', $row['banner_id'], '', '', 'no', 'src') ?>') no-repeat center center; background-size: 100% auto;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>


        <!--        <!--=== Illustration v4 ===-->
        <!--        <div class="row illustration-v4 margin-bottom-20">-->
        <!--            -->
        <!---->
        <!---->
        <!--        </div><!--/end row-->


        <?php
        $i = 0;
//        $brands = json_decode($this->crud_model->get_type_name_by_id('ui_settings', '13', 'value'));
//        if ($brands){
        ?>
        <!--=== Sponsors ===-->
        <div class="container content">

            <div class="heading heading-v1 margin-bottom-20">
<!--                <h2>--><?php //echo translate('our_available_brands'); ?><!--</h2>-->
                <h2><?php echo translate('other_interesting_models'); ?></h2>
            </div>

            <ul class="list-inline owl-sponsor">
                <?php
//                foreach ($brands as $row1) {
                    $brand = $this->db->get_where('brand')->result_array();
                    foreach ($brand as $row) {
                        $i++;
                        ?>
                        <li class="item <?php if ($i == 1) { ?>first-child<?php } ?>">
                            <a href="<?php echo base_url(); ?>index.php/home/brand_item/<?php echo $row['brand_id']; ?>/">
                            <img
                                src="<?php echo $this->crud_model->file_view('brand', $row['brand_id'], '', '', 'no', 'src', '', '', '.png') ?>"
                                alt="" style="max-width: 150px;">
                            </a>
                        </li>
                        <?php
                    }
//                }
//                }
                ?>
            </ul><!--/end owl-carousel-->
        </div>
    </div>
</div>


<div class="parallax-team parallaxBg">
    <div class="container content">
        <div class="title-box-v2">
            <h2><?php echo translate('search_product'); ?></h2>
        </div>

        <div class="row">
            <?php
            echo form_open(base_url() . 'index.php/home/home_search/text', array(
                'class' => 'sky-form',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'style' => 'border:none !important;'
            ));
            ?>
            <div class="col-md-3 col-sm-6">
                <label class="select">
                    <select name='category' id='category'>
                        <option value="0"><?php echo translate('choose_category'); ?></option>
                        <?php
                        $categories = $this->db->get('category')->result_array();
                        foreach ($categories as $row) {
                            ?>
                            <option
                                value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <i></i>
                </label>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="select">
                    <select name='sub_category' onchange='get_pricerange(this.value)' id='sub_category'>
                        <option value="0"><?php echo translate('choose_sub_category'); ?></option>
                    </select>
                    <i></i>
                </label>
            </div>

            <div class="col-md-3 col-sm-6" id="range">
                <input type="text" id="rangelvl" value="" name="range"/>
                <script>
                    $(document).ready(function () {
                        $("#rangelvl").ionRangeSlider({
                            hide_min_max: false,
                            keyboard: true,
                            min:<?php echo $min; ?>,
                            max:<?php echo $max; ?>,
                            from:<?php echo $min; ?>,
                            to:<?php echo $max; ?>,
                            type: "double",
                            step: 1,
                            prefix: "<?php echo currency(); ?>",
                            grid: true,
                            onFinish: function (data) {
                                filter('click', 'none', 'none', '0');
                            }
                        });
                    });
                </script>
            </div>

            <div class="col-md-3 col-sm-6">
                <input type="submit" class="form-control" value="Search">
            </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#category').on('change', function () {
        var category = $('#category').val();
        var list1 = $('#sub_category');
        var list2 = $('#range');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/others/get_sub_by_cat/' + category,
            beforeSend: function () {
                list1.html('...');
            },
            success: function (data) {
                list1.html(data);
            },
            error: function (e) {
                console.log(e)
            }
        });
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/others/get_range_by_cat/' + category,
            beforeSend: function () {
                list2.html('...');
            },
            success: function (data) {
                list2.html(data);
            },
            error: function (e) {
                console.log(e)
            }
        });
    });
    $('#sub_category').on('change', function () {
        var sub_category = $('#sub_category').val();
        var list2 = $('#range');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/others/get_range_by_sub/' + sub_category,
            beforeSend: function () {
                list2.html('...');
            },
            success: function (data) {
                list2.html(data);
            },
            error: function (e) {
                console.log(e)
            }
        });
    });
    function filter() {
    }
</script>
<style>

    .shadow {
        max-height: 300px;
        min-height: 300px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -webkit-transition: all 0.3s ease-in-out;
    }

    .shadow:hover {
        /*background-size: 110% auto !important;*/
        -transform: scale(1.05);
        -o-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -webkit-transform: scale(1.05);
    }

    .custom_item {
        overflow: hidden;
        border: 1px solid #ccc;
        border-radius: 4px !important;
        transition: all .2s ease-in-out;
        margin-top: 10px !important;
    }

    .custom_item:hover {
        /*webkit-transform: translate3d(0, -5px, 0);*/
        /*-moz-transform: translate3d(0, -5px, 0);*/
        /*-o-transform: translate3d(0, -5px, 0);*/
        /*-ms-transform: translate3d(0, -5px, 0);*/
        /*transform: translate3d(0, -5px, 0);*/
        border: 1px solid #E67C8E;
    }

    .tab_hov {
        transition: all .5s ease-in-out;
    }

    .tab_hov:hover {
        opacity: 0.7;
        transition: all .5s ease-in-out;
    }

    .tab_hov:active {
        opacity: 0.7;
    }
</style>



