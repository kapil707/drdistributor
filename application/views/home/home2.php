<!-- 
<div class="home" id="home">

    <div class="row">
	<div class="col-xs-12 col-sm-12 col-12">
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
						<div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
							<div data-u="prototype" class="i" style="width:16px;height:16px;">
								<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
									<circle class="b" cx="8000" cy="8000" r="5800"></circle>
								</svg>
							</div>
						</div>
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
    </div>

</div>

home section ense  -->


        
        
<section class="blogs" id="blogs">

    <h1 class="heading"> <span><?php echo $title1 ?></span> </h1>

    <div class="swiper featured-slider">

        <div class="swiper-wrapper">
		
			<?php
				foreach($result1 as $row)
				{
					if(empty($row["division"])){
						$row["division"] = "not";
					}
					
					?>

            <div class="swiper-slide box">
                <div class="mcs-items-container">
                    <div class="part_div_02">
                        <div class="image">
                            <img src="<?= $row["image"]; ?>" alt="">
                        </div>
                        <div class="content">
                            <h3><?= base64_decode($row["company_full_name"]); ?></h3>
                            <a href="<?= base_url(); ?>home/featured_brand/<?= $row["compcode"]; ?>/<?= $row["division"]; ?>/<?= $row["company_full_name"]; ?>" class="btn">View More</a>
                        </div>
                    </div>
                </div>
            </div>
			
			<?php } ?>
        </div>

    </div>

</section>

<section class="icons-container">

    
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn1.png">My folder</a>
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn2.png">Draft </a>
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn3.png">My orders</a>
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn4.png">My invoices</a>
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn5.png">Track order</a>
    <a href="#" class="myfolder"><img class="icons" src="<?= base_url(); ?>assets/newgreen/image/homebtn6.png">Upload order</a>

</section>

<!-- featured section starts  -->

<section class="featured" id="featured">

    <h1 class="heading"> <span><?php echo $title2 ?></span> </h1>


    <div class="swiper featured-slider">

        <div class="swiper-wrapper">

			<?php
				foreach($result2 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
            <div class="swiper-slide box">
				<div class="ribbon">
                    <img src="<?= base_url(); ?>assets/newgreen/image/red-ribbon-png.png">xxxx</div>
                <div class="image">
                    <img src="<?= $row["image"]; ?>" alt="">
                </div>
                
                <div class="content">
                    <h5 style="font-size: 12px; color: blue;"><?= ($row["item_name"]); ?>
                    <span style="color: orange;">(<?= $row["packing"]; ?> Packing)</span></h5>
                    <p style="font-size: 14px; color: brown;">By <?= ($row["company_full_name"]); ?> </p>
                    <div class="price">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-
                    <span style="font-size: 20px;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</span></div>
                    <p style="font-size: 18px; color: orangered;">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</p>
                    
                </div>
            </div>
			<?php } ?>
        </div>  

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>

</section>

<section class="featured" id="featured">

    <h1 class="heading"> <span><?php echo $title3 ?></span> </h1>


    <div class="swiper featured-slider">

        <div class="swiper-wrapper">

			<?php
				foreach($result3 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
            <div class="swiper-slide box">
				<div class="ribbon">
                    <img src="<?= base_url(); ?>assets/newgreen/image/red-ribbon-png.png">xxxx</div>
                <div class="image">
                    <img src="<?= $row["image"]; ?>" alt="">
                </div>
                
                <div class="content">
                    <h5 style="font-size: 12px; color: blue;"><?= ($row["item_name"]); ?>
                    <span style="color: orange;">(<?= $row["packing"]; ?> Packing)</span></h5>
                    <p style="font-size: 14px; color: brown;">By <?= ($row["company_full_name"]); ?> </p>
                    <div class="price">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-
                    <span style="font-size: 20px;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</span></div>
                    <p style="font-size: 18px; color: orangered;">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</p>
                    
                </div>
            </div>
			<?php } ?>
        </div>  

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>

</section>

<section class="featured" id="featured">

    <h1 class="heading"> <span><?php echo $title4 ?></span> </h1>


    <div class="swiper featured-slider">

        <div class="swiper-wrapper">

			<?php
				foreach($result4 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
            <div class="swiper-slide box">
				<div class="ribbon">
                    <img src="<?= base_url(); ?>assets/newgreen/image/red-ribbon-png.png">xxxx</div>
                <div class="image">
                    <img src="<?= $row["image"]; ?>" alt="">
                </div>
                
                <div class="content">
                    <h5 style="font-size: 12px; color: blue;"><?= ($row["item_name"]); ?>
                    <span style="color: orange;">(<?= $row["packing"]; ?> Packing)</span></h5>
                    <p style="font-size: 14px; color: brown;">By <?= ($row["company_full_name"]); ?> </p>
                    <div class="price">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-
                    <span style="font-size: 20px;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</span></div>
                    <p style="font-size: 18px; color: orangered;">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</p>
                    
                </div>
            </div>
			<?php } ?>
        </div>  

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>

</section>


<section class="footer">

    <div class="box-container">

        <div class="box">
         </div>
        <div class="box">
            
            <img src="<?= base_url(); ?>assets/newgreen/image/drphone.png">
        </div>

        <div class="box">
            <h3>Download the App for Free</h3>
            <img src="<?= base_url(); ?>assets/newgreen/image/playstote.jpg">
        </div>

        <div class="box">
        </div>

        
        
    </div>

  
    <div class="credit"> created by <span>web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->

<!-- loader  -->

<script src="<?= base_url(); ?>assets/newgreen/js/min.js"></script>


<!-- custom js file link  -->
<script src="<?= base_url(); ?>assets/newgreen/js/script.js"></script>

</body>
</html>