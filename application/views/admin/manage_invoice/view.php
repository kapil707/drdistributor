<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
		<?php */ ?>
		<form method="post">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
					<div class="input-group date nk-int-st">
						<label>Select Date</label>
						<span class="input-group-addon"></span>
						<input type="text" class="form-control" value="<?= $vdt1; ?>" name="vdt">
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
				<button type="submit" name="submit" class="btn btn-success notika-btn-success waves-effect" value="submit">Submit</button>
			</div>
		</form>
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
							GSTVNO
						</th>
						<th>
							Date
						</th>
						<th>
							Chemist
						</th>
						<th>
							Total Amount
						</th>
						<th>
							View Order
						</th>
                    </tr>
                </thead>
                <tbody>
                <?php
				$i=1;
				$total_amount = 0;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $i; ?>">
                    	<td>
                        	<?= $i; ?>
                        </td>
						<td>
                        	<?= $row->gstvno;?>
                        </td>
						<td>
                        	<?= date("d-M-y",strtotime($row->date))?>
                        </td>
						<td>
							<?php
							$row2 = $this->db->query("select name,altercode from tbl_acm where code='$row->acno'")->row();
							?>
							<?= $row2->name; ?> (<?= $row2->altercode;?>)
                        </td>
						<td>
                        	<?php echo money_format('%!i',$row->amt); ?>
							<?php $total_amount = $total_amount + $row->amt; ?>
                        </td>
						<td class="text-right">
							<div class="btn-group">
								<a href="http://drdistributor.com/invoice/<?= $row2->altercode;?>/<?= $row->gstvno;?>" class="btn-white btn btn-xs" target="_blank">View</a>
							</div>
                        </td>
					</tr>
                    <?php
						$i++;
                    }
                    ?>
                </tbody>
				<tfoot>
                    <tr>
                    	<th>
                        	Total
                        </th>
						
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							<?php echo money_format('%!i',$total_amount); ?>
						</th>
						<th>
							
						</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
function create_copy_order(id)
{
	if (confirm('Are you sure Resend?')) { 
		order_id = $(".order_id_"+id).val();
		$.ajax({
		type       : "POST",
		data       :  {order_id:order_id},
		url        : "<?= base_url()?>admin/<?= $Page_name; ?>/create_copy_order",
		success    : function(data){
				if(data!="")
				{
					java_alert_function("success","Created Successfully");
				}
				else
				{
					java_alert_function("error","Something Wrong")
				}
			}
		});
	}
}
</script>