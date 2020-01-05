		<div class="container" style="min-height:500px;">
			<div class="space20"></div>
<?php 
if($_GET['get']==1) {
	$getID = "1";
	$namePage = "JV Products Chilled";
} elseif($_GET['get']==2) {
	$getID = "2";
	$namePage = "Textture Soy Protein";
}
?>
			<div class="group-spafoods">
				<div class="row">
					<div class="col-sm-6">
						<div class="thumbnail-page">
							<img class="img-responsive hidden-xs" src="<?php echo base_url(); ?>template/front/images/overy590x290.jpg" />
							<div class="content-page">
								<div class="name-p text-center"><?php echo $namePage; ?></div>
								<hr class="dash-w10h3 center-block">
								<div class="caption text-center">The Magic of Soy,In this way,one gets the benefits of soy, while also reducing the intake of saturated fat and cholesterol, and heteroclycic amines, potentially harmful carcinogenic compounds that are formed when meatis cooked(8).</div>
							</div>
						</div>
					</div>
					<?php for ($i=1;$i<=10;$i++) {?>
					<div class="col-sm-3">
						<div class="thumbnail">
							<a href="<?php echo base_url(); ?>index.php/home/jvproduct_detail?get=<?php echo $getID; ?>&id=<?php echo $i; ?>">
								<img alt="" src="<?php echo base_url(); ?>template/front/images/noimg400x300.jpg" />
								<div class="caption">
									Veggie SPA Frankfurt Sausage
									<i class="fa fa-plus" aria-hidden="true"></i>
								</div>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<nav aria-label="Page navigation" class="text-center pageall">
				<ul class="pagination">
					<li class="previous">
						<a href="#" aria-label="Previous">
							<span aria-hidden="true">PREV</span>
						</a>
					</li>
					<li class="active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li class="next">
						<a href="#" aria-label="Next">
							<span aria-hidden="true">NEXT</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>