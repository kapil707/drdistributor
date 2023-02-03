<style>
.menubtn1
{
	display:none;
}
</style>
<script>
$(".headertitle").html("Stock And Sales Analysis");
</script>
<div class="container all_page_main_part">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-8 col-12">
					Company : <?= base64_decode($_SESSION['user_compname']); ?>
					<br>
					From : 
					<?php
					$time 	= time();
					$d1 	= "01".date("-M-y",$time);
					$d2 	= date("d-M-y",$time);
					?>
					<?= $d1?> To: <?= $d2?>
				</div>
				<div class="col-sm-4 col-12">	
					<button type="submit" name="submit" class="btn btn-success btn-block downloadbtn" onclick="call_download()" style="display:none;">Download</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Item</th>
							<th>Pack</th>
							<th>Opening</th>
							<th>Purchase / Return</th>
							<th>Sale</th>
							<th>Closing</th>
						</tr>
					</thead>
					<tbody class="load_page">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
  
<script>
$(document).ready(function(){
	call_page();
});
function call_page()
{
	user_session	=	'<?=$_SESSION["user_session"]?>';
	user_division	=	'<?=$_SESSION["user_division"]?>';
	user_compcode	=	'<?=$_SESSION["user_compcode"]?>';
	
	$(".load_page").html('<tr><td colspan="6"><h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1></td></tr>');
	$.ajax({
		type       : "POST",
		data       :  {user_session:user_session,user_division:user_division,user_compcode:user_compcode,} ,
		url        : "<?php echo base_url(); ?>corporate/stock_and_sales_analysis_api",
		cache	   : false,
		error: function(){
			$(".load_page").html('<tr><td colspan="6"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1></td></tr>');
		},
		success    : function(data){
			$(".load_page").html("");
			$.each(data.items, function(i,item){	
				if (item){
					if(item.permission!="")
					{
						$(".load_page").append('<center>'+item.permission+'</center>');
					}
					else
					{
						$(".downloadbtn").show();
						$(".load_page").append('<tr><td>'+atob(item.item_name)+'</td><td>'+atob(item.packing)+'</td><td>'+(item.qty)+'</td><td>'+(item.purchase)+'</td><td>'+(item.sale)+'</td><td>'+(item.closing)+'</td></tr>');
					}
				}
			});	
		},
		timeout: 10000
	});
}
function call_download()
{
	$(".downloadbtn").hide();
	formdate = $(".formdate").val();
	todate   = $(".todate").val();
	if(formdate=="")
	{
		alert("Select Date from")
		return false;
	}
	if(todate=="")
	{
		alert("Select Date to")
		return false;
	}
	window.location.href = "<?php echo constant('api_url'); ?>api_website_html/staff_download_stock_and_sales_analysis/<?= $user_session; ?>/<?= $user_division; ?>/<?= $user_compcode; ?>";
	$(".downloadbtn").show(10000);
}
</script>