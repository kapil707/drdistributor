<style>
.menubtn1,.menubtn2
{
	display:none;
}
.homepgsearch_w
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
.home_page_search_div_box,.select_chemist
{
	display: inline-block;
}
.select_medicine,.home_page_search_div,.search_medicine_result,.clear_search_icon
{
	display: none;
}
@media screen and (max-width: 767px) {
	.homebtn_div
	{
		display:none;
	}
}
</style>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<span class="draft_order_list_sales_div">
			</span>
		</div>
	</div>
</div>
<script>
$(".headertitle").html("Search chemist");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="background_blur" onclick="clear_search_icon()" style="display:none"></div>
<script>
function page_load()
{
	search_focus();
	clear_search_icon();
}
function search_focus()
{
	$(".search_medicine_result").hide();
	$('.select_chemist').focus();
}
function clear_search_icon()
{
	$(".search_medicine_result").html("");
	$(".select_chemist").val("");
	$('.select_chemist').focus();
	$(".clear_search_icon").hide();
	$(".search_medicine_result").hide();	
	$(".background_blur").hide();
}
$(document).ready(function(){
	$(".select_chemist").keyup(function(e){
		if(e.keyCode == 8)
		{
			var keyword = $(".select_chemist").val();
			if(keyword!="")
			{
				if(keyword.length<3)
				{
					$('.select_chemist').focus();
					$(".search_medicine_result").html("");
				}
			}
			else{
				clear_search_icon();
			}
		}
	})
	$(".select_chemist").keypress(function() { 
		var keyword = $(".select_chemist").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.select_chemist').focus();
				$(".search_medicine_result").html("");
			}
			search_chemist()
		}
		else{
			clear_search_icon();
		}
	});
	$(".select_chemist").change(function() { 
	});
	$(".select_chemist").on("search", function() { 
	});
	
    $(".select_chemist").keydown(function(event) {
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
function search_chemist()
{
		new_i = 0;
		$(".clear_search_icon").show();
        var keyword = $(".select_chemist").val();
		if(keyword!="")
		{
			if(keyword.length>1)
			{
				$(".background_blur").show();
				$(".search_medicine_result").show();
				$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
				$.ajax({
					type       : "POST",
					data       :  { keyword : keyword} ,
					url        : "<?php echo base_url(); ?>Chemist_json/chemist_search_api",
					cache	   : false,
					error: function(){
						$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
					},
					success    : function(data){
						if(data.items=="")
						{
							$(".search_medicine_result").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
						}
						else
						{
							$(".search_medicine_result").html("");
						}
						$.each(data.items, function(i,item){	
							if (item){
								chemist_altercode	= item.chemist_altercode;
								new_i				= item.count;
								
								//new_i = parseInt(new_i) + 1;
								
								a_ = 'onclick=select_chemist("'+chemist_altercode+'")';
								csshover1 = 'hover_'+new_i;

								chemist_message = "";
								if(item.user_cart!="0")
								{
									chemist_message = '<div class="medicine_cart_item_date_time">Order '+item.user_cart+' Items | Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item.user_cart_total+'/-</div></div></div>';
								}
								
								$(".search_medicine_result").append('<div class="main_theme_li_bg '+csshover1+' select_chemist_'+new_i+'" '+a_+'><div class="search_chemist_div1"><img src="'+item.chemist_image+'" class="medicine_cart_item_image" onerror=this.src="<?= base_url(); ?>/uploads/default_img.jpg"></div><div class="search_chemist_div2"><div class="chemist_user_name">'+item.chemist_name+'</div><div class="chemist_altercode"> Code : '+item.chemist_altercode+'</div>'+chemist_message+'</div>');
							}
						});					
					}
				});
			}
		}
		else{
			$(".clear_search_icon").hide();
			$(".search_medicine_result").html("");
		}
}
function select_chemist(chemist_id)
{	
	window.location.href = "<?= base_url();?>home/salesman_chemist_add/"+chemist_id+"/<?= $next_page ?>"
}
function page_up_down_arrow(new_i)
{
	$('.hover_'+new_i).keypress(function (e) {
		 if (e.which == 13) {
			$('.select_chemist_'+new_i).click();
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
				var searchInput = $('.select_chemist');
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
</script>

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
		url        : "<?php echo base_url(); ?>chemist_json/salesman_my_cart_api",
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
					chemist_altercode = item.chemist_altercode
					a_ = 'onclick=select_chemist("'+chemist_altercode+'")';

					$(".draft_order_list_sales_div").append('<div class="main_theme_li_bg" '+a_+'><div class="medicine_chemist_div1"><img src="'+item.chemist_image+'" class="medicine_cart_item_image" onerror=this.src="<?= base_url(); ?>/uploads/default_img.jpg"></div><div class="medicine_chemist_div2"><div class="medicine_cart_item_name">'+item.chemist_name+'</div><div class="medicine_cart_item_packing"> Code : '+item.chemist_altercode+'</div><div class="medicine_cart_item_date_time">Order '+item.user_cart+' Items | Total : <i class="fa fa-inr" aria-hidden="true"></i> '+item.user_cart_total+'/-</div></div></div>');				
				}
			});	
		}
	});
}
</script>