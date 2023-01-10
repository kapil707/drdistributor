<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home_json extends CI_Controller {
	
	public function home_fun1(){
		$title1 = "Our top brands";
		$result1 = $this->Chemist_Model->featured_brand_json();
		$result1 = json_decode("[$result1]", true);
		if(!empty($result1[0])){
		?>
		<div class="home_page_big_title"><?= $title1 ?></div>
		<div class="part_div_1" style="">
			<div class="MagicScroll" data-options="step: 1; speed: 300; arrows: outside;">
				<?php
				foreach($result1 as $row)
				{
					if(empty($row["division"])){
						$row["division"] = "not";
					}
					
					?>
					<div class="text-left part_div_01" style="">
					<a href="<?= base_url(); ?>home/featured_brand/<?= $row["compcode"]; ?>/<?= $row["division"]; ?>/<?= $row["company_full_name"]; ?>" style="margin-left:5px;margin-right:5px;">
					<div class="text-center">
					<img src="<?= $row["image"]; ?>" class="part_div_img_01" style="margin-bottom:15px;" alt>
					<br>
					<span class="text_cut_or_dot text-capitalize home_page_company_full_name"><?= base64_decode($row["company_full_name"]); ?></span>
					</div>
					</a>
					</div>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
		<?php
		}
	}
	
	public function home_fun2(){
		$title2 = "New arrivals";
		$result2 = $this->Chemist_Model->new_medicine_this_month();
		$result2 = json_decode("[$result2]", true);
		if(!empty($result2[0])){
		?>
		<div class="home_page_big_title"><?= $title2 ?></div>
		<div class="part_div_2" style="">
			<div class="MagicScroll" data-options="step: 1; speed: 300; arrows: outside;">
				<?php
				foreach($result2 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
				<div class="text-left part_div_02" style="">
					<a href="javascript:void(0)" onClick="get_single_medicine_info('<?= $row["i_code"]; ?>')" style="text-decoration: none;"> 
						<p class="text-center">
						<img src="<?= $row["image"]; ?>" class="part_div_img_02" style="margin-bottom: 20px;" title="<?= ($row["item_name"]); ?> (<?= $row["packing"]; ?> Packing)" alt>
						<?php if($row["featured"]==1 && $row["batchqty"]!=0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="home_page_featurediconcss" alt>
						<?php } ?>
						<?php if($row["batchqty"]==0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="home_page_outofstockiconcss" alt>
						<?php } ?>
						</center>
						<div class="home_page_title"><?= ($row["item_name"]); ?> <span class="home_page_packing">(<?= $row["packing"]; ?> Packing)</span>
						</div>
						<div class="home_page_margin_icon">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt>
						</div>
						<div class="home_page_margin"><?= ($row["margin"]); ?> % Margin
						</div>
						<div class="text-capitalize home_page_company">By <?= ($row["company_full_name"]); ?></div>
						<div class="home_page_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-</div>
						<div class="home_page_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</div>
						<div class="home_page_final_price">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</div>
						</p>
					</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
		<?php
		}
	}
	
	public function home_fun3(){
		$title3 = "Hot selling";
		$result3 = $this->Chemist_Model->hot_selling_today_json();
		$result3 = json_decode("[$result3]", true);
		if(!empty($result3[0])){
		?>
		<div class="home_page_big_title"><?= $title3 ?></div>
		<div class="part_div_2" style="">
			<div class="MagicScroll" data-options="step: 1; speed: 300; arrows: outside;">
				<?php
				foreach($result3 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
				<div class="text-left part_div_02" style="">
					<a href="javascript:void(0)" onClick="get_single_medicine_info('<?= $row["i_code"]; ?>')" style="text-decoration: none;"> 
						<p class="text-center">
						<img src="<?= $row["image"]; ?>" class="part_div_img_02" style="margin-bottom: 20px;" title="<?= ($row["item_name"]); ?> (<?= $row["packing"]; ?> Packing)" alt>
						<?php if($row["featured"]==1 && $row["batchqty"]!=0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="home_page_featurediconcss" alt>
						<?php } ?>
						<?php if($row["batchqty"]==0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="home_page_outofstockiconcss" alt>
						<?php } ?>
						</center>
						<div class="home_page_title"><?= ($row["item_name"]); ?> <span class="home_page_packing">(<?= $row["packing"]; ?> Packing)</span>
						</div>
						<div class="home_page_margin_icon">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt>
						</div>
						<div class="home_page_margin"><?= ($row["margin"]); ?> % Margin
						</div>
						<div class="text-capitalize home_page_company">By <?= ($row["company_full_name"]); ?></div>
						<div class="home_page_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-</div>
						<div class="home_page_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</div>
						<div class="home_page_final_price">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</div>
						</p>
					</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
		<?php
		}
	}
	
	public function home_fun4(){
		$title4 = "Must buy";
		$result4 = $this->Chemist_Model->must_buy_medicines_json();
		$result4 = json_decode("[$result4]", true);
		if(!empty($result4[0])){
		?>
		<div class="home_page_big_title"><?= $title4 ?></div>
		<div class="part_div_2" style="">
			<div class="MagicScroll" data-options="step: 1; speed: 300; arrows: outside;">
				<?php
				foreach($result4 as $row)
				{
					if(empty($_SESSION['user_session']))
					{
						$row["mrp"] = "xx.xx";
						$row["sale_rate"] = "xx.xx";
						$row["final_price"] = "xx.xx";
						$row["margin"] = "xx";
					}
				?>
				<div class="text-left part_div_02" style="">
					<a href="javascript:void(0)" onClick="get_single_medicine_info('<?= $row["i_code"]; ?>')" style="text-decoration: none;"> 
						<p class="text-center">
						<img src="<?= $row["image"]; ?>" class="part_div_img_02" style="margin-bottom: 20px;" title="<?= ($row["item_name"]); ?> (<?= $row["packing"]; ?> Packing)" alt>
						<?php if($row["featured"]==1 && $row["batchqty"]!=0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="home_page_featurediconcss" alt>
						<?php } ?>
						<?php if($row["batchqty"]==0) {?>
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="home_page_outofstockiconcss" alt>
						<?php } ?>
						</center>
						<div class="home_page_title"><?= ($row["item_name"]); ?> <span class="home_page_packing">(<?= $row["packing"]; ?> Packing)</span>
						</div>
						<div class="home_page_margin_icon">
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt>
						</div>
						<div class="home_page_margin"><?= ($row["margin"]); ?> % Margin
						</div>
						<div class="text-capitalize home_page_company">By <?= ($row["company_full_name"]); ?></div>
						<div class="home_page_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-</div>
						<div class="home_page_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</div>
						<div class="home_page_final_price">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</div>
						</p>
					</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
		<?php
		}
	}
	
	public function home_fun5(){
		$title5 = "Frequently use";
		$result5 = $this->Chemist_Model->frequently_use_medicines_json();
		$result5 = json_decode("[$result5]", true);
		if(!empty($result5[0])){
			?>
			<div class="home_page_big_title"><?= $title5 ?></div>
			<div class="part_div_2" style="">
				<div class="MagicScroll" data-options="step: 1; speed: 300; arrows: outside;">
					<?php
					foreach($result5 as $row)
					{
						if(empty($_SESSION['user_session']))
						{
							$row["mrp"] = "xx.xx";
							$row["sale_rate"] = "xx.xx";
							$row["final_price"] = "xx.xx";
							$row["margin"] = "xx";
						}
					?>
					<div class="text-left part_div_02" style="">
						<a href="javascript:void(0)" onClick="get_single_medicine_info('<?= $row["i_code"]; ?>')" style="text-decoration: none;"> 
							<p class="text-center">
							<img src="<?= $row["image"]; ?>" class="part_div_img_02" style="margin-bottom: 20px;" title="<?= ($row["item_name"]); ?> (<?= $row["packing"]; ?> Packing)" alt>
							<?php if($row["featured"]==1 && $row["batchqty"]!=0) {?>
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="home_page_featurediconcss" alt>
							<?php } ?>
							<?php if($row["batchqty"]==0) {?>
							<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="home_page_outofstockiconcss" alt>
							<?php } ?>
							</center>
							<div class="home_page_title"><?= ($row["item_name"]); ?> <span class="home_page_packing">(<?= $row["packing"]; ?> Packing)</span>
							</div>
							<div class="home_page_margin_icon">
								<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt>
							</div>
							<div class="home_page_margin"><?= ($row["margin"]); ?> % Margin
							</div>
							<div class="text-capitalize home_page_company">By <?= ($row["company_full_name"]); ?></div>
							<div class="home_page_mrp">MRP : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["mrp"]; ?>/-</div>
							<div class="home_page_ptr">PTR : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["sale_rate"]; ?>/-</div>
							<div class="home_page_final_price">~Price : <i class="fa fa-inr" aria-hidden="true"></i> <?= $row["final_price"]; ?>/-</div>
							</p>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
			<script type="text/javascript" src="<?= base_url(); ?>assets/website/magicscroll/magicscroll.js"></script>
			<?php
		}
	}
}
?>