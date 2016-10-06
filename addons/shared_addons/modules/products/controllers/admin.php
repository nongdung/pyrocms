<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller{
    protected $section = 'products';
    
    public function __construct(){
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('products');
    }

    public function index(){
        $extra['title'] = 'lang:products:products';
        
        $extra['buttons'] = array(
            array(
                'label' =>lang('global:edit'),
                'url'   => 'admin/products/edit/-entry_id-'
            ),
            array(
                'label' =>lang('global:delete'),
                'url'   => 'admin/products/delete/-entry_id-',
                'confirm'   =>true
            ),
        );
        
        $this ->streams->cp->entries_table('product', 'products', null, 'admin/products/index', true, $extra);
    }
    
    public function create(){
        $extra['title'] = 'Create Product';
        $extra = array(
            'return' => 'admin/products',
            'success_message' => lang('Success'),
            'failure_message' => lang('Failed'),
            'title' => 'New Product',
         );

        $this->streams->cp->entry_form('products', 'products', 'new', null, true, $extra);
    }
    
    public function edit($id = 0){
        $this->template->title(lang('Edit Product'));

        $extra = array(
            'return' => 'admin/products',
            'success_message' => lang(' successfully.'),
            'failure_message' => lang(' failed.'),
            'title' => lang('Edit Product')
        );

        $this->streams->cp->entry_form('products', 'products', 'edit', $id, true, $extra);
    }
    
    public function delete($id = 0){
        $this->streams->entries->delete_entry($id, 'products', 'products');
        $this->session->set_flashdata('error', lang('Product has deleted'));
        redirect('admin/products');
    }
}