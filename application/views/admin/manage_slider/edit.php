<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
            <input type="hidden" name="old_image" value="<?= $row->image; ?>" />
			
			<div class="form-group">	
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Function Type
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="funtype" id="funtype" class="form-control">
							<option value="0">
								Not Need
							</option>
							<option value="1" <?php if($row->funtype=="1"){ ?> selected <?php } ?>>
								Select Item
							</option>							
							<option value="2" <?php if($row->funtype=="2"){ ?> selected <?php } ?>>
								Select Company
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('funtype'); ?>
                        </span>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Item
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" id="i_code" name="i_code" value="<?= $i_code = $row->itemid?>"/>
						<?php 
						$row1 =  $this->db->query ("select item_name,item_code from tbl_medicine where i_code='$i_code'")->row();
						?>
						<input type="text" class="form-control" id="item_name" name="item_name"tabindex="1" onkeydown="call_search_item()" onkeyup="call_search_item()" placeholder="Select Item" autocomplete="off" value="<?= $row1->item_name?> (<?= $row1->item_code?>)" />
						<div class="call_search_item_result" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('itemid'); ?>
                        </span>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Company
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="hidden" id="compid" name="compid" value="<?= $compid = $row->compid?>" />
						<?php 
						$row1 =  $this->db->query ("select company_full_name from tbl_medicine where compcode='$compid'")->row();
						?>
						<input type="text" class="form-control" id="company_name" name="company_name" tabindex="1" onkeydown="call_search_company()" onkeyup="call_search_company()" placeholder="Select Company" autocomplete="off"value="<?= $row1->company_full_name?>" />
						<div class="call_search_company_result" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('compid'); ?>
                        </span>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Company Division
                        </label>
                    </div>
                    <div class="col-sm-8 division_div">                        
						<select name="division" id="division" class="form-control">
							<option value="">
								Select Company Division
							</option>
							<?php
							$result1 =  $this->db->query ("select DISTINCT division from tbl_medicine where compcode='$compid' order by division asc")->result();
							foreach($result1 as $row1)
							{
								$division = $row1->division;
								?>
								<option value="<?= $division ?>" <?php if($division==$row->division) { ?>selected <?php } ?>>
									<?= $division ?>
								</option>
								<?php
							}?>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('division'); ?>
                        </span>
                    </div>
                </div>
			</div>
           
            <div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image" name="image" />
                    </div>
                    <div class="col-sm-2" id="imgchange">
                    	<img src="<?= $url_path ?><?= $row->image; ?>" class="img-responsive" />
                    	<?php if($row->image!="default.jpg") { ?>
                    	<Br /><a href="javascript:void(0)" onclick="delete_photo('<?= $row->id; ?>')"><i class="fa fa-remove"></i>Delete</a>
                        <?php } ?>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Image'); ?>
                        </span>
                    </div>
                </div>				
			</div>
			
			<div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" class="form-control">
							<option value="1" <?php if($row->status==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->status==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('status'); ?>
                        </span>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
							Short Order
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="number" class="form-control" id="short_order" name="short_order" placeholder="Short Order" value="<?= $row->short_order;?>" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('short_order'); ?>
                        </span>
                    </div>
                </div>
			</div>
            
            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info" name="Submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
            <?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
function call_search_item()
{	
	item_name = $("#item_name").val();
	$(".call_search_item_result").html("Loading....");
	if(item_name=="")
	{
		$(".call_search_item_result").html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {item_name:item_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_item",
		cache	   : false,
		success    : function(data){
			$(".call_search_item_result").html(data);
			}
		});
	}
}
function additem(i_code,name)
{
	name = atob(name);
	$("#i_code").val(i_code);
	$("#item_name").val(name);
	$(".call_search_item_result").html("");
}

function call_search_company()
{	
	company_name = $("#company_name").val();
	$(".call_search_company_result").html("Loading....");
	if(company_name=="")
	{
		$(".call_search_company_result").html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {company_name:company_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_company",
		cache	   : false,
		success    : function(data){
			$(".call_search_company_result").html(data);
			}
		});
	}
}
function addcompany(id,name)
{
	name = atob(name);
	$("#compid").val(id);
	$("#company_name").val(name);
	$(".call_search_company_result").html("");
	get_company_division();
}
function get_company_division()
{	
	compid = $("#compid").val();
	$(".division_div").html("Loading....");
	$.ajax({
	type       : "POST",
	data       :  {compid:compid},
	url        : "<?= base_url()?>admin/<?= $Page_name?>/get_company_division",
	cache	   : false,
	success    : function(data){
		$(".division_div").html(data);
		}
	});
}
</script>