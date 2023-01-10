<style>
.menubtn1
{
	display:none;
}
@media screen and (max-width: 767px) {
	.search_pg_menu_off,.main_home_top_btn
	{
		display:none;
	}
	.current_order_search_page,.delete_btn_icon
	{
		display: block !important;
	}
}
.deleteicon
{
	display: initial !important;
}
.home_page_search_div_box,.select_medicine
{
	display: inline-block;
}
.select_chemist,.home_page_search_div,.search_medicine_result,.clear_search_icon
{
	display: none;
}
.headertitle
{
	margin-top: 5px;
}
</style>
<?php if(!empty($chemist_id)){ ?>
<style>
.headertitle
{
	margin-top: -5px;
}
</style>
<script>
$(".headertitle1").show();
</script>
<?php } ?>
<script>
$(".headertitle").html("Search medicines");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-6 col-12 mobile_off" style="margin-bottom:5px;">
			<span class="text-left">
				<h6 class="search_pg_title_color">Favourite medicines</h6>
			</span>
		</div>
		<div class="col-sm-3 col-12 mobile_off" style="margin-bottom:5px;">
			<h6 class="search_pg_title_color" onclick="current_order_ref()">Current order <span class="div_cart_total_items1"></span></h6>
		</div>
		<div class="col-sm-3 col-12 mobile_off text-right" style="margin-bottom:5px;">
			<a href="#" onclick="delete_all_medicine()" tabindex="-10" class="cart_delete_btn delete_all_btn" title="Delete all medicines"> <img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete all medicines" title="Delete all medicines"> Delete all medicines</a>
		</div>
		
		<div class="col-sm-6 col-12 mobile_off">
			<div class="fix_box_in_search_page searchpagescrolling1">
				<div class="favourite_medicines_search_pg_div fix_box_in_search_page_under">
					<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6 col-12 border_off_mobile">
			<div class="fix_box_in_search_page searchpagescrolling1">
				<div class="medicine_cart_list_div fix_box_in_search_page_under">
					<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="view_cart_or_empty_cart_btn_div">
	<div class="container">
		<div class="row">
			<div class="col-5 text-center">				
				<div class="div_cart_total_items">0 items</div>
				<div class="div_cart_total_price"><i class="fa fa-inr"></i>0.00</div>
			</div>
			<div class="col-7 text-center">
				<span class="cart_empty_cart_div">
					<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn btn-primary btn-block mainbutton_disable" onclick="cart_empty_btn()" tabindex="-3" title="Cart Is Empty">Cart is empty</button>
				</span>
				<span class="cart_add_to_cart_div" style="display:none">
					<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn btn-primary btn-block mainbutton" onclick="view_cart_btn()" tabindex="-3" title="View cart">View cart</button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="background_blur" onclick="clear_search_icon()" style="display:none"></div>
<script type="text/javascript">
function current_order_ref()
{
	page_load();
}
favourite_medicines_search_pg();
function page_load()
{
	$(".search_medicine_result").hide();
	$('.homepgsearch_w').hide();
	$('.search_textbox').focus();
	medicine_cart_list();
}
function clear_search_icon()
{
	$(".search_medicine_result").html("");
	$(".search_medicine_result").hide();

	$(".search_textbox").val("");
	$('.search_textbox').focus();

	$(".clear_search_icon").hide();	
	$(".background_blur").hide();

	$(".search_pg_current_order").show();
	$(".search_pg_result_found").hide();
}

function medicine_details_funcation(item_code)
{	
	$(".medicine_details_item_order_quantity_textbox").val("");
	$(".medicine_details_item_order_quantity_textbox").focus();
	
	medicine_details_get(item_code);
	setTimeout(medicine_details_api(item_code),500);// its on header page

	$('.search_textbox').val("");
	$(".search_medicine_result").html("");
	$(".myModal_medicine_details").click();	
}

function medicine_details_get(item_code)
{	
	item_image = $(".medicine_details_all_data_"+item_code).attr("item_image")
	item_name = $(".medicine_details_all_data_"+item_code).attr("item_name")
	item_packing = $(".medicine_details_all_data_"+item_code).attr("item_packing")
	item_expiry = $(".medicine_details_all_data_"+item_code).attr("item_expiry")
	item_company = $(".medicine_details_all_data_"+item_code).attr("item_company")
	item_quantity = $(".medicine_details_all_data_"+item_code).attr("item_quantity")
	item_stock = $(".medicine_details_all_data_"+item_code).attr("item_stock")
	item_ptr = $(".medicine_details_all_data_"+item_code).attr("item_ptr")
	item_mrp = $(".medicine_details_all_data_"+item_code).attr("item_mrp")
	item_price = $(".medicine_details_all_data_"+item_code).attr("item_price")
	item_scheme = $(".medicine_details_all_data_"+item_code).attr("item_scheme")
	item_margin = $(".medicine_details_all_data_"+item_code).attr("item_margin")
	item_featured = $(".medicine_details_all_data_"+item_code).attr("item_featured")
	item_description1 = $(".medicine_details_all_data_"+item_code).attr("item_description1")
	
	item_date_time = item_batch_no = item_gst = item_description2 = "";
	$(".medicine_details_item_date_time").html("Loading....")
	$(".medicine_details_item_batch_no").html("")
	$(".medicine_details_item_gst").html("")
	$(".medicine_details_item_description2").html("")

	medicine_details_api_data(item_code) // its on header page
}

$(document).ready(function(){	
	$(".search_textbox").keyup(function(e){
		if(e.keyCode == 8)
		{
			var keyword = $(".search_textbox").val();
			if(keyword!="")
			{
				if(keyword.length<3)
				{
					$('.search_textbox').focus();
					$(".search_medicine_result").html("");
				}
			}
			else{
				clear_search_icon();
			}
		}
	})  
	$(".search_textbox").keypress(function() { 
		var keyword = $(".search_textbox").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.search_textbox').focus();
				$(".search_medicine_result").html("");
			}
			if(keyword.length>2)
			{
				setTimeout('medicine_search_api();',500);
			}
		}
		else{
			clear_search_icon();
		}
	});
	$(".search_textbox").change(function() { 
	});
	$(".search_textbox").on("search", function() { 
	});
	
    $(".search_textbox").keydown(function(event) {
    	if(event.key=="ArrowDown")
    	{
			page_up_down_arrow("1");
    		$('.hover_1').attr("tabindex",-1).focus();
			return false;
    	}
    });
	setTimeout('page_load();',100);
	
	document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 27) {
			clear_search_icon();
		}
	};
});

function page_up_down_arrow(new_i)
{
	$('.hover_'+new_i).keypress(function (e) {
		 if (e.which == 13) {
			$('.medicine_details_funcation_'+new_i).click();
		 } 						 
	 });
	$('.hover_'+new_i).keydown(function(event) {
		if(event.key=="ArrowDown")
		{
			new_i = parseInt(new_i) + 1;
			page_up_down_arrow(new_i);
			$('.hover_'+new_i).attr("tabindex",-1).focus();
			return false;
		}
		if(event.key=="ArrowUp")
		{
			if(parseInt(new_i)==1)
			{
				var searchInput = $('.search_textbox');
				var strLength = searchInput.val().length * 2;

				searchInput.focus();
				searchInput[0].setSelectionRange(strLength, strLength);
			}
			else
			{
				new_i = parseInt(new_i) - 1;
				page_up_down_arrow(new_i);
				$('.hover_'+new_i).attr("tabindex",-1).focus();
			}
			return false;
		}
	});
}

function cart_empty_btn()
{
	swal("Cart is empty");
}
function view_cart_btn()
{
	window.location.href= "<?= base_url() ?>home/draft_order_list";
}

function medicine_search_api()
{
	$(".search_pg_current_order").hide();
	$(".search_pg_result_found").show();
	new_i = 0;
	$(".clear_search_icon").show();
	var keyword = $(".search_textbox").val();
	if(keyword!="")
	{
		if(keyword=="#")
		{
			keyword = "k1k2k12k";
		}
		if(keyword.length>1)
		{
			$(".background_blur").show();
			$(".search_medicine_result").show();
			$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
			$(".header_result_found").html("Loading....");
			$.ajax({
			type       : "POST",
			data       :  {keyword:keyword} ,
			url        : "<?php echo base_url(); ?>Chemist_json/medicine_search_api",
			cache	   : true,
			error: function(){
				$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
				$(".header_result_found").html("No record found");
			},
			success    : function(data){
				if(data.items=="")
				{
					$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></h1></div></div>');
					$(".header_result_found").html("No record found");
				}
				else
				{
					$(".search_medicine_result").html("");
					$(".header_result_found").html("Found result");
				}
				$.each(data.items, function(i,item){
						if (item)
						{
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
							item_description1 	= item.item_description1;
							similar_items 		= item.similar_items;
							new_i				= item.count;

							//new_i = parseInt(new_i) + 1;
							csshover1 = 'hover_'+new_i;

							div_all_data = "<div class='medicine_details_all_data_"+item_code+"' item_image='"+item_image+"' item_name='"+item_name+"' item_packing='"+item_packing+"' item_expiry='"+item_expiry+"' item_company='"+item_company+"' item_quantity='"+item_quantity+"' item_stock='"+item_stock+"' item_ptr='"+item_ptr+"' item_mrp='"+item_mrp+"' item_price='"+item_price+"' item_scheme='"+item_scheme+"' item_margin='"+item_margin+"' item_featured='"+item_featured+"' item_description1='"+item_description1+"' similar_items='"+similar_items+"'></div>"

							div_start = 'onClick=medicine_details_funcation("'+item_code+'"),clear_search_icon()';
							
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
							
							rete_div =  '<span class="medicine_cart_item_ptr" title="PTR : Rs. '+item_ptr+'">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+item_ptr+'/- </span> | <span class="medicine_cart_item_mrp" title="MRP : Rs. '+item_mrp+'">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+item_mrp+'/- </span> | <span class="medicine_cart_item_price" title="*Approximate ~ Rs. '+item_price+'">*Approximate ~ : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/- </span>';							

							$(".search_medicine_result").append('<div class="main_theme_li_bg '+csshover1+' medicine_details_funcation_'+new_i+'" '+div_start+'><div class="medicine_search_div1">'+item_image_div+'</div><div class="medicine_search_div2"><div class="medicine_cart_item_name">'+item_name+'<span class="medicine_cart_item_packing mobile_off"> ('+item_packing+' Packing)</span></div><div class="medicine_cart_item_packing mobile_show">'+item_packing+' Packing</div><div class=""><span class="medicine_cart_item_margin">'+item_margin+'% Margin </span>| <span class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</span></div><div class="medicine_cart_item_company">By '+item_company+'</div><div>'+item_quantity_div+'</div><div class="mobile_off">'+rete_div+'</div></div><div class="medicine_search_full_width mobile_show" style="margin-left:5px;">'+rete_div+'</div><div class="medicine_search_full_width medicine_cart_item_description1">'+item_description1+'</div><div class="medicine_search_full_width medicine_cart_item_similar_items"><a href="<?= base_url();?>home/medicine_category/medicine_similar/'+item_code+'">'+similar_items+'</a></div></div>'+div_all_data);
				
							$(".search_pg_result_found").html("Search result");	
							
							if(new_i=="50")
							{
								$(".search_medicine_result").append('<div style="color: green;font-weight: bold;margin: 10px" class="text-center"><a href="<?= base_url();; ?>/home/search_view_all?keyword='+keyword+'">View All</a></div>');
							}
						}						
					});
				},
				timeout: 60000
			});
		}
		else{
			$(".clear_search_icon").hide();
			$(".search_medicine_result").html("");
		}
	}
}
/*****************************************/
function medicine_cart_list()
{
	$(".header_result_found").html("Loading....");
	$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	id = "";
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_json/my_cart_api",
		type:"POST",
		cache: true,
		data: {id:id},
		error: function(){
			$(".medicine_cart_list_div").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success: function(data){
			if(data.items=="")
			{
				$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/cartempty.png" width="80%"></center></h1>');
				$(".delete_all_btn").hide();
			}
			else
			{
				$(".medicine_cart_list_div").html("");
				$(".delete_all_btn").show();
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
					item_margin 		= item.item_margin;
					item_featured 		= item.item_featured;
					item_price 			= item.item_price;
					item_quantity_price = item.item_quantity_price;
					item_datetime 		= item.item_datetime;
					item_modalnumber 	= item.item_modalnumber;

					error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'"

					item_other_image_div = '';
					if(item_featured=="1"){
						item_other_image_div = '<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featured_img.png" class="medicine_cart_item_featured_img">';
					}
					
					image_div = item_other_image_div+'<img src="'+item_image+'" style="width: 100%;cursor: pointer;" class="medicine_cart_item_image" onclick="get_single_medicine_info('+item_code+')" '+error_img+'>';
					
					item_scheme_div = "";
					if(item_scheme!="0+0")
					{
						item_scheme_div =  ' | <span class="medicine_cart_item_scheme" title="'+item_name+' '+item_scheme+'">Scheme : '+item_scheme+'</span>';
					}

					rate_div = '<div class="cart_ki_main_div3"><span class="medicine_cart_item_price2" title="*Approximate ~">*Approximate ~ : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/-</span> | <span class="medicine_cart_item_price">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item_quantity_price+'/-</span></div><div class="cart_ki_main_div3"><span class="medicine_cart_item_datetime">'+item_modalnumber+' | '+item_datetime+'</span><span style="float:right;"><a href="javascript:delete_medicine('+item_code+')" tabindex="-10" title="Delete '+item_name+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;margin-right:5px;"></a>&nbsp;<a href="javascript:get_single_medicine_info('+item_code+')" tabindex="-10" title="Edit '+item_name+'" class="edit_item_focues'+item_code+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;"></a>&nbsp;&nbsp;</div>';
					
					$(".medicine_cart_list_div").append('<div class="main_theme_li_bg"><div class="medicine_cart_small_div1">'+image_div+'</div><div class="medicine_cart_small_div2"><div class="medicine_cart_item_name" title="'+item_name+'" onclick="get_single_medicine_info('+item_code+')" style="cursor: pointer;">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class=""><span class="medicine_cart_item_margin">'+item_margin+'% Margin </span> | <span class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</span></div><div class="medicine_cart_item_company">By '+item_company+'</div><div class="text-left medicine_cart_item_order_quantity" title="'+item_name+' Quantity: '+item_quantity+'" >Order quantity : '+item_quantity+item_scheme_div+'</div><span class="mobile_off">'+rate_div+'</span></div><span class="mobile_show" style="margin-left:5px;">'+rate_div+'</span></div>');
				}
			});
			$.each(data.other_items, function(i,item){
				if (item)
				{
					items_price = item.items_price;
					items_total = item.items_total;
					place_order_button = item.place_order_button;
					place_order_message = item.place_order_message;
					$(".div_cart_total_price").html('<i class="fa fa-inr"></i> '+items_price+'/-');
					$(".div_cart_total_items").html(items_total+" items");
					$(".div_cart_total_items1").html("("+items_total+")");
					$(".header_cart_span").html(items_total);
					$(".place_order_message").html(place_order_message);
					$(".header_result_found").html("Current order ("+items_total+")");
					if(items_total==0)
					{
						$(".cart_empty_cart_div").show();
						$(".cart_add_to_cart_div").hide();
						$(".cart_disabled_cart_div").hide();
					}
					else
					{
						$(".cart_empty_cart_div").hide();
						$(".cart_add_to_cart_div").show();
						$(".cart_disabled_cart_div").show();
					}
				}
			});
		},
		timeout: 10000
	});
}
function delete_medicine(item_code)
{
	swal({
		title: "Are you sure to delete medicine?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) 
		{
			$.ajax({                          
				url: "<?php echo base_url(); ?>Chemist_json/delete_medicine_api",
				type:"POST",
				/*dataType: 'html',*/
				data:{item_code: item_code},
				error: function(){
					swal("Medicine not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.status=="1")
							{
								page_load();
								$(".item_focues"+item_code).html('')
								swal("Medicine deleted successfully", {
									icon: "success",
								});
							}
							else{
								swal("Medicine not deleted");
							}
						} 
					});
				},
				timeout: 10000
			});
		} else {
			swal("Medicine not deleted");
		}
	});
}
function delete_all_medicine()
{
	swal({
		title: "Are you sure to delete all medicines?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) 
		{
			id = "";
			$.ajax({                          
				url: "<?php echo base_url(); ?>Chemist_json/delete_all_medicine_api",
				type:"POST",
				/*dataType: 'html',*/
				data: {id:id},
				error: function(){
					swal("Medicines not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.status=="1")
							{
								page_load();
								swal("Medicines deleted successfully", {
									icon: "success",
								});
							}
							else{
								swal("Medicines not deleted");
							}
						} 
					});
				},
				timeout: 10000
			});
		} else {
			swal("Medicines not deleted");
		}
	});
}
function favourite_medicines_search_pg()
{
	$('.favourite_medicines_search_pg_div').html('');
	id = "";
	$.ajax({
		url: "<?php echo base_url(); ?>chemist_json/medicines_last_order_api",
		type:"POST",
		cache: true,
		data: {id:id},
		error: function(){
			$(".favourite_medicines_search_pg_div").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success: function(data){
			if(data.items=="")
			{
				$(".favourite_medicines_search_pg_div").html('');
			}
			else
			{
				$(".favourite_medicines_search_pg_div").html("");
			}
			$.each(data.items, function(i,item){
				if (item)
				{
					item_code 	= item.item_code;
					item_name 	= item.item_name;
					quantity 	= item.quantity;
					item_image  = item.item_image;

					error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'";
					
					$(".favourite_medicines_search_pg_div").append('<a href="javascript:void(0)" onClick="get_single_medicine_info('+item_code+')" style="text-decoration: none;"><div class="main_theme_li_bg"><div class="medicine_cart_small_div3"><img src="'+item_image+'" style="width: 100%;cursor: pointer;" class="medicine_cart_item_image" onclick="get_single_medicine_info('+item_code+')" '+error_img+'></div><div class="medicine_cart_small_div4"><div class="text-capitalize medicine_cart_item_name">'+item_name+'</div><div class="text-left medicine_cart_item_order_quantity">Last order quantity : '+quantity+'</div></div></div></a>');
				}
			});
		},
		timeout: 10000
	});
}
</script>