<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellerdb extends CI_Model {

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
	public function seller_list($startpage,$limit)
	{
		try
		{
			if($this->db->get("seller")->num_rows()>0)
			{
				$rec = ceil($this->db->get("seller")->num_rows()/$limit);
				
				$lTo = $limit;
				
				if($startpage<1){$startpage=1;}
				if($startpage>$rec){$startpage = $rec;}
				if($startpage>1){$lFrom = ($startpage-1)*$limit;}
				else{$lFrom = 0;}
				
				$query = $this->db->select("*")->from("seller")->join('setup_package_subscription', 'seller.seller_package = setup_package_subscription.package_subscription_id')->join('setup_country', 'seller.seller_country = setup_country.country_id')->order_by('seller_id', 'desc')->limit($lTo,$lFrom);
				
				
				$data["seller_list"] = $this->db->get()->result();
				
				
				$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);
				return $data;
			}
			else
			{
				throw new Exception("No record found...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function get_seller_search_resutl($data,$startpage,$limit)
	{
		try
		{			
			if(!empty($data["seller_type"]) && $data["seller_type"]!="all"){$query = $this->db->select("*")->from("seller")->where("seller_type",$data["seller_type"]);}
			else{$query = $this->db->select("*")->from("seller");}			
			if(!empty($data["seller_username"])){$query = $query->where("seller_username",$data["seller_username"]);}			
			if(!empty($data["seller_company"])){$query = $query->like("seller_company",$data["seller_company"]);}
			if(!empty($data["seller_firstname"])){$query = $query->like("seller_firstname",$data["seller_firstname"]);}
			if(!empty($data["seller_lastname"])){$query = $query->where("seller_lastname",$data["seller_lastname"]);}			
						

			
			$rec = ceil($this->db->get()->num_rows()/$limit);
			//re using query for fetching records
			if(!empty($data["seller_type"]) && $data["seller_type"]!="all"){$query = $this->db->select("*")->from("seller")->where("seller_type",$data["seller_type"]);}
			else{$query = $this->db->select("*")->from("seller");}			
			if(!empty($data["seller_username"])){$query = $query->where("seller_username",$data["seller_username"]);}			
			if(!empty($data["seller_company"])){$query = $query->like("seller_company",$data["seller_company"]);}
			if(!empty($data["seller_firstname"])){$query = $query->like("seller_firstname",$data["seller_firstname"]);}
			if(!empty($data["seller_lastname"])){$query = $query->where("seller_lastname",$data["seller_lastname"]);}
			
			$query = $query->join('setup_package_subscription', 'seller.seller_package = setup_package_subscription.package_subscription_id')->join('setup_country', 'seller.seller_country = setup_country.country_id');
			
			if($data["order_by"]=="id"){$query = $query->order_by("seller_id",'desc');}
			if($data["order_by"]=="username"){$query = $query->order_by("seller_username",'asc');}
			if($data["order_by"]=="firstname"){$query = $query->order_by("seller_firstname",'asc');}
			$lTo = $limit;
			
			if($startpage<1){$startpage=1;}
			if($startpage>$rec){$startpage = $rec;}
			if($startpage>1){$lFrom = ($startpage-1)*$limit;}
			else{$lFrom = 0;} 				
			
			$query->limit($lTo,$lFrom);				
			$data["post_data"] = $data;
			$data["seller_list"] = $this->db->get()->result();		
			
			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);
			return $data;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function count_seller_list($data)
	{
		try
		{
			return $this->db->get_where("listing",$data)->num_rows();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function select_seller($data)
	{
		try
		{
			if($this->db->get_where("seller",$data)->num_rows()>0)
			{
				$this->db->select("*")->from("seller")->where($data)->join('setup_package_subscription', 'seller.seller_package = setup_package_subscription.package_subscription_id');
				//var_dump($this->db->get()->result());
				return $this->db->get()->result();
			}
			else
			{
				throw new Exception("No record found...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}	
	}
	public function update_seller()
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$this->input->post("seller_id")))->num_rows()>0)
			{
				$data = array(
				"seller_password"=>$this->input->post("seller_password"),
				"seller_package"=>$this->input->post("seller_package"),
				"seller_payment_period"=>$this->input->post("seller_payment_period"),
				"seller_expire_date"=>date("Y-m-d H:i:s",strtotime($this->input->post("seller_expire_date")." ".date("H:s:i"))),
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_status"=>"approved",
				"seller_status_feature"=>"",
				"seller_status_email"=>"approved",
				"seller_status_approval"=>"off",
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				
				$this->db->where('seller_id', $this->input->post("seller_id"));		
				$this->db->update('seller', $data);
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record found to Update...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function update_seller_profile()
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$this->input->post("seller_id")))->num_rows()>0)
			{
				$data = array(
				"seller_title"=>$this->input->post("seller_title"),
				"seller_firstname"=>$this->input->post("seller_firstname"),
				"seller_lastname"=>$this->input->post("seller_lastname"),
				"seller_phone"=>$this->input->post("seller_phone"),
				"seller_mobile"=>$this->input->post("seller_mobile"),
				"seller_fax"=>$this->input->post("seller_fax"),
				"seller_email"=>$this->input->post("seller_email"),
				"seller_website"=>$this->input->post("seller_website"),
				"seller_address"=>$this->input->post("seller_address"),
				"seller_address2"=>$this->input->post("seller_address2"),
				"seller_city"=>$this->input->post("seller_city"),
				"seller_province"=>$this->input->post("seller_province"),
				"seller_zip"=>$this->input->post("seller_zip"),
				"seller_country"=>$this->input->post("seller_country"),
				"seller_type"=>$this->input->post("seller_type"),
				"seller_company"=>$this->input->post("seller_company"),
				"seller_desc_1"=>$this->input->post("seller_desc_1"),
				"seller_language"=>$this->input->post("seller_language"),
				"seller_lastupdate"=>date("Y-m-d H:i:s")				
				);
				
				$this->db->where('seller_id', $this->input->post("seller_id"));		
				$this->db->update('seller', $data);
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record found to Update...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function add_new_seller($data)
	{
		try
		{
			$this->db->insert("seller",$data);
			$data["id"] = $this->db->insert_id();
			
                        $packageAry = $this->get_package_detail($data["seller_package"]);
			$packageObj = $packageAry["package_detail"];
			$seller_payment_period = $this->input->post("seller_payment_period");
			if($seller_payment_period=="monthly"){$payment_amount = $packageObj->package_subscription_monthly; $payment_pack_days=30;}
			elseif($seller_payment_period=="quarterly"){$payment_amount = $packageObj->package_subscription_quarterly; $payment_pack_days=90;}
			elseif($seller_payment_period=="semiannually"){$payment_amount = $packageObj->package_subscription_semi_annually;$payment_pack_days=180;}			
			elseif($seller_payment_period=="annually"){$payment_amount = $packageObj->package_subscription_yearly;$payment_pack_days=365;}
			
			$package_quantity = $this->input->post("package_quantity");
			if(!empty($package_quantity)){$payment_status = "pending";}else{$payment_status="accepted";}
			
			$payment_data = array("payment_type"=>"subscription","payment_seller"=>$data["id"],"payment_amount"=>$payment_amount,"payment_pack_id"=>$data["seller_package"],"payment_pack_days"=>$payment_pack_days,"payment_date"=>date("Y-m-d H:i:s"),"payment_status"=>$payment_status);

			$this->db->insert("payment",$payment_data);
			throw new Exception("New user has been added sucessfully...");		
		}
		catch(Exception $e)
		{
			$data["msg"] = $e->getMessage();
		}
		return $data;		
	}
	public function payment_history($data)
	{
		try
		{
			$rec = ceil($this->db->get("payment")->num_rows()/$data["limit"]);
				
			$lTo = $data["limit"];
			$startpage = $data["currentPage"];	
			if($startpage<1){$startpage=1;}
			if($startpage>$rec){$startpage = $rec;}
			if($startpage>1){$lFrom = ($startpage-1)*$data["limit"];}
			else{$lFrom = 0;} 				
			
			$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);
			
			$this->db->select("*")->from("payment")->where(array("payment_seller"=>$data["payment_seller"]))->order_by('payment_id', 'desc')->limit($lTo,$lFrom);
			$data["payment_detail"] = $this->db->get()->result();		
	
			$this->db->select("*")->from("seller")->where(array("seller_id"=>$data["payment_seller"]))->join('setup_package_subscription', 'seller.seller_package = setup_package_subscription.package_subscription_id');
			$data["seller_detail"] = $this->db->get()->result();
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	public function feature($data)
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$data["seller_id"]))->num_rows()>0)
			{
				$this->db->where('seller_id', $data["seller_id"]);		
				$this->db->update('seller', array("seller_status_feature"=>$data["seller_status_feature"],"seller_lastupdate"=>date("Y-m-d H:i:s")));
				throw new Exception("Seller feature list updated...");
			}
			else
			{
				throw new Exception("Seller feature record not found...");
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] = $e->getMessage();
		}
		return $data;
	}
	public function auto_approve($data)
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$data["seller_id"]))->num_rows()>0)
			{
				$this->db->where('seller_id', $data["seller_id"]);		
				$this->db->update('seller', array("seller_status_approval"=>$data["seller_status_approval"]));
				throw new Exception("Seller Approve list updated...");
			}
			else
			{
				throw new Exception("Seller Approve record not found...");
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] = $e->getMessage();
		}
		return $data;
	}
	public function delete_seller($data)
	{
		try
		{
			if($this->db->get_where("seller",$data)->num_rows()>0)
			{
				$this->db->delete("seller",$data);
				@unlink("./logo_cache/".$data["seller_id"].".jpg");
				$detail = $this->db->get_where("listing",array("listing_seller"=>$data["seller_id"]))->result();
				foreach($detail as $obj)
				{
					$this->db->delete("payment",array("payment_listing"=>$obj->listing_id));
				}
				$this->db->delete("listing",array("listing_seller"=>$data["seller_id"]));
				$this->db->delete("payment",array("payment_seller"=>$data["seller_id"]));				
				throw new Exception("One seller has been Deleted sucessfully...");
			}
			else
			{
				throw new Exception("Record not found to delete...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function get_payment_detail($payment_id=0)
	{
		$detail = $this->db->get_where("payment",array("payment_id"=>$payment_id))->result();
		foreach($detail as $obj){return $obj;}
	}
	public function delete_payment_histroy($data)
	{
		try
		{
			if($this->db->get_where("payment",$data)->num_rows()>0)
			{
				$this->db->delete("payment",$data);	
				
				throw new Exception("One Payment Transaction has been Deleted sucessfully...");
			}
			else
			{
				throw new Exception("Record not found to delete...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function payment_pack_detail($data)
	{
		switch($data["payment_type"])
		{
			case "listing":
			$array =  $this->db->get_where("setup_package_listing",array("package_listing_id"=>$data["payment_pack_id"]))->result();
			foreach($array as $k=>$obj){return $obj->package_listing_name_1;}
			break;
			
			case "subscription":
			$temp_array = array("0"=>"Pay Per Listing","1"=>"Lite");
			return $temp_array[$data["payment_pack_id"]];
			break;
			
			default:
			return "none";
			break;
		}
	}
	public function get_package_detail($id=0)
	{
		try
		{
			if($id>0)
			{
				$array = $this->db->get_where("setup_package_subscription",array("package_subscription_id"=>$id))->result();
				foreach($array as $k=>$obj){$data["package_detail"] = $obj;}				
				throw new Exception("One user has been Deleted sucessfully...");
			}
			else
			{
				throw new Exception("Record not found...");
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] = $e->getMessage();
		}
		return $data;
	}
	public function seller_package_degrade($data)
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$data["seller_id"]))->num_rows()>0)
			{
				$this->db->where('seller_id', $data["seller_id"]);		
				$this->db->update('seller', array("seller_expire_date"=>$data["seller_expire_date"]));				
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record found to Update...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function seller_package_upgrade($data)
	{
		try
		{
			if($this->db->get_where("seller",array("seller_id"=>$data["seller_id"]))->num_rows()>0)
			{
				$this->db->where('seller_id', $data["seller_id"]);		
				$this->db->update('seller', array("seller_expire_date"=>$data["seller_expire_date"],"seller_package"=>$data["seller_package"],"seller_payment_period"=>$data["seller_payment_period"]));
				$this->db->insert("payment",array("payment_type"=>"subscription","payment_seller"=>$data["seller_id"],"payment_pack_id"=>$data["package_subscription_id"],"payment_pack_days"=>$data["payment_pack_days"],"payment_date"=>date("Y-m-d H:i:s"),"payment_status"=>"approved"));
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record found to Update...");
			}
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function get_country_list()
	{
		$this->db->select("*")->from("setup_country")->where(array("country_status"=>1))->order_by('country_order', 'asc');
		return $this->db->get()->result();
	}	
	public function get_title_list()
	{
		$this->db->select("*")->from("setup_title");
		return $this->db->get()->result();
	}
	//listing package section
	public function select_listing_package()
	{
		try
		{
			$data["listing_package_result"] = $this->db->get("setup_package_listing")->result();
			return $data;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function get_listing_package($data)
	{
		try
		{
			$listing_detail = $this->db->get_where("setup_package_listing",$data)->result();
			foreach($listing_detail as $k=>$obj){$data["listingObj"] = $obj;}
			return $data;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function add_listing_package()
	{		
		try
		{			
			$tempdata = array(
				"package_listing_name_1"=>$this->input->post("package_listing_name_1"),
				"package_listing_price"=>$this->input->post("package_listing_price"),
				"package_listing_days"=>$this->input->post("package_listing_days"),
				"package_listing_pics"=>$this->input->post("package_listing_pics"),
				"package_listing_video"=>$this->input->post("package_listing_video"),
				"package_listing_doc"=>$this->input->post("package_listing_doc"),
				"package_listing_event"=>$this->input->post("package_listing_event"),
				"package_listing_news"=>$this->input->post("package_listing_news"),
				"package_listing_coupon"=>$this->input->post("package_listing_coupon"),
				"package_listing_product"=>$this->input->post("package_listing_product"),			
				"package_listing_category"=>$this->input->post("package_listing_category"),
				"package_listing_renew"=>$this->input->post("package_listing_renew"),
				"package_listing_featured"=>$this->input->post("package_listing_featured")
			);
			$this->db->insert("setup_package_listing",$tempdata);
			throw new Exception("One record has Added...");			
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	public function listing_package_update()
	{		
		try
		{
			if($this->db->get_where("setup_package_listing",array("package_listing_id"=>$this->input->post("package_listing_id")))->num_rows()>0)
			{
				$tempdata = array(
					"package_listing_name_1"=>$this->input->post("package_listing_name_1"),
					"package_listing_price"=>$this->input->post("package_listing_price"),
					"package_listing_days"=>$this->input->post("package_listing_days"),
					"package_listing_pics"=>$this->input->post("package_listing_pics"),
					"package_listing_video"=>$this->input->post("package_listing_video"),
					"package_listing_doc"=>$this->input->post("package_listing_doc"),
					"package_listing_event"=>$this->input->post("package_listing_event"),
					"package_listing_news"=>$this->input->post("package_listing_news"),
					"package_listing_coupon"=>$this->input->post("package_listing_coupon"),
					"package_listing_product"=>$this->input->post("package_listing_product"),			
					"package_listing_category"=>$this->input->post("package_listing_category"),
					"package_listing_renew"=>$this->input->post("package_listing_renew"),
					"package_listing_featured"=>$this->input->post("package_listing_featured")
				);
				$this->db->update("setup_package_listing",$tempdata);
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record has Update...");
			}			
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	public function listing_package_delete($data)
	{
		try
		{
			if($this->db->get_where("setup_package_listing",$data)->num_rows()>0)
			{
				$this->db->delete("setup_package_listing",$data);
				throw new Exception("One record has been deleted...");	
			}
			else
			{
				throw new Exception("Record Not found...");
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	//subscription package section
	public function select_subscription_package()
	{
		try
		{
			$data["subscription_package_result"] = $this->db->get("setup_package_subscription")->result();
			return $data;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public function get_subscription_package($data)
	{
		try
		{
			$subscription_detail = $this->db->get_where("setup_package_subscription",$data)->result();
			foreach($subscription_detail as $k=>$obj){$data["subscriptionObj"] = $obj;}
			return $data;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	// add subscription package
	public function add_subscription_package()
	{		
		try
		{			
			$tempdata = array(
					"package_subscription_name_1"=>$this->input->post("package_subscription_name_1"),
					"package_subscription_listings"=>$this->input->post("package_subscription_listings"),
					"package_subscription_pics"=>$this->input->post("package_subscription_pics"),
					"package_subscription_videos"=>$this->input->post("package_subscription_videos"),
					"package_subscription_docs"=>$this->input->post("package_subscription_docs"),
					"package_subscription_events"=>$this->input->post("package_subscription_events"),
					"package_subscription_news"=>$this->input->post("package_subscription_news"),
					"package_subscription_coupons"=>$this->input->post("package_subscription_coupons"),
					"package_subscription_products"=>$this->input->post("package_subscription_products"),
					"package_subscription_categories"=>$this->input->post("package_subscription_categories"),			
					"package_subscription_featured"=>$this->input->post("package_subscription_featured"),
					"package_subscription_monthly"=>$this->input->post("package_subscription_monthly"),
					"package_subscription_quarterly"=>$this->input->post("package_subscription_quarterly"),
					"package_subscription_semi_annually"=>$this->input->post("package_subscription_semi_annually"),
					"package_subscription_annually"=>$this->input->post("package_subscription_annually")
				);
			$this->db->insert("setup_package_subscription",$tempdata);
			throw new Exception("One record has Added...");			
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	// update subscription package
	public function subscription_package_update()
	{		
		try
		{
			if($this->db->get_where("setup_package_subscription",array("package_subscription_id"=>$this->input->post("package_subscription_id")))->num_rows()>0)
			{
				$tempdata = array(
					"package_subscription_name_1"=>$this->input->post("package_subscription_name_1"),
					"package_subscription_listings"=>$this->input->post("package_subscription_listings"),
					"package_subscription_pics"=>$this->input->post("package_subscription_pics"),
					"package_subscription_videos"=>$this->input->post("package_subscription_videos"),
					"package_subscription_docs"=>$this->input->post("package_subscription_docs"),
					"package_subscription_events"=>$this->input->post("package_subscription_events"),
					"package_subscription_news"=>$this->input->post("package_subscription_news"),
					"package_subscription_coupons"=>$this->input->post("package_subscription_coupons"),
					"package_subscription_products"=>$this->input->post("package_subscription_products"),
					"package_subscription_categories"=>$this->input->post("package_subscription_categories"),			
					"package_subscription_featured"=>$this->input->post("package_subscription_featured"),
					"package_subscription_monthly"=>$this->input->post("package_subscription_monthly"),
					"package_subscription_quarterly"=>$this->input->post("package_subscription_quarterly"),
					"package_subscription_semi_annually"=>$this->input->post("package_subscription_semi_annually"),
					"package_subscription_annually"=>$this->input->post("package_subscription_annually")
				);
				$this->db->update("setup_package_subscription",$tempdata);
				throw new Exception("One record has Updated...");
			}
			else
			{
				throw new Exception("No record has Update...");
			}			
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	public function subscription_package_delete($data)
	{
		try
		{
			if($this->db->get_where("setup_package_subscription",$data)->num_rows()>0)
			{
				$this->db->delete("setup_package_subscription",$data);
				throw new Exception("One record has been deleted...");	
			}
			else
			{
				throw new Exception("Record Not found...");
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] =  $e->getMessage();
		}
		return $data;
	}
	public function change_seller_pass($status=true)
	{
		if($status)
		{
			$seller_detail = $this->session->getdata("slrd");
			$this->db->where("seller_username",$seller_detail["slrnm"]);
			$this->update("seller",array("seller_password"=>$this->input->post("seller_password_new")));
			return "password changed...";
		}
	}
	public function get_member_list()
	{
		return $this->db->select("seller_id,seller_firstname,seller_lastname")->from("seller")->order_by("seller_firstname","asc")->get()->result();
	}	
	public function get_seller_listing_setting()
	{
		$result = $this->db->get("contractor_listing_setting")->result();
		foreach($result as $obj){return $obj;}
	}
	public function update_seller_listing_setting($id,$data)
	{
		try
		{	
			$this->db->where('contractor_listing_setting_id', $id);
			$this->db->update('contractor_listing_setting', $data);	
			throw new Exception("Setting Updated...");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}	
	}
	public function seller_email_verification($seller_id,$status)
	{
		if($seller_id>0)
		{
			$this->db->where("seller_id",$seller_id);
			$this->db->update("seller",array("seller_status_email"=>$status));
		}
	}
	public function get_paypaldetail()
	{
		$detail = $this->db->get_where("setup_payment",array("payment_name"=>"paypal"))->result();
		foreach($detail as $obj){return $obj;}
	}
	public function get_mail_template($email_id=0)
	{
		if($email_id>0)
		{
			$detail = $this->db->get_where("setup_email",array("email_id"=>$email_id,"email_status"=>"yes"))->result();
			foreach($detail as $obj){return $obj;}
		}
	}
}