<?php 
    // $model = CIntro::find()->where(['intro_public'=>1, 'active'=>1])->orderBy('intro_id DESC')->one();
    // if($model){
    //     Yii::$app->session['intro'] = true;
    //     return $this->render('_view_'.$model->intro_type, [
    //         'model'=>$model
    //     ]);
    // }else{
    //     $this->redirect(['site/index']);
    // }
$intro = $this->db->get_where('intro')->row();
$intro_img = $this->crud_model->file_view('intro', $intro->id, '', '', 'no', 'src', '', 'all');
$background_intro = $this->crud_model->file_view('backgroundintro', $intro->id, '', '', 'no', 'src', '', 'all');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
<style>


    .text-center {
        text-align: center;
    }

    body {
        background: url('<?php echo $background_intro; ?>') no-repeat top center fixed; 
        background-size: 100% 100%;
        font-family: 'Prompt', sans-serif;
    }

    .clear {
        clear: both;
    }
    .wrapper {
        max-width: 900px;
        margin: 0 auto 70px auto;
        padding: 0;
        display: block;
        position: relative;
    }

    .slider {
        display: block;
        margin: 0
    }
    .btn-layout{
        position: absolute;
        bottom: -40px;
        left: 34%;
        z-index: 999999999
    }
    @media screen and (max-width: 480px) {
        .btn-layout{
            position: absolute;
            bottom: -80px;
            left: 35%;
            z-index: 999999999
        }
    }
    .btn-custom{
        border-radius: 15px;
        background: rgba(255,149,0,1);
        background: -moz-linear-gradient(top, rgba(255,149,0,1) 0%, rgba(102,61,0,1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,149,0,1)), color-stop(100%, rgba(102,61,0,1)));
        background: -webkit-linear-gradient(top, rgba(255,149,0,1) 0%, rgba(102,61,0,1) 100%);
        background: -o-linear-gradient(top, rgba(255,149,0,1) 0%, rgba(102,61,0,1) 100%);
        background: -ms-linear-gradient(top, rgba(255,149,0,1) 0%, rgba(102,61,0,1) 100%);
        background: linear-gradient(to bottom, rgba(255,149,0,1) 0%, rgba(102,61,0,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff9500', endColorstr='#663d00', GradientType=0 );
        border: red;
    }
    .btn-custom:hover, .btn-custom:focus, .btn-custom.focus, .btn-custom:active, .btn-custom.active, .open > .dropdown-toggle.btn-custom {
        background-color: rgba(102,61,0,1);
        border-color: rgba(102,61,0,1);
        color: rgb(255, 255, 255);
    }
    .mt-2em{margin-top: 2em;}
    .dt-sc-bordered-button{width: 100px;}
</style>

<div class="wrapper content-wrapper">
    <div id="slider-wrapper" class="mt-2em">
            <div id="intro" class="ls-slide" data-ls="slidedelay:4000;transition2d:5;">
                <img src="<?php echo $intro_img; ?>" longdesc="Image intro" class="ls-bg" style="width:970px;">
            </div>
            <div class="text-center btn-intro mt-2em">
                <a type="button" style="background-color:#003865;" href="<?php echo base_url(); ?>index.php/home/set_language/Thai" class="btn btn-primary" name="site_language" value="th">เข้าสู่เว็บไซต์</a>
                <a type="button" style="background-color:#003865;" href="<?php echo base_url(); ?>index.php/home/set_language/english" class="btn btn-primary" name="site_language" value="en" style="margin-left:4px;">Enter Site</a>
            </div>
    </div>
</div>