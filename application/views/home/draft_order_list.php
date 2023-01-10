<div style="width:100%;display:none;padding-top: 100px;" class="loading_pg">
	<h1 class="text-center">
		<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px" alt="Loading...." title="Loading....">
	</h1>
	<h1 class="text-center">Loading....</h1>
	<h1 class="text-center">Please wait, Your order is under process.</h1>
</div>
<style>
.menubtn1
{
	display:none;
}
@media screen and (max-width: 767px) {
	.website_menu,.current_order_search_page1,.select_chemist,.homebtn_div
	{
		display: none ;
	}
	.current_order_search_page,.deletebtn_div
	{
		display: block !important;
	}
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<script>
$(".headertitle").html("Draft");
function goBack() {
	window.location.href = "<?= base_url();?>home/search_medicine";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-6 col-6 current_order_search_page1">
			<h6 class="search_pg_title_color Current_Order">Current order <span class="mycartwalidiv1"></span></h6>
		</div>
		<div class="col-sm-6 col-6 text-right current_order_search_page1" style="margin-bottom:5px;">
			<a href="#" onclick="delete_all_medicine()" tabindex="-10" class="delete_all delete_all_btn" title="Delete all"> <img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete all" title="Delete all"> Delete all </a>
		</div>
		<div class="col-sm-12 col-12">
			<span class="medicine_cart_list_div">
			</span>
		</div>
		<div class="col-sm-6 col-6 text-left">
			<a href="<?=base_url();?>home/search_medicine" class="btn btn-primary next_btn site_main_btn31 btn_add_medicine"> 
				+ Add medicine
			</a>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<div class="place_order_or_empty_cart_btn_div">
	<p class="text-center">Loading....</p>
</div>
<?php if(!empty($_SESSION['user_temp_rec'])){ ?>
<input type="hidden" value="<?php echo $_SESSION["user_temp_rec"] ?>" class="user_temp_rec">
<?php } ?>
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
				<div class="form-check">
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
					<textarea class="form-control rounded-0 border" id="remarks" rows="5" placeholder="Enter a remark" style="border-style: solid !important;    border-color: #e0e0e0 !important;    border-width: 1px !important;"></textarea>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-block site_main_btn31" data-dismiss="modal" onclick="place_order_complete()">Place order</button>
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
	place_order_or_empty_cart_btn();
}
function medicine_cart_list()
{
	$(".btn_add_medicine").show();
	mcl_i = 0;
	$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
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
				$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/cartempty.png" width="50%"></center></h1>');
				$(".delete_all_btn").hide();
				$(".Current_Order").hide();
				$(".place_order_or_empty_cart_btn_div").hide();
				$(".btn_add_medicine").hide();
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
					
					scheme_work = "1";
					if(scheme=="0+0")
					{
						scheme =  'No scheme';
						scheme_work = "0";
					}
					else
					{
						scheme =  'Scheme: '+scheme;
					}
					
					mcl_i = parseInt(mcl_i) + 1;
					li_start = '<div class="item_focues'+i_code+'"><li class="list_item_radius cart_page_full">';
					
					image_ = '<img src="'+image+'" style="width: 100%;cursor: pointer;" class="border rounded" title="'+item_name+'" onclick="get_single_medicine_info('+i_code+')">';
					
					scheme_ =  '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/scheme.png" class="cart_scheme_icon" title="'+item_name+' '+scheme+'"><span class="cart_scheme" title="'+item_name+' '+scheme+'">'+scheme+'</span>';
					if(scheme_work=="0")
					{
						scheme_ = "";
					}
					
					edit_delete_btn = '<a href="javascript:delete_medicine('+id+','+i_code+')" tabindex="-10" title="Delete '+item_name+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;margin-right:5px;"></a><a href="javascript:get_single_medicine_info('+i_code+')" tabindex="-10" title="Edit '+item_name+'" class="edit_item_focues'+i_code+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;"></a>';
					
					down_side_part = '<div class="row"><div class="col-sm-12 col-12">'+scheme_+'</div><div class="col-sm-12 col-12 cart_date_time">'+modalnumber+' | '+datetime+'</div><div class="col-sm-8 col-8 cart_ptr">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/- | <span class="cart_total">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+finalpay+'/-</span></div><div class="col-sm-4 col-4 text-right">'+edit_delete_btn+'</div></div>';
					
					$(".medicine_cart_list_div").append(li_start+'<div class="row"><div class="col-sm-2 col-4">'+image_+'</div><div class="col-sm-10 col-8"><div class="text-capitalize cart_title" title="'+item_name+'" onclick="get_single_medicine_info('+i_code+')" style="cursor: pointer;">'+item_name+' <span class="cart_packing">('+packing+' Packing)</span></div><div class="cart_expiry">Expiry : '+expiry+'</div><div class="cart_company">By '+company_full_name+'</div><div class="text-left cart_stock" title="'+item_name+' Quantity: '+quantity+'" >Order quantity : '+quantity+'</div><div class="mobile_off">'+down_side_part+'</div></div></div><div class="mobile_show">'+down_side_part+'</div></li></div>');
				}
			});
		},
		timeout: 10000
	});
}
function place_order_or_empty_cart_btn()
{
	chemist_id = "<?=$chemist_id?>";
	$('.place_order_model').hide();
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/place_order_or_empty_cart_btn",
		type:"POST",
		dataType: 'html',
		data: {chemist_id:chemist_id},
		error: function(){
			$('.place_order_or_empty_cart_btn_div').html('');
		},
		success: function(data){
			$('.place_order_or_empty_cart_btn_div').html(data);
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
	chemist_id  = "<?=$chemist_id?>";
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
		data       :  {slice_type:slice_type,slice_item:slice_item,chemist_id:chemist_id,remarks:remarks},
		url        : "<?php echo base_url(); ?>Chemist_order/save_order_to_server",
		cache	   : true,
		error: function(){
			window.location.href = "<?= base_url();?>home/draft_order_list";
		},
		success    : function(data){
			$.each(data.items, function(i,item){
				if (item)
				{
					order_success 	= item.order_success;
					place_order_message = atob(item.place_order_message);
					if(order_success=="0" || order_success=="1")
					{
						$(".loading_pg").html("<h1 class='text-center'>"+place_order_message+"</h1><h1 class='text-center'><input type='submit' value='Go home' class='btn btn-primary site_main_btn31' name='Go home' onclick='gohome()' style='width:50%;margin-top:100px;'></h1>");
				    }
					count_temp_rec();
				}
			});
		},
		//timeout: 10000
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
							place_order_or_empty_cart_btn();
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
function gohome()
{
	window.location.href= "<?= base_url() ?>home";
}
</script>