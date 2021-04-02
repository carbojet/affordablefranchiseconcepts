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
						<form class="" role="form" action="'.base_url().'/listing/?type=search" method="post">          
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
		$arg_array = array('limit' => null,'view_type' => 'list');
		$ads_rotation = $this->ads_rotation();		
		//Shortcode arguments
		/*
		$arg_array = shortcode_atts(array(
			'limit' => NULL	,
			'view_type' => 'list'
		),$args);
		*/
		if(is_array($args) && count($args)>0){
			$arg_array = array_merge($arg_array,$args);
		}
		
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}

		if($arg_array['view_type']=="list"){
			$from = $ads_rotation["fc_from"];
			$to = $ads_rotation["fc_to"];
			$limit = "LIMIT $from,$to";
		}else{
			$limit ="";
		}
		$featured_array = $this->db->order_by("listing_lastupdate","DESC")->get_where("listing",array("listing_status_feature"=>"featured"),$to,$from)->result();
		//$featured_array = $edmanagerdb->get_results("SELECT * FROM listing WHERE listing_status_feature='featured' ORDER BY listing_lastupdate DESC $limit",ARRAY_A); 
		
		$html = '<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="listing-title">Featured Listings</h3>
			</div>
		</div>';
		$i = 0; 
		foreach($featured_array as $row){
			$row = (array) $row;
			if(!empty($row["listing_image"])){
				$url = base_url().'photo_big/'.$row['listing_image'];
			}else{
				$url = base_url().'photo_big/'.$row['listing_id'].'.jpg';
			}
			$url_header = @get_headers($url);

			$rating_array = $this->db->order_by("comment_id","DESC")->get_where("visitor_comment",array("comment_linkid"=>$row['listing_id']),1)->result();			
			//$rating_array = $edmanagerdb->get_results("SELECT * FROM visitor_comment WHERE comment_linkid = '".$row['listing_id']."' ORDER BY comment_id DESC LIMIT 1",ARRAY_A);	
			
			$comment_rating=0;
			foreach($rating_array as $rating_row){ $comment_rating = $rating_row->comment_rating; }
			$photo_array = $this->db->get_where("listing_photo",array("photo_listing"=>$row['listing_id'],"photo_status_main"=>"main"),1)->result();
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
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<h5><a href="'.base_url().'product/?listing_id='.$row['listing_id'].'">'.$row['listing_title_1'].'</a></h5>
							<p class="text-left"><a href="'.base_url().'product/?listing_id='.$row['listing_id'].'">'.substr(strip_tags($row['listing_descbrief_1']),0,180)."...".'</a></p>
							<span class="rating" style="margin-right:15px;">'.$city.", ".$state.'</span><br/><span class="rating">Investment: $'.number_format($row['listing_price']).'</span>
						</div>
					</div>
				</div>';
			}elseif($arg_array['view_type'] == 'grid'){
				if($i==0){
				$html .='<div class="row">';
				}$i++;
					$html .='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="featured-listing">
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
									<h5><a href="'.base_url().'product/?listing_id='.$row['listing_id'].'">'.$row['listing_title_1'].'</a></h5>
									<p class="text-justify"><a style="color:#555;" href="'.base_url().'product/?listing_id='.$row['listing_id'].'"></a></p>
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
		return $html;
	}

	function new_listing($args){
		$ads_rotation = ads_rotation();
		$edmanagerdb = db_connection();
		$arg_array = shortcode_atts(array(
			'limit' => NULL,	
			'view_type' => 'list'	
		),$args);		
		$limit = $arg_array['limit'];
		if($arg_array['limit'] != NULL){
			$to = $limit;
		}
		$from = $ads_rotation["nc_from"];
		$to = $ads_rotation["nc_to"];
		if($arg_array['view_type']=="list"){	
			$from = $ads_rotation["nc_from"];
			$to = $ads_rotation["nc_to"];
			$limit = "LIMIT $from,$to";
		}else{
			$limit ="";
		}
		$new_array = $edmanagerdb->get_results("SELECT * FROM listing WHERE listing_status_new='renew' ORDER BY listing_lastupdate DESC $limit",ARRAY_A);
		$html ='<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    	<h3 class="listing-title">New Listings</h3>
			</div>
		</div>';
		foreach($new_array as $row){
    		if(!empty($row["listing_image"])){
				$url = get_site_url().'/directory/photo_big/'.$row['listing_image'];
			}else{
				$url = get_site_url().'/directory/photo_big/'.$row['listing_id'].'.jpg';
			}
			$url_header = @get_headers($url);
			$rating_array = $edmanagerdb->get_results("SELECT * FROM visitor_comment WHERE comment_linkid = '".$row['listing_id']."' ORDER BY comment_id DESC LIMIT 1",ARRAY_A);
			$comment_rating=0;
			foreach($rating_array as $rating_row){ $comment_rating = $rating_row['comment_rating']; }
			$photo_array = $edmanagerdb->get_results("SELECT * FROM listing_photo WHERE photo_listing = '".$row['listing_id']."' AND photo_status_main = 'main' LIMIT 1",ARRAY_A);
			foreach($photo_array as $photo_row){ $photo_id = $photo_row['photo_id']; }
			if(empty($photo_id)){$photo_id = "sample";}
			//List View Type Check
			$loc = explode("-",$row['listing_location_path']);
			$country_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[1]."'",ARRAY_A);
			$state_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[2]."'",ARRAY_A);
			$city_arr = $edmanagerdb->get_results("SELECT location_name FROM setup_location WHERE location_id = '".$loc[3]."'",ARRAY_A);
			foreach($country_arr as $country_rw){ $country = $country_rw['location_name']; }
			foreach($state_arr as $state_rw){ $state = $state_rw['location_name']; }
			foreach($city_arr as $city_rw){ $city = $city_rw['location_name']; }
		    if($arg_array['view_type'] == 'list'){
				
				$html .='<div class="new-listing">
  					<div class="row">
					    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					    	<div class="img-hover">';
      							if($url_header[0] == 'HTTP/1.1 404 Not Found' ){
						        	$html .='<a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">
							        	<img class="img-responsive" src="'.base_url().'/directory/photo_big/sample.jpg" width="100%" />
						            </a>';
	  							}else{
						        	$html .='<a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">
							            <img class="img-responsive" src="'.$url.'" width="100%" />
						            </a>';
						        }
							$html .='</div>
					    </div>
    					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
      						<h5><a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">'.$row['listing_title_1'].'</a></h5>
      						<p class="text-left"><a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">'.substr($row['listing_descbrief_1'],0,180).'...</a></p>
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
										$html .='<a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">
											<img class="img-responsive" src="'.base_url().'/directory/photo_big/sample.jpg" width="100%" />
										</a>';      		
									}else{
										$html .='<a href="'.base_url().'/product/?listing_id='.$row['listing_id'].'">
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
		return $html;
	}



	public function advanced_search_widget_form(){	
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
		if (isset($_SERVER['HTTP_USER_AGENT'])) $curl_opt[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt_array($ch, $curl_opt);
		$content = curl_exec($ch);
		if (!is_null($curl_info)) $curl_info = curl_getinfo($ch);
		curl_close($ch);
		$ary = unserialize($content);
		$country = $ary["country"];
		$regionName = $ary["regionName"];
		//$edmanagerdb = db_connection();	
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
}