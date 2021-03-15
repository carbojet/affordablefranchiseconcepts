<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/gritter/css/jquery.gritter.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/jquery-tags-input/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/clockface/css/clockface.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
<!-- END PAGE LEVEL STYLES -->
</head><!-- BEGIN BODY -->
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

			$sidemenu[5] =array("1"=>"active","2"=>array("2"=>"active"));

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
          <div class="portlet box grey" style="border-color:#004080;">
            <div class="portlet-title" style="background-color:#004080;">
              <div class="caption"><i class="icon-search"></i> Search Listings</div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url("listing/listing_search/");?>" class="form-horizontal" method="post">
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls"> You can simply use the following search form to search the listings you want. <br>
                    Please understand that the more criteria you put in the form will give you narrower results ... </div>
                </div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <h5 style="font-weight:700">Enter Listing Criteria ...</h5>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">ID Number</label>
                  <div class="controls span6">
                    <input type="text" name="listing_id" data-required="1" class="span12 m-wrap">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Keyword</label>
                  <div class="controls span6">
                    <input type="text" name="listing_status_keywords" data-required="1" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Sector Name</label>
                  <div class="controls span6">
                    <select name="listing_sector" class="span12 m-wrap" onChange="jQuery.fn.ajax_category_list(this.value,1);">
                      <option value="">Select Sector</option>                        
                    	<?php						
						$sector_list = $this->Generaldb->sector_list();						
						if(!empty($sector_list)){
						foreach($sector_list as $k=>$sectorlistObj){ ?>
                    	<option value="<?php echo $sectorlistObj->category_id; ?>"><?php echo $sectorlistObj->category_name_1; ?></option>
                        <?php }} ?>
                    </select>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Category</label>
                  <div class="controls span6">
						<div id="listing_category_1" class="listing_category" style="current:block; padding-top:0px">
                      <select name="listing_category[]" id="box_listing_category_1" class="span12 m-wrap" >
                        <option value="0"></option>
                       
                      </select>
                    </div>  
                  </div>
                </div>
                <div class="control-group span12">
                  <label class="control-label">Location</label>
                  <div class="controls span8 location">
                    <div id="listing_location_1" style="current:block; padding-top:0px" class="span4">
                      <select name="listing_location_1" id="box_listing_location_1" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,2);">
                        <option value="">Choose your business location</option>
                        <?php

													$country_list = $this->Listingdb->get_active_country();

													foreach($country_list as $k=>$ClocationObj)

													{?>
                        <?php if(preg_match("/".$ClocationObj->location_path."/",$listingObj->listing_location_path)){ $select_country = $ClocationObj->location_id;?>
                        <option value="<?php echo $ClocationObj->location_id; ?>" selected="selected"><?php echo $ClocationObj->location_name; ?></option>
                        <?php }else{?>
                        <option value="<?php echo $ClocationObj->location_id; ?>"><?php echo $ClocationObj->location_name; ?></option>
                        <?php }?>
                        <?php	}

												?>
                      </select>
                    </div>
                    <div id="listing_location_2" style="current:none; padding-top:0px" class="span4">
                      <select name="listing_location_2" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,3);">
                        <?php

                                            $state_list = $this->Listingdb->get_location_list(array("location_parent"=>$select_country));

                                            foreach($state_list as $k=>$stateObj){

                                            if(preg_match("/".$stateObj->location_id."/",$listingObj->listing_location_path)){

                                            $select_state = $stateObj->location_id;?>
                        <option value="<?php echo $stateObj->location_id; ?>" selected="selected"><?php echo $stateObj->location_name ?></option>
                        <?php }else{?>
                        <option value="<?php echo $stateObj->location_id; ?>"><?php echo $stateObj->location_name ?></option>
                        <?php }?>
                        <?php }?>
                      </select>
                    </div>
                    <div id="listing_location_3" style="current:none; padding-top:0px" class="span4">
                      <select multiple name="listing_location[]" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,4);">
                        <?php

                                            $state_div_list = $this->Listingdb->get_location_list(array("location_parent"=>$select_state));

                                            foreach($state_div_list as $k=>$divObj){

                                            if(preg_match("/".$divObj->location_id."/",$listingObj->listing_location_path)){

                                            $select_div = $divObj->location_id;?>
                        <option value="<?php echo $divObj->location_id; ?>" selected="selected"><?php echo $stateObj->location_name ?></option>
                        <?php }else{?>
                        <option value="<?php echo $divObj->location_id; ?>"><?php echo $divObj->location_name ?></option>
                        <?php }?>
                        <?php }?>
                      </select>
                    </div>                    
                    <div id="listing_location_notification" style="display:none; padding-top:5px"> <img src="gui/ltr/img/ajax-loader.gif" align="left" style="padding-right:5px"> <font>please wait while loading sub locations data ...</font> </div>
                  </div>
                </div>
                <div class="control-group span12">
                  <label class="control-label">Zip Code</label>
                  <div class="controls zip">
                    <input type="text" name="listing_zip" data-required="1" class="span3 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span4">
                  <label class="control-label"> Featured </label>
                  <div class="controls span4">
                    <select name="s_featured" class="span12 m-wrap">
                      <option value="">Any </option>
                      <option value="featured">Featured Listings </option>
                      <option value="not_featured">Not-Featured Listings </option>
                    </select>
                  </div>
                </div>
                <div class="control-group span3">
                  <label class="control-label"> Order By </label>
                  <div class="controls span4">
                    <select name="s_order" class="span12 m-wrap">
                      <option value="id">ID Number </option>
                      <option value="seller">Member Name </option>
                      <option value="status">Status </option>
                      <option value="expire">Expire Date </option>
                      <!--<option value="viewed">Times Viewed			</option>

										<option value="distance">Distance				</option>-->
                    </select>
                  </div>
                </div>
                <div style="clear:both"></div>
                <div class="form-actions">
                  <button type="submit" name="" class="btn black" style="background-color:#461B7E;"><i class="icon-search"></i> Search</button>
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
<div class="footer" style="text-align:center; background-color:#1B2E44;"> <a href="http://www.affordablebusinessconcepts.com/" style="color:#FC0; background-color:#1b2e44">&copy; Affordable Busindess Concepts LLC</a>
  <div class="span pull-right"> <span class="go-top" style="background-color: #FFC000;"><i class="icon-angle-up"></i></span> </div>
</div>
<!-- END FOOTER -->
<!-- END FOOTER -->
<?php

	$this->load->view("foot");

?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script src="<?php echo base_url();?>theme/scripts/app.js"></script>
<script src="<?php echo base_url();?>theme/scripts/form-components.js"></script>
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

							

							seller_username: 						{ required: true, minlength: 3, remote: "system_seller_check_username.php" },

							seller_password: 						{ required: true, minlength: 3 },

							seller_language: 						{ required: true },

							

							seller_package: 						{ required: true },

							seller_payment_period: 					{ required: true },

							seller_expire_date: 					{ required: true },

							

							seller_title: 							{ required: true },

							seller_firstname: 						{ required: true },

							seller_lastname: 						{ required: true },

							seller_email: 							{ required: true, email: true },

							seller_website:							{ url: true },

							

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

							seller_website: 						{ url: "Please enter a valid URL (with http://)" 	   },

							

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

		jQuery.fn.ajax_location_list = function(id,level)

		{

			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("listing/ajax_location_list"); ?>'+'/'+id,

				ContentType : 'application/json',

				success:function(data){

					if(Object.keys(data).length>0)

					{

						

						$("#listing_location_"+level).find("select option").remove();

						jQuery("#listing_location_"+level).find("select").append('<option value="0">All</option>')

						//for(var key in data){
						jQuery.each(data,function(key,obj){  

						$("#listing_location_"+level).find("select").append('<option value="'+obj.id+'">'+obj.location_name+'</option>')

						})
						//}				

					}

				}

			});

		}

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>