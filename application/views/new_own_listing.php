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
		input[type=checkbox]{margin-left:0px !important;}
	</style>
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
		<div class="page-content">
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
				<div class="row-fluid inbox">
					<div class="span12">
						<div class="portlet box grey" style="border-color:#800000;">
							<div class="portlet-title" style="background-color:#800000;">
								<div class="caption">
									<i class="icon-edit"></i> 
									Create New Listing
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form name="form" id="form" action="<?php echo base_url('listing/new_own_listing/');?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
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
                                    
									<input type="hidden" name="listing_seller" value="<?php echo $listingObj->listing_seller; ?>">
									<input type="hidden" name="listing_package" value="<?php echo $listingObj->seller_package; ?>">									
									<input type="hidden" name="listing_expire" value="<?php echo $listingObj->seller_expire_date; ?>">
									
									<div class="control-group" style="margin-top:50px">
										<label class="control-label"></label>
										<div class="controls">
											
											<h5 style="font-weight:700">Choose Primary Classification</h5>
											
										</div>
									</div>
									
									
									
									<!--- FORM SECTION - START : BUSINESS NAME -->
											<div class="control-group form_field">
										<label class="control-label">Category <span class="required">*</span></label>
										<div class="controls">
											
											
											<div id="listing_category_1" style="current:block; padding-top:0px">
												<select name="listing_category_1" id="box_listing_category_1" class="span6 m-wrap" onChange="">
												<option value=""></option>
                                                	<?php
														$category_detail = $this->Listingdb->get_category_list(0);
														//var_dump($category_detail);
														foreach($category_detail as $k=>$categoryObj)
														{?>
															<?php if($listingObj->listing_category==$categoryObj->category_id){?>
                                                            <option value="<?php echo $categoryObj->category_id ?>" selected="selected"><?php echo $categoryObj->category_name_1; ?></option>
                                                            <?php }else{?>
                                                            <option value="<?php echo $categoryObj->category_id ?>"><?php echo $categoryObj->category_name_1; ?></option>
                            								<?php }?>                 
												<?php	}?>
												</select>
											</div>
											
																							
												<div id="listing_category_2" style="current:none; padding-top:0px"></div>
												<div id="listing_category_3" style="current:none; padding-top:0px"></div>
												<div id="listing_category_4" style="current:none; padding-top:0px"></div>
												<div id="listing_category_5" style="current:none; padding-top:0px"></div>
												<div id="listing_category_6" style="current:none; padding-top:0px"></div>
												<div id="listing_category_7" style="current:none; padding-top:0px"></div>
												<div id="listing_category_8" style="current:none; padding-top:0px"></div>
												<div id="listing_category_9" style="current:none; padding-top:0px"></div>
												<div id="listing_category_10" style="current:none; padding-top:0px"></div>
												
																						
											<div id="listing_category_notification" style="display:none; padding-top:5px">
											<img src="gui/ltr/img/ajax-loader.gif" align="left" style="padding-right:5px"> <font>please wait while loading sub categories data ...</font>
											</div>
											
										</div>
									</div>								
																				
																																													
																																																																				
											<div class="control-group form_field">
												<label class="control-label">
													Enter Your Business Name 
													
													<span class="required">*</span>
												</label>
												<div class="controls">
													<input type="text" name="listing_title_1" value="<?php echo $listingObj->listing_title_1; ?>" data-required="1" class="span6 m-wrap" style="">
												</div>
											</div>
                                            <!--- FORM SECTION - END : BUSINESS NAME -->
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
												
																						
											<div id="listing_location_notification" style="display:none; padding-top:5px">
											<img src="<?php echo base_url("theme");?>/img/ajax-loader.gif" align="left" style="padding-right:5px"> <font>please wait while loading sub locations data ...</font>
											</div>
											
										</div>
									</div>
																											<div class="control-group form_field">
										<label class="control-label">Address <span class="required">*</span></label>
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
										<label class="control-label">Zip Code <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="listing_zip" value="<?php echo $listingObj->listing_zip; ?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<!--- FORM SECTION - END : BUSINESS PLACE -->
									
									
									
									
									<!--- FORM SECTION - START : SPECIFIC GEO LOCATION -->
									<div class="control-group">
										<label class="control-label"></label>
										<div class="controls">
											<div class="span8">
											If you want to use your own longitude and latitude coordinates, then you must enter both longitude and latitude coordinates into the field below.
											However if you don't put the coordinates, then the system will use the default system generated values.
											</div>
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
																											<!--- FORM SECTION - END : SPECIFIC GEO LOCATION -->
									
									
									
									
									
									<div class="control-group" style="margin-top:50px">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Enter Your Business Contact Information</h5>
										</div>
									</div>
									
																		<div class="control-group form_field">
										<label class="control-label">Phone <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="listing_phone" value="<?php echo $listingObj->listing_phone; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">FAX</label>
										<div class="controls">
											<input type="text" name="listing_fax" value="<?php echo $listingObj->listing_fax; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">Email <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="listing_email" value="<?php echo $listingObj->listing_email; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">Website</label>
										<div class="controls">
											<input type="text" name="listing_website" value="<?php echo $listingObj->listing_website; ?>" data-required="1" class="span6 m-wrap" style="">
                                            <p>please follow format ( http://www.domain.com )</p>
										</div>
									</div>
																		
									
									<div class="space20"></div>
									<div class="space20"></div>
									
									
																		<div class="control-group form_field">
										<label class="control-label">Facebook</label>
										<div class="controls">
											<input type="text" name="listing_facebook" value="<?php echo $listingObj->listing_facebook; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">Twitter</label>
										<div class="controls">
											<input type="text" name="listing_twitter" value="<?php echo $listingObj->listing_twitter; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		
									
									<div class="space20"></div>
									<div class="space20"></div>
									
									
																		<div class="control-group form_field">
										<label class="control-label">AIM</label>
										<div class="controls">
											<input type="text" name="listing_aim" value="<?php echo $listingObj->listing_aim; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">Yahoo ID</label>
										<div class="controls">
											<input type="text" name="listing_yahoo" value="<?php echo $listingObj->listing_yahoo; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">MSN</label>
										<div class="controls">
											<input type="text" name="listing_msn" value="<?php echo $listingObj->listing_msn; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		<div class="control-group form_field">
										<label class="control-label">Skype</label>
										<div class="controls">
											<input type="text" name="listing_skype" value="<?php echo $listingObj->listing_skype; ?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
																		
																		
									
									
									<!--- FORM SECTION - START : BUSINESS HOURS -->
                                    <?php
												$openstatus = $this->Listingdb->get_openstatus();
												$openhour = $this->Listingdb->get_openhour();
													
									?>
																		<div class="control-group" style="margin-top:50px">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Enter Your Business Hours</h5>
										</div>
									</div>
									
																		<div class="control-group ">
										<label class="control-label">Sunday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_1" class="span12 m-wrap" onChange="update_open_close('1', this.value);">
                                            <?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_1_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_1_hourfrom" class="span2 m-wrap">
											<select name="listing_open_hourfrom_1" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
                                            <?php
												$tempHr = $openhour ;											
												foreach($tempHr as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_1_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_1_hourto" class="span2 m-wrap">
											<select name="listing_open_hourto_1" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            <?php												
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_1_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
												<script language="javascript">update_open_close('1', '<?php echo $listingObj->listing_open_1_status; ?>');</script>										
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Monday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_2" class="span12 m-wrap" onChange="update_open_close('2', this.value);">
                                            <?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_2_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_2_hourfrom" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourfrom_2" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
                                            <?php																			
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_2_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_2_hourto" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourto_2" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            	<?php												
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_2_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<script language="javascript">update_open_close('2', '<?php echo $listingObj->listing_open_2_status; ?>');</script>
											
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Tuesday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_3" class="span12 m-wrap" onChange="update_open_close('3', this.value);">
                                            <?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_3_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>                                            </select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_3_hourfrom" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourfrom_3" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
                                            <?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_3_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_3_hourto" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourto_3" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            <?php											
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_3_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<script language="javascript">update_open_close('3', '<?php echo $listingObj->listing_open_3_status; ?>');</script>
											
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Wednesday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_4" class="span12 m-wrap" onChange="update_open_close('4', this.value);">
                                            <?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_4_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_4_hourfrom" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourfrom_4" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
											<?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_4_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>											
											</select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_4_hourto" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourto_4" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
											<?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_4_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>											
											</select>
											</div>
											
											<script language="javascript">update_open_close('4', '<?php echo $listingObj->listing_open_4_status; ?>');</script>
											
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Thursday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_5" class="span12 m-wrap" onChange="update_open_close('5', this.value);">
                                            <?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_5_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_5_hourfrom" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourfrom_5" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
                                            <?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_5_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_5_hourto" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourto_5" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            	<?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_5_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<script language="javascript">update_open_close('5', '<?php echo $listingObj->listing_open_5_status; ?>');</script>
											
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Friday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_6" class="span12 m-wrap" onChange="update_open_close('6', this.value);">
                                            	<?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_6_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_6_hourfrom" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourfrom_6" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
											<?php						
												$tempHr = $openhour ;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_6_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_6_hourto" class="span2 m-wrap" style="display: block;">
											<select name="listing_open_hourto_6" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            <?php						
												$tempHr = $openhour;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_6_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<script language="javascript">update_open_close('6', '<?php echo $listingObj->listing_open_6_status; ?>');</script>
											
										</div>
									</div>
																		<div class="control-group ">
										<label class="control-label">Saturday <span class="required"></span></label>
										<div class="controls">
											
											<!-- status -->
											<div class="span2 m-wrap">
											<select name="listing_open_status_7" class="span12 m-wrap" onChange="update_open_close('7', this.value);">
											<?php
												$temp_status = $openstatus;
												foreach($temp_status as $k=>$openstatusObj){
													if(strtolower($openstatusObj->openstatus_name_1)==$listingObj->listing_open_7_status){
													?>
                                            		<option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>" selected="selected"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo strtolower($openstatusObj->openstatus_name_1);?>"><?php echo $openstatusObj->openstatus_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : from -->
											<div id="section_7_hourfrom" class="span2 m-wrap" style="display: none;">
											<select name="listing_open_hourfrom_7" class="span12 m-wrap">
											<!-- <option value="">From</option> -->
											<?php						
												$tempHr = $openhour;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_7_start){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
                                            </select>
											</div>
											
											<!-- open hour : to -->
											<div id="section_7_hourto" class="span2 m-wrap" style="display: none;">
											<select name="listing_open_hourto_7" class="span12 m-wrap">
											<!-- <option value="">To</option> -->
                                            <?php						
												$tempHr = $openhour;											
												foreach($openhour as $k=>$openhourObj){
													if($openhourObj->openhour_id==$listingObj->listing_open_7_end){?>
                                            		<option value="<?php echo $openhourObj->openhour_id;?>" selected="selected"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                	<?php }else{?>
                                                    <option value="<?php echo $openhourObj->openhour_id;?>"><?php echo $openhourObj->openhour_name_1; ?></option>
                                                    <?php }?>
                                            <?php }?>
											</select>
											</div>
											
											<script language="javascript">update_open_close('7', '<?php echo $listingObj->listing_open_7_status; ?>');</script>
											
										</div>
									</div>
																											<!--- FORM SECTION - END : BUSINESS HOURS -->
									
									
									
																		<div class="control-group form_field">
										<label class="control-label">Insured <span class="required"></span></label>
										<div class="controls">
											<select name="listing_dropdown1" class="span4 m-wrap">
                                            <?php
												$array = $this->Listingdb->get_insured_list();
												
												foreach($array as $k=>$insuredObj){
												if($listingObj->listing_dropdown1==$insuredObj->dropdown1_id){
											?>
                                            	<option value="<?php echo $insuredObj->dropdown1_id; ?>" selected="selected"><?php echo $insuredObj->dropdown1_name_1; ?></option>
                                            <?php }else{?>
                                            <option value="<?php echo $insuredObj->dropdown1_id; ?>"><?php echo $insuredObj->dropdown1_name_1; ?></option>
                                            <?php }?>
                                            <?php }?>
                                            </select>
										</div>
									</div>
																											<div class="control-group form_field">
										<label class="control-label">Bonded <span class="required"></span></label>
										<div class="controls">
											<select name="listing_dropdown2" class="span4 m-wrap">
											<?php
												$array = $this->Listingdb->get_bonded_list();
												foreach($array as $k=>$bondedObj){
												if($listingObj->listing_dropdown2==$bondedObj->dropdown2_id){
											?>
                                            	<option value="<?php echo $bondedObj->dropdown2_id; ?>" selected="selected"><?php echo $bondedObj->dropdown2_name_1; ?></option>
                                            <?php }else{?>
                                            <option value="<?php echo $bondedObj->dropdown2_id; ?>"><?php echo $bondedObj->dropdown2_name_1; ?></option>
                                            <?php }?>
                                            <?php }?>											
											</select>
										</div>
									</div>																																															
                                    <div class="control-group form_field">
                                        <label class="control-label">
                                            Trade License Num 
                                            
                                            <span class="required">*</span>
                                        </label>
                                        <div class="controls">
                                            <input type="text" name="listing_textbox1_1" value="<?php echo $listingObj->listing_textbox1_1; ?>" data-required="1" class="span6 m-wrap" style="">
                                        </div>
                                    </div>
											
																				
																												
																					
																																																							
																																																																				
											<div class="control-group form_field">
												<label class="control-label">
													Trade License Locale 
													
													<span class="required">*</span>
												</label>
												<div class="controls">
													<input type="text" name="listing_textbox2_1" value="<?php echo $listingObj->listing_textbox2_1; ?>" data-required="1" class="span6 m-wrap" style="">
												</div>
											</div>
											
																				
																												
																					
																																																							
																																																																				
											<div class="control-group form_field">
												<label class="control-label">
													Trade License Authority 
													
													<span class="required">*</span>
												</label>
												<div class="controls">
													<input type="text" name="listing_textbox3_1" value="<?php echo $listingObj->listing_textbox3_1; ?>" data-required="1" class="span6 m-wrap" style="">
												</div>
											</div>
											
																				
																												
																					
																																																							
																																																																				
											<div class="control-group form_field">
												<label class="control-label">
													Trade License Expiration 
													
													<span class="required">*</span>
												</label>
												<div class="controls">
													<input type="text" name="listing_textbox4_1" value="<?php echo $listingObj->listing_textbox4_1; ?>" data-required="1" class="span6 m-wrap" style="">
												</div>
											</div>																																					
																																																																				
											<div class="control-group form_field">
												<label class="control-label">
													Trade License Description 
													
													<span class="required">*</span>
												</label>
												<div class="controls">
													<input type="text" name="listing_textbox5_1" value="<?php echo $listingObj->listing_textbox5_1; ?>" data-required="1" class="span6 m-wrap" style="">
												</div>
											</div>
											
																				
																		
									
									
									
																		<div class="control-group" style="margin-top:50px">
										<label class="control-label"></label>
										<div class="controls">
											<h5 style="font-weight:700">Features or Services or Facilities</h5>
											<div class="row-fluid">
                                                <div class="span3">
                                                    <h6 style="font-weight:700">Payments Accepted</h6>
                                                    
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-1-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_1" value="yes" <?php $chk_status; ?> style="opacity: 0;"></span>
                                                   
                                                    </div>VISA</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                   <?php if(preg_match("/-2-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_2" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>

                                                    </div>Master Card</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-3-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_3" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>AMEX</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-4-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_4" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Cash</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-5-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_5" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Wire Transfer</label>
                                                    <h6 style="font-weight:700">Delivery Services</h6>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-11-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_11" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>50 miles only</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-9-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_9" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Nationwide</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-10-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_10" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Worldwide</label>
                                                </div>
                                                <div class="span3">
                                                    <h6 style="font-weight:700">Service Offered</h6>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-13-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_13" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Free Wi-Fi</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-20-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_20" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Happy Hour</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-12-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_12" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span>
                                                    </div>Kid Friendly</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-14-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_14" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Late Night</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-17-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_17" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Live Music</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-15-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_15" value="yes" style="opacity: 0;"></span></div>Outdoor Seating</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-16-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span><input type="checkbox" name="listing_feature_16" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Romantic</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-19-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_19" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Vegan Friendly</label>
                                                    <label class="checkbox line"><div class="checker" id="uniform-undefined">
                                                    <?php if(preg_match("/-24-/",$listingObj->listing_feature)){$chk_status = "checked";}
													else{$chk_status="";}
													?>
                                                    <span class="<?php echo $chk_status; ?>"><input type="checkbox" name="listing_feature_24" value="yes" <?php echo $chk_status; ?> style="opacity: 0;"></span></div>Waterfront</label>
                                                </div>
                                            </div>
										</div>
									</div>
																		
									
									<div class="space20"></div>
									<div class="space20"></div>																									
											<div class="space20"></div>
											<div class="control-group">
												<label class="control-label">
												Brief / Summary Description  <span class="required">*</span>
												</label>
												<div class="controls">
													<textarea name="listing_descbrief_1" class="span8 m-wrap" rows="6"><?php echo $listingObj->listing_descbrief_1; ?></textarea>
												</div>
											</div>
											
																				
																		
									
									<div class="space20"></div>
									<div class="space20"></div>
											<div class="space20"></div>
											<div class="control-group">
												<label class="control-label">
												Full or Complete Description 
												</label>
												<div class="controls">
													<textarea name="listing_descfull_1" class="span8 ckeditor m-wrap" rows="6" style="visibility: hidden; display: none;"><?php echo $listingObj->listing_descfull_1; ?></textarea><div id="cke_listing_descfull_1" class="cke_1 cke cke_reset cke_chrome cke_editor_listing_descfull_1 cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_listing_descfull_1_arialbl"></div>
												</div>
											</div>
									<div class="form-actions">
										<button type="submit" class="btn black" style="background-color:#800000;"><i class="icon-ok"></i> Save</button>
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
							listing_address:						{ required: true },
							listing_zip:							{ required: true },
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
							listing_descbrief_1:	{ required: true },
							//listing_descfull_1:	{ required: true },
							
							listing_textbox1_1:	{ required: true },
							listing_textbox2_1:	{ required: true },
							listing_textbox3_1:	{ required: true },
							listing_textbox4_1:	{ required: true },
							listing_textbox5_1:	{ required: true },
							
														
														
							
						},
						
						
						// custom messages for radio buttons and checkboxes
						messages: {
							
														
							listing_category_1:						{ required: "Please fill this field." },
							listing_location_1:						{ required: "Please fill this field." },
							listing_address:						{ required: "Please fill this field." },
							listing_zip:							{ required: "Please fill this field." },
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
							listing_descbrief_1:	{ required: "Please fill this field." },
							//listing_descfull_1:	{ required: "Please fill this field." },
							
							listing_textbox1_1:	{ required: "Please fill this field." },
							listing_textbox2_1:	{ required: "Please fill this field." },
							listing_textbox3_1:	{ required: "Please fill this field." },
							listing_textbox4_1:	{ required: "Please fill this field." },
							listing_textbox5_1:	{ required: "Please fill this field." },
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
		});
		CKEDITOR.replace( '', { language: 'en' });
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
						window.location.assign('<?php echo base_url("seller_login"); ?>');
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
						for(var key in data){
						$("#listing_location_"+level).find("select").append('<option value="'+key+'">'+data[key]+'</option>')
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