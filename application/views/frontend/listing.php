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
                        echo $this->Chome->getStringBetween($pageObj->post_content);
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