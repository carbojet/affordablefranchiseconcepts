<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvaldb extends CI_Model {

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
	
	//sellse approval status
	public function seller_approval()
	{
		try
		{
			return $this->db->join("setup_package_subscription","seller.seller_package=setup_package_subscription.package_subscription_id")->get_where("seller",array("seller_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_seller($seller_id=0,$status="pending")
	{
		try
		{
			$this->db->where("seller_id",$seller_id);
			$this->db->update("seller",array("seller_status"=>$status));
			$this->db->where("listing_seller",$seller_id);
			$this->db->update("listing",array("listing_status"=>$status));
			$detail = $this->db->get_where("seller",array("seller_id"=>$seller_id))->result();
			foreach($detail as $obj){$data["sellerObj"] = $obj;}
			 
			throw new Exception("Seller approval status changed to $status...");
		}
		catch(Exception $e)
		{
			$data["success_msg"] = $e->getMessage();
		}
		return $data;
	}
	//visitor approval status
	public function visitor_approval()
	{
		try
		{
			return $this->db->get_where("visitor",array("visitor_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_visitor($visitor_id=0,$status)
	{
		try
		{
			$this->db->where("visitor_id",$visitor_id);
			$this->db->update("visitor",array("visitor_status"=>$status));
			throw new Exception("Visitor approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//listing approval status
	public function listing_approval()
	{
		try
		{
			return $this->db->get_where("listing",array("listing_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_listing($listing_id=0,$status)
	{
		try
		{
			$this->db->where("listing_id",$listing_id);
			$this->db->update("listing",array("listing_status"=>$status));
			throw new Exception("Listing approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//photo approval status
	public function photo_approval()
	{
		try
		{
			return $this->db->get_where("listing_photo",array("photo_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_photo($photo_id=0,$status)
	{
		try
		{
			$this->db->where("photo_id",$listing_id);
			$this->db->update("listing_photo",array("photo_status"=>$status));
			throw new Exception("Listing Photo approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//video approval status
	public function video_approval()
	{
		try
		{
			return $this->db->get_where("listing_video",array("video_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_video($video_id=0,$status)
	{
		try
		{
			$this->db->where("video_id",$video_id);
			$this->db->update("listing_video",array("video_status"=>$status));
			throw new Exception("Listing Video approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//document approval status
	public function document_approval()
	{
		try
		{
			return $this->db->get_where("listing_document",array("document_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_document($video_id=0,$status)
	{
		try
		{
			$this->db->where("document_id",$video_id);
			$this->db->update("listing_document",array("document_status"=>$status));
			throw new Exception("Listing Document approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//event approval status
	public function event_approval()
	{
		try
		{
			return $this->db->get_where("listing_event",array("event_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_event($event_id=0,$status)
	{
		try
		{
			$this->db->where("event_id",$event_id);
			$this->db->update("listing_event",array("event_status"=>$status));
			throw new Exception("Listing Event approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//coupon approval status
	public function coupon_approval()
	{
		try
		{
			return $this->db->get_where("listing_coupon",array("coupon_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_coupon($coupon_id=0,$status)
	{
		try
		{
			$this->db->where("coupon_id",$coupon_id);
			$this->db->update("listing_coupon",array("coupon_status"=>$status));
			throw new Exception("Listing Coupon approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//product approval status
	public function product_approval()
	{
		try
		{
			return $this->db->get_where("listing_product",array("product_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_product($product_id=0,$status)
	{
		try
		{
			$this->db->where("product_id",$product_id);
			$this->db->update("listing_product",array("product_status"=>$status));
			throw new Exception("Listing Product approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//news approval status
	public function news_approval()
	{
		try
		{
			return $this->db->get_where("listing_news",array("news_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_news($news_id=0,$status)
	{
		try
		{
			$this->db->where("news_id",$news_id);
			$this->db->update("listing_news",array("news_status"=>$status));
			throw new Exception("Listing News approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//review approval status
	public function review_approval()
	{
		try
		{
			return $this->db->get_where("visitor_comment",array("comment_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_review($comment_id=0,$status)
	{
		try
		{
			$this->db->where("comment_id",$comment_id);
			$this->db->update("visitor_comment",array("comment_status"=>$status));
			throw new Exception("Comment approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//Banner ads approval status
	public function advertisement_approval()
	{
		try
		{
			return $this->db->get_where("advertisement",array("advertisement_status"=>"pending"))->result();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function approve_advertisement($advertisement_id=0,$status)
	{
		try
		{
			$this->db->where("advertisement_id",$advertisement_id);
			$this->db->update("advertisement",array("advertisement_status"=>$status));
			throw new Exception("Advertisement approval status changed to $status....");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
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
