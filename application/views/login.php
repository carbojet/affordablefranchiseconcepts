<?php
	$this->load->view("head");
	if($this->session->flashdata('data'))
	{
		extract($this->session->flashdata('data'),EXTR_SKIP);
	}
?>

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="<?php echo base_url(); ?>theme/css/pages/lock.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
</head>
<!-- BEGIN BODY -->
<body>
	<div class="page-lock">
		<div class="page-logo">
			<a class="brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>theme/img/logo.png" alt="logo" /></a>
		</div>
		<div class="page-body" style="padding-top:20px">
			<div class="page-lock-infoleft" style="margin-bottom:30px">				
				<img src="<?php echo base_url(); ?>theme/img/login.png" alt="" style="margin-bottom:10px">
                				
				<div style="text-align:center; color:#000; background-color:#fff; padding:10px 0 10px 0">Security Code :<div style="font-size:20px;font-weight:bold;color:#C10000;display:inline-block;line-height:20px;"><?php echo $captcha; ?></div></div>				
			</div>
			<div class="page-lock-info">			
				<h1>Please Login</h1>
                
                <?php
				
					if(!empty($validation_errors))
					{?>
						<span><em><?php echo $validation_errors; ?></em></span>
				<?php	}
				?>
                <?php
				
					if(!empty($msg))
					{?>
						<span><em><?php echo $msg; ?></em></span>
				<?php	}
				?>				
				<span><em>Please enter your username and password below ...</em></span>			
				<form class="form-search" method="post" action="<?php echo base_url(); ?>login/access" style="margin-top:10px">
                    <div class="input-append" style="margin-bottom:5px;">
                        <div class="input-icon left">
                            <i class="icon-user"></i>
                            <input type="text" name="user_username"	value="" placeholder="Username"	class="m-wrap placeholder-no-fix" style="padding-right:20px !important;"/>
                            <!--<input type="hidden" name="required_user_username" value="text" />-->
                        </div>
                    </div>
                    <div class="input-append" style="margin-bottom:5px">
                        <div class="input-icon left">
                            <i class="icon-lock"></i>
                            <input type="password" 	name="user_password" value="" placeholder="Password" class="m-wrap placeholder-no-fix" style="padding-right:20px !important;"/>
                            <!--<input type="hidden" name="required_user_password" value="text" />-->
                        </div>
                    </div>
                    <div class="input-append" style="margin-bottom:5px">
                        <div class="input-icon left">
                            <i class="icon-key"></i>
                            <input type="text" name="verification_code"	value="" placeholder="Enter Code" class="m-wrap placeholder-no-fix" style="padding-right:20px !important;"/>
                            <input type="hidden" name="required_verification_code" value="<?php echo $captcha; ?>" />
                        </div>
                    </div>
                    <div class="input-append" style="margin-bottom:5px">
                        <button type="submit" class="btn yellow">
                            Login <i class="m-icon-swapright m-icon-white"></i>
                        </button>
                    </div>
                    <!--<div class="relogin">
                        <a href="lost_password">Lost Password? click here</a>
                    </div>-->
				</form>			
			</div>
		</div>
		<div class="page-footer">
			<a href="http://www.affordablebusinessconcepts.com/" style="color:#FC0; background-color:#1b2e44">&copy; Affordable Busindess Concepts LLC</a>
        </div>
	</div>
<?php
	$this->load->view("foot");
?>
</body>
<!-- END BODY -->
</html>