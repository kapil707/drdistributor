<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">	<?php /*<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a> */ ?>
   	</div>
    <div class="col-xs-12">
        <div class="table-responsive">
			<table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Altercode
						</th>
						<th>
							Message
						</th>
						<th>
							Email / Phone
						</th>
                    </tr>
                </thead>				<tbody>
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
							<?= $row->altercode; ?>
                        </td>
						<td>
							<?= $row->message; ?>
                        </td>
						<td>
							<?= $row->mobile; ?>
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
	$(".loadingcss_"+id).html("Loading....");	password = $(".password_"+id).val();
	$.ajax({
	type       : "POST",
	data       :  { id : id ,password:password} ,
	url        : "<?= base_url()?>admin/<?= $Page_name; ?>/password_create1",
	success    : function(data){			if(data!="")
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