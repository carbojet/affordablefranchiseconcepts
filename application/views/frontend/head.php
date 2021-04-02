<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="ltr">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>Affordable Busindess Concepts LLC </title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<?php
	$description = 'Affordable Business Concepts';
	$keywords = 'Affordable Business Concepts';
	//var_dump($pageObj);
	?>
	<?php if(isset($pageObj) && isset($pageObj->page_meta_description)){ $description = $pageObj->page_meta_description;} ?>
	<?php if(isset($pageObj) && isset($pageObj->page_keywords)){ $keywords = $pageObj->page_keywords;} ?>
	<meta content="<?php echo $description;?>" name="description" />
	<meta content="<?php echo $keywords;?>" name="keywords" />
	
	
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="<?php echo base_url("theme");?>/frontend/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url("theme");?>/frontend/css/bootstrap-select.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url("theme");?>/frontend/css/cyclone_templates_css.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url("theme");?>/frontend/css/font-awesome.min.css?ver=4.3.0" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url("theme");?>/frontend/css/style.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
	<script type='text/javascript' src='<?php echo base_url();?>/theme/frontend/js/jquery.js'></script>
	<script type='text/javascript' src='<?php echo base_url();?>/theme/frontend/js/jquery.cycle.all.min.js?ver=4.3.1'></script>
	<script type='text/javascript' src='<?php echo base_url();?>/theme/frontend/js/bootstrap.min.js?ver=3.3.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>/theme/frontend/js/bootstrap-select.js'></script>
	<link rel="shortcut icon" href="<?php echo base_url("theme");?>/img/icon.png" />

<!-- END HEAD -->