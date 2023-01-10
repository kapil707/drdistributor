<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
    	<?php /*<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a> */ ?>
   	</div>
    <div class="col-xs-12">
        <div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
						<th>
							Code
						</th>
						<th>
                        	Name
                        </th>
						<th>
                        	Email / 
                        	Mobile /
                        	Address
                        </th>
						<th>
                        	Login Expired
                        </th>
						<th>
                        	Status
                        </th>
						<th>
                        	Delete
                        </th>
                        <th>
                        	Create Password
                        </th>
                    </tr>
                </thead>
				<tbody class="load_page">
					<?php
					$i=1;
					foreach ($result as $row)
					{
						?>
						<tr id="row_<?= $row->id; ?>">
							<td><?= $row->altercode; ?></td>
							<td><?= $row->name; ?></td>
							<td><?= $row->email; ?><br><?= $row->mobile; ?><br><?= $row->address; ?></td>
							<td><?= $row->exp_date; ?></td>
							<td><?= $row->status; ?></td>
							<td class="text-right">
								<form method="post">
									<input type="hidden" name="code" value="<?= $row->altercode; ?>">
									<button type="submit" class="btn btn-primary" name="Submit">Delete</button>
								</form>
							</td>						
							<td>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_<?= $row->id; ?>">Create New</button><div class="modal" id="myModal_<?= $row->id; ?>'"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Create New Password</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body"><div class="row"><div class="col-sm-12"><input type="password" name="password" class="form-control password_<?= $row->id; ?>" placeholder="New Password" style="width: 100%;"></div><div class="col-sm-12 loadingcss_<?= $row->id; ?>" style="margin-top:5px;margin-bottom:5px;"></div><div class="col-sm-6"><input type="submit" name="Submit1" class="btn btn-info" value="Create Password" onclick="password_create1('<?= $row->id; ?>)"></div><div class="col-sm-6 text-right"><input type="submit" name="Submit" class="btn btn-info" value="Random Create Password" onclick="password_create2('<?= $row->id; ?>')"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-danger myModalClose" data-dismiss="modal">Close</button></div></div></div></div>
							</td>
						</tr>
					<?php } ?>
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
function password_create1(id)
{
	$(".loadingcss_"+id).html("Loading....");
	password = $(".password_"+id).val();
	$.ajax({
	type       : "POST",
	data       :  {id:id,password:password},
	url        : "<?= base_url()?>admin/<?= $Page_name; ?>/password_create1",
	success    : function(data){
			if(data!="")
			{
				//alert(data);
				java_alert_function("success","Password Created Successfully");
				$(".loadingcss_"+id).html("");
				$(".myModalClose").click();
				$(".password_"+id).val('');
			}
			else
			{
				java_alert_function("error","Something Wrong")
			}
		}
	});
}
function password_create2(id)
{
	$(".loadingcss_"+id).html("Loading....");
	$.ajax({
	type       : "POST",
	data       :  {id:id},
	url        : "<?= base_url()?>admin/<?= $Page_name; ?>/password_create2",
	success    : function(data){
			if(data!="")
			{
				java_alert_function("success","Password Created Successfully");
				$(".loadingcss_"+id).html("");
				$(".myModalClose").click();
				$(".password_"+id).val('');
			}
			else
			{
				java_alert_function("error","Something Wrong")
			}
		}
	});
}
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
				exp_date	= item.exp_date;
				status	 	= item.status;
				id	 		= item.id;
				address		= atob(item.address);
				if(status=="1")
				{
					status = "Active";
				}
				else
				{
					status = "Inactive";
				}
				mod = modalopen(id);
				$(".load_page").append('<tr><td>'+altercode+'</td><td>'+name+'</td><td>'+email+'<br>'+mobile+'<br>'+address+'</td><td>'+exp_date+'</td><td>'+status+'</td><td class="text-right"><div class="btn-group"><a href="edit/'+id+'" class="btn-white btn btn-xs">Edit</a></div></td><td>'+mod+'</td></tr>');
				$(".lastid1").val(item.id);
				if(item.css!="")
				{
					//$(".load_more").show();
				}
			}
		});	
		}
	});
}
//setTimeout('call_page("kapil");',1000);
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page(lastid1)
}
function call_page(lastid1)
{
	$(".load_more").hide();
	$(".load_page_loading").html("<center>Loading....</center>");
	$.ajax({
	type       : "POST",
	data       :  {lastid1:lastid1},
	url        : "<?php echo base_url(); ?>admin/<?= $Page_name ?>/alldata/post/",
	cache	   : false,
	success    : function(data){
		if(data!="")
		{
			$(".load_page_loading").html("");
		}
		$.each(data.items, function(i,item){
			if (item){
				altercode	= item.altercode;
				name	 	= item.name;
				email	 	= item.email;
				mobile	 	= item.mobile;
				exp_date	= item.exp_date;
				status	 	= item.status;
				id	 		= item.id;
				if(status=="")
				{
					status = "Active";
				}
				else
				{
					status = "Inactive";
				}
				mod = modalopen(id);
				$(".load_page").append('<tr><td>'+id+'</td><td>'+altercode+'</td><td>'+name+'</td><td>'+email+'</td><td>'+mobile+'</td><td>'+exp_date+'</td><td>'+status+'</td><td class="text-right"><div class="btn-group"><a href="edit/'+id+'" class="btn-white btn btn-xs">Edit</a></div></td><td>'+mod+'</td></tr>');
				$(".lastid1").val(item.id);
				if(item.css!="")
				{
					$(".load_more").show();
				}
			}
		});	
		}
	});
}
function modalopen(id)
{
	x = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_'+id+'">Create New</button><div class="modal" id="myModal_'+id+'"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Create New Password</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body"><div class="row"><div class="col-sm-12"><input type="password" name="password" class="form-control password_'+id+'" placeholder="New Password" style="width: 100%;"></div><div class="col-sm-12 loadingcss_'+id+'" style="margin-top:5px;margin-bottom:5px;"></div><div class="col-sm-6"><input type="submit" name="Submit1" class="btn btn-info" value="Create Password" onclick="password_create1('+id+')"></div><div class="col-sm-6 text-right"><input type="submit" name="Submit" class="btn btn-info" value="Random Create Password" onclick="password_create2('+id+')"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-danger myModalClose" data-dismiss="modal">Close</button></div></div></div></div>';
	return x;
}
</script>