<?php
	foreach($category_data as $row){
?>
	<div class="tab-pane fade active in" id="edit">
		<?php
			echo form_open(base_url() . 'index.php/admin/category/update/' . $row['category_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'category_edit',
				'enctype' => 'multipart/form-data'
			));
		?>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="demo-hor-1">
                    	<?php echo translate('category_name');?>
                        	</label>
					<div class="col-sm-6">
						<input type="text" name="category_name"  
                        	value="<?php echo $row['category_name'];?>" id="demo-hor-1" 
                            	class="form-control required" placeholder="<?php echo translate('category_name');?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="demo-hor-1">
                    	<?php echo translate('category_name_eng');?>
                        	</label>
					<div class="col-sm-6">
						<input type="text" name="category_name_en"  
                        	value="<?php echo $row['category_name_en'];?>" id="demo-hor-1" 
                            	class="form-control required" placeholder="<?php echo translate('category_name_eng');?>" >
					</div>
				</div>
				<div class="form-group">
	                <label class="col-sm-4 control-label" for="demo-hor-1">
	                    <?php echo translate('image'); ?>
	                </label>
	                <div class="col-sm-6">
	                    <?php
	                        $images = $this->crud_model->file_view('category', $row['category_id'], '', '', 'thumb', 'src', '', 'all');
	                    ?>
	                    <span id="previewImg" style="padding: 10px"><?php if(!empty($images)){ ?><img width='250' src="<?=$images?>" class='img-thumbnail'><?php } ?></span>
	                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?> (290 x 290 px)
	                        <input type="file" multiple name="pic" onchange="preview(this);" id="demo-hor-12" class="form-control">
	                    </span>
	                </div>
	            </div>
			</div>
		</form>
	</div>
<?php
	}
?>

<script>
	$(document).ready(function() {
	    $("form").submit(function(e) {
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