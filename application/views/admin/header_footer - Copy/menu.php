    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">
                                <li><a href="<?= base_url()?>admin/dashboard">Home</a>
                                </li> 
                                <li><a data-toggle="collapse" data-target="#Android" href="#">Android</a>
                                    <ul id="Android" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_android_info/view">Users Info</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_allbiker_map/view">Track Rider</a>
										</li>
										 <li><a href="#">Track Chemist</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_emails/add/treak_time">Rider Timer</a>
										<li><a href="<?= base_url()?>admin/manage_emails/add/treak_time">Chemist Timer</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_emails/add/android_mobile">Mobile</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_emails/add/android_email">Email</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_emails/add/android_whatsapp">Whatsapp</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_emails/add/force_update_title">Force Update Title</a>
										</li>
                                        <li><a href="<?= base_url()?>admin/manage_emails/add/force_update_message">Force Update Message</a>
										</li>
                                        <li><a href="<?= base_url()?>admin/manage_emails/add/force_update">Force Update</a>
										</li>
                                        <li><a href="<?= base_url()?>admin/manage_emails/add/android_versioncode">Android Version</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Notification" href="#">Notification</a>
                                    <ul id="Notification" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_broadcast/view">Broadcast</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_notification/view">Notification</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_email_notification/view">Email Broadcast</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_whatsapp_message/view">Whatsapp Broadcast</a>
										</li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Users" href="#">Users</a>
                                    <ul id="Users" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_chemist/view">Chemist</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_corporate/view">Corporate</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_master/view">Rider</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_salesman/view">Salesman</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_salesman/view">Employee</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_chemist_request/view">Chemist Request</a>
										</li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Medicine" href="#">Medicine</a>
                                    <ul id="Medicine" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_medicine/view">Medicine</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_medicine_category/view">Medicine Category</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_featured_brand/view">Featured Brand</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_company_discount/view">Company Discount</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_medicine_image/view">Medicine Image</a>
										</li>
                                        <li><a href="<?= base_url()?>admin/manage_medicine_info2/view">Medicine Image Scraping</a>
                                        </li>
										<li><a href="<?= base_url()?>admin/manage_must_buy_medicines/view">Must Buy Medicines</a>
										</li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Reports" href="#">Reports</a>
                                    <ul id="Reports" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_delete_import/view">Delete Import</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_fail_log/view">Notification Failure</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_low_stock_alert/view">Low Stock Alert</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_sales_deleted/view">Short Items</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_orders/view">Orders</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_invoice/view">Invoice</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_pending_order/view">Pending Order</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_sales/view">Sales Items</a>
										</li>
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Settings" href="#">Settings</a>
                                    <ul id="Settings" class="collapse dropdown-header-top">
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
                                    </ul>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Othres" href="#">Othres</a>
                                    <ul id="Othres" class="collapse dropdown-header-top">
                                        <li><a href="<?= base_url()?>admin/manage_slider/view">Slider</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_slider2/view">Slider2</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_user_type/view">User Type</a>
										</li>
										<li><a href="<?= base_url()?>admin/manage_users/view">Users</a>
										</li>
										<li><a href="<?= base_url()?>admin/profile_management/permission_settings">Profile Management</a>
										</li>
                                        <li><a href="<?= base_url()?>admin/manage_website/add/corporate_url">Corporate Url</a>
                                        </li>
										<li><a href="<?= base_url()?>admin/manage_website/add/corporate_url_local">Corporate Url Local</a>
                                        </li>
                                        <li><a href="<?= base_url()?>admin/logout">Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu end -->
	
    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li><a data-toggle="tab" href="#web_Main"></i> Home</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Android"><i class="notika-icon notika-mail"></i> Android</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Notification"><i class="notika-icon notika-edit"></i> Notification</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Users"><i class="notika-icon notika-bar-chart"></i> Users</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Medicine"><i class="notika-icon notika-windows"></i> Medicine</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Reports"><i class="notika-icon notika-form"></i> Reports</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Settings"><i class="notika-icon notika-app"></i> Settings</a>
                        </li>
                        <li><a data-toggle="tab" href="#web_Othres"><i class="notika-icon notika-support"></i> Othres</a>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
						<div id="web_Main" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?= base_url()?>admin/dashboard">Dashboard</a>
                                </li>
                            </ul>
                        </div>
                        <div id="web_Android" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">								
                                <li><a href="<?= base_url()?>admin/manage_android_info/view">Users Info</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_allbiker_map/view">Track Rider</a>
                                </li>
								 <li><a href="#">Track Chemist</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_emails/add/treak_time">Rider Timer</a>
								<li><a href="<?= base_url()?>admin/manage_emails/add/treak_time">Chemist Timer</a>
                                </li>							
								<li><a href="<?= base_url()?>admin/manage_emails/add/android_mobile">Mobile</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_emails/add/android_email">Email</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_emails/add/android_whatsapp">Whatsapp</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_emails/add/force_update_title">Force Update Title</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_emails/add/force_update_message">Force Update Message</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_emails/add/force_update">Force Update</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_emails/add/android_versioncode">Android Version</a>
                                </li>	
                            </ul>
                        </div>
                        <div id="web_Notification" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?= base_url()?>admin/manage_broadcast/view">Broadcast</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_notification/view">Notification</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_email_notification/view">Email Broadcast</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_whatsapp_message/view">Whatsapp Broadcast</a>
                                </li>								
                            </ul>
                        </div>
                        <div id="web_Users" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?= base_url()?>admin/manage_chemist/view">Chemist</a></li>
                                <li><a href="<?= base_url()?>admin/manage_corporate/view">Corporate</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_master/view">Rider</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_salesman/view">Salesman</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_salesman/view">Employee</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_chemist_request/view">Chemist Request</a>
								</li>
                            </ul>
                        </div>
						<div id="web_Medicine" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?= base_url()?>admin/manage_medicine/view">Medicine</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_medicine_category/view">Medicine Category</a>
								</li>
                                <li><a href="<?= base_url()?>admin/manage_featured_brand/view">Featured Brand</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_company_discount/view">Company Discount</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_medicine_image/view">Medicine Image</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_medicine_info2/view">Medicine Image Scraping</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_must_buy_medicines/view">Must Buy Medicines</a>
                                </li>
                            </ul>
                        </div>
                        <div id="web_Reports" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                 <li><a href="<?= base_url()?>admin/manage_delete_import/view">Delete Import</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_fail_log/view">Notification Failure</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_low_stock_alert/view">Low Stock Alert</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_sales_deleted/view">Short Items</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_orders/view">Orders</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_invoice/view">Invoice</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_pending_order/view">Pending Order</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_sales/view">Sales Items</a>
								</li>
                            </ul>
                        </div>
						<div id="web_Settings" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
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
                            </ul>
                        </div>
                        <div id="web_Othres" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?= base_url()?>admin/manage_slider/view">Slider</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_slider2/view">Slider2</a>
								</li>
                                <li><a href="<?= base_url()?>admin/manage_user_type/view">User Type</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_users/view">Users</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/profile_management/permission_settings">Profile Management</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/manage_website/add/corporate_url">Corporate Url</a>
                                </li>
								<li><a href="<?= base_url()?>admin/manage_website/add/corporate_url_local">Corporate Url Local</a>
                                </li>
                                <li><a href="<?= base_url()?>admin/logout">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Menu area End-->