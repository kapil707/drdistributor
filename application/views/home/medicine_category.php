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
$(".headertitle").html("<?= $company_full_name; ?>");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 text-right" style="margin-bottom:5px;">
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
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
			</div>
		</div>
	</div>     
</div>
<input type="hidden" class="lastid1">
<script>
$(document).ready(function(){
	call_page("not");
});
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page("not")
}
function call_page(orderby1)
{
	$(".load_page").html("");
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  { itemcat:'<?= $itemcat; ?>',orderby:orderby1} ,
		url        : "<?php echo base_url(); ?>Chemist_json/medicine_category_api",
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
					i_code				= item.i_code;			
					item_name 			= item.item_name;
					company_full_name 	= item.company_full_name;
					image 				= item.image;
					packing 			= item.packing;
					mrp 				= item.mrp;
					ptr					= item.sale_rate;
					sale_rate 			= item.sale_rate;
					batchqty 			= item.batchqty;
					scheme 				= item.scheme;
					batch_no 			= item.batch_no;
					expiry 				= item.expiry;
					med_date_time 		= item.med_date_time;
					featured 			= item.featured;
					margin 				= item.margin;
					
					image1 = '<img src="'+image+'" class="img-fluid img-responsive" style="border-radius: 5px;">';
					if(featured=="1"){
						image1 = '<img src="'+image+'" class="img-fluid img-responsive" style="border-radius: 5px;"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/featuredicon.png" class="category_page_featurediconcss">';
					}
					
					if(batchqty==0)
					{
						image1 = '<img src="'+image+'" class="img-fluid img-responsive" style="border-radius: 5px;"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/outofstockicon.png" class="category_page_outofstockiconcss">';
					}
					
					$(".load_page").append('<div class="col-sm-3 col-6 p-0 m-0 text-center"><div style="margin-left:7px;margin-left:7px;margin-bottom:7px;padding: 10px;border-radius: 10px;background:#ffffff;" onClick="get_single_medicine_info('+i_code+')" style="cursor: pointer;" title="'+item_name+'">'+image1+'<div class="text-left text-capitalize category_page_title">'+item_name+' <span class="category_page_packing">('+packing+' Packing)</span></div><div class="category_page_margin_icon text-left"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt> </div><div class="category_page_margin">'+margin+'% Margin</div><div class="text-left text-capitalize category_page_company">By '+company_full_name+'</div><div class="text-left category_page_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/-</div><div class="text-left category_page_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+ptr+'/-</div><div class="text-left category_page_final_price">~Price : <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/-</div></div></div>');
				}
			});
		},
		timeout: 10000
	});
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