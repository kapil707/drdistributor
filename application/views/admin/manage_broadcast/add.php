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
                        <input type="text" class="form-control" id="form-field-1" placeholder="Title" name="title" value="DRD - Broadcast" required="required" />
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
                            Broadcast
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="broadcast" name="broadcast" value="" required="required"><?= set_value('broadcast'); ?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('broadcast'); ?>
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