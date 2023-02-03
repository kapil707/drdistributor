<div class="row">
	<div class="col-xs-12">
        <a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>/view?pg=<?= $_GET["pg"]; ?>#row_<?=$id ?>">
		<button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
			<div class="form-group">
				<div class="col-sm-6">
					<div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Medicine Category
                        </label>
                    </div>
                    <div class="col-sm-8">
						<select name="medicine_category" id="medicine_category" class="form-control" onchange="onchange_medicine_category()" required>
							<option value="0">
								Select Medicine Category
							</option>
							<?php
							$query = $this->db->query("SELECT * FROM `tbl_master` WHERE `slcd`='ic' order by name asc")->result();
							foreach($query as $row1){
							?>
							<option value="<?= $row1->code; ?>" <?php if($row->code==$row1->code) { ?> selected <?php } ?>><?= $row1->name; ?></option>
							<?php } ?>
						</select>
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
                            Medicine Category
                        </label>
                    </div>
                    <div class="col-sm-8">
						<input type="text" class="form-control" id="menu" name="menu" tabindex="1" placeholder="Medicine Category" required value="<?= $row->menu; ?>" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('menu'); ?>
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
                        <input type="file" class="form-control" id="form-field-1" placeholder="image" name="image" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $url_path ?><?= $row->image; ?>" class="img-responsive" />
                    	<?php if($row->image!="default.jpg") { ?>
                    	<Br /><a href="javascript:void(0)" onclick="delete_photo('<?= $row->image; ?>','image')" class="btn-white btn btn-xs">Delete</i></a>
                        <?php } ?>
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
						<input type="number" class="form-control" id="short_order" name="short_order" placeholder="Short Order" value="<?= $row->short_order; ?>" />
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
function onchange_medicine_category()
{	
	menu = $("#medicine_category").find("option:selected").text();
	$("#menu").val(menu);
}
</script>