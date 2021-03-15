<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userdb extends CI_Model {

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
	
	public function user_list()
	{
		try
		{
			if($this->db->get("user")->num_rows()>0)
			{
				return $this->db->get("user")->result();
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
	public function select_user($data)
	{
		try
		{
			if($this->db->get_where("user",$data)->num_rows()>0)
			{
				return $this->db->get_where("user",$data)->result();
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
	public function update_user()
	{
		try
		{
			if($this->db->get_where("user",array("user_id"=>$this->input->post("user_id")))->num_rows()>0)
			{
				$data = array("user_password"=>$this->input->post("user_password"),"user_firstname"=>$this->input->post("user_firstname"),"user_lastname"=>$this->input->post("user_lastname"),"user_email"=>$this->input->post("user_email"),"user_type"=>$this->input->post("user_type"));
				$this->db->where('user_id', $this->input->post("user_id"));		
				$this->db->update('user', $data);
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
	public function add_new_user($data)
	{
		try
		{
			$result = $this->db->insert("user",$data);
			throw new Exception("New user has been added sucessfully...");			
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}		
	}
	public function delete_user($data)
	{
		try
		{
			if($this->db->get_where("user",$data)->num_rows()>0)
			{
				$this->db->delete("user",$data);
				throw new Exception("One user has been Deleted sucessfully...");
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
}
