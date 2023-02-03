<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<script>
$(".headertitle").html("Select chemist");
function goBack() {
	window.location.href = "<?= base_url();?>home/search_medicine";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<span class="draft_order_list_sales_div">
			</span>
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
	$(".draft_order_list_sales_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
	type       : "POST",
	data       :  { lastid1:lastid1} ,
	url        : "<?php echo base_url(); ?>Chemist_json/draft_order_list_sales_api",
	cache	   : false,
	error: function(){
        $(".draft_order_list_sales_div").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
    },
	success    : function(data){
		if(data.items=="")
		{
			$(".draft_order_list_sales_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
		}
		else
		{
			$(".draft_order_list_sales_div").html("");
		}
		$.each(data.items, function(i,item){	
			if (item){
				$(".draft_order_list_sales_div").append('<li class="list_item_radius"><a href="<?= base_url();?>home/draft_order_list/'+item.chemist_id+'"><div class="row"><div class="col-sm-1 col-3"><img src="'+item.user_image+'" class="rounded account_page_header_image"></div><div class="col-sm-11 col-9 text-left"><div class="cart_title">'+item.user_name+'</div><div class="cart_chemist_code"> Code : '+item.chemist_id+'</div><div class="cart_date_time">Order '+item.order_items+' Items | Total : <i class="fa fa-inr" aria-hidden="true"></i>'+item.total+'/-</div></div></div></a></li>');
				//$(".lastid1").val(item.lastid1);
				if(item.sec_row!="")
				{
					//$(".load_more").show();
				}
			}
		});	
		}
	});
}
</script>