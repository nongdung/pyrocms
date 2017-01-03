<?php defined('BASEPATH') or exit('No direct script access allowed');

class Homepage_m extends MY_Model
{   
    function __construct() 
    {
        parent::__construct();
        include('E:/Work/xampp/htdocs/pyrocms-pyrocms/addons/shared_addons/modules/products/config/aws.inc.php');
        
    }
    
    public function deleteTable(){
         $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'AKIAJHDNGDS75DEYKEUA',
                'secret' => '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',
            ],
        ];
        $sdk = new Aws\Sdk($config);
        $dynamodb = $sdk->createDynamoDb();
        $params = [
            'TableName' => 'Products_comment'
        ];

        try {
            $result = $dynamodb->deleteTable($params);
            echo "Deleted table.\n";

        } catch (DynamoDbException $e) {
            echo "Unable to delete table:\n";
            echo $e->getMessage() . "\n";
        }
    }
    public function createTablelike(){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'AKIAJTFJLDUUQWOVNEWA',
                'secret' => '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',
            ],
        ];
        $sdk = new Aws\Sdk($config);
        $dynamodb = $sdk->createDynamoDb();

        $params = [
             'TableName' => 'Products_like',
             'KeySchema' => [
                 [
                     "AttributeName"=> "product_id",
                     "KeyType"=> "HASH"
                 ],
                 [
                     "AttributeName"=> "user_id",
                     "KeyType"=> "RANGE"
                 ]
             ],
             'AttributeDefinitions' => [
                 [
                     "AttributeName"=> "product_id",
                     "AttributeType"=> "N"
                 ],
                 [
                     "AttributeName"=> "user_id",
                     "AttributeType"=> "N"
                 ],

             ],
             'ProvisionedThroughput' => [
                 'ReadCapacityUnits' => 5,
                 'WriteCapacityUnits' => 5
             ],
        //     'GlobalSecondaryIndexes'=> [ 
        //         [ 
        //             'IndexName' => 'product_id_Index', 
        //             'KeySchema'=> [
        //                 [ // Required HASH type attribute
        //                     "AttributeName"=> "product_id",
        //                     "KeyType"=> "HASH"
        //                 ],
        //                 [ // Optional RANGE key type for HASH + RANGE secondary indexes
        //                     "AttributeName"=> "user_id",
        //                     "KeyType"=> "RANGE"
        //                 ]
        //             ],
        //            'Projection'=> [// attributes to project into the index
        //                 'ProjectionType'=> 'ALL', // (ALL | KEYS_ONLY | INCLUDE)

        //            ],
        //             'ProvisionedThroughput'=> [ // throughput to provision to the index
        //                 'ReadCapacityUnits'=> 1,
        //                 'WriteCapacityUnits'=> 1,
        //             ],
        //         ],
        //         // ... more global secondary indexes ...
        //     ],

         ];
        
        
        try {
             $result = $dynamodb->createTable($params);
             echo 'Created table.  Status: ' . 
                 $result['TableDescription']['TableStatus'] ."\n";

         } catch (DynamoDbException $e) {
             echo "Unable to create table:\n";
             echo $e->getMessage() . "\n";
         }
    }
    public function createTablecomment(){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'AKIAJHDNGDS75DEYKEUA',
                'secret' => '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',
            ],
        ];
        $sdk = new Aws\Sdk($config);
        $dynamodb = $sdk->createDynamoDb();

        $params = [
            'TableName' => 'Products_comment',
            'KeySchema' => [
                [
                    "AttributeName"=> "Id",
                    "KeyType"=> "HASH"
                ],
            ],
            'AttributeDefinitions' => [
                [
                    "AttributeName"=> "Id",
                    "AttributeType"=> "N"
                ],

                [
                     "AttributeName"=> "product_id_c",
                     "AttributeType"=> "N"
                ],
                [
                     "AttributeName"=> "reply_id",
                     "AttributeType"=> "N"
                ],
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 1,
                'WriteCapacityUnits' => 1
            ],
             'GlobalSecondaryIndexes'=> [ 
                 
                 [ 
                     'IndexName' => 'product_id_c_Index', 
                     'KeySchema'=> [
                         [ // Required HASH type attribute
                             "AttributeName"=> "product_id_c",
                             "KeyType"=> "HASH"
                         ],
                     ],
                    'Projection'=> [// attributes to project into the index
                         'ProjectionType'=> 'ALL', // (ALL | KEYS_ONLY | INCLUDE)

                    ],
                     'ProvisionedThroughput'=> [ // throughput to provision to the index
                         'ReadCapacityUnits'=> 1,
                         'WriteCapacityUnits'=> 1,
                     ],
                 ],
                 
                 [ 
                     'IndexName' => 'reply_id_Index', 
                     'KeySchema'=> [
                         [ // Required HASH type attribute
                             "AttributeName"=> "reply_id",
                             "KeyType"=> "HASH"
                         ],
                     ],
                    'Projection'=> [// attributes to project into the index
                         'ProjectionType'=> 'ALL', // (ALL | KEYS_ONLY | INCLUDE)

                    ],
                     'ProvisionedThroughput'=> [ // throughput to provision to the index
                         'ReadCapacityUnits'=> 1,
                         'WriteCapacityUnits'=> 1,
                     ],
                 ],
                 // ... more global secondary indexes ...
                 
             ],

         ];
        
        
        try {
             $result = $dynamodb->createTable($params);
             echo 'Created table.  Status: ' . 
                 $result['TableDescription']['TableStatus'] ."\n";

         } catch (DynamoDbException $e) {
             echo "Unable to create table:\n";
             echo $e->getMessage() . "\n";
         }
    }
    
    public function loadTablecomment(){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'AKIAJHDNGDS75DEYKEUA',
                'secret' => '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',
            ],
        ];
        $sdk = new Aws\Sdk($config);
        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Aws\DynamoDb\Marshaler();
        $eav = $marshaler->marshalJson('
            {
                ":id": 1
            }
        ');
        $params =[
            'TableName' => 'Products_comment',
            'KeyConditionExpression' => 'id = :id',
            'ExpressionAttributeValues'=> $eav
        ];
        
        try {
            $result = $dynamodb->query($params);
            
            } 
        catch (DynamoDbException $e) {
            echo "Unable to query:\n";
            echo $e->getMessage() . "\n";
        }
        return $result;
        
    }
    public function loadlike($user_id=null){
        $this->db->select('id as pro_id')->from('products_products');
	$query = $this->db->get()->result_array();
        
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                    'key'    => 'AKIAJHDNGDS75DEYKEUA',
                    'secret' => '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',
                ],
        ];
        $sdk = new Aws\Sdk($config);
        $marshaler = new Aws\DynamoDb\Marshaler();
        $dynamodb = $sdk->createDynamoDb();
        
        $arr = array();
        for($i=1;$i < count($query)+1;$i++){
            $arr[$i][':value'] = $i;
            //$json = '{ ":value": 1 }';
            $json = json_encode($arr[$i]);
            $eav = $marshaler->marshalJson($json);
            $params = [
                'TableName' => 'Products_like',
                'KeyConditionExpression' => 'product_id = :value',
                'ExpressionAttributeValues'=> $eav
                ];
            try {
                $result[] = $dynamodb->query($params);

            } catch (DynamoDbException $e) {
                echo "Unable to query:\n";
                echo $e->getMessage() . "\n";
            }
        }
        for($i=0;$i<count($arr);$i++){
            $arr2[$i]['likecount'] = $result[$i]['Count'];
        }
        
        if($user_id!=null){
            $user_id = (int)$user_id;
            for($i=1;$i < count($query)+1;$i++){
                $arr3[$i][':user_id'] = $user_id;
                $arr3[$i][':pro_id'] = $i;
                //$json2 = '{ ":pro_id": 1, ":user_id": 1 }';
                $json2 = json_encode($arr3[$i]);
                $eav2 = $marshaler->marshalJson($json2);
                $params2 = [
                    'TableName' => 'Products_like',
                    'KeyConditionExpression' => 'product_id = :pro_id and user_id = :user_id',
                    'ExpressionAttributeValues'=> $eav2
                    ];
                try {
                    $result2[] = $dynamodb->query($params2);

                } catch (DynamoDbException $e) {
                    echo "Unable to query:\n";
                    echo $e->getMessage() . "\n";
                }
            }

            for($i=0;$i<count($arr3);$i++){
                $arr4[$i]['usercount'] = $result2[$i]['Count'];
            }

            for ($i = 0; $i <count($query); $i++){
                    $q[] = array_merge($query[$i],$arr4[$i], $arr2[$i]); 
                }
            return $q;
        }
        else{ 
            $arr4[] = array("usercount"=>"2");

            for ($i = 0; $i <count($query); $i++){
                    $q[] = array_merge($query[$i],$arr4[0], $arr2[$i]); 
                }
            return $q;    
        }

        
    }
       /* public function loadlike($user_id=null){
        
            $this->db->select('id as pro_id')->from('products_products');
            $query = $this->db->get()->result_array();

            $config = [
                'region'  => 'ap-southeast-1',
                'scheme' => 'http',
                'version'  => 'latest',
                'credentials' => [
                    'key'    => 'AKIAJHDNGDS75DEYKEUA',
                    'secret' => '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',
                ],
            ];
            $sdk = new Aws\Sdk($config);
            $marshaler = new Aws\DynamoDb\Marshaler();
            $dynamodb = $sdk->createDynamoDb();

            $arr = array();
            for($i=1;$i < count($query)+1;$i++){
                $arr[$i][':value'] = $i;
                //$json = '{ ":value": 1 }';
                $json = json_encode($arr[$i]);
                $eav = $marshaler->marshalJson($json);
                $params = [
                    'TableName' => 'Products_like',
                    'KeyConditionExpression' => 'product_id = :value',
                    'ExpressionAttributeValues'=> $eav
                    ];
                try {
                    $result[] = $dynamodb->query($params);

                } catch (DynamoDbException $e) {
                    echo "Unable to query:\n";
                    echo $e->getMessage() . "\n";
                }
            }
            for($i=0;$i<count($arr);$i++){
                $arr2[$i]['likecount'] = $result[$i]['Count'];
            }

            if($user_id!=null){
                $user_id = (int)$user_id;
                for($i=1;$i < count($query)+1;$i++){
                    $arr3[$i][':user_id'] = $user_id;
                    $arr3[$i][':pro_id'] = $i;
                    //$json2 = '{ ":pro_id": 1, ":user_id": 1 }';
                    $json2 = json_encode($arr3[$i]);
                    $eav2 = $marshaler->marshalJson($json2);
                    $params2 = [
                        'TableName' => 'Products_like',
                        'KeyConditionExpression' => 'product_id = :pro_id and user_id = :user_id',
                        'ExpressionAttributeValues'=> $eav2
                        ];
                    try {
                        $result2[] = $dynamodb->query($params2);

                    } catch (DynamoDbException $e) {
                        echo "Unable to query:\n";
                        echo $e->getMessage() . "\n";
                    }
                }

                for($i=0;$i<count($arr3);$i++){
                    $arr4[$i]['usercount'] = $result2[$i]['Count'];
                }

                for ($i = 0; $i <4; $i++){
                        $q[] = array_merge($query[$i],$arr4[$i], $arr2[$i]); 
                    }
                return $q;
            }
            else{ 
                $arr4[] = array("usercount"=>"2");

                for ($i = 0; $i <4; $i++){
                        $q[] = array_merge($query[$i],$arr4[0], $arr2[$i]); 
                    }
                return $q;    
            }    
    }*/
    public function loadlikedetail($user_id=null,$pro_id=null){
            $pro_id = (int)$pro_id;
            $config = [
                'region'  => 'ap-southeast-1',
                'scheme' => 'http',
                'version'  => 'latest',
                'credentials' => [
                    'key'    => 'AKIAJHDNGDS75DEYKEUA',
                    'secret' => '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',
                ],
            ];
            $sdk = new Aws\Sdk($config);
            $marshaler = new Aws\DynamoDb\Marshaler();
            $dynamodb = $sdk->createDynamoDb();   
            $arr = array();
            $arr[':value'] = $pro_id;
                //$json = '{ ":value": 1 }';
            $json = json_encode($arr);
            $eav = $marshaler->marshalJson($json);
            $params = [
                'TableName' => 'Products_like',
                'KeyConditionExpression' => 'product_id = :value',
                'ExpressionAttributeValues'=> $eav
                ];
            try {
                $result[] = $dynamodb->query($params);

            } catch (DynamoDbException $e) {
                echo "Unable to query:\n";
                echo $e->getMessage() . "\n";
            }
            $arr2[0]['likecount'] = $result[0]['Count'];
            
            
            if($user_id!=null){
                $user_id = (int)$user_id;
                
                    $arr3[':user_id'] = $user_id;
                    $arr3[':pro_id'] = $pro_id;
                    //$json2 = '{ ":pro_id": 1, ":user_id": 1 }';
                    $json2 = json_encode($arr3);
                    $eav2 = $marshaler->marshalJson($json2);
                    $params2 = [
                        'TableName' => 'Products_like',
                        'KeyConditionExpression' => 'product_id = :pro_id and user_id = :user_id',
                        'ExpressionAttributeValues'=> $eav2
                        ];
                    try {
                        $result2[] = $dynamodb->query($params2);

                    } catch (DynamoDbException $e) {
                        echo "Unable to query:\n";
                        echo $e->getMessage() . "\n";
                    }

                    $arr4[0]['usercount'] = $result2[0]['Count'];               
                        $q[0] = array_merge($arr4[0], $arr2[0]); 
                return $q;
            }
            else{ 
                $arr4[0] = array("usercount"=>"2");
                $q[0] = array_merge($arr4[0], $arr2[0]); 

                return $q;    
            }
            return;
    }
    public function addlikedyna($product_id,$u_id){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                    'key'    => 'AKIAJHDNGDS75DEYKEUA',
                    'secret' => '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',
                ],
        ];
        $sdk = new Aws\Sdk($config);
        $marshaler = new Aws\DynamoDb\Marshaler();
        $dynamodb = $sdk->createDynamoDb();
        
        $product_id = (int)$product_id;
        $u_id = (int)$u_id;
        $arr['product_id'] = $product_id;
        $arr['user_id'] = $u_id;
        $json = json_encode($arr);
        $item = $marshaler->marshalJson($json);

        $params = [
            'TableName' => 'Products_like',
            'Item' => $item
        ];


        try {
            $result = $dynamodb->putItem($params);
        } catch (DynamoDbException $e) {
            echo "Unable to add item:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function deletelike($product_id,$u_id){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                    'key'    => 'AKIAJHDNGDS75DEYKEUA',
                    'secret' => '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',
                ],
        ];
        $sdk = new Aws\Sdk($config);
        $marshaler = new Aws\DynamoDb\Marshaler();
        $dynamodb = $sdk->createDynamoDb();

        $product_id = (int)$product_id;
        $u_id = (int)$u_id;
        
        $arr['product_id'] = $product_id;
        $arr['user_id'] = $u_id;
        $json = json_encode($arr);
//        $key = $marshaler->marshalJson('
//            { "product_id": "'.$product_id.'", "user_id": "'.$user_id.'" }
//        ');
        $key = $marshaler->marshalJson($json);
        
        $params = [
            'TableName' => 'Products_like',
            'Key' => $key
        ];


        try {
           $result = $dynamodb->deleteItem($params);
            echo "Deleted item.\n";
            
        } catch (DynamoDbException $e) {
            echo "Unable to add item:\n";
            echo $e->getMessage() . "\n";
        }
    }

    /*
    public function ajaxlike($user_id=null){
        $this->db->select('id as pro_id')->from('products_products');
	$query = $this->db->get()->result_array();
        
        $q1 = array();
        $q2 = array();
        for($i = 1; $i < count($query)+1; $i++){   
	$pro_id=$i; 
        
	$this->db->select('product_id,count(*) as likecount')->from('default_products_like use index (product_idIndex)')->where('product_id',$pro_id);
        //$this->db->select('count(*) as usercount')->where('user_id',$user_id);
	$q1[] = $this->db->get()->result_array();	
        }
        if($user_id!=null){
            for($i = 1; $i < count($query)+1; $i++){   
                $pro_id=$i; 
                $this->db->select('count(*) as usercount')->from('default_products_like use index (product_idIndex) IGNORE INDEX FOR ORDER BY (user_idIndex) ');
                $this->db->where('product_id',$pro_id);
                $this->db->where('user_id',$user_id);
               // $this->db->select('count(*) as usercount')->where('user_id',$user_id);
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
    */
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
    
    public function ajaxlistsearch($limit = 2, $offset = 0,$cat=null, $f_id = null){
        $this->db->select('products_products.id,p_name,p_image,p_price,files.id as f_id,files.path');
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

    public function loadcomment(){
        $config = [
            'region'  => 'ap-southeast-1',
            'scheme' => 'http',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'AKIAJTFJLDUUQWOVNEWA',
                'secret' => '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',
            ],
        ];
        $sdk = new Aws\Sdk($config);
        $marshaler = new Aws\DynamoDb\Marshaler();
        $dynamodb = $sdk->createDynamoDb();
        
        $params =[
            
        ];
    }
    
    public function ajaxcomments($limit=2,$offset=0,$pro_id=null)
    {
        $pro_id = (int)$pro_id;
            $q =" SELECT * FROM (SELECT (UNIX_TIMESTAMP(default_products_comment.created)*1000) as created,comments,product_id_c,reply_id,default_products_comment.id
                    FROM default_products_comment 
                    WHERE product_id_c = $pro_id 
                    AND reply_id IS NULL    
                    ORDER BY default_products_comment.created DESC
                    LIMIT $limit 
                    OFFSET $offset
                    ) AS `table` ORDER by id ASC";
        $query = $this->db->query($q);
        return $query->result_array();

        
    }
    
    public function ajaxcommentcount($pro_id =null){
       if($pro_id == ''){ 
        $this->db->select("id as pro_id");
        $this->db->from('products_products');
        $q1 = $this->db->get()->result_array();
        for($i=1;$i<count($q1)+1;$i++){

             $this->db->select("count(product_id_c) as commentcount");
             $this->db->from('products_comment');
             $this->db->where('product_id_c',$i);
             $query[] = $this->db->get()->result_array();
        }
        for($i=0;$i<count($q1);$i++){
        $q2[] = array_merge($q1[$i],$query[$i][0]);
        }
        return $q2;
       }
       else{
        $pro_id = (int)$pro_id;
        $q1[0]['pro_id'] = $pro_id;
        $this->db->select("count(product_id_c) as commentcount");
        $this->db->from('products_comment');
        $this->db->where('product_id_c',$pro_id);
        $query = $this->db->get()->result_array();
        
        
        $q2[] = array_merge($q1[0],$query[0]);
        
        return $q2;
       }
    }
    
    public function ajaxreply($pro_id=null,$com_id=null,$limit=2,$offset=0)
    {
            $q =" SELECT * FROM (SELECT (UNIX_TIMESTAMP(default_products_comment.created)*1000) as created,comments,product_id_c,reply_id,default_products_comment.id
                    FROM default_products_comment 
                    WHERE product_id_c = $pro_id 
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
    
    public function test(){
        /*$config = [
                'region'  => 'ap-southeast-1',
                'scheme' => 'http',
                'version'  => 'latest',
                'credentials' => [
                    'key'    => 'AKIAJTFJLDUUQWOVNEWA',
                    'secret' => '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',
                ],
            ];
            $sdk = new Aws\Sdk($config);
        $dynamodb = $sdk->createDynamoDb();

        $response = $dynamodb->scan([
            'TableName' => 'Products_like'
        ]);
        $response = $dynamodb->deleteItem([
            'TableName' => 'Products_like',
            'Key' => [
                'product_id' => [
                    'N' => '0'
                ],
                'user_id' => [
                    'N' => '1'
                ]
            ]
        ]);
        return $response;*/
        $this->db->select('id as pro_id')->from('products_products');
	$query = $this->db->get()->result_array();
        
        return $query;
        
    }
    
    
  
}