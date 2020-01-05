
		<div class="container" style="min-height:500px;">
			<div class="space20"></div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="name-p text-center">
						<?php echo $page_title ?>
					</div>
					<hr class="dash-w10h3 center-block">
				</div>
			</div>

			<div class="group-spafoods">
				<div class="row">
					<?php 
					foreach ($content as $row) {
					?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a target="_blank" href="<?php echo $row["partners_link"] ? $row["partners_link"] : 'javascript:void(0)'; ?>">
								<img alt="" src="<?php echo $this->crud_model->file_view('partners',$row['partners_id'],'','','thumb','src','','one'); ?>" />
								<div class="caption">
									<?php echo $row["partners_name"]; ?>
									<i class="fa fa-plus" aria-hidden="true"></i>
								</div>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>

		</div>
