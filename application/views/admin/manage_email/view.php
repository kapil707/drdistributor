<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
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
                        	Add Replyto<br>
                        	Add Replyto Name                        </th>						<th>                        	Server Email<br>                        	Server Email Name                        </th>						<th>                        	Email<br>                        	Email Bcc                        </th>						<th>                        	Email Function<br>                        	Live Or Demo                        </th>
                        <th>
                        	Action
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
                        	<?= $row->addreplyto; ?><br>
                        	<?= $row->addreplyto_name; ?>
                        </td>						<td>                        	<?= $row->server_email; ?><br>                        	<?= $row->server_email_name; ?>                        </td>						<td>                        	<?= $row->email; ?><br>                        	<?= $row->email_bcc; ?>                        </td>						<td>                        	<?= $row->email_function; ?><br>                        	<?= $row->live_or_demo; ?>                        </td>
                        <td class="text-right">
							<div class="btn-group">
								<a href="edit/<?= $row->id; ?>" class="btn-white btn btn-xs">Edit
								</a>								<a href="javascript:void(0)" onclick="delete_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
							</div>
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
var delete_rec1 = 0;
function delete_rec(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_rec",
			success    : function(data){
					if(data!="")
					{
						java_alert_function("success","Delete Successfully");
						$("#row_"+id).hide("500");
					}
					else
					{
						java_alert_function("error","Something Wrong")
					}
					delete_rec1 = 0;
				}
			});
		}
	}
}
</script>