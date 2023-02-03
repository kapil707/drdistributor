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
	if(sortpicture1=="")
	{
		alert("Select File")
		$("#sortpicture").focus();
		return;
	}
	
	$("#upload_import_file_loading").show();
	$("#upload_import_file").hide();
	var file_data = $('#sortpicture').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('file',file_data);
    //alert(form_data);                             
    $.ajax({
		url: "<?= base_url()?>new_account/upload_file_master2",
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