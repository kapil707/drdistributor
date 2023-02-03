<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">	<?php /*<a href="add">
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
							Altercode
						</th>
						<th>
							Name
						</th>
						<th>
							Phone
						</th>
						<th>
							Address
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
						<?php
						$row1 = $this->db->query("select * from tbl_acm where altercode='$row->altercode'")->row();
						?>
						<td>
							<?= $row1->name; ?>
                        </td>
						<td>
							<?= $row1->mobile; ?>
                        </td>
						<td>
							<?= base64_decode($row1->address); ?>,
							<?= base64_decode($row1->address1); ?>,
							<?= base64_decode($row1->address2); ?>,
							<?= base64_decode($row1->address3); ?>
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