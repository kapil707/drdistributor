<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>		<?php */ ?>
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
							GSTVNO
						</th>
						<th>
							Date
						</th>
						<th>
							Chemist
						</th>
						<th>
							Item Name
						</th>
						<th>
                        	Sale Rate						</th>
						<th>
                        	Net Amt
                        </th>
						<th>
                        	Final Amt
                        </th>
                        <th>
                        	Descp
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
                        	<?= $row->gstvno;?>
                        </td>
						<td>
                        	<?= date("d-M-Y", strtotime($row->vdt));?>
                        </td>
						<td>
                        	<?php
							$row1 = $this->db->query("select acno from tbl_sales_main where gstvno='$row->gstvno' and vdt='$row->vdt'")->row();
							?>
							<?php
							$row2 = $this->db->query("select name,altercode from tbl_acm where code='$row1->acno'")->row();
							?>
							<?= $row2->name; ?> (<?= $row2->altercode;?>)
                        </td>
						<td>
                        	<?= $row->item_name;?>
                        </td>
						<td>
							<?php
							$row2 = $this->db->query("select sale_rate from tbl_medicine where item_code='$row->item_code'")->row();
							?>
							<?php
							echo $sale_rate  = $row2->sale_rate;
							$total_sale_rate = $total_sale_rate + $sale_rate; ?>
                        </td>
						<td>
                        	<?php 
							echo $net_amt = $row->delete_amt - $row->delete_namt;
							$total_net_amt = $total_net_amt + $net_amt; ?>
                        </td>
						<td>
                        	<?php echo $final_amt = $net_amt*$sale_rate;
							$total_final_amt = $total_final_amt + $final_amt; ?>
                        </td>						<td>                        	<?= $row->delete_descp;?>                        </td>					</tr>
                    <?php
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
                        	<?= $total_sale_rate; ?>
						</th>
						<th>
                        	<?= $total_net_amt; ?>
                        </th>
						<th>
							<?= $total_final_amt; ?>
                        </th>
                        <th>
                        	
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div></div>