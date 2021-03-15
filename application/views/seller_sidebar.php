<!-- BEGIN SIDEBAR -->
<div class="page-sidebar nav-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->

<ul>
	<!-- menu : toggler -->
	<li>
		<div class="sidebar-toggler hidden-phone" style="margin-bottom:30px"></div>
	</li>
	<!-- menu : dashboard -->
	<li class="<?php if(!empty($sidemenu[1][1])){ echo $sidemenu[1][1];} ?>">
		<a href="<?php echo base_url("seller_dashboard");?>">
			<i class="icon-home"></i> 
			<span class="title">Dashboard </span>
		</a>
	</li>
	<!-- menu : company profile -->
	<li class="<?php if(!empty($sidemenu[2][1])){ echo $sidemenu[2][1];} ?>">
		<a href="<?php echo base_url("seller/seller_profile_edit/");?>">
			<i class="icon-user"></i> 
			<span class="title">My Profile</span>
			<span class="selected"></span>
		</a>
	</li>
	
	
	<!-- menu : manage listings -->
	<li class="<?php if(!empty($sidemenu[3][1])){ echo $sidemenu[3][1];} ?>">
		<a href="<?php echo base_url("listing/seller_own_listing");?>">
			<i class="icon-list"></i> 
			<span class="title">My Listings </span>
			<span class="selected"></span>
		</a>
	</li>
	
	
	<!-- menu : transaction history -->
	<li class="<?php if(!empty($sidemenu[4][1])){ echo $sidemenu[4][1];} ?>">
		<a href="<?php echo base_url("seller/seller_transaction/");?>">
			<i class="icon-money"></i> 
			<span class="title">My Transactions </span>
			<span class="selected"></span>
		</a>
	</li>
	<!-- menu : change password -->
	<li class="<?php if(!empty($sidemenu[5][1])){ echo $sidemenu[5][1];} ?>">
		<a href="<?php echo base_url("seller/seller_profile_password");?>">
			<i class="icon-key"></i> 
			<span class="title">My Password </span>
			<span class="selected"></span>
		</a>
	</li>
	<!-- menu : subscription -->
	<!-- menu : change language -->
	<!-- menu : log out -->
	<li>
		<a href="<?php echo base_url("seller_login/logout");?>">
			<i class="icon-off"></i> 
			<span class="title">Logout</span>
			<span class="selected"></span>
		</a>
	</li>
</ul>
 <!-- if $cloginid -->
<!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->