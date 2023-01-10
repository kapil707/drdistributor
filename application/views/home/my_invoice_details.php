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
	window.location.href = "<?= base_url();?>home/my_invoice";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-3 col-6 download_excel_url" style="margin-top:5px;margin-bottom:5px;">
					
		</div>
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
			</div>
			<span class="load_page"></span>
			<div class="col-sm-12 col-12 text-center div_item_delete" style="display:none" style="margin-top:5px;margin-bottom:5px;">
					<h4>Quantity changed and items deleted</h4>
				</div>
			<span class="load_page_delete"></span>
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
		data       : {item_id:item_id} ,
		url        : "<?php echo base_url(); ?>Chemist_json/my_invoice_details_api",
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
				if (item)
				{
					item_id 			= item.item_id;
					item_code 			= item.item_code;
					item_quantity 		= item.item_quantity;
					item_image 			= item.item_image;
					item_name 			= item.item_name;
					item_packing 		= item.item_packing;
					item_expiry			= item.item_expiry;
					item_company 		= item.item_company;
					item_scheme 		= item.item_scheme;
					item_price 			= item.item_price;
					item_quantity_price = item.item_quantity_price;
					item_date_time 		= item.item_date_time;
					item_modalnumber 	= item.item_modalnumber;
					
					error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'"
					
					image_div = '<img src="'+item_image+'" style="width: 100%;cursor: pointer;" class="medicine_cart_item_image" '+error_img+'>';
					
					item_scheme_div = "";
					if(item_scheme!="0+0")
					{
						item_scheme_div =  ' | <span class="medicine_cart_item_scheme" title="'+item_name+' '+item_scheme+'">Scheme : '+item_scheme+'</span>';
					}

					rate_div = '<div class="cart_ki_main_div3 medicine_cart_item_datetime">'+item_modalnumber+' | '+item_date_time+'</div><div class="cart_ki_main_div3"><span class="medicine_cart_item_price2">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/-</span> | <span class="medicine_cart_item_price">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item_quantity_price+'/-</span></div>';
					
					$(".load_page").append('<div class="main_theme_li_bg" onclick="get_single_medicine_info('+item_code+')" style="cursor: pointer;"><div class="medicine_cart_div1">'+image_div+'</div><div class="medicine_cart_div2"><div class="medicine_cart_item_name" title="'+item_name+'">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</div><div class="medicine_cart_item_company">By '+item_company+'</div><div class="text-left medicine_cart_item_order_quantity" title="'+item_name+' Quantity: '+item_quantity+'" >Order quantity : '+item_quantity+item_scheme_div+'</div><span class="mobile_off">'+rate_div+'</span></div><span class="mobile_show" style="margin-left:5px;">'+rate_div+'</span></div>');
				}
			});	

			$.each(data.delete_items, function(i,item){	
				if (item)
				{
					item_id 			= item.item_id;
					item_code 			= item.item_code;
					item_quantity 		= item.item_quantity;
					item_image 			= item.item_image;
					item_name 			= item.item_name;
					item_packing 		= item.item_packing;
					item_expiry			= item.item_expiry;
					item_company 		= item.item_company;
					item_scheme 		= item.item_scheme;
					item_price 			= item.item_price;
					item_quantity_price = item.item_quantity_price;
					item_date_time 		= item.item_date_time;
					item_modalnumber 	= item.item_modalnumber;
					item_description1	= item.item_description1;
					
					error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'"
					
					image_div = '<img src="'+item_image+'" style="width: 100%;cursor: pointer;" class="medicine_cart_item_image" '+error_img+'>';
					
					item_scheme_div = "";
					if(item_scheme!="0+0")
					{
						item_scheme_div =  ' | <span class="medicine_cart_item_scheme" title="'+item_name+' '+item_scheme+'">Scheme : '+item_scheme+'</span>';
					}

					rate_div = '<div class="cart_ki_main_div3 medicine_cart_item_datetime">'+item_modalnumber+' | '+item_date_time+'</div><div class="cart_ki_main_div3"><span class="medicine_cart_item_price2">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/-</span> | <span class="medicine_cart_item_price">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item_quantity_price+'/-</span></div>';
					
					$(".load_page_delete").append('<div class="main_theme_li_bg" onclick="get_single_medicine_info('+item_code+')" style="cursor: pointer;"><div class="medicine_cart_div1">'+image_div+'</div><div class="medicine_cart_div2"><div class="medicine_cart_item_name" title="'+item_name+'">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</div><div class="medicine_cart_item_company">By '+item_company+'</div><div class="text-left medicine_cart_item_order_quantity" title="'+item_name+' Quantity: '+item_quantity+'" >Order quantity : '+item_quantity+item_scheme_div+'</div><span class="mobile_off">'+rate_div+'</span></div><span class="mobile_show" style="margin-left:5px;">'+rate_div+'</span><div class="cart_ki_main_div3 medicine_cart_item_description1">'+item_description1+'</div></div>');

					$(".div_item_delete").show();
				}
			});	

			$.each(data.download_url, function(i,item){	
				if (item)
				{
					$(".download_excel_url").html("<a href="+item.download_url+"><button type='button' class='btn btn-warning btn-block'>Download Excel</button></a>");
				}
			});	

			$.each(data.header_title, function(i,item){	
				if (item)
				{
					$(".headertitle").html(item.header_title);
				}
			});	
		},
		//timeout: 10000
	});
}
</script>