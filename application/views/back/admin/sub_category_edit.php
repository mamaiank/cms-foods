<?php
	foreach($sub_category_data as $row){
?>
 
<div>
	<?php
        echo form_open(base_url() . 'index.php/admin/sub_category/update/' . $row['sub_category_id'], array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'sub_category_edit',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-inputemail">
                	<?php echo translate('sub-category_name');?>
                    	</label>
                <div class="col-sm-6">
                    <input type="text" name="sub_category_name" value="<?php echo $row['sub_category_name'];?>" class="form-control required" placeholder="<?php echo translate('sub-category_name'); ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-inputemail">
                    <?php echo translate('sub-category_name_eng');?>
                        </label>
                <div class="col-sm-6">
                    <input type="text" name="sub_category_name_en" value="<?php echo $row['sub_category_name_en'];?>" class="form-control required" placeholder="<?php echo translate('sub-category_name_eng'); ?>" >
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-inputemail">
                    <?php echo translate('sub-category_description');?>
                        </label>
                <div class="col-sm-6">
                    <input type="text" name="description" value="<?php echo $row['description'];?>" class="form-control required" placeholder="<?php echo translate('sub-category_description'); ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-inputemail">
                    <?php echo translate('sub-category_description_eng');?>
                        </label>
                <div class="col-sm-6">
                    <input type="text" name="description_en" value="<?php echo $row['description_en'];?>" class="form-control required" placeholder="<?php echo translate('sub-category_description_eng'); ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo translate('category');?></label>
                <div class="col-sm-6">
                    <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category']); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });


	$(document).ready(function() {
		$("form").submit(function(e){
			return false;
		});
	});
</script>

<?php
	}
?>
	
