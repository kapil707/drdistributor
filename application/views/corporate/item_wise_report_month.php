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
$(".headertitle").html("Item wise report monthly");
function goBack() {
	window.location.href = "<?= base_url();?>corporate";
}
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12">
			<iframe src="<?= $this->Scheme_Model->get_website_data("corporate_url") ;?>drd_local_server/corporate/item_wise_report_month/<?= $user_session?>/<?= $user_division?>/<?= $user_compcode?>" title="" class="iframe" width="100%" height="450px;" border=0 style="border:none; margin-top:-30px;"></iframe>
		</div>
	</div>
</div>
<script>
$(".iframe").css("height", screen.height - 250);
</script>