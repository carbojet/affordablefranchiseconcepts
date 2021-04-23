<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url("theme");?>/css/style_table.css" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<style>
@media (min-width: 1200px) {
 .location {
margin-left:10px !important;
}
}
</style>
</head><!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php

		$this->load->view("menu");

	?>
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
  <?php

    $sidemenu[9] =array("1"=>"active","2"=>array("4"=>"active"));
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
          <h3 class="page-title">Banners</h3>
          <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->      
      <div class="row-fluid profile">
        <div class="span12">

          <!--BEGIN TABS-->
          <div class="row-fluid">
            <div class="span12">
              <!-- BEGIN PORTLET-->
              <div class="portlet">
                <div class="portlet-title">
                  <div class="caption"><i class="icon-list"></i> Manage Banners</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("pages/createbanner/"); ?>"><i class="icon-plus"></i> Add Banner </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet-body">
                  <?php
					if(isset($success_msg)){?>
                  <div class="alert alert-success " style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"><span></span></button>
                    <font style="font-weight:bold">
                    <h3><i class="icon-ok pull-left" style="padding-right:5px;"></i></h3>
                    <div style="min-height:31px; vertical-align:middle;"> <?php echo $success_msg; ?> </div>
                    </font> </div>
                  <?php } ?>
                  <form name="listing-form" method="post" action="<?php echo base_url("pages/delete_selected_banner");?>" enctype="multipart/form-data">
                    <table class="table table-bordered table-advance table-hover" id="sample_1">
                      <thead>
                        <tr>
                          <th class="span10">Image</th>
                          <th class="span2">Operat</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($banners)){
                          foreach($banners as $k=>$post){ ?>
                          <?php //var_dump($post);?>
                        <tr>
                          <td style="text-align:left; vertical-align:baseline; padding:10px;">
                            <h5 style="font-weight:700; margin:0;"><?php echo $post->title; ?></h5>
                            <?php
                                $url_header = @get_headers(base_url($post->_wp_attached_file));
                                //var_dump($url_header);
                                if($url_header[0] == 'HTTP/1.1 404 Not Found'){
                                  $imgsrc = base_url('uploads/'.$post->_wp_attached_file);
                                }else{
                                  $imgsrc = base_url($post->_wp_attached_file);
                                }                                
                            ?>
                            <img src="<?php echo $imgsrc;?>" width="150px" />
                            
                          </td>
                          <td style="padding-right:20px; vertical-align:middle;">                          
                              <!-- property links -->
                              <div class="btn-group"> <a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Option <i class="icon-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                  <li><a href="<?php echo base_url("pages/deletebanner/".$k);?>"><i class="icon-trash"></i> Delete </a></li>
                                </ul>
                              </div> 
                          </td>                          
                        </tr>
                        <?php
                        
                       }
                        
                      }else{ echo "Record Not Found!";}?>
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="gui/ltr/scripts/app.js"></script>
<script>
    jQuery(document).ready(function() { 
        // initiate layout and plugins
        App.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>