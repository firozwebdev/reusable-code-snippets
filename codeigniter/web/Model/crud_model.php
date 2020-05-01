<?php

class Crud_Model extends CI_Model{

    

   public function save_post_info($data){

     $this->db->insert('tbl_post',$data);

   }

   public function select_all_posts_info(){

    $this->db->select('*')
            ->from('tbl_post')
            ->order_by('post_id','desc');

        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
        
   }

   public function select_post_by_id_info($post_id){

        $this->db->select('*')
            ->from('tbl_post')
            ->where('post_id',$post_id);

        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
   }

   public function update_post_info($data){

        $this->db->where('post_id', $data['post_id'])
        ->update('tbl_post',$data);

   }

   public function delete_post_by_id($post_id){
        
        $this->db->where('post_id',$post_id)
        ->delete('tbl_post');

    }
}