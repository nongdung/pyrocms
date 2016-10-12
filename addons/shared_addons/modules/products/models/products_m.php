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
    # lấy ra chi tiết sản phẩm
    public function detail_products($id_p)
    {
        $this->db->select("*");
        $this->db->where("id",$id_p);
        $this->db->from("products_products");
        $query = $this->db->get();
        return $query->row_array();
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

    public function server(){
        $this->db->select('*');
        $this->db->from('products_products');
        $this->db->join('files', 'files.id = products_products.p_image', 'inner');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }
}
