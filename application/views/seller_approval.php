<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	
	<script type="text/javascript">
	function confirm_approve(id,page){	
			if ( confirm("Do you want to approve ?\n( Current Page : " + page + " )") ){
				window.location = "<?php echo base_url("approval/approve_seller");?>"+"/"+id+"/approved"; 
				return true;
			} 
			else{ return false; }
		}
	function confirm_cancel(id,page){	
			if ( confirm("Do you want to approve ?\n( Current Page : " + page + " )") ){
				window.location = "<?php echo base_url("approval/approve_seller");?>"+"/"+id+"/canceled"; 
				return true;
			} 
			else{ return false; }
		}
	<!--
		//function confirm_approve_all(page, id){	
//			if ( confirm("Do you want to approve all data?\n( Current Page : " + page + " )") ){
//				window.location = "system_approve_seller_approve_all.php?backurl=" + id; 
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function confirm_reject_all(page, id){	
//			if ( confirm("Do you want to reject all data?\n( Current Page : " + page + " )") ){
//				window.location = "system_approve_seller_reject_all.php?backurl=" + id; 
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function confirm_approve_selected(page){	
//			if ( confirm("Do you want to approve selected data?\n( Current Page : " + page + " )") ){
//				document.form.form_action.value = 'approve_selected';
//				document.form.submit();
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function confirm_reject_selected(page){	
//			if ( confirm("Do you want to reject selected data?\n( Current Page : " + page + " )") ){
//				document.form.form_action.value = 'reject_selected';	
//				document.form.submit();
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function preview(id) {
//			var leftPos = (screen.availWidth-1000) / 2;
//			var topPos 	= (screen.availHeight-600) / 2;
//			window.open('preview_seller.php?seller=' + id,'','width=1000,height=600,scrollbars=yes,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
//		}
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
			$sidemenu[8] =array("1"=>"active","2"=>array("1"=>"active"));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("sidebar",$data);
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content">
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
										<div class="caption"><i class="icon-list"></i> Approve Sellers</div>
										<div class="actions">
											<div class="btn-group">
												<button class="btn red dropdown-toggle" data-toggle="dropdown">Approve All <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu pull-right">
													<li><a onClick="confirm_approve_all('Approve Sellers','%2Fdirectory%2Fadmin%2Fapprove_seller.php')" style="cursor:pointer"><i class="icon-thumbs-up"></i> Approve All</a></li>
													<li><a onClick="confirm_approve_selected('Approve Sellers')" style="cursor:pointer"><i class="icon-thumbs-up"></i> Approve Selected</a></li>
													<li><a onClick="confirm_reject_all('Approve Sellers','%2Fdirectory%2Fadmin%2Fapprove_seller.php')" style="cursor:pointer"><i class="icon-thumbs-down"></i> Reject All</a></li>
													<li><a onClick="confirm_reject_selected('Approve Sellers')" style="cursor:pointer"><i class="icon-thumbs-down"></i> Reject Selected</a></li>
												</ul>
											</div>
									  </div>
									</div>
									<div class="portlet-body">
										<form name="form" method="post" action="<?php echo base_url();?>">
										
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span9">Detailed Info</th>
											<th class="span3"></th>
                                            <th class="span3"></th>
										</tr>
										</thead>
										<tbody>
											<?php
												if(count($seller_approval_list)>0)
												{
													foreach($seller_approval_list as $sellerObj)
													{?>
														<tr>
											<td style="vertical-align:middle;">
												<h5 style="font-weight:700; margin:0">
												<?php echo $sellerObj->seller_firstname." ".$sellerObj->seller_lastname;?>
												</h5>												
												# <?php echo $sellerObj->seller_id;?>
												<br>
												<div style="margin:5px 0 5px 0">
												<?php if($sellerObj->seller_status=="approved"){?>
												<a class="btn mini red" onClick="confirm_cancel('<?php echo $sellerObj->seller_id;?>', '<?php echo $sellerObj->seller_firstname;?>')" style="cursor:pointer"><i class="icon-thumbs-down"></i> Cancel</a>
                                                <?php }else{?>
												<a class="btn mini green" onClick="confirm_approve('<?php echo $sellerObj->seller_id;?>', '<?php echo $sellerObj->seller_firstname;?>')" style="cursor:pointer"><i class="icon-thumbs-up"></i> Approve</a>
                                                <?php }?>												
																								
												</div>
												
											</td>
											<td class="hidden-320" style="vertical-align:middle; text-align:center">
                                            <?php if($sellerObj->seller_status=="approved"){?>
												 <div class="btn mini green"><?php echo $sellerObj->seller_status;?></div>
                                            <?php }else{?>
                                            <div class="btn mini red"><?php echo $sellerObj->seller_status;?></div>
                                            <?php }?>      																																				</td>
											<td style="padding-right:10px; text-align:right; vertical-align:middle">
												<h4 style="font-weight:700; margin:0; color:#990000">$<?php echo $sellerObj->package_subscription_monthly;?></h4>
											</td>
										</tr>
											<?php	}
																								
												}
												else{
											?>																			<tr>
											<td colspan="2" style="vertical-align:middle">
												There are no data found ...
											</td>
                                            <?php }?>
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