<style>
.menubtn1
{
	display:none;
}
/*.headertitle
{
    margin-top: 5px !important;
}*/
.headertitle
{
    margin-top: 0px !important;
    font-size: 14px;
}
@media screen and (max-width: 767px) {
	.homebtn_div
	{
		display:none;
	}
}
</style>
<script>
$(".headertitle").html("Order : <?= $order_id = $id?>");
function goBack() {
	window.location.href = "<?= base_url();?>home/my_orders";
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
	call_page("kapil");
});
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page(lastid1)
}
function call_page(lastid1)
{
	user_type 		= "<?php echo $_SESSION['user_type']; ?>";
	user_altercode 	= "<?php echo $_SESSION['user_altercode']; ?>";
	order_id 		= "<?php echo $order_id; ?>";
	
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       : {lastid1:lastid1,order_id:order_id,user_type:user_type,user_altercode:user_altercode} ,
		url        : "<?php echo base_url(); ?>Chemist_json/my_orders_view_api",
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
					ptr	 		= parseFloat(item.ptr);
					ptr	 		= ptr.toFixed(2);
					total		= parseFloat(item.total);
					total		= total.toFixed(2);
					
					i_code 		= item.i_code;
					item_name 	= item.item_name;
					image		= item.image;
					date_time   = item.date_time;
					
					if(item.user_type=="chemist")
					{
						$(".headertitle").html("Order : <?= $order_id = $id?> <br>"+item.date_time);
					}
					else{
						$(".headertitle").html("Order : <?= $order_id = $id?> | ("+item.chemist_id+")<br>"+item.date_time);
					}
					
					image_ = '<img src="'+image+'" style="width: 100%;cursor: pointer;" class="border rounded" title="'+item_name+'" onclick="get_single_medicine_info('+i_code+')">';
					
					price_date_time = '<div class="col-sm-12 col-12 cart_ptr">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+ptr+'/- | Total: <i class="fa fa-inr" aria-hidden="true"></i>'+total+'/-</div><div class="col-sm-12 col-12 text_cut_or_dot cart_date_time">'+date_time+'</div>'

					$(".load_page").append('<li class="list_item_radius"><div class="row"><div class="col-sm-2 col-3">'+image_+'</div><div class="col-sm-10 col-9"><div class="row"><div class="col-sm-12 col-12 text-capitalize cart_title" title="'+item_name+'" style="cursor: pointer;" onclick="get_single_medicine_info('+i_code+')">'+item_name+'<span class="cart_packing"> ('+item.packing+' Packing)</span></div><div class="col-sm-12 col-12 cart_expiry">Expiry : '+item.expiry+'</div><div class="col-sm-12 col-12 cart_company">By : '+item.company_full_name+'</div><div class="col-sm-12 col-12 cart_stock" title="'+item_name+' Order Quantity : '+item.qty+'">Order Quantity : '+item.qty+'</div><div class="mobile_off">'+price_date_time+'</div></div></div><div class="mobile_show">'+price_date_time+'</div></div></li>');
					//$(".lastid1").val(item.lastid1);
					if(item.sec_row!="")
					{
						//$(".load_more").show();
					}
				}
			});	
		},
		//timeout: 10000
	});
}
</script>