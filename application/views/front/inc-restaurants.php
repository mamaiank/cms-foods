<meta charset="utf-8">
<?php
	
    $this->db->limit(5);
    $this->db->order_by('id', 'asc');
    $a = $this->db->get('store_locations')->result_array();
?>
	<h3 class="text-color-003366"><?php echo translate('Restaurants & Services'); ?></h3>
   <?php
	$i = 0;
	foreach ($a as $row) {
		if($i < 3){ $i++;	
		$title = $this->nookcs_model->getDataMultiLanguage($row['store_name'],$row['store_name']);	
		if($i == 1){
			$color = 'brown';
		} else if($i == 2){
			$color = 'blue';
		} else {
			$color = 'green';
		}
	?>
	<div class="thumbnail <?php echo $color ?>">
		<a href="<?php echo base_url(); ?>index.php/home/restaurant_detail/<?php echo $row['id'] ?>">
			<img alt="The Vegetarian Cottage" src="<?php echo $this->crud_model->file_view('store_locations',$row['id'],'','','thumb','src','','one'); ?>" />
			<span class="caption"><?php echo $title; ?></span>
		</a>
	</div>
	<?php 
		} 
	}
	?>