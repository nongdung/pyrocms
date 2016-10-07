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
                            'name'  => 'product:create',
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

        if( ! $product_id = $this->streams->streams->add_stream('products','products','products','products_',null)) return false;

        if( ! $category_id = $this->streams->streams->add_stream('categories','categories','products','products_',null)) return false;

        if( ! $this->streams->streams->add_stream('comments','comment','products','products_',null)) return false;

        if( ! $this->streams->streams->add_stream('likes','like','products','products_',null)) return false;

        if( ! $this->streams->streams->add_stream('rates','rate','products','products_',null)) return false;

        # add fields categories
        $fields_categories = array(
            array(
                'name'        => 'Categories Id',
                'slug'        => 'cat_id',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 10),
                'assign'      => 'categories',
                'required'    => true
            ), 
            array(
                'name'        => 'Categories Name',
                'slug'        => 'c_name',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 100),
                'assign'       => 'categories',
                'title_column' => true,
                'required'     => true
            ), 
            array(
                'name'        => 'Categories Description',
                'slug'        => 'c_description',
                'namespace'   => 'products',
                'type'        => 'text',
                'extra'       => array('max_length' => 200),
                'assign'      => 'categories',
                'required'    => true
            ), 
            array(
                'name'          => 'Image',
                'slug'          => 'c_image',
                'namespace'     => 'products',
                'type'          => 'image',
                'extra'         => array('folder' => 1, 'allowed_types' => 'jpg|gif|png'),
                'assign'        => 'categories',
                'required'      => true
            ),

        );

        $this->streams->fields->add_fields($fields_categories);
        $this->streams->streams->update_stream('categories', 'products',array(
            'view_options' => array(
                'cat_id', 'c_name', 'c_description', 'c_image'
            ))
        );

        # add fields products
        $field_products = array(
            array(
                'name'          => 'Product Id',
                'slug'          => 'p_id',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 10),
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'Product Name',
                'slug'          => 'p_name',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 100),
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'Image',
                'slug'          => 'p_image',
                'namespace'     => 'products',
                'type'          => 'image',
                'extra'         => array('folder' => 1, 'allowed_types' => 'jpg|gif|png'),
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'Price',
                'slug'          => 'p_price',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'Highlight',
                'slug'          => 'p_highlight',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'products',
                'required'      => false
            ),
            array(
                'name'          => 'Discount',
                'slug'          => 'p_discount',
                'namespace'     => 'products',
                'type'          => 'integer',
                'assign'        => 'products',
                'required'      => false
            ),
            array(
                'name'          => 'Unit',
                'slug'          => 'p_unit',
                'namespace'     => 'products',
                'type'          => 'text',
                'extra'         => array('max_length' => 10),
                'assign'        => 'products',
                'required'      => true
            ),
            array(
                'name'          => 'Short Description',
                'slug'          => 'p_short_description',
                'namespace'     => 'products',
                'type'          => 'wysiwyg',
                'extra'         => array('editor_type' => 'advanced ', 'allow_tags' => 'y'),
                'assign'        => 'products',
                'required'      => false
            ),
             array(
                'name'          => 'Long Description',
                'slug'          => 'p_long_description',
                'namespace'     => 'products',
                'type'          => 'wysiwyg',
                'extra'         => array('editor_type' => 'advanced ', 'allow_tags' => 'y'),
                'assign'        => 'products',
                'required'      => false
            ),
            array(
                'name'          => 'Category',
                'slug'          => 'category_id',
                'namespace'     => 'products',
                'type'          => 'relationship',
                'assign'        => 'products',
                'extra'         => array('choose_stream' => $category_id),
                'required'      => true
            )
        );

        $this->streams->fields->add_fields($field_products);
        $this->streams->streams->update_stream('products', 'products',array(
            'view_options' => array(
                'p_id', 'p_name', 'p_price','p_image', 'p_highlight', 'p_discount', 'p_unit', 'p_short_description','p_long_description', 'category_id'
            ))
        );

        # add fields comments
        $fields_comments = array(
            array(
                'name'        => 'Comments',
                'slug'        => 'comments',
                'namespace'   => 'products',
                'type'        => 'wysiwyg',
                'extra'       => array('editor_type' => 'advanced', 'allow_tags' => 'y'),
                'assign'      => 'comment',
                'title_column' => true,
                'required'    => false
            ),
            array(
                'name'        => 'Product Id',
                'slug'        => 'product_id_c',
                'namespace'   => 'products',
                'type'        => 'relationship',             
                'extra'       => array('choose_stream' => $product_id),
                'assign'      => 'comment',
                'required'    => true
            ),
            array(
                'name'        => 'Reply Id',
                'slug'        => 'reply_id',
                'namespace'   => 'products',
                'type'        => 'wysiwyg',
                'extra'       => array('editor_type' => 'advanced', 'allow_tags' => 'y'),
                'assign'      => 'comment',
                'required'    => false
            ),
            array(
                'name'        => 'User Id',
                'slug'        => 'user_id_c',
                'namespace'   => 'products',
                'type'        => 'integer',
                'assign'      => 'comment',
                'required'    => true
            ),
        );

        $this->streams->fields->add_fields($fields_comments);
        $this->streams->streams->update_stream('comment', 'products',array(
            'view_options' => array(
                'comments', 'user_id_c', 'reply_id' , 'product_id_c'
            ))
        );

        # add fields like
        $fields_likes = array(
            array(
                'name'        => 'Product Id',
                'slug'        => 'product_id_l',
                'namespace'   => 'products',
                'type'        => 'relationship',          
                'extra'       => array('choose_stream' => $product_id),
                'assign'      => 'like',
                'required'    => true
            ),
            array(
                'name'        => 'User Id',
                'slug'        => 'user_id_l',
                'namespace'   => 'products',
                'type'        => 'integer',
                'assign'      => 'like',
                'required'    => true
            )
        );

        $this->streams->fields->add_fields($fields_likes);
        $this->streams->streams->update_stream('like', 'products',array(
            'view_options' => array(
                'user_id_l', 'product_id_l'
            ))
        );

        # add fields rate
        $fields_rate = array(
            array(
                'name'        => 'Rates',
                'slug'        => 'rates',
                'namespace'   => 'products',
                'type'        => 'integer',
                'assign'      => 'rate',
                'required'    => true
            ),
            array(
                'name'        => 'Product Id',
                'slug'        => 'product_id_r',
                'namespace'   => 'products',
                'type'        => 'relationship',
                'extra'       => array('choose_stream' => $product_id),
                'assign'      => 'rate',
                'required'    => true
            ),
            array(
                'name'        => 'User Id',
                'slug'        => 'user_id_r',
                'namespace'   => 'products',
                'type'        => 'integer',
                'assign'      => 'rate',
                'required'    => true
            )
        );
        $this->streams->fields->add_fields($fields_rate);
        $this->streams->streams->update_stream('rate', 'products',array(
            'view_options' => array(
                'rates', 'user_id_r', 'product_id_r'
            ))
        );

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