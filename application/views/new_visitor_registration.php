<?php

	$this->load->view("head");

?>

	<!-- END PAGE LEVEL STYLES -->

</head>

<!-- BEGIN BODY -->

<body class="fixed-top">	

	<!-- BEGIN HEADER -->

	<?php

		$this->load->view("menu");

	?>

    <form method="post" action="http://www.affordablebusinessconcepts.com/directory/visitor/access" enctype="multipart/form-data">

    <input type="hidden" name="visitor_username" value="<?php echo $visitor_username;?>">

    <input type="hidden" name="visitor_password" value="<?php echo $visitor_password;?>">

    <input type="hidden" name="listing_id" value="<?php echo $listing_id;?>" /> 

    <input type="hidden" name="redirect_page" value="<?php echo $redirect_page;?>" />

    </form>

<?php

	$this->load->view("foot");

?>

<script>

	$("document").ready(function(){

		$("form").submit();

	})

</script>

<!-- END JAVASCRIPTS -->	

</body>

<!-- END BODY -->

</html>