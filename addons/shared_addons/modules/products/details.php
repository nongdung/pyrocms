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
                            'name'  => 'product:create',
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

    public function install()
    {
        $this->load->driver("Streams");

        $this->streams->utilities->remove_namespace('products');

        if( ! $product_id = $this->streams->streams->add_stream('Products','product','products',null)) return false;

        if( ! $category_id = $this->streams->streams->add_stream('Categories','category','products',null)) return false;

        if( ! $this->streams->streams->add_stream('Comments','comment','products',null)) return false;

        if( ! $this->streams->streams->add_stream('Likes','like','products',null)) return false;

        if( ! $this->streams->streams->add_stream('Rates','rate','products',null)) return false;

        # add fields categories
        $fields_categories = array(
            array(
                'name'        => 'categories id',
                'slug'        => 'cat_id',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 10),
                'assign'      => 'category',
                'title_colum' => true,
                'required'    => true
            ), 
            array(
                'name'        => 'categories name',
                'slug'        => 'c_name',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 100),
                'assign'      => 'category',
                'title_colum' => true,
                'required'    => true
            ), 
            array(
                'name'        => 'categories description',
                'slug'        => 'c_description',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 200),
                'assign'      => 'category',
                'title_colum' => true,
                'required'    => true
            ), 
            array(
                'name'          => 'image',
                'slug'          => 'c_image',
                'namespace'     => 'products',
                'type'          => 'image',
                'extra'         => array('folder' => 1, 'allowed_types' => 'jpg|gif|png'),
                'assign'        => 'category',
                'required'      => true
            ),

        );

        $this->streams->fields->add_fields($fields_categories);
        $this->streams->streams->update_stream('category', 'products',array(
            'view_options' => array(
                'cat_id', 'c_name', 'c_description', 'c_image'
            ))
        );

        # add fields products
        $field_products = array(
            array(
                'name'          => 'product id',
                'slug'          => 'p_id',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 10),
                'assign'        => 'product',
                'required'      => true
            ),
            array(
                'name'          => 'product name',
                'slug'          => 'p_name',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 100),
                'assign'        => 'product',
                'required'      => true
            ),
            array(
                'name'          => 'image',
                'slug'          => 'p_image',
                'namespace'     => 'products',
                'type'          => 'image',
                'extra'         => array('folder' => 1, 'allowed_types' => 'jpg|gif|png'),
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'price',
                'slug'          => 'p_price',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'product',
                'required'      => true
            ),
            array(
                'name'          => 'highlight',
                'slug'          => 'p_highlight',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'product',
                'required'      => false
            ),
            array(
                'name'          => 'discount',
                'slug'          => 'p_discount',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'product',
                'required'      => false
            ),
            array(
                'name'          => 'unit',
                'slug'          => 'p_unit',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 10),
                'assign'        => 'product',
                'required'      => true
            ),
            array(
                'name'          => 'short description',
                'slug'          => 'p_short_description',
                'namespace'     => 'products',
                'type'          => 'wysiwyg',
                'extra'         => array('editor_type' => 'advanced ', 'allow_tags' => 'y'),
                'assign'        => 'product',
                'required'      => false
            ),
             array(
                'name'          => 'long description',
                'slug'          => 'p_long_description',
                'namespace'     => 'products',
                'type'          => 'wysiwyg',
                'extra'         => array('editor_type' => 'advanced ', 'allow_tags' => 'y'),
                'assign'        => 'product',
                'required'      => false
            ),
            array(
                'name'          => 'category',
                'slug'          => 'category_id',
                'namespace'     => 'products',
                'type'          => 'relationship',
                'assign'        => 'product',
                'extra'         => array('choose_stream' => $category_id),
                'required'      => true
            )
        );

        $this->streams->fields->add_fields($field_products);
        $this->streams->streams->update_stream('product', 'products',array(
            'view_options' => array(
                'p_id', 'p_name', 'p_price','p_image', 'p_highlight', 'p_discount', 'p_unit', 'p_short_description','p_long_description', 'category_id'
            ))
        );

        # add fields comments
        #$fields_comments = array();
        return true;
    }

    public function uninstall()
    {
        $this->streams->utilities->remove_namespace('products');

        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    public function help()
    {
        return true;
    }
}     

?>