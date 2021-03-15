<?php
	$this->load->view("head");
?>
</head>
<!-- BEGIN BODY -->
<body>	
	<form method="post" action="<?php echo base_url("seller_login/reg_access/");?>" enctype="multipart/form-data">
    	<input type="hidden" name="msg" value="<?php if(isset($success_msg)){echo $success_msg;}?>">
        <input type="hidden" name="seller_username" value="<?php echo $seller_username;?>">
        <input type="hidden" name="seller_password" value="<?php echo $seller_password;?>">
        <input type="hidden" name="verification_code" value="12345">
        <input type="hidden" name="required_verification_code" value="12345">
    </form>
<?php
	$this->load->view("foot");
?> 
<script>
	jQuery("document").ready(function(){
		$("form").submit();
	})
</script>   	
</body>
<!-- END BODY -->
</html>