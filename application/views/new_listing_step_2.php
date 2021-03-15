<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/style_table.css" type="text/css"/>
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
		<div class="page-content">			
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
										<div class="caption"><i class="icon-cogs"></i>   Create New Listing - Step 2 of 3 </div>
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
										<form name="form" method="post" action="">										
										<table class="table table-bordered table-advance table-hover" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th class="span9">Detailed Info</th>
                                                    <th class="span3"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php
													foreach($seller_list as $k=>$sellerObj)
													{
												?>
                                                <tr>
                                                    <td class="span8" style="padding-right:20px; vertical-align:middle">
                                                        <h5 style="font-weight:700; margin:0;"><?php echo $sellerObj->seller_company; ?><br></h5>												
                                                        <?php echo $sellerObj->seller_address." ". $sellerObj->seller_address2; ?><br><?php echo $sellerObj->seller_province." ".$sellerObj->seller_zip.", ".$sellerObj->country_name; ?><br>												
                                                        <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                                            <div class="span6">														
                                                                <div class="td_label">ID Number</div>
                                                                <div class="td_value"><?php echo $sellerObj->seller_id; ?></div>
                                                                <div class="td_clear"></div>
                                                                                                                        
                                                                <div class="td_label">Username</div>
                                                                <div class="td_value"><?php echo $sellerObj->seller_username; ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Password</div>
                                                                <div class="td_value"><?php echo $sellerObj->seller_password; ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Package</div>
                                                                <div class="td_value"><?php echo $sellerObj->package_subscription_name_1; ?> - <?php echo $sellerObj->seller_payment_period; ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Exp. Date</div>
                                                                <div class="td_value"><?php echo date("d M Y",strtotime($sellerObj->seller_expire_date)); ?></div>
                                                                <div class="td_clear"></div>
                                                                                                                        
                                                                <div class="td_label">Listings</div>
                                                                <div class="td_value"><?php echo $this->Sellerdb->count_seller_list(array("listing_seller"=>$sellerObj->seller_id)); ?></div>
                                                                <div class="td_clear"></div>
                                                            </div>
                                                            <div class="span6">
                                                                <div class="td_label">Email</div>
                                                                <div class="td_value"><?php if($sellerObj->seller_status_email=="approved"){echo "Confirmed";}else{ echo "Not Confirm";} ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Auto Approve</div>
                                                                <div class="td_value"><?php if(!empty($sellerObj->seller_status_approval)){echo $sellerObj->seller_status_approval;}else{echo "off";} ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Status</div>
                                                                <div class="td_value">
                                                                     <font color="#336600"><?php echo $sellerObj->seller_status; ?></font>
                                                                </div>
                                                                <div class="td_clear"></div>
                                                                
                                                                <div class="td_label">Featured</div>
                                                                <div class="td_value"><?php if($sellerObj->seller_status_feature=="featured"){echo "Yes";}else{echo "No";} ?></div>
                                                                <div class="td_clear"></div>
                                                                
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                                                                        
                                                        <a class="btn mini yellow" href="<?php echo base_url("/listing/new_listing_final_step/".$sellerObj->seller_id);?>">Create Listing for This Seller</a>
                                                    </td>
                                                    <td class="span3" style="text-align:right; vertical-align:middle; padding:10px;">
                                                    	<?php
															$url = base_url()."logo_cache/".$sellerObj->seller_id.".jpg";
															$url = get_headers($url, 1);
															if(!preg_match("/404/",$url[0]))
															{
														?>
                                                        <img src="<?php echo base_url(); ?>logo_cache/<?php echo $sellerObj->seller_id; ?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
                                                        <?php
															}
														?>
                                                    </td>
                                                </tr>
                                                <?php
													}
												?>
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
                        <div style="padding-bottom:50px">
                            <div class="control-group" style="float:left">
                                <div class="controls" style="font-weight:bold">
                                    
                                    <!--<form action="system_paging_navigation.php" dir="ltr">
                                    <input type="hidden" name="navigation_url" value="seller.php">
                                    <input type="hidden" name="navigation_pageitem" value="">
                                    <input type="hidden" name="navigation_total" value="21">
                                    <input type="hidden" name="navigation_values" value="">-->
                                    
                                    <span class="help-inline">Page 	&nbsp; </span>
                                    <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
                                    <span class="help-inline">of  <?php echo $pagination["pages"]; ?></span>
                                    </form>
                                    
                                </div>
                            </div>
                            <div style="float:right">
                                <div class="hidden-480" style="float:right">
                                    <div dir="ltr">
                                    <a href="<?php echo base_url("seller/seller_pre_page/".($pagination["startpage"])); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a>
                                    <a href="<?php echo base_url("seller/seller_nxt_page/".($pagination["startpage"])); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a>
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
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>theme/scripts/app.js"></script>	
<script type="text/javascript">

    function confirm_delete(id, name, page){	
        if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
            window.location = "<?php echo base_url()."seller/delete_seller/"; ?>"+ id; return true;
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