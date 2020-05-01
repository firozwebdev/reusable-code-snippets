<?php 


class CRUD extends CI_Controller{

    public function create(){
		$data = [];
		$data['title']= 'Add Post';
		$data['categories']= $this->admin_model->select_all_category_info();
        $data['main_content'] = $this->load->view('admin/post/add_post',$data,true);
		$this->load->view('admin_layout',$data);
	}

	public function store(){
		
		$data = [];
		$data['post_name'] = $this->input->post('post_name',true);
		$data['post_category'] = $this->input->post('post_category',true);
		$data['post_description'] = $this->input->post('post_description',true);
		
		
		if($_FILES['post_image']['name']){

			$config['upload_path']= 'admin_assets/admin/images/';
			$config['allowed_types']= 'gif|jpg|png';
			$config['max_size']= '5000';
			$config['max_width']= '1024';
			$config['max_height']= '768';

			$this->upload->initialize($config);

			if($this->upload->do_upload('post_image')){
				$upload_item = $this->upload->data();
				$img_name= $upload_item['file_name'];
			}

			$data['post_image']= $config['upload_path'].$img_name;
		}

		$this->admin_model->save_post_info($data);

		$sdata=array();
       	$sdata['message']= "Post Information has been Saved Successfully";
        $this->session->set_userdata($sdata);

	   
	   
	    redirect('admincontroller/manage_post');
	}

	public function manage_post(){
		$data = [];
		$data['title'] = 'Manage Post';
		$data['posts'] = $this->admin_model->select_all_posts_info();
		$data['main_content'] = $this->load->view('admin/post/manage_post',$data,true);
		$this->load->view('admin_layout',$data);
	}

	public function edit($post_id){
		$data = [];
		$data['title'] = 'Edit Post';
		$data['categories']= $this->admin_model->select_all_category_info();
		$data['post'] = $this->admin_model->select_post_by_id_info($post_id);

		$data['main_content'] = $this->load->view('admin/post/edit_post',$data,true);
		$this->load->view('admin_layout',$data);
		
	}

	public function update(){
		$data = [];
		$data['post_id'] = $this->input->post('post_id',true);
		$data['post_name'] = $this->input->post('post_name',true);
		$data['post_category'] = $this->input->post('post_category',true);
		$data['post_description'] = $this->input->post('post_description',true);

		
		if($_FILES['post_image']['name']){
			$config['upload_path']= 'admin_assets/admin/images/';
			$config['allowed_types']= 'gif|jpg|png';
			$config['max_size']= '5000';
			$config['max_width']= '1024';
			$config['max_height']= '768';

			$this->upload->initialize($config);

			if($this->upload->do_upload('post_image')){
				$upload_item = $this->upload->data();
				

				$img_name= $upload_item['file_name'];
			}

			$data['post_image']= $config['upload_path'].$img_name;
			
			
		}
		$this->admin_model->update_post_info($data);

		$sdata=array();
		$sdata['message']= "Post Information has been Updated Successfully";
		$this->session->set_userdata($sdata);
		redirect('admincontroller/manage_post');
			
	}

	public function destroy($post_id){
		$this->admin_model->delete_post_by_id($post_id);
		
		
		$sdata= array();
        $sdata['message'] = 'Post Information has been deleted.';
		$this->session->set_userdata($sdata);
        redirect('admincontroller/manage_post');
	}
}