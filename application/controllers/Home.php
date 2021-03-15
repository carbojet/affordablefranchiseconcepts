<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
	  	parent::__construct();
		$this->load->model('Generaldb');
		$this->Chome = & get_instance();
	}		
	public function index(){
        $this->load->view('frontend/home');
	}

	public function search_list_form(){
		//location by ip address
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		else { $ip = $_SERVER['REMOTE_ADDR']; }
		$url = 'http://ip-api.com/php/'.$ip;
		$i = 0; $content=''; $curl_info='';
		$ch = curl_init();
		$curl_opt = array(
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER  => 1,
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 1,
			CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
		);
		if (isset($_SERVER['HTTP_USER_AGENT'])) {$curl_opt[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];}

		curl_setopt_array($ch, $curl_opt);
		$content = curl_exec($ch);
		if (!is_null($curl_info)){$curl_info = curl_getinfo($ch);}
		curl_close($ch);
		$ary = unserialize($content);
		$country = $ary["country"];
		$regionName = $ary["regionName"];
		$sector_array = $this->Generaldb->select_setup_sector_listing(
			array(
				'category_parent'=>0,
				'category_stat_listing'=>1
			)
		);	
		//$edmanagerdb = db_connection();
		//$sector_array = $edmanagerdb->get_results("SELECT category_id,category_name_1 FROM setup_category_listing WHERE category_parent = '0' AND category_stat_listing = '1' ORDER BY category_name_1",ARRAY_A);	
		
		/* ?> */
		?>
		<div class="container text-center" style="background:rgba(0,0,0,0.5);">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
					<h3 style="color:#fff;text-shadow:2px 2px 2px #000;margin-top:2px;" class="srch-title">Search Businesses For Sale</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="search-form">
						<form class="" role="form" action="<?php echo base_url(); ?>/listing/?type=search" method="post">          
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<div class="sec-1">
								
								<select id="categories" class="selectpicker" name="list_state">
									<option value="0">Location</option>
									<?php 
										//$countryArray = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '0' AND location_stat = '1' ORDER BY location_name ASC",ARRAY_A);		
										$countryArray = $this->Generaldb->select_setup_location(
											array(
												'location_parent'=>0,
												'location_stat'=>1
											)
										);
										foreach($countryArray as $row){?>
										<?php $row = (array) $row;?>
										<optgroup label="<?php echo $row['location_name']; ?>">
										<?php 
											//$stat_array = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '".$row['location_id']."' AND location_stat = '1' ORDER BY location_name",ARRAY_A);		
											$stat_array = $this->Generaldb->select_setup_location(
												array(
													'location_parent'=>$row['location_id'],
													'location_stat'=>1
												)
											);
											foreach($stat_array as $state_row){?>
											<?php $state_row = (array) $state_row;?>
											<option value="<?php echo $state_row['location_id']; ?>" <?php if($state_row['location_name'] == $regionName){ ?>selected="selected" <?php } ?>><?php echo $state_row['location_name']; ?></option>
											<?php }?>
										</optgroup>
									<?php }?>
								</select>
								
								</div>
							</div>
							</div>                      
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<div class="sec-2">
									<div id="ajax_cty">
									<select id="categories" class="selectpicker" name="list_city">
									<option value="0">City</option>                    
									</select>
								</div>
								</div>
							</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
							<div class="form-group">
								<div class="sec-3">
								
								<select class="selectpicker" multiple id="list_sector" name="list_sector[]"  data-max-options="100">                    
									<?php foreach($sector_array as $sec_row){ ?>
									<?php $sec_row = (array)$sec_row;?>
									<optgroup label="<?php echo $sec_row['category_name_1']; ?>" data-max-options="100">
									<?php //$cat_array = $edmanagerdb->get_results("SELECT category_id,category_name_1 FROM setup_category_listing WHERE category_parent = '".$sec_row['category_id']."' AND category_stat_listing = '1'",ARRAY_A);			
										$cat_array = $this->Generaldb->select_setup_sector_listing(
											array(
												'category_parent'=>$sec_row['category_id'],
												'category_stat_listing'=>1
											)
										);

										foreach($cat_array as $cat_row){?>
										<?php  $cat_row = (array)$cat_row; ?>
										<option value="<?php echo $cat_row['category_id']; ?>"><?php echo $cat_row['category_name_1']; ?></option>
										<?php } ?>
									</optgroup>
									<?php } ?>
								</select>
								
								</div>
							</div>
							</div>            
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<button type="submit" name="search_now" class="btn btn-warning"><i class="fa fa-search"></i> Search Now </button>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
					<div class="adv_search">
					<h4>Refine your search</h4>
					<div style="display: inline-block;padding: 3px;border: 2px solid #9d8330;border-radius: 5px;">
						<button type="submit" name="search_now" class="btn btn-warning" data-toggle="modal" data-target="#myModal2"><i class="fa fa-search"></i> Advanced Search </button>
					</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

