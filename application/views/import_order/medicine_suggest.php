<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px;
}
</style>
<?php if(!empty($chemist_id)){ ?>
<style>
.headertitle
{
	margin-top: -5px;
}
</style>
<script>
$(".headertitle1").show();
</script>
<?php } ?>
<script>
$(".headertitle").html("Suggest medicine");
function goBack() {
	window.location.href = "<?= base_url();?>import_order";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<table class="table table-striped table-bordered" aria-describedby>
				<thead>
					<tr>
						<th style="width:50px;" scope>
							S.No.
						</th>
						<th scope>
							Item Name
						</th>
						<th scope>
							Suggest Item
						</th>
						<th scope>
							Action
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$lastcount=1;
				$user_altercode	= $_SESSION["user_altercode"];
				$where = array('user_altercode'=>$user_altercode);
				$query = $this->Scheme_Model->select_all_result("drd_import_orders_suggest",$where,"your_item_name","asc");
				foreach($query as $row)
				{
					?>
					<tr class="selected_suggest_<?= $row->id ?>">
						<td><?= $lastcount++?></td>
						<td><?= ucwords(strtolower($row->your_item_name))?></td>
						<td><?= ucwords(strtolower($row->item_name))?></td>
						<td><a href="javascript:delete_suggest_by_id('<?= $row->id ?>')" title="Delete Suggest Medicine"><i class="fa fa-trash" aria-hidden="true" style="margin-left:10px; font-size:20px"></i></a></td>
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
function delete_suggest_by_id(_id)
{
	if (confirm('Are you sure Delete Suggest?')) {
		$('.selected_suggest_'+_id).hide();
		$.ajax({
			url: "<?php echo base_url(); ?>import_order/delete_suggest_by_id",
			type:"POST",
			dataType: 'html',
			data: {id:_id},
			success: function(data){
				//import_order_dropdownbox(cssid,item_name,item_mrp,item_qty)
			}
		});
	}
}
</script>