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
		function confirm_cancel(id, name){	
			if ( confirm("Do you want to cancel this payment?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url("payment/cancel_payment");?>"+"/"+id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_approve(id, name){	
			if ( confirm("Do you want to approve this payment?\n( Current Data : " + name + ")") ){
				window.location = "<?php echo base_url("payment/approve_payment");?>"+"/"+id; 
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
			$sidemenu[6] =array("1"=>"active","2"=>array("3"=>"active"));
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
						<h3 class="page-title">Payments</h3>
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
										<div class="caption"><i class="icon-money"></i>Approved Payments</div>
										
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
										<form name="form" method="post" action="<?php echo base_url();?>">										
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span9">Details</th>
											<th class="hidden-320"></th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
                                        	<?php
											if(count($payment_list)>0)
											{
											foreach($payment_list as $paymentObj){ ?>
                                            <tr>
											<td style="vertical-align:middle;">
												<h5 style="font-weight:700; margin:0">
												<?php echo date("d M Y",strtotime($paymentObj->payment_date));?>
												</h5>												
												# <?php echo date("d M Y",strtotime($paymentObj->payment_id));?>
												<br>
												
												<?php echo $paymentObj->payment_type;?> # <?php if($paymentObj->payment_listing>0){ echo $paymentObj->payment_listing;}else{echo $paymentObj->payment_seller;}?> Payment																										<br>
                                                <?php
													$packObj = $this->Paymentdb->get_listing_package(array("listing_package"=>$paymentObj->payment_pack_id));
												?>
												Package : <?php echo $package=$packObj->package_listing_name_1;?>
												
												
												
												<div style="margin:5px 0 5px 0">
												
																								<a class="btn mini red" onClick="confirm_cancel(<?php echo $paymentObj->payment_id;?>, <?php echo $paymentObj->payment_id;?>)" style="cursor:pointer"><i class="icon-thumbs-down"></i> Cancel</a>
																								
																								
												</div>
												
											</td>
											<td class="hidden-320" style="vertical-align:middle; text-align:center">
												 <div class="btn mini green"><?php echo $paymentObj->payment_status;?></div> 																																				</td>
											<td style="padding-right:10px; text-align:right; vertical-align:middle">
												<h4 style="font-weight:700; margin:0; color:#990000">$<?php echo $paymentObj->payment_amount;?></h4>
											</td>
										</tr>
                                            <?php }}else{?>
											
											<tr><td colspan="3">There are no data found ...</td></tr>
											
									<?php	}?>
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
																		<!-- navigation here -->
						<div style="padding-bottom:50px">
							<div class="control-group" style="float:left">
								<div class="controls" style="font-weight:bold">
									
									<!--<form action="system_paging_navigation.php" dir="ltr">
									<input type="hidden" name="navigation_url" value="listing.php">
									<input type="hidden" name="navigation_pageitem" value="">
									<input type="hidden" name="navigation_total" value="20">
									<input type="hidden" name="navigation_values" value="">-->
									
									<span class="help-inline">Page 	&nbsp; </span>
									<form name="pagination" action="<?php echo base_url("payment/approved_payments/");?>" method="post">
                                    <input type="hidden" name="page_click">
                                    <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
                                    <span class="help-inline">of  <?php echo $pagination["pages"]; ?></span>
                                    </form>
									
								</div>
							</div>
							<div style="float:right">
								<div class="hidden-480" style="float:right">
									<div dir="ltr">
									<a href="#" onClick="jQuery.fn.submit_pagination_form('prev');" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a>
									<a href="#" onClick="jQuery.fn.submit_pagination_form('next');" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a>
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
						if (checked) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}
						jQuery(set).each(function () {
							if (checked) { $(this).attr("checked", true);$(this).parent().addClass("checked"); } 
							else { $(this).attr("checked", false); $(this).parent().removeClass("checked");}
						});
						jQuery.uniform.update(set);
					});
					jQuery('#sample_1 .checkboxes').change(function(){
						if (jQuery(this).is(":checked")) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}
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