<?php $this->Admin_Model->check_login1(); ?>
<?php include "head.php" ?>
	<!-- bootstrap & fontawesome -->
	<link href="<?= base_url()?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?= base_url()?>/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/select2/select2.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="<?= base_url()?>/assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	<link href="<?= base_url()?>/assets/css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/animate.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="<?= base_url()?>/assets/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body>
	<body>
    	<div id="wrapper">
			<?php include 'menu.php'; ?>
			<div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <div class="col-lg-6">
                        	<h3 class="pull-right" style="margin-top:20px;">
                                Last Login Time : <?php
                                /*$last_login_time = $this->session->userdata('last_login_time');
                                if($last_login_time!=""){
                                $display_time_H = date("H",$last_login_time);
                                $display_time_i = date("i",$last_login_time);
                                echo $time= date("d-M-Y",$last_login_time)." at ".$this->Scheme_Model->time_conveter($display_time_H,$display_time_i);
							                  }*/
                                ?>
                            </h3>
                        </div>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                        	
                            <li style="font-size:20px;">
                                <span class="m-r-sm text-muted welcome-message">
								Welcome to Admin+ </span>
                            </li>
                            
                            <li>
                                <a href="<?= base_url()?>admin/logout">
                                    <i class="fa fa-sign-out fa-2x" style="color:#F00"></i>
                                    <span style="font-size:20px;">Log out</span>
                                </a>
                            </li>
                        </ul>
            
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-12">
                    	<div class="col-lg-12">
                        	<h2><?= $title1 ?></h2>
                      	</div>
                        <div class="col-lg-12">
                        	<div class="col-lg-4">
                                <ol class="breadcrumb">
                                    <?php echo $this->breadcrumbs->show(); ?>
                                </ol>
                         	</div>
                            <div class="col-lg-8">
                            	<marquee style="color:#08daaf">
								
								</marquee>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                	<div class="row">
                    	<div class="col-lg-12">
                    		<div class="ibox float-e-margins">
                    			<div class="ibox-content">
