<?php
	$this->load->view("head");
?>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
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
	
	<script type="text/javascript">
	<!--
	function confirm_restore_default(page){	
		if ( confirm("Do you want to restore default data?\n( Current Page : " + page + " )") ){
		
			window.location = "system_setup_email_restore_default.php"; 
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
			$sidemenu[1] =array("1"=>"active","2"=>array("8"=>"active"));
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
						<h3 class="page-title">Website Setup</h3>
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
										<div class="caption"><i class="icon-money"></i>Payment Preferences</div>
									</div>
									<div class="portlet-body">
										<form name="form" method="post" action="<?php echo base_url("sitesetup/update_all_payment_preference/");?>">
										<table class="table table-bordered table-advance table-hover" id="sample_1">
										<thead>
										<tr>
											<th class="span7">Payment Method</th>
											<th class="span3"></th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach($payment_preference_list as $payment_preferenceObj){?>
                                            <tr>
                                                <td style="vertical-align:middle; padding-top:13px">
                                                    <h5 style="font-weight:700; margin:0; padding-bottom:0"><?php echo $payment_preferenceObj->payment_name;?></h5>
                                                    <?php if(!empty($payment_preferenceObj->payment_url)){?>
                                                    <a class="btn mini yellow" href="<?php echo base_url("sitesetup/".$payment_preferenceObj->payment_url."/".$payment_preferenceObj->payment_id);?>"> Edit</a>
                                                    <?php }?>                                              
                                                </td>
                                                <td style="text-align:right; vertical-align:middle">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="basic-toggle-button toggle-button" style="width: 100px; height: 25px;">
                                                            	<?php
														if($payment_preferenceObj->payment_status=="yes"){?>
														<div style="left: 0px; width: 150px;">
                                                        	<input type="hidden" name="payment_id[]" value="<?php echo $payment_preferenceObj->payment_id; ?>">
                                                            <input type="hidden" name="payment_status_val[]" value="<?php echo $payment_preferenceObj->payment_status; ?>" class="toggleval">
                                                        	<input name="payment_status[]" value="<?php echo $payment_preferenceObj->payment_status;?>" type="checkbox" class="toggle" checked="checked" >
                                                            <span class="labelLeft" style="width: 50px; height: 25px; line-height: 25px;">ON</span><label style="width: 50px; height: 25px;"></label>
                                                            <span class="labelRight" style="width: 50px; height: 25px; line-height: 25px;">OFF </span>
                                                        </div>
													<?php }else{?>
														<div style="left: -50%; width: 150px;">
                                                        	<input type="hidden" name="payment_id[]" value="<?php echo $payment_preferenceObj->payment_id; ?>">
                                                            <input type="hidden" name="payment_status_val[]" value="<?php echo $payment_preferenceObj->payment_status; ?>" class="toggleval">
                                                        	<input name="payment_status[]" value="<?php echo $payment_preferenceObj->payment_status;?>" type="checkbox" class="toggle">
                                                            <span class="labelLeft" style="width: 50px; height: 25px; line-height: 25px;">ON</span><label style="width: 50px; height: 25px;"></label>
                                                            <span class="labelRight" style="width: 50px; height: 25px; line-height: 25px;">OFF </span>
                                                        </div>
													<?php }?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
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
						<div style="padding-bottom:50px">
							<div style="float:right">
								<a onClick="document.form.submit()" class="btn black"><i class="icon-ok"></i> Update</a>
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
	<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
	<script src="<?php echo base_url("theme");?>/scripts/form-components.js"></script>     
	
	<script>
		jQuery(document).ready(function() {       
			// initiate layout and plugins
			App.init();
			//FormComponents.init();
			//working with check box animation
			jQuery("body").on("click",".basic-toggle-button",function(){			
			var checked = jQuery(this).find(".toggle");
			var chkval = jQuery(this).find(".toggleval");
				if(checked.is(":checked")==true && checked.attr("disabled")!="disabled")
				{
					jQuery(this).children("div").animate({left:"-=50%"},100);
					checked.attr("checked",false);
					chkval.val("no");					
				}
				else if(checked.is(":checked")==false && checked.attr("disabled")!="disabled")
				{					
					jQuery(this).children("div").animate({left:"+=50%"},100);
					checked.attr("checked",true);
					chkval.val("yes");
				}				
			})
		});
	</script>
	
	<!-- END JAVASCRIPTS -->	
</body>
<!-- END BODY -->
</html>