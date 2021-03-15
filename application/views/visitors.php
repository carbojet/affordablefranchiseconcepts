<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">

	<!--

	

		function confirm_delete(id, name, page){	

			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){

				window.location = "<?php echo base_url("visitor/delete_visitor/");?>"+"/"+id+"/"+page; 

				return true;

			} 

			else{ return false; }

		}		

		

		

		function confirm_delete_all(page){	

			if ( confirm("Do you want to delete all data?\n( Current Page : " + page + " )") ){

				window.location = "<?php echo base_url();?>"; 

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
          <!--BEGIN TABS-->
          <div class="row-fluid">
            <div class="span12">
              <!-- BEGIN PORTLET-->
              <div class="portlet">
                <div class="portlet-title">
                  <div class="caption"><i class="icon-user"></i> Manage Visitors</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Options <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <?php /*?><li><a href="<?php echo base_url("visitor/add_visitor/");?>"><i class="icon-plus"></i> Add New </a></li><?php */?>
                        <li><a style="cursor:pointer" class="delete_selected"><i class="icon-trash"></i> Delete Selected </a></li>
                        <li><a href="<?php echo base_url("visitor/search_visitor");?>"><i class="icon-search"></i> Search </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet-body">
                  <form name="visitor-form" method="post" action="<?php echo base_url("visitor/delete_selected_visitor");?>" enctype="multipart/form-data">
                    <table class="table table-bordered table-advance table-hover" id="sample_1">
                      <thead>
                        <tr>
                          <th style="width:8px;"><div class="checker" id="uniform-undefined"><span class="">
                              <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" style="opacity: 0;">
                              </span></div></th>
                          <th class="span8">Detailed Info</th>
                          <!--<th class="span4" style="text-align:right">Photo</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($visitor_list)>0){foreach($visitor_list as $visitorObj){?>
                        <tr>
                          <td style="padding-top:8px"><div class="checker" id="uniform-undefined"><span class="">
                              <input name="visitor_status_delete[]" type="checkbox" class="checkboxes" value="<?php echo $visitorObj->visitor_id; ?>" style="opacity: 0;">
                              </span></div></td>
                          <td style="padding-right:20px; vertical-align:middle"><h5 style="font-weight:700; margin:0;"> <?php echo $visitorObj->visitor_firstname." ".$visitorObj->visitor_lastname;?> </h5>
                            <div class="hidden-320"> <?php echo $visitorObj->visitor_address;?><br>
                              <?php echo $visitorObj->visitor_province." ".$visitorObj->visitor_zip;?>, <?php echo $visitorObj->visitor_country;?> </div>
                            <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                              <div class="span6">
                                <div class="td_label">ID Number</div>
                                <div class="td_value"><?php echo $visitorObj->visitor_id;?></div>
                                <div class="td_clear"></div>
                                <div class="td_label">Username</div>
                                <div class="td_value"><?php echo $visitorObj->visitor_username;?></div>
                                <div class="td_clear"></div>
                                <div class="td_label">Password</div>
                                <div class="td_value"><?php echo $visitorObj->visitor_password;?></div>
                                <div class="td_clear"></div>
                                <?php
									$reviews_list = $this->Visitordb->get_visitor_reviews($visitorObj->visitor_id);
									$reviews_list_listing = "";
									foreach($reviews_list as $obj)
									{
										$reviews_list_listing .= "# ".$obj->comment_linkid.", ";
									}
									$reviews = count($this->Visitordb->get_visitor_reviews($visitorObj->visitor_id));
								?>
                                <div class="td_label">Reviews</div>
                                <div class="td_value"><?php echo $reviews;?></div>
                                <div class="td_clear"></div>
                              </div>
                              <div class="span6">
                                <div class="td_label">Email</div>
                                <div class="td_value"><?php echo $visitorObj->visitor_email;?></div>
                                <div class="td_clear"></div>
                                <div class="td_label">Phone</div>
                                <div class="td_value"> <font color="#336600"><?php echo $visitorObj->visitor_phone;?></font> </div>
                                <div class="td_clear"></div>
                                <div class="td_label">Date</div>
                                <div class="td_value"> <font color="#336600"><?php echo $visitorObj->visitor_lastupdate;?></font> </div>
                                <div class="td_clear"></div>
                                <div class="td_label">Listing ID</div>
                                <div class="td_value"> <font color="#336600"><?php echo $reviews_list_listing;?></font> </div>
                                <div class="td_clear"></div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            <div class="btn-group"> <a class="btn mini yellow dropdown-toggle" data-toggle="dropdown" href="#">View <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("visitor/visitor_edit/".$visitorObj->visitor_id."/".$pagination["startpage"]);?>"><i class="icon-edit"></i> View </a></li>
                           
                                
                              </ul>
                            </div></td>
                          <?php /*?><td style="text-align:right; vertical-align:middle; padding:10px;"><?php											

                                            $url = base_url()."visitor_cache/".$visitorObj->visitor_id.".jpg";

													$url = get_headers($url, 1);

													if(!preg_match("/404/",$url[0]))

													{  ?>
                            <img src="<?php echo base_url();?>visitor_catch/<?php echo $visitorObj->visitor_id;?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
                            <?php }?>
                          </td><?php */?>
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
          <!-- navigation here -->
          <!-- navigation here -->
          <div style="padding-bottom:50px">
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                <form action="<?php echo base_url("visitor/visitor_list/");?>" dir="ltr" method="post" name="pagination">
                  <input type="hidden" name="page_click">
                  <span class="help-inline">Page 	&nbsp; </span>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"];?>" class="span6 m-wrap" style="width:50px" onChange="this.form.submit();">
                  <span class="help-inline">of 		&nbsp; <?php echo $pagination["pages"];?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">
                <div dir="ltr"> <a href="#" onClick="jQuery.fn.submit_pagination_form('prev');" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="#" onClick="jQuery.fn.submit_pagination_form('next');" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
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

		jQuery.fn.submit_pagination_form = function(page_event)

		{

			$("input[name=page_click]").val(page_event);

			$("form[name=pagination]").submit();

		}

</script>
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
			jQuery("body").on("click",".delete_selected",function(){
			if ( confirm("Do you want to delete selected data?") ){

				jQuery("form[name=visitor-form]").submit();

				return true;

			} 

			else{ return false; }
			
		})

			App.init();

			TableManaged.init();

		});

		

	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>