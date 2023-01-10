<style>
.headertitle1
{
	display: block !important;
}
.menubtn2,.homebtn_div
{
	display:none;
}
.headertitle
{
	font-size:13px;
	color:white;
}
.part_div_1
{
	width: 100%;
	height: 160px;
	display: flex;
	overflow-y: hidden;
	margin-top:20px;
}
.part_div_01
{
	width:250px; 
	margin-left:7px;
	margin-right:7px;
	background:#ffffff;
	padding:10px;
	border-radius:10px;
}
.part_div_img_01
{
	width:200px;
	height:100px;
	margin-bottom:20px !important;
}

.part_div_2
{
	width: 100%;
	height: 385px;
	display: flex; 
	overflow-y: hidden; 
	margin-top: 20px;
}
.part_div_02
{
	width:200px;
	height: 385px;
	margin-left:7px;
	margin-right:7px;
	padding: 10px;
	border-radius: 10px;
	background:#ffffff;
}
.part_div_img_02
{
	width:150px;
	height:150px;
}
@media screen and (max-width: 767px) {
	.mcs-wrapper
	{
		left:0px !important;
		right:0px !important;
	}
	.part_div_1
	{
		width: 100%;
		height: 90px;
		display: flex;
		overflow-y: hidden;
		margin-top:20px;
	}
	.part_div_01
	{
		width:100px; 
		margin-left:7px;
		margin-right:7px;
		background:#ffffff;
		padding:10px;
		border-radius:10px;
	}
	.part_div_img_01
	{
		width:100px;
		height:100px;
	}

	.part_div_2
	{
		width: 100%;
		height: 280px;
		display: flex; 
		overflow-y: hidden; 
		margin-top: 20px;
	}
	.part_div_02
	{
		width:120px;
		height: 280px; 
		margin-left:7px;
		margin-right:7px;
		padding: 10px;
		border-radius: 10px;
		background:#ffffff;
	}
	.part_div_img_02
	{
		width:120px;
		height:120px;
	}
	
	.home_page_title
	{
		color: #1084a1;
		font-size: 15px;
		height:35px;
		width: 120px;
		overflow:hidden;
		word-wrap: break-word;
		white-space: pre-wrap;
		line-height: 17px;
		margin-top:-15px;
	}
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12"  style="margin-top:50px;">
			<div class="row">			
				<div class="col-xs-12 col-sm-12 col-12" style="width: 100%;">
					<script src="<?= base_url(); ?>assets/js/jssor.slider-28.0.0.min.js" type="text/javascript"></script>
					<script type="text/javascript">
					window.jssor_1_slider_init = function() {

						var jssor_1_options = {
						  $AutoPlay: 1,
						  $SlideWidth: 700,
						  $ArrowNavigatorOptions: {
							$Class: $JssorArrowNavigator$
						  },
						  $BulletNavigatorOptions: {
							$Class: $JssorBulletNavigator$
						  }
						};

						var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

						/*#region responsive code begin*/

						var MAX_WIDTH = screen.width;

						function ScaleSlider() {
							var containerElement = jssor_1_slider.$Elmt.parentNode;
							var containerWidth = containerElement.clientWidth;

							if (containerWidth) {

								var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

								jssor_1_slider.$ScaleWidth(expectedWidth);
							}
							else {
								window.setTimeout(ScaleSlider, 30);
							}
						}

						ScaleSlider();

						$Jssor$.$AddEvent(window, "load", ScaleSlider);
						$Jssor$.$AddEvent(window, "resize", ScaleSlider);
						$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
						/*#endregion responsive code end*/
					};
					</script>
					<style>
						/*jssor slider loading skin spin css*/
						.jssorl-009-spin img {
							animation-name: jssorl-009-spin;
							animation-duration: 1.6s;
							animation-iteration-count: infinite;
							animation-timing-function: linear;
						}

						@keyframes jssorl-009-spin {
							from { transform: rotate(0deg); }
							to { transform: rotate(360deg); }
						}

						/*jssor slider bullet skin 051 css*/
						.jssorb051 .i {position:absolute;cursor:pointer;}
						.jssorb051 .i .b {fill:#fff;fill-opacity:0.5;}
						.jssorb051 .i:hover .b {fill-opacity:.7;}
						.jssorb051 .iav .b {fill-opacity: 1;}
						.jssorb051 .i.idn {opacity:.3;}

						/*jssor slider arrow skin 051 css*/
						.jssora051 {display:block;position:absolute;cursor:pointer;}
						.jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
						.jssora051:hover {opacity:.8;}
						.jssora051.jssora051dn {opacity:.5;}
						.jssora051.jssora051ds {opacity:.3;pointer-events:none;}
						.img_css_forslider
						{
							margin-left: 10px;
							margin-right: 10px;
							border-radius: 15px;
							width: 98% !important;
						}
					</style>
					<div id="jssor_1">
					<!-- Loading Screen -->
						<div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
							<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/spin.svg" alt>
						</div>
						<div data-u="slides" class="top_flash_div">
							<?php
							foreach($top_flash as $row)
							{
								if(empty($row["division"])){
									$row["division"]="not";
								}
								?>
								<div>
									<a href="javascript:callandroidfun('<?= $row["funtype"] ?>','<?= $row["itemid"] ?>','<?= base64_encode($row["compname"])?>','<?= $row["image"] ?>','<?= $row["division"] ?>');">
										<img src="<?= $row["image"] ?>" data-u="image" class="img_css_forslider" alt>
									</a>
								</div>
							<?php 
							} ?>
						</div>
						<!-- Bullet Navigator -->
						<div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
							<div data-u="prototype" class="i" style="width:16px;height:16px;">
								<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
									<circle class="b" cx="8000" cy="8000" r="5800"></circle>
								</svg>
							</div>
						</div>
						<!-- Arrow Navigator -->
						<div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:35px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
							<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
								<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
							</svg>
						</div>
						<div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:35px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
							<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
								<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
							</svg>
						</div>
					</div>
					<script type="text/javascript">jssor_1_slider_init();</script>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-12 rounded p-1 home_fun1">
				</div>
				
			</div>
			
			<div class="row home_page_big_div2 home_big_menu">
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/search_medicine')?>" style="color:black">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn1.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">New order</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/draft_order_list')?>"  style="color:black">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn2.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Draft <span class="mycartwalidiv1"></span></div>
							</div>
						</a>
					</div>
				</div>

				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/my_orders')?>" style="color:black" title="My orders">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn3.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">My orders</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/my_invoice')?>" style="color:black" title="My invoices">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn4.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">My invoices</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/track_order')?>" style="color:black" title="Track order">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn5.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Track order</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1 mobile_off">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('import_order')?>" title="Upload order">
							<div class="text-center">
								<img src="<?= base_url()?>img_v<?= constant('site_v') ?>/homebtn6.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Upload order</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1 mobile_show">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('home/my_notification')?>" title="Notifications">
							<div class="text-center">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homebtn7.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Notifications</div>
							</div>
						</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-12 rounded p-1 home_fun2">
				</div>
				
				<div class="col-xs-12 col-sm-12 col-12 rounded p-1 home_fun3">
				</div>
				
				<div class="col-xs-12 col-sm-12 col-12 rounded p-1 home_fun4">
				</div>
				
				<div class="col-xs-12 col-sm-12 col-12 rounded p-1 home_fun5">
				</div>
				
				<div class="col-xs-12 col-sm-12 col-12 p-1">
					<div id="flash2" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
						<?php
						foreach($top_flash2 as $row)
						{
							if(!empty($row["division"])){
								$row["division"]="not";
							}
							?>
							<div class="carousel-item <?= $row["id"] ?>">
								<a href="javascript:callandroidfun('<?= $row["funtype"] ?>','<?= $row["itemid"] ?>','<?= base64_encode($row["compname"])?>','<?= $row["image"] ?>','<?= $row["division"] ?>');">
									<img src="<?= $row["image"] ?>" data-u="image" class="img_css_forslider1" alt>
								</a>
							</div>
							<?php
						}
						?>
						</div>
						<a class="carousel-control-prev" href="#flash2" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</a>
						<a class="carousel-control-next" href="#flash2" data-slide="next">
							<span class="carousel-control-next-icon"></span>
						</a>
					</div>
				</div>
			</div>
		</div>		
	</div> 
</div>
<?php
$broadcast_status = $this->Scheme_Model->get_website_data("broadcast_status");
if($broadcast_status=="1"){ ?>
	<script>
	setTimeout(function() {
		$('.broadcast_title').html("<?= $this->Scheme_Model->get_website_data("broadcast_title"); ?>");
		$('.broadcast_message').html("<?= $this->Scheme_Model->get_website_data("broadcast_message"); ?>");
        $('.myModal_broadcast').click();
    }, 2000);
	</script>
	<?php
}
?>
<script>
$(document).ready(function(){
	setTimeout("home_fun1()",50);
});
function home_fun1()
{
	$('.home_fun1').html('<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant("site_v") ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>');
	id = "";
	$.ajax({
		type       : "POST",
		data       : {id:id},
		url        : "<?php echo base_url(); ?>home_json/home_fun1",
		cache	   : true,
		error: function(){
			//alert("error home_fun1")
		},
		success    : function(data){
			$('.home_fun1').html(data)
			setTimeout("home_fun2()",50);
		},
		timeout: 60000
		
	});
}
function home_fun2()
{
	$('.home_fun2').html('<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant("site_v") ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>');
	id = "";
	$.ajax({
		type       : "POST",
		data       : {id:id},
		url        : "<?php echo base_url(); ?>home_json/home_fun2",
		cache	   : true,
		error: function(){
			//alert("error home_fun2")
		},
		success    : function(data){
			$('.home_fun2').html(data)
			setTimeout("home_fun3()",50);
		},
		timeout: 60000
		
	});
}
function home_fun3()
{
	$('.home_fun3').html('<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant("site_v") ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>');
	id = "";
	$.ajax({
		type       : "POST",
		data       : {id:id},
		url        : "<?php echo base_url(); ?>home_json/home_fun3",
		cache	   : true,
		error: function(){
			//alert("error home_fun3")
		},
		success    : function(data){
			$('.home_fun3').html(data)
			setTimeout("home_fun4()",50);
		},
		timeout: 60000
		
	});
}
function home_fun4()
{
	$('.home_fun4').html('<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant("site_v") ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>');
	id = "";
	$.ajax({
		type       : "POST",
		data       : {id:id},
		url        : "<?php echo base_url(); ?>home_json/home_fun4",
		cache	   : true,
		error: function(){
			//alert("error home_fun4")
		},
		success    : function(data){
			$('.home_fun4').html(data)
			setTimeout("home_fun5()",50);
		},
		timeout: 60000
		
	});
}

function home_fun5()
{
	$('.home_fun5').html('<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant("site_v") ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>');
	id = "";
	$.ajax({
		type       : "POST",
		data       : {id:id},
		url        : "<?php echo base_url(); ?>home_json/home_fun5",
		cache	   : true,
		error: function(){
			//alert("error home_fun5")
		},
		success    : function(data){
			$('.home_fun5').html(data)
		},
		timeout: 60000
		
	});
}
</script>