<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      <?= $this->Scheme_Model->get_website_data("title") ;?> || <?= $main_page_title;?>
    </title>
    <!-- Stylesheets -->
	<meta name="theme-color" content="#27ae60">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="https://fonts.googleapis.com/css?family=Cabin:700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/font-awesome.min.css"> 
	<link href="<?= base_url(); ?>assets/website/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="<?= base_url(); ?>assets/website/js/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bigSlide.js"></script> 

	<style>/*light theme*/
	:root{
		--main_theme_color:#27ae60;
		--main_theme_footer_color:#ffffff;
		--main_theme_bg_color:#d3cfcf42;

		--main_theme_white_bg_color:#ffffff;
		--main_theme_scrollbar_color:#27ae60;
		

		--main_theme_li_color:rgb(240, 240, 240);
		--main_theme_li_bg_color:#969a9829;
		--main_theme_li_bg_hover_color:#27ae6029;

		--main_theme_li2_color:rgb(240, 240, 240);
		--main_theme_li2_bg_color:#ffffff;
		--main_theme_li2_bg_hover_color:#27ae6029;

		--main_theme_textbox_bg_color:#ffffff;
		--main_theme_textbox_color:#6A6767;
		--main_theme_text_white_color:#ffffff;
		--main_theme_text_black_color:#000000;
		--main_theme_border_color:#ebebeb;
		--main_theme_border_hover_color:#27ae6085;
		--main_theme_modal_bg_color:#ffffff;

		--mainbutton-color:#27ae60; /* #27ae60; */
		--mainbuttonhover-color:#1b6339; /* #27ae60; */
	}
	</style>

	<link href="<?= base_url(); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" href="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" type="image/logo" sizes="16x16">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>

  <body style="margin-top: 0px !important">
	<div class="container-fluid" style="">
		<div class="row main_round_theme">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">						
				<div class="text-center">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" width="100px" alt>
				</div>
				<div class="text-right login_text_font">
					Create account
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:30px;">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<div class="form-row">
					<div class="form-group col">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 10px;" alt>
						<input type="text" value="" class="form-control form-control-lg input_type_text" placeholder="Chemist code(e.g. A125)" required="" name="user_name1" id="user_name1" title="Chemist code(e.g. A125)">
					</div>
				</div>
				<div style="border-top: 1px solid white;"></div>
				<div class="form-row" style="margin-top:15px;">
					<div class="form-group col">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/phone1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 10px;" alt>
						<input type="text" value="" class="form-control form-control-lg input_type_text" placeholder="Mobile number(e.g. 95123XXXXX)" required="" name="phone_number1" id="phone_number1" style="float: left;" title="Mobile number(e.g. 95123XXXXX)" maxlength="10">
					</div>
				</div>
				<h5 class="text-center gray_text_31 submit_div" style="margin-top:10px;">&nbsp;</h5>
				<div class="text-center" style="margin-top:10px;">
					<input type="submit" value="Create account" class="btn btn-primary mainbutton" name="Submit" onclick="submitbtn()"
					id="submitbtn"><input type="submit" value="Create account" class="btn btn-primary mainbutton_disable" id="submitbtn_disable" style="display:none">
				</div>
				<div class="text-center" style="margin-top:30px;">
					Already have an account? 
					<a href="<?= base_url() ?>user/login" class="main_theme_a">
					Login</a>
				</div>
				<div class="text-center website_name_css" style="margin-top:15px;">
					<?= $this->Scheme_Model->get_website_data("title2") ;?>
				</div>
				<div class="text-center website_version_css" style="margin-top:5px;">
					Website version <?= $this->Scheme_Model->get_website_data("android_versioncode") ;?>
				</div>
			</div>
			<div class="col-md-3">
			</div>
		</div>
	</div>
</body>
</html>
<script>
$('#user_name1').on("keypress", function(e) {
	if (e.keyCode == 13) {
		submitbtn()
		return false; // prevent the button click from happening
	}
});
$('#phone_number1').on("keypress", function(e) {
	if (e.keyCode == 13) {
		submitbtn()
		return false; // prevent the button click from happening
	}
});
function submitbtn()
{
	chemist_code 	= $('#user_name1').val();
	phone_number	= $('#phone_number1').val();
	if(chemist_code=="")
	{
		swal("Enter Chemist code");
		$(".submit_div").html("<p class='text-danger'>Enter Chemist code</p>");
		$('#user_name1').focus();
		return false;
	}
	if(phone_number=="")
	{
		swal("Enter Mobile number");
		$(".submit_div").html("<p class='text-danger'>Enter Mobile number</p>");
		$('#phone_number1').focus();
		return false;
	}
	
	$("#submitbtn").hide();
	$("#submitbtn_disable").show();
	$(".submit_div").html("Loading....");
	
	$.ajax({
		type       : "POST",
		data       : {chemist_code:chemist_code,phone_number:phone_number},
		url        : "<?= base_url();?>chemist_json/create_new_api",
		cache	   : false,
		error: function(){
			swal("Error")
			$(".submit_div").html("<p class='text-danger'>Error</p>");
			$("#submitbtn").show();
			$("#submitbtn_disable").hide();
		},
		success    : function(data){
			if(data!="")
			{
				$(".submit_div").html("");
				$("#submitbtn").show();
				$("#submitbtn_disable").hide();
			}
			$.each(data.items, function(i,item){	
				if (item)
				{
					swal(item.status);
					if(item.status1=="1")
					{
						$(".submit_div").html("<p class='text-success'>"+item.status+"</p>");
						$('#user_name1').val('');
						$('#phone_number1').val('');
					}
					else{
						$(".submit_div").html("<p class='text-danger'>"+item.status+"</p>");
					}
				}
			});	
		},
		timeout: 10000
	});
}
</script>