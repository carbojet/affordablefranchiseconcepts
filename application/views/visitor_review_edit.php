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
				window.location = "<?php echo base_url('visitor/delete_visitor_review');?>"+"/"+id;
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
		<div class="page-content">
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">My Reviews</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
						
					</div>
				</div>
				<!-- END PAGE HEADER-->

				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid inbox">

					<div class="span12">
						
						
												<div class="portlet box grey" style="border-color:#004080;">
							<div class="portlet-title" style="background-color:#004080;">
								<div class="caption"><i class="icon-comments"></i>Edit Review / Comment</div>
							</div>
							
							
							<div class="portlet-body form">
								
								
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url("visitor/update_visitor_review/")?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
								<input name="comment_id" type="hidden" value="<?php echo $reviewObj->comment_id;?>">
								
																
										<div class="alert alert-error hide" style="margin:10px 0 10px 0">
											<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
											<font style="font-weight:bold">
												<h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3> 
												<div style="min-height:31px; vertical-align:middle;">
													Please fill the following form completely. <br>Fields marked  * are required ...
												</div>
											</font>
										</div>																		<div class="alert alert-success hide" style="margin:10px 0 10px 0">
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
									<label class="control-label">Listing</label>
									<div class="controls">
                                    <input type="hidden" name="listing_id" value="<?php echo $reviewObj->listing_id;?>">
                                    <input type="hidden" name="listing_id" value="<?php echo $reviewObj->listing_url_1;?>">
                                    <input type="hidden" name="listing_id" value="<?php echo $reviewObj->listing_title_1;?>">
                                    <input type="hidden" name="listing_id" value="<?php echo $reviewObj->comment_rating;?>">
										<a href="http://www.affordablebusinessconcepts.com/listing-<?php echo $reviewObj->listing_id;?>-<?php echo $reviewObj->listing_url_1;?>" target="_blank">
										<span class="text bold" style="color:#900"><?php echo $reviewObj->listing_title_1;?></span>
										</a>
									</div>
								</div>
								
								<div class="control-group form_field">
									<label class="control-label">Your Rating <span class="required">*</span></label>
									<div class="controls">
                                    		
                                            
																				<label class="radio">
											<div class="radio" id="uniform-undefined">
                                            <?php if($reviewObj->comment_rating==5){?>
                                            <span class="checked"><input name="comment_rating" type="radio" value="5" checked="checked" style="opacity: 0;"></span>
         									<?php }else{?> 
                                             <span><input name="comment_rating" type="radio" value="5" style="opacity: 0;"></span>
                                             <?php }?>                                 
                                            </div>
											<img width="84" height="16" src="<?php echo base_url("theme");?>/gui/ltr/img/stars/pic_star5.png" alt="" style="width:84px; height:16px;">
										</label>
                                        
										<br>
										<label class="radio">
											<div class="radio" id="uniform-undefined">
                                            <?php if($reviewObj->comment_rating==4){?>
                                            <span class="checked"><input name="comment_rating" type="radio" value="4" checked="checked" style="opacity: 0;"></span>
         									<?php }else{?> 
                                             <span><input name="comment_rating" type="radio" value="4" style="opacity: 0;"></span></span>
                                             <?php }?>
                                             
                                            </div>
											<img width="84" height="16" src="<?php echo base_url("theme");?>/gui/ltr/img/stars/pic_star4.png" alt="" style="width:84px; height:16px;">
										</label>
										<br>
																				<label class="radio">
											<div class="radio" id="uniform-undefined">
                                            <?php if($reviewObj->comment_rating==3){?>
                                            <span class="checked"><input name="comment_rating" type="radio" value="3" checked="checked" style="opacity: 0;"></span>
         									<?php }else{?> 
                                             <span><input name="comment_rating" type="radio" value="3" style="opacity: 0;"></span>
                                             <?php }?>                                            
                                            </div>
											<img width="84" height="16" src="<?php echo base_url("theme");?>/gui/ltr/img/stars/pic_star3.png" alt="" style="width:84px; height:16px;">
										</label>
										<br>
																				<label class="radio">
											<div class="radio" id="uniform-undefined">
                                            <?php if($reviewObj->comment_rating==2){?>
                                            <span class="checked"><input name="comment_rating" type="radio" value="2" checked="checked" style="opacity: 0;"></span>
         									<?php }else{?> 
                                             <span><input name="comment_rating" type="radio" value="2" style="opacity: 0;"></span>
                                             <?php }?>                                            
                                            </div>
											<img width="84" height="16" src="<?php echo base_url("theme");?>/gui/ltr/img/stars/pic_star2.png" alt="" style="width:84px; height:16px;">
										</label>
										<br>
																				<label class="radio">
											<div class="radio" id="uniform-undefined">
                                            <?php if($reviewObj->comment_rating==1){?>
                                            <span class="checked"><input name="comment_rating" type="radio" value="1" checked="checked" style="opacity: 0;"></span>
         									<?php }else{?> 
                                             <span><input name="comment_rating" type="radio" value="1" style="opacity: 0;"></span>
                                             <?php }?>
                                            
                                            </div>
											<img width="84" height="16" src="<?php echo base_url("theme");?>/gui/ltr/img/stars/pic_star1.png" alt="" style="width:84px; height:16px;">
										</label>
										<br>
																				
									</div>
								</div>
								
																	
																		<input type="hidden" name="comment_language" value="1">
																		
																
								<div class="control-group form_field">
									<label class="control-label">Title / Summary <span class="required">*</span></label>
									<div class="controls">
										<input type="text" name="comment_title" value="<?php echo $reviewObj->comment_title;?>" data-required="1" class="span6 m-wrap" style="">
									</div>
								</div>
								<div class="control-group form_field">
									<label class="control-label">Reviews / Comments <span class="required">*</span></label>
									<div class="controls">
										<textarea name="comment_description" class="span6 m-wrap" rows="5"><?php echo $reviewObj->comment_description;?></textarea>
									</div>
								</div>
								
								
								<div class="form-actions">
									<button type="submit" class="btn black" style="background-color:#004080;"><i class="icon-ok"></i> Save</button>
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