<style>
.menubtn1
{
	display:none;
}
.headertitle
{
	font-size: 16px !important;
    margin-top: 7px !important;
}
</style>
<script>
$(".headertitle").html("D R Distributor");
</script>
<div style="width:100%;" class="">
	<br><br>
	<h1><center>Thanks, Your Order Has been Placed Successfully</center></h1>
	<center><input type="submit" value="Go Home" class="btn btn-primary site_main_btn" name="Go Home" onclick="gohome()"></center>
</div>
<script>
function gohome()
{
	window.location.href= "<?= base_url() ?>home";
}
</script>