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
	<meta name="theme-color" content="#f7625b">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="https://fonts.googleapis.com/css?family=Cabin:700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/font-awesome.min.css"> 
	<link href="<?= base_url(); ?>assets/website/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="<?= base_url(); ?>assets/website/js/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bigSlide.js"></script> 
	<link href="<?= base_url(); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" href="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" type="image/logo" sizes="16x16">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>

  <body style="margin-top: 0px !important">
	<div class="container-fluid" style="">
		<div class="row new_orange_header">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">						
				<div class="text-center">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" width="100px" alt>
				</div>
				<div class="text-right login_text_font">
					Login
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:30px;">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<div class="form-row">
					<div class="form-group col">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
						<input type="text" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter username" required="" name="user_name1" id="user_name1" title="Enter username">
					</div>
				</div>
				<div style="border-top: 1px solid white;"></div>
				<div class="form-row" style="margin-top:15px;">
					<div class="form-group col">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/b_lock.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
						<input type="password" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter password" required="" name="password1" id="password1" style="float: left;" title="Enter password">
						<div style="float: right; margin-top: 10px;margin-left: -50px; width:45px;">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/b_eyes1.png" width="25px" onclick="showpassword()" id="eyes1" alt>
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/b_eyes.png" width="25px" onclick="hidepassword()" id="eyes" style="display:none" alt>
						</div>
					</div>
				</div>
				<h5 class="text-center gray_text_31 submit_div" style="margin-top:10px;">&nbsp;</h5>
				<div class="form-row" style="margin-top:15px;">
					<div class="form-group col text-center">
						<label class="gray_text_31">
							<input type="checkbox" checked id="checkbox"> I agree to the
						</label>&nbsp;
						<a href="<?= base_url(); ?>user/termsofservice" style="color:#311B92">
							<strong>terms of services</strong>
						</a>
					</div>
				</div>
				<div class="text-center">
					<input type="submit" value="Login" class="btn btn-primary btn-block site_main_btn31" name="Submit" onclick="submitbtn()" id="submitbtn">

					<input type="submit" value="Login" class="btn btn-primary btn-block site_main_btn31_disabled" id="submitbtn_disable" style="display:none">
				</div>
				<div class="text-center" style="margin-top:30px;">
					Don't have an account? 
					<a href="<?= base_url() ?>user/register" class="register31">
					Create account</a>
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
function showpassword()
{
	$("#eyes1").hide();
	$("#eyes").show();
	document.getElementById("password1").type = 'text';
}
function hidepassword()
{
	$("#eyes1").show();
	$("#eyes").hide();
	document.getElementById("password1").type = 'password';
}
$('#user_name1').on("keypress", function(e) {
	if (e.keyCode == 13) {
		submitbtn()
		return false; // prevent the button click from happening
	}
});
$('#password1').on("keypress", function(e) {
	if (e.keyCode == 13) {
		submitbtn()
		return false; // prevent the button click from happening
	}
});
function submitbtn()
{
	user_name1 	= $('#user_name1').val();
	password1	= $('#password1').val();
	checkbox	= $('#checkbox').val();
	submit = "98c08565401579448aad7c64033dcb4081906dcb";
	if(user_name1=="")
	{
		swal("Enter username");
		$(".submit_div").html("<p class='text-danger'>Enter username</p>");
		$('#user_name1').focus();
		return false;
	}
	if(password1=="")
	{
		swal("Enter password");
		$(".submit_div").html("<p class='text-danger'>Enter password</p>");
		$('#password1').focus();
		return false;
	}
	if($('#checkbox').is(':checked'))
	{
	}
	else
	{
		swal("Check terms of service");
		$(".submit_div").html("<p class='text-danger'>Check terms of service</p>");
		$('#checkbox').focus();
		return false;
	}
	
	$("#submitbtn").hide();
	$("#submitbtn_disable").show();
	$(".submit_div").html("Loading....");

	$.ajax({
		type       : "POST",
		data       : {user_name1:user_name1,password1:password1,submit:submit},
		url        : "<?= base_url();?>chemist_json/login",
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
					if(item.user_return=="1")
					{
						$(".submit_div").html("<p class='text-success'>"+item.user_alert+"</p>");
						if(item.user_type=="chemist" || item.user_type=="sales")
						{
							window.location.href = "<?= constant('main_site');?>home";
						}
						/*if(item.user_type=="sales")
						{
							window.location.href = "<?= constant('img_url_site');?>home/insert_login/"+user_name1+"/"+password1;
						}*/
						if(item.user_type=="corporate")
						{
							window.location.href = "<?= constant('img_url_site');?>corporate/insert_login/"+user_name1+"/"+password1;
						}
					}else{
						swal(item.user_alert);
						$(".submit_div").html("<p class='text-danger'>"+item.user_alert+"</p>");
					}
				}
			});	
		},
		timeout: 10000
	});
}
</script>