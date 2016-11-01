<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Public_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('products');
        $this->load->model("products_m");
        $this->load->model("homepage_m");
        $this->load->library('session');
    }
    
    # hiển thị categories
    public function index()
    {
         $this->template
            ->title($this->module_details['name'])
            ->append_metadata(' <script src="https://unpkg.com/react@15.3.0/dist/react.js"></script>')
            ->append_metadata('<script src="https://unpkg.com/react-dom@15.3.0/dist/react-dom.js"></script>')
            ->append_metadata('<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>')
            ->append_metadata('<script src="https://unpkg.com/jquery@3.1.0/dist/jquery.min.js"></script>')
            ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/mystyle.css">')
            ->build('homepage/index');    
    }
    
    # hiển thị chi tiết sản phẩm 
    public function detail($id_p)
    {
        $this->session->set_userdata('id_p', $id_p);
        $this->template
                ->title($this->module_details['name'])
                ->append_metadata('<script src="https://unpkg.com/react@15.3.0/dist/react.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/react-dom@15.3.0/dist/react-dom.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/jquery@3.1.0/dist/jquery.min.js"></script>')
                ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/mystyle.css">')
                ->build('detail/detail_p');                     
    }
    
    public function ajaxdetail()
    {
        $id_p = $this->session->userdata('id_p');

        $data = $this->products_m->detail_products($id_p);

        $json = $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));      
    }
    # hiển thị comments
    public function comment()
    {   
        $id_p =  $this->session->userdata('id_p');    
        if($this->input->post('asd'))
        {
            $data = array (
                'comments'     => $this->input->post('comment'),
                'product_id_c' => $this->input->post('pro_id'),
                'user_id_c'    => '1',
                'created'      => date('Y-m-d H:i:s')
            ); 
            $this->products_m->insert_comments($data);
        }
        $limit  = $this->input->post("limit");
       
        $offset = $this->input->post("offset");
            $data = $this->products_m->comments($limit,$offset,$id_p);
            $json = $this->output->set_content_type('application/json')->set_output(json_encode($data));         
    }
    
    public function reply_comments()
    {
        $reply_id = 6;
        $limit  = $this->input->post("limit");
        $offset = $this->input->post("offset");
        $data = $this->products_m->reply_comments($limit,$offset,$reply_id);
        $json = $this->output->set_content_type('application/json')->set_output(json_encode($data)); 
        #echo "<pre>"; print_r($data); die();
    }
    # tìm kiếm
    public function search()
    {

    }
   
    //New function here--provide jsondata for react main.js
    public function ajaxlist(){
        //receive value limit from loadmore button
        $limit =(int) $this->input->post('limit');
        $offset =(int) $this->input->post('offset');
        $cat = $this->input->post('cat_id');
        $f_id = $this->input->post('f_id');
        $data = $this->homepage_m->ajaxlist($limit, $offset, $cat, $f_id);
        $json = $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));  
    }
   
    public function ajaxcategories(){
       $data = $this->homepage_m->ajaxcategories();
       $json = $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));  
    }
    public function ajaxcomment(){
        if($this->input->post('asd'))
        {
            $data = array (
                'comments'     => $this->input->post('comment'),
                'product_id_c' => $this->input->post('pro_id'),
                'user_id_c'    => '1',
                'created'      => date('Y-m-d H:i:s')
            ); 
            $this->products_m->insert_comments($data);
        }
        $limit =(int) $this->input->post('limit');
        $offset =(int) $this->input->post('offset');
        $pro_id = $this->input->post('pro_id');
        $data =  $this->homepage_m->comments($limit, $offset, $pro_id);
        $json = $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));  
   }
}

