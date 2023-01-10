<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->Scheme_Model->get_website_data("title") ;?> || <?= $main_page_title;?></title>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/newgreen/css/min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/newgreen/css/zwicon/zwicon.min.css"/>
    

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/newgreen/css/all.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/newgreen/css/style.css">

	<link rel="icon" href="<?= base_url(); ?>img_v<?= constant('site_v') ?>/logo.png" type="image/logo" sizes="16x16">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php
if(empty($chemist_id_for_cart_total))
{
	$chemist_id_for_cart_total = "";
}

$someArray = $this->Chemist_Model->website_menu();
$par = '['.$someArray.']';
$someArray = json_decode($par, true);

$pg_dt_row = "col-sm-12 col-12";
if(!empty($_SESSION['user_type'])){
	if($_SESSION['user_type']=="sales")
	{
		$msg_show = "Search chemist / medicines";
		$pg_dt_row = "col-sm-9 col-9";
	}
	else{
		$msg_show = "Search medicines / company";
	}
}else{
	$msg_show = "Search medicines / company";
}
?>
<header class="header">

    <div class="header-1">

        <a href="#" class="logo"><img src="<?= base_url(); ?>assets/newgreen/image/distibuter_logo.png" class="logo_size"> <div class="logotext">Delivering to<br><?= $session_user_fname ?></div></a>

        <form action="" class="search-form">
            <label for="search-box" class="fas fa-search"></label>
            <input type="search" name="" placeholder="search here..." id="search-box" class="SearchMedicine_search_box">
        </form>
        <span class="search_medicine_result"></span>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <div id="#" class="fas fa-heart"></div>
            <a href="#" class="fas fa-shopping-cart">
			<span class="header_cart_span">0</span></a>
            <div id="#" class="fas fa-user"></div>
        </div>
 </div>

    <div class="header-2">
        <nav class="navbar">
			<a href="#home">home</a>
			<?php
			foreach($someArray as $row)
			{
			?>
			<a href="<?= base_url();?>home/medicine_category/<?= $row["code"] ?>/<?= $row["name"] ?>"><?= base64_decode($row["name"]) ?></a>
			<?php } ?>
        </nav>
    </div>
    <div id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar(this)">
          <span></span>
          <span></span>
          <span></span>
        </div>  
        <div class="list">
            <div class="item"><img src="image/distibuter_logo1.png">
                <h4 class="guest">Guest
                    <span>: xxxxxx</span> </h4>
            </div>
          <div class="item"><i class="zwicon-user"></i >Account</div>
          <div class="item"><i class="zwicon-edit-square"></i> Update Account</div>
          <div class="item"><i class="zwicon-camera-alt"></i> Update Image</div>
          <div class="item"><i class="zwicon-lock"></i> Update Password</div>
          <div class="item"><i class="zwicon-thumbs-up"></i> Update Suggest Medicine</div>
          <div class="item">Others</div>
          <div class="item"><i class="zwicon-phone"></i> Contact Us</div>
          <div class="item"><i class="zwicon-mail"></i> Email</div>
          <div class="item"><i class="zwicon-file-pdf"></i> Privacy Policy</div>
          <div class="item"><i class="zwicon-share"></i> Share App</div>
          <div class="item"><i class="zwicon-sign-out"></i> Logout</div>
          
          
        </div>
      </div>
</header>


<!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar">
    <a href="#home" class="fas fa-home"></a>
    <a href="#featured" class="fas fa-list"></a>
    <a href="#arrivals" class="fas fa-tags"></a>
    <a href="#reviews" class="fas fa-comments"></a>
    <a href="#blogs" class="fas fa-blog"></a>
</nav>

<!-- login form  -->

<div class="login-form-container">

    <div id="close-login-btn" class="fas fa-times"></div>

    <form action="">
        <h3>sign in</h3>
        <span>username</span>
        <input type="email" name="" class="box" placeholder="enter your email" id="">
        <span>password</span>
        <input type="password" name="" class="box" placeholder="enter your password" id="">
        <div class="checkbox">
            <input type="checkbox" name="" id="remember-me">
            <label for="remember-me"> remember me</label>
        </div>
        <input type="submit" value="sign in" class="btn">
        <p>forget password ? <a href="#">click here</a></p>
        <p>don't have an account ? <a href="#">create one</a></p>
    </form>

</div>	

<input type="hidden" class="_cart_item_name">
<input type="hidden" class="_cart_final_price">
<input type="hidden" class="_cart_scheme">
<input type="hidden" class="_cart_image">
<script>
$(document).ready(function(){
	//setTimeout('check_login_function();',2000);
	setTimeout('count_temp_rec();',500);
	
	$(".SearchMedicine_search_box").keyup(function() { 
		var keyword = $(".SearchMedicine_search_box").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.SearchMedicine_search_box').focus();
				$(".search_medicine_result").html("");
			}
			setTimeout('search_medicine();',500);
		}
		else{
			clear_search_box();
		}
	});
	$(".SearchMedicine_search_box").change(function() { 
	});
	$(".SearchMedicine_search_box").on("search", function() { 
	});
	
    $(".SearchMedicine_search_box").keydown(function(event) {
    	if(event.key=="ArrowDown")
    	{
			page_up_down_arrow("1");
    		$('.hover_1').attr("tabindex",-1).focus();
			return false;
    	}
    });
	setTimeout('page_load();',100);
	
	document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 27) {
			clear_search_box();
		}
	};
});
function callandroidfun(funtype,id,compname,image,division) {	
	if(funtype=="1"){
		//android.fun_Get_single_medicine_info(id);
		get_single_medicine_info(id);
	}
	if(funtype=="2")
	{
		window.location.href = '<?= base_url(); ?>home/featured_brand/'+id+'/'+division+'/'+compname;
	}
}
function gosearchpage()
{
	window.location.href = "<?= base_url();?>home/search_medicine";
}
function count_temp_rec()
{
	chemist_id = "<?= $chemist_id_for_cart_total?>";
	$.ajax({
		type       : "POST",
		data       : {chemist_id:chemist_id} ,
		url        : "<?php echo base_url(); ?>Chemist_order/count_temp_rec",
		cache	   : true,
		success    : function(data){
			$(".mycartwalidiv1").html("("+data+")");
			$(".mycartwalidiv2").html(data);
			dt = parseInt(data);
			if(dt>=99)
			{
				data = "99+";
			}
			$(".header_cart_span").html(data);
		},
		timeout: 10000
	});
	setTimeout('count_temp_rec();',10000);
}
function check_login_function()
{
	id ='';
	$.ajax({
	type       : "POST",
		data       :  { id:id} ,
		url        : "<?php echo base_url(); ?>Chemist_json/check_login_function",
		cache	   : true,
		success : function(data){
			if(data!="")
			{
				$.each(data.items, function(i,item){	
					if (item){
						/*if(item.status=="0")
						{
							window.location.href = "<?= base_url();?>user/logout2";
						}*/

						notiid		= (item.notiid);
						broadcastid = (item.broadcastid);
						if(notiid!=""){
							notititle 	= atob(item.notititle);
							notibody 	= atob(item.notibody);
							$(".only_for_noti").append('<li class="only_for_noti_li notiid_'+notiid+'"><div class="notititle">'+notititle+'</div><div class="notibody">'+notibody+'</div></li>');						
							setTimeout('$(".notiid_"+notiid).hide()',10000);
						}
						if(broadcastid!=""){
							broadcasttitle 		= atob(item.broadcasttitle);
							broadcastmessage 	= atob(item.broadcastmessage);
							$('.broadcast_title').html(broadcasttitle);
							$('.broadcast_message').html(broadcastmessage);
							$('.myModal_broadcast').click();
						}
						if(item.count!="")
						{
							//$(".notificationdiv").html("("+item.count+")");
							if(item.count=="0")
							{
								$(".cssnotification").show();
								$(".cssnotification1").hide();
							}
							else
							{
								$(".cssnotification").hide();
								$(".cssnotification1").show();
							}
						}
					}
				});	
			}
		},
		timeout: 10000
	});
	setTimeout('check_login_function();',60000);
}

function get_single_medicine_info(i_code)
{
	var session_user_altercode = "<?= $session_user_altercode ?>";
	if(session_user_altercode=="xxxxxx")
	{
		window.location.href = "<?=base_url(); ?>home";
	} else {
		$('.MedicineDetailsData').html('<h1><center><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>')
		$(".MedicineSmilerProduct").html('');
		$('.myModal_loading').click();
		chemist_id = "<?=$chemist_id?>";
		$('.SearchMedicine_search_box').val("");
		$(".search_medicine_result").html("");
		$.ajax({
			url: "<?php echo base_url(); ?>Chemist_medicine/get_single_medicine_info",
			type:"POST",
			/*dataType: 'html',*/
			data: {i_code:i_code,chemist_id:chemist_id},
			error: function(){
				
			},
			success: function(data){
				$.each(data.items, function(i,item){	
					if (item)
					{
						i_code 				= item.i_code;
						item_code 			= item.item_code;
						item_name 			= item.item_name;
						company_full_name 	= item.company_full_name;
						image1 				= item.image1;
						image2 				= item.image2;
						image3 				= item.image3;
						image4 				= item.image4;
						description1 		= item.description1;
						description2 		= item.description2;
						batchqty 			= item.batchqty;
						sale_rate 			= item.sale_rate;
						mrp 				= item.mrp;
						final_price 		= item.final_price;
						batch_no 			= item.batch_no;
						packing 			= item.packing;
						expiry 				= item.expiry;
						scheme 				= item.scheme;
						margin 				= item.margin;
						featured 			= item.featured;
						gstper 				= item.gstper;
						discount 			= item.discount;
						itemjoinid 			= item.itemjoinid;
						items1				= item.items1;
						date_time			= item.date_time;
						misc_settings		= item.misc_settings;
						
						item_name			= btoa(item_name);
						company_full_name 	= btoa(company_full_name);
						image_m1 	 		= btoa(image1);
						image_m2 	 		= btoa(image2);
						image_m3 	 		= btoa(image3);
						image_m4 	 		= btoa(image4);
						description1_m 	 	= btoa(description1);
						description2_m 	 	= btoa(description2);
						packing 			= btoa(packing);
						expiry  			= btoa(expiry);
						batch_no			= btoa(batch_no);
						scheme  			= btoa(scheme);
						date_time  			= btoa(date_time);
						
						items1				= JSON.stringify(items1);
						items1 	 			= btoa(items1);
						
						your_order_qty = "";
						
						$(".MedicineDetailscssmod").html("Medicine details");
						$('.SearchMedicine_search_box').val("");
						$(".search_medicine_result").html("");
						$(".MedicineSmilerProduct").html("");
						$(".MedicineDetailsData").html("");
						
						MedicineDetails = MedicineDetails_modal(i_code,item_name,company_full_name,image_m1,image_m2,image_m3,image_m4,description1_m,description2_m,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,date_time,your_order_qty,misc_settings);
						$('.MedicineDetailsData').html(MedicineDetails);
						
						setTimeout('model_quantity_focus('+i_code+');',100);
		
						if(itemjoinid!="")
						{
							MedicineSmilerProduct_data = MedicineSmilerProduct_fun(items1,'1');
							$(".MedicineSmilerProduct").html(MedicineSmilerProduct_data);
						}
					}
				});	
			},
			timeout: 10000
		});
	}
}

function model_quantity_focus(i_code)
{
	$('.new_quantity'+i_code).focus();
	$('.new_quantity'+i_code).keypress(function (e) {
		 if (e.which == 13) {
			 add_medicine_to_cart(i_code);
		 } 
	});
	
	chemist_id = "<?=$chemist_id?>";
	$.ajax({
		url: "<?php echo base_url(); ?>Chemist_order/get_order_quantity_of_medicine",
		type:"POST",
		/*dataType: 'html',*/
		data: {i_code:i_code,chemist_id:chemist_id},
		error: function(){
			
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					$('.new_quantity'+i_code).val(item.quantity);
					if(item.quantity!="")
					{
						$('.add_to_cart_btn'+i_code).html("Update cart");
					}
				} 
			});
		},
		timeout: 10000
 
	});
}

function MedicineDetails_modal(i_code,item_name,company_full_name,image1,image2,image3,image4,description1,description2,batchqty,sale_rate,mrp,final_price,batch_no,packing,expiry,scheme,margin,featured,gstper,discount,itemjoinid,date_time,your_order_qty,misc_settings)
{	
	sale_rate 	= parseFloat(sale_rate).toFixed(2);
	mrp 		= parseFloat(mrp).toFixed(2);
	final_price = parseFloat(final_price).toFixed(2);
	$('._cart_item_name').val(item_name);
	$('._cart_final_price').val(final_price);
	$('._cart_scheme').val(scheme);
	$('._cart_image').val(atob(image1));
	
	item_name			= atob(item_name);
	company_full_name 	= atob(company_full_name);
	image1	 			= atob(image1);
	image2	 			= atob(image2);
	image3	 			= atob(image3);
	image4	 			= atob(image4);
	packing 			= atob(packing);
	expiry  			= atob(expiry);
	batch_no  			= atob(batch_no);
	scheme  			= atob(scheme);
	date_time  			= atob(date_time);
	description1  		= atob(description1);
	description2  		= atob(description2);
	
	//itemjoinid = btoa(itemjoinid)
	if(scheme=="0+0")
	{
		scheme =  'No scheme';
		scheme_line = '';
	}
	else
	{
		scheme =  'Scheme : '+scheme;
		scheme_line = '<span class="schemenew1">Scheme is not added in Landing price</span>';
	}
	
	scheme_or_margin =  '<div class="row"><div class="col-sm-6 col-6"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/scheme.png" class="modal_scheme_icon"><span class="modal_scheme">'+scheme+'</span></div><div class="col-sm-6 col-6 text-right"><span class="modal_margin">'+margin+'% Margin</span><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon.png" class="modal_margin_icon"></div><div class="col-sm-12 col-12 text-center">'+scheme_line+'</div></div>';
	
	image_more = '<img src="'+image1+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img1" onclick="open_img(1)" title="'+item_name+'"><img src="'+image2+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img2" onclick="open_img(2)" title="'+item_name+'"><img src="'+image3+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;margin-right: 6.6%;" class="border rounded open_img3" onclick="open_img(3)" title="'+item_name+'"><img src="'+image4+'" width="20%" style="float: left;margin-top:10px;cursor: pointer;" class="border rounded open_img4" onclick="open_img(4)" title="'+item_name+'">';
	
	image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'">';
	if(featured==1){
		image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="modal_featurediconcss">';
	}
	disabled = "";
	if(parseInt(batchqty)==0)
	{
		image_ = '<img src="'+image1+'" width="100%" style="float: right;margin-top:10px;" class="border rounded open_img" title="'+item_name+'"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="modal_outofstockiconcss">';
		batchqty1 = '<div class="modal_out_of_stock" style="margin-top: 0px;">Out of stock</div>';
		addtocartbtn ='<button type="submit" class="btn btn-primary btn-block site_main_btn_out_of_stock" onclick="" title="Add to cart">Add to cart</button>';
		disabled = "disabled";
		
		add_low_stock_alert(i_code);
	}
	else
	{
		batchqty1 = '<div class="text_cut_or_dot modal_stock" style="margin-top: 0px;">Stock : '+batchqty+'</div>';
		
		if(misc_settings=="#NRX")
		{
			if(parseInt(batchqty)>10)
			{
				batchqty1 = '<div class="text_cut_or_dot modal_stock" style="margin-top: 0px;">Available</div>';
			}
		}
		
		addtocartbtn ='<button type="submit" class="btn btn-primary btn-block site_main_btn31 add_to_cart_btn'+i_code+'" onclick="add_medicine_to_cart('+i_code+')" title="Add to cart" style="margin-top:10px;">Add to cart</button>';
	}
	
	description1_ = "";
	if(description1)
	{
		description1_ = '<div class="text-left modal_description1" style="margin-top: 0px;">'+description1+'</div>';
	}
	
	description2_ = "";
	if(description2)
	{
		description2_ = '<div class="text-left modal_description2 col-sm-12 col-12" style="    max-height: 90px;overflow-x: auto;">'+description2+'</div>';
	}
	
	var MedicineDetails = '<div class="modal_date_time" style="margin-top: -35px;">As on '+date_time+'</div><div class="row"><div class="col-sm-5 col-12">'+image_+''+image_more+'</div><div class="col-sm-7 col-12"><div class="text-left" style="margin-top: 5px;"><span class="modal_title">'+item_name+'</span> <span class="modal_packing">('+packing+' Packing)</span></div><div><span class="modal_expiry">Expiry : '+expiry+'</span></div>'+description1_+'<div class="text-left modal_company" style="margin-top: 0px;">By '+company_full_name+'</div><div class="text-left modal_batch_no">Batch no : '+batch_no+'</div>'+batchqty1+'<hr>'+scheme_or_margin+'<hr><span class="text_cut_or_dot text-left model_ptr" style="width:50%;float:left;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/-</span><span class="text-right model_mrp" style="width:50%;float:left;">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/-</span><span class="text_cut_or_dot text-left model_gst" style="width:50%;float:left;">GST : '+gstper+'%</span><span class="model_landing_price text-right" style="width:50%;float:left;">~ <span class="mobile_off">Landing</span> price : <i class="fa fa-inr" aria-hidden="true"></i> '+final_price+'/-</span><div class="row"><div class="col-sm-5 col-5 mar_top10px search_page_order_quantity" style="margin-top:5px;">Order quantity</div><div class="col-sm-7 col-7 text-right mar_top10px"><input type="number" class="new_quantity new_quantity'+i_code+'" placeholder="Eg 1,2" name="quantity" required style="width:100px;float:right;" value="'+your_order_qty+'" title="Enter quantity" min="1" max="1000"><input type="hidden" class="max_quantity'+i_code+'" value="'+batchqty+'"><input type="hidden" value="'+i_code+'" name="i_code" class="new_item_id'+i_code+'"></div><div class="col-sm-12 col-12 text_cut_or_dot text-left add_medicine_to_cart" style="width:100%;float:left">'+addtocartbtn+'</div></div></div><div class="col-sm-12"><hr></div>'+description2_+'</div>';
	return MedicineDetails;
}

function add_low_stock_alert(i_code)
{
	$.ajax({
		type       : "POST",
		data       : {i_code:i_code},
		url        : "<?php echo base_url(); ?>Chemist_order/add_low_stock_alert",
		cache	   : true,
		success    : function(data){
		},
		timeout: 10000
		
	});
}

function open_img(_id)
{
	openimg = $(".open_img"+_id).attr("src");
	$(".open_img").attr("src",openimg);
}

function MedicineSmilerProduct_fun(items1,titleshow)
{
	items1 = atob(items1);	
	items1 = JSON.parse(items1);
	MedicineSmilerProduct_data = '<h6 class="Similar_Products_title" style="margin-top:10px;">Similar Products</h6><div class="searchpagescrolling4 Similar_Products_div"><div class="row"><div class="col-sm-12">';
	$.each(items1, function(i,item){
		if (item)
		{
			//MedicineSmilerProduct_data+= items1[0].i_code;
			
			MedicineSmilerProduct_data+='<div class="Similar_Products_div--box" onClick="SmilerProduct_modal_open('+items1[0].i_code+')" style="text-decoration: none;">';
			
			MedicineSmilerProduct_data+='<img src="'+items1[0].image1+'" class="img-fluid img-responsive" style="border-radius: 5px;">';
			
			if(items1[0].featured==1 && items1[0].batchqty!=0)
			{
				MedicineSmilerProduct_data+='<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/featuredicon.png" class="category_page_featurediconcss">';
			}
			
			if(items1[0].batchqty==0)
			{
				MedicineSmilerProduct_data+='<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/outofstockicon.png" class="category_page_outofstockiconcss">';
			}
									
			MedicineSmilerProduct_data+='<div class="text-left text-capitalize home_page_title" style="margin-top:1px;">'+items1[0].item_name+' <span class="cart_packing">('+items1[0].packing+' Packing)</span></div><div class="category_page_margin_icon text-left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/ribbonicon1.png" style="" alt> </div><div class="category_page_margin">'+items1[0].margin+'% Margin</div><div class="text_cut_or_dot text-capitalize category_page_company">'+items1[0].company_name+'</div><div class="category_page_mrp" style="width:100%;float:left;">MRP : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].mrp+'/-</div><div class="category_page_ptr" style="width:100%;float:left;">PTR : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].sale_rate+'/-</div><div class="category_page_final_price" style="width:100%;float:left;">~Price : <i class="fa fa-inr" aria-hidden="true"></i> '+items1[0].final_price+'/-</div>';
			MedicineSmilerProduct_data+='</div>';
		}
	});
	MedicineSmilerProduct_data+= '</div></div></div>';
	return MedicineSmilerProduct_data;
}

function SmilerProduct_modal_open(i_code)
{
	$('.myModal_loading').click();
	setTimeout('get_single_medicine_info("'+i_code+'");',200);
}

function add_medicine_to_cart(i_code)
{	
	<?php 
	if(!empty($page_cart)) {
	if($page_cart=="1") { ?>
	setTimeout(function() {
        $(".edit_item_focues"+i_code).focus();
    }, 2000);
	<?php } }?>	

	chemist_id 		= "<?=$chemist_id?>";
	quantity		= $(".new_quantity"+i_code).val();
	max_quantity	= $(".max_quantity"+i_code).val();
	i_code			= $(".new_item_id"+i_code).val();
	
	item_name 	= $('._cart_item_name').val();
	final_price = $('._cart_final_price').val();
	scheme 		= $('._cart_scheme').val();
	image 		= $('._cart_image').val();
	
	if(quantity=="")
	{
		swal("Enter quantity");
		$(".new_quantity"+i_code).val("");
		$(".new_quantity"+i_code).focus();
	}
	else
	{
		quantity 		= parseInt(quantity);
		max_quantity	= parseInt(max_quantity);
		if(quantity!=0)
		{
			if(quantity<=max_quantity)
			{
				var import_order_page = "";
				
				<?php if(!empty($import_order_page)){ ?>
				import_order_page = "<?php echo $import_order_page;?>";
				<?php } ?>
				
				if(import_order_page=="yes")
				{
					/**************2021-05-17 only for import order page*************/
					item_name 	= $(".new_import_page_item_name").val();
					mrp 		= $(".new_import_page_item_mrp").val();
					add_new_row_import_order_page(item_name,mrp,quantity);
					$(".modaloff").click();
					clear_search_box();
					/***************************************************************/
				}
				else
				{
					$(".add_medicine_to_cart").html("<center>Loading....</center>");
					$.ajax({
						type       : "POST",
						data       : {i_code:i_code,item_name:item_name,final_price:final_price,scheme:scheme,image:image,quantity:quantity,chemist_id:chemist_id},
						url        : "<?php echo base_url(); ?>Chemist_order/add_medicine_to_cart",
						cache	   : true,
						error: function(){
							swal("error add to cart")
						},
						success    : function(data){
							$.each(data.items, function(i,item){	
								if (item)
								{
									if(item.response=="1")
									{
										$(".modaloff").click();
										$(".SearchMedicine_search_box").focus();
										page_load();
									}
								}
							});
						},
						timeout: 10000
					});
				}
			}
			else
			{
				swal("Etner quantity only " + max_quantity);
				$(".new_quantity"+i_code).val("");
				$(".new_quantity"+i_code).focus();
			}
		}
		else{
			swal("Etner quantity one or more than one");
			$(".new_quantity"+i_code).val("");
			$(".new_quantity"+i_code).focus();
		}
	}
}

function search_medicine()
{
	$(".search_pg_current_order").hide();
	$(".search_pg_result_found").show();
	new_i = 0;
	$(".clear_search_box").show();
	var keyword = $(".SearchMedicine_search_box").val();
	if(keyword!="")
	{
		if(keyword=="#")
		{
			keyword = "k1k2k12k";
		}
		if(keyword.length>1)
		{
			$(".background_blur").show();
			$(".search_medicine_result").show();
			$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
			$(".search_pg_result_found").html("Loading....");
			$.ajax({
			type       : "POST",
			data       :  {keyword:keyword} ,
			url        : "<?php echo base_url(); ?>Chemist_medicine/search_medicine_api",
			cache	   : true,
			error: function(){
				$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
				$(".search_pg_result_found").html("No Result Found");
			},
			success    : function(data){
				if(data.items=="")
				{
					$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></h1></div></div>');
					$(".search_pg_result_found").html("No Result Found");
				}
				else
				{
					$(".search_medicine_result").html("");
				}
				$.each(data.items, function(i,item){
						if (item)
						{
							//count_i			= item.count;
							//new_i				= parseInt(item.i);
							date_time			= item.date_time;
							i_code				= item.i_code;			
							item_name 			= item.item_name;
							company_full_name 	= item.company_full_name;
							image1 				= item.image1;
							image2 				= item.image2;
							image3 				= item.image3;
							image4 				= item.image4;
							description1 		= item.description1;
							description2 		= item.description2;
							batchqty 			= item.batchqty;
							sale_rate 			= item.sale_rate;
							mrp 				= item.mrp;
							final_price 		= item.final_price;
							batch_no 			= item.batch_no;
							packing 			= item.packing;
							expiry 				= item.expiry;
							scheme 				= item.scheme;
							margin 				= item.margin;
							featured 			= item.featured;
							gstper 				= item.gstper;
							discount          	= item.discount;
							misc_settings      	= item.misc_settings;
							itemjoinid         	= item.itemjoinid;
							items1				= item.items1;
							
							/*itemjoinid          = "";
							items1				= "";*/
							
							item_name_1 = item_name.charAt(0);
							
							if(item_name_1==".")
							{
							}
							else
							{							
								new_i = parseInt(new_i) + 1;
								smilerproduct = '';
								if(itemjoinid!="")
								{
									arr = itemjoinid.split(',');
									smilerproductcount  = arr.length;
									
									smilerproduct_i_code   	= items1[0].i_code;
									smilerproduct_data 		= items1[0].item_name+" | MRP. "+items1[0].mrp+" | "+items1[0].margin+" % Margin";
									
									smilerproduct ='<div class="row" style="border-top: 1px solid #1084a1;margin-top: -1px;font-size: 13px;padding:5px;"><div class="col-sm-12 col-12 spansmilerproduct_text">'+smilerproduct_data+'</div><div class="col-sm-12 col-12"><a href="#" onClick=javascript:open_model_smilerproduct('+smilerproduct_i_code+');><div class="spansmilerproduct">View all '+smilerproductcount+' Similar Items<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/next1.png" width=16px></div></a></div></div>';
								}
								
								outofstockicon = '';
								if(batchqty=="0"){
									batchqty1 = '<span class="main_search_out_of_stock">Out of stock</span>';
									outofstockicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/outofstockicon.png" class="main_search_outofstockiconcss">';
								} 
								else 
								{
									batchqty1 = '<span class="main_search_stock">Stock : '+batchqty+'</span>';
									
									if(misc_settings=="#NRX")
									{
										if(parseInt(batchqty)>10)
										{
											batchqty1 = '<span class="main_search_stock">Available</span>';
										}
									}
								}
								
								featuredicon = '';
								if(featured=="1" && batchqty!="0"){
									featuredicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/featuredicon.png" class="main_search_featurediconcss">';
								}
								
								li_css = "";
								if(new_i%2==0) 
								{ 
									li_css = "search_page_gray"; 
								} 
								else 
								{  
									li_css = "search_page_gray1"; 
								}
								
								csshover1 = 'hover_'+new_i;
								
								your_order_qty = "";
								
								item_name_m 		= btoa(item_name);
								company_full_name_m = btoa(company_full_name);
								image_m1 	 		= btoa(image1);
								image_m2 	 		= btoa(image2);
								image_m3 	 		= btoa(image3);
								image_m4 	 		= btoa(image4);
								description1_m 	 	= btoa(description1);
								description2_m 	 	= btoa(description2);
								packing_m 			= btoa(packing);
								expiry_m  			= btoa(expiry);
								batch_no_m			= btoa(batch_no);
								scheme_m  			= btoa(scheme);
								date_time_m  		= btoa(date_time);
								items1				= JSON.stringify(items1);
								items1 	 			= btoa(items1);
								
								li_start = '<li class="search_page_hover '+li_css+' '+csshover1+'"><a href="#" onClick=get_single_medicine_info_search_page("'+i_code+'","'+item_name_m+'","'+company_full_name_m+'","'+image_m1+'","'+image_m2+'","'+image_m3+'","'+image_m4+'","'+description1_m+'","'+description2_m+'","'+batchqty+'","'+sale_rate+'","'+mrp+'","'+final_price+'","'+batch_no_m+'","'+packing_m+'","'+expiry_m+'","'+scheme_m+'","'+margin+'","'+featured+'","'+gstper+'","'+discount+'","'+itemjoinid+'","'+items1+'","'+date_time_m+'","'+your_order_qty+'","'+misc_settings+'"),clear_search_box(); class="search_page_hover_a get_single_medicine_info_'+new_i+'">';
								
								image_ = '<img src="'+image1+'" style="width: 100%;" class="border rounded">'+featuredicon+outofstockicon;
								
								scheme_show_hide = "";
								if(scheme=="0+0")
								{
									scheme =  'No scheme';
									scheme_show_hide = "display:none"
								}
								else
								{
									scheme =  'Scheme : '+scheme;
								}
								
								scheme_or_margin =  '<div class="row"><div class="col-sm-6 col-6"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/scheme.png" class="main_search_scheme_icon" style="'+scheme_show_hide+'"><span class="main_search_scheme" style="'+scheme_show_hide+'">'+scheme+'</span></div><div class="col-sm-6 col-6 text-right"><span class="main_search_margin">'+margin+'% Margin</span><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/ribbonicon.png" class="main_search_margin_icon"></div></div>';
								
								rete_div =  '<span class="cart_ptr">PTR: <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/- </span> | <span class="cart_ptr">MRP: <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/- </span> | <span class="cart_landing_price"> ~ <span class="mobile_off">Landing</span> Price: <i class="fa fa-inr" aria-hidden="true"></i> '+final_price+'/- </span>';
								
								sale_rate 	= parseFloat(sale_rate).toFixed(2);
								mrp 		= parseFloat(mrp).toFixed(2);
								final_price = parseFloat(final_price).toFixed(2);
								
								$(".search_medicine_result").append(li_start+'<div class="row"><div class="col-sm-3 col-4">'+image_+'</div><div class="col-sm-9 col-8"><div class="cart_title">'+item_name+'<span class="cart_packing"> ('+packing+' Packing)</span> </div><div class="cart_expiry">Expiry : '+expiry+'</div><span class="cart_description1">'+description1+'</span><div class="cart_company">By '+company_full_name+'</div><div class="cart_stock">'+batchqty1+'</div><div class="mobile_off">'+scheme_or_margin+'</div><div class="mobile_off">'+rete_div+'</div></div><div class="mobile_show col-sm-12 col-12">'+scheme_or_margin+'</div><div class="mobile_show col-sm-12 col-12">'+rete_div+'</div></div></li>'+smilerproduct);
								
								$(".search_pg_result_found").html("Search result");		
							}						
						}
					});
				},
				timeout: 60000
			});
		}
		else{
			$(".clear_search_box").hide();
			$(".search_medicine_result").html("");
		}
	}
}

</script>
<div class="select_medicine_in_modal_script_css"></div>
<div class="only_for_noti"></div>
<a href="#" data-toggle="modal" data-target="#myModal_loading" style="text-decoration: none;" class="myModal_loading"></a>
<div class="modal modaloff" id="myModal_loading">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title MedicineDetailscssmod">Medicine details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="MedicineDetailsData"></div>				
				<div class="MedicineSmilerProduct"></div>
			</div>
		</div>
	</div>
</div>
<?php /***************************broadcast**************************************/ ?>
<a href="#" data-toggle="modal" data-target="#myModal_broadcast" style="text-decoration: none;" class="myModal_broadcast"></a>
<div class="modal modaloff" id="myModal_broadcast">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title broadcast_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body broadcast_message">
				
			</div>
		</div>
	</div>
</div>