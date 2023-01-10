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
$(".headertitle").html("Update account");
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
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/phone1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="text" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter mobile number" required="" name="mobile1" id="mobile1" title="Enter mobile number">
				</div>
				<div class="col-sm-12 m-1">
					<div style="border-top: 1px solid white;"></div>
				</div>
				<div class="col-sm-12 m-2">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/email1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="text" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter email" required="" name="email1" id="email1" title="Enter email">
				</div>
				<div class="col-sm-12 m-1">
					<div style="border-top: 1px solid white;"></div>
				</div>
				<div class="col-sm-12 m-2">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/map1.png" width="25px" style="float: left; margin-top: 10px;position: absolute;margin-left: 20px;" alt>
					<input type="text" value="" class="form-control form-control-lg new_text_box_bg_white" placeholder="Enter address" required="" name="address1" id="address1" title="Enter address">
				</div>
				<div class="col-sm-12 m-2 text-center">
					<span class="gray_text_31 submit_div" style="margin-top:10px;">&nbsp;</span>
				</div>
				<div class="col-sm-12 m-2">
					<input type="submit" value="Update account" class="btn btn-primary btn-block site_main_btn31" name="Submit" onclick="submitbtn()" id="submitbtn">

					<input type="submit" value="Update account" class="btn btn-primary btn-block site_main_btn31_disabled" id="submitbtn_disable" style="display:none">
				</div>
			</div>
			<div class="round_white_bg load_page" style=" margin-top: 30px;">
				
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	call_page("kapil");
});
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page(lastid1)
}
function call_page(lastid1)
{
	new_i = 0;
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";
	$(".load_more").hide();
	$(".load_page").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {user_type:user_type,user_altercode:user_altercode} ,
		url        : "<?php echo base_url(); ?>Chemist_json/check_user_account_api",
		cache	   : false,
		error: function(){
			$(".load_page").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
		},
		success    : function(data){
			if(data.items=="")
			{
				$(".load_page").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
			}
			else
			{
				$(".load_page").html("");
			}
			$.each(data.items, function(i,item){	
				if (item){

					$(".load_page").append('<div class="row"><div class="col-sm-12 col-12"><h5>Last update request</h5></div></div>');
					
					$(".load_page").append('<div class="row"><div class="col-sm-12"><img class="img-circle" src="<?= base_url() ?>/img_v<?= constant("site_v") ?>/phone1.png" width="25" alt="Mobile" title="Mobile"><span style="margin-left:20px;">'+item.user_phone+'</span></div></div>');

					$(".load_page").append('<div class="row"><div class="col-sm-12"><img class="img-circle" src="<?= base_url() ?>/img_v<?= constant("site_v") ?>/email1.png" width="25" alt="Email" title="Email"><span style="margin-left:20px;">'+item.user_email+'</span></div></div>');

					$(".load_page").append('<div class="row"><div class="col-sm-12"><img class="img-circle" src="<?= base_url() ?>/img_v<?= constant("site_v") ?>/map1.png" width="25" alt="Address" title="Address"><span style="margin-left:20px;">'+item.user_address+'</span></div></div>');
				}
			});
		},
		timeout: 10000
	});
}
function submitbtn()
{
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";

	mobile1 	= $('#mobile1').val();
	email1	    = $('#email1').val();
	address1	= $('#address1').val();
	submit = "98c08565401579448aad7c64033dcb4081906dcb";
	if(mobile1=="")
	{
		swal("Enter mobile number")
		$(".submit_div").html("<p class='text-danger'>Enter mobile number</p>");
		$('#mobile1').focus();
		return false;
	}
	if(email1=="")
	{
		swal("Enter email")
		$(".submit_div").html("<p class='text-danger'>Enter email</p>");
		$('#email1').focus();
		return false;
	}
	if(address1=="")
	{
		swal("Enter address")
		$(".submit_div").html("<p class='text-danger'>Enter address</p>");
		$('#address1').focus();
		return false;
	}
	
	$("#submitbtn").hide();
	$("#submitbtn_disable").show();
	$(".submit_div").html("Loading....");
	
	$.ajax({
		type       : "POST",
		data       : {user_type:user_type,user_altercode:user_altercode,user_phone:mobile1,user_email:email1,user_address:address1},
		url        : "<?= base_url();?>chemist_json/update_user_account_api",
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
						call_page("kapil");
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