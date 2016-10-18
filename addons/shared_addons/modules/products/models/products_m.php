<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }
    //update server
    public function ajaxlist($limit = 2, $offset = 0){
        $this->db->select("*");
        $this->db->from('products_products');
        $this->db->join('files', 'files.id = products_products.p_image','inner');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }

    public function detail_products($id_p)
    {            
        $this->db->select("products_products.id"); 
        $this->db->select("products_products.p_id");
        $this->db->select("products_products.p_name");
        $this->db->select("products_products.p_price");
        $this->db->select("products_products.p_discount");
        $this->db->select("products_products.p_long_description");
        $this->db->select("products_products.category_id");
        $this->db->select("files.path");
        $this->db->select("products_comment.comments"); 
        $this->db->select("products_comment.user_id_c"); 
        $this->db->select("products_comment.reply_id");
        $this->db->select("products_products.p_image");
        
        $this->db->where("products_products.id",$id_p);
        $this->db->from("products_products");
        $this->db->join('files', 'files.id = products_products.p_image', 'inner');
        $this->db->join('products_comment', 'products_comment.product_id_c = products_products.id', 'inner');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }

    public function comments($id_p)
    {
        $this->db->select("*");
        $this->db->where("products_products.id",$id_p);
        $this->db->from("products_products");
        $this->db->join('products_comment', 'products_comment.product_id_c = products_products.id', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_comments($data)
    {
        $this->db->insert("products_comment",$data);
        return true;
    }
}
