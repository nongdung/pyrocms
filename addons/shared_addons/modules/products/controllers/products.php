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
            ->append_metadata('<script src="https://unpkg.com/axios/dist/axios.min.js"></script>')
             ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/mystyle.css">')
             ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/redux/3.3.1/redux.min.js"></script>')
             ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/react-redux/4.4.0/react-redux.min.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/views/homepage/polyfill.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/preload.js"></script>')
            ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/loadingprocess.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/timecalculator.js"></script>')
            ->build('homepage/index');   
    }
    
    public function ajaxuserdata(){
        //$data = $this->session->userdata('user_id');
        $data = $this->homepage_m->ajaxlike();

        echo "<pre>";
        print_r($data);
        echo "</pre>";  
//        echo "<pre>";
//        print_r($data2);
//        echo "</pre>"; 
        $json = $this->output->set_content_type('application/json')->set_output(json_encode($data));      
    }
    # hiển thị chi tiết sản phẩm 
    public function detail($id_p)
    {
        $this->session->set_userdata('id_p', $id_p);
        $this->template
                ->title($this->module_details['name'])
                ->append_metadata(' <script src="https://unpkg.com/react@15.3.0/dist/react.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/react-dom@15.3.0/dist/react-dom.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>')
                ->append_metadata('<script src="https://unpkg.com/axios/dist/axios.min.js"></script>')
                ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/mystyle.css">')
                ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/detail.css">')
                ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/redux/3.3.1/redux.min.js"></script>')
                ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/react-redux/4.4.0/react-redux.min.js"></script>')
                ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/views/detail/polyfill.js"></script>')
                ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/preload.js"></script>')
                ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/loadingprocess.js"></script>')
                ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/timecalculator.js"></script>')
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
   
    public function search(){
         $this->template
             ->title($this->module_details['name'])
             ->append_metadata(' <script src="https://unpkg.com/react@15.3.0/dist/react.js"></script>')
             ->append_metadata('<script src="https://unpkg.com/react-dom@15.3.0/dist/react-dom.js"></script>')
             ->append_metadata('<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>')
            ->append_metadata('<script src="https://unpkg.com/axios/dist/axios.min.js"></script>')
             ->append_metadata('<link rel="stylesheet" href="{{ url:base }}/addons/shared_addons/modules/products/css/mystyle.css">')
             ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/redux/3.3.1/redux.min.js"></script>')
             ->append_metadata('<script src="https://cdnjs.cloudflare.com/ajax/libs/react-redux/4.4.0/react-redux.min.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/views/homepage/polyfill.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/preload.js"></script>')
            ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/loadingprocess.js"></script>')
             ->append_metadata('<script src="{{ url:base }}addons/shared_addons/modules/products/js/timecalculator.js"></script>')
            ->build('homepage/search');  
    }
    
    public function commentcount(){
        $data= $this->homepage_m->ajaxcommentcount();
        echo "<pre>";
        print_r($data);
        echo "</pre>"; 
    }
}

