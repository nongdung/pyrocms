<?php defined('BASEPATH') or exit('No direct script access allowed');

class Homepage_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();

    }
    
    public function ajaxlike($user_id=null){
        $this->db->select('id as pro_id')->from('products_products');
	$query = $this->db->get()->result_array();
        
        $q1 = array();
        $q2 = array ();
        for($i = 1; $i < count($query)+1; $i++){   
	$pro_id=$i; 
        
	$this->db->select('product_id,count(*) as likecount')->from('products_like')->where('product_id',$pro_id);
        //$this->db->select('count(*) as usercount')->where('user_id',$user_id);
	$q1[] = $this->db->get()->result_array();	
        }
        if($user_id!=null){
            for($i = 1; $i < count($query)+1; $i++){   
                $pro_id=$i; 
                $this->db->select('count(*)')->from('products_like')->where('product_id',$pro_id);
                $this->db->select('count(*) as usercount')->where('user_id',$user_id);
                $q2[] = $this->db->get()->result_array();
            }
            for ($i = 0; $i <count($q1); $i++){
                $q[] = array_merge($query[$i],$q1[$i][0], $q2[$i][0]); 
            }
            return $q;
        }
        else{
        $q2[] = array("usercount"=>"2");
        for ($i = 0; $i <count($q1); $i++){
            $q[] = array_merge($query[$i],$q1[$i][0], $q2[0]); 
        }
        return $q;
        }
    }
    
    public function add_like($data){
        $this->db->insert("products_like",$data);
        return true;
    }
    
    public function remove_like($product_id,$u_id){
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $u_id);
        $this->db->delete('products_like');
        return true;
    }
    
    public function ajaxcategories(){
        $this->db->select('c_name,id as id_c');
        $this->db->from('products_categories');
        $query = $this->db->get();
        return $query->result_array();
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