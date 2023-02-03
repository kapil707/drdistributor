<style>
.menubtn1
{
	display:none;
}
/*.headertitle
{
    margin-top: 5px !important;
}*/
.headertitle
{
    margin-top: 0px !important;
    font-size: 14px;
}
@media screen and (max-width: 767px) {
	.homebtn_div
	{
		display:none;
	}
}
</style>
<script>
$(".headertitle").html("<?= ($gstvno);?>");
function goBack() {
	window.location.href = "<?= base_url();?>home/my_invoice";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-3 col-6 download_excel_url" style="margin-top:5px;margin-bottom:5px;">
					
				</div>
				<table class="table table-striped table-bordered" aria-describedby>
					<thead>
						<tr>
							<th style="width:50px;" scope>
								S.No.
							</th>
							<th scope>
								Item name
							</th>
							<th style="width:150px;" scope>
								Batch No.
							</th>
							<th style="width:150px;" scope>
								Expiry
							</th>
							<th style="width:150px;" scope>
								Quantity
							</th>
							<th style="width:150px;" scope>
								Free Quantity
							</th>
							<th style="width:150px;" scope>
								Total
							</th>
						</tr>
					</thead>
					<tbody class="load_page">

					</tbody>
					<tfoot class="load_page_tfoot">

					</tfoot>
				</table>
				<div class="col-sm-12 col-12 text-center div_item_delete" style="display:none" style="margin-top:5px;margin-bottom:5px;">
					<h4>Quantity changed and items deleted</h4>
				</div>
				<table class="table table-striped table-bordered div_item_delete" aria-describedby style="display:none">
					<thead>
						<tr>
							<th style="width:200px;" scope>
								Item name
							</th>
							<th style="width:100px;" scope>
								Quantity
							</th>
							<th style="width:100px;" scope>
								Total qty
							</th>
							<th style="width:200px;" scope>
								Descp
							</th>
							<th scope>
								Remarks
							</th>
						</tr>
					</thead>
					<tbody class="load_page1">

					</tbody>
				</table>
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
sno = 0;
function call_page(lastid1)
{
	user_type 		= "chemist";
	user_altercode 	= "<?php echo $chemist_id; ?>";
	gstvno			= "<?php echo $gstvno; ?>";
	
	$(".load_more").hide();
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {lastid1:lastid1,user_type:user_type,user_altercode:user_altercode,gstvno:gstvno} ,
		url        : "<?php echo base_url(); ?>Chemist_json/my_invoices_view_api",
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
					if(item.inv_type=="insert")
					{
						$(".download_excel_url").html(atob(item.download_excel_url));
						$(".headertitle").html("<?= ($gstvno);?><br>"+item.date);

						$(".load_page_tfoot").html('<tr><td>Total</td><td></td><td></td><td></td><td></td><td></td><td class="cart_ptr text-right"><i class="fa fa-inr" aria-hidden="true"></i>'+item.total_price+'/-</td></tr>');

						sno = parseInt(sno) + 1
						
						$(".load_page").append('<tr><td>'+sno+'</td><td class="text-capitalize cart_title">'+atob(item.item_name)+'</td><td class="cart_batch_no">'+item.batch+'</td><td class="cart_expiry">'+item.expiry+'</td><td class="cart_stock">'+item.qty+'</td><td class="cart_stock">'+item.fqty+'</td><td class="cart_ptr text-right"><i class="fa fa-inr" aria-hidden="true"></i>'+item.mrp+'/-</td></tr>');
					}
					if(item.inv_type=="delete")
					{
						$(".div_item_delete").show();
						$(".load_page1").append('<tr><td class="text-capitalize cart_title">'+atob(item.item_name)+'</td><td class="cart_stock">'+item.delete_amt+'</td><td class="cart_stock">'+item.delete_namt+'</td><td class="cart_ptr">'+item.delete_descp+'</td><td class="cart_ptr">'+item.delete_remarks+'</td></tr>');
					}
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