	<?= $this->session->flashdata('message'); ?>
	<?php
	if($this->session->userdata('user_type')!="") { ?>
	<div class="notika-status-area">
        <div class="container">
            <div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-cyan mg-t-30">
						<h2><span class="counter"><?php echo $total_medicine ?></span></h2>
						<p>Total Medicine</p>
					</div>
                </div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-teal mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_chemist">
							<h2><span class="counter"><?php echo $total_acm ?></span></h2>
							<p>Total Chemist</p>
						</a>
					</div>
				</div>
				
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-blue mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_corporate">
							<h2><span class="counter"><?php echo $total_staffdetail ?></span></h2>
							<p>Total Corporate</p>
						</a>
					</div>
                </div>
			
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-light-blue mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_salesman">
							<h2><span class="counter"><?php echo $total_salesman ?></span></h2>
							<p>Total Salesman</p>
						</a>
					</div>
                </div>
			
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-cyan mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_master">
							<h2><span class="counter"><?php echo $today_master ?></span></h2>
							<p>Total Rider</p>
						</a>
					</div>
                </div>
			
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-teal mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_orders3 ?></span></h2>
							<p>Today Unique Orders</p>
						</a>
					</div>
                </div>
			
			</div>
			<div class="row">
			
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-green mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class=""><?php echo $today_orders ?></span></h2>
							<p>Today Orders</p>
						</a>
					</div>
                </div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-light-green mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_orders_price ?></span></h2>
							<p>Today Order Price</p>
						</a>
					</div>
                </div>	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-lime mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_orders_items ?></span></h2>
							<p>Today Order Items</p>
						</a>
					</div>
                </div>
			
			</div>
			<div class="row">	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-teal mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_website_orders_items ?></span></h2>
							<p>Today Website Order</p>
						</a>
					</div>
                </div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-green mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_android_orders_items ?></span></h2>
							<p>Today Android Order</p>
						</a>
					</div>
                </div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-light-green mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_orders">
							<h2><span class="counter"><?php echo $today_excel_orders_items ?></span></h2>
							<p>Today Excel Order</p>
						</a>
					</div>
                </div>
			</div>
			<div class="row">	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-amber mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_invoice">
							<h2><span class="counter"><?php echo $today_invoice ?></span></h2>
							<p>Today Invoice</p>
						</a>
					</div>
                </div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="color-single nk-orange mg-t-30">
						<a href="<?=base_url(); ?>admin/manage_invoice">
							<h2><span class="counter"><?php echo $today_total_sales ?></span></h2>
							<p>Today Total Sales</p>
						</a>
					</div>
                </div>
            </div>
			<!-- 
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-4">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Top 10 Medicine</h5>								
							</div>
							<canvas height="140vh" width="180vw" id="barchart1"></canvas>
						</div>
					</div>
				</div>
			</div> -->
            <?php } ?>
        </div><!-- /.row -->
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->