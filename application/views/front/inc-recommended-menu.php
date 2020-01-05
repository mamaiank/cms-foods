<div class="panel panel-default border-color-fff">
	<div class="panel-body">
		<div class="name-p text-center">
			<?php echo translate('RECOMMENDED MENUS'); ?>
		</div>
		<hr class="dash-w10h3 center-block">
	</div>
</div>
<div class="group-recommended">
	<div class="row">
<?php	
    $this->db->limit(5);
    $this->db->order_by('id', 'asc');
    $a = $this->db->get('recommended_menus')->result_array();
?>
<?php
$i = 0;
foreach ($a as $row) {
	// if($i < 3){ $i++;	
	$title = $this->nookcs_model->getDataMultiLanguage($row['menu_name'],$row['menu_name_en']);	
?>
<div class="col-sm-3">
	<div class="thumbnail">
		<a href="<?php echo base_url(); ?>index.php/home/recommended_menus_detail/<?php echo $row['id'] ?>">
			<img alt="" src="<?php echo $this->crud_model->file_view('recommended_menus',$row['id'],'','','thumb','src','','one'); ?>" />
			<div class="caption">
				<?php echo $title; ?>
			</div>
		</a>
	</div>
</div>
<?php
	// }
}
?>
	</div>
</div>