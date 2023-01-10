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
$(".headertitle").html("Loading....");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 text-right" style="margin-bottom:5px;display:none;">
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/sortline.png" width="25px;" onclick="show_sorting_div();" class="showbtn" alt>
					<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/sortline.png" width="25px;" onclick="hide_sorting_div();" class="showbtn1" style="display:none;" alt>
				</div>
				<div class="col-sm-12 sorting_div text-right" style="margin-bottom:5px;display:none;">
					<span class="sort_atoz" onclick="sort_atoz();">Name A to Z |</span>
					<span class="sort_ztoa" onclick="sort_ztoa();" style="display:none;">Name Z to A |</span>
					<span class="sort_price" onclick="sort_price();">Price Low to High | </span>
					<span class="sort_price1" onclick="sort_price1();" style="display:none;">Price High to Low | </span>
					<span class="sort_margin" onclick="sort_margin();">Margin Low to High</span>
					<span class="sort_margin1" onclick="sort_margin1();" style="display:none;">Margin High to Low</span>
				</div>
			</div>
			<div class="row load_page"></div>
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
			data       :  { item_page_type:'<?= $item_page_type; ?>',item_code:'<?= $item_code; ?>',item_division:'<?= $item_division; ?>',get_record:get_record} ,
			url        : "<?php echo base_url(); ?>Chemist_json/medicine_category_api",
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
						//$(".load_page").html("");
					}
				}
				else
				{
					$(".load_page_loading").html("");
				}
				$.each(data.items, function(i,item){
					if (item){
						item_code			= item.item_code;
						item_image			= item.item_image;
						item_name 			= item.item_name;
						item_packing 		= item.item_packing;
						item_expiry 		= item.item_expiry;
						item_company 		= item.item_company;
						item_quantity 		= item.item_quantity;
						item_stock 			= item.item_stock;
						item_ptr 			= item.item_ptr;
						item_mrp 			= item.item_mrp;
						item_price 			= item.item_price;
						item_scheme 		= item.item_scheme;
						item_margin 		= item.item_margin;
						item_featured 		= item.item_featured;
						get_record			= item.get_record;

						item_scheme_div = "";
						if(item_scheme!="0+0")
						{
							item_scheme_div =  ' | <span class="medicine_cart_item_scheme">Scheme : '+item_scheme+'</span>';
						}

						item_other_image_div = '';
						if(item_featured=="1" && item_quantity!="0"){
							item_other_image_div = '<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featured_img.png" class="medicine_cart_item_featured_img">';
						}

						item_quantity_div = '<span class="medicine_cart_item_out_of_stock">Out of stock</span>';
						if(item_quantity=="0"){
							item_other_image_div = '<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/out_of_stock_img.png" class="medicine_cart_item_out_of_stock_img">';
						} 
						else 
						{
							item_quantity_div = '<span class="medicine_cart_item_stock">Stock : '+item_quantity+'</span>' + item_scheme_div;
							if(item_stock!="")
							{
								item_quantity_div = '<span class="medicine_cart_item_stock">'+item_stock+'</span>' + item_scheme_div;
							}
						}

						error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'"

						item_image_div = item_other_image_div+'<img src="'+item_image+'" class="medicine_cart_item_image" '+error_img+'>';
						
						rete_div =  '<div class="medicine_cart_item_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+item_ptr+'/- </div><div class="medicine_cart_item_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+item_mrp+'/- </div><div class="medicine_cart_item_price"> *Approximate ~ : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/- </div>';
						
						$(".load_page").append('<div class="col-sm-3 col-6 p-0 m-0 text-center"><div class="featured_brand_div" onClick="get_single_medicine_info('+item_code+')" style="cursor: pointer;" title="'+item_name+'">'+item_image_div+'<div class="medicine_cart_item_name">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class="medicine_cart_item_company">By '+item_company+'</div>'+rete_div+'</div></div>');

						$(".headertitle").html(item.item_header_title);

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
<script>
function show_sorting_div()
{
	$(".showbtn").hide();	
	$(".showbtn1").show();
	$(".sorting_div").show();
}
function hide_sorting_div()
{
	$(".showbtn").show();	
	$(".showbtn1").hide();
	$(".sorting_div").hide();
}

function sort_atoz()
{
	$(".sort_atoz").hide();
	$(".sort_ztoa").show();	
	hide_sorting_div();
	call_page("sort_atoz");
}
function sort_ztoa()
{	
	$(".sort_atoz").show();
	$(".sort_ztoa").hide();
	hide_sorting_div();
	call_page("sort_ztoa");
}
function sort_price()
{
	$(".sort_price").hide();
	$(".sort_price1").show();	
	hide_sorting_div();
	call_page("sort_price");
}
function sort_price1()
{	
	$(".sort_price").show();
	$(".sort_price1").hide();
	hide_sorting_div();
	call_page("sort_price1");
}
function sort_margin()
{
	$(".sort_margin").hide();
	$(".sort_margin1").show();	
	hide_sorting_div();
	call_page("sort_margin");
}
function sort_margin1()
{	
	$(".sort_margin").show();
	$(".sort_margin1").hide();
	hide_sorting_div();
	call_page("sort_margin1");
}
</script>