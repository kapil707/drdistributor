<?php 
$theme_type = "lite";
if (!isset($_COOKIE["user_cart_total"])) {
	setcookie("user_cart_total", "0", time() + (86400 * 30), "/");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		<?= $this->Scheme_Model->get_website_data("title") ;?> || <?= $main_page_title;?>
    </title>
    <meta charset utf="8">
	<meta name="theme-color" content="#27ae60">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/font-awesome.min.css"> 
	<link href="<?= base_url(); ?>assets/website/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<?php if($theme_type=="lite") { ?>
	<style>/*light theme*/
	:root{
		--main_theme_color:#27ae60;
		--main_theme_footer_color:#ffffff;
		--main_theme_bg_color:#d3cfcf42;

		--main_theme_white_bg_color:#ffffff;
		--main_theme_left_menu_bg_color:#27ae60;
		--main_theme_scrollbar_color:#27ae60;
		

		--main_theme_li_color:rgb(240, 240, 240);
		--main_theme_li_bg_color:#969a9829;
		--main_theme_li_bg_hover_color:#27ae6029;

		--main_theme_li2_color:rgb(240, 240, 240);
		--main_theme_li2_bg_color:#ffffff;
		--main_theme_li2_bg_hover_color:#27ae6029;

		--main_theme_textbox_bg_color:#ffffff;
		--main_theme_textbox_color:#6A6767;

		--main_theme_textbox2_bg_color:#ffffff;
		--main_theme_textbox2_color:#6A6767;

		--main_theme_text_white_color:#ffffff;
		--main_theme_text_black_color:#000000;

		--main_theme_border_color:#ebebeb;
		--main_theme_border_hover_color:#27ae6085;
		
		--main_theme_modal_bg_color:#ffffff;

		--mainbutton-color:#27ae60; /* #27ae60; */
		--mainbuttonhover-color:#1b6339; /* #27ae60; */

		
		--item_order_quantity_bg:#e8e8e8;
	}
	</style>
	<?php } ?>

	<?php if($theme_type=="dark") { ?>
	<style>/*dark theme */
	:root{
		--main_theme_color:#191616;
		--main_theme_footer_color:#191616;
		--main_theme_bg_color:#474040;

		--main_theme_white_bg_color:#606060;
		--main_theme_left_menu_bg_color:#606060;
		

		--main_theme_li_color:#474040;
		--main_theme_li_bg_color:#000000;
		--main_theme_li_bg_hover_color:#232020;

		--main_theme_li2_color:rgb(240, 240, 240);
		--main_theme_li2_bg_color:#000000;
		--main_theme_li2_bg_hover_color:#27ae6029;

		--main_theme_textbox_bg_color:#474040;
		--main_theme_textbox_color:#ebebeb;

		--main_theme_textbox2_bg_color:#191616;
		--main_theme_textbox2_color:#ebebeb;

		--main_theme_text_white_color:#000000;
		--main_theme_text_black_color:#ffffff;
		
		--main_theme_border_color:#6A6767;
		--main_theme_border_hover_color:#6A6767;
		--main_theme_modal_bg_color:#000000; /* 474040 */

		--mainbutton-color:#607d8b; /* #27ae60; */
		--mainbuttonhover-color:#364952; /* #27ae60; */

		--item_order_quantity_bg:#474040;
	} /************/
	</style>
	<?php } ?>

	<link href="<?= base_url(); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>
	<script>
		/*function goBack() {
			window.history.back();
		}*/
	</script>

	<link rel="icon" href="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" type="image/logo" sizes="16x16">
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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

	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/min.css"/>
	<script src="<?= base_url(); ?>assets/website/js/min.js"></script>

</head>
<body>
<?php
if(empty($chemist_id_for_cart_total))
{
	$chemist_id_for_cart_total = "";
}
$website_menu 	= file_get_contents('./json_api/website_menu_json_new.json');
$website_menu 	= '['.$website_menu.']';
$website_menu 	= json_decode($website_menu, true);
?>
	<img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" style="display:none" alt="Dr. Distributor" title="Dr. Distributor">
	<div class="left_menu_bar">
		<div class="left_menu_bar_part1">
			<div class="row">
				<div class="col-sm-3 col-3">
					<img src="<?= $session_user_image ?>" alt="<?= $session_user_fname ?>" title="<?= $session_user_fname ?>" class="left_menu_bar_account_image" onerror=this.src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png">
				</div>
				<div class="col-sm-7 col-7">
					<div class="left_menu_bar_accoun_chemist_name">
						<?= $session_user_fname ?>
					</div>
					<div class="left_menu_bar_accoun_chemist_code">
						Code : <?= $session_user_altercode ?>
					</div>
					<div class="" style="display:none">
						<lable>Select theme</lable><br>
						<select class="input_type_text2 theme_set_css" onchange="theme_set()">
							<option value="lite" <?php if($theme_type=="lite") { echo "selected"; } ?>>Lite</option>
							<option value="dark" <?php if($theme_type=="dark") { echo "selected"; } ?>>Dark</option>
						</select>
					</div>
				</div>
				<div class="col-sm-2 col-2 text-left">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cancelbtn.png" width="40" onclick="new_style_menu_hide()" title="Cancel menu" alt="Cancel menu">
				</div>
			</div>
		</div>
		<div class="left_menu_bar_part2 text-center">
			<div class="social-icon">
			<div class="text-left" style="margin-left:10px;margin-top:10px; border-top: 1px solid #f3f3f3;">Account</div>
				<ul>
					<li>
						<a href="<?= base_url('home/account')?>" title="Account">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="20" alt="Account" title="Account">
							Account
						</a>
					</li>
					<li>
						<a href="<?= base_url('home/change_account')?>" title="Update account">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/edit_icon_w.png" width="20" alt="Update account" title="Update account">
							Update account
						</a>
					</li>
					<li>
						<a href="<?= base_url('home/change_image')?>" title="Update image">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/photo1_w.png" width="20" alt="Update image" title="Update image">
							Update image
						</a>
					</li>
					<li>
						<a href="<?= base_url('home/change_password')?>" title="Update password">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/lock.png" width="20" alt="Update password" title="Update password">
							Update password
						</a>
					</li>
					<li class="mobile_off">
						<a href="<?= base_url('import_order/suggest_medicine')?>" title="Update suggest medicine">
							<i class="fa fa-thumbs-o-up" aria-hidden="true" style="font-size:20px;"></i>
							Update suggest medicine
						</a>
					</li>
					<?php
					if(!empty($_COOKIE['user_type'])){
					if($_COOKIE['user_type']=="sales")
					{
						$user_type = $_COOKIE['user_type'];
						?>
					<div class="text-left" style="margin-left:10px;margin-top:10px; border-top: 1px solid #f3f3f3;">Server Report</div>

					<li>
						<a href="http://49.205.182.192:7272/drd_local_server/pendingorder_report" title="Pending Order" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20" alt="All Invoice" title="Pending Order">
							Pending Order
						</a>
					</li>

					<li>
						<a href="http://192.168.0.100:7272/drd_local_server/drd_today_invoice" title="All Invoice" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20" alt="All Invoice" title="All Invoice">
							All Invoice
						</a>
					</li>
					
					<li>
						<a href="http://192.168.0.100:7272/drd_local_server/child_invoice/pickedby" title="Pickedby Invoice" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20" alt="Pickedby Invoice" title="Pickedby Invoice">
							Pickedby Invoice
						</a>
					</li>
					
					<li>
						<a href="http://192.168.0.100:7272/drd_local_server/child_invoice/pickedby" title="Deliverby Invoice" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20" alt="Deliverby Invoice" title="Deliverby Invoice">
							Deliverby Invoice
						</a>
					</li>
					
					<li>
						<a href="http://192.168.0.100:7272/drd_local_server/delivery_report" title="Delivery Report" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20" alt="Delivery Report" title="Delivery Report">
							Delivery Report
						</a>
					</li>
					<?php } }?>
					<div class="text-left" style="margin-left:10px;margin-top:10px; border-top: 1px solid #f3f3f3;">Others</div>
					<li>
						<a href="tel:+919899133989" title="Contact us">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/phone.png" width="20" alt="Contacts" title="Contact us">
							Contact us
						</a>
					</li>
					<li title="Email">
						<a href="mailto:vipul@drdindia.com" title="Email">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/email.png" width="20" alt="Email" title="Email">
							Email
						</a>
					</li>
					<li title="Privacy policy">
						<a href="<?= base_url('user/privacy_policy')?>" title="Privacy policy">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20"  alt="Privacy policy" title="Privacy policy">
							Privacy policy
						</a>
					</li>
					<li title="Share App">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black" title="Share App">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/share.png" width="20" alt="Share App" title="Share App">
							Share App
						</a>
					</li>
					<li title="Download App">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black" title="Download App">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/playstrore.png" width="20" alt="Download App" title="Download App">
							Download App
						</a>
					</li>
					<?php if(!empty($_COOKIE['user_session'])){ ?>
					<li title="Logout">
						<a href="<?= base_url('logout')?>" title="Logout">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logout.png" width="20"  alt="Logout" title="Logout">
							Logout
						</a>
					</li>
					<?php } else { ?>
					<li title="Login">
						<a href="<?= base_url('login')?>" title="Login">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="20"  alt="Login" title="Login">
							Login
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>				
	</div>
			
			
	<div class="top_menu_bar main_round_theme">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-12">
					<span style="float:left; margin-right:10px;">
						<a href="javascript:goBack()" class="menubtn2" title="Go Back">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/back_button.png" width="30px;" style="margin-top: 5px;" alt="Go Back" title="Go back">
						</a>
						<a href="javascript:new_style_menu_show()" class="menubtn1" style="color:white;" title="Drd Menu">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" width="40px;" alt="Dr. Distributor" title="Dr. Distributor">
						</a>
					</span>

					<span style="float:left; margin: auto;width:60%;">
						<div class="pro-link headertitle">
						Delivering to
						</div>
						<div class="pro-link headertitle1">
							<?= $session_user_fname ?>
						</div>
					</span>

					<span class="mobile_show">
						<a href="<?= base_url(); ?>home/my_cart" class="top_menu_small_btn top_menu_cart_div" title="Cart" style="float:right">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cart.png" width="28px;" alt="Cart" title="Cart">
							<span class="header_cart_span" style="">
								<?= $_COOKIE["user_cart_total"]; ?>
							</span>
						</a>

						<a href="#" onclick="delete_all_medicine()" class="top_menu_small_btn delete_btn_icon" title="Delete All" style="float:right">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/delete_icon_w.png" width="28px;" alt="Delete All" title="Delete All">
						</a>
					</span>
				</div>

				
				<div class="col-sm-6">

					<a href="<?= base_url(); ?>home/search_medicine" title="Search medicine / company" class="home_page_search_div">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homepgsearch.png" width="25px;" class="search_icon1" alt="Search medicine / company" title="Search medicine / company">Search medicine / company 
					</a>
					
					<div class="home_page_search_div_box">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homepgsearch.png" width="25px;" class="search_icon" alt="Search medicine / company" title="Search medicine / company">
						<input type="text" class="select_medicine search_textbox input_type_text" placeholder="Search medicine / company" tabindex="1">
						<input type="text" class="select_chemist search_textbox input_type_text" placeholder="Search chemist"  tabindex="1" />
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cancelbtn1.png" width="25px;" class="clear_search_icon" onclick="clear_search_icon()" alt="Clear" title="Clear">
					</div>
					<div class="search_medicine_result"></div>
				</div>

				<div class="col-sm-3 mobile_off text-right" style="margin-top:5px;">	
					<a href="<?= base_url() ?>home" class="top_menu_small_btn main_home_top_btn" title="Home">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homelcon.png" width="28px;" alt="Home" title="Home">
					</a>

					<a href="<?= base_url(); ?>home/my_cart" class="top_menu_small_btn top_menu_cart_div" title="Cart">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cart.png" width="28px;" alt="Cart" title="Cart">
						<span class="header_cart_span" style="">
							<?= $_COOKIE["user_cart_total"]; ?>
						</span>
					</a>

					<a href="<?= base_url() ?>home/my_notification" class="top_menu_small_btn mobile_off" title="Notification">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification_w.png" width="28px" class="cssnotification" alt="Notification" title="Notification">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification_w1.png" width="28px" style="display:none;" class="cssnotification1" alt="Notification" title="Notification">
					</a>

					<a href="<?= base_url() ?>home/account" class="top_menu_small_btn mobile_off">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="28px;" alt="Account" title="Account">
					</a>
					<?php if($_COOKIE['user_session']!=""){ ?>
					<a href="<?= base_url('logout')?>" class="top_menu_small_btn mobile_off" title="Logout">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logout.png" width="28px;" alt="Logout" title="Logout">
					</a>
					<?php } ?>
				</div>

				<div class="col-sm-12 col-12 search_pg_menu_off">
					<div class="top-menu123" id="top-menu123">
						<div class="swiper top-menu123-slider featured-slider">
							<div class="swiper-wrapper">
								<?php
								foreach($website_menu as $row)
								{
								?>
								<div class="swiper-slide box">
									<div class="mcs-items-container2">
										<div class="top-menu123_div">
											<div class="content">
												<a href="<?= base_url();?>home/medicine_category/medicine_category/<?= $row["item_code"] ?>">
													<span>
													<?= ($row["item_company"]) ?>
													</span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="swiper-button-next top-menu123-next"></div>
					<div class="swiper-button-prev top-menu123-prev"></div>
				</div>

				<div class="col-sm-12 current_order_search_page" style="width: 100%;margin-top: 45px;text-align: right;display:none;">
					<sapn class="header_result_found"></sapn>
				</div>

				<div class="col-sm-3 col-3 current_order_cart_page account_page_header" style="margin-top:10px;display:none;">
					<img src="<?= $session_user_image ?>" alt="<?= $session_user_fname ?>" title="<?= $session_user_fname ?>" class="rounded account_page_header_image" onerror=this.src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png">
				</div>
			</div>
		</div>
	</div>

<script>
function theme_set()
{
	theme_set_css = $(".theme_set_css").val()
	$.ajax({
		type       : "POST",
		data       :  { theme_set_css:theme_set_css} ,
		url        : "<?php echo base_url(); ?>Chemist_json/theme_set",
		cache	   : true,
		success : function(data){
			if(data!="")
			{
				$.each(data.items, function(i,item){	
					if (item){
						location.reload();
					}
				});	
			}
		},
	});
}

function callandroidfun(funtype,id,compname,image,division) {	
	if(funtype=="1"){
		//android.fun_Get_single_medicine_info(id);
		get_single_medicine_info(id);
	}
	if(funtype=="2")
	{
		window.location.href = '<?= base_url(); ?>home/featured_brand/'+id+'/'+division;
	}
}
function gosearchpage()
{
	window.location.href = "<?= base_url();?>home/search_medicine";
}
function check_login_function()
{
	id ='';
	$.ajax({
		type       : "POST",
		data       :  { id:id} ,
		url        : "<?php echo base_url(); ?>Chemist_json/check_login_function",
		cache	   : true,
		success : function(data){
			if(data!="")
			{
				$.each(data.items, function(i,item){	
					if (item){
						
						if(item.download_invoice_url!="")
						{
							download_invoice(item.download_invoice_url)
						}

						/*if(item.status=="0")
						{
							window.location.href = "<?= base_url();?>user/logout2";
						}*/

						/*notiid		= (item.notiid);
						broadcastid = (item.broadcastid);
						if(notiid!=""){
							notititle 	= atob(item.notititle);
							notibody 	= atob(item.notibody);
							$(".only_for_noti").append('<li class="only_for_noti_li notiid_'+notiid+'"><div class="notititle">'+notititle+'</div><div class="notibody">'+notibody+'</div></li>');						
							setTimeout('$(".notiid_"+notiid).hide()',10000);
						}
						if(broadcastid!=""){
							broadcasttitle 		= atob(item.broadcasttitle);
							broadcastmessage 	= atob(item.broadcastmessage);
							$('.broadcast_title').html(broadcasttitle);
							$('.broadcast_message').html(broadcastmessage);
							$('.myModal_broadcast').click();
						}
						if(item.count!="")
						{
							//$(".notificationdiv").html("("+item.count+")");
							if(item.count=="0")
							{
								$(".cssnotification").show();
								$(".cssnotification1").hide();
							}
							else
							{
								$(".cssnotification").hide();
								$(".cssnotification1").show();
							}
						}*/
					}
				});	
			}
		},
		timeout: 10000
	});
	setTimeout('check_login_function();',60000);
}
$(document).ready(function(){
	setTimeout('count_temp_rec();',500);

	$('.medicine_details_item_order_quantity_textbox').keypress(function (e) {
		 if (e.which == 13) {
			medicine_add_to_cart_api();
		 } 
	});
});

function get_single_medicine_info(item_code)
{
	var session_user_altercode = "<?= $session_user_altercode ?>";
	if(session_user_altercode=="xxxxxx")
	{
		window.location.href = "<?=base_url(); ?>home";
	} else 
	{
		$('.myModal_medicine_details').click();
		$(".medicine_details_api_loading").show();
		$(".medicine_details_api_data").hide();
		$(".medicine_details_item_description1").hide();
		$(".medicine_details_item_description2").hide();

		$(".medicine_details_item_order_quantity_textbox").val("");
		medicine_details_api(item_code);
	}
}

function medicine_details_api(item_code)
{
	$('.medicine_details_item_add_to_cart_btn').html("Add to cart");
	$('.medicine_details_item_add_to_cart_btn_loading').hide();

	item_date_time = item_batch_no = item_gst = item_description2 = "";

	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_json/medicine_details_api",
		type:"POST",
		/*dataType: 'html',*/
		data: {item_code:item_code},
		error: function(){
			
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					item_date_time	= item.item_date_time;
					$(".medicine_details_item_date_time").html("as on " + item_date_time)

					item_batch_no	= item.item_batch_no;
					$(".medicine_details_item_batch_no").html("Batch no : "+item_batch_no)

					item_gst	= item.item_gst;
					$(".medicine_details_item_gst").html("GST : "+item_gst +"%")

					item_image	= item.item_image;
					$(".medicine_details_image").attr("src",item_image)
					item_image	= item.item_image;
					$(".modal_item_image_change1").attr("src",item_image)
					item_image2	= item.item_image2;
					$(".modal_item_image_change2").attr("src",item_image2)
					item_image3	= item.item_image3;
					$(".modal_item_image_change3").attr("src",item_image3)
					item_image4	= item.item_image4;
					$(".modal_item_image_change4").attr("src",item_image4)					

					$(".medicine_details_item_description2").show()
					item_description2	= item.item_description2;
					$(".medicine_details_item_description2").html(item_description2)
					if(item_description2=="")
					{
						$(".medicine_details_item_description2").hide()
					}

					item_order_quantity	= item.item_order_quantity;
					$(".medicine_details_item_order_quantity_textbox").val(item_order_quantity)
					if(item_order_quantity!=""){
						$('.medicine_details_item_add_to_cart_btn').html("Update cart");
					}

					item_name		= item.item_name;
					item_packing	= item.item_packing;
					item_expiry		= item.item_expiry;
					item_company	= item.item_company;
					item_quantity	= item.item_quantity;
					item_stock		= item.item_stock;
					item_ptr		= item.item_ptr;
					item_mrp		= item.item_mrp;
					item_price		= item.item_price;
					item_scheme		= item.item_scheme;
					item_margin		= item.item_margin;
					item_featured	= item.item_featured;
					item_description1= item.item_description1;
					
					
					insert_top_search(item_code,item_name,item_packing) // firebase code
					medicine_details_api_data(item_code)	
					
					item_image	= item.item_image;
					$(".medicine_details_image").attr("src",item_image)
					item_image	= item.item_image;
					$(".modal_item_image_change1").attr("src",item_image)
					item_image2	= item.item_image2;
					$(".modal_item_image_change2").attr("src",item_image2)
					item_image3	= item.item_image3;
					$(".modal_item_image_change3").attr("src",item_image3)
					item_image4	= item.item_image4;
					$(".modal_item_image_change4").attr("src",item_image4)
				}
			});	
		},
		timeout: 10000
	});
}

function medicine_details_api_data(item_code)
{
	$(".medicine_details_api_loading").hide();
	$(".medicine_details_api_data").show();

	/***********************important ************************/
	$('.medicine_details_item_code').val(item_code);
	/********************************************************/

	$(".medicine_details_item_add_to_cart_btn").hide()
	$(".medicine_details_item_add_to_cart_btn_disable").hide()
	$('.medicine_details_item_add_to_cart_btn_loading').hide()

	$(".medicine_details_featured_img").hide()
	$(".medicine_details_out_of_stock_img").hide()	

	$(".medicine_details_image").attr("src",item_image)
	$(".medicine_details_image_small").attr("src",item_image)

	$(".medicine_details_item_name").html(item_name)
	$(".medicine_details_item_packing").html("Packing : "+item_packing)
	$(".medicine_details_item_batch_no").html("Batch no : "+item_batch_no)

	$(".medicine_details_item_margin").html(item_margin+'% Margin')
	$(".medicine_details_item_expiry").html("Expiry : "+item_expiry)
	$(".medicine_details_item_company").html("By "+item_company)
	$(".medicine_details_item_stock").html("Stock : " +item_quantity)
	$(".medicine_details_item_scheme").html("Scheme : " +item_scheme)

	$(".medicine_details_item_description1").html(item_description1)
	$(".medicine_details_item_description1").show()
	if(item_description1=="")
	{
		$(".medicine_details_item_description1").hide()
	}

	$(".medicine_details_item_ptr").html('PTR : <i class="fa fa-inr" aria-hidden="true"></i> ' +item_ptr + "/-")
	$(".medicine_details_item_mrp").html('MRP : <i class="fa fa-inr" aria-hidden="true"></i> ' +item_mrp + "/-")
	$(".medicine_details_item_gst").html("GST : "+item_gst +"%")
	$(".medicine_details_item_price").html('*Approximate Value ~ : <i class="fa fa-inr" aria-hidden="true"></i> ' +item_price + "/-")

	$(".medicine_details_item_scheme_line").show()
	$(".medicine_details_item_scheme").show()
	if(item_scheme=="0+0")
	{
		$(".medicine_details_out_of_stock_img").hide()
		$(".medicine_details_item_scheme_line").hide()
		$(".medicine_details_item_scheme").hide()
	}

	if(item_featured=="1" && item_quantity!="0"){
		$(".medicine_details_featured_img").show()
	}

	if(parseInt(item_quantity)==0){
		
		$(".medicine_details_item_add_to_cart_btn_disable").show()
		$(".medicine_details_item_stock").html("<font color=red>Out of stock</font>")

		$(".medicine_details_out_of_stock_img").show()
		$(".medicine_details_item_scheme").hide()
		$(".medicine_details_item_scheme_line").hide()
	}else{
		$(".medicine_details_item_add_to_cart_btn").show()
	}

	if(item_stock!="")
	{
		$(".medicine_details_item_stock").html(item_stock)
	}

	$(".medicine_details_item_quantity").val(item_quantity)

	$(".medicine_details_item_order_quantity_textbox").focus()
}

function modal_item_image_change(_id)
{
	modal_item_image_change_url = $(".modal_item_image_change"+_id).attr("src");
	$(".modal_item_image_change").attr("src",modal_item_image_change_url);
}

function medicine_add_to_cart_api()
{
	<?php 
	if(!empty($page_cart)) {
		if($page_cart=="1") { ?>
			setTimeout(function() {
				$(".edit_item_focues"+i_code).focus();
			}, 2000);
		<?php 
		} 
	}?>	

	item_quantity		= $(".medicine_details_item_quantity").val();
	item_order_quantity	= $(".medicine_details_item_order_quantity_textbox").val();
	item_code			= $(".medicine_details_item_code").val();
	
	if(item_order_quantity=="")
	{
		swal("Enter quantity");
		$(".medicine_details_item_order_quantity_textbox").val("");
		$(".medicine_details_item_order_quantity_textbox").focus();
	}
	else
	{
		item_order_quantity = parseInt(item_order_quantity);
		item_quantity		= parseInt(item_quantity);
		if(item_order_quantity!=0)
		{
			if(item_order_quantity<=item_quantity)
			{
				$(".medicine_details_item_add_to_cart_btn").hide()
				$(".medicine_details_item_add_to_cart_btn_disable").hide()

				$('.medicine_details_item_add_to_cart_btn_loading').show()
				
				$.ajax({
					type       : "POST",
					data       : {item_code:item_code,	 item_order_quantity:item_order_quantity},
					url        : "<?php echo base_url(); ?>Chemist_json/medicine_add_to_cart_api",
					cache	   : true,
					error: function(){
						swal("error add to cart")
					},
					success    : function(data){
						$.each(data.items, function(i,item){	
							if (item)
							{
								if(item.status=="1")
								{
									$(".modaloff").click();
									$(".SearchMedicine_search_box").focus();
									page_load();

									$('.medicine_details_item_add_to_cart_btn_loading').hide()

									$('.search_textbox').val("");
									$(".search_medicine_result").html("");
								}
							}
						});
					},
					timeout: 10000
				});
			}
			else
			{
				swal("Enter a valid quantity");
			}
		}
		else{
			swal("Enter quantity one or more than one");
		}
	}
}

</script>
<div class="select_medicine_in_modal_script_css"></div>
<div class="only_for_noti"></div>

<input type="hidden" class="medicine_details_item_code">
<div type="hidden" class="medicine_details_all_data"></div>
<a href="#" data-toggle="modal" data-target="#myModal_medicine_details" style="text-decoration: none;" class="myModal_medicine_details"></a>
<div class="modal modaloff" id="myModal_medicine_details">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Medicine details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
			<div class="medicine_details_item_date_time" style="">Loading....</div>
			<div class="medicine_details_api_loading text-center" style="display:none">
				<h1>
					<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="">
				</h1>
				<h1>Loading....</h1>
			</div>
			<div class="row medicine_details_api_data" style="display:none">
				<div class="col-sm-5 col-12">

					<img src="<?= base_url(); ?>/uploads/default_img.jpg" width="100%" style="float: right;margin-top:10px;" class="medicine_details_image modal_item_image_change" alt="" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>
					
					<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/featured_img.png" width="100" style="position: absolute;margin-top:10px;display:none;" alt="" class="medicine_details_featured_img" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>

					<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/out_of_stock_img.png" width="100" style="position: absolute;margin-top:10px;display:none;" alt="" class="medicine_details_out_of_stock_img" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>
					
					<img src="<?= base_url(); ?>/uploads/default_img.jpg" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="medicine_details_image_small modal_item_image_change1" onclick="modal_item_image_change(1)" alt="" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>

					<img src="<?= base_url(); ?>/uploads/default_img.jpg" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="medicine_details_image_small modal_item_image_change2" onclick="modal_item_image_change(2)" alt="" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>

					<img src="<?= base_url(); ?>/uploads/default_img.jpg" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="medicine_details_image_small modal_item_image_change3" onclick="modal_item_image_change(3)" alt="" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>

					<img src="<?= base_url(); ?>/uploads/default_img.jpg" width="20%" style="float: left;margin-top:10px;cursor: pointer;" class="medicine_details_image_small modal_item_image_change4" onclick="modal_item_image_change(4)" alt="" onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'>
				</div>
				<div class="col-sm-7 col-12">
					<div class="row">
						<div class="col-sm-12 col-12" style="margin-top: 5px;">
							<span class="medicine_details_item_name"></span>
						</div>
						<div class="col-sm-6 col-6 text-left">
							<span class="medicine_details_item_packing text-left"></span>
						</div>
						<div class="col-sm-6 col-6 text-right">
							<span class="medicine_details_item_batch_no"></span>
						</div>
						<div class="col-sm-6 col-6 text-left">
							<span class="medicine_details_item_margin"></span>
						</div>
						<div class="col-sm-6 col-6 text-right">
							<span class="medicine_details_item_expiry"></span>
						</div>
						<div class="col-sm-12 col-12">
							<span class="medicine_details_item_company"></span>
						</div>
						<div class="col-sm-6 col-6 text-left">
							<span class="medicine_details_item_stock"></span>
						</div>

						<div class="col-sm-6 col-6 text-right">
							<span class="medicine_details_item_scheme"></span>
						</div>
						
						<div class="col-sm-12 col-12 medicine_details_hr medicine_details_item_scheme_line text-center">
							Scheme is not added in Landing price
						</div>

						<div class="col-sm-12 col-12 medicine_details_hr medicine_details_item_description1">
						</div>

						<div class="col-sm-12 col-12 medicine_details_hr">
						</div>

						<div class="col-sm-6 col-6 text-left">
							<span class="medicine_details_item_ptr">
							</span>
						</div>
						<div class="col-sm-6 col-6 text-right">	
							<span class="medicine_details_item_mrp"></span>
						</div>
						<div class="col-sm-4 col-5 text-left">	
							<span class="medicine_details_item_gst"></span>
						</div>
						<div class="col-sm-8 col-7 text-right">
							<span class="medicine_details_item_price" title="*Approximate value ~"></span>
						</div>
						<div class="col-sm-12 col-12 text-left">
						*Approximate billing value per unit, subject change . As per final invoice.
						</div>

						<div class="col-sm-12 col-12 medicine_details_hr">
						</div>

						<div class="col-sm-12 col-12">
							<span class="medicine_details_item_order_quantity" style="width:50%;float:left;margin-top:5px;">Order quantity
							</span>
							
							<span class="text-right" style="width:50%;float:left;margin-top:5px;">

								<input type="number" class="medicine_details_item_order_quantity_textbox" placeholder="Eg 1,2" name="quantity" required="" style="width:100px;float:right;" value="" title="Enter quantity" min="1" max="1000">

								<input type="hidden" class="medicine_details_item_quantity">
							</span>
						</div>

						<div class="col-sm-12 col-12 medicine_details_hr">
						</div>

						<div class="col-sm-12 col-12">
							<button type="submit" class="btn btn-primary mainbutton medicine_details_item_add_to_cart_btn"  onclick="medicine_add_to_cart_api()" title="Add to cart">Add to cart</button>

							<button type="submit" class="btn btn-primary mainbutton_disable medicine_details_item_add_to_cart_btn_disable" onclick="" title="Add to cart">Add to cart</button>

							<div class="medicine_details_item_add_to_cart_btn_loading text-center" style="display:none">
								<button type="submit" class="btn btn-primary mainbutton_disable" onclick="" title="Loading....">Loading....</button>
							</div>
						</div>

						<div class="col-sm-12 col-12 medicine_details_hr">
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-12 medicine_details_hr medicine_details_item_description2">
			</div>

			<div class="col-sm-12 col-12 medicine_details_hr">
			</div>
			</div>
		</div>
	</div>
</div>

<a href="#" data-toggle="modal" data-target="#myModal_loading" style="text-decoration: none;" class="myModal_loading"></a>
<div class="modal modaloff" id="myModal_loading">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title MedicineDetailscssmod">Medicine details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="MedicineDetailsData"></div>				
				<div class="MedicineSmilerProduct"></div>
			</div>
		</div>
	</div>
</div>
<?php /***************************broadcast**************************************/ ?>
<a href="#" data-toggle="modal" data-target="#myModal_broadcast" style="text-decoration: none;" class="myModal_broadcast"></a>
<div class="modal modaloff" id="myModal_broadcast">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title broadcast_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body broadcast_message">
				
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url(); ?>assets/website/js/scripts.js"></script>
<script>
function new_style_menu_show()
{
	$(".left_menu_bar").show(500);
}
function new_style_menu_hide()
{
	$(".left_menu_bar").hide(500);
}
</script>

<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-database.js"></script>
<script>
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
/*var  firebaseConfig = {
apiKey: "AIzaSyBovCE4GE71WoWlK5KcWXZl7WZjGVUiQiM",
authDomain: "drd-web-firebase-db.firebaseapp.com",
databaseURL: "https://drd-web-firebase-db-default-rtdb.firebaseio.com",
projectId: "drd-web-firebase-db",
storageBucket: "drd-web-firebase-db.appspot.com",
messagingSenderId: "810227054981",
appId: "1:810227054981:web:b4a453038af2a21c71acec",
measurementId: "G-MN55NJJGBX"
};*/

var  firebaseConfig = {
apiKey: "AIzaSyBPkM-zLmMQbHGE_Ye1qOsBl6IhROvu6RU",
authDomain: "drd-noti-fire-base.appspot.com",
databaseURL: "https://drd-noti-fire-base.firebaseio.com",
projectId: "drd-noti-fire-base",
storageBucket: "drd-web-firebase-db.appspot.com",
messagingSenderId: "504935735685",
appId: "1:504935735685:android:a2d0ae89504ba935f5e4ec"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// Set database variable
var database = firebase.database()
function insert_users_live()
{
	var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
	var m 	= new Date(todayDateTime)
	year 	= m.getFullYear()
	month 	= change_dt_format(m.getMonth()+1);
	day 	= change_dt_format(m.getDate());
	hours 	= change_dt_format(m.getHours());
	minutes = change_dt_format(m.getMinutes());
	var dateString = year +"-"+ (month) +"-"+ day;
	var timeString = hours + ":" + minutes;

	database.ref('chemist_online/<?php echo $this->session->userdata('user_altercode'); ?>').set({
		user_altercode : '<?php echo $this->session->userdata('user_altercode'); ?>',
		user_date : dateString,
		user_time : timeString,
		value : "web"
	})

	/*var chemist_onlineRef = firebase.database().ref("chemist_online/");
	chemist_onlineRef.ref ({
		'<?php echo $this->session->userdata('user_altercode'); ?>' : {
			user_time : '<?php echo date("H:i"); ?>',
			user_date : '<?php echo date("d-m-Y"); ?>'
		}
	});*/

	/*let today = new Date();
	let m = today.toLocaleString("en-US", "Asia/Delhi");
	//var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + m.getUTCHours() + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

	var dateString = m.getUTCFullYear() +"-"+ (m.getUTCMonth()+1) +"-"+ m.getUTCDate();
	var timeString = m.getUTCHours() + ":" + m.getUTCMinutes();

	database.ref('chemist_online/<?php echo $this->session->userdata('user_altercode'); ?>').set({
		user_altercode : '<?php echo $this->session->userdata('user_altercode'); ?>',
		user_time : timeString,
		user_date : dateString
	})*/
	setTimeout(function() { insert_users_live() }, 30000);
}
<?php if($this->session->userdata('user_type')!="") { ?>
insert_users_live();
insert_open_page();
<?php } ?>
function change_dt_format(dt)
{
	if(dt==1)
	{
		dt = "01"
	}
	if(dt==2)
	{
		dt = "02"
	}
	if(dt==3)
	{
		dt = "03"
	}
	if(dt==4)
	{
		dt = "04"
	}
	if(dt==5)
	{
		dt = "05"
	}
	if(dt==6)
	{
		dt = "06"
	}
	if(dt==7)
	{
		dt = "07"
	}
	if(dt==8)
	{
		dt = "08"
	}
	if(dt==9)
	{
		dt = "09"
	}
	return dt;
}
function insert_open_page()
{
	var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
	var m 	= new Date(todayDateTime)
	year 	= m.getFullYear()
	month 	= change_dt_format(m.getMonth()+1);
	day 	= change_dt_format(m.getDate());
	hours 	= change_dt_format(m.getHours());
	minutes = change_dt_format(m.getMinutes());
	var dateString = year +"-"+ (month) +"-"+ day;
	var timeString = hours + ":" + minutes;

	database.ref('chemist_open_page/'+dateString+'/<?php echo $this->session->userdata('user_altercode'); ?>').push({
		user_altercode : '<?php echo $this->session->userdata('user_altercode'); ?>',
		page_url : '<?php echo $_SERVER['HTTP_REFERER']; ?>',
		user_date : dateString,
		user_time : timeString,
		value : "web"
	})
}

function insert_top_search(item_code,item_name,item_packing)
{
	var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
	var m 	= new Date(todayDateTime)
	year 	= m.getFullYear()
	month 	= change_dt_format(m.getMonth()+1);
	day 	= change_dt_format(m.getDate());
	hours 	= change_dt_format(m.getHours());
	minutes = change_dt_format(m.getMinutes());
	var dateString = year +"-"+ (month) +"-"+ day;
	var timeString = hours + ":" + minutes;

	database.ref('chemist_top_search/'+dateString+'/<?php echo $this->session->userdata('user_altercode'); ?>').push({
		user_altercode : '<?php echo $this->session->userdata('user_altercode'); ?>',
		item_code : item_code,
		item_name : item_name,
		item_packing : item_packing,
		user_date : dateString,
		user_time : timeString,
		value : "web"
	})
}

</script>