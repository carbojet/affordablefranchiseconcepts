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

    $sidemenu[9] =array("1"=>"active","2"=>array("3"=>"active"));
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
          <h3 class="page-title">Media</h3>
          <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->      
      <div class="row-fluid profile">
        <div class="span12">
          <div>
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                
                <span class="help-inline">Page 	&nbsp; </span>
                <form>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["currentpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["currentpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">

                <?php if($pagination["currentpage"]>0){$pre = $pagination["currentpage"]-1;}else{$pre=0;}
                if($pagination["currentpage"]<$pagination["pages"]){$nxt = $pagination["currentpage"]+1;}else{$nxt=$pagination["pages"];}?>
                <div dir="ltr"> <a href="<?php echo base_url("pages/media_prev/".$pre); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="<?php echo base_url("pages/media_next/".$nxt); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
              </div>
            </div>
            <div style="clear:both"></div>
          </div>
          <!--BEGIN TABS-->
          <div class="row-fluid">
            <div class="span12">
              <!-- BEGIN PORTLET-->
              <div class="portlet">
                <div class="portlet-title">
                  <div class="caption"><i class="icon-list"></i> Manage Media</div>
                  <div class="actions">
                    <div class="btn-group">
                      <button class="btn red dropdown-toggle" data-toggle="dropdown">Add New <i class="icon-angle-down"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url("pages/createmedia/"); ?>"><i class="icon-plus"></i> Add Media </a></li>
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
                  <form name="listing-form" method="post" action="<?php echo base_url("media/delete_selected_media");?>" enctype="multipart/form-data">
                    <table class="table table-bordered table-advance table-hover" id="sample_1">
                      <thead>
                        <tr>
                          <th style="width:8px;"><div class="checker" id="uniform-undefined"><span class="">
                              <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" style="opacity: 0;">
                              </span></div></th>
                          <th class="span10">Image</th>
                          <th class="span2">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($media)){
                          foreach($media as $k=>$post){                            
                            ?>
                        <tr>
                          <td style="padding-top:8px">
                            <div class="checker" id="uniform-undefined">
                              <span class="">
                                <input name="media_status_delete[]" type="checkbox" class="checkboxes" value="<?php echo $post->ID; ?>" style="opacity: 0;">
                              </span>
                            </div>
                          </td>
                          <td style="text-align:left; vertical-align:baseline; padding:10px;">
                            <h5 style="font-weight:700; margin:0;"><?php echo $post->post_title; ?></h5>
                            <?php
                                $url_header = @get_headers(base_url($post->_wp_attached_file));
                                //var_dump($url_header);
                                if($url_header[0] == 'HTTP/1.1 404 Not Found'){
                                  $imgsrc = base_url('uploads/'.$post->_wp_attached_file);
                                }else{
                                  $imgsrc = base_url($post->_wp_attached_file);
                                }
                                
                                //var_dump( unserialize($post->_wp_attachment_metadata));
                            ?>
                            <img src="<?php echo $imgsrc;?>" width="150px" />
                            <!-- property links -->
                            <div class="btn-group"> <a class="btn mini purple dropdown-toggle" data-toggle="dropdown" href="#">Delete <i class="icon-angle-down"></i></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url("pages/deletemedia/".$post->ID);?>"><i class="icon-edit"></i> Delete </a></li>
                              </ul>
                            </div>
                          </td>
                          <td style="padding-right:20px; vertical-align:middle;">                          
                              <!-- details -->
                              <div class="hidden-768" style="margin-left:0px; margin-bottom:5px; margin-top:10px">
                                <div class="span12">
                                  <div class="td_label"><?php echo $post->post_mime_type;?></div>
                                  <div class="td_value"><?php echo date('M Y',strtotime($post->post_date));?></div>
                                  <div class="td_clear"></div>
                                </div>
                                <div class="clearfix"></div>
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
          <div style="padding-bottom:50px">
            <div class="control-group" style="float:left">
              <div class="controls" style="font-weight:bold">
                
                <span class="help-inline">Page 	&nbsp; </span>
                <form>
                  <input type="text" name="navigation_page" value="<?php echo $pagination["currentpage"]; ?>" class="span6 m-wrap" style="width:50px">
                  <input type="hidden" name="currentpage" value="<?php echo $pagination["currentpage"]; ?>">
                  <span class="help-inline">of <?php echo $pagination["pages"]; ?></span>
                </form>
              </div>
            </div>
            <div style="float:right">
              <div class="hidden-480" style="float:right">
                <?php if($pagination["currentpage"]>0){$pre = $pagination["currentpage"]-1;}else{$pre=0;}
                if($pagination["currentpage"]<$pagination["pages"]){$nxt = $pagination["currentpage"]+1;}else{$nxt=$pagination["pages"];}?>

                <div dir="ltr"> <a href="<?php echo base_url("pages/media_prev/".$pre); ?>" class="btn black"><i class="m-icon-swapleft m-icon-white"></i> Prev</a> <a href="<?php echo base_url("pages/media_next/".$nxt); ?>" class="btn black">Next <i class="m-icon-swapright m-icon-white"></i></a> </div>
              </div>
            </div>
            <div style="clear:both"></div>
          </div>
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