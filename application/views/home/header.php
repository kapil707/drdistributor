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
	<meta name="theme-color" content="#f7625b">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/font-awesome.min.css"> 
	<link href="<?= base_url(); ?>assets/website/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>
	<script>
		/*function goBack() {
			window.history.back();
		}*/
	</script>
	<link href="<?= base_url(); ?>assets/website/css/scrolling/css/amazon_scroller.css" rel="stylesheet" type="text/css"></link>
	<script type="text/javascript" src="<?= base_url(); ?>assets/website/css/scrolling/js/amazon_scroller.js"></script>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+HK&display=swap" rel="stylesheet">

	<link rel="icon" href="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" type="image/logo" sizes="16x16">
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<link href="<?= base_url(); ?>assets/website/magicscroll/magicscroll.css" rel="stylesheet" type="text/css"></link>
	<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>

<style>
body{
	background-image: url("<?php echo base_url(); ?>img_v<?= constant('site_v') ?>/background.jpg");
}
</style>
</head>
<body>
<?php
if(empty($chemist_id_for_cart_total))
{
	$chemist_id_for_cart_total = "";
}

$someArray = $this->Chemist_Model->website_menu();
$par = '['.$someArray.']';
$someArray = json_decode($par, true);
?>
	<img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" style="display:none" alt="Dr. Distributor" title="Dr. Distributor">
	<div class="new_style_menu">
		<div class="header_title_logo_or_name">
			<div class="row">
				<div class="col-sm-3 col-3">
					<img src="<?= $session_user_image ?>" alt="<?= $session_user_fname ?>" title="<?= $session_user_fname ?>" class="rounded account_page_header_image">
				</div>
				<div class="col-sm-7 col-7">
					<p style="word-wrap: break-word;font-size: 13px;">
						<span class="account_page_chemist_name">
							<?= $session_user_fname ?>
						</span>
						<span class="account_page_chemist_code">
							<br> Code : <?= $session_user_altercode ?>
						</span>
					</p>
				</div>
				<div class="col-sm-2 col-2 text-left">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cancelbtn.png" width="40" onclick="new_style_menu_hide()" title="Cancel menu" alt="Cancel menu">
				</div>
			</div>
		</div>
		<div class="profile-menu text-center">
			<div class="social-icon">
				<div class="text-left" style="margin-left:10px;">Account</div>
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
					if(!empty($_SESSION['user_type'])){
					if($_SESSION['user_type']=="sales")
					{
						$user_type = $_SESSION['user_type'];
						?>
					<div class="text-left" style="margin-left:10px;margin-top:10px; border-top: 1px solid #f3f3f3;">Server Report</div>

					<li>
						<a href="http://192.168.0.100:7272/drd_local_server/pendingorder_report" title="Pending Order" target="_black">
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
					<li title="Share app">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black" title="Share app">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/share.png" width="20" alt="Share app" title="Share app">
							Share app
						</a>
					</li>
					<li title="Logout">
						<a href="<?= base_url('logout')?>" title="Logout">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logout.png" width="20"  alt="Logout" title="Logout">
							Logout
						</a>
					</li>
				</ul>
			</div>
		</div>				
	</div>
			
			
	<div class="menu-notify new_orange_header">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-7">
					<span style="float:left; margin-right:10px;">
						<a href="javascript:goBack()" class="menubtn2" title="Go Back">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/back_button.png" width="30px;" style="margin-top: 5px;" alt="Go Back" title="Go back">
						</a>
						<a href="javascript:new_style_menu_show()" class="menubtn1" style="color:white;" title="Drd Menu">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" width="40px;" style="margin-top: 5px;" alt="Dr. Distributor" title="Dr. Distributor">
						</a>
					</span>
					<span style="float:left; margin: auto;">
						<div class="pro-link headertitle1" style="color:white;font-size: 13px; margin-top: 3px;display:none;">
						Delivering to
						</div>
						<div class="pro-link headertitle">
							<?= $session_user_fname ?>
						</div>
					</span>
				</div>
				<?php
				$pg_dt_row = "col-sm-12 col-12";
				if(!empty($_SESSION['user_type'])){
					if($_SESSION['user_type']=="sales")
					{
						$msg_show = "Search chemist / medicines";
						$pg_dt_row = "col-sm-9 col-9";
					}
					else{
						$msg_show = "Search medicines / company";
					}
				}else{
					$msg_show = "Search medicines / company";
				}
				?>
				<div class="col-sm-9 col-5">
					<a href="<?= base_url(); ?>home/search_medicine" title="<?= $msg_show?>">
						<div class="homepagesearchdiv">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homepgsearch.png" width="25px;" class="searchiconcss" alt="<?= $msg_show?>" title="<?= $msg_show?>">
							<?= $msg_show?>
						</div>
					</a>
					
					<div class="SearchMedicine_search_box_div">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homepgsearch.png" width="25px;" class="searchiconcss1" alt="<?= $msg_show?>" title="<?= $msg_show?>">
						
						<input type="text" class="select_medicine SearchMedicine_search_box form-control" placeholder="<?= $msg_show?>" tabindex="1">
						
						<input type="text" class="select_chemist form-control SearchMedicine_search_box" placeholder="Search chemist"  tabindex="1" />
						
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cancelbtn1.png" width="25px;" class="clear_search_box" onclick="clear_search_box()" alt="Clear" title="Clear">
					</div>
					
					<a href="<?= base_url('logout')?>" class="logout_div mobile_off" style="float:right" title="Logout">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logout.png" width="28px;" alt="Logout" title="Logout">
					</a>

					<a href="<?= base_url() ?>home/account" class="offers_div mobile_off" style="float:right">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="28px;" alt="Account" title="Account">
					</a>
					
					<a href="<?= base_url() ?>home/my_notification" class="notification_div mobile_off" style="float:right" title="Notification">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification_w.png" width="28px" class="cssnotification" alt="Notification" title="Notification">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification_w1.png" width="28px" style="display:none;" class="cssnotification1" alt="Notification" title="Notification">
					</a>
					
					<a href="<?= base_url(); ?>home/draft_order_list" class="cart_div" style="float:right" title="Cart">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/cart.png" width="30px;" alt="Cart" title="Cart">
						<span class="header_cart_span" style="">0</span>
					</a>
					
					<a href="<?= base_url() ?>home" class="homebtn_div" style="float:right" title="Home">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/homelcon.png" width="28px;" alt="Home" title="Home">
					</a>
					
					
					<a href="#" onclick="delete_all_medicine()" style="float:right;display:none" class="deletebtn_div" title="Delete All">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/delete_icon_w.png" width="28px;" alt="Delete All" title="Delete All">
					</a>
					
					<a href="<?= base_url() ?>home/search_medicine" class="searchbtn_div" style="float:right;display:none" title="Search">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/search_white.png" width="28px;" alt="Search" title="Search">
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-12">
					<div class="website_menuscrolling1 website_menu">
						<div class="MagicScroll">
							<?php
							foreach($someArray as $row)
							{
							?>
							<div style="width:160px;margin-top: 20px;">
								<a href="<?= base_url();?>home/medicine_category/<?= $row["code"] ?>/<?= $row["name"] ?>" class="fixed_menu_ul_li_a">
									<span class="text_cut_or_dot text-capitalize" style="width:140px;">
										<?= base64_decode($row["name"]) ?>
									</span>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>
					<link href="<?= base_url(); ?>assets/website/magicscroll/magicscroll.css" rel="stylesheet" type="text/css"></link>
					<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
					</div>
					<div class="current_order_search_page" style="width: 100%;margin-top: 66px;text-align: right;display:none;">
						<div class="search_pg_current_order">Current Order <span class="mycartwalidiv1"></span><span class="header_part_search_page_chemist_name" style="display:none"></span></div>
						<div class="search_pg_result_found" style="display:none">Loading....</div>
					</div>
				</div>

				<div class="<?= $pg_dt_row ?> current_order_cart_page text-right" style="margin-top:10px;display:none;">
					<h6 class="">Order : <span class="mycartwalidiv2">0</span> Items</h6>
					<div class="">Order Price : <span class="mycartwalidiv_price">0</span></div>
					<div class="account_page_chemist_code">Code : <?= $session_user_altercode ?></div>
				</div>

				<div class="col-sm-9 col-9 account_page_header text-right" style="margin-top:10px;display:none;">
					<div class="account_page_chemist_name"><?= $session_user_fname ?></div>
					<div class="account_page_chemist_code">Code : <?= $session_user_altercode ?></div>
				</div>
				<div class="col-sm-3 col-3 current_order_cart_page account_page_header" style="margin-top:10px;display:none;">
					<img src="<?= $session_user_image ?>" alt="<?= $session_user_fname ?>" title="<?= $session_user_fname ?>" class="rounded account_page_header_image">
				</div>
			</div>
		</div>
	</div>
<input type="hidden" class="_cart_item_name">
<input type="hidden" class="_cart_final_price">
<input type="hidden" class="_cart_scheme">
<input type="hidden" class="_cart_image">
<script>
function callandroidfun(funtype,id,compname,image,division) {	
	if(funtype=="1"){
		//android.fun_Get_single_medicine_info(id);
		get_single_medicine_info(id);
	}
	if(funtype=="2")
	{
		window.location.href = '<?= base_url(); ?>home/featured_brand/'+id+'/'+division+'/'+compname;
	}
}
function gosearchpage()
{
	window.location.href = "<?= base_url();?>home/search_medicine";
}
function count_temp_rec()
{
	chemist_id = "<?= $chemist_id_for_cart_total?>";
	$.ajax({
		type       : "POST",
		data       : {chemist_id:chemist_id} ,
		url        : "<?php echo base_url(); ?>Chemist_order/count_temp_rec",
		cache	   : true,
		success    : function(data){
			$(".mycartwalidiv1").html("("+data+")");
			$(".mycartwalidiv2").html(data);
			dt = parseInt(data);
			if(dt>=99)
			{
				data = "99+";
			}
			$(".header_cart_span").html(data);
		},
		timeout: 10000
	});
	setTimeout('count_temp_rec();',120000);
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
						/*if(item.status=="0")
						{
							window.location.href = "<?= base_url();?>user/logout2";
						}*/

						notiid		= (item.notiid);
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
						}
					}
				});	
			}
		},
		timeout: 10000
	});
	setTimeout('check_login_function();',60000);
}
$(document).ready(function(){
	//setTimeout('check_login_function();',2000);
	setTimeout('count_temp_rec();',500);
});

function get_single_medicine_info(i_code)
{
	var session_user_altercode = "<?= $session_user_altercode ?>";
	if(session_user_altercode=="xxxxxx")
	{
		window.location.href = "<?=base_url(); ?>home";
	} else {
		$('.MedicineDetailsData').html('<h1><center><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>')
		$(".MedicineSmilerProduct").html('');
		$('.myModal_loading').click();
		chemist_id = "<?=$chemist_id?>";
		$('.SearchMedicine_search_box').val("");
		$(".search_medicine_result").html("");
		$.ajax({
			url: "<?php echo base_url(); ?>Chemist_medicine/get_single_medicine_info",
			type:"POST",
			/*dataType: 'html',*/
			data: {i_code:i_code,chemist_id:chemist_id},
			error: function(){
				
			},
			success: function(data){
				$.each(data.items, function(i,item){	
					if (item)
					{
						i_code 				= item.i_code;
						item_code 			= item.item_code;
						item_name 			= item.item_name;
						company_full_name 	= item.company_full_name;
						image1 				= item.image1;
						image2 				= item.image2;
						image3 				= item.image3;
						image4 				= item.image4;
						description1 		= item.description1;
						description2 		= item.description2;
						batchqty 			= item.batchqty;
						sale_rate 			= item.sale_rate;
						mrp 				= item.mrp;
						final_price 		= item.final_price;
						batch_no 			= item.batch_no;
						packing 			= item.packing;
						expiry 				= item.expiry;
						scheme 				= item.scheme;
						margin 				= item.margin;
						featured 			= item.featured;
						gstper 				= item.gstper;
						discount 			= item.discount;
						itemjoinid 			= item.itemjoinid;
						items1				= item.items1;
						date_time			= item.date_time;
						misc_settings		= item.misc_settings;
						
						item_name			= btoa(item_name);
						company_full_name 	= btoa(company_full_name);
						image_m1 	 		= btoa(image1);
						image_m2 	 		= btoa(image2);
						image_m3 	 		= btoa(image3);
						image_m4 	 		= btoa(image4);
						description1_m 	 	= btoa(description1);
						description2_m 	 	= btoa(description2);
						packing 			= btoa(packing);
						expiry  			= btoa(expiry);
						batch_no			= btoa(batch_no);
						scheme  			= btoa(scheme);
						date_time  			= btoa(date_time);
						
						items1				= JSON.stringify(items1);
						items1 	 			= btoa(items1);
						
						your_order_qty = "";
						
						$(".MedicineDetailscssmod").html("Medicine details");
						$('.SearchMedicine_search_box').val("");
						$(".search_medicine_result").html("");
						$(".MedicineSmilerProduct").html("");
						$(".MedicineDetailsData").html("");
						
						MedicineDetails = MedicineDetails_modal(i_code,item_name,company_full_name,image_m1,image_m2,image_m3,image_m4,description1_m,description2_m,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,date_time,your_order_qty,misc_settings);
						$('.MedicineDetailsData').html(MedicineDetails);
						
						setTimeout('model_quantity_focus('+i_code+');',100);
		
						if(itemjoinid!="")
						{
							MedicineSmilerProduct_data = MedicineSmilerProduct_fun(items1,'1');
							$(".MedicineSmilerProduct").html(MedicineSmilerProduct_data);
						}
					}
				});	
			},
			timeout: 10000
		});
	}
}

function model_quantity_focus(i_code)
{
	$('.new_quantity'+i_code).focus();
	$('.new_quantity'+i_code).keypress(function (e) {
		 if (e.which == 13) {
			 add_medicine_to_cart(i_code);
		 } 
	});
	
	chemist_id = "<?=$chemist_id?>";
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/get_order_quantity_of_medicine",
		type:"POST",
		/*dataType: 'html',*/
		data: {i_code:i_code,chemist_id:chemist_id},
		error: function(){
			
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					$('.new_quantity'+i_code).val(item.quantity);
					if(item.quantity!="")
					{
						$('.add_to_cart_btn'+i_code).html("Update cart");
					}
				} 
			});
		},
		timeout: 10000
 
	});
}

function MedicineDetails_modal(i_code,item_name,company_full_name,image1,image2,image3,image4,description1,description2,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,date_time,your_order_qty,misc_settings)
{	
	sale_rate 	= parseFloat(sale_rate).toFixed(2);
	mrp 		= parseFloat(mrp).toFixed(2);
	final_price = parseFloat(final_price).toFixed(2);
	$('._cart_item_name').val(item_name);
	$('._cart_final_price').val(final_price);
	$('._cart_scheme').val(scheme);
	$('._cart_image').val(atob(image1));
	
	item_name			= atob(item_name);
	company_full_name 	= atob(company_full_name);
	image1	 			= atob(image1);
	image2	 			= atob(image2);
	image3	 			= atob(image3);
	image4	 			= atob(image4);
	packing 			= atob(packing);
	expiry  			= atob(expiry);
	batch_no  			= atob(batch_no);
	scheme  			= atob(scheme);
	date_time  			= atob(date_time);
	description1  		= atob(description1);
	description2  		= atob(description2);
	
	//itemjoinid = btoa(itemjoinid)
	if(scheme=="0+0")
	{
		scheme =  'No scheme';
		scheme_line = '';
	}
	else
	{
		scheme =  'Scheme : '+scheme;
		scheme_line = '<span class="schemenew1">Scheme is not added in Landing price</span>';
	}
	
	scheme_or_margin =  '<div class="row"><div class="col-sm-6 col-6"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/scheme.png" class="modal_scheme_icon"><span class="modal_scheme">'+scheme+'</span></div><div class="col-sm-6 col-6 text-right"><span class="modal_margin">'+margin+'% Margin</span><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon.png" class="modal_margin_icon"></div><div class="col-sm-12 col-12 text-center">'+scheme_line+'</div></div>';
	
	image_more = '<img src="'+image1+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img1" onclick="open_img(1)" title="'+item_name+'"><img src="'+image2+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img2" onclick="open_img(2)" title="'+item_name+'"><img src="'+image3+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img3" onclick="open_img(3)" title="'+item_name+'"><img src="'+image4+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;" class="border rounded open_img4" onclick="open_img(4)" title="'+item_name+'">';
	
	image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'">';
	if(featured==1){
		image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="modal_featurediconcss">';
	}
	disabled = "";
	if(parseInt(batchqty)==0)
	{
		image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="modal_outofstockiconcss">';
		batchqty1 = '<div class="modal_out_of_stock" style="margin-top: 0px;">Out of stock</div>';
		addtocartbtn ='<button type="submit" class="btn btn-primary btn-block site_main_btn_out_of_stock" onclick="" title="Add to cart">Add to cart</button>';
		disabled = "disabled";
		
		add_low_stock_alert(i_code);
	}
	else
	{
		batchqty1 = '<div class="text_cut_or_dot modal_stock" style="margin-top: 0px;">Stock : '+batchqty+'</div>';
		
		if(misc_settings=="#NRX")
		{
			if(parseInt(batchqty)>10)
			{
				batchqty1 = '<div class="text_cut_or_dot modal_stock" style="margin-top: 0px;">Available</div>';
			}
		}
		
		addtocartbtn ='<button type="submit" class="btn btn-primary btn-block site_main_btn31 add_to_cart_btn'+i_code+'" onclick="add_medicine_to_cart('+i_code+')" title="Add to cart" style="margin-top:10px;">Add to cart</button>';
	}
	
	description1_ = "";
	if(description1)
	{
		description1_ = '<div class="text-left modal_description1" style="margin-top: 0px;">'+description1+'</div>';
	}
	
	description2_ = "";
	if(description2)
	{
		description2_ = '<div class="text-left modal_description2 col-sm-12 col-12" style="    max-height: 90px;overflow-x: auto;">'+description2+'</div>';
	}
	
	var MedicineDetails = '<div class="modal_date_time" style="margin-top: -35px;">As on '+date_time+'</div><div class="row"><div class="col-sm-5 col-12">'+image_+''+image_more+'</div><div class="col-sm-7 col-12"><div class="text-left" style="margin-top: 5px;"><span class="modal_title">'+item_name+'</span> <span class="modal_packing">('+packing+' Packing)</span></div><div><span class="modal_expiry">Expiry : '+expiry+'</span></div>'+description1_+'<div class="text-left modal_company" style="margin-top: 0px;">By '+company_full_name+'</div><div class="text-left modal_batch_no">Batch no : '+batch_no+'</div>'+batchqty1+'<hr>'+scheme_or_margin+'<hr><span class="text_cut_or_dot text-left model_ptr" style="width:50%;float:left;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/-</span><span class="text-right model_mrp" style="width:50%;float:left;">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/-</span><span class="text_cut_or_dot text-left model_gst" style="width:50%;float:left;">GST : '+gstper+'%</span><span class="model_landing_price text-right" style="width:50%;float:left;">~ <span class="mobile_off">Landing</span> price : <i class="fa fa-inr" aria-hidden="true"></i> '+final_price+'/-</span><div class="row"><div class="col-sm-5 col-5 mar_top10px search_page_order_quantity" style="margin-top:5px;">Order quantity</div><div class="col-sm-7 col-7 text-right mar_top10px"><input type="number" class="new_quantity new_quantity'+i_code+'" placeholder="Eg 1,2" name="quantity" required style="width:100px;float:right;" value="'+your_order_qty+'" title="Enter quantity" min="1" max="1000"><input type="hidden" class="max_quantity'+i_code+'" value="'+batchqty+'"><input type="hidden" value="'+i_code+'" name="i_code" class="new_item_id'+i_code+'"></div><div class="col-sm-12 col-12 text_cut_or_dot text-left add_medicine_to_cart" style="width:100%;float:left">'+addtocartbtn+'</div></div></div><div class="col-sm-12"><hr></div>'+description2_+'</div>';
	return MedicineDetails;
}

function add_low_stock_alert(i_code)
{
	$.ajax({
		type       : "POST",
		data       : {i_code:i_code},
		url        : "<?php echo base_url(); ?>Chemist_order/add_low_stock_alert",
		cache	   : true,
		success    : function(data){
		},
		timeout: 10000
		
	});
}

function open_img(_id)
{
	openimg = $(".open_img"+_id).attr("src");
	$(".open_img").attr("src",openimg);
}

function MedicineSmilerProduct_fun(items1,titleshow)
{
	items1 = atob(items1);	
	items1 = JSON.parse(items1);
	MedicineSmilerProduct_data = '<h6 class="Similar_Products_title" style="margin-top:10px;">Similar Products</h6><div class="searchpagescrolling4 Similar_Products_div"><div class="row"><div class="col-sm-12">';
	$.each(items1, function(i,item){
		if (item)
		{
			//MedicineSmilerProduct_data+= items1[0].i_code;
			
			MedicineSmilerProduct_data+='<div class="Similar_Products_div--box" onClick="SmilerProduct_modal_open('+items1[0].i_code+')" style="text-decoration: none;">';
			
			MedicineSmilerProduct_data+='<img src="'+items1[0].image1+'" class="img-fluid img-responsive" style="border-radius: 5px;">';
			
			if(items1[0].featured==1 && items1[0].batchqty!=0)
			{
				MedicineSmilerProduct_data+='<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="category_page_featurediconcss">';
			}
			
			if(items1[0].batchqty==0)
			{
				MedicineSmilerProduct_data+='<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="category_page_outofstockiconcss">';
			}
									
			MedicineSmilerProduct_data+='<div class="text-left text-capitalize home_page_title" style="margin-top:1px;">'+items1[0].item_name+' <span class="cart_packing">('+items1[0].packing+' Packing)</span></div><div class="category_page_margin_icon text-left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt> </div><div class="category_page_margin">'+items1[0].margin+'% Margin</div><div class="text_cut_or_dot text-capitalize category_page_company">'+items1[0].company_name+'</div><div class="category_page_mrp" style="width:100%;float:left;">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].mrp+'/-</div><div class="category_page_ptr" style="width:100%;float:left;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].sale_rate+'/-</div><div class="category_page_final_price" style="width:100%;float:left;">~Price : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].final_price+'/-</div>';
			MedicineSmilerProduct_data+='</div>';
		}
	});
	MedicineSmilerProduct_data+= '</div></div></div>';
	return MedicineSmilerProduct_data;
}

function SmilerProduct_modal_open(i_code)
{
	$('.myModal_loading').click();
	setTimeout('get_single_medicine_info("'+i_code+'");',200);
}

function add_medicine_to_cart(i_code)
{	
	<?php 
	if(!empty($page_cart)) {
	if($page_cart=="1") { ?>
	setTimeout(function() {
        $(".edit_item_focues"+i_code).focus();
    }, 2000);
	<?php } }?>	

	chemist_id 		= "<?=$chemist_id?>";
	quantity		= $(".new_quantity"+i_code).val();
	max_quantity	= $(".max_quantity"+i_code).val();
	i_code			= $(".new_item_id"+i_code).val();
	
	item_name 	= $('._cart_item_name').val();
	final_price = $('._cart_final_price').val();
	scheme 		= $('._cart_scheme').val();
	image 		= $('._cart_image').val();
	
	if(quantity=="")
	{
		swal("Enter quantity");
		$(".new_quantity"+i_code).val("");
		$(".new_quantity"+i_code).focus();
	}
	else
	{
		quantity 		= parseInt(quantity);
		max_quantity	= parseInt(max_quantity);
		if(quantity!=0)
		{
			if(quantity<=max_quantity)
			{
				var import_order_page = "";
				
				<?php if(!empty($import_order_page)){ ?>
				import_order_page = "<?php echo $import_order_page;?>";
				<?php } ?>
				
				if(import_order_page=="yes")
				{
					/**************2021-05-17 only for import order page*************/
					item_name 	= $(".new_import_page_item_name").val();
					mrp 		= $(".new_import_page_item_mrp").val();
					add_new_row_import_order_page(item_name,mrp,quantity);
					$(".modaloff").click();
					clear_search_box();
					/***************************************************************/
				}
				else
				{
					$(".add_medicine_to_cart").html("<center>Loading....</center>");
					$.ajax({
						type       : "POST",
						data       : {i_code:i_code,item_name:item_name,final_price:final_price,scheme:scheme,image:image,quantity:quantity,chemist_id:chemist_id},
						url        : "<?php echo base_url(); ?>Chemist_order/add_medicine_to_cart",
						cache	   : true,
						error: function(){
							swal("error add to cart")
						},
						success    : function(data){
							$.each(data.items, function(i,item){	
								if (item)
								{
									if(item.response=="1")
									{
										$(".modaloff").click();
										$(".SearchMedicine_search_box").focus();
										page_load();
									}
								}
							});
						},
						timeout: 10000
					});
				}
			}
			else
			{
				swal("Etner quantity only " + max_quantity);
				$(".new_quantity"+i_code).val("");
				$(".new_quantity"+i_code).focus();
			}
		}
		else{
			swal("Etner quantity one or more than one");
			$(".new_quantity"+i_code).val("");
			$(".new_quantity"+i_code).focus();
		}
	}
}

</script>
<div class="select_medicine_in_modal_script_css"></div>
<div class="only_for_noti"></div>
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