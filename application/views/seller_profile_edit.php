<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/jquery-tags-input/jquery.tagsinput.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/clockface/css/clockface.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
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
			$sidemenu[2] =array("1"=>"active");
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
						<h3 class="page-title">My Profile</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid inbox">

					<div class="span12">
						
						<div class="portlet box grey" style="border-color:#461B7E;">
							<div class="portlet-title" style="background-color:#461B7E;">
								<div class="caption"><i class="icon-edit"></i> Edit Your Account Profile</div>
							</div>
							
							
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url("seller/update_seller_profile");?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
								<input name="seller_id" value="<?php echo $sellerObj->seller_id; ?>" type="hidden">
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
									
									
									<div class="control-group" style="margin-top:0; margin-bottom:0">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Contact Information</h5>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Title <span class="required">*</span></label>
										<div class="controls">
											<select name="seller_title" class="m-wrap span2">
                                            	<?php
													foreach($titleObjArray as $k=>$titleObj)
													{?>
                                                    	<?php if($k==$sellerObj->seller_title){ ?>
														<option value="<?php echo $titleObj->title_id; ?>" selected="selected"><?php echo $titleObj->title_name_1; ?></option>
                                                        <?php }else{ ?>
                                                        <option value="<?php echo $titleObj->title_id; ?>"><?php echo $titleObj->title_name_1; ?></option>
                                                        <?php } ?>
                                                        
										<?php		}
												?>
											</select>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">First Name <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_firstname" value="<?php echo $sellerObj->seller_firstname; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Last Name <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_lastname" value="<?php echo $sellerObj->seller_lastname; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Phone Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="seller_phone" value="<?php echo $sellerObj->seller_phone; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Mobile Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="seller_mobile" value="<?php echo $sellerObj->seller_mobile; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Fax Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="seller_fax" value="<?php echo $sellerObj->seller_fax; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Email <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_email" value="<?php echo $sellerObj->seller_email; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Website URL <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="seller_website" value="<?php echo $sellerObj->seller_website; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="space20"></div>
									
									
									
									<div class="control-group" style="margin-top:0; margin-bottom:0">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Mailing Information</h5>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Mailing Address <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_address" value="<?php echo $sellerObj->seller_address; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label"></label>
										<div class="controls">
											<input type="text" name="seller_address2" value="<?php echo $sellerObj->seller_address2; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">City / Town <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_city" value="<?php echo $sellerObj->seller_city; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">State / Province <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_province" value="<?php echo $sellerObj->seller_province; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">ZIP / Post Code <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="seller_zip" value="<?php echo $sellerObj->seller_zip; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Country <span class="required">*</span></label>
										<div class="controls">
											
											<select name="seller_country" class="m-wrap span6">												
											<?php 	foreach($countryObjArray as $k=>$countryObj) { ?>
														<?php if($k==$sellerObj->seller_country) { ?>
                                                        <option value="<?php echo $countryObj->country_id; ?>" selected="selected"><?php echo $countryObj->country_name; ?></option>
                                                        <?php }else{ ?>
                                                        <option value="<?php echo $countryObj->country_id; ?>"><?php echo $countryObj->country_name; ?></option>
                                                        <?php } ?>
											<?php	}?>                                                											
											</select>
										</div>
									</div>
									<div class="space20"></div>
									
									
									
									
									<div class="control-group" style="margin-top:0; margin-bottom:0">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Other Information</h5>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Which type of sellers are you? <span class="required">*</span></label>
										<div class="controls">
											<label class="radio">
												<div class="radio" id="uniform-undefined"><span class=""><input name="seller_type" type="radio" value="personal" style="opacity: 0;" checked="<?php if($sellerObj->seller_type=="personal"){ echo "true";}else{echo "false";} ?>"></span></div>
												Personal
											</label>
											<br>
											<label class="radio">
												<div class="radio" id="uniform-undefined"><span class="checked"><input name="seller_type" type="radio" value="company" checked="<?php if($sellerObj->seller_type=="company"){ echo "true";}else{echo "false";} ?>" style="opacity: 0;"></span></div>
												Company
											</label>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Company Name <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="seller_company" value="<?php echo $sellerObj->seller_company; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									
									
									
									<div class="control-group form_field">
										<label class="control-label">Upload your logo or picture</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="seller_logo">
												<div class="fileupload-new thumbnail">
                                                
                                                <?php
													$url = base_url()."logo_cache/".$sellerObj->seller_id.".jpg";
													$url = get_headers($url, 1);
													if(!preg_match("/404/",$url[0]))
													{
												?>
                                                <img src="<?php echo base_url(); ?>logo_cache/<?php echo $sellerObj->seller_id; ?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
												<?php }else{?>
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">	
											<?php	}
												?>
												
                                                
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Select File</span>
													<span class="fileupload-exists">Change</span>
													<input name="seller_logo" type="file" class="default"></span>
													<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
												<div style="margin-top:10px">
													<span class="label label-important">Note :</span>
													<span style="font-weight:normal">Please only upload JPG or JPEG file only ...</span>
												</div>
											</div>
										</div>
									</div>
									<div class="space20"></div>																														
									<div class="control-group">
										<label class="control-label">Please let us know more about you or your company.  <span class="required"></span></label>
										<div class="controls">
											<textarea name="seller_desc_1" class="span8 m-wrap" rows="6"><?php echo $sellerObj->seller_desc_1; ?></textarea>
										</div>
									</div>
									<div class="space20"></div>
									<div class="form-actions">
										<button type="submit" class="btn black" style="background-color:#461B7E;"><i class="icon-ok"></i> Save</button>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/ckeditor/ckeditor.js"></script>  
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>theme/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<script src="<?php echo base_url(); ?>theme/scripts/app.js"></script>
	<script src="<?php echo base_url(); ?>theme/scripts/form-components.js"></script>     
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
						errorElement: 'span', 						// default input error message container
						errorClass: 'help-inline', 					// default input error message class
						focusInvalid: false, 						// do not focus the last invalid input
						ignore: "",
						
						rules: {
							
							seller_username: 						{ required: true, minlength: 3},
							seller_password: 						{ required: true, minlength: 3 },
							seller_language: 						{ required: true },
							
							seller_package: 						{ required: true },
							seller_payment_period: 					{ required: true },
							seller_expire_date: 					{ required: true },
							
							seller_title: 							{ required: true },
							seller_firstname: 						{ required: true },
							seller_lastname: 						{ required: true },
							seller_email: 							{ required: true, email: true },
							//seller_website:						{ url: true },
							
							seller_address: 						{ required: true },
							seller_city: 							{ required: true },
							seller_province: 						{ required: true },
							seller_zip: 							{ required: true },
							seller_country: 						{ required: true },
							
						},
						
						
						// custom messages for radio buttons and checkboxes
						messages: {
							
							seller_username: 						{ required: "Please fill this field.", minlength: "Please enter at least 3 characters.", remote: "The username you choose is not available.." },
							seller_password: 						{ required: "Please fill this field.", minlength: "Please enter at least 3 characters." },
							seller_language: 						{ required: "Please fill this field." },
							
							seller_package: 						{ required: "Please fill this field." },
							seller_payment_period: 					{ required: "Please fill this field." },
							seller_expire_date: 					{ required: "Please fill this field." },
							
							seller_title: 							{ required: "Please fill this field." },
							seller_firstname: 						{ required: "Please fill this field." },
							seller_lastname: 						{ required: "Please fill this field." },
							seller_email: 							{ required: "Please fill this field.", email: "Please enter a valid email address." },
							//seller_website: 						{ url: "Please enter a valid URL (with http://)" 	   },
							
							seller_address: 						{ required: "Please fill this field." },
							seller_city: 							{ required: "Please fill this field." },
							seller_province: 						{ required: "Please fill this field." },
							seller_zip: 							{ required: "Please fill this field." },
							seller_country: 						{ required: "Please fill this field." },
							
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
						window.location.assign('<?php echo base_url("login"); ?>');
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