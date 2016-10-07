<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_categories extends Admin_Controller{
    protected $section = 'categories';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('Streams');
        $this->lang->load('products');
    }

    public function index()
    {
        $extra['title']   = 'lang:product:categories';
        
        $extra['columns'] = array('c_name', 'c_description', 'c_image');

        $extra['buttons'] = array(
            array(
                'label'   => lang('global:edit'),
                'url'     => 'admin/products/categories/edit/-entry_id-'
            ),
            array(
                'label'   => lang('global:delete'),
                'url'     => 'admin/products/categories/delete/-entry_id-',
                'confirm' => true
            )
        );

        $this->streams->cp->entries_table('categories', 'products', 3 , 'admin/products/categories/index', true, $extra);
    }
    
    public function create()
    {
        $extra['title'] = 'Create Category';

        $extra = array(
            'return'          => 'admin/products/categories/index',
            'success_message' => lang('Success'),
            'failure_message' => lang('Failed'),
            'title'           => 'New Product',
            'columns'         => array('c_name', 'c_description', 'c_image')
         );

        $this->streams->cp->entry_form('categories', 'products', 'new', null, true, $extra);
    }
    
    public function edit($id = 0)
    {
        $this->template->title(lang('Edit Product'));

        $extra = array(
            'return'          => 'admin/products/categories/index',
            'success_message' => lang(' successfully.'),
            'failure_message' => lang(' failed.'),
            'title'           => lang('Edit Product')
        );

        $this->streams->cp->entry_form('categories', 'products', 'edit', $id, true, $extra);
    }
    
    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, 'categories', 'products');
        $this->session->set_flashdata('error', lang('category has deleted'));
        redirect('admin/products/categories/index');
    }
}