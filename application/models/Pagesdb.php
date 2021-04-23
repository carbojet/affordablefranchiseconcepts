
<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pagesdb extends CI_Model {
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
	public function __construct(){
		parent::__construct();
	}

	public function pages($startpage,$limit){
		try{
			if($this->db->select("*")->from("wp_posts")->where(array("post_type"=>"page"))->get()->num_rows()>0){
				$rec = ceil($this->db->select("*")->from("wp_posts")->where(array("post_type"=>"page"))->get()->num_rows()/$limit);				
				$lTo = $limit;				
				//if($startpage<1){$startpage=1;}
				if($startpage>$rec){$startpage = $rec;}
				if($startpage>1){$lFrom = ($startpage-1)*$limit;}
				else{$lFrom = 0;}				
				$query = $this->db->select("*")->from("wp_posts")->where(array("post_type"=>"page"))->order_by('post_modified', 'desc')->limit($lTo,$lFrom);				
				$data["pages"] = $this->db->get()->result();
				$data["pagination"] = array("startpage"=>$startpage,"pages"=>$rec);
			}
			else{
				$data["pages"] = array();
				$data["pagination"] = array("startpage"=>0,"pages"=>0);
				throw new Exception("No record found...");
			}
		}
		catch(Exception $e)	{
			$data['msg']= $e->getMessage();
		}
		return $data;
	}
	
	
	public function select_page($data){
		try{

			if($this->db->get_where("wp_posts",$data)->num_rows()>0){
				$this->db->select("*")->from("wp_posts")->where($data);
				$result = $this->db->get()->result();
				$page = (array) $result[0];

				//getting page meta tag
				$result = $this->db->select("*")->from("wp_postmeta")->where(array("post_id"=>$page['ID']))->get()->result();
				foreach($result as $postmeta){
					$page[$postmeta->meta_key] = $postmeta->meta_value;
				}
				
				$result = (object) $page;
				return $result;
			}else{
				throw new Exception("No record found...");
			}
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function update_page($data)
	{
		try
		{	
			if($this->db->get_where("wp_posts",array("ID"=>$this->input->post("post_id")))->num_rows()>0){
				$this->db->where("ID",$this->input->post("post_id"))->update('wp_posts', $data['post']);
				if(count($data['post_meta'])>0){
					foreach($data['post_meta'] as $metakey=>$metavalue){
						if($this->db->get_where("wp_postmeta",array("post_id"=>$this->input->post("post_id"),"meta_key"=>$metakey))->num_rows()>0){
							$this->db->where(array("post_id"=>$this->input->post("post_id"),"meta_key"=>$metakey))->update('wp_postmeta', array("meta_value"=>$metavalue));
						}else{
							$this->db->insert("wp_postmeta",array(
								"post_id"=>$this->input->post("post_id"),
								"meta_key"=>$metakey,
								"meta_value"=>$metavalue
							));
						}
					}	
				}else{
					throw new Exception("One record has Updated...");
				}		
			}else{
				throw new Exception("No record found to Update...");
			}
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function create($data){
		try{
			$this->db->insert("wp_posts",array(
				"post_title"=>$data->post_title,
				"post_content"=>$data->post_content,
				"post_name"=>$data->post_name,
				"post_status"=>"publish",
				"post_date"=>date("Y-m-d H:i:s"),
				"post_date_gmt"=>date("Y-m-d H:i:s"),
				"post_modified"=>date("Y-m-d H:i:s"),
				"post_modified_gmt"=>date("Y-m-d H:i:s"),
				"comment_status"=>"closed",
				"ping_status"=>"closed",
				"post_type"=>"page",
				"post_author"=>"1",	
			));

			$data->post_id =  $this->db->insert_id();

			$this->db->insert("wp_postmeta",array(
				"post_id"=>$data->post_id,
				"meta_key"=>'page_keywords',
				"meta_value"=>$data->page_keywords
			));
			$this->db->insert("wp_postmeta",array(
				"post_id"=>$data->post_id,
				"meta_key"=>'page_meta_description',
				"meta_value"=>$data->page_meta_description
			));
			$data = array(
				'status'=>true,
				'msg'=>'Page Created',
				'post'=>$data	
			);
		}catch(Exception $e){
			$data = array(
				'status'=>false,
				'msg'=>$e->getMessage()
			);
		}
		return $data;
	}
	public function get_menus($id=0){
		
		if($id<=0){
			$result = $this->db->select("wpt.term_id,wpt.name,wptt.taxonomy,wptt.count,wptt.term_taxonomy_id,wptt.count")
			->from("wp_term_taxonomy wptt")
			->join("wp_terms wpt","wpt.term_id=wptt.term_id","left")

			/*
			->join("wp_term_relationships wptr","wptt.term_taxonomy_id=wptr.term_taxonomy_id","left")
			->join("wp_posts wpp","wpp.ID=wptr.object_id","left")
			*/
			->where(array("wptt.taxonomy"=>"nav_menu"))
			->get()->result();
			$data["menus"] = $result;
			$data["pagination"] = array("startpage"=>0,"menus"=>0);

			return $data;
		}else{
			$result = $this->db->select("wptt.term_taxonomy_id,wpt.name,wptt.description,wptt.count,wpt.term_id")
			->from("wp_terms wpt")
			->join("wp_term_taxonomy wptt",'wptt.term_id=wpt.term_id',"left")
			->where("wpt.term_id",$id)
			->get()->result();
			foreach($result as $menuObj){
				$data['menu'] = (array) $menuObj;
			}

			$result = $this->db->select(
				"wptr.object_id,wptr.term_taxonomy_id,
				wpp.menu_order,wpp.post_name,wpp.post_title,
				wppm.meta_value as _menu_item_object_id,
				wppm1.meta_value as _menu_item_menu_item_parent,
				wppm2.meta_value as _menu_item_object,
				wpp1.post_title as menu_title,
				wpp1.post_name as menu_name,
				wpp.ID as post_id
				")->from("wp_term_relationships wptr")
			->join("wp_posts wpp",'wpp.ID=wptr.object_id AND wpp.post_type="nav_menu_item"',"left")
			->join("wp_postmeta wppm",'wppm.post_id=wpp.ID AND wppm.meta_key="_menu_item_object_id"',"left")
			->join("wp_postmeta wppm1",'wppm1.post_id=wpp.ID AND wppm1.meta_key="_menu_item_menu_item_parent"',"left")
			->join("wp_postmeta wppm2",'wppm2.post_id=wpp.ID AND wppm2.meta_key="_menu_item_object"',"left")
			->join("wp_posts wpp1",'wpp1.ID=wppm.meta_value',"left")
			->where(array("wptr.term_taxonomy_id"=>$data['menu']["term_taxonomy_id"]))
			->order_by("wpp.menu_order","ASC")
			->get()->result();
			$menus = array();
			$count=0;
			foreach($result as $k=>$menu){
				if($menu->_menu_item_menu_item_parent<=0){
					$menus[$menu->object_id] = array(						
						"menu_name"=>$menu->menu_name,
						"menu_title"=>$menu->menu_title,
						"term_taxonomy_id"=>$menu->term_taxonomy_id,
						"menu_id"=> $menu->post_id,
					);
					$count++;
				}
			}

			$submenus = array();
			if($count<count($result)){
				foreach($result as $k=>$menu){
					if($menu->_menu_item_menu_item_parent>0){
						if(isset($menus[$menu->_menu_item_menu_item_parent])){
							$menus[$menu->_menu_item_menu_item_parent]["submenu"][] = array(						
								"menu_name"=>$menu->menu_name,
								"menu_title"=>$menu->menu_title,
								"term_taxonomy_id"=>$menu->term_taxonomy_id,
								"menu_id"=> $menu->post_id,
							);
							$count++;
						}
					}
				}
			}


			$data["menu"]["menus"] = $menus;
			
			return $data;
		}
	}
	public function get_all_pages(){
		return $this->db->get_where('wp_posts',array("post_type"=>"page","post_status"=>"publish"))->result();
	}
	public function add_new_menu_item($data){
		
		$this->db->insert('wp_posts',array(
			'post_type'=>'nav_menu_item',
			'post_status'=>'publish',
			'menu_order'=>$data['count'],
			'comment_status'=>'closed',
			'ping_status'=>'closed',
			'post_title'=>data['post_title'],
			"post_date"=>date("Y-m-d H:i:s"),
			"post_date_gmt"=>date("Y-m-d H:i:s"),
			"post_modified"=>date("Y-m-d H:i:s"),
			"post_modified_gmt"=>date("Y-m-d H:i:s"),
			'guid'=>$data['guid'],
			'post_author'=>1,
		));
		$post_id = $this->db->insert_id();
		
		$this->db->insert('wp_postmeta',array(
			'post_id' => $post_id,
			'meta_key'=>'_menu_item_menu_item_parent',
			'meta_value'=>$data['_menu_item_menu_item_parent']
		));
		$this->db->insert('wp_postmeta',array(
			'post_id' => $post_id,
			'meta_key'=>'_menu_item_object_id',
			'meta_value'=>$data['_menu_item_object_id']
		));
		$this->db->insert('wp_postmeta',array(
			'post_id' => $post_id,
			'meta_key'=>'_menu_item_object',
			'meta_value'=>'page'
		));
		$this->db->where("ID",$post_id)->update('wp_posts',array('post_name'=>$post_id));
		

		$result = $this->db->insert('wp_term_relationships',array(
			'object_id'=>$post_id,
			'term_taxonomy_id'=>$data['term_taxonomy_id'],
			'term_order'=>0
		));
		
		$this->db->where('term_taxonomy_id',$data['term_taxonomy_id'])->update('wp_term_taxonomy',array('count'=>$data['count']));
		
		return $post_id;
	}

	public function get_menu_item_details($id){

		$result = $this->db->select(
				"wptr.object_id,wptr.term_taxonomy_id,
				wpp.menu_order,wpp.post_name as menu_name,wpp.post_title as menu_title,
				wppm.meta_value as _menu_item_object_id,
				wppm1.meta_value as _menu_item_menu_item_parent,
				wppm2.meta_value as _menu_item_object,
				wpp1.post_title as post_title,
				wpp1.post_name as post_name,
				wpp.ID as menu_id
				")->from("wp_term_relationships wptr")
			->join("wp_posts wpp",'wpp.ID=wptr.object_id AND wpp.post_type="nav_menu_item"',"left")
			->join("wp_postmeta wppm",'wppm.post_id=wpp.ID AND wppm.meta_key="_menu_item_object_id"',"left")
			->join("wp_postmeta wppm1",'wppm1.post_id=wpp.ID AND wppm1.meta_key="_menu_item_menu_item_parent"',"left")
			->join("wp_postmeta wppm2",'wppm2.post_id=wpp.ID AND wppm2.meta_key="_menu_item_object"',"left")
			->join("wp_posts wpp1",'wpp1.ID=wppm.meta_value',"left")
			->where(array("wptr.object_id"=>$id))
			->get()->result();

		return $result;
	}
	public function update_menu_item($data){
		$result = $this->db->select('wpp.ID as menu_id,wppm.meta_value as _menu_item_menu_item_parent')->from('wp_posts wpp')
		->join('wp_postmeta wppm','wppm.post_id=wpp.ID AND wppm.meta_key="_menu_item_menu_item_parent" AND wppm.meta_value="'.$data['_menu_item_menu_item_parent'].'"','left')
		->where('wpp.ID',$data['menu_id'])->get()->result();
		$row =  $result[0];
		if($row->_menu_item_menu_item_parent==null){
			$result1 = $this->db->where(array('meta_key'=>'_menu_item_menu_item_parent',"meta_value"=>$data['menu_id']))->update('wp_postmeta',array(
				'meta_value'=>0,
			))->get()->result();
			$result2 = $this->db->where(array('ID'=>$data['menu_id']))->update('wp_posts',array('post_title'=>$data['post_title']));
			return array($result1,$result2);

		}else{
			$result = $this->db->where(array('ID'=>$data['menu_id']))->update('wp_posts',array('post_title'=>$data['post_title']));
			return $result;
		}
	}
	public function delete_menu_item($data){
		$result1 = $this->db->where('term_taxonomy_id',$data['term_taxonomy_id'])->update('wp_term_taxonomy',array("count"=>$data['count']));
		$result2 = $this->db->where('object_id',$data['object_id'])->delete('wp_term_relationships');
		$result3 = $this->db->where('ID',$data['object_id'])->delete('wp_posts');
		return array($result1,$result2,$result3);
	}

	public function get_media_list($startpage,$limit){

		if($this->db->get_where('wp_posts',array('post_type'=>'attachment','post_status'=>'inherit'))->num_rows()>0){
			$rec = ceil($this->db->get_where('wp_posts',array('post_type'=>'attachment','post_status'=>'inherit'))->num_rows()/$limit);				
			$lTo = $limit;				
			if($startpage>$rec){$startpage = $rec;}
			if($startpage>1){$lFrom = ($startpage-1)*$limit;}
			else{$lFrom = 0;}		
			$data["media"] = $this->db->select('wpp.ID,wpp.post_name,wpp.guid,wpp.post_title,wpp.post_date,wpp.post_mime_type,wppm1.meta_value as _wp_attached_file,wppm2.meta_value as _wp_attachment_metadata')->from('wp_posts wpp')
			->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_wp_attached_file"','left')
			->join('wp_postmeta wppm2','wppm2.post_id=wpp.ID AND wppm2.meta_key="_wp_attachment_metadata"','left')
			->limit($lTo,$lFrom)->order_by('wpp.post_date','DESC')->where(array('wpp.post_type'=>'attachment','wpp.post_status'=>'inherit'))->get()->result();				
			$data["pagination"] = array("currentpage"=>$startpage,"pages"=>$rec);
		}
		else{
			$data["media"] = array();
			$data["pagination"] = array("currentpage"=>0,"pages"=>0);
			//throw new Exception("No record found...");
		}
		return $data;
	}

	public function addmedia($data){
		try{
			$folderDir = date('Y/m');
			if (!file_exists('uploads/'.$folderDir)){
				mkdir("uploads/".$folderDir, 0777);
			}
			$data['media_image_name'] = str_replace(" ","-",$data['media_image_name']);
			$imageExt = explode(".",$data['file']['name']);
			$imageExt = $imageExt[1];
			$imagename = $data['media_image_name'].'.'.$imageExt;
			$imgurl = $folderDir.'/'.$imagename;
			$guid = base_url('uploads/'.$imgurl);

			//var_dump($data);
			
			$this->media_image_upload($data['media_image_name'],'media_image',$folderDir);
			$this->db->insert('wp_posts',array(
				"post_title"=>$data['media_image_name'],
				"post_name"=>$data['media_image_name'],
				"post_mime_type"=>$data['file']['type'],
				"guid"=> $guid,
				"post_status"=>"inherit",
				"post_date"=>date("Y-m-d H:i:s"),
				"post_date_gmt"=>date("Y-m-d H:i:s"),
				"post_modified"=>date("Y-m-d H:i:s"),
				"post_modified_gmt"=>date("Y-m-d H:i:s"),
				"comment_status"=>"closed",
				"ping_status"=>"closed",
				"post_type"=>"attachment",
				"post_author"=>"1",	
			));
			$post_id = $this->db->insert_id();
			
			$wp_attached_file = $imgurl;
			$this->db->insert("wp_postmeta",array(
				"post_id"=>$post_id,
				"meta_key"=>'_wp_attached_file',
				"meta_value"=>$wp_attached_file,
			));
			$imagesize = @getimagesize($data['file']['tmp_name']);
			$wp_attachment_metadata = serialize( array(
				"file"=> $imgurl,
				"width"=>$imagesize[0],
				"height"=>$imagesize[1],
				"sizes"=> array( 
					"thumbnail" => array(
						"fileimagesize" =>$data['file']['name'],
						"mime-type" => $data['file']['type']
					),
					"image_meta" => array(
						"aperture" => 0,
						"credit" => '',
						"camera" => '',
						"caption" => "",
						"created_timestamp" => 0,
						"copyright" => "",
						"focal_length" => 0,
						"iso" => 0,
						"shutter_speed" => 0,
						"title" => "",
						"orientation" =>0,
					),
				)
			));
			$this->db->insert("wp_postmeta",array(
				"post_id"=>$post_id,
				"meta_key"=>'_wp_attachment_metadata',
				"meta_value"=>$wp_attachment_metadata,
			));
			
			throw new Exception("image uploaded...");	
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function deletemedia($id){
		try{			
			$posts = $this->db->select('wpp.ID as post_id,wppm.meta_value as _wp_attached_file')->from('wp_posts wpp')
			->join('wp_postmeta wppm','wppm.post_id=wpp.ID AND wppm.meta_key="_wp_attached_file"','left')
			->where(array('wpp.ID'=>$id))
			->get()->result();
			foreach($posts as $post){
				@unlink("./".$post->_wp_attached_file);
			}

			$this->db->where(array('post_id'=>$id))->delete('wp_postmeta');
			$this->db->where(array('ID'=>$id))->delete('wp_posts');
			
			throw new Exception("image Deleted...");	
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	private function media_image_upload($file_name,$tag_name,$folderDir){
		
		$this->load->library('image_lib');
		$config['upload_path'] = "./uploads/".$folderDir;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']	= '12400'; //in km = 10mb
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($tag_name)){
			return $data["error"] = $this->upload->display_errors();		
		}else{
			$image_data = $this->upload->data();
			//for big
			//$new_image_path = explode("photo_big/",$image_data["file_path"])[0]."photo_medium/".$file_name.".jpg";
			$img_cfg['image_library'] = 'gd2';
			$img_cfg['source_image'] = $image_data["full_path"];
			$img_cfg['maintain_ratio'] = FALSE;
			$img_cfg['create_thumb'] = TRUE;
			$img_cfg['thumb_marker'] = "";
			$img_cfg['new_image'] = $image_data["full_path"];
			//$img_cfg['width'] = 600;			
			//$img_cfg['height'] = 500;
			$img_cfg['quality'] = "100%";
			$img_cfg['x_axis'] = '0';
			$img_cfg['y_axis'] = '0';			
			$this->image_lib->initialize($img_cfg);
			$this->image_lib->resize();		
		}		
	}
	public function get_image_by_id($id){
		$result = $this->db->select('wpp.ID,wpp.post_title,wpp.post_mime_type,wpp.post_date,wpp.guid,wppm.meta_value as _wp_attached_file')
		->from('wp_posts wpp')
		->join('wp_postmeta wppm','wppm.post_id=wpp.ID AND wppm.meta_key="_wp_attached_file"','left')
		->where(array('wpp.ID'=>$id))
		->get()->result();
		return $result[0];
	}	
	public function get_banners($startpage,$limit){

		if($this->db->get_where('wp_posts',array('post_type'=>'cycloneslider','post_status'=>'publish'))->num_rows()>0){
			$rec = ceil($this->db->get_where('wp_posts',array('post_type'=>'cycloneslider','post_status'=>'publish'))->num_rows()/$limit);				
			$lTo = $limit;				
			if($startpage>$rec){$startpage = $rec;}
			if($startpage>1){$lFrom = ($startpage-1)*$limit;}
			else{$lFrom = 0;}		
			$data["sliders"] = $this->db->select('
			wpp.ID,
			wppm1.meta_value as _edit_last,
			wppm2.meta_value as _edit_lock,
			wppm3.meta_value as _cycloneslider_metas,
			wppm4.meta_value as _cycloneslider_settings
			')
			->from('wp_posts wpp')
			->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_edit_last"','left')
			->join('wp_postmeta wppm2','wppm2.post_id=wpp.ID AND wppm2.meta_key="_edit_lock"','left')
			->join('wp_postmeta wppm3','wppm3.post_id=wpp.ID AND wppm3.meta_key="_cycloneslider_metas"','left')
			->join('wp_postmeta wppm4','wppm4.post_id=wpp.ID AND wppm4.meta_key="_cycloneslider_settings"','left')
			->limit($lTo,$lFrom)->order_by('wpp.post_date','DESC')
			->where(array('wpp.post_type'=>'cycloneslider','wpp.post_status'=>'publish'))->get()->result();				
			$data["pagination"] = array("currentpage"=>$startpage,"pages"=>$rec);
			$images = array();
			$banner = $data['sliders'][0];
				
			$banner->_cycloneslider_metas = unserialize($banner->_cycloneslider_metas);
			//var_dump($banner);
			
			foreach($banner->_cycloneslider_metas as $img){
				//var_dump($img);
				$image = (array) $this->get_image_by_id($img['id']);
				$image = (object)array_merge($image,$img);
				$images[] = $image;
			}				
			$data['banners'] = $images;
		}
		else{
			$data["sliders"] = array();
			$data['banners'] = array();
			$data["pagination"] = array("currentpage"=>0,"pages"=>0);
			//throw new Exception("No record found...");
		}
		return $data;
	}
	public function addbanner($data){
		$img = array(
			"id"=>$data['id'],
			"link"=>'',
			"title"=>$data['title'],
			"description"=>$data['description'],
			"link_target"=>"_self",
			"fx"=>"",
			"speed"=> "",
			"timeout"=> "",
			"type"=>"image"
		);
		$sliders = $this->db->select('
			wpp.ID,
			wppm1.meta_value as _cycloneslider_metas,
			')
			->from('wp_posts wpp')
			->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_cycloneslider_metas"','left')
			->order_by('wpp.post_date','DESC')
			->where(array('wpp.post_type'=>'cycloneslider','wpp.post_status'=>'publish'))->get()->result();
		$slider = $sliders[0];
		$post_id = $slider->ID;
		$banners = unserialize( $slider->_cycloneslider_metas );
		$banners[] = $img;
		$this->db->where(array("post_id"=>$post_id,"meta_key"=>"_cycloneslider_metas"))->update("wp_postmeta",array("meta_value"=>serialize($banners)));
	}
	public function deletebanner($id){
		$sliders = $this->db->select('
			wpp.ID,
			wppm1.meta_value as _cycloneslider_metas,
			')
			->from('wp_posts wpp')
			->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_cycloneslider_metas"','left')
			->limit($lTo,$lFrom)->order_by('wpp.post_date','DESC')
			->where(array('wpp.post_type'=>'cycloneslider','wpp.post_status'=>'publish'))->get()->result();
		$slider = $sliders[0];
		$post_id = $slider->ID;
		$banners = unserialize( $slider->_cycloneslider_metas );
		unset($banners[$id]);
		$banners = serialize( array_values($banners));
		$this->db->where(array('post_id'=>$post_id,'meta_key'=>'_cycloneslider_metas'))->upadate('wp_postmeta',array('meta_value'=>$banners));
	}

	public function testimonials(){

		$result = $this->db->select('
			wpp.ID,
			wpp.post_title,
			wpp.post_name,
			wpp.post_date,
			wpp.post_modified,
			wppm1.meta_value as _edit_lock,
			wppm2.meta_value as _edit_last,
			wppm3.meta_value as tss_name,
			wppm4.meta_value as tss_ocupation,
			wppm5.meta_value as tss_image,
			wppm6.meta_value as tss_testimonial,
			wppm7.meta_value as _wp_old_slug
			')->from('wp_posts wpp')
		->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_edit_lock"','left')
		->join('wp_postmeta wppm2','wppm2.post_id=wpp.ID AND wppm2.meta_key="_edit_last"','left')
		->join('wp_postmeta wppm3','wppm3.post_id=wpp.ID AND wppm3.meta_key="tss_name"','left')
		->join('wp_postmeta wppm4','wppm4.post_id=wpp.ID AND wppm4.meta_key="tss_ocupation"','left')
		->join('wp_postmeta wppm5','wppm5.post_id=wpp.ID AND wppm5.meta_key="tss_image"','left')
		->join('wp_postmeta wppm6','wppm6.post_id=wpp.ID AND wppm6.meta_key="tss_testimonial"','left')
		->join('wp_postmeta wppm7','wppm7.post_id=wpp.ID AND wppm7.meta_key="_wp_old_slug"','left')
		->where(array("wpp.post_type"=>"tss_data","post_status"=>"publish"))
		->order_by('wpp.post_modified','ASC')
		->get()->result();
		return $result;
	}
	public function addtestimonial($data){
		try{

			$this->db->insert('wp_posts',array(			
				"post_status"=>"publish",
				"post_date"=>date("Y-m-d H:i:s"),
				"post_date_gmt"=>date("Y-m-d H:i:s"),
				"post_modified"=>date("Y-m-d H:i:s"),
				"post_modified_gmt"=>date("Y-m-d H:i:s"),
				"comment_status"=>"closed",
				"ping_status"=>"closed",
				'post_type'=>'tss_data',
				"post_author"=>"1",	
			));
			$post_id = $this->db->insert_id();
			
			$this->db->insert('wp_postmeta',array(
				'post_id'=>$post_id,
				'meta_key'=>'tss_image',
				'meta_value'=>$data['tss_image'],
			));
			$this->db->insert('wp_postmeta',array(
				'post_id'=>$post_id,
				'meta_key'=>'tss_name',
				'meta_value'=>$data['tss_name'],
			));
			$this->db->insert('wp_postmeta',array(
				'post_id'=>$post_id,
				'meta_key'=>'tss_testimonial',
				'meta_value'=>$data['tss_testimonial'],
			));
			
			throw new Exception("New Testimonial created...");
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function get_testimonial($id){
		$result = $this->db->select('
			wpp.ID,
			wpp.post_title,
			wpp.post_name,
			wpp.post_date,
			wpp.post_modified,
			wppm1.meta_value as _edit_lock,
			wppm2.meta_value as _edit_last,
			wppm3.meta_value as tss_name,
			wppm4.meta_value as tss_ocupation,
			wppm5.meta_value as tss_image,
			wppm6.meta_value as tss_testimonial,
			wppm7.meta_value as _wp_old_slug
			')->from('wp_posts wpp')
		->join('wp_postmeta wppm1','wppm1.post_id=wpp.ID AND wppm1.meta_key="_edit_lock"','left')
		->join('wp_postmeta wppm2','wppm2.post_id=wpp.ID AND wppm2.meta_key="_edit_last"','left')
		->join('wp_postmeta wppm3','wppm3.post_id=wpp.ID AND wppm3.meta_key="tss_name"','left')
		->join('wp_postmeta wppm4','wppm4.post_id=wpp.ID AND wppm4.meta_key="tss_ocupation"','left')
		->join('wp_postmeta wppm5','wppm5.post_id=wpp.ID AND wppm5.meta_key="tss_image"','left')
		->join('wp_postmeta wppm6','wppm6.post_id=wpp.ID AND wppm6.meta_key="tss_testimonial"','left')
		->join('wp_postmeta wppm7','wppm7.post_id=wpp.ID AND wppm7.meta_key="_wp_old_slug"','left')
		->where(array("wpp.ID"=>$id))
		->get()->result();
		return $result[0];
	}
	public function updatetestimonial($data){
		$this->db->where(array('post_id'=>$data['post_id'],'meta_key'=>'tss_image'))->update('wp_postmeta',array(				
			'meta_value'=>$data['tss_image'],
		));
		$this->db->where(array('post_id'=>$data['post_id'],'meta_key'=>'tss_name'))->update('wp_postmeta',array(
			'meta_value'=>$data['tss_name'],
		));
		$this->db->where(array('post_id'=>$data['post_id'],'meta_key'=>'tss_testimonial'))->update('wp_postmeta',array(
			'meta_value'=>$data['tss_testimonial'],
		));
	}
	public function delete_testimonial($id){
		$this->db->where(array("ID"=>$id))->delete("wp_posts");
		$this->db->where(array("post_id"=>$id))->delete("wp_postmeta");
	}

















	public function feature($data){
		try{
			if($this->db->get_where("listing",array("listing_id"=>$data["listing_id"]))->num_rows()>0){
				$this->db->where('listing_id', $data["listing_id"]);
				$this->db->update('listing', array("listing_status_feature"=>$data["listing_status_feature"],"listing_lastupdate"=>date("Y-m-d H:i:s")));
				throw new Exception("Listing feature list updated...");
			}else{
				throw new Exception("Listing feature record not found...");
			}
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	
	
	public function status_new($data){
		try{
			if($this->db->get_where("listing",array("listing_id"=>$data["listing_id"]))->num_rows()>0){
				$this->db->where('listing_id', $data["listing_id"]);
				$this->db->update('listing', array("listing_status_new"=>$data["listing_status_new"],"listing_lastupdate"=>date("Y-m-d H:i:s")));
				throw new Exception("Listing new list updated...");
			}else{
				throw new Exception("Listing new record not found...");
			}
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function auto_approve($data)

	{

		try

		{

			if($this->db->get_where("listing",array("_id"=>$data["listing_id"]))->num_rows()>0)

			{

				$this->db->where('listing_id', $data["listing_id"]);		

				$this->db->update('listing', array("listing_status_approval"=>$data["listing_status_approval"]));

				throw new Exception("Listing Approve list updated...");

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
	
	public function delete_all_listing(){		

		try

		{
			$this->db->truncate('seller');
			$this->db->truncate('listing_category');
			$this->db->truncate('listing');
			throw new Exception("Successfully Deleted!");
		}

		catch(Exception $e)
		{

			return $e->getMessage();

		}
	
	}

	public function delete_listing($data)

	{

		try

		{

			if($this->db->get_where("listing",$data)->num_rows()>0)

			{

				$this->db->delete("listing",$data);

				//@unlink("./logo_cache/".$data["seller_id"].".jpg");

				$this->db->delete("listing_category",array("category_listing"=>$data["listing_id"]));				
							
				$this->db->delete("seller",array("seller_id"=>$data["listing_id"]));	
				
				throw new Exception("One Listing has been Deleted sucessfully...");

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

	//add category into listing

	public function add_listing_category()

	{

		try

		{
			$data = array("category_listing"=>$this->input->post("category_listing"),"category_value"=>$this->input->post("listing_category_1"),"category_path"=>"-".$this->input->post("listing_category_1")."-","category_status"=>"approved");			
				
			
			$this->db->insert("listing_category",$data);

			$detail = $this->db->get_where("listing_category",array("category_listing"=>$this->input->post("category_listing")))->result();

			$listing_category_path = "-";

			foreach($detail as $k=>$obj)

			{

				$listing_category_path .= $obj->category_value."-, ";

			}

			$this->db->where("listing_id",$this->input->post("category_listing"))->update("listing",array("listing_category_path"=>$listing_category_path));

			throw new Exception("New category added into listing # ".$this->input->post("category_listing"));

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}	

	}
	
	// Select Sector
	public function	sector_list()
	{
		return $this->db->order_by('category_name_1','ASC')->get_where('setup_category_listing', array('category_parent' => 0))->result();		
	}
	
	//Select Sector through Category Id
	public function category_sector($data){
		return $this->db->get_where('setup_category_listing',array('category_id' => $data))->result();
	}
	

	//delete gategory from listing

	public function delete_listing_category($category_id=0,$listing_id=0)

	{

		try

		{

			$detail = $this->db->select("setup_category_listing.category_id")->from("listing_category")->where(array("listing_category.category_id"=>$category_id))->join("setup_category_listing","listing_category.category_value=setup_category_listing.category_id")->get()->result();

			if(count($detail)>0)

			{

				foreach($detail as $k=>$obj){$setup_category_id=$obj->category_id;}

				$listing_detail = $this->db->get_where("listing",array("listing_id"=>$listing_id))->result();

				foreach($listing_detail as $k=>$obj)

				{

					$listing_category_path = str_replace("-".$setup_category_id."-, "," ",$obj->listing_category_path);

					$this->db->where("listing_id",$listing_id);

					$this->db->update("listing",array("listing_category_path"=>$listing_category_path));

				}

				$this->db->delete("listing_category",array("category_id"=>$category_id));	

				throw new Exception("One Category has been removed from selected listing sucessfully...");			

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

	//get category listing

	public function get_category_list($id,$level=0)

	{		
		return $this->db->get_where("setup_category_listing",array("category_parent"=>$id))->result();

	}
	
	//get SELECT CITY

	public function get_select_city($id)

	{	
		//return $this->db->where(array("location_parent"=>$id))->order_by("location_name","desc")->get("setup_location")->result();
		return $this->db->query("SELECT * FROM setup_location WHERE location_parent = '$id' ORDER BY location_name ASC")->result();
	}

	//get listing category

	public function get_listing_category($data)
	{

		return $this->db->select("listing_category.category_id,listing_category.category_value,setup_category_listing.category_name_1")->from("listing_category")->where($data)->join("setup_category_listing","listing_category.category_value=setup_category_listing.category_id")->get()->result();
	}
	
	
	// GET SECTOR BASED ON CATEGORY
	public function get_sector_detail($data){
		$result =  $this->db->get_where("setup_category_listing",$data)->result();
		foreach($result as $obj){
			return $obj;
		}
	}

	

	//get listing photo list

	public function listing_photos($data)

	{

		return $this->db->get_where("listing_photo",$data)->result();

	}

	//set photo as main in listing

	public function set_listing_main_photo($photo_id=0,$listing_id=0)

	{

		try

		{

			$this->db->where("photo_listing",$listing_id)->update("listing_photo",array("photo_status_main"=>""));

			$this->db->where("photo_id",$photo_id)->update("listing_photo",array("photo_status_main"=>"main"));

			

			throw new Exception("Photo # ".$photo_id." been set as main photo...");	

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}		

	}

	

	// get listing photo detail to edit

	public function edit_listing_photo($photo_id=0)

	{

		$detail = $this->db->get_where("listing_photo",array("photo_id"=>$photo_id))->result();

		foreach($detail as $obj){return $obj;}

	}

	public function update_listing_photo()

	{

		try

		{

			$this->db->where("photo_id",$this->input->post("photo_id"))->update("listing_photo",array("photo_caption_1"=>$this->input->post("photo_caption_1")));

			throw new Exception("Photo # ".$this->input->post("photo_id")." been updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function add_listing_photo()

	{

		try

		{

			$loop = $this->input->post("upload_loop");

			$photo_listing = $this->input->post("photo_listing");

			$temparray = array();

			for($i=$loop;$i<=$this->input->post("upload_limit");$i++)

			{

				if(!empty($_FILES['photo_file_1']["name"]))

				{

					$data = array("photo_listing"=>$photo_listing,"photo_caption_1"=>$this->input->post("photo_caption_1"),"photo_status"=>"approved","photo_lastupdate"=>date("Y-m-d H:i:s"));

					$this->db->insert("listing_photo",$data);

					$temparray[] = $this->db->insert_id();

					$this->new_listing_photo_upload($this->db->insert_id(),"photo_file_1");

				}

			}

			$content="";

			foreach($temparray as $k=>$id){

				$content .=" # $id ";

			}			

			throw new Exception("Photo $content been updated...");

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	}

	public function delete_listing_photo($photo_id=0)

	{

		try

		{

			if($this->db->get_where("listing_photo",array("photo_id"=>$photo_id))->num_rows()>0)

			{

				$this->db->delete("listing_photo",array("photo_id"=>$photo_id));

				

				@unlink("./photo_big/".$photo_id.".jpg");

				@unlink("./photo_medium/".$photo_id.".jpg");

				@unlink("./photo_small/".$photo_id.".jpg");

				

				throw new Exception("Photo # ".$photo_id." been deleted...");

				

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

	//uploading videos

	private function listing_video_upload($file_name,$tag_name)

	{

		$this->load->library('image_lib');

		$config['upload_path'] = "./video/";

		$config['allowed_types'] = 'mov|swf|wmv';

		$config['max_size']	= '512000';

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			$data["error"] = $this->upload->display_errors();			

		}

		else

		{

			$data["image_data"] = $this->upload->data();

		}

		return $data;		

	}

	//uploading video cover photo

	private function listing_video_photo_upload($file_name,$tag_name)

	{

		$this->load->library('image_lib');

		$config['upload_path'] = "./video_big/";

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '5120';

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			$data["error"] = $this->upload->display_errors();		

		}

		else

		{

			$data["image_data"] = $this->upload->data();

			//for big

			@unlink("./video_big/".$data["video_id"].".jpg");

			@unlink("./video_small/".$data["video_id"].".jpg");

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $data["image_data"]["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $data["image_data"]["full_path"];

			$img_cfg['width'] = 480;

			$img_cfg['height'] = 315;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			

			//for small

			$temp_var = explode("video_big/",$data["image_data"]["file_path"]);

			$new_image_path = $temp_var[0]."video_small/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $data["image_data"]["full_path"];

			$img_cfg['maintain_ratio'] = TRUE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 80;

			$img_cfg['height'] = 80;			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

		}

		return $data;		

	}

	//uploading images for listing

	private function new_listing_photo_upload($file_name,$tag_name)

	{
		
		$this->load->library('image_lib');

		$config['upload_path'] = "./photo_big/";

		$config['allowed_types'] = 'jpg|jpeg';

		$config['max_size']	= '12400'; //in km = 10mb

		$config['file_name'] = $file_name;

		

		$this->load->library('upload', $config);



		if (!$this->upload->do_upload($tag_name))

		{

			return $data["error"] = $this->upload->display_errors();		

		}

		else

		{

			$image_data = $this->upload->data();

			//for big

			//$new_image_path = explode("photo_big/",$image_data["file_path"])[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $image_data["full_path"];

			$img_cfg['width'] = 600;			

			$img_cfg['height'] = 500;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			//for medium

			$temp_var = explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_medium/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 280;

			$img_cfg['height'] = 250;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

			//for small

			$temp_var = explode("photo_big/",$image_data["file_path"]);

			$new_image_path = $temp_var[0]."photo_small/".$file_name.".jpg";

			$img_cfg['image_library'] = 'gd2';

			$img_cfg['source_image'] = $image_data["full_path"];

			$img_cfg['maintain_ratio'] = FALSE;

			$img_cfg['create_thumb'] = TRUE;

			$img_cfg['thumb_marker'] = "";

			$img_cfg['new_image'] = $new_image_path;

			$img_cfg['width'] = 80;

			$img_cfg['height'] = 80;

			$img_cfg['quality'] = "100%";

			$img_cfg['x_axis'] = '0';

			$img_cfg['y_axis'] = '0';			

			$this->image_lib->initialize($img_cfg);

			$this->image_lib->resize();

		}		

	}

	//get listing video list

	public function get_listing_video($data)

	{

		return $this->db->select("*")->from("listing_video")->where($data)->get()->result();

	}

	//get listing video list

	public function edit_listing_videos($data)

	{

		$detail = $this->db->select("*")->from("listing_video")->where($data)->get()->result();

		foreach($detail as $k=>$obj)

		{

			return $obj;

		}

	}

	//add listing video from external

	public function add_listing_video_youtube()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_youtube"=>$this->input->post("video_youtube"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				

				$this->db->insert("listing_video",$data_array);

				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video from external

	public function add_listing_video_external()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_url"=>$this->input->post("video_url"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);				

				$this->db->insert("listing_video",$data_array);				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video upload

	public function add_listing_video_upload()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;		

			if(!empty($_FILES["video_file"]["name"]) &&!empty($_FILES["video_photo"]["name"]))

			{				

				$allowed_v_types = array('mov','swf','wmv');

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				$xv = explode('.', $_FILES["video_file"]["name"]);

				$xv = $xv[1];

				if(!in_array($xv, $allowed_v_types))

				{

					throw new Exception("Upload Video File (.MOV, .SWF or .WMV files)...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif($_FILES["video_file"]["size"]>(512000*1024*1024))

				{

					throw new Exception("Upload Video File Size must not exceed 100MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}				

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video and cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_file"=>$_FILES["video_file"]["name"],

					"video_ext"=>$xv,

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->insert("listing_video",$data_array);

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				$data["upload_video_data"] = $this->listing_video_upload($this->db->insert_id(),"video_file");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	

	//add listing video from external

	public function update_listing_video_youtube()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_youtube"=>$this->input->post("video_youtube"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->where("video_id",$this->input->post("video_id"));

				$this->db->update("listing_video",$data_array);

				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->input->post("video_id"),"video_photo");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video from external

	public function update_listing_video_external()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;

			if(!empty($_FILES["video_photo"]["name"]))

			{

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				if(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_url"=>$this->input->post("video_url"),

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->where("video_id",$this->input->post("video_id"));				

				$this->db->update("listing_video",$data_array);				

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->input->post("video_id"),"video_photo");				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	//add listing video upload

	public function update_listing_video_upload()

	{

		try

		{

			$data["upload_status"] = true;	

			$data["status"] = true;		

			if(!empty($_FILES["video_file"]["name"]) &&!empty($_FILES["video_photo"]["name"]))

			{				

				$allowed_v_types = array('mov','swf','wmv');

				$allowed_p_types = array("jpg","jpeg");

				$xp = explode('.', $_FILES["video_photo"]["name"]);

				$xp = $xp[1];

				$xv = explode('.', $_FILES["video_file"]["name"]);

				$xv = $xv[1];

				if(!in_array($xv, $allowed_v_types))

				{

					throw new Exception("Upload Video File (.MOV, .SWF or .WMV files)...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif($_FILES["video_file"]["size"]>(512000*1024*1024))

				{

					throw new Exception("Upload Video File Size must not exceed 100MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}

				elseif(!in_array($xp, $allowed_p_types))

				{

					throw new Exception("Upload Video cover Photo (.jpg only");

					$data["upload_status"] = false;

					$data["status"] = false;

				}

				elseif($_FILES["video_photo"]["size"]>(5120*1024*1024))

				{

					throw new Exception("Upload Video cover photo 5MB...");

					$data["upload_status"] = false	;

					$data["status"] = false;

				}				

			}

			else

			{

				$data["upload_status"] = false;

				throw new Exception("Please upload a video and cover photo...");

				$data["status"] = false;

			}

			if($data["upload_status"])

			{

				$data_array = array(

					"video_listing"=>$this->input->post("video_listing"),

					"video_title_1"=>$this->input->post("video_title_1"),

					"video_type"=>$this->input->post("video_type"),

					"video_file"=>$_FILES["video_file"]["name"],

					"video_ext"=>$xv,

					"video_description_1"=>$this->input->post("video_description_1"),

					"video_status"=>"approved",

				);

				$this->db->insert("listing_video",$data_array);

				$data["upload_photo_data"] = $this->listing_video_photo_upload($this->db->insert_id(),"video_photo");

				$data["upload_video_data"] = $this->listing_video_upload($this->db->insert_id(),"video_file");

				

				throw new Exception("One Video Has beeen uploaded...");

				$data["status"] = true;

			}

		}

		catch(Exception $e)

		{

			$data["success_msg"] = $e->getMessage();

		}

		return $data;

	}

	

	

	//delete listnig videos

	public function delete_listing_video($data)

	{

		try

		{

			if($this->db->get_where("listing_video",array("video_id"=>$data["video_id"]))->num_rows()>0)

			{

				$this->db->delete("listing_video",array("video_id"=>$data["video_id"]));

				@unlink("./video_big/".$data["video_id"].".jpg");

				@unlink("./video_small/".$data["video_id"].".jpg");

				@unlink("./video/".$data["video_id"].".wmv");

				

				throw new Exception("Listing Video #".$data["video_id"]." Been Deleted successfully...");

			}

			else

			{

				throw new Exception("Record Not Found...");

			}

		}

		catch(Exception $e)

		{

			return $e->getMessage();

		}

	} 

	// get default country listing

	public function get_country_list()

	{

		$this->db->select("*")->from("default_setup_country")->where(array("country_status"=>1))->order_by('country_order', 'asc');

		return $this->db->get()->result();

	}

	//get package detail

	public function get_package_detail($listing_package=0)

	{

		$detail = $this->db->get_where("setup_package_listing",array("package_listing_id"=>$listing_package))->result();

		foreach($detail as $k=>$obj){return $obj;}

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

	public function get_opendays()

	{

		return $this->db->select("day_id,day_name_1")->from("setup_dayname")->get()->result();

	}

	public function get_setup_filed_listing()

	{

		return $this->db->get("setup_field_listing")->result();

	}

	public function update_all_setup_field_listing()

	{

		$field_listing_id_list = $this->input->post("field_listing_id");

		$status_list = $this->input->post("field_listing_val");

		foreach($field_listing_id_list as $k=>$field_listing_id)

		{						

			$field_listing_enable = $status_list[$k];

			$this->db->where("field_listing_id",$field_listing_id);

			$this->db->update("setup_field_listing",array("field_listing_enable"=>$field_listing_enable));			

		}

		return "All Field Listing Been Updated...";

	}

	public function update_setup_field_listing()

	{					

		$this->db->where("field_listing_id",$this->input->post("field_listing_id"));

		$this->db->update("setup_field_listing",array("field_listing_name_1"=>$this->input->post("field_listing_name_1")));			

		return "One record Been Updated...";

	}

	public function setup_field_listing_edit($field_listing_id)

	{

		$result = $this->db->get_where("setup_field_listing",array("field_listing_id"=>$field_listing_id))->result();		

		foreach($result as $obj){return $obj;}

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