<?php
	$this->load->view("head");
?>
    <!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/data-tables/DT_bootstrap.css" />
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
		$sidemenu[1] =array("1"=>"active","2"=>array("2"=>"active"));
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
						<h3 class="page-title">Website Setup</h3>
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
										<div class="caption"><i class="icon-cogs"></i>Manage Adminisrator Users</div>
										<div class="actions">                                        	
											<a class="btn small red" href="<?php echo base_url("user/new_user/"); ?>" ><i class="icon-plus"></i> Add User</a>
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
											<th class="span7">Full Name</th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
                                        <?php
											foreach($user_list as $k=>$userObj)
											{
										?>
										<tr>
											<td style="padding-right:20px; vertical-align:middle">
												
												<h5 style="font-weight:700; margin:0">
													<?php echo $userObj->user_firstname." ".$userObj->user_lastname; ?>
                                                </h5>
												
												<strong>Username :</strong> <?php echo $userObj->user_username; ?><br>
												<strong>Password :</strong> <?php echo $userObj->user_password; ?><br>
												 <?php echo $userObj->user_type; ?> Access Administrator 																									
											</td>
											<td style="text-align:right; vertical-align:middle">
												<div class="btn-group" style="text-align:left">
													<a class="btn mini yellow dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
													<ul class="dropdown-menu pull-right">
														<li>                                                        
                                                        <a href="<?php echo base_url("user/user_edit/".$userObj->user_id); ?>"><i class="icon-edit"></i> Edit</a></li>
														<li><a onClick="confirm_delete('<?php echo $userObj->user_id; ?>','<?php echo $userObj->user_username; ?>','user')" style="cursor:pointer"><i class="icon-trash"></i> Delete</a></li>
													</ul>
												</div>
											</td>
										</tr>
                                        <?php 
										}
										?>																														</tbody>
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
<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url(); ?>theme/scripts/app.js"></script>	
    <script type="text/javascript">
	
		function confirm_delete(id, name, page){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url()."user/delete_user/"; ?>"+ id; return true;
			} 
			else{ return false; }
		}
	</script>
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