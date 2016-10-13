<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Public_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('products');
        $this->load->model("products_m");
    }
    
    # hiển thị categories
    public function index()
    {
         $this->template
             ->title($this->module_details['name'])
             ->build('homepage/index');    
    }
    
    # hiển thị chi tiết sản phẩm 
    public function detail($id_p)
    {
        $data = $this->streams->entries->get_entry($id_p,'products','products',true);
        $this->template
            ->title($this->module_details['name'])
            ->build('design/product',$data); 
    }
    # hiển thị comments
    public function get_comments()
    {     
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

        $data = $this->products_m->ajaxlist($limit, $offset);
        $json = $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));  
   
   }
}

