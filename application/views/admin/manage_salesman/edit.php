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
			<input type="hidden" name="old_customer_code" value="<?= $row->customer_code; ?>" />
        	<input type="hidden" name="old_cust_email" value="<?= $row->cust_email; ?>" />
			<input type="hidden" name="old_cust_mobile" value="<?= $row->cust_mobile; ?>" />
			<?php
			$row1 = $this->db->query("select * from tbl_users_other where customer_code='$row->customer_code' ")->row();
			?>
			<input type="hidden" name="old_password" value="<?= $row1->password; ?>" />
			<div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
							First Name
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="First Name" name="firstname" value="<?= $row->firstname; ?>" required="required" />					</div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('firstname'); ?>
                        </span>
                    </div>
                </div>			
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Last Name
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="Last Name" name="lastname" value="<?= $row->lastname; ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('lastname'); ?>						</span>
                    </div>
                </div>
			</div>			
			<div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
							Email
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="form-field-1" placeholder="Email" name="cust_email" value="<?= $row->cust_email; ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('cust_email'); ?>
                        </span>
                    </div>
                </div>			
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Mobile No
                        </label>
                    </div>
                    <div class="col-sm-8">						<input type="text" class="form-control" id="form-field-1" placeholder="Mobile No" name="cust_mobile" value="<?= $row->cust_mobile; ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('cust_mobile'); ?>
                        </span>
                    </div>
                </div>
          	</div>		
			<div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
							Password
                        </label>					</div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="form-field-1" placeholder="Password" name="password" value="" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('password'); ?>
                        </span>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" data-placeholder="Select Status" class="chosen-select">
							<option value="1" <?php if($row->is_active==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->is_active==0) { ?> selected <?php } ?>>
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