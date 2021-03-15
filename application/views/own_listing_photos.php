<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link href="<?php echo base_url("theme");?>/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.css" rel="stylesheet" type="text/css"/>
	
	<!-- END PAGE LEVEL STYLES -->   

	<script type="text/javascript">
	<!--
		function confirm_delete(id, photo_listing){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + id + " )") ){
			window.location = "<?php echo base_url("listing/delete_own_listing_photo");?>"+"/"+ id+"/"+ photo_listing; 
			return true;
		} 
		else { return false; }
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
			$sidemenu[3] =array("1"=>"active","2"=>array("1"=>"active"));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("seller_sidebar",$data);		
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="1037">
			
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
							if ( confirm("Do you want to delete this data?\n( Current Data : <?php echo $listingObj->listing_id;?> )") ){
								window.location = "<?php echo base_url("listing/delete_listing/".$listingObj->listing_id);?>"; 
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
                        <?php
							if($packageObj===NULL)
							{
								if(count($this->Listingdb->listing_photos(array("photo_listing"=>$listingObj->listing_id)))<1)
								{
									$listing_photo_auth=true;
								}
								else
								{
									$listing_photo_auth=false;
								}
							}
							else
							{
								if(count($this->Listingdb->listing_photos(array("photo_listing"=>$listingObj->listing_id)))<$packageObj->package_listing_pics)
								{
									$listing_photo_auth=true;
								}
								else
								{
									$listing_photo_auth=false;
								}
							}
						?>
						<div class="row-fluid">
							<div class="span12">
								<!-- BEGIN PORTLET-->
								<div class="portlet">
									<div class="portlet-title">
										<div class="caption"><i class="icon-picture"></i> Manage Photos</div>
											<div class="actions">
                                            <?php if($listing_photo_auth){?>
											<a href="<?php echo base_url("listing/add_own_listing_photo/".$listingObj->listing_id);?>" class="btn small red"><i class="icon-plus"></i> Add Photo</a>
                                            <?php }?>
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
										<!-- BEGIN GALLERY MANAGER LISTING-->
										<div class="row-fluid">
                                        <?php if(count($listing_photo)>0){foreach($listing_photo as $k=>$listing_photosObj){?>
											<div class="span3" style="margin:0; padding:10px 0 10px 0px; padding-right:30px">
												<div class="item">
													<div style="font-weight:600; text-align:center; vertical-align:bottom; overflow:hidden"><?php echo $listing_photosObj->photo_caption_1;?></div>
													<a class="fancybox-button" data-rel="fancybox-button" title="Simple Bathroom Design" href="<?php echo base_url();?>photo_big/<?php echo $listing_photosObj->photo_id;?>.jpg">
														<div class="zoom" style="width:auto;height:auto;">
														<img src="<?php echo base_url();?>photo_medium/<?php echo $listing_photosObj->photo_id;?>.jpg" alt="Simple Bathroom Design" title="Simple Bathroom Design">
														<div class="zoom-icon"></div>
														</div>
													</a>
													<div class="details">
																												<a href="<?php echo base_url("listing/set_own_listing_main_photo/".$listing_photosObj->photo_id."/".$listing_photosObj->photo_listing); ?>" class="icon" title="Set As Main"><i class="icon-tag"></i></a>
																												<a href="<?php echo base_url("listing/edit_own_listing_photo/".$listing_photosObj->photo_id."/".$listing_photosObj->photo_listing); ?>" class="icon" title="Edit"><i class="icon-pencil"></i></a>
														<a onClick="confirm_delete('<?php echo $listing_photosObj->photo_id;?>','<?php echo $listing_photosObj->photo_listing;?>')" class="icon" style="cursor:pointer" title="Delete"><i class="icon-remove"></i></a>
													</div>
													
													
																																							<span class="label" style="background-color: #060; color:#fff"><?php echo $listing_photosObj->photo_status;?></span>
																																							
													
												</div>
											</div>
                                        <?php }}?>
										</div>
										<!-- END GALLERY MANAGER PAGINATION-->										
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
	<script src="<?php echo base_url("theme");?>/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>   
	<script src="<?php echo base_url("theme");?>/scripts/gallery.js"></script>  
	<!-- END PAGE LEVEL SCRIPTS -->
	
	<script>
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
			Gallery.init();
		});
	</script>
	
	<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>