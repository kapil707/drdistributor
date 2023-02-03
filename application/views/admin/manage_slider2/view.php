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
							Function Type
						</th>
						<th>
							Select
						</th>
						<th>
							Image
						</th>
                        <th>
                        	Action
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
                        	<?= $row->short_order ?>
                        </td>
						<td>
                        	<?if($row->funtype=="0"){ ?>Not Need<?php } ?>
							<?if($row->funtype=="1"){ ?>Item <?= $row->itemid; ?><?php } ?>
							<?if($row->funtype=="2"){ ?>Company <?= $row->compid; ?><?php } ?>
                        </td>
						<td>
							<?if($row->funtype=="1"){ ?>
								<?php $itemid = $row->itemid; ?>
								<?php 
								$row1 =  $this->db->query ("select item_name from tbl_medicine where id='$itemid'")->row();?>
								<?= $row1->item_name?>
							<?php } ?>
							<?if($row->funtype=="2"){ ?>
								<?php $compid = $row->compid; ?>
								<?php 
								$row1 =  $this->db->query ("select company_name from tbl_medicine where compcode='$compid'")->row();?>
								<?= $row1->company_name?> / <?= $row->division; ?>
							<?php } ?>
                        </td>
						<td>
						    <img src="<?= $url_path ?><?= $row->image; ?>" width="100px" />
						</td>
                        <td>
                        	<div class="btn-group">
								<a href="edit/<?= $row->id; ?>" class="btn-white btn btn-xs">Edit
								</a>
								<?php if($count==0 && $count1==0) { ?>
								<a href="javascript:void(0)" onclick="delete_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
								<?php } ?>
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