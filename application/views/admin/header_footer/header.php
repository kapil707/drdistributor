<?php $this->Admin_Model->check_login1(); ?>
<?php include "head.php" ?>
	<!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/owl.theme.css">
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/owl.transitions.css">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/meanmenu/meanmenu.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/normalize.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/jvectormap/jquery-jvectormap-2.0.3.css">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/notika-custom-icon.css">
    <!-- wave CSS
		============================================ -->		
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/wave/waves.min.css">
	<!-- Data Table JS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/jquery.dataTables.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/main.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="<?= base_url()?>/newcss/css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="<?= base_url()?>/newcss/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body>
	 <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="<?= base_url()?>admin/dashboard"><img src="<?= base_url()?>/uploads/manage_website/photo/<?= $this->Scheme_Model->get_website_data("logo") ;?>" alt="" width="40px" /></a>
						<?= $this->Scheme_Model->get_website_data("title") ;?>
                    </div>
                </div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						
						<input type="text" class="select_medicine SearchMedicine_search_box form-control" placeholder="<?= $msg_show?>" tabindex="1">
				</div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right m-2">
                  <div class="logo-area">
                  <a href="<?= base_url()?>admin/logout" style="color:black">Logout</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
	<!-- End Header Top Area -->
	<?php include 'menu.php'; ?>


	<div class="colr-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="color-wrap">
						<div class="color-hd">