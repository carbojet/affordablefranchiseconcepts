<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme'); ?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url('theme'); ?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url('theme'); ?>/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
    <script type="text/javascript">
	<!--		
		//function confirm_delete_all(page){	
//			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){
//				window.location = "system_setup_package_listing_delete_all.php"; 
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function confirm_restore_default(page){	
//			if ( confirm("Do you want to restore default data?\n( Current Page : " + page + " )") ){
//				window.location = "system_setup_package_listing_restore_default.php"; 
//				return true;
//			} 
//			else{ return false; }
//		}		
		function confirm_delete(id, name){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url('seller/subscription_package_delete/') ?>/" + id; 
				return true;
			} 
			else{ return false; }
		}		
		//function confirm_delete_selected(page){	
//			if ( confirm("Do you want to delete selected data?\n( Current Page : " + page + " )") ){
//				document.form.submit();
//				return true;
//			} 
//			else{ return false; }
//		}
//		
//		function confirm_update_order(page){	
//			if ( confirm("Do you want to save the order of data?\n( Current Page : " + page + " )") ){
//				document.form.submit();
//				return true;
//			} 
//			else{ return false; }
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
			$sidemenu[4] =array("1"=>"active","4"=>array("1"=>"active"));
			$sidemenu[4] =array("1"=>"active","4"=>array("1"=>"active","2"=>array("2"=>"active")));
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
						<h3 class="page-title">Packages</h3>
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
										<div class="caption"><i class="icon-cogs"></i> Manage Subscription Packages</div>
										<div class="actions">
											<div class="btn-group">
												<button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu pull-right">
													<li><a href="<?php echo base_url("seller/add_subscription_package"); ?>"><i class="icon-plus"></i> Add New</a></li>
													<!--<li><a onClick="confirm_delete_all('Manage Listing Packages')" style="cursor:pointer"><i class="icon-trash"></i> Delete All</a></li>
													<li><a onClick="confirm_restore_default('Manage Listing Packages')" style="cursor:pointer"><i class="icon-refresh"></i> Restore Default</a></li>-->
												</ul>
											</div>
									  </div>
									</div>
									<div class="portlet-body">
                                    <?php
											if(isset($success_msg))
											{?>
												<div class="alert alert-success " style="margin:10px 0 10px 0">
													<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
													<font style="font-weight:bold">
														<h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
														<div style="min-height:31px; vertical-align:middle;">
															<?php echo $success_msg; ?>
														</div>
													</font>
												</div>
									  <?php } ?>
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span9">Subcscription Details</th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach($subscription_package_result as $k=>$subscriptionObj){?>
											<tr>
											<td style="padding-right:20px; vertical-align:middle">											
												
												<h5 style="font-weight:700; margin:0"><?php echo $subscriptionObj->package_subscription_name_1; ?></h5>
												
												<div class="hidden-480" style="margin-left:70px; margin-top:20px; margin-bottom:20px">
													<div class="span4" style="margin:0">
														
														<div class="td_label"># Listings</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_listings; ?></div>
														<div class="td_clear"></div>

														<div class="td_label"># Categories</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_categories; ?></div>
														<div class="td_clear"></div>

														<div class="td_label"># Pictures</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_pics; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label"># Videos</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_videos; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label"># Documents</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_docs; ?></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="span4" style="margin:0">
														
														<div class="td_label"># Events</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_events; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label"># Coupons</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_coupons; ?></div>
														<div class="td_clear"></div>

														<div class="td_label"># Products</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_products; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label"># News</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_news; ?></div>
														<div class="td_clear"></div>
														
																												
														<div class="td_label">Featured</div>
														<div class="td_value"><?php echo $subscriptionObj->package_subscription_featured; ?></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="span4" style="margin:0">
														
														<div class="td_label">Monthly</div>
														<div class="td_value">$ <?php echo $subscriptionObj->package_subscription_monthly; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">3 Months</div>
														<div class="td_value">$ <?php echo $subscriptionObj->package_subscription_quarterly; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">6 Months</div>
														<div class="td_value">$ <?php echo $subscriptionObj->package_subscription_semi_annually; ?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">12 Months</div>
														<div class="td_value">$ <?php echo $subscriptionObj->package_subscription_annually; ?></div>
														<div class="td_clear"></div>
														
													</div>
												</div>
												
											</td>
											<td style="text-align:right; vertical-align:middle">
												
												<div class="btn-group" style="text-align:left">
													<a class="btn yellow dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
													<ul class="dropdown-menu pull-right">
														<li><a href="<?php echo base_url("seller/subscription_package_edit/".$subscriptionObj->package_subscription_id) ?>"><i class="icon-edit"></i> Edit</a></li>
														<li><a onClick="confirm_delete('<?php echo $subscriptionObj->package_subscription_id; ?>','<?php echo $subscriptionObj->package_subscription_name_1; ?>')" style="cursor:pointer"><i class="icon-trash"></i> Delete</a></li>
													</ul>
												</div>
												
											</td>
										</tr>
                                        <?php }?>
                                        </tbody>
										</table>
									</div>
								</div>
								<!-- END PORTLET-->
							</div>
						</div>						
						<!--END TABS-->
						
						
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
</script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url('theme'); ?>/scripts/app.js"></script>	
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