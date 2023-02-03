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
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12 load_page">
					
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<span class="load_page_loading" style="position: fixed;top: 300px;z-index: 100;margin-left:-90px"></span>
				</div>
				<div class="col-sm-12" style="margin-top:10px;">
					<button onclick="load_more()" class="load_more"></button>
				</div>
			</div>
		</div>
	</div>     
</div>
<input type="hidden" class="get_record" value="0">
<script>
$(window).scroll(function(){
	var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
	if (scrollBottom<100){
		//alert(parseInt($(window).scrollTop()))
		$(".load_more").click()
	}
});
$(document).ready(function(){
	get_record=$(".get_record").val();
	call_page(get_record)
});
function load_more()
{
	get_record=$(".get_record").val();
	call_page(get_record)
}
var query_work = 0;
var no_record_found = 0;
function call_page(get_record)
{
	if(query_work=="0")
	{
		query_work = 1;
		$(".load_more").hide();
		$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
		$.ajax({
			type       : "POST",
			data       :  { get_record:get_record} ,
			url        : "<?php echo base_url(); ?>Chemist_json/my_notification_api",
			cache	   : false,
			error: function(){
				$(".load_page_loading").html("");
				$(".load_page").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
			},
			success    : function(data){
				if(data.items=="")
				{
					if(no_record_found=="0")
					{
						$(".load_page_loading").html("");
						$(".load_page").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
					}
					else
					{
						$(".load_page_loading").html("");
						$(".load_page").html("");
					}
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
						
						$(".load_page").append('<div class="main_theme_li_bg"><a href="<?php echo base_url() ?>home/my_notification_details/'+item_id+'"><div class="medicine_my_page_div1"><img src="'+item_image+'" alt="" title="" onerror=this.src="<?= base_url(); ?>/uploads/default_img.jpg" class="medicine_cart_item_image"></div><div class="medicine_my_page_div2 text-left"><div class="medicine_cart_item_name">'+item_title+'</div><div class="medicine_cart_item_price">'+item_message+'</div><div class="medicine_cart_item_datetime">'+item_date_time+'</div></div></a></div>');

						query_work = 0;
						no_record_found = 1;
						$(".get_record").val(item.get_record);
						$(".load_more").show();
					}
				});
			},
			timeout: 10000
		});
	}
}
</script>