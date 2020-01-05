<div class="panel-body">
    <!-- Delete Logo Div -->
    <?php foreach ($gallery as $row){
        ?>
        <div class="delete-div-wrap col-xs-3">
            <span class="close"><i class="fa fa-trash"></i></span>
            <div class="inner-div tr-bg">
                <img class="img-responsive img-md"
                	src="<?php echo base_url(); ?>uploads/gallery_image/<?php echo $row['gallery_name']; ?>_thumb<?=$row['gallery_extension'];?>"
                    	data-id="<?php echo $row['gallery_id']; ?>" >
            <?php
//            $this->crud_model->file_gallery_view('gallery');
            ?>
            </div>
        </div>
    <?php } ?>
</div>
<script>
	$('.delete-div-wrap .close').on('click', function() {
	    var id = $(this).closest('.delete-div-wrap').find('img').data('id');
	    delete_confirm(id, '<?php echo translate('really_want_to_delete_this_logo?'); ?>');
	});
</script>