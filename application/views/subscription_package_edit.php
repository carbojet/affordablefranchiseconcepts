<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/jquery-tags-input/jquery.tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/clockface/css/clockface.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme"); ?>/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
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
			$sidemenu[4] =array("1"=>"active","4"=>array("1"=>"active"));
			$sidemenu[4] =array("1"=>"active","4"=>array("1"=>"active","2"=>array("2"=>"active")));
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
						<h3 class="page-title">Packages</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid inbox">

					<div class="span12">
						
												<div class="portlet box grey" style="border-color:#7D1B7E;">
							<div class="portlet-title" style="background-color:#7D1B7E;">
								<div class="caption"><i class="icon-edit"></i> Edit Subscription Package</div>
							</div>
							
							
							<div class="portlet-body form">
								
								
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url("seller/subscription_package_update"); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
								<input name="package_subscription_id" type="hidden" value="<?php echo $subscriptionObj->package_subscription_id; ?>">
									
									
																		
																			<div class="alert alert-error hide" style="margin:10px 0 10px 0">
											<button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
											<font style="font-weight:bold">
												<h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3> 
												<div style="min-height:31px; vertical-align:middle;">
													Please fill the following form completely. <br>Fields marked  * are required ...
												</div>
											</font>
										</div>																			<div class="alert alert-success hide" style="margin:10px 0 10px 0">
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
									
									
									
									<div class="control-group" style="margin-top:0; margin-bottom:0">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Package Name</h5>
										</div>
									</div>
																		<div class="control-group form_field">
										<label class="control-label">English <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_name_1" value="<?php echo $subscriptionObj->package_subscription_name_1; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="space20"></div>
									<div class="space20"></div>
									<div class="control-group form_field">
										<label class="control-label">Listings <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_listings" value="<?php echo $subscriptionObj->package_subscription_listings; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Pictures <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_pics" value="<?php echo $subscriptionObj->package_subscription_pics; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Videos <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_videos" value="<?php echo $subscriptionObj->package_subscription_videos; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Documents <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_docs" value="<?php echo $subscriptionObj->package_subscription_docs; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									
									
									<div class="control-group form_field">
										<label class="control-label">Events <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_events" value="<?php echo $subscriptionObj->package_subscription_events; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">News <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_news" value="<?php echo $subscriptionObj->package_subscription_news; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Coupons <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_coupons" value="<?php echo $subscriptionObj->package_subscription_coupons; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Products <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_products" value="<?php echo $subscriptionObj->package_subscription_products; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Categories <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_categories" value="<?php echo $subscriptionObj->package_subscription_categories; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									
									
									<div class="control-group form_field">
										<label class="control-label">Featured on Homepage <span class="required">*</span></label>
										<div class="controls">
											<select name="package_subscription_featured" class="m-wrap span3">
                                            <?php
												$temp_array = array("yes"=>"Yes","no"=>"No");
												foreach($temp_array as $k=>$v)
												{?>
                                                	<?php if($subscriptionObj->package_subscription_featured==$k){ ?>
													<option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
                                                    <?php }else{?>
                                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php }?>
										<?php	}?>
											</select>
										</div>
									</div>
									
									
									<div class="control-group">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Pricing Details</h5>
											<div class="span4" style="margin-left:0; padding-left:0; margin-right:0; padding-right:0">
												All prices are in $, please enter 0.00 for FREE price amount.
											</div>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Monthly <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_monthly" value="<?php echo $subscriptionObj->package_subscription_monthly; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">3 Months <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_quarterly" value="<?php echo $subscriptionObj->package_subscription_quarterly; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">6 Months <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_semi_annually" value="<?php echo $subscriptionObj->package_subscription_semi_annually; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">12 Months <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="package_subscription_annually" value="<?php echo $subscriptionObj->package_subscription_annually; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="form-actions">
										<button type="submit" class="btn black" style="background-color:#7D1B7E;"><i class="icon-ok"></i> Save</button>
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
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/ckeditor/ckeditor.js"></script>  
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("theme"); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<script src="<?php echo base_url("theme"); ?>/scripts/app.js"></script>
	<script src="<?php echo base_url("theme"); ?>/scripts/form-components.js"></script>     
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
						errorElement: 'span', 													// default input error message container
						errorClass: 'help-inline', 												// default input error message class
						focusInvalid: false, 													// do not focus the last invalid input
						ignore: "",
						rules: {
							
														package_subscription_name_1:		{ required: true },
														
							package_subscription_listings: 										{ required: true, digits: true },
							package_subscription_pics: 											{ required: true, digits: true },
							package_subscription_videos: 										{ required: true, digits: true },
							package_subscription_docs: 											{ required: true, digits: true },
							package_subscription_events: 										{ required: true, digits: true },
							package_subscription_news: 											{ required: true, digits: true },
							package_subscription_coupons: 										{ required: true, digits: true },
							package_subscription_products: 										{ required: true, digits: true },
							package_subscription_categories: 									{ required: true, digits: true },
							package_subscription_featured: 										{ required: true },
							
							package_subscription_monthly: 										{ required: true, number: true },
							package_subscription_quarterly: 									{ required: true, number: true },
							package_subscription_semi_annually: 								{ required: true, number: true },
							package_subscription_annually: 										{ required: true, number: true },
							
						},
						
						
						// custom messages for radio buttons and checkboxes
						messages: {

														package_subscription_name_1:		{ required: "Please fill this field." },
														
							package_subscription_listings: 										{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_pics: 											{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_videos: 										{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_docs: 											{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_events: 										{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_news: 											{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_coupons: 										{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_products: 										{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_categories: 									{ required: "Please fill this field.", digits: "Please enter only digits." },
							package_subscription_featured: 										{ required: "Please fill this field." },
							
							package_subscription_monthly: 										{ required: "Please fill this field.", number: "Please enter a number." },
							package_subscription_quarterly: 									{ required: "Please fill this field.", number: "Please enter a number." },
							package_subscription_semi_annually: 								{ required: "Please fill this field.", number: "Please enter a number." },
							package_subscription_annually: 										{ required: "Please fill this field.", number: "Please enter a number." },
							
						},
						
						
						// display error alert on form submit   
						invalidHandler: function (event, validator) {
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