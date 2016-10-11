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
       $data['results'] = $this->products_m->get_categories();

       $this->load->view('design/categories',$data);
       /*$params = array(
                'stream'    => 'categories',
                'namespace' => 'products',
                'order_by'  => 'ordering_count',
                'sort'      => 'asc',
            );
        $data['categories'] = $this->streams->entries->get_entries($params);
        $this->template
            ->title($this->module_details['name'])
            ->build('design/categories',$data);*/    
    }

    # hiển thị products
    public function get_products()
    {
    	#$data = $this->products_m->get_products();
        $data = $this->streams->entries->get_entry($id,'products','products',true);
        $this->template
            ->title($this->module_details['name'])
            ->build('design/product',$data);   	       
    }
    # hiển thị chi tiết sản phẩm 
    public function show_products($id_p)
    {
        $data['results'] = $this->products_m->detail_products($id_p);
        $this->load->view('design/product',$data);
        #print_r($data);
    }
    # hiển thị comments
    public function get_comments()
    {
    	$data = $this->products_m->get_comments();
        
    }

    # tìm kiếm
    public function search()
    {
    	if($this->input->get())
    	{
    		$keyword =  $this->input->get('keyword');
    		$data    =  $this->products_m->search($keyword);
    	}
    	$this->output
        	 ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }
   
}

