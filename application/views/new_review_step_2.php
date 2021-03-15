<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
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
			$sidemenu[5] =array("1"=>"active","2"=>array("1"=>"active"));
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
						<h3 class="page-title">Listings</h3>
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
										<div class="caption"><i class="icon-comments"></i> Add Review / Comment - Step 2 of 3</div>
									</div>
									<div class="portlet-body">
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span8">Detailed Info</th>
											<th class="span4" style="text-align:right">Photo</th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach($visitor_list as $k=>$visitorObj){?>
										<tr>
											<td style="padding-right:20px; vertical-align:middle">
												<h5 style="font-weight:700; margin:0;">
												<?php echo $visitorObj->visitor_username;?>
												</h5>
												<div class="hidden-320">
												<?php echo $visitorObj->visitor_address;?><br>
												<?php echo $visitorObj->visitor_province." ".$visitorObj->visitor_zip.",";?> 
												United States
												</div>
												
												<div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
													<div class="span6">
														
														<div class="td_label">ID Number</div>
														<div class="td_value"><?php echo $visitorObj->visitor_id;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Username</div>
														<div class="td_value"><?php echo $visitorObj->visitor_username;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Password</div>
														<div class="td_value"><?php echo $visitorObj->visitor_password;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Reviews</div>
														<div class="td_value"></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="span6">
														
														<div class="td_label">Email</div>
														<div class="td_value"><?php echo $visitorObj->visitor_status_email;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Status</div>
														<div class="td_value">
															 <font color=""><?php echo $visitorObj->visitor_status;?></font>  
															 
															 
														</div>
														<div class="td_clear"></div>
														
														<div class="td_label">Auto Approve</div>
														<div class="td_value"><?php echo $visitorObj->visitor_status_approval;?></div>
														<div class="td_clear"></div>
														
																												
													</div>
													<div class="clearfix"></div>
												</div>
												
												<div style="margin-top:10px">
												<a class="btn mini yellow" href="<?php echo base_url("listing/new_review_final_step/".$comment_linkid."/".$visitorObj->visitor_id); ?>">Create Review</a>
												</div>
												
												
											</td>
											<td style="text-align:right; vertical-align:middle; padding:10px;">
												
																								
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
						
						
						<!-- navigation here -->
																		<!-- navigation here -->
						<div style="padding-bottom:50px">
							<div class="control-group" style="float:left">
								<div class="controls" style="font-weight:bold">
									
									<form action="system_paging_navigation.php" dir="ltr">
									<input type="hidden" name="navigation_url" value="listing_comment_add_step2.php">
									<input type="hidden" name="navigation_pageitem" value="">
									<input type="hidden" name="navigation_total" value="1">
									<input type="hidden" name="navigation_values" value="search_listing=116&amp;search_username=Jerry P">
									
									<span class="help-inline">Page 	&nbsp; </span>
									<input type="text" name="navigation_page" value="1" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
									<span class="help-inline">of 		&nbsp; 1</span>
									</form>
									
								</div>
							</div>
							<div style="float:right">
								<div class="hidden-480" style="float:right">
									<div dir="ltr">
									<a href="system_paging_navigation.php?navigation_page=0&amp;navigation_url=listing_comment_add_step2.php&amp;navigation_total=1&amp;navigation_pageitem=&amp;navigation_values=%26search_listing%3D116%26search_username%3DJerry+P" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a>
									<a href="system_paging_navigation.php?navigation_page=2&amp;navigation_url=listing_comment_add_step2.php&amp;navigation_total=1&amp;navigation_pageitem=&amp;navigation_values=%26search_listing%3D116%26search_username%3DJerry+P" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a>
									</div>
								</div>
							</div>
							<div style="clear:both"></div>
						</div>												
						
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
		jQuery.fn.ajax_location_list = function(id,level)
		{
			jQuery.ajax({
				type:'POST',
				url:'<?php echo base_url("listing/ajax_location_list"); ?>'+'/'+id,
				ContentType : 'application/json',
				success:function(data){
					if(Object.keys(data).length>0)
					{
						
						$("#listing_location_"+level).find("select option").remove();
						for(var key in data){
						$("#listing_location_"+level).find("select").append('<option value="'+key+'">'+data[key]+'</option>')
						}						
					}
				}
			});
		}
</script>
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>