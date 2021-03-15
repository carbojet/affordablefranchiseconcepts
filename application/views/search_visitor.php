<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
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

			$sidemenu[7] =array("1"=>"active","2"=>array("2"=>"active"));

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
      <div class="row-fluid inbox">
        <div class="span12">
          <div class="portlet box grey" style="border-color:#7D1B7E;">
            <div class="portlet-title" style="background-color:#7D1B7E;">
              <div class="caption"><i class="icon-search"></i> Search Visitors</div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url("visitor/search_visitor/");?>" class="form-horizontal" method="post">
                <div class="alert alert-error hide" style="margin:10px 0 10px 0">
                  <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                  <font style="font-weight:bold">
                  <h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3>
                  <div style="min-height:31px; vertical-align:middle;"> Please fill the following form completely. <br>
                    Fields marked  * are required ... </div>
                  </font> </div>
                <div class="alert alert-success hide" style="margin:10px 0 10px 0">
                  <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                  <font style="font-weight:bold">
                  <h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
                  <div style="min-height:31px; vertical-align:middle;"> Your changes have been successfully saved. </div>
                  </font> </div>
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="control-group span5">
                  <label class="control-label">First Name </label>
                  <div class="controls">
                    <input type="text" name="visitor_firstname" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Last Name </label>
                  <div class="controls">
                    <input type="text" name="visitor_lastname" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Email </label>
                  <div class="controls">
                    <input type="text" name="visitor_email" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Phone </label>
                  <div class="controls">
                    <input type="text" name="visitor_phone" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div style="clear:both"></div>
                <div class="form-actions">
                  <button type="submit" class="btn black" style="background-color:#7D1B7E;"><i class="icon-search"></i> Search</button>
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

		

		jQuery(document).ready(function() {

			// initiate layout and plugins

			App.init();

			FormComponents.init();

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