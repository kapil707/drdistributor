<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<script>
$(".headertitle").html("Hot Deals");
</script>
<div class="container all_page_main_part">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12 load_page">
				
				</div>
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
			</div>
		</div>
	</div>     
</div>
<script>
$(document).ready(function(){
	call_page("kapil");
});
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page("0")
}
function call_page(lastid1)
{
	new_i = 0;
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
	type       : "POST",
	data       :  { lastid1:lastid1} ,
	url        : "<?php echo base_url(); ?>Chemist_json/hot_deals_apis",
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
				salescm = '';
				if(item.scheme=="0+0")
				{
					salescm = '';
				}
				else
				{
					salescm = '<span class="search_page_scheme">Scheme: '+item.scheme+'</span>';
				}
				
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
				
				$(".load_page").append('<li class="search_page_hover '+li_css+'"><a href="javascript:void(0)" onClick="get_single_medicine_info('+item.i_code+')" style="text-decoration: none;"><div class="row"><div class="col-sm-6 col-6 text_cut_or_dot text-capitalize search_page_title">'+item.item_name+'</div><div class="col-sm-6 col-6 text-right">'+salescm+'</div><div class="col-sm-6 col-6 search_page_mrp">MRP: <i class="fa fa-inr" aria-hidden="true"></i>'+item.mrp+'/-</div><div class="col-sm-6 col-6 text-right search_page_ptr">PTR: <i class="fa fa-inr" aria-hidden="true"></i>'+item.sale_rate+'/-</div></div></a></li>');
				//$(".lastid1").val(item.lastid1);
				if(item.sec_row!="")
				{
					//$(".load_more").show();
				}
			}
		});	
		},
		timeout: 10000
	});
}
</script>