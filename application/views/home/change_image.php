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
$(".headertitle").html("Update image");
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
					<div class="main_theme_li_bg p-4">
						<div class="row">
							<div class="col-sm-2 col-2">
								<img src="<?= $_SESSION['user_image'] ?>" class="medicine_cart_item_image" onerror=this.src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png">
							</div>
							<div class="col-sm-10 col-10 text-left">
								<span class="chemist_user_name"><?= $_SESSION['user_fname'] ?></span><br>
								<span class="chemist_altercode">Code : <?= $_SESSION['user_altercode'] ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 m-2">
					<img class="img-circle" src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/logo.png" width="40%" alt="Change Image" title="Change Image" style="margin-left:30%" id="user_profile">
				</div>
				<div class="col-sm-12 m-2">
					<div class="cart_div_bg p-4">
						<a href="javascript:getfile_fun()" title="Select image from gallery">
							<img class="img-circle" src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/photo1.png" width="30" alt="Select image from gallery" title="Select image from gallery">
							<span style="margin-left:20px;">Select image from gallery</span>
						</a>
					</div>
					<input type="file" id="getfile" onchange="image_upload_start()" style="display:none" accept=", image/gif,image/jpg,image/png,image/jpeg" />
				</div>
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
		url        : "<?php echo base_url(); ?>Chemist_json/user_account_api",
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
					if(item.user_profile!="")
					{
						$("#user_profile").attr("src",item.user_profile);
					}
				}
			});
		},
		timeout: 10000
	});
}

function getfile_fun()
{
	document.getElementById('getfile').click();
}
function image_upload_start()
{
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";

	var file_data = $('#getfile').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('image_path',file_data);
	form_data.append('user_type',user_type);
	form_data.append('user_altercode',user_altercode);
    //alert(form_data);                             
    $.ajax({
		url: "<?= base_url()?>Chemist_json/user_image_upload",
		/*dataType: 'text',*/
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		error: function(){
		   	swal("Error Upload Image");
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					swal(item.status)
					if(item.status1=="1")
					{
						call_page("kapil");
					}
				} 
			});
		},
		timeout: 10000
	});
}
</script>