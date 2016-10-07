<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Public_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('products');
    }
    
    public function index(){
        echo '123';
    }
}

