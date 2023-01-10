<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
		<a href="view2" class="btn btn-w-m btn-info">
			View all Users
		</a>
   	</div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Name
						</th>
						<th>
							Date
						</th>
						<th>
							Time
						</th>
						<th>
							Notification
						</th>
						<th>
							View In Map
						</th>
                    </tr>
                </thead>
                <tbody>
                <?php
				$i=1;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $row->id; ?>">
                    	<td>
                        	<?= $i++; ?>
                        </td>
						<td>
                        	<?= $row->name;?>
                        </td>
						<td>
                        	<?= $row->date;?>
                        </td>
						<td>
                        	<?= $row->time;?>
                        </td>
						<td>
							<form method="post">
							<input type="hidden" value="<?php echo $row->altercode;?>" name="altercode">
                        	<button type="submit" class="btn btn-primary block full-width m-b" name="Notification" value="Notification">Notification</button>
							</form>
                        </td>
						<td>
                        	<div class="btn-group">
								<a href="view2/?altercode=<?= $row->altercode; ?>" class="btn-white btn btn-xs">View</a>
							</div>
                        </td>					</tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div></div>