<header id="masthead" class="site-header" role="banner">
	<div class="mob-menu">
		<div class="container">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h1 class="menu-toggle sr-only screen-reader-text">Primary Menu</h1>
				<div class="skip-link"><a class="screen-reader-text sr-only" href="#content">Skip to content</a></div>

				<div class="navbar navbar-default navbar-static-top">
					<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">MENU</button>
					<a class="navbar-brand" href="<?php echo base_url();?>" rel="home">Affordable Business Concepts</a>
				</div>
				<!-- navbar-header -->
				
				<?php //$menu = $this->Chome->get_menu(3);?>
				<div class="navbar-collapse collapse">
					<ul id="menu-navigation" class="nav navbar-nav">
						<?php foreach($menu['menus'] as $menuitem){?>
							<li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-5 current_page_item menu-item-8 active">
								<?php if(isset($menuitem['submenu'])){?>									
									<a title="<?php echo $menuitem['menu_title'];?>" href="#" data-target="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $menuitem['menu_title'];?><span class="caret"></span></a>
									<ul role="menu" class=" dropdown-menu">
										<?php foreach($menuitem['submenu'] as $submenuitem){?>
											<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38">
												<a title="<?php echo $submenuitem['menu_title'];?>" href="<?php echo base_url().$submenuitem['menu_name'];?>"><?php echo $submenuitem['menu_title'];?></a>
											</li>
										<?php }?>
									</ul>
								<?php }else{?>
									<a title="<?php echo $menuitem['menu_title'];?>" href="<?php echo base_url().$menuitem['menu_name'];?>">
										<?php echo $menuitem['menu_title'];?>
									</a>
								<?php }?>
							</li>	
						<?php } ?>
						<!--
						<li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-5 current_page_item menu-item-8 active"><a title="Home" href="https://www.affordablebusinessconcepts.com/">Home</a></li>
						<li id="menu-item-223" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-223"><a title="Business Directory" href="https://www.affordablebusinessconcepts.com/business-directory/">Business Directory</a></li>
						<li id="menu-item-36" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-36 dropdown"><a title="ABC Advice" href="#" data-target="#" data-toggle="dropdown" class="dropdown-toggle">ABC Advice <span class="caret"></span></a>
							<ul role="menu" class=" dropdown-menu">
								<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a title="Why Buy a Franchised Business" href="https://www.affordablebusinessconcepts.com/why-buy-a-franchised-business/">Why Buy a Franchised Business</a></li>
								<li id="menu-item-37" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37"><a title="How to Investigate a Franchise" href="https://www.affordablebusinessconcepts.com/how-to-investigate-a-franchise/">How to Investigate a Franchise</a></li>
								<li id="menu-item-42" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-42"><a title="Why use a Franchise Consultant" href="https://www.affordablebusinessconcepts.com/why-use-a-franchise-consultant/">Why use a Franchise Consultant</a></li>
								<li id="menu-item-316" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-316"><a title="Franchising 101" href="https://www.affordablebusinessconcepts.com/franchising-101/">Franchising 101</a></li>
								<li id="menu-item-667" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-667"><a title="Before Buying a Franchise" href="https://www.affordablebusinessconcepts.com/before-buying-a-franchise/">Before Buying a Franchise</a></li>
								<li id="menu-item-315" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-315"><a title="FDD Overview" href="https://www.affordablebusinessconcepts.com/fdd-overview/">FDD Overview</a></li>
								<li id="menu-item-459" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-459"><a title="Questions to Ask Franchisees" href="https://www.affordablebusinessconcepts.com/questions-to-ask-franchisees/">Questions to Ask Franchisees</a></li>
								<li id="menu-item-643" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-643"><a title="Video Tutorials" href="https://www.affordablebusinessconcepts.com/video-tutorial/">Video Tutorials</a></li>
							</ul>
						</li>
						<li id="menu-item-59" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-59 dropdown"><a title="Resources" href="#" data-target="#" data-toggle="dropdown" class="dropdown-toggle">Resources <span class="caret"></span></a>
							<ul role="menu" class=" dropdown-menu">
								<li id="menu-item-188" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-188"><a title="Pre-Qualification Form" href="https://www.affordablebusinessconcepts.com/pre-qualification-form/">Pre-Qualification Form</a></li>
								<li id="menu-item-61" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-61"><a title="Legal and Financial Help" href="https://www.affordablebusinessconcepts.com/legal-and-financial-help/">Legal and Financial Help</a></li>
								<li id="menu-item-591" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-591"><a title="Industry  Insights" href="https://www.affordablebusinessconcepts.com/industry-insights/">Industry  Insights</a></li>
								<li id="menu-item-60" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-60"><a title="Net Worth Calculator" href="https://www.affordablebusinessconcepts.com/net-worth-calculator/">Net Worth Calculator</a></li>
							</ul>
						</li>
						<li id="menu-item-190" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-190 dropdown"><a title="About ABC" href="#" data-target="#" data-toggle="dropdown" class="dropdown-toggle">About ABC <span class="caret"></span></a>
							<ul role="menu" class=" dropdown-menu">
								<li id="menu-item-399" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-399"><a title="About ABC" href="https://www.affordablebusinessconcepts.com/about-abc/">About ABC</a></li>
								<li id="menu-item-691" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-691"><a title="ABC Announcements" href="https://www.affordablebusinessconcepts.com/abc-announcements/">ABC Announcements</a></li>
								<li id="menu-item-191" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-191"><a title="Disclosure Statement" href="https://www.affordablebusinessconcepts.com/disclosure-statement/">Disclosure Statement</a></li>
								<li id="menu-item-317" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-317"><a title="FAQ" href="https://www.affordablebusinessconcepts.com/faq/">FAQ</a></li>
							</ul>
						</li>
						<li id="menu-item-193" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-193"><a title="Testimonials" href="https://www.affordablebusinessconcepts.com/testimonials/">Testimonials</a></li>
						<li id="menu-item-232" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-232"><a title="Search" href="https://www.affordablebusinessconcepts.com/search/">Search</a></li>
								-->
					</ul>
				</div>
					<!-- .navbar -->

				</div>
			</nav>
		</div>
	</div>
	<div class="header-top">
		<div class="row" style="margin:0px;">
			<div class="col-lg-1 col-md-12 col-sm-12 col-xs-2"> </div>
			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-custom">
				<div class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/theme/frontend/img/abc-logo.png" width="100%"></a></div>
			</div>
			<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 text-right"> <img src="<?php echo base_url(); ?>/theme/frontend/img/abc-building.png"> </div>

			<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 text-right">
				<div class="rght-cont"> <span class="cell-no"><a href="wtai://wp/mc;866-388-3576" class="btn btn-default top-btn">Call Us Toll Free<br>
				<i class="fa fa-phone"></i> 866-388-3576</a></span>                  
				</div>
			</div>
		</div>
	</div>

	<!-- Request Free Phone Consultation Modal End -->
	<?php
		echo $this->Chome->forms(array('form'=>"multiad"));
	?>
	
	<!-- desktop menu -->
	<div class="nav-menu">
		<div class="container">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h1 class="menu-toggle sr-only screen-reader-text">Primary Menu</h1>
				<div class="skip-link"><a class="screen-reader-text sr-only" href="#content">Skip to content</a></div>

				<div class="navbar navbar-default navbar-static-top">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">MENU</button>
						<a class="navbar-brand" href="<?php echo base_url();?>" rel="home">Affordable Business Concepts</a>
					</div>
					<!-- navbar-header -->
					<div class="navbar-collapse collapse">
						<ul id="menu-navigation-1" class="nav navbar-nav">
							<?php foreach($menu['menus'] as $menuitem){?>								
								<?php
									if(isset($menuitem['submenu'])){
										if(array_search($slug, array_column($menuitem['submenu'], 'menu_name'))==2){
											$class = 'menu-item menu-item-type-post_type menu-item-object-page current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-'.$menuitem['menu_id'].' dropdown';
										}
										else{
											$class = 'menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-'.$menuitem['menu_id'].' dropdown';
										}
									}else{
										if($menuitem['menu_name']==$slug){
											$class = 'menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-5 current_page_item menu-item-'.$menuitem['menu_id'].' active';
										}else{
											$class = 'menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-'.$menuitem['menu_id'].' dropdown';
										}
									}									
								?>
								<li class="<?php echo $class;?>">
									<?php if(isset($menuitem['submenu'])){?>									
										<a title="<?php echo $menuitem['menu_title'];?>" href="#" data-target="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $menuitem['menu_title'];?><span class="caret"></span></a>
										<ul role="menu" class=" dropdown-menu">
											<?php foreach($menuitem['submenu'] as $submenuitem){?>
												<?php	
													if($submenuitem['menu_name']==$slug){
														$submenuclass = 'menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-24 current_page_item menu-item-'.$submenuitem['menu_id'].' active';
													}else{
														$submenuclass = 'menu-item menu-item-type-post_type menu-item-object-page menu-item-'.$submenuitem['menu_id'];
													}
												?>
												<li class="<?php echo $submenuclass;?>">
													<a title="<?php echo $submenuitem['menu_title'];?>" href="<?php echo base_url().$submenuitem['menu_name'];?>"><?php echo $submenuitem['menu_title'];?></a>
												</li>
											<?php }?>
										</ul>
									<?php }else{?>
										<a title="<?php echo $menuitem['menu_title'];?>" href="<?php echo base_url().$menuitem['menu_name'];?>">
											<?php echo $menuitem['menu_title'];?>
										</a>
									<?php }?>
								</li>
							<?php }?>
						</ul>
					</div>
					<!-- .navbar -->

				</div>
			</nav>

		</div>

	</div>

	<!-- #site-navigation -->
</header>
<div class="fixed-bar ci-mail-send" data-toggle="modal" data-target="#myModal-fixed">
	<span class="count-ads"></span>
	<img src="<?php echo base_url();?>theme/frontend/images/right-tab-button.png"/>
</div>