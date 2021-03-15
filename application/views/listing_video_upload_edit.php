<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/jquery-tags-input/jquery.tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/clockface/css/clockface.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<!-- END PAGE LEVEL STYLES -->	
	<script src="<?php echo base_url("theme");?>/scripts/javascript.js" type="text/javascript"></script>
    <script language="javascript">
	<!--
		
		function preview(id) {
			var leftPos = (screen.availWidth-550) / 2;
			var topPos 	= (screen.availHeight-500) / 2;
			window.open('listing_video_view.php?video=' + id,'','width=550,height=500,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
		
		function confirm_delete_file(id){
			if ( confirm("Are you sure want to delete this video file?") ){
				window.location = "<?php echo base_url("listing/remove_listing_video");?>"+"/"+id; 
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
				<div class="row-fluid inbox">
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
											<strong>Status</strong> <?php echo $listingObj->listing_status; ?>  / <?php echo $listingObj->listing_status_feature; ?> <br>
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
													<!-- <li><a href="" target="_blank"><i class="icon-zoom-in"></i> Preview </a></li> -->
													
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

													<li><a href="<?php echo base_url("listing/listing_category/".$listingObj->listing_id);?>"><i class="icon-sitemap"></i> Categories <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_category(array("category_listing"=>$listingObj->listing_id)));?>)</font></a></li>
													
                                                    <li><a href="<?php echo base_url("listing/listing_photos/".$listingObj->listing_id);?>"><i class="icon-picture"></i> Photos  <font dir="ltr">(<?php echo count($this->Listingdb->listing_photos(array("photo_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                    
                                                    <li><a href="<?php echo base_url("listing/listing_videos/".$listingObj->listing_id);?>/"><i class="icon-facetime-video"></i> Videos  <font dir="ltr">(<?php echo count($this->Listingdb->get_listing_video(array("video_listing"=>$listingObj->listing_id)));?>)</font></a></li>
                                                    
                                                    <!--<li><a href="listing_document.php?listing=117"><i class="icon-briefcase"></i> Documents <font dir="ltr">(0)</font> </a></li>
                                                    
                                                    <li><a href="listing_event.php?listing=117"><i class="icon-calendar"></i> Events <font dir="ltr">(0)</font> </a></li>
                                                    
                                                    <li><a href="listing_coupon.php?listing=117"><i class="icon-barcode"></i> Coupons <font dir="ltr">(0)</font> </a></li>
                                                    
                                                    <li><a href="listing_product.php?listing=117"><i class="icon-gift"></i> Products <font dir="ltr">(0)</font> </a></li>
                                                    
                                                    <li><a href="listing_news.php?listing=117"><i class="icon-book"></i> News <font dir="ltr">(0)</font> </a></li>-->
																										
												</ul>
											</div>
		
										</div>
																		
									</div>
								</div>

								<div class="hidden-768">
									
																		
								</div>
								
							</div>
							
						</div>						
						
						<div class="portlet box grey" style="border-color:#9F000F;">
							<div class="portlet-title" style="background-color:#9F000F;">
								<div class="caption"><i class="icon-facetime-video"></i>Edit Video</div>
							</div>
							
							
							<div class="portlet-body form">
								
								
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url("listing/upload_listing_video/");?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
								<input name="video_id" type="hidden" value="<?php echo $listing_videoObj->video_id;?>">
                               
										<div class="alert alert-error hide" style="margin:10px 0 10px 0">
											<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
											<font style="font-weight:bold">
												<h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3> 
												<div style="min-height:31px; vertical-align:middle;">
													Please fill the following form completely. <br>Fields marked  * are required ...
												</div>
											</font>
										</div>																		
                                        <div class="alert alert-success hide" style="margin:10px 0 10px 0">
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
								<div class="control-group form_field">
									<label class="control-label">Video Type <span class="required">*</span></label>
									<div class="controls">
											<label class="radio line">
												<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="video_type" value="upload" onClick="location.href='<?php echo base_url("listing/edit_listing_video/".$listing_videoObj->video_id."/upload/");?>'" style="opacity: 0;"></span></div>
												I want to upload video from my harddrive.
											</label>
											<label class="radio line">
												<div class="radio" id="uniform-undefined"><span><input type="radio" name="video_type" value="external" checked="checked" onClick="location.href='<?php echo base_url("listing/edit_listing_video/".$listing_videoObj->video_id."/external/");?>'" style="opacity: 0;"></span></div>
												I want to link to external video url.
											</label>
											<label class="radio line">
												<div class="radio" id="uniform-undefined"><span><input type="radio" name="video_type" value="youtube" onClick="location.href='<?php echo base_url("listing/edit_listing_video/".$listing_videoObj->video_id."/youtube/");?>'" style="opacity: 0;"></span></div>
												I want to embed a YouTube video.
											</label>
										</div>
								</div>
								
								
								<div class="space20"></div>
								
								
																																																
																																
								<div class="control-group ">
									<label class="control-label">Video Title <span class="required">*</span></label>
									<div class="controls">
										<input type="text" name="video_title_1" value="<?php echo $listing_videoObj->video_title_1;?>" data-required="1" class="span6 m-wrap" style="">
									</div>
								</div>
								<div class="space20"></div>
								<div class="control-group form_field" style="margin-bottom:0;">
									<label class="control-label">Upload Video Thumbnail <span class="required">*</span></label>
									<div class="controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;">
												<img src="<?php echo base_url();?>video_big/<?php echo $listing_videoObj->video_id;?>.jpg" border="0">
											</div>
											<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
											<div>
												<span class="btn btn-file"><span class="fileupload-new">Select File</span>
												<span class="fileupload-exists">Change</span>
												<input name="video_photo" type="file" class="default" onChange="$('form').trigger('submit');"></span>
												<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
											</div>
											<div style="margin-top:10px">
												<span class="label label-important">Note :</span><br>
												<span style="font-weight:normal">Please only upload JPG or JPEG file only ...</span>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="space20"></div>
								
								
																<div class="space20"></div>
								<div class="control-group form_field" style="margin-bottom:0">
									<label class="control-label">Upload Video File (.MOV, .SWF or .WMV files) <span class="required">*</span></label>
									<div class="controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<span class="btn btn-file">
											<span class="fileupload-new">Select File</span>
											<span class="fileupload-exists">Change</span>
											<input name="video_file" type="file" class="default">
											</span>
											<span class="fileupload-preview" style="padding-right:10px"></span>
											<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
										</div>
										<div style="margin-top:10px">
											<span class="label label-important">Note :</span><br>
											<span style="font-weight:normal">Please only upload .MOV, .SWF or .WMV files</span>
										</div>
									</div>
								</div>
																<div class="control-group" style="margin-top:10px">
									<label class="control-label"></label>
									<div class="controls">
										<a onClick="preview('<?php echo $listing_videoObj->video_id;?>');" class="btn mini purple" style="cursor:pointer"><i class="icon-zoom-in"></i> Preview Video</a> &nbsp;&nbsp;|&nbsp;&nbsp;
										<a onClick="confirm_delete_file('<?php echo $listing_videoObj->video_id;?>');" class="btn mini yellow" style="cursor:pointer"><i class="icon-trash"></i> Delete Video File</a>
									</div>
								</div>
																								
								
								<div class="space20"></div>
								
								
																
								
																
								
								<div class="space20"></div>
								
								
																																																
																																
								<div class="control-group form_field">
									<label class="control-label">Description <span class="required">*</span></label>
									<div class="controls">
										<textarea name="video_description_1" class="span8 m-wrap" rows="5">testing</textarea>
										<input type="hidden" name="required_video_description_1" value="text">
									</div>
								</div>
																
								
								<div class="form-actions">
									<button type="submit" class="btn black" style="background-color:#9F000F;"><i class="icon-ok"></i> Save</button>
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
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/ckeditor/ckeditor.js"></script>  
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
	<script src="<?php echo base_url("theme");?>/scripts/form-components.js"></script>
	<!-- END PAGE LEVEL STYLES -->
	<script>
	
	
		var FormValidation = function () {
		
		
			return {
			
				//main function to initiate the module
				init: function () {
		
					var this_form 		= $('#form');
					var this_error 		= $('.alert-error'	, this_form);
					var this_success 	= $('.alert-success', this_form);
					
					this_form.validate({
						errorElement: 'span', 								// default input error message container
						errorClass: 'help-inline',							// default input error message class
						focusInvalid: false, 								// do not focus the last invalid input
						ignore: "",
						
						rules: {
							
																					video_title_1:				{ required: true },
							video_description_1:			{ required: true },
																					
							video_photo:									{ required: true },
							video_file:										{ required: true },
							video_url:										{ required: true, url:true },
							video_youtube:									{ required: true },
							
						},
						
						
						// custom messages for radio buttons and checkboxes
						messages: {
							
																					video_title_1:				{ required: "Please fill this field." },
							video_description_1:			{ required: "Please fill this field." },
																					
							video_photo:									{ required: "Please fill this field." },
							video_file:										{ required: "Please fill this field." },
							video_url:										{ required: "Please fill this field.", url: "Please enter a valid URL (with http://)" },
							video_youtube:									{ required: "Please fill this field." },
							
						},
						
						
						// display error alert on form submit   
						invalidHandler: function (video, validator) {
							this_success.hide();
							this_error.show();
							App.scrollTo(this_error, -200);
						},
						
						
						// hightlight error inputs
						highlight: function (element) { 
							$(element)
								.closest('.help-inline').removeClass('ok'); // display OK icon
							$(element)
								.closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
						},
						// revert the change dony by hightlight
						unhighlight: function (element) {
							$(element)
								.closest('.control-group').removeClass('error'); // set error class to the control group
						},
		
						success: function (label) {
							if (label.attr("for") == "service" || label.attr("for") == "membership") { // for checkboxes and radip buttons, no need to show OK icon
								label
									.closest('.control-group').removeClass('error').addClass('success');
								label.remove(); // remove error label here
							} else { // display success icon for other inputs
								label
									.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
									.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
							}
						},
		
						submitHandler: function (form) {
							form.submit();
						}
		
					});
		
					// apply validation on chosen dropdown value change, this only needed for chosen dropdown integration.
					$('.chosen, .chosen-with-diselect', this_form).change(function () {
						this_form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
					});
		
				}
		
			};
		
		}();
		
		jQuery(document).ready(function() {   
			// initiate layout and plugins
			App.init();
			FormComponents.init();
			FormValidation.init();
		});
		
	</script>
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>