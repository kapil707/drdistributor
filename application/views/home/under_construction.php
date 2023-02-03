<div style="width:60%; margin-top:1;margin-left:20%;margin-right:20%;">
	<br><br>
	<h1 style="text-align: center;"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/underconstruction.png" style="width:50%;" alt></h1>
	<?php
	$under_construction_message = $this->Scheme_Model->get_website_data("under_construction_message");
	?>
	<h1 style="text-align: center;"><?= $under_construction_message ?></h1>
</div>