<?php

	$this->load->view("head");

?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/gritter/css/jquery.gritter.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/jquery-tags-input/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/clockface/css/clockface.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme");?>/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
<!-- END PAGE LEVEL STYLES -->
<script src="<?php echo base_url("theme");?>/scripts/javascript.js" type="text/javascript"></script>
<style>
input[type=checkbox] {
	margin-left:0px !important;
}
.add-new-menu-item{
    display:none;
}
.add-new-menu-item.active{
    display:block;
    position:relative;
}
.nav-menu{
    padding-left:50px;
    width:350px;
}
.nav-menu li.menu-item{
    position:relative;
}
.nav-menu li.menu-item.edit-menu-item>a{
    display:none;
}
.nav-menu>li.menu-item>a .edit-menu-item,.submenu>li.menu-item>a .edit-menu-item{
    position:absolute;
    right:0;
    display:none;
    cursor: pointer;
}
.nav-menu>li.menu-item:hover>a .edit-menu-item,.submenu>li.menu-item:hover>a .edit-menu-item{
    display:inline-block;
}
.add-new-menu-item input[name=menu_name]{
    display:block;
}
.add-new-menu-item.custom-menu input[name=menu_name]{
    display:none;
}
.add-new-menu-item input[name=custom_menu_url]{
    display:none;
}
.add-new-menu-item.custom-menu input[name=custom_menu_url]{
    display:block;
}

</style>
</head><!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php

		$this->load->view("menu");

	?>
<!-- BEGIN CONTAINER -->
<!-- <div class="page-container row-fluid sidebar-closed"> -->
<div class="page-container row-fluid">
  <?php

			$sidemenu[9] =array("1"=>"active","2"=>array("2"=>"active"));
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
          <h3 class="page-title">Page</h3>
          <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
      <?php /*
      <pre>
      <?php var_dump($menu);?>
      </pre>
      */ ?>
      <div class="row-fluid inbox">
        <div class="span12">
          <div class="portlet box grey" style="border-color:#800000;">
            <div class="portlet-title" style="background-color:#800000;">
              <div class="caption"> <i class="icon-edit"></i> Edit Menu <?php echo $menu['name'];?> </div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url('pages/menuupdate/');?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
              	<input type="hidden" name="term_id" value="<?php echo $menu['term_id'];?>"/>
                <div class="alert alert-error <?php if(!isset($validation_errors)){echo "hide";} ?>" style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                    <h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3>
                    <div style="min-height:31px; vertical-align:middle;"> Please fill the following form completely. <br>
                    Fields marked  * are required ... </div>
                </div>
                  
                
                <div class="space20"></div>
                <div class="space20"></div> 
                
                <div class="control-group">
                  <label class="control-label"> Menu Name </label>
                  <div class="controls">
                    <input type="text" name="name" value="<?php echo $menu['name']; ?>" class="span12 m-wrap" />
                  </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <div class="page-list">
                            <div class="control-group">
                                <div class="span12">
                                    <label class="control-label"> Pages </label>
                                </div>
                                <div class="span12">
                                    <ul id="page-list" style="height:250px;overflow:auto;width:100%;">
                                        <?php foreach($pages as $page){?>                                    
                                            <li><label><input type="radio" name="new_menu_page_id" value="<?php echo $page->ID;?>"><?php echo $page->post_title?> </label></li>                                    
                                        <?php }?>
                                    </ul>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="span1"></div>
                                <div class="span11">
                                    <button type="button" class="btn black" style="background-color:#800000;" name="add_page_into_menu">Add Page to Menu</button>
                                </div>
                            </div>
                            <?php /* ?>
                            <div class="control-group">
                                <div class="span1"></div>
                                <div class="span11">
                                    <button type="button" class="btn black" style="background-color:#800000;" name="add_custom_menu">Add custom Menu</button>
                                </div>                                
                            </div>  
                            <?php */ ?>
                        </div>
                    </div>
                    <div class="span8">
                        <div class="control-group">
                            <ul class="nav-menu">
                                <?php foreach($menu['menus'] as $menuitem){?>
                                    <li class="menu-item menu-item-<?php echo $menuitem['menu_id'];?>"><a href="#"><?php echo $menuitem['menu_title'];?><span class="edit-menu-item" id="<?php echo $menuitem['menu_id'];?>"><i class="icon-edit"></i></span></a>
                                        <?php if(isset($menuitem['submenu'])){?>
                                            <ul class="submenu" id="<?php echo $menuitem['menu_id'];?>">
                                            <?php foreach($menuitem['submenu'] as $submenuitem){?>
                                                <li class="menu-item menu-item-<?php echo $submenuitem['menu_id'];?>">
                                                    <a hrerf="#"><?php echo $submenuitem['menu_title'];?><span class="edit-menu-item" id="<?php echo $submenuitem['menu_id'];?>"><i class="icon-edit"></i></span></a>
                                                </li>
                                            <?php }?>
                                            </ul>
                                        <?php }?>
                                    </li>
                                <?php }?>
                                <li style="list-style-type:none;">
                                    <div class="add-new-menu-item">
                                        <div class="control-group">
                                            <input type="text" name="menu_title" value="" class="span12 m-wrap" placeholder="Menu Name" />
                                            <input type="hidden" name="page_id" value="" />
                                            <input type="hidden" name="page_title" value="" />
                                            <input type="hidden" name="menu_id" value="" />
                                            <input type="hidden" name="object_id" value="" />
                                            <input type="hidden" name="term_id" value="<?php echo $menu['term_id'];?>" />
                                            <input type="hidden" name="term_taxonomy_id" value="<?php echo $menu['term_taxonomy_id'];?>" />
                                            <input type="hidden" name="count" value="<?php echo $menu['count'];?>" />
                                            <select name="post_parent" class="span12 m-wrap">
                                                <option value="0">No Parent</option>
                                                <?php foreach($menu['menus'] as $menuitem){?>
                                                <option value="<?php echo $menuitem['menu_id'];?>"><?php echo $menuitem['menu_title'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="control-group">
                                            <div class="span8">
                                                <button type="buttom" class="btn black" style="background-color:#800000;" name="save_menu_item"><i class="icon-ok"></i> Save</button>
                                                <button type="buttom" class="btn black" style="background-color:#800000;" name="cancel_menu"> Cancel</button>
                                            </div>
                                            <div class="span4"><button type="buttom" class="btn black" style="background-color:#800000;" name="remove_menu"><i class="icon-trash"></i> Remove</button></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
              </form>
              <!-- END FORM-->
            </div>
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
<script src="<?php echo base_url("theme");?>/scripts/form-components.js"></script>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/data-tables/DT_bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="gui/ltr/scripts/app.js"></script>
<script>
		var TableManaged = function () {
			return {	
				//main function to initiate the module

				init: function () {				

					if (!jQuery().dataTable) { return; }			

					jQuery('#sample_1 .group-checkable').change(function () {

						var set = jQuery(this).attr("data-set");

						var checked = jQuery(this).is(":checked");

						if (checked) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

						jQuery(set).each(function () {

							if (checked) { $(this).attr("checked", true);$(this).parent().addClass("checked"); } 

							else { $(this).attr("checked", false); $(this).parent().removeClass("checked");}

						});

						jQuery.uniform.update(set);

					});

					jQuery('#sample_1 .checkboxes').change(function(){

						if (jQuery(this).is(":checked")) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

					});					

				}

			};

		}();	
		jQuery(document).ready(function() {       

			// initiate layout and plugins

			App.init();

			TableManaged.init();
            
            jQuery('body').on("click",'span.edit-menu-item',function(e){
                e.preventDefault()
                var Elem = $(this)
                var menuId = $(this).attr('id')
                var element = $("li:last .add-new-menu-item").clone()
                $(element).addClass('active').addClass('edit-menu-item')
                
                var site_url = '<?php echo base_url();?>'+'/pages/ajax_edit_menu_item/'+menuId;
                jQuery.ajax({
                    url:site_url,
                    type:'GET',
                    ContentType : 'application/json',
                    beforeSend:function(){
                    },
                    success:function(response){
                        console.log(response)
                        menuitem = response.result[0]
                        element.find('input[name=menu_title]').val(menuitem.post_title)
                        element.find('input[name=page_title]').val(menuitem.post_title)
                        element.find('select[name=post_parent]').val(menuitem._menu_item_menu_item_parent)
                        element.find('input[name=term_taxonomy_id]').val(menuitem.term_taxonomy_id)
                        element.find('input[name=object_id]').val(menuitem.object_id)
                        element.find('input[name=menu_id]').val(menuitem.menu_id)
                        Elem.closest('li').addClass('edit-menu-item')
                        Elem.closest('li').prepend(element)
                    },
                    error:function(error){
                        console.log(error)
                    }
                })                
                
                
                
            })
            jQuery('body').on("click",'button[name=remove_menu]',function(){
                
                if (window.confirm("Sure Want to Remove ?")) {
                    if($(this).closest('li').hasClass("edit-menu-item")){
                        var site_url = '<?php echo base_url();?>'+'/pages/ajax_remove_menu_item/';
                        var postData = {
                            object_id:$(this).closest('li').find('input[name=object_id]').val(),
                            term_taxonomy_id:$(this).closest('li').find('input[name=term_taxonomy_id]').val(),
                            count:$(this).closest('li').find('input[name=count]').val()
                        }
                        jQuery.ajax({
                            url:site_url,
                            type:'POST',
                            ContentType : 'application/json',
                            data:postData,
                            beforeSend:function(){
                            },
                            success:function(response){
                                console.log(response)
                            },
                            error:function(error){
                                console.log(error)
                            }
                        })
                        $(this).closest('li').remove()
                    }  
                }                            
            })
            jQuery('body').on("click",'button[name=cancel_menu]',function(e){
                e.preventDefault();
                if($(this).closest('li').hasClass("edit-menu-item")){
                    $(this).closest('li').removeClass('edit-menu-item')
                    $(this).closest('.add-new-menu-item').remove()
                }else{
                    $(this).closest('.add-new-menu-item').removeClass('active')
                }                
            })
            jQuery("body").on("click",'button[name=add_custom_menu]',function(){
                $("li:last .add-new-menu-item").addClass('active custom-menu')
                $("li:last .add-new-menu-item").find('input[name=page_title]').val('')
                $("li:last .add-new-menu-item").find('select').val(0)
            })
            jQuery("body").on("click",'button[name=save_menu_item]',function(e){
                e.preventDefault();
                var site_url = '<?php echo base_url();?>'+'/pages/ajax_save_menu_item/';
                var form = $(this).closest('li')
                

                var postData = {
                    'page_id':form.find('input[name=page_id]').val(),
                    'page_title':form.find('input[name=page_title]').val(),
                    'menu_title': form.find('input[name=menu_title]').val(),
                    'menu_id': form.find('input[name=menu_id]').val(),
                    'term_id': form.find('input[name=term_id]').val(),
                    'count': form.find('input[name=count]').val(),
                    
                    'term_taxonomy_id': form.find('input[name=term_taxonomy_id]').val(),
                    "post_parent" : form.find('select[name=post_parent]').val(),
                }
                
                console.log(postData)
                jQuery.ajax({
                    url:site_url,
                    type:'POST',
                    ContentType : 'application/json',
                    data:postData,
                    beforeSend:function(){},
                    success:function(response){
                        console.log(response)
                    },
                    error:function(error){
                        console.log(error)
                    }
                })
            })
            jQuery("body").on("click",'button[name=add_page_into_menu]',function(){
                if($("#page-list input[name=new_menu_page_id]:checked").length>0){
                    $("li:last .add-new-menu-item").find('select').val(0)
                    var page_id = $("#page-list input[name=new_menu_page_id]:checked").attr('value')
                    var site_url = '<?php echo base_url();?>'+'/pages/ajax_get_page/'+page_id;
                    //alert(site_url);  
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            data = eval('(' + xhttp.responseText + ')');
                            if(Object.keys(data).length>0){
                                $("li:last .add-new-menu-item").find('input[name=menu_title]').val(data.page.post_title)
                                $("li:last .add-new-menu-item").find('input[name=page_title]').val(data.page.post_title)
                                $("li:last .add-new-menu-item").find('input[name=menu_name]').val(data.page.post_name)
                                $("li:last .add-new-menu-item").find('input[name=page_id]').val(data.page.ID)
                            	$("li:last .add-new-menu-item").addClass('active').removeClass('custom-menu')
                            }
                        }
                    }
                    xhttp.open("GET", site_url, true);
                    xhttp.send();
                }
            })

		});

		

	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>