<body class="header-fixed">
<div class="wrapper animations">
    <div class="header-<?php echo $theme_color; ?> header-sticky header-fixed animatedParent">
        <div class="topbar-v3 animated fadeInDown slowest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Topbar Navigation -->
                        <ul class="left-topbar">
                            <li>
                                <?php
                                if ($set_lang = $this->session->userdata('language')) {
                                } else {
                                    $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
                                }
                                ?>
                                <a>Language (<?php echo $set_lang; ?>)</a>
                                <ul class="language">
                                    <?php
                                    $fields = $this->db->list_fields('language');
                                    foreach ($fields as $field) {
                                        if ($field !== 'word' && $field !== 'word_id') {
                                            ?>
                                            <li <?php if ($set_lang == $field){ ?>class="active"<?php } ?> >
                                                <a href="<?php echo base_url(); ?>index.php/home/set_language/<?php echo $field; ?>">
                                                    <?php echo $field; ?>
                                                    <?php if ($set_lang == $field) { ?>
                                                        <i class="fa fa-check"></i>
                                                    <?php } ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul><!--/end left-topbar-->
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-inline right-topbar pull-right" id="loginsets">
                        </ul>
                    </div>
                </div>
            </div><!--/container-->

        </div>
        <!-- End Topbar v3 -->

        <div class="ztopy-header animated fadeInDown slowest">
            <div class="container">
                <div class="col-md-3 hidden-xs">
                    <div class="ztopy-logo">
                        <a href="<?php echo base_url(); ?>index.php/home/">
                            <img id="logo-header" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>"
                                 alt="Logo"
                                 class="img-responsive" style="width: 100%">
                        </a>
                    </div>
                </div>
                <div class="col-md-9 col-xs-12">
                        <div class="col-md-4 col-xs-12 header-top-margin">
                            <div class="box-header">
                                <div class="header-image push"><img
                                        src="<?php echo base_url(); ?>template/front/assets/img/header-img1.png" alt=""
                                        class=""></div>
                                <div class="header-text">
                                    <h3 style="text-transform: uppercase;"><a href="<?php echo base_url(); ?>index.php/home/storeLocations">
                                            <?php echo translate('store_locations'); ?>
                                        </a></h3>
                                    <p>Find Us <?php echo translate('store_locations'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 header-top-margin">
                            <div class="box-header">
                                <div class="header-image push">
                                    <a href="https://line.me/R/ti/p/%40spp9501f%22" target="_blank">
                                    <img src="<?php echo base_url(); ?>template/front/assets/img/line.png" alt="line">
                                    </a>
                                </div>
                                <div class="header-text">
                                    <h3>
                                        <a href="https://line.me/R/ti/p/%40spp9501f%22" target="_blank">
                                            line: @heelcarethailand
                                        </a>
                                    </h3>
                                    <p class="">contact: 091-890-3797</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 header-top-margin">
                            <div class="box-header col2">
                                <div class="header-image push"><img
                                        src="<?php echo base_url(); ?>template/front/assets/img/header-img3.png" alt=""
                                        class=""></div>
                                <div class="header-text">
                                    <h3 style="text-transform: uppercase;">
                                            <a href="<?php echo base_url(); ?>index.php/home/contact/">
                                                <?php echo translate('contact'); ?>
                                            </a>
                                        </h3>
                                    <p class="">TEL. 02-689-8345</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-responsive-collapse">
                        <span class="sr-only"><?php echo translate('toggle_navigation'); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand visible-xs" href="<?php echo base_url(); ?>index.php/home/">
                        <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>"
                             alt="Logo"
                             class="img-responsive" style="height: inherit;">
                    </a>
                </div>

                <ul class="list-inline shop-badge badge-lists badge-icons pull-right" id="added_list">
                </ul>
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <!-- Badge -->
                    <!-- End Badge -->
                    <ul class="nav navbar-nav">
                        <!-- Home -->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/" class="dropdown-toggle">
                                <?php echo translate('home'); ?>
                            </a>
                        </li>
                        <!-- End Home -->
                        <!-- Categories-->
                        <li class="dropdown mega-menu-fullwidth">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown"
                               data-toggle="dropdown">
                                <?php echo translate('categories'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="container">
                                            <div class="row equal-height mega-menu">
                                                <?php
                                                $category = $this->db->get('category')->result_array();
                                                foreach ($category as $row) {
                                                    ?>
                                                    <div class="col-md-2 col-sm-12 equal-height-in">
                                                        <h3 class="mega-menu-heading">
                                                            <a href="<?php echo base_url(); ?>index.php/home/category/<?php echo $row['category_id']; ?>/">
                                                                <?php echo $row['category_name']; ?>
                                                            </a>
                                                        </h3>
                                                        <ul class="list-unstyled equal-height-list">
                                                            <?php
                                                            $sub_category = $this->db->get_where('sub_category', array('category' => $row['category_id']))->result_array();
                                                            foreach ($sub_category as $row1) {
                                                                ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>index.php/home/category/<?php echo $row['category_id']; ?>/<?php echo $row1['sub_category_id']; ?>/">
                                                                        <?php echo $row1['sub_category_name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div><!--/end row-->
                                        </div><!--/end container-->
                                    </div><!--/end mega menu content-->
                                </li>
                            </ul><!--/end dropdown-menu-->
                        </li>
                        <!-- END Categories-->

                        <!-- Promotion-->
                        <li class="dropdown mega-menu-fullwidth">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown"
                               data-toggle="dropdown">
                                <?php echo translate('promotion'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="container">
                                            <div class="row">

                                                <?php
                                                $this->db->order_by('product_id', 'desc');
                                                $this->db->limit(3);
                                                $promotion= $this->db->get_where('product', array('promotion' => 'ok','status' => 'ok'))->result_array();
                                                foreach ($promotion as $row) {
                                                    ?>
                                                    <div class="col-md-3 md-margin-bottom-30">
                                                        <div class="overflow-h">
                                                            <a href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">
                                                                <div class="illustration-v1 illustration-img1">
                                                                    <div class="illustration-bg"
                                                                         style="background:url('<?php echo $this->crud_model->file_view('product', $row['product_id'], '', '', 'no', 'src', 'multi', 'one') ?>') no-repeat center center; background-size: 100% auto;">
                                                                        <div class="illustration-ads ad-details-v1">
                                                                            <h4 style="background:rgba(205, 168, 168, 0.6); text-decoration:none; padding:3px; color:#fff;"><?php echo $row['title']; ?></h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-md-3 md-margin-bottom-30">
                                                    <div class="overflow-h">
                                                        <a href="<?php echo base_url(); ?>index.php/home/promotion_item">
                                                            <div class="illustration-v1 illustration-img1">
                                                                <div class="illustration-bg">
                                                                    <div class="illustration-ads ad-details-v1">
                                                                        <div
                                                                            class="btn-u btn-u-sea"><?php echo translate('see_more'); ?>
                                                                            <i class="fa fa-arrow-circle-right"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div><!--/end row-->
                                        </div><!--/end container-->
                                    </div><!--/end mega menu content-->
                                </li>
                            </ul><!--/end dropdown-menu-->
                        </li>
                        <!-- End Promotion-->

                        <!-- Sales Activities-->
<!--                        <li>-->
<!--                            <a href="--><?php //echo base_url(); ?><!--index.php/home/" class="dropdown-toggle">-->
<!--                                --><?php //echo translate('sales_activities'); ?>
<!--                            </a>-->
<!--                        </li>-->
                        <!-- End Sales Activities-->

                        <!-- Sales ordering-->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/policies/1" class="dropdown-toggle">
                                <?php echo translate('ordering'); ?>
                            </a>
                        </li>
                        <!-- End Sales ordering-->

                        <!-- Sales payment-->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/policies/7" class="dropdown-toggle">
                                <?php echo translate('payment'); ?>
                            </a>
                        </li>
                        <!-- End Sales payment-->

                        <!-- Sales shipping-->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/policies/2" class="dropdown-toggle">
                                <?php echo translate('shipping'); ?>
                            </a>
                        </li>
                        <!-- End Sales shipping-->


                        <!-- Sales shipping-->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/confirm_payment/" class="dropdown-toggle">
                                <?php echo translate('confirm_payment'); ?>
                            </a>
                        </li>
                        <!-- End Sales shipping-->






                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown"
                               data-toggle="dropdown">
                                <?php echo translate('other'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/policies/8" class="dropdown-toggle">
                                        การรับประกันสินค้าและรับซ่อมสินค้า
                                    </a>
                                </li>
                                <?php
                                $pages = $this->db->get_where('page', array('status' => 'ok'))->result_array();
                                foreach ($pages as $row1) {
                                    ?>
                                    <!-- Home -->
                                    <li class="dropdown">
                                        <a href="<?php echo base_url(); ?>index.php/home/page/<?php echo $row1['parmalink']; ?>"
                                           class="dropdown-toggle">
                                            <?php echo translate($row1['page_name']); ?>
                                        </a>
                                    </li>
                                    <!-- End Home -->
                                    <?php
                                }
                                ?>
                                <!-- Sales Activities-->
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/gallery/" class="dropdown-toggle">
                                        <?php echo translate('gallery'); ?>
                                    </a>
                                </li>
                                <!-- End Sales Activities-->
                                <!-- Event & Activity-->
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/event_activity" class="dropdown-toggle">
                                        <?php echo translate('event_&_activity'); ?>
                                    </a>
                                </li>
                                <!-- End Event & Activity-->

                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/storeLocations/" class="dropdown-toggle">
                                        <?php echo translate('branch'); ?>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/tracking/" class="dropdown-toggle">
                                        <?php echo translate('product_tracking'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Contact -->
                        <li class="dropdown">

                            <div  style="padding-top: 25px;">
                                <?php
                                echo form_open(base_url() . 'index.php/home/search', array(
                                    'class' => 'sky-form',
                                    'method' => 'get',
                                    'enctype' => 'multipart/form-data',
                                    'style' => 'border:none !important;'
                                ));
                                ?>
                                <input type="text" name="textSearch" class="form-control" placeholder="Search Product" value="<?=$_GET['textSearch'];?>" />
                                </form>
                            </div>

                        </li>
                        <!-- End Contact -->

                    </ul>
                </div><!--/navbar-collapse-->
            </div>
        </div>
        <!-- End Navbar -->
    </div>
    <!--=== End Header style1 ===-->
