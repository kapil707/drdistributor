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
$(".headertitle").html("<?= $main_page_title ?>");
function goBack() {
	window.location.href = "<?= base_url();?>home/my_notification";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
			</div>
			<span class="load_page"></span>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	call_page();
});
function call_page()
{
	item_id 		= "<?php echo $item_id; ?>";

	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {item_id:item_id} ,
		url        : "<?php echo base_url(); ?>Chemist_json/my_notification_details_api",
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
					item_id 			= item.item_id;
					item_title 			= item.item_title;
					item_message 		= item.item_message;
					item_date_time 		= item.item_date_time;
					item_image 			= item.item_image;
					item_image2			= item.item_image2;

					item_fun_type 		= item.item_fun_type;
					item_fun_name 		= item.item_fun_name;
					item_fun_id 		= item.item_fun_id;
					item_fun_id2 		= item.item_fun_id2;

					function_call = "#";
					if(item_fun_type=="1")
					{
						function_call = "javascript:"+item_fun_name+"('"+item_fun_id+"')";
					}

					if(item_fun_type=="2")
					{
						if(item_fun_id2=="")
						{
							item_fun_id2 = "not";
						}
						function_call = "<?= base_url();?>home/"+item_fun_name+"/"+item_fun_id + "/" + item_fun_id2;
					}

					if(item_fun_type=="3"){
						function_call = "<?= base_url();?>home/"+item_fun_id;
					}

					if(item_fun_type=="4"){
						function_call = "<?= base_url();?>home/"+item_fun_id;
					}

					if(item_fun_type=="5"){
						function_call = "<?= base_url();?>home/"+item_fun_id;
					}

					if(item_image2)
					{
						item_image2 = "<img src='"+item_image2+"' class='medicine_cart_item_image'>";
					}

					$(".load_page").append('<div class="main_theme_li_bg"><a href="'+function_call+'"><div class="medicine_my_page_div1"><img src="'+item_image+'" alt="" title="" onerror=this.src="<?= base_url(); ?>/uploads/default_img.jpg" class="medicine_cart_item_image"></div><div class="medicine_my_page_div2 text-left"><div class="medicine_cart_item_name">'+item_title+'</div><div class="medicine_cart_item_price">'+item_message+'</div><div class="medicine_cart_item_datetime">'+item_date_time+'</div><div class="medicine_cart_item_datetime">'+item_image2+'</div></div></a></div>');
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