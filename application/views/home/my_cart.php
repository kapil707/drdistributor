<div style="width:100%;display:none;padding-top: 100px;" class="loading_pg">
	<h1 class="text-center">
		<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading....">
	</h1>
	<h1 class="text-center">Loading....</h1>
	<h1 class="text-center">Please wait, Your order is under process.</h1>
</div>
<style>
.menubtn1,.headertitle1
{
	display:none;
}
@media screen and (max-width: 767px) {
	.search_pg_menu_off,.main_home_top_btn
	{
		display: none;
	}
	.current_order_search_page,.delete_btn_icon
	{
		display: block !important;
	}
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
$(".headertitle").html("Draft");
function goBack() {
	window.location.href = "<?= base_url();?>home/search_medicine";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-6 col-6 current_order_search_page1 mobile_off">
			<h6 class="search_pg_title_color Current_Order">Current order 
				<span class="div_cart_total_items1"></span></h6>
		</div>
		<div class="col-sm-6 col-6 text-right current_order_search_page1 mobile_off" style="margin-bottom:5px;">
			<a href="#" onclick="delete_all_medicine()" tabindex="-10" class="cart_delete_btn delete_all_btn" title="Delete all medicine"> <img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete all medicine" title="Delete all medicine"> Delete all <span class="mobile_off">medicines</span></a>
		</div>
		<div class="col-sm-12 col-12">
			<span class="medicine_cart_list_div">
			</span>
		</div>
		<div class="col-sm-3 col-8 text-left">
			<a href="<?=base_url();?>home/search_medicine" class="btn mainbutton" style="margin-top:10px;"> 
				+ Add new medicine
			</a>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<div class="place_order_or_empty_cart_btn_div">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">	
				<strong style="color:red" class="place_order_message">
				
				</strong>
			</div>
			<div class="col-5 text-center">				
				<div class="div_cart_total_items">0 items</div>
				<div class="div_cart_total_price"><i class="fa fa-inr"></i>0.00</div>
			</div>
			<div class="col-7 text-center">
				<span class="cart_empty_cart_div">
					<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></i><button class="btn mainbutton_disable" onclick="cart_empty_btn()" tabindex="-3" title="Cart Is Empty">Cart is empty</button>
				</span>
				<span class="cart_disabled_cart_div" style="display:none">
					<em class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></em><button class="btn mainbutton_disable" tabindex="-3" title="Can't place order">Can't place order</button>
				</span>
				<span class="cart_add_to_cart_div" style="display:none">
					<em class="fa fa-circle-o-notch fa-spin" style="font-size:24px;display:none" id="order_loading"></em><button class="btn mainbutton" onclick="place_order_model()" tabindex="-3" title="Place order">Place order</button>
				</span>
			</div>
		</div>
	</div>
</div>
<button type="button" class="place_order_model" data-toggle="modal" data-target="#myModal_place_order" style="display:none"></button>
<!-- The Modal -->
<div class="modal" id="myModal_place_order">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Enter a remark</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div class="form-check" style="display:none;">
					<label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio" id="slice_type0" onclick="slice_type_change('0')" checked>Complete one order
					</label>
				</div>
				<?php /*
				<div class="form-check">
					<label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio" id="slice_type1" onclick="slice_type_change('1')">Break by Amount
					</label>
				</div>
				<div class="form-check disabled">
					<label class="form-check-label">
					<input type="radio" class="form-check-input" name="optradio" id="slice_type2" onclick="slice_type_change('2')">Break by Line Quantity
					</label>
					<input type="hidden" class="form-control" id="slice_type" value="0" />
				</div>*/ ?>
				<div class="form-group slice_item1_div" style="display:none">
					<label>Break by Amount</label>
					<select class="form-control" id="slice_item1">
						<option value="9000">9000</option>
						<option value="19000">19000</option>
						<option value="49000">49000</option>
						<option value="99000">99000</option>
						<option value="199000">199000</option>
					</select>
				</div>
				<div class="form-group slice_item2_div" style="display:none">
					<label>Break by Line Quantity</label>
					<select class="form-control" id="slice_item2">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="40">40</option>
						<option value="100">100</option>
					</select>
				</div>
				<div class="form-group">
					<textarea class="" id="remarks" rows="5" placeholder="Enter a remark" style="border-style: solid !important;border-color: #e0e0e0 !important;border-width: 1px !important;border-radius:10px;"></textarea>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn mainbutton" data-dismiss="modal" onclick="place_order_complete()">Place order</button>
			</div>
		</div>
	</div>
</div>
<script>
function slice_type_change(mtid)
{
	$(".slice_item1_div").hide();
	$(".slice_item2_div").hide();
	$("#slice_type").val(mtid);
	if(mtid=="1")
	{
		$(".slice_item1_div").show();
	}
	if(mtid=="2")
	{
		$(".slice_item2_div").show();
	}
}
$(document).ready(function(){
	setTimeout('page_load();',100);
});
function page_load()
{
	medicine_cart_list();
	//place_order_or_empty_cart_btn();
}
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
					
					image_div = item_other_image_div+'<img src="'+item_image+'" style="width: 100%;" class="medicine_cart_item_image" '+error_img+'>';
					
					item_scheme_div = "";
					if(item_scheme!="0+0")
					{
						item_scheme_div =  ' | <span class="medicine_cart_item_scheme" title="'+item_name+' '+item_scheme+'">Scheme : '+item_scheme+'</span>';
					}

					rate_div = '<div class="cart_ki_main_div3"><span class="medicine_cart_item_price2" title="*Approximate ~">*Approximate ~ : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/-</span> | <span class="medicine_cart_item_price">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item_quantity_price+'/-</span></div><div class="cart_ki_main_div3"><span class="medicine_cart_item_datetime">'+item_modalnumber+' | '+item_datetime+'</span><span style="float:right;"><a href="javascript:delete_medicine('+item_code+')" tabindex="-10" title="Delete '+item_name+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;margin-right:5px;"></a>&nbsp;<a href="javascript:get_single_medicine_info('+item_code+')" tabindex="-10" title="Edit '+item_name+'" class="edit_item_focues'+item_code+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;"></a>&nbsp;&nbsp;</div>';
					
					$(".medicine_cart_list_div").append('<div class="main_theme_li_bg"><div class="medicine_cart_div1">'+image_div+'</div><div class="medicine_cart_div2"><div class="medicine_cart_item_name" title="'+item_name+'">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</div><div class="medicine_cart_item_company">By '+item_company+'</div><div class="text-left medicine_cart_item_order_quantity" title="'+item_name+' Quantity: '+item_quantity+'" >Order quantity : '+item_quantity+item_scheme_div+'</div><span class="mobile_off">'+rate_div+'</span></div><span class="mobile_show" style="margin-left:5px;">'+rate_div+'</span></div>');
				}
			});
			$.each(data.other_items, function(i,item){
				if (item)
				{
					items_price = item.items_price;
					items_total = item.items_total;
					place_order_button = item.place_order_button;
					place_order_message = item.place_order_message;
					$(".div_cart_total_price").html('<i class="fa fa-inr"></i>'+items_price+'/-');
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
					if(items_total!=0)
					{
						if(place_order_button==1)
						{
							$(".cart_empty_cart_div").hide();
							$(".cart_add_to_cart_div").show();
							$(".cart_disabled_cart_div").hide();

							$(".place_order_message").html('');
						}
						else{
							$(".cart_empty_cart_div").hide();
							$(".cart_add_to_cart_div").hide();
							$(".cart_disabled_cart_div").show();
						}
					}
				}
			});
		},
		timeout: 10000
	});
}
function place_order_model()
{
	$(".place_order_model").click();
	$("#remarks").focus();
}
function place_order_complete()
{
	slice_item 	= "";
	slice_type 	= $("#slice_type").val();
	if(slice_type=="1")
	{
		slice_item 	= $("#slice_item1").val();
	}
	if(slice_type=="2")
	{
		slice_item 	= $("#slice_item2").val();
	}
	remarks 	= $("#remarks").val();
	
	$(".loading_pg").show();
	$(".maincontainercss").hide();
	$(".place_order_or_empty_cart_btn_div").hide();
	
	$.ajax({
		type       : "POST",
		data       :  {slice_type:slice_type,slice_item:slice_item,remarks:remarks},
		url        : "<?php echo base_url(); ?>Chemist_order/save_order_to_server",
		cache	   : true,
		error: function(){
			window.location.href = "<?= base_url();?>home/draft_order_list";
		},
		success    : function(data){
			$.each(data.items, function(i,item){
				if (item)
				{
					status 	= item.status;
					place_order_message = (item.place_order_message);
					if(status=="0" || status=="1")
					{
						$(".loading_pg").html("<h1 class='text-center'>"+place_order_message+"</h1><h1 class='text-center'><input type='submit' value='Go home' class='btn mainbutton' name='Go home' onclick='gohome()' style='width:50%;margin-top:100px;'></h1>");
				    }
					count_temp_rec();
				}
			});
		},
		//timeout: 10000
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
			data: {item_code: item_code},
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
function gohome()
{
	window.location.href= "<?= base_url() ?>home";
}
</script>