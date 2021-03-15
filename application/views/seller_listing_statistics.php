<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link href="<?php echo base_url("theme");?>/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
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
			$sidemenu[3] =array("1"=>"active");
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
						<h3 class="page-title">Listings</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid profile">
					<div class="span12">
						
						
						<!-- load listing information section -->
						<script type="text/javascript">
						<!--
						function confirm_delete_listing_final() {
							if ( confirm("Do you want to delete this data?\n( Current Data : <?php echo $listingObj->listing_id; ?>)") ){
								window.location = "<?php echo base_url("/listing/delete_seller_listing/");?>"+"/"+<?php echo $listingObj->listing_id; ?>; 
								return true;
							} 
							else { return false; }
						}
						
						-->
						</script>
						
						<div class="portlet box blue" style="margin-bottom:40px">
							<div class="portlet-title">
								<div class="caption"><i class="icon-info-sign"></i>Listing Information</div>
							</div>
							
							<div class="row-fluid" style="background-color:#FFFFFF">
								<div class="span9 portfolio-text">
									<div class="portfolio-text-info" style="padding:10px 10px 10px 25px">
										
										<h4 style="font-weight:900; padding-bottom:0; margin-bottom:10px;"><?php echo $listingObj->listing_title_1;?></h4>
										
										<div style="padding:0px 0 10px 0; margin-top:0">
                                        <?php $visitor_commentObj  = $this->Listingdb->get_listing_rating(array("listing_id"=>$listingObj->listing_id)); 
										if(!empty($visitor_commentObj->comment_rating)){?>
										<img width="84" height="16" src="<?php echo base_url("theme");?>/img/stars/pic_star<?php echo $visitor_commentObj->comment_rating; ?>.png" alt="" style="width:84px; height:16px;">
                                        <?php }?>
										</div>
																				
										<div style="clear:both"></div>
                                        <?php $packageObj = $this->Listingdb->get_listing_package(array("listing_package"=>$listingObj->listing_package)); ?>
										<div class="hidden-480">
										<p>
											<strong>Package</strong> <?php if(!empty($packageObj->package_listing_name_1)){echo $packageObj->package_listing_name_1;} ?><br>
											<strong>Status</strong> <?php echo $listingObj->listing_status; ?>  / <?php echo $listingObj->listing_status_feature; ?><br>
										</p>
										</div>

								
										<div style="padding:0 0 10px 0;">
											
											
											<div class="btn-group">
												<a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
												<ul class="dropdown-menu">
                                                            
                                                            <li><a href="<?php echo base_url("listing/seller_listing_edit/".$listingObj->listing_id);?>"><i class="icon-edit"></i> Edit </a></li>
                                                            <li><a onClick="confirm_delete('<?php echo $listingObj->listing_id;?>','# <?php echo $listingObj->listing_id;?>','listing')" style="cursor:pointer"><i class="icon-trash"></i> Delete </a></li>
                                                                                                                    
                                                            <li><a href="<?php echo base_url("listing/seller_listing_statistics/".$listingObj->listing_id); ?>"><i class="icon-bar-chart"></i> Statistics </a></li>                    
                                                            <li><a href="<?php echo base_url("listing/seller_listing_reviews/".$listingObj->listing_id); ?>"><i class="icon-comments"></i> Reviews  <font dir="ltr">(<?php echo $this->Listingdb->get_review_list(true,$listingObj->listing_id) ; ?>)</font></a></li>
                                                            <li><a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $listingObj->listing_id."-".$listingObj->listing_url_1;?>" target="_blank"><i class="icon-zoom-in"></i> Preview </a></li>                                                            
                                                            
                                                            
                                                        </ul>
											</div>
											
											<div class="btn-group">
												<button class="btn mini yellow dropdown-toggle" data-toggle="dropdown">Photos <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu">
                                                            
                                                            <li><a href="<?php echo base_url("listing/seller_listing_category/".$listingObj->listing_id);?>"><i class="icon-sitemap"></i> Categories  <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_category(array("category_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                            
                                                            <li><a href="<?php echo base_url("listing/own_listing_photos/".$listingObj->listing_id);?>"><i class="icon-picture"></i> Photos  <font dir="ltr">(<?php echo count($this->Listingdb->listing_photos(array("photo_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                                                                                    
                                                            <li><a href="<?php echo base_url("listing/own_listing_videos/".$listingObj->listing_id);?>/"><i class="icon-facetime-video"></i> Videos  <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_video(array("video_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                                                                                    
                                                            <!--<li><a href="#"><i class="icon-briefcase"></i> Documents  <font dir="ltr">(0)</font></a></li>
                                                            
                                                            <li><a href="#"><i class="icon-calendar"></i> Events  <font dir="ltr">(0)</font></a></li>
                                                            
                                                            <li><a href="#"><i class="icon-barcode"></i> Coupons  <font dir="ltr">(0)</font></a></li>
                                                            
                                                            <li><a href="#"><i class="icon-gift"></i> Products  <font dir="ltr">(0)</font></a></li>
                                                            
                                                            <li><a href="#"><i class="icon-book"></i> News  <font dir="ltr">(0)</font></a></li>-->
                                                                                                                    
                                                        </ul>
											</div>
		
										</div>
																		
									</div>
								</div>

								<div class="hidden-768">									
									<div class="span3" style="text-align:right; float:right; vertical-align:middle; padding:30px 10px 10px 25px ">
                                    <?php
									$listing_photoObj = $this->Listingdb->get_listing_main_photo(array("listing_id"=>$listingObj->listing_id,"photo_status_main"=>"main"));
									if(!empty($listing_photoObj->photo_id)){
								?>    
									<img src="<?php echo base_url();?>photo_small/<?php echo $listing_photoObj->photo_id;?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
								<?php }?> 
									
									</div>																		
								</div>								
							</div>							
						</div>
						<!--BEGIN TABS-->
						<div class="space20"></div>
						<div class="row-fluid">
							<div class="span12" data-tablet="span6" data-desktop="span6">								
								<!-- BEGIN PORTLET-->
								<div class="dashboard-stat purple">
									<div class="visual">
										<i class="icon-bar-chart"></i>
									</div>
									<div class="details">
                                     <?php
								   $viewed = $this->Listingdb->get_listing_visited(array("stat_listing"=>$listingObj->listing_id));
									?>
										<div class="number"> <?php echo $viewed; ?></div>
										<div class="desc">All Views</div>
									</div>
									<a class="more">
									Total Statistics <i class="m-icon-swapright m-icon-white"></i>
									</a>                 
								</div>
								<!-- END PORTLET-->
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<!-- BEGIN PORTLET-->
								<a name="monthly"></a>
								<div class="portlet box grey" style="border-color:#493D26;">
									<div class="portlet-title" style="background-color:#493D26;">
										<div class="caption"><i class="icon-bar-chart"></i> Monthly Statistics</div>
									</div>
									<div class="portlet-body">
				                        <div id="chart_monthly" class="chart" style="padding: 0px; position: relative;"></div>
									</div>
								</div>
								<!-- END PORTLET-->
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<!-- BEGIN PORTLET-->
								<a name="daily"></a>
								<div class="portlet box grey" style="border-color:#493D26;">
									<div class="portlet-title" style="background-color:#493D26;">
										<div class="caption"><i class="icon-bar-chart"></i> Daily Statistics</div>
									</div>
									<div class="portlet-body">
				                        <div id="chart_daily" class="chart" style="padding: 0px; position: relative;">
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
<!-- END FOOTER -->   <!-- END FOOTER -->
<?php
	$this->load->view("foot");
?>
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
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo base_url("theme");?>/plugins/flot/jquery.flot.js"></script>
	<script src="<?php echo base_url("theme");?>/plugins/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo base_url("theme");?>/plugins/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url("theme");?>/plugins/flot/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url("theme");?>/plugins/flot/jquery.flot.crosshair.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
	
	<script>
	   
		var xdates = new Array();
		<?php
				$temp_array = $daily;$i=1;
				foreach($temp_array as $k=>$v){?>
					xdates[<?php echo $i;?>] ="<?php echo date("d-M-Y",strtotime($k));?>";
		<?php $i++;}?>
				/*xdates[1] = "26 Jul 2015";
				xdates[2] = "27 Jul 2015";
				xdates[3] = "28 Jul 2015";
				xdates[4] = "29 Jul 2015";
				xdates[5] = "30 Jul 2015";
				xdates[6] = "31 Jul 2015";
				xdates[7] = "01 Aug 2015";
				xdates[8] = "02 Aug 2015";
				xdates[9] = "03 Aug 2015";
				xdates[10] = "04 Aug 2015";
				xdates[11] = "05 Aug 2015";
				xdates[12] = "06 Aug 2015";
				xdates[13] = "07 Aug 2015";
				xdates[14] = "08 Aug 2015";
				xdates[15] = "09 Aug 2015";
				xdates[16] = "10 Aug 2015";
				xdates[17] = "11 Aug 2015";
				xdates[18] = "12 Aug 2015";
				xdates[19] = "13 Aug 2015";
				xdates[20] = "14 Aug 2015";
				xdates[21] = "15 Aug 2015";
				xdates[22] = "16 Aug 2015";
				xdates[23] = "17 Aug 2015";
				xdates[24] = "18 Aug 2015";
				xdates[25] = "19 Aug 2015";
				xdates[26] = "20 Aug 2015";
				xdates[27] = "21 Aug 2015";
				xdates[28] = "22 Aug 2015";
				xdates[29] = "23 Aug 2015";
				xdates[30] = "24 Aug 2015";*/
				
		var xmonths = new Array();
		<?php
				$temp_array = $monthly;$i=1;
				foreach($temp_array as $k=>$v){?>
					xmonths[<?php echo $i;?>] ="<?php echo date("d-M-Y",strtotime($k));?>";
		<?php $i++;}?>		
				/*xmonths[1] = "September 2014";
				xmonths[2] = "October 2014";
				xmonths[3] = "November 2014";
				xmonths[4] = "December 2014";
				xmonths[5] = "January 2015";
				xmonths[6] = "February 2015";
				xmonths[7] = "March 2015";
				xmonths[8] = "April 2015";
				xmonths[9] = "May 2015";
				xmonths[10] = "June 2015";
				xmonths[11] = "July 2015";
				xmonths[12] = "August 2015";*/			
		
		var Charts = function () {
		
			return {
			
				//main function to initiate the module
				init: function () {
					App.addResponsiveHandler(function () {
						Charts.initPieCharts(); // need to subscribe to reponsive handler in order to fix the pie charts while window resized.
					});
		
					$('.page-sidebar .sidebar-toggler').click(function () {
						setTimeout(function () {
							Charts.initPieCharts(); // need to reinitialize pie charts when page layout changed(on sidebar close/hide).
						}, 100);
					});
				},
		
				initCharts: function () {
		
					if (!jQuery.plot) { return; }
					
					
					// Interactive Chart
					function chart_monthly() {
						var visitors = [
						<?php
							$temp_array = $monthly;$i=1;
							foreach($temp_array as $k=>$v){?>
								[<?php echo $i; ?>,<?php if(empty($v)){echo 0;}else{echo $v;} ?>],
					<?php $i++;}?>
														/*[1, 0],
														[2, 0],
														[3, 0],
														[4, 0],
														[5, 0],
														[6, 0],
														[7, 0],
														[8, 0],
														[9, 0],
														[10, 0],
														[11, 0],
														[12, 3],*/
													];
		
						var plot = $.plot($("#chart_monthly"), [
							{
								data: visitors,
								label: "Page Views"
							}
						], 
						{
							series: {
								lines: {
									show: true,
									lineWidth: 2,
									fill: true,
									fillColor: {colors: [{ opacity: 0.05 }, { opacity: 0.01 }]}
								},
								points: { show: true },
								shadowSize: 2
							},
							grid: {
								hoverable: true,
								clickable: true,
								tickColor: "#eee",
								borderWidth: 0
							},
							colors: ["#37b7f3", "#d12610", "#37b7f3", "#52e136"],
							xaxis: { 
								/*
								ticks: [
																		[1, 'September 2014'],
																		[2, 'October 2014'],
																		[3, 'November 2014'],
																		[4, 'December 2014'],
																		[5, 'January 2015'],
																		[6, 'February 2015'],
																		[7, 'March 2015'],
																		[8, 'April 2015'],
																		[9, 'May 2015'],
																		[10, 'June 2015'],
																		[11, 'July 2015'],
																		[12, 'August 2015'],
																	],
								*/
							},
							yaxis: { ticks: 5, tickDecimals: 0 }
						});
		
		
						function showTooltip(x, y, contents) {
							$('<div id="tooltip">' + contents + '</div>').css({
								position: 'absolute',
								display: 'none',
								top: y - 43,
								left: x - 100,
								border: '1px solid #333',
								padding: '4px',
								color: '#fff',
								'border-radius': '3px',
								'background-color': '#333',
								opacity: 0.80
							}).appendTo("body").fadeIn(200);
						}
		
						var previousPoint = null;
						$("#chart_monthly").bind("plothover", function (event, pos, item) {
							$("#x").text(pos.x.toFixed(2));
							$("#y").text(pos.y.toFixed(2));
							if (item) {
								if (previousPoint != item.dataIndex) {
									previousPoint = item.dataIndex;
									$("#tooltip").remove();
									var x = item.datapoint[0].toFixed(2),
										y = item.datapoint[1].toFixed(2),
										x2 = Math.round( x ),
										y2 = Math.round( y ),
										xlabel = xmonths[x2];
									showTooltip(item.pageX, item.pageY, xlabel + "<br>( " + y2 + " Views )");
								}
							} else {
								$("#tooltip").remove();
								previousPoint = null;
							}
						});
					}
						
					// Interactive Chart
					function chart_daily() {
						var visitors = [
						<?php
							$temp_array = $daily;$i=1;
							foreach($temp_array as $k=>$v){?>
								[<?php echo $i; ?>,<?php if(empty($v)){echo 0;}else{echo $v;} ?>],
					<?php $i++;}?>
														/*[1, 0],
														[2, 0],
														[3, 0],
														[4, 0],
														[5, 0],
														[6, 0],
														[7, 2],
														[8, 1],
														[9, 0],
														[10, 0],
														[11, 0],
														[12, 0],
														[13, 0],
														[14, 0],
														[15, 0],
														[16, 0],
														[17, 0],
														[18, 0],
														[19, 0],
														[20, 0],
														[21, 0],
														[22, 0],
														[23, 0],
														[24, 0],
														[25, 0],
														[26, 0],
														[27, 0],
														[28, 0],
														[29, 0],
														[30, 0],*/
													];
		
						var plot = $.plot($("#chart_daily"), [
							{
								data: visitors,
								label: "Page Views"
							}
						], 
						{
							series: {
								lines: {
									show: true,
									lineWidth: 2,
									fill: true,
									fillColor: {colors: [{ opacity: 0.05 }, { opacity: 0.01 }]}
								},
								points: { show: true },
								shadowSize: 2
							},
							grid: {
								hoverable: true,
								clickable: true,
								tickColor: "#eee",
								borderWidth: 0
							},
							colors: ["#37b7f3", "#d12610", "#37b7f3", "#52e136"],
							xaxis: { 
								ticks: [
								<?php
										$temp_array = $daily;$i=1;
										foreach($temp_array as $k=>$v){?>
											[<?php echo $i;?>, '<?php echo date("d",strtotime($k));?>'],
								<?php $i++;}?>
																		/*[1, '26'],
																		[2, '27'],
																		[3, '28'],
																		[4, '29'],
																		[5, '30'],
																		[6, '31'],
																		[7, '1'],
																		[8, '2'],
																		[9, '3'],
																		[10, '4'],
																		[11, '5'],
																		[12, '6'],
																		[13, '7'],
																		[14, '8'],
																		[15, '9'],
																		[16, '10'],
																		[17, '11'],
																		[18, '12'],
																		[19, '13'],
																		[20, '14'],
																		[21, '15'],
																		[22, '16'],
																		[23, '17'],
																		[24, '18'],
																		[25, '19'],
																		[26, '20'],
																		[27, '21'],
																		[28, '22'],
																		[29, '23'],
																		[30, '24'],*/
																	],
							},
							yaxis: { ticks: 5, tickDecimals: 0 }
						});
		
		
						function showTooltip(x, y, contents) {
							$('<div id="tooltip">' + contents + '</div>').css({
								position: 'absolute',
								display: 'none',
								top: y - 43,
								left: x - 100,
								border: '1px solid #333',
								padding: '4px',
								color: '#fff',
								'border-radius': '3px',
								'background-color': '#333',
								opacity: 0.80
							}).appendTo("body").fadeIn(200);
						}
		
						var previousPoint = null;
						$("#chart_daily").bind("plothover", function (event, pos, item) {
							$("#x").text(pos.x.toFixed(2));
							$("#y").text(pos.y.toFixed(2));
							if (item) {
								if (previousPoint != item.dataIndex) {
									previousPoint = item.dataIndex;
									$("#tooltip").remove();
									var x = item.datapoint[0].toFixed(2),
										y = item.datapoint[1].toFixed(2),
										x2 = Math.round( x ),
										y2 = Math.round( y ),
										xlabel = xdates[x2];
									showTooltip(item.pageX, item.pageY, xlabel + "<br>( " + y2 + " Views )");
								}
							} else {
								$("#tooltip").remove();
								previousPoint = null;
							}
						});
					}
					
					// draw graph
					chart_daily();
					chart_monthly();
				}
			};
		}();
	
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
			Charts.init();
			Charts.initCharts();
		});
	</script>
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>