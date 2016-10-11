<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url("addons/shared_addons/modules/products")?>/css/mystyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>


    <!-- Menu -->
    <div class="jumbotron">
      <div class="container text-center">
        <h1>Main Menu</h1>

      </div>
    </div>
<!-- search box + filter-->  
    <div class="row">
    <!-- search box -->
        <div class="searchbox input-group col-xs-12">
            <input type="text" class="search-query form-control" placeholder="Search" />
            <span class="input-group-btn">
                <button class="btn btn-danger" type="button" >
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    <!--  filter-->
        <div class="filter-category col-xs-12">
            
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Categories <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Category 1</a></li>
                    <li><a href="#">Category 2</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Filter <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Most popular</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


<!-- list product-->
   <!-- Product One -->
    {{ products.entries }}    
    <div class="row">
        <div class="product">
            <div class="col-xs-12">
                <a href="{{ url:site }}products/detail/{{ id }}">
                   {{ p_image:img }}
                </a>
            </div>
            <div class="ls col-xs-12">
                <div class="detail col-xs-6 col-md-6 ">
                    <p class="properties-label"> <a href="{{ url:site }}products/detail/{{ id }}"> {{ p_name }} </a> </p>
                   
                </div>
                <div class="detail col-xs-6 col-md-6">
                    <div class="pull-right">
                    <p class="properties-label"> Price :</p>
                <span class="price properties-content"> {{ p_price }}</span>   
                </div>
                </div>
                <div class="detail col-xs-12 col-md-12"> 
                    <span class="properties-label-des"> Short description:</span>
                    <p>{{ p_short_description }}</p>
                    <a href="{{ url:site }}products/detail/{{ id }}"> Read more </a>
                </div>
                
                <div class="btn-group btn-group-justified">
                    <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                    <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span></a>
                    <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span></a>
                </div>             
            </div>
        </div>
    </div>
     {{ /products.entries }} 
    <!-- /.row -->
    
    

<br><br>

  <p>Show more...</p>
 


</body>
</html>

