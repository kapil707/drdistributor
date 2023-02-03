<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
		<a href="add" class="btn btn-info">
			Add Pending Order File
        </a>
		<a href="add2" class="btn btn-info">
			Add Shortage Report File
        </a>
		<a href="<?=base_url(); ?>admin/manage_pending_order/download_pending_order_medicine"  class="btn btn-primary">Download File</a>
		
		<a href="add3" class="btn btn-info">
			Add Final File
        </a>
		<br><br>
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">    
			<?= $row1->email; ?>
			<a class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				Add Your Email / Password
			</a>
		
			<button type="submit" class="btn btn-primary" name="Submit1">
				Demo Email Send</button>			 
			 
			<button type="submit" class="btn btn-primary" name="Submit2">
				Email Start</button>
				
			<button type="submit" class="btn btn-danger" name="Submit3">
				Email Stop</button>
				
			<button type="submit" class="btn btn-danger" name="Submit4">
				Clear All Data</button>
			
		</form>
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
                        	Company
                        </th>
						<th>
                        	Item Code
                        </th>
                        <th>
                        	Item Name
                        </th>						<th>                        	Pack                        </th>						<th>                        	Qty                        </th>						<th>                        	F Qty                        </th>						<th>                        	Division                        </th>
						<th>
                        	Status
                        </th>
						<th>
                        	Delete
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
                        	<?= $row->company; ?>
                        </td>
						<td>							<?= $row->item_code; ?>
                        </td>
						<td>							<?= $row->item_name; ?>                        </td>						<td>							<?= $row->pack; ?>                        </td>						<td>							<input type="number" value="<?= $row->qty; ?>" onchange="change_qty('<?= $row->id; ?>')" class="qty_<?= $row->id; ?>">                        </td>						<td>							<?= $row->f_qty; ?>                        </td>						<td>							<?= $row->division; ?>                        </td>
						<td>
							<?php if($row->status==0){ echo "Stop";} else { echo "Start";}?>
                        </td>
						<td>
							<a href="javascript:void(0)" onclick="delete_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
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
	{		delete_rec1 = 1;
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
var change_qty1 = 0;
function change_qty(id)
{
	if(change_qty1==0)
	{
		qty = $(".qty_"+id).val();
		change_qty1 = 1;
		if(parseInt(qty)<10)
		{
			java_alert_function("error","Enter greater than 9 qty");
			//alert("Enter greater than 9 qty")
			change_qty1 = 0;
			$(".qty_"+id).val("10");
		}
		else
		{
			$.ajax({
				type       : "POST",
				data       :  { id:id,qty:qty,} ,
				url        : "<?= base_url()?>admin/<?= $Page_name; ?>/change_qty",
				success    : function(data){
					if(data!="")
					{
						java_alert_function("success","Update Successfully");
					}
					else
					{
						java_alert_function("error","Something Wrong")
					}
					change_qty1 = 0;
				}
			});
		}
	}
}
</script>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
			<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
				</div>
				<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
				</div>
				<button type="submit" class="btn btn-primary" name="Submit">
				Submit</button>
			</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>