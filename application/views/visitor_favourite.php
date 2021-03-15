<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/gui/ltr/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/gui/ltr/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/gui/ltr/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
    <script language="javascript">
	<!--		
		function confirm_delete(id, name, page){	
			if ( confirm("Are you sure want to delete favourite \"" + name + "\" ?") ){
				window.location = "<?php echo base_url('visitor/delete_visitor_favourite');?>"+"/"+id;
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
		$this->load->view("visitor_menu");
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
			$this->load->view("visitor_sidebar",$data);
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="860">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Favourite</h3>
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
										<div class="caption"><i class="icon-thumbs-up"></i> Your Favourite Listings</div>
									</div>
									<div class="portlet-body">
										
										
																				
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span9">Detailed Info</th>
											<th class="span3" style="text-align:right">Thumbnail</th>
										</tr>
										</thead>
										<tbody>
                                        <?php if(count($visitor_favourite)){foreach($visitor_favourite as $obj){?>
																				<tr>
											<td style="padding-right:20px; vertical-align:middle">
												
												
												<div style="padding:5px 0 5px 0">
												<?php $visitor_commentObj  = $this->Visitordb->get_listing_rating(array("listing_id"=>$obj->listing_id)); 
													if(!empty($visitor_commentObj->comment_rating)){?>
                                                    	<img width="84" height="16" src="<?php echo base_url('theme');?>/img/stars/pic_star<?php echo $visitor_commentObj->comment_rating; ?>.png" alt="" style="width:84px; height:16px;">
                                                     <?php }?>
												</div>
																								
												<a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $obj->listing_id;?>-<?php echo $obj->listing_url_1;?>" target="_blank">
												<h5 style="font-weight:700; margin:0;">
													<?php echo $obj->listing_title_1;?> 
												</h5>
												</a>
												
												<div>
													<?php echo $obj->listing_descbrief_1;?> 
												</div>												
												
												<div class="btn-group">
													<a class="btn mini yellow dropdown-toggle" data-toggle="dropdown" href="#">View <i class="icon-angle-down"></i></a>
													<ul class="dropdown-menu">
														<li><a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $obj->listing_id;?>-<?php echo $obj->listing_url_1;?>" target="_blank"><i class="icon-zoom-in"></i> View</a></li>
														<li><a onclick="confirm_delete('<?php echo $obj->favourite_id;?>','#<?php echo $obj->favourite_id;?>','favourite')" style="cursor:pointer"><i class="icon-trash"></i> Delete</a></li>
													</ul>
												</div>
												
												
												
											</td>
											<td style="text-align:right; vertical-align:middle; padding:10px;">
												
																								<a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $obj->listing_id;?>-<?php echo $obj->listing_url_1;?>" target="_blank">
												<?php
													$listing_photoObj = $this->Visitordb->get_listing_main_photo(array("listing_id"=>$obj->listing_id,"photo_status_main"=>"main"));
													if(!empty($listing_photoObj->photo_id)){
												?>    
                                                <img src="<?php echo base_url();?>photo_medium/<?php echo $listing_photoObj->photo_id;?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
                                                <?php }?>
												</a>
																								
											</td>
										</tr>
                                        <?php }}?>
																				
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
	<script type="text/javascript" src="<?php echo base_url("theme");?>gui/ltr/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/gui/ltr/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/gui/ltr/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url("theme");?>/gui/ltr/scripts/app.js"></script>    
	<!-- END PAGE LEVEL STYLES -->    
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
				url:'<?php echo base_url("visitor/ajax_log_status"); ?>',
				ContentType : 'application/json',
				success:function(data){
					if(data.log_status>0)
					{
						window.location.assign('<?php echo base_url("visitor/login/"); ?>');
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