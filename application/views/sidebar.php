<!-- BEGIN SIDEBAR -->

<div class="page-sidebar nav-collapse collapse">
  <!-- BEGIN SIDEBAR MENU -->
  <ul>
    <li>
      <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
      <div class="sidebar-toggler hidden-phone" style="margin-bottom:30px"></div>
      <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    </li>
    <!-- menu : setup -->
    <li class="start <?php if(!empty($sidemenu[1][1])){ echo $sidemenu[1][1];} ?>"> <a href="javascript:;"> <i class="icon-dashboard"></i> <span class="title">Website Setup </span> <span class="selected"></span> <span class="arrow open"></span> </a>
      <ul class="sub-menu">
        <!--<li class="<?php //if(!empty($sidemenu[1][2][1])){ echo $sidemenu[1][2][1];} ?>"><a href="<?php //echo base_url("sitesetup"); ?>">Website&nbsp;Summary </a></li>

			<li class="<?php //if(!empty($sidemenu[1][2][7])){ echo $sidemenu[1][2][7];} ?>"><a href="<?php //echo base_url("sitesetup/mail_templates/");?>">Email&nbsp;Templates </a></li>

			<li class="<?php //if(!empty($sidemenu[1][2][8])){ echo $sidemenu[1][2][8];} ?>"><a href="<?php //echo base_url("sitesetup/payment_preferences/");?>">Payment&nbsp;Preferences </a></li>-->
        <li class="<?php if(!empty($sidemenu[1][2][2])){ echo $sidemenu[1][2][2];} ?>"><a href="<?php echo base_url("/user/"); ?>">Administrator&nbsp;Users </a></li>
        <li class="<?php if(!empty($sidemenu[1][2][3])){ echo $sidemenu[1][2][3];} ?>"><a href="<?php echo base_url("sitesetup/import_export/");?>">Import / Export (CSV)</a></li>
        <!--<li class=""><a href="#">Refresh Database </a></li>-->
      </ul>
    </li>
    <!-- menu : lookup -->
    <li class="<?php if(!empty($sidemenu[2][1])){ echo $sidemenu[2][1];} ?>"> <a href="javascript:;"> <i class="icon-cogs"></i> <span class="title">Lookup </span> <span class="selected"></span> <span class="arrow open"></span> </a>
      <ul class="sub-menu">
        <li class="<?php if(!empty($sidemenu[2][2][1])){ echo $sidemenu[2][2][1];} ?>"> <a href="javascript:;">General <span class="arrow"></span></a>
          <ul class="sub-menu">
            <li class="<?php if(!empty($sidemenu[2][2][2][2])){ echo $sidemenu[2][2][2][2];} ?>"><a href="<?php echo base_url("general/setup_location"); ?>">Location </a></li>
          </ul>
        </li>
        <li class="<?php if(!empty($sidemenu[2][3][1])){ echo $sidemenu[2][3][1];} ?>"> <a href="javascript:;">Directory&nbsp;Details <span class="arrow"></span></a>
          <ul class="sub-menu">
            <li class="<?php if(!empty($sidemenu[2][3][2][4])){ echo $sidemenu[2][3][2][4];} ?>"><a href="<?php echo base_url("general/setup_sector_listing"); ?>">Listing&nbsp;Industry </a></li>
            <li class="<?php if(!empty($sidemenu[2][3][2][3])){ echo $sidemenu[2][3][2][3];} ?>"><a href="<?php echo base_url("general/setup_category_listing"); ?>">Listing&nbsp;Category </a></li>
          </ul>
        </li>
      </ul>
    </li>
    
    <!-- menu : pages -->
    <li class="<?php if(!empty($sidemenu[9][1])){ echo $sidemenu[9][1];} ?>">
      <a href="javascript:;">
        <i class="icon-reorder"></i>
        <span class="title">CMS</span>
        <span class="selected"></span>
        <span class="arrow open"></span>
      </a>
      <ul class="sub-menu">
        <li class="<?php if(!empty($sidemenu[9][2][1])){ echo $sidemenu[9][2][1];} ?>"><a href="<?php echo base_url("pages");?>">Pages</a></li>
        <li class="<?php if(!empty($sidemenu[9][2][2])){ echo $sidemenu[9][2][2];} ?>"><a href="<?php echo base_url("pages/menus");?>">Menu List</a></li>
        <li class="<?php if(!empty($sidemenu[9][2][3])){ echo $sidemenu[9][2][3];} ?>"><a href="<?php echo base_url("pages/media");?>">Media</a></li>
        <li class="<?php if(!empty($sidemenu[9][2][4])){ echo $sidemenu[9][2][4];} ?>"><a href="<?php echo base_url("pages/banners");?>">Banners</a></li>
        <li class="<?php if(!empty($sidemenu[9][2][7])){ echo $sidemenu[9][2][7];} ?>"><a href="<?php echo base_url("pages/testimonials");?>">Testimonials</a></li>
      </ul>
    </li>
    <!-- menu : listing -->
    <li class="<?php if(!empty($sidemenu[5][1])){ echo $sidemenu[5][1];} ?>"> <a href="javascript:;"> <i class="icon-reorder"></i> <span class="title">Listings </span> <span class="selected"></span> <span class="arrow open"></span> </a>
      <ul class="sub-menu">
        <li class="<?php if(!empty($sidemenu[5][2][1])){ echo $sidemenu[5][2][1];} ?>"><a href="<?php echo base_url("listing");?>">Listing Manager </a></li>
        <?php /*?><li class="<?php if(!empty($sidemenu[5][2][2])){ echo $sidemenu[5][2][2];}?>"><a href="<?php echo base_url("listing/listing_search");?>">Listing&nbsp;Search </a></li>
        <li class="<?php if(!empty($sidemenu[5][2][3])){ echo $sidemenu[5][2][3];}?>"><a href="<?php echo base_url("listing/setup_field_listing");?>">Listing&nbsp;Field&nbsp;Editor </a></li><?php */?>
      </ul>
    </li>
    <!-- menu : payment -->
    <!-- display payment menu only if multiple seller mode or addon banner installed -->
    <!--<li class="<?php if(!empty($sidemenu[6][1])){ echo $sidemenu[6][1];} ?>">

		<a href="javascript:;">

			<i class="icon-money"></i>

			<span class="title">Payments </span>

			<span class="selected"></span>

			<span class="arrow open"></span>

		</a>

		<ul class="sub-menu">

			<li class="<?php if(!empty($sidemenu[6][2][1])){ echo $sidemenu[6][2][1];} ?>"><a href="<?php echo base_url("payment/all_payments");?>">All Payments </a></li>

			<li class="<?php if(!empty($sidemenu[6][2][2])){ echo $sidemenu[6][2][2];} ?>"><a href="<?php echo base_url("payment/pending_payments");?>">Payments&nbsp;Pending </a></li>

			<li class="<?php if(!empty($sidemenu[6][2][3])){ echo $sidemenu[6][2][3];} ?>"><a href="<?php echo base_url("payment/approved_payments");?>">Payments&nbsp;Approved </a></li>

			<li class="<?php if(!empty($sidemenu[6][2][4])){ echo $sidemenu[6][2][4];} ?>"><a href="<?php echo base_url("payment/cancelled_payments");?>">Payments&nbsp;Cancelled </a></li>

		</ul>

	</li>-->
    <!-- menu : visitor -->
    <li class="<?php if(!empty($sidemenu[7][1])){ echo $sidemenu[7][1];} ?>"> <a href="javascript:;"> <i class="icon-user"></i> <span class="title">Visitors</span> <span class="selected"></span> <span class="arrow open"></span> </a>
      <ul class="sub-menu">
        <li class="<?php if(!empty($sidemenu[7][2][1])){ echo $sidemenu[7][2][1];} ?>"><a href="<?php echo base_url("visitor/visitor_list");?>">Visitor Manager </a></li>
        <li class="<?php if(!empty($sidemenu[7][2][2])){ echo $sidemenu[7][2][2];} ?>"><a href="<?php echo base_url("visitor/search_visitor");?>">Search </a></li>
      </ul>
    </li>
    <!-- if $setup_addon_review|lower == "yes" -->
    <!-- if $cloginusertype == "full" -->
    <!-- menu : approval -->
    <!-- display approval only if the multiple seller mode -->
    <!--<li class="<?php if(!empty($sidemenu[8][1])){ echo $sidemenu[8][1];} ?>"> <a href="javascript:;"> <i class="icon-thumbs-up"></i> <span class="title">Approval </span> <span class="selected"></span> <span class="arrow open"></span> </a>
      <ul class="sub-menu">
        <li class="<?php if(!empty($sidemenu[8][2][1])){ echo $sidemenu[8][2][1];} ?>"><a href="<?php echo base_url("approval/seller_approval/");?>">Approve&nbsp;Sellers </a></li>
        <li class="<?php if(!empty($sidemenu[8][2][2])){ echo $sidemenu[8][2][2];} ?>"><a href="<?php echo base_url("approval/visitor_approval/");?>">Approve&nbsp;Visitors </a></li>
        <li class="<?php if(!empty($sidemenu[8][2][3])){ echo $sidemenu[8][2][3];} ?>"><a href="<?php echo base_url("approval/listing_approval/");?>">Approve&nbsp;Listings </a></li>
        <li class="<?php if(!empty($sidemenu[8][2][4])){ echo $sidemenu[8][2][4];} ?>"><a href="<?php echo base_url("approval/photo_approval/");?>">Approve&nbsp;Photos </a></li>
        <li class="<?php if(!empty($sidemenu[8][2][5])){ echo $sidemenu[8][2][5];} ?>"><a href="<?php echo base_url("approval/video_approval/");?>">Approve&nbsp;Videos </a></li>
        <li class="<?php if(!empty($sidemenu[8][2][11])){ echo $sidemenu[8][2][11];} ?>"><a href="<?php echo base_url("approval/review_approval/");?>">Approve&nbsp;Reviews </a></li>
      </ul>
    </li>-->
    <!-- menu : change language -->
    <!-- menu : log out -->
    <li> <a href="<?php echo base_url("login/logout"); ?>"> <i class="icon-off"></i> <span class="title">Logout</span> <span class="selected"></span> </a> </li>
  </ul>
  <!-- if $cloginid -->
  <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
