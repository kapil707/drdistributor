<input type="hidden" value="<?php echo $chemist_id ?>" class="chemist_id" id="chemist_id">
<style>
.menubtn1
{
	display:none;
}
@media screen and (max-width: 767px) {
	.website_menu,.current_order_search_page1,.homebtn_div
	{
		display:none;
	}
	.current_order_search_page,.deletebtn_div
	{
		display: block !important;
	}
	<?php if($chemist_id!=""){ ?>
		.headertitle
		{
			display:none;
		}
		.headertitle1
		{
			display: block !important;
		}
		.header_part_search_page_chemist_name
		{
			display: inline-block !important;
		}
	<?php } ?>
}
.deleteicon
{
	display: initial !important;
}
.headertitle
{
    margin-top: 5px !important;
}
.SearchMedicine_search_box_div
{
	display: inline-block;
}
.select_chemist,.homepagesearchdiv,.search_medicine_result
{
	display: none;
}
</style>
<script>
$(".headertitle").html("Search medicines");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<?php if($chemist_id!=""){ ?>
<script>
$(".headertitle1").html("Search medicines<br><?php echo $chemist_name; ?>");
$(".header_part_search_page_chemist_name").html('&nbsp; | Code : <?php echo $chemist_id; ?> | <a href="<?= base_url(); ?>import_order/select_chemist" style="color:gray" title="Change Chemist"><img class="img-circle" src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon_w.png" width="15" alt="Change Chemist" title="Change Chemist"></a>');
</script>
<?php } ?>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-7 col-12">
			<span class="search_medicine_result searchpagescrolling2"></span>
		</div>
		<div class="col-sm-2"></div>
		<?php if($chemist_id!=""){ ?>
			<div class="col-sm-12 mobile_off" style="margin-top:-20px;">
				<li class="list_item_radius">
					<div class="row">
						<div class="col-sm-1 col-3">
							<img src="<?= $chemist_image ?>" alt="" title="" class="rounded account_page_header_image">
						</div>
						<div class="col-sm-11 col-9 text-left">
							<span class="select_chemist_name">
								<?php echo $chemist_name; ?>
							</span>
							<br>
							<span class="select_chemist_code">
								Code : <?php echo $chemist_id; ?>
							</span>
							<br>
							<a href="<?= base_url(); ?>home/select_chemist" style="color:gray" title="Change Chemist">
							<img class="img-circle" src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="15" alt="Change Chemist" title="Change Chemist"> Change chemist</a>
						</div>
					</div>
				</li>
			</div>
		<?php } ?>
		<div class="col-sm-6 col-12 mobile_off" style="margin-bottom:5px;">
			<span class="text-left">
				<h6 class="search_pg_title_color">Favourite medicines</h6>
			</span>
		</div>
		<div class="col-sm-4 col-12 mobile_off" style="margin-bottom:5px;">
			<h6 class="search_pg_title_color" onclick="current_order_ref()">Current order <span class="mycartwalidiv1"></span></h6>
		</div>
		<div class="col-sm-2 col-12 mobile_off text-right" style="margin-bottom:5px;">
			<a href="#" onclick="delete_all_medicine()" tabindex="-10" class="delete_all delete_all_btn" title="Delete all"> <img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete all" title="Delete all"> Delete all </a>
		</div>
		
		<div class="col-sm-6 col-12 mobile_off">
			<div class="fix_box_in_search_page searchpagescrolling3 border1" style="width:100%;float:left;">
				<span class="user_top_order_div">
				<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>
				</span>
			</div>
		</div>
		
		<div class="col-sm-6 col-12 border_off_mobile">
			<div class="fix_box_in_search_page searchpagescrolling1 border1" style="width:100%;float:left;">
				<span class="medicine_cart_list_div">
				<h1 class="text-center"><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading...."></h1><h1 class="text-center">Loading....</h1>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="view_cart_or_empty_cart_btn_div">
	<p class="text-center">Loading....</p>
</div>
<div class="background_blur" onclick="clear_search_box()" style="display:none"></div>
<script type="text/javascript">
function current_order_ref()
{
	page_load();
}
user_top_order();
function page_load()
{
	$(".search_medicine_result").hide();
	$('.SearchMedicine_search_box_div').show();
	$('.homepgsearch_w').hide();
	$('.SearchMedicine_search_box').focus();
	view_cart_or_empty_cart_btn();
	medicine_cart_list();
	count_temp_rec();
}
function clear_search_box()
{
	$(".search_medicine_result").html("");
	$(".SearchMedicine_search_box").val("");
	$('.SearchMedicine_search_box').focus();
	$(".clear_search_box").hide();
	$(".search_medicine_result").hide();	
	$(".background_blur").hide();
	$(".search_pg_current_order").show();
	$(".search_pg_result_found").hide();
}
$(document).ready(function(){	
	$(".SearchMedicine_search_box").keyup(function() { 
		var keyword = $(".SearchMedicine_search_box").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.SearchMedicine_search_box').focus();
				$(".search_medicine_result").html("");
			}
			setTimeout('search_medicine();',500);
		}
		else{
			clear_search_box();
		}
	});
	$(".SearchMedicine_search_box").change(function() { 
	});
	$(".SearchMedicine_search_box").on("search", function() { 
	});
	
    $(".SearchMedicine_search_box").keydown(function(event) {
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
			clear_search_box();
		}
	};
});

function search_medicine()
{
	$(".search_pg_current_order").hide();
	$(".search_pg_result_found").show();
	new_i = 0;
	$(".clear_search_box").show();
	var keyword = $(".SearchMedicine_search_box").val();
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
			$(".search_pg_result_found").html("Loading....");
			$.ajax({
			type       : "POST",
			data       :  {keyword:keyword} ,
			url        : "<?php echo base_url(); ?>Chemist_medicine/search_medicine_api",
			cache	   : true,
			error: function(){
				$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
				$(".search_pg_result_found").html("No Result Found");
			},
			success    : function(data){
				if(data.items=="")
				{
					$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></h1></div></div>');
					$(".search_pg_result_found").html("No Result Found");
				}
				else
				{
					$(".search_medicine_result").html("");
				}
				$.each(data.items, function(i,item){
						if (item)
						{
							//count_i			= item.count;
							//new_i				= parseInt(item.i);
							date_time			= item.date_time;
							i_code				= item.i_code;			
							item_name 			= item.item_name;
							company_full_name 	= item.company_full_name;
							image1 				= item.image1;
							image2 				= item.image2;
							image3 				= item.image3;
							image4 				= item.image4;
							description1 		= item.description1;
							description2 		= item.description2;
							batchqty 			= item.batchqty;
							sale_rate 			= item.sale_rate;
							mrp 				= item.mrp;
							final_price 		= item.final_price;
							batch_no 			= item.batch_no;
							packing 			= item.packing;
							expiry 				= item.expiry;
							scheme 				= item.scheme;
							margin 				= item.margin;
							featured 			= item.featured;
							gstper 				= item.gstper;
							discount          	= item.discount;
							misc_settings      	= item.misc_settings;
							itemjoinid         	= item.itemjoinid;
							items1				= item.items1;
							
							/*itemjoinid          = "";
							items1				= "";*/
							
							item_name_1 = item_name.charAt(0);
							
							if(item_name_1==".")
							{
							}
							else
							{							
								new_i = parseInt(new_i) + 1;
								smilerproduct = '';
								if(itemjoinid!="")
								{
									arr = itemjoinid.split(',');
									smilerproductcount  = arr.length;
									
									smilerproduct_i_code   	= items1[0].i_code;
									smilerproduct_data 		= items1[0].item_name+" | MRP. "+items1[0].mrp+" | "+items1[0].margin+" % Margin";
									
									smilerproduct ='<div class="row" style="border-top: 1px solid #1084a1;margin-top: -1px;font-size: 13px;padding:5px;"><div class="col-sm-12 col-12 spansmilerproduct_text">'+smilerproduct_data+'</div><div class="col-sm-12 col-12"><a href="#" onClick=javascript:open_model_smilerproduct('+smilerproduct_i_code+');><div class="spansmilerproduct">View all '+smilerproductcount+' Similar Items<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/next1.png" width=16px></div></a></div></div>';
								}
								
								outofstockicon = '';
								if(batchqty=="0"){
									batchqty1 = '<span class="main_search_out_of_stock">Out of stock</span>';
									outofstockicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/outofstockicon.png" class="main_search_outofstockiconcss">';
								} 
								else 
								{
									batchqty1 = '<span class="main_search_stock">Stock : '+batchqty+'</span>';
									
									if(misc_settings=="#NRX")
									{
										if(parseInt(batchqty)>10)
										{
											batchqty1 = '<span class="main_search_stock">Available</span>';
										}
									}
								}
								
								featuredicon = '';
								if(featured=="1" && batchqty!="0"){
									featuredicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/featuredicon.png" class="main_search_featurediconcss">';
								}
								
								li_css = "";
								if(new_i%2==0) 
								{ 
									li_css = "search_page_gray"; 
								} 
								else 
								{  
									li_css = "search_page_gray1"; 
								}
								
								csshover1 = 'hover_'+new_i;
								
								your_order_qty = "";
								
								item_name_m 		= btoa(item_name);
								company_full_name_m = btoa(company_full_name);
								image_m1 	 		= btoa(image1);
								image_m2 	 		= btoa(image2);
								image_m3 	 		= btoa(image3);
								image_m4 	 		= btoa(image4);
								description1_m 	 	= btoa(description1);
								description2_m 	 	= btoa(description2);
								packing_m 			= btoa(packing);
								expiry_m  			= btoa(expiry);
								batch_no_m			= btoa(batch_no);
								scheme_m  			= btoa(scheme);
								date_time_m  		= btoa(date_time);
								items1				= JSON.stringify(items1);
								items1 	 			= btoa(items1);
								
								li_start = '<li class="search_page_hover '+li_css+' '+csshover1+'"><a href="#" onClick=get_single_medicine_info_search_page("'+i_code+'","'+item_name_m+'","'+company_full_name_m+'","'+image_m1+'","'+image_m2+'","'+image_m3+'","'+image_m4+'","'+description1_m+'","'+description2_m+'","'+batchqty+'","'+sale_rate+'","'+mrp+'","'+final_price+'","'+batch_no_m+'","'+packing_m+'","'+expiry_m+'","'+scheme_m+'","'+margin+'","'+featured+'","'+gstper+'","'+discount+'","'+itemjoinid+'","'+items1+'","'+date_time_m+'","'+your_order_qty+'","'+misc_settings+'"),clear_search_box(); class="search_page_hover_a get_single_medicine_info_'+new_i+'">';
								
								image_ = '<img src="'+image1+'" style="width: 100%;" class="border rounded">'+featuredicon+outofstockicon;
								
								scheme_show_hide = "";
								if(scheme=="0+0")
								{
									scheme =  'No scheme';
									scheme_show_hide = "display:none"
								}
								else
								{
									scheme =  'Scheme : '+scheme;
								}
								
								scheme_or_margin =  '<div class="row"><div class="col-sm-6 col-6"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/scheme.png" class="main_search_scheme_icon" style="'+scheme_show_hide+'"><span class="main_search_scheme" style="'+scheme_show_hide+'">'+scheme+'</span></div><div class="col-sm-6 col-6 text-right"><span class="main_search_margin">'+margin+'% Margin</span><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/ribbonicon.png" class="main_search_margin_icon"></div></div>';
								
								rete_div =  '<span class="cart_ptr">PTR: <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/- </span> | <span class="cart_ptr">MRP: <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/- </span> | <span class="cart_landing_price"> ~ <span class="mobile_off">Landing</span> Price: <i class="fa fa-inr" aria-hidden="true"></i> '+final_price+'/- </span>';
								
								sale_rate 	= parseFloat(sale_rate).toFixed(2);
								mrp 		= parseFloat(mrp).toFixed(2);
								final_price = parseFloat(final_price).toFixed(2);
								
								$(".search_medicine_result").append(li_start+'<div class="row"><div class="col-sm-3 col-4">'+image_+'</div><div class="col-sm-9 col-8"><div class="cart_title">'+item_name+'<span class="cart_packing"> ('+packing+' Packing)</span> </div><div class="cart_expiry">Expiry : '+expiry+'</div><span class="cart_description1">'+description1+'</span><div class="cart_company">By '+company_full_name+'</div><div class="cart_stock">'+batchqty1+'</div><div class="mobile_off">'+scheme_or_margin+'</div><div class="mobile_off">'+rete_div+'</div></div><div class="mobile_show col-sm-12 col-12">'+scheme_or_margin+'</div><div class="mobile_show col-sm-12 col-12">'+rete_div+'</div></div></li>'+smilerproduct);
								
								$(".search_pg_result_found").html("Search result");		
							}						
						}
					});
				},
				timeout: 60000
			});
		}
		else{
			$(".clear_search_box").hide();
			$(".search_medicine_result").html("");
		}
	}
}


function get_single_medicine_info_search_page(i_code,item_name,company_full_name,image1,image2,image3,image4,description1,description2,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,items1,date_time,your_order_qty,misc_settings)
{	
	$(".MedicineDetailscssmod").html("Medicine details");
	$('.myModal_loading').click();
	$('.SearchMedicine_search_box').val("");
	$(".search_medicine_result").html("");
	$(".MedicineSmilerProduct").html("");
	$(".MedicineDetailsData").html("");
	
	MedicineDetails = MedicineDetails_modal(i_code,item_name,company_full_name,image1,image2,image3,image4,description1,description2,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,date_time,your_order_qty,misc_settings);
	$('.MedicineDetailsData').html(MedicineDetails);
	
	setTimeout('model_quantity_focus('+i_code+');',100);
	
	if(itemjoinid!="")
	{
		MedicineSmilerProduct_data = MedicineSmilerProduct_fun(items1,'1');
		$(".MedicineSmilerProduct").html(MedicineSmilerProduct_data);
	}
}

function page_up_down_arrow(new_i)
{
	$('.hover_'+new_i).keypress(function (e) {
		 if (e.which == 13) {
			$('.get_single_medicine_info_'+new_i).click();
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
				$('.SearchMedicine_search_box').focus();
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
 
function view_cart_or_empty_cart_btn()
{
	chemist_id = $(".chemist_id").val();
	$('.save_order').hide();
	$('.save_draft').hide();
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/view_cart_or_empty_cart_btn",
		type:"POST",
		dataType: 'html',
		data: {chemist_id:chemist_id},
		error: function(){
			$(".view_cart_or_empty_cart_btn_div").html('');
		},
		success: function(data){
			$('.view_cart_or_empty_cart_btn_div').html(data);
		},
		timeout: 10000
	});
}

function cart_empty_btn()
{
	swal("Cart Is Empty");
}
function view_cart_btn()
{
	window.location.href= "<?= base_url() ?>home/draft_order_list";
}
/*****************************************/
function medicine_cart_list()
{
	mcl_i = 0;
	$('.medicine_cart_list_div').html('');
	chemist_id = "<?=$chemist_id?>";
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/medicine_cart_list_api",
		type:"POST",
		cache: true,
		data: {chemist_id:chemist_id},
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
					id 			= item.id;
					i_code 		= item.i_code;
					item_name 	= item.item_name;
					company_full_name 	= item.company_full_name;
					packing 	= item.packing;
					expiry 		= item.expiry;
					image		= item.image;
					quantity 	= item.quantity;
					sale_rate 	= item.sale_rate;
					scheme 		= item.scheme;
					modalnumber = item.modalnumber;
					datetime 	= item.datetime;
					finalpay 	= atob(item.finalpay);
					
					if(mcl_i%2==0) { 
						csscls = "search_page_gray"; 
					} else { 
						csscls = "search_page_gray1"; 
					}
					
					mcl_i = parseInt(mcl_i) + 1;
					li_start = '<div class="item_focues'+i_code+'"><li class="list_item_radius_r">';
					
					image_ = '<img src="'+image+'" style="width: 100%;cursor: pointer;" class="border rounded" title="'+item_name+'" onclick="get_single_medicine_info('+i_code+')">';
					
					scheme_ = "";
					if(scheme!="0+0")
					{
						scheme  =  'Scheme : '+scheme;
						scheme_ =  '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/scheme.png" class="cart_scheme_icon" title="'+item_name+' '+scheme+'"><span class="cart_scheme" title="'+item_name+' '+scheme+'">'+scheme+'</span>';
					}
					
					$(".medicine_cart_list_div").append(li_start+'<div class="row"><div class="col-sm-3 col-4">'+image_+'</div><div class="col-sm-9 col-8"><div class="text-capitalize cart_title" title="'+item_name+'" onclick="get_single_medicine_info('+i_code+')" style="cursor: pointer;">'+item_name+' <span class="cart_packing">('+packing+' Packing)</span></div><div class="cart_expiry">Expiry : '+expiry+'</div><div class="cart_company">By '+company_full_name+'</div><div class="text-left cart_stock" title="'+item_name+' Quantity: '+quantity+'" >Order quantity: '+quantity+'</div></div><div class="col-sm-12 col-12">'+scheme_+'</div><div class="col-sm-12 col-12 cart_date_time">'+modalnumber+' | '+datetime+'</div><div class="col-sm-7 col-7 cart_ptr">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/- | <span class="cart_total">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+finalpay+'/-</span></div><div class="col-sm-5 col-5 text-right"><a href="javascript:delete_medicine('+id+','+i_code+')" tabindex="-10" title="Delete '+item_name+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;margin-right:5px;"></a><a href="javascript:get_single_medicine_info('+i_code+')" tabindex="-10" title="Edit '+item_name+'" class="edit_item_focues'+i_code+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;"></a></div></div></li></div>');
				}
			});
		},
		timeout: 10000
	});
}
function delete_medicine(id,i_code)
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
				url: "<?php echo base_url(); ?>Chemist_order/delete_medicine",
				type:"POST",
				/*dataType: 'html',*/
				data: {'id': id},
				error: function(){
					swal("Medicine not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								count_temp_rec();
								view_cart_or_empty_cart_btn();
								//page_load();
								$(".item_focues"+i_code).html('')
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
			chemist_id = "<?=$chemist_id?>";
			$.ajax({                          
				url: "<?php echo base_url(); ?>Chemist_order/delete_all_medicine",
				type:"POST",
				/*dataType: 'html',*/
				data: {'chemist_id': chemist_id},
				error: function(){
					swal("Medicines not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								count_temp_rec();
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
function user_top_order()
{
	uto_i = 0;
	$('.user_top_order_div').html('');
	chemist_id = "<?=$chemist_id?>";
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/user_top_order",
		type:"POST",
		cache: true,
		data: {chemist_id:chemist_id},
		error: function(){
			$(".user_top_order_div").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success: function(data){
			if(data.items=="")
			{
				$(".user_top_order_div").html('');
			}
			else
			{
				$(".user_top_order_div").html("");
			}
			$.each(data.items, function(i,item){
				if (item)
				{
					id 			= item.id;
					i_code 		= item.i_code;
					item_name 	= item.item_name;
					quantity 	= item.quantity;
					
					if(uto_i%2==0) { 
						csscls = "search_page_gray"; 
					} else { 
						csscls = "search_page_gray1"; 
					}
					
					uto_i = parseInt(uto_i) + 1;
					li_start = '<li class="list_item_radius_r">';
					
					$(".user_top_order_div").append('<a href="javascript:void(0)" onClick="get_single_medicine_info('+i_code+')" style="text-decoration: none;">'+li_start+'<div class="row"><div class="col-sm-12 col-12"><div class="text-capitalize cart_title">'+item_name+'</div><div class="text-left cart_stock">Last order quantity : '+quantity+'</div></div></div></li></a>');
				}
			});
		},
		timeout: 10000
	});
}
</script>