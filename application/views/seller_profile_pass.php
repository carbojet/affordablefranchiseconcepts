<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
    
    <script type="text/javascript">
	<!--
		function confirm_cancel(seller_id,payment_id,name){	
			if ( confirm("Do you want to cancel this payment?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url();?>seller/delete_payment_histroy/"+seller_id+"/"+payment_id; 
				return true;
			} 
			else{ return false; }
		}
	-->
	</script>
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
			$sidemenu[5] =array("1"=>"active");
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("seller_sidebar",$data);		
			$seller_detail = $this->session->userdata("slrd");	
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="860">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Password</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid inbox">

					<div class="span12">
						
												<div class="portlet box grey" style="border-color:#493D26;">
							<div class="portlet-title" style="background-color:#493D26;">
								<div class="caption"><i class="icon-key"></i> Change Password</div>
							</div>
							
							
							<div class="portlet-body form">
								
								
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url("seller/seller_profile_pass") ?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
										<div class="alert alert-error hide" style="margin:10px 0 10px 0">
											<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
											<font style="font-weight:bold">
												<h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3> 
												<div style="min-height:31px; vertical-align:middle;">
													Please fill the following form completely. <br>Fields marked  * are required ...
												</div>
											</font>
										</div>																			<div class="alert alert-success hide" style="margin:10px 0 10px 0">
											<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
											<font style="font-weight:bold">
												<h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
												<div style="min-height:31px; vertical-align:middle;">
													Your changes have been successfully saved.
												</div>
											</font>
										</div>									
									
									<div class="space20"></div>
									<div class="space20"></div>
									
									
									<div class="control-group">
										<label class="control-label"></label>
										<div class="controls">
											<div class="span7">Please enter your old password, then enter your new desired password<br>and confirm the new password again in the Confirm Password box ...</div>
										</div>
									</div>
									<div class="space20"></div>
									
																		
									<div class="control-group ">
										<label class="control-label">Username <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_username" value="<?php echo $seller_detail["slrnm"];?>" data-required="1" class="span4 m-wrap" style="" disabled="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Old Password <span class="required">*</span></label>
										<div class="controls">
											<input type="password" name="seller_password_old" value="" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">New Password <span class="required">*</span></label>
										<div class="controls">
											<input type="password" name="seller_password_new" value="" data-required="1" class="span4 m-wrap" style="" id="seller_password_new">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Confirm Password <span class="required">*</span></label>
										<div class="controls">
											<input type="password" name="seller_password_new2" value="" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="space20"></div>
									<div class="form-actions">
										<button type="submit" class="btn black" style="background-color:#493D26;"><i class="icon-ok"></i> Save</button>
									</div>									
									
								</form>
								<!-- END FORM-->
								
								
							</div>
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
<!-- END FOOTER -->   
<!-- END FOOTER -->
<?php
	$this->load->view("foot");
?>
    
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="gui/ltr/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="gui/ltr/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="gui/ltr/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="gui/ltr/scripts/app.js"></script>
	
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

<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>