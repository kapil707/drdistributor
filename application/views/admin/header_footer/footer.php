</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                     <div class="pull-right">
						Powered by Wevkings&nbsp; &nbsp; &nbsp; &nbsp; 
					</div>
					<div>
						All rights are reserved  &copy; <?php echo date("Y") ?>
					</div>
                </div>
            </div>
        </div>
	</div>
    <!-- Mainly scripts -->
    <script src="<?= base_url()?>/assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url()?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Flot -->
    <script src="<?= base_url()?>/assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/flot/jquery.flot.pie.js"></script>
    <!-- Peity -->
    <script src="<?= base_url()?>/assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?= base_url()?>/assets/js/demo/peity-demo.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?= base_url()?>/assets/js/inspinia.js"></script>
    <script src="<?= base_url()?>/assets/js/plugins/pace/pace.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?= base_url()?>/assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- GITTER -->
    <script src="<?= base_url()?>/assets/js/plugins/gritter/jquery.gritter.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url()?>/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- Sparkline demo data  -->
    <script src="<?= base_url()?>/assets/js/demo/sparkline-demo.js"></script>
    <!-- ChartJS-->
    <script src="<?= base_url()?>/assets/js/plugins/chartJs/Chart.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url()?>/assets/js/plugins/toastr/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "progressBar": true,
				  "preventDuplicates": false,
				  "positionClass": "toast-top-right",
				  "onclick": null,
				  "showDuration": "400",
				  "hideDuration": "1000",
				  "timeOut": "7000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};
				<?php
				if($this->session->flashdata('message_footer')!="")
				{
					if($this->session->flashdata('message_type')=="success")
					{ 
						?>
							toastr.success('<?= $this->session->flashdata('full_message'); ?>');
						<?php 
					} 
					if($this->session->flashdata('message_type')=="info")
					{ 
						?>
							toastr.info('<?= $this->session->flashdata('full_message'); ?>');
						<?php
					}
					if($this->session->flashdata('message_type')=="warning")
					{ 
						?>
							toastr.warning('<?= $this->session->flashdata('full_message'); ?>');
						<?php
					}						
					if($this->session->flashdata('message_type')=="error")
					{
						?>
							toastr.error('<?= $this->session->flashdata('full_message'); ?>');
						<?php
					}
				}?>
            }, 1300);
        });
		function java_alert_function(message_type,full_message)
		{
			toastr.options = {
			  "closeButton": true,
			  "debug": false,
			  "progressBar": true,
			  "preventDuplicates": false,
			  "positionClass": "toast-top-right",
			  "onclick": null,
			  "showDuration": "400",
			  "hideDuration": "5000",
			  "timeOut": "7000",
			  "extendedTimeOut": "5000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};
			if(message_type=="success")
			{ 
				toastr.success(full_message);
			} 
			if(message_type=="info")
			{ 
				toastr.info(full_message);
			}
			if(message_type=="warning")
			{ 
				toastr.warning(full_message);
			}						
			if(message_type=="error")
			{
				toastr.error(full_message);
			}
		}
    </script>
	<script src="<?= base_url()?>/assets/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},
                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]
            });
        });
    </script>
<!-- Data picker -->
   <script src="<?= base_url()?>/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script>
$('#data_5 .input-daterange').datepicker({
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true,
	format: 'dd-MM-yyyy'
});  </script>
<!-- Dual Listbox -->
<script src="<?= base_url()?>/assets/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
<script>
$(document).ready(function(){
$('.dual_select').bootstrapDualListbox({
selectorMinimalHeight: 160
});
check_login();
get_latitude_longitude();
});
</script>
<!-- Chosen -->
    <script src="<?= base_url()?>/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Jasny -->
    <script src="<?= base_url()?>/assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script>
function goBack() {
    window.history.back();
}
</script>
   <!-- Switchery -->
   <script src="<?= base_url()?>/assets/js/plugins/switchery/switchery.js"></script>
<script>
$(document).ready(function(){
$('.chosen-select').chosen({width: "100%"});
var elem = document.querySelector('.js-switch');
var switchery = new Switchery(elem, { color: '#1AB394' });
var elem1 = document.querySelector('.js-switch1');
var switchery1 = new Switchery(elem1, { color: '#1AB394' });
var elem2 = document.querySelector('.js-switch2');
var switchery2 = new Switchery(elem2, { color: '#1AB394' });
var elem3 = document.querySelector('.js-switch3');
var switchery3 = new Switchery(elem3, { color: '#1AB394' });
var elem4 = document.querySelector('.js-switch4');
var switchery4 = new Switchery(elem4, { color: '#1AB394' });
var elem5 = document.querySelector('.js-switch5');
var switchery5 = new Switchery(elem5, { color: '#1AB394' });
});
</script>
<div class="script_load"></div>
<script>
function onchange_theme_header()
{
	id = $("#theme_header").val();
	$.ajax({
	type       : "POST",
	data       :  { id : id } ,
	url        : "<?= base_url()?>admin/dashboard/onchange_theme_header",
	success    : function(data){
			if(data=="ok")
			{
				java_alert_function("success","Theme Set");
			}
		}
	});
}
function onchange_theme_footer()
{
	id = $("#theme_footer").val();
	$.ajax({
	type       : "POST",
	data       :  { id : id } ,
	url        : "<?= base_url()?>admin/dashboard/onchange_theme_footer",
	success    : function(data){
			if(data=="ok")
			{
				java_alert_function("success","Website Type Set");
			}
		}
	});
}
function onchange_theme_slider()
{
	id = $("#theme_slider").val();
	$.ajax({
	type       : "POST",
	data       :  { id : id } ,
	url        : "<?= base_url()?>admin/dashboard/onchange_theme_slider",
	success    : function(data){
			if(data=="ok")
			{
				java_alert_function("success","Website Type Set");
			}
		}
	});
}
function check_login()
{
	var time1="yoyo";
	$.ajax({
	type       : "POST",
	data       :  { time1 : time1 } ,
	url        : "<?= base_url()?>admin/dashboard/check_login",
	success    : function(data){
			if(data=="notok")
			{
				window.location.href = "<?= base_url()?>admin"
			}
			else
			{
				if(data=="update")
				{
					window.location.href = "<?= base_url()?>admin/dashboard"
				}
				else
				{
					$(".script_load").html(data);
				}
			}
		}
	});
	setTimeout('check_login();',1000);
	//show_now_time1();
}
function notify(pgtype)
{
	$.ajax({
	type       : "POST",
	data       :  { pgtype : pgtype } ,
	url        : "<?= base_url()?>admin/dashboard/notify",
	success    : function(data){
			if(data)
			{
				$("#"+pgtype+"_div").html(data)
			}
		}
	});
}
</script>
<!-- SUMMERNOTE -->
<script src="<?= base_url()?>/assets/js/plugins/summernote/summernote.min.js"></script>
<script>
	$(document).ready(function(){
		$('.summernote').summernote();
   });
</script>
</body>
</html>