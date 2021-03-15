<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
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
			$sidemenu[7] =array("1"=>"active","2"=>array("1"=>"active"));
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
						<h3 class="page-title">Visitors</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid profile">
					<div class="span12">
						<!-- load listing information section -->
						<div class="portlet box blue" style="margin-bottom:40px">
							<div class="portlet-title">
								<div class="caption"><i class="icon-info-sign"></i>Information</div>
							</div>
							
							<div class="row-fluid" style="background-color:#FFFFFF">
								<div class="span9 portfolio-text">
									<div class="portfolio-text-info" style="padding:10px 10px 10px 25px">
										
										<h4 style="font-weight:900; padding-bottom:0; margin-bottom:10px;"><?php echo $visitorObj->visitor_username;?></h4>
										
										<?php echo $visitorObj->visitor_address;?><br>
										<?php echo $visitorObj->visitor_city;?>, United States
										<br>
										
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
										<div class="caption"><i class="icon-comments"></i> View Reviews / Comments</div>
									</div>
									<div class="portlet-body">
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span12">Details</th>
										</tr>
										</thead>
										<tbody>
                                        <?php if(count($visitor_review_list)>0){foreach($visitor_review_list as $reviewObj){?>
										<tr>
											<td style="padding-right:20px; vertical-align:middle">
												
												<div style="padding:5px 0 5px 0">
												<img width="84" height="16" src="<?php echo base_url("theme");?>/img/stars/pic_star<?php echo $reviewObj->comment_rating;?>.png" alt="" style="width:84px; height:16px;">
												</div>
												
												<h5 style="font-weight:700; margin:0">
												<?php echo $reviewObj->comment_title;?>
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
														<div class="td_label"><?php echo $reviewObj->comment_type;?></div>
														<div class="td_value"><a href="#" target="_blank"><?php echo $reviewObj->listing_title_1;?></a></div>
														<div class="td_clear"></div>
														
														<div class="td_label">Submitted At</div>
														<div class="td_value"><?php echo date("d M Y",strtotime($reviewObj->comment_lastupdate));?></div>
														<div class="td_clear"></div>
														
														<div class="td_label">IP Address</div>
														<div class="td_value"><?php echo $reviewObj->comment_ipaddress;?></div>
														<div class="td_clear"></div>
														
													</div>
													<div class="clearfix"></div>
												</div>
												
												
											</td>
										</tr>
                                        <?php }}?>
										</tbody>
										</table>
										</form>

										
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
<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>