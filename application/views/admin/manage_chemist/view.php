<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
    	<?php /*<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a> */ ?>
   	</div>
	<div class="col-xs-6">
		<div class="form-group">
			<label for="text">Search Name / AlterCode:</label>
			<input type="text" class="form-control search" id="search" placeholder="Search Name / AlterCode:">
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group" style="margin-top:22px;">
			<button type="submit" class="btn btn-primary" onclick="search_user()">Search</button>
		</div>
	</div>
    <div class="col-xs-12">
        <div class="table-responsive">
			<table id="data-table-basic" class="table table-striped" aria-labelledby>
                <thead>
                    <tr>
						<th scope>
							Name / Code
						</th>
						<th scope>
                        	Email / 
                        	Mobile /
                        	Address
                        </th>
						<th scope>
							Order Limit
						</th>
						<th scope>
                        	Status
                        </th>
						<th scope>
                        	Edit
                        </th>
						<th scope>
                        	Logout
                        </th>
                    </tr>
                </thead>
				<tbody class="load_page">
				
                </tbody>
            </table>
			<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
		
			</div>
			<div class="col-sm-12" style="margin-top:10px;">
				<button onclick="call_page_by_last_id()" class="load_more btn btn-success btn-block" style="display:none">Load More</button>
			</div>
        </div>
    </div>
</div>
<input type="hidden" class="lastid1">
<script>
function search_user()
{
	search = $(".search").val();
	$(".load_more").hide();
	$(".load_page_loading").html("<center>Loading....</center>");
	$.ajax({
		type       : "POST",
		data       :  {search:search},
		url        : "<?php echo base_url(); ?>admin/<?= $Page_name ?>/search_user/post/",
		cache	   : false,
		error: function(){
			$(".load_page_loading").html("");
			$(".load_page").html('<h1><center><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></center></h1>');
		},
		success    : function(data){
			if(data!="")
			{
				$(".load_page_loading").html("");
				$(".load_page").html("");
			}
			$.each(data.items, function(i,item){
				if (item){
					altercode	= atob(item.altercode);
					name	 	= atob(item.name);
					email	 	= atob(item.email);
					mobile	 	= atob(item.mobile);
					status	 	= item.status;
					order_limit = item.order_limit;
					id	 		= item.id;
					address		= atob(item.address);
					logout_btn = '<a href="javascript:void(0)" onclick=logout_fun("'+altercode+'")>Logout</a>';
					
					$(".load_page").append('<tr><td>'+name+'<br> Code : '+altercode+'</td><td>'+email+'<br>'+mobile+'<br>'+address+'</td><td>Order Limit Rs.'+order_limit+' /-</td><td>'+status+'</td><td><div class="btn-group"><a href="edit/'+id+'" class="btn-white btn btn-xs">Edit</a></div></td><td>'+logout_btn+'</td></tr>');
					$(".lastid1").val(item.id);
					if(item.css!="")
					{
						//$(".load_more").show();
					}
				}
			});	
		},
		timeout: 10000
	});
}
function logout_fun(altercode)
{
	$.ajax({
		type       : "POST",
		data       :  {altercode:altercode},
		url        : "<?php echo base_url(); ?>admin/<?= $Page_name ?>/user_logout",
		cache	   : false,
		success    : function(data){
			if(data!="")
			{
				swal("Error");
			}
			$.each(data.items, function(i,item){
				if (item){
					swal("Logout Successfully");
				}
			});	
		}
	});
}
</script>