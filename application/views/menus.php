<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<style>
@media (min-width: 1200px) {
 .location {
margin-left:10px !important;
}
 .zip {
margin-left:170px !important;
}
}
</style>
</head><!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php

		$this->load->view("menu");

	?>
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
  <?php

    $sidemenu[9] =array("1"=>"active","2"=>array("2"=>"active"));
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
          <h3 class="page-title">Menus</h3>
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
                  <div class="caption"><i class="icon-list"></i> Manage Menus</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("pages/newmenu/"); ?>"><i class="icon-plus"></i> Add New </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet-body">
                  <?php
					if(isset($success_msg)){?>
                  <div class="alert alert-success " style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"><span></span></button>
                    <font style="font-weight:bold">
                    <h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
                    <div style="min-height:31px; vertical-align:middle;"> <?php echo $success_msg; ?> </div>
                    </font> </div>
                  <?php } ?>
                  <form name="listing-form" method="post" action="<?php echo base_url("listing/delete_selected_listing");?>" enctype="multipart/form-data">
                    <table class="table table-bordered table-advance table-hover" id="sample_1">
                      <thead>
                        <tr>
                          <th style="width:8px;"><div class="checker" id="uniform-undefined"><span class="">
                              <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" style="opacity: 0;">
                              </span></div></th>
                          <th class="span10">Title</th>
                          <th class="span2">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($menus)){
                          foreach($menus as $k=>$menu){                            
                            ?>
                        <tr>
                          <td style="padding-top:8px">
                            <div class="checker" id="uniform-undefined">
                              <span class="">
                                <input name="page_status_delete[]" type="checkbox" class="checkboxes" value="<?php echo $menu->term_taxonomy_id; ?>" style="opacity: 0;">
                              </span>
                            </div>
                          </td>
                          <td style="text-align:left; vertical-align:baseline; padding:10px;">
                            <h5 style="font-weight:700; margin:0;"><?php echo $menu->name; ?></h5>
                            <!-- property links -->
                            <div class="btn-group"> <a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("pages/menuedit/".$menu->term_taxonomy_id."/".$pagination["currentpage"]);?>"><i class="icon-edit"></i> Edit </a></li>
                              </ul>
                            </div>
                          </td>
                          <td style="padding-right:20px; vertical-align:middle;">                          
                              <!-- details -->
                              <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                <div class="span12">
                                  <div class="td_label">Menus</div>
                                  <div class="td_value"><?php echo $menu->count; ?></div>
                                  <div class="td_clear"></div>
                                </div>
                                <div class="clearfix"></div>
                              </div> 
                          </td>                          
                        </tr>
                        <?php
                        
                       }
                        
                      }else{ echo "Record Not Found!";}?>
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
<div class="footer" style="text-align:center; background-color:#1B2E44;"> <a href="http://www.affordablebusinessconcepts.com/" style="color:#FC0; background-color:#1b2e44">&copy; Affordable Busindess Concepts LLC</a>
  <div class="span pull-right"> <span class="go-top" style="background-color: #FFC000;"><i class="icon-angle-up"></i></span> </div>
</div>
<!-- END FOOTER -->
<!-- END FOOTER -->
<?php
	$this->load->view("foot");
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="gui/ltr/scripts/app.js"></script>
<script>

	

		var TableManaged = function () {

			return {

		

				//main function to initiate the module

				init: function () {

					

					if (!jQuery().dataTable) { return; }

					

					jQuery('#sample_1 .group-checkable').change(function () {

						var set = jQuery(this).attr("data-set");

						var checked = jQuery(this).is(":checked");

						if (checked) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

						jQuery(set).each(function () {

							if (checked) { $(this).attr("checked", true);$(this).parent().addClass("checked"); } 

							else { $(this).attr("checked", false); $(this).parent().removeClass("checked");}

						});

						jQuery.uniform.update(set);

					});

					jQuery('#sample_1 .checkboxes').change(function(){

						if (jQuery(this).is(":checked")) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

					});					

				}

			};

		}();	
		jQuery(document).ready(function() {       

			
			// initiate layout and plugins

			App.init();

			TableManaged.init();

		});

		

	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>