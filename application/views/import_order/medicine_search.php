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
$(".headertitle").html("Upload order");
function goBack() {
	window.location.href = "<?= base_url();?>import_order";
}
</script>

<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<table class="table table-striped table-bordered" aria-describedby>
				<thead>
					<tr>
						<th style="width:50px;" scope>
							S.No.
						</th>
						<th scope>
							Item Information
						</th>
					</tr>
				</thead>
				<tbody class="tbody_row">
			<?php
			$lastcount=0;
			$j = 0;
			foreach($result as $row)
			{
				$item_name 	= ucwords(strtolower($row->item_name));
				if(!empty($item_name))
				{
					$item_qty 	= $row->quantity;
					$item_mrp 	= $row->mrp;
					$i          = $row->id; 
					$j++?>
					<tr class="remove_css_<?= $i ?>">
						<td>
							<?= $j ?>
							<input type="hidden" value="<?= $item_name ?>" class="your_item_name_<?= $i ?>">
							<input type="hidden" value="<?= $item_mrp ?>" class="your_item_mrp_<?= $i ?>">
							<input type="hidden" value="<?= $item_qty ?>" class="your_item_qty_<?= $i ?>">
						</td>
						<td class="import_order_td_<?= $i ?>">
							<div class="row">
								<div class="col-sm-1">
									<img src="<?=base_url(); ?>img_v<?= constant('site_v') ?>/logo2.png" width="60px;" style="margin-top: 5px;" class="image_css_<?= $i ?> medicine_cart_item_image" alt="" onerror="this.src='<?= base_url(); ?>/uploads/default_img.jpg'">
								</div>
								<div class="col-sm-11">
									<div class="row">
										<div class="col-sm-8">
											<span style="float:left;">
												<?= $myname;?> : 
												<span class="import_order_title_1 medicine_cart_item_name">
												<?= $item_name; ?>
												</span>
											</span>
											<span style="float:left; margin-left:10px;margin-right:10px;" class="">
											|
											</span>
											<span style="float:left;" class="cart_delete_btn_<?= $i ?>">
											
											<a href="javascript:void(0)" onclick="delete_row_medicine('<?= $i; ?>')" title="Delete medicine" class="cart_delete_btn">
											<img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete medicine"> Delete medicine</a>

											</span>
										</div>
										<div class="col-sm-4 text-right">
											<span style="float:right;">
											<div class="import_order_mrp medicine_cart_item_mrp">MRP. : <i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($item_mrp,2) ?>/-</div>
											</span>
											<span style="float:right; margin-left:10px;margin-right:10px;" class="import_order_mrp">
											|
											</span>
											<span style="float:right;">
												<input type="number" name="item_qty[]" value="<?= $item_qty ?>" class="form-control new_quantity item_qty_<?= $i ?>" style="width: 50px;height: 30px;font-size: 12px;padding: 3px;" onchange="change_order_quantity('<?= $i; ?>')" min="1" max="1000" />
											</span>
											<span style="float:right;margin-right:5px;" class="cart_order_qty1">
											Quantity : 
											</span>
										</div>
										<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div>
									</div>
									<div class="row select_product_<?= $i ?>" style="display:none">
										<div class="col-sm-8">
											DRD : 
											<span class="medicine_cart_item_name selected_item_name_<?= $i ?>"></span>
											<span class="medicine_cart_item_packing">
											(<span class="selected_packing_<?= $i ?>"></span> Packing) </span> - <span class="medicine_cart_item_expiry expiry_css_<?= $i ?>"> Expiry : <span class="selected_expiry_<?= $i ?>"></span></span>
										</div>
										<div class="col-sm-4 text-right">
											<span class="medicine_cart_item_stock">
											Stock : <span class="selected_batchqty_<?= $i ?>"></span></span> | 
											<span class="medicine_cart_item_mrp">
											MRP. : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_mrp_<?= $i ?>">0.00</span>/- </span>
										</div>	
										<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div>
										<div class="col-sm-7">
											<span class="medicine_cart_item_company">
											By : <span class="selected_company_full_name_<?= $i ?>"></span></span> 
											|  <span class="medicine_cart_item_batch_no"> Batch no : <span class="selected_batch_no_<?= $i ?>"></span></span>
											<span class="select_product_<?= $i ?> selected_scheme_span_<?= $i ?>"> | 
												<span class="medicine_cart_item_scheme selected_scheme_<?= $i ?>"></span>
											</span>
										</div>
										<div class="col-sm-5 text-right">
											<span class="medicine_cart_item_ptr">
											PTR : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_sale_rate_<?= $i ?>">0.00</span>/-</span> | 
											<span class="medicine_cart_item_price">
											~ Landing price : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_final_price_<?= $i ?>">0.00</span>/-</span>
										</div>
									</div>
								</div>
								<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div>
								<div class="col-sm-12">
									<span class="cart_description1 selected_msg_<?= $i ?>"> Loading.... </span>
									<span class="selected_SearchAnotherMedicine_<?= $i ?>" style="display:none">
										<a href="javascript:change_medicine('<?= $i ?>')" class="cart_delete_btn" title="Change medicine">
										<img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Change Medicine">
											Change medicine
										</a>
									</span>
									<span class="selected_suggest_<?= $i ?>" style="display:none">
									|
										<a href="javascript:delete_suggested_medicine('<?= $i ?>')" title="Delete suggested medicine" class="cart_delete_btn"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete suggested medicine">Delete suggested medicine</a>
									</span>
								</div>
							</div>
							<?php /***main result show hear*/ ?>
							<span class="insert_main_row_data_<?= $i ?>"></span>
						</td>
					</tr>
				<?php
				$lastcount++;
				}
			}
			?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-6 col-6 text-left">
			<button type="submit" class="btn btn-primary mainbutton next_btn" name="submit" value="submit" onclick="add_new_medicine()" style="width:30%"> + Add Medicine</button>
		</div>
		<div class="col-sm-6 col-6 text-right">
			<a href="<?= base_url(); ?>import_order/medicine_deleted_items/<?php echo base64_encode($order_id); ?>">
				<button type="submit" class="btn btn-primary mainbutton next_btn" name="submit" value="submit" style="width:20%">Next</button>
			</a>
		</div>
		<div class="col-sm-12 col-12">
			<span class="medicine_cart_list_div">
			</span>
		</div>		
	</div>     
</div>

<input type="hidden" class="_row_id">
<div class="background_blur" onclick="clear_search_icon()" style="display:none"></div>
<div class="script_css"></div>
<input type="hidden" value="<?php echo time(); ?>" class="mytime">

<input type="hidden" value="" class="new_import_page_item_name">
<input type="hidden" value="" class="new_import_page_item_mrp">
<script>
function insert_main_row_data(row_id)
{
	item_name = $(".your_item_name_"+row_id).val();
	item_mrp  = $(".your_item_mrp_"+row_id).val();
	item_qty  = $(".your_item_qty_"+row_id).val();

	mytime = $(".mytime").val();
	$.ajax({
		type       : "POST",
		data       :  {row_id:row_id} ,
		url        : "<?= base_url(); ?>import_order/insert_main_row_data",
		cache	   : false,
		error: function(){
			$(".selected_msg_"+cssid).html("Server not Responding, Please try Again");
		},
		success    : function(data){
			$(".insert_main_row_data_"+row_id).html(data);
		}
	});
}

function change_order_quantity(row_id)
{
	quantity  = $(".item_qty_"+row_id).val();

	$.ajax({
		type       : "POST",
		data       :  {row_id:row_id,quantity:quantity} ,
		url        : "<?= base_url(); ?>import_order/change_order_quantity",
		cache	   : false,
		error: function(){
			swal("Quantity not updated");
		},
		success    : function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					if(item.response=="1")
					{
						$(".your_item_qty_"+row_id).val(quantity);
						swal("Quantity updated successfully");
						setTimeout(insert_main_row_data(row_id),500);
					}
					else{
						swal("Quantity not updated");
					}
				} 
			});
		},
		timeout: 10000
	});
}

function delete_row_medicine(row_id)
{
	swal({
		title: "Are you sure to delete medicine?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) {
			$.ajax({
				type       : "POST",
				data       :  {row_id:row_id,} ,
				url        : "<?= base_url(); ?>import_order/delete_row_medicine",
				cache	   : false,
				error: function(){
					swal("Medicine not deleted");
				},
				success    : function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								$(".remove_css_"+row_id).html('');
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

function delete_suggested_medicine(row_id)
{
	swal({
		title: "Are you sure to delete suggested medicine?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) {
			$.ajax({
				url: "<?php echo base_url(); ?>import_order/delete_suggested_medicine",
				type:"POST",
				/*dataType: 'html',*/
				data: {row_id:row_id,user_altercode:'<?= $chemist_id ?>'},
				error: function(){
					swal("Suggested medicine not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								swal("Suggested Medicine deleted successfully", {
									icon: "success",
								});
								$('.selected_suggest_'+row_id).hide();
								insert_main_row_data(row_id)
							}
							else{
								swal("Suggested medicine not deleted");
							}
						} 
					});
				},
				timeout: 10000
			});
		} else {
			swal("Suggested medicine not deleted");
		}
	});
}
/*************************************/

function change_medicine(row_id)
{
	$(".select_chemist").hide();
	$(".select_medicine").focus();
	$(".select_medicine").val('');
	$(".background_blur").show();
	$("._row_id").val(row_id);
	item_name = $(".your_item_name_"+row_id).val();
	setTimeout($('.select_medicine').val(item_name),500);
	setTimeout(search_medicine(),1000);
}

function clear_search_icon()
{
	$(".clear_search_icon").hide();
	$(".select_medicine").val('');
	$(".background_blur").hide();
	i = $("._row_id").val();
	$(".item_qty_"+i).focus();
	$(".search_medicine_result").hide();
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
				//clear_search_icon();
			}
		}
	}) 
	$(".search_textbox").keyup(function() { 
		var keyword = $(".search_textbox").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.search_textbox').focus();
				$(".search_medicine_result").html("");
			}
			search_medicine()
		}
		else{
			//clear_search_icon();
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
	//setTimeout('page_load();',100);
	
	document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 27) {
			//clear_search_icon();
		}
	};
});

function search_medicine()
{
	new_i = 0;
	$(".clear_search_icon").show();
	var keyword = $(".search_textbox").val();
	if(keyword!="")
	{
		if(keyword=="#")
		{
			keyword = "k1k2k12k";
		}
		if(keyword.length>2)
		{
			$(".background_blur").show();
			$(".search_medicine_result").show();
			$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
			$(".header_result_found").html("Loading....");
			$.ajax({
				type       : "POST",
				data       :  { keyword : keyword} ,
				url        : "<?php echo base_url(); ?>Chemist_json/medicine_search_api",
				error: function(){
					$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
				},
				cache	   : false,
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
							
							div_start = 'onClick=change_medicine_2("'+item_code+'"),clear_search_icon()';

							//new_i = parseInt(new_i) + 1;
							csshover1 = 'hover_'+new_i;

							div_all_data = "<div class='medicine_details_all_data_"+item_code+"' item_image='"+item_image+"' item_name='"+item_name+"' item_packing='"+item_packing+"' item_expiry='"+item_expiry+"' item_company='"+item_company+"' item_quantity='"+item_quantity+"' item_stock='"+item_stock+"' item_ptr='"+item_ptr+"' item_mrp='"+item_mrp+"' item_price='"+item_price+"' item_scheme='"+item_scheme+"' item_margin='"+item_margin+"' item_featured='"+item_featured+"' item_description1='"+item_description1+"' similar_items='"+similar_items+"'></div>"
							
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
							
							rete_div =  '<span class="medicine_cart_item_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+item_ptr+'/- </span> | <span class="medicine_cart_item_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+item_mrp+'/- </span> | <span class="medicine_cart_item_price"> ~ Price : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/- </span>';
							

							$(".search_medicine_result").append('<div class="main_theme_li_bg '+csshover1+' medicine_details_funcation_'+new_i+'" '+div_start+'><div class="medicine_search_div1">'+item_image_div+'</div><div class="medicine_search_div2"><div class="medicine_cart_item_name">'+item_name+'<span class="medicine_cart_item_packing mobile_off"> ('+item_packing+' Packing)</span></div><div class="medicine_cart_item_packing mobile_show">'+item_packing+' Packing</div><div class=""><span class="medicine_cart_item_margin">'+item_margin+'% Margin </span>| <span class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</span></div><div class="medicine_cart_item_company">By '+item_company+'</div><div>'+item_quantity_div+'</div><div class="mobile_off">'+rete_div+'</div></div><div class="cart_ki_main_div3 mobile_show" style="margin-left:5px;">'+rete_div+'</div><div class="cart_ki_main_div3 medicine_cart_item_description1" style="margin-left:5px;">'+item_description1+'</div></div>'+div_all_data);
						}
					});
				},
				timeout: 10000
			});
		}
		else{
			$(".clear_search_icon").hide();
			$(".search_medicine_result").html("");
		}
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

function add_new_medicine()
{
	clear_search_icon();
	$(".select_medicine").focus();
	$(".background_blur").show();
	$(".clear_search_icon").show();
}

function change_medicine_2(item_code)
{	
	row_id = $("._row_id").val();
	if(row_id!="")
	{
		$.ajax({
			url: "<?php echo base_url(); ?>import_order/change_medicine_2",
			type:"POST",
			/*dataType: 'html',*/
			data: {item_code:item_code,row_id:row_id},
			error: function(){
				swal("Medicine not changed");
			},
			success: function(data){
					$.each(data.items, function(i,item){	
					if (item)
					{
						if(item.response=="1")
						{
							setTimeout(insert_main_row_data(row_id),200);
							swal("Medicine changed successfully", {
								icon: "success",
							});
							$("._row_id").val('');
						}
						else{
							swal("Medicine not changed");
						}
					} 
				});
			},
			timeout: 10000
		});
	}
	else{
		get_single_medicine_info(item_code);
	}
}

var js_i = "";
var js_j = "";
function add_new_row_import_order_page(item_code,item_order_quantity)
{
	if(js_i=="")
	{
		js_i = parseInt("<?= $i; ?>");
		js_j = parseInt("<?= $j; ?>");
	}
	
	js_i++;
	js_j++;

	<?php $myname = ""; ?>
	
	js1 = "javascript:change_medicine('"+js_i+"')";
	js2 = "javascript:delete_suggested_medicine('"+js_i+"')";

	item_image = $(".medicine_details_all_data_"+item_code).attr("item_image")
	item_name = $(".medicine_details_all_data_"+item_code).attr("item_name")
	item_mrp = $(".medicine_details_all_data_"+item_code).attr("item_mrp")

	$(".tbody_row").append('<tr class="remove_css_'+js_i+'"><td>'+js_j+'<input type="hidden" value="'+item_name+'" class="your_item_name_'+js_i+'"><input type="hidden" value="'+item_mrp+'" class="your_item_mrp_'+js_i+'"><input type="hidden" value="'+item_order_quantity+'" class="your_item_qty_'+js_i+'"></td><td class="import_order_td_'+js_i+'"><div class="row"><div class="col-sm-1"><img src="<?=base_url(); ?>img_v<?= constant('site_v') ?>/logo2.png" width="60px;" style="margin-top: 5px;" class="image_css_'+js_i+'" alt=""></div><div class="col-sm-11"><div class="row"><div class="col-sm-8"><span style="float:left;"><?= $myname;?> : <span class="import_order_title_1"> '+item_name+'</span> </span> <span style="float:left; margin-left:10px;margin-right:10px;" class="import_order_mrp"> | </span> <span style="float:left;"><a href="javascript:void(0)" onclick="delete_row_medicine('+js_i+')" title="Delete medicine" class="cart_delete_btn"> <img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete medicine"> Delete medicine</a> </span> </div> <div class="col-sm-4 text-right"> <span style="float:right;"> <div class="import_order_mrp">MRP. : <i class="fa fa-inr" aria-hidden="true"></i> '+item_mrp+'/-</div> </span> <span style="float:right; margin-left:10px;margin-right:10px;" class="import_order_mrp"> | </span> <span style="float:right;"> <input type="number" name="item_qty[]" value="'+item_order_quantity+'" class="form-control item_qty_'+js_i+'" style="width: 50px;height: 30px;font-size: 12px;padding: 3px;" onchange="change_order_quantity('+js_i+')" min="1" max="1000" /> </span> <span style="float:right;margin-right:5px;" class="cart_order_qty1"> Quantity : </span> </div> <div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> </div> <div class="row select_product_'+js_i+'" style="display:none"> <div class="col-sm-8"> DRD :  <span class="import_order_title selected_item_name_'+js_i+'"></span> <span class="import_order_packing"> (<span class="selected_packing_'+js_i+'"></span> Packing) </span> - <span class="import_order_expiry expiry_css_'+js_i+'"> Expiry : <span class="selected_expiry_'+js_i+'"></span></span> </div> <div class="col-sm-4 text-right"> <span class="import_order_stock"> Stock : <span class="selected_batchqty_'+js_i+'"></span></span> | <span class="import_order_mrp"> MRP. : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_mrp_'+js_i+'">0.00</span>/- </span> </div>	<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> <div class="col-sm-7"> <span class="import_order_company"> By : <span class="selected_company_full_name_'+js_i+'"></span></span> |  <span class="import_order_batch_no"> Batch No : <span class="selected_batch_no_'+js_i+'"></span></span> <span class="select_product_'+js_i+' selected_scheme_span_'+js_i+'"> |  <span class="import_order_scheme selected_scheme_'+js_i+'"></span> </span> </div> <div class="col-sm-5 text-right"> <span class="import_order_ptr"> PTR : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_sale_rate_'+js_i+'">0.00</span>/-</span> | <span class="import_order_landing_price"> ~ Landing price : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_final_price_'+js_i+'">0.00</span>/-</span> </div> </div> </div> <div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> <div class="col-sm-12"> <span class="selected_msg_'+js_i+'"> Loading.... </span> <span class="selected_SearchAnotherMedicine_'+js_i+'" style="display:none">  | <a href="'+js1+'" class="cart_delete_btn" title="Change medicine"> <img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Change medicine"> Change medicine </a> </span> <span class="selected_suggest_'+js_i+'" style="display:none"> | <a href="'+js2+'" title="Delete Suggest Medicine" class="cart_delete_btn"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete Suggest Medicine">Delete Suggest Medicine</a> </span> </div> </div> <span class="insert_main_row_data_'+js_i+'"></span> </td> </tr>');

	setTimeout("insert_main_row_data('"+js_i+"')",1000);
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
				data: {item_code:item_code},
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

function medicine_cart_list()
{
	id = "";
	$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_json/my_cart_api",
		type:"POST",
		cache: true,
		data: {id:id},
		error: function(){
			$(".medicine_cart_list_div").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success: function(data){
			$(".medicine_cart_list_div").html("");
			/* if(data.items=="")
			{
				$(".medicine_cart_list_div").html('<h1><center><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/cartempty.png" width="50%"></center></h1>');
				$(".delete_all_btn").hide();
				$(".Current_Order").hide();
			} */
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
					item_datetime 		= item.item_datetime;
					item_modalnumber 	= item.item_modalnumber;
					
					error_img ="onerror=this.src='<?= base_url(); ?>/uploads/default_img.jpg'"
					
					image_div = '<img src="'+item_image+'" style="width: 100%;" class="medicine_cart_item_image" '+error_img+'>';
					
					item_scheme_div = "";
					if(item_scheme!="0+0")
					{
						item_scheme_div =  ' | <span class="medicine_cart_item_scheme" title="'+item_name+' '+item_scheme+'">Scheme : '+item_scheme+'</span>';
					}

					rate_div = '<div class="cart_ki_main_div3 medicine_cart_item_datetime">'+item_modalnumber+' | '+item_datetime+'</div><div class="cart_ki_main_div3"><span class="medicine_cart_item_price2">Price : <i class="fa fa-inr" aria-hidden="true"></i> '+item_price+'/-</span> | <span class="medicine_cart_item_price">Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item_quantity_price+'/-</span><span style="float:right;"><a href="javascript:delete_medicine('+item_code+')" tabindex="-10" title="Delete '+item_name+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;margin-right:5px;"></a>&nbsp;<a href="javascript:get_single_medicine_info('+item_code+')" tabindex="-10" title="Edit '+item_name+'" class="edit_item_focues'+item_code+'"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" style="margin-top: 5px;margin-bottom: 2px;"></a>&nbsp;&nbsp;</div>';
					
					$(".medicine_cart_list_div").append('<div class="main_theme_li_bg"><div class="medicine_cart_div1">'+image_div+'</div><div class="medicine_cart_div2"><div class="medicine_cart_item_name" title="'+item_name+'">'+item_name+' <span class="medicine_cart_item_packing">('+item_packing+' Packing)</span></div><div class="medicine_cart_item_expiry">Expiry : '+item_expiry+'</div><div class="medicine_cart_item_company">By '+item_company+'</div><div class="text-left medicine_cart_item_order_quantity" title="'+item_name+' Quantity: '+item_quantity+'" >Order quantity : '+item_quantity+item_scheme_div+'</div><span class="mobile_off">'+rate_div+'</span></div><span class="mobile_show" style="margin-left:5px;">'+rate_div+'</span></div>');
				}
			});
		},
		timeout: 10000
	});
}
function page_load()
{
	medicine_cart_list();
}
setTimeout('page_load();',500);
</script>
<script src="<?= base_url(); ?>assets/website/select_css/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/website/select_css/init.js" type="text/javascript" charset="utf-8"></script>

<?php
foreach($result as $row)
{ ?>
<script>
$(document).ready(function(){
	setTimeout("insert_main_row_data('<?php echo $row->id ?>')",500);
});
</script>
<?php 
} ?>