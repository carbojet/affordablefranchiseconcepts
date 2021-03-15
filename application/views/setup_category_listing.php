<?php
	$this->load->view("head");
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
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

			$sidemenu[2] =array("1"=>"active","3"=>array("1"=>"active","2"=>array("3"=>"active")));

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
                  <div class="caption"> <i class="icon-cogs"></i> Manage Listing Category Values </div>
                  <div class="actions">
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn red dropdown-toggle">Options <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <!--<li><a href="<?php echo base_url("general/setup_category_listing_add"); ?>"><i class="icon-plus"></i> Add New</a></li>-->
                        <li><a href="#" onClick="confirm_delete_all();"><i class="icon-trash"></i> Delete All</a></li>
                        <!--<li><a style="cursor:pointer" onClick="confirm_delete_selected('Manage Listing Category Values')"><i class="icon-remove"></i> Delete Selected</a></li>
                        <li><a style="cursor:pointer" onClick="confirm_update_order('Manage Listing Category Values')"><i class="icon-edit"></i> Update</a></li>-->
                        
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
                  <ul style="margin-bottom:5px;" class="breadcrumb">
                    <li> <i class="icon-globe"></i> <a href="<?php echo base_url("general/setup_category_listing"); ?>">Category</a> </li>
                  </ul>
                  <form action="system_setup_category_listing_update.php" method="post" name="form">
                    <table id="sample_1" class="table table-bordered table-advance table-hover">
                      <thead>
                        <tr>
                          <th class="span6">Details</th>
                          <th width="150" class="hidden-480">Industry</th>
                          <th width="150" style="text-align:center" class="hidden-480">Listings</th>
                          <th style="text-align:right" class="span3">Popular</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($category_listing_list)>0){ foreach($category_listing_list as $k=>$category_listingObj){ ?>
                        <tr>
                          <td style="padding-right:20px"><a href="<?php echo base_url("general/setup_category_listing/".$category_listingObj->category_id); ?>">
                            <h5 style="font-weight:700; margin:0"><?php echo $category_listingObj->category_name_1; ?></h5>
                            </a> Category # <?php echo $category_listingObj->category_id; ?> <br>
                            <div class="btn-group"> <a href="#" data-toggle="dropdown" class="btn mini yellow dropdown-toggle">Edit <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("general/setup_category_listing_edit/".$category_listingObj->category_id); ?>"><i class="icon-edit"></i> Edit</a></li>                                
                              </ul>
                            </div></td>
                          <td style="vertical-align:middle" class="hidden-480"><?php
						  	$sectorArray = $this->Generaldb->select_setup_sector_listing(array("category_id"=>$category_listingObj->category_parent));
							foreach($sectorArray as $sectorObj){echo $sectorObj->category_name_1;}
							
							
						  ?>
                            <?php //echo $category_listingObj->category_name_1; ?>
                          </td>
                          <td style="text-align:center; vertical-align:middle" class="hidden-480"><?php echo $this->Generaldb->setup_listings_category_count($category_listingObj->category_id); ?></td>
                          <td style="text-align:right; vertical-align:middle">
                          <div class="control-group">
                            <div class="controls">
                              <div class="basic-toggle-button toggle-button" style="width: 100px; height: 25px;">
                              <?php if($category_listingObj->category_stat_listing){ $left = "0%";$checked = 'checked="checked"';}else{$left = "-50%";$checked = '';} ?>
                                <div style="left: <?php echo $left; ?>; width: 150px;">
                                  <input type="checkbox" class="toggle" value="<?php echo $category_listingObj->category_stat_listing; ?>" name="category_stat_listing_<?php echo $category_listingObj->category_id; ?>" <?php echo $checked;?> >
                                  <input type="hidden" name="category_id" value="<?php echo $category_listingObj->category_id; ?>">
                                  <span class="labelLeft" style="width: 50px; height: 25px; line-height: 25px;">ON</span>
                                  <label style="width: 50px; height: 25px;"></label>
                                  <span class="labelRight" style="width: 50px; height: 25px; line-height: 25px;">OFF </span></div>
                              </div>
                            </div>
                          </div>
                          </td>
                        </tr>
                        <?php }}else{ ?>
                        <tr>
                          <td style="vertical-align:middle" colspan="3"> There are no data found ... </td>
                        </tr>
                        <?php } ?>
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
          <!-- navigation here -->
          <div style="padding-bottom:50px">
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                <!--<form action="system_paging_navigation.php" dir="ltr">

									<input type="hidden" name="navigation_url" value="listing.php">

									<input type="hidden" name="navigation_pageitem" value="">

									<input type="hidden" name="navigation_total" value="20">

									<input type="hidden" name="navigation_values" value="">-->
                <span class="help-inline">Page 	&nbsp; </span>
                <form>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["startpage"]; ?>" />
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">
                <div dir="ltr">
                  <?php if(empty($category_listingObj->category_parent)){ 

									$category_parent = 0;}else{ $category_parent = $category_listingObj->category_parent; }

									?>
                  <a href="<?php echo base_url("general/category_listing_pre_page/".$category_parent."/".$pagination["startpage"]); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="<?php echo base_url("general/category_listing_nxt_page/".$category_parent."/".$pagination["startpage"]); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
              </div>
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
			jQuery("body").on("keypress","input[name=navigation_page]",function(e){
				e.prevenDefault();				
			})
			jQuery("body").on("keyup","input[name=navigation_page]",function(e){
				if(e.keyCode == 13)
				{				
					currntpage = jQuery("input[name=currentpage]").val();
					pagenum = jQuery(this).val();
					if(pagenum >= 1){
						pagenum -= 1;
					}
					if(currntpage <= pagenum){					
						window.location = "<?php echo base_url("general/category_listing_nxt_page/0"); ?>"+"/"+pagenum;
					}else{
						window.location = "<?php echo base_url("general/category_listing_pre_page/0"); ?>"+"/"+pagenum;
					}				
				}
			})

			App.init();

			TableManaged.init();

		});

		

	</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">

	

		function confirm_delete_all(){	

			if ( confirm("Do you want to delete all data?") ){

				window.location = "<?php echo base_url()."general/delete_all_category/"; ?>"; 

				return true;

			} 

			else{ return false; }

		}
		

		function confirm_delete(id, name){	

			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){

				window.location = "<?php echo base_url()."general/delete_setup_category_listing/"; ?>" + id; 

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
<script>

		jQuery(document).ready(function() {       

			// initiate layout and plugins


			//FormComponents.init();

			//working with check box animation

			jQuery("body").on("click",".basic-toggle-button",function(){			

			var checked = jQuery(this).find(".toggle");

			var chkval = jQuery(this).find(".toggleval");
			var category_id = jQuery(this).find("input[name=category_id]").val();
			
				if(checked.is(":checked")==true && checked.attr("disabled")!="disabled")

				{

					jQuery(this).children("div").animate({left:"-=50%"},100);

					checked.attr("checked",false);

					chkval.val("0");		
					
					jQuery.fn.ajaxCategory_stat(0,category_id);
					
								

				}

				else if(checked.is(":checked")==false && checked.attr("disabled")!="disabled")

				{					

					jQuery(this).children("div").animate({left:"+=50%"},100);

					checked.attr("checked",true);

					chkval.val("1");
					jQuery.fn.ajaxCategory_stat(1,category_id);

				}				

			})
			
			jQuery.fn.ajaxCategory_stat = function(val,category_id)

			{

			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("general/ajaxCategory_stat"); ?>'+'/'+val+'/'+category_id,

				ContentType : 'application/json',

				success:function(data){						


				}

			});

		}

		});
		
		

	</script>
</body>
<!-- END BODY -->
</html>