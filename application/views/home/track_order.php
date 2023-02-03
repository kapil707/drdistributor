<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
@media screen and (max-width: 767px) {
	.homebtn_div
	{
		display:none;
	}
}
</style>
<script>
$(".headertitle").html("Track order");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container-fluid maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12 load_page">
					<iframe src="<?= base_url(); ?>/website_map/index/<?= base64_encode($_SESSION['user_altercode']); ?>" style="width:100%;height: 544px;border:none;" title="" border=0></iframe>
				</div>
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
			</div>
		</div>
	</div>     
</div>