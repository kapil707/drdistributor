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
$(".headertitle").html("Service Unavailable");
function goBack() {
	window.location.href = "<?= base_url();?>corporate";
}
</script>
<div class="container" style="margin-top:20px;">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 col-12">
			<div class="row">
				<div class="col-sm-12 col-12">
					<h2 class="text-center">
						Service Unavailable
					</h2>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>     
</div>