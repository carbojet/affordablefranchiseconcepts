<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

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
      $this->load->model("Pagesdb");
	}		
	public function index(){

        if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->pages($page,20);
		$this->data["pages"]= $data["pages"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];

        $this->load->view('pages',$this->data);
	}
	
	
	public function create($id=0){
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->load->library('form_validation');
		$this->form_validation->set_rules("post_title","Enter Your page title","trim|required");
		$this->form_validation->set_rules("post_name","seo url","trim|required");
		$this->form_validation->set_rules("page_keywords","Keywords","trim|required");
		$this->form_validation->set_rules("page_meta_description","Meta Description","trim|required");
		$this->data['pageObj'] = (object) [
			'post_title'=>$this->input->post("post_title"),
			'post_name'=>str_replace(' ','-',$this->input->post("post_name")),
			'page_keywords'=>$this->input->post("page_keywords"),
			'page_meta_description'=>$this->input->post("page_meta_description"),
			'post_content'=>$this->input->post("post_content"),
		];

		if($this->form_validation->run()!=false){
			//form validation true
			$data = $this->Pagesdb->create($this->data['pageObj']);
			$this->edit($data->post->post_id);

		}else{
			//form validation false	
			$this->data["validation_errors"] = validation_errors();
			$this->load->view("new_page",$this->data);
		}
	}

	public function addnew(){
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data['pageObj'] = (object) [
			'post_title'=>'',
			'post_name'=>'',
			'page_keywords'=>'',
			'page_meta_description'=>'',
			'post_content'=>'',
		];
		$this->load->view("new_page",$this->data);
	}


	public function edit($id=0,$page=0)
	{
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if($id>0){

			$result = $this->Pagesdb->select_page(array("ID"=>$id,'post_type'=>'page'));			
			$this->data["pageObj"] = $result;

			$this->data["page"] = $page;
			$this->load->view("page_edit",$this->data);
		}else{
			redirect("/pages/","refresh");
		}
	}
	public function next_page($id=1){
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data['page'] = $id;
		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->pages($page,20);
		$this->data["pages"]= $data["pages"];
		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}
		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];
        $this->load->view('pages',$this->data);
	}

	public function update(){
		//check weather user logged in or not
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		if($this->input->post("post_id")){

			$this->load->library('form_validation');
			$this->form_validation->set_rules("post_title","Enter Page Title","trim|required");
			if($this->form_validation->run()!=false){							
				$this->data = array(
					"post" => array(
						"post_title"=>$this->input->post("post_title"),
						"post_content"=>$this->input->post("post_content"),
						"post_name"=>$this->input->post("post_name"),
						//"post_status"=>"publish",
						"post_modified"=>date("Y-m-d H:i:s"),
						"post_modified_gmt"=>date("Y-m-d H:i:s"),
						//"ping_status"=>"close",
						//"post_type"=>"page",
						//"post_author"=>"1",						
					),
					"post_meta"=>array(
						"page_keywords"=>$this->input->post("page_keywords"),
						"page_meta_description"=>$this->input->post("page_meta_description"),
					)					
				);				
				$result = $this->Pagesdb->update_page($this->data);
				$this->data["success_msg"] = $result;
				$this->edit($this->input->post("post_id"),1);
			}else{	
				echo $this->data["validation_errors"] = validation_errors();							 
			}
		}
		else{
			$this->index();
		}		
	}
	public function menus(){

		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->get_menus();
		$this->data["menus"]= $data["menus"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->menus = $this->data["pagination"]["menus"];
		$this->load->view('menus',$this->data);		
	}
	public function menuedit($id=0,$page=0){

		$this->data["menu"] = (object) array(
			"term_taxonomy_id"=>0,
			"name"=>'',
			"term_id"=>0,
			"taxonomy"=>"",
			"count"=>0
		);
		$result = $this->Pagesdb->get_menus($id);
		$this->data['pages'] = $this->Pagesdb->get_all_pages();
		foreach($result as $menu){
			$this->data["menu"] = $menu;
		}		
		$this->load->view('menu_edit',$this->data);
	}
	public function ajax_get_page($id=0){
		$result = $this->Pagesdb->select_page(array("ID"=>$id,'post_type'=>'page'));
		$this->data['page'] = $result;
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));

	}
	public function ajax_save_menu_item(){
		
		$post_title ='';
		if($this->input->post('page_title')!=$this->input->post('menu_title')){
			$post_title = $this->input->post('menu_title');
		}

		if($this->input->post('page_id')){
			$count = $this->input->post('count') + 1;
			$data = array(
				'_menu_item_object_id'=>$this->input->post('page_id'),
				'post_title'=>$post_title,
				'guid'=> base_url().'?page_id='.$this->input->post('page_id'),
				'count'=> $count,
				'_menu_item_menu_item_parent'=>$this->input->post('post_parent'),
				'term_taxonomy_id'=>$this->input->post('term_taxonomy_id'),
			);			
			$result = $this->Pagesdb->add_new_menu_item($data);
			$this->data['result'] = $result;
		}else{
			$data = array(
				'menu_id' => $this->input->post('menu_id'),
				'post_title'=>$post_title,
				'_menu_item_menu_item_parent'=>$this->input->post('post_parent'),
			);
			$this->data['result'] = $this->Pagesdb->update_menu_item($data);	
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function ajax_edit_menu_item($id){
		$this->data['result'] = $this->Pagesdb->get_menu_item_details($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}
	public function ajax_remove_menu_item(){
		$data = array(
			'object_id' => $this->input->post('object_id'),
			'term_taxonomy_id'=> $this->input->post('term_taxonomy_id'),
			'count'=> $this->input->post('count') - 1,
		);
		$result = $this->Pagesdb->delete_menu_item($data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
	public function media(){
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}

		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->get_media_list($page,20);
		$this->data["media"]= $data["media"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];

		$this->load->view('media',$this->data);
	}
	public function media_next($id){
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data['page'] = $id;
		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->get_media_list($page,20);
		$this->data["media"]= $data["media"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];

		$this->load->view('media',$this->data);
	}
	public function media_prev($id){
		if(!array_key_exists("ud",$this->session->userdata())){redirect("login");}
		$this->data['page'] = $id;
		if(isset($this->data["page"])){$page = $this->data["page"];}
		else{$page=1;}
		$data = $this->Pagesdb->get_media_list($page,20);
		$this->data["media"]= $data["media"];

		if(isset($page)){$data["pagination"]["currentpage"]=$page;}
		else{$data["pagination"]["currentpage"]=1;}

		$this->data["pagination"] = $data["pagination"];
		$this->pages = $this->data["pagination"]["pages"];
		
		$this->load->view('media',$this->data);
	}
	public function createmedia(){
		$this->data['listingObj'] = '';
		$this->load->view('new_media',$this->data);
	}
	public function addmedia(){
		$data['file'] = $_FILES['media_image'];
		//var_dump($data['file']);
		$data['media_image_name'] = $this->input->post('media_image_name');
		$result = $this->Pagesdb->addmedia($data);
		//var_dump($result);
		$this->data["success_msg"] = $result;
		$this->media();
	}
	public function deletemedia($id){
		$this->Pagesdb->deletemedia($id);
		$this->data["success_msg"] = $result;
		$this->media();
	}
}
