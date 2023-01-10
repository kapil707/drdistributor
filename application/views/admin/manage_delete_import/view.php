<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
		<?php */ ?>
		<form method="post">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
					<div class="input-group date nk-int-st">
						<label>Select Date</label>
						<span class="input-group-addon"></span>
						<input type="text" class="form-control" value="<?= $vdt1; ?>" name="vdt">
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
				<button type="submit" name="submit" class="btn btn-success notika-btn-success waves-effect" value="submit">Submit</button>
			</div>
		</form>
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
							Date
						</th>
						<th>
							Chemist
						</th>
						<th>
                        	Selesman
						</th>
						 <th>
                        	Item Name
                        </th>
						<th>
                        	Item MRP
                        </th>
                        <th>
                        	Item QTY
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
                        	<?= date("d-M-y h:i a ", ($row->time));?>
                        </td>
						<td>
                        	<?php
							$row2 = $this->db->query("select name,altercode from tbl_acm where altercode='$row->acm_altercode'")->row();
							?>
							<?= $row2->name; ?> (<?= $row->acm_altercode;?>)
                        </td>
						<td>
                        	<?php
							if($row->salesman_altercode!=""){
							$row2 = $this->db->query("select * from tbl_users where customer_code='$row->salesman_altercode'")->row();
							?>
							<?= $row2->firstname; ?> <?= $row2->lastname; ?> (
                        	<?= $row->salesman_altercode;?>)
							<?php } ?>
                        </td>
						<td>
                        	<?= $row->your_item_name;?>
                        </td>
						<td>
                        	<?= $row->your_item_mrp;?>
                        </td>
						<td>
                        	<?= $row->item_qty;?>
                        </td>
					</tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>