<?= $this->session->flashdata('message'); ?>
	<?php
	if($this->session->userdata('user_type')=="Admin" || $this->session->userdata('user_type')=="Super_Admin") { ?>
	<div class="notika-status-area">
        <div class="container">
            <div class="row">
				<div class="col-xs-12">
					<div class="col-lg-3">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-check fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<span>Total Medicine</span>
									<h2 class="font-bold"><span class="counter"><?php echo $total_medicine ?></span></h2>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 lazur-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-thumbs-up fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_chemist">
										<span>Total Chemist</span>
										<h2 class="font-bold"><span class="counter"><?php echo $total_acm ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 yellow-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-bell fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_corporate">
										<span>Total Corporate</span>
										<h2 class="font-bold"><span class="counter"><?php echo $total_staffdetail ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 btn-danger m-r-sm">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-warning fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_salesman">
										<span>Total Salesman</span>
										<h2 class="font-bold"><span class="counter"><?php echo $total_salesman ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-rss fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_master">
										<span>Total Rider</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_master ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 lazur-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-thumbs-up fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Today Unique Orders</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_orders3 ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 yellow-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-bell fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Today Orders</span>
										<h2 class="font-bold"><span class=""><?php echo $today_orders ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 btn-danger m-r-sm">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-warning fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Today Order Price</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_orders_price ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-rss fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Today Order Items</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_orders_items ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 lazur-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-thumbs-up fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Today Website Order</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_website_orders_items ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 yellow-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-bell fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Total Android Order</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_android_orders_items ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 btn-danger m-r-sm">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-warning fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_orders">
										<span>Total Excel Order</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_excel_orders_items ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-rss fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_invoice">
										<span>Today Invoice</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_invoice ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 lazur-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-thumbs-up fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="<?=base_url(); ?>admin/manage_invoice">
										<span>Today Total Sales</span>
										<h2 class="font-bold"><span class="counter"><?php echo $today_total_sales ?></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 lazur-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-thumbs-up fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="" data-toggle="modal" data-target="#myModal_online_user">
										<span>Active User Now</span>
										<h2 class="font-bold"><span class="counter total_online_users"></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-rss fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<a href="" data-toggle="modal" data-target="#myModal_today_online_user">
										<span>Today Active User</span>
										<h2 class="font-bold"><span class="counter today_total_online_users"></span></h2>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br><br>
			<a href="" data-toggle="modal" data-target="#myModal_chemist_open_page">
				<span>View Chemist Open Page</span>
			</a>
			<br><br>
			<a href="" data-toggle="modal" data-target="#myModal_chemist_top_search">
				<span>View Chemist Top Search</span>
			</a>
			<!-- -->
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
			</div> <!-- -->
            <?php } ?>
        </div><!-- /.row -->
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->

	<div id="myModal_online_user" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Active User Now</h4>
			</div>
			<div class="modal-body">
				<table class='table table-striped table-bordered table-hover dataTables-example'>
					<thead>
							<tr>
								<th>Sno.</th>
								<th>Chemist Code</th>
								<th>Active Time</th>
							</tr>
					</thead>
					<tbody class="total_online_users_data">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
	</div>

	<div id="myModal_today_online_user" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Today Active User Now</h4>
			</div>
			<div class="modal-body">
				<table class='table table-striped table-bordered table-hover dataTables-example'>
					<thead>
							<tr>
								<th>Sno.</th>
								<th>Chemist Code</th>
								<th>Active Time</th>
							</tr>
					</thead>
					<tbody class="today_total_online_users_data">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
	</div>
	
	<div id="myModal_chemist_open_page" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Chemist activites</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="chemist_id1" style="text-transform: uppercase;">
				<input type="submit" onclick="chemist_open_page()" value="Submit">
				<table class='table table-striped table-bordered table-hover dataTables-example'>
					<thead>
							<tr>
								<th>Sno.</th>
								<th>Chemist Code</th>
								<th>Active Time</th>
								<th>Page Url</th>
							</tr>
					</thead>
					<tbody class="chemist_open_page_dt">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
	</div>

	<div id="myModal_chemist_top_search" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Chemist Top Search activites</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="chemist_id2" style="text-transform: uppercase;">
				<input type="submit" onclick="chemist_top_search()" value="Submit">
				<table class='table table-striped table-bordered table-hover dataTables-example'>
					<thead>
							<tr>
								<th>Sno.</th>
								<th>Chemist Code</th>
								<th>Active Time</th>
								<th>Item Name</th>
							</tr>
					</thead>
					<tbody class="chemist_top_search_dt">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-database.js"></script>
    <script>
	

	// Your web app's Firebase configuration
	// For Firebase JS SDK v7.20.0 and later, measurementId is optional
	var  firebaseConfig = {
		apiKey: "AIzaSyBPkM-zLmMQbHGE_Ye1qOsBl6IhROvu6RU",
		authDomain: "drd-noti-fire-base.appspot.com",
		databaseURL: "https://drd-noti-fire-base.firebaseio.com",
		projectId: "drd-noti-fire-base",
		storageBucket: "drd-web-firebase-db.appspot.com",
		messagingSenderId: "504935735685",
		appId: "1:504935735685:android:a2d0ae89504ba935f5e4ec"
	};

  	// Initialize Firebase
  	firebase.initializeApp(firebaseConfig);

	// Set database variable
	var database = firebase.database()

	function total_online_users()
	{
		var leadsRef = database.ref('chemist_online/');
		leadsRef.on('value', function(snapshot) {
			$(".total_online_users").html('');
			$(".total_online_users_data").html("")
			var i = 0;
			snapshot.forEach(function(childSnapshot) {
				var childData = childSnapshot.val();
				console.log(childData.user_time);
			  
				var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
				var m = new Date(todayDateTime)

				var dateString = m.getFullYear() +"-"+ (m.getMonth()+1) +"-"+ m.getDate();
				var timeString = m.getHours() + ":" + m.getMinutes();
			  
				if(timeString==childData.user_time){
					i = parseInt(i) + 1;
					$(".total_online_users_data").append("<tr><td>"+i+"</td><td>"+childData.user_altercode+"</td><td>"+childData.user_time+"</td></tr>");
				}
				$(".total_online_users").html(i);
			});
		});
	}

	function today_total_online_users()
	{
		var leadsRef = database.ref('chemist_online/');
		leadsRef.on('value', function(snapshot) {
			$(".today_total_online_users").html('');
			$(".today_total_online_users_data").html("")
			var i = 0;
			snapshot.forEach(function(childSnapshot) {
				var childData = childSnapshot.val();
				console.log(childData.user_time);
			  
				var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
				var m = new Date(todayDateTime)

				var dateString = m.getFullYear() +"-"+ (m.getMonth()+1) +"-"+ m.getDate();
				var timeString = m.getHours() + ":" + m.getMinutes();
			  
				if(dateString==childData.user_date){
					i = parseInt(i) + 1;
					$(".today_total_online_users_data").append("<tr><td>"+i+"</td><td>"+childData.user_altercode+"</td><td>"+childData.user_time+"</td></tr>");
				}
				$(".today_total_online_users").html(i);
			});
		});
	}

	total_online_users()
	today_total_online_users()
	
	function chemist_open_page()
	{
		var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
		var m 	= new Date(todayDateTime)
		year 	= m.getFullYear()
		month 	= change_dt_format(m.getMonth()+1);
		day 	= change_dt_format(m.getDate());
		hours 	= change_dt_format(m.getHours());
		minutes = change_dt_format(m.getMinutes());
		var dateString = year +"-"+ (month) +"-"+ day;
		var timeString = hours + ":" + minutes;

		chemist_id1 = $(".chemist_id1").val()
		chemist_id1 = chemist_id1.toUpperCase();
		var leadsRef = database.ref('chemist_open_page/'+dateString+'/'+chemist_id1);
		leadsRef.on('value', function(snapshot) {
			$(".chemist_open_page_dt").html("")
			var i = 0;
			snapshot.forEach(function(childSnapshot) {
				var childData = childSnapshot.val();
				
				i = parseInt(i) + 1;
				$(".chemist_open_page_dt").append("<tr><td>"+i+"</td><td>"+childData.user_altercode+"</td><td>"+childData.user_time+"</td><td>"+childData.page_url+"</td></tr>");
			});
		});
	}

	function chemist_top_search()
	{
		var todayDateTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
		var m 	= new Date(todayDateTime)
		year 	= m.getFullYear()
		month 	= change_dt_format(m.getMonth()+1);
		day 	= change_dt_format(m.getDate());
		hours 	= change_dt_format(m.getHours());
		minutes = change_dt_format(m.getMinutes());
		var dateString = year +"-"+ (month) +"-"+ day;
		var timeString = hours + ":" + minutes;

		chemist_id2 = $(".chemist_id2").val()
		chemist_id2 = chemist_id2.toUpperCase();
		var leadsRef = database.ref('chemist_top_search/'+dateString+'/'+chemist_id2);
		leadsRef.on('value', function(snapshot) {
			$(".chemist_top_search_dt").html("")
			var i = 0;
			snapshot.forEach(function(childSnapshot) {
				var childData = childSnapshot.val();
				
				i = parseInt(i) + 1;
				$(".chemist_top_search_dt").append("<tr><td>"+i+"</td><td>"+childData.user_altercode+"</td><td>"+childData.user_time+"</td><td>"+childData.item_name+" | " + childData.item_packing +"</td></tr>");
			});
		});
	}
	function change_dt_format(dt)
	{
		if(dt==1)
		{
			dt = "01"
		}
		if(dt==2)
		{
			dt = "02"
		}
		if(dt==3)
		{
			dt = "03"
		}
		if(dt==4)
		{
			dt = "04"
		}
		if(dt==5)
		{
			dt = "05"
		}
		if(dt==6)
		{
			dt = "06"
		}
		if(dt==7)
		{
			dt = "07"
		}
		if(dt==8)
		{
			dt = "08"
		}
		if(dt==9)
		{
			dt = "09"
		}
		return dt;
	}
</script>