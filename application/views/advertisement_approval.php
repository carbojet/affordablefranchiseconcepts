<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	
	<script type="text/javascript">
	<!--
		function confirm_approve_all(page, id){	
			if ( confirm("Do you want to approve all data?\n( Current Page : " + page + " )") ){
				window.location = "system_approve_seller_approve_all.php?backurl=" + id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_reject_all(page, id){	
			if ( confirm("Do you want to reject all data?\n( Current Page : " + page + " )") ){
				window.location = "system_approve_seller_reject_all.php?backurl=" + id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_approve_selected(page){	
			if ( confirm("Do you want to approve selected data?\n( Current Page : " + page + " )") ){
				document.form.form_action.value = 'approve_selected';
				document.form.submit();
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_reject_selected(page){	
			if ( confirm("Do you want to reject selected data?\n( Current Page : " + page + " )") ){
				document.form.form_action.value = 'reject_selected';	
				document.form.submit();
				return true;
			} 
			else{ return false; }
		}
		
		function preview(id) {
			var leftPos = (screen.availWidth-1000) / 2;
			var topPos 	= (screen.availHeight-600) / 2;
			window.open('preview_seller.php?seller=' + id,'','width=1000,height=600,scrollbars=yes,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	-->
	</script>
</head>
<!-- BEGIN BODY -->
<body class="fixed-top">	
	<!-- BEGIN HEADER -->
	<?php
		$this->load->view("menu");
	?>
    <!-- BEGIN CONTAINER -->   
	<!-- <div class="page-container row-fluid sidebar-closed"> -->
	<div class="page-container row-fluid">		
		<!-- BEGIN SIDEBAR -->
		<!--- lookup database :: sidebar_menu_setup :: done -->
        <!--- lookup database :: sidebar_menu_lookup_general :: done -->
        <!--- lookup database :: sidebar_menu_lookup_directory :: done -->
        <!--- lookup database :: sidebar_menu_lookup_additional :: done -->
        <!--- lookup database :: sidebar_menu_lookup_feature :: done -->
        <!--- seller -->
        <!--- advertiser -->
        <!--- visitor -->
        <!--- listing -->
        <!-- payment -->
        <!-- approval -->
		<?php
			$sidemenu[8] =array("1"=>"active","2"=>array("12"=>"active"));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("sidebar",$data);
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="860">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">Approval</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
		
					</div>
				</div>
				<!-- END PAGE HEADER-->
				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid profile">
					<div class="span12">
						
						
						<!--BEGIN TABS-->
						<div class="row-fluid">
							<div class="span12">
								<!-- BEGIN PORTLET-->
								<div class="portlet">
									<div class="portlet-title">
										<div class="caption"><i class="icon-list"></i> Approve Advertisements</div>
										<div class="actions">
											<div class="btn-group">
												<button class="btn red dropdown-toggle" data-toggle="dropdown">Approve All <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu pull-right">
													<li><a onClick="confirm_approve_all('Approve Advertisements','%2Fdirectory%2Fadmin%2Fapprove_advertisement.php')" style="cursor:pointer"><i class="icon-thumbs-up"></i> Approve All</a></li>
													<li><a onClick="confirm_approve_selected('Approve Advertisements')" style="cursor:pointer"><i class="icon-thumbs-up"></i> Approve Selected</a></li>
													<li><a onClick="confirm_reject_all('Approve Advertisements','%2Fdirectory%2Fadmin%2Fapprove_advertisement.php')" style="cursor:pointer"><i class="icon-thumbs-down"></i> Reject All</a></li>
													<li><a onClick="confirm_reject_selected('Approve Advertisements')" style="cursor:pointer"><i class="icon-thumbs-down"></i> Reject Selected</a></li>
												</ul>
											</div>
									  </div>
									</div>
									<div class="portlet-body">
										
										
																				
										
										<form name="form" method="post" action="system_approve_advertisement_update.php">
										<input name="form_action" type="hidden">
										<input name="backurl" type="hidden" value="%2Fdirectory%2Fadmin%2Fapprove_advertisement.php">
										
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
																						<th class="span9">Details</th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
																														<tr>
											<td colspan="2" style="vertical-align:middle">
												There are no data found ...
											</td>
										</tr>
																				</tbody>
										</table>
										
										</form>
										
										
									</div>
								</div>
								<!-- END PORTLET-->
							</div>
						</div>						
						<!--END TABS-->
						
						
						<!-- navigation here -->
												
						
					</div>
				</div>
				<!-- END PAGE CONTENT-->
				
			</div>
			<!-- END PAGE CONTAINER-->
			
		</div>
		<!-- END PAGE -->	
	</div>
	<!-- END CONTAINER -->   
	<!-- BEGIN FOOTER -->
	<!-- BEGIN FOOTER -->
<div class="footer" style="text-align:center; background-color:#1B2E44;">
	<a href="http://www.affordablebusinessconcepts.com/" style="color:#FC0; background-color:#1b2e44">&copy; Affordable Busindess Concepts LLC</a>
    <div class="span pull-right">
		<span class="go-top" style="background-color: #FFC000;"><i class="icon-angle-up"></i></span>
	</div>
</div>
<!-- END FOOTER -->   <!-- END FOOTER -->
<?php
	$this->load->view("foot");
?>
<script>
	jQuery.fn.ajaxLog = function()
		{
			jQuery.ajax({
				type:'POST',
				url:'<?php echo base_url("login/ajax_log_status"); ?>',
				ContentType : 'application/json',
				success:function(data){
					if(data.log_status>0)
					{
						window.location.assign('<?php echo base_url("login"); ?>');
					}
				}
			});
		}
		setInterval(jQuery.fn.ajaxLog,1000);
		jQuery.fn.ajaxLog();
		jQuery.fn.submit_pagination_form = function(page_event)
		{
			$("input[name=page_click]").val(page_event);
			$("form[name=pagination]").submit();
		}
</script>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
	
	<script>	
		var TableManaged = function () {
			return {		
				//main function to initiate the module
				init: function () {					
					if (!jQuery().dataTable) { return; }
					
					jQuery('#sample_1 .group-checkable').change(function () {
						var set = jQuery(this).attr("data-set");
						var checked = jQuery(this).is(":checked");
						jQuery(set).each(function () {
							if (checked) { $(this).attr("checked", true); } 
							else { $(this).attr("checked", false); }
						});
						jQuery.uniform.update(set);
					});
					
				}
			};
		}();	
	
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
			TableManaged.init();
		});
		
	</script>
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>