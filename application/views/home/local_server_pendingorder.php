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
$(".headertitle").html("Pending Order");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12" style="margin-top:30px;">
			<iframe src="<?= $this->Scheme_Model->get_website_data("corporate_url_local") ;?>drd_local_server/pendingorder_report" title="" class="iframe" width="100%" height="450px;" border=0 style="border:none; margin-top:-26px;"></iframe>
		</div>
	</div>
</div>
<script>
$(".iframe").css("height", screen.height - 250);
</script>