
<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_founder');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="tab-base tab-stacked-left">
                <!-- <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-5">Founder <?php echo translate('settings');?></a>
                    </li>
                </ul> -->

                <div class="tab-content bg_grey">

                    <!-- START : MANAGE Founder------>
                    <div id="demo-stk-lft-tab-5" class="tab-pane fade active in">
                         <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading margin-bottom-20">
                                    <h3 class="panel-title">
                                        <?php echo translate('manage_founder');?>
                                    </h3>
                                </div>
                            <?php 
                                $firstname =  $this->db->get_where('founder',array('type' => 'firstname'))->row()->value;
                                $lastname =  $this->db->get_where('founder',array('type' => 'lastname'))->row()->value;
                                $firstname_en =  $this->db->get_where('founder',array('type' => 'firstname'))->row()->value_en;
                                $lastname_en =  $this->db->get_where('founder',array('type' => 'lastname'))->row()->value_en;
                            ?>
							<?php
                                echo form_open(base_url() . 'index.php/admin/founder/set', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-1">
                                        <?php echo translate('image'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php
                                            $images = $this->crud_model->file_view('founder', 'image', '', '', 'thumb', 'src', '', 'all');
                                        ?>
                                        <span id="previewImg" style="padding: 10px"><?php if(!empty($images)){ ?><img width='250' src="<?=$images?>" class='img-thumbnail'><?php } ?></span>
                                                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (300 x 400 px)
                                                <input type="file" multiple name="pic" onchange="preview(this);" id="demo-hor-12"
                                                       class="form-control">
                                                                        </span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('firstname'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('lastname'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('firstname_eng'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <input type="text" name="firstname_en" value="<?php echo $firstname_en; ?>" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                        <?php echo translate('lastname_eng'); ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="col-sm-">
                                            <input type="text" name="lastname_en" value="<?php echo $lastname_en; ?>" class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                    <?php echo translate('save');?></span>
                                </div>
                            </form>               
                        </div>
                        </div> 
                    </div>
                    <!-- END : MANAGE Founder-->                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="site"></div>

<script type="text/javascript">

    $(document).ready(function() {
//        sets('later');
		$("form").submit(function(e){
			return false;
		});

	});
        
         window.preview = function (input) {
            if (input.files && input.files[0]) {
                $("#previewImg").html('');
                $(input.files).each(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this);
                    reader.onload = function (e) {
                        $("#previewImg").append("<img width='250' src='" + e.target.result + "' class='img-thumbnail'>");
                    }
                });
            }
        }
    
</script>

