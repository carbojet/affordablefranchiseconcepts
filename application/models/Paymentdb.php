<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentdb extends CI_Model {

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
	public function payments($current_page=0,$limit=5,$data=array())
	{
		try
		{
			if($this->db->get("payment")->num_rows()>0)
			{
				if(!empty($data))
				{
					$this->db->where($data);
				}
				$rec = ceil($this->db->get("payment")->num_rows()/$limit);
				
				$lTo = $limit;
				
				if($current_page<1){$current_page=1;}
				if($current_page>$rec){$current_page = $rec;}
				if($current_page>1){$lFrom = ($current_page-1)*$limit;}
				else{$lFrom = 0;} 				
				
				if(!empty($data))
				{
					$this->db->where($data);
				}
				$this->db->select("*")->from("payment")->order_by('payment_id', 'desc')->limit($lTo,$lFrom);				
				
				$data["payment_list"] = $this->db->get()->result();				
				
				$data["pagination"] = array("startpage"=>$current_page,"pages"=>$rec);
				return $data;
			}
		}
		catch(Exception $e)
		{
			$data["success_msg"] = $e->getMessage();
		}
		return $data;
	}
	public function get_listing_package($data)
	{
		$detail = $this->db->select("*")->where(array("package_listing_id"=>$data["listing_package"]))->get("setup_package_listing")->result();
		foreach($detail as $k=>$obj){ return $obj;}
	}
	public function update_payment_status($payment_id=0,$status="rejected")
	{
		try
		{
			$this->db->where("payment_id",$payment_id);
			$this->db->update("payment",array("payment_status"=>$status));
			throw new Exception("One Payment has been $status successfully...");
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
}
