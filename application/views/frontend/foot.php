<script type='text/javascript' src='<?php echo base_url();?>theme/frontend/js/autoNumeric.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>theme/frontend/js/jquery-ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>theme/frontend/js/custom-javascript.js'></script>
<script type="text/javascript">
				jQuery(document).ready(function(){
					(function() {
						var slider = "#cycloneslider-slider-44";
						jQuery(slider+" .cycloneslider-slides").cycle(
							{
								fx: "fade",
								speed: 1000,
								timeout: 10000,
								pager: jQuery(slider+" .cycloneslider-pager"),
								prev: jQuery(slider+" .cycloneslider-prev"),
								next: jQuery(slider+" .cycloneslider-next"),
								slideExpr: ".cycloneslider-slide",
								slideResize: false,	pause:false	
							}
						);
					})();
				});
			</script>