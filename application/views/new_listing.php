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
<style>
input[type=checkbox] {
	margin-left:0px !important;
}
</style>
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
  <!--- lookup database :: sidebar_menu_lookup_additio	nal :: done -->
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
          <div class="portlet box grey" style="border-color:#800000;">
            <div class="portlet-title" style="background-color:#800000;">
              <div class="caption"> <i class="icon-edit"></i> Create New Listing</div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url('listing/new_listing/');?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
              
                <div class="alert alert-error <?php if(!isset($validation_errors)){echo "hide";} ?>" style="margin:10px 0 10px 0">
                  <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                  <font style="font-weight:bold">
                  <h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3>
                  <div style="min-height:31px; vertical-align:middle;"> Please fill the following form completely. <br>
                    Fields marked  * are required ... </div>
                  </font> </div>
                  
                  
                  
                
                <div class="space20"></div>
                <div class="space20"></div>
                <!--<div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <h5 style="font-weight:700">Member Information</h5>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Member Name</label>
                  <div class="controls"> <span class="text bold" style="color:#900"><?php echo $listingObj->seller_firstname." ".$listingObj->seller_lastname ?></span> </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Curent Package</label>
                  <div class="controls">
                    <?php $packageObj = $this->Listingdb->get_seller_package(array("seller_package"=>$listingObj->seller_package)); ?>
                    <span class="text bold" style="color:#900">
                    <?php if(!empty($packageObj->package_subscription_name_1)){ echo $packageObj->package_subscription_name_1;}else{echo "None";} ?>
                    </span>
                    <input type="hidden" name="listing_seller" value="<?php echo $listingObj->listing_seller; ?>">
                    <input type="hidden" name="listing_package" value="<?php echo $listingObj->seller_package; ?>">
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Expire Date</label>
                  <div class="controls">
                    <input type="text" name="listing_expire" value="<?php echo date("Y-m-d",strtotime($listingObj->seller_expire_date)); ?>" data-required="1" class="span6 m-wrap" style="">
                    <br>
                    <div class="span6" style="margin-left:0"> Because this is a subscription, you can only change the listing expire date by editing the seller expiration date ... </div>
                  </div>
                </div>-->
                <div class="control-group form_field">
                  <label class="control-label">Seller Id</label>
                  <div class="controls">
                    <input type="text" name="listing_seller" value="" data-required="1" class="span6 m-wrap" style="">
                  </div>
                </div>
                <!--- FORM SECTION - START : BUSINESS NAME -->
                <div class="control-group form_field sec_cat">
                	<div class="add_div">
                	<div class="span5">
                  <label class="control-label">Sector <span class="required">*</span></label>
                  <div class="controls">
                    <div id="listing_sector_1" style="current:block; padding-top:0px">
                      <!-- onChange="jQuery.fn.ajax_sector_list(this.value,3);" -->
                      <select name="listing_sector[]" id="listing_sector" class="span12 m-wrap listing_sector" onChange="jQuery.fn.ajax_category_list(this.value,1);">
                        <option value="">Select Sector</option>                        
                    	<?php
						$sector_list = $this->Listingdb->sector_list();
						if(!empty($sector_list)){
						foreach($sector_list as $k=>$sectorlistObj){ ?>
                    	<option value="<?php echo $sectorlistObj->category_id; ?>"><?php echo $sectorlistObj->category_name_1; ?></option>
                        <?php }} ?>
                      </select>
                    </div>
                  </div></div>
                  	<div class="span5">                  
                  <label class="control-label">Category <span class="required">*</span></label>
                  <div class="controls">
                    <div id="listing_category_1" class="listing_category" style="current:block; padding-top:0px">
                      <select name="listing_category[]" id="box_listing_category_1" class="span12 m-wrap" >
                        <option value=""></option>
                       
                      </select>
                    </div>                    
                  </div>                  
                </div></div>
                <div class="span2 adbtn"><button type="button" name="addbutton" class="btn btn-default addButton"><i class="icon-plus"></i></button></div>
                </div>
                <input type="hidden" name="listing_category_count" value="1" />
                
                <div class="control-group form_field">
                  <label class="control-label"> Enter Your Business Name <span class="required">*</span> </label>
                  <div class="controls">
                    <input type="text" name="listing_title_1" value="<?php echo $listingObj->listing_title_1; ?>" data-required="1" class="span6 m-wrap" style="">
                  </div>
                </div>
                <!--- FORM SECTION - END : BUSINESS NAME -->
                <div class="control-group" style="margin-top:50px">
                  <label class="control-label"></label>
                  <div class="controls">
                    <h5 style="font-weight:700">Enter Your Listing Price</h5>
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Pricing $ <span class="required">*</span></label>
                  <div class="controls">
                    <div style="current:block; padding-top:0px">
                      <input type="text" name="listing_price" value="<?php echo $listingObj->listing_price; ?>" data-required="1" class="span6 m-wrap" style="">
                    </div>
                  </div>
                </div>
                <!--- FORM SECTION - START : BUSINESS PLACE -->
                <div class="control-group" style="margin-top:50px">
                  <label class="control-label"></label>
                  <div class="controls">
                    <h5 style="font-weight:700">Enter Your Business Location</h5>
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Location <span class="required">*</span></label>
                  <div class="controls">
                    <div id="listing_location_1" style="current:block; padding-top:0px">
                      <select name="listing_location_1" id="box_listing_location_1" class="span6 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,2);">
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
                    <div id="listing_location_2" style="current:none; padding-top:5px">
                      <select name="listing_location_2" class="span6 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,3);">
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
                    <div id="listing_location_3" style="current:none; padding-top:5px">
                      <select name="listing_location_3" class="span6 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,4);">
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
                    <div id="listing_location_4" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_5" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_6" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_7" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_8" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_9" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_10" style="current:none; padding-top:0px"></div>
                    <div id="listing_location_notification" style="display:none; padding-top:5px"> <img src="<?php echo base_url("theme");?>/img/ajax-loader.gif" align="left" style="padding-right:5px"> <font>please wait while loading sub locations data ...</font> </div>
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Address </label>
                  <div class="controls">
                    <input type="text" name="listing_address" value="<?php echo $listingObj->listing_address; ?>" data-required="1" class="span6 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label"></label>
                  <div class="controls">
                    <input type="text" name="listing_address2" value="<?php echo $listingObj->listing_address2; ?>" data-required="1" class="span6 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Zip Code </label>
                  <div class="controls">
                    <input type="text" name="listing_zip" value="<?php echo $listingObj->listing_zip; ?>" data-required="1" class="span4 m-wrap" style="">
                  </div>
                </div>
                <!--- FORM SECTION - END : BUSINESS PLACE -->
                <!--- FORM SECTION - START : SPECIFIC GEO LOCATION -->
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <div class="span8"> If you want to use your own longitude and latitude coordinates, then you must enter both longitude and latitude coordinates into the field below.
                      
                      However if you don't put the coordinates, then the system will use the default system generated values. </div>
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Latitude</label>
                  <div class="controls">
                    <input type="text" name="listing_posted_latitude" value="<?php echo $listingObj->listing_posted_latitude; ?>" data-required="1" class="span4 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Longitude</label>
                  <div class="controls">
                    <input type="text" name="listing_posted_longitude" value="<?php echo $listingObj->listing_posted_longitude; ?>" data-required="1" class="span4 m-wrap" style="">
                  </div>
                </div>
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"> Facilities <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_facilities" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_facilities; ?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Competition <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_competition" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_competition; ?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Growth <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_growth" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_growth; ?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Financing <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_financing" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_financing; ?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Training <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_training" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_training; ?></textarea>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"> Business Status <span class="required">*</span> </label>
                  <div class="controls">
                    <textarea name="listing_sell_reason" class="span8 m-wrap" rows="6"></textarea>
                  </div>
                </div>
                
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"> Full or Complete Description </label>
                  <div class="controls">
                    <textarea name="listing_descfull_1" class="span8 ckeditor m-wrap" rows="6" style="visibility: hidden; display: none;"><?php echo $listingObj->listing_descfull_1; ?></textarea>
                    <div id="cke_listing_descfull_1" class="cke_1 cke cke_reset cke_chrome cke_editor_listing_descfull_1 cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_listing_descfull_1_arialbl"></div>
                  </div>
                </div>
                <div class="space20"></div>
                
                <div class="space10"></div>
                <div class="control-group">
                  <label class="control-label">Image Name ( case sensitive with extention ex : tEst.jpg) <span class="required">*</span></label>
                  <div class="controls">
                    <input type="text" name="photo_caption_1" value="" data-required="1" class="span5 m-wrap" style="">
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn black" style="background-color:#800000;" name="listing_new"><i class="icon-ok"></i> Save</button>
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

						errorElement: 'span', 						// default input error message container

						errorClass: 'help-inline',					// default input error message class

						focusInvalid: false, 						// do not focus the last invalid input

						ignore: "",

						

						rules: {

														

							listing_category_1:						{ required: true },

							listing_location_1:						{ required: true },

							//listing_address:						{ required: true },

							//listing_zip:							{ required: true },

							listing_posted_latitude:				{ number: true },

							listing_posted_longitude:				{ number: true },

							

							listing_phone:							{ required: true },

							listing_email: 							{ required: true, email: true },

							//listing_website:						{ url: true },

							

							//listing_dropdown1:					{ required: true },

							//listing_dropdown2:					{ required: true },

							//listing_dropdown3:					{ required: true },

							//listing_dropdown4:					{ required: true },

							//listing_dropdown5:					{ required: true },

							

							//listing_radio1:						{ required: true },

							//listing_radio2:						{ required: true },

							//listing_radio3:						{ required: true },

							//listing_radio4:						{ required: true },

							//listing_radio5:						{ required: true },



														

														

							listing_title_1:		{ required: true },

							//listing_descbrief_1:	{ required: true },

							//listing_descfull_1:	{ required: true },

							

							listing_textbox1_1:	{ required: true },

							listing_textbox2_1:	{ required: true },

							listing_textbox3_1:	{ required: true },

							listing_textbox4_1:	{ required: true },

							listing_textbox5_1:	{ required: true },

							photo_caption_1: { required: true },
							

						},

						

						

						// custom messages for radio buttons and checkboxes

						messages: {

							

														

							listing_category_1:						{ required: "Please fill this field." },

							listing_location_1:						{ required: "Please fill this field." },

							//listing_address:						{ required: "Please fill this field." },

							//listing_zip:							{ required: "Please fill this field." },

							listing_posted_latitude:				{ number: "Please enter a number." },

							listing_posted_longitude:				{ number: "Please enter a number." },

							

							listing_phone:							{ required: "Please fill this field." },

							listing_email: 							{ required: "Please fill this field.", email: "Please enter a valid email address." },

							//listing_website:						{ url: "Please enter a valid URL (with http://)" },

							

							//listing_dropdown1:					{ required: "Please fill this field." },

							//listing_dropdown2:					{ required: "Please fill this field." },

							//listing_dropdown3:					{ required: "Please fill this field." },

							//listing_dropdown4:					{ required: "Please fill this field." },

							//listing_dropdown5:					{ required: "Please fill this field." },

							

							//listing_radio1:						{ required: "Please fill this field." },

							//listing_radio2:						{ required: "Please fill this field." },

							//listing_radio3:						{ required: "Please fill this field." },

							//listing_radio4:						{ required: "Please fill this field." },

							//listing_radio5:						{ required: "Please fill this field." },



							

														

							listing_title_1:		{ required: "Please fill this field." },

							//listing_descbrief_1:	{ required: "Please fill this field." },

							//listing_descfull_1:	{ required: "Please fill this field." },

							

							listing_textbox1_1:	{ required: "Please fill this field." },

							listing_textbox2_1:	{ required: "Please fill this field." },

							listing_textbox3_1:	{ required: "Please fill this field." },

							listing_textbox4_1:	{ required: "Please fill this field." },

							listing_textbox5_1:	{ required: "Please fill this field." },
							
							photo_caption_1: { required: "Please fill this field." },
							

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

			jQuery("input[type=checkbox]").click(function(){

				if (jQuery(this).is(":checked")) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

			})	
			
			
			///////////////////////////////Add button for Sector and category///////////////////////////
			
			jQuery("body").on("click","button[name=listing_new]",function(e){
			
				if(jQuery("input[name=listing_category_count]").val()==3)
				{
					e.preventDefault();
					alert("You must add 3 category list");
				}
				
			});
			jQuery("body").on("click","button[name=addbutton]",function(){
				len = jQuery("select.listing_sector").length+1;	
				if(len<=3){
				addrow = jQuery(this).closest(".form_field").clone();
				addrow.find("div.adbtn").remove();
				addrow.find(".add_div").append('<div class="span2 adbtn"><button type="button" name="addbutton" class="btn btn-default addButton"><i class="icon-plus"></i></button><button type="button" name="minusbutton" class="btn btn-default addButton"><i class="icon-minus"></i></button></div>');

				addrow.find("select.listing_sector").attr("onchange","jQuery.fn.ajax_category_list(this.value,"+len+");");
				addrow.find(".listing_category").attr({"id":"listing_category_"+len});
				jQuery(this).closest(".form_field").after(addrow);
				jQuery(this).closest(".form_field").find("div.adbtn").remove();
				jQuery("listing_category_count").val(len)
				}
				
			})
			
			jQuery("body").on("click","button[name=minusbutton]",function(){
				
				prevrow = jQuery(this).closest(".form_field").prev();
				prevrow.find(".add_div").append('<div class="span2 adbtn"><button type="button" name="addbutton" class="btn btn-default addButton"><i class="icon-plus"></i></button><button type="button" name="minusbutton" class="btn btn-default addButton"><i class="icon-minus"></i></button></div>');
				if(len = jQuery("select.listing_sector").length>1){
					jQuery(this).closest(".form_field").remove();				
				}
				
			})
					

		});

		CKEDITOR.replace( '', { language: 'en' });

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
						
						jQuery("#listing_location_"+level).find("select").append('<option value="">All</option>')

						//for(var key in data){
						jQuery.each(data,function(key,obj){  

						$("#listing_location_"+level).find("select").append('<option value="'+obj.id+'">'+obj.location_name+'</option>')

						})
						//}						

					}

				}

			});

		}

		jQuery.fn.ajax_category_list = function(id,level)

		{
			
			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("listing/ajax_category_list"); ?>'+'/'+id,

				ContentType : 'application/json',

				success:function(data){
					if(Object.keys(data).length>0)

					{

						$("#listing_category_"+level).find("select option").remove();

						for(var key in data){

						$("#listing_category_"+level).find("select").append('<option value="'+key+'">'+data[key]+'</option>')

						}						

					}

				}

			});
			

		}
		

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>