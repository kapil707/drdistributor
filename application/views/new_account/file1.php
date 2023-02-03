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
$(".headertitle").html("<?= $main_page_title ?>");
function goBack() {
	window.location.href = "<?= base_url();?>home";
}
</script>
<div class="container maincontainercss">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-12 col-12">
					<div class="form-group">
						<label for="file">Upload excel file</label>
						<div class="row">
							<div class="col-sm-8 col-11">
								<input id="sortpicture" type="file" name="sortpic" class="form-control" onchange="sortpicture_change()" />
							</div>
							<div class="col-sm-1 col-1">
								<input id="clearfile" type="submit" name="clearfile" class="btn btn-w-m btn-danger clearfile site_round_btn31" onclick="clearfile()" style="display:none" value="Clear" style="width:20%" />
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="file">Header column number</label>
						<input type="text" name="headername"  class="form-control headername" placeholder="Header column number" value="5" />
					</div>	
					<div class="form-group">
						<label for="file">Header column company name</label>
						<input type="text" name="companyname" class="form-control companyname" placeholder="Header column company name" value="a" />
					</div>	
					<div class="form-group">
						<label for="file">Header column gst 0%</label>
						<input type="text" name="gst0" class="form-control gst0" placeholder="Header column gst 0%" value="b" />
					</div>
					<div class="form-group">
						<label for="file">Header column gst 5%</label>
						<input type="text" name="gst5" class="form-control gst5" placeholder="Header column gst 5%" value="d" />
					</div>
					<div class="form-group">
						<label for="file">Header column gst 12%</label>
						<input type="text" name="gst12" class="form-control gst12" placeholder="Header column gst 12%" value="f" />
					</div>
					<div class="form-group">
						<label for="file">Header column gst 18%</label>
						<input type="text" name="gst18" class="form-control gst18" placeholder="Header column gst 18%" value="h" />
					</div>
					<div class="form-group">
						<label for="file">Header column gst 28%</label>
						<input type="text" name="gst28" class="form-control gst28" placeholder="Header column gst 28%"  value="j" />
					</div>
					<div class="form-group">
						<label for="file">Header column total value</label>
						<input type="text" name="totalvalue" class="form-control totalvalue" placeholder="Header column total value"  value="l" />
					</div>
					<div class="form-group">
						<label for="file">GST add or not add</label>
						<br>
						<label for="file"><input type="checkbox" class="add_gst" checked>Add GST</label>
					</div>
					<div class="form-group text-right">
						<span id="upload_import_file_loading" style="display:none">Uploading....</span>
						<button id="upload_import_file" onclick="upload_import_file()" class="btn btn-primary mainbutton" style="width:20%">Upload</button>
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
	sortpicture1    = $("#sortpicture").val();	
	headername 		= $(".headername").val();
	companyname 	= $(".companyname").val();
	gst0 			= $(".gst0").val();
	gst5 			= $(".gst5").val();
	gst12			= $(".gst12").val();
	gst18 			= $(".gst18").val();	
	gst28 			= $(".gst28").val();
	totalvalue 		= $(".totalvalue").val();
	add_gst 		= $(".add_gst").val();	
	if(sortpicture1=="")
	{
		alert("Select File")
		$("#sortpicture").focus();
		return;
	}
	if(companyname=="")
	{
		$(".companyname").focus();
		alert("Enter header column company name")
		return;
	}
	if(gst0=="")
	{
		$(".gst0").focus();
		alert("Enter header column gst 0%")
		return;
	}
	if(gst5=="")
	{
		$(".gst5").focus();
		alert("Enter header column gst 5%")
		return;
	}
	if(gst12=="")
	{
		$(".gst12").focus();
		alert("Enter header column gst 12%")
		return;
	}
	if(gst18=="")
	{
		$(".gst18").focus();
		alert("Enter header column gst 18%")
		return;
	}
	if(gst28=="")
	{
		$(".gst28").focus();
		alert("Enter header column gst 28%")
		return;
	}
	if(totalvalue=="")
	{
		$(".totalvalue").focus();
		alert("Enter header column total value")
		return;
	}
	if(add_gst=="")
	{
		add_gst = "0";
	}
	
	$("#upload_import_file_loading").show();
	$("#upload_import_file").hide();
	var file_data = $('#sortpicture').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('file',file_data);
    //alert(form_data);                             
    $.ajax({
		url: "<?= base_url()?>new_account/upload_file1/?headername="+headername+"&companyname="+companyname+"&gst0="+gst0+"&gst5="+gst5+"&gst12="+gst12+"&gst18="+gst18+"&gst28="+gst28+"&totalvalue="+totalvalue+"&add_gst="+add_gst,
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
		timeout: 40000
	});
}
</script>