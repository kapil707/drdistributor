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
			<table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Order No
						</th><th>
							GSTVNO
						</th>
						<th>
							Date
						</th>
						<th>
							Chemist
							<br>
							SalesMan
						</th>
						<th>
							Download Status
							/
							Order Type
						</th>
						<th>
							Total Amount
						</th>
						<th>
							Line Items
						</th>
						<th>
							View Order
						</th>
						<th>
							Export
						</th>
                    </tr>
                </thead>
                <tbody>
                <?php
				$i=1;
                foreach ($result as $row)
                {
					$total = 0;
					$line_items = $row->count;
					$total_line_items = $total_line_items + $row->count;
										
					$total = $total + ($row->stockvalue);
					$total_amount = $total_amount + $total;
					?>
                    <tr id="row_<?= $row->order_id; ?>">
                    	<td>
                        	<?= $i; ?>
                        </td>
						<td>
                        	<?= $row->order_id;?>
						</td>
						<td>
							<?= $row->gstvno;?>
                        </td>
						<td>
                        	<?= $row->date;?>
							<?= $row->time;?>
                        </td>
						<td>
							<?php
							$row2 = $this->db->query("select name from tbl_acm where altercode='$row->chemist_id'")->row();
							?>
							<?= $row2->name; ?> (<?= $row->chemist_id;?>)
							<br>
							<?php
							if($row1->selesman_id!=""){
							$row2 = $this->db->query("select * from tbl_users where customer_code='$row1->selesman_id'")->row();
							?>
							<?= $row2->firstname; ?> <?= $row2->lastname; ?> (
                        	<?= $row1->selesman_id;?>)
							<?php } ?>
                        </td>
						<td>
                        	<?php if($row->download_status==0){ echo "No"; }?>
							<?php if($row->download_status==1){ echo "Yes"; }?> 
							<br>
                        	<?php if($row->order_type=="pc_mobile") { echo "Direct Order";} ?>
							<?php if($row->order_type=="excelFile") { ?>
							<a href="http://drdistributor.com/chemist/upload_import_orders/<?php echo base64_decode($row1->filename) ?>">
								Excel File
							</a>
							<?php } ?>
							<?php if($row->order_type=="android") { echo "Android";} ?>
                        </td>
						<td>
                        	<?php echo money_format('%!i',$total); ?>
                        </td>
						<td>
                        	<?= $line_items;?>
                        </td>
						<td class="text-right">
							<div class="btn-group">
								<a href="view2/<?= $row->order_id; ?>" class="btn-white btn btn-xs">View
								</a>
							</div>
                        </td>
						<td>
                        	<a href="download_order/<?= $row->order_id; ?>">
								Download
							</a>
                        </td>
					</tr>
                    <?php
						$i++;
                    }
                    ?>
                </tbody>
				<tfoot>
                    <tr>
                    	<th>
                        	Total
                        </th>
						
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							
						</th>
						<th>
							<?php echo money_format('%!i',$total_amount); ?>
						</th>
						<th>
							<?php echo $total_line_items ?>
						</th>
						<th>
							
						</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>