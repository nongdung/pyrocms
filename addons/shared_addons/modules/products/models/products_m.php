<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }

    public function detail_products($id_p=null)
    {            
        $this->db->select("products_products.id"); 
        $this->db->select("products_products.p_id");
        $this->db->select("products_products.p_name");
        $this->db->select("products_products.p_price");
        $this->db->select("products_products.p_discount");
        $this->db->select("products_products.p_long_description");
        $this->db->select("products_products.category_id");
        $this->db->select("files.path");
        $this->db->from("products_products");
        $this->db->where("products_products.id",$id_p);
        $this->db->join('files', 'files.id = products_products.p_image');
        
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }

    public function comments($limit=2,$offset=0,$id_p=null)
    {
        $this->db->select("products_products.id as pro_id");
        $this->db->select("products_comment.id as com_id");
        $this->db->select("products_comment.comments");
        $this->db->select("products_comment.reply_id");
        $this->db->from("products_comment");
        $this->db->where("products_products.id",$id_p);
        $this->db->join('products_products', 'products_products.id = products_comment.product_id_c');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function reply_comments($limit=2,$offset=0,$reply_id)
    {
        $this->db->select("*");
        $this->db->from("products_comment");
        $this->db->where("reply_id",$reply_id);$this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_comments($data)
    {
        $this->db->insert("products_comment",$data);
        return true;
    }
}
