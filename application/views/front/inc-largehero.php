<meta charset="utf-8">
		<div class="container">
			<div class="largehero">
				<div id="layerslider" style="width:1140px; height:479px;max-width:1140px;">
<?php 
	$this->db->where('status','ok');
	$this->db->order_by('serial','desc');
	$this->db->order_by('slider_id','desc');
	$sliders = $this->db->get('slider')->result_array();
	foreach ($sliders as $row1) {
		$elements = json_decode($row1['elements'],true);
		$oimgs 	= $elements['images'];
		$txts 	= $elements['texts'];
		$style = json_decode($this->db->get_where('slider_style',array('slider_style_id'=>$row1['style']))->row()->value,true);
?>
			<!--slide-->
			<div class="ls-slide" <?php echo $style['full_slide_style']; ?> >
                <!--BACKGROUND-->
				<?php if(file_exists('uploads/slider_image/background_'.$row1['slider_id'].'.jpg')){ ?>
					<img src="<?php echo base_url(); ?>uploads/slider_image/background_<?php echo $row1['slider_id']; ?>.jpg" class="ls-bg" alt="Slide background"/>
				<?php } else { ?>
					<img src="<?php echo base_url(); ?>uploads/others/slider default.jpg" class="ls-bg" alt="Slide background"/>
				<?php } ?>

                <?php
                	foreach($style['images'] as $image){
                		if(in_array($image['name'], $oimgs)){
                ?>
                    <img class="ls-l" src="<?php echo base_url(); ?>uploads/slider_image/<?php echo $row1['slider_id']; ?>_<?php echo $image['name']; ?>.png"   style="<?php echo $image['style']; ?>" data-ls="<?php echo $image['data_ls']; ?>" >
                <?php
                		}
                	}
                ?>
                <?php
                	foreach($style['texts'] as $text){
                		$txt = ''; $color = ''; $background = '';
                		foreach ($txts as $a) {
            				if($a['name'] == $text['name']){
            					$txt = $a['text'];
            					$color = $a['color'];
            					$background = $a['background'];
                			}
                		}
                		if($txt !== ''){
                ?>
                    <<?php echo $text['element']; ?> class="ls-l" style="<?php echo $text['style']; ?> color:<?php echo $color; ?>; background:<?php echo $background; ?>" data-ls="<?php echo $text['data_ls']; ?>" >
                        <?php echo $txt; ?>
                    </<?php echo $text['element']; ?>>
                <?php
                		}
                	}
                ?>
			</div>
			<!--slide-->
<?php
	}
?>
					
				</div>
			</div>
		</div>
		<div class="space10"></div>
		<script>
		initLayerSlider();
		</script>