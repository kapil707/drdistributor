<script src="<?= base_url(); ?>assets/website/js/scripts.js"></script>
<?php
$website_menu 	= file_get_contents('./json_api/website_menu_json_new.json');
$website_menu 	= '['.$website_menu.']';
$website_menu 	= json_decode($website_menu, true);

$title0 = "Our top brands";
$featured_brand_json 	= file_get_contents('./json_api/featured_brand_json_new.json');
$featured_brand_json	= '['.$featured_brand_json.']';
$featured_brand_json 	= json_decode($featured_brand_json, true);
?>

<div class="website_footer1 mobile_off">
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/drphone.png" class="img-fluid" style="margin-top: 5px;" alt>
			</div>
			<div class="col-sm-10 text-center download_app_div">
				Download the App for Free
				<div style="width:250px;margin:auto;margin-top:50px;">
					<div class="google_play">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en_IN" target="_blank">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/playstrore.png" alt="Google Play" style="width:35px;"> Google Play
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="website_footer mobile_off">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title text-capitalize"><?php echo $title0; ?></li>
						<?php
						$i = 0;
						foreach($featured_brand_json as $row)
						{
							$i++;
							if ($i <= 7) {
								if (empty($row["division"])) {
									$row["division"] = "not";
								}
								?>
							<li class="footer_li_text">
								<a href="<?= base_url(); ?>home/medicine_category/featured_brand/<?= $row["item_code"] ?>">
									<span class="">
										<?= $row["item_company"]; ?>
									</span>
								</a>
							</li>
							<?php
							}
						}
						?>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title text-capitalize">Medicine Category</li>
						<?php
						$i = 0;
						foreach($website_menu as $row)
						{
							?>
							<li class="footer_li_text">
								<a href="<?= base_url();?>home/medicine_category/medicine_category/<?= $row["item_code"] ?>">
									<span>
									<?= ($row["item_company"]) ?>
									</span>
								</a>
							</li>
							<?php
						}
						?>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">Need Help?</li>
						<li class="footer_li_text">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/phone.png" width="20" alt="Contacts" title="Contact us"> Contact us
						</li>
						<li class="footer_li_text">
							<a href="tel:+919899133989" title="Contact us">
								+919899133989
							</a>
						</li>
						<li class="footer_li_text">
							<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/email.png" width="20" alt="Email" title="Email"> Email us
						</li>
						<li class="footer_li_text">
							<a href="mailto:vipul@drdindia.com" title="Email">
								vipul@drdindia.com
							</a>
						</li>
						<li class="footer_li_text">
							<a href="<?= base_url('user/privacy_policy')?>" title="Privacy policy">
								<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/privacy_policy.png" width="20"  alt="Privacy policy" title="Privacy policy">
								Privacy policy
							</a>
						</li>
						<li class="footer_li_text">
							<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black" title="Share App">
								<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/share.png" width="20" alt="Share App" title="Share App">
								Share App
							</a>
						</li>
						<li class="footer_li_text">
							<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black" title="Download App">
								<img class="img-circle" src="<?= base_url() ?>img_v<?= constant('site_v') ?>/playstrore.png" width="20" alt="Download App" title="Download App">
								Download App
							</a>
						</li>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">FOLLOW US</li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/insta.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/fb.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/youtube.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/twitter.svg"></li>
					<ul>
				</div>
			</div>
			<div class="col-sm-1"></div>
			<div class="col-sm-10 text-center footer_copy">
			<div class="text-center" style="margin-top:15px;">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" class="img-fluid" style="margin-top: 5px;" alt width="100px;">
				</div>
				<div class="text-center" style="margin-top:15px;">
					<strong><?= $this->Scheme_Model->get_website_data("title2") ;?></strong>
				</div>
				<div class="text-center" style="margin-top:5px;">
					Website version <?= $this->Scheme_Model->get_website_data("android_versioncode") ;?>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</div>

<div class="fix_footer mobile_show">
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok text-center">
		<a href="<?= base_url('home/account')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="22px" alt>
			<div style="font-size: 11px;">Account</div>
		</a>
	</div>
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_left text-center">
		<a href="<?= base_url('home/track_order')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/map.png" width="22px" alt>
			<div style="font-size: 11px;">Track</div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_center text-center">
		<a href="<?= base_url('home/search_medicine')?>" style="color:white" alt>
			<div style="font-size: 27px;">+</div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_right text-center">
		<a href="<?= base_url('home/my_notification')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification.png" width="22px" class="cssnotification" alt>
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification1.png" width="22px" style="display:none;" class="cssnotification1" alt>
			<div style="font-size: 11px;" class="mobile_off">Notifications <span class="notificationdiv"></span></div>
			<div style="font-size: 11px;" class="mobile_show">Notifications <span class="notificationdiv"></span></div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok text-center"
	style="margin-right: -15px;">
		<a href="<?= base_url();?>/home" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/reload1_w.png" width="22px" alt>
			<div style="font-size: 11px;">Reload</div>
		</a>
	</div>
</div>