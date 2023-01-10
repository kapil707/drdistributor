<style>
body
{
	margin:0px;
	padding:0px;
}
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
$(".headertitle").html("Pickedby");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12">
			<iframe src="<?= $this->Scheme_Model->get_website_data("corporate_url_local") ;?>drd_local_server/drd_live_report" title="" class="iframe" width="100%" height="100%" border=0 style="border:none;width:100%;height:100%;"></iframe>
		</div>
	</div>
</div>
<script>
$(".iframe").css("height", screen.height - 250);
</script>