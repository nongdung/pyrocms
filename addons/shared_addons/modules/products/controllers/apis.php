<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Apis extends REST_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("homepage_m");
        $this->load->model("products_m");
        $this->load->library('session');
    }
    function ajaxlistsearch_post(){
        $limit = $this->post('limit');
        $offset = $this->post('offset');
        $cat_id = $this->post('cat_id');
        $f_id = $this->post('f_id');
        $data = $this->homepage_m->ajaxlistsearch($limit,$offset,$cat_id,$f_id);
        $this->response($data);
    }
    function ajaxlist_post(){
        $limit = $this->post('limit');
        $offset = $this->post('offset');
        $cat_id = $this->post('cat_id');
        $f_id = $this->post('f_id');
        $data = $this->homepage_m->ajaxlist($limit,$offset,$cat_id,$f_id);
        $this->response($data);
    }
    function ajaxcategories_post(){
        $data = $this->homepage_m->ajaxcategories();
        $this->response($data);
    }
    function ajaxcomment_post(){
        //$this->response("asdfads");
        if($this->post('asd'))
        {
            $data = array (
                'comments'     => $this->post('comment'),
                'product_id_c' => $this->post('pro_id'),
                'user_id_c'    => '1',
                'created'      => date('Y-m-d H:i:s')
            ); 
            $this->products_m->insert_comments($data);
        }
        $limit = $this->post('limit');
        $offset = $this->post('offset');
        $pro_id = $this->post('pro_id');
        //$data = ["adsfad"];
        $data = $this->homepage_m->ajaxcomments($limit, $offset, $pro_id);
        $this->response($data);
        
    }
    
    function ajaxreply_post(){
        if($this->post('asd'))
        {
            $data = array (
                'comments'     => $this->post('comment'),
                'product_id_c' => $this->post('pro_id'),
                'user_id_c'    => '1',
                'created'      => date('Y-m-d H:i:s'),
                'reply_id'     => $this->post('com_id')
            ); 
            $this->products_m->insert_comments($data);
        }
        $pro_id = $this->post('pro_id');
        $com_id = $this->post('com_id');
        $limit = $this->post('limit');
        $offset = $this->post('offset');
        $data = $this->homepage_m->ajaxreply($pro_id,$com_id,$limit,$offset);
        $this->response($data);
    }
    
    function ajaxlike_post(){
        if($this->post('addlike')){
            $product_id=$this->post('pro_id');
            $u_id =$this->post('user_id');
            $this->homepage_m->addlikedyna($product_id, $u_id);
        }
        if($this->post('removelike')){
            
            $product_id=$this->post('pro_id');
            $u_id =$this->post('user_id');
            $this->homepage_m->deletelike($product_id,$u_id);
        }
        
        $user_id = $this->post('user_id');
        $data = $this->homepage_m->loadlike($user_id);
        //$data = $this->pyrocache->model('homepage_m', 'loadlike', array($user_id), 7200);
        $this->response($data);
    }
    
    function ajaxlikedetail_post(){
        if($this->post('addlike')){
            $product_id=$this->post('pro_id');
            $u_id =$this->post('user_id');
            $this->homepage_m->addlikedyna($product_id, $u_id);
        }
        if($this->post('removelike')){
            
            $product_id=$this->post('pro_id');
            $u_id =$this->post('user_id');
            $this->homepage_m->deletelike($product_id,$u_id);
        }
        $pro_id = $this->post('pro_id');
        $user_id = $this->post('user_id');
        $data = $this->homepage_m->loadlikedetail($user_id,$pro_id);
        $this->response($data);
    }
    function ajaxuserdata_get(){
        $data = $this->session->userdata('user_id');
        $this->response($data);
    }
    function ajaxproductid_get(){
        $data = $this->session->userdata('id_p');
        $this->response($data);
    }
    public function ajaxcommentcount_post(){
        $pro_id = $this->post('pro_id');
        $data= $this->homepage_m->ajaxcommentcount($pro_id);
        $this->response($data);
    }
}
