<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element"> <span>
                	<?php 
					if($this->session->userdata("user_type") !=""){ ?>
                    <img alt="image" class="img-circle" src="<?= base_url()?>uploads/manage_users/photo/<?= $this->session->userdata("image") ?>" width="100" />
                    <?php } else { 
					?>
                    <img alt="image" class="img-circle" src="<?= base_url()?>uploads/manage_profile/photo/unapproved.jpg" width="100" />
                    <?php
					}?>
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $this->session->userdata("name"); ?></strong>
                     </span> <span class="text-muted text-xs block"><?php $user_type1 = $this->session->userdata("user_type"); ?>
                     <?php echo str_replace("_"," ",$user_type1); ?><b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="<?= base_url()?>admin/dashboard/edit_profile">Edit Profile</a></li>
                        <?php /* <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                       	<li class="divider"></li> */ ?>
                        <li><a href="<?= base_url()?>admin/logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    DRD
                </div>
            </li>
            <li <?php if($Page_menu=="dashboard") { ?> class="active" <?php } ?>>
                <a href="<?= base_url()?>admin/dashboard">
                <i class="fa fa-th-large"></i>
                <span class="nav-label">Dashboard</span>
                </a>
            </li>
			
			<?php
			$user_type = $this->session->userdata("user_type");			
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_android_info' or tbl_permission_settings.page_type='manage_allbiker_map' or tbl_permission_settings.page_type='manage_chemist_map' or tbl_permission_settings.page_type='manage_emails') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Android
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
					<?php 
					foreach($menu as $mymenu){
					if($mymenu->page_type=="manage_android_info") { ?>
					<li><a href="<?= base_url()?>admin/manage_android_info/view">Android Users</a>
					</li>
					<?php } 
					if($mymenu->page_type=="manage_allbiker_map") { ?>
					<li><a href="<?= base_url()?>admin/manage_allbiker_map/view">Rider Users Treck</a>
					</li>
					<?php } 
					if($mymenu->page_type=="manage_chemist_map") { ?>
					<li><a href="<?= base_url()?>admin/manage_chemist_map/view">Android Users Treck</a>
					</li>
					<?php } 
					if($mymenu->page_type=="manage_emails") { ?>
					<li><a href="<?= base_url()?>admin/manage_emails/add/android_mobile">Android Mobile</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/android_email">Android Email</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/android_whatsapp">Android Whatsapp</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/force_update_title">Android Force Update Title</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/force_update_message">Android Force Update Message</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/force_update">Android Force Update</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/android_versioncode">Android Version</a>
					</li>
					<?php } 
					}?>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_broadcast' or tbl_permission_settings.page_type='manage_notification' or tbl_permission_settings.page_type='manage_email_notification' or tbl_permission_settings.page_type='manage_whatsapp_message') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Notification
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
				<?php 
				foreach($menu as $mymenu){
					if($mymenu->page_type=="manage_broadcast") { ?>
					<li><a href="<?= base_url()?>admin/manage_broadcast/view">Broadcast</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_notification") { ?>
					<li><a href="<?= base_url()?>admin/manage_notification/view">Notification</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_email_notification") { ?>
					<li><a href="<?= base_url()?>admin/manage_email_notification/view">Email Broadcast</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_whatsapp_message") { ?>
					<li><a href="<?= base_url()?>admin/manage_whatsapp_message/view">Whatsapp Broadcast</a>
					</li>
					<?php } }?>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_chemist' or tbl_permission_settings.page_type='manage_corporate' or tbl_permission_settings.page_type='manage_master' or tbl_permission_settings.page_type='manage_salesman' or tbl_permission_settings.page_type='manage_chemist_request') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Users
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
				<?php 
				foreach($menu as $mymenu){
					if($mymenu->page_type=="manage_chemist") { ?>
					<li><a href="<?= base_url()?>admin/manage_chemist/view">Chemist</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_corporate") { ?>
					<li><a href="<?= base_url()?>admin/manage_corporate/view">Corporate</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_master") { ?>
					<li><a href="<?= base_url()?>admin/manage_master/view">Rider</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_salesman") { ?>
					<li><a href="<?= base_url()?>admin/manage_salesman/view">Salesman</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_chemist_request") { ?>
					<li><a href="<?= base_url()?>admin/manage_chemist_request/view">Chemist Request</a>
					</li>
					<?php } }?>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_medicine' or tbl_permission_settings.page_type='manage_medicine_category' or tbl_permission_settings.page_type='manage_featured_brand' or tbl_permission_settings.page_type='manage_company_discount' or tbl_permission_settings.page_type='manage_medicine_image' or tbl_permission_settings.page_type='manage_medicine_info2' or tbl_permission_settings.page_type='manage_must_buy_medicines') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Medicine
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
				<?php 
				foreach($menu as $mymenu){
					if($mymenu->page_type=="manage_medicine") { ?>
					<li><a href="<?= base_url()?>admin/manage_medicine/view">Medicine</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_medicine_category") { ?>
					<li><a href="<?= base_url()?>admin/manage_medicine_category/view">Medicine Category</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_featured_brand") { ?>
					<li><a href="<?= base_url()?>admin/manage_featured_brand/view">Featured Brand</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_company_discount") { ?>
					<li><a href="<?= base_url()?>admin/manage_company_discount/view">Company Discount</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_medicine_image") { ?>
					<li><a href="<?= base_url()?>admin/manage_medicine_image/view">Medicine Image</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_medicine_info2") { ?>
					<li><a href="<?= base_url()?>admin/manage_medicine_info2/view">Medicine Image Scraping</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_must_buy_medicines") { ?>
					<li><a href="<?= base_url()?>admin/manage_must_buy_medicines/view">Must Buy Medicines</a>
					</li>
					<?php } }?>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_delete_import' or tbl_permission_settings.page_type='manage_fail_log' or tbl_permission_settings.page_type='manage_low_stock_alert' or tbl_permission_settings.page_type='manage_sales_deleted' or tbl_permission_settings.page_type='manage_orders' or tbl_permission_settings.page_type='manage_invoice' or tbl_permission_settings.page_type='manage_pending_order' or tbl_permission_settings.page_type='manage_sales') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Reports
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
				<?php 
				foreach($menu as $mymenu){
					if($mymenu->page_type=="manage_delete_import") { ?>
					<li><a href="<?= base_url()?>admin/manage_delete_import/view">Delete Import</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_fail_log") { ?>
					<li><a href="<?= base_url()?>admin/manage_fail_log/view">Notification Failure</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_low_stock_alert") { ?>
					<li><a href="<?= base_url()?>admin/manage_low_stock_alert/view">Low Stock Alert</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_sales_deleted") { ?>
					<li><a href="<?= base_url()?>admin/manage_sales_deleted/view">Short Items</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_orders") { ?>
					<li><a href="<?= base_url()?>admin/manage_orders/view">Orders</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_invoice") { ?>
					<li><a href="<?= base_url()?>admin/manage_invoice/view">Invoice</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_pending_order") { ?>
					<li><a href="<?= base_url()?>admin/manage_pending_order/view">Pending Order</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_sales") { ?>
					<li><a href="<?= base_url()?>admin/manage_sales/view">Sales Items</a>
					</li>
					<?php } }?>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='manage_website') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){
			?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Settings
					</span><span class="fa arrow"></span>
				</a>	
				<ul class="nav nav-second-level collapse">
					<li><a href="<?= base_url()?>admin/manage_website/add/title">Title</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/title2">Title2</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/logo">Logo</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/icon">Icon</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/defaultpassword">Default Password</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/mapapikey">Map Api Key</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_email/view">Email Setting</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/whatsapp_deviceid">Whatsapp Deviceid</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/whatsapp_key">Whatsapp Key</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/whatsapp_group1">Whatsapp Group1</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_emails/add/whatsapp_group2">Whatsapp Group2</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/broadcast_title">Broadcast Title</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/broadcast_message">Broadcast Message</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/broadcast_status">Broadcast Status</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/place_order_message">Place Order Message</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/under_construction">Under Construction</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/under_construction_message">Under Construction Message</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/medicine_icon">Medicine icon</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/corporate_url">Corporate Url</a>
					</li>
					<li><a href="<?= base_url()?>admin/manage_website/add/corporate_url_local">Corporate Url Local</a>
					</li>
				</ul>
			</li>
			<?php } 
			$menu = $this->db->query("select DISTINCT tbl_permission_settings.page_type,sorting_order from tbl_permission_settings,tbl_permission_page where tbl_permission_settings.page_type=tbl_permission_page.page_type and user_type='$user_type' and (tbl_permission_settings.page_type='profile_management' or tbl_permission_settings.page_type='manage_users' or tbl_permission_settings.page_type='manage_user_type' or tbl_permission_settings.page_type='manage_slider' or tbl_permission_settings.page_type='manage_slider2') GROUP BY tbl_permission_settings.page_type,sorting_order order by sorting_order asc")->result();
			if(!empty($menu)){ ?>
			<li>
				<a href="#">
					<span class="nav-label">
						<i class="fa fa-th-large"></i>
						Manage Othres
					</span><span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">	
				<?php 
				foreach($menu as $mymenu){
					if($mymenu->page_type=="profile_management") { ?>			
					<li><a href="<?= base_url()?>admin/profile_management/permission_settings">Profile Management</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_users") { ?>
					<li><a href="<?= base_url()?>admin/manage_users/view">Users</a></li>
					<?php }
					if($mymenu->page_type=="manage_user_type") { ?>
					<li><a href="<?= base_url()?>admin/manage_user_type/view">User Type</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_slider") { ?>
					<li><a href="<?= base_url()?>admin/manage_slider/view">Slider</a>
					</li>
					<?php }
					if($mymenu->page_type=="manage_slider2") { ?>
					<li><a href="<?= base_url()?>admin/manage_slider2/view">Slider2</a>
					</li>
					<?php } } ?>
					<li><a href="<?= base_url()?>admin/logout">Logout</a>
					</li>
				</ul>
			</li>
			<?php } ?>
		</ul>
    </div>
</nav>