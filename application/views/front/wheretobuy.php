
		<div class="container">
			<div class="space20"></div>

			<div class="panel panel-default border-color-fff">
				<div class="panel-body">
					<div class="name-p text-center">
						<?php echo $page_title ?>
					</div>
					<hr class="dash-w10h3 center-block">
				</div>
			</div>
					<?php 
					foreach ($content as $row) {
					?>
			<div class="group-spafoods">
				<div class="row">
					
					<div class="col-sm-3">
						<div class="thumbnail">
							<a target="_blank" href="<?php echo $row["where_to_buy_link"] ? $row["where_to_buy_link"] : 'javascript:void(0)'; ?>">
								<img alt="<?php echo $row["where_to_buy_name"]; ?>" src="<?php echo $this->crud_model->file_view('where_to_buy',$row['where_to_buy_id'],'','','thumb','src','','one'); ?>" />
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>

		</div>