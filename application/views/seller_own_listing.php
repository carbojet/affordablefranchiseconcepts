<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	
	<link rel="shortcut icon" href="favicon.ico" />
	
	
	<script type="text/javascript">
	<!--
		function confirm_delete(id, name, page){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url("/listing/delete_seller_listing/");?>"+"/"+id; 
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
		
		function confirm_delete_all(page){	
			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){
				window.location = "system_listing_delete_all.php"; 
				return true;
			} 
			else{ return false; }
		}
		
		function menu_resort(menuform) {
			var baseurl		= "?" ;
			selecteditem	= menuform.s_order.selectedIndex ;
			newurl 			= menuform.s_order.options[ selecteditem ].value ;
			location.href	= baseurl + '&s_order=' + newurl;
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
			$sidemenu[3] =array("1"=>"active");
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("seller_sidebar",$data);
		?>		
		<!-- BEGIN PAGE -->
		<div class="page-content" data-height="1491">			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Listings</h3>
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
										<div class="caption"><i class="icon-list"></i> Manage Listings</div>
										
                                      <div class="actions"><a href="<?php echo base_url("listing/new_own_listing/".$sellerObj->seller_id); ?>" class="btn red"><i class="icon-plus"></i> Add New</a>																																		
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
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th style="width:8px;"><div class="checker" id="uniform-undefined"><span class=""><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" style="opacity: 0;"></span></div></th>
											<th class="span9">Detailed Info</th>
											<th class="span3" style="text-align:right">Thumbnail</th>
										</tr>
										</thead>
										<tbody>
                                        	<?php foreach($listing_list as $k=>$listingObj){ ?>
                                            <tr>
                                                <td style="padding-top:8px"><div class="checker" id="uniform-undefined"><span class=""><input name="listing_status_delete_<?php echo $listingObj->listing_id; ?>" type="checkbox" class="checkboxes" value="yes" style="opacity: 0;"></span></div></td>
                                                <td style="padding-right:20px; vertical-align:middle">
                                                	<div style="padding:5px 0 5px 0">
                                                    <?php $visitor_commentObj  = $this->Listingdb->get_listing_rating(array("listing_id"=>$listingObj->listing_id)); 
													if(!empty($visitor_commentObj->comment_rating)){?>
                                                    	<img width="84" height="16" src="<?php echo base_url('theme');?>/img/stars/pic_star<?php echo $visitor_commentObj->comment_rating; ?>.png" alt="" style="width:84px; height:16px;">
                                                     <?php }?>
                                                    </div>
                                                    <h5 style="font-weight:700; margin:0;"><?php echo $listingObj->listing_title_1; ?></h5>
                                                    <?php echo $listingObj->listing_address; ?><br>
                                                    <?php echo $listingObj->listing_address2.", ".$listingObj->country_name;?> <br>
                                                    <!-- details -->
                                                    <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                                        <div class="span6">
                                                            <div class="td_label">ID Number</div>
                                                            <div class="td_value"><?php echo $listingObj->listing_id;?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                            <div class="td_label">Seller</div>
                                                            <div class="td_value"><?php echo $listingObj->seller_firstname." ".$listingObj->seller_lastname;?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                            <?php
                                                           $viewed = $this->Listingdb->get_listing_visited(array("stat_listing"=>$listingObj->listing_id));
															?>
                                                            <div class="td_label">Viewed</div>
                                                            <div class="td_value"> <?php echo $viewed; ?> times</div>
                                                            <div class="td_clear"></div>
                                                            <?php $favourited_detail = $this->Listingdb->get_listing_favourited(array("favourite_listing"=>$listingObj->listing_id)); ?>
                                                            <div class="td_label">Favourited</div>
                                                            <div class="td_value"> <?php echo count($favourited_detail); ?> times</div>
                                                            <div class="td_clear"></div>
                                                        </div>
                                                        <div class="span6">
                                                        	<?php $packageObj = $this->Listingdb->get_listing_package(array("listing_package"=>$listingObj->listing_package)); ?>
                                                            <div class="td_label">Package</div>
                                                            <div class="td_value"><?php if(!empty($packageObj->package_listing_name_1)){echo $packageObj->package_listing_name_1;} ?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                            <div class="td_label">Expired</div>
                                                            <div class="td_value"><?php echo date("d-M-Y",strtotime($listingObj->listing_expire)); ?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                            <div class="td_label">Featured</div>
                                                            <div class="td_value"><?php if(!empty($listingObj->listing_status_feature)){ echo "Yes";}else{echo "No";} ?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                            <div class="td_label">Status</div>
                                                            <div class="td_value"><?php echo $listingObj->listing_status; ?></div>
                                                            <div class="td_clear"></div>
                                                            
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    
                                                    <!-- property links -->
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
                                                    
                                                    
                                                </td>
                                                <td style="text-align:right; vertical-align:middle; padding:10px;">
                                                <?php
													$listing_photoObj = $this->Listingdb->get_listing_main_photo(array("listing_id"=>$listingObj->listing_id,"photo_status_main"=>"main"));
													if(!empty($listing_photoObj->photo_id)){
												?>    
                                                                                                    <img src="<?php echo base_url();?>photo_medium/<?php echo $listing_photoObj->photo_id;?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
                                                <?php }?>                                                    
                                                                                                    
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
									<form>
                                    <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
                                    <span class="help-inline">of  <?php echo $pagination["pages"]; ?></span>
                                    </form>
									
								</div>
							</div>
							<div style="float:right">
								<div class="hidden-480" style="float:right">
									<div dir="ltr">
									<a href="<?php //echo base_url("listing/listing_pre_page/".($pagination["startpage"])); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a>
									<a href="<?php //echo base_url("listing/listing_nxt_page/".($pagination["startpage"])); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a>
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
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.js"></script>
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