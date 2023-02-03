<div class="row">
	<div class="col-xs-12">
		<a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>/view">
		    <button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Title
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="Title" name="title" value="DRD - Notification" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('title'); ?>
                        </span>
                    </div>
                </div>
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
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<div class="col-sm-4 text-right">
						<label class="control-label" for="form-field-1">
							Message
						</label>
					</div>
					<div class="col-sm-8">
						<textarea type="text" class="form-control" id="form-field-1" placeholder="Message" name="message" value="" required="required"><?= set_value('message'); ?></textarea>
					</div>
					<div class="help-inline col-sm-12 has-error">
						<span class="help-block reset middle">
							<?= form_error('message'); ?>
						</span>
					</div>
				</div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image" name="image" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image'); ?>
                        </span>
                    </div>
              	</div>
			</div>
				
			<div class="form-group">				
				<div class="col-sm-6">
					<div class="col-sm-4 text-right">
						<label class="control-label" for="form-field-1">
							Enter Name / Altercode
						</label>
					</div>
					<div class="col-sm-8">
						<input type="hidden" id="altercode" name="altercode"/>
						<input type="text" class="form-control" id="acm_name" name="acm_name"tabindex="1" onkeydown="call_search_acm()" onkeyup="call_search_acm()" placeholder="Enter Name / Altercode" autocomplete="off" />
						<div class="call_search_acm_result" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
					</div>
					<div class="help-inline col-sm-12 has-error">
						<span class="help-block reset middle">
							<?= form_error('altercode'); ?>
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
                        <input type="hidden" id="itemid" name="itemid"/>
						<input type="text" class="form-control" id="item_name" name="item_name"tabindex="1" onkeydown="call_search_item()" onkeyup="call_search_item()" placeholder="Select Item" autocomplete="off" />
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
						<input type="hidden" id="compid" name="compid"/>
						<input type="text" class="form-control" id="company_name" name="company_name" tabindex="1" onkeydown="call_search_company()" onkeyup="call_search_company()" placeholder="Select Company" autocomplete="off" />
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
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('division'); ?>
                        </span>
                    </div>
                </div>
			</div>
            

            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info submit_button" name="Submit">
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
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
function call_search_acm()
{	
	acm_name = $("#acm_name").val();
	$(".call_search_acm_result").html("Loading....");
	if(acm_name=="")
	{
		$(".call_search_acm_result").html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {acm_name:acm_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_acm",
		cache	   : false,
		success    : function(data){
			$(".call_search_acm_result").html(data);
			}
		});
	}
}
function addacm(id,name)
{
	name = atob(name);
	$("#altercode").val(id);
	$("#acm_name").val(name);
	$(".call_search_acm_result").html("");
}
</script>

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
function additem(id,name)
{
	name = atob(name);
	$("#itemid").val(id);
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