<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
@media screen and (max-width: 767px) {
	.homebtn_div
	{
		display:none;
	}
}
</style>
<script>
$(".headertitle").html("Notification");
function goBack() {
	window.location.href = "<?= base_url();?>home/my_notification";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12 load_page">
					
				</div>
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
				<div class="col-sm-12" style="margin-top:10px;">
					<button onclick="call_page_by_last_id()" class="load_more btn btn-success btn-block site_main_btn31">Load More</button>
				</div>
			</div>
		</div>
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
	/*user_type 	= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";*/
	notification_id 	= "<?php echo $notification_id; ?>";
	
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
	type       : "POST",
	data       :  {lastid1:lastid1,notification_id:notification_id} ,
	url        : "<?php echo base_url(); ?>Chemist_json/my_notification_view_api",
	cache	   : false,
	error: function(){
        $(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
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
				title   = atob(item.title);
				message = atob(item.message);
				$(".headertitle").html(title);

				image   = "";
				if(item.image!=""){
					image   = '<img src='+item.image+' width="100%">';
				}
				okok = '<a href=javascript:callandroidfun("'+item.funtype+'","'+item.itemid+'","","'+item.image+'","'+item.division+'"); style="text-decoration:none;">';
				
				$(".load_page").append(okok+'<li class="list_item_radius"><div class="row"><div class="col-sm-12 col-12 text-left cart_title">'+title+'</div><div class="col-sm-12 col-12 text-left cart_date_time">'+item.date_time+'</div><div class="col-sm-12 col-12 text-left notifiction_message">'+message+'</div><div class="col-sm-4 col-12 text_cut_or_dot text-center">'+image+'</div></div></li></a>');
				$(".lastid1").val(item.lastid1);
				if(item.css!="")
				{
					//$(".load_more").show();
				}
			}
		});
		},
		timeout: 10000
	});
}
function callandroidfun(funtype,id,compname,image,division) {
	if(funtype=="1"){
		android.fun_Get_single_medicine_info(id);
	}
	if(funtype=="2"){
		compname = atob(compname);
		android.fun_Featured_brand_medicine_division(id,compname,image,division);
	}
	if(funtype=="3"){
		window.location.href = "<?php echo base_url(); ?>home/map"
	}
	if(funtype=="4"){
		window.location.href = "<?php echo base_url(); ?>home/my_orders"
	}
	if(funtype=="5"){
		window.location.href = "<?php echo base_url(); ?>home/my_invoice"
	}
}
</script>