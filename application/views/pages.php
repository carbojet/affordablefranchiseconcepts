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
<script type="text/javascript">
	<!--
		function confirm_delete(id, name, page){	
			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){
				window.location = "<?php echo base_url("/listing/delete_listing/");?>"+"/"+id+"/"+page; 
				return true;
			} 
			else{ return false; }
		}		
		function confirm_delete_all(){	
			
			if ( confirm("Do you want to delete all data?") ){
				window.location = "<?php echo base_url("listing/delete_all_listing/"); ?>"; 
				return true;
			} 
			else{ return false; }
		}		

		function menu_resort(menuform) {
			var baseurl		= "?" ;
			selecteditem	= menuform.s_order.selectedIndex ;
			newurl 			= menuform.s_order.options[ selecteditem ].value ;
			location.href	= baseurl + '&s_order=' + newurl;
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

			$sidemenu[9] =array("1"=>"active","2"=>array("1"=>"active"));

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
          <h3 class="page-title">Pages</h3>
          <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
      
      <div class="row-fluid profile">
        <div class="span12">
          <div>
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                
                <span class="help-inline">Page 	&nbsp; </span>
                <form>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["currentpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["currentpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">

                <?php if($pagination["currentpage"]>0){$pre = $pagination["currentpage"]-1;}else{$pre=0;}
                if($pagination["currentpage"]<$pagination["pages"]){$nxt = $pagination["currentpage"]+1;}else{$nxt=$pagination["pages"];}?>
                <div dir="ltr"> <a href="<?php echo base_url("pages/preview/".$pre); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="<?php echo base_url("pages/next/".$nxt); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
              </div>
            </div>
            <div style="clear:both"></div>
          </div>
          <!--BEGIN TABS-->
          <div class="row-fluid">
            <div class="span12">
              <!-- BEGIN PORTLET-->
              <div class="portlet">
                <div class="portlet-title">
                  <div class="caption"><i class="icon-list"></i> Manage Pages</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("pages/addnew/"); ?>"><i class="icon-plus"></i> Add New </a></li>
                        <li><a href="#" onClick="confirm_delete_all();"><i class="icon-trash"></i> Delete All </a></li>
                        <li><a href="#" class="delete_selected"><i class="icon-trash"></i>Delete Selected</a></li>
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
                        <?php if(!empty($pages)){
                          foreach($pages as $k=>$page){                            
                            ?>
                        <tr>
                          <td style="padding-top:8px">
                            <div class="checker" id="uniform-undefined">
                              <span class="">
                                <input name="page_status_delete[]" type="checkbox" class="checkboxes" value="<?php echo $page->ID; ?>" style="opacity: 0;">
                              </span>
                            </div>
                          </td>
                          <td style="text-align:left; vertical-align:baseline; padding:10px;">
                            <h5 style="font-weight:700; margin:0;"><?php echo $page->post_title; ?></h5>
                            <!-- property links -->
                            <div class="btn-group"> <a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("pages/edit/".$page->ID."/".$pagination["currentpage"]);?>"><i class="icon-edit"></i> Edit </a></li>
                                <li><a onClick="confirm_delete('<?php echo $page->ID;?>','# <?php echo $page->ID;?>','<?php echo $pagination["startpage"];?>')" style="cursor:pointer"><i class="icon-trash"></i> Delete </a></li>
                                <li><a href="<?php echo base_url("pages/listing_statistics/".$page->ID); ?>"><i class="icon-bar-chart"></i> Statistics </a></li>
                                <li><a href="<?php echo base_url($page->post_name); ?>" target="_blank"><i class="icon-zoom-in"></i> Preview </a></li>
                              </ul>
                            </div>
                          </td>
                          <td style="padding-right:20px; vertical-align:middle;">                          
                              <!-- details -->
                              <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                <div class="span12">
                                  <div class="td_label">Status</div>
                                  <div class="td_value"><?php echo $page->post_status; ?></div>
                                  <div class="td_clear"></div>
                                  <div class="td_label">Viewed</div>
                                  <div class="td_value">times</div>
                                  <div class="td_clear"></div>
                                  <div class="td_label">Date</div>
                                  <div class="td_value"><?php echo date('d M y',strtotime($page->post_modified));?></div>
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
          <!-- navigation here -->
          <!-- navigation here -->
          <div style="padding-bottom:50px">
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                
                <span class="help-inline">Page 	&nbsp; </span>
                <form>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["currentpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["currentpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">

<?php if($pagination["currentpage"]>0){$pre = $pagination["currentpage"]-1;}else{$pre=0;}
if($pagination["currentpage"]<$pagination["pages"]){$nxt = $pagination["currentpage"]+1;}else{$nxt=$pagination["pages"];}?>

                <div dir="ltr"> <a href="<?php echo base_url("pages/prev/".$pre); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="<?php echo base_url("pages/next/".$nxt); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
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

		

		jQuery(".toggle-slider").click(function(){
			id = jQuery(this).attr("data-toggle")

			jQuery("#"+id).toggle("slow");

		})
		jQuery(".search-btn").click(function(){
			id = jQuery(this).attr("data-toggle")

			jQuery("#portlet-body").toggle("slow");

		})

		

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
		jQuery.fn.pagination = function(){
			return false;
		}
		
		jQuery("body").on("click",".delete_selected",function(){
			if ( confirm("Do you want to delete selected data?") ){

				jQuery("form[name=listing-form]").submit();

				return true;

			} 

			else{ return false; }
			
		})
		
		jQuery("body").on("keypress","input[name=navigation_page]",function(e){
			e.prevenDefault();
		})
		
		jQuery("body").on("keyup","input[name=navigation_page]",function(e){
			if(e.keyCode == 13){
				currntpage = jQuery("input[name=currentpage]").val();
				pagenum = jQuery(this).val();
				//if(pagenum >= 1){
				//	pagenum -= 1;
				//}
				if(currntpage <= pagenum){					
					window.location = "<?php echo base_url("listing/listing_nxt_page"); ?>"+"/"+pagenum;
				}else{
					window.location = "<?php echo base_url("listing/listing_pre_page"); ?>"+"/"+pagenum;
				}
				
			}
		})
		
		
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

			App.init();

			TableManaged.init();

		});

		

	</script>
<script>

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