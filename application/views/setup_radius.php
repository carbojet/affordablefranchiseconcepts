<?php
	$this->load->view("head");
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
	<!--
		
		function confirm_delete_all(page){	
			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){
				window.location = "system_setup_radius_delete_all.php"; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_restore_default(page){	
			if ( confirm("Do you want to restore default data?\n( Current Page : " + page + " )") ){
				window.location = "system_setup_radius_restore_default.php"; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete(id, name){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "system_setup_radius_delete.php?radius=" + id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete_selected(page){	
			if ( confirm("Do you want to delete selected data?\n( Current Page : " + page + " )") ){
				document.form.submit();
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_update_order(page){	
			if ( confirm("Do you want to save the order of data?\n( Current Page : " + page + " )") ){
				document.form.form_action.value = 'update';
				document.form.submit();
				return true;
			} 
			else{ return false; }
		}
		
	-->
	</script>
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
			$sidemenu[2] =array("1"=>"active","2"=>array("1"=>"active","2"=>array("9"=>"active")));
			$data["sidemenu"] =  $sidemenu; 
			$this->load->view("sidebar",$data);
  ?>
  <!-- BEGIN PAGE -->
  <div class="page-content" data-height="860" style="">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
      <div class="row-fluid">
        <div class="span12">
          <!-- BEGIN PAGE TITLE & BREADCRUMB-->
          <h3 class="page-title">Lookup</h3>
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
                  <div class="caption"><i class="icon-cogs"></i> Manage Distance Radius</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn red dropdown-toggle">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("general/setup_radius_add"); ?>"><i class="icon-plus"></i> Add New</a></li>
                        <li><a style="cursor:pointer" onclick="confirm_delete_all('Manage Distance Radius')"><i class="icon-trash"></i> Delete All</a></li>
                        <li><a style="cursor:pointer" onclick="confirm_delete_selected('Manage Distance Radius')"><i class="icon-remove"></i> Delete Selected</a></li>
                        <li><a style="cursor:pointer" onclick="confirm_update_order('Manage Distance Radius')"><i class="icon-edit"></i> Update Order</a></li>
                        <li><a style="cursor:pointer" onclick="confirm_restore_default('Manage Distance Radius')"><i class="icon-refresh"></i> Restore Default</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet-body">
                <?php				
				if(isset($success_msg))
					{?>
                  <div class="alert alert-success" style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                    <font style="font-weight:bold">
                    <h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
                    <div style="min-height:31px; vertical-align:middle;"> <?php echo $success_msg; ?> </div>
                    </font> </div>
                  <?php } ?>
                  <form action="system_setup_radius_update.php" method="post" name="form">
                    <input type="hidden" value="delete" name="form_action">
                    <table id="sample_1" class="table table-bordered table-advance table-hover">
                      <thead>
                        <tr>
                          <th style="width:8px;"><div class="checker" id="uniform-undefined"><span>
                              <input type="checkbox" data-set="#sample_1 .checkboxes" class="group-checkable" style="opacity: 0;">
                              </span></div></th>
                          <th class="span7">Value</th>
                          <th style="text-align:right" class="span3">Value</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php if(count($radius_list)>0){ foreach($radius_list as $k=>$radiusObj){ ?>
                        	<tr>
                          <td style="padding-top:8px"><div class="checker" id="uniform-undefined"><span>
                              <input type="checkbox" value="yes" class="checkboxes" name="radius_status_delete_1" style="opacity: 0;">
                              </span></div></td>
                          <td style="padding-right:20px"><h5 style="font-weight:700; margin:0"><?php echo $radiusObj->radius_name_1; ?></h5>
                            <div class="btn-group"> <a href="#" data-toggle="dropdown" class="btn mini yellow dropdown-toggle">Edit <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("general/setup_radius_edit/".$radiusObj->radius_id); ?>"><i class="icon-edit"></i> Edit</a></li>
                                <li><a style="cursor:pointer" onclick="confirm_delete('<?php echo $radiusObj->radius_id; ?>','<?php echo $radiusObj->radius_name_1; ?>')"><i class="icon-trash"></i> Delete</a></li>
                              </ul>
                            </div></td>
                          <td style="text-align:right"><input type="text" style="" class="span3 m-wrap" data-required="1" value="<?php echo $radiusObj->radius_name_1; ?>" name="radius_status_value_1">
                          </td>
                        </tr>                        
                        <?php }} ?>
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
            <div style="float:right;"> <a class="btn mini yellow" style="cursor:pointer; width:100px; margin-bottom:7px; text-align:left" onclick="confirm_update_order('Manage Distance Radius')"><i class="icon-edit"></i> Update Order</a><br>
              <a class="btn mini red" style="cursor:pointer; width:100px; margin-bottom:7px; text-align:left" onclick="confirm_delete_selected('Manage Distance Radius')"><i class="icon-remove"></i> Delete Selected</a> </div>
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
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
<script src="<?php echo base_url("theme");?>/scripts/form-components.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
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
<script type="text/javascript">
	
		function confirm_delete_all(page){	
			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){
				window.location = "system_setup_discount_delete_all.php"; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_restore_default(page){	
			if ( confirm("Do you want to restore default data?\n( Current Page : " + page + " )") ){
				window.location = "system_setup_discount_restore_default.php"; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete(id, name){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url()."general/delete_setup_radius/"; ?>" + id; 
				return true;
			} 
			else{ return false; }
		}
		
		function confirm_delete_selected(page){	
			if ( confirm("Do you want to delete selected data?\n( Current Page : " + page + " )") ){
				document.form.form_action.value = 'update';
				document.form.submit();
				return true;
			} 
			else{ return false; }
		}
		
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
</body>
<!-- END BODY -->
</html>