<?php
    $this->load->view("frontend/head");
?>
    </head>
    <body class="">
        <div class="site">
            <?php
            //var_dump($slug);
                $this->load->view("frontend/header");
            ?>
            <?php if($slug=='home'){?>
            <div class="top-slider">
                <div class="cycloneslider cycloneslider-template-responsive" id="cycloneslider-slider-1">
                    <div class="cycloneslider-slides">
                        <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2021/03/cycloneslider_trans-1400x445.gif" alt="">
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: none; z-index: 6; opacity: 0;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/Phoenix-and-Mountains-1400x445.jpg" alt="slide">
                        </div>
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: none; z-index: 6; opacity: 0;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/For-Lease-3-with-full-number-1400x445.jpg" alt="slide">
                        </div>
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: block; z-index: 7; opacity: 1;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/Popcorn-Mall-Full-Size-1400x445.jpg" alt="slide">
                        </div>
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: none; z-index: 6; opacity: 0;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/Best-Phoenix-Skyline-1400x445.jpg" alt="slide">
                        </div>
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: none; z-index: 6; opacity: 0;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/mall-with-Umbrellas1-1400x445.jpg" alt="slide">
                        </div>
                        <div class="cycloneslider-slide" style="position: absolute; top: 0px; left: 0px; display: none; z-index: 6; opacity: 0;">
                            <img src="https://www.affordablebusinessconcepts.com/wp-content/uploads/2016/01/Casa-Paloma-1400x445.jpg" alt="slide">
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        (function() {
                            var slider = '#cycloneslider-slider-1';
                            jQuery(slider+' .cycloneslider-slides').cycle(
                                {
                                    fx: "fade",
                                    speed: 1000,
                                    timeout: 10000,
                                    pager: jQuery(slider+' .cycloneslider-pager'),
                                    prev: jQuery(slider+' .cycloneslider-prev'),
                                    next: jQuery(slider+' .cycloneslider-next'),
                                    slideExpr: '.cycloneslider-slide',
                                    slideResize: false,	pause:false	
                                }
                            );
                        })();
                    });
                </script>
                <div class="search-sec">
                    <?php
                        echo $this->Chome->do_shortcode('[search_list_form]');
                        //$this->Chome->search_list_form();
                    ?>
                </div>
                <?php echo $this->Chome->do_shortcode('[advanced_search_widget_form]'); ?>

            </div>
            <!-- sticky bar-->
            <div class="sticky-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="sticky-icon">
                            <h4>Executive Expertise</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 cus-text-center">
                            <div>
                            <div style="display:inline-block;padding:20px 9px 20px 0;"><img src="<?php echo base_url()?>/theme/frontend/images/sticky.png"></div>
                            <h4 style="display:inline-block;">Free Entrepreneurial Consulting</h4>
                            <div style="clear:both;"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="sticky-icon">
                                <h4>Insight with Integrity</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <!-- site content start -->
            <div id="content" class="site-content">
                <?php if($slug=='home'){?>
                <div class="bg-slider">
                    <img class="bottom" src="<?php echo base_url(); ?>/theme/frontend/images/bg-men.jpg" />
                    <img class="top" src="<?php echo base_url(); ?>/theme/frontend/images/People-in-Globe1.jpg" />
                </div>
                
                <?php }?>
                <div id="primary" class="content-area-wide container">
                    <?php
                    $result = $this->Chome->getStringBetween($pageObj->post_content);
                    echo $result;
                    ?>
                </div>
            </div>
            <!-- end -->
            <?php
                $this->view('frontend/footer');
            ?>        
        </div>
    <?php
        $this->view('frontend/foot');
    ?>
    </body>

</html>