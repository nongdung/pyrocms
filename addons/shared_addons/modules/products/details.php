<?php  defined('BASEPATH') or exit('No direct script access allowed');

class Module_Products extends Module{
    public $version = '1.0';

    public function info(){

        return array(
            'name'  => array(
                'en'    => 'Products'
            ),
            'description'   => array(
                'en'    => 'Products management'
            ),
            'frontend'  => true,
            'backend'   => true,
            'menu'      => 'content',
            'sections'  => array(
                'products'  =>  array(
                    'name'  => 'Products',
                    'uri'   => 'admin/products',
                    'shortcuts' => array(
			        'create'=>array(
                            'name'  => 'product:Create',
                            'uri'   => 'admin/products/create',
                            'class' => 'add',
                        ),
                    ),
                ),

                'categories'=> array(
                    'name'  => 'Categories',
                    'uri'   => 'admin/products/categories/index',
                    'shortcuts' => array(
                       'create'=>array(
                            'name'  => 'product:Create',
                            'uri'   => 'admin/products/categories/create',
                            'class' => 'add',
                        ),
                    ),
                ),
            ),
        );
    }

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }

    public function upgrade($old_version){
        return true;
    }

    public function help(){
        return true;
    }
}     

?>