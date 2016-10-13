<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }
    //update server
    public function ajaxlist($limit = 2, $offset = 0){
        $this->db->select('*');
        $this->db->from('products_products');
        $this->db->join('files', 'files.id = products_products.p_image', 'inner');
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
        $this->db->select("*");
        $this->db->where("products_products.id",$id_p);
        $this->db->from("products_products");
        $this->db->join('files', 'files.id = products_products.p_image', 'inner');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }
}
