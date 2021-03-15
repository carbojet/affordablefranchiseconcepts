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

    <form method="post" action="http://www.affordablebusinessconcepts.com/add-comment" enctype="multipart/form-data">

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