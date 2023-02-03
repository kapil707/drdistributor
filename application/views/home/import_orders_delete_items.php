<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<script>
$(".headertitle").html("Deleted items");
function goBack() {
	window.location.href = "<?= base_url();?>import_order";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12">
					<table class="table table-striped table-bordered" aria-describedby>
						<thead>
							<tr>
								<th style="width:50px;" scope>
									S.No.
								</th>
								<th scope>
									Item name
								</th>
								<th style="width:150px;" scope>
									Mrp.
								</th>
								<th style="width:150px;" scope>
									Quantity
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i = 1;
						foreach ($result as $row)
						{
							?>
							<tr>
								<td>
									<?= $i++ ?>
								</td>
								<td>
									<?= ucwords(strtolower($row->item_name)) ?>
								</td>
								<td>
									<?= $row->mrp ?>
								</td>
								<td>
									<?= $row->quantity ?>
								</td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-8 col-8 text-left">	
					<a href="<?= base_url(); ?>import_order/downloadfile/<?php echo base64_encode($order_id); ?>">
						<button type="submit" class="btn btn-success site_round_btn31" name="submit" value="submit" style="margin-top: 10px;">Download deleted items</button>
					</a>
				</div>
				<div class="col-sm-4 col-4 text-right">
					<a href="<?= base_url(); ?>home/draft_order_list/<?php echo ($chemist_id); ?>">
						<button type="submit" class="btn btn-primary next_btn site_main_btn31" name="submit" value="submit" style="width:20%">Next</button>
					</a>
				</div>
			</div>
		</div>
	</div>     
</div>