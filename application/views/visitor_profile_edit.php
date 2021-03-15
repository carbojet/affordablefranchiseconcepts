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
			$sidemenu[2] =array("1"=>"active");
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
								<form name="form" id="form" action="<?php echo base_url("visitor/update_visitor_profile/");?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
								<input type="hidden" name="visitor_id" value="<?php echo $visitorObj->visitor_id;?>">
																		
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
									
									
									
									
									<input type="hidden" name="visitor_language" value="1">
																			
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
											<select name="visitor_title" class="m-wrap span2">
																						<option value="1" selected="">Mr. </option>
																						<option value="2">Mrs. </option>
																						<option value="3">Ms. </option>
																						</select>
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">First Name <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_firstname" value="<?php echo $visitorObj->visitor_firstname;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Last Name <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_lastname" value="<?php echo $visitorObj->visitor_lastname;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Phone Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="visitor_phone" value="<?php echo $visitorObj->visitor_phone;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Mobile Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="visitor_mobile" value="<?php echo $visitorObj->visitor_mobile;?>" data-required="1" class="span4 m-wrap" style="">

										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Fax Number <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="visitor_fax" value="<?php echo $visitorObj->visitor_fax;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Email <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_email" value="<?php echo $visitorObj->visitor_email;?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Website URL <span class="required"></span></label>
										<div class="controls">
											<input type="text" name="visitor_website" value="<?php echo $visitorObj->visitor_website;?>" data-required="1" class="span6 m-wrap" style="">
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
											<input type="text" name="visitor_address" value="<?php echo $visitorObj->visitor_address;?>" data-required="1" class="span6 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label"></label>
										<div class="controls">
											<input type="text" name="visitor_address2" value="<?php echo $visitorObj->visitor_address2;?>" data-required="1" class="span6 m-wrap" style="">
											
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">City / Town <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_city" value="<?php echo $visitorObj->visitor_city;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">State / Province <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_province" value="<?php echo $visitorObj->visitor_province;?>" data-required="1" class="span4 m-wrap" style="">
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">ZIP / Post Code <span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="visitor_zip" value="<?php echo $visitorObj->visitor_zip;?>" data-required="1" class="span4 m-wrap" style="">
											
										</div>
									</div>
									<div class="control-group form_field">
										<label class="control-label">Country <span class="required">*</span></label>
										<div class="controls">
											
											<select name="visitor_country" class="m-wrap span6">
																						<option value="252" selected="">United States</option>
																						<option value="2">Albania</option>
																						<option value="3">Algeria</option>
																						<option value="4">American Samoa</option>
																						<option value="5">Andorra</option>
																						<option value="6">Angola</option>
																						<option value="7">Anguilla</option>
																						<option value="8">Antarctica</option>
																						<option value="9">Antigua and Barbuda</option>
																						<option value="10">Arctic Ocean</option>
																						<option value="11">Argentina</option>
																						<option value="12">Armenia</option>
																						<option value="13">Aruba</option>
																						<option value="14">Ashmore and Cartier Islands</option>
																						<option value="15">Atlantic Ocean</option>
																						<option value="16">Australia</option>
																						<option value="17">Austria</option>
																						<option value="18">Azerbaijan</option>
																						<option value="19">Bahamas</option>
																						<option value="20">Bahrain</option>
																						<option value="21">Baker Island</option>
																						<option value="22">Bangladesh</option>
																						<option value="23">Barbados</option>
																						<option value="24">Bassas da India</option>
																						<option value="25">Belarus</option>
																						<option value="26">Belgium</option>
																						<option value="27">Belize</option>
																						<option value="28">Benin</option>
																						<option value="29">Bermuda</option>
																						<option value="30">Bhutan</option>
																						<option value="31">Bolivia</option>
																						<option value="32">Bosnia and Herzegovina</option>
																						<option value="33">Botswana</option>
																						<option value="34">Bouvet Island</option>
																						<option value="35">Brazil</option>
																						<option value="36">British Indian Ocean Territory</option>
																						<option value="37">British Virgin Islands</option>
																						<option value="38">Brunei</option>
																						<option value="39">Bulgaria</option>
																						<option value="40">Burkina Faso</option>
																						<option value="41">Burma</option>
																						<option value="42">Burundi</option>
																						<option value="43">Cambodia</option>
																						<option value="44">Cameroon</option>
																						<option value="45">Canada</option>
																						<option value="46">Cape Verde</option>
																						<option value="47">Cayman Islands</option>
																						<option value="48">Central African Republic</option>
																						<option value="49">Chad</option>
																						<option value="50">Chile</option>
																						<option value="51">China</option>
																						<option value="52">Christmas Island</option>
																						<option value="53">Clipperton Island</option>
																						<option value="54">Cocos (Keeling) Islands</option>
																						<option value="55">Colombia</option>
																						<option value="56">Comoros</option>
																						<option value="57">Congo, Democratic Republic</option>
																						<option value="58">Congo, Republic</option>
																						<option value="59">Cook Islands</option>
																						<option value="60">Coral Sea Islands</option>
																						<option value="61">Costa Rica</option>
																						<option value="62">Cote d'Ivoire</option>
																						<option value="63">Croatia</option>
																						<option value="64">Cuba</option>
																						<option value="65">Cyprus</option>
																						<option value="66">Czech Republic</option>
																						<option value="67">Denmark</option>
																						<option value="68">Djibouti</option>
																						<option value="69">Dominica</option>
																						<option value="70">Dominican Republic</option>
																						<option value="71">Ecuador</option>
																						<option value="72">Egypt</option>
																						<option value="73">El Salvador</option>
																						<option value="74">Equatorial Guinea</option>
																						<option value="75">Eritrea</option>
																						<option value="76">Estonia</option>
																						<option value="77">Ethiopia</option>
																						<option value="78">Europa Island</option>
																						<option value="79">Falkland Islands (Islas Malvinas)</option>
																						<option value="80">Faroe Islands</option>
																						<option value="81">Fiji</option>
																						<option value="82">Finland</option>
																						<option value="83">France</option>
																						<option value="84">French Guiana</option>
																						<option value="85">French Polynesia</option>
																						<option value="86">French Southern and Antarctic Lands</option>
																						<option value="87">Gabon</option>
																						<option value="88">Gambia</option>
																						<option value="89">Gaza Strip</option>
																						<option value="90">Georgia</option>
																						<option value="91">Germany</option>
																						<option value="92">Ghana</option>
																						<option value="93">Gibraltar</option>
																						<option value="94">Glorioso Islands</option>
																						<option value="95">Greece</option>
																						<option value="96">Greenland</option>
																						<option value="97">Grenada</option>
																						<option value="98">Guadeloupe</option>
																						<option value="99">Guam</option>
																						<option value="100">Guatemala</option>
																						<option value="101">Guernsey</option>
																						<option value="102">Guinea</option>
																						<option value="103">Guinea-Bissau</option>
																						<option value="104">Guyana</option>
																						<option value="105">Haiti</option>
																						<option value="106">Heard Island and McDonald Islands</option>
																						<option value="107">Holy See (Vatican City)</option>
																						<option value="108">Honduras</option>
																						<option value="109">Hong Kong</option>
																						<option value="110">Howland Island</option>
																						<option value="111">Hungary</option>
																						<option value="112">Iceland</option>
																						<option value="113">India</option>
																						<option value="114">Indian Ocean</option>
																						<option value="115">Indonesia</option>
																						<option value="116">Iran</option>
																						<option value="117">Iraq</option>
																						<option value="118">Ireland</option>
																						<option value="119">Israel</option>
																						<option value="120">Italy</option>
																						<option value="121">Jamaica</option>
																						<option value="122">Jan Mayen</option>
																						<option value="123">Japan</option>
																						<option value="124">Jarvis Island</option>
																						<option value="125">Jersey</option>
																						<option value="126">Johnston Atoll</option>
																						<option value="127">Jordan</option>
																						<option value="128">Juan de Nova Island</option>
																						<option value="129">Kazakhstan</option>
																						<option value="130">Kenya</option>
																						<option value="131">Kingman Reef</option>
																						<option value="132">Kiribati</option>
																						<option value="135">Kuwait</option>
																						<option value="136">Kyrgyzstan</option>
																						<option value="137">Laos</option>
																						<option value="138">Latvia</option>
																						<option value="139">Lebanon</option>
																						<option value="140">Lesotho</option>
																						<option value="141">Liberia</option>
																						<option value="142">Libya</option>
																						<option value="143">Liechtenstein</option>
																						<option value="144">Lithuania</option>
																						<option value="145">Luxembourg</option>
																						<option value="146">Macau</option>
																						<option value="147">Macedonia</option>
																						<option value="148">Madagascar</option>
																						<option value="149">Malawi</option>
																						<option value="150">Malaysia</option>
																						<option value="151">Maldives</option>
																						<option value="152">Mali</option>
																						<option value="153">Malta</option>
																						<option value="154">Man, Isle of</option>
																						<option value="155">Marshall Islands</option>
																						<option value="156">Martinique</option>
																						<option value="157">Mauritania</option>
																						<option value="158">Mauritius</option>
																						<option value="159">Mayotte</option>
																						<option value="160">Mexico</option>
																						<option value="161">Micronesia</option>
																						<option value="162">Midway Islands</option>
																						<option value="163">Moldova</option>
																						<option value="164">Monaco</option>
																						<option value="165">Mongolia</option>
																						<option value="166">Montserrat</option>
																						<option value="167">Morocco</option>
																						<option value="168">Mozambique</option>
																						<option value="169">Namibia</option>
																						<option value="170">Nauru</option>
																						<option value="171">Navassa Island</option>
																						<option value="172">Nepal</option>
																						<option value="173">Netherlands</option>
																						<option value="174">Netherlands Antilles</option>
																						<option value="175">New Caledonia</option>
																						<option value="176">New Zealand</option>
																						<option value="177">Nicaragua</option>
																						<option value="178">Niger</option>
																						<option value="179">Nigeria</option>
																						<option value="180">Niue</option>
																						<option value="181">Norfolk Island</option>
																						<option value="133">North Korea</option>
																						<option value="182">Northern Mariana Islands</option>
																						<option value="183">Norway</option>
																						<option value="184">Oman</option>
																						<option value="185">Pacific Ocean</option>
																						<option value="186">Pakistan</option>
																						<option value="187">Palau</option>
																						<option value="188">Palmyra Atoll</option>
																						<option value="189">Panama</option>
																						<option value="190">Papua New Guinea</option>
																						<option value="191">Paracel Islands</option>
																						<option value="192">Paraguay</option>
																						<option value="193">Peru</option>
																						<option value="194">Philippines</option>
																						<option value="195">Pitcairn Islands</option>
																						<option value="196">Poland</option>
																						<option value="197">Portugal</option>
																						<option value="198">Puerto Rico</option>
																						<option value="199">Qatar</option>
																						<option value="200">Reunion</option>
																						<option value="201">Romania</option>
																						<option value="202">Russia</option>
																						<option value="203">Rwanda</option>
																						<option value="204">Saint Helena</option>
																						<option value="205">Saint Kitts and Nevis</option>
																						<option value="206">Saint Lucia</option>
																						<option value="207">Saint Pierre and Miquelon</option>
																						<option value="208">Saint Vincent and the Grenadines</option>
																						<option value="209">Samoa</option>
																						<option value="210">San Marino</option>
																						<option value="211">Sao Tome and Principe</option>
																						<option value="212">Saudi Arabia</option>
																						<option value="213">Senegal</option>
																						<option value="214">Seychelles</option>
																						<option value="215">Sierra Leone</option>
																						<option value="216">Singapore</option>
																						<option value="217">Slovakia</option>
																						<option value="218">Slovenia</option>
																						<option value="219">Solomon Islands</option>
																						<option value="220">Somalia</option>
																						<option value="221">South Africa</option>
																						<option value="222">South Georgia and the South Sandwich Islands</option>
																						<option value="134">South Korea</option>
																						<option value="223">Southern Ocean</option>
																						<option value="224">Spain</option>
																						<option value="225">Spratly Islands</option>
																						<option value="226">Sri Lanka</option>
																						<option value="227">Sudan</option>
																						<option value="228">Suriname</option>
																						<option value="229">Svalbard</option>
																						<option value="230">Swaziland</option>
																						<option value="231">Sweden</option>
																						<option value="232">Switzerland</option>
																						<option value="233">Syria</option>
																						<option value="234">Taiwan</option>
																						<option value="235">Tajikistan</option>
																						<option value="236">Tanzania</option>
																						<option value="237">Thailand</option>
																						<option value="238">Togo</option>
																						<option value="239">Tokelau</option>
																						<option value="240">Tonga</option>
																						<option value="241">Trinidad and Tobago</option>
																						<option value="242">Tromelin Island</option>
																						<option value="243">Tunisia</option>
																						<option value="244">Turkey</option>
																						<option value="245">Turkmenistan</option>
																						<option value="246">Turks and Caicos Islands</option>
																						<option value="247">Tuvalu</option>
																						<option value="248">Uganda</option>
																						<option value="249">Ukraine</option>
																						<option value="250">United Arab Emirates</option>
																						<option value="251">United Kingdom</option>
																						<option value="253">Uruguay</option>
																						<option value="254">Uzbekistan</option>
																						<option value="255">Vanuatu</option>
																						<option value="256">Venezuela</option>
																						<option value="257">Vietnam</option>
																						<option value="258">Virgin Islands</option>
																						<option value="259">Wake Island</option>
																						<option value="260">Wallis and Futuna</option>
																						<option value="261">West Bank</option>
																						<option value="262">Western Sahara</option>
																						<option value="263">World</option>
																						<option value="264">Yemen</option>
																						<option value="265">Yugoslavia</option>
																						<option value="266">Zambia</option>
																						</select>
											<input type="hidden" name="required_visitor_country" value="text">
											
										</div>
									</div>
									<div class="space20"></div>
									
									
									
									<div class="control-group form_field">
										<label class="control-label">Upload your photo or picture</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="fileupload-new thumbnail">
												<?php
													$url = base_url()."visitor_cache/".$visitorObj->visitor_id.".jpg";
													$url = get_headers($url, 1);
													if(!preg_match("/404/",$url[0]))
													{
												?>
                                                <img src="<?php echo base_url(); ?>visitor_cache/<?php echo $visitorObj->visitor_id; ?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
												<?php }else{?>
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">	
											<?php	}
												?>
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Select File</span>
													<span class="fileupload-exists">Change</span>
													<input name="visitor_photo" type="file" class="default"></span>
													<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
												</div>
												<div style="margin-top:10px">
													<span class="label label-important">Note :</span>
													<span style="font-weight:normal">Please only upload JPG or JPEG file only ...</span>
												</div>
											</div>
										</div>
									</div>
									
									
									<div class="form-actions">
										<button type="submit" class="btn black" style="background-color:#254117;"><i class="icon-ok"></i> Save</button>
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