<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }

    # lấy categories
    public function get_categories()
    {
    	$this->db->select("*");
    	$this->db->from("products_categories");
    	$query = $this->db->get();
    	return $query->result();
    }

    # lấy products
    public function get_products()
    {
    	$this->db->select("*");
    	$this->db->from("products_products");
    	$query = $this->db->get();
    	return $query->result();
    }

    # lấy comments
    public function get_comments()
    {
    	$this->db->select("*");
    	$this->db->from("products_comment");
    	$query = $this->db->get();
    	return $query->result();
    }

    # tìm kiếm theo products
    public function search($keyword)
    {
	    $this->db->like('p_name',$keyword);
	    $this->db->or_like('p_id',$keyword);
	    $query = $this->db->get('products_products');
	    return $query->result();
    }
}
