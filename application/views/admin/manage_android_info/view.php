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
                        	Sno.
                        </th>
						<th>
							User
						</th>
						<th>
							Version
						</th>
						<th>
							Cart
						</th>
						<th>
							Logout
						</th>
						<th>
							Clear Data
						</th>
						<th>
							Broadcast
						</th>
                    </tr>
                </thead>
				<tbody>
                <?php
				$i=1;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $row->id; ?>">
                    	<td>
                        	<?= $i++; ?>
                        </td>
						<td>
							<?php if($row->user_type=="chemist") { ?>
							<?= $row->name; ?> (<?= $row->chemist_id; ?>) - chemist
							<?php } ?>
							
							<?php if($row->user_type=="sales") { ?>
							<?php
							$row1 = $this->db->query("select * from tbl_users where customer_code='$row->chemist_id'")->row();
							?>
							<?= $row1->firstname; ?> <?= $row1->lastname; ?> (<?= $row->chemist_id; ?>) - SalesMan
							<?php } ?><br>
							<?= date("d-M-y h:i a ",$row->time); ?>
                        </td>
						<td>
							<?= $row->versioncode; ?>
                        </td>
						<td>
							<?= $row->count_draft; ?>
                        </td>
						<td>
							<?php if($row->logout==0) { ?>
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to Logout?');">
							<input type="hidden" name="id1" value="<?=$row->id; ?>"/>
							<button type="submit" class="btn btn-info submit_button" name="Submit1">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Logout
							</button>
							</form>
							<?php } else { ?>
							Logout Ready To Process
							<?php } ?>
                        </td>
						<td>
							<?php if($row->clear_database==0) { ?>
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to submit the Clear Database?');">
							<input type="hidden" name="id2" value="<?=$row->id; ?>"/>
							<button type="submit" class="btn btn-info submit_button" name="Submit2">
							<i class="ace-icon fa fa-check bigger-110"></i>
							Clear Database
							</button>
							</form>
							<?php } else { ?>
							Clear Database Ready To Process
							<?php } ?>
                        </td>
						<td>
							<?= base64_decode($row->broadcast); ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function password_create1(id)
{
	$(".loadingcss_"+id).html("Loading....");
	password = $(".password_"+id).val();
	$.ajax({
	type       : "POST",
	data       :  { id : id ,password:password} ,
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
</script>