<div class="row">
	<div class="col-xs-12">
		<a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>">
		<button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
			<input type="hidden" value="<?= $row->image ?>" name="old_image">
        	<br><h4><?= $row->name ?>
			<br>Code : <?= $row->altercode ?></h4>
            <div class="form-group" id="data_5">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" data-placeholder="Select Status" class="chosen-select" >
							<option value="1" <?php if($row->status==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->status=="0") { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
				</div>				
				
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Block
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="block" id="block" data-placeholder="Select Status" class="chosen-select" >
							<option value="1" <?php if($row->block==1) { ?> selected <?php } ?>>
								Yes
							</option>
							<option value="0" <?php if($row->block=="0") { ?> selected <?php } ?>>
								No
							</option>
						</select>
                    </div>
				</div>				
          	</div>
			<div class="form-group" id="data_5">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Order Limit
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="" value="<?= $row->order_limit ?>" required name="order_limit">
                    </div>
				</div>

				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            New Password
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="text" class="" value="" name="new_password">
                    </div>
				</div>
			</div>
            <div class="form-group" id="data_5">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="file" class="" value="" name="image">
                        <?php
                        $user_image 	= 	base_url()."user_profile/".$row->image;
						if($row->image=="")
						{
							$user_image = base_url()."img_v".constant('site_v')."/logo.png";
						} ?>
                        <br>
                        <img src="<?= $user_image ?>" width="70%" alt>
                    </div>
				</div>
			</div>

            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info" name="Submit">
                        <em class="ace-icon fa fa-check bigger-110"></em>
                        Submit
                    </button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <em class="ace-icon fa fa-undo bigger-110"></em>
                        Reset
                    </button>
                </div>
            </div>
            <?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->