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
}
