<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
		<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
   	</div>
    <div class="col-xs-12">
         <div class="table-responsive">
		 	Total Records : <?php echo $count_records ?> / <?= count($result) + ($_GET["pg"]) ?>
			<table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Function Type
						</th>
						<th>
							Chemist
						</th>
						<th>
							Title
						</th>
						<th>
							View
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
                        	<?if($row->funtype=="0"){ ?>Not Need<?php } ?>
							<?if($row->funtype=="1"){ ?>Item <?= $row->itemid; ?><?php } ?>
							<?if($row->funtype=="2"){ ?>Company <?= $row->compid; ?><?php } ?>
							<?if($row->funtype=="3"){ ?>Map Page<?php } ?>
							<?if($row->funtype=="4"){ ?>Orders Page<?php } ?>
							<?if($row->funtype=="5"){ ?>Invoice Page<?php } ?>
                        </td>
						<td>
							<?= ($row->user_type); ?> (<?= ($row->chemist_id); ?>)
                        </td>
						<td>
							<?= ($row->title); ?>
                        </td>
						<td>
							<a href="#" data-toggle="modal" data-target="#myModal_<?php echo $row->id ?>">View</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<ul class="pagination">
    <li class="startcss1 disabled"><span class="">First</span></li>
    <li class="startcss2 disabled"><span class="">Prev</span></li>
<?php
$endcss = "class='disabled'";
for($i=0;$i<($count_records);$i= 100 + $i){
	$showone = 0;
	if($i==0 && $per_page!=0){


		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo ceil($i/100)+1 ?></a></li>
		<script>
			$(".startcss1").removeClass("disabled");
			$(".startcss2").removeClass("disabled");

			$(".startcss1").html('<a rel="noopener" href="javascript:void(0)" class="fast" per_page="0">First</a>');
			$(".startcss2").html('<a rel="noopener" href="javascript:void(0)" class="previous" per_page="<?php echo $per_page - 100 ?>">Prev</a>');
		</script>
		<?php
		$showone = 1;
	}
	
	if($i==$per_page-100 && $showone == 0){
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval = ceil($i/100)+1 ?></a></li>
		<?php
	}
	
	if($i==$per_page){
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval1 = ceil($i/100)+1 ?></a></li>
		<?php
	}
	
	if($i==$per_page+100){
		$endcss = "";
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval2 = ceil($i/100)+1 ?></a></li>
		<?php
	}
}

if(ceil($i/100)==$lastval || ceil($i/100)==$lastval1 || ceil($i/100)==$lastval2){}else{
	?>
	<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($count_records/100)*100 - 100; ?>" ><?php echo ceil($i/100)?></a></li>
	<?php
}
$last = $next = '';

if($endcss == ''){
	$last = 'last';
	$next = 'next';
}
       /*echo $per_page;
    for($i=0;$i<ceil($count_records/100);$i++){

  if($i<=ceil($per_page/100)+10&&$i>=ceil($per_page/100)){
       if($i==0){ ?>
      <li class="<?php if(ceil($per_page/100)==$i){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo $i ?>" per_page="<?php echo "0"; ?>" ><?php echo "1" ?>xx</a></li>
      <?php  }else{ ?>
     <li class="<?php if(ceil($per_page/100)==$i){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per"  ford="<?php echo $i ?>" per_page="<?php echo $i*100; ?>" ><?php echo $i+1 ?>yy</a></li>
     <?php   }
    	?>
   
    
    <?php } ?>
    


    <?php }*/ ?>
    
    <li <?php /* class="<?php if($per_page >= $count_records){ echo 'disabled'; } ?>"*/ ?> <?=$endcss; ?>>
        <a rel="noopener" href="javascript:void(0);" class="<?= $next?>" per_page="<?php echo $per_page + 100; ?>">Next</a>
    </li>
    <li <?=$endcss; ?>><a rel="noopener" href="javascript:void(0)" class="<?= $last?>" per_page="<?php echo ceil($count_records/100)*100 - 100; ?>">Last</a></li>
</ul>
        </div>
    </div>
</div>
<script>
function password_create1(id)
{
	$(".loadingcss_"+id).html("Loading....");
	password = $(".password_"+id).val();
	$.ajax({
	type       : "POST",
	data       :  { id : id ,password:password} ,
	url        : "<?= base_url()?>admin/<?= $Page_name; ?>/password_create1",
	success    : function(data){
			if(data!="")
			{
				//alert(data);
				java_alert_function("success","Password Created Successfully");
				$(".loadingcss_"+id).html("");
				$(".myModalClose").click();
				$(".password_"+id).val('');
			}
			else
			{
				java_alert_function("error","Something Wrong")
			}
		}
	});
}


$(".for_per,.previous,.next,.last,.fast").click(function(){
	for_per=$(this).attr("ford");
	per_page=$(this).attr("per_page");
	url="<?php echo base_url() ?>admin/<?= $Page_name; ?>/view?pg="+per_page;
	window.location.href=url;
  
  });
  $(".page_btn").click(function(){
  	//alert("ok");
 // per_page="<?php echo $per_page ?>";
// for_per=$(this).attr("ford");
  //per_page=$(this).attr("per_page");
 page_no=$('.page_no').val();

 bysearch=0;
 if(page_no!=""&&page_no!=0){
 	for_per=page_no-1;
  per_page=for_per*100;
  bysearch=1;
 }
 url="<?php echo base_url() ?>admin/<?= $Page_name; ?>/view?pg="+per_page;
	window.location.href=url;
  });
</script>

<?php
$i=1;
foreach ($result as $row)
{
	?>
<div id="myModal_<?php echo $row->id ?>" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-center"><?= ($row->subject); ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>				
			</div>
			<div class="modal-body">
				<?= ($row->message); ?>
				
				<?php
				if($row->file_name1!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name1); ?>">
					<?= ($row->file_name_1); ?>
				</a>
				<?php } ?>
				
				<?php
				if($row->file_name2!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name2); ?>">
					<?= ($row->file_name_2); ?>
				</a>
				<?php } ?>
				
				<?php
				if($row->file_name3!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name3); ?>">
					<?= ($row->file_name_3); ?>
				</a>
				<?php } ?>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php
}
?>