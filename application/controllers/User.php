<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class User extends CI_Controller {



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

	  $this->load->model("Userdb");

	}

		

	//default load user page		

	public function index()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		$this->data["user_list"]=$this->Userdb->user_list();

		$this->load->view("user",$this->data);

	}

		

	//user edit sec

	public function user_edit($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if($id>0)

		{

			$result = $this->Userdb->select_user(array("user_id"=>$id));

			foreach($result as $k=>$obj){$this->data["userObj"] = $obj;}

			$this->load->view("user_edit",$this->data);

		}

		else

		{

			redirect("/user/","refresh");

		}

	}

	//user update sec	

	public function update()

	{	

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

			

		$this->load->library('form_validation');

		$this->form_validation->set_rules("user_username","User Name","trim|required");

		$this->form_validation->set_rules("user_password","Password","trim|required");

		$this->form_validation->set_rules("user_firstname","First Name","trim|required");

		$this->form_validation->set_rules("user_lastname","Last Name","trim|required");

		$this->form_validation->set_rules("user_email","Email","trim|required|valid_email");

		

		if($this->form_validation->run()!=false)

		{

			//validation sucess

			$result = $this->Userdb->update_user();

			$this->data["success_msg"] = $result;			

			$this->index();

		}

		else

		{	

			//validation error

			$this->data["validation_errors"] = validation_errors();							 

			$userObj = (object) array("user_id"=>$this->input->post("user_id"),"user_username"=>$this->input->post("user_username"),"user_password"=>$this->input->post("user_password"),"user_firstname"=>$this->input->post("user_firstname"),"user_lastname"=>$this->input->post("user_lastname"),"user_email"=>$this->input->post("user_email"),"user_type"=>$this->input->post("user_type"));			

			$this->data["userObj"] = $userObj;

			$this->load->view("user_edit",$this->data);				

		}		

	}

	//user edit add new

	public function new_user()

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		

		if($this->input->post("user_username"))

		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules("user_username","User Name","trim|required|is_unique[user.user_username]");

			$this->form_validation->set_rules("user_password","Password","trim|required");

			$this->form_validation->set_rules("user_firstname","First Name","trim|required");

			$this->form_validation->set_rules("user_lastname","Last Name","trim|required");

			$this->form_validation->set_rules("user_email","Email","trim|required|valid_email");


			if($this->form_validation->run()!=false)

			{

				//form validation true

				$this->data = array("user_username"=>$this->input->post("user_username"),"user_password"=>$this->input->post("user_password"),"user_firstname"=>$this->input->post("user_firstname"),"user_lastname"=>$this->input->post("user_lastname"),"user_email"=>$this->input->post("user_email"),"user_type"=>$this->input->post("user_type"));

				

				$result = $this->Userdb->add_new_user($this->data);

				$this->data["success_msg"] = $result;

				$this->index();

			}

			else

			{

				//form validation false

				$this->data["validation_errors"] = validation_errors();

								 

				$userObj = (object) array("user_username"=>$this->input->post("user_username"),"user_password"=>$this->input->post("user_password"),"user_firstname"=>$this->input->post("user_firstname"),"user_lastname"=>$this->input->post("user_lastname"),"user_email"=>$this->input->post("user_email"),"user_type"=>$this->input->post("user_type"));

				

				$this->data["userObj"] = $userObj;

				

				$this->load->view("new_user",$this->data);

			}

		}

		else

		{

			$this->data["userObj"] = (object) array("user_username"=>$this->input->post("user_username"),"user_password"=>$this->input->post("user_password"),"user_firstname"=>$this->input->post("user_firstname"),"user_lastname"=>$this->input->post("user_lastname"),"user_email"=>$this->input->post("user_email"),"user_type"=>$this->input->post("user_type"));

			$this->load->view("new_user",$this->data);

		}

		

	}

	//user delete sec

	public function delete_user($id=0)

	{

		//check weather user logged in or not

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		$result = $this->Userdb->delete_user(array("user_id"=>$id));	

		$this->data["success_msg"] = $result;

		$this->index();

	}

}

