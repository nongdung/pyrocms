<?php defined('BASEPATH') or exit('No direct script access allowed');

class Homepage_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }
    public function ajaxcategories(){
        $this->db->select('c_name,id as id_c');
        $this->db->from('products_categories');
        $query = $this->db->get();
        return $query->result();
    }
    //update server
    public function ajaxlist($limit = 2, $offset = 0,$cat=null, $f_id = null){
        $this->db->select('products_products.id,p_id,p_name,p_image,p_price,p_highlight,p_discount,p_unit,p_short_description,p_long_description,category_id,files.id as f_id,files.path,products_categories.c_name');
        if($cat!=""){
        $this->db->where('category_id',$cat);
        };
        $this->db->from('products_products');
        $this->db->join('files', 'files.id = products_products.p_image');
        $this->db->join('products_categories','products_categories.id = products_products.category_id');
        $this->db->limit($limit, $offset);
        if($f_id=="1"){
             $this->db->order_by('p_price','DESC');
        }
        if($f_id=="2"){
             
             $this->db->order_by('p_price','ASC');
        }
        else{
            $this->db->order_by('p_price','ASC');
        }
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $index=>$value){
            $data[$index]["path"] = str_replace("{{ url:site }}",BASE_URL,$value['path']);
        }
        return $data;
    }

    public function ajaxcomments($limit=2,$offset=0,$pro_id=null)
    {
            $q =" SELECT * FROM (SELECT comments,product_id_c,reply_id,default_products_comment.id
                    FROM default_products_comment 
                    INNER JOIN default_products_products 
                    ON default_products_comment.product_id_c = default_products_products.id
                    WHERE default_products_products.id = $pro_id 
                    AND reply_id IS NULL    
                    ORDER BY default_products_comment.created DESC
                    LIMIT $limit 
                    OFFSET $offset
                    ) AS `table` ORDER by id ASC";
        
        
       
        $query = $this->db->query($q);
        return $query->result_array();

        
    }
    
    public function ajaxreply($pro_id=null,$com_id=null,$limit=2,$offset=0)
    {
            $q =" SELECT * FROM (SELECT comments,product_id_c,reply_id,default_products_comment.id
                    FROM default_products_comment 
                    INNER JOIN default_products_products 
                    ON default_products_comment.product_id_c = default_products_products.id
                    WHERE default_products_products.id = $pro_id 
                    AND reply_id = $com_id    
                    ORDER BY default_products_comment.created DESC
                    LIMIT $limit 
                    OFFSET $offset
                    ) AS `table` ORDER by id ASC";
        
        
       
        $query = $this->db->query($q);
        return $query->result_array();

        
    }
    public function insert_comments($data)
    {
        $this->db->insert("products_comment",$data);
        return true;
    }
    
}