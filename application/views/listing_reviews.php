<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('theme'); ?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url('theme'); ?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url('theme'); ?>/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
    <script type="text/javascript">
	<!--
		
		function confirm_delete_all(page, id){	
			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){
				window.location = "system_listing_comment_delete_all.php?listing=" + id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete(id, linkid, name){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url("listing/delete_review");?>"+"/"+id+"/"+linkid; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete_selected(page){	
			if ( confirm("Do you want to delete selected data?\n( Current Page : " + page + " )") ){
				document.form.submit();
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
			$sidemenu[5] =array("1"=>"active","2"=>array("1"=>"active"));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("sidebar",$data);		
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
													
													<li><a href="<?php echo base_url("listing/edit/".$listingObj->listing_id);?>"><i class="icon-edit"></i> Edit </a></li>
													<li><a onClick="confirm_delete_listing_final()" style="cursor:pointer"><i class="icon-trash"></i> Delete </a></li>
													
																										
													<li><a href="<?php echo base_url("listing/listing_statistics/".$listingObj->listing_id);?>"><i class="icon-bar-chart"></i> Statistics </a></li>
													
													<li><a href="<?php echo base_url("listing/listing_reviews/".$listingObj->listing_id);?>"><i class="icon-comments"></i> Reviews <font dir="ltr">(<?php echo $this->Listingdb->get_review_list(true,$listingObj->listing_id) ; ?>)</font></a></li>
													
																										
													<li><a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $listingObj->listing_id."-".$listingObj->listing_url_1;?>" target="_blank"><i class="icon-zoom-in"></i> Preview </a></li>
													
													<li>
                                                    <?php if($listingObj->listing_status_feature=="featured"){ ?>
                                                    <a href="<?php echo base_url("listing/feature/off/".$listingObj->listing_id); ?>"><i class="icon-star-empty"></i> Un-Feature </a>
                                                    <?php }else{ ?>
                                                    <a href="<?php echo base_url("listing/feature/on/".$listingObj->listing_id); ?>"><i class="icon-star"></i> Feature </a>
                                                    <?php } ?>
                                                    </li>
												</ul>
											</div>
											
											<div class="btn-group">
												<button class="btn mini yellow dropdown-toggle" data-toggle="dropdown">Photos <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu">
                                                            
                                                            <li><a href="<?php echo base_url("listing/listing_category/".$listingObj->listing_id);?>"><i class="icon-sitemap"></i> Categories  <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_category(array("category_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                            
                                                            <li><a href="<?php echo base_url("listing/listing_photos/".$listingObj->listing_id);?>"><i class="icon-picture"></i> Photos  <font dir="ltr">(<?php echo count($this->Listingdb->listing_photos(array("photo_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                                                                                    
                                                            <li><a href="<?php echo base_url("listing/listing_videos/".$listingObj->listing_id);?>/"><i class="icon-facetime-video"></i> Videos  <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_video(array("video_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                                                                                    
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
						<div class="row-fluid">
							<div class="span12">
								<!-- BEGIN PORTLET-->
								<div class="portlet">
									<div class="portlet-title">
										<div class="caption"><i class="icon-comments"></i> Manage Reviews / Comments</div>
										<div class="actions">
											<div class="btn-group">
												<button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
												<ul class="dropdown-menu pull-right">
													<li><a href="<?php echo base_url("listing/new_review_step_1/".$listingObj->listing_id);?>"><i class="icon-plus"></i> Add New</a></li>
																										<li><a onClick="confirm_delete_all('Manage Reviews / Comments','116')" style="cursor:pointer"><i class="icon-trash"></i> Delete All</a></li>
													<li><a onClick="confirm_delete_selected('Manage Reviews / Comments')" style="cursor:pointer"><i class="icon-remove"></i> Delete Selected</a></li>
																									</ul>
											</div>
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
										<form name="form" method="post" action="<?php echo base_url();?>">
										<input name="comment_listing" type="hidden" value="<?php echo $listingObj->listing_id;?>">
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
																						<th style="width:8px;"><div class="checker" id="uniform-undefined"><span class=""><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" style="opacity: 0;"></span></div></th>
																						<th class="span9">Details</th>
											<th class="hidden-320" style="width:200px"></th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach($listing_review_list as $k=>$reviewObj){?>
																				<tr>
											<td style="padding-top:8px"><div class="checker" id="uniform-undefined"><span class=""><input name="comment_status_delete_176" type="checkbox" class="checkboxes" value="yes" style="opacity: 0;"></span></div></td>
											<td style="padding-right:20px; vertical-align:middle">
												
												<div style="padding:5px 0 5px 0">
                                                
												<?php
												if(!empty($reviewObj->comment_rating)){?>
												<img width="84" height="16" src="<?php echo base_url("theme");?>/img/stars/pic_star<?php echo $reviewObj->comment_rating; ?>.png" alt="" style="width:84px; height:16px;">
												<?php }?>
												</div>
												
												<h5 style="font-weight:700; margin:0">
												Reviews
												</h5>
												
												<div class="hidden-480">
												<?php echo $reviewObj->comment_description;?>
												</div>
												
												<div class="hidden-768" style="margin-left:0; margin-bottom:5px; margin-top:10px">
													<div class="span6">
														
														<div class="td_label">Review #</div>
														<div class="td_value"><?php echo $reviewObj->comment_id;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Language</div>
														<div class="td_value">English</div>
														<div class="td_clear"></div>
														
														<div class="td_label">Status</div>
														<div class="td_value"><?php echo $reviewObj->comment_status;?></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="span6">
														
														<div class="td_label">Submitted By</div>
														<div class="td_value"><?php echo $reviewObj->visitor_username;?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Submitted At</div>
														<div class="td_value">
															<?php echo date("d M Y",strtotime($reviewObj->comment_lastupdate));?>
                                                        </div>
														<div class="td_clear"></div>
														
														<div class="td_label">IP Address</div>
														<div class="td_value"><?php echo $reviewObj->comment_ipaddress;?></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="clearfix"></div>
												</div>
												
												<div class="btn-group">
													<a class="btn mini yellow dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
													<ul class="dropdown-menu">
														<li><a href="<?php echo base_url("listing/edit_review/".$reviewObj->comment_id);?>"><i class="icon-edit"></i> Edit</a></li>
														<li><a onClick="confirm_delete('<?php echo $reviewObj->comment_id;?>','<?php echo $reviewObj->comment_linkid;?>','Reviews')" style="cursor:pointer"><i class="icon-trash"></i> Delete</a></li>
													</ul>
												</div>
												
												
											</td>
											<td class="hidden-320" style="padding:0 5px 0 5px; text-align:right; vertical-align:middle;">									
																								
											</td>
										</tr>
                                        <?php }?>
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
												<!--<div style="padding-bottom:50px">
							<div style="float:right;">
								<a onClick="confirm_delete_selected('Manage Reviews / Comments')" style="cursor:pointer; margin-bottom:7px; text-align:left" class="btn mini red"><i class="icon-remove"></i> Delete Selected</a>
							</div>
							<div style="clear:both"></div>
						</div>-->
												
						
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url('theme'); ?>/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url('theme'); ?>/scripts/app.js"></script>	
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