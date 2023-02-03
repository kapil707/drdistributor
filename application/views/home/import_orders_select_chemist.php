<style>
.menubtn1
{
	display:none;
}
.homepgsearch_w
{
	display:none;
}
/*.headertitle
{
    margin-top: 5px !important;
}*/
.SearchMedicine_search_box_div
{
	display: inline-block;
}
.select_medicine,.homepagesearchdiv,.select_chemist_result
{
	display: none ;
}
</style>
<script>
$(".headertitle").html("Search chemist");
function goBack() {
	window.location.href = "<?= base_url();?>import_order";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-7 col-12">
			<span class="select_chemist_result searchpagescrolling2"></span>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
<div class="background_blur" onclick="clear_search_box()" style="display:none"></div>
<script>
function page_load()
{
	search_focus();
	clear_search_box();
}
function search_focus()
{
	$(".select_chemist_result").hide();
	$('.SearchMedicine_search_box_div').show();
	$('.homepgsearch_w').hide();
	$('.SearchMedicine_search_box').focus();
}
function clear_search_box()
{
	$(".select_chemist_result").html("");
	$(".SearchMedicine_search_box").val("");
	$('.SearchMedicine_search_box').focus();
	$(".clear_search_box").hide();
	$(".select_chemist_result").hide();	
	$(".background_blur").hide();
}
$(document).ready(function(){	
	$(".select_chemist").keyup(function() { 
		var keyword = $(".select_chemist").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.select_chemist').focus();
				$(".select_chemist_result").html("");
			}
			search_chemist()
		}
		else{
			clear_search_box();
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
			clear_search_box();
		}
	};
});
function search_chemist()
{
		new_i = 0;
		$(".clear_search_box").show();
        var keyword = $(".select_chemist").val();
		if(keyword!="")
		{
			if(keyword.length>1)
			{
				$(".background_blur").show();
				$(".select_chemist_result").show();
				$(".select_chemist_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
				$.ajax({
					type       : "POST",
					data       :  { keyword : keyword} ,
					url        : "<?php echo base_url(); ?>Chemist_medicine/search_chemist_api",
					cache	   : false,
					error: function(){
						$(".select_chemist_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
					},
					success    : function(data){
						if(data.items=="")
						{
							$(".select_chemist_result").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
						}
						else
						{
							$(".select_chemist_result").html("");
						}
						$.each(data.items, function(i,item){	
							if (item){
								id	 		= item.id;
								chemist_id	= item.chemist_id;
								
								new_i = parseInt(new_i) + 1;
								li_css = "";
								if(new_i%2==0) 
								{ 
									li_css = "search_page_gray"; 
								} 
								else 
								{  
									li_css = "search_page_gray1"; 
								}
								
								a_ = 'onclick=select_chemist("'+chemist_id+'")';
								csshover1 = 'hover_'+new_i;
								
								$(".select_chemist_result").append('<li class="search_page_hover '+li_css+' '+csshover1+'"><a href="#" class="search_page_hover_a select_chemist_'+new_i+'" '+a_+'><div class="row"><div class="col-sm-2 col-3"><img src="'+item.user_image+'" class="account_page_header_image"></div><div class="col-sm-10 col-9 text-left"><div class="select_chemist_name">'+item.user_name+'</div><div class="select_chemist_code"> Code : '+item.chemist_id+'</div></div></div></a></li>');
							}
						});					
					}
				});
			}
		}
		else{
			$(".clear_search_box").hide();
			$(".select_chemist_result").html("");
		}
}
function select_chemist(id)
{	
	window.location.href = "<?= base_url();?>import_order/?chemist_id="+id;
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
</script>