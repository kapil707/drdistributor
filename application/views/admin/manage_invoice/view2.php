<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
    	<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
   	</div>
    <div class="col-xs-12">
         <div class="table-responsive">
			<table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Item
						</th>
						<th>
							Quantity
						</th>
						<th>
							Sales Rate
						</th>
						<th>
							Total
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
                        	<?= $row->item_name;?>
                        </td>
						<td>
                        	<?= round($row->qty);?>
                        </td>
						<td>
                        	<?= $row->netamt;?>
                        </td>
						<td>
                        	<?= $row->qty * $row->netamt;?>
                        </td>					</tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div></div>