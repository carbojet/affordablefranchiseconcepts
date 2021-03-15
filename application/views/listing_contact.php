<?php
	$this->load->view("head");
?>
</head>
<!-- BEGIN BODY -->
<body>	
	<form method="post" action="http://affordablebusinessconcepts.com/contact-<?php echo $listingObj->listing_id;?>-<?php echo $listingObj->listing_url_1;?>" enctype="multipart/form-data">
    	<input type="hidden" name="msg" value="<?php if(isset($success_msg)){echo $success_msg;}?>">
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