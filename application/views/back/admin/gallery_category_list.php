	<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >

			<thead>
				<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('image');?></th>
					<th><?php echo translate('name');?></th>
					<th><?php echo translate('description');?></th>
					<th class="text-right"><?php echo translate('options');?></th>
				</tr>
			</thead>
				
			<tbody >
			<?php
				$i = 0;
            	foreach($all_categories as $row){
            		$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td>
					<?php
					$images = $this->crud_model->file_view('gallery_category', $row['c_gallery_id'], '', '', 'thumb', 'src', '', 'all');
					?>
					<img class="img-thumbnail" width="150" src="<?php echo $images; ?>" alt="<?= $row['c_gallery_title'] ?>">
				</td>
				<td><?php echo $row['c_gallery_title']; ?></td>
				<td><?php echo $row['c_gallery_description']; ?></td>
				<td class="text-right">
					<a class="btn btn-success btn-xs btn-labeled fa fa-picture-o" data-toggle="tooltip" href="gallery/<?=$row['c_gallery_id']?>">
						<?php echo translate('add_images');?>
					</a>
					<a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                    	onclick="ajax_modal('edit','<?php echo translate('edit_gallery_category'); ?>','<?php echo translate('successfully_edited!'); ?>','gallery_category_edit','<?php echo $row['c_gallery_id']; ?>')"
                        	data-original-title="Edit" data-container="body">
                            	<?php echo translate('edit');?>
                    </a>
					<a onclick="delete_confirm('<?php echo $row['c_gallery_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip"
                    	data-original-title="Delete" data-container="body">
                        	<?php echo translate('delete');?>
                    </a>
				</td>
			</tr>
            <?php
            	}
			?>
			</tbody>
		</table>
	</div>
           
	<div id='export-div'>
		<h1 style="display:none;"><?php echo translate('gallery_category'); ?></h1>
		<table id="export-table" data-name='gallery_category' data-orientation='p' style="display:none;">
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
						<th><?php echo translate('name');?></th>
					</tr>
				</thead>
					
				<tbody >
				<?php
					$i = 0;
	            	foreach($all_categories as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['c_gallery_title']; ?></td>
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>

