<nav id="mainnav-container">
    <div id="mainnav">
        <!--Menu-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header"></li>
                        <!--Menu list item-->
                        <li <?php if ($page_name == "dashboard") { ?> class="active-link" <?php } ?>
                            style="border-top:1px solid rgba(69, 74, 84, 0.7);">
                            <a href="<?php echo base_url(); ?>index.php/admin/">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard'); ?>
                                </span>
                            </a>
                        </li>

                        <?php
                        if ($this->crud_model->admin_permission('category') ||
                            $this->crud_model->admin_permission('sub_category') ||
                            $this->crud_model->admin_permission('product') ||
                            $this->crud_model->admin_permission('stock')
                        ) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "category" ||
                                $page_name == "sub_category" ||
                                $page_name == "product" ||
                                $page_name == "stock"
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('products'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <!--PRODUCT------------------>
                                <ul class="collapse <?php if ($page_name == "category" ||
                                    $page_name == "sub_category" ||
                                    $page_name == "product" ||
                                    $page_name == "brand" ||
                                    $page_name == "stock"
                                ) { ?>
                                                                             in
                                                                                <?php } ?> >">

                                    <?php
                                    if ($this->crud_model->admin_permission('category')) {
                                        ?>
                                        <li <?php if ($page_name == "category") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/category">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('category'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if ($this->crud_model->admin_permission('sub_category')) {
                                        ?>
                                        <li <?php if ($page_name == "sub_category") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/sub_category">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('sub-category'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if ($this->crud_model->admin_permission('brand')) {
                                        ?>
                                        <li <?php if ($page_name == "brand") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/brand">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('brands'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if ($this->crud_model->admin_permission('product')) {
                                        ?>
                                        <li <?php if ($page_name == "product") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/product">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('all_products'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if ($this->crud_model->admin_permission('stock')) {
                                        ?>
                                        <li <?php if ($page_name == "stock") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/stock">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('product_stock'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>

                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('founder') ||
                            $this->crud_model->admin_permission('founder_message')
                        ) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "founder" ||
                                $page_name == "founder_message" 
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('message from founder'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <!--founder------------------>
                                <ul class="collapse <?php if ($page_name == "founder" ||
                                    $page_name == "founder_message" 
                                ) { ?>
                                                                             in
                                                                                <?php } ?> >">

                                    <?php
                                    if ($this->crud_model->admin_permission('founder')) {
                                        ?>
                                        <li <?php if ($page_name == "founder") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/founder">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('founder'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    if ($this->crud_model->admin_permission('founder_message')) {
                                        ?>
                                        <li <?php if ($page_name == "founder_message") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/founder_message">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('founder_message'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    
                                    ?>
                                </ul>
                            </li>

                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('intro')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "intro") { ?> class="active-link" <?php } ?>>
                                <a href="<?php echo base_url(); ?>index.php/admin/intro/">
                                    <i class="fa fa-desktop"></i>
                                    <span class="menu-title">
                                        <?php echo translate('intro'); ?>
                                    </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                            
                            
                        <!--SALE-------------------->
                        <?php
                        if ($this->crud_model->admin_permission('sale')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "sales") { ?> class="active-link" <?php } ?>>
                                <a href="<?php echo base_url(); ?>index.php/admin/sales/">
                                    <i class="fa fa-usd"></i>
                                    <span class="menu-title">
                                		<?php echo translate('sale'); ?>
                                    </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <!--SALE-------------------->
                        <?php
                        if ($this->crud_model->admin_permission('manege_confirm_payment')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "confirm_payment") { ?> class="active-link" <?php } ?>>
                                <a href="<?php echo base_url(); ?>index.php/admin/confirm_payment/">
                                    <i class="fa fa-usd"></i>
                                    <span class="menu-title">
                                		<?php echo translate('manege_confirm_payment'); ?>
                                    </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        // if ($this->crud_model->admin_permission('report')) {
                            ?>
                            <!--Menu list item-->
                            <!-- <li <?php if ($page_name == "report" ||
                                $page_name == "report_stock" ||
                                $page_name == "report_wish"
                            ) { ?>
                                class="active-sub"
                            <?php } ?>>
                                <a href="#">
                                    <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                		<?php echo translate('reports'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a> -->

                                <!--REPORT-->
                               <!--  <ul class="collapse <?php if ($page_name == "report" ||
                                    $page_name == "report_stock" ||
                                    $page_name == "report_wish"
                                ) { ?>
                                                                             in
                                                                                <?php } ?> ">
                                    <li <?php if ($page_name == "report") { ?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/report/">
                                            <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('product_compare'); ?>
                                        </a>
                                    </li>
                                    <li <?php if ($page_name == "report_stock") { ?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/report_stock/">
                                            <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('product_stock'); ?>
                                        </a>
                                    </li>
                                    <li <?php if ($page_name == "report_wish") { ?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/report_wish/">
                                            <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('product_wishes'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <?php
                        // }
                        ?>


                        <?php
                        if ($this->crud_model->admin_permission('user')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "user") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/user/">
                                    <i class="fa fa-users"></i>
                                    <span class="menu-title">
                                        <?php echo translate('customers'); ?>
                                    </span>
                                </a>
                            </li>
                            <!--Menu list item-->
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('coupon')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "coupon") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/coupon/">
                                    <i class="fa fa-tag"></i>
                                    <span class="menu-title">
                                        <?php echo translate('discount_coupon'); ?>
                                    </span>
                                </a>
                            </li>
                            <!--Menu list item-->
                            <?php
                        }
                        ?>


                        <?php
//                        if ($this->crud_model->admin_permission('vendor') ||
//                            $this->crud_model->admin_permission('membership_payment') ||
//                            $this->crud_model->admin_permission('membership')
//                        ) {
                            ?>
                            <!--Menu list item-->
<!--                            <li <?php // if ($page_name == "vendor" ||
//                                $page_name == "membership_payment" ||
//                                $page_name == "membership"
//                            ) { ?>
                                class="active-sub"
                            <?php // } ?>>-->
<!--                                <a href="#">
                                    <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">
                                        <?php // echo translate('vendors'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a>-->

                                <!--REPORT-------------------->
<!--                                <ul class="collapse <?php // if ($page_name == "vendor" ||
//                                    $page_name == "membership_payment" ||
//                                    $page_name == "membership"
//                                ) { ?>
                                                                             in
                                                                                <?php // } ?> ">-->
                                    <!--<li <?php // if ($page_name == "vendor") { ?> class="active-link" <?php // } ?> >-->
<!--                                        <a href="<?php // echo base_url(); ?>index.php/admin/vendor/">
                                            <i class="fa fa-circle fs_i"></i>-->
                                            <?php // echo translate('vendor_list'); ?>
<!--                                        </a>-->
<!--                                    </li>
                                    <li <?php // if ($page_name == "membership_payment") { ?> class="active-link" <?php // } ?> >
                                        <a href="<?php // echo base_url(); ?>index.php/admin/membership_payment/">
                                            <i class="fa fa-circle fs_i"></i>
                                            <?php // echo translate('membership_payments'); ?>
                                        </a>
                                    </li>
                                    <li <?php // if ($page_name == "membership") { ?> class="active-link" <?php // } ?> >
                                        <a href="<?php // echo base_url(); ?>index.php/admin/membership/">
                                            <i class="fa fa-circle fs_i"></i>
                                            <?php // echo translate('membership_type'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>-->
                            <?php
//                        }
                        ?>

                        <?php
                        // if ($this->crud_model->admin_permission('page')) {
                            ?>
                            <!-- <li <?php // if ($page_name == "page") { ?> class="active-link" <?php // } ?> >
                                <a href="<?php // echo base_url(); ?>index.php/admin/page/">
                                    <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                        <?php // echo translate('create_new_page'); ?>
                                    </span>
                                </a>
                            </li> -->
                            <?php
                        // }
                        ?>
                        <?php
                        if ($this->crud_model->admin_permission('slider')) {
                            ?>
                            <!--Menu list item-->
                            <li <?php if ($page_name == "slider") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/slider/">
                                    <i class="fa fa-sliders"></i>
                                    <span class="menu-title">
                                        <?php echo translate('slider'); ?>
                                    </span>
                                </a>
                            </li>
                            <!--Menu list item-->
                            <?php
                        }
                        ?>

                        <?php
//                        if ($this->crud_model->admin_permission('gallery') ||
//                            $this->crud_model->admin_permission('gallery_edit') ||
//                            $this->crud_model->admin_permission('gallery_view') ||
//                            $this->crud_model->admin_permission('gallery_delete') ||
//                            $this->crud_model->admin_permission('gallery_category') ||
//                            $this->crud_model->admin_permission('gallery_category_edit') ||
//                            $this->crud_model->admin_permission('gallery_category_view') ||
//                            $this->crud_model->admin_permission('gallery_category_delete')
//                        ) {
                            ?>
                            <!--Menu list item-->
<!--                            <li <?php // if ($page_name == "gallery" ||
//                                $page_name == "gallery_category"
//                            ) { ?>
                                class="active-sub"
                            <?php // } ?> >
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                            <span class="menu-title">
                                                <?php // echo translate('gallery'); ?>
                                            </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <ul class="collapse <?php // if ($page_name == "gallery" ||
//                                    $page_name == "gallery_category"
//                                ) { ?>
                                      in
                                 <?php // } ?> >">-->


                                    <?php
//                                    if ($this->crud_model->admin_permission('gallery_category')) {
                                        ?>
<!--                                        <li <?php // if ($page_name == "gallery_category") { ?> class="active-link" <?php // } ?> >
                                            <a href="<?php // echo base_url(); ?>index.php/admin/gallery_category">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php // echo translate('gallery_category'); ?>
                                            </a>
                                        </li>-->
                                        <?php
//                                    }?>


                                <!--</ul>-->
                            <!--</li>-->
                            <!--Menu list item-->
                            <?php
//                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('site_settings') ||
                            $this->crud_model->admin_permission('banner')
                        ) {
                            ?>
                            <li <?php if ($page_name == "banner" ||
                                $page_name == "site_settings"
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-desktop"></i>
                                    <span class="menu-title">
                                		<?php echo translate('front_settings'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse <?php if ($page_name == "banner" ||
                                    $page_name == "site_settings"
                                ) { ?>
                                                             in
                                                                <?php } ?>">


                                    <?php
                                    // if ($this->crud_model->admin_permission('banner')) {
                                        ?>
                                        <!--Menu list item-->
                                       <!--  <li <?php if ($page_name == "banner") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/banner/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('banner_settings'); ?>
                                            </a>
                                        </li> -->
                                        <!--Menu list item-->
                                        <?php
                                    // }
                                    ?>
                                    <?php
                                    if ($this->crud_model->admin_permission('site_settings')) {
                                        ?>
                                        <li <?php if ($page_name == "site_settings") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/site_settings/general_settings/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('site_settings'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>


                        <?php
                        if ($this->crud_model->admin_permission('role') ||
                            $this->crud_model->admin_permission('admin')
                        ) {
                            ?>
                            <li <?php if ($page_name == "role" ||
                                $page_name == "admin"
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-user"></i>
                                <span class="menu-title">
                                	<?php echo translate('staffs'); ?>
                                </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <ul class="collapse <?php if ($page_name == "admin" ||
                                    $page_name == "role"
                                ) { ?>
                                                                 in
                                                                    <?php } ?>">

                                    <?php
                                    if ($this->crud_model->admin_permission('admin')) {
                                        ?>
                                        <li <?php if ($page_name == "admin") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/admins/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('all_staffs'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($this->crud_model->admin_permission('role')) {
                                        ?>
                                        <!--Menu list item-->
                                        <li <?php if ($page_name == "role") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/role/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('staff_permissions'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('newsletter') ||
                            $this->crud_model->admin_permission('contact_message')
                        ) {
                            ?>
                            <li <?php if ($page_name == "newsletter" ||
                                $page_name == "contact_message"
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-envelope"></i>
                                <span class="menu-title">
                                	<?php echo translate('messaging'); ?>
                                </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <ul class="collapse <?php if ($page_name == "newsletter" ||
                                    $page_name == "contact_message"
                                ) { ?>
                                                                 in
                                                                    <?php } ?>">

                                    <?php
                                    if ($this->crud_model->admin_permission('newsletter')) {
                                        ?>
                                        <li <?php if ($page_name == "newsletter") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/newsletter">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('newsletters'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($this->crud_model->admin_permission('contact_message')) {
                                        ?>
                                        <li <?php if ($page_name == "contact_message") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/contact_message">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('contact_messages'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('seo')) {
                            ?>
                            <li <?php if ($page_name == "seo_settings") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/seo_settings">
                                    <i class="fa fa-search-plus"></i>
                                <span class="menu-title">
                                    SEO
                                </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('language')) {
                            ?>
                            <li <?php if ($page_name == "language") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/language_settings">
                                    <i class="fa fa-language"></i>
                                <span class="menu-title">
                                    <?php echo translate('language'); ?>
                                </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('about_us')) {
                            ?>
                            <li <?php if ($page_name == "about_us") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/about_us">
                                    <i class="fa fa-search-plus"></i>
                                <span class="menu-title">
                                    About Us
                                </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>    
                            

                        <?php
                        if ($this->crud_model->admin_permission('business_settings')) {
                            ?>
                            <li <?php if ($page_name == "business_settings") { ?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/business_settings/">
                                    <i class="fa fa-briefcase"></i>
                                <span class="menu-title">
                                	<?php echo translate('business_settings'); ?>
                                </span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>


                        <?php
                        // if ($this->crud_model->admin_permission('store_locations') ||
                        //     $this->crud_model->admin_permission('store_locations_edit') ||
                        //     $this->crud_model->admin_permission('store_locations_view') ||
                        //     $this->crud_model->admin_permission('store_locations_delete')
                        // ) {
                            ?>

                            <?php
                            // if ($this->crud_model->admin_permission('store_locations')) {
                                ?>
                                <!-- <li <?php if ($page_name == "store_locations") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/store_locations">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('store_locations'); ?>
                                    </a>
                                </li> -->
                                <?php
                            //}?>

                            <!--Menu list item-->
                            <?php
                        // }
                        ?>



                        <?php
                        // if ($this->crud_model->admin_permission('policy') ||
                        //     $this->crud_model->admin_permission('policy_edit') ||
                        //     $this->crud_model->admin_permission('policy_view') ||
                        //     $this->crud_model->admin_permission('policy_delete')
                        // ) {
                            ?>



                                    <?php
                                    // if ($this->crud_model->admin_permission('policy')) {
                                        ?>
                                        <!-- <li <?php if ($page_name == "policy") { ?> class="active-sub" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/policy">
                                                <i class="fa fa-shopping-cart"></i>
                                                <?php echo translate('policy'); ?>
                                            </a>
                                        </li> -->
                                        <?php
                                    //}?>

                            <!--Menu list item-->
                            <?php
                        //}
                        ?>


                        <?php
                        if ($this->crud_model->admin_permission('bank') ||
                            $this->crud_model->admin_permission('bank_edit') ||
                            $this->crud_model->admin_permission('bank_view') ||
                            $this->crud_model->admin_permission('bank_delete')
                        ) {
                            ?>



                            <?php
                            if ($this->crud_model->admin_permission('bank')) {
                                ?>
                                <li <?php if ($page_name == "bank") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/bank">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('bank'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>

                            <!--Menu list item-->
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('payment_method') ||
                            $this->crud_model->admin_permission('payment_method_edit') ||
                            $this->crud_model->admin_permission('payment_method_view') ||
                            $this->crud_model->admin_permission('payment_method_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('payment_method')) {
                                ?>
                                <li <?php if ($page_name == "payment_method") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/payment_method">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('payment_method'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('restaurant_detail') ||
                            $this->crud_model->admin_permission('store_locations')
                        ) {
                            ?>
                            <li <?php if ($page_name == "store_locations" ||
                                $page_name == "restaurant_detail"
                            ) { ?>
                                class="active-sub"
                            <?php } ?> >
                                <a href="#">
                                    <i class="fa fa-desktop"></i>
                                    <span class="menu-title">
                                        <?php echo translate('store_locations_manage'); ?>
                                    </span>
                                    <i class="fa arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse <?php if ($page_name == "store_locations" ||
                                    $page_name == "restaurant_detail"
                                ) { ?>
                                                             in
                                                                <?php } ?>">

                                    <?php
                                    if ($this->crud_model->admin_permission('restaurant_detail')) {
                                        ?>
                                        <li <?php if ($page_name == "restaurant_detail") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/restaurant_detail/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('restaurant_detail'); ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($this->crud_model->admin_permission('store_locations')) {
                                        ?>
                                        <!--Menu list item-->
                                        <li <?php if ($page_name == "store_locations") { ?> class="active-link" <?php } ?> >
                                            <a href="<?php echo base_url(); ?>index.php/admin/store_locations/">
                                                <i class="fa fa-circle fs_i"></i>
                                                <?php echo translate('store_locations'); ?>
                                            </a>
                                        </li>
                                        <!--Menu list item-->
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                            
                        <?php
                        if ($this->crud_model->admin_permission('recommended_menus') ||
                            $this->crud_model->admin_permission('recommended_menus_edit') ||
                            $this->crud_model->admin_permission('recommended_menus_view') ||
                            $this->crud_model->admin_permission('recommended_menus_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('recommended_menus')) {
                                ?>
                                <li <?php if ($page_name == "recommended_menus") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/recommended_menus">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('recommended_menus'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('event_activity') ||
                            $this->crud_model->admin_permission('event_activity_edit') ||
                            $this->crud_model->admin_permission('event_activity_view') ||
                            $this->crud_model->admin_permission('event_activity_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('event_activity')) {
                                ?>
                                <li <?php if ($page_name == "news_event") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/event_activity">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('News & Events'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->crud_model->admin_permission('vdo_clips') ||
                            $this->crud_model->admin_permission('vdo_clips_edit') ||
                            $this->crud_model->admin_permission('vdo_clips_view') ||
                            $this->crud_model->admin_permission('vdo_clips_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('vdo_clips')) {
                                ?>
                                <li <?php if ($page_name == "vdo_clips") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/vdo_clips">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('vdo_clips'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>
                        
                                
                                
                        <?php
                        if ($this->crud_model->admin_permission('health_corner') ||
                            $this->crud_model->admin_permission('health_corner_edit') ||
                            $this->crud_model->admin_permission('health_corner_view') ||
                            $this->crud_model->admin_permission('health_corner_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('health_corner')) {
                                ?>
                                <li <?php if ($page_name == "health_corner") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/health_corner">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('health_corner'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>
                        <?php
                        if ($this->crud_model->admin_permission('partners') ||
                            $this->crud_model->admin_permission('partners_edit') ||
                            $this->crud_model->admin_permission('partners_view') ||
                            $this->crud_model->admin_permission('partners_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('partners')) {
                                ?>
                                <li <?php if ($page_name == "partners") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/partners">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('partners'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>
                        <?php
                        if ($this->crud_model->admin_permission('where_to_buy') ||
                            $this->crud_model->admin_permission('where_to_buy_edit') ||
                            $this->crud_model->admin_permission('where_to_buy_view') ||
                            $this->crud_model->admin_permission('where_to_buy_delete')
                        ) {
                            ?>
                            <?php
                            if ($this->crud_model->admin_permission('where_to_buy')) {
                                ?>
                                <li <?php if ($page_name == "where_to_buy") { ?> class="active-sub" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/where_to_buy">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php echo translate('where_to_buy'); ?>
                                    </a>
                                </li>
                                <?php
                            }?>
                            <?php
                        }
                        ?>


                        <li <?php if ($page_name == "remark") { ?> class="active-sub" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/remark">
                                <i class="fa fa-shopping-cart"></i>
                                <?php echo translate('remark'); ?>
                            </a>
                        </li>

                        <li <?php if ($page_name == "manage_admin") { ?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/manage_admin/">
                                <i class="fa fa-lock"></i>
                                <span class="menu-title">
                                	<?php echo translate('manage_admin_profile'); ?>
                                </span>
                            </a>
                        </li>
                </div>
            </div>
        </div>
    </div>
</nav>