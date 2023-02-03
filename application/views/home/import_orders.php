<style>
.menubtn1
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<script>
$(".headertitle").html("Upload order");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<?php if($chemist_id!=""){ ?>
					<div class="col-sm-12">
						<li class="list_item_radius">
							<div class="row">
								<div class="col-sm-1 col-3">
									<img src="<?= $chemist_image ?>" alt="" title="" class="rounded account_page_header_image">
								</div>
								<div class="col-sm-11 col-9 text-left">
									<span class="select_chemist_name">
										<?php echo $chemist_name; ?>
									</span>
									<br>
									<span class="select_chemist_code">
										Code : <?php echo $chemist_id; ?>
									</span>
									<br>
									<a href="<?= base_url(); ?>import_order/select_chemist" style="color:gray" title="Change Chemist">
									<img class="img-circle" src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/edit_icon.png" width="15" alt="Change Chemist" title="Change Chemist"> Change chemist</a>
								</div>
							</div>
						</li>
					</div>
				<?php } ?>
				<div class="col-sm-12 col-12">
					<div class="form-group">
						<label for="file">Upload excel file</label>
						<div class="row">
							<div class="col-sm-8 col-11">
								<input id="sortpicture" type="file" name="sortpic" class="form-control" onchange="sortpicture_change()" />
								<input type="hidden" name="chemist_id" id="chemist_id" class="chemist_id" value="<?= $chemist_id ?>" style="padding-bottom: 36px;" />
							</div>
							<div class="col-sm-1 col-1">
								<input id="clearfile" type="submit" name="clearfile" class="btn btn-w-m btn-danger clearfile site_round_btn31" onclick="clearfile()" style="display:none" value="Clear" style="width:20%" />
							</div>
							
							<div class="col-sm-3 col-12 text-right">
								<a href="<?= base_url('import_order/suggest_medicine')?>" title="Suggest medicine edit" style="font-size: 15px; color:gray">
									<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
									Suggest medicine edit
								</a>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="file">Header row number</label>
						<input type="text" name="headername"  class="form-control headername" placeholder="Header row number" value="<?= $headername ?>" />
					</div>	
					<div class="form-group">
						<label for="file">Item row name</label>
						<input type="text" name="itemname" class="form-control itemname" placeholder="Item row name" value="<?= $itemname ?>" />
					</div>	
					<div class="form-group">
						<label for="file">Item row mrp</label>
						<input type="text" name="itemmrp" class="form-control itemmrp" placeholder="Item row mrp" value="<?= $itemmrp ?>" />
					</div>
					<div class="form-group">
						<label for="file">Item row quantity</label>
						<input type="text" name="itemqty" class="form-control itemqty" placeholder="Item row quantity" value="<?= $itemqty ?>" />
					</div>
					<div class="form-group text-right">
						<span id="upload_import_file_loading" style="display:none">Uploading....</span>
						<button id="upload_import_file" onclick="upload_import_file()" class="btn btn-w-m btn-success site_main_btn31" style="width:20%">Upload</button>
					</div>					
				</div>
			</div>
		</div>
	</div>     
</div>
<script type="text/javascript">
function sortpicture_change()
{
	sortpicture1 = $("#sortpicture").val();	
	if(sortpicture1=="")
	{
		$(".clearfile").hide();
	}
	else
	{
		$(".clearfile").show();
	}
}
function clearfile()
{
	$("#sortpicture").val('');
	$(".clearfile").hide();
}
function upload_import_file()
{
	headername 	= $(".headername").val();
	itemname 	= $(".itemname").val();
	itemqty 	= $(".itemqty").val();
	itemmrp 	= $(".itemmrp").val();
	chemist_id	= $(".chemist_id").val();
	sortpicture1 = $("#sortpicture").val();	
	if(sortpicture1=="")
	{
		alert("Select File")
		$("#sortpicture").focus();
		return;
	}
	if(headername=="")
	{
		$(".headername").focus();
		alert("Enter Header Row Number")
		return;
	}
	if(itemname=="")
	{
		$(".itemname").focus();
		alert("Enter Item Row Name")
		return;
	}
	if(itemqty=="")
	{
		$(".itemqty").focus();
		alert("Enter Item Row Quantity")
		return;
	}
	if(itemmrp=="")
	{
		$(".itemmrp").focus();
		alert("Enter Item Row Mrp")
		return;
	}	
	$("#upload_import_file_loading").show();
	$("#upload_import_file").hide();
	var file_data = $('#sortpicture').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('file',file_data);
    //alert(form_data);                             
    $.ajax({
		url: "<?= base_url()?>import_order/upload_import_file/?headername="+headername+"&itemname="+itemname+"&itemqty="+itemqty+"&itemmrp="+itemmrp+"&chemist_id="+chemist_id,
		/*dataType: 'text',*/
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		error: function(){
		   	swal("Please compare the columns in the Excel file with those you have entered in the website.");
		   	$("#upload_import_file_loading").hide();
			$("#upload_import_file").show();
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					window.location.href = item.url;
				} 
			});
		},
		timeout: 10000
	});
}
</script>