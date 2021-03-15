<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link href="<?php echo base_url(); ?>theme/css/pages/pricing-tables.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES --> 
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
			$sidemenu[4] =array("1"=>"active","2"=>array("1"=>"active"));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("sidebar",$data);
			foreach($seller_detail as $k=>$obj){$sellerObj = $obj;}
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">Sellers / Members</h3>
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
								
								
								<!-- load information section -->
														<div class="portlet box blue" style="margin-bottom:40px">
							<div class="portlet-title">
								<div class="caption"><i class="icon-info-sign"></i>Information</div>
							</div>
							
							<div class="row-fluid" style="background-color:#FFFFFF">
								<div class="span12 portfolio-text">
									<div class="portfolio-text-info" style="padding:10px 10px 10px 25px">
										
										<h4 style="font-weight:900; padding-bottom:0; margin-bottom:10px;">
										<?php echo $sellerObj->seller_company; ?>
                                        </h4>
										
										<div class="hidden-480">
											<div class="span6">
												<strong>Full Name</strong> <?php echo $sellerObj->seller_firstname." ".$sellerObj->seller_lastname; ?><br>
												<strong>Email</strong> <?php echo $sellerObj->seller_email; ?><br>
												<strong># Listings</strong> <?php echo $this->Sellerdb->count_seller_list(array("listing_seller"=>$sellerObj->seller_id)); ?><br>
											</div>
											<div class="span6">
												<strong>ID Number</strong> <?php echo $sellerObj->seller_id; ?><br>
												<strong>Package</strong> <?php echo $sellerObj->package_subscription_name_1; ?> / <?php echo $sellerObj->seller_payment_period; ?><br>
												 
												<strong>Expired</strong> <?php echo date("d M Y",strtotime($sellerObj->seller_expire_date)); ?><br>
																							</div>
											<div class="clearfix"></div>
										</div>
										
										<div class="btn-group">
											<a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
											<ul class="dropdown-menu">
												<li><a href="<?php echo base_url("seller/seller_edit/".$sellerObj->seller_id); ?>"><i class="icon-edit"></i> Edit</a></li>
												<li><a href="#"><i class="icon-list"></i> Listings</a></li>
											</ul>
										</div>
										
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							
						</div>								
								
								<!-- BEGIN PORTLET-->
								<div class="portlet">
									<div class="portlet-title">
										<div class="caption" style="padding-top:18px"><i class="icon-money"></i> Record New Pay-Per-Month (Subscription) Payment</div>
										<div class="actions">
											<form action="#" method="post">
												<div class="input-append span12">
												<input name="payment_coupon" type="text" value="" class="m-wrap" placeholder="Enter coupon here">
												<button class="btn red" type="button" onClick="this.form.submit()">Use Promo Code</button>
												</div>
											</form>
										</div>
									</div>
									<div class="portlet-body">
										<div class="row-fluid" style="padding-bottom:120px">																																
											<div class="span12">
                                            <?php
												$data = $this->Sellerdb->get_package_detail($sellerObj->seller_package);
												$package_detailObj = $data["package_detail"];
											
											?>
												<div class="pricing-table selected">
													<h3><?php echo $package_detailObj->package_subscription_name_1; ?></h3>
													<div class="desc"></div>
													<ul style="min-height:300px">
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_listings; ?> Listings</li>
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_pics; ?> Pictures</li>
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_videos; ?> Videos</li>
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_docs; ?> Documents</li>
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_events; ?> Events</li>
														<li><i class="icon-angle-right"></i> <?php echo $package_detailObj->package_subscription_coupons; ?> Coupons</li>	
														<li><i class="icon-angle-right"></i> $<?php echo $package_detailObj->package_subscription_monthly; ?>  &nbsp; Monthly</li>
														<li><i class="icon-angle-right"></i> $<?php echo $package_detailObj->package_subscription_quarterly; ?>  &nbsp; 3 Months</li>
														<li><i class="icon-angle-right"></i> $<?php echo $package_detailObj->package_subscription_semi_annually; ?>  &nbsp; 6 Months</li>
														<li><i class="icon-angle-right"></i> $<?php echo $package_detailObj->package_subscription_annually; ?>  &nbsp; 12 Months</li>
														
														
													</ul>
													<div class="rate" style="min-height:100px">				
														<div class="btn-group" style="text-align:left">
															<a class="btn yellow dropdown-toggle" data-toggle="dropdown" href="#">Proceed <i class="icon-angle-down"></i></a>
															<ul class="dropdown-menu">
																<li>
																	<a href="<?php echo base_url('/seller/seller_package_upgrade/'.$sellerObj->seller_id.'/'.$package_detailObj->package_subscription_id.'/1m');?>">
																	Monthly
																	( $<?php echo $package_detailObj->package_subscription_monthly; ?> )
																	</a>
																</li>
																<li>
																	<a href="<?php echo base_url('/seller/seller_package_upgrade/'.$sellerObj->seller_id.'/'.$package_detailObj->package_subscription_id.'/3m');?>">
																	3 Months
																	( $<?php echo $package_detailObj->package_subscription_quarterly; ?> )
																	</a>
																</li>
																<li>
																	<a href="<?php echo base_url('/seller/seller_package_upgrade/'.$sellerObj->seller_id.'/'.$package_detailObj->package_subscription_id.'/6m');?>">
																	6 Months
																	( $<?php echo $package_detailObj->package_subscription_semi_annually; ?> )
																	</a>
																</li>
																<li>
																	<a href="<?php echo base_url('/seller/seller_package_upgrade/'.$sellerObj->seller_id.'/'.$package_detailObj->package_subscription_id.'/12m');?>">
																	12 Months
																	( $<?php echo $package_detailObj->package_subscription_annually; ?> )
																	</a>
																</li>
															</ul>
														</div>
														
																												
														
													</div>
												</div>
											</div>
											<div class="spance10 visible-phone"></div>
																						
											
										</div>
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
<!-- END FOOTER -->   
<!-- END FOOTER -->
<?php
	$this->load->view("foot");
?>    
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="gui/ltr/scripts/app.js"></script>	
	<script>
		jQuery(document).ready(function() {
			// initiate layout and plugins
			App.init();
			TableManaged.init();
		});
	</script>
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
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>