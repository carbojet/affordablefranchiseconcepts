<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logindb extends CI_Model {

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
	public function login($data)
	{
		if($data["table_name"]=="user")
		{
			return $this->db->get_where("user",array("user_username"=>$this->input->post("user_username"),"user_password"=>$this->input->post("user_password")))->result();
		}
		elseif($data["table_name"]=="seller")
		{
			return $this->db->get_where("seller",array("seller_username"=>$this->input->post("seller_username"),"seller_password"=>$this->input->post("seller_password")))->result();
		}
	}	
}
