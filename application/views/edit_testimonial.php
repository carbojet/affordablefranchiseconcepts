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
h5.modal-title{
    display:inline-block;
}
.media-image{
    width:100%;
    height:120px;
    background-position: center center;
    background-size: cover;
    border: 5px solid #fff;
    border-radius: 2px !important;
    background-repeat: no-repeat;
    position: relative;
}
.media-image:hover {
    cursor: pointer;
    border-color: #dcdcdc;
}
.media-image.active {
    border-color: #1857e8;
}
div#media-popup.in {
    width: 100%;
    height: 100%;
    top: 6%;
    left: 0;
    margin: 0;
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
  <!-- BEGIN SIDEBAR -->
  <!--- lookup database :: sidebar_menu_setup :: done -->
  <!--- lookup database :: sidebar_menu_lookup_general :: done -->
  <!--- lookup database :: sidebar_menu_lookup_directory :: done -->
  <!--- lookup database :: sidebar_menu_lookup_additio	nal :: done -->
  <!--- lookup database :: sidebar_menu_lookup_feature :: done -->
  <!--- seller -->
  <!--- advertiser -->
  <!--- visitor -->
  <!--- listing -->
  <!-- payment -->
  <!-- approval -->
  <?php

            $sidemenu[9] =array("1"=>"active","2"=>array("5"=>"active"));

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
          <h3 class="page-title">Testimonial</h3>
          <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
      <div class="row-fluid inbox">
        <div class="span12">
          <div class="portlet box grey" style="border-color:#800000;">
            <div class="portlet-title" style="background-color:#800000;">
              <div class="caption"> <i class="icon-edit"></i> Edit Testimonial</div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form name="form" id="form" action="<?php echo base_url('pages/updatetestimonial/');?>" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate="novalidate">
                <input type="hidden" name="post_id" value="<?php echo $testimonial->ID;?>"> 
                <div class="alert alert-error <?php if(!isset($validation_errors)){echo "hide";} ?>" style="margin:10px 0 10px 0">
                    <button class="close" data-dismiss="alert" style="margin-top:7px;"></button>
                    <h3><i class="icon-warning-sign pull-left" style="padding-right:5px;"></i></h3>
                    <div style="min-height:31px; vertical-align:middle;"> Please fill the following form completely. <br>
                    Fields marked  * are required ... </div>
                </div>
                <div class="control-group form_field">
                  <label class="control-label">Image </label>
                  <div class="controls">					

                    <div class="selected-image-for-banner"></div>
                    <input name="tss_image" type="text" data-required="0" value="<?php echo $testimonial->tss_image;?>" class="span12 m-wrap" placeholder="image url">
                    <button type="button" class="btn black" style="background-color:#800000;" name="selectimagefrommedia"><i class="icon-img"></i> Select from Media</button>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Name </label>
                  <div class="controls">
                    <input type="text" name="tss_name" value="<?php echo $testimonial->tss_name;?>" class="span12 m-wrap" />
                  </div>
                </div>
                <div class="space20"></div>
                <div class="control-group">
                  <label class="control-label"> Full or Complete Description </label>
                  <div class="controls">
                    <textarea name="tss_testimonial" class="span8 ckeditor m-wrap" rows="6" style="visibility: hidden; display: none;"><?php echo $testimonial->tss_testimonial;?></textarea>
                    <div id="cke_tss_testimonial" class="cke_1 cke cke_reset cke_chrome cke_editor_listing_descfull_1 cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_listing_descfull_1_arialbl"></div>
                  </div>
                </div>
                <div class="control-group">
                    <!-- Modal -->
                    <div class="modal fade" id="media-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Media</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" name="get-image" class="btn btn-primary">Get Image</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn black" style="background-color:#800000;" name="testimonial_new"><i class="icon-ok"></i> Save</button>
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
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("theme");?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script src="<?php echo base_url("theme");?>/scripts/app.js"></script>
<script src="<?php echo base_url("theme");?>/scripts/form-components.js"></script>
<!-- END PAGE LEVEL STYLES -->

<script>

		var FormValidation = function () {

			return {

				//main function to initiate the module

				init: function () {

					var this_form 		= $('#form');

					var this_error 		= $('.alert-error'	, this_form);

					var this_success 	= $('.alert-success', this_form);
					this_form.validate({
						errorElement: 'span', 						// default input error message container
						errorClass: 'help-inline',					// default input error message class
						focusInvalid: false, 						// do not focus the last invalid input
						ignore: "",

						rules: {
						},
						// custom messages for radio buttons and checkboxes
						messages: {														
						},
						// display error alert on form submit   
						invalidHandler: function (event, validator) {
							this_success.hide();
							this_error.show();
							App.scrollTo(this_error, -200);

						},

						// hightlight error inputs

						highlight: function (element) { 

							$(element).closest('.help-inline').removeClass('ok'); // display OK icon

							$(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group

						},

						// revert the change dony by hightlight

						unhighlight: function (element) {

							$(element).closest('.control-group').removeClass('error'); // set error class to the control group

						},

		

						success: function (label) {

							if (label.attr("for") == "service" || label.attr("for") == "membership") { // for checkboxes and radip buttons, no need to show OK icon

								label

									.closest('.control-group').removeClass('error').addClass('success');

								label.remove(); // remove error label here

							} else { // display success icon for other inputs

								label

									.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon

									.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group

							}

						},

		

						submitHandler: function (form) {

							form.submit();

						}

		

					});

		

					// apply validation on chosen dropdown value change, this only needed for chosen dropdown integration.

					$('.chosen, .chosen-with-diselect', this_form).change(function () {

						this_form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input

					});

				}		

			};		

		}();

		

		jQuery(document).ready(function() {   

			// initiate layout and plugins

			

			App.init();

			FormComponents.init();

			FormValidation.init();

            jQuery("body").on("click","button[name=selectimagefrommedia]",function(e){
                e.preventDefault();
                var base_url = '<?php echo base_url("uploads"); ?>';
                jQuery.ajax({
                    type:'POST',
                    url:'<?php echo base_url("pages/ajax_media"); ?>',
                    ContentType : 'application/json',
                    success:function(response){
                        if(response.length>0){
                            var html = '<div class="control-group">';
                            var count = 0;
                            for(k in response){
                                count++;
                                var post = response[k]
                                html +='<div class="span2"><div class="media-image" style="background-image:url('+base_url+'/'+post._wp_attached_file+');" data-url="'+base_url+'/'+post._wp_attached_file+'"></div></div>';
                                if(count==6){
                                    count=0
                                    html +='</div><div class="control-group">';
                                }
                            }
                            if(count<6){
                                html +='</div>';
                            }
                            jQuery("#media-popup").find('.modal-body').html(html)
                            jQuery("#media-popup").modal('show')
                        }
                    }
			    });
                
            })
            jQuery("body").on("click",".media-image",function(){
                $(this).closest(".modal-body").find(".media-image").removeClass("active")
                $(this).addClass("active")
            })
            jQuery("body").on("click","button[name=get-image]",function(){
                var url = $(".modal-body").find(".media-image.active").data("url")
                $("input[name=tss_image]").val(url)
                jQuery("#media-popup").modal('hide')
            })
			jQuery("input[type=checkbox]").click(function(){

				if (jQuery(this).is(":checked")) {jQuery(this).parent().addClass("checked");}else{jQuery(this).parent().removeClass("checked");}

			})	
			jQuery("body").on("change","input[name=post_title]",function(e){
				
				jQuery("input[name=post_name]").val(jQuery("input[name=post_title]").val().toString().replace(/\s/g, '-').replace(/'/g, '-'))
			})
			jQuery("body").on("change","input[name=post_name]",function(e){
				jQuery("input[name=post_name]").val(jQuery("input[name=post_name]").val().toString().replace(/\s/g, '-').replace(/'/g, '-'))
			})
			
			///////////////////////////////Add button for Sector and category///////////////////////////
			
			jQuery("body").on("click","button[name=listing_new]",function(e){
			
				if(jQuery("input[name=listing_category_count]").val()==3)
				{
					e.preventDefault();
					alert("You must add 3 category list");
				}
				
			});
			jQuery("body").on("click","button[name=addbutton]",function(){
				len = jQuery("select.listing_sector").length+1;	
				if(len<=3){
				addrow = jQuery(this).closest(".form_field").clone();
				addrow.find("div.adbtn").remove();
				addrow.find(".add_div").append('< class="span2 adbtn"><button type="button" name="addbutton" class="btn btn-default addButton"><i class="icon-plus"></i></button><button type="button" name="minusbutton" class="btn btn-default addButton"><i class="icon-minus"></i></button></>');

				addrow.find("select.listing_sector").attr("onchange","jQuery.fn.ajax_category_list(this.value,"+len+");");
				addrow.find(".listing_category").attr({"id":"listing_category_"+len});
				jQuery(this).closest(".form_field").after(addrow);
				jQuery(this).closest(".form_field").find("div.adbtn").remove();
				jQuery("listing_category_count").val(len)
				}
				
			})
			
			jQuery("body").on("click","button[name=minusbutton]",function(){
				
				prevrow = jQuery(this).closest(".form_field").prev();
				prevrow.find(".add_div").append('<div class="span2 adbtn"><button type="button" name="addbutton" class="btn btn-default addButton"><i class="icon-plus"></i></button><button type="button" name="minusbutton" class="btn btn-default addButton"><i class="icon-minus"></i></button></div>');
				if(len = jQuery("select.listing_sector").length>1){
					jQuery(this).closest(".form_field").remove();				
				}
				
			})
					

		});

		CKEDITOR.replace( '', { language: 'en' });

	</script>
<script>

	jQuery.fn.ajaxLog = function()

		{

			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("login/ajax_log_status"); ?>',

				ContentType : 'application/json',

				success:function(data){

					if(data.log_status>0)

					{

						window.location.assign('<?php echo base_url("login"); ?>');

					}

				}

			});

		}

		setInterval(jQuery.fn.ajaxLog,1000);

		jQuery.fn.ajaxLog();

		jQuery.fn.ajax_location_list = function(id,level){

			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("listing/ajax_location_list"); ?>'+'/'+id,

				ContentType : 'application/json',

				success:function(data){

					if(Object.keys(data).length>0)

					{					

						$("#listing_location_"+level).find("select option").remove();
						
						jQuery("#listing_location_"+level).find("select").append('<option value="">All</option>')

						//for(var key in data){
						jQuery.each(data,function(key,obj){  

						$("#listing_location_"+level).find("select").append('<option value="'+obj.id+'">'+obj.location_name+'</option>')

						})
						//}						

					}

				}

			});

		}

		jQuery.fn.ajax_category_list = function(id,level)

		{
			
			jQuery.ajax({

				type:'POST',

				url:'<?php echo base_url("listing/ajax_category_list"); ?>'+'/'+id,

				ContentType : 'application/json',

				success:function(data){
					if(Object.keys(data).length>0)

					{

						$("#listing_category_"+level).find("select option").remove();

						for(var key in data){

						$("#listing_category_"+level).find("select").append('<option value="'+key+'">'+data[key]+'</option>')

						}						

					}

				}

			});
			

		}
		

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>