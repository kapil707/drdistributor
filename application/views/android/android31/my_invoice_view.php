<div class="container" style="margin-top:-100px;">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-3 col-6 download_excel_url" style="margin-top:5px">
					
				</div>
				<div class="col-sm-9 col-6" style="margin-top:5px">
					
				</div>
				<div class="col-sm-6 col-6 text-left div_gstvno search_page_mrp" style="margin-top:10px;">
					
				</div>
				<div class="col-sm-6 col-6 text-right div_date search_page_mrp" style="margin-top:10px;">
					
				</div>
				<div class="col-sm-6 col-6 text-left div_total_price search_page_mrp" style="margin-top:10px;">
				</div>
				
				<div class="col-sm-6 col-6 text-right div_status search_page_mrp" style="margin-top:10px;">
				</div>
				<div class="col-sm-12 col-12 load_page" style="margin-bottom:20px;">
					
				</div>
				<div class="col-sm-12 col-12 text-center div_item_delete" style="display:none">
					<h4>Quantity Changed and Items Deleted</h4>
				</div>
				<div class="col-sm-12 col-12 load_page1" style="margin-bottom:20px;">
					
				</div>
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
				<div class="col-sm-12" style="margin-top:10px;">
					<button onclick="call_page_by_last_id()" class="load_more btn btn-success btn-block">Load More</button>
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
	call_page(lastid1)
}
function call_page(lastid1)
{
	user_type 		= "chemist";
	user_altercode 	= "<?php echo $user_altercode; ?>";
	
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	gstvno	= "<?php echo $gstvno; ?>";
	$.ajax({
		type       : "POST",
		data       :  {lastid1:lastid1,user_type:user_type,user_altercode:user_altercode,gstvno:gstvno} ,
		url        : "<?php echo base_url(); ?>android/api_mobile31/my_invoices_view",
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
				if (item){
					if(item.inv_type=="insert")
					{
						$(".download_excel_url").html(atob(item.download_excel_url));
						$(".div_gstvno").html('Invoice: '+item.gstvno);
						$(".div_date").html('Date: '+item.date);
						$(".div_status").html(item.status);
						$(".div_total_price").html('Total: <i class="fa fa-inr" aria-hidden="true"></i>'+item.total_price+'/-');
						
						$(".load_page").append('<li class="list_item_radius"><div class="row"><div class="col-sm-6 col-6 text_cut_or_dot text-capitalize search_page_title">'+item.item_name+'</div><div class="col-sm-6 col-6 text-right text_cut_or_dot search_page_batch_no">Batch No: '+item.batch+'</div><div class="col-sm-6 col-6 search_page_exp">Expiry: '+item.expiry+'</div><div class="col-sm-6 col-6 text-right search_page_stock ">Quantity: '+item.qty+'</div><div class="col-sm-6 col-6 search_page_stock">Free Quantity: '+item.fqty+'</div><div class="col-sm-6 col-6 text-right search_page_mrp">PTR: <i class="fa fa-inr" aria-hidden="true"></i>'+item.mrp+'/-</div></div></li>');
					}
					if(item.inv_type=="delete")
					{
						$(".div_item_delete").show();
						$(".load_page1").append('<li class="list_item_radius"><div class="row"><div class="col-sm-6 col-6 text_cut_or_dot text-capitalize search_page_title">'+item.item_name+'</div><div class="col-sm-6 col-6 text-right text_cut_or_dot search_page_batch_no">Descp: '+item.delete_descp+'</div><div class="col-sm-6 col-6 search_page_stock">Total Qty: '+item.delete_amt+'</div><div class="col-sm-6 col-6 text-right search_page_stock">Change Qty: '+item.delete_namt+'</div><div class="col-sm-12 col-12 search_page_mrp">Remarks: '+item.delete_remarks+'</div></div></li>');
					}
					//$(".lastid1").val(item.lastid1);
					if(item.sec_row!="")
					{
						//$(".load_more").show();
					}
				}
			});	
		}
	});
}
</script>