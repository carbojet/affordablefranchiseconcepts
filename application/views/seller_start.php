<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="gui/ltr/plugins/glyphicons/css/glyphicons.css" rel="stylesheet" />
	<link href="gui/ltr/plugins/glyphicons_halflings/css/halflings.css" rel="stylesheet" />
	<!-- END PAGE LEVEL STYLES -->
</head>
<!-- BEGIN BODY -->
<body class="fixed-top">	
	<!-- BEGIN HEADER -->
	<?php
		$this->load->view("seller_menu");
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
		$sidemenu[1] =array("1"=>"active");
		$data["sidemenu"] =  $sidemenu; 
		$this->load->view("seller_sidebar",$data);
	?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="860">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Subscription</h3>
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
										<div class="caption">
											<i class="icon-money"></i> Thank You for Your Payment
										</div>
									</div>
									<div class="portlet-body">
									
										<p>You have successfully submitted your payment of $ 0.00 for your account.<br>
                                        Your account will now expire on <?php echo date("d M Y",strtotime('+1 month'));?></p>
										
                                        <h4 style="margin-top:30px; font-weight:700">Next Step</h4>
                                        <p>To take full advantage of your account, start managing the <strong><a href="<?php echo base_url("listing/seller_own_listing");?>">ad listings</a></strong> your customers engage with.</p>
										
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
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url(); ?>theme/scripts/app.js"></script>      
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
		});
	</script>
	<script>
		jQuery.fn.ajaxLog = function()
		{
			jQuery.ajax({
				type:'POST',
				url:'<?php echo base_url("seller_login/ajax_log_status"); ?>',
				ContentType : 'application/json',
				success:function(data){
					if(data.log_status>0)
					{
						window.location.assign('<?php echo base_url("seller_login"); ?>');
					}
				}
			});
		}
		setInterval(jQuery.fn.ajaxLog,1000);
		jQuery.fn.ajaxLog();
	</script>	
</body>
<!-- END BODY -->
</html>