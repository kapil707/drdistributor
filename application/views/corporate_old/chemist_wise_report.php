<style>
.menubtn1
{
	display:none;
}
</style>
<script>
$(".headertitle").html("Chemist wise report");
</script>
<div class="container all_page_main_part">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class='row'>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							<input type='text' class="form-control formdate" id="from" name="from" value="" placeholder="Select date from" data-date-format="DD-MMM-YYYY">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>

				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker2' style="width: 100%">
							<input type='text' class="form-control todate" id="to" name="to" value="" placeholder="Select date to" data-date-format="DD-MMM-YYYY">
							<span class="input-group-addon">
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
			<table class="table table-striped table-bordered" aria-describedby style="background:white" style="width:100%">
				<thead>
					<tr>
						<th style="width:100px;" scope>
							Party Name
						</th>
						<th style="width:100px;" scope>
							Item Name
						</th>
						<th style="width:50px;" scope>
							Pack
						</th>
						<th style="width:50px;" scope>
							Qty.
						</th>
						<th style="width:50px;" scope>
							Free
						</th>
						<th style="width:50px;" scope>
							Amount
						</th>
						<th style="width:200px" scope>
							Address
						</th>
						<th style="width:50px;" scope>
							MOBILE
						</th>
					</tr>
				</thead>
				<tbody class="load_page">
					
				</tbody>
			</table>
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
	$(".load_more").hide();
	$(".load_page").html("");
	$(".load_page_loading").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {user_session:user_session,user_division:user_division,user_compcode:user_compcode,formdate:formdate,todate:todate} ,
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
						$(".load_page").append('<tr><td class="cart_chemist_name">'+atob(item.chemist_name)+'</td><td class="cart_title">'+atob(item.item_name)+'</td><td class="cart_packing">('+atob(item.item_packing)+' Packing)</td><td class="cart_stock">'+item.qty+'</td><td class="cart_stock_free">'+item.fqty+'</td><td>'+item.netamt+'</td><td class="cart_chemist_phone">'+atob(item.chemist_address)+'</td><td class="cart_chemist_phone">'+atob(item.chemist_mobile)+'</td></tr>');
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
		alert("Select date from")
		return false;
	}
	if(todate=="")
	{
		alert("Select date to")
		return false;
	}
	window.location.href = "<?= constant('api_url') ?>staff_download_chemist_wise_report/<?= $user_session; ?>/<?= $user_division; ?>/<?= $user_compcode; ?>/"+formdate+"/"+todate;
	$(".downloadbtn").show(10000);
}
</script>