<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
			<div class="form-group">	
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Item
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="hidden" id="i_code" name="i_code" value=""/>
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
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" data-placeholder="Select Status" class="form-control">
							<option value="1" <?php if(set_value('status')==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if(set_value('status')==0) { ?> selected <?php } ?>>
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
function call_search_item()
{	
	item_name = $("#item_name").val();
	$(".call_search_item_result").html("Loading....");
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
function additem(i_code,name)
{
	name = atob(name);
	$("#i_code").val(i_code);
	$("#item_name").val(name);
	$(".call_search_item_result").html("");
}
</script>