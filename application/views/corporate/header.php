<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		Dr. Distributor || <?= $main_page_title; ?>
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
	<style>
	.menu-notify {
		height: 60px;
		padding: 5px !important;
	}
	</style>
</head>
<body>
<?php
if(empty($session_user_fname))
{
	$session_user_image = base_url()."img_v".constant('site_v')."/logo.png";
	$session_user_fname = $this->session->userdata('user_fname');
	$session_user_altercode = $this->session->userdata('user_division');
}
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
							<br> Division : <?= $session_user_altercode ?>
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
				<div class="text-left" style="margin-left:10px;margin-top:10px; border-top: 1px solid #f3f3f3;">Others</div>
				<ul>
					<li>
						<a href="tel:+919899133989" title="Contact us">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/phone.png" width="20" alt="Contacts" title="Contact us">
							Contact us
						</a>
					</li>
					<li title="Email">
						<a href="mailto:vipul@drdindia.com">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/email.png" width="20" alt="Email" title="Email">
							Email
						</a>
					</li>
					<li title="Privacy policy">
						<a href="<?= base_url('user/privacy_policy')?>">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20"  alt="Privacy policy" title="Privacy policy">
							Privacy policy
						</a>
					</li>
					<li title="Share app">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/share.png" width="20" alt="Share app" title="Share app">
							Share app
						</a>
					</li>
					<li title="Logout">
						<a href="<?= base_url('user/logout')?>">
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
				<div class="col-sm-3 col-5">
					<span style="float:left; margin-right:10px;">
						<a href="javascript:new_style_menu_show()" class="menubtn1" style="color:white;" title="Drd Menu">
							<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/logo2.png" width="40px;" style="margin-top: 5px;" alt>
						</a>
						<a href="javascript:goBack()" class="menubtn2" title="Go Back">
							<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/back_button.png" width="30px;" style="margin-top: 5px;" alt>
						</a>
					</span>
					<span style="float:left; margin: auto;">
						<div class="pro-link headertitle1" style="color:white;font-size: 13px; margin-top: 3px;display:none;">
						Delivering To
						</div>
						<div class="pro-link headertitle">
							Corporate <?= $_SESSION['user_fname'] ?>
						</div>
					</span>
				</div>
				<div class="col-sm-9 col-7">
					<a href="<?= base_url('user/logout')?>" class="logout_div" style="float:right" title="Logout">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/logout.png" width="28px;" alt>
					</a>
					
					<a href="<?= base_url() ?>home/my_notification" class="notification_div mobile_off" style="float:right" title="Notification">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/notification_w.png" width="28px" class="cssnotification" alt>
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/notification_w1.png" width="28px" style="display:none;" class="cssnotification1" alt>
					</a>
					
					<a href="<?= base_url() ?>home" class="homebtn_div" style="float:right" title="Home">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/homelcon.png" width="28px;" alt>
					</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>