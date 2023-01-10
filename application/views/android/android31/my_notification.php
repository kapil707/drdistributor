<div class="container" style="margin-top:-10px;">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10 col-12">
			<span class="load_page"></span>
			<div class="row">			
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
				<div class="col-sm-12" style="margin-top:10px;">
					<button onclick="call_page_by_last_id()" class="load_more btn btn-block site_main_btn31">Load More</button>
				</div>
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<input type="hidden" class="lastid1">
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
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {lastid1:lastid1,user_type:'<?= $user_type; ?>',user_altercode:'<?= $user_altercode; ?>'} ,
		url        : "<?php echo base_url(); ?>android/api_mobile31/my_notification_api",
		cache	   : false,
		error: function(){
			$(".load_page_loading").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success    : function(data){
			if(data.items=="")
			{
				$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
			}
			else
			{
				$(".load_page_loading").html("");
			}
			$.each(data.items, function(i,item){	
				if (item){
					title 	= atob(item.title);
					message = atob(item.message);
					message = message.substring(0,100);
					image  	= (item.image);

					image_ = '<img src="'+image+'" style="width: 100%;cursor: pointer;" class="rounded account_page_header_image">';
					
					$(".load_page").append('<li class="list_item_radius"><a href="<?= base_url(); ?>android/api_mobile_html31/my_notification_view/'+item.url+'"><div class="row"><div class="col-sm-1 col-3">'+image_+'</div><div class="col-sm-11 col-9 text-left"><div class="text-capitalize cart_title">'+title+'</div><div class="cart_date_time">'+item.date_time+'</div><div class="text_cut_or_dot text-left notifiction_message">'+message+'</div></div></div></a></div>');
					$(".lastid1").val(item.lastid1);
					if(item.css!="")
					{
						$(".load_more").show();
					}
				}
			});
		},
		timeout: 10000
	});
}
function callandroidfun(funtype,id,compname,image,division) {
	if(funtype=="0"){
		window.location.href = "<?= base_url(); ?>android/api_mobile_html31/chemist_notification_view/"+id;
	}
	if(funtype=="1"){
		android.fun_Get_single_medicine_info(id);
	}
	if(funtype=="2"){
		compname = atob(compname);
		android.fun_Featured_brand_medicine_division(id,compname,image,division);
	}
}
</script>