<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>		<?php */ ?>
		<form method="post">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
					<div class="input-group date nk-int-st">
						<label>Start Date</label>
						<span class="input-group-addon"></span>
						<input type="text" class="form-control" value="<?= $vdt; ?>" name="vdt">
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
					<div class="input-group date nk-int-st">
						<label>End Date</label>
						<span class="input-group-addon"></span>
						<input type="text" class="form-control" value="<?= $vdt1; ?>" name="vdt1">
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<label>Select Item</label>
				<input type="hidden" id="i_code" name="i_code"/>
				<input type="text" class="form-control" id="item_name" name="item_name"tabindex="1" onkeydown="call_search_item()" onkeyup="call_search_item()" placeholder="Select Item" autocomplete="off" />
				<div class="call_search_item_result" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
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
							Qty
						</th>
                    </tr>
                </thead>
                <tbody>
                <?php
				$i=1;
				$total_amount = 0;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $i; ?>">
                    	<td>
                        	<?= $i; ?>
                        </td>
						<td>
                        	<?= $row->gstvno;?>
                        </td>
						<td>
							<?php
							$vdt = DateTime::createFromFormat("Y-m-d",$row->vdt);
							echo $vdt->format('d-M-yy');
							?>
                        </td>
						<td>
							<?php
							$row1 = $this->db->query("select acno from tbl_sales_main where gstvno='$row->gstvno'")->row();
							$row2 = $this->db->query("select name,altercode from tbl_acm where code='$row1->acno'")->row();
							?>
							<?= $row2->name; ?> (<?= $row2->altercode;?>)
                        </td>
						<td>
                        	<?= $row->item_name;?>
                        </td>
						<td>
                        	<?= round($row->qty);?>
							<?php $total_amount = $total_amount + round($row->qty);?>
                        </td>					</tr>
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
							<?php echo round($total_amount); ?>
						</th>
						<th>
							
						</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div></div>
<script>
function call_search_item()
{	
	item_name = $("#item_name").val();
	$(".call_search_item_result").html("Loading....");
	if(item_name=="")
	{
		$(".call_search_item_result").html("");
	}
	else
	{
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
}
function additem(i_code,name)
{
	name = atob(name);
	$("#i_code").val(i_code);
	$("#item_name").val(name);
	$(".call_search_item_result").html("");
}
</script>