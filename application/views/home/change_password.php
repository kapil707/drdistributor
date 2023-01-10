<style>
.menubtn1
{
	display:none;
}
@media screen and (max-width: 767px) {
	.website_menu,.current_order_search_page1,.select_chemist,.homebtn_div
	{
		display: none ;
	}
}
</style>
<script>
$(".headertitle").html("Update password");
function goBack() {
	window.location.href = "<?= base_url();?>home/account";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 col-12">
			<div class="row">
				<div class="col-sm-12 m-2">
					<div class="round_white_bg">
						<div class="row">
							<div class="col-sm-2 col-3">
								<img src="<?= $_SESSION['user_image'] ?>" alt="<?= $_SESSION['user_fname'] ?>" title="<?= $_SESSION['user_fname'] ?>" class="rounded account_page_header_image">
							</div>
							<div class="col-sm-9 col-9 text-left">
								<span class="select_chemist_name"><?= $_SESSION['user_fname'] ?></span><br>
								<span class="select_chemist_code">Code : <?= $_SESSION['user_altercode'] ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 m-2">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_lock.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="password" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter oldpassword" required="" name="old_password" id="old_password" style="float: left;" title="Enter oldpassword" autocomplete="new-password" onchange="check_old_password()">
					<div style="float: right; margin-top: 10px;margin-left: -50px; width:45px;">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes1.png" width="25px" onclick="showpassword()" id="eyes1" alt>
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes.png" width="25px" onclick="hidepassword()" id="eyes" style="display:none" alt>
					</div>
				</div>
				<div class="col-sm-12 m-1">
					<div style="border-top: 1px solid white;"></div>
				</div>
				<div class="col-sm-12 m-2">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_lock.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="password" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter newpassword" required="" name="new_password" id="new_password" style="float: left;" title="Enter newpassword" maxlength="16" autocomplete="new-password" onchange="check_password1()">
					<div style="float: right; margin-top: 10px;margin-left: -50px; width:45px;">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes1.png" width="25px" onclick="showpassword1()" id="eyes1" alt>
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes.png" width="25px" onclick="hidepassword1()" id="eyes" style="display:none" alt>
					</div>
				</div>
				<div class="col-sm-12 m-1">
					<div style="border-top: 1px solid white;"></div>
				</div>
				
				<div class="col-sm-12 m-2">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_lock.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="password" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Re-enter newpassword" required="" name="renew_password" id="renew_password" style="float: left;" title="Re-enter newpassword" autocomplete="new-password" onchange="check_password2()">
					<div style="float: right; margin-top: 10px;margin-left: -50px; width:45px;">
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes1.png" width="25px" onclick="showpassword2()" id="eyes1" alt>
						<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/b_eyes.png" width="25px" onclick="hidepassword2()" id="eyes" style="display:none" alt>
					</div>
				</div>
				<div class="col-sm-12 m-1 text-center">
					<span class="text-center gray_text_31 submit_div" style="margin-top:10px;">&nbsp;</span>
				</div>
				<div class="col-sm-12 m-2">
					<input type="submit" value="Update password" class="btn btn-primary btn-block site_main_btn31" onclick="submitbtn()" id="submitbtn">

					<input type="submit" value="Update password" class="btn btn-primary btn-block site_main_btn31_disabled" id="submitbtn_disable" style="display:none">
				</div>
			</div> 
		</div>
	</div>
</div>
  
<script>
function showpassword()
{
	$("#eyes1").hide();
	$("#eyes").show();
	document.getElementById("old_password").type = 'text';
}
function hidepassword()
{
	$("#eyes1").show();
	$("#eyes").hide();
	document.getElementById("old_password").type = 'password';
}
function showpassword1()
{
	$("#eyes1").hide();
	$("#eyes").show();
	document.getElementById("new_password").type = 'text';
}
function hidepassword1()
{
	$("#eyes1").show();
	$("#eyes").hide();
	document.getElementById("new_password").type = 'password';
}
function showpassword2()
{
	$("#eyes1").hide();
	$("#eyes").show();
	document.getElementById("renew_password").type = 'text';
}
function hidepassword2()
{
	$("#eyes1").show();
	$("#eyes").hide();
	document.getElementById("renew_password").type = 'password';
}
var pass1 = 0;
var pass2 = 0;
var pass3 = 0;
function check_old_password()
{
	pass1 = 0;
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";

	old_password = $("#old_password").val();
	//$(".check_old_password_div").html("Loading....");
	if(old_password=="")
	{
		$(".submit_div").html("&nbsp;");
	} else{
		pass1 = 1;
		submit_btn();
		/*
		$.ajax({
			type       : "POST",
			data       :  {old_password:old_password,user_type:user_type,user_altercode:user_altercode} ,
			url        : "<?php echo base_url(); ?>Chemist_json/check_old_password_api",
			cache	   : false,
			success    : function(data){
				$.each(data.items, function(i,item){	
					if (item){
						if(item.status1=="1")
						{
							$(".check_old_password_div").html("<p class='text-success'>"+item.status+"</p>");
							pass1 = 1;
							submit_btn();
						}
						else{
							$(".check_old_password_div").html("<p class='text-danger'>"+item.status+"</p>");
							pass1 = 0;
							submit_btn();
						}
					}
				});	
			}
		});*/
	}
}
function check_password1()
{
	$(".check_new_password_div").html("Loading....");
	new_password = $("#new_password").val();
	if(new_password.length < 8)
	{
		swal("Password must contain 8 characters (e.g. A,a or 1,2 or !,$,@)");
		$(".submit_div").html("<p class='text-danger'>Password must contain 8 characters (e.g. A,a or 1,2 or !,$,@)</p>");
		pass2 = 0;
		submit_btn();
	}
	else
	{
		$(".submit_div").html("&nbsp;");
		pass2 = 1;
		submit_btn();
	}
}
function check_password2()
{
	$(".check_renew_password_div").html("Loading....");
	new_password = $("#new_password").val();
	renew_password = $("#renew_password").val();
	check_password1();
	if(new_password!=renew_password)
	{
		swal("Password doesn't match");
		$(".submit_div").html("<p class='text-danger'>Password doesn't match</p>");
		pass3 = 0;
		submit_btn();
	}
	else
	{
		$(".submit_div").html("<p class='text-success'>Password Matched.</p>");
		pass3 = 1;
		submit_btn();
	}
}
function submit_btn()
{
	$("#submitbtn").hide()
	$("#submitbtn_disable").show()
	if(pass1=="1" && pass2=="1" && pass3=="1")
	{
		$("#submitbtn").show()
		$("#submitbtn_disable").hide()
	}
}
function submitbtn()
{
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";

	old_password = $("#old_password").val();
	new_password = $("#new_password").val();
	renew_password = $("#renew_password").val();
	if(old_password=="")
	{
		swal("Enter oldpassword")
		$(".submit_div").html("<p class='text-danger'>Enter oldpassword</p>");
		$('#old_password').focus();
		return false;
	}

	if(new_password=="")
	{
		swal("Enter newpassword")
		$(".submit_div").html("<p class='text-danger'>Enter newpassword</p>");
		$('#new_password').focus();
		return false;
	}

	if(renew_password=="")
	{
		swal("Enter Re-enter newpassword")
		$(".submit_div").html("<p class='text-danger'>Enter Re-enter newpassword</p>");
		$('#renew_password').focus();
		return false;
	}

	$("#submitbtn").hide();
	$("#submitbtn_disable").show();
	$(".submit_div").html("Loading....");
	
	$.ajax({
		type       : "POST",
		data       :  {old_password:old_password,new_password:new_password,user_type:user_type,user_altercode:user_altercode} ,
		url        : "<?php echo base_url(); ?>Chemist_json/change_password_api",
		cache	   : false,
		error: function(){
			swal("Error")
			$(".submit_div").html("<p class='text-danger'>Error</p>");
			$("#submitbtn").show();
			$("#submitbtn_disable").hide();
		},
		success    : function(data){			
			$.each(data.items, function(i,item){	
				if (item){
					swal(item.status);
					if(item.status1=="1")
					{
						$(".submit_div").html("<p class='text-success'>"+item.status+"</p>");
						$(".check_old_password_div").html("");
						$(".check_new_password_div").html("");
						$(".check_renew_password_div").html("");

						$("#old_password").val("");
						$("#new_password").val("");
						$("#renew_password").val("");						
					}
					else{
						$(".submit_div").html("<p class='text-danger'>"+item.status+"</p>");
					}
				}
			});	
		}
	});
}
</script>