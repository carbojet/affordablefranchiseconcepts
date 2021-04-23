<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript">

	<!--

		function confirm_delete(id, name, page){	

			if ( confirm("Do you want to delete this data?\n( Current Data : " + name + " )") ){

				window.location = "<?php echo base_url("/listing/delete_listing/");?>"+"/"+id+"/"+page; 

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

		

		function confirm_delete_all(page){	

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

			$sidemenu[5] =array("1"=>"active","2"=>array("2"=>"active"));

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
          <div class="portlet box grey" style="border-color:#004080;">
            <div class="portlet-title" style="background-color:#004080;">
              <div class="caption"><i class="icon-search"></i> Search Listings</div>
              <div class="actions">
                <button class="btn blue dropdown-toggle toggle-slider" data-toggle="portlet-body"><i class="icon-angle-down rotate"></i></button>
              </div>
            </div>
            <div id="portlet-body" class="portlet-body form" style="display:none;">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url("listing/listing_search/");?>" class="form-horizontal" method="post">
                <div class="space20"></div>
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls"> You can simply use the following search form to search the listings you want. <br>
                    Please understand that the more criteria you put in the form will give you narrower results ... </div>
                </div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <h5 style="font-weight:700">Enter Listing Criteria ...</h5>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">ID Number</label>
                  <div class="controls span6">
                    <input type="text" name="listing_id" data-required="1" class="span12 m-wrap">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Seller Id</label>
                  <div class="controls span6">
                    <input type="text" name="listing_seller_id" data-required="1" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Sector Name</label>
                  <div class="controls span6">
                    <select name="listing_sector" class="span12 m-wrap" onChange="jQuery.fn.ajax_category_list(this.value,1);">
                      <option value="">Select Sector</option>
                      <?php						
						$sector_list = $this->Listingdb->sector_list();						
						if(!empty($sector_list)){
						foreach($sector_list as $k=>$sectorlistObj){ ?>
                      <option value="<?php echo $sectorlistObj->category_id; ?>"><?php echo $sectorlistObj->category_name_1; ?></option>
                      <?php }} ?>
                    </select>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Category</label>
                  <div class="controls span6">
                    <div id="listing_category_1" class="listing_category" style="current:block; padding-top:0px">
                      <select name="listing_category" id="box_listing_category_1" class="span12 m-wrap" >
                        <option value="0"></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="control-group span12">
                  <label class="control-label">Location</label>
                  <div class="controls span8 location">
                    <div id="listing_location_1" style="current:block; padding-top:0px" class="span4">
                      <select name="listing_location_country" id="box_listing_location_1" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,2);">
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
                    <div id="listing_location_2" style="current:none; padding-top:0px" class="span4">
                      <select name="listing_location_state" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,3);">
                        <option value="">State</option>
                      </select>
                    </div>
                    <div id="listing_location_3" style="current:none; padding-top:0px" class="span4">
                      <select multiple name="listing_location_city[]" class="span12 m-wrap" onChange="jQuery.fn.ajax_location_list(this.value,4);">
                        <option value="">City</option>
                      </select>
                    </div>
                    <div id="listing_location_notification" style="display:none; padding-top:5px"> <img src="gui/ltr/img/ajax-loader.gif" align="left" style="padding-right:5px"> <font>please wait while loading sub locations data ...</font> </div>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Zip Code</label>
                  <div class="controls span6">
                    <input type="text" name="listing_zip" data-required="1" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label">Keyword</label>
                  <div class="controls span6">
                    <input type="text" name="listing_status_keywords" data-required="1" class="span12 m-wrap" style="">
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label"> Featured </label>
                  <div class="controls span6">
                    <select name="s_featured" class="span12 m-wrap">
                      <option value="">Any </option>
                      <option value="featured">Featured Listings </option>
                      <option value="unfeatured">Not-Featured Listings </option>
                    </select>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label"> New </label>
                  <div class="controls span6">
                    <select name="listing_status_new" class="span12 m-wrap">
                      <option value="">Any </option>
                      <option value="renew">New </option>
                      <option value="new">Old </option>
                    </select>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label"> Visit Status </label>
                  <div class="controls span6">
                    <select name="visit_status" class="span12 m-wrap">
                      <option value="any">Any </option>
                      <option value="visited">Visited</option>
                      <option value="not_visited">Not-visited</option>
                    </select>
                  </div>
                </div>
                <div class="control-group span5">
                  <label class="control-label"> Order By </label>
                  <div class="controls span6">
                    <select name="s_order" class="span12 m-wrap">
                    	<option value="listing_id desc">Ads DESC</option>
                      <option value="listing_id asc">Ads ASC</option>                      
                      <option value="listing_visited asc">Visited ASC</option>
                      <option value="listing_visited desc">Visited DESC</option>
                    </select>
                  </div>
                </div>
                <div style="clear:both"></div>
                <div class="form-actions">
                  <button type="submit" name="" class="btn black" style="background-color:#461B7E;"> <i class="icon-search"></i> Search </button>
                </div>
              </form>
              <!-- END FORM-->
            </div>
          </div>
        </div>
      </div>
      <div class="row-fluid profile">
        <div class="span12">
          <div>
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                <!--<form action="system_paging_navigation.php" dir="ltr">

									<input type="hidden" name="navigation_url" value="listing.php">

									<input type="hidden" name="navigation_pageitem" value="">

									<input type="hidden" name="navigation_total" value="20">

									<input type="hidden" name="navigation_values" value="">-->
                <span class="help-inline">Page 	&nbsp; </span>
                <form method="post" action="<?php echo base_url("listing/listing_search");?>" name="pagination" id="pagination">
                <?php
					if(empty($post_data["listing_location_path"])){$post_data["listing_location_path"]=array();}
				?>
                  <input type="hidden" name="page_click">
                  <input type="hidden" name="s_order" value="<?php echo $post_data["s_order"];?>">
                  <input type="hidden" name="s_featured" value="<?php echo $post_data["s_featured"];?>">
                  <input type="hidden" name="listing_status_new" value="<?php echo $post_data["listing_status_new"];?>">
                  <input type="hidden" name="visit_status" value="<?php echo $post_data["visit_status"];?>">
                  <input type="hidden" name="listing_zip" value="<?php echo $post_data["listing_zip"];?>">
                  <?php foreach($post_data["listing_location_path"] as $key=>$val){
				  $val = explode("-",$val);
				  if($key == 0){ 
                  	if(isset($val[1])){?>
                  	<input type="hidden" name="listing_location_country" value="<?php echo $val[1]; ?>">
                  	<?php } 
                    if(isset($val[2])){?>
                  	<input type="hidden" name="listing_location_state" value="<?php echo $val[2]; ?>">
                  	<?php } ?>
				  <?php } if(isset($val[3])){?>
                  <input type="hidden" name="listing_location_city[]" value="<?php echo $val[3]; ?>">
                  <?php } ?>
                  <?php } ?>
                  <input type="hidden" name="listing_sector" value="<?php echo $post_data["listing_sector"];?>">
                  <input type="hidden" name="listing_category" value="<?php echo $post_data["listing_category"];?>">
                  <input type="hidden" name="listing_status_keywords" value="<?php echo $post_data["listing_status_keywords"];?>">
                  <input type="hidden" name="listing_id" value="<?php echo $post_data["listing_id"];?>">
                  <input type="hidden" name="listing_seller_id" value="<?php echo $post_data["listing_seller_id"];?>">
                  <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["startpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
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
          <!--BEGIN TABS-->
          <div class="row-fluid">
            <div class="span12">
              <!-- BEGIN PORTLET-->
              <div class="portlet">
                <div class="portlet-title">
                  <div class="caption"><i class="icon-list"></i> Manage Listings</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("listing/new_listing/"); ?>"><i class="icon-plus"></i> Add New </a></li>
                        <li><a href="#" onClick="confirm_delete_all();"><i class="icon-trash"></i> Delete All </a></li>
                        <li><a href="#" class="delete_selected"><i class="icon-trash"></i>Delete Selected</a></li>
                        <li><a href="#" class="search-btn"><i class="icon-search"></i> Search </a></li>
                        <!--<li><a onClick="confirm_delete_all('Manage Listings')" style="cursor:pointer"><i class="icon-trash"></i> Delete All </a></li>
                        <li><a onClick="confirm_delete_selected('Manage Listings')" style="cursor:pointer"><i class="icon-remove"></i> Delete Selected </a></li>-->
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet-body">
                  <?php

											if(isset($success_msg))

											{?>
                  <div class="alert alert-success " style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
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
                          <th class="span9">Detailed Info</th>
                          <th class="span3" style="text-align:right">Thumbnail</th>
                        </tr>
                      </thead>
                      <tbody>
                   	
                        <?php if(!empty($listing_list)){ foreach($listing_list as $k=>$listingObj){ ?>
                        	<?php //if(!isset($visit_status)){$visit_status="any";} ?>
                            <tr>
                              <td style="padding-top:8px"><div class="checker" id="uniform-undefined"><span class="">
                                  <input name="listing_status_delete[]" type="checkbox" class="checkboxes" value="<?php echo $listingObj->listing_id; ?>" style="opacity: 0;">
                                  </span></div></td>
                              <td style="padding-right:20px; vertical-align:middle"><div style="padding:5px 0 5px 0">
                                  <?php $visitor_commentObj  = $this->Listingdb->get_listing_rating(array("listing_id"=>$listingObj->listing_id)); 
    
                                                        if(!empty($visitor_commentObj->comment_rating)){?>
                                  <img width="84" height="16" src="<?php echo base_url('theme');?>/img/stars/pic_star<?php echo $visitor_commentObj->comment_rating; ?>.png" alt="" style="width:84px; height:16px;">
                                  <?php }?>
                                </div>
                                <h5 style="font-weight:700; margin:0;"><?php echo $listingObj->listing_title_1; ?></h5>
                                <?php 
                                    echo $this->Listingdb->listing_location_path($listingObj->listing_location_path);
                                    
                                ?>
                                <!-- details -->
                                <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                  <div class="span6">
                                    <div class="td_label">ID Number</div>
                                    <div class="td_value"><?php echo $listingObj->listing_id;?></div>
                                    <div class="td_clear"></div>
                                    <div class="td_label">Seller Id</div>
                                    <div class="td_value"><?php echo $listingObj->seller_username;?></div>
                                    <div class="td_clear"></div>
                                    <?php $viewed = $this->Listingdb->get_listing_visited(array("stat_listing"=>$listingObj->listing_id));?>
                                    <div class="td_label">Viewed</div>
                                    <div class="td_value"> <?php echo $viewed; ?> times </div>
                                    <div class="td_clear"></div>
                                    <?php //$favourited_detail = $this->Listingdb->get_listing_favourited(array("favourite_listing"=>$listingObj->listing_id)); ?>
                                    <?php /*?><div class="td_label">Favourited</div>
                                    <div class="td_value"> <?php echo count($favourited_detail); ?> times</div><?php */?>
                                    <div class="td_clear"></div>
                                  </div>
                                  <div class="span6">
                                    <?php $packageObj = $this->Listingdb->get_listing_package(array("listing_package"=>$listingObj->listing_package)); ?>
                                    <!--<div class="td_label">Package</div>
                                    <div class="td_value">
                                      <?php if(!empty($packageObj->package_listing_name_1)){echo $packageObj->package_listing_name_1;} ?>
                                    </div>-->
                                    <?php /*?><div class="td_clear"></div>
                                    <div class="td_label">Expired</div>
                                    <div class="td_value"><?php echo date("d-M-Y",strtotime($listingObj->listing_expire)); ?></div><?php */?>
                                    <div class="td_clear"></div>
                                    <div class="td_label">Featured</div>
                                    <div class="td_value">
                                      <?php if($listingObj->listing_status_feature=="featured"){ echo "Yes";}else{echo "No";} ?>
                                    </div>
                                    <div class="td_clear"></div>
                                    <div class="td_clear"></div>
                                    <div class="td_label">New</div>
                                    <div class="td_value">
                                      <?php if($listingObj->listing_status_new=="new"){ echo "No";}else{echo "Yes";} ?>
                                    </div>
                                    <div class="td_clear"></div>
                                    <?php $visitor_comment_array = $this->Listingdb->get_listing_mailed(array("comment_linkid"=>$listingObj->listing_id));?>
                                    <div class="td_label">Visited</div>
                                    <div class="td_value"><?php echo $listingObj->listing_visited; ?></div>
                                    <div class="td_clear"></div>
                                  </div>
                                  <div class="clearfix"></div>
                                </div>
                                <!-- property links -->
                                <div class="btn-group"> <a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Edit <i class="icon-angle-down"></i></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url("listing/edit/".$listingObj->listing_id."/".$pagination["startpage"]);?>"><i class="icon-edit"></i> Edit </a></li>
                                    <li><a onClick="confirm_delete('<?php echo $listingObj->listing_id;?>','# <?php echo $listingObj->listing_id;?>','<?php echo $pagination["startpage"];?>')" style="cursor:pointer"><i class="icon-trash"></i> Delete </a></li>
                                    <li><a href="<?php echo base_url("listing/listing_statistics/".$listingObj->listing_id); ?>"><i class="icon-bar-chart"></i> Statistics </a></li>
                                    <?php /*?><li><a href="<?php echo base_url("listing/listing_reviews/".$listingObj->listing_id); ?>"><i class="icon-comments"></i> Reviews <font dir="ltr">(<?php echo $this->Listingdb->get_review_list(true,$listingObj->listing_id) ; ?>)</font></a></li><?php */?>
                                    <li><a href="<?php echo base_url("product/".$listingObj->listing_slug); ?>" target="_blank"><i class="icon-zoom-in"></i> Preview </a></li>
                                    <li>
                                      <?php if($listingObj->listing_status_feature=="featured"){ ?>
                                      <a href="<?php echo base_url("listing/feature/off/".$listingObj->listing_id."/".$pagination["startpage"]); ?>"><i class="icon-star-empty"></i> Un-Feature </a>
                                      <?php }else{ ?>
                                      <a href="<?php echo base_url("listing/feature/on/".$listingObj->listing_id."/".$pagination["startpage"]); ?>"><i class="icon-star"></i> Feature </a>
                                      <?php } ?>
                                    </li>
                                    <li>
                                  <?php if($listingObj->listing_status_new=="new"){ ?>
                                  <a href="<?php echo base_url("listing/status_new/on/".$listingObj->listing_id."/".$pagination["startpage"]); ?>"><i class="icon-star"></i> New</a>
                                  <?php }else{ ?>
                                  <a href="<?php echo base_url("listing/status_new/off/".$listingObj->listing_id."/".$pagination["startpage"]); ?>"><i class="icon-star-empty"></i> Old </a>
                                  <?php } ?>
                                </li>
                                  </ul>
                                </div></td>
                              <td style="text-align:right; vertical-align:middle; padding:10px;"><?php
    
                                                        $listing_photoObj = $this->Listingdb->get_listing_main_photo(array("listing_id"=>$listingObj->listing_id,"photo_status_main"=>"main"));													
                                                        if(!empty($listing_photoObj->photo_id)){
    
                                                    ?>
                                <img src="<?php echo base_url();?>photo_medium/<?php echo $listing_photoObj->photo_id;?>.jpg" border="0" style="border:1px solid #cccccc; padding:2px">
                                <?php }?>
                              </td>
                            </tr>
                            <?php 
							 }}else{ echo "Record Not Found!";}?>
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
                <form method="post" action="<?php echo base_url("listing/listing_search");?>" name="pagination" id="pagination">
                <?php
					if(empty($post_data["listing_location_path"])){$post_data["listing_location_path"]=array();}
				?>
                  <input type="hidden" name="page_click">
                  <input type="hidden" name="s_order" value="<?php echo $post_data["s_order"];?>">
                  <input type="hidden" name="s_featured" value="<?php echo $post_data["s_featured"];?>">
                  <input type="hidden" name="listing_status_new" value="<?php echo $post_data["listing_status_new"];?>">
                  <input type="hidden" name="visit_status" value="<?php echo $post_data["visit_status"];?>">
                  <input type="hidden" name="listing_zip" value="<?php echo $post_data["listing_zip"];?>">
                  <?php foreach($post_data["listing_location_path"] as $key=>$val){
				  $val = explode("-",$val);
				  if($key == 0){ 
                  	if(isset($val[1])){?>
                  	<input type="hidden" name="listing_location_country" value="<?php echo $val[1]; ?>">
                  	<?php } 
                    if(isset($val[2])){?>
                  	<input type="hidden" name="listing_location_state" value="<?php echo $val[2]; ?>">
                  	<?php } ?>
				  <?php } if(isset($val[3])){?>
                  <input type="hidden" name="listing_location_city[]" value="<?php echo $val[3]; ?>">
                  <?php } ?>
                  <?php } ?>
                  <input type="hidden" name="listing_sector" value="<?php echo $post_data["listing_sector"];?>">
                  <input type="hidden" name="listing_category" value="<?php echo $post_data["listing_category"];?>">
                  <input type="hidden" name="listing_status_keywords" value="<?php echo $post_data["listing_status_keywords"];?>">
                  <input type="hidden" name="listing_id" value="<?php echo $post_data["listing_id"];?>">
                  <input type="hidden" name="listing_seller_id" value="<?php echo $post_data["listing_seller_id"];?>">
                  <input type="text" name="navigation_page" value="<?php echo $pagination["startpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["startpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
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

		jQuery(".toggle-slider").click(function(){
			id = jQuery(this).attr("data-toggle")

			jQuery("#"+id).toggle("slow");

		})
		jQuery(".search-btn").click(function(){
			id = jQuery(this).attr("data-toggle")

			jQuery("#portlet-body").toggle("slow");

		})


	jQuery.fn.submit_pagination_form = function(page_event)

	{
		
		$("input[name=page_click]").val(page_event);

		$("form[name=pagination]").submit();		

	}
	
	jQuery("body").on("click",".delete_selected",function(){
			if ( confirm("Do you want to delete selected data?") ){

				jQuery("form[name=listing-form]").submit();

				return true;

			} 

			else{ return false; }
			
		})
	
	jQuery("body").on("keypress","input[name=navigation_page]",function(e){
		if(e.keyCode == 13){		
			e.preventDefault();	
		}	
	})
	jQuery("body").on("keyup","input[name=navigation_page]",function(e){
			if(e.keyCode == 13){
				currntpage = jQuery("input[name=currentpage]").val();
				pagenum = jQuery(this).val();
				if(pagenum >= 1){
					pagenum -= 1;
				}
				if(currntpage <= pagenum){					
					//window.location = "<?php //echo base_url("listing/listing_nxt_page"); ?>"+"/"+pagenum;
					jQuery.fn.submit_pagination_form('next');
				}else{
					//window.location = "<?php //echo base_url("listing/listing_pre_page"); ?>"+"/"+pagenum;
					jQuery.fn.submit_pagination_form('prev');
				}
				
			}
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