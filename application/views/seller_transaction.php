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
			$sidemenu[4] =array("1"=>"active");
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("seller_sidebar",$data);			
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Transactions</h3>
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
										<div class="caption"><i class="icon-money"></i> Payment History</div>
										
									</div>
									<div class="portlet-body">
										
										
																				
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span9">Details</th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
                                        	<?php foreach($payment_detail as $k=>$paymentObj){?>
                                            <tr>
                                                <td style="vertical-align:middle;">
                                                    <h5 style="font-weight:700; margin:0">
                                                    <?php echo date("d M Y",strtotime($paymentObj->payment_date)); ?>
                                                    </h5>                                                    
                                                    # <?php echo $paymentObj->payment_id;?>
                                                    <?php if($paymentObj->payment_type=="listing") {?>
                                                    <br>Listing # <?php echo $paymentObj->payment_listing; ?> Payment<br>
                                                    <?php }else{?>
                                                    <br>Account # <?php echo $paymentObj->payment_seller; ?> Payment<br>
                                                    <?php }?>
                                                    Package : <?php 
													echo $this->Sellerdb->payment_pack_detail(array("payment_type"=>$paymentObj->payment_type,"payment_pack_id"=>$paymentObj->payment_pack_id));
													?>                                              
                                                </td>
                                                <td style="padding-right:10px; text-align:right; vertical-align:middle">
                                                    <h4 style="font-weight:700; margin:0; color:#990000">$<?php echo $paymentObj->payment_amount; ?></h4>
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
									
									
									<span class="help-inline">Page 	&nbsp; </span>
									<input type="text" name="navigation_page" value="1" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
									<span class="help-inline">of &nbsp; 1</span>
									</form>
									
								</div>
							</div>
							<div style="float:right">
								<div class="hidden-480" style="float:right">
									<div dir="ltr">
									<a href="#" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a>
									<a href="#" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a>
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