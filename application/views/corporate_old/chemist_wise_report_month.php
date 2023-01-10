<style>
.menubtn1
{
	display:none;
}
</style>
<script>
$(".headertitle").html("Chemist wise report monthly");
</script>
<div class="container all_page_main_part">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class='row'>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							 <input type='text' class="form-control monthdate" id="month" name="month" value="" placeholder="Select month" />
							<span class="input-group-addon d-xs-none d-md-block">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31" onclick="call_page()">Submit</button>
					</div>
				</div>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31 downloadbtn" onclick="call_download()" style="display:none;">Download</button>
					</div>
				</div>
			</div>
			<div class="load_page" style="margin-top:10px;">
				
			</div>
			<div class="load_page_loading">
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script>
$('#from').datetimepicker({format: 'DD-MMM-YYYY'});
$('#to').datetimepicker({format: 'DD-MMM-YYYY'});
$('#month').datetimepicker({format: 'MMM'});
</script>    
<script>
function call_page()
{
	user_session	=	'<?=$_SESSION["user_session"]?>';
	user_division	=	'<?=$_SESSION["user_division"]?>';
	user_compcode	=	'<?=$_SESSION["user_compcode"]?>';
	
	$(".downloadbtn").hide();
	monthdate   = $(".monthdate").val();
	if(monthdate=="")
	{
		alert("Select month")
		return false;
	}
	$(".load_more").hide();
	$(".load_page").html("");
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {user_session:user_session,user_division:user_division,user_compcode:user_compcode,monthdate:monthdate} ,
		url        : "<?php echo base_url(); ?>corporate/chemist_wise_report_api",
		cache	   : false,
		error: function(){
			$(".load_page_loading").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success    : function(data){
			if(data!="")
			{
				$(".load_page_loading").html("");
			}
			var itc1 = "";
			var itc2 = "";
			$.each(data.items, function(i,item){	
				if (item){
					if(item.permission!="")
					{
						$(".load_page").append('<center>'+item.permission+'</center>');
					}
					else
					{
						$(".downloadbtn").show();
						itc1 = item.acno;
						if(itc1!=itc2)
						{
							itc2 = item.acno;
							$(".load_page").append('<div class="row list_item_radius" style="margin-top:25px;"><div class="col-sm-6 col-6 cart_chemist_name">'+atob(item.chemist_name)+' <span class="cart_chemist_code">('+item.chemist_id+')</span></div><div class="col-sm-6 col-6 text-right cart_chemist_phone">'+atob(item.chemist_mobile)+'<Br>'+atob(item.chemist_address)+'</div></div>');					
						}
						$(".load_page").append('<div class="row list_item_radius"><div class="col-sm-6 col-6 cart_title">'+atob(item.item_name)+'  <span class="cart_packing">('+atob(item.item_packing)+' Packing)</span></div><div class="col-sm-6 col-6 text-right cart_date_time">Date : '+item.date+'</div><div class="col-sm-6 col-6 cart_stock">Quantity : '+item.qty+'</div><div class="col-sm-6 col-6 text-right cart_stock_free">Free Quantity : '+item.fqty+'</div></div>');
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
	monthdate = $(".monthdate").val();
	if(monthdate=="")
	{
		alert("Select Month")
		return false;
	}
	window.location.href = "<?= constant('api_url') ?>staff_download_chemist_wise_report_month/<?= $user_session; ?>/<?= $user_division; ?>/<?= $user_compcode; ?>/"+monthdate;
	$(".downloadbtn").show(10000);
}
</script>