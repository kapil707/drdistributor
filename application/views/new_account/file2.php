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
						<input type="text" name="headername"  class="form-control headername" placeholder="Header column number" value="7" />
					</div>
					<div class="form-group">
						<label for="file">Header column code</label>
						<input type="text" name="code" class="form-control code" placeholder="Header column code" value="b" />
					</div>	
					<div class="form-group">
						<label for="file">Header column name</label>
						<input type="text" name="name" class="form-control name" placeholder="Header column name" value="c" />
					</div>	
					<div class="form-group">
						<label for="file">Header column flag</label>
						<input type="text" name="flag" class="form-control flag" placeholder="Header column flag" value="d" />
					</div>
					<div class="form-group">
						<label for="file">Header column debit</label>
						<input type="text" name="debit" class="form-control debit" placeholder="Header column debit" value="i" />
					</div>
					<div class="form-group">
						<label for="file">Header column credit</label>
						<input type="text" name="credit" class="form-control credit" placeholder="Header column credit" value="j" />
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
	code 			= $(".code").val();
	name 			= $(".name").val();
	flag 			= $(".flag").val();
	debit			= $(".debit").val();
	credit			= $(".credit").val();	
	if(sortpicture1=="")
	{
		alert("Select File")
		$("#sortpicture").focus();
		return;
	}
	if(code=="")
	{
		$(".code").focus();
		alert("Enter header column code")
		return;
	}
	if(name=="")
	{
		$(".name").focus();
		alert("Enter header column name")
		return;
	}
	if(flag=="")
	{
		$(".flag").focus();
		alert("Enter header column flag")
		return;
	}
	if(debit=="")
	{
		$(".debit").focus();
		alert("Enter header column debit")
		return;
	}
	if(credit=="")
	{
		$(".credit").focus();
		alert("Enter header column credit")
		return;
	}
	$("#upload_import_file_loading").show();
	$("#upload_import_file").hide();
	var file_data = $('#sortpicture').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('file',file_data);
    //alert(form_data);                             
    $.ajax({
		url: "<?= base_url()?>new_account/upload_file2/?headername="+headername+"&code="+code+"&name="+name+"&flag="+flag+"&debit="+debit+"&credit="+credit,
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