<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitesetupdb extends CI_Model {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
	}
	public function mail_templates()
	{
		return $this->db->order_by("email_name_1","asc")->get("setup_email")->result();
	}
	public function update_all_mail_templates()
	{
		try
		{
			$temp_array = $this->input->post("email_id");
			$status_list = $this->input->post("email_status_val");
			foreach($temp_array as $k=>$val)
			{
				$this->db->where("email_id",$val);
				$this->db->update("setup_email",array("email_status"=>$status_list[$k]));
			}
			throw new Exception("mail template status been updated...");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}	 	
	}
	public function email_template_edit($email_id=0)
	{
		$result = $this->db->get_where("setup_email",array("email_id"=>$email_id))->result();
		foreach($result as $obj){return $obj;}
	}
	public function update_email_template()
	{
		try
		{
			$this->db->where("email_id",$this->input->post("email_id"));
			$this->db->update("setup_email",array("email_subject_1"=>$this->input->post("email_subject_1"),"email_name_1"=>$this->input->post("email_name_1"),"email_content_1"=>$this->input->post("email_content_1")));
			throw new Exception("mail template been updated...");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}	 	
	}
	
	public function payment_preferences()
	{
		return $this->db->order_by("payment_name","asc")->get("setup_payment")->result();
	}
	
	public function update_all_payment_preference()
	{
		try

		{

			$temp_array = $this->input->post("payment_id");

			$status_list = $this->input->post("payment_status_val");

			foreach($temp_array as $k=>$val)

			{

				$this->db->where("payment_id",$val);

				$this->db->update("setup_payment",array("payment_status"=>$status_list[$k]));

			}

			throw new Exception("payment status been updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}	 	

	}

	public function payment_preference_edit($payment_id=0)
	{
		$result = $this->db->get_where("setup_payment",array("payment_id"=>$payment_id))->result();
		foreach($result as $obj){return $obj;}
	}
	public function update_payment_preference($data)
	{
		try
		{
			$this->db->where("payment_id",$this->input->post("payment_id"));
			$this->db->update("setup_payment",$data);
			throw new Exception("payment preference updated...");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function import_export($result=array(),$type,$import_section="listing")
	{
		if($type=="import")
		{			
			$record_not_insert = "";			
			$ads = 0;
			$update = 0;
			$delete = 0;
			$row_pos=2;
			$record_rows="";
			if(!empty($result))
			{				
				foreach($result as $row)
				{					
					set_time_limit(0);
					$category_path="";
					$category_list = array();
					$location_list = array();
					$mismatch_category ="";
					$mismatch_location ="";
					
					if($import_section=="listing")
					{
						//sector and category check with update level one
						//all category is in array $category_list
						if(count($row)==25)
						{					
							$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[2]))->result();
							$sector_category = false;
							if(count($result)>0)
							{
								foreach($result as $obj){$category_list[] = $obj->category_id;}
								$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[3]))->result();
								if(count($result)>0)
								{
									foreach($result as $obj){$category_list[] = $obj->category_id;}
									$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[4]))->result();
									if(count($result)>0)
									{
										foreach($result as $obj){$category_list[] = $obj->category_id;}
										$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[5]))->result();
										if(count($result)>0)
										{
											foreach($result as $obj){$category_list[] = $obj->category_id;}
											$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[6]))->result();
											if(count($result)>0)
											{
												foreach($result as $obj){$category_list[] = $obj->category_id;}
												$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[7]))->result();														
												if(count($result)>0)
												{
													foreach($result as $obj){$category_list[] = $obj->category_id;}
													$sector_category =true;
												}else{$mismatch_category .= $row[7];}											
											}else{$mismatch_category .= $row[6];}
										}else{$mismatch_category .= $row[5];}
									}else{$mismatch_category .= $row[4];}
								}else{$mismatch_category .= $row[3];}
							}else{$mismatch_category .= $row[2];}
							
							
							
												
							//check location
							$location = false;
							$result = $this->db->get_where("setup_location",array("location_parent"=>0,"location_name"=>$row[8]))->result();
							if(count($result)>0)
							{
								foreach($result as $obj){$location_list[] = $obj->location_id; $country_id=$obj->location_id;}
								$result = $this->db->get_where("setup_location",array("location_parent"=>$obj->location_id,"location_name"=>$row[9]))->result();
								if(count($result)>0)
								{
									foreach($result as $obj){$location_list[] = $obj->location_id;}
									$result = $this->db->get_where("setup_location",array("location_parent"=>$obj->location_id,"location_name"=>$row[10]))->result();
									if(count($result)>0)
									{
										foreach($result as $obj){$location_list[] = $obj->location_id;$listing_zip = $obj->location_zipcode;}
										$location = true;								
									}else{$mismatch_location .="Country : ".$row[8]." State : ".$row[9]." City : ".$row[10];}
								}else{$mismatch_location .="Country : ".$row[8]." State : ".$row[9];}						
							}else{$mismatch_location .="Country : ".$row[8];}
							
							
							if(!$sector_category)
							{
								$record_not_insert .="# ".$row[0]." record can not inserted cause of these <b> $mismatch_category </b> category mismatch...<br/>";
							}
							
							if(!$location)
							{
								$record_not_insert .="# ".$row[0]." record can not inserted cause of this <b> $mismatch_location </b> location mismatch...<br/>";
							}
							
							//insert listing		 
							if($sector_category==true && $location==true)
							{
								$result = $this->db->get_where("seller",array("seller_username"=>$row[0]))->result();
								if(count($result)>0){foreach($result as $obj){$seller_id=$obj->seller_id;}}
								else
								{
									$this->db->insert("seller",array("seller_username"=>$row[0],"seller_language"=>$row[12],"seller_country"=>$country_id,"seller_status"=>"approved","seller_status_feature"=>"featured","seller_status_email"=>"approved","seller_status_approval"=>"on"));
									$seller_id = $this->db->insert_id();
								}						
								$listing_category_path = "-".implode("-",$category_list)."-";
								$listing_url_1 = str_replace(" ","-",$row[1]);
								$listing_location_path = "-".implode("-",$location_list)."-";
								
								$listing_status_keywords = $row[1]." + ".str_replace(" ","-",$row[1])." + ".$row[14]." + ".$row[2]." + ".$row[3]." + ".$row[4]." + ".$row[5]." + ".$row[6]." + ".$row[7]." + ".$row[8]." + ".$row[9]." + ".$row[10]." + ".$row[11]." + ".$row[17]."+".$row[18]."+".$row[19]."+".$row[20]."+".$row[21];
								
								if($seller_id>0)
								{
									$listingresult = $this->db->get_where("listing",array("listing_seller"=>$seller_id))->result();
									
									$data = array("listing_seller"=>$seller_id,"listing_category"=>$category_list[0],"listing_category_path"=>$listing_category_path,"listing_url_1"=>$listing_url_1,"listing_title_1"=>$row[1],"listing_zip"=>$listing_zip,"listing_price"=>$row[13],"listing_location_path"=>$listing_location_path,"listing_location"=>$location_list[0],"listing_facilities"=>$row[17],"listing_competition"=>$row[18],"listing_growth"=>$row[19],"listing_financing"=>$row[20],"listing_training"=>$row[21],"listing_descbrief_1"=>$row[14],"listing_descfull_1"=>$row[14],"listing_sell_reason"=>$row[22],"listing_image"=>$row[23],"listing_status_feature"=>"unfeatured","listing_status_new"=>"new","listing_status_claimed"=>"claimed","listing_status_keywords"=>$listing_status_keywords,"listing_status"=>"approved","listing_lastupdate"=>date("Y-m-d H:i:s"));
									if(count($listingresult)<=0)
									{
									
										$ads++;
										$this->db->insert("listing",$data);
										$data["id"] = $this->db->insert_id();
										if($data["id"]>0)
										{
											$temp_array = $category_list;
											foreach($temp_array as $k=>$val)
											{
												$this->db->insert("listing_category",array("category_listing"=>$data["id"],"category_value"=>$val,"category_path"=>"-".$val."-","category_status"=>"approved"));
											}
										}
									}
									else
									{
										$data = array("listing_seller"=>$seller_id,"listing_category"=>$category_list[0],"listing_category_path"=>$listing_category_path,"listing_url_1"=>$listing_url_1,"listing_title_1"=>$row[1],"listing_zip"=>$listing_zip,"listing_price"=>$row[13],"listing_location_path"=>$listing_location_path,"listing_location"=>$location_list[0],"listing_facilities"=>$row[17],"listing_competition"=>$row[18],"listing_growth"=>$row[19],"listing_financing"=>$row[20],"listing_training"=>$row[21],"listing_descbrief_1"=>$row[14],"listing_descfull_1"=>$row[14],"listing_sell_reason"=>$row[22],"listing_image"=>$row[23],"listing_lastupdate"=>date("Y-m-d H:i:s"));
										
										foreach($listingresult as $obj){$obj = $obj;}
										if($row[24]=="Update" || $row[24]=="update")
										{
											//$this->db->where(array("category_listing"=>$obj->listing_id));
											//$this->db->delete("listing_category");								
											$this->db->where(array("listing_id"=>$obj->listing_id));
											$this->db->update("listing",$data);
											//$temp_array = $category_list;
//											foreach($temp_array as $k=>$val)
//											{
//												$this->db->insert("listing_category",array("category_listing"=>$obj->listing_id,"category_value"=>$val,"category_path"=>"-".$val."-","category_status"=>"approved"));
//											}
											$update++;
										}
										if($row[24]=="Delete" || $row[24]=="delete")
										{
											$this->db->where(array("listing_id"=>$obj->listing_id));
											$this->db->delete("listing");
											$delete++;
										}
									}
								}
							}
						}
						else
						{
							$record_rows .="<span style='color:red'># $row_pos doesn't have proper format in CSV sheet<span><br/>";
						}
						$row_pos++;
					}					
					
					if($import_section=="location")
					{
						//location
						if(count($row)==5)
						{
							$country = $row[0];
							$state = $row[1];
							$city = $row[2];
							$zipcode = $row[3];
							$result1 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>0,"location_name"=>$country))->result();
							if(count($result1)<=0)
							{
								//country
								$location_pathname = "-".$country."-";						
								$this->db->insert("setup_location",array("location_parent"=>0,"location_pathname"=>$location_pathname,"location_name"=>$country));
								$location_id = $this->db->insert_id();
								$location_path = "-$location_id-";						
								$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
														
								$result2 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>$location_id,"location_name"=>$state))->result();
								//if state not exist
								if(count($result2)<=0)
								{
									//state
									$location_pathname = "-".$country."-".$state."-";						
									$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$state));
									
									$location_id = $this->db->insert_id();
									$location_path .= "$location_id-";						
									$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
									$result3 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>$location_id,"location_name"=>$city))->result();
									//if city not exist
									if(count($result3)<=0)
									{
										//city
										$location_pathname = "-".$country."-".$state."-".$city."-";						
										$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$city,"location_zipcode"=>$zipcode));
										$location_id = $this->db->insert_id();
										$location_path .= "$location_id-";						
										$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
										$ads++;
									}
									else
									{
										//if city exist
										foreach($result3 as $obj){$location_id = $obj->location_id;}
										if($row[4]=="update" || $row[4]=="Update")
										{
											$this->db->where(array("location_id"=>$location_id))->update("setup_location",array("location_zipcode"=>$zipcode));
											$update++;
										}
										
										if($row[4]=="delete" || $row[4]=="Delete")
										{
											$this->db->delete("setup_location",array("location_id"=>$location_id));
											$delete++;
										}
									}
								}
								else
								{
									//if state exist
									foreach($result2 as $obj){$location_id = $obj->location_id;$location_path = $obj->location_path;}								
									$result4 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>$location_id,"location_name"=>$city))->result();
									//if city not exist
									if(count($result4)<=0)
									{
										//city
										$location_pathname = "-".$country."-".$state."-".$city."-";						
										$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$city,"location_zipcode"=>$zipcode));
										$location_id = $this->db->insert_id();
										$location_path .= "$location_id-";						
										$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
										$ads++;
									}
									else
									{
										//if city exist
										foreach($result4 as $obj){$location_id = $obj->location_id;}
										if($row[4]=="update" || $row[4]=="Update")
										{
											$this->db->where(array("location_id"=>$location_id))->update("setup_location",array("location_zipcode"=>$zipcode));
											$update++;
										}
										if($row[4]=="delete" || $row[4]=="Delete")
										{
											$this->db->delete("setup_location",array("location_id"=>$location_id));
											$delete++;
										}
									}
								}
								
							}
							else
							{
								//if country exist
								foreach($result1 as $obj){$location_id = $obj->location_id;$location_path = $obj->location_path;}
								
								$result5 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>$location_id,"location_name"=>$state))->result();
								//if state not exist
								if(count($result5)<=0)
								{
									//state
									$location_pathname = "-".$country."-".$state."-";						
									$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$state));
									$location_id = $this->db->insert_id();
									$location_path .= "$location_id-";						
									$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
										//city
										$location_pathname = "-".$country."-".$state."-".$city."-";						
										$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$city,"location_zipcode"=>$zipcode));
										$location_id = $this->db->insert_id();
										$location_path .= "$location_id-";						
										$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
										$ads++;								
								}
								else
								{
									//if state exist
									foreach($result5 as $obj){$location_id = $obj->location_id;$location_path = $obj->location_path;}
									
									$result6 = $this->db->limit(0,1)->get_where("setup_location",array("location_parent"=>$location_id,"location_name"=>$city))->result();
									if(count($result6)<=0)
									{
										//city
										$location_pathname = "-".$country."-".$state."-".$city."-";						
										$this->db->insert("setup_location",array("location_parent"=>$location_id,"location_pathname"=>$location_pathname,"location_name"=>$city,"location_zipcode"=>$zipcode));
										$location_id = $this->db->insert_id();
										$location_path .= "$location_id-";						
										$this->db->where("location_id=$location_id")->update("setup_location",array("location_path"=>$location_path));
										$ads++;
									}
									else
									{
										//if city exist
										foreach($result6 as $obj){$location_id = $obj->location_id;}
										if($row[4]=="update" || $row[4]=="Update")
										{
											$this->db->where(array("location_id"=>$location_id))->update("setup_location",array("location_zipcode"=>$zipcode));
											$update++;
										}
										if($row[4]=="delete" || $row[4]=="Delete")
										{
											$this->db->delete("setup_location",array("location_id"=>$location_id));
											$delete++;
										}
									}
								}
							}
							
							}
						else
						{
							
						}
					}					
					
					if($import_section=="sectors")
					{
						if(count($row)==5)
						{
							if(!empty($row[0]))
							{
								$result = $this->db->get_where("setup_category_listing",array("category_name_1"=>$row[0]))->result();
								if(count($result)<=0)
								{
									//sector
									$category_url = str_replace(" ","-",$row[0]);
									$this->db->insert("setup_category_listing",array("category_name_1"=>$row[0],"category_parent"=>0,"category_desc_1"=>$row[2],"category_url_1"=>$category_url,"category_stat_listing"=>1,"category_image"=>$row[3],"category_lastupdate"=>date("Y-m-d H:i:s")));
									$category_id = $this->db->insert_id();
									$category_path = "-$category_id-";
									$this->db->where("category_id=$category_id")->update("setup_category_listing",array("category_path"=>$category_path,"category_parent"=>0));
									
									//category
									$result1 = $this->db->get_where("setup_category_listing",array("category_name_1"=>htmlentities($row[1]),"category_parent"=>$category_id))->result();
									if(count($result1)<=0)
									{
										$category_url = htmlentities(str_replace(" ","-",$row[1]));
										$this->db->insert("setup_category_listing",array("category_name_1"=>htmlentities($row[1]),"category_url_1"=>$category_url,"category_parent"=>$category_id,"category_stat_listing"=>1,"category_lastupdate"=>date("Y-m-d H:i:s")));
										$category_id = $this->db->insert_id();
										$category_path .= "$category_id-";
										$this->db->where("category_id=$category_id")->update("setup_category_listing",array("category_path"=>$category_path));
										$ads++;
									}
								}
								else
								{								
									foreach($result as $obj){$category_parent = $obj->category_id;}
									if($row[4]=="update" || $row[4]=="Update")
									{
										$this->db->where(array("category_id"=>$category_parent))->update("setup_category_listing",array("category_desc_1"=>$row[2],"category_image"=>$row[3]));
										$update++;
									}
									$result2 = $this->db->get_where("setup_category_listing",array("category_name_1"=>htmlentities($row[1]),"category_parent"=>$category_parent))->result();
									if(count($result2)<=0)
									{
										//category
										$category_url = htmlentities(str_replace(" ","-",$row[1]));
										$this->db->insert("setup_category_listing",array("category_name_1"=>htmlentities($row[1]),"category_url_1"=>$category_url,"category_parent"=>$category_parent,"category_stat_listing"=>1,"category_lastupdate"=>date("Y-m-d H:i:s")));
										$category_id = $this->db->insert_id();
										$category_path = "-$category_parent-$category_id-";
										$this->db->where("category_id=$category_id")->update("setup_category_listing",array("category_path"=>$category_path));
										$ads++;
									}
									else
									{
										foreach($result as $obj){$category_id = $obj->category_id;$category_parent = $obj->category_parent;}
										
										if($row[4]=="delete" || $row[4]=="Delete")
										{
											$this->db->where(array("category_id"=>$category_id))->delete("setup_category_listing");
											
											//$result3 = $this->db->get_where("setup_category_listing",array("category_parent"=>$category_parent))->result();
//											if(count($result3)<=0)
//											{
//												$this->db->where(array("category_id"=>$category_parent))->delete("setup_category_listing");
//											}
											$delete++;											
										}
										
									}
								}
								
							}
						}
						else
						{
						
						}
					}
				}
			}
			
			$record_not_insert .=$record_rows; 
			$record_not_insert .=$ads." record has been inserted...<br/>";
		
			$record_not_insert .=$update." record has been updated...<br/>";
			
			$record_not_insert .=$delete." record has been deleted...<br/>";
				
			return $record_not_insert;
		}
		if($type=="export")
		{
			$rows=array();
			if($import_section=="listing")
			{			
				$seller_result = $this->db->get("seller")->result();
				$rows[] = array("id","title","Sector","category","Sector","category","Sector","category","Country","Location","city","postal code","currency","asking","summary","year established","number of employees","facilities","competition","growth","financing","training","Business Status","image","status");		
				foreach($seller_result as $sellerObj)
				{
					set_time_limit(0);
					$seller_username = $sellerObj->seller_username;
					$listing_result = $this->db->get_where("listing",array("listing_seller"=>$sellerObj->seller_id))->result();
					foreach($listing_result as $key => $listingObj)
					{					
						$row = array();
						$row[0] = $sellerObj->seller_username;
						$row[1] = $listingObj->listing_title_1;
						
						
						
						//getting sector and category list
						$cat_key = 3;
						$sec_key = 2;
						$category_result = explode('-',$listingObj->listing_category_path);
						if(isset($category_result[0])){unset($category_result[0]);}
						if(isset($category_result[7])){unset($category_result[7]);}
						if(isset($category_result[8])){unset($category_result[8]);}
						if(isset($category_result[9])){unset($category_result[9]);}
						if(isset($category_result[10])){unset($category_result[10]);}
						foreach($category_result as $k=>$id)
						{							
							$sector_result = $this->db->get_where("setup_category_listing",array("category_id"=>$id))->result();
							foreach($sector_result as $sectorObj)
							{
								if($k%2!=0)
								{
									$row[$sec_key] = $sectorObj->category_name_1;
									$sec_key +=2;
								}
								else
								{
									//$row[$cat_key] = $categoryObj->category_name_1;
									$row[$cat_key] = $sectorObj->category_name_1;
									$cat_key +=2;
								}
							}						
						}
						
						//getting sector and category list
						//$category_result = $this->db->join("setup_category_listing","listing_category.category_value=setup_category_listing.category_id")->get_where("listing_category",array("category_listing"=>$listingObj->listing_id))->result();
//						$cat_key = 3;
//						$sec_key = 2;
//						foreach($category_result as $categoryObj)
//						{
//							$sector_result = $this->db->get_where("setup_category_listing",array("category_id"=>$categoryObj->category_parent))->result();
//							foreach($sector_result as $sectorObj)
//							{
//								$row[$sec_key] = $sectorObj->category_name_1;
//								$row[$cat_key] = $categoryObj->category_name_1;
//								$cat_key +=2;
//								$sec_key +=2;
//							}						
//						}
						
						$locationArray =  explode("-",$listingObj->listing_location_path);
						
						$lcoation_result = $this->db->get_where("setup_location",array("location_parent"=>0,"location_id"=>$locationArray[1]))->result();
						
						if(count($lcoation_result)>0)
						{
							foreach($lcoation_result as $locationObj){$row[8]=$locationObj->location_name;}
						}
						else
						{
							$row[8]="";
						}
						
						$lcoation_result = $this->db->get_where("setup_location",array("location_parent"=>$locationObj->location_id,"location_id"=>$locationArray[2]))->result();						
						if(count($lcoation_result)>0)
						{						
							foreach($lcoation_result as $locationObj){$row[9]=$locationObj->location_name;}
						}
						else
						{
							$row[9]="";
						}
						
						$lcoation_result = $this->db->get_where("setup_location",array("location_parent"=>$locationObj->location_id,"location_id"=>$locationArray[3]))->result();
						if(count($lcoation_result)>0)
						{						
							foreach($lcoation_result as $locationObj){$row[10]=$locationObj->location_name;}
						}
						else
						{
							$row[10]="";
						}
						$row[11] = $listingObj->listing_zip;
						$row[12] = 1;
						$row[13] = $listingObj->listing_price;
						$row[14] = str_replace(",","&#44;",$listingObj->listing_descfull_1);
						$row[15] = 0;
						$row[16] = "";
						$row[17] = str_replace(",","&#44;",$listingObj->listing_facilities);
						$row[18] = str_replace(",","&#44;",$listingObj->listing_competition);
						$row[19] = str_replace(",","&#44;",$listingObj->listing_growth);
						$row[20] = str_replace(",","&#44;",$listingObj->listing_financing);
						$row[21] = str_replace(",","&#44;",$listingObj->listing_training);
						$row[22] = str_replace(",","&#44;",$listingObj->listing_sell_reason);
						$row[23] = $listingObj->listing_image;
						if(!empty($sellerObj->seller_username))
						{
							$rows[] = $row;
						}				
					}	
				}
			}
			if($import_section=="sectors")
			{
				$rows[] = array("Sector","Category","Description","Image","Status");
				$sector_result = $this->db->order_by("category_name_1","asc")->get_where("setup_category_listing",array("category_parent"=>0))->result();
				foreach($sector_result as $sector_obj)
				{
					$category_result = $this->db->order_by("category_name_1","asc")->get_where("setup_category_listing",array("category_parent"=>$sector_obj->category_id))->result();
					foreach($category_result as $category_obj)
					{
						set_time_limit(0);
						$rows[] = array($sector_obj->category_name_1,$category_obj->category_name_1,$sector_obj->category_desc_1,$sector_obj->category_image,"new");
					}				
				}				
			}
			
			if($import_section=="location")
			{
				$rows[] = array("Country","State","City","Zipcode","Status");
				$country_result = $this->db->order_by("location_name","asc")->get_where("setup_location",array("location_parent"=>0))->result();
				foreach($country_result as $c_obj)
				{
					$state_result = $this->db->order_by("location_name","asc")->get_where("setup_location",array("location_parent"=>$c_obj->location_id))->result();
					foreach($state_result as $s_obj)
					{
						$ct_result = $this->db->order_by("location_name","asc")->get_where("setup_location",array("location_parent"=>$s_obj->location_id))->result();
						foreach($ct_result as $ct_obj)
						{
							set_time_limit(0);
							$rows[] = array($c_obj->location_name,$s_obj->location_name,$ct_obj->location_name,$ct_obj->location_zipcode,"new");
						}
					}				
				}				
			}
			
			if($import_section=="visitors")
			{				
				$result = $this->db->order_by("visitor_firstname","asc")->join("visitor_comment","visitor_comment.comment_visitor=visitor.visitor_id")->get("visitor")->result();
				
				$rows[] = array("visitor","email","phone","address 1","address 2","city","state","country","zip","Capital Available to invest","Estimated Net Worth","Purchase Time Frame","Desired Location","Additional Comments","IRA/401K use");
				
				
				foreach($result as $obj)
				{
					$rows[] = array($obj->visitor_title." ".$obj->visitor_firstname." ".$obj->visitor_lastname,$obj->visitor_email,$obj->visitor_phone,$obj->visitor_address,$obj->visitor_address2,$obj->visitor_city,$obj->visitor_province,$obj->visitor_country,$obj->visitor_zip,$obj->visitor_company,$obj->visitor_mobile,$obj->visitor_fax,$obj->visitor_website,$obj->comment_description);
				}
			}
			return $rows;		
		}		
	}
}

