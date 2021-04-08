<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shortcodes extends CI_Model {
    public function __construct(){
		parent::__construct();
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
        $sector_array = $this->db->get_where("setup_category_listing",array(
				'category_parent'=>0,
				'category_stat_listing'=>1
			))->result();
			
		
		$html ='<div class="container text-center" style="background:rgba(0,0,0,0.5);">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
					<h3 style="color:#fff;text-shadow:2px 2px 2px #000;margin-top:2px;" class="srch-title">Search Businesses For Sale</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="search-form">
						<form class="" role="form" action="'.base_url().'products/" method="post">          
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<div class="sec-1">
								
								<select id="categories" class="selectpicker" name="list_state">
									<option value="0">Location</option>';
									
                                        $countryArray = $this->db->get_where("setup_location",array(
												'location_parent'=>0,
												'location_stat'=>1
											))->result();
										
										foreach($countryArray as $row){
											$row = (array) $row;
											$html .='<optgroup label="'.$row['location_name'].'">';
											
												$stat_array = $this->db->get_where("setup_location",array(
														'location_parent'=>$row['location_id'],
														'location_stat'=>1
													))->result();
												foreach($stat_array as $state_row){
													$state_row = (array) $state_row;
													$html .='<option value="'.$state_row['location_id'].'"';
													if($state_row['location_name'] == $regionName){
														$html .='selected="selected"';
													} 
													$html .='>'.$state_row['location_name'].'</option>';
												}
											$html .='</optgroup>';
										}
								$html .='</select>								
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
								
								<select class="selectpicker" multiple id="list_sector" name="list_sector[]"  data-max-options="100">';                    
									foreach($sector_array as $sec_row){
										$sec_row = (array)$sec_row;
										$html .='<optgroup label="'.$sec_row['category_name_1'].'" data-max-options="100">';
									
                                    	$cat_array = $this->db->get_where("setup_category_listing",array(
												'category_parent'=>$sec_row['category_id'],
												'category_stat_listing'=>1
											))->result();

										foreach($cat_array as $cat_row){
											$cat_row = (array)$cat_row;
											$html .='<option value="'.$cat_row['category_id'].'">'.$cat_row['category_name_1'].'</option>';
										} 
									$html .='</optgroup>';
									}
								$html .='</select>
								
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
		</div>';
		return $html;
	}
	

	
	public function ads_rotation(){
		//$edmanagerdb = db_connection();
		
		$featured_array = $this->db->get_where("listing",array("listing_status_feature"=>'featured'))->result();
		$fc_to=4;
		$featured_pages = ceil(count($featured_array)/$fc_to);
		$new_array = $this->db->get_where("listing",array("listing_status_new"=>'renew'))->result();
		$nc_to=4;
		$new_pages = ceil(count($new_array)/$nc_to);
		$this->db->where("contractor_listing_setting_id",1)->update('contractor_listing_setting', array("fc_page"=>$featured_pages,"nc_page"=>$new_pages));
		
		//$edmanagerdb->update("contractor_listing_setting",array("fc_page"=>$featured_pages,"nc_page"=>$new_pages),array("contractor_listing_setting_id"=>1));
		
		$ads_rotation = $this->db->get("contractor_listing_setting")->result();
		
		//$ads_rotation = $edmanagerdb->get_results("SELECT * FROM contractor_listing_setting",ARRAY_A);
		$current_date_time = date("Y-m-d H:i:s");
		if(count($ads_rotation)>0){
			foreach($ads_rotation as $row){
				$row = (array) $row;
				$feature_contractor_time_span = $row["feature_contractor_time_span"];
				$last_loop_time_fc = $row["last_loop_time_fc"];
				$fc_current_page = $row["fc_current_page"];
				$fc_page = $row["fc_page"];						
				
				$featured_array = $this->db->get_where("listing",array("listing_lastupdate"=>$last_loop_time_fc,"listing_status_feature"=>"featured"))->result();
				//$featured_array = $edmanagerdb->get_results("SELECT * FROM listing WHERE listing_lastupdate >= '$last_loop_time_fc' AND listing_status_feature='featured'",ARRAY_A);
				
				$d = date("d",strtotime($last_loop_time_fc));
				$m = date("m",strtotime($last_loop_time_fc));
				$y = date("Y",strtotime($last_loop_time_fc));
				$h = date("H",strtotime($last_loop_time_fc));
				$i = date("i",strtotime($last_loop_time_fc));
				$s = date("s",strtotime($last_loop_time_fc));
				$fc_execute_time = date("Y-m-d H:i:s",mktime($h+$feature_contractor_time_span,$i,$s,$m,$d,$y));
				if($current_date_time>=$fc_execute_time){
					$fc_current_page++;
					if($fc_page>$fc_current_page){
						$fc_from = $fc_current_page*$fc_to;
					}else{
						$fc_current_page=0;
						$fc_from = 0;
					}
					$this->db->where("contractor_listing_setting_id",1)->update("contractor_listing_setting",array("fc_current_page"=>$fc_current_page,"last_loop_time_fc"=>$current_date_time));
					//$edmanagerdb->update("contractor_listing_setting",array("fc_current_page"=>$fc_current_page,"last_loop_time_fc"=>$current_date_time),array("contractor_listing_setting_id"=>1));
				}elseif(count($featured_array)>0){
					$this->db->where("contractor_listing_setting_id",1)->update("contractor_listing_setting",array("fc_current_page"=>0,"last_loop_time_fc"=>$current_date_time));
					//$edmanagerdb->update("contractor_listing_setting",array("fc_current_page"=>0,"last_loop_time_fc"=>$current_date_time),array("contractor_listing_setting_id"=>1));
					$fc_from = 0;
				}else{
					$fc_from = $fc_current_page;
				}
				$new_contractor_time_span = $row["new_contractor_time_span"];			
				$last_loop_time_nc = $row["last_loop_time_nc"];			
				$nc_current_page = $row["nc_current_page"];			
				$nc_page = $row["nc_page"];
				$new_array = $this->db->get_where("listing",array("listing_lastupdate"=>$last_loop_time_nc,"listing_status_new"=>"renew"))->result();
				//$new_array = $edmanagerdb->get_results("SELECT * FROM listing WHERE listing_lastupdate >= '$last_loop_time_nc' AND listing_status_new='renew'",ARRAY_A);
				$d = date("d",strtotime($last_loop_time_nc));
				$m = date("m",strtotime($last_loop_time_nc));
				$y = date("Y",strtotime($last_loop_time_nc));
				$h = date("H",strtotime($last_loop_time_nc));
				$i = date("i",strtotime($last_loop_time_nc));
				$s = date("s",strtotime($last_loop_time_nc));
				$nc_execute_time = date("Y-m-d H:i:s",mktime($h+$new_contractor_time_span,$i,$s,$m,$d,$y));
				if($current_date_time>=$nc_execute_time){
					$nc_current_page++;
					if($nc_page>$nc_current_page){
						$nc_from = $nc_current_page*$nc_to;
					}else{
						$nc_current_page=0;
						$nc_from = 0;
					}
					$this->db->where("contractor_listing_setting_id",1)->update("contractor_listing_setting",array("nc_current_page"=>$nc_current_page,"last_loop_time_nc"=>$current_date_time));
					//$edmanagerdb->update("contractor_listing_setting",array("nc_current_page"=>$nc_current_page,"last_loop_time_nc"=>$current_date_time),array("contractor_listing_setting_id"=>1));
				}elseif(count($new_array)>0){
					$this->db->where("contractor_listing_setting_id",1)->update("contractor_listing_setting",array("nc_current_page"=>0,"last_loop_time_nc"=>$current_date_time));
					//$edmanagerdb->update("contractor_listing_setting",array("nc_current_page"=>0,"last_loop_time_nc"=>$current_date_time),array("contractor_listing_setting_id"=>1));
					$nc_from = 0;
				}else{
					$nc_from = $nc_current_page;
				}
			}
		}else{
			$this->db->insert("contractor_listing_setting",array(
				"fc_page"=>$featured_pages,
				"nc_page"=>$new_pages,
				"last_loop_time_nc"=>$current_date_time,
				"last_loop_time_fc"=>$current_date_time,
				"new_contractor_time_span"=>24,
				"feature_contractor_time_span"=>24
			));
			//$edmanagerdb->insert("contractor_listing_setting",array("fc_page"=>$featured_pages,"nc_page"=>$new_pages,"last_loop_time_nc"=>$current_date_time,"last_loop_time_fc"=>$current_date_time,"new_contractor_time_span"=>24,"feature_contractor_time_span"=>24));
			$fc_from = 0;$nc_from = 0;
		}
		$fc_from = $fc_from*4;
		$nc_from = $nc_from*4;
		return array("fc_from"=>$fc_from,"fc_to"=>$fc_to,"nc_from"=>$nc_from,"nc_to"=>$nc_to);
		
	}

	public function featured_list($args=array()){
		//var_dump($args);
		$arg_array = array('limit' => null,'view_type'=> 'list');
		$ads_rotation = $this->ads_rotation();		
		
		//Shortcode arguments
		
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		//var_dump($arg_array);
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}

		if($arg_array['view_type']=="list"){
			$from = $ads_rotation["fc_from"];
			$to = $ads_rotation["fc_to"];
			$featured_array = $this->db->limit($to,$from)->order_by("listing_lastupdate","DESC")->get_where("listing",array("listing_status_feature"=>"featured"))->result();
		}else{
			$featured_array = $this->db->limit($limit)->order_by("listing_lastupdate","DESC")->get_where("listing",array("listing_status_feature"=>"featured"))->result();
		}

		$html = '<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="listing-title">Featured Listings</h3>
			</div>
		</div>';
		$i = 0; 
		//$arg_array['view_type'];
		foreach($featured_array as $row){
			$row = (array) $row;
			//var_dump($row);
			if(!empty($row["listing_image"])){
				$url = base_url().'photo_big/'.$row['listing_image'];
			}else{
				$url = base_url().'photo_big/'.$row['listing_id'].'.jpg';
			}
			$url_header = @get_headers($url);

			$rating_array = $this->db->limit(1)->order_by("comment_id","DESC")->get_where("visitor_comment",array("comment_linkid"=>$row['listing_id']))->result();			
			//$rating_array = $edmanagerdb->get_results("SELECT * FROM visitor_comment WHERE comment_linkid = '".$row['listing_id']."' ORDER BY comment_id DESC LIMIT 1",ARRAY_A);	
			
			$comment_rating=0;
			foreach($rating_array as $rating_row){ $comment_rating = $rating_row->comment_rating; }
			$photo_array = $this->db->limit(1)->get_where("listing_photo",array("photo_listing"=>$row['listing_id'],"photo_status_main"=>"main"))->result();
			//$photo_array = $edmanagerdb->get_results("SELECT * FROM listing_photo WHERE photo_listing = '".$row['listing_id']."' AND photo_status_main = 'main' LIMIT 1",ARRAY_A);
			
			foreach($photo_array as $photo_row){ $photo_id = $photo_row['photo_id']; }

			if(empty($photo_id)){$photo_id = "sample";}
			//List View Type Check
			$loc = explode("-",$row['listing_location_path']);
			$country_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[1]))->get()->result();
			//$country_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[1]."'",ARRAY_A);
			$state_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[2]))->get()->result();
			//$state_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[2]."'",ARRAY_A);
			$city_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[3]))->get()->result();
			//$city_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[3]."'",ARRAY_A);

			foreach($country_arr as $country_rw){ $country = $country_rw->location_name; }
			foreach($state_arr as $state_rw){ $state = $state_rw->location_name; }
			foreach($city_arr as $city_rw){ $city = $city_rw->location_name; }

			if($arg_array['view_type'] == 'list'){
				
				$html .='<div class="featured-listing">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="img-hover">';
								if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
									$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
										<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%" />
									</a>';
								}else{
									$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
										<img class="img-responsive" src="'.$url.'" width="100%" />
									</a>';
								}
							$html .='</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<h5><a href="'.base_url().'product/'.$row['listing_slug'].'">'.$row['listing_title_1'].'</a></h5>
							<p class="text-left"><a href="'.base_url().'product/'.$row['listing_slug'].'">'.substr(strip_tags($row['listing_descbrief_1']),0,180)."...".'</a></p>
							<span class="rating" style="margin-right:15px;">'.$city.", ".$state.'</span><br/><span class="rating">Investment: $'.number_format($row['listing_price']).'</span>
						</div>
					</div>
				</div>';
			}elseif($arg_array['view_type'] == 'grid'){
				 
				//var_dump($row);
				if($i==0){
				$html .='<div class="row">';
				}$i++;
					$html .='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="featured-listing">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="img-hover" data-toggle="tooltip" title="click for more info">';
										if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
											$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
												<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%" />
											</a>';      		
										}else{
											$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
												<img class="img-responsive" src="'.$url.'" width="100%" />
											</a>';
										}
									$html .='</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h5><a href="'.base_url().'product/'.$row['listing_slug'].'">'.$row['listing_title_1'].'</a></h5>
									<p class="text-justify"><a style="color:#555;" href="'.base_url().'product/'.$row['listing_slug'].'"></a></p>
									<span class="rating" style="margin-right:15px;">'.$city.'</span><br/>
									<span class="rating" style="margin-right:15px;">'.$state.'</span><br/>
									<span class="rating">Investment: $'.number_format($row['listing_price']).'</span><br/>
									<span class="cross-btn"><input class="selected_ad_id" type="checkbox" name="selected_ad_id[]" value="'.$row['listing_id'].'" />Request AD #'.$row['listing_id'].'<input type="hidden" name="ad_title[]" value="'.$row['listing_title_1'].'"/></span>
								</div>
							</div>
						</div>
					</div>';
				if($i==4){ $i = 0;
				$html .='</div>';
				}
			}
		}
		if($arg_array['view_type'] != 'grid'){
			$html .='<a style="float:right;color:#000;" href="'.base_url().'featured-list/" class="btn btn-warning btn-xs">View More</a>';
		}
		return $html;
	}

	public function new_listing($args=array()){
		$arg_array = array('limit' => null,'view_type' => 'list');
		$html ='';
		$ads_rotation = $this->ads_rotation();

		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}
		$from = $ads_rotation["nc_from"];
		$to = $ads_rotation["nc_to"];
		if($arg_array['view_type']=="list"){	
			$from = $ads_rotation["nc_from"];
			$to = $ads_rotation["nc_to"];
			$new_array = $this->db->limit($to,$from)->order_by('listing_lastupdate',"DESC")->get_where("listing",array("listing_status_new"=>"renew"))->result();
		}else{
			$new_array = $this->db->limit($limit)->order_by('listing_lastupdate',"DESC")->get_where("listing",array("listing_status_new"=>"renew"))->result();
		}
		
		
		//$new_array = $edmanagerdb->get_results("SELECT * FROM listing WHERE listing_status_new='renew' ORDER BY listing_lastupdate DESC $limit",ARRAY_A);
		$html ='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    	<h3 class="listing-title">New Listings</h3>
			</div>
		</div>';
		$i = 0;
		foreach($new_array as $row){
			$row = (array) $row;
    		
			if(!empty($row["listing_image"])){
				$url = base_url().'photo_big/'.$row['listing_image'];
			}else{
				$url = base_url().'photo_big/'.$row['listing_id'].'.jpg';
			}
			
			$url_header = @get_headers($url);
			
			$rating_array = $this->db->order_by("comment_id","DESC")->get_where("visitor_comment",array("comment_linkid"=>$row['listing_id']))->result();
			//$rating_array = $edmanagerdb->get_results("SELECT * FROM visitor_comment WHERE comment_linkid = '".$row['listing_id']."' ORDER BY comment_id DESC LIMIT 1",ARRAY_A);
			$comment_rating=0;
			foreach($rating_array as $rating_row){ $comment_rating = $rating_row->comment_rating; }
			$photo_array = $this->db->get_where("listing_photo",array("photo_listing"=>$row['listing_id'],"photo_status_main"=>"main"))->result();
			//$photo_array = $edmanagerdb->get_results("SELECT * FROM listing_photo WHERE photo_listing = '".$row['listing_id']."' AND photo_status_main = 'main' LIMIT 1",ARRAY_A);
			foreach($photo_array as $photo_row){ $photo_id = $photo_row->photo_id; }
			if(empty($photo_id)){$photo_id = "sample";}
			//List View Type Check
			$loc = explode("-",$row['listing_location_path']);
			$country_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[1]))->get()->result();
			//$country_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[1]."'",ARRAY_A);
			$state_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[2]))->get()->result();
			//$state_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[2]."'",ARRAY_A);
			$city_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id"=>$loc[3]))->get()->result();
			//$city_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[3]."'",ARRAY_A);
			foreach($country_arr as $country_rw){ $country = $country_rw->location_name; }
			foreach($state_arr as $state_rw){ $state = $state_rw->location_name; }
			foreach($city_arr as $city_rw){ $city = $city_rw->location_name; }
		    if($arg_array['view_type'] == 'list'){
				
				$html .='<div class="new-listing">
  					<div class="row">
					    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					    	<div class="img-hover">';
      							if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
						        	$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
							        	<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%" />
						            </a>';
	  							}else{
						        	$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'">
							            <img class="img-responsive" src="'.$url.'" width="100%" />
						            </a>';
						        }
							$html .='</div>
					    </div>
    					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
      						<h5><a href="'.base_url().'product/'.$row['listing_slug'].'">'.$row['listing_title_1'].'</a></h5>
      						<p class="text-left"><a href="'.base_url().'product/'.$row['listing_slug'].'">'.substr($row['listing_descbrief_1'],0,180).'...</a></p>
      						<span class="rating" style="margin-right:15px;">'.$city.', '.$state.'</span><br/><span class="rating">Investment: $'.number_format($row['listing_price']).'</span>
					    </div>
					</div>
				</div>';
				
			}elseif($arg_array['view_type'] == 'grid'){ 
				if($i==0){
					$html .='<div class="row">';
  				}$i++;
				  
				$html .='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
    				<div class="new-listing">
      					<div class="row">
					        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						        <div class="img-hover" data-toggle="tooltip" title="click for more info">';
									if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
										$html .='<a href="'.base_url().'product/?listing_id='.$row['listing_id'].'">
											<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%" />
										</a>';      		
									}else{
										$html .='<a href="'.base_url().'product/?listing_id='.$row['listing_id'].'">
											<img class="img-responsive" src="'.$url.'" width="100%" />
										</a>';
									}
        						$html .='</div>
					        </div>
        					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						        <h5><a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">'.$row['listing_title_1'].'</a></h5>
						        <p class="text-justify"><a style="color:#555;" href="'.base_url().'/product/?listing_id='.$row['listing_id'].'"></a></p>
								<span class="rating" style="margin-right:15px;">'.$city.'</span><br/>
					      		<span class="rating" style="margin-right:15px;">'.$state.'</span><br/>
						        <span class="rating">Investment: $'.number_format($row['listing_price']).'</span><br/>
							    <span class="cross-btn"><input class="selected_ad_id" type="checkbox" name="selected_ad_id[]" value="'.$row['listing_id'].'" />Request AD #'.$row['listing_id'].' <input type="hidden" name="ad_title[]" value="'.$row['listing_title_1'].'"/></span>
					        </div>
    					</div>
				    </div>
				</div>';
				
				if($i==4){ $i = 0;
					$html .='</div>';
				}
			}
			
		}
		if($arg_array['view_type'] != 'grid'){
			$html .='<a style="float:right;color:#000;" href="'.base_url().'new-listing/" class="btn btn-warning btn-xs">View More</a>';
		}
		return $html;
	}

	public function advanced_search_widget_form(){
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
		if (isset($_SERVER['HTTP_USER_AGENT'])) $curl_opt[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt_array($ch, $curl_opt);
		$content = curl_exec($ch);
		if (!is_null($curl_info)) $curl_info = curl_getinfo($ch);
		curl_close($ch);
		$ary = unserialize($content);
		$country = $ary["country"];
		$regionName = $ary["regionName"];

		$sector_array = $this->db->select("category_id,category_name_1")->from("setup_category_listing")->where(array("category_parent" => '0', "category_stat_listing" => '1'))->order_by("category_name_1","ASC")->get()->result();
		//$sector_array = $edmanagerdb->get_results("SELECT category_id,category_name_1 FROM setup_category_listing WHERE category_parent = '0' AND category_stat_listing = '1' ORDER BY category_name_1",ARRAY_A);


		$html ='<div id="myModal2" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close adv-reset-close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Advanced Search</h4>
			</div>
			<div class="modal-body">
				<form name="advance_search" action="'.base_url().'/listing/?type=search" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="control-label">Ad ID:</label>
						<input type="text" class="form-control" name="list_seller_username" placeholder="Ad ID">
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="control-label">Location:</label>
						<select id="categories" class="form-control advance-list-state" name="list_state" ng-model="type">
							<option value="0">Location</option>';
					$countryArray = $this->db->order_by("location_name","ASC")->get_where("setup_location",array(
						"location_parent" => '0',
						"location_stat" => '1'
					))->result();
                    //$countryArray = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '0' AND location_stat = '1' ORDER BY location_name ASC",ARRAY_A);		
					foreach($countryArray as $row){
						$row = (array) $row;
                    	$html .='<optgroup label="'.$row['location_name'].'">';
						$stat_array = $this->db->order_by("location_name","ASC")->get_where("setup_location",array(
							"location_parent" =>$row['location_id'],
							"location_stat" => '1'
						))->result();
                    	//$stat_array = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '".$row['location_id']."' AND location_stat = '1' ORDER BY location_name ASC",ARRAY_A);			
						foreach($stat_array as $state_row){
							$state_row = (array) $state_row;
                    		$html .='<option value="'.$state_row['location_id'].'"';
							if($state_row['location_name'] == $regionName){
								$html .='selected="selected"';
							}
							$html .='>'.$state_row['location_name'].'</option>';
                    	}
                    	$html .='</optgroup>';
                    }                    
                $html .='</select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">City:</label>
                <div id="ajax_city">';
				$state_array = $this->db->select("location_id,location_name")->from("setup_location")->where(array(
					"location_name" =>$regionName
				))->get()->result();
				
				//$state_array = $edmanagerdb->get_results("SELECT location_id,location_name FROM setup_location WHERE location_name = '".$regionName."'",ARRAY_A); 
				
                $html .='<select id="categories" class="form-control" name="list_city" ng-model="type">
                	<option value="0">All</option>';
					if(count($state_array)>0){
					foreach($state_array as $state_row){ $parent_id = $state_row['location_id']; }
				    $city_array = $edmanagerdb->get_results("SELECT location_id,location_name FROM setup_location WHERE location_parent = '".$parent_id."'",ARRAY_A); 
						foreach($city_array as $city_row){
                    	$html .='<option value="'.$city_row['location_id'].'">'.$city_row['location_name'].'</option>';
                    	}
					}
                $html .='</select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Industry:</label>
                <select class="form-control ajax_category_list" id="list_sector" name="list_sector">
                  <option value="0">Select Industry</option>';
                  	foreach($sector_array as $sector_row){
						$sector_row = (array) $sector_row;
                  		if($sector_row['category_name_1']=="Franchise Resales"){$style='style="font-weight:bold;"';}else{$style="";}
                		$html .='<option value="'.$sector_row['category_id'].'" '.$style.'>'.$sector_row['category_name_1'].'</option>';
                	}
                $html .='</select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Category:</label>
                <div id="listing_category_1">
                  <select class="form-control" id="list_category" name="list_category" >
                    <option value="0">Category</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Investment Level:</label>';
                if(isset($_POST["list_invest_level"])){$list_invest_level = $_POST["list_invest_level"];}else{$list_invest_level="";}
					$list_invest_level_array = array(				 
						"<=100000"=>"Less Than $100K",
						"<=200000"=>"Less Than $200K",
						"<=300000"=>"Less Than $300K",
						"<=400000"=>"Less Than $400K",
						"<=500000"=>"Less Than $500K",
						">=500000"=>"Greater Than $500K",
						""=>"All Investment Levels",
					); 
				
                $html .='<select class="form-control" id="invest-level" name="list_invest_level">';
                   	foreach($list_invest_level_array as $k=>$v){
                   		if($list_invest_level==$k){       	
                        	$html .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
                        }else{
                        	$html .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
                        }
                  	}
						$html .='</select>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label class="control-label">Search Keyword:</label>
						<input type="text" class="form-control" value="" name="list_search_keywork" placeholder="Search Keyword...">
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group">
						<button type="submit" name="search_now" class="btn btn-warning"><i class="fa fa-search"></i> Search Now </button>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group">
						<button type="reset" name="reset" class="btn btn-warning adv-reset"><i class="fa fa-recycle"></i> Modify Search </button>
					</div>              
					</div>
				</div>
				</form>
			</div>
			</div>
		</div>
		</div>';
		
		return $html;
	}


	public function listing_description($params=array()){	
		$html = '';
		if(isset($_REQUEST["visitor_tel"])){			
	    	$html .='<div class="query_content">';		
			$visitor_name_title = $_REQUEST["title"];
			$visitor_first_name = $_REQUEST["visitor_first_name"];
			$visitor_last_name = $_REQUEST["visitor_last_name"];
			$visitor_email = $_REQUEST["visitor_email"];
			$visitor_tel = $_REQUEST["visitor_tel"];
			$visitor_strt_add_one = $_REQUEST["visitor_strt_add_one"];
			$visitor_strt_add_two = $_REQUEST["visitor_strt_add_two"];
			$visitor_city = $_REQUEST["visitor_city"];
			$visitor_st_pro = $_REQUEST["visitor_st_pro"];
			$visitor_country = $_REQUEST["visitor_country"];
			$visitor_zip = $_REQUEST["visitor_zip"];
			$visitor_capital_invest = $_REQUEST["visitor_capital_invest"];
			$visitor_est_nt_worth = $_REQUEST["visitor_est_nt_worth"];
			$visitor_time_frame = $_REQUEST["visitor_time_frame"];
			$visitor_eesired_location = $_REQUEST["visitor_eesired_location"];
			$visitor_comments = $_REQUEST["comments"];
			$listing_id = $_REQUEST["listing_id"];
			if(isset($_REQUEST["chk1"])){
				$im_interest = $_REQUEST["chk1"][0];
			}
			$visitor_username = mt_rand(1000000000,9999999999);
			$visitor_password = mt_rand(1000000000,9999999999);
			$comment_visitor = $this->db->insert("visitor",array("visitor_username"=>$visitor_username,"visitor_password"=>$visitor_password,"visitor_title"=>$visitor_name_title,"visitor_firstname"=>$visitor_first_name,"visitor_lastname"=>$visitor_last_name,"visitor_email"=>$visitor_email,"visitor_phone"=>$visitor_tel,"visitor_address"=>$visitor_strt_add_one,"visitor_address2"=>$visitor_strt_add_two,"visitor_city"=>$visitor_city,"visitor_province"=>$visitor_st_pro,"visitor_zip"=>$visitor_zip,"visitor_country"=>$visitor_country,"visitor_company"=>$visitor_capital_invest,"visitor_mobile"=>$visitor_est_nt_worth,"visitor_fax"=>$visitor_time_frame,"visitor_website"=>$visitor_eesired_location,"visitor_logo"=>$visitor_comments,"visitor_lastupdate"=>date("Y-m-d H:i:s")));
			//$comment_visitor = $this->db->insert_id;
			//getting ip address
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
			else { $ip = $_SERVER['REMOTE_ADDR']; }
			$this->db->insert("visitor_comment",array("comment_type"=>"listing","comment_linkid"=>$listing_id,"comment_visitor"=>$comment_visitor,"comment_rating"=>0,"comment_title"=>"Subscribe mail","comment_description"=>$visitor_comments,"comment_ipaddress"=>$ip,"comment_lastupdate"=>date("Y-m-d H:s:i"),"comment_status"=>"approved"));
			$listing_array = $this->db->get_where("listing",array("listing_id"=>$listing_id))->result();
			//$listing_array = $edmanagerdb->get_results("select * from listing where listing_id='$listing_id'",ARRAY_A);
			foreach($listing_array as $listing){
				$visited = $listing["listing_visited"]+1;
				//$edmanagerdb->update("listing",array("listing_visited"=>$visited),array("listing_id"=>$listing_id));
				$this->db->where(array("listing_id"=>$listing_id))->update("listing",array("listing_visited"=>$visited));
			}
			$html .='</div>';			
		}
		/*
		if(isset($_REQUEST['listing_id'])){
			$post_listing_id = $_REQUEST['listing_id'];
		}else{
			global $post;
			$post_slug=$post->post_name;
			$post_slug_array = explode("-",$post_slug);
			$length = count($post_slug_array);		
			$post_listing_id = $post_slug_array[$length-1];
		}
		*/
		$product_array = $this->db->select('*')->from('listing li')		
		->join('listing_photo lip','lip.photo_listing=li.listing_id AND photo_status_main="main"','left')->limit(1)
		//->join('setup_sector_listing setupsl','setupsl.sector_id=li.listing_sector','left')
		->join('visitor_comment vc','vc.comment_linkid=li.listing_id','left')->order_by('vc.comment_id','DESC')->limit(1)
		->join('visitor v','v.visitor_id=vc.comment_visitor','left')
		->join('setup_category_listing scl','scl.category_id=li.listing_category','left')->limit(1)
		->where(array('li.listing_slug'=>$params['listing_slug']))
		->get()->result();
		//var_dump($product_array);
		
		foreach($product_array as $product){
			$product = (array) $product;
			//Photo
			
			if(isset($product['photo_id'])){ $photo_id = $product['photo_id'];}
			if(empty($photo_id)){$photo_id = "sample";}		
			
			if(isset($product['sector_name_1'])){$sector_name = $product['sector_name_1'];}
			
			//Comment 			
			if(isset($product['comment_rating'])){$comment_rating = $product['comment_rating'];}

			
			$result = $this->db->order_by("comment_id","DESC")->get_where("visitor_comment",array("comment_linkid"=>$product['listing_id'],"comment_rating"=>$comment_rating))->result();
			
			$no_of_reviews = count($result);
			

			if(isset($product['visitor_firstname'])){$visitor_firstname = $product['visitor_firstname'];}

			if(isset($product['category_name_1'])){$category_name = $product['category_name_1'];}

			//visitor log with each ad list
			$visitor_log = $this->db->select("*")->from("listing_stat")->order_by('stat_date','ASC')->limit(1)->where(array("stat_listing" => $product['listing_id']))->get()->result();

			if(count($visitor_log)>0){
				foreach($visitor_log as $visitor_log_row){
					$visitor_log_row = (array) $visitor_log_row;
					$stat_total = $visitor_log_row['stat_total'];
					$stat_listing = $visitor_log_row['stat_listing'];
					$stat_date = $visitor_log_row['stat_date'];
					$stat_id = $visitor_log_row['stat_id'];
				}
				if($stat_date==date("Y-m-d")){
					$stat_total +=1;
					$this->db->where(array("stat_id"=>$stat_id))->update("listing_stat",array("stat_total"=>$stat_total));
				}else{
					$insert_log  = $this->db->insert("listing_stat",array("stat_listing"=>$product["listing_id"],"stat_total"=>1,"stat_date"=>date("Y-m-d")));
				}
			}else{			
				$this->db->insert("listing_stat",array("stat_listing"=>$product["listing_id"],"stat_total"=>1,"stat_date"=>date("Y-m-d")));
			}
			
			$loc = explode("-",$product['listing_location_path']);
			$country_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[1]))->get()->result();
			$state_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[2]))->get()->result();
			$city_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[3]))->get()->result();
			foreach($country_arr as $country_rw){ $country = $country_rw->location_name; }
			foreach($state_arr as $state_rw){ $state = $state_rw->location_name; }
			foreach($city_arr as $city_rw){ $city = $city_rw->location_name; }
			

			$html .='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>'.$product['listing_title_1'].'</h3>    
				<p></p>
			</div>
			</div>';
			
				$product_desc = explode("<split>",$product['listing_descfull_1']);
			$html .='<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12"><span class="desc_img">';
			$url = base_url().'photo_big/'.$product['listing_image'];			
			
			$url_header = @get_headers($url);

			if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
				$html .='<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%"/>';
			}else{
				$html .='<img class="img-responsive" src="'.$url.'" width="100%"/>';
			}

			$html .='</span></div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<span class="rating" style="margin-right:30px;font-size:20px;">#'.$product['listing_id'].'</span><br/>
				<div class=""><span class="rating" style="margin-right:30px;font-size:20px;"><?php echo "Location: ".$city.", ".$state.", ".$country; ?></span>
				<h4 class="pro_head">Investment: <span class="">$'.number_format($product['listing_price']).'</span></h4></div>
				<h4 class="pro_head">Description</h4>
				<p class="text-left">';
				if(isset($product_desc[0])){ $html .=$product_desc[0];}
				$html .='</p>
			</div>
			</div>
			<div class="row">
				<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left"><p class="text-left"><?php if(isset($product_desc[1])){echo $product_desc[1];} //echo $product_desc[1];?></p></div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>Facilities</h4>
				<p class="text-left">'.$product['listing_facilities'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>Competition</h4>
				<p class="text-left">'.$product['listing_competition'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>Growth</h4>
				<p class="text-left">'.$product['listing_growth'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>Financing</h4>
				<p class="text-left">'.$product['listing_financing'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4>Training</h4>
				<p class="text-left">'.$product['listing_training'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h4 class="pro_head">Business Status </h4>
				<p class="text-left">'.$product['listing_sell_reason'].'</p>
			</div>
			</div>
			<div class="row">
			<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h4 class="panel-title">Inquiry</h4>
					</div>
					<div id="reviews" class="panel-collapse collapse in">
					<div class="panel-body">
						<input type="hidden" name="plisting_title" value="'.'#'.$product['listing_id'].' '.$product['listing_title_1'].'" />
						<input type="hidden" name="listing_id" value="'.$product['listing_id'].'" />';
						//do_shortcode('[custom_forms form="singalad"]');
						$html .=$this->custom_forms(array('form'=>'singalad'));
					$html .='</div>
					</div>
				</div>
				</div>
			</div>
			</div>';
			/*
			$comments_array = $edmanagerdb->get_results("SELECT * FROM visitor_comment WHERE comment_linkid = '".$product['listing_id']."' ORDER BY comment_id DESC LIMIT 10",ARRAY_A);
			if(count($comments_array)<1){ echo "No reviews yet!";}else{	
				foreach($comments_array as $comment_row){
					$visitors_array = $edmanagerdb->get_results("SELECT * FROM visitor WHERE visitor_id = '".$comment_row['comment_visitor']."' ORDER BY visitor_id",ARRAY_A);
					foreach($visitors_array as $visitor_row){ $visitor_username = $visitor_row['visitor_username']; }
				}
			}
			*/			
		}
		return $html;
	}

	public function custom_forms($args=array()){
		
		$arg_array = array('form'=>'');
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		$html ='';
		
		if($arg_array['form']=="multiad"){

			$html .='<div id="myModal-fixed" class="modal fade" role="dialog">
					<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content req-free-phone">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">AD(s) Request Form</h4>
				</div>
				<div class="modal-body">
					<div role="form" lang="en-US" dir="ltr">
					<div class="screen-reader-response"></div>
					<form action="'.base_url().'visitor/multipl_ads_request/" method="post" enctype="application/x-www-form-urlencoded" >
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <strong>The more information you provide the better we can match businesses to you</strong>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<label class="control-label"></label>
								<br>
								<span class="wpcf7-form-control-wrap title">
									<select name="title" class="wpcf7-form-control wpcf7-select form-control" aria-invalid="false">
										<option value="Mr">Mr</option>
										<option value="Mrs">Mrs</option>
										<option value="Ms">Ms</option>
									</select>
								</span>
							</div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">First Name <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_first_name">
							<input type="text" name="visitor_first_name" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Last Name <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_last_name">
							<input type="text" name="visitor_last_name" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="control-label">Email <span style="color:#ff0000;">*</span></label>
								<br>
								<span class="wpcf7-form-control-wrap visitor_email">
								<input type="email" name="visitor_email" value="" size="40" class="form-control" required pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$">                 </span> </div>
								<p></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label class="control-label">Phone <span style="color:#ff0000;">*</span></label>
									<br>
									<span class="wpcf7-form-control-wrap visitor_tel">
										<input type="tel" name="visitor_tel" value="" size="40" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$" >   
									</span>
								</div>
								<p></p>
							</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Street Address Line One <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_strt_add_one">
							<input type="text" name="visitor_strt_add_one" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Street Address Line Two</label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_strt_add_two">
							<input type="text" name="visitor_strt_add_two" value="" size="40" class="form-control" >
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">City<span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_city">
							<input type="text" name="visitor_city" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">State or Province<span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_st_pro">
							<input type="text" name="visitor_st_pro" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Country <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_country">
							<input type="text" name="visitor_country" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Zip or Postal Code<span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap">
							<input type="text" name="visitor_postal_code" value="" size="40" class="form-control" required maxlength="7" id="multi_ad_zip"/>
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Capital Available to invest <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_capital_invest">
							<input type="text" name="visitor_capital_invest" value="" size="40" class="form-control" required placeholder="$">
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Estimated Net Worth <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_est_nt_worth">
							<input type="text" name="visitor_est_nt_worth" value="" size="40" class="form-control" required placeholder="$">
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Purchase Time Frame <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_time_frame">
							<input type="text" name="visitor_time_frame" value="" size="40" class="form-control" required />
							</span> </div>
							<p></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
							<label class="control-label">Desired Location <span style="color:#ff0000;">*</span></label>
							<br>
							<span class="wpcf7-form-control-wrap visitor_eesired_location">
							<input type="text" name="visitor_eesired_location" value="" size="40" class="form-control" required>
							</span> </div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Additional Comments</label>
							<p></p>
							<div class="form-group"><span class="wpcf7-form-control-wrap comments">
							<textarea name="comments" cols="40" rows="5" class="wpcf7-form-control wpcf7-textarea form-control" aria-invalid="false"></textarea>
							</span></div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group"><span class="wpcf7-form-control-wrap chk1"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item first last">
							<input type="checkbox" name="chk1" value="I want to learn about using my 401K/IRA funds to buy a business" checked="checked">
							&nbsp;<span class="wpcf7-list-item-label">I want to learn about using my 401K/IRA funds to buy a business</span></span></span></span></div>
							<p></p>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">ABC will contact you with more information on selected business(es)</div>
							<p></p>
						</div>
						</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Security Checks</label><br/>
							<span><!--please enter the text below --></span>
							<!-- <div class="form-group">$this->custom_captcha()</div>  -->
							<!-- re-Capthca code -->
							<div class="g-recaptcha" data-sitekey="6LekPjEUAAAAAHist3I-4TOKI3OPM9Gy6bqCyqZ8"></div>   
								<!-- re-Capthca code -->
							</div>
					</div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
							<input type="button" value="Send" class="btn-warning" name="ci_mail_send" onclick="multi_ad_zip_validateZIP()"/>
							</div>              
						</div>
						</div>
					</form>
					</div>
				</div>
				</div>
			</div>
			</div>';	
		}
		
		if($arg_array['form']=="singalad"){

			$html .='<form action="'.base_url().'visitor/request_singalad/" method="post" enctype="application/x-www-form-urlencoded" class="custom-forms">
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
				For more information on this business fill out this form
			</div>
			</div>
			<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="form-group">
				<label class="control-label"></label>
				<select name="title" class="form-control">
					<option value="Mr">Mr</option>
					<option value="Mrs">Mrs</option>
					<option value="Ms">Ms</option>
				</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">First Name <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_first_name" class="form-control" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Last Name <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_last_name" class="form-control" required /> 
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Email <span style="color:#ff0000;">*</span></label>
				<input type="email" name="visitor_email" class="form-control" required pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" /> 
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Phone <span style="color:#ff0000;">*</span></label>
				<input type="tel" name="visitor_tel" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$" />
				</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Street Address Line One <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_strt_add_one" class="form-control" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Street Address Line Two</label>
				<input type="text" name="visitor_strt_add_two" class="form-control" />
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">City<span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_city" class="form-control" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">State or Province<span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_st_pro" class="form-control" required />
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Country <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_country" class="form-control" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Zip or Postal Code<span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_postal_code" class="form-control" required maxlength="7" id="enquiry_zip"/> 
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Capital Available to invest <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_capital_invest" class="form-control" placeholder="$" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Estimated Net Worth <span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_est_nt_worth" class="form-control" placeholder="$" required />
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Purchase Time Frame<span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_time_frame" class="form-control" required />
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<label class="control-label">Desired Location<span style="color:#ff0000;">*</span></label>
				<input type="text" name="visitor_eesired_location" class="form-control" required />
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<label class="control-label">Additional Comments</label>
				<div class="form-group"><textarea name="comments" rows="5" cols="40" class="form-control"></textarea></div>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
				<label><input type="checkbox" checked="checked" value="I am interested in learning more about how to use my retirement funds (IRA/401K) to buy a business."  />I am interested in learning more about how to use my retirement funds (IRA/401K) to buy a business.</label>
			</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="control-label">Security Check</label><br/><span>please enter the text below</span>
				<div class="form-group">'.$this->custom_captcha().'</div>
			</div>
			</div>';
			if(isset($_GET['listing_id'])){
				$html .='<input type="hidden" name="listing_id" value="'.$_GET['listing_id'].'" />';
			}
			if(isset($_GET['listing_slug'])){
				$html .='<input type="hidden" name="listing_slug" value="'.$_GET['listing_slug'].'" />';
				$html .='<input type="hidden" name="listing_ad_link" value="'.base_url().'product/'.$_GET['listing_slug'].'" />';
			}
			

			$html .='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group"><input type="submit" class="btn-warning" name="visitor_inquiry" value="Send" onclick="enquiry_zip_validateZIP()"/></div>
			</div>
			</div>
			</form>';
		}
		
		if($arg_array['form']=="pre-qualification-form"){

    	    $html .='<div class="row">
				<div class="col-lg-12 text-center">
				<h1 class="page-title">CONFIDENTIAL FRANCHISE PRE-QUALIFICATION QUESTIONNAIRE</h1>
				<p style="font-family: "ABeeZee", sans-serif;text-align:left;">Affordable Business Concepts, LLC matches qualified buyers with credible franchise opportunities in their desired location. Your information coupled with our market knowledge and industry relationships will help us to identify the franchise opportunities both new and existing that meet your goals. It will also determine your pre-qualifications for franchise ownership in the various industries.</p>
				<p style="font-family: "ABeeZee", sans-serif;text-align:left;">Take a few minutes to complete our franchise pre-qualification confidential questionnaire. Completing this questionnaire <u>does NOT obligate</u> you to any franchise or any franchise to you. If you have any questions regarding the completion of this form contact us toll free at 1-866-388-3576.</p>
				</div>
				</div>
				<div class="row">
				<div  style="border:2px solid #054872;border-radius:5px;margin:15px;">
				<form action="'.base_url().'visitor/request_pre_qual_form/" method="post" enctype="application/x-www-form-urlencoded" class="custom-forms pre-qualification-form">
				<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">First Name<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_frst_name" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Last Name<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_last_name" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Street<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_street" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">City<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_city" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">State or Province,Country<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_addr" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Zip or Postal Code<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_zip" class="form-control auto-num" maxlength="7" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Email<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="email" name="pre_qual_email" class="form-control" required pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Cell Phone<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="tel" name="pre_qual_cellphone" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$" /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Home Phone<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="tel" name="pre_qual_homephone" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$" /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Business Phone</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="tel" name="pre_businessphone" class="form-control" /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Fax</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="tel" name="pre_qual_fax" class="form-control" /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Country of Citizenship<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_country_citizen" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Desired Location<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_de_loc" class="form-control" required /></div></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Purchase Time Frame<span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_time_frame" class="form-control" required /></div></div>
					<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-lg-6">
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Date<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group hero-unit">
						<input type="text" id="datepicker" name="pre_qual_today_dt" class="form-control" required pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="MM/DD/YYYY"/>
					</div>        
				</div>
				<div class="clearfix"></div> 
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Spouse’s Name<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group"><input type="text" name="pre_qual_spouse_name" class="form-control" required /></div></div>
						<div class="clearfix"></div>    
				</div>
				<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Is Spouse Employed? <span> *</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label><input type="radio" name="pre_qual_is_sp_emp" value="Yes" checked="checked" /> Yes</label>
						<label><input type="radio" name="pre_qual_is_sp_emp" value="No" /> No</label>
					</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Business Partner(s) Name(s)<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_partner_name" class="form-control" required /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Rent or Own a home<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label><input type="radio" name="pre_qual_home" value="Rent" checked="checked" /> Rent</label>
				<label><input type="radio" name="pre_qual_home" value="Own a Home" /> Own a Home</label>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Highest Education (level)<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_name" class="form-control" required /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Education Major<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_edu_major" class="form-control" required /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Credit Score<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_cr_score" class="form-control" required /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Are you Currently Employed?<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label><input type="radio" name="pre_qual_employed" value="Yes" checked="checked" /> Yes</label>
				<label><input type="radio" name="pre_qual_employed" value="No" /> No</label>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Describe Position Held<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_desc_posistion" class="form-control" required /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Full or Part Time Ownership in New Business?<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<select name="pre_qual_fl_prt_time" class="form-control" required>
						<option value="">---------</option>
						<option value="Full time">Full time</option>
						<option value="Part time">Part time</option>
					</select>
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Amount in your Retirement Funds (401K + IRA)? <span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_retirement_fund" class="form-control" required placeholder="$" /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Amount to Invest in a new Business Opportunity<span> *</span></label>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_invest_amt" class="form-control" required placeholder="$" /></div></div>
				<div class="clearfix"></div>
				</div>
				<div class="form-group">
				<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Net Worth<span> *</span></label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_nt_worth" class="form-control" required placeholder="$" /></div></div>
				<div class="clearfix"></div>
				</div>
			</div>
			</div>
				</div>
				<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
					<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label required">What specific Franchises or types of Industries, interest you ?<span> *</span></label>
				</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group"><textarea name="pre_qual_explore" rows="2" cols="40" class="form-control" required ></textarea></div></div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
					<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label required">Select Franchised Model: Home Based, Mobile,  Office or Retail.<span> *</span></label>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_homebase_busi" class="form-control" required /></div></div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
					<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label required">Are you interested in Multiple Units?<span> *</span></label>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_multplu_units" class="form-control" required /></div></div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
					<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label required">What Franchises have you already considered?<span> *</span> <br>(Specify their names)</label>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group"><input type="text" name="pre_qual_act_franchise" class="form-control" required /></div></div>
					</div>
				</div>
				</div>
			
				<!-- NET WORTH CALCULATOR -->
				
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h4>Net Worth Calculator (Estimate to nearest dollar)</h4></div>
				</div>
				</div>
				<div class="row net-worth">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 assets">
					<div class="form-group" style="border-bottom:1px solid #054872;">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label required"><span style="font-size: 18px;
					color: #054872;">Assets</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><strong></strong></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Cash in Bank</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank23" id="cash_in_bank23" class="form-control" placeholder="$"/>       
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Cash In Savings</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank2" id="cash_in_bank2" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Stocks, Bonds, Mutual Funds</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank3" id="cash_in_bank3" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Retirement (IRA+ 401K)</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank4" id="cash_in_bank4" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Primary Home Market Value </label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank5" id="cash_in_bank5" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Other Real Estate Market Value</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank6" id="cash_in_bank6" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>    
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Business Value</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank8" id="cash_in_bank8" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Money Due You</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank9" id="cash_in_bank9" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Other Assets</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank10" id="cash_in_bank10" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 liable">
					<div class="form-group" style="border-bottom:1px solid #054872;">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label required"><span style="font-size: 18px;
					color: #054872;">Liabilities</span></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><strong></strong></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Credit Cards Debt</label>
				
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank13" id="cash_in_bank13" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Auto Loans Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank14" id="cash_in_bank14" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Student Loans Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank15" id="cash_in_bank15" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
				<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Home Equity Line of Credit</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank19" id="cash_in_bank19" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Primary Mortgage  Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank16" id="cash_in_bank16" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Second Mortgage Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank17" id="cash_in_bank17" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Other Real Estate Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank18" id="cash_in_bank18" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
				<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Account Charge Debt</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank21" id="cash_in_bank21" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Other Debts</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank20" id="cash_in_bank20" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required"></label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> </div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 assets">
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Assets</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank11" id="cash_in_bank11" class="form-control" placeholder="$"/>        
					</div>
					<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 liable">
					<div class="form-group">
					<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 control-label required">Total Liabilities</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="cash_in_bank22" id="cash_in_bank22" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
					<label class="control-label required">TOTAL NET WORTH = Assets – Liabilities:$</label>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<input type="text" name="cash_in_bank12" id="cash_in_bank12" class="form-control" placeholder="$"/>
					</div>
					<div class="clearfix"></div>
					</div>
				
				</div>  
				</div>
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-12">
				<p style="font-family: "ABeeZee", sans-serif;">Affordable Business Concepts, LLC respects your privacy. Your information will never be shared, rented or sold to any 3rd parties. The information you submit is only provided to franchise opportunities for which you have requested additional information.<br>
				By clicking the submit button you certify that all of the information stated herein is a true and correct representation of your personal and financial condition. It is understood that the purpose of this questionnaire is to compile general information so we may help you and that is in no way binding upon either party.</p></div>
				</div>
				</div>
			
				<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
					</div>
				</div>
				<div class="col-lg-4 text-center">
					<div class="form-group">
					<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label"><input type="submit" value="submit" name="submit" class="btn btn-warning" onclick="pre_quali_validateZIP()" /></label>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
					</div>
				</div>
				</div>
				</form>
				</div>
				</div>';
        
		}
		
		if($arg_array['form']=="request-free-phone-consultation"){

	    	$html .='<form action="'.base_url().'visitor/request_free_phone_consult/" method="post" enctype="application/x-www-form-urlencoded" class="custom-forms">
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<strong>The more information you provide the better we can match businesses to you</strong>
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label class="control-label"></label>
						<select name="title" class="form-control" tabindex="0">
							<option value="Mr">Mr</option>
							<option value="Mrs">Mrs</option>
							<option value="Ms">Ms</option>
						</select>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">First Name <span style="color:#ff0000;">*</span></label>
							<input type="text" name="visitor_first_name" class="form-control" required  tabindex="0"/>
						</div>
					
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Last Name <span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_last_name" class="form-control" required tabindex="0" /> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Email <span style="color:#ff0000;">*</span></label>
							<input type="email" name="visitor_email" class="form-control" required pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" tabindex="0" /> </div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Phone <span style="color:#ff0000;">*</span></label>
						<input type="tel" name="visitor_tel" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$" tabindex="0" /></div>
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Street Address Line One <span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_strt_add_one" class="form-control" tabindex="0" required /></div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Street Address Line Two</label>
						<input type="text" name="visitor_strt_add_two" class="form-control" tabindex="0" /> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">City<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_city" class="form-control" required tabindex="0" /> </div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">State or Province<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_st_pro" class="form-control" required tabindex="0" /> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Country <span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_country" class="form-control" tabindex="0" required /> </div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Zip or Postal Code<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_postal_code" id="rqst_free_phn_zip" class="form-control auto-num" maxlength="7" required tabindex="0"/> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Capital Available to invest<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_capital_invest" class="form-control" placeholder="$" tabindex="0" required/> </div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Estimated Net Worth<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_est_nt_worth" class="form-control" placeholder="$" tabindex="0" required/> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

						<div class="form-group">
						<label class="control-label">Purchase Time Frame<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_time_frame" class="form-control" tabindex="0" required/> </div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="control-label">Desired Location<span style="color:#ff0000;">*</span></label>
						<input type="text" name="visitor_eesired_location" class="form-control" tabindex="0" required/> </div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="control-label">Additional Comments</label>
						<textarea name="comments" rows="5" cols="40" class="form-control" tabindex="0"></textarea>
					</div>
					</div>
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label><input type="checkbox" name="chk1" checked="checked" value="I want to learn about using my (401K/IRA) funds to buy a business." />
							I want to learn about using my (401K/IRA) funds to buy a business.</label>
						</div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">Affordable Business Concepts, LLC will call you for a free consultation.</div>
						
					</div>
					</div>
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="control-label">Security Check</label><br/><span>please enter the text below</span>
						<div class="form-group">'.$this->custom_captcha().'</div>
					</div>
					</div>
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group"><input type="submit" name="submit" value="Send" onclick="rqst_free_phn_zip_validateZIP()"/></div>
						
					</div>
					</div>
				</form>';
		}

		if($arg_array['form']=="request-information"){
    		$html .='<div class="col-lg-7">
			<form action="'.base_url().'visitor/request_information/" method="post" enctype="application/x-www-form-urlencoded" class="custom-forms">
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br/><br/>
				<strong>The more information you provide the better we can match businesses to you</strong>    
			</div>
			</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group">
					<label class="control-label"></label>
					<select name="title" class="form-control">
					<option value="Mr">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option></select> </div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
				</div>
						</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">First Name <span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_first_name" class="form-control" required/> </div>
					
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Last Name <span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_last_name" class="form-control" required /> </div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Email <span style="color:#ff0000;">*</span></label>
					<!--<input type="email" name="visitor_email" class="form-control" required pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$"/> -->
					<input type="email" name="visitor_email" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"/>
					</div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Phone <span style="color:#ff0000;">*</span></label>
					<input type="tel" name="visitor_tel" class="form-control" required pattern="^\d{3}-\d{3}-\d{4}$"/> 
		
				</div>
					
				</div>
				</div>
				
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Street Address Line One <span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_strt_add_one" class="form-control" required />          
					</div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Street Address Line Two</label>
					<input type="text" name="visitor_strt_add_two" class="form-control" /> </div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">City<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_city" class="form-control" required /> </div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">State or Province<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_st_pro" class="form-control" required /> </div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Country <span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_country" class="form-control" required /> </div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Zip or Postal Code<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_postal_code" id="contact_zip" class="form-control zip-code" required maxlength="7" pattern="^[a-zA-Z0-9]+$" /></div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Capital Available to invest<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_capital_invest" class="form-control" placeholder="$" required/> </div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Estimated Net Worth<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_est_nt_worth" class="form-control" placeholder="$" required/> </div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Purchase Time Frame<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_time_frame" class="form-control" required/> </div>

					
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					<label class="control-label">Desired Location<span style="color:#ff0000;">*</span></label>
					<input type="text" name="visitor_eesired_location" class="form-control" required/> </div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="control-label">Additional Comments</label>
					<div class="form-group"><textarea name="comments" rows="5" cols="40" class="form-control"></textarea></div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
					<label><input type="checkbox" checked="checked" name="chk1" value="I want to learn about using my (401K/IRA) funds to buy a business." />I want to learn about using my (401K/IRA) funds to buy a business.</label>
					</div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">Affordable Business Concepts, LLC will contact you shortly for a free consultation.</div>
					
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="control-label">Security Check</label><br/><span>please enter the text below </span> 
				<div class="form-group">'.$this->custom_captcha().'</div>  
				</div>
				</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group"> <input type="submit" class="btn btn-warning" name="send-message-request-information" value="Send" onclick="contact_zip_validateZIP()"/> </div>

				</div>
				</div>
			</form>
			</div>';
		}
		
		return $html;
	}

	public function custom_captcha(){
		$chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
		$captchacode = substr( str_shuffle( $chars ), 0, 5 );  
		return  '<label class="control-label" style="-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;padding:3px 10px;background-color:#000000;color:#f4c730;font-size:25px;">'.$captchacode.' </label><input type="text" name="captcha" size="4" maxlength="5" style="font-size:25px;" tabindex="0" required /><input type="hidden"  name="captcha_validate" value="'.$captchacode.'" />';
	}
	
	public function listing($args = array()){
		$html = '';
		$where = '';
		$arg_array = array(
			'limit' => NULL,
			'pagination' => false
		);
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}
		$new_array = array();
		if($arg_array['pagination']){			
			if(isset($_POST['search_now'])){
				if(!empty($_POST['list_state'])){

					$where = "listing_location_path LIKE '%-".$_POST['list_state']."-%'";
					if(!empty($_POST['list_city']) && $_POST['list_city']!=0){
						$where = "listing_location_path LIKE '%-".$_POST['list_city']."-'";
					}
				}
				if(!empty($_POST['list_seller_username'])){
					if(!empty($where)){
					$where .= " AND listing_id = '".$_POST['list_seller_username']."'";
					}else{
						$where = "listing_id = '".$_POST['list_seller_username']."'";
					}
				}
				if(is_array($_POST['list_sector'])){
					if(!empty($_POST['list_sector'])){
					    $length = count($_POST['list_sector']);
						if($length >=2){ $or_starter = "("; $or_ender = ")"; }else{ $or_starter = "";$or_ender = "";}
						foreach($_POST['list_sector'] as $k=>$val){
							if($val!=0){
								if(!empty($where)){
									if($k==0){
										$where .= " AND $or_starter listing_category_path LIKE '%-".$val."-%'";
									}else{
										$where .= " OR listing_category_path LIKE '%-".$val."-%'";
									}	
								}else{
									$where = "$or_starter listing_category_path LIKE '%-".$val."-%'";
								}
							}
						}
						if(!empty($or_starter)){
							$where .= "$or_ender";
						}
					}
				}else{
					if(!empty($_POST['list_sector'])){
						if(!empty($where)){
							$where .= " AND listing_category_path LIKE '%-".$_POST['list_sector']."-%'";
						}else{
							$where = "listing_category_path LIKE '%-".$_POST['list_sector']."-%'";
						}
					}
				}
				if(is_array($_POST['list_category'])){				
					if(!empty($_POST['list_category'])){
						$length = count($_POST['list_category']);
						if($length >=2){ $or_starter = "("; $or_ender = ")"; }else{ $or_starter = "";$or_ender = "";}
						foreach($_POST['list_category'] as $k=>$val){						
							if($val!=0){
								if(!empty($where)){
									if($k==0){
										$where .= " AND $or_starter listing_category_path LIKE '%-".$val."-%'";
									}else{
										$where .= " OR listing_category_path LIKE '%-".$val."-%'";
									}
								}else{
									$where = "$or_starter listing_category_path LIKE '%-".$val."-%'";
								}
							}
						}
						if(!empty($or_starter)){
							$where .= "$or_ender";
						}
					}
				}else{
					if(!empty($_POST['list_category'])){
						if(!empty($where)){
							$where .= " AND listing_category_path LIKE '%-".$_POST['list_category']."-%'";
						}else{
							$where = "listing_category_path LIKE '%-".$_POST['list_category']."-%'";
						}
					}
				}
				if(!empty($_POST['list_invest_level'])){
					$list_invest_level = $_POST['list_invest_level'];
					if(!empty($where)){				
						$where .= " AND listing_price".$list_invest_level;
					}else{				
						$where = "listing_price".$list_invest_level;
					}
				}
			}
			if(!empty($_POST["list_search_keywork"])){
				if(!empty($where)){				
					$where .= " AND listing_status_keywords like '%".$_POST["list_search_keywork"]." %'";
				}else{				
					$where = "listing_status_keywords like '%".$_POST["list_search_keywork"]." %'";
				}
			}
			$new_array_count = $this->db->query("SELECT * FROM listing WHERE $where")->result();			
			
			if(!empty($_POST['list_seller_username'])){
				$new_array_count = $this->db->get_where("listing",array("listing_id"=>$_POST['list_seller_username']))->result();
			}			
			$records = count($new_array_count);
			$pages = ceil($records/$limit);
			if(isset($_POST['current_page'])){
				$current_page = $_POST['current_page'];
			}else{
				$current_page = 0;				
			}
			if($current_page <1){
				$from = 0;
			}else{ $from = $current_page*$limit; }
			if(isset($_POST['next'])){
			 	$current_page++;
			}elseif(isset($_POST['prev'])){ $current_page--;}
		}else{
			$from = 0;
		}
		
		if(!empty($where)){
			$new_array = $this->db->query("SELECT * FROM listing WHERE $where ORDER BY listing_id DESC LIMIT $from,$to")->result();
		}

		if(!empty($_POST['list_seller_username'])){
			$new_array = $this->get_where("listing",array("listing_id" => $_POST['list_seller_username']))->result();
		}
		
	
			$html .='<div id="myModal5" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close adv-reset-close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Advanced Search</h4>
			</div>
			<div class="modal-body">';
				$html .=$this->search_page(array("view_page"=>"refine"));
			$html .='</div>
			</div>
		</div>
		</div>

		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="portlet-title">
			<h3 class="page-listing-title">Listings</h3>      
			<div class="action">
				<button type="submit" name="search_now" class="btn btn-warning" data-toggle="modal" data-target="#myModal5" style="font-size:20px;padding:0px;background-color:#b5940b;color:#fff;"><i class="fa fa-search"></i> REFINE SEARCH </button>
			</div>';
			if(count($new_array)<=0){ 
				$html .='<h5 style="font-size:20px;color:#ff0000;">No Opportunities Found!</h5>';
			}
			$html .='</div>
		</div>
		</div>';
		
		if(count($new_array)>0){
			foreach($new_array as $row){
				
				$row = (array) $row;
				if(!empty($row["listing_image"])){
					$url = base_url().'photo_big/'.$row['listing_image'];
				}else{
					$url = base_url().'photo_big/'.$row['listing_id'].'.jpg';
				}

				$url_header = @get_headers($url);
				$loc = explode("-",$row['listing_location_path']);
				$country_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[1]))->get()->result();
				$state_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[2]))->get()->result();
				$city_arr = $this->db->select("location_name")->from("setup_location")->where(array("location_id" =>$loc[3]))->get()->result();
				foreach($country_arr as $country_rw){ $country = $country_rw->location_name; }
				foreach($state_arr as $state_rw){ $state = $state_rw->location_name; }
				foreach($city_arr as $city_rw){ $city = $city_rw->location_name; }
	

				if($i==0){$html .='<div class="row">';}$i++;
				$html .='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<form action="" method="post" enctype="multipart/form-data">
					<div class="new-listing">
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="img-hover" data-toggle="tooltip" title="click for more info">';
							if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
								$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'" >
								<img class="img-responsive" src="'.base_url().'photo_big/sample.jpg" width="100%" />      		
								</a>';
							}else{
								$html .='<a href="'.base_url().'product/'.$row['listing_slug'].'" >
								<img class="img-responsive" src="'.$url.'" width="100%" />
								</a>';
							}
							$html .='</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h5><a href="'.base_url().'product/'.$row['listing_slug'].'" >'.$row['listing_title_1'].'</a></h5>
							<span class="rating" style="margin-right:15px;">'.$city.'</span><br/>
							<span class="rating" style="margin-right:15px;">'.$state.'</span><br/>
							<span class="rating">Investment: $'.number_format($row['listing_price']).'</span><br />
							<span class="cross-btn"><input class="selected_ad_id" type="checkbox" name="selected_ad_id[]" value="'.$row['listing_id'].'" />Request AD #'.$row['listing_id'].' <input type="hidden" name="ad_title[]" value="'.$row['listing_title_1'].'"/></span>
							</div>
						</div>
						
					</div>
					</form>
				</div>';
  				if($i==4){ $i = 0;$html .='</div>';}
				  
			}
			
		}

		return $html;
	}
	
	public function search_page($args=array()){
		$html ='';
		$arg_array = array(
			'view_page' => false
		);
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		else { $ip = $_SERVER['REMOTE_ADDR']; }
		
		$url = 'http://ip-api.com/php/'.$ip;
		$i = 0; 
		$content='';
		$curl_info='';
		$ch = curl_init();
		
		$curl_opt = array(
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER  => 1,
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 1,
			CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
		);
		
		if (isset($_SERVER['HTTP_USER_AGENT'])) $curl_opt[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt_array($ch, $curl_opt);
		$content = curl_exec($ch);
		if (!is_null($curl_info)) $curl_info = curl_getinfo($ch);
		curl_close($ch);
		$ary = unserialize($content);
		$country = $ary["country"];
		$regionName = $ary["regionName"];
		
		$sector_array = $this->db->select("category_id,category_name_1")->from("setup_category_listing")->where(array("category_parent" => '0', "category_stat_listing" => '1'))->order_by("category_name_1","ASC")->get()->result();
		//$sector_array = $edmanagerdb->get_results("SELECT category_id,category_name_1 FROM setup_category_listing WHERE category_parent = '0' AND category_stat_listing = '1' ORDER BY category_name_1",ARRAY_A);	
	 	if($arg_array["view_page"]!="refine"){
            $html .='<div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                <h1 class="page-title" >Advanced Search </h1>
              </div>
            </div>';
		 }
		$html .='<form name="advance_search" action="'.base_url().'listing/?type=search" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">Ad ID:</label>';
				if(isset($_POST["list_seller_username"])){$list_seller_username = $_POST["list_seller_username"];}else{$list_seller_username="";}
				$html .='<input type="text" class="form-control" value="'.$list_seller_username.'" name="list_seller_username" placeholder="Ad Id">
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> </div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">Location:</label>';
				
				if(isset($_POST["list_state"])){$regionId = $_POST["list_state"];}
				$countryArray = $this->db->get_where("setup_location",array("location_id" =>$regionId))->result();
				//$countryArray = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_id = '$regionId'",ARRAY_A); 
				foreach($countryArray as $row){$regionName = $row->location_name;}
				
				$html .='<select id="categories" class="form-control" name="list_state" ng-model="type">
				<option value="0">Location</option>';
				$countryArray = $this->db->select("*")->from("setup_location")->where(array("location_parent" => '0',"location_stat" => '1'))->order_by("location_name","ASC")->get()->result();
				
				//$countryArray = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '0' AND location_stat = '1' ORDER BY location_name ASC",ARRAY_A);		
				foreach($countryArray as $row){
					$row = (array) $row;
					$html .='<optgroup label="'.$row['location_name'].'">';
					$stat_array = $this->db->order_by("location_name","ASC")->get_where("setup_location",array("location_parent" => $row['location_id'],"location_stat" => '1'))->result();
					//$stat_array = $edmanagerdb->get_results("SELECT * FROM setup_location WHERE location_parent = '".$row['location_id']."' AND location_stat = '1' ORDER BY location_name ASC",ARRAY_A);			
					foreach($stat_array as $state_row){
						$state_row = (array) $state_row;
						if($state_row['location_name'] == $regionName){
							$regionId = $state_row['location_id'];
							$html .='<option value="'.$state_row['location_id'].'" selected="selected">'.$state_row['location_name'].'</option>';
						}else{
							$html .='<option value="'.$state_row['location_id'].'">'.$state_row['location_name'].'</option>';
						}          
					}
					$html .='</optgroup>';
				}
				
				$html .='</select>
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">City:</label>
				<div id="ajax_city">';
				
				if(isset($_POST["list_city"])){$list_city = $_POST["list_city"];}else{$list_city = "";}
					$html .='<select id="categories" class="form-control" name="list_city" ng-model="type"><option value="0">All</option>';
					$parent_id = $regionId;
					$city_array = array();
					if($parent_id!="" || $parent_id>0){
						$city_array = $this->db->select("location_id,location_name")->from("setup_location")->where(array("location_parent"=>$parent_id))->get()->result();
						//$city_array = $edmanagerdb->get_results("SELECT location_id,location_name FROM setup_location WHERE location_parent = '".$parent_id."'",ARRAY_A);				
						foreach($city_array as $city_row){ 
							$city_row = (array) $city_row;
							if($city_row['location_id']==$list_city){               
								$html .='<option value="'.$city_row['location_id'].'" selected="selected">'.$city_row['location_name'].'</option>';
							}else{               
								$html .='<option value="'.$city_row['location_id'].'">'.$city_row['location_name'].'</option>';
							}
						}
					}
					
				$html .='</select>
				</div>
			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">Industry:</label>';        
				
				if(isset($_POST["list_sector"])){
					if(is_array($_POST["list_sector"])){
						$list_sector = $_POST["list_sector"][0];
					}else{
						$list_sector = $_POST["list_sector"];
					}
				}
				elseif(isset($_REQUEST["sec_id"])){$list_sector = $_REQUEST["sec_id"];}else{$list_sector=0;} 

				if(!isset($_POST["list_category"])){
					$sector_array1 = $this->db->select("category_parent")->from("setup_category_listing")->where(array("category_id" => $list_sector))->get()->result();
					//$sector_array1 = $edmanagerdb->get_results("SELECT category_parent FROM setup_category_listing WHERE category_id = '".$list_sector."'",ARRAY_A);
					foreach($sector_array1 as $sector_row1){$sector_id = $sector_row1->category_parent;}
				
				}else{
				
					$sector_id = $list_sector;
					$list_sector = $_POST["list_category"];
				}
				
				if(isset($_REQUEST["sec_id"])){$sector_id = $_REQUEST["sec_id"];}		
					$html .='<select class="form-control" id="list_sector" name="list_sector" onChange="javascript:ajax_category_list(this.value,0);">
					<option value="0">Select Industry</option>';
					foreach($sector_array as $sector_row){
						$sector_row = (array) $sector_row;
						if($sector_row['category_name_1']=="Franchise Resales"){$style='style="font-weight:bold;"';}else{$style="";}
						if($sector_row['category_id'] == $sector_id){
							$html .='<option value="'.$sector_row['category_id'].'" selected="selected" '.$style.' >'.$sector_row['category_name_1'].'</option>';
						}else{
						$html .='<option value="'.$sector_row['category_id'].'" '.$style.' >'.$sector_row['category_name_1'].'</option>';
					}
				}
				
				$html .='</select>
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">Category:</label>
				<div id="listing_category_1">';
				if(isset($_POST["list_category"])){$list_category = $_POST["list_category"];}
				elseif(isset($_REQUEST["cat_id"])){$list_category = $_REQUEST["cat_id"];}else{$list_category=0;}	        
				$html .='<select class="form-control" id="list_category" name="list_category" ng-model="type">
				<option value="0">All</option>';
				$cat_array = $this->db->select("category_id,category_name_1")->from("setup_category_listing")->where(array("category_parent" =>$sector_id))->get()->result(); 
				//$cat_array = $edmanagerdb->get_results("SELECT category_id,category_name_1 FROM setup_category_listing WHERE category_parent = '".$sector_id."'",ARRAY_A);
				foreach($cat_array as $cat_row){ $cat_row = (array) $cat_row;		   
					$html .='<option value="'.$cat_row['category_id'].'"';if($cat_row['category_id'] == $list_category ){ $html .='selected="selected"';}$html .='>'.$cat_row['category_name_1'].'</option>';
				}
				$html .='</select>
				</div>
			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">';
				if(isset($_POST["list_invest_level"])){$list_invest_level = $_POST["list_invest_level"];}else{$list_invest_level="";}
			$list_invest_level_array = array(
				"<=100000"=>"Less Than $100K",
				"<=200000"=>"Less Than $200K",
				"<=300000"=>"Less Than $300K",
				"<=400000"=>"Less Than $400K",
				"<=500000"=>"Less Than $500K",
				">=500000"=>"Greater Than $500K",
				""=>"All Investment Levels"
			); 
			
				$html .='<label class="control-label">Investment Level:</label>
				<select class="form-control" id="invest-level" name="list_invest_level">';
				foreach($list_invest_level_array as $k=>$v){
					if($list_invest_level==$k){       	
						$html .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
					}else{
						$html .='<option value="'.$k.'">'.$v.'</option>';
					}
				}
				$html .='</select>
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label class="control-label">Search Keyword:</label>';
				if(isset($_POST["list_search_keywork"])){$list_search_keywork = $_POST["list_search_keywork"];}else{$list_search_keywork=0;}
				$html .='<input type="text" class="form-control" value="'.$list_search_keywork.'" name="list_search_keywork" placeholder="Search Keyword...">
			</div>
			</div>
		</div>
		
		<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group">
						<button type="submit" name="search_now" class="btn btn-warning"><i class="fa fa-search"></i> Search Now </button>
					</div>
					
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group">
						<button type="reset" name="reset" class="btn btn-warning adv-reset"><i class="fa fa-recycle"></i> Modify Search </button>
					</div>              
					</div>
				</div>
		</form>';
		
		return $html;
	}

	public function visitor_login($args = array()){	

		$arg_array = array(
			'visitor' => "register"
		);
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		//Visitor Registration
		if($arg_array['visitor'] == 'register'){
			$html .='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Visitor Registration - Fill Registration Form</h3>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>Please fill the following form completely. <br>
				Fields marked  * are required ...</p>
				<form id="defaultForm" method="post" class="form-horizontal" action="'.base_url().'visitor/visitor_registration">
				<input type="hidden" name="listing_id" value="'.$_REQUEST['listing_id'].'">
				<input type="hidden" name="redirect_page" value="comment">
				<div class="form-group">
					<div class="col-sm-4">
					<label><strong>Account Info</strong></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Username</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_username" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Password</label>
					<div class="col-sm-3">
					<input type="password" class="form-control" name="visitor_password" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label><strong>Contact Information</strong></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Full name</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_firstname" placeholder="First name" />
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_lastname" placeholder="Last name" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Contact</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_phone" placeholder="Phone Number" />
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_mobile" placeholder="Mobile Number" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Email address</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" name="visitor_email" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label><strong>Mailing Information</strong></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Address</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" name="visitor_address" placeholder="Mailing Address" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_city" placeholder="City/ Town" />
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control auto-num" name="visitor_zip" maxlength="7" placeholder="Zip/ Post Code" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-3">
					<input type="text" class="form-control" name="visitor_province" placeholder="State/ Province" />
					</div>
					<div class="col-sm-3">
					<select name="visitor_country" placeholder="Country" class="form-control">
						<option value="252">United States</option>
						<option value="2">Albania</option>
						<option value="3">Algeria</option>
						<option value="4">American Samoa</option>
						<option value="5">Andorra</option>
						<option value="6">Angola</option>
						<option value="7">Anguilla</option>
						<option value="8">Antarctica</option>
						<option value="9">Antigua and Barbuda</option>
						<option value="10">Arctic Ocean</option>
						<option value="11">Argentina</option>
						<option value="12">Armenia</option>
						<option value="13">Aruba</option>
						<option value="14">Ashmore and Cartier Islands</option>
						<option value="15">Atlantic Ocean</option>
						<option value="16">Australia</option>
						<option value="17">Austria</option>
						<option value="18">Azerbaijan</option>
						<option value="19">Bahamas</option>
						<option value="20">Bahrain</option>
						<option value="21">Baker Island</option>
						<option value="22">Bangladesh</option>
						<option value="23">Barbados</option>
						<option value="24">Bassas da India</option>
						<option value="25">Belarus</option>
						<option value="26">Belgium</option>
						<option value="27">Belize</option>
						<option value="28">Benin</option>
						<option value="29">Bermuda</option>
						<option value="30">Bhutan</option>
						<option value="31">Bolivia</option>
						<option value="32">Bosnia and Herzegovina</option>
						<option value="33">Botswana</option>
						<option value="34">Bouvet Island</option>
						<option value="35">Brazil</option>
						<option value="36">British Indian Ocean Territory</option>
						<option value="37">British Virgin Islands</option>
						<option value="38">Brunei</option>
						<option value="39">Bulgaria</option>
						<option value="40">Burkina Faso</option>
						<option value="41">Burma</option>
						<option value="42">Burundi</option>
						<option value="43">Cambodia</option>
						<option value="44">Cameroon</option>
						<option value="45">Canada</option>
						<option value="46">Cape Verde</option>
						<option value="47">Cayman Islands</option>
						<option value="48">Central African Republic</option>
						<option value="49">Chad</option>
						<option value="50">Chile</option>
						<option value="51">China</option>
						<option value="52">Christmas Island</option>
						<option value="53">Clipperton Island</option>
						<option value="54">Cocos (Keeling) Islands</option>
						<option value="55">Colombia</option>
						<option value="56">Comoros</option>
						<option value="57">Congo, Democratic Republic</option>
						<option value="58">Congo, Republic</option>
						<option value="59">Cook Islands</option>
						<option value="60">Coral Sea Islands</option>
						<option value="61">Costa Rica</option>
						<option value="62">Cote d\'Ivoire</option>
						<option value="63">Croatia</option>
						<option value="64">Cuba</option>
						<option value="65">Cyprus</option>
						<option value="66">Czech Republic</option>
						<option value="67">Denmark</option>
						<option value="68">Djibouti</option>
						<option value="69">Dominica</option>
						<option value="70">Dominican Republic</option>
						<option value="71">Ecuador</option>
						<option value="72">Egypt</option>
						<option value="73">El Salvador</option>
						<option value="74">Equatorial Guinea</option>
						<option value="75">Eritrea</option>
						<option value="76">Estonia</option>
						<option value="77">Ethiopia</option>
						<option value="78">Europa Island</option>
						<option value="79">Falkland Islands (Islas Malvinas)</option>
						<option value="80">Faroe Islands</option>
						<option value="81">Fiji</option>
						<option value="82">Finland</option>
						<option value="83">France</option>
						<option value="84">French Guiana</option>
						<option value="85">French Polynesia</option>
						<option value="86">French Southern and Antarctic Lands</option>
						<option value="87">Gabon</option>
						<option value="88">Gambia</option>
						<option value="89">Gaza Strip</option>
						<option value="90">Georgia</option>
						<option value="91">Germany</option>
						<option value="92">Ghana</option>
						<option value="93">Gibraltar</option>
						<option value="94">Glorioso Islands</option>
						<option value="95">Greece</option>
						<option value="96">Greenland</option>
						<option value="97">Grenada</option>
						<option value="98">Guadeloupe</option>
						<option value="99">Guam</option>
						<option value="100">Guatemala</option>
						<option value="101">Guernsey</option>
						<option value="102">Guinea</option>
						<option value="103">Guinea-Bissau</option>
						<option value="104">Guyana</option>
						<option value="105">Haiti</option>
						<option value="106">Heard Island and McDonald Islands</option>
						<option value="107">Holy See (Vatican City)</option>
						<option value="108">Honduras</option>
						<option value="109">Hong Kong</option>
						<option value="110">Howland Island</option>
						<option value="111">Hungary</option>
						<option value="112">Iceland</option>
						<option value="113">India</option>
						<option value="114">Indian Ocean</option>
						<option value="115">Indonesia</option>
						<option value="116">Iran</option>
						<option value="117">Iraq</option>
						<option value="118">Ireland</option>
						<option value="119">Israel</option>
						<option value="120">Italy</option>
						<option value="121">Jamaica</option>
						<option value="122">Jan Mayen</option>
						<option value="123">Japan</option>
						<option value="124">Jarvis Island</option>
						<option value="125">Jersey</option>
						<option value="126">Johnston Atoll</option>
						<option value="127">Jordan</option>
						<option value="128">Juan de Nova Island</option>
						<option value="129">Kazakhstan</option>
						<option value="130">Kenya</option>
						<option value="131">Kingman Reef</option>
						<option value="132">Kiribati</option>
						<option value="135">Kuwait</option>
						<option value="136">Kyrgyzstan</option>
						<option value="137">Laos</option>
						<option value="138">Latvia</option>
						<option value="139">Lebanon</option>
						<option value="140">Lesotho</option>
						<option value="141">Liberia</option>
						<option value="142">Libya</option>
						<option value="143">Liechtenstein</option>
						<option value="144">Lithuania</option>
						<option value="145">Luxembourg</option>
						<option value="146">Macau</option>
						<option value="147">Macedonia</option>
						<option value="148">Madagascar</option>
						<option value="149">Malawi</option>
						<option value="150">Malaysia</option>
						<option value="151">Maldives</option>
						<option value="152">Mali</option>
						<option value="153">Malta</option>
						<option value="154">Man, Isle of</option>
						<option value="155">Marshall Islands</option>
						<option value="156">Martinique</option>
						<option value="157">Mauritania</option>
						<option value="158">Mauritius</option>
						<option value="159">Mayotte</option>
						<option value="160">Mexico</option>
						<option value="161">Micronesia</option>
						<option value="162">Midway Islands</option>
						<option value="163">Moldova</option>
						<option value="164">Monaco</option>
						<option value="165">Mongolia</option>
						<option value="166">Montserrat</option>
						<option value="167">Morocco</option>
						<option value="168">Mozambique</option>
						<option value="169">Namibia</option>
						<option value="170">Nauru</option>
						<option value="171">Navassa Island</option>
						<option value="172">Nepal</option>
						<option value="173">Netherlands</option>
						<option value="174">Netherlands Antilles</option>
						<option value="175">New Caledonia</option>
						<option value="176">New Zealand</option>
						<option value="177">Nicaragua</option>
						<option value="178">Niger</option>
						<option value="179">Nigeria</option>
						<option value="180">Niue</option>
						<option value="181">Norfolk Island</option>
						<option value="133">North Korea</option>
						<option value="182">Northern Mariana Islands</option>
						<option value="183">Norway</option>
						<option value="184">Oman</option>
						<option value="185">Pacific Ocean</option>
						<option value="186">Pakistan</option>
						<option value="187">Palau</option>
						<option value="188">Palmyra Atoll</option>
						<option value="189">Panama</option>
						<option value="190">Papua New Guinea</option>
						<option value="191">Paracel Islands</option>
						<option value="192">Paraguay</option>
						<option value="193">Peru</option>
						<option value="194">Philippines</option>
						<option value="195">Pitcairn Islands</option>
						<option value="196">Poland</option>
						<option value="197">Portugal</option>
						<option value="198">Puerto Rico</option>
						<option value="199">Qatar</option>
						<option value="200">Reunion</option>
						<option value="201">Romania</option>
						<option value="202">Russia</option>
						<option value="203">Rwanda</option>
						<option value="204">Saint Helena</option>
						<option value="205">Saint Kitts and Nevis</option>
						<option value="206">Saint Lucia</option>
						<option value="207">Saint Pierre and Miquelon</option>
						<option value="208">Saint Vincent and the Grenadines</option>
						<option value="209">Samoa</option>
						<option value="210">San Marino</option>
						<option value="211">Sao Tome and Principe</option>
						<option value="212">Saudi Arabia</option>
						<option value="213">Senegal</option>
						<option value="214">Seychelles</option>
						<option value="215">Sierra Leone</option>
						<option value="216">Singapore</option>
						<option value="217">Slovakia</option>
						<option value="218">Slovenia</option>
						<option value="219">Solomon Islands</option>
						<option value="220">Somalia</option>
						<option value="221">South Africa</option>
						<option value="222">South Georgia and the South Sandwich Islands</option>
						<option value="134">South Korea</option>
						<option value="223">Southern Ocean</option>
						<option value="224">Spain</option>
						<option value="225">Spratly Islands</option>
						<option value="226">Sri Lanka</option>
						<option value="227">Sudan</option>
						<option value="228">Suriname</option>
						<option value="229">Svalbard</option>
						<option value="230">Swaziland</option>
						<option value="231">Sweden</option>
						<option value="232">Switzerland</option>
						<option value="233">Syria</option>
						<option value="234">Taiwan</option>
						<option value="235">Tajikistan</option>
						<option value="236">Tanzania</option>
						<option value="237">Thailand</option>
						<option value="238">Togo</option>
						<option value="239">Tokelau</option>
						<option value="240">Tonga</option>
						<option value="241">Trinidad and Tobago</option>
						<option value="242">Tromelin Island</option>
						<option value="243">Tunisia</option>
						<option value="244">Turkey</option>
						<option value="245">Turkmenistan</option>
						<option value="246">Turks and Caicos Islands</option>
						<option value="247">Tuvalu</option>
						<option value="248">Uganda</option>
						<option value="249">Ukraine</option>
						<option value="250">United Arab Emirates</option>
						<option value="251">United Kingdom</option>
						<option value="253">Uruguay</option>
						<option value="254">Uzbekistan</option>
						<option value="255">Vanuatu</option>
						<option value="256">Venezuela</option>
						<option value="257">Vietnam</option>
						<option value="258">Virgin Islands</option>
						<option value="259">Wake Island</option>
						<option value="260">Wallis and Futuna</option>
						<option value="261">West Bank</option>
						<option value="262">Western Sahara</option>
						<option value="263">World</option>
						<option value="264">Yemen</option>
						<option value="265">Yugoslavia</option>
						<option value="266">Zambia</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label><strong></strong></label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-9 col-sm-offset-2">
					<button type="submit" class="btn btn-warning" name="signup" value="Sign up">Register Now</button>
					</div>
				</div>
				</form>
			</div>
			</div>
			</div>';
		}elseif($arg_array['visitor'] == 'login'){
			$html .='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Visitors Login</h3>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<form action="'.base_url().'visitor/access/" method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="listing_id" value="'.$_REQUEST['listing_id'].'">
				<input type="hidden" name="redirect_page" value="comment">
				<input type="hidden" name="listing_title" value="'.$_REQUEST['listing_title'].'">
				<div class="form-group">
					<label class="col-xs-3 control-label" for="yourRating">User Name *</label>
					<div class="col-xs-6">
					<input type="text" name="visitor_username" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" for="titleSummary">Password *</label>
					<div class="col-xs-6">
					<input type="password" class="form-control" name="visitor_password">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" for="titleSummary"></label>
					<div class="col-xs-6"> <a href="'.base_url().'/login/?user-type=new&listing_id='.$product['listing_id'].'">Not Registered? Register Now</a> </div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" for="reviewsComments"></label>
					<div class="col-xs-6">
					<button type="submit" name="login-submit" class="btn btn-warning">Login</button>
					</div>
				</div>
				</form>
			</div>
			</div>';
		}
		return $html;
	}
	public function add_comment(){
		$html .='<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Write Your Review Or Comment Here</h3>
		</div>
		</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<form class="form-horizontal" action="'.base_url().'visitor/add_visitor_review/" method="post" enctype="multipart/form-data">
			<input name="comment_linkid" value="'.$_REQUEST['comment_linkid'].'" type="hidden">
			<input name="comment_visitor" value="'.$_REQUEST['comment_visitor'].'" type="hidden">
			<div class="form-group">
				<label class="col-xs-2 control-label" for="yourRating">Your Rating *</label>
				<div class="col-xs-10">
				<ul class="review-radio">
					<li>
					<input type="radio" value="5" name="comment_rating" class="rting"/>
					<img width="84" height="16" src="'.base_url().'images/stars/pic_star5.png" alt=""></li>
					<li>
					<input type="radio" value="4" name="comment_rating" class="rting"/>
					<img width="84" height="16" src="'.base_url().'images/stars/pic_star4.png" alt=""></li>
					<li>
					<input type="radio" value="3" name="comment_rating" class="rting"/>
					<img width="84" height="16" src="'.base_url().'images/stars/pic_star3.png" alt=""></li>
					<li>
					<input type="radio" value="2" name="comment_rating" class="rting"/>
					<img width="84" height="16" src="'.base_url().'images/stars/pic_star2.png" alt=""></li>
					<li>
					<input type="radio" value="1" name="comment_rating" class="rting"/>
					<img width="84" height="16" src="'.base_url().'images/stars/pic_star1.png" alt="" style="width:84px; height:16px;"></li>
				</ul>
				</div>

			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label" for="titleSummary">Title / Summary *</label>
				<div class="col-xs-5">
				<input type="text" class="form-control" name="comment_title" placeholder="Title / Summary">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label" for="reviewsComments">Reviews / Comments *</label>
				<div class="col-xs-5">
				<textarea class="form-control" rows="5" name="comment_description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label" for="reviewsComments"></label>
				<div class="col-xs-5">
				<input type="submit" name="review-submit" class="btn btn-warning" value="Submit" />
				</div>
			</div>
			</form>
		</div>
		</div>';
		return $html;
	}
	public function business_directory($args=array()){

		$arg_array = array(
			'limit' => NULL,'pagination' => false
		);
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}		
		if($arg_array['pagination']){	
			$new_array_count = $this->db->query("SELECT * FROM setup_category_listing WHERE category_parent = 0")->result();
			$records = count($new_array_count);
			$pages = ceil($records/$limit);
			if(isset($_POST['current_page'])){
				$current_page = $_POST['current_page'];
			}else{
				$current_page = 0;				
			}
			if($current_page <1){
				$from = 0;
			}else{ $from = $current_page*$limit; }
			if(isset($_POST['next'])){
			 	$current_page++;
			}elseif(isset($_POST['prev'])){ $current_page--;}
		}else{
			$from = 0;
		}
		$new_array = $this->db->query("SELECT * FROM setup_category_listing WHERE category_parent = 0 AND category_stat_listing = '1' ORDER BY category_name_1 ASC LIMIT $from,$to")->result();	
		if(count($new_array)<=0){
			$html .='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="page-title">Business Directory</h1>
				<h5 style="font-size:20px;color:#ff0000;">No Opportunities Found!</h5>
			</div>
			</div>';
		}else{

			$html .='<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<h1 class="page-title">Business Industries</h1>
			</div>
			</div>';
			foreach($new_array as $row){
				$row = (array) $row;
				if(!empty($row["category_image"])){
					$url = base_url().'sector_photo/'.$row['category_image'];
				}else{
					$url = base_url().'sector_photo/'.$row['category_id'].'.jpg';
				}
				$url_header = @get_headers($url);
				if($i==0){$html .='<div class="row">';}$i++;
				$html .='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<form action="" method="post" enctype="multipart/form-data">
					<div class="directory-listing featured-listing">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="img-hover" data-toggle="tooltip" title="click for more info"><a href="#" data-toggle="modal" data-target="#myModal-'.$row['category_id'].'">';
            	if($url_header[0] == 'HTTP/1.1 404 Not Found' ){ 
            		$html .='<img class="img-responsive" src="'.base_url().'sector_photo/sample.jpg" width="100%"/>';
            	}else{
            		$html .='<img class="img-responsive" src="'.$url.'" width="100%"/>';
            	}
							$html .='</a></div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5><a href="#" data-toggle="modal" data-trigger="hover" data-target="#myModal-'.$row['category_id'].'">'.$row['category_name_1'].'</a></h5>
						</div>
					</div>
					</form>
				</div>';
  				if($i==4){ $i = 0;$html .='</div>';}
				$html .='</div>
				<!-- Modal -->
				<div id="myModal-'.$row['category_id'].'" class="modal fade" role="dialog">
				<div class="modal-dialog container">
					<!-- Modal content-->
					<div class="modal-content">
					<div class="modal-header" style="background:#fad455;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">'.$row['category_name_1'].'</h4>
					</div>
					<div class="modal-body">
						<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<div class="img-hover">';
							if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
							}else{
								$html .='<img class="img-responsive" src="'.$url.'" width="100%"/>';
							}
							$html .='</div>
						</div>
						<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
							<p class="text-justify"><strong>'.$row['category_desc_1'].'</strong></p>
						</div>
						</div>        
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 style="border-bottom: 1px solid #ddd;padding-bottom: 15px;">Categories</h4></div>            
						</div>
						<div class="row">';
						$cat_array = $this->db->query("SELECT * FROM setup_category_listing WHERE category_parent = '".$row['category_id']."' AND category_stat_listing = '1' ORDER BY category_name_1 ASC")->result();		
						foreach($cat_array as $row_cat){
							$row_cat = (array) $row_cat;	  		  
							$html .='<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<a class="cat-name" href="'.base_url().'search/?sec_id='.$row['category_id'].'&cat_id='.$row_cat['category_id'].'">'.$row_cat['category_name_1'].'</a>
							</div>';
						}         
						$html .='</div>
					</div>
					<div class="modal-footer" style="text-align:center;">
						<a href="'.base_url().'search/?sec_id='.$row['category_id'].'" class="btn btn-warning btn-sm" style="background-color:#333;color:#fff;border-color:#333;">Search Categories Now</a>
					</div>
					</div>
				</div>
				</div>';
			}
		}
	}
} 
